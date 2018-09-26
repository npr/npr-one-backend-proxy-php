<?php

namespace NPR\One\Controllers;

use GuzzleHttp\Client;
use NPR\One\DI\DI;
use NPR\One\Exceptions\ApiException;
use NPR\One\Interfaces\ConfigInterface;
use NPR\One\Interfaces\EncryptionInterface;
use NPR\One\Interfaces\StorageInterface;
use NPR\One\Models\AccessTokenModel;
use NPR\One\Providers\CookieProvider;
use NPR\One\Providers\EncryptionProvider;
use NPR\One\Providers\SecureCookieProvider;


/**
 * This is an abstract class optimized to more easily share common code between the different OAuth2 grant types.
 * Consumers should never interact with this class directly, but instead use either the {@see AuthCodeController} or
 * {@see DeviceCodeController} classes depending on which grant type is used, along with the {@see RefreshTokenController}
 * (regardless of which grant type is used) to generate fresh access tokens when the old ones have expired.
 *
 * @package NPR\One\Controllers
 * @internal
 */
abstract class AbstractOAuth2Controller
{
    /** @internal */
    const FIVE_YEARS = 157784760; // in seconds

    /** @var string[]
     * @internal */
    private $headers = [];
    /** @var ConfigInterface
      * @internal */
    private $config;
    /** @var StorageInterface
      * @internal */
    private $secureStorage;
    /** @var EncryptionInterface
     * @internal */
    private $encryption;


    /**
     * Performs basic initialization and forwards on lat and lon if found within GEOIP server headers.
     */
    public function __construct()
    {
        if (isset($_SERVER['GEOIP_LATITUDE']) && isset($_SERVER['GEOIP_LONGITUDE']))
        {
            $this->headers = [
                'X-Latitude'  => $_SERVER['GEOIP_LATITUDE'],
                'X-Longitude' => $_SERVER['GEOIP_LONGITUDE']
            ];
        }
        $this->encryption = DI::container()->get(EncryptionProvider::class);
        $this->secureStorage = DI::container()->get(SecureCookieProvider::class);
        $this->secureStorage->setEncryptionProvider($this->encryption);
    }

    /**
     * Returns the lat and long headers if GeoIP is available. Useful for testing.
     *
     * @return string[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Sets the configuration provider for this class. This is a required step for consumers of this code,
     * as no default config provider is available.
     *
     * @param ConfigInterface $configProvider
     * @return $this
     */
    public function setConfigProvider(ConfigInterface $configProvider)
    {
        $this->config = $configProvider;
        return $this;
    }

    /**
     * Sets the storage provider to use across PHP sessions for items requiring extra security, such as
     * refresh tokens. By default, the SecureCookieProvider will be used (in tandem with an EncryptionProvider
     * to securely encrypt the cookies), but it can be overridden here.
     *
     * @param StorageInterface $storageProvider
     * @return $this
     */
    public function setSecureStorageProvider(StorageInterface $storageProvider)
    {
        $this->secureStorage = $storageProvider;
        return $this;
    }

    /**
     * Sets the encryption provider that is used by the SecureCookieProvider class if it is selected as the
     * secure storage provider of choice. If a custom secure storage provider is used, the encryption
     * provider may no longer be needed. By default, an EncryptionProvider class using openssl is used,
     * but it can be overridden here.
     *
     * @param EncryptionInterface $encryptionProvider
     * @return $this
     */
    public function setEncryptionProvider(EncryptionInterface $encryptionProvider)
    {
        $this->encryption = $encryptionProvider;
        return $this;
    }

    /**
     * Ensures that externally supplied providers are set
     *
     * @internal
     * @throws \RuntimeException - if any one of the required providers are not set
     */
    protected function ensureExternalProvidersExist()
    {
        if (empty($this->config))
        {
            throw new \RuntimeException('ConfigProvider must be set. See ' . __CLASS__ . '::setConfigProvider.');
        }

        if (empty($this->secureStorage))
        {
            throw new \RuntimeException('SecureStorageProvider must be set. See ' . __CLASS__ . '::setSecureStorageProvider.');
        }

        if ($this->secureStorage instanceof SecureCookieProvider)
        {
            $this->secureStorage->setDomain($this->config->getCookieDomain());
            $this->secureStorage->setKeyPrefix($this->config->getCookiePrefix());
            if (empty($this->encryption))
            {
                throw new \RuntimeException('EncryptionProvider must be set. See ' . __CLASS__ . '::setEncryptionProvider.');
            }
            $this->encryption->setSalt($this->config->getEncryptionSalt());
            if (!$this->encryption->isValid())
            {
                throw new \RuntimeException('EncryptionProvider must be valid. See EncryptionInterface::isValid.');
            }
            $this->secureStorage->setEncryptionProvider($this->encryption);
        }
        else if ($this->secureStorage instanceof CookieProvider)
        {
            /*
             * We're throwing an exception here to emphasize that we really do strongly discourage it, but if you have
             * no other option, you can technically extend this class and catch the exception and still execute all of
             * the subsequent code. We're just, y'know, _strongly_ discouraging it.
             */
            throw new \RuntimeException('WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider. '
                . 'Please use SecureCookieProvider, which uses encrypted cookies, instead.');
        }
    }

    /**
     * Returns the previously-set configuration provider for consumers extending this class.
     *
     * @internal
     * @return ConfigInterface
     */
    final protected function getConfigProvider()
    {
        return $this->config;
    }

    /**
     * Returns the previously-set secure storage provider for consumers extending this class.
     *
     * @internal
     * @return StorageInterface
     */
    final protected function getSecureStorageProvider()
    {
        return $this->secureStorage;
    }

    /**
     * Performs basic validation on the passed-in scopes by simply ensuring that they are all non-empty strings.
     * This does not actually validate them against the scopes available on the NPR One API's authorization server,
     * so the remote server may still reject the request.
     *
     * @internal
     * @param string[] $scopes
     */
    final protected function validateScopes(array $scopes)
    {
        if (count($scopes) === 0)
        {
            throw new \InvalidArgumentException('Must specify at least one scope in order to use the NPR One API');
        }
        foreach ($scopes as $scope)
        {
            if (empty($scope) || !is_string($scope))
            {
                throw new \InvalidArgumentException('All scopes must be non-empty strings; passed in: ' . print_r($scope, 1));
            }
        }
    }

    /**
     * Creates a new access token by POSTing to the `/token` endpoint. Any error-level output will result in an
     * exception being thrown; this function will only return successfully if an access token was actually created.
     *
     * @internal
     * @param string $grantType
     * @param string[] $additionalParams
     * @return AccessTokenModel
     * @throws \InvalidArgumentException
     * @throws ApiException
     */
    final protected function createAccessToken($grantType, $additionalParams = [])
    {
        if (empty($grantType) || !is_string($grantType))
        {
            throw new \InvalidArgumentException('Must specify grant type');
        }

        $this->ensureExternalProvidersExist();

        /** @var Client $client */
        $client = DI::container()->get(Client::class);
        $response = $client->request('POST', $this->config->getNprApiHost() . '/authorization/v2/token', [
            'headers'     => $this->headers,
            'form_params' => array_merge([
                'client_id'     => $this->config->getClientId(),
                'client_secret' => $this->config->getClientSecret(),
                'grant_type'    => $grantType
            ], $additionalParams)
        ]);

        if ($response->getStatusCode() >= 400)
        {
            throw new ApiException("Error during createAccessToken for grant $grantType", $response); // @codeCoverageIgnore
        }

        $body = $response->getBody();
        return new AccessTokenModel($body);
    }

    /**
     * Stores the refresh token, if set, using the secure storage provider.
     *
     * @internal
     * @param AccessTokenModel $accessToken
     */
    final protected function storeRefreshToken(AccessTokenModel $accessToken)
    {
        $refreshToken = $accessToken->getRefreshToken();
        if (!empty($refreshToken))
        {
            $this->secureStorage->set('refresh_token', $refreshToken, self::FIVE_YEARS);
        }
        else
        {
            $this->secureStorage->remove('refresh_token');
        }
    }
}

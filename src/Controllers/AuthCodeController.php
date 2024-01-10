<?php

namespace NPR\One\Controllers;

use NPR\One\DI\DI;
use NPR\One\Interfaces\ConfigInterface;
use NPR\One\Interfaces\StorageInterface;
use NPR\One\Models\AccessTokenModel;
use NPR\One\Providers\CookieProvider;


/**
 * Use this controller to power your OAuth2 proxy if you are using the `authorization_code` grant.
 * The consumer of this codebase is responsible for setting up a router which forwards on the relevant requests
 * to the {@see AuthCodeController::startAuthorizationGrant()} and {@see AuthCodeController::completeAuthorizationGrant()}
 * public methods in this class.
 *
 * @package NPR\One\Controllers
 */
class AuthCodeController extends AbstractOAuth2Controller
{
    /** @internal */
    const ONE_DAY = 86400; // in seconds

    /** @var StorageInterface
     * @internal */
    private $storage;
    /** @var CookieProvider
     * @internal */
    private $cookies;


    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();
        $this->cookies = DI::container()->get(CookieProvider::class);
    }

    /**
     * {@inheritdoc}
     */
    public function setConfigProvider(ConfigInterface $configProvider)
    {
        parent::setConfigProvider($configProvider);
        $this->cookies->setDomain($configProvider->getCookieDomain());
        $this->cookies->setKeyPrefix($configProvider->getCookiePrefix());
        return $this;
    }

    /**
     * Sets a storage provider to use across PHP sessions. Used to validate the OAuth `state` param.
     *
     * @param StorageInterface $storageProvider
     * @return $this
     */
    public function setStorageProvider(StorageInterface $storageProvider)
    {
        $this->storage = $storageProvider;
        return $this;
    }

    /**
     * {@inheritdoc}
     * @internal
     */
    final protected function ensureExternalProvidersExist()
    {
        parent::ensureExternalProvidersExist();

        if (empty($this->storage))
        {
            throw new \RuntimeException('StorageProvider must be set. See ' . __CLASS__ . '::setStorageProvider.');
        }
    }

    /**
     * Returns the webapp URL as set in the configuration provider.
     *
     * @return string
     */
    public function getRedirectUri()
    {
        $this->ensureExternalProvidersExist();

        return $this->getConfigProvider()->getClientUrl();
    }

    /**
     * Kicks off a new authorization grant flow
     *
     * @api
     * @param string[] $scopes
     * @param string|null $email - This email address will be used to pre-populate the login page.
     * @param string|null $accessToken - User's anonymous access token, if it exists
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function startAuthorizationGrant(array $scopes, ?string $email=null, ?string $accessToken=null): string
    {
        $this->ensureExternalProvidersExist();

        $this->validateScopes($scopes);

        $queryParams = [
            'client_id'     => $this->getConfigProvider()->getClientId(),
            'redirect_uri'  => $this->getConfigProvider()->getAuthCodeCallbackUrl(),
            'state'         => $this->generateOAuth2State(),
            'response_type' => 'code',
            'scope'         => join(' ', $scopes),
            'email'         => $email,
            'user_id'       => $accessToken,
        ];

        return $this->getConfigProvider()->getNprAuthorizationServiceHost() . '/v2/authorize?' . http_build_query($queryParams);
    }

    /**
     * Finishes the authorization grant flow
     *
     * @api
     * @param string $authorizationCode
     * @param string $state
     * @return AccessTokenModel - useful for debugging
     * @throws \InvalidArgumentException
     * @throws \Exception when state param is invalid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function completeAuthorizationGrant($authorizationCode, $state)
    {
        if (empty($authorizationCode) || !is_string($authorizationCode))
        {
            throw new \InvalidArgumentException('Must specify authorization code');
        }
        if (empty($state) || !is_string($state))
        {
            throw new \InvalidArgumentException('Must specify state');
        }

        $this->ensureExternalProvidersExist();

        $this->verifyOAuth2State($state);

        $accessToken = $this->createAccessToken('authorization_code', [
            'code'         => $authorizationCode,
            'redirect_uri' => $this->getConfigProvider()->getAuthCodeCallbackUrl()
        ]);

        $this->cookies->set('access_token', $accessToken->getAccessToken(), $accessToken->getExpiresIn());

        $this->storeRefreshToken($accessToken);

        return $accessToken;
    }

    /**
     * Generates a new state string comprised of a key and a value. Session storage is
     * required to persist the key & value across the redirect requests.
     *
     * @internal
     * @return string
     */
    private function generateOAuth2State()
    {
        $key = mt_rand();
        $value = mt_rand();

        $this->storage->set($key, $value, self::ONE_DAY);

        return $key . ':' . $value;
    }

    /**
     * Checks sessions storage to ensure that the state value is the correct value given earlier
     * in the flow
     *
     * @internal
     * @param string $serverState
     * @throws \Exception when state is invalid
     */
    private function verifyOAuth2State($serverState)
    {
        if (strpos($serverState, ':') === false)
        {
            throw new \Exception("Invalid state returned from OAuth server, colon separator missing: $serverState");
        }

        list($serverKey, $serverValue) = explode(':', $serverState);
        $compareResult = $this->storage->compare($serverKey, $serverValue);
        $this->storage->remove($serverKey);

        if (!$compareResult)
        {
            throw new \Exception("Invalid state returned from OAuth server, server state '$serverState' does not match stored value");
        }
    }
}

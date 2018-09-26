<?php

namespace NPR\One\Controllers;

use GuzzleHttp\Client;
use NPR\One\DI\DI;
use NPR\One\Exceptions\ApiException;


/**
 * This controller should always be used by every consumer, regardless of whether you are using the `authorization_code`
 * or `device_code` grant types. Use this to fully log out users by revoking their `access_token` and `refresh_token`
 * from the NPR authorization server and then deleting the reference to the refresh token in the secure cookie or other
 * secure storage provider.
 *
 * @package NPR\One\Controllers
 */
class LogoutController extends AbstractOAuth2Controller
{
    /**
     * Revokes an access+refresh token pair and removes the refresh token from the secure storage layer.
     * By default, this takes in an access token (string); however, the access token *may* be omitted, in which case it
     * will attempt to revoke the pair based on the refresh token previously saved to the secure storage layer. If no
     * refresh token is found, this function will throw an exception (because there is nothing to be revoked).
     *
     * @api
     * @param string|null $accessToken
     * @throws \Exception if no access token is passed in and no refresh token is found in the secure storage layer
     */
    public function deleteAccessAndRefreshTokens($accessToken = null)
    {
        $this->ensureExternalProvidersExist();

        if (empty($accessToken))
        {
            $refreshToken = $this->getSecureStorageProvider()->get('refresh_token');
            if (empty($refreshToken))
            {
                throw new \Exception('Could not locate a token to revoke');
            }
            $this->revokeToken($refreshToken, true);
        }
        else
        {
            $this->revokeToken($accessToken);
        }

        $this->getSecureStorageProvider()->remove('refresh_token');
    }

    /**
     * Makes the actual call to the revoke token endpoint in the NPR One Authorization Service.
     *
     * @internal
     * @param string $token
     * @param bool $isRefreshToken
     * @throws ApiException
     */
    private function revokeToken($token, $isRefreshToken = false)
    {
        if (empty($token) || !is_string($token))
        {
            throw new \InvalidArgumentException('Must specify token to be revoked');
        }

        $this->ensureExternalProvidersExist();

        $additionalParams = [];
        if ($isRefreshToken === true)
        {
            $additionalParams['token_type_hint'] = 'refresh_token';
        }

        /** @var Client $client */
        $client = DI::container()->get(Client::class);
        $response = $client->request('POST', $this->getConfigProvider()->getNprApiHost() . '/authorization/v2/token/revoke', [
            'headers'     => [
                'Authorization' => 'Bearer ' . $this->getConfigProvider()->getClientCredentialsToken()
            ],
            'form_params' => array_merge([
                'token' => $token
            ], $additionalParams)
        ]);

        if ($response->getStatusCode() >= 400)
        {
            throw new ApiException("Error during revokeToken for token $token", $response); // @codeCoverageIgnore
        }

        // A successful call has no response body, so there's nothing to return!
    }
}

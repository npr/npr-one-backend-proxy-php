<?php

namespace NPR\One\Controllers;

use NPR\One\Models\AccessTokenModel;


/**
 * This controller should always be used by every consumer, regardless of whether you are using the `authorization_code`
 * or `device_code` grant types. Use this to generate a new access token when a previously-generated token has expired.
 * The consumer of this codebase is responsible for setting up a router which forwards on the relevant requests
 * to the {@see RefreshTokenController::generateNewAccessTokenFromRefreshToken()} public method in this class.
 *
 * @package NPR\One\Controllers
 */
class RefreshTokenController extends AbstractOAuth2Controller
{
    /**
     * Attempts to locate a refresh token securely stored in the cookies and, if found,
     * generates a new access token.
     *
     * @api
     * @return AccessTokenModel
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateNewAccessTokenFromRefreshToken(): AccessTokenModel
    {
        $this->ensureExternalProvidersExist();

        $refreshToken = $this->getSecureStorageProvider()->get('refresh_token');
        if (empty($refreshToken))
        {
            throw new \Exception('Could not locate a refresh token');
        }

        $accessToken = $this->createAccessToken('refresh_token', [
            'refresh_token' => $refreshToken
        ]);

        $this->storeRefreshToken($accessToken);

        return $accessToken;
    }
}

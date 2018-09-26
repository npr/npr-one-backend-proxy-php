<?php

namespace NPR\One\Interfaces;


/**
 * Establishes a set of requirements for the configuration provider for the project
 *
 * @package NPR\One\Interfaces
 */
interface ConfigInterface
{
    /**
     * Returns the NPR One OAuth2 client ID, obtainable from the NPR One Developer Center's Developer Console
     *
     * @return string
     */
    public function getClientId();

    /**
     * Returns the NPR One OAuth2 client secret, obtainable from the NPR One Developer Center's Developer Console
     *
     * @return string
     */
    public function getClientSecret();

    /**
     * Returns a single, static client credentials token associated with the same `client_id` from `getClientId()` above
     * that we can use for the logout/disconnect functionality. (See also: `LogoutController`.)
     *
     * Because there currently is no other use case requiring client credentials tokens, this proxy does not implement
     * the functionality to generate a `client_credentials` token for you; you are expected to provide your own. The
     * easiest method to do so is to go to our interactive API documentation at http://dev.npr.org/api/#!/authorization/createToken
     * and plug in your `client_id` and `client_secret`, the only two parameters required by the `client_credentials`
     * grant type. Currently, client credentials tokens never expire, so hard-coding it here is not an issue.
     *
     * **Only** if your app does not provide any kind of logout/disconnect functionality (and you are not using
     * `LogoutController` at all), you can set this function to return an empty string.
     *
     * @return string
     */
    public function getClientCredentialsToken();

    /**
     * Returns the NPR One Authorization Service hostname, useful for testing on staging environments.
     * Most consumers will want to hard-code this to always return `https://authorization.api.npr.org`.
     * Please do not include a trailing slash.
     *
     * @return string
     */
    public function getNprAuthorizationServiceHost();

    /**
     * Returns the host (or path) of the NPR One application (the client/frontend). This is where the `authorization_code`
     * flow *eventually* redirects to, either when it has successfully obtained an access token or if there was an
     * unrecoverable error. This is **NOT** the `redirect_uri` that you've added in the NPR One Developer Center's
     * Developer Console; see `getAuthCodeCallbackUrl()` for that.
     * If you are using the `device_code` grant instead of the `authorization_code` grant, you do not need this function
     * and can simply hard-code it to return an empty string.
     *
     * @return string
     */
    public function getClientUrl();

    /**
     * Returns the url of this backend proxy, corresponding specifically to the path that invokes `completeAuthorizationGrant()`
     * in the AuthCodeController. This is where the `authorization_code` flow first redirects to; this URL **must** be
     * added as a valid `redirect_uri` in the NPR One Developer Center's Developer Console.
     * If you are using the `device_code` grant instead of the `authorization_code` grant, you do not need this function
     * and can simply hard-code it to return an empty string.
     *
     * @return string
     */
    public function getAuthCodeCallbackUrl();

    /**
     * Returns the custom domain to use for your cookies. If your cookies do not require a custom domain, have this
     * function return `null`.
     *
     * @return string|null
     */
    public function getCookieDomain();

    /**
     * If you have multiple proxies living on one server and are using the same cookie domain, you may need to be able
     * to use a prefix to differentiate between them. In that case, have this function return a non-empty string. If
     * your cookies do not require a prefix, have this function return an empty string (`''`).
     *
     * @return string
     */
    public function getCookiePrefix();

    /**
     * Returns a salt to use for the default EncryptionProvider. If you are using your own custom secure storage provider
     * and/or an encryption provider that does not require a salt, just have this function return an empty string.
     *
     * @return string
     */
    public function getEncryptionSalt();
}

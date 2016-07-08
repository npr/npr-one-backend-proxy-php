NPR\One\Controllers\LogoutController
===============

This controller should always be used by every consumer, regardless of whether you are using the `authorization_code`
or `device_code` grant types. Use this to fully log out users by revoking their `access_token` and `refresh_token`
from the NPR authorization server and then deleting the reference to the refresh token in the secure cookie or other
secure storage provider.

Consumers should never interact with this class directly, but instead use either the [\NPR\One\Controllers\AuthCodeController](../classes/NPR.One.Controllers.AuthCodeController.html) or
[\NPR\One\Controllers\DeviceCodeController](../classes/NPR.One.Controllers.DeviceCodeController.html) classes depending on which grant type is used, along with the [\NPR\One\Controllers\RefreshTokenController](../classes/NPR.One.Controllers.RefreshTokenController.html)
(regardless of which grant type is used) to generate fresh access tokens when the old ones have expired.


* Class name: LogoutController
* Namespace: NPR\One\Controllers
* Parent class: [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)







Methods
-------


### deleteAccessAndRefreshTokens

    mixed NPR\One\Controllers\LogoutController::deleteAccessAndRefreshTokens(string|null $accessToken)

Revokes an access+refresh token pair and removes the refresh token from the secure storage layer.

By default, this takes in an access token (string); however, the access token *may* be omitted, in which case it
will attempt to revoke the pair based on the refresh token previously saved to the secure storage layer. If no
refresh token is found, this function will throw an exception (because there is nothing to be revoked).

* Visibility: **public**


#### Arguments
* $accessToken **string|null**



### __construct

    mixed NPR\One\Controllers\AbstractOAuth2Controller::__construct()

Performs basic initialization and forwards on lat and lon if found within GEOIP server headers.



* Visibility: **public**
* This method is defined by [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)




### getHeaders

    array<mixed,string> NPR\One\Controllers\AbstractOAuth2Controller::getHeaders()

Returns the lat and long headers if GeoIP is available. Useful for testing.



* Visibility: **public**
* This method is defined by [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)




### setConfigProvider

    \NPR\One\Controllers\AbstractOAuth2Controller NPR\One\Controllers\AbstractOAuth2Controller::setConfigProvider(\NPR\One\Interfaces\ConfigInterface $configProvider)

Sets the configuration provider for this class. This is a required step for consumers of this code,
as no default config provider is available.



* Visibility: **public**
* This method is defined by [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)


#### Arguments
* $configProvider **[NPR\One\Interfaces\ConfigInterface](NPR-One-Interfaces-ConfigInterface.md)**



### setSecureStorageProvider

    \NPR\One\Controllers\AbstractOAuth2Controller NPR\One\Controllers\AbstractOAuth2Controller::setSecureStorageProvider(\NPR\One\Interfaces\StorageInterface $storageProvider)

Sets the storage provider to use across PHP sessions for items requiring extra security, such as
refresh tokens. By default, the SecureCookieProvider will be used (in tandem with an EncryptionProvider
to securely encrypt the cookies), but it can be overridden here.



* Visibility: **public**
* This method is defined by [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)


#### Arguments
* $storageProvider **[NPR\One\Interfaces\StorageInterface](NPR-One-Interfaces-StorageInterface.md)**



### setEncryptionProvider

    \NPR\One\Controllers\AbstractOAuth2Controller NPR\One\Controllers\AbstractOAuth2Controller::setEncryptionProvider(\NPR\One\Interfaces\EncryptionInterface $encryptionProvider)

Sets the encryption provider that is used by the SecureCookieProvider class if it is selected as the
secure storage provider of choice. If a custom secure storage provider is used, the encryption
provider may no longer be needed. By default, an EncryptionProvider class using openssl is used,
but it can be overridden here.



* Visibility: **public**
* This method is defined by [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)


#### Arguments
* $encryptionProvider **[NPR\One\Interfaces\EncryptionInterface](NPR-One-Interfaces-EncryptionInterface.md)**



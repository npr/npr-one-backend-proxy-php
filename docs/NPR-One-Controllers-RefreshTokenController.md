NPR\One\Controllers\RefreshTokenController
===============

This controller should always be used by every consumer, regardless of whether you are using the `authorization_code`
or `device_code` grant types. Use this to generate a new access token when a previously-generated token has expired.

The consumer of this codebase is responsible for setting up a router which forwards on the relevant requests
to the [\NPR\One\Controllers\RefreshTokenController::generateNewAccessTokenFromRefreshToken()](../classes/NPR.One.Controllers.RefreshTokenController.html#method_generateNewAccessTokenFromRefreshToken) public method in this class.


* Class name: RefreshTokenController
* Namespace: NPR\One\Controllers
* Parent class: [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)







Methods
-------


### generateNewAccessTokenFromRefreshToken

    \NPR\One\Models\AccessTokenModel NPR\One\Controllers\RefreshTokenController::generateNewAccessTokenFromRefreshToken()

Attempts to locate a refresh token securely stored in the cookies and, if found,
generates a new access token.



* Visibility: **public**




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



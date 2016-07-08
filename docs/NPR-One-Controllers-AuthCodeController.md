NPR\One\Controllers\AuthCodeController
===============

Use this controller to power your OAuth2 proxy if you are using the `authorization_code` grant.

The consumer of this codebase is responsible for setting up a router which forwards on the relevant requests
to the [\NPR\One\Controllers\AuthCodeController::startAuthorizationGrant()](../classes/NPR.One.Controllers.AuthCodeController.html#method_startAuthorizationGrant) and [\NPR\One\Controllers\AuthCodeController::completeAuthorizationGrant()](../classes/NPR.One.Controllers.AuthCodeController.html#method_completeAuthorizationGrant)
public methods in this class.


* Class name: AuthCodeController
* Namespace: NPR\One\Controllers
* Parent class: [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)







Methods
-------


### __construct

    mixed NPR\One\Controllers\AbstractOAuth2Controller::__construct()

Performs basic initialization and forwards on lat and lon if found within GEOIP server headers.



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



### setStorageProvider

    \NPR\One\Controllers\AuthCodeController NPR\One\Controllers\AuthCodeController::setStorageProvider(\NPR\One\Interfaces\StorageInterface $storageProvider)

Sets a storage provider to use across PHP sessions. Used to validate the OAuth `state` param.



* Visibility: **public**


#### Arguments
* $storageProvider **[NPR\One\Interfaces\StorageInterface](NPR-One-Interfaces-StorageInterface.md)**



### getRedirectUri

    string NPR\One\Controllers\AuthCodeController::getRedirectUri()

Returns the webapp URL as set in the configuration provider.



* Visibility: **public**




### startAuthorizationGrant

    string NPR\One\Controllers\AuthCodeController::startAuthorizationGrant(array<mixed,string> $scopes)

Kicks off a new authorization grant flow



* Visibility: **public**


#### Arguments
* $scopes **array&lt;mixed,string&gt;**



### completeAuthorizationGrant

    \NPR\One\Models\AccessTokenModel NPR\One\Controllers\AuthCodeController::completeAuthorizationGrant(string $authorizationCode, string $state)

Finishes the authorization grant flow



* Visibility: **public**


#### Arguments
* $authorizationCode **string**
* $state **string**



### getHeaders

    array<mixed,string> NPR\One\Controllers\AbstractOAuth2Controller::getHeaders()

Returns the lat and long headers if GeoIP is available. Useful for testing.



* Visibility: **public**
* This method is defined by [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)




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



NPR\One\Controllers\DeviceCodeController
===============

Use this controller to power your OAuth2 proxy if you are using the `device_code` grant.

The consumer of this codebase is responsible for setting up a router which forwards on the relevant requests
to the [\NPR\One\Controllers\DeviceCodeController::startDeviceCodeGrant()](../classes/NPR.One.Controllers.DeviceCodeController.html#method_startDeviceCodeGrant) and [\NPR\One\Controllers\DeviceCodeController::pollDeviceCodeGrant()](../classes/NPR.One.Controllers.DeviceCodeController.html#method_pollDeviceCodeGrant)
public methods in this class.


* Class name: DeviceCodeController
* Namespace: NPR\One\Controllers
* Parent class: [NPR\One\Controllers\AbstractOAuth2Controller](NPR-One-Controllers-AbstractOAuth2Controller.md)







Methods
-------


### startDeviceCodeGrant

    \NPR\One\Models\DeviceCodeModel NPR\One\Controllers\DeviceCodeController::startDeviceCodeGrant(array<mixed,string> $scopes)

Kicks off a new device code flow



* Visibility: **public**


#### Arguments
* $scopes **array&lt;mixed,string&gt;**



### pollDeviceCodeGrant

    \NPR\One\Models\AccessTokenModel NPR\One\Controllers\DeviceCodeController::pollDeviceCodeGrant()

Polls the `POST /token` endpoint as part of the device code flow. It will throw an exception if the user
has not yet logged in, and return an access token once the user has successfully logged in.



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



NPR\One\Controllers\AbstractOAuth2Controller
===============

This is an abstract class optimized to more easily share common code between the different OAuth2 grant types.

Consumers should never interact with this class directly, but instead use either the [\NPR\One\Controllers\AuthCodeController](../classes/NPR.One.Controllers.AuthCodeController.html) or
[\NPR\One\Controllers\DeviceCodeController](../classes/NPR.One.Controllers.DeviceCodeController.html) classes depending on which grant type is used, along with the [\NPR\One\Controllers\RefreshTokenController](../classes/NPR.One.Controllers.RefreshTokenController.html)
(regardless of which grant type is used) to generate fresh access tokens when the old ones have expired.


* Class name: AbstractOAuth2Controller
* Namespace: NPR\One\Controllers
* This is an **abstract** class







Methods
-------


### __construct

    mixed NPR\One\Controllers\AbstractOAuth2Controller::__construct()

Performs basic initialization and forwards on lat and lon if found within GEOIP server headers.



* Visibility: **public**




### getHeaders

    array<mixed,string> NPR\One\Controllers\AbstractOAuth2Controller::getHeaders()

Returns the lat and long headers if GeoIP is available. Useful for testing.



* Visibility: **public**




### setConfigProvider

    \NPR\One\Controllers\AbstractOAuth2Controller NPR\One\Controllers\AbstractOAuth2Controller::setConfigProvider(\NPR\One\Interfaces\ConfigInterface $configProvider)

Sets the configuration provider for this class. This is a required step for consumers of this code,
as no default config provider is available.



* Visibility: **public**


#### Arguments
* $configProvider **[NPR\One\Interfaces\ConfigInterface](NPR-One-Interfaces-ConfigInterface.md)**



### setSecureStorageProvider

    \NPR\One\Controllers\AbstractOAuth2Controller NPR\One\Controllers\AbstractOAuth2Controller::setSecureStorageProvider(\NPR\One\Interfaces\StorageInterface $storageProvider)

Sets the storage provider to use across PHP sessions for items requiring extra security, such as
refresh tokens. By default, the SecureCookieProvider will be used (in tandem with an EncryptionProvider
to securely encrypt the cookies), but it can be overridden here.



* Visibility: **public**


#### Arguments
* $storageProvider **[NPR\One\Interfaces\StorageInterface](NPR-One-Interfaces-StorageInterface.md)**



### setEncryptionProvider

    \NPR\One\Controllers\AbstractOAuth2Controller NPR\One\Controllers\AbstractOAuth2Controller::setEncryptionProvider(\NPR\One\Interfaces\EncryptionInterface $encryptionProvider)

Sets the encryption provider that is used by the SecureCookieProvider class if it is selected as the
secure storage provider of choice. If a custom secure storage provider is used, the encryption
provider may no longer be needed. By default, an EncryptionProvider class using openssl is used,
but it can be overridden here.



* Visibility: **public**


#### Arguments
* $encryptionProvider **[NPR\One\Interfaces\EncryptionInterface](NPR-One-Interfaces-EncryptionInterface.md)**



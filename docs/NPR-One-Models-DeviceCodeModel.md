NPR\One\Models\DeviceCodeModel
===============

A thin wrapper around a device code/user code pair, based on the raw JSON returned from the `POST /device` endpoint.




* Class name: DeviceCodeModel
* Namespace: NPR\One\Models
* Parent class: [NPR\One\Models\JsonModel](NPR-One-Models-JsonModel.md)







Methods
-------


### __construct

    mixed NPR\One\Models\JsonModel::__construct($json)

Model constructor.



* Visibility: **public**
* This method is defined by [NPR\One\Models\JsonModel](NPR-One-Models-JsonModel.md)


#### Arguments
* $json **mixed**



### getDeviceCode

    string NPR\One\Models\DeviceCodeModel::getDeviceCode()

Returns the device code -- the 40-character alphanumeric code for the proxy to use. This code should never
be shown to the user, and it is generally preferable to keep this code within the proxy, rather than return it
to the client, where it could be compromised.



* Visibility: **public**




### getUserCode

    string NPR\One\Models\DeviceCodeModel::getUserCode()

Returns the user code -- the 8-character alphanumeric code that the user is asked to enter at http://npr.org/device
before logging in. This code can safely be returned to the client and displayed on the device's screen.



* Visibility: **public**




### getVerificationUri

    string NPR\One\Models\DeviceCodeModel::getVerificationUri()

Returns the URL at which the user should log in. It is usually displayed on the screen together with the user code.



* Visibility: **public**




### getExpiresIn

    integer NPR\One\Models\DeviceCodeModel::getExpiresIn()

Returns the remaining lifetime of the device code/user code pair, in seconds. Once the codes expire, the client
is responsible for starting a new device code flow, which will result in a new keypair being generated.



* Visibility: **public**




### getInterval

    integer NPR\One\Models\DeviceCodeModel::getInterval()

Returns the interval at which the client is advised to poll the authorization server (and, by extension, this proxy)
to see if the user has logged in yet. Polling more frequently than that may result in a rate limit kicking in.



* Visibility: **public**




### __toString

    string NPR\One\Models\JsonModel::__toString()

Re-encodes the original JSON model as a string and returns it.



* Visibility: **public**
* This method is defined by [NPR\One\Models\JsonModel](NPR-One-Models-JsonModel.md)




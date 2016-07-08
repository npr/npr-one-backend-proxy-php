NPR\One\Models\AccessTokenModel
===============

A thin wrapper around an access token, based on the raw JSON returned from the `POST /token` endpoint.




* Class name: AccessTokenModel
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



### getAccessToken

    string NPR\One\Models\AccessTokenModel::getAccessToken()

Returns the access token itself -- a 40-character, alphanumeric string.



* Visibility: **public**




### getTokenType

    string NPR\One\Models\AccessTokenModel::getTokenType()

Returns the type of token, usually assumed to be `Bearer`.



* Visibility: **public**




### getExpiresIn

    integer NPR\One\Models\AccessTokenModel::getExpiresIn()

Returns the remaining seconds in the lifetime of the access token.



* Visibility: **public**




### getRefreshToken

    null|string NPR\One\Models\AccessTokenModel::getRefreshToken()

Returns the refresh token associated with this access token, if it exists.



* Visibility: **public**




### __toString

    string NPR\One\Models\JsonModel::__toString()

Re-encodes the original JSON model as a string and returns it.



* Visibility: **public**
* This method is defined by [NPR\One\Models\JsonModel](NPR-One-Models-JsonModel.md)




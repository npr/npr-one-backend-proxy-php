NPR\One\Exceptions\ApiException
===============

An extension of CookieProvider that encrypts cookies before setting them and decrypts them when retrieving them




* Class name: ApiException
* Namespace: NPR\One\Exceptions
* Parent class: Exception







Methods
-------


### __construct

    mixed NPR\One\Exceptions\ApiException::__construct(string $message, \GuzzleHttp\Psr7\Response $response)

Constructs the exception using the response from the API call.



* Visibility: **public**


#### Arguments
* $message **string**
* $response **GuzzleHttp\Psr7\Response**



### getStatusCode

    integer NPR\One\Exceptions\ApiException::getStatusCode()

Returns the HTTP status code from the failed API call; should generally always be 400 or greater.



* Visibility: **public**




### getBody

    \GuzzleHttp\Psr7\Stream NPR\One\Exceptions\ApiException::getBody()

Returns the body of the response from the failed API call. May be empty.



* Visibility: **public**




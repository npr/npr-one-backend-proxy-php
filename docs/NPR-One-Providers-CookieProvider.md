NPR\One\Providers\CookieProvider
===============

A thin wrapper around the PHP functions to get and set cookies. Useful for unit testing.




* Class name: CookieProvider
* Namespace: NPR\One\Providers
* This class implements: [NPR\One\Interfaces\StorageInterface](NPR-One-Interfaces-StorageInterface.md)






Methods
-------


### set

    mixed NPR\One\Interfaces\StorageInterface::set(string $key, mixed $value, null|integer $expiresIn)

Stores a value for a given key across PHP sessions



* Visibility: **public**
* This method is defined by [NPR\One\Interfaces\StorageInterface](NPR-One-Interfaces-StorageInterface.md)


#### Arguments
* $key **string**
* $value **mixed**
* $expiresIn **null|integer** - &lt;p&gt;An optional TTL (in seconds) for the data, relative to the current Unix timestamp&lt;/p&gt;



### get

    mixed NPR\One\Interfaces\StorageInterface::get(string $key)

Gets a value for a given key across PHP sessions



* Visibility: **public**
* This method is defined by [NPR\One\Interfaces\StorageInterface](NPR-One-Interfaces-StorageInterface.md)


#### Arguments
* $key **string**



### compare

    boolean NPR\One\Interfaces\StorageInterface::compare(string $key, mixed $value)

The provided $key should be used to lookup a value and then compare
that value to the $value provided. If they match, return true. If not, false.



* Visibility: **public**
* This method is defined by [NPR\One\Interfaces\StorageInterface](NPR-One-Interfaces-StorageInterface.md)


#### Arguments
* $key **string**
* $value **mixed**



### remove

    mixed NPR\One\Interfaces\StorageInterface::remove(string $key)

Remove all data associated with a given key



* Visibility: **public**
* This method is defined by [NPR\One\Interfaces\StorageInterface](NPR-One-Interfaces-StorageInterface.md)


#### Arguments
* $key **string**



### setDomain

    mixed NPR\One\Providers\CookieProvider::setDomain(null|string $domain)

Sets the domain to use for the cookies.



* Visibility: **public**


#### Arguments
* $domain **null|string**



### setKeyPrefix

    mixed NPR\One\Providers\CookieProvider::setKeyPrefix(string $prefix)

If you have multiple proxies living on one server and are using the same cookie domain, you may need to be able
to use a prefix to differentiate between them. Use this function in that case.

(By default, this should not be needed, and the prefix is initially set to an empty string.)

* Visibility: **public**


#### Arguments
* $prefix **string**



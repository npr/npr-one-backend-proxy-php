NPR\One\Interfaces\StorageInterface
===============

Establishes a set of requirements for the storage provider for the project




* Interface name: StorageInterface
* Namespace: NPR\One\Interfaces
* This is an **interface**






Methods
-------


### set

    mixed NPR\One\Interfaces\StorageInterface::set(string $key, mixed $value, null|integer $expiresIn)

Stores a value for a given key across PHP sessions



* Visibility: **public**


#### Arguments
* $key **string**
* $value **mixed**
* $expiresIn **null|integer** - &lt;p&gt;An optional TTL (in seconds) for the data, relative to the current Unix timestamp&lt;/p&gt;



### get

    mixed NPR\One\Interfaces\StorageInterface::get(string $key)

Gets a value for a given key across PHP sessions



* Visibility: **public**


#### Arguments
* $key **string**



### compare

    boolean NPR\One\Interfaces\StorageInterface::compare(string $key, mixed $value)

The provided $key should be used to lookup a value and then compare
that value to the $value provided. If they match, return true. If not, false.



* Visibility: **public**


#### Arguments
* $key **string**
* $value **mixed**



### remove

    mixed NPR\One\Interfaces\StorageInterface::remove(string $key)

Remove all data associated with a given key



* Visibility: **public**


#### Arguments
* $key **string**



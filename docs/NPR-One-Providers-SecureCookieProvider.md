NPR\One\Providers\SecureCookieProvider
===============

An extension of CookieProvider that encrypts cookies before setting them and decrypts them when retrieving them




* Class name: SecureCookieProvider
* Namespace: NPR\One\Providers
* Parent class: [NPR\One\Providers\CookieProvider](NPR-One-Providers-CookieProvider.md)







Methods
-------


### setEncryptionProvider

    mixed NPR\One\Providers\SecureCookieProvider::setEncryptionProvider(\NPR\One\Interfaces\EncryptionInterface $encryptionProvider)

Sets the encryption provider that will be used to encrypt cookies before setting them and decrypt cookies when
retrieving them.



* Visibility: **public**


#### Arguments
* $encryptionProvider **[NPR\One\Interfaces\EncryptionInterface](NPR-One-Interfaces-EncryptionInterface.md)**



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
* This method is defined by [NPR\One\Providers\CookieProvider](NPR-One-Providers-CookieProvider.md)


#### Arguments
* $domain **null|string**



### setKeyPrefix

    mixed NPR\One\Providers\CookieProvider::setKeyPrefix(string $prefix)

If you have multiple proxies living on one server and are using the same cookie domain, you may need to be able
to use a prefix to differentiate between them. Use this function in that case.

(By default, this should not be needed, and the prefix is initially set to an empty string.)

* Visibility: **public**
* This method is defined by [NPR\One\Providers\CookieProvider](NPR-One-Providers-CookieProvider.md)


#### Arguments
* $prefix **string**



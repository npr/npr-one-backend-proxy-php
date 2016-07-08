NPR\One\Providers\EncryptionProvider
===============

A sample encryption provider, used in tandem with the SecureCookieProvider as the default implementation for
secure storage of refresh tokens.




* Class name: EncryptionProvider
* Namespace: NPR\One\Providers
* This class implements: [NPR\One\Interfaces\EncryptionInterface](NPR-One-Interfaces-EncryptionInterface.md)






Methods
-------


### isValid

    boolean NPR\One\Interfaces\EncryptionInterface::isValid()

Returns whether or not this EncryptionProvider is valid and ready to be used. This is a good
place to perform checks such as making sure any particular PHP extensions or packages
required for this encryption algorithm are installed. If no such checks are required, just
hard-code the function to return true.



* Visibility: **public**
* This method is defined by [NPR\One\Interfaces\EncryptionInterface](NPR-One-Interfaces-EncryptionInterface.md)




### encrypt

    string NPR\One\Interfaces\EncryptionInterface::encrypt(string $value)

Securely encrypts the given text.



* Visibility: **public**
* This method is defined by [NPR\One\Interfaces\EncryptionInterface](NPR-One-Interfaces-EncryptionInterface.md)


#### Arguments
* $value **string**



### decrypt

    string NPR\One\Interfaces\EncryptionInterface::decrypt(string $value)

Securely decrypts the given text.



* Visibility: **public**
* This method is defined by [NPR\One\Interfaces\EncryptionInterface](NPR-One-Interfaces-EncryptionInterface.md)


#### Arguments
* $value **string**



### setSalt

    mixed NPR\One\Providers\EncryptionProvider::setSalt(string $salt)

Sets the salt for the encryption. This function must be called with a valid argument at least once before the
EncryptionProvider is available for use.



* Visibility: **public**


#### Arguments
* $salt **string**



### setCipherMethod

    mixed NPR\One\Providers\EncryptionProvider::setCipherMethod(string $cipherMethod)

Sets the cipher method to use for the encryption. By default, it will attempt to use "aes-256-ctr", but this
may not be available on your system. For a complete list of possible inputs, call `openssl_get_cipher_methods()`
on your server; results will vary by environment.



* Visibility: **public**


#### Arguments
* $cipherMethod **string**



NPR\One\Interfaces\EncryptionInterface
===============

Establishes a set of requirements for the encryption provider for the project




* Interface name: EncryptionInterface
* Namespace: NPR\One\Interfaces
* This is an **interface**






Methods
-------


### isValid

    boolean NPR\One\Interfaces\EncryptionInterface::isValid()

Returns whether or not this EncryptionProvider is valid and ready to be used. This is a good
place to perform checks such as making sure any particular PHP extensions or packages
required for this encryption algorithm are installed. If no such checks are required, just
hard-code the function to return true.



* Visibility: **public**




### encrypt

    string NPR\One\Interfaces\EncryptionInterface::encrypt(string $value)

Securely encrypts the given text.



* Visibility: **public**


#### Arguments
* $value **string**



### decrypt

    string NPR\One\Interfaces\EncryptionInterface::decrypt(string $value)

Securely decrypts the given text.



* Visibility: **public**


#### Arguments
* $value **string**



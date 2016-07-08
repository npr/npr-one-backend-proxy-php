<?php

namespace NPR\One\Interfaces;


/**
 * Establishes a set of requirements for the encryption provider for the project
 *
 * @package NPR\One\Interfaces
 */
interface EncryptionInterface
{
    /**
     * Returns whether or not this EncryptionProvider is valid and ready to be used. This is a good
     * place to perform checks such as making sure any particular PHP extensions or packages
     * required for this encryption algorithm are installed. If no such checks are required, just
     * hard-code the function to return true.
     *
     * @return boolean
     */
    public function isValid();

    /**
     * Securely encrypts the given text.
     *
     * @param string $value
     * @return string
     * @throws \InvalidArgumentException if no value is passed in, or the value isn't a string
     */
    public function encrypt($value);

    /**
     * Securely decrypts the given text.
     *
     * @param string $value
     * @return string
     * @throws \InvalidArgumentException if no value is passed in, or the value isn't a string
     */
    public function decrypt($value);
}

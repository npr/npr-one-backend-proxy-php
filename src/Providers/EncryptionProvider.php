<?php

namespace NPR\One\Providers;

use NPR\One\Interfaces\EncryptionInterface;


/**
 * A sample encryption provider, used in tandem with the SecureCookieProvider as the default implementation for
 * secure storage of refresh tokens.
 *
 * @package NPR\One\Providers
 */
class EncryptionProvider implements EncryptionInterface
{
    /** @var string - the cipher method to use, assuming it is available; defaults to "aes-256-ctr"
      * @internal */
    protected $cipherMethod = 'aes-256-ctr';
    /** @var string - the salt to use for the encryption algorithm
      * @internal */
    protected $salt;


    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        if (!extension_loaded('openssl') || !isset($this->salt))
        {
            return false;
        }
        if (!in_array($this->cipherMethod, openssl_get_cipher_methods(true)))
        {
            return false; // @codeCoverageIgnore
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($value)
    {
        if (empty($value))
        {
            throw new \InvalidArgumentException('Must specify a value to encrypt');
        }
        if (!is_string($value))
        {
            throw new \InvalidArgumentException('The passed-in value must be a string');
        }

        $ivSize = openssl_cipher_iv_length($this->cipherMethod);
        $iv = openssl_random_pseudo_bytes($ivSize);
        $hashedSalt = openssl_digest($this->salt, 'sha256', true);
        $encryptedText = openssl_encrypt($value, $this->cipherMethod, $hashedSalt, OPENSSL_RAW_DATA, $iv);

        if ($encryptedText === false)
        {
            throw new \Exception('EncryptionProvider failed to encrypt the text; error message: ' . openssl_error_string()); // @codeCoverageIgnore
        }

        $encryptedValue = base64_encode($iv . $encryptedText);

        return $encryptedValue;
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($value)
    {
        if (empty($value))
        {
            throw new \InvalidArgumentException('Must specify a value to decrypt');
        }
        if (!is_string($value))
        {
            throw new \InvalidArgumentException('The passed-in value must be a string');
        }

        $encrypted = base64_decode($value);
        $ivSize = openssl_cipher_iv_length($this->cipherMethod);
        $iv = mb_substr($encrypted, 0, $ivSize, '8bit');
        $encryptedText = mb_substr($encrypted, $ivSize, null, '8bit');
        $hashedSalt = openssl_digest($this->salt, 'sha256', true);
        $decryptedText = openssl_decrypt($encryptedText, $this->cipherMethod, $hashedSalt, OPENSSL_RAW_DATA, $iv);

        if ($decryptedText === false)
        {
            throw new \Exception('EncryptionProvider failed to decrypt the text; error message: ' . openssl_error_string()); // @codeCoverageIgnore
        }

        return $decryptedText;
    }

    /**
     * Sets the salt for the encryption. This function must be called with a valid argument at least once before the
     * EncryptionProvider is available for use.
     *
     * @param string $salt
     * @throws \InvalidArgumentException if the passed-in value is not a non-empty string
     */
    public function setSalt($salt)
    {
        if (empty($salt) || !is_string($salt))
        {
            throw new \InvalidArgumentException('The encryption salt must be a string');
        }
        $this->salt = $salt;
    }

    /**
     * Sets the cipher method to use for the encryption. By default, it will attempt to use "aes-256-ctr", but this
     * may not be available on your system. For a complete list of possible inputs, call `openssl_get_cipher_methods()`
     * on your server; results will vary by environment.
     *
     * @see http://php.net/manual/en/function.openssl-get-cipher-methods.php
     *
     * @param string $cipherMethod
     * @throws \InvalidArgumentException if the passed-in value is not a non-empty string
     */
    public function setCipherMethod($cipherMethod)
    {
        if (empty($cipherMethod) || !is_string($cipherMethod))
        {
            throw new \InvalidArgumentException('The encryption cipher method must be a string');
        }
        if (!in_array($cipherMethod, openssl_get_cipher_methods(true)))
        {
            throw new \InvalidArgumentException('The selected cipher is not available on your system');
        }
        $this->cipherMethod = $cipherMethod;
    }
}

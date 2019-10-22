<?php

namespace NPR\One\Providers;

use NPR\One\Interfaces\EncryptionInterface;


/**
 * An extension of CookieProvider that encrypts cookies before setting them and decrypts them when retrieving them
 *
 * @package NPR\One\Providers
 * @codeCoverageIgnore
 */
class SecureCookieProvider extends CookieProvider
{
    /** @var EncryptionInterface - the encryption provider to use when encrypting and decrypting the cookies
      * @internal */
    private $encryptionProvider;


    /**
     * Sets the encryption provider that will be used to encrypt cookies before setting them and decrypt cookies when
     * retrieving them.
     *
     * @param EncryptionInterface $encryptionProvider
     */
    public function setEncryptionProvider(EncryptionInterface $encryptionProvider)
    {
        $this->encryptionProvider = $encryptionProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $expiresIn = null)
    {
        $encryptedValue = $this->encryptionProvider->encrypt($value);
        parent::set($key, $encryptedValue, $expiresIn);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key): ?string
    {
        $value = parent::get($key);
        if (!empty($value))
        {
            return $this->encryptionProvider->decrypt($value);
        }
        return $value;
    }
}

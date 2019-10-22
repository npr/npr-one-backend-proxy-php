<?php

namespace NPR\One\Providers;

use NPR\One\Interfaces\StorageInterface;


/**
 * A thin wrapper around the PHP functions to get and set cookies. Useful for unit testing.
 *
 * @package NPR\One\Providers
 */
class CookieProvider implements StorageInterface
{
    /** @var null|string - the domain to use for the cookies
      * @internal */
    private $domain = null;
    /** @var string - the key prefix use for the cookies
     * @internal */
    public $keyPrefix = '';


    /**
     * Sets a cookie value for the given name
     *
     * @param string $key
     * @param string $value
     * @param null|int $expiresIn
     * @codeCoverageIgnore
     */
    public function set($key, $value, $expiresIn = null)
    {
        if (isset($expiresIn))
        {
            $expiresIn += time();
        }
        setcookie($this->keyPrefix . $key, $value, $expiresIn, '/', $this->domain);
    }

    /**
     * Get the value of cookie by given name
     *
     * @param string $key
     * @return string|null
     * @codeCoverageIgnore
     */
    public function get($key): ?string
    {
        return isset($_COOKIE[$this->keyPrefix . $key]) ? $_COOKIE[$this->keyPrefix . $key] : null;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function compare($key, $value): bool
    {
        return $this->get($key) === $value;
    }

    /**
     * Removes the cookie if one exists
     *
     * @param string $key
     * @codeCoverageIgnore
     */
    public function remove($key)
    {
        if (isset($_COOKIE[$this->keyPrefix . $key]))
        {
            unset($_COOKIE[$this->keyPrefix . $key]);
            setcookie($this->keyPrefix . $key, '', time() - 3600, '/'); // empty value and old timestamp
        }
    }

    /**
     * Sets the domain to use for the cookies.
     *
     * @param null|string $domain
     * @throws \InvalidArgumentException if the passed-in value is not either a non-empty string, or null
     */
    public function setDomain($domain = null)
    {
        if (!($domain === null || (!empty($domain) && is_string($domain))))
        {
            throw new \InvalidArgumentException('If set, the cookie domain must be a string; otherwise, it should be null');
        }
        $this->domain = $domain;
    }

    /**
     * If you have multiple proxies living on one server and are using the same cookie domain, you may need to be able
     * to use a prefix to differentiate between them. Use this function in that case.
     * (By default, this should not be needed, and the prefix is initially set to an empty string.)
     *
     * @param string $prefix
     * @throws \InvalidArgumentException if the passed-in value is not a string
     */
    public function setKeyPrefix($prefix = '')
    {
        if (!is_string($prefix))
        {
            throw new \InvalidArgumentException('The cookie prefix should always be a string, even if it is an empty one.');
        }
        $this->keyPrefix = $prefix;
    }
}

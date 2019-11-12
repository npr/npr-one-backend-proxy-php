<?php

namespace NPR\One\Interfaces;


/**
 * Establishes a set of requirements for the storage provider for the project
 *
 * @package NPR\One\Interfaces
 */
interface StorageInterface
{
    /**
     * Stores a value for a given key across PHP sessions
     *
     * @param string $key
     * @param mixed $value
     * @param null|int $expiresIn An optional TTL (in seconds) for the data, relative to the current Unix timestamp
     */
    public function set($key, $value, $expiresIn = null);

    /**
     * Gets a value for a given key across PHP sessions
     *
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * The provided $key should be used to lookup a value and then compare
     * that value to the $value provided. If they match, return true. If not, false.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function compare($key, $value): bool;

    /**
     * Remove all data associated with a given key
     *
     * @param string $key
     */
    public function remove($key);
}

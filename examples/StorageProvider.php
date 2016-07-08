<?php

namespace Your\Package\Here;

use NPR\One\Interfaces\StorageInterface;
use Predis\Client;


class StorageProvider implements StorageInterface
{
    const MY_CUSTOM_KEY_PREFIX = 'npr:one:';


    /**
     * @inheritdoc
     */
    public function set($key, $value, $expiresIn = null)
    {
        $client = new Client();
        $client->set(self::MY_CUSTOM_KEY_PREFIX . $key, $value);
        if (!empty($expiresIn))
        {
            $client->expire($expiresIn);
        }
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        $client = new Client();
        return $client->get(self::MY_CUSTOM_KEY_PREFIX . $key);
    }

    /**
     * @inheritdoc
     */
    public function compare($key, $value)
    {
        return $this->get($key) === $value;
    }

    /**
     * @inheritdoc
     */
    public function remove($key)
    {
        $client = new Client();
        $client->del(self::MY_CUSTOM_KEY_PREFIX . $key);
    }
}

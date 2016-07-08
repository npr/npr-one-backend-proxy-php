<?php

use NPR\One\Providers\CookieProvider;


class CookieProviderTests extends PHPUnit_Framework_TestCase
{
    private static $domain = '.example.com';
    private static $keyPrefix = 'example_';


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetDomainWithArgumentOfWrongType()
    {
        $provider = new CookieProvider();
        $provider->setDomain(new \stdClass());
    }

    public function testSetDomain()
    {
        $provider = new CookieProvider();
        $provider->setDomain(self::$domain);

        // nothing really to do here, just verifying that it doesn't throw an exception
    }

    public function testSetDomainWithEmptyArgument()
    {
        $provider = new CookieProvider();
        $provider->setDomain(null);

        // nothing really to do here, just verifying that it doesn't throw an exception
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetKeyPrefixWithEmptyArgument()
    {
        $provider = new CookieProvider();
        $provider->setKeyPrefix(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetKeyPrefixWithArgumentOfWrongType()
    {
        $provider = new CookieProvider();
        $provider->setKeyPrefix(new \stdClass());
    }

    public function testSetKeyPrefix()
    {
        $provider = new CookieProvider();
        $provider->setKeyPrefix(self::$keyPrefix);

        // nothing really to do here, just verifying that it doesn't throw an exception
    }
}

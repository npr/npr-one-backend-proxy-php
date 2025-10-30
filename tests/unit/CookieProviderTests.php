<?php

use NPR\One\Providers\CookieProvider;
use PHPUnit\Framework\TestCase;

class CookieProviderTests extends TestCase
{
    private static $domain = '.example.com';
    private static $keyPrefix = 'example_';


    public function testSetDomainWithArgumentOfWrongType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $provider = new CookieProvider();
        $provider->setDomain(new \stdClass());
    }

    public function testSetDomain()
    {
        $provider = new CookieProvider();
        $provider->setDomain(self::$domain);
        $reflection = new \ReflectionClass($provider);
        $prop = $reflection->getProperty('domain');
        $prop->setAccessible(true);
        $this->assertSame(self::$domain, $prop->getValue($provider), 'Domain should be stored internally');
    }

    public function testSetDomainWithEmptyArgument()
    {
        $provider = new CookieProvider();
        $provider->setDomain(null);
        $reflection = new \ReflectionClass($provider);
        $prop = $reflection->getProperty('domain');
        $prop->setAccessible(true);
        $this->assertNull($prop->getValue($provider), 'Domain should be null when set to null');
    }

    public function testSetKeyPrefixWithEmptyArgument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $provider = new CookieProvider();
        $provider->setKeyPrefix(null);
    }

    public function testSetKeyPrefixWithArgumentOfWrongType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $provider = new CookieProvider();
        $provider->setKeyPrefix(new \stdClass());
    }

    public function testSetKeyPrefix()
    {
        $provider = new CookieProvider();
        $provider->setKeyPrefix(self::$keyPrefix);
        $this->assertSame(self::$keyPrefix, $provider->keyPrefix, 'Key prefix should be updated');
    }
}

<?php

use PHPUnit\Framework\TestCase;

use NPR\One\Providers\CookieProvider;

class CookieProviderTest extends TestCase
{
    private static $domain = '.example.com';
    private static $keyPrefix = 'example_';


    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testSetDomainWithArgumentOfWrongType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $provider = new CookieProvider();
        $provider->setDomain(new \stdClass());
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testSetDomain()
    {
        $provider = new CookieProvider();
        $provider->setDomain(self::$domain);

        // nothing really to do here, just verifying that it doesn't throw an exception
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testSetDomainWithEmptyArgument()
    {
        $provider = new CookieProvider();
        $provider->setDomain(null);

        // nothing really to do here, just verifying that it doesn't throw an exception
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testSetKeyPrefixWithEmptyArgument()
    {
        $this->expectException(\InvalidArgumentException::class);

        $provider = new CookieProvider();
        $provider->setKeyPrefix(null);
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testSetKeyPrefixWithArgumentOfWrongType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $provider = new CookieProvider();
        $provider->setKeyPrefix(new \stdClass());
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testSetKeyPrefix()
    {
        $provider = new CookieProvider();
        $provider->setKeyPrefix(self::$keyPrefix);

        // nothing really to do here, just verifying that it doesn't throw an exception
    }
}

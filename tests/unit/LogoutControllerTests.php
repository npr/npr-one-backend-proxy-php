<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use NPR\One\Controllers\LogoutController;
use NPR\One\DI\DI;


class LogoutControllerTests extends PHPUnit_Framework_TestCase
{
    /** @var \NPR\One\Providers\SecureCookieProvider */
    private $mockSecureCookie;
    /** @var \NPR\One\Providers\EncryptionProvider */
    private $mockEncryption;
    /** @var \NPR\One\Interfaces\ConfigInterface */
    private $mockConfig;
    /** @var \GuzzleHttp\Client */
    private $mockClient;

    /** @var string */
    private static $accessToken = 'LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken';
    /** @var string */
    private static $refreshToken = '6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh';
    /** @var string */
    private static $clientCredentialsToken = 'rWlf1a84WB09R0H65D8Q6Mm8E3ttDWOKfakecc';


    public function setUp()
    {
        $this->mockSecureCookie = $this->getMock('NPR\One\Providers\SecureCookieProvider');

        $this->mockEncryption = $this->getMock('NPR\One\Providers\EncryptionProvider');
        $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockEncryption->method('set')->willReturn(true);

        $this->mockConfig = $this->getMock('NPR\One\Interfaces\ConfigInterface');
        $this->mockConfig->method('getClientCredentialsToken')->willReturn(self::$clientCredentialsToken);
        $this->mockConfig->method('getNprApiHost')->willReturn('https://api.npr.org');
        $this->mockConfig->method('getCookieDomain')->willReturn('.example.com');
        $this->mockConfig->method('getEncryptionSalt')->willReturn('asYh&%D9ne!j8HKQ');

        $this->mockClient = new Client(['handler' => HandlerStack::create(new MockHandler())]);

        DI::container()->set('NPR\One\Providers\SecureCookieProvider', $this->mockSecureCookie);
        DI::container()->set('NPR\One\Providers\EncryptionProvider', $this->mockEncryption);
        DI::container()->set('GuzzleHttp\Client', $this->mockClient); // just in case
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #ConfigProvider must be set. See.*setConfigProvider#
     */
    public function testConfigProviderException()
    {
        $controller = new LogoutController();
        $controller->deleteAccessAndRefreshTokens();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#
     */
    public function testSecureStorageProviderException()
    {
        $mockCookie = $this->getMock('NPR\One\Providers\CookieProvider');

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($mockCookie);
        $controller->deleteAccessAndRefreshTokens();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be valid. See.*EncryptionInterface::isValid#
     */
    public function testEncryptionProviderException()
    {
        $mockEncryption = $this->getMock('NPR\One\Providers\EncryptionProvider');
        $mockEncryption->method('isValid')->willReturn(false);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setEncryptionProvider($mockEncryption);
        $controller->deleteAccessAndRefreshTokens();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage   Could not locate a token to revoke
     */
    public function testDeleteAccessAndRefreshTokensMissingToken()
    {
        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage   Must specify token to be revoked
     */
    public function testDeleteAccessAndRefreshTokensInvalidToken()
    {
        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens(new \stdClass());
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteAccessAndRefreshTokensWithApiError()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set('GuzzleHttp\Client', $client);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens(self::$accessToken);
    }

    public function testDeleteAccessAndRefreshTokens()
    {
        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set('GuzzleHttp\Client', $client);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens(self::$accessToken);

        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testDeleteAccessAndRefreshTokensUsingRefreshToken()
    {
        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set('GuzzleHttp\Client', $client);

        $this->mockSecureCookie->method('get')->willReturn(self::$refreshToken);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens();

        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

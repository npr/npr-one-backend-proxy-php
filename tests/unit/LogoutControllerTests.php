<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use NPR\One\Controllers\LogoutController;
use NPR\One\DI\DI;
use NPR\One\Interfaces\ConfigInterface;
use NPR\One\Providers\CookieProvider;
use NPR\One\Providers\EncryptionProvider;
use NPR\One\Providers\SecureCookieProvider;


class LogoutControllerTests extends PHPUnit_Framework_TestCase
{
    /** @var SecureCookieProvider */
    private $mockSecureCookie;
    /** @var EncryptionProvider */
    private $mockEncryption;
    /** @var ConfigInterface */
    private $mockConfig;
    /** @var Client */
    private $mockClient;

    /** @var string */
    private static $accessToken = 'LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken';
    /** @var string */
    private static $refreshToken = '6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh';
    /** @var string */
    private static $clientCredentialsToken = 'rWlf1a84WB09R0H65D8Q6Mm8E3ttDWOKfakecc';


    public function setUp()
    {
        $this->mockSecureCookie = $this->getMock(SecureCookieProvider::class);

        $this->mockEncryption = $this->getMock(EncryptionProvider::class);
        $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockEncryption->method('set')->willReturn(true);

        $this->mockConfig = $this->getMock(ConfigInterface::class);
        $this->mockConfig->method('getClientCredentialsToken')->willReturn(self::$clientCredentialsToken);
        $this->mockConfig->method('getNprAuthorizationServiceHost')->willReturn('https://authorization.api.npr.org');
        $this->mockConfig->method('getCookieDomain')->willReturn('.example.com');
        $this->mockConfig->method('getEncryptionSalt')->willReturn('asYh&%D9ne!j8HKQ');

        $this->mockClient = new Client(['handler' => HandlerStack::create(new MockHandler())]);

        DI::container()->set(SecureCookieProvider::class, $this->mockSecureCookie);
        DI::container()->set(EncryptionProvider::class, $this->mockEncryption);
        DI::container()->set(Client::class, $this->mockClient); // just in case
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
        $mockCookie = $this->getMock(CookieProvider::class);

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
        $mockEncryption = $this->getMock(EncryptionProvider::class);
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

        DI::container()->set(Client::class, $client);

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

        DI::container()->set(Client::class, $client);

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

        DI::container()->set(Client::class, $client);

        $this->mockSecureCookie->method('get')->willReturn(self::$refreshToken);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens();

        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

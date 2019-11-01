<?php

use GuzzleHttp\{Client, HandlerStack};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use NPR\One\Controllers\LogoutController;
use NPR\One\DI\DI;
use NPR\One\Interfaces\{ConfigInterface, EncryptionInterface};
use NPR\One\Providers\{CookieProvider, EncryptionProvider, SecureCookieProvider};

class LogoutControllerTest extends TestCase
{
    /** @var CookieProvider */
    private $mockCookie;
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


    public function setUp(): void
    {
        $this->mockCookie = $this->getMockBuilder(CookieProvider::class)->getMock();

        $this->mockSecureCookie = $this->getMockBuilder(SecureCookieProvider::class)->getMock();

        $this->mockEncryption = $this->getMockBuilder(EncryptionProvider::class)->setMethods(['isValid', 'set'])->getMock();
        $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockEncryption->method('set')->willReturn(true);

        $this->mockEncrypt = $this->createMock(EncryptionInterface::class);
        $this->mockEncrypt->method('isValid')->willReturn(false);

        $this->mockConfig = $this->createMock(ConfigInterface::class);
        $this->mockConfig->method('getClientCredentialsToken')->willReturn(self::$clientCredentialsToken);
        $this->mockConfig->method('getNprAuthorizationServiceHost')->willReturn('https://authorization.api.npr.org');
        $this->mockConfig->method('getCookieDomain')->willReturn('.example.com');
        $this->mockConfig->method('getEncryptionSalt')->willReturn('asYh&%D9ne!j8HKQ');

        $this->mockClient = new Client(['handler' => HandlerStack::create(new MockHandler())]);

        DI::container()->set(CookieProvider::class, $this->mockCookie);
        DI::container()->set(SecureCookieProvider::class, $this->mockSecureCookie);
        DI::container()->set(EncryptionProvider::class, $this->mockEncryption);
        DI::container()->set(Client::class, $this->mockClient); // just in case
    }

    /**
     * Expect exception type\RuntimeException
     * @expectedExceptionMessageRegExp   #ConfigProvider must be set. See.*setConfigProvider#
     */
    public function testConfigProviderException()
    {
        $this->expectException(\RuntimeException::class);

        $controller = new LogoutController();
        $controller->deleteAccessAndRefreshTokens();
    }

    /**
     * Expect exception type\RuntimeException
     * @expectedExceptionMessageRegExp   #WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#
     */
    public function testSecureStorageProviderException()
    {
        $mockCookie = $this->createMock(CookieProvider::class);
        $mockCookie->method('compare')->willReturn(false);

        $this->expectException(\RuntimeException::class);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockCookie);
        $controller->deleteAccessAndRefreshTokens();
    }

    /**
     * Expect exception type\RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be valid. See.*EncryptionInterface::isValid#
     */
    public function testEncryptionProviderException()
    {
        $mockEncryption = $this->createMock(EncryptionProvider::class);
        $mockEncryption->method('isValid')->willReturn(false);

        $this->expectException(\Error::class);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setEncryptionProvider($this->mockEncrypt);
        $controller->deleteAccessAndRefreshTokens();
    }

    /**
     * Expect exception type\Exception
     * @expectedExceptionMessage   Could not locate a token to revoke
     */
    public function testDeleteAccessAndRefreshTokensMissingToken()
    {
        $this->expectException(\Exception::class);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens();
    }

    /**
     * Expect exception type\InvalidArgumentException
     * @expectedExceptionMessage   Must specify token to be revoked
     */
    public function testDeleteAccessAndRefreshTokensInvalidToken()
    {
        $this->expectException(\InvalidArgumentException::class);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens(new \stdClass());
    }

    /**
     * Expect exception type\Exception
     */
    public function testDeleteAccessAndRefreshTokensWithApiError()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set(Client::class, $client);

        $this->expectException(\Exception::class);

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

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
use NPR\One\Interfaces\EncryptionInterface;
use NPR\One\Interfaces\StorageInterface;
use PHPUnit\Framework\TestCase;

/**
 * @noinspection PhpPossiblePolymorphicInvocationInspection
 * @psalm-suppress InvalidArgument
 * @phpstan-ignore-file
 */
class LogoutControllerTests extends TestCase
{
    /** @var SecureCookieProvider|\PHPUnit\Framework\MockObject\MockObject */
    private $mockSecureCookie;
    /** @var EncryptionProvider|\PHPUnit\Framework\MockObject\MockObject|EncryptionProvider */
    private $mockEncryption;
    /** @var ConfigInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $mockConfig;
    /** @var Client */
    private $mockClient;

    /** @var string */
    private static $accessToken = 'LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken';
    /** @var string */
    private static $refreshToken = '6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh';
    /** @var string */
    private static $clientCredentialsToken = 'rWlf1a84WB09R0H65D8Q6Mm8E3ttDWOKfakecc';


    protected function setUp(): void
    {
        // Mock the secure cookie provider so setEncryptionProvider exists
        $this->mockSecureCookie = $this->getMockBuilder(SecureCookieProvider::class)->disableOriginalConstructor()->getMock();

    // Use a partial mock of the concrete provider so setSalt is available
    $this->mockEncryption = $this->getMockBuilder(EncryptionProvider::class)->onlyMethods(['isValid', 'encrypt', 'decrypt'])->getMock();
    $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockConfig = $this->getMockBuilder(ConfigInterface::class)->getMock();
        $this->mockConfig->method('getClientCredentialsToken')->willReturn(self::$clientCredentialsToken);
        $this->mockConfig->method('getNprAuthorizationServiceHost')->willReturn('https://authorization.api.npr.org');
        $this->mockConfig->method('getCookieDomain')->willReturn('.example.com');
        $this->mockConfig->method('getEncryptionSalt')->willReturn('asYh&%D9ne!j8HKQ');

        $this->mockClient = new Client(['handler' => HandlerStack::create(new MockHandler())]);

        DI::container()->set(SecureCookieProvider::class, $this->mockSecureCookie);
        DI::container()->set(EncryptionProvider::class, $this->mockEncryption);
        DI::container()->set(Client::class, $this->mockClient); // just in case
    }

    public function testConfigProviderException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/ConfigProvider must be set.*setConfigProvider/');
        $controller = new LogoutController();
        $controller->deleteAccessAndRefreshTokens();
    }

    public function testSecureStorageProviderException()
    {
        $mockCookie = $this->getMockBuilder(CookieProvider::class)->disableOriginalConstructor()->getMock();
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider\./');

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($mockCookie);
        $controller->deleteAccessAndRefreshTokens();
    }

    public function testEncryptionProviderException()
    {
    $mockEncryption = $this->getMockBuilder(EncryptionProvider::class)->onlyMethods(['isValid', 'encrypt', 'decrypt'])->getMock();
    $mockEncryption->method('isValid')->willReturn(false);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/EncryptionProvider must be valid.*EncryptionInterface::isValid/');

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setEncryptionProvider($mockEncryption);
        $controller->deleteAccessAndRefreshTokens();
    }

    public function testDeleteAccessAndRefreshTokensMissingToken()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Could not locate a token to revoke');
        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens();
    }

    public function testDeleteAccessAndRefreshTokensInvalidToken()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must specify token to be revoked');
        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens(new \stdClass());
    }

    public function testDeleteAccessAndRefreshTokensWithApiError()
    {
        $this->expectException(\Exception::class);
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

        $this->mockSecureCookie->expects($this->any())
            ->method('get')
            ->with('refresh_token')
            ->willReturn(self::$refreshToken);

        $controller = new LogoutController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->deleteAccessAndRefreshTokens();

        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

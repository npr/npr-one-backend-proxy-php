<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use NPR\One\Controllers\AuthCodeController;
use NPR\One\DI\DI;
use NPR\One\Interfaces\ConfigInterface;
use NPR\One\Interfaces\StorageInterface;
use NPR\One\Models\AccessTokenModel;
use NPR\One\Providers\CookieProvider;
use NPR\One\Providers\SecureCookieProvider;
use NPR\One\Providers\EncryptionProvider;
use PHPUnit\Framework\TestCase;

/**
 * @noinspection PhpPossiblePolymorphicInvocationInspection
 * @psalm-suppress InvalidArgument
 * @phpstan-ignore-file
 */
class AuthCodeControllerTests extends TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';
    const ACCESS_TOKEN_RESPONSE_2 = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';

    /** @var CookieProvider|\PHPUnit\Framework\MockObject\MockObject */
    private $mockCookie;
    /** @var SecureCookieProvider|\PHPUnit\Framework\MockObject\MockObject */
    private $mockSecureCookie;
    /** @var EncryptionProvider|\PHPUnit\Framework\MockObject\MockObject */
    private $mockEncryption;
    /** @var StorageInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $mockStorage;
    /** @var ConfigInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $mockConfig;
    /** @var Client */
    private $mockClient;

    private static string $clientId = 'fake_client_id';

    protected function setUp(): void
    {
        $this->mockCookie = $this->createMock(CookieProvider::class);
        $this->mockSecureCookie = $this->createMock(SecureCookieProvider::class);
        $this->mockEncryption = $this->createMock(EncryptionProvider::class);
        $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockStorage = $this->createMock(StorageInterface::class);
        $this->mockStorage->method('compare')->willReturn(true);
        $this->mockConfig = $this->createMock(ConfigInterface::class);
        $this->mockConfig->method('getClientId')->willReturn(self::$clientId);
        $this->mockConfig->method('getNprAuthorizationServiceHost')->willReturn('https://authorization.api.npr.org');
        $this->mockConfig->method('getClientUrl')->willReturn('https://one.example.com');
        $this->mockConfig->method('getAuthCodeCallbackUrl')->willReturn('https://one.example.com/oauth2/callback');
        $this->mockConfig->method('getCookieDomain')->willReturn('.example.com');
        $this->mockConfig->method('getEncryptionSalt')->willReturn('asYh&%D9ne!j8HKQ');
        $this->mockClient = new Client(['handler' => HandlerStack::create(new MockHandler())]);
        DI::container()->set(CookieProvider::class, $this->mockCookie);
        DI::container()->set(SecureCookieProvider::class, $this->mockSecureCookie);
        DI::container()->set(EncryptionProvider::class, $this->mockEncryption);
        DI::container()->set(Client::class, $this->mockClient);
    }

    public function testGeoIpHeadersSetInConstructor(): void
    {
        $_SERVER['GEOIP_LATITUDE'] = 37.24;
        $_SERVER['GEOIP_LONGITUDE'] = -77.91;

        $controller = new AuthCodeController();

        $this->assertArrayHasKey('X-Latitude', $controller->getHeaders(), 'Latitude header not found');
        $this->assertEquals(37.24, $controller->getHeaders()['X-Latitude'], 'Latitude is not the correct value');
        $this->assertArrayHasKey('X-Longitude', $controller->getHeaders(), 'Longitude header not found');
        $this->assertEquals(-77.91, $controller->getHeaders()['X-Longitude'], 'Longitude is not the correct value');
    }

    public function testConfigProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#ConfigProvider must be set. See.*setConfigProvider#');
        $controller = new AuthCodeController();
        $controller->startAuthorizationGrant(['fake_scope']);
    }

    public function testStorageProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#StorageProvider must be set. See.*setStorageProvider#');
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->startAuthorizationGrant(['fake_scope']);
    }

    public function testSecureStorageProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#');
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->setSecureStorageProvider($this->mockCookie);
        $controller->startAuthorizationGrant(['fake_scope']);
    }

    public function testEncryptionProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#EncryptionProvider must be valid. See.*EncryptionInterface::isValid#');
        $mockEncryption = $this->createMock(EncryptionProvider::class);
        $mockEncryption->method('isValid')->willReturn(false);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->setEncryptionProvider($mockEncryption);
        $controller->startAuthorizationGrant(['fake_scope']);
    }

    public function testGetRedirectUri(): void
    {
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $url = $controller->getRedirectUri();
        $this->assertNotEmpty($url, 'Url should not be empty');
    }

    public function testStartAuthorizationGrantMissingScopes(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->startAuthorizationGrant([]);
    }

    public function testStartAuthorizationGrantInvalidScope(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->startAuthorizationGrant([new \stdClass()]);
    }

    public function testStartAuthorizationGrant(): void
    {
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $url = $controller->startAuthorizationGrant(['fake_scope']);
        $this->assertStringContainsString('/v2/authorize', $url);
        $this->assertStringContainsString('client_id=' . self::$clientId, $url);
        $this->assertStringContainsString('redirect_uri=', $url);
        $this->assertStringContainsString('state=', $url);
        $this->assertStringContainsString('response_type=code', $url);
        $this->assertStringContainsString('scope=fake_scope', $url);
    }

    public function testCompleteAuthorizationGrantMissingCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->completeAuthorizationGrant(null, null);
    }

    public function testCompleteAuthorizationGrantMissingState(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->completeAuthorizationGrant('fake_grant_code', null);
    }

    public function testCompleteAuthorizationGrantStateFailure(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('#Invalid state returned from OAuth server.*#');
        $this->mockStorage->method('compare')->willReturn(false);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->completeAuthorizationGrant('fake_grant_code', 'fake_state');
    }

    public function testCompleteAuthorizationGrantWithSwapAuthCodeNoSeparatorFailure(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('#Invalid state returned from OAuth server, colon separator missing.*#');
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler, 'http_errors' => false]);
        DI::container()->set(Client::class, $client);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->completeAuthorizationGrant('fake_grant_code', 'fake_state_without_colon');
    }

    public function testCompleteAuthorizationGrantWithSwapAuthCodeBadState(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('#Invalid state returned from OAuth server, server state .*#');
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler, 'http_errors' => false]);
        DI::container()->set(Client::class, $client);
        $mockStorage = $this->createMock(StorageInterface::class);
        $mockStorage->method('compare')->willReturn(false);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($mockStorage);
        $controller->completeAuthorizationGrant('fake_grant_code', 'fake_state:other');
    }

    public function testCompleteAuthorizationGrant(): void
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        DI::container()->set(Client::class, $client);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $accessToken = $controller->completeAuthorizationGrant('fake_grant_code', 'fake:state');
        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'completeAuthorizationGrant response was not of type AccessTokenModel: ' . print_r($accessToken, true));
        $this->assertSame(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testCompleteAuthorizationGrantNoRefreshToken(): void
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE_2),
        ]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        DI::container()->set(Client::class, $client);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $accessToken = $controller->completeAuthorizationGrant('fake_grant_code', 'fake:state');
        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'completeAuthorizationGrant response was not of type AccessTokenModel: ' . print_r($accessToken, true));
        $this->assertSame(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

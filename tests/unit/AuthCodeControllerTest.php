<?php

use GuzzleHttp\{Client, HandlerStack};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use NPR\One\Controllers\AuthCodeController;
use NPR\One\DI\DI;
use NPR\One\Interfaces\{ConfigInterface, EncryptionInterface, StorageInterface};
use NPR\One\Models\AccessTokenModel;
use NPR\One\Providers\{CookieProvider, EncryptionProvider, SecureCookieProvider};


class AuthCodeControllerTest extends TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';
    const ACCESS_TOKEN_RESPONSE_2 = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';

    /** @var CookieProvider */
    private $mockCookie;
    /** @var SecureCookieProvider */
    private $mockSecureCookie;
    /** @var EncryptionProvider */
    private $mockEncryption;
    /** @var StorageInterface */
    private $mockStorage;
     /** @var EncryptionInterface */
     private $mockEncrypt;
    /** @var ConfigInterface */
    private $mockConfig;
    /** @var Client */
    private $mockClient;

    /** @var string */
    private static $clientId = 'fake_client_id';


    public function setUp(): void
    {
        $this->mockCookie = $this->getMockBuilder(CookieProvider::class)->getMock();

        $this->mockSecureCookie = $this->getMockBuilder(SecureCookieProvider::class)->getMock();

        $this->mockEncryption = $this->getMockBuilder(EncryptionProvider::class)->setMethods(['isValid', 'set'])->getMock();
        $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockEncryption->method('set')->willReturn(true);

        $this->mockStorage = $this->createMock(StorageInterface::class);
        $this->mockStorage->method('compare')->willReturn(true);

        $this->mockEncrypt = $this->createMock(EncryptionInterface::class);
        $this->mockEncrypt->method('isValid')->willReturn(false);

        $this->mockConfig = $this->createMock(ConfigInterface::class);
        $this->mockConfig->method('getClientId')->willReturn(self::$clientId);
        $this->mockConfig->method('getClientSecret')->willReturn('');
        $this->mockConfig->method('getClientCredentialsToken')->willReturn('');
        $this->mockConfig->method('getNprAuthorizationServiceHost')->willReturn('https://authorization.api.npr.org');
        $this->mockConfig->method('getClientUrl')->willReturn('https://one.example.com');
        $this->mockConfig->method('getAuthCodeCallbackUrl')->willReturn('https://one.example.com/oauth2/callback');
        $this->mockConfig->method('getCookieDomain')->willReturn('.example.com');
        $this->mockConfig->method('getCookiePrefix')->willReturn('.example.com');
        $this->mockConfig->method('getEncryptionSalt')->willReturn('asYh&%D9ne!j8HKQ');

        $this->mockClient = new Client(['handler' => HandlerStack::create(new MockHandler())]);

        DI::container()->set(CookieProvider::class, $this->mockCookie);
        DI::container()->set(SecureCookieProvider::class, $this->mockSecureCookie);
        DI::container()->set(EncryptionProvider::class, $this->mockEncryption);
        DI::container()->set(Client::class, $this->mockClient); // just in case
    }

    public function testGeoIpHeadersSetInConstructor()
    {
        $_SERVER['GEOIP_LATITUDE'] = 37.24;
        $_SERVER['GEOIP_LONGITUDE'] = -77.91;

        $controller = new AuthCodeController();

        $this->assertArrayHasKey('X-Latitude', $controller->getHeaders(), 'Latitude header not found');
        $this->assertEquals($controller->getHeaders()['X-Latitude'], 37.24, 'Latitude is not the correct value');
        $this->assertArrayHasKey('X-Longitude', $controller->getHeaders(), 'Longitude header not found');
        $this->assertEquals($controller->getHeaders()['X-Longitude'], -77.91, 'Latitude is not the correct value');
    }

    /**
     * Expect exception type \RuntimeException
     * @expectedExceptionMessageRegExp   #ConfigProvider must be set. See.*setConfigProvider#
     */
    public function testConfigProviderException()
    {
        $this->expectException(\RuntimeException::class);
        $controller = new AuthCodeController();
        $controller->startAuthorizationGrant(['fake_scope']);
    }

    /**
     * Expect exception type \RuntimeException
     * @expectedExceptionMessageRegExp   #StorageProvider must be set. See.*setStorageProvider#
     */
    public function testStorageProviderException()
    {
        $this->expectException(\RuntimeException::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->startAuthorizationGrant(['fake_scope']);
    }

    /**
     * Expect exception type \RuntimeException
     * @expectedExceptionMessageRegExp   #WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#
     */
    public function testSecureStorageProviderException()
    {
        $this->expectException(\RuntimeException::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->setSecureStorageProvider($this->mockCookie);
        $controller->startAuthorizationGrant(['fake_scope']);
    }

    /**
     * Expect exception type \RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be valid. See.*EncryptionInterface::isValid#
     */
    public function testEncryptionProviderException()
    {
        $mockEncryption = $this->createMock(EncryptionProvider::class);
        $mockEncryption->method('isValid')->willReturn(false);

        $this->expectException(\Error::class);
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->setEncryptionProvider($this->mockEncrypt);
        $controller->startAuthorizationGrant(['fake_scope']);
    }

    public function testGetRedirectUri()
    {
        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);

        $url = $controller->getRedirectUri();

        $this->assertNotEmpty($url, 'Url should not be empty');
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testStartAuthorizationGrantMissingScopes()
    {
        $this->expectException(\InvalidArgumentException::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->startAuthorizationGrant([]);
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testStartAuthorizationGrantInvalidScope()
    {
        $this->expectException(\InvalidArgumentException::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->startAuthorizationGrant([new \stdClass()]);
    }

    public function testStartAuthorizationGrant()
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

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testCompleteAuthorizationGrantMissingCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->completeAuthorizationGrant(null, null);
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testCompleteAuthorizationGrantMissingState()
    {
        $this->expectException(\InvalidArgumentException::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->completeAuthorizationGrant('fake_grant_code', null);
    }

    /**
     * Expect exception type \Exception
     * @expectedExceptionMessageRegExp #Invalid state returned from OAuth server.*#
     */
    public function testCompleteAuthorizationGrantStateFailure()
    {
        $this->mockStorage->method('compare')->willReturn(false);
        $this->expectException(\Exception::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $controller->completeAuthorizationGrant('fake_grant_code', 'fake_state');
    }

    /**
     * Expect exception type \Exception
     * @expectedExceptionMessageRegExp #Invalid state returned from OAuth server, colon separator missing.*#
     */
    public function testCompleteAuthorizationGrantWithSwapAuthCodeNoSeparatorFailure()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler, 'http_errors' => false]);

        DI::container()->set(Client::class, $client);

        $this->expectException(\Exception::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);

        $controller->completeAuthorizationGrant('fake_grant_code', 'fake_state_without_colon');
    }

    /**
     * Expect exception type \Exception
     * @expectedExceptionMessageRegExp #Invalid state returned from OAuth server, server state .*#
     */
    public function testCompleteAuthorizationGrantWithSwapAuthCodeBadState()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler, 'http_errors' => false]);

        DI::container()->set(Client::class, $client);

        $mockStorage = $this->createMock(StorageInterface::class);
        $mockStorage->method('compare')->willReturn(false);

        $this->expectException(\Exception::class);

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);

        $controller->completeAuthorizationGrant('fake_grant_code', 'fake:state');
    }

    public function testCompleteAuthorizationGrant()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set(Client::class, $client);

        $this->mockCookie->expects($this->once())->method('set'); //access token

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $accessToken = $controller->completeAuthorizationGrant('fake_grant_code', 'fake:state');

        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'completeAuthorizationGrant response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testCompleteAuthorizationGrantNoRefreshToken()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE_2),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set(Client::class, $client);

        $this->mockCookie->expects($this->once())->method('set'); //access token

        $controller = new AuthCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setStorageProvider($this->mockStorage);
        $accessToken = $controller->completeAuthorizationGrant('fake_grant_code', 'fake:state');

        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'completeAuthorizationGrant response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

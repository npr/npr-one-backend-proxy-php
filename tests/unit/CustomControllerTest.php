<?php

use GuzzleHttp\{Client, HandlerStack};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use NPR\One\Controllers\AbstractOAuth2Controller;
use NPR\One\DI\DI;
use NPR\One\Interfaces\{ConfigInterface, EncryptionInterface};
use NPR\One\Models\AccessTokenModel;
use NPR\One\Providers\{CookieProvider, EncryptionProvider, SecureCookieProvider};

class CustomControllerTest extends TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';
    const ACCESS_TOKEN_RESPONSE_2 = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';

    /** @var CookieProvider */
    private $mockCookie;
    /** @var SecureCookieProvider */
    private $mockSecureCookie;
    /** @var EncryptionProvider */
    private $mockEncryption;
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

        $this->mockConfig = $this->createMock(ConfigInterface::class);
        $this->mockConfig->method('getClientId')->willReturn(self::$clientId);
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

        $controller = new CustomController();
        $controller->issueAccessToken();
    }

    /**
     * Expect exception type\RuntimeException
     * @expectedExceptionMessageRegExp   #SecureStorageProvider must be set. See.*setSecureStorageProvider#
     */
    public function testSecureStorageProviderException()
    {
        $this->expectException(\RuntimeException::class);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->issueAccessToken();
    }

    /**
     * Expect exception type\RuntimeException
     * @expectedExceptionMessageRegExp   #WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#
     */
    public function testSecureStorageProviderWarning()
    {
        $mockCookie = $this->createMock(CookieProvider::class);
        $mockCookie->method('compare')->willReturn(false);

        $this->expectException(\RuntimeException::class);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockCookie);
        $controller->issueAccessToken();
    }

    /**
     * Expect exception type\RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be set. See.*setEncryptionProvider#
     */
    public function testEncryptionProviderException()
    {
        $this->expectException(\RuntimeException::class);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->issueAccessToken();
    }

    /**
     * Expect exception type\RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be valid. See.*EncryptionInterface::isValid#
     */
    public function testEncryptionProviderInvalidException()
    {
        $mockEncryption = $this->createMock(EncryptionProvider::class);
        $mockEncryption->method('isValid')->willReturn(false);

        $this->expectException(\TypeError::class);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($this->mockEncrypt);
        $controller->issueAccessToken();
    }

    /**
     * Expect exception type\InvalidArgumentException
     * @expectedExceptionMessage   Must specify grant type
     */
    public function testBadIssueAccessTokenMissingGrantType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($this->mockEncryption);
        $controller->badIssueAccessToken();
    }

    /**
     * Expect exception type\Exception
     */
    public function testIssueAccessTokenWithApiError()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        DI::container()->set(Client::class, $client);

        $this->expectException(\Exception::class);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->issueAccessToken();
    }

    public function testIssueAccessToken()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        DI::container()->set(Client::class, $client);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($this->mockEncryption);
        $accessToken = $controller->issueAccessToken();

        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'issueAccessToken response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testIssueAccessTokenNoRefreshToken()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE_2),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        DI::container()->set(Client::class, $client);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($this->mockEncryption);
        $accessToken = $controller->issueAccessToken();

        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'issueAccessToken response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

class CustomController extends AbstractOAuth2Controller
{
    public function __construct()
    {
        // intentionally don't call parent constructor
    }

    public function issueAccessToken()
    {
        $this->ensureExternalProvidersExist();

        $accessToken = $this->createAccessToken('fake_grant_type');

        $this->storeRefreshToken($accessToken);

        return $accessToken;
    }

    public function badIssueAccessToken()
    {
        $this->ensureExternalProvidersExist();

        $accessToken = $this->createAccessToken(null);

        $this->storeRefreshToken($accessToken);

        return $accessToken;
    }
}

<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use NPR\One\Controllers\AbstractOAuth2Controller;
use NPR\One\DI\DI;
use NPR\One\Interfaces\ConfigInterface;
use NPR\One\Models\AccessTokenModel;
use NPR\One\Providers\CookieProvider;
use NPR\One\Providers\EncryptionProvider;
use NPR\One\Providers\SecureCookieProvider;


use PHPUnit\Framework\TestCase;

/**
 * @noinspection PhpPossiblePolymorphicInvocationInspection
 * @psalm-suppress InvalidArgument
 * @phpstan-ignore-file
 */
class CustomControllerTests extends TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';
    const ACCESS_TOKEN_RESPONSE_2 = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';

    /** @var SecureCookieProvider|\PHPUnit\Framework\MockObject\MockObject */
    private $mockSecureCookie;
    /** @var EncryptionProvider|\PHPUnit\Framework\MockObject\MockObject */
    private $mockEncryption;
    /** @var ConfigInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $mockConfig;
    /** @var Client */
    private $mockClient;

    /** @var string */
    private static $clientId = 'fake_client_id';


    protected function setUp(): void
    {
        $this->mockSecureCookie = $this->createMock(SecureCookieProvider::class);
        $this->mockEncryption = $this->createMock(EncryptionProvider::class);
        $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockConfig = $this->createMock(ConfigInterface::class);
        $this->mockConfig->method('getClientId')->willReturn(self::$clientId);
        $this->mockConfig->method('getNprAuthorizationServiceHost')->willReturn('https://authorization.api.npr.org');
        $this->mockConfig->method('getCookieDomain')->willReturn('.example.com');
        $this->mockConfig->method('getEncryptionSalt')->willReturn('asYh&%D9ne!j8HKQ');

        $this->mockClient = new Client(['handler' => HandlerStack::create(new MockHandler())]);

        DI::container()->set(SecureCookieProvider::class, $this->mockSecureCookie);
        DI::container()->set(EncryptionProvider::class, $this->mockEncryption);
        DI::container()->set(Client::class, $this->mockClient); // just in case
    }

    public function testConfigProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#ConfigProvider must be set. See.*setConfigProvider#');
        $controller = new CustomController();
        $controller->issueAccessToken();
    }

    public function testSecureStorageProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#SecureStorageProvider must be set. See.*setSecureStorageProvider#');
        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->issueAccessToken();
    }

    public function testSecureStorageProviderWarning(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#');
        $mockCookie = $this->createMock(CookieProvider::class);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($mockCookie);
        $controller->issueAccessToken();
    }

    public function testEncryptionProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#EncryptionProvider must be set. See.*setEncryptionProvider#');
        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->issueAccessToken();
    }

    public function testEncryptionProviderInvalidException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#EncryptionProvider must be valid. See.*EncryptionInterface::isValid#');
        $mockEncryption = $this->createMock(EncryptionProvider::class);
        $mockEncryption->method('isValid')->willReturn(false);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($mockEncryption);
        $controller->issueAccessToken();
    }

    public function testBadIssueAccessTokenMissingGrantType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must specify grant type');
        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($this->mockEncryption);
        $controller->badIssueAccessToken();
    }

    public function testIssueAccessTokenWithApiError(): void
    {
        $this->expectException(\Exception::class);
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        DI::container()->set(Client::class, $client);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->issueAccessToken();
    }

    public function testIssueAccessToken(): void
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

        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'issueAccessToken response was not of type AccessTokenModel: ' . print_r($accessToken, true));
        $this->assertSame(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testIssueAccessTokenNoRefreshToken(): void
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

        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'issueAccessToken response was not of type AccessTokenModel: ' . print_r($accessToken, true));
        $this->assertSame(0, $mock->count(), 'Expected additional HTTP requests to be made');
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

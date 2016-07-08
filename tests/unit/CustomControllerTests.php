<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use NPR\One\Controllers\AbstractOAuth2Controller;
use NPR\One\DI\DI;


class CustomControllerTests extends PHPUnit_Framework_TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';
    const ACCESS_TOKEN_RESPONSE_2 = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';

    /** @var \NPR\One\Providers\SecureCookieProvider */
    private $mockSecureCookie;
    /** @var \NPR\One\Providers\EncryptionProvider */
    private $mockEncryption;
    /** @var \NPR\One\Interfaces\ConfigInterface */
    private $mockConfig;
    /** @var \GuzzleHttp\Client */
    private $mockClient;

    /** @var string */
    private static $clientId = 'fake_client_id';


    public function setUp()
    {
        $this->mockSecureCookie = $this->getMock('NPR\One\Providers\SecureCookieProvider');

        $this->mockEncryption = $this->getMock('NPR\One\Providers\EncryptionProvider');
        $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockEncryption->method('set')->willReturn(true);

        $this->mockConfig = $this->getMock('NPR\One\Interfaces\ConfigInterface');
        $this->mockConfig->method('getClientId')->willReturn(self::$clientId);
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
        $controller = new CustomController();
        $controller->issueAccessToken();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #SecureStorageProvider must be set. See.*setSecureStorageProvider#
     */
    public function testSecureStorageProviderException()
    {
        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->issueAccessToken();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#
     */
    public function testSecureStorageProviderWarning()
    {
        $mockCookie = $this->getMock('NPR\One\Providers\CookieProvider');

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($mockCookie);
        $controller->issueAccessToken();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be set. See.*setEncryptionProvider#
     */
    public function testEncryptionProviderException()
    {
        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->issueAccessToken();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be valid. See.*EncryptionInterface::isValid#
     */
    public function testEncryptionProviderInvalidException()
    {
        $mockEncryption = $this->getMock('NPR\One\Providers\EncryptionProvider');
        $mockEncryption->method('isValid')->willReturn(false);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($mockEncryption);
        $controller->issueAccessToken();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage   Must specify grant type
     */
    public function testBadIssueAccessTokenMissingGrantType()
    {
        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($this->mockEncryption);
        $controller->badIssueAccessToken();
    }

    /**
     * @expectedException \Exception
     */
    public function testIssueAccessTokenWithApiError()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        DI::container()->set('GuzzleHttp\Client', $client);

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
        DI::container()->set('GuzzleHttp\Client', $client);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($this->mockEncryption);
        $accessToken = $controller->issueAccessToken();

        $this->assertInstanceOf('NPR\One\Models\AccessTokenModel', $accessToken, 'issueAccessToken response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testIssueAccessTokenNoRefreshToken()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE_2),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        DI::container()->set('GuzzleHttp\Client', $client);

        $controller = new CustomController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockSecureCookie);
        $controller->setEncryptionProvider($this->mockEncryption);
        $accessToken = $controller->issueAccessToken();

        $this->assertInstanceOf('NPR\One\Models\AccessTokenModel', $accessToken, 'issueAccessToken response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
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

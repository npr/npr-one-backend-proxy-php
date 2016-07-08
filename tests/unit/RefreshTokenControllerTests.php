<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use NPR\One\Controllers\RefreshTokenController;
use NPR\One\DI\DI;


class RefreshTokenControllerTests extends PHPUnit_Framework_TestCase
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
        $controller = new RefreshTokenController();
        $controller->generateNewAccessTokenFromRefreshToken();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#
     */
    public function testSecureStorageProviderException()
    {
        $mockCookie = $this->getMock('NPR\One\Providers\CookieProvider');

        $controller = new RefreshTokenController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($mockCookie);
        $controller->generateNewAccessTokenFromRefreshToken();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be valid. See.*EncryptionInterface::isValid#
     */
    public function testEncryptionProviderException()
    {
        $mockEncryption = $this->getMock('NPR\One\Providers\EncryptionProvider');
        $mockEncryption->method('isValid')->willReturn(false);

        $controller = new RefreshTokenController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setEncryptionProvider($mockEncryption);
        $controller->generateNewAccessTokenFromRefreshToken();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage   Could not locate a refresh token
     */
    public function testGenerateNewAccessTokenFromRefreshTokenMissingRefreshToken()
    {
        $controller = new RefreshTokenController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->generateNewAccessTokenFromRefreshToken();
    }

    /**
     * @expectedException \Exception
     */
    public function testGenerateNewAccessTokenFromRefreshTokenWithApiError()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set('GuzzleHttp\Client', $client);

        $this->mockSecureCookie->method('get')->willReturn('i_am_a_refresh_token');

        $controller = new RefreshTokenController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->generateNewAccessTokenFromRefreshToken();
    }

    public function testGenerateNewAccessTokenFromRefreshToken()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set('GuzzleHttp\Client', $client);

        $this->mockSecureCookie->method('get')->willReturn('i_am_a_refresh_token');

        $controller = new RefreshTokenController();
        $controller->setConfigProvider($this->mockConfig);
        $accessToken = $controller->generateNewAccessTokenFromRefreshToken();

        $this->assertInstanceOf('NPR\One\Models\AccessTokenModel', $accessToken, 'generateNewAccessTokenFromRefreshToken response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testGenerateNewAccessTokenFromRefreshTokenNoNewRefreshToken()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE_2),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set('GuzzleHttp\Client', $client);

        $this->mockSecureCookie->method('get')->willReturn('i_am_a_refresh_token');

        $controller = new RefreshTokenController();
        $controller->setConfigProvider($this->mockConfig);
        $accessToken = $controller->generateNewAccessTokenFromRefreshToken();

        $this->assertInstanceOf('NPR\One\Models\AccessTokenModel', $accessToken, 'generateNewAccessTokenFromRefreshToken response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

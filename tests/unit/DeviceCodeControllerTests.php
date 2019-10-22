<?php

use GuzzleHttp\{Client, HandlerStack};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

use NPR\One\Controllers\DeviceCodeController;
use NPR\One\DI\DI;
use NPR\One\Interfaces\ConfigInterface;
use NPR\One\Models\{AccessTokenModel, DeviceCodeModel};
use NPR\One\Providers\{CookieProvider, EncryptionProvider, SecureCookieProvider};

class DeviceCodeControllerTests extends PHPUnit_Framework_TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';
    const ACCESS_TOKEN_RESPONSE_2 = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';
    const DEVICE_CODE_RESPONSE = '{"device_code":"IevXEi6eNBPemJA7OWCuBzQ3tua9iHyifakecode","user_code":"2OA7PP","verification_uri":"http:\/\/www.npr.org\/device","expires_in":1800,"interval":5}';

    /** @var SecureCookieProvider */
    private $mockSecureCookie;
    /** @var EncryptionProvider */
    private $mockEncryption;
    /** @var ConfigInterface */
    private $mockConfig;
    /** @var Client */
    private $mockClient;

    /** @var string */
    private static $clientId = 'fake_client_id';


    public function setUp()
    {
        $this->mockSecureCookie = $this->getMock(SecureCookieProvider::class);

        $this->mockEncryption = $this->getMock(EncryptionProvider::class);
        $this->mockEncryption->method('isValid')->willReturn(true);
        $this->mockEncryption->method('set')->willReturn(true);

        $this->mockConfig = $this->getMock(ConfigInterface::class);
        $this->mockConfig->method('getClientId')->willReturn(self::$clientId);
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
        $controller = new DeviceCodeController();
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#
     */
    public function testSecureStorageProviderException()
    {
        $mockCookie = $this->getMock(CookieProvider::class);

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($mockCookie);
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be valid. See.*EncryptionInterface::isValid#
     */
    public function testEncryptionProviderException()
    {
        $mockEncryption = $this->getMock(EncryptionProvider::class);
        $mockEncryption->method('isValid')->willReturn(false);

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setEncryptionProvider($mockEncryption);
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    public function testStartDeviceCodeGrant()
    {
        $mock = new MockHandler([
            new Response(200, [], self::DEVICE_CODE_RESPONSE),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set(Client::class, $client);

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $deviceCode = $controller->startDeviceCodeGrant(['fake_scope']);

        $this->assertInstanceOf(DeviceCodeModel::class, $deviceCode, 'startDeviceCodeGrant response was not of type DeviceCodeModel: ' . print_r($deviceCode, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    /**
     * @expectedException \Exception
     */
    public function testStartDeviceCodeGrantWithApiException()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set(Client::class, $client);

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage   Could not locate a device code
     */
    public function testPollDeviceCodeGrantMissingDeviceCode()
    {
        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->pollDeviceCodeGrant();
    }

    public function testPollDeviceCodeGrant()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set(Client::class, $client);

        $this->mockSecureCookie->method('get')->willReturn('i_am_a_device_code');

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $accessToken = $controller->pollDeviceCodeGrant();

        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'pollDeviceCodeGrant response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testPollDeviceCodeGrantNoRefreshToken()
    {
        $mock = new MockHandler([
            new Response(200, [], self::ACCESS_TOKEN_RESPONSE_2),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set(Client::class, $client);

        $this->mockSecureCookie->method('get')->willReturn('i_am_a_device_code');

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $accessToken = $controller->pollDeviceCodeGrant();

        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'pollDeviceCodeGrant response was not of type AccessTokenModel: ' . print_r($accessToken, 1));
        $this->assertEquals(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

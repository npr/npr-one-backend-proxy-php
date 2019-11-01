<?php

use GuzzleHttp\{Client, HandlerStack};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use NPR\One\Controllers\DeviceCodeController;
use NPR\One\DI\DI;
use NPR\One\Interfaces\{ConfigInterface, EncryptionInterface};
use NPR\One\Models\{AccessTokenModel, DeviceCodeModel};
use NPR\One\Providers\{CookieProvider, EncryptionProvider, SecureCookieProvider};

class DeviceCodeControllerTest extends TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';
    const ACCESS_TOKEN_RESPONSE_2 = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';
    const DEVICE_CODE_RESPONSE = '{"device_code":"IevXEi6eNBPemJA7OWCuBzQ3tua9iHyifakecode","user_code":"2OA7PP","verification_uri":"http:\/\/www.npr.org\/device","expires_in":1800,"interval":5}';

    /** @var CookieProvider */
    private $mockCookie;
    /** @var SecureCookieProvider */
    private $mockSecureCookie;
    /** @var EncryptionProvider */
    private $mockEncryption;
    /** @var ConfigInterface */
    private $mockConfig;
    /** @var EncryptionInterface */
    private $mockEncrypt;
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

        $this->mockEncrypt = $this->createMock(EncryptionInterface::class);
        $this->mockEncrypt->method('isValid')->willReturn(false);

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
     * Expect exception type \RuntimeException
     * Expect exception message regular expression  #ConfigProvider must be set. See.*setConfigProvider#
     */
    public function testConfigProviderException()
    {
        $this->expectException(\RuntimeException::class);
        $controller = new DeviceCodeController();
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    /**
     * Expect exception type \RuntimeException
     * @expectedExceptionMessageRegExp   #WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#
     */
    public function testSecureStorageProviderException()
    {
        $mockCookie = $this->createMock(CookieProvider::class);
        $mockCookie->method('compare')->willReturn(false);


        $this->expectException(\RuntimeException::class);

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($this->mockCookie);
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    /**
     * Expect exception type \RuntimeException
     * @expectedExceptionMessageRegExp   #EncryptionProvider must be valid. See.*EncryptionInterface::isValid#
     */
    public function testEncryptionProviderException()
    {
        $mockEncryption = $this->createMock(EncryptionProvider::class);
        $mockEncryption->method('isValid')->willReturn(false);

        $this->expectException(\Error::class); //fix later

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setEncryptionProvider($this->mockEncrypt);
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
     * Expect exception type \Exception
     */
    public function testStartDeviceCodeGrantWithApiException()
    {
        $mock = new MockHandler([
            new Response(500, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        DI::container()->set(Client::class, $client);
        $this->expectException(\Exception::class);

        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    /**
     * Expect exception type \Exception
     * @expectedExceptionMessage   Could not locate a device code
     */
    public function testPollDeviceCodeGrantMissingDeviceCode()
    {
        $this->expectException(\Exception::class);

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

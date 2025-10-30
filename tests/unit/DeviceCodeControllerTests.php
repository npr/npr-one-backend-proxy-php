<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use NPR\One\Controllers\DeviceCodeController;
use NPR\One\DI\DI;
use NPR\One\Interfaces\ConfigInterface;
use NPR\One\Models\AccessTokenModel;
use NPR\One\Models\DeviceCodeModel;
use NPR\One\Providers\CookieProvider;
use NPR\One\Providers\EncryptionProvider;
use NPR\One\Providers\SecureCookieProvider;


use PHPUnit\Framework\TestCase;

/**
 * @noinspection PhpPossiblePolymorphicInvocationInspection
 * @psalm-suppress InvalidArgument
 * @phpstan-ignore-file
 */
class DeviceCodeControllerTests extends TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';
    const ACCESS_TOKEN_RESPONSE_2 = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';
    const DEVICE_CODE_RESPONSE = '{"device_code":"IevXEi6eNBPemJA7OWCuBzQ3tua9iHyifakecode","user_code":"2OA7PP","verification_uri":"http:\/\/www.npr.org\/device","expires_in":1800,"interval":5}';

    /** @var SecureCookieProvider|\PHPUnit\Framework\MockObject\MockObject */
    private $mockSecureCookie;
    /** @var EncryptionProvider|\PHPUnit\Framework\MockObject\MockObject */
    private $mockEncryption;
    /** @var ConfigInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $mockConfig;
    /** @var Client */
    private $mockClient;

    private static string $clientId = 'fake_client_id';

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
        DI::container()->set(Client::class, $this->mockClient);
    }

    public function testConfigProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#ConfigProvider must be set. See.*setConfigProvider#');
        $controller = new DeviceCodeController();
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    public function testSecureStorageProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#WARNING: It is strongly discouraged to use CookieProvider as your secure storage provider.#');
        $mockCookie = $this->createMock(CookieProvider::class);
        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setSecureStorageProvider($mockCookie);
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    public function testEncryptionProviderException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('#EncryptionProvider must be valid. See.*EncryptionInterface::isValid#');
        $mockEncryption = $this->createMock(EncryptionProvider::class);
        $mockEncryption->method('isValid')->willReturn(false);
        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->setEncryptionProvider($mockEncryption);
        $controller->startDeviceCodeGrant(['fake_scope']);
    }

    public function testStartDeviceCodeGrant(): void
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
        $this->assertInstanceOf(DeviceCodeModel::class, $deviceCode, 'startDeviceCodeGrant response was not of type DeviceCodeModel: ' . print_r($deviceCode, true));
        $this->assertSame(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testStartDeviceCodeGrantWithApiException(): void
    {
        $this->expectException(\Exception::class);
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

    public function testPollDeviceCodeGrantMissingDeviceCode(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Could not locate a device code');
        $controller = new DeviceCodeController();
        $controller->setConfigProvider($this->mockConfig);
        $controller->pollDeviceCodeGrant();
    }

    public function testPollDeviceCodeGrant(): void
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
        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'pollDeviceCodeGrant response was not of type AccessTokenModel: ' . print_r($accessToken, true));
        $this->assertSame(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }

    public function testPollDeviceCodeGrantNoRefreshToken(): void
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
        $this->assertInstanceOf(AccessTokenModel::class, $accessToken, 'pollDeviceCodeGrant response was not of type AccessTokenModel: ' . print_r($accessToken, true));
        $this->assertSame(0, $mock->count(), 'Expected additional HTTP requests to be made');
    }
}

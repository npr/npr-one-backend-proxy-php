<?php

use NPR\One\Models\DeviceCodeModel;
use PHPUnit\Framework\TestCase;

class DeviceCodeModelTests extends TestCase
{
    const DEVICE_CODE_RESPONSE = '{"device_code":"IevXEi6eNBPemJA7OWCuBzQ3tua9iHyifakecode","user_code":"2OA7PP","verification_uri":"http:\/\/www.npr.org\/device","expires_in":1800,"interval":5}';


    public function testJsonModelCreationFail(): void
    {
        $this->expectException(\Exception::class);
        new DeviceCodeModel('I am not JSON');
    }

    public function testModelCreationFail(): void
    {
        $this->expectException(\Exception::class);
        new DeviceCodeModel('{"device_code":"blah"}');
    }

    public function testCorrectlyPopulatedModel(): void
    {
        $json = json_decode(self::DEVICE_CODE_RESPONSE);
        $model = new DeviceCodeModel(self::DEVICE_CODE_RESPONSE);

        $this->assertSame($json->device_code, $model->getDeviceCode(), 'Code does not match.');
        $this->assertSame($json->user_code, $model->getUserCode(), 'User code does not match.');
        $this->assertSame($json->verification_uri, $model->getVerificationUri(), 'Verification URI does not match.');
        $this->assertSame($json->expires_in, $model->getExpiresIn(), 'TTL does not match.');
        $this->assertSame($json->interval, $model->getInterval(), 'Interval does not match.');
    }

    public function testCorrectlyPopulatedModelToString(): void
    {
        $model = new DeviceCodeModel(self::DEVICE_CODE_RESPONSE);
        $json = (string) $model;

        $this->assertStringNotContainsString($model->getDeviceCode(), $json, 'Stringified device code model should not contain device code.');
        $this->assertStringContainsString($model->getUserCode(), $json, 'Stringified device code model should contain user code.');
        $this->assertStringContainsString(json_encode($model->getVerificationUri()), $json, 'Stringified device code model should contain verification URI.');
        $this->assertStringContainsString((string) $model->getExpiresIn(), $json, 'Stringified device code model should contain code TTL.');
        $this->assertStringContainsString((string) $model->getInterval(), $json, 'Stringified device code model should contain interval.');
    }
}

<?php

use PHPUnit\Framework\TestCase;

use NPR\One\Models\AccessTokenModel;

class AccessTokenModelTests extends TestCase
{
    const ACCESS_TOKEN_RESPONSE = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786,"refresh_token": "6KVn9BOhHhUFR1Yqi2T2pzpTWI9WIfakerefresh"}';


    /**
     * @expectedException \Exception
     */
    public function testJsonModelCreationFail()
    {
        new AccessTokenModel('I am not JSON');
    }

    /**
     * @expectedException \Exception
     */
    public function testModelCreationFail()
    {
        new AccessTokenModel('{"access_token":"faketoken"}');
    }

    public function testCorrectlyPopulatedModel()
    {
        $json = json_decode(self::ACCESS_TOKEN_RESPONSE);
        $model = new AccessTokenModel(self::ACCESS_TOKEN_RESPONSE);

        $this->assertEquals($json->access_token, $model->getAccessToken(), 'Token does not match.');
        $this->assertEquals($json->token_type, $model->getTokenType(), 'Token type does not match.');
        $this->assertEquals($json->expires_in, $model->getExpiresIn(), 'TTL does not match.');
        $this->assertEquals($json->refresh_token, $model->getRefreshToken(), 'Refresh token does not match.');
    }

    public function testCorrectlyPopulatedModelWithoutRefreshToken()
    {
        $tokenStr = '{"access_token": "LT8gvVDyeKwQJVVf6xwKAWdK0bOik64faketoken","token_type": "Bearer","expires_in": 690448786}';

        $json = json_decode($tokenStr);
        $model = new AccessTokenModel($tokenStr);

        $this->assertEquals($json->access_token, $model->getAccessToken(), 'Token does not match.');
        $this->assertEquals($json->token_type, $model->getTokenType(), 'Token type does not match.');
        $this->assertEquals($json->expires_in, $model->getExpiresIn(), 'TTL does not match.');
        $this->assertObjectNotHasAttribute('refresh_token', $json, 'Refresh token should not be set.');
    }

    public function testCorrectlyPopulatedModelToString()
    {
        $model = new AccessTokenModel(self::ACCESS_TOKEN_RESPONSE);
        $json = (string) $model;

        $this->assertContains($model->getAccessToken(), $json, 'Stringified access token model should contain access token.');
        $this->assertContains($model->getTokenType(), $json, 'Stringified access token model should contain token type.');
        $this->assertContains((string) $model->getExpiresIn(), $json, 'Stringified access token model should contain token TTL.');
        $this->assertNotContains($model->getRefreshToken(), $json, 'Stringified access token model should not contain refresh token.');
    }
}

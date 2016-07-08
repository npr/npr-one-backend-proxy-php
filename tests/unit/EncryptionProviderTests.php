<?php

use NPR\One\Providers\EncryptionProvider;


class EncryptionProviderTests extends PHPUnit_Framework_TestCase
{
    private static $salt = 'I am a test salt';
    private static $salt2 = 'J=j<4\bL6Y_T!{="EeU@!Z5eEqe64Qv$<.9:eD/JHzv=puhj$`FNr5DBN"Ej';


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSaltWithEmptyArgument()
    {
        $provider = new EncryptionProvider();
        $provider->setSalt(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSaltWithArgumentOfWrongType()
    {
        $provider = new EncryptionProvider();
        $provider->setSalt(new \stdClass());
    }

    public function testIsValidNoSalt()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }

        $provider = new EncryptionProvider();

        $result = $provider->isValid();

        $this->assertFalse($result, 'EncryptionProvider should not be considered valid if no salt has been provided');
    }

    public function testIsValidWithSalt()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }

        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $result = $provider->isValid();

        $this->assertTrue($result, 'EncryptionProvider should be considered valid since a salt has been provided');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEncryptWithEmptyArgument()
    {
        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $provider->encrypt(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEncryptWithArgumentOfWrongType()
    {
        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $provider->encrypt(new \stdClass());
    }

    public function testEncrypt()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }

        $originalText = 'I am a string to be encrypted! Hello, hi.';

        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $encryptedText = $provider->encrypt($originalText);

        $this->assertInternalType('string', $encryptedText, 'The encrypted value should be a string');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDecryptWithEmptyArgument()
    {
        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $provider->decrypt(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDecryptWithArgumentOfWrongType()
    {
        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $provider->decrypt(new \stdClass());
    }

    public function testEncryptAndDecrypt()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }

        $originalText = 'I am a string to be encrypted! Hello, hi.';

        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $encryptedText = $provider->encrypt($originalText);
        $decryptedText = $provider->decrypt($encryptedText);

        $this->assertEquals($originalText, $decryptedText, 'Decrypted text should match original text');
    }

    public function testEncryptAndDecryptAgain()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }

        $originalText = 'd95yk2By.%k=CE=HSd_g("tZ!5Rn`Y<y5M64bn@\'@$y5s5`EDr{_Q(=44@-&';

        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $encryptedText = $provider->encrypt($originalText);
        $decryptedText = $provider->decrypt($encryptedText);

        $this->assertEquals($originalText, $decryptedText, 'Decrypted text should match original text');
    }

    public function testEncryptAndDecryptWithAnotherSalt()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }

        $originalText = 'I am a string to be encrypted! Hello, hi.';

        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt2);

        $encryptedText = $provider->encrypt($originalText);
        $decryptedText = $provider->decrypt($encryptedText);

        $this->assertEquals($originalText, $decryptedText, 'Decrypted text should match original text');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetCipherMethodWithEmptyArgument()
    {
        $provider = new EncryptionProvider();
        $provider->setCipherMethod(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetCipherMethodWithArgumentOfWrongType()
    {
        $provider = new EncryptionProvider();
        $provider->setCipherMethod(new \stdClass());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetCipherMethodWithInvalidCipher()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }

        $provider = new EncryptionProvider();
        $provider->setCipherMethod('I-am-not-a-real-cipher');
    }

    public function testSetCipherMethod()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }

        $provider = new EncryptionProvider();
        $provider->setCipherMethod('aes-128-cbc');
    }
}

<?php

use PHPUnit\Framework\TestCase;

use NPR\One\Providers\EncryptionProvider;
class EncryptionProviderTest extends TestCase
{
    private static $salt = 'I am a test salt';
    private static $salt2 = 'J=j<4\bL6Y_T!{="EeU@!Z5eEqe64Qv$<.9:eD/JHzv=puhj$`FNr5DBN"Ej';


    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testSetSaltWithEmptyArgument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $provider = new EncryptionProvider();
        $provider->setSalt(null);
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testSetSaltWithArgumentOfWrongType()
    {
        $this->expectException(\InvalidArgumentException::class);
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
     * Expect exception type \InvalidArgumentException
     */
    public function testEncryptWithEmptyArgument()
    {
        $this->expectException(\InvalidArgumentException::class);
        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $provider->encrypt(null);
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testEncryptWithArgumentOfWrongType()
    {
        $this->expectException(\InvalidArgumentException::class);
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

        $this->assertIsString('string', $encryptedText, 'The encrypted value should be a string');
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testDecryptWithEmptyArgument()
    {
        $this->expectException(\InvalidArgumentException::class);

        $provider = new EncryptionProvider();
        $provider->setSalt(self::$salt);

        $provider->decrypt(null);
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testDecryptWithArgumentOfWrongType()
    {
        $this->expectException(\InvalidArgumentException::class);

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
     * Expect exception type \InvalidArgumentException
     */
    public function testSetCipherMethodWithEmptyArgument()
    {
        $this->expectException(\InvalidArgumentException::class);

        $provider = new EncryptionProvider();
        $provider->setCipherMethod(null);
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testSetCipherMethodWithArgumentOfWrongType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $provider = new EncryptionProvider();
        $provider->setCipherMethod(new \stdClass());
    }

    /**
     * Expect exception type \InvalidArgumentException
     */
    public function testSetCipherMethodWithInvalidCipher()
    {
        if (!extension_loaded('openssl'))
        {
            $this->markTestSkipped('openssl is not loaded, so this test cannot be run');
        }
        $this->expectException(\InvalidArgumentException::class);

        $provider = new EncryptionProvider();
        $provider->setCipherMethod('I-am-not-a-real-cipher');
    }
    /**
     * @doesNotPerformAssertions
     */
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

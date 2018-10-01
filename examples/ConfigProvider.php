<?php

namespace Your\Package\Here;

use NPR\One\Interfaces\ConfigInterface;
use Your\Package\Config\SuperSecretConfig;


class ConfigProvider implements ConfigInterface
{
    /**
     * @inheritdoc
     */
    public function getClientId()
    {
        return 'my_client_id';
    }

    /**
     * @inheritdoc
     */
    public function getClientSecret()
    {
        return SuperSecretConfig::$nprOneClientSecret;
    }

    /**
     * @inheritdoc
     */
    public function getClientCredentialsToken()
    {
        return SuperSecretConfig::$nprOneClientCredentialsToken;
    }

    /**
     * @inheritdoc
     */
    public function getNprAuthorizationServiceHost()
    {
        return 'https://authorization.api.npr.org';
    }

    /**
     * @inheritdoc
     */
    public function getClientUrl()
    {
        return 'https://nprone.example.com';
    }

    /**
     * @inheritdoc
     */
    public function getAuthCodeCallbackUrl()
    {
        return 'https://nprone.example.com/oauth2/callback';
    }

    /**
     * @inheritdoc
     */
    public function getCookieDomain()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getCookiePrefix()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function getEncryptionSalt()
    {
        return SuperSecretConfig::$nprOneEncryptionSalt;
    }
}

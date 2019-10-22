<?php

namespace NPR\One\Models;


/**
 * A thin wrapper around a device code/user code pair, based on the raw JSON returned from the `POST /device` endpoint.
 *
 * @package NPR\One\Models
 */
class DeviceCodeModel extends JsonModel
{
    /** @var string - 40 character alphanumeric code for the proxy to use
      * @internal */
    private $deviceCode;
    /** @var string - 8-character alphanumeric code for the user to enter
      * @internal */
    private $userCode;
    /** @var string - the external URL at which the user should log in
      * @internal */
    private $verificationUri;
    /** @var int - number of seconds from now when this code has expired
      * @internal */
    private $expiresIn;
    /** @var int - the interval (in seconds) at which to poll at
      * @internal */
    private $interval;


    /**
     * DeviceCodeModel constructor.
     *
     * @param $json
     * @throws \Exception
     */
    public function __construct($json)
    {
        parent::__construct($json);
        $object = $this->originalJsonObject;
        if (!isset($object->device_code) ||
            !isset($object->user_code) ||
            !isset($object->verification_uri) ||
            !isset($object->expires_in) ||
            !isset($object->interval))
        {
            throw new \Exception("DeviceCodeModel could not be created. Invalid device code string received: $json");
        }

        $this->deviceCode = $object->device_code;
        $this->userCode = $object->user_code;
        $this->verificationUri = $object->verification_uri;
        $this->expiresIn = $object->expires_in;
        $this->interval = $object->interval;

        unset($this->originalJsonObject->device_code); // keep this secret
    }

    /**
     * Returns the device code -- the 40-character alphanumeric code for the proxy to use. This code should never
     * be shown to the user, and it is generally preferable to keep this code within the proxy, rather than return it
     * to the client, where it could be compromised.
     *
     * @return string
     */
    public function getDeviceCode(): string
    {
        return $this->deviceCode;
    }

    /**
     * Returns the user code -- the 8-character alphanumeric code that the user is asked to enter at https://npr.org/device
     * before logging in. This code can safely be returned to the client and displayed on the device's screen.
     *
     * @return string
     */
    public function getUserCode(): string
    {
        return $this->userCode;
    }

    /**
     * Returns the URL at which the user should log in. It is usually displayed on the screen together with the user code.
     *
     * @return string
     */
    public function getVerificationUri(): string
    {
        return $this->verificationUri;
    }

    /**
     * Returns the remaining lifetime of the device code/user code pair, in seconds. Once the codes expire, the client
     * is responsible for starting a new device code flow, which will result in a new keypair being generated.
     *
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * Returns the interval at which the client is advised to poll the authorization server (and, by extension, this proxy)
     * to see if the user has logged in yet. Polling more frequently than that may result in a rate limit kicking in.
     *
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }
}

<?php

namespace NPR\One\Models;


/**
 * A thin wrapper around an access token, based on the raw JSON returned from the `POST /token` endpoint.
 *
 * @package NPR\One\Models
 */
class AccessTokenModel extends JsonModel
{
    /** @var string - 40 character alphanumeric token
      * @internal */
    private $accessToken;
    /** @var string
      * @internal */
    private $tokenType;
    /** @var int - number of seconds from now when this token has expired
      * @internal */
    private $expiresIn;
    /** @var null|string - 40 character alphanumeric token
      * @internal */
    private $refreshToken = null;


    /**
     * AccessTokenModel constructor.
     *
     * @param $json
     * @throws \Exception
     */
    public function __construct($json)
    {
        parent::__construct($json);
        $object = $this->originalJsonObject;
        if (!isset($object->access_token) ||
            !isset($object->token_type) ||
            !isset($object->expires_in))
        {
            throw new \Exception("AccessTokenModel could not be created. Invalid access token string received: $json");
        }

        $this->accessToken = $object->access_token;
        $this->tokenType = $object->token_type;
        $this->expiresIn = $object->expires_in;
        $this->refreshToken = isset($object->refresh_token) ? $object->refresh_token : null;

        unset($this->originalJsonObject->refresh_token); // keep this secret
    }

    /**
     * Returns the access token itself -- a 40-character, alphanumeric string.
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Returns the type of token, usually assumed to be `Bearer`.
     *
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * Returns the remaining seconds in the lifetime of the access token.
     *
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * Returns the refresh token associated with this access token, if it exists.
     *
     * @return null|string
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }
}

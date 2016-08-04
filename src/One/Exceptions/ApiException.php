<?php

namespace NPR\One\Exceptions;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;


/**
 * An extension of CookieProvider that encrypts cookies before setting them and decrypts them when retrieving them
 *
 * @package NPR\One\Exceptions
 * @codeCoverageIgnore
 */
class ApiException extends \Exception
{
    /**
     * @var int
     * @internal
     */
    private $statusCode;
    /**
     * @var string
     * @internal
     */
    private $statusText;
    /**
     * @var Stream
     * @internal
     */
    private $body;


    /**
     * Constructs the exception using the response from the API call.
     *
     * @param string $message
     * @param Response $response
     */
    public function __construct($message, Response $response)
    {
        parent::__construct($message . " - status: {$response->getStatusCode()}, body: {$response->getBody()}");

        $this->statusCode = $response->getStatusCode();
        $this->statusText = $response->getReasonPhrase();
        $this->body = $response->getBody();
    }

    /**
     * Returns the HTTP status code from the failed API call; should generally always be 400 or greater.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Returns the HTTP status text (a.k.a. reason phrase) from the failed API call.
     *
     * @return string
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * Returns the body of the response from the failed API call. May be empty.
     *
     * @return Stream
     */
    public function getBody()
    {
        return $this->body;
    }
}

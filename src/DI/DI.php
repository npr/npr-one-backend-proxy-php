<?php

namespace NPR\One\DI;

use DI\ContainerBuilder;
use GuzzleHttp\Client;
use NPR\One\Providers\{CookieProvider, SecureCookieProvider, EncryptionProvider};


/**
 * Sets up a dependency injection container for the project, to enable better isolation in unit tests
 *
 * @package NPR\One\DI
 */
class DI
{
    /** @var \DI\Container
      * @internal */
    private static $container;

    /**
     * Returns a dependency injection container for the project, creating one if it does not already exist.
     *
     * @return \DI\Container
     */
    public static function container()
    {
        if (!empty(self::$container))
        {
            return self::$container;
        }

        $containerBuilder = new ContainerBuilder;
        $containerBuilder->addDefinitions([
            CookieProvider::class       => \DI\object(CookieProvider::class),
            SecureCookieProvider::class => \DI\object(SecureCookieProvider::class),
            EncryptionProvider::class   => \DI\object(EncryptionProvider::class),
            // Bind an interface to an implementation
            Client::class               => \DI\object(Client::class)->constructor([
                'timeout'     => 5.0,
                'http_errors' => false
            ]),
        ]);
        self::$container = $containerBuilder->build();

        return self::$container;
    }
}

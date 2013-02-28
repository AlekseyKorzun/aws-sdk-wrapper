<?php
namespace classes;

use \library\Configuration;

/**
 * Wrapper for Amazon Web Services library
 *
 * @author Aleksey Korzun <al.ko@webfoundation.net>
 */
class Amazon {
    /**
     * Stores instance of Amazon service builder
     *
     * @var \Guzzle\Service\Builder\ServiceBuilder
     */
    protected static $instance;

    /**
     * Class constructor, if no credentials are passed we will attempt to load
     * data from our configuration file.
     *
     * @param string $key optional key
     * @param string $secret optional secret hash
     */
    public function __construct($key = null, $secret = null) {
        // Amazon Phar library is required at this point
        require('amazon/library.phar');

        // If no key was passed, attempt to load data from our configuration file
        if (is_null($key)) {
            $configuration = Configuration::get('amazon');
        } else {
            $configuration = array(
                'key' => (string) $key,
                'secret' => (string) $secret
            );
        }

        // Always set region if it's missing
        if (!isset($configuration['region'])) {
            $configuration['region'] = \Aws\Common\Enum\Region::US_EAST_1;
        }

        self::$instance = \Aws\Common\Aws::factory($configuration);
    }

    /**
     * Pass all method calls directly to instance of Amazon service builder
     *
     * @param string $name method that was invoked
     * @param mixed[] $arguments arguments that were passed to invoked method
     *
     * @return mixed
     */
    public function __call($name, $arguments) {
        return self::$instance->$name(array_shift($arguments));
    }
}

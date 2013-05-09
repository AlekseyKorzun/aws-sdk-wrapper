<?php
namespace Library;

use \Aws\Common\Aws;
use \Aws\Common\Enum\Region;
use \Guzzle\Service\Builder\ServiceBuilder;

/**
 * Wrapper for Amazon Web Services library
 *
 * @author Aleksey Korzun <al.ko@webfoundation.net>
 */
class Amazon
{
    /**
     * Stores instance of Amazon service builder
     *
     * @var ServiceBuilder
     */
    protected static $instance;

    /**
     * Class constructor
     *
     * @param string $key access key
     * @param string $secret secret key
     * @param string $region optional service region
     */
    public function __construct($key, $secret, $region = null)
    {
        // Amazon Phar library is required at this point
        require('amazon/library.phar');

        // Construct configuration array
        $configuration = array(
            'key' => (string)$key,
            'secret' => (string)$secret,
            'region' => (string)$region
        );

        // Set region if it's missing
        if (!isset($region)) {
            $configuration['region'] = Region::US_EAST_1;
        }

        self::$instance = Aws::factory($configuration);
    }

    /**
     * Pass all method calls directly to instance of Amazon service builder
     *
     * @param string $name method that was invoked
     * @param mixed[] $arguments arguments that were passed to invoked method
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array(
            array(
                self::$instance,
                $name
            ),
            $arguments
        );
    }
}

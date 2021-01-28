<?php

namespace Royalcms\Component\Redis;

use Royalcms\Component\Support\Arr;

class RedisServiceProvider extends \Illuminate\Redis\RedisServiceProvider
{
    /**
     * The application instance.
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new service provider instance.
     * @param \Royalcms\Component\Contracts\Foundation\Royalcms|\Illuminate\Contracts\Foundation\Application $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);

        $this->royalcms = $royalcms;
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->loadAlias();

        parent::register();
    }

    /**
     * Load the alias = One less install step for the user
     */
    protected function loadAlias()
    {
        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();

        foreach (self::aliases() as $class => $alias) {
            $loader->alias($class, $alias);
        }
    }

    /**
     * Load the alias = One less install step for the user
     */
    public static function aliases()
    {

        return [
            'Royalcms\Component\Redis\Connections\Connection'                => 'Illuminate\Redis\Connections\Connection',
            'Royalcms\Component\Redis\Connections\PhpRedisClusterConnection' => 'Illuminate\Redis\Connections\PhpRedisClusterConnection',
            'Royalcms\Component\Redis\Connections\PhpRedisConnection'        => 'Illuminate\Redis\Connections\PhpRedisConnection',
            'Royalcms\Component\Redis\Connections\PredisClusterConnection'   => 'Illuminate\Redis\Connections\PredisClusterConnection',
            'Royalcms\Component\Redis\Connections\PredisConnection'          => 'Illuminate\Redis\Connections\PredisConnection',
            'Royalcms\Component\Redis\Connectors\PhpRedisConnector'          => 'Illuminate\Redis\Connectors\PhpRedisConnector',
            'Royalcms\Component\Redis\Connectors\PredisConnector'            => 'Illuminate\Redis\Connectors\PredisConnector',
            'Royalcms\Component\Redis\RedisManager'                          => 'Illuminate\Redis\RedisManager',
        ];
    }

    /**
     * Get a list of files that should be compiled for the package.
     * @return array
     */
    public static function compiles()
    {
        $basePath = royalcms('path.base');
        $dir      = __DIR__;

        return [
            $basePath . "/vendor/predis/predis/src/Command/CommandInterface.php",
            $basePath . "/vendor/predis/predis/src/Command/Command.php",
            $basePath . "/vendor/predis/predis/src/Command/StringGet.php",
            $basePath . "/vendor/predis/predis/src/Command/RawCommand.php",
            $basePath . "/vendor/predis/predis/src/Configuration/ProfileOption.php",
            $basePath . "/vendor/predis/predis/src/Response/Status.php",

            $basePath . "/vendor/predis/predis/src/Profile/ProfileInterface.php",
            $basePath . "/vendor/predis/predis/src/Profile/RedisProfile.php",
            $basePath . "/vendor/predis/predis/src/Profile/RedisVersion300.php",
            $basePath . "/vendor/predis/predis/src/Profile/Factory.php",

            $basePath . "/vendor/predis/predis/src/Connection/FactoryInterface.php",
            $basePath . "/vendor/predis/predis/src/Connection/Factory.php",
            $basePath . "/vendor/predis/predis/src/Connection/ParametersInterface.php",
            $basePath . "/vendor/predis/predis/src/Connection/NodeConnectionInterface.php",
            $basePath . "/vendor/predis/predis/src/Connection/ConnectionInterface.php",
            $basePath . "/vendor/predis/predis/src/Connection/AbstractConnection.php",
            $basePath . "/vendor/predis/predis/src/Connection/Parameters.php",
            $basePath . "/vendor/predis/predis/src/Connection/StreamConnection.php",

            $basePath . "/vendor/predis/predis/src/Response/ResponseInterface.php",
            $basePath . "/vendor/predis/predis/src/Configuration/OptionsInterface.php",
            $basePath . "/vendor/predis/predis/src/Configuration/OptionInterface.php",
            $basePath . "/vendor/predis/predis/src/ClientInterface.php",

            $basePath . "/vendor/predis/predis/src/Client.php",
            $basePath . "/vendor/predis/predis/src/Configuration/ConnectionFactoryOption.php",
            $basePath . "/vendor/predis/predis/src/Configuration/Options.php",

            $dir . '/Connections/Connection.php',
            $dir . '/Connections/PredisConnection.php',
            $dir . '/Connectors/PredisConnector.php',
            $dir . '/Contracts/Factory.php',
            $dir . '/RedisManager.php',

        ];
    }
}

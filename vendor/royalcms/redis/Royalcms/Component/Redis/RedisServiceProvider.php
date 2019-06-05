<?php

namespace Royalcms\Component\Redis;

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Support\ServiceProvider;

class RedisServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('redis', function ($royalcms) {
            $config = $royalcms->make('config')->get('database.redis');

            return new RedisManager(Arr::pull($config, 'client', 'predis'), $config);
        });

        $this->royalcms->bind('redis.connection', function ($royalcms) {
            return $royalcms['redis']->connection();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['redis', 'redis.connection'];
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $basePath = royalcms('path.base');
        $dir = static::guessPackageClassPath('royalcms/redis');

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

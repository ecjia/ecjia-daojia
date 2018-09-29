<?php

namespace Royalcms\Component\DumpServer;

use Royalcms\Component\Support\ServiceProvider;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Server\Connection;
use Symfony\Component\VarDumper\Server\DumpServer;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;

class DumpServerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->royalcms->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('debug-server.php'),
            ], 'config');

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../../config/config.php', 'debug-server');

        $this->royalcms->bind('command.dumpserver', DumpServerCommand::class);

        $this->commands([
            'command.dumpserver',
        ]);

        $host = config('debug-server.host');

        //$this->royalcms->when(DumpServer::class)->needs('$host')->give($host);
        $this->royalcms->bind(DumpServer::class, function() use ($host) {
            return new DumpServer($host, royalcms('log'));
        });

        $connection = new Connection($host, [
            'request' => new RequestContextProvider($this->royalcms['request']),
            'source' => new SourceContextProvider('utf-8', base_path())
        ]);

        VarDumper::setHandler(function($var) use ($connection) {
            (new Dumper($connection))->dump($var);
        });
    }
}

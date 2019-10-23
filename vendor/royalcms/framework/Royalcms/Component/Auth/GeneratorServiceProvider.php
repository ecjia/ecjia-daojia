<?php

namespace Royalcms\Component\Auth;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Auth\Console\ClearResetsCommand;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'ClearResets',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->commands as $command) {
            $this->{"register{$command}Command"}();
        }

        $this->commands(
            'command.auth.resets.clear'
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerClearResetsCommand()
    {
        $this->royalcms->singleton('command.auth.resets.clear', function () {
            return new ClearResetsCommand;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.auth.resets.clear',
        ];
    }
}

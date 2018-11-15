<?php

namespace Royalcms\Component\Routing;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Routing\Console\MiddlewareMakeCommand;
use Royalcms\Component\Routing\Console\ControllerMakeCommand;

class GeneratorServiceProvider extends ServiceProvider
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
        $this->registerControllerGenerator();

        $this->registerMiddlewareGenerator();

        $this->commands('command.controller.make', 'command.middleware.make');
    }

    /**
     * Register the controller generator command.
     *
     * @return void
     */
    protected function registerControllerGenerator()
    {
        $this->royalcms->singleton('command.controller.make', function ($royalcms) {
            return new ControllerMakeCommand($royalcms['files']);
        });
    }

    /**
     * Register the middleware generator command.
     *
     * @return void
     */
    protected function registerMiddlewareGenerator()
    {
        $this->royalcms->singleton('command.middleware.make', function ($royalcms) {
            return new MiddlewareMakeCommand($royalcms['files']);
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
            'command.controller.make', 'command.middleware.make',
        ];
    }
}

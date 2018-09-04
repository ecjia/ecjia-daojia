<?php

namespace Royalcms\Component\Session;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Session\Console\SessionTableCommand;

class CommandsServiceProvider extends ServiceProvider
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
        $this->royalcms->singleton('command.session.database', function ($royalcms) {
            return new SessionTableCommand($royalcms['files'], $royalcms['composer']);
        });

        $this->commands('command.session.database');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.session.database'];
    }
}

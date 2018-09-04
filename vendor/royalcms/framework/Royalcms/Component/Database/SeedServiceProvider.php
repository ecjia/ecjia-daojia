<?php

namespace Royalcms\Component\Database;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Database\Console\Seeds\SeedCommand;
use Royalcms\Component\Database\Console\Seeds\SeederMakeCommand;

class SeedServiceProvider extends ServiceProvider
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
        $this->registerSeedCommand();

        $this->registerMakeCommand();

        $this->royalcms->singleton('seeder', function () {
            return new Seeder;
        });

        $this->commands('command.seed', 'command.seeder.make');
    }

    /**
     * Register the seed console command.
     *
     * @return void
     */
    protected function registerSeedCommand()
    {
        $this->royalcms->singleton('command.seed', function ($royalcms) {
            return new SeedCommand($royalcms['db']);
        });
    }

    /**
     * Register the seeder generator command.
     *
     * @return void
     */
    protected function registerMakeCommand()
    {
        $this->royalcms->singleton('command.seeder.make', function ($royalcms) {
            return new SeederMakeCommand($royalcms['files'], $royalcms['composer']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['seeder', 'command.seed', 'command.seeder.make'];
    }
}

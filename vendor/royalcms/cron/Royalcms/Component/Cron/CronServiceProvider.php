<?php

namespace Royalcms\Component\Cron;

use Illuminate\Contracts\Support\DeferrableProvider;
use Royalcms\Component\Cron\Commands\KeygenCommand;
use Royalcms\Component\Cron\Commands\ListCommand;
use Royalcms\Component\Cron\Commands\RunCommand;
use Royalcms\Component\Support\ServiceProvider;

class CronServiceProvider extends ServiceProvider //implements DeferrableProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->package('royalcms/cron');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('cron', function ($royalcms) {
            return new Cron;
        });

        $this->loadAlias();

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->royalcms->singleton('cron::command.run', function ($royalcms) {
            return new RunCommand;
        });
        $this->commands('cron::command.run');

        $this->royalcms->singleton('cron::command.list', function ($royalcms) {
            return new ListCommand;
        });
        $this->commands('cron::command.list');

        $this->royalcms->singleton('cron::command.keygen', function ($royalcms) {
            return new KeygenCommand;
        });
        $this->commands('cron::command.keygen');
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
            'RC_Cron' => 'Royalcms\Component\Cron\Facades\Cron',
        ];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('cron');
    }

}
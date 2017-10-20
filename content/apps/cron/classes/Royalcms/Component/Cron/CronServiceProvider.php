<?php

namespace Royalcms\Component\Cron;

use Royalcms\Component\Support\ServiceProvider;

class CronServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('royalcms/cron');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->royalcms['cron'] = $this->royalcms->share(function($royalcms) {
                    return new Cron;
                });

        $this->royalcms->booting(function() {
                    $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
                    $loader->alias('RC_Cron', 'Royalcms\Component\Cron\Facades\Cron');
                });

        $this->royalcms['cron::command.run'] = $this->royalcms->share(function($royalcms) {
                    return new RunCommand;
                });
        $this->commands('cron::command.run');

        $this->royalcms['cron::command.list'] = $this->royalcms->share(function($royalcms) {
                    return new ListCommand;
                });
        $this->commands('cron::command.list');

        $this->royalcms['cron::command.keygen'] = $this->royalcms->share(function($royalcms) {
                    return new KeygenCommand;
                });
        $this->commands('cron::command.keygen');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
<?php

namespace Royalcms\Component\Console;

use Royalcms\Component\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
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
        $this->commands('Royalcms\Component\Console\Scheduling\ScheduleRunCommand');

        $this->commands('Royalcms\Component\Console\Scheduling\ScheduleListCommand');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Royalcms\Component\Console\Scheduling\ScheduleRunCommand',
            'Royalcms\Component\Console\Scheduling\ScheduleListCommand',
        ];
    }
}

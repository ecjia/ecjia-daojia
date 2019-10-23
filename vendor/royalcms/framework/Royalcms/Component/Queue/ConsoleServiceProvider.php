<?php

namespace Royalcms\Component\Queue;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Queue\Console\TableCommand;
use Royalcms\Component\Queue\Console\RetryCommand;
use Royalcms\Component\Queue\Console\ListFailedCommand;
use Royalcms\Component\Queue\Console\FlushFailedCommand;
use Royalcms\Component\Queue\Console\FailedTableCommand;
use Royalcms\Component\Queue\Console\ForgetFailedCommand;

class ConsoleServiceProvider extends ServiceProvider
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
        $this->royalcms->singleton('command.queue.table', function ($royalcms) {
            return new TableCommand($royalcms['files'], $royalcms['composer']);
        });

        $this->royalcms->singleton('command.queue.failed', function () {
            return new ListFailedCommand;
        });

        $this->royalcms->singleton('command.queue.retry', function () {
            return new RetryCommand;
        });

        $this->royalcms->singleton('command.queue.forget', function () {
            return new ForgetFailedCommand;
        });

        $this->royalcms->singleton('command.queue.flush', function () {
            return new FlushFailedCommand;
        });

        $this->royalcms->singleton('command.queue.failed-table', function ($app) {
            return new FailedTableCommand($app['files'], $app['composer']);
        });

        $this->commands(
            'command.queue.table', 'command.queue.failed', 'command.queue.retry',
            'command.queue.forget', 'command.queue.flush', 'command.queue.failed-table'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.queue.table', 'command.queue.failed', 'command.queue.retry',
            'command.queue.forget', 'command.queue.flush', 'command.queue.failed-table',
        ];
    }
}

<?php


namespace Royalcms\Component\Sentry;

use Royalcms\Component\Support\ServiceProvider;

class SentryConsoleServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($royalcms->runningInConsole()) {
            $this->registerArtisanCommands();
        }
    }

    /**
     * Register the artisan commands.
     */
    protected function registerArtisanCommands()
    {
        $this->commands([
            \Royalcms\Component\Sentry\SentryTestCommand::class,
        ]);
    }

}
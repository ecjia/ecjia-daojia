<?php namespace Royalcms\Component\Notifications;

use Royalcms\Component\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('notification', function ($royalcms) {
            return new ChannelManager($royalcms);
        });
    }
}

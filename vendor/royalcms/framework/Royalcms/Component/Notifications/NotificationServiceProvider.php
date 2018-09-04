<?php

namespace Royalcms\Component\Notifications;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Contracts\Notifications\Factory as FactoryContract;
use Royalcms\Component\Contracts\Notifications\Dispatcher as DispatcherContract;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
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

        $this->royalcms->singleton(ChannelManager::class, function ($royalcms) {
            return new ChannelManager($royalcms);
        });

        $this->royalcms->alias(
            ChannelManager::class, 'notification'
        );

        $this->royalcms->alias(
            ChannelManager::class, DispatcherContract::class
        );

        $this->royalcms->alias(
            ChannelManager::class, FactoryContract::class
        );
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('notification');
    }
}

<?php

namespace Royalcms\Component\Broadcasting;

use Royalcms\Component\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
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
        $this->royalcms->singleton('Royalcms\Component\Broadcasting\BroadcastManager', function ($royalcms) {
            return new BroadcastManager($royalcms);
        });

        $this->royalcms->singleton('Royalcms\Component\Contracts\Broadcasting\Broadcaster', function ($royalcms) {
            return $royalcms->make('Royalcms\Component\Broadcasting\BroadcastManager')->connection();
        });

        $this->royalcms->alias(
            'Royalcms\Component\Broadcasting\BroadcastManager', 'Royalcms\Component\Contracts\Broadcasting\Factory'
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
            'Royalcms\Component\Broadcasting\BroadcastManager',
            'Royalcms\Component\Contracts\Broadcasting\Factory',
            'Royalcms\Component\Contracts\Broadcasting\Broadcaster',
        ];
    }
}

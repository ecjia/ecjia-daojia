<?php

namespace Royalcms\Component\Routing;

use Royalcms\Component\Support\ServiceProvider;

class ControllerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('royalcms.route.dispatcher', function ($royalcms) {
            return new ControllerDispatcher($royalcms['router'], $royalcms);
        });
    }
}

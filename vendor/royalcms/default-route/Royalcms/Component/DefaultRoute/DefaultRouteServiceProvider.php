<?php

namespace Royalcms\Component\DefaultRoute;

use Royalcms\Component\Support\ServiceProvider;

class DefaultRouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $router = royalcms('router');
        
        $router->get('/{action?}', '\Royalcms\Component\DefaultRoute\DefaultRouteController@runAction');
        $router->any('/{controller}/{action?}', '\Royalcms\Component\DefaultRoute\DefaultRouteController@runControllerAction');
        $router->any('/{module}/{controller}/{action?}', '\Royalcms\Component\DefaultRoute\DefaultRouteController@runModuleControllerAction');
    }

    public function register()
    {
        
    }
    
}

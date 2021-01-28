<?php

namespace Royalcms\Component\DefaultRoute;

use Royalcms\Component\Support\ServiceProvider;

class DefaultRouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //$router = royalcms('router');
        
        //$router->get('/{action?}', '\Royalcms\Component\DefaultRoute\DefaultRouteController@runAction');
        //$router->any('/{controller}/{action?}', '\Royalcms\Component\DefaultRoute\DefaultRouteController@runControllerAction');
        //$router->any('/{module}/{controller}/{action?}', '\Royalcms\Component\DefaultRoute\DefaultRouteController@runModuleControllerAction');
    }

    public function register()
    {
        $this->royalcms->singleton('default-router', function($royalcms) {
            $route = new HttpQueryRoute();
            return $route;
        });
    }

    /**
     * Get a list of files that should be compiled for the package.
     *
     * @return array
     */
    public static function compiles()
    {
        $dir = static::guessPackageClassPath('royalcms/default-route');

        return [
            $dir . '/DefaultRouteTrait.php',
            $dir . '/HttpQueryRoute.php',
            $dir . '/DefaultRouteServiceProvider.php',
        ];
    }
    
}

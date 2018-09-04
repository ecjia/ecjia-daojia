<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Contracts\Foundation\Royalcms;
use RC_Loader;
use RC_Hook;

class Booted
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        $royalcms->booted(function() use ($royalcms) {

            // 请求数据自动转义
            $_POST      = rc_addslashes($_POST);
            $_GET       = rc_addslashes($_GET);
            $_REQUEST   = rc_addslashes($_REQUEST);
            $_COOKIE    = rc_addslashes($_COOKIE);


            // 加载扩展函数库
            RC_Loader::auto_load_func();

            /*
            |--------------------------------------------------------------------------
            | Load The Royalcms Start Script
            |--------------------------------------------------------------------------
            |
            | The start scripts gives this royalcms the opportunity to override
            | any of the existing IoC bindings, as well as register its own new
            | bindings for things like repositories, etc. We'll load it here.
            |
            */

            $path = $royalcms['path.system'].'/start/global.php';

            if (file_exists($path)) require $path;


            /*
            |--------------------------------------------------------------------------
            | Load The Environment Start Script
            |--------------------------------------------------------------------------
            |
            | The environment start script is only loaded if it exists for the app
            | environment currently active, which allows some actions to happen
            | in one environment while not in the other, keeping things clean.
            |
            */
            $env = $royalcms['env'];

            $path = $royalcms['path.system']."/start/{$env}.php";

            if (file_exists($path)) require $path;


            /*
            |--------------------------------------------------------------------------
            | Load The Royalcms Routes
            |--------------------------------------------------------------------------
            |
            | The Royalcms routes are kept separate from the royalcms starting
            | just to keep the file a little cleaner. We'll go ahead and load in
            | all of the routes now and return the application to the callers.
            |
            */
            $routes = $royalcms['path.system'].'/start/routes.php';

            if (file_exists($routes)) require $routes;


            /**
             * Fires after Royalcms has finished loading but before any headers are sent.
             *
             * @since 1.5.0
             */
            RC_Hook::do_action('init');


        });
    }
}

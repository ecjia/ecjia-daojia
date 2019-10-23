<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Contracts\Foundation\Royalcms;
use RC_Loader;
use RC_Hook;

class CommandBooted
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


            /**
             * Fires after Royalcms has finished loading but before any headers are sent.
             *
             * @since 1.5.0
             */
            RC_Hook::do_action('init');

        });
    }
}

<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Contracts\Foundation\Royalcms;

class BootProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        /*
        |--------------------------------------------------------------------------
        | Load The Royalcms bootstrap before Start Script
        |--------------------------------------------------------------------------
        |
        | The start scripts gives this royalcms the opportunity to override
        | any of the existing IoC bindings, as well as register its own new
        | bindings for things like repositories, etc. We'll load it here.
        |
        */

        $path = $royalcms['path.system'].'/start/bootstrap.php';

        if (file_exists($path)) require $path;

        $royalcms->boot();
    }
}

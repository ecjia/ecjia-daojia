<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Contracts\Foundation\Royalcms;

class Starting
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms|\Royalcms\Component\Foundation\Royalcms
     *
     * \Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        /*
        |--------------------------------------------------------------------------
        | Set PHP Error Reporting Options
        |--------------------------------------------------------------------------
        |
        | Here we will set the strictest error reporting options, and also turn
        | off PHP's error reporting, since all errors will be handled by the
        | framework and we don't want any output leaking back to the user.
        |
        */
        error_reporting(-1);

        /*
        |--------------------------------------------------------------------------
        | Check Extensions
        |--------------------------------------------------------------------------
        |
        | Royalcms requires a few extensions to function. Here we will check the
        | loaded extensions to make sure they are present. If not we'll just
        | bail from here. Otherwise, Composer will crazily fall back code.
        |
        */


    }
}

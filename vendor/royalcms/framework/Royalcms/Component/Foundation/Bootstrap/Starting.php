<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Contracts\Foundation\Royalcms;
use InvalidArgumentException;
use Royalcms\Component\Config\Dotenv;

class Starting
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
        | Laravel requires a few extensions to function. Here we will check the
        | loaded extensions to make sure they are present. If not we'll just
        | bail from here. Otherwise, Composer will crazily fall back code.
        |
        */

        if ( ! extension_loaded('mcrypt') && version_compare(PHP_VERSION, '7.2', '<'))
        {
            echo 'Mcrypt PHP extension required.'.PHP_EOL;

            exit(1);
        }

        /*
         * php >= 7.0
         */
        if ( ! interface_exists('Throwable')) {
            class_alias('\Royalcms\Component\Foundation\Compatible\Throwable', 'Throwable');
        }
        if ( ! class_exists('Error')) {
            class_alias('\Royalcms\Component\Foundation\Compatible\Error', 'Error');
        }

        /*
        |--------------------------------------------------------------------------
        | autoload cloass manager
        |--------------------------------------------------------------------------
        */
        \Royalcms\Component\ClassLoader\ClassManager::auto_loader_class();

        /*
        |--------------------------------------------------------------------------
        | Detect The Royalcms Environment
        |--------------------------------------------------------------------------
        |
        | Royalcms takes a dead simple approach to your application environments
        | so you can just specify a machine name for the host that matches a
        | given environment, then we will automatically detect it for you.
        |
        */

        try
        {
            Dotenv::load(SITE_PATH, $royalcms->environmentFile());
        }
        catch (InvalidArgumentException $e)
        {
            try {
                Dotenv::load(SITE_ROOT, $royalcms->environmentFile());
            }
            catch (InvalidArgumentException $e)
            {
                //
            }
        }

        $royalcms->detectEnvironment(function() {

            return env('ROYALCMS_ENV', 'production');

        });




    }
}

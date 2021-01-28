<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Contracts\Foundation\Royalcms;
use Royalcms\Component\ClassLoader\ClassManager;

class RegisterNamespaces
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
        | Register The Royalcms Auto Loader
        |--------------------------------------------------------------------------
        |
        | We register an auto-loader "behind" the Composer loader that can load
        | model classes on the fly, even if the autoload files have not been
        | regenerated for the application. We'll add it to the stack here.
        |
        */
        ClassManager::addNamespaces($royalcms['config']->get('namespaces', array()));

    }
}

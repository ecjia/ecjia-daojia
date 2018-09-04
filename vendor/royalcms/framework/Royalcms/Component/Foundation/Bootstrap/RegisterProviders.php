<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Contracts\Foundation\Royalcms;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        $royalcms->registerConfiguredProviders();

        /*
        |--------------------------------------------------------------------------
        | Register The User Service Providers
        |--------------------------------------------------------------------------
        |
        | The Royalcms user service providers register all of the core pieces
        | of the Royalcms framework including session, caching, encryption
        | and more. It's simply a convenient wrapper for the registration.
        |
        */

        collect($royalcms['config']->get('provider', array()))->map(function($provider) use ($royalcms) {
            if (class_exists($provider)) $royalcms->register($provider);
        });
    }
}

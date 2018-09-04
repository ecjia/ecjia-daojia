<?php

namespace Royalcms\Component\Cookie;

use Royalcms\Component\Support\ServiceProvider;

class CookieServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('cookie', function ($royalcms) {
            $config = $royalcms['config']['cookie'];

            return with(new CookieJar)->setDefaultPathAndDomain($config['path'], $config['domain'], $config['secure']);
        });
    }
}

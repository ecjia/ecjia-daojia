<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Http\Request;
use Royalcms\Component\Contracts\Foundation\Royalcms;

class SetRequestForConsole
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        $url = $royalcms->make('config')->get('system.url', 'http://localhost');

        $royalcms->instance('request', Request::create($url, 'GET', [], [], [], $_SERVER));
    }
}

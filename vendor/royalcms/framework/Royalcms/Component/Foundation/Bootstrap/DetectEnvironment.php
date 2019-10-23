<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Config\Dotenv;
use InvalidArgumentException;
use Royalcms\Component\Contracts\Foundation\Royalcms;

class DetectEnvironment
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        try {
            Dotenv::load($royalcms->environmentPath(), $royalcms->environmentFile());
        } catch (InvalidArgumentException $e) {
            //
        }

        $royalcms->detectEnvironment(function () {
            return env('ROYALCMS_ENV', 'production');
        });
    }
}

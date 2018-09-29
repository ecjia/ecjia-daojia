<?php

namespace Royalcms\Component\Swoole\Swoole\Traits;

use Royalcms\Component\Swoole\Foundation\Royalcms;

trait RoyalcmsTrait
{
    protected function initRoyalcms(array $conf, \swoole_server $swoole)
    {
        $royalcms = new Royalcms($conf);
        $royalcms->prepareRoyalcms();
        $royalcms->bindSwoole($swoole);
        return $royalcms;
    }
}
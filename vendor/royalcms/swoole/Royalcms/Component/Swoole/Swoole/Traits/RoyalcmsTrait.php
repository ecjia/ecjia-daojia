<?php

namespace Royalcms\Component\Swoole\Swoole\Traits;

use Royalcms\Component\Swoole\Foundation\Royalcms;
use Swoole\Http\Server;

trait RoyalcmsTrait
{
    protected function initRoyalcms(array $conf, Server $swoole)
    {
        $royalcms = new Royalcms($conf);
        $royalcms->prepareRoyalcms();
        $royalcms->bindSwoole($swoole);
        return $royalcms;
    }
}
<?php

namespace Royalcms\Component\Swoole\Traits;

use Royalcms\Component\Swoole\Royalcms;
use Swoole\Server;

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
<?php

namespace Royalcms\Component\Swoole\Swoole\Socket;

use Swoole\Server;

interface UdpInterface
{
    public function onPacket(Server $server, $data, array $clientInfo);
}
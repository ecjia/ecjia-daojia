<?php

namespace Royalcms\Component\Swoole\Swoole\Socket;

interface UdpInterface
{
    public function onPacket(\swoole_server $server, $data, array $clientInfo);
}
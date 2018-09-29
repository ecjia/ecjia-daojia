<?php

namespace Royalcms\Component\Swoole\Swoole;

use Royalcms\Component\Swoole\Swoole\Socket\WebSocketInterface;

interface WebSocketHandlerInterface extends WebSocketInterface
{
    public function __construct();
}
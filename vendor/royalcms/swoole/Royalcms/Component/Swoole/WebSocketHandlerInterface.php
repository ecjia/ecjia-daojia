<?php

namespace Royalcms\Component\Swoole;

use Royalcms\Component\Swoole\Socket\WebSocketInterface;

interface WebSocketHandlerInterface extends WebSocketInterface
{
    public function __construct();
}
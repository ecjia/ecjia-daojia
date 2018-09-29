<?php

namespace Royalcms\Component\Swoole\Swoole\Task;

abstract class Listener
{
    abstract public function __construct();

    abstract public function handle(Event $event);
}
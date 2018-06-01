<?php

if (! function_exists('websocket')) {

    function websocket($websocketName = '')
    {
        $queueHandle = royalcms('\Royalcms\Component\WebSocket\QueueHandles\RedisQueueHandle');
        $queueHandle->setQueueName(config('websocket::websocket.queue_name'));
        return $queueHandle;
    }


}
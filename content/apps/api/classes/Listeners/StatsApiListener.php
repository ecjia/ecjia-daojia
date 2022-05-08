<?php

namespace Ecjia\App\Api\Listeners;

use Ecjia\App\Api\Events\ApiRemoteRequestEvent;
use RC_Api;

class StatsApiListener
{

    /**
     * 处理事件
     *
     * @param ApiRemoteRequestEvent $event
     * @return void
     */
    public function handle(ApiRemoteRequestEvent $event)
    {
        // 使用 $event->controller 来访问控制器 ...
        RC_Api::api('stats', 'statsapi', array('api_name' => $event->controller->getRequest()->input('url'), 'device' => $event->controller->getDevice()));
    }

}
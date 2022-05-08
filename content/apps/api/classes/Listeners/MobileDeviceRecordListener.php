<?php

namespace Ecjia\App\Api\Listeners;

use Ecjia\App\Api\Events\ApiRemoteRequestEvent;
use RC_Api;

class MobileDeviceRecordListener
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

        RC_Api::api('mobile', 'device_record', array('device' => $event->controller->getDevice()));

    }

}
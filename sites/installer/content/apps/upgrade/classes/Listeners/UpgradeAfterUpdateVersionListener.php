<?php

namespace Ecjia\App\Upgrade\Listeners;

use Ecjia\App\Upgrade\UpgradeUtility;
use Ecjia\Component\Version\Events\UpgradeAfterEvent;

class UpgradeAfterUpdateVersionListener
{

    /**
     * 处理事件
     *
     * @param UpgradeAfterEvent $event
     * @return void|bool
     */
    public function handle(UpgradeAfterEvent $event)
    {

        if (is_ecjia_error($event->result)) {
            return false;
        }

        $version = $event->version->getVersionString();

        UpgradeUtility::updateEcjiaVersion($version);

    }

}
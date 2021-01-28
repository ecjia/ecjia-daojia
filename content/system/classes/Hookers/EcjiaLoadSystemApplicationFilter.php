<?php


namespace Ecjia\System\Hookers;


/**
 * ECJia 安装应用注册进AppManager
 * Class EcjiaInitLoadAction
 * @package Ecjia\System\Hookers
 */
class EcjiaLoadSystemApplicationFilter
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($bundles)
    {
        // 加载系统应用
        if (config('system.admin_enable') === true) {
            $bundles[] = new \Royalcms\Component\App\Bundles\SystemBundle();
        }

        return $bundles;
    }

}
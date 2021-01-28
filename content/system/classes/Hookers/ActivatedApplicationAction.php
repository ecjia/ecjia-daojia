<?php


namespace Ecjia\System\Hookers;


use Ecjia\System\Admins\AdminMenu\HeaderMenuGroup;
use Ecjia\System\Admins\AdminMenu\SidebarMenuGroup;

class ActivatedApplicationAction
{

    /**
     * Handle the event.
     * hook:activated_application
     * @return void
     */
    public function handle($app_id)
    {
        //清除头部菜单缓存
        (new HeaderMenuGroup())->cleanMenuCache();
        //清除边栏菜单缓存
        (new SidebarMenuGroup())->cleanMenuCache();
    }

}
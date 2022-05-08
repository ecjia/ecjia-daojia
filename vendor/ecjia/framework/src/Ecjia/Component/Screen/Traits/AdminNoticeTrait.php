<?php


namespace Ecjia\Component\Screen\Traits;


use Ecjia\Component\AdminNotice\AdminNotice;
use Ecjia\Component\Screen\Screens\AdminNoticeScreen;

/**
 * Trait AdminNoticeTrait
 * @package Ecjia\Component\Screen\Traits
 *
 * @property AdminNoticeScreen $admin_notice_screen
 */
trait AdminNoticeTrait
{

    /**
     * 添加一个对象
     * @param AdminNotice $admin_notice
     */
    public function add_admin_notice(AdminNotice $admin_notice)
    {
        return $this->admin_notice_screen->add_admin_notice($admin_notice);
    }

    /**
     * Gets the admin notice registered for the screen.
     *
     * @return array Help tabs with arguments.
     * @since 1.0.0
     *
     */
    public function get_admin_notice()
    {
        return $this->admin_notice_screen->get_admin_notice();
    }

}
<?php


namespace Ecjia\Component\Screen\Screens;


use Ecjia\Component\AdminNotice\AdminNotice;

class AdminNoticeScreen
{
    /**
     * The screen options associated with screen, if any.
     *
     * @since 1.0.0
     * @var array
     * @access protected
     */
    protected $admin_notice = array();


    /**
     * 添加一个对象
     * @param admin_notice $admin_notice
     */
    public function add_admin_notice(AdminNotice $admin_notice)
    {
        if ($admin_notice instanceof AdminNotice) {
            $this->admin_notice[] = $admin_notice;
        }

        return $this;
    }

    /**
     * 移除所有对象
     */
    public function remove_admin_notice()
    {
        $this->admin_notice = array();
    }

    /**
     * 移出最后一个对象
     */
    public function remove_last_admin_notice()
    {
        array_pop($this->admin_notice);
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
        return $this->admin_notice;
    }

}
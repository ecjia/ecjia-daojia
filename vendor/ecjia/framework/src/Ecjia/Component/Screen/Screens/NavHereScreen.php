<?php

namespace Ecjia\Component\Screen\Screens;

use Ecjia\Component\AdminNavHere\AdminNavHere;

class NavHereScreen
{

    /**
     * The screen options associated with screen, if any.
     *
     * @since 1.0.0
     * @var array
     * @access protected
     */
    protected $nav_here = array();

    /**
     * 添加一个对象
     * @param admin_nav_here $nav_here
     */
    public function add_nav_here(AdminNavHere $nav_here)
    {
        if ($nav_here instanceof AdminNavHere) {
            $this->nav_here[] = $nav_here;
        }

        return $this;
    }

    /**
     * 移除所有对象
     */
    public function remove_nav_heres()
    {
        $this->nav_here = array();
    }

    /**
     * 移出最后一个对象
     */
    public function remove_last_nav_here()
    {
        array_pop($this->nav_here);
    }

    /**
     * 获取所有对象
     * @return AdminNavHere[]
     */
    public function get_nav_heres()
    {
        return $this->nav_here;
    }

    /**
     * 移出最后一个对象
     */
    public function get_last_nav_here()
    {
        return end($this->nav_here);
    }

    /**
     * 判断是否含有对象
     * @return bool
     */
    public function has_nav_here()
    {
        if (!empty($this->nav_here)) {
            return true;
        }
        return false;
    }


}
<?php


namespace Ecjia\Component\Screen\Traits;

use Ecjia\Component\AdminNavHere\AdminNavHere;
use Ecjia\Component\Screen\Screens\NavHereScreen;

/**
 * Class NavHereTrait
 * @package Ecjia\Component\Screen\Traits
 *
 * @property NavHereScreen $nav_here_screen
 */
trait NavHereTrait
{
    /**
     * 添加一个对象
     * @param AdminNavHere $nav_here
     */
    public function add_nav_here(AdminNavHere $nav_here)
    {
        return $this->nav_here_screen->add_nav_here($nav_here);
    }

    /**
     * 移除所有对象
     */
    public function remove_nav_here()
    {
        return $this->nav_here_screen->remove_nav_here();
    }

    /**
     * 移出最后一个对象
     */
    public function remove_last_nav_here()
    {
        return $this->nav_here_screen->remove_last_nav_here();
    }

    /**
     * 获取所有对象
     */
    public function get_nav_heres()
    {
        return $this->nav_here_screen->get_nav_heres();
    }

    /**
     * 移出最后一个对象
     */
    public function get_last_nav_here()
    {
        return $this->nav_here_screen->get_last_nav_here();
    }

    /**
     * 判断是否含有对象
     * @return bool
     */
    public function has_nav_here()
    {
        return $this->nav_here_screen->has_nav_here();
    }

}
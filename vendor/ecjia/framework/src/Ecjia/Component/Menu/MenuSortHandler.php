<?php


namespace Ecjia\Component\Menu;

/**
 * 菜单排序
 * Class MenuSortHandler
 * @package Ecjia\Component\Menu
 */
class MenuSortHandler
{
    /**
     * @param Menu $a
     * @param Menu $b
     * @return int
     */
    public static function handler(Menu $a, Menu $b)
    {
        if ($a->getSort() == $b->getSort()) {
            return 0;
        } else {
            return ($a->getSort() > $b->getSort()) ? 1 : -1;
        }
    }

}
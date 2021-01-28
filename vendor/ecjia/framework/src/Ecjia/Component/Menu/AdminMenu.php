<?php


namespace Ecjia\Component\Menu;


class AdminMenu extends Menu
{
    /**
     * 获取属性
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($name == 'purview') {
            return 'purviews';
        }
        elseif ($name == 'has_submenus') {
            return $this->hasSubmenus();
        }

        return $this->$name;
    }

    /**
     * 添加base名称
     * @param string $base
     */
    public function add_base($base)
    {
        return $this->setBase($base);
    }

    /**
     * 添加icon图片
     * @param string $icon
     */
    public function add_icon($icon)
    {
        return $this->setIcon($icon);
    }

    /**
     * 添加菜单或菜单数组进子菜单数组里
     * @param Menu|array $menu
     */
    public function add_submenu($menus)
    {
        return $this->addSubmenus($menus);
    }

    /**
     * @param Menu $menu
     */
    public function remove_submenu(Menu $menu)
    {
        return $this->removeSubmenu($menu);
    }

    /**
     * 获取子菜单数组
     */
    public function submenus()
    {
        return $this->getSubmenus();
    }

    /**
     * 添加使用该菜单的权限
     */
    public function add_purview($priv)
    {
        return $this->addPurview($priv);
    }

    /**
     * 获取权限列表
     */
    public function purview()
    {
        return $this->purviews;
    }

    /**
     * 检测是否有权限设置
     * @return boolean
     */
    public function has_purview()
    {
        return $this->hasPurviews();
    }

    /**
     * 检测是否有子菜单数据
     */
    public function has_submenus()
    {
        return $this->hasSubmenus();
    }

}
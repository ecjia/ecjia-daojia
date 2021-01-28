<?php


namespace Ecjia\Component\Menu;


class Menu
{
    /**
     * @var string
     */
    protected $base;

    /**
     * 动作标识
     * @var string
     */
    protected $action;

    /**
     * 菜单名称
     * @var string
     */
    protected $name;

    /**
     * 菜单排序
     * @var int
     */
    protected $sort;

    /**
     * 菜单链接
     * @var string
     */
    protected $link;

    /**
     * 菜单图标
     * @var string
     */
    protected $icon;

    /**
     * 菜单打开新窗口的方式
     * @var string
     */
    protected $target;

    /**
     * 子菜单
     * @var array
     */
    protected $submenus = [];

    /**
     * 权限组
     * @var array
     */
    protected $purviews = [];

    /**
     * Menu constructor.
     * @param $action
     * @param $name
     * @param $link
     * @param int $sort
     * @param string $target
     */
    public function __construct($action, $name, $link, $sort = 99, $target = '_self')
    {
        $this->action   = $action;
        $this->name     = $name;
        $this->link     = $link;
        $this->sort     = $sort;
        $this->target   = $target;
    }

    /**
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param string $base
     * @return Menu
     */
    public function setBase($base): Menu
    {
        $this->base = $base;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return Menu
     */
    public function setAction($action): Menu
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Menu
     */
    public function setName($name): Menu
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     * @return Menu
     */
    public function setSort($sort): Menu
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return Menu
     */
    public function setLink($link): Menu
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return Menu
     */
    public function setIcon($icon): Menu
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return Menu
     */
    public function setTarget($target): Menu
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return array
     */
    public function getSubmenus()
    {
        if (is_array($this->submenus)) {
            usort($this->submenus, array('Ecjia\Component\Menu\MenuSortHandler', 'Handler'));
        }

        return $this->submenus;
    }

    /**
     * @param array $submenus
     * @return Menu
     */
    public function setSubmenus(array $submenus): Menu
    {
        $this->submenus = $submenus;
        return $this;
    }

    /**
     * 添加菜单或菜单数组进子菜单数组里
     * @param Menu|array $menus
     */
    public function addSubmenus($menus)
    {
        // 如果是菜单对象，直接添加进子菜单数组
        if (is_object($menus) && $menus instanceof Menu) {
            $this->submenus[] = $menus;
        }
        // 如果是数组，直接合并进子菜单数组里
        elseif (is_array($menus)) {
            foreach ($menus as $submenu) {
                $this->addSubmenus($submenu);
            }
        }

        return $this;
    }

    /**
     * 移除Submenu菜单
     * @param Menu $menu
     */
    public function removeSubmenu(Menu $menu)
    {
        if (is_object($menu)) {
            $key = array_search($menu, $this->submenus, true);
            if (!is_null($key)) {
                unset($this->submenus[$key]);
            }
        }
        return $this;
    }


    /**
     * 检测是否有子菜单数据
     */
    public function hasSubmenus()
    {
        if (empty($this->submenus)) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * @return array
     */
    public function getPurviews()
    {
        return $this->purviews;
    }

    /**
     * @param array $purviews
     * @return Menu
     */
    public function setPurviews(array $purviews): Menu
    {
        $this->purviews = $purviews;
        return $this;
    }

    /**
     * 检测是否有权限设置
     * @return boolean
     */
    public function hasPurviews()
    {
        if (empty($this->purviews)) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * 添加使用该菜单的权限
     *
     * @param array|string $priv
     */
    public function addPurview($priv)
    {
        if (is_array($priv)) {
            $this->purviews = $priv;
        }
        else {
            $this->purviews[] = $priv;
        }

        return $this;
    }

    /**
     * 移除使用该菜单的权限
     *
     * @param array|string $priv
     */
    public function removePurview($priv)
    {
        if (is_object($priv)) {
            $key = array_search($priv, $this->purviews, true);
            if (!is_null($key)) {
                unset($this->purviews[$key]);
            }
        }

        return $this;
    }


}
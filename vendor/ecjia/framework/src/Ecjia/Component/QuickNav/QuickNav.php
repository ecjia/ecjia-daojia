<?php


namespace Ecjia\Component\QuickNav;


class QuickNav
{
    /**
     * 失败登录次数
     */
    const META_KEY_QUICK_NAV_LIST = 'quick_nav_list';

    protected $model;

    public function __construct($model, $site = null)
    {
        if (empty($site)) {
            $site = defined('RC_SITE') ? constant('RC_SITE') : null;
        }

        $this->model = $model;
        $this->meta_key = $site ? self::META_KEY_QUICK_NAV_LIST . '_' . $site : self::META_KEY_QUICK_NAV_LIST;
    }

    /**
     * 失败增加一次
     * @param array $navs
     * @return
     */
    public function save($navs)
    {
        return $this->model->setMeta($this->meta_key, $navs);
    }

    /**
     * 获取数据
     */
    public function get()
    {
        return $this->model->getMeta($this->meta_key);
    }

    /**
     * 删除数据
     */
    public function delete()
    {
        return $this->model->removeMeta($this->meta_key);
    }

}
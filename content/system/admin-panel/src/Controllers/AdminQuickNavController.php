<?php


namespace Ecjia\System\AdminPanel\Controllers;


use admin_nav_here;
use ecjia;
use Ecjia\Component\QuickNav\QuickNav;
use Ecjia\Component\ShowMessage\Options\PjaxShowMessageOption;
use Ecjia\System\Admins\AdminMenu\HeaderMenuGroup;
use Ecjia\System\Admins\Users\AdminUserRepository;
use ecjia_admin;
use ecjia_admin_log;
use ecjia_screen;
use RC_Cache;
use RC_Script;
use RC_Style;
use RC_Uri;

class AdminQuickNavController extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('jquery-uniform');

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('ecjia-admin_privilege');
        //js语言包调用
        RC_Script::localize_script('ecjia-admin_privilege', 'admin_privilege', config('system::jslang.privilege_page'));

    }

    /**
     * 个人快捷导航菜单修改
     */
    public function init()
    {
        $admin_id = intval($_SESSION['admin_id']);
        if (empty($admin_id)) {
            return $this->showmessage(__('非法操作！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('设置个人导航菜单')));

        $model = AdminUserRepository::model()->find($admin_id);
        if (empty($model)) {
            return $this->showmessage(__('非法操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $nav      = new QuickNav($model);
        $nav_list = $nav->get();

        $nav_list = collect($nav_list)->mapWithKeys(function ($item) {
            $tmp = explode('|', $item);
            if (isset($tmp[0], $tmp[1])) {
                return [$tmp[1] => $tmp[0]];
            }
        })->all();

        $menus_list = (new HeaderMenuGroup)->getMenus();
        $menus_list = collect($menus_list)->map(function ($item) {
            return $item['menus'];
        })->all();

        $this->assign('menus_list', $menus_list);
        $this->assign('nav_arr', $nav_list);
        $this->assign('ur_here', __('设置个人导航菜单'));
        $this->assign('form_link', RC_Uri::url('@admin_quick_nav/quick_nav_save'));

        return $this->display('privilege_quick_nav.dwt');
    }

    /**
     * 个人快捷导航菜单修改 - 保存
     */
    public function quick_nav_save()
    {
        try {
            $admin_id = intval($_SESSION['admin_id']);
            if (empty($admin_id)) {
                return $this->showmessage(__('非法操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $model = AdminUserRepository::model()->find($admin_id);

            if (empty($model)) {
                return $this->showmessage(__('非法操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $nav_list = $this->request->input('nav_list', []);

            $nav = new QuickNav($model);
            $nav->save($nav_list);

            /* 记录管理员操作 */
            ecjia_admin_log::instance()->add_object('admin_quick_nav', __('个人导航'));
            ecjia_admin::admin_log($_SESSION['admin_name'], 'edit', 'admin_quick_nav');

            /* 清除用户缓存 */
            RC_Cache::userdata_cache_delete('admin_navlist', $admin_id, 'admin');

            return $this->showmessage('更新成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,
                (new PjaxShowMessageOption())->setPjaxurl(RC_Uri::url('@admin_quick_nav/init'))
            );
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

}
<?php


namespace Ecjia\System\AdminPanel\Controllers;


use admin_nav_here;
use ecjia;
use Ecjia\Component\SessionLogins\SessionLoginsModel;
use ecjia_admin;
use ecjia_page;
use ecjia_screen;
use RC_Script;

class AdminSessionLoginController extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

        RC_Script::enqueue_script('smoke');

        RC_Script::enqueue_script('ecjia-admin_logs');

        //js语言包调用
        RC_Script::localize_script('ecjia-admin_logs', 'admin_logs_lang', config('system::jslang.logs_page'));

    }

    public function init()
    {
        $this->admin_priv('session_login_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('登录日志')));

        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台会员管理页面，可以在此查看用户登录操作的一些会话记录信息。') . '</p>'
        ));

        $this->assign('ur_here', __('登录日志'));

        $logs = $this->get_logs();
        $this->assign('logs', $logs);

        return $this->display('admin_session_login.dwt');
    }

    /**
     * 删除
     */
    public function remove()
    {
        $this->admin_priv('session_manage');

        try {
            $key = trim($this->request->input('key'));

            SessionLoginsModel::where('id', $key)->delete();

            return $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }


    private function get_logs()
    {
        $query = SessionLoginsModel::with([]);

        $keyword = !empty($_GET['keyword']) ? trim($_GET['keyword']) : '';

        if (!empty($keyword)) {
            $query->where('id', $keyword);
        }
        $count = $query->count();
        $page = new ecjia_page($count, 10, 5);

        $logs = $query
            ->orderby('login_time', 'DESC')
            ->take(10)
            ->skip($page->start_id-1)
            ->get();

        $logs = $logs ? $logs->toArray() : [];

        return array('list' => $logs, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }

}
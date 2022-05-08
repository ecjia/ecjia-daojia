<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//

namespace Ecjia\System\AdminPanel\Controllers;

/**
 * 管理员用户控制器
 */

use admin_nav_here;
use ecjia;
use Ecjia\System\Admins\Users\AdminUserModel;
use Ecjia\System\Admins\Users\AdminUserRepository;
use Ecjia\System\Admins\Users\Password;
use Ecjia\System\Models\RoleModel;
use ecjia_admin;
use ecjia_admin_log;
use ecjia_page;
use ecjia_password;
use ecjia_purview;
use ecjia_screen;
use RC_Script;
use RC_Session;
use RC_Style;
use RC_Time;
use RC_Uri;

class AdminUserController extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('verify_csrf_token', ['only' => ['signin']]);

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

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员管理'), RC_Uri::url('@admin_user/init')));

    }

    /**
     * 管理员列表页面
     */
    public function init()
    {
        $this->admin_priv('admin_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员列表')));

        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台管理员列表页面，系统中所有的管理员都会显示在此列表中。') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E7.AE.A1.E7.90.86.E5.91.98.E5.88.97.E8.A1.A8" target="_blank">关于管理员列表帮助文档</a>') . '</p>'
        );

        $keyword = remove_xss($this->request->input('keyword'));

        $query = AdminUserRepository::model()->select('user_id', 'user_name', 'email', 'add_time', 'last_login');
        if (!empty($keyword)) {
            $key_type = intval($this->request->input('key_type', 1));
            switch ($key_type) {
                case 1 :
                    $query->where('user_name', 'like', "%$keyword%");
                    break;
                case 2:
                    $query->where('user_id', $keyword);
                    break;
                case 3:
                    $query->where('email', 'like', "%$keyword%");
                    break;
            }
        }

        $page = new ecjia_page($query->count(), 15, 6);

        $sort_by    = remove_xss($this->request->input('sort_by', 'user_id'));
        $sort_order = remove_xss($this->request->input('sort_order', 'DESC'));
        $models     = $query->orderBy($sort_by, $sort_order)->skip($page->start_id - 1)->take($page->page_size)->get();
        $list       = [];
        if (!empty($models)) {
            $list = $models->map(function ($model) {
                $model->add_time   = RC_Time::local_date(ecjia::config('time_format'), $model->add_time);
                $model->last_login = RC_Time::local_date(ecjia::config('time_format'), $model->last_login);
                return $model;
            })->toArray();
        }

        $this->assign('ur_here', __('管理员列表'));
        $this->assign('action_link', array('href' => RC_Uri::url('@admin_user/add'), 'text' => __('添加管理员')));
        $this->assign('full_page', 1);
        $this->assign('admin_list', ['list' => $list, 'page' => $page->show(5)]);
        $this->assign('full_page', 1);
        return $this->display('privilege_list.dwt');
    }

    /**
     * 添加管理员页面
     */
    public function add()
    {
        $this->admin_priv('admin_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加管理员')));

        /* 模板赋值 */
        $this->assign('ur_here', __('添加管理员'));
        $this->assign('action_link', array('href' => RC_Uri::url('@admin_user/init'), 'text' => __('管理员列表')));
        $this->assign('form_action', RC_Uri::url('@admin_user/insert'));
        $this->assign('pjax_link', RC_Uri::url('@admin_user/edit'));
        $this->assign('action', 'add');
        $this->assign('select_role', $this->get_role_list());

        return $this->display('privilege_info.dwt');
    }

    /**
     * 添加管理员的处理
     */
    public function insert()
    {
        $this->admin_priv('admin_manage');

        try {
            $user_name = remove_xss($this->request->input('user_name'));
            $email     = remove_xss($this->request->input('email'));
            $password  = remove_xss($this->request->input('password'));

            if (empty($user_name) || empty($email) || empty($password)) {
                return $this->showmessage(__('数据不完整'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 判断用户名和密码是否相等 */
            if ($user_name == $password) {
                return $this->showmessage(__('该管理员密码不能和管理员账号一样！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 判断管理员是否已经存在 */
            if ($user_name && AdminUserRepository::model()->where('user_name', $user_name)->count()) {
                return $this->showmessage(sprintf(__('该管理员 %s 已经存在！'), $user_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* Email地址是否有重复 */
            if ($email && AdminUserRepository::model()->where('email', $email)->count()) {
                return $this->showmessage(sprintf(__('该Email地址 %s 已经存在！'), $email), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $role_id = remove_xss($this->request->input('select_role', 0));

            /* 获取添加日期及密码 */
            $add_time    = RC_Time::gmtime();
            $ec_salt     = rand(1, 9999);
            $password    = ecjia_password::driver('hash')->createSaltPassword($password, $ec_salt);

            $insert_data = [
                'user_name'   => $user_name,
                'email'       => $email,
                'password'    => $password,
                'ec_salt'     => $ec_salt,
                'add_time'    => $add_time,
                'role_id'     => $role_id,
                'action_list' => '',
            ];

            $new_id = AdminUserRepository::model()->insertGetId($insert_data);

            if (!empty($new_id)) {
                $role_model = RoleModel::find($role_id);
                if (!empty($role_model)) {
                    $user = new \Ecjia\System\Admins\Users\AdminUser($new_id);
                    $user->setActionList($role_model->action_list);
                }
            }

            /*添加链接*/
            $links = ecjia_alert_links(
                [
                    'text' => __('设置管理员权限'),
                    'href' => RC_Uri::url('@admin_user/allot', ['id' => $new_id, 'user' => $user_name]),
                ],
                [
                    'text' => __('继续添加管理员'),
                    'href' => RC_Uri::url('@admin_user/add'),
                ]
            );

            /* 记录管理员操作 */
            ecjia_admin::admin_log($user_name, 'add', 'privilege');
            return $this->showmessage(sprintf(__('添加 %s 操作成功'), $user_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'id' => $new_id));
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑管理员信息
     */
    public function edit()
    {
        /* 不能编辑demo这个管理员 */
        if ($_SESSION['admin_name'] == 'demo') {
            $links = ecjia_alert_links([
                'text' => __('返回管理员列表'),
                'href' => RC_Uri::url('@admin_user/init'),
            ]);
            return $this->showmessage(__('您不能对此管理员的权限进行任何操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }

        $id = intval($this->request->input('id', 0));

        /* 查看是否有权限编辑其他管理员的信息 */
        if ($_SESSION['admin_id'] != $id) {
            $this->admin_priv('admin_manage');
        }

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑管理员')));

        /* 获取管理员信息 */
        $user_info = AdminUserRepository::model()->find($id)->toArray();

        /* 模板赋值 */
        $this->assign('ur_here', __('编辑管理员'));
        $this->assign('action_link', ['text' => __('管理员列表'), 'href' => RC_Uri::url('@admin_user/init')]);
        $this->assign('user', $user_info);

        /* 获得该管理员的权限 */
        $priv_str = $user_info['action_list'];

        if ($_SESSION['action_list'] == 'all' && $priv_str != 'all') {
            $this->assign('no_oldpwd', 1);
        }

        /* 如果被编辑的管理员拥有了all这个权限，将不能编辑 */
        if ($priv_str != 'all') {
            $this->assign('select_role', $this->get_role_list());
        }

        $this->assign('form_link', RC_Uri::url('@admin_user/update'));
        $this->assign('pjax_link', RC_Uri::url('@admin_user/edit'));
        $this->assign('action', 'edit');
        $this->assign('form_action', RC_Uri::url('@admin_user/update'));

        return $this->display('privilege_info.dwt');
    }

    /**
     * 获取角色列表
     * @return array
     */
    private function get_role_list($where = array())
    {
        $record_count = RoleModel::where($where)->count();
        $page         = new ecjia_page($record_count, 15, 6);

        $list = RoleModel::orderBy('role_id', 'DESC')->take($page->page_size)->skip($page->start_id - 1)->get()->toArray();
        return ['list' => $list, 'page' => $page->show(5)];
    }

    /**
     * 更新管理员信息
     */
    public function update()
    {
        try {
            /* 变量初始化 */
            $admin_id     = intval($this->request->input('id'));
            $admin_name   = remove_xss($this->request->input('user_name', ''));
            $admin_email  = remove_xss($this->request->input('email', ''));
            $new_password = remove_xss($this->request->input('new_password'));

            /* 查看是否有权限编辑其他管理员的信息 */
            if ($_SESSION['admin_id'] != $admin_id) {
                $this->admin_priv('admin_manage');
            }

            /* 判断管理员是否已经存在 */
            if ($admin_name && AdminUserRepository::model()->where('user_name', $admin_name)->where('user_id', '!=', $admin_id)->count()) {
                return $this->showmessage(sprintf(__('该管理员 %s 已经存在！'), $admin_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* Email地址是否有重复 */
            if ($admin_email && AdminUserRepository::model()->where('email', $admin_email)->where('user_id', '!=', $admin_id)->count()) {
                return $this->showmessage(sprintf(__('该Email地址 %s 已经存在！'), $admin_email), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $user_model = AdminUserRepository::model()->find($admin_id);
            if ($user_model->action_list == 'all') {
                return $this->showmessage(sprintf(__('超级管理员 %s 不可被修改！'), $admin_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (!empty($new_password)) {
                $links = ecjia_alert_links([
                    'text' => __('返回上一页'),
                    'href' => 'javascript:history.back(-1)',
                ]);

                /* 判断用户名和密码是否相等 */
                if ($admin_name == $new_password) {
                    return $this->showmessage(__('该管理员密码不能和管理员账号一样！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                /* 比较新密码和确认密码是否相同 */
                if ($new_password != remove_xss($this->request->input('pwd_confirm'))) {
                    return $this->showmessage(__('两次输入的密码不一致！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, ['links' => $links]);
                }

                $pm = ecjia_password::driver('hash');

                $user_model->ec_salt  = rand(1, 9999);
                $user_model->password = $pm->createSaltPassword($new_password, $user_model->ec_salt);
            }

            $role_id    = remove_xss($this->request->input('select_role'));
            $role_model = RoleModel::find($role_id);
            if (!empty($role_model)) {
                $user_model->role_id = $role_id;

                $user = new \Ecjia\System\Admins\Users\AdminUser($admin_id);
                $user->setActionList($role_model->action_list);
            }

            //更新管理员信息
            $user_model->user_name = $admin_name;
            $user_model->email     = $admin_email;
            $user_model->save();

            /* 记录日志 */
            ecjia_admin_log::instance()->add_object('admin_user', __('管理员账号'));
            ecjia_admin::admin_log($admin_name, 'edit', 'admin_user');
            $msg = __('您已经成功的修改了该用户信息！');

            /* 提示信息 */
            $links = ecjia_alert_links([
                'text' => __('返回管理员列表'),
                'href' => RC_Uri::url('@admin_user/init'),
            ]);
            return $this->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, ['links' => $links]);
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 为管理员分配权限
     */
    public function allot()
    {
        $this->admin_priv('allot_priv');

        $userid = intval($this->request->input('id'));
        if ($_SESSION['admin_id'] == $userid) {
            $this->admin_priv('all');
        }

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('分派权限')));
        ecjia_screen::get_current_screen()->add_option('current_code', 'admin_privilege_menu');

        $user      = new \Ecjia\System\Admins\Users\AdminUser($userid);
        $user_name = $user->getUserName();
        $priv_str  = $user->getActionList();

        /* 如果被编辑的管理员拥有了all这个权限，将不能编辑 */
        if ($priv_str == 'all') {
            $links = ecjia_alert_links([
                'text' => __('返回管理员列表'),
                'href' => RC_Uri::url('@admin_user/init'),
            ]);
            return $this->showmessage(__('您不能对此管理员的权限进行任何操作！'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, ['links' => $links]);
        }

        $priv_group = ecjia_purview::load_purview($priv_str);

        /* 赋值 */
        $this->assign('ur_here', sprintf(__('分派平台权限 [ %s ] '), $user_name));
        $this->assign('action_link', ['href' => RC_Uri::url('@admin_user/init'), 'text' => __('管理员列表')]);
        $this->assign('priv_group', $priv_group);
        $this->assign('user_id', $userid);

        /* 显示页面 */
        $this->assign('form_action', RC_Uri::url('@admin_user/update_allot'));

        return $this->display('privilege_allot.dwt');
    }

    /**
     * 更新管理员的权限
     */
    public function update_allot()
    {
        $this->admin_priv('admin_manage');

        try {
            $userid = intval($this->request->input('id'));

            /* 取得当前管理员用户名 */
            $user       = new \Ecjia\System\Admins\Users\AdminUser($userid);
            $admin_name = $user->getUserName();

            /* 更新管理员的权限 */
            $action_code = array_map('remove_xss', $this->request->input('action_code', []));
            $act_list    = join(',', $action_code);
            $user->setActionList($act_list);

            /* 动态更新管理员的SESSION */
            if ($_SESSION['admin_id'] == $userid) {
                $_SESSION['action_list'] = $act_list;
            }

            /* 记录管理员操作 */
            ecjia_admin::admin_log(addslashes($admin_name), 'edit', 'privilege');

            /* 提示信息 */
            $links = ecjia_alert_links([
                'text' => __('返回管理员列表'),
                'href' => RC_Uri::url('@admin_user/init'),
            ]);
            return $this->showmessage(sprintf(__('编辑 %s 操作成功！'), $admin_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, ['links' => $links]);
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除一个管理员
     */
    public function remove()
    {
        $this->admin_priv('admin_drop', ecjia::MSGTYPE_JSON);

        try {
            $id = intval($this->request->input('id'));

            /* ID为1的不允许删除 */
            if ($id === 1) {
                return $this->showmessage(__('此管理员您不能进行删除操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 管理员不能删除自己 */
            if ($id == $_SESSION['admin_id']) {
                return $this->showmessage(__('您不能删除自己！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 获得管理员用户名 */
            $model = AdminUserRepository::model()->find($id);
            if (empty($model)) {
                return $this->showmessage(__('您不能删除这个管理员！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* demo这个管理员不允许删除 */
            if ($model->user_name == 'demo') {
                return $this->showmessage(__('您不能删除demo这个管理员！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if (!$model->delete()) {
                return $this->showmessage(__('操作失败！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            RC_Session::session()->deleteSpecSession($id, 'admin'); // 删除session中该管理员的记录
            /* 记录日志 */
            ecjia_admin_log::instance()->add_object('admin_user', __('管理员账号'));
            ecjia_admin::admin_log(addslashes($model->user_name), 'remove', 'admin_user');
            return $this->showmessage(__('删除成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }


}
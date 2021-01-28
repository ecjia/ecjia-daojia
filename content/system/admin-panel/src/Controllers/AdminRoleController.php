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

use admin_nav_here;
use ecjia;
use Ecjia\System\Admins\Users\AdminUserModel;
use Ecjia\System\Admins\Users\AdminUserRepository;
use Ecjia\System\Models\RoleModel;
use ecjia_admin;
use ecjia_admin_log;
use ecjia_page;
use ecjia_purview;
use ecjia_screen;
use RC_Script;
use RC_Style;
use RC_Uri;

/**
 * ECJIA 角色管理信息以及权限管理程序
 */
class AdminRoleController extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Style::enqueue_style('fontello');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('ecjia-admin_role');
        RC_Script::enqueue_script('jquery-uniform');

        // 加载JS语言包
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');

        //js语言包调用
        RC_Script::localize_script('ecjia-admin_role', 'admin_role_lang', config('system::jslang.role_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('角色管理'), RC_Uri::url('@admin_role/init')));
    }

    public function init()
    {
        $this->admin_priv('admin_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('角色管理')));
        $this->assign('ur_here', __('角色管理'));

        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台角色管理页面，系统中所有的角色都会显示在此列表中。') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E8.A7.92.E8.89.B2.E7.AE.A1.E7.90.86" target="_blank">关于角色管理帮助文档</a>') . '</p>'
        );

        $this->assign('action_link', array('href' => RC_Uri::url('@admin_role/add'), 'text' => __('添加角色')));
        $this->assign('admin_list', $this->get_role_list());

        return $this->display('role_list.dwt');

    }

    /**
     * 添加角色页面
     */
    public function add()
    {
        $this->admin_priv('admin_manage');

        $priv_group = ecjia_purview::load_purview();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加角色')));
        $this->assign('ur_here', __('添加角色'));
        $this->assign('action_link', array('href' => RC_Uri::url('@admin_role/init'), 'text' => __('角色列表')));

        $this->assign('form_act', 'insert');
        $this->assign('priv_group', $priv_group);
        $this->assign('pjaxurl', RC_Uri::url('@admin_role/edit'));

        return $this->display('role_info.dwt');
    }

    /**
     * 添加角色的处理
     */
    public function insert()
    {
        $this->admin_priv('admin_manage');

        try {
            $username = remove_xss($this->request->input('user_name', ''));
            $act_list = join(',', array_map('remove_xss', $this->request->input('action_code', [])));

            $role_data = [
                'role_name'     => $username,
                'role_describe' => remove_xss($this->request->input('role_describe', '')),
                'action_list'   => $act_list
            ];

            $new_id = RoleModel::insertGetId($role_data);

            /* 记录日志 */
            ecjia_admin_log::instance()->add_object('role', __('管理员角色'));
            ecjia_admin::admin_log($username, 'add', 'role');

            /*添加链接*/
            $links = ecjia_alert_links([
                'text' => __('角色列表'),
                'href' => RC_Uri::url('@admin_role/init'),
            ]);

            return $this->showmessage(sprintf(__('添加 %s 操作成功'), $username), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'id' => $new_id));
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑角色信息
     */
    public function edit()
    {
        $this->admin_priv('admin_manage');

        $id = intval($this->request->input('id'));

        /* 查看是否有权限编辑其他管理员的信息 */
        if ($_SESSION['admin_id'] != $id) {
            $this->admin_priv('admin_manage');
        }

        $role_model = RoleModel::find($id);
        if (empty($role_model)) {
            return $this->showmessage(__('此角色不存在'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        $priv_str  = $role_model['action_list'];
        $user_info = $role_model->toArray();

        $priv_group = ecjia_purview::load_purview($priv_str);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('修改角色')));

        $this->assign('user', $user_info);
        $this->assign('ur_here', __('修改角色'));
        $this->assign('action_link', array('href' => RC_Uri::url('@admin_role/init'), 'text' => __('角色列表')));
        $this->assign('priv_group', $priv_group);
        $this->assign('user_id', $id);
        $this->assign('form_act', 'update');

        return $this->display('role_info.dwt');
    }

    /**
     * 更新角色信息
     */
    public function update()
    {
        $this->admin_priv('admin_manage');

        try {
            $act_list  = join(',', array_map('remove_xss', $this->request->input('action_code', [])));
            $role_id   = remove_xss($this->request->input('id'));
            $username  = remove_xss($this->request->input('user_name', ''));
            $role_data = [
                'role_name'     => $username,
                'role_describe' => remove_xss($this->request->input('role_describe', '')),
                'action_list'   => $act_list
            ];

            RoleModel::where('role_id', $role_id)->update($role_data);
            AdminUserRepository::model()->where('role_id', $role_id)->update(['action_list' => $act_list]);

            /* 记录日志 */
            ecjia_admin_log::instance()->add_object('role', __('管理员角色'));
            ecjia_admin::admin_log($username, 'edit', 'role');

            /* 提示信息 */
            $links = ecjia_alert_links([
                'text' => __('返回角色列表'),
                'href' => RC_Uri::url('@admin_role/init'),
            ]);
            return $this->showmessage(sprintf(__('编辑 %s 操作成功'), $username), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除一个角色
     */
    public function remove()
    {
        $this->admin_priv('admin_drop', ecjia::MSGTYPE_JSON);

        try {
            $role_id = intval($this->request->input('id'));

            $remove_num = AdminUserRepository::model()->where('role_id', $role_id)->count();
            if ($remove_num > 0) {
                return $this->showmessage(__('此角色有管理员在使用，暂时不能删除！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $role      = RoleModel::select('role_id', 'role_name')->find($role_id);
            $role_name = $role->role_name;
            $role->delete();

            /* 记录日志 */
            ecjia_admin_log::instance()->add_object('role', __('管理员角色'));
            ecjia_admin::admin_log($role_name, 'remove', 'role');

            return $this->showmessage(sprintf(__('成功删除管理员角色 %s'), $role_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
        catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 获取角色列表
     * @return array
     */
    private function get_role_list($where = [])
    {
        $record_count = RoleModel::where($where)->count();
        $page         = new ecjia_page($record_count, 15, 6);

        $list  = RoleModel::orderBy('role_id', 'DESC')->take($page->page_row)->skip($page->start_id - 1)->get()->toArray();
        $lists = array('list' => $list, 'page' => $page->show(5));
        return $lists;
    }

}
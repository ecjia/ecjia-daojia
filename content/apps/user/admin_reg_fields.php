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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员注册项管理程序
 */
class admin_reg_fields extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('admin_user');
        RC_Loader::load_app_func('global', 'goods');

        /* 加载所需js */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('user_info', RC_App::apps_url('statics/js/user_info.js', __FILE__));
        RC_Script::localize_script('user_info', 'js_lang', config('app-user::jslang.admin_reg_fields_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员注册项设置', 'user'), RC_Uri::url('user/admin_reg_fields/init')));
    }

    /**
     * 会员注册项列表
     */
    public function init()
    {
        $this->admin_priv('reg_fields');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员注册项设置', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台会员注册项列表页面，系统中所有的会员注册项都会显示在此列表中。', 'user') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员注册项设置" target="_blank">关于会员注册项帮助文档</a>', 'user') . '</p>'
        );

        $this->assign('ur_here', __('会员注册项设置', 'user'));
        $this->assign('action_link', array('text' => __('添加会员注册项', 'user'), 'href' => RC_Uri::url('user/admin_reg_fields/add')));

        $fields = RC_DB::table('reg_fields')->orderBy('dis_order', 'asc')->orderBy('id', 'asc')->get();
        $this->assign('reg_fields', $fields);

        return $this->display('reg_fields_list.dwt');
    }

    /**
     * 添加会员注册项
     */
    public function add()
    {
        $this->admin_priv('reg_fields');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加会员注册项', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台添加会员注册项页面，在此页面可以进行添加会员注册项操作。', 'user') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员注册项设置" target="_blank">关于添加会员注册项帮助文档</a>', 'user') . '</p>'
        );

        $this->assign('ur_here', __('添加会员注册项', 'user'));
        $this->assign('action_link', array('text' => __('会员注册项设置', 'user'), 'href' => RC_Uri::url('user/admin_reg_fields/init')));

        $reg_field['reg_field_order']   = 100;
        $reg_field['reg_field_display'] = 1;
        $reg_field['reg_field_need']    = 1;
        $this->assign('reg_field', $reg_field);
        $this->assign('form_action', RC_Uri::url('user/admin_reg_fields/insert'));

        return $this->display('reg_fields_edit.dwt');
    }

    /**
     * 增加会员注册项到数据库
     */
    public function insert()
    {
        $this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);

        /* 取得参数  */
        $field_name = trim($_POST['reg_field_name']);
        $dis_order  = intval($_POST['reg_field_order']);
        $display    = intval($_POST['reg_field_display']);
        $is_need    = intval($_POST['reg_field_need']);
        /* 检查是否存在重名的会员注册项 */
        if (RC_DB::table('reg_fields')->where('reg_field_name', $field_name)->count() != 0) {

            return $this->showmessage(sprintf(__('会员注册项名 %s 已经存在。', 'user'), $field_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data   = array(
            'reg_field_name' => $field_name,
            'dis_order'      => $dis_order,
            'display'        => $display,
            'is_need'        => $is_need,
        );
        $max_id = RC_DB::table('reg_fields')->insertGetId($data);
        ecjia_admin::admin_log($field_name, 'add', 'reg_fields');

        $links[] = array('text' => __('返回会员注册项列表', 'user'), 'href' => RC_Uri::url('user/admin_reg_fields/init'));
        $links[] = array('text' => __('继续添加会员注册项', 'user'), 'href' => RC_Uri::url('user/admin_reg_fields/add'));
        return $this->showmessage(__('会员注册项已经添加成功。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_reg_fields/edit', array('id' => $max_id))));
    }

    /**
     * 编辑会员注册项
     */
    public function edit()
    {
        $this->admin_priv('reg_fields');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑会员注册项', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台编辑会员注册项页面，在此页面可以进行编辑会员注册项操作。', 'user') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员注册项设置" target="_blank">关于编辑会员注册项帮助文档</a>', 'user') . '</p>'
        );

        $this->assign('ur_here', __('编辑会员注册项', 'user'));
        $this->assign('action_link', array('text' => __('会员注册项设置', 'user'), 'href' => RC_Uri::url('user/admin_reg_fields/init')));

        $reg_field = RC_DB::table('reg_fields')
            ->where('id', $_REQUEST['id'])
            ->select('id as reg_field_id', 'reg_field_name', 'dis_order as reg_field_order', 'display as reg_field_display', 'is_need as reg_field_need')
            ->first();

        $this->assign('reg_field', $reg_field);
        $this->assign('form_action', RC_Uri::url('user/admin_reg_fields/update'));

        return $this->display('reg_fields_edit.dwt');
    }

    /**
     * 更新会员注册项
     */
    public function update()
    {
        $this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);

        /* 取得参数  */
        $field_name = trim($_POST['reg_field_name']);
        $dis_order  = intval($_POST['reg_field_order']);
        $display    = intval($_POST['reg_field_display']);
        $is_need    = intval($_POST['reg_field_need']);
        $id         = intval($_POST['id']);

        /* 根据id获取之前的名字  */
        $old_name = RC_DB::table('reg_fields')->where('id', $id)->value('reg_field_name');

        /* 检查是否存在重名的会员注册项 */
        if ($field_name != $old_name) {
            if (RC_DB::table('reg_fields')->where('reg_field_name', $field_name)->count() != 0) {
                return $this->showmessage(sprintf(__('会员注册项名 %s 已经存在。', 'user'), $field_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $data = array(
            'reg_field_name' => $field_name,
            'dis_order'      => $dis_order,
            'display'        => $display,
            'is_need'        => $is_need,
        );
        RC_DB::table('reg_fields')->where('id', $id)->update($data);

        ecjia_admin::admin_log($field_name, 'edit', 'reg_fields');
        $links[] = array('text' => __('返回会员注册项列表', 'user'), 'href' => RC_Uri::url('user/admin_reg_fields/init'));
        return $this->showmessage(__('会员注册项已经修改成功。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_reg_fields/edit', array('id' => $id))));
    }

    /**
     * 删除会员注册项
     */
    public function remove()
    {
        $this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);

        $field_id   = intval($_GET['id']);
        $field_name = RC_DB::table('reg_fields')->where('id', $field_id)->value('reg_field_name');

        if (RC_DB::table('reg_fields')->where('id', $field_id)->delete()) {
            /* 删除会员扩展信息表的相应信息 */
            RC_DB::table('reg_extend_info')->where('reg_field_id', $field_id)->delete();
            ecjia_admin::admin_log(addslashes($field_name), 'remove', 'reg_fields');

            return $this->showmessage(__('删除成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    /**
     * 编辑会员注册项名称
     */
    public function edit_name()
    {
        $this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);

        $id  = intval($_REQUEST['pk']);
        $val = empty($_REQUEST['value']) ? '' : trim($_REQUEST['value']);

        if (empty($val)) {
            return $this->showmessage(__('您没有输入会员注册字段名称。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 验证名称,根据id获取之前的名字  */
        $old_name = RC_DB::table('reg_fields')->where('id', $id)->value('reg_field_name');

        if ($val != $old_name) {
            if (RC_DB::table('reg_fields')->where('reg_field_name', $val)->count() != 0) {
                return $this->showmessage(sprintf(__('会员注册项名 %s 已经存在。', 'user'), htmlspecialchars($val)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        if (RC_DB::table('reg_fields')->where('id', $id)->update(array('reg_field_name' => $val))) {
            /* 管理员日志 */
            ecjia_admin::admin_log($val, 'edit', 'reg_fields');
            return $this->showmessage(__('编辑成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑会员注册项排序权值
     */
    public function edit_order()
    {
        $this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);

        $id  = intval($_REQUEST['pk']);
        $val = isset($_REQUEST['value']) ? intval($_REQUEST['value']) : 0;

        /* 验证参数有效性  */
        if (!is_numeric($val) || empty($val) || $val < 0 || strpos($val, '.') > 0) {
            return $this->showmessage(__('输入的排序权值不是有效的数字。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('reg_fields')->where('id', $id)->update(array('dis_order' => $val));

        if (RC_DB::table('reg_fields')->where('id', $id)->update(array('dis_order' => $val)) == 0) {
            return $this->showmessage(__('编辑成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/admin_reg_fields/init')));
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 修改会员注册项显示状态
     */
    public function toggle_dis()
    {
        $this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);

        $id     = intval($_POST['id']);
        $is_dis = intval($_POST['val']);

        if (RC_DB::table('reg_fields')->where('id', $id)->update(array('display' => $is_dis))) {
            return $this->showmessage(__('切换成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_dis));
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 修改会员注册项必填状态
     */
    public function toggle_need()
    {
        $this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);

        $id      = intval($_POST['id']);
        $is_need = intval($_POST['val']);

        if (RC_DB::table('reg_fields')->where('id', $id)->update(array('is_need' => $is_need))) {
            return $this->showmessage(__('切换成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_need));
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
}

// end
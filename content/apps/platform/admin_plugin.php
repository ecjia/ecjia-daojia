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
 * ECJIA 功能扩展
 */
class admin_plugin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Platform\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-chosen');

        RC_Script::enqueue_script('platform', RC_App::apps_url('statics/js/platform.js', __FILE__), array(), false, true);
        RC_Script::localize_script('platform', 'js_lang', config('app-platform::jslang.admin_plugin_page'));

        RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/css/wechat_extend.css', __FILE__));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('公众平台', 'platform'), RC_Uri::url('platform/admin_plugin/init')));
        ecjia_screen::get_current_screen()->set_parentage('platform', 'platform/admin_plugin.php');
    }

    /**
     * 功能扩展列表
     */
    public function init()
    {
        $this->admin_priv('extend_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('功能扩展', 'platform')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'platform'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台功能扩展页面，系统中所有的功能扩展都会显示在此列表中。', 'platform') . '</p>',
        ));
        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息', 'platform') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:功能扩展#.E5.8A.9F.E8.83.BD.E6.89.A9.E5.B1.95" target="_blank">' . __('关于功能扩展帮助文档', 'platform') . '</a>') . '</p>'
        );

        $this->assign('ur_here', __('公众平台-功能扩展', 'platform'));

        $modules = $this->exts_list();
        $this->assign('modules', $modules);

        return $this->display('extend_list.dwt');
    }

    /**
     * 编辑扩展功能页面
     */
    public function edit()
    {
        $this->admin_priv('extend_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑功能扩展', 'platform')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'platform'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台编辑功能扩展页面，在此页面可以进行编辑功能扩展操作。', 'platform') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'platform') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:功能扩展#.E7.BC.96.E8.BE.91.E5.8A.9F.E8.83.BD.E6.89.A9.E5.B1.95" target="_blank">' . __('关于编辑功能扩展帮助文档', 'platform') . '</a>') . '</p>'
        );

        $this->assign('ur_here', __('编辑功能扩展', 'platform'));
        $this->assign('action_link', array('text' => __('功能扩展', 'platform'), 'href' => RC_Uri::url('platform/admin_plugin/init')));
        $this->assign('form_action', RC_Uri::url('platform/admin_plugin/save'));

        $code = trim($_GET['code']);
        $bd   = RC_DB::table('platform_extend')->where('ext_code', $code)->first();

        $this->assign('bd', $bd);

        return $this->display('extend_edit.dwt');
    }

    /**
     * 编辑扩展功能处理
     */
    public function save()
    {
        $this->admin_priv('extend_update', ecjia::MSGTYPE_JSON);

        $data['ext_name'] = trim($_POST['ext_name']);
        $data['ext_desc'] = trim($_POST['ext_desc']);
        $ext_code         = trim($_POST['ext_code']);

        RC_DB::table('platform_extend')->where('ext_code', $ext_code)->update($data);

        ecjia_admin::admin_log($data['ext_name'], 'edit', 'platform_extend');
        return $this->showmessage(__('编辑功能扩展成功', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin_plugin/edit', array('code' => $ext_code))));
    }

    /**
     * 禁用扩展处理
     */
    public function disable()
    {
        $this->admin_priv('extend_update', ecjia::MSGTYPE_JSON);

        $code     = trim($_GET['code']);
        $ext_name = RC_DB::table('platform_extend')->where('ext_code', $code)->value('ext_name');
        $data     = array(
            'enabled' => 0,
        );
        RC_DB::table('platform_extend')->where('ext_code', $code)->update($data);

        ecjia_admin::admin_log($ext_name, 'stop', 'platform_extend');
        return $this->showmessage(sprintf('%s<strong>%s</strong>', __('插件', 'platform'), __('已停用', 'platform')) . '</strong>', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin_plugin/init')));
    }

    /**
     * 启用扩展处理
     */
    public function enable()
    {
        $this->admin_priv('extend_update', ecjia::MSGTYPE_JSON);

        $code     = trim($_GET['code']);
        $ext_name = RC_DB::table('platform_extend')->where('ext_code', $code)->value('ext_name');

        $data = array(
            'enabled' => 1,
        );
        RC_DB::table('platform_extend')->where('ext_code', $code)->update($data);

        ecjia_admin::admin_log($ext_name, 'use', 'platform_extend');
        return $this->showmessage(sprintf('%s<strong>%s</strong>', __('插件', 'platform'), __('已启用', 'platform')), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin_plugin/init')));
    }

    /**
     * 扩展列表
     */
    private function exts_list()
    {
        $db_ext = RC_DB::table('platform_extend');

        $count                  = $db_ext->count();
        $filter['record_count'] = $count;
        $page                   = new ecjia_page($count, 10, 5);

        $arr  = array();
        $data = $db_ext->orderBy('ext_id', 'desc')->take(10)->skip($page->start_id - 1)->get();
        if (isset($data)) {
            foreach ($data as $rows) {
                $arr[] = $rows;
            }
        }
        return array('module' => $arr, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

// end

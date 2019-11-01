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
 * 公众平台命令速查
 */
class admin_command extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Platform\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');

        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('platform', RC_App::apps_url('statics/js/platform.js', __FILE__), array(), false, true);
        RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/css/wechat_extend.css', __FILE__));
        RC_Script::localize_script('platform', 'js_lang', config('app-platform::jslang.admin_command_page'));
    }

    /**
     * 扩展下的命令列表
     */
    public function extend_command()
    {
        $this->admin_priv('platform_command_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('功能扩展', 'platform'), RC_Uri::url('platform/admin_plugin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('命令列表', 'platform')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'platform'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台功能扩展命令页面，有关该扩展的命令都会显示在此列表中。', 'platform') . '</p>',
        ));
        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息', 'platform') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:功能扩展#.E6.9F.A5.E7.9C.8B.E5.91.BD.E4.BB.A4" target="_blank">' . __('关于功能扩展命令列表帮助文档', 'platform') . '</a>') . '</p>'
        );

        $id   = !empty($_GET['id']) ? $_GET['id'] : 0;
        $code = !empty($_GET['code']) ? trim($_GET['code']) : '';

        $this->assign('ur_here', __('命令列表', 'platform'));
        $this->assign('back_link', array('text' => __('功能扩展', 'platform'), 'href' => RC_Uri::url('platform/admin_plugin/init')));
        $this->assign('search_action', RC_Uri::url('platform/admin_command/extend_command', array('code' => $code)));

        $ext_name = RC_DB::table('platform_extend')->where('ext_code', $code)->value('ext_name');
        $this->assign('code', $code);
        $this->assign('ext_name', $ext_name);

        $ext_type_list = array('wechat', 'weibo', 'alipay');
        $this->assign('type_list', $ext_type_list);

        $this->assign('id', $id);
        $modules = $this->get_command_list();
        $this->assign('modules', $modules);

        return $this->display('extend_command_list.dwt');
    }

    /**
     * 扩展下的命令列表
     */
    private function get_command_list()
    {
        $db_command_view = RC_DB::table('platform_command as pc')
            ->leftJoin('platform_extend as pe', RC_DB::raw('pc.ext_code'), '=', RC_DB::raw('pe.ext_code'))
            ->leftJoin('platform_account as pa', RC_DB::raw('pa.id'), '=', RC_DB::raw('pc.account_id'));

        $type     = !empty($_GET['platform']) ? $_GET['platform'] : '';
        $keywords = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
        $code     = trim($_GET['code']);

        $db_command_view->where(RC_DB::raw('pc.ext_code'), $code)->where(RC_DB::raw('pa.shop_id'), 0);
        if (!empty($type)) {
            $db_command_view->where(RC_DB::raw('pc.platform'), $type);
        }
        if (!empty($keywords)) {
            $db_command_view->where(RC_DB::raw('pc.cmd_word'), 'like', '%' . mysql_like_quote($keywords) . '%');
        }
        $count = $db_command_view->count(RC_DB::raw('cmd_id'));

        $page = new ecjia_page($count, 15, 5);

        $data = $db_command_view->select(RC_DB::raw('pc.*, pa.name'))->take(15)->skip($page->start_id - 1)->orderBy(RC_DB::raw('pc.cmd_id'), 'asc')->get();

        return array('module' => $data, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

//end

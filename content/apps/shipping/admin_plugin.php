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
 * ECJIA 配送方式管理程序
 */
class admin_plugin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Shipping\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');

        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));

        RC_Script::enqueue_script('ecjia.utils');
        RC_Script::enqueue_script('ecjia.common');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Loader::load_app_class('shipping_factory', null, false);

        //时间控件
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
        RC_Script::enqueue_script('bootstrap-timepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));

        RC_Script::enqueue_script('shipping_admin', RC_App::apps_url('statics/js/shipping_admin.js', __FILE__), array(), false, 1);
		
        RC_Script::enqueue_script('acejs', RC_Uri::admin_url('statics/lib/acejs/ace.js'), array(), false, true);
        RC_Script::enqueue_script('acejs-emmet', RC_Uri::admin_url('statics/lib/acejs/ext-emmet.js'), array(), false, true);
        RC_Script::enqueue_script('template', RC_App::apps_url('statics/js/template.js', __FILE__), array(), false, 1);
        
        //js语言包
        RC_Script::localize_script('shipping_admin', 'js_lang', config('app-shipping::jslang.shipping_list_page'));
        RC_Script::localize_script('template', 'admin_template_lang', config('app-shipping::jslang.shipping_list_page'));
		
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('配送方式', 'shipping'), RC_Uri::url('shipping/admin_plugin/init')));
        ecjia_screen::get_current_screen()->set_parentage('shipping', 'shipping/admin_plugin.php');
    }

    /**
     * 配送方式列表  get
     */
    public function init()
    {
        $this->admin_priv('ship_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('配送方式', 'shipping')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'shipping'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台配送方式页面，系统中所有的配送方式都会显示在此列表中。', 'shipping') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'shipping') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">关于配送方式帮助文档</a>', 'shipping') . '</p>'
        );
        $this->assign('ur_here', __('配送方式', 'shipping'));

        //替换数据库获取数据方式
        $data = RC_DB::table('shipping')
            ->select('shipping_id', 'shipping_code', 'shipping_name', 'shipping_desc', 'insure', 'support_cod', 'shipping_order', 'enabled')
            ->orderBy('shipping_order', 'asc')
            ->get();

        $data or $data = array();

        $plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);

        /* 插件已经安装了，获得名称以及描述 */
        $modules = array();
        foreach ($data as $_key => $_value) {
            if (isset($plugins[$_value['shipping_code']])) {
                $modules[$_key]['id']             = $_value['shipping_id'];
                $modules[$_key]['code']           = $_value['shipping_code'];
                $modules[$_key]['name']           = $_value['shipping_name'];
                $modules[$_key]['desc']           = $_value['shipping_desc'];
                $modules[$_key]['cod']            = $_value['support_cod'];
                $modules[$_key]['shipping_order'] = $_value['shipping_order'];
                $modules[$_key]['insure_fee']     = $_value['insure'];
                $modules[$_key]['enabled']        = $_value['enabled'];
                if ($_value['enabled'] == 1) {
                    $plugin_handle                   = ecjia_shipping::channel($_value['shipping_code']);
                    $print_support                   = $plugin_handle->isSupportPrint();
                    $config                          = $plugin_handle->loadConfig();
                    $modules[$_key]['print_support'] = $print_support;
                }

                /* 只能根据配置判断是否支持保价  只有配置项明确说明不支持保价，才是不支持*/
                if (isset($config['insure']) && ($config['insure'] === false)) {
                    $modules[$_key]['is_insure'] = false;
                } else {
                    $modules[$_key]['is_insure'] = true;
                }
            }
        }
        $this->assign('modules', $modules);

        return $this->display('shipping_channel.dwt');
    }

    /**
     * 编辑配送方式 code={$code}
     */
    public function edit()
    {
        $this->admin_priv('ship_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑配送方式', 'shipping')));
        $this->assign('action_link', array('text' => __('配送方式', 'shipping'), 'href' => RC_Uri::url('shipping/admin_plugin/init')));
        $this->assign('ur_here', __('编辑配送方式', 'shipping'));

        if (isset($_GET['code'])) {
            $shipping_code = trim($_GET['code']);
        } else {
            return $this->showmessage(__('参数无效', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 查询该支付方式内容 */
        $shipping = RC_DB::table('shipping')->where('shipping_code', $shipping_code)->where('enabled', 1)->first();

        if (empty($shipping)) {
            return $this->showmessage(__('该配送插件不存在或尚未安装', 'shipping'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        $this->assign('form_action', RC_Uri::url('shipping/admin_plugin/save'));
        $this->assign('shipping', $shipping);

        return $this->display('shipping_edit.dwt');
    }

    /**
     * 提交配送方式post
     */
    public function save()
    {
        $this->admin_priv('ship_update');

        $name = trim($_POST['shipping_name']);
        $code = trim($_POST['shipping_code']);
        if (empty($name)) {
            return $this->showmessage(__('名称不能为空', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $count = RC_DB::table('shipping')->where('shipping_name', $name)->where('shipping_code', '!=', $code)->count();
        if ($count > 0) {
            return $this->showmessage(__('名称已存在', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $array = array(
            'shipping_name' => $name,
            'shipping_desc' => trim($_POST['shipping_desc']),
        );
        RC_DB::table('shipping')->where('shipping_code', $code)->update($array);

        /* 记录日志 */
        ecjia_admin::admin_log($name, 'edit', 'shipping');
        return $this->showmessage(__('编辑成功', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('shipping/admin_plugin/edit', array('code' => $code))));
    }

    /**
     * 禁用配送方式
     */
    public function disable()
    {
        $this->admin_priv('ship_update');

        $code = trim($_GET['code']);
        $data = array('enabled' => 0);
        RC_DB::table('shipping')->where('shipping_code', $code)->update($data);

        $shipping_name = RC_DB::table('shipping')->where('shipping_code', $code)->value('shipping_name');

        ecjia_admin::admin_log($shipping_name, 'stop', 'shipping');
        return $this->showmessage(__('插件', 'shipping') . ' <strong>' . __('已停用', 'shipping') . '</strong>', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('shipping/admin_plugin/init')));
    }

    /**
     * 启用配送方式
     */
    public function enable()
    {
        $this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);

        $code = trim($_GET['code']);
        $data = array('enabled' => 1);
        RC_DB::table('shipping')->where('shipping_code', $code)->update($data);

        $shipping_name = RC_DB::table('shipping')->where('shipping_code', $code)->value('shipping_name');

        ecjia_admin::admin_log($shipping_name, 'use', 'shipping');
        return $this->showmessage(__('插件', 'shipping') . ' <strong>' . __('已启用', 'shipping') . '</strong>', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('shipping/admin_plugin/init')));
    }

    /**
     * 编辑配送方式名称
     */
    public function edit_name()
    {
        $this->admin_priv('ship_update');

        /* 取得参数 */
        $shipping_id   = intval($_POST['pk']);
        $shipping_name = trim($_POST['value']);
        /* 检查名称是否为空 */
        if (empty($shipping_name) || $shipping_id == 0) {
            return $this->showmessage(__('配送方式名称不能为空。', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            /* 检查名称是否重复 */
            $old_name = RC_DB::table('shipping')->where('shipping_id', $shipping_id)->value('shipping_name');

            /* 名称是否有修改 */
            if ($old_name == $shipping_name) {
                return $this->showmessage(__('已经存在一个同名的配送方式。', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                /* 名称是否重复 */
                $count = RC_DB::table('shipping')->where('shipping_name', $shipping_name)->where('shipping_id', '!=', $shipping_id)->count();
                if ($count != 0) {
                    return $this->showmessage(__('已经存在一个同名的配送方式。', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    RC_DB::table('shipping')->where('shipping_id', $shipping_id)->update(array('shipping_name' => $shipping_name));

                    ecjia_admin::admin_log(addslashes($shipping_name), 'edit', 'shipping');
                    return $this->showmessage(__('操作成功!', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
                }
            }
        }
    }

    /**
     * 修改配送方式保价费
     */
    public function edit_insure()
    {
        $this->admin_priv('ship_update');

        $shipping_id     = intval($_POST['pk']);
        $shipping_insure = trim($_POST['value']);

        if (empty($shipping_insure) && !($shipping_insure === '0')) {
            return $this->showmessage(__('保价费用不能为空，不想使用请将其设置为0', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $shipping_insure = make_semiangle($shipping_insure); //全角转半角
            if (strpos($shipping_insure, '%') === false) {
                if (!is_numeric($_POST['value'])) {
                    return $this->showmessage(__('请输入合法数字或百分比%', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    $shipping_insure = floatval($shipping_insure);
                }
            } else {
                $shipping_insure = floatval($shipping_insure) . '%';
            }
            /* 检查该插件是否支持保价   在此不做检查，在页面上进行控制，不支持保价的不允许修改*/
            RC_DB::table('shipping')->where('shipping_id', $shipping_id)->update(array('insure' => $shipping_insure));

            return $this->showmessage(__('操作成功!', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    /**
     * 修改配送方式排序
     */
    public function edit_order()
    {
        $this->admin_priv('ship_update');

        if (!is_numeric($_POST['value'])) {
            return $this->showmessage(__('输入格式不正确', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            /* 取得参数 */
            $shipping_id    = intval($_POST['pk']);
            $shipping_order = intval($_POST['value']);

            RC_DB::table('shipping')->where('shipping_id', $shipping_id)->update(array('shipping_order' => $shipping_order));
            return $this->showmessage(__('操作成功!', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('shipping/admin_plugin/init')));
        }
    }
}

// end

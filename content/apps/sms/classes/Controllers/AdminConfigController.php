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
namespace Ecjia\App\Sms\Controllers;

use admin_nav_here;
use ecjia;
use ecjia_admin;
use ecjia_config;
use ecjia_screen;
use RC_App;
use RC_Script;
use RC_Style;
use RC_Uri;

/**
 * ECJIA短信模块
 * @author songqian
 */
class AdminConfigController extends AdminBase
{
    public function __construct()
    {
        parent::__construct();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('sms_config', RC_App::apps_url('statics/js/sms_config.js', $this->__FILE__), array(), false, true);
        RC_Script::localize_script('sms_config', 'js_lang_sms_config', config('app-sms::jslang.sms_config'));
    }

    /**
     * 短信配置页面
     */
    public function init()
    {
        $this->admin_priv('sms_config_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('短信配置', 'sms')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'sms'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台短信配置页面，系统中有关短信配置信息显示在此页面。', 'sms') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'sms') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:短信配置" target="_blank">' . __('关于短信配置帮助文档', 'sms') . '</a>', 'sms') . '</p>'
        );

        $this->assign('ur_here', __('短信通知', 'sms'));

        $this->assign('config_mobile', ecjia::config('sms_shop_mobile')); //商家电话
        $this->assign('current_code', 'sms');
        $this->assign('form_action', RC_Uri::url('sms/admin_config/update'));

        return $this->display('sms_config.dwt');
    }

    /**
     * 处理短信配置
     */
    public function update()
    {
        $this->admin_priv('sms_config_update', ecjia::MSGTYPE_JSON);

        $sms_mobile = $_POST['sms_shop_mobile'];
        ecjia_config::instance()->write_config('sms_shop_mobile', $sms_mobile);
        ecjia_admin::admin_log(__('短信管理>短信配置', 'sms'), 'setup', 'sms_config');
        return $this->showmessage(__('更新短信配置成功！', 'sms'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin_config/init')));
    }
}

//end

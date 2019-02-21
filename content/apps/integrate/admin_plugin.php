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
 * ECJIA 第三方程序会员数据整合插件管理程序
 */
class admin_plugin extends ecjia_admin
{

	public function __construct()
    {
		parent::__construct();

		/* 加载所全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('integrate_list', RC_App::apps_url('statics/js/integrate_list.js', __FILE__), array(), false, false);

        RC_Script::localize_script('integrate_list', 'js_lang', config('app-integrate::jslang.integrate_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员整合', 'integrate'), RC_Uri::url('integrate/admin_plugin/init')));
        ecjia_screen::get_current_screen()->set_parentage('integrate', 'integrate/admin_plugin.php');
	}

	/**
	 * 会员数据整合插件列表
	 */
	public function init()
    {
	    $this->admin_priv('integrate_users');
		
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('jquery-dataTables-sorting');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员整合', 'integrate')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述', 'integrate'),
			'content'	=> '<p>' . __('欢迎访问ECJia智能后台会员整合页面，用户可通过蓝色背景提示信息对会员进行相应的整合操作。', 'integrate') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：', 'integrate')  . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员整合" target="_blank">关于会员整合帮助文档</a>', 'integrate') . '</p>'
		);
		$this->assign('ur_here', __('会员整合', 'integrate'));

        $integrate_list = ecjia_integrate::integrate_list();
        $code = ecjia::config('integrate_code') == 'ecshop' ? 'ecjia' : ecjia::config('integrate_code');

		foreach ($integrate_list as & $integrate) {
            $integrate['code'] = $integrate['integrate_code'];
		    if ($integrate['code'] == $code) {
		        $integrate['activate'] = 1;
		    } else {
		        $integrate['activate'] = 0;
		    }
		}
		$this->assign('integrate_list', $integrate_list);

		$this->display('integrates_list.dwt');
	}
	
	/**
	 * 设置会员数据整合插件
	 */
	public function setup()
    {
	    $this->admin_priv('integrate_users');
	
	    $this->assign('ur_here',      __('设置会员数据整合插件', 'integrate'));
	    $this->assign('action_link',  array('text' => __('返回会员整合', 'integrate'), 'href' => RC_Uri::url('integrate/admin_plugin/init')));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('设置会员数据整合插件', 'integrate')));

	    $code = strval($_GET['code']);

	    
	    if ($code == 'ecshop' || $code == 'ecjia') {
	        $error_message = __('当您采用ECJia会员系统时，无须进行设置。', 'integrate');
	        $this->assign('error_message', $error_message);
	    } else {

            $cfg = unserialize(ecjia::config('integrate_config'));

            if ($code != 'ucenter') {
                $cfg['integrate_url'] = "http://";
            }

            $this->assign('cfg', $cfg);
        }

        $plugin_handler = ecjia_integrate::plugin()->channel($code);
	    if ( ! is_ecjia_error($plugin_handler)) {
	        $plugin_lang = $plugin_handler->loadLanguage();
        } else {
            $plugin_lang = [];
        }

	    $this->assign('code',         $code);
	    $this->assign('form_action',  RC_Uri::url('integrate/admin_plugin/save_config'));
        $this->assign('plugin_lang', $plugin_lang);
	    $this->display('integrates_setup.dwt');
	}
	
	/**
	 * 启用会员数据整合插件
	 */
	public function activate()
    {
        $this->admin_priv('integrate_users', ecjia::MSGTYPE_JSON);

		$code = strval($_GET['code']);

		if ($code == 'ucenter') {
		    ecjia_config::instance()->write_config('integrate_code', 'ucenter'); 
		} elseif ($code == 'ecshop') {
			ecjia_config::instance()->write_config('integrate_code', 'ecshop');
		} elseif ($code == 'ecjia') {
		    ecjia_config::instance()->write_config('integrate_code', 'ecjia');
		} else {
		    //如果有标记，清空标记
			$data = array(
				'flag' 	=> 0,
				'alias' => ''
			);
			RC_DB::table('users')->where('flag', '>', 0)->update($data);
			
			ecjia_config::instance()->write_config('integrate_code', $code);
		}
		ecjia_config::instance()->write_config('points_rule', '');
		
		return $this->showmessage(__('成功启用会员整合插件', 'integrate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('integrate/admin_plugin/init')));
	}
	
	/**
	 * 保存整合填写的配置资料
	 */
	public function save_config()
    {
        $this->admin_priv('integrate_users', ecjia::MSGTYPE_JSON);

		$code = strval($_POST['code']);

		if ($code != 'ecjia' && $code != 'ucenter' && $code != 'ecshop') {
		    return $this->showmessage(__('目前仅支持UCenter方式的会员整合。', 'integrate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$cfg = unserialize(ecjia::config('integrate_config'));
		$_POST['cfg']['quiet'] = 1;
		
		/* 合并数组，保存原值 */
		$cfg = array_merge($cfg, $_POST['cfg']);
		
		/* 直接保存修改 */
		if (ecjia_integrate::plugin()->saveConfigData($code, $cfg)) {
			return $this->showmessage(__('保存成功', 'integrate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {			
			return $this->showmessage(__('保存失败', 'integrate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end
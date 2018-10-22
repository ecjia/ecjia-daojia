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
class admin_integrate extends ecjia_admin {
	private $db_user;	
	private $integrate;
	
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('admin_user');
		
		$this->db_user = RC_Model::model('user/users_model');

		/* 加载所全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('integrate_list', RC_Uri::home_url('content/apps/user/statics/js/integrate_list.js'));
		
		$integrate_jslang = array(
			'home'		=>	RC_Lang::get('user::integrate.home'),
			'last_page'	=> 	RC_Lang::get('user::integrate.last_page'),
			'previous'	=> 	RC_Lang::get('user::integrate.previous'),
			'next'		=> 	RC_Lang::get('user::integrate.next'),
		);
		RC_Script::localize_script('integrate_list', 'js_lang', RC_Lang::get('user::integrate.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::integrate.member_integration'), RC_Uri::url('user/admin_integrate/init')));
	}

	/**
	 * 会员数据整合插件列表
	 */
	public function init() {
	    $this->admin_priv('integrate_users');
		
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('jquery-dataTables-sorting');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::integrate.member_integration')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' . RC_Lang::get('user::users.user_integrate_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员整合" target="_blank">'.RC_Lang::get('user::users.about_user_integrate').'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('user::integrate.member_integration'));

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
	public function setup() {
	    $this->admin_priv('integrate_users');
	
	    $this->assign('ur_here',      RC_Lang::get('user::integrate.integrate_setup'));
	    $this->assign('action_link',  array('text' => RC_Lang::get('user::integrate.back_integration'), 'href' => RC_Uri::url('user/admin_integrate/init')));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::integrate.integrate_setup')));

	    $code = strval($_GET['code']);

	    
	    if ($code == 'ecshop' || $code == 'ecjia') {
	        $error_message = RC_Lang::get('user::integrate.need_not_setup');
	        $this->assign('error_message', $error_message);
	    } else {

            $cfg = unserialize(ecjia::config('integrate_config'));

            if ($code != 'ucenter') {
                $cfg['integrate_url'] = "http://";
            }

            $this->assign('cfg', $cfg);
        }

	    $this->assign('code',         $code);
	    $this->assign('form_action',  RC_Uri::url('user/admin_integrate/save_config'));

	    $this->display('integrates_setup.dwt');
	}
	
	/**
	 * 启用会员数据整合插件
	 */
	public function activate() {
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
		
		return $this->showmessage(RC_Lang::get('user::integrate.integration_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/admin_integrate/init')));
	}
	
	/**
	 * 保存整合填写的配置资料
	 */
	public function save_config()
    {
        $this->admin_priv('integrate_users', ecjia::MSGTYPE_JSON);

		$code = strval($_POST['code']);

		if ($code != 'ecjia' && $code != 'ucenter' && $code != 'ecshop') {
		    return $this->showmessage(RC_Lang::get('user::integrate.support_UCenter'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
		
		$cfg = unserialize(ecjia::config('integrate_config'));
		$_POST['cfg']['quiet'] = 1;
		
		/* 合并数组，保存原值 */
		$cfg = array_merge($cfg, $_POST['cfg']);
		
		/* 直接保存修改 */
		if (ecjia_integrate::plugin()->saveConfigData($code, $cfg)) {
			return $this->showmessage(RC_Lang::get('user::integrate.save_ok'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
		} else {			
			return $this->showmessage(RC_Lang::get('user::integrate.save_error'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
	}
}

// end
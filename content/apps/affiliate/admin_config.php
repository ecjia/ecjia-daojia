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
 * 后台推荐设置
 * @author wutifang
 */
class admin_config extends ecjia_admin {
	private $db_shop_config;
	public function __construct() {
		parent::__construct();
		
		$this->db_shop_config = RC_Loader::load_app_model('affiliate_shop_config_model');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('affiliate', RC_App::apps_url('statics/js/affiliate.js', __FILE__));
		
		$js_lang = array(
			'ok'		=> RC_Lang::get('affiliate::affiliate.ok'),
			'cancel'	=> RC_Lang::get('affiliate::affiliate.cancel'),
		);
		RC_Script::localize_script('affiliate', 'js_lang', $js_lang);
	}
	
	/**
	 *推荐设置
	 */
	public function init() {
		$this->admin_priv('affiliate_config');
		
		RC_Style::enqueue_style('affiliate-css', RC_App::apps_url('statics/css/affiliate.css', __FILE__));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.affiliate_set')));
		
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.affiliate_set'));
		$this->assign('separate_config', RC_Lang::get('affiliate::affiliate.affiliate_set'));
		$this->assign('add_separate', RC_Lang::get('affiliate::affiliate.add_affiliate'));
		$this->assign('unit', RC_Lang::get('affiliate::affiliate.unit'));
		
		$config = unserialize(ecjia::config('affiliate'));

		$bonus_type_list = RC_Api::api('bonus', 'bonus_type_list', array('type' => 'allow_send'));

		$this->assign('bonus_type_list', $bonus_type_list);
		$this->assign('config', $config);
		$this->assign('invite_template', ecjia::config('invite_template'));
		$this->assign('invite_explain', ecjia::config('invite_explain'));
		$this->assign('current_code', 'affiliate');
		$this->assign('form_action', RC_Uri::url('affiliate/admin_config/update'));
		
		$this->display('affiliate_config.dwt');
	}
	
	/**
	 * 修改配置
	 */
	public function update() {
		$this->admin_priv('affiliate_config', ecjia::MSGTYPE_JSON);

		$config = unserialize(ecjia::config('affiliate'));

		$separate_by 		= isset($_POST['separate_by']) 		? intval($_POST['separate_by']) 	: $config['config']['separate_by'];
		$expire_unit 		= isset($_POST['expire_unit']) 		? $_POST['expire_unit'] 			: $config['config']['expire_unit'];
		$invite_template	= isset($_POST['invite_template']) 	? trim($_POST['invite_template']) 	: '';
		$invite_explain		= isset($_POST['invite_explain']) 	? $_POST['invite_explain'] 			: '';
		
		$_POST['expire'] 			= (float)$_POST['expire'];
		$_POST['level_point_all'] 	= (float)$_POST['level_point_all'];
		$_POST['level_money_all'] 	= (float)$_POST['level_money_all'];
		$_POST['level_money_all'] 	> 100 && $_POST['level_money_all'] = 100;
		$_POST['level_point_all'] 	> 100 && $_POST['level_point_all'] = 100;
		
		if (!empty($_POST['level_point_all']) && strpos($_POST['level_point_all'], '%') === false) {
			$_POST['level_point_all'] .= '%';
		}
		if (!empty($_POST['level_money_all']) && strpos($_POST['level_money_all'], '%') === false) {
			$_POST['level_money_all'] .= '%';
		}
		$_POST['level_register_all']			= intval($_POST['level_register_all']);
		$_POST['level_register_up']				= intval($_POST['level_register_up']);

		$temp = array();
		$temp['on'] = (intval($_POST['on']) == 1) ? 1 : 0;
		
		if ($temp['on'] == 1) {
			$temp['config'] = array(
				'expire'                		=> $_POST['expire'],             //COOKIE过期数字
				'expire_unit'           		=> $expire_unit,        		 //单位：小时、天、周
				'separate_by'           		=> $separate_by,                 //分成模式：0、注册 1、订单
				'level_point_all'       		=> $_POST['level_point_all'],    //积分分成比
				'level_money_all'       		=> $_POST['level_money_all'],    //金钱分成比
				'level_register_all'    		=> intval($_POST['level_register_all']), //推荐注册奖励积分
				'level_register_up'     		=> intval($_POST['level_register_up']),  //推荐注册奖励积分上限
			);
			
			/* 邀请人奖励*/
			$intive_reward_by	= trim($_POST['intive_reward_by']) == 'orderpay' ? 'orderpay' : 'signup';
			$intive_reward_type = trim($_POST['intive_reward_type']);
			if ($intive_reward_type == 'bonus') {
				$intive_reward_value = intval($_POST['intive_reward_type_bonus']);
			} elseif ($intive_reward_type == 'integral') {
				$intive_reward_value = intval($_POST['intive_reward_type_integral']);
			} else {
				$intive_reward_value = trim($_POST['intive_reward_type_balance']);
			}
			
			/* 受邀人奖励*/
			$intivee_reward_by	= trim($_POST['intivee_reward_by']) == 'orderpay' ? 'orderpay' : 'signup';
			$intivee_reward_type = trim($_POST['intivee_reward_type']);
			if ($intivee_reward_type == 'bonus') {
				$intivee_reward_value = intval($_POST['intivee_reward_type_bonus']);
			} elseif ($intivee_reward_type == 'integral') {
				$intivee_reward_value = intval($_POST['intivee_reward_type_integral']);
			} else {
				$intivee_reward_value = trim($_POST['intivee_reward_type_balance']);
			}
			
			$temp['intvie_reward'] = array(
				'intive_reward_by'		=> $intive_reward_by,
				'intive_reward_type'	=> $intive_reward_type,
				'intive_reward_value'	=> $intive_reward_value
			);
			
			$temp['intviee_reward'] = array(
				'intivee_reward_by'		=> $intivee_reward_by,
				'intivee_reward_type'	=> $intivee_reward_type,
				'intivee_reward_value'	=> $intivee_reward_value
			);
			
		} else {
			$temp['config'] = !empty($config['config']) ? $config['config'] : '';
		}
		
		$temp['item'] = !empty($config['item']) ? $config['item'] : array();
		
		ecjia_config::instance()->write_config('affiliate', serialize($temp));
		ecjia_config::instance()->write_config('invite_template', $invite_template);
		ecjia_config::instance()->write_config('invite_explain', $invite_explain);
		ecjia_admin::admin_log(RC_Lang::get('system::system.affiliate'), 'edit', 'config');
		
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('affiliate/admin_config/init')));
	}
}

//end
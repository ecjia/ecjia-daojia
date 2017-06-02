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
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_userbind_bind_init implements platform_interface {
	//加载绑定页面 新用户 or 已有账号
    public function action() {
        $css_url = RC_Plugin::plugins_url('css/wechat_redirect.css', __FILE__);
    	$jq_url = RC_Plugin::plugins_url('js/jquery.js', __FILE__);
    	ecjia_front::$controller->assign('jq_url',$jq_url);
    	ecjia_front::$controller->assign('css_url',$css_url);
    	ecjia_front::$controller->assign_lang();
    	
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	RC_Loader::load_app_class('wechat_user', 'wechat', false);
    	$termmeta_db = RC_Loader::load_app_model('term_meta_model','wechat');
    	$bonustype_db  = RC_Loader::load_app_model('bonus_type_model','bonus');
    	$platform_config = RC_Loader::load_app_model('platform_config_model','platform');
    	$connect_db = RC_Loader::load_app_model('connect_user_model', 'connect');
    	$user_db = RC_Loader::load_app_model('users_model', 'user');
    	
        $tplpath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/wechat_redirect.dwt.php';
        $tplsuccesspath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/wechat_bind_success.dwt.php';

        $openid = trim($_GET['openid']);
        $uuid = trim($_GET['uuid']);

        $account = platform_account::make($uuid);
        $wechat_id = $account->getAccountID();
        $wechat_name = $account->getAccountName();
        
        $wechat_user = new wechat_user($wechat_id, $openid);
        $unionid = $wechat_user->getUnionid();
        $user_id = $connect_db->where(array('open_id' => $unionid))->get_field('user_id');
        $user = $user_db->field('user_name, rank_points')->find(array('user_id' => $user_id));
        if (empty($user_id)) {
        	$signup_url = RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_signup', 'openid' => $openid, 'uuid' => $uuid));
        	$signin_url = RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_login', 'openid' => $openid, 'uuid' => $uuid));
        	ecjia_front::$controller->assign('wechat_name', $wechat_name);
        	ecjia_front::$controller->assign('signup_url', $signup_url);
        	ecjia_front::$controller->assign('signin_url', $signin_url);
        	ecjia_front::$controller->display($tplpath);
        } else {
        	$meta_value = $termmeta_db->where(array('object_id' => $user_id,'object_type' => 'ecjia.user','meta_key' => 'user_first_change_pwd'))->get_field('meta_value');
        	if(empty($meta_value) || $meta_value === 0) {
        		ecjia_front::$controller->assign('one','one');
        	}
        	$info = $platform_config->find(array('account_id' => $wechat_id,'ext_code'=>'mp_userbind'));
        	if (!empty($info)) {
        		// 配置信息
        		$config = array();
        		$config = unserialize($info['ext_config']);
        		foreach ($config as $k => $v) {
            		if ($v['name'] == 'point_status') {
            			$point_status = $v['value'];
            		}
            		if ($v['name'] == 'point_value') {
            			$point_value = $v['value'];
            		}
            		if ($v['name'] == 'bonus_status') {
            			$bonus_status = $v['value'];
            		}
            		if ($v['name'] == 'bonus_id') {
            			$bonus_id = $v['value'];
            		}
            	}
        	
        		if (isset($point_status) && $point_status == 1) {
        			ecjia_front::$controller->assign('point_value', $point_value);
        		}
        		if (isset($bonus_status) && $bonus_status == 1) {
        			$type_money = $bonustype_db->where(array('type_id' => $bonus_id))->get_field('type_money');
        			ecjia_front::$controller->assign('type_money', $type_money);
        		}
        	}
			ecjia_front::$controller->assign('form_action',RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_password', 'openid' => $openid, 'uuid' => $uuid)));
			ecjia_front::$controller->assign('username', $user['user_name']);
			ecjia_front::$controller->display($tplsuccesspath);
		}
	}
}

// end
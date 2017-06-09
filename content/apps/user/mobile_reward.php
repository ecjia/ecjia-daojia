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

class mobile_reward extends ecjia_front {
	public function __construct() {	
		parent::__construct();	
		
  		/* js与css加载路径*/
  		$this->assign('front_url', RC_App::apps_url('statics/front', __FILE__));
  		$this->assign('title', '新人有礼');
	}
	
	public function init() {
		$token = isset($_GET['token']) ? trim($_GET['token']) : '';
		setcookie("ecjia_token", $token);
		
		$mobile_signup_reward_notice = ecjia::config('mobile_signup_reward_notice');

		$mobile_signup_reward_notice = nl2br($mobile_signup_reward_notice);

		$this->assign('mobile_signup_reward_notice', $mobile_signup_reward_notice);
		$this->assign('token', $token);
		
	    $this->display(
	        RC_Package::package('app::user')->loadTemplate('front/reward.dwt', true)
	    );
	}
	
	public function recieve() {
		$token = isset($_POST['token']) ? trim($_POST['token']) : '';
		
		$need_login = false;
		if (!isset($_SESSION['user_id']) || !$_SESSION['user_id']) {
		    $need_login = true;
		}
		/* 新人有礼的红包id*/
		$bonus_id = ecjia::config('mobile_signup_reward');
		if ($bonus_id) {
		    $bonus_info = RC_DB::table('bonus_type')->where('type_id', $bonus_id)->first();
		}
		
// 		if ($bonus_info['use_start_date'] < RC_Time::gmtime() && $bonus_info['use_end_date'] > RC_Time::gmtime()) {
// 		    ecjia_front::$controller->showmessage('不在活动时间内！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => RC_Uri::url('touch/my/init')));
// 		}
		
		$is_received = RC_DB::table('term_meta')->where('object_type', 'ecjia.user')->where('object_group', 'user')->where('object_id', $_SESSION['user_id'])
		  ->where('meta_key', 'signup_reward_receive_time')->count();
		
		/* 判断是否是ecjia设备扫描*/
		// 		ECJiaBrowse/1.2.0
		if(!preg_match('/ECJiaBrowse/', $_SERVER['HTTP_USER_AGENT'])) {
		    if ($need_login) {
		        ecjia_front::$controller->showmessage('您还未登录，请先登录！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => RC_Uri::url('user/privilege/login')));
		    }
		    
		    /* 新人有礼的红包id*/
		    if (!$bonus_id) {
		        ecjia_front::$controller->showmessage('活动未开始！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => RC_Uri::url('touch/my/init')));
		    }
		    
		    if (!empty($is_received)) { 
		        ecjia_front::$controller->showmessage('你已领取过！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => RC_Uri::url('touch/index/init')));
		    }
		    
		    $this->send_bonus($_SESSION['user_id'], $bonus_id);
		    
		    ecjia_front::$controller->showmessage('发放成功！', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('url' => RC_Uri::url('user/bonus/init'), 'close_url' => RC_Uri::url('touch/index/init')));
		    
		} else {
		    if ($need_login) {
		        ecjia_front::$controller->showmessage('您还未登录，请先登录！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => 'ecjiaopen://app?open_type=signin'));
		    }
		    
		    /* 新人有礼的红包id*/
		    if (!$bonus_id) {
		        ecjia_front::$controller->showmessage('活动未开始！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		    }
		    
		    if (!empty($is_received)) {
		        ecjia_front::$controller->showmessage('您已领取过！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		    }
		    
		    // 		$user_info = RC_Model::model('user/users_model')->where(array('user_id' => $_SESSION['user_id']))->find();
		    // 		$reg_time = $user_info['reg_time']+2592000;//默认30天时间
		    // 		if (empty($user_info['reg_time']) || $reg_time < RC_Time::gmtime()) {
		    // 			ecjia_front::$controller->showmessage('您已过了领取时间！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		    // 		}
		    
		    $this->send_bonus($_SESSION['user_id'], $bonus_id);
		    
		    ecjia_front::$controller->showmessage('发放成功！', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('url' => 'ecjiaopen://app?open_type=user_bonus&type=usable'));
		}
		
	}
	
	private function send_bonus($user_id, $bonus_id) {
	    RC_Model::model('bonus/user_bonus_model')->insert(array(
    	    'user_id'		=> $user_id,
    	    'bonus_type_id' => $bonus_id,
	    ));
	    
	    //存储 领取时间
	    $data = array(
	        'object_type' => 'ecjia.user',
	        'object_group' => 'user',
	        'object_id' => $user_id,
	        'meta_key' => 'signup_reward_receive_time',
	        'meta_value' => RC_Time::gmtime()
	    );
	    RC_DB::table('term_meta')->insert($data);
	}
	
	
	
}

// end
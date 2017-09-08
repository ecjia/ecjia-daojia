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


class mobile_profile extends ecjia_front {
    
    public function __construct() {
        parent::__construct();
        
        RC_Loader::load_app_class('platform_account', 'platform', false);
        RC_Loader::load_app_class('wechat_user', 'wechat', false);
        
        $this->assign('front_url', RC_App::apps_url('statics/front', __FILE__));
        $this->assign('system_statics_url', RC_Uri::admin_url('statics'));      
    }
    
    public function init() {
    	$openid = trim($_GET['openid']);
    	$uuid   = trim($_GET['uuid']);
    	$account     = platform_account::make($uuid);
    	$wechat_id   = $account->getAccountID();
    	$wechat_user = new wechat_user($wechat_id, $openid);
    	$unionid     = $wechat_user->getUnionid();
 
    	$connect_user  = new \Ecjia\App\Connect\ConnectUser('sns_wechat', $unionid, 'user');
    	$user_id = $connect_user->getUserId();
    	$_SESSION['wechat_user_id'] = $user_id;
    	$_SESSION['wechat_open_id']  = $openid;
    	$_SESSION['wechat_uuid']    = $uuid;
    	$user_info = RC_DB::table('users')->where('user_id', $user_id)->select('user_name', 'email', 'mobile_phone', 'user_rank')->first();
    
    	$db_user_rank = RC_Model::model('user/user_rank_model');
    	if ($user_info['user_rank'] == 0) {
    		// 非特殊等级，根据等级积分计算用户等级（注意：不包括特殊等级）
    		$row = $db_user_rank->field('rank_id, rank_name')->find(array('special_rank' => 0 , 'min_points' => array('elt' => intval($user_info['rank_points'])) , 'max_points' => array('gt' => intval($user_info['rank_points']))));
    	} else {
    		// 特殊等级
    		$row = $db_user_rank->field('rank_id, rank_name')->find(array('rank_id' => $user_info[user_rank]));
    	}
    	$user_info['user_rank_name'] = $row['rank_name'];
    	$user_info['user_rank_id']   = $row['rank_id'];
    	$user_info['wechat_image'] = $wechat_user->getImage();
    	$this->assign('user_info', $user_info);
    	
    	$this->assign('icon_wechat_user', RC_App::apps_url('statics/front/images/icon_wechat_user.png', __FILE__));
        $this->display(
            RC_Package::package('app::wechat')->loadTemplate('front/bind_user_profile.dwt', true)
        );
    }
   
    //重设密码--校验验证码页面加载
    public function reset_get_code() {
    	$mobile = $_GET['mobile'];
    	$this->assign('mobile', $mobile);
    	
    	$this->display(
    		RC_Package::package('app::wechat')->loadTemplate('front/reset_get_code.dwt', true)
    	);
    }
    
    //获取验证码请求处理
    public function get_code() { 
    	$mobile = $_POST['mobile'];
    	$code = rand(100000, 999999);
    	$options = array(
    		'mobile' => $mobile,
    		'event'	 => 'sms_get_validate',
    		'value'  =>array(
    			'code' 			=> $code,
    			'service_phone' => ecjia::config('service_phone'),
    		),
    	);
    	$response = RC_Api::api('sms', 'send_event_sms', $options);

    	$_SESSION['temp_code'] 	= $code;
    	$_SESSION['temp_code_time'] = RC_Time::gmtime();
    	if (!is_ecjia_error($response)) {
    		return ecjia_front::$controller->showmessage("短信已发送到手机".$mobile."，请注意查看", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    	} else {
    		return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    //获取验证码进行下一步设置密码
    public function next_pwd() {
    	$code = $_POST['code'];
    	$time = RC_Time::gmtime() - 6000*3;
    	if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
    		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('wechat/mobile_profile/reset_pwd')));
    	}else{
    		return ecjia_front::$controller->showmessage('请输入正确的手机校验码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    //加载重置密码模板
    public function reset_pwd() {
    	$this->display(
    		 RC_Package::package('app::wechat')->loadTemplate('front/reset_pwd.dwt', true)
    	);
    }
    
    //处理重置密码逻辑
    public function reset_pwd_update(){
    	$password = trim($_POST['password']);
    	$confirm_password  = trim($_POST['confirm_password']);
    	
    	if ($password =='' || $confirm_password== '') {
    		return ecjia_front::$controller->showmessage('密码不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	if ($password != $confirm_password) {
    		return ecjia_front::$controller->showmessage('新密码和确认密码须保持一致', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$result = RC_Api::api('user', 'edit_user', array('new_password' => $password, 'user_id' => $_SESSION['wechat_user_id']));
    	if ($result) {
    		RC_DB::table('users')->where('user_id', $_SESSION['wechat_user_id'])->update(array('ec_salt'=> 0));
    		return ecjia_front::$controller->showmessage('密码重设成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('wechat/mobile_profile/init', array('openid' => $_SESSION['wechat_open_id'], 'uuid' => $_SESSION['wechat_uuid']))));
    	} else {
    		return ecjia_front::$controller->showmessage('密码重设失败!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    //用户中心绑定手机号模板加载
    public function bind_mobile() {
    	$this->display(
    		RC_Package::package('app::wechat')->loadTemplate('front/bind_mobile.dwt', true)
    	);
    }
    
    
    //绑定手机号逻辑处理
    public function bind_mobile_update() {
    	$code = $_POST['code'];
    	$time = RC_Time::gmtime() - 6000*3;
    	$mobile = $_POST['mobile'];
    	if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
    		$mobile_phone = RC_DB::table('users')->where('mobile_phone', $mobile)->where('user_id','!=',$_SESSION['wechat_user_id'])->pluck('mobile_phone');
    		if (!empty($mobile_phone)) {
    			return ecjia_front::$controller->showmessage('该手机号已被注册', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		} else {
    			RC_DB::table('users')->where('user_id', $_SESSION['wechat_user_id'])->update(array('mobile_phone'=> $mobile));
    			return ecjia_front::$controller->showmessage('绑定手机号成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('wechat/mobile_profile/init', array('openid' => $_SESSION['wechat_open_id'], 'uuid' => $_SESSION['wechat_uuid']))));
    		}
    	}else{
    		return ecjia_front::$controller->showmessage('请输入正确的手机校验码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
}
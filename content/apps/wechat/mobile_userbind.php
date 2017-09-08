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


class mobile_userbind extends ecjia_front {
    
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
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	$wechat_user = new wechat_user($wechat_id, $openid);
    	$unionid     = $wechat_user->getUnionid();
    	$data['wechat_image'] 	 = $wechat_user->getImage();
    	$data['wechat_nickname'] = $wechat_user->getNickname();
    	
    	$connect_user  = new \Ecjia\App\Connect\ConnectUser('sns_wechat', $unionid, 'user');
    	if ($connect_user->checkUser()) {
    		return $this->redirect(RC_Uri::url('wechat/mobile_profile/init', array('openid' => $openid, 'uuid' => $uuid)));
    	}

    	$data['register_url'] = RC_Uri::url('wechat/mobile_userbind/register', array('uuid' => $uuid, 'openid' => $openid));
        $data['bind_url']  = RC_Uri::url('wechat/mobile_userbind/bind_login', array('uuid' => $uuid, 'openid' => $openid));
        $this->assign('data', $data);

        $this->display(
            RC_Package::package('app::wechat')->loadTemplate('front/bind.dwt', true)
        );
    }

    //注册登录
    public function register() {
    	$openid = trim($_GET['openid']);
    	$uuid   = trim($_GET['uuid']);
    	
    	$account     = platform_account::make($uuid);
    	$wechat_id   = $account->getAccountID();
    	$wechat_user = new wechat_user($wechat_id, $openid);
    	$username    = $wechat_user->getNickname();
    	$unionid     = $wechat_user->getUnionid();
    	$sex         = $wechat_user->sex();
    	$user_profile = $wechat_user->getWechatUser();
    	
    	$connect_user  = new \Ecjia\App\Connect\ConnectUser('sns_wechat', $unionid, 'user');
    	$connect_user->saveOpenId('', '', serialize($user_profile), 7200);
        /*创建用户*/
		$username = $connect_user->getGenerateUserName();
		$password = $connect_user->getGeneratePassword();
		$email    = $connect_user->getGenerateEmail();
		
        $user_info = RC_Api::api('user', 'add_user', array('username' => $username, 'password' => $password, 'email' => $email, 'sex' => $sex, 'reg_time' => RC_Time::gmtime()));
       
        if (is_ecjia_error($user_info)) {
        	return ecjia_front::$controller->showmessage($user_info->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
        	//绑定用户
        	$result = $connect_user->bindUser($user_info['user_id']);
        	if ($result) {
        		$info = RC_DB::table('platform_config')->where('account_id', $wechat_id)->where('ext_code', 'mp_userbind')->first();
        		$getUserId = $user_info['user_id'];
        		
        		// 积分/红包赠送
        		$this->give_point($openid, $info, $getUserId);
        		
        		return $this->redirect(RC_Uri::url('wechat/mobile_profile/init', array('user_id' => $user_info['user_id'], 'openid' => $openid, 'uuid' => $uuid)));
        	} else {
        		return ecjia_front::$controller->showmessage('绑定用户失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
        }
    }
    
    //已有账号绑定
    public function bind_login() {
    	$openid = trim($_GET['openid']);
    	$uuid   = trim($_GET['uuid']);
    	$this->assign('openid', $openid);
    	$this->assign('uuid', $uuid);
    	
    	$this->display(
    		RC_Package::package('app::wechat')->loadTemplate('front/bind_signin.dwt', true)
    	);
    }
    
    //已有账号绑定
    public function bind_login_insert() {
    	$openid 	= trim($_POST['openid']);
    	$uuid   	= trim($_POST['uuid']);
    	$user_name  = trim($_POST['username']);
    	$password   = trim($_POST['password']);
    	
    	$account   = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	$wechat_user = new wechat_user($wechat_id, $openid);
    	$unionid     = $wechat_user->getUnionid();
    	$user_profile = $wechat_user->getWechatUser();
    	
    	if (empty($user_name)) {
    		return ecjia_front::$controller->showmessage('用户名不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	if (empty($password)) {
    		return ecjia_front::$controller->showmessage('密码不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	//判断已绑定用户
    	$row = RC_DB::table('users')->where('user_name', $user_name)->first();
    	if ($row) {
    		if (!empty($row['ec_salt'])) {
    			if (!($row['user_name'] == $user_name && $row['password'] == md5(md5($password) . $row['ec_salt']))) {
    				return ecjia_front::$controller->showmessage('您输入账号信息不正确，绑定失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    		} else {
    			if (!($row['user_name'] == $user_name && $row['password'] == md5($password))) {
    				return ecjia_front::$controller->showmessage('您输入账号信息不正确，绑定失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    		}
    		
    		$connect_user = new \Ecjia\App\Connect\ConnectUser('sns_wechat', $unionid, 'user');
    		$connect_user->saveOpenId('', '', serialize($user_profile), 7200);
    		
    		$result = $connect_user->bindUser($row['user_id']);
    		if ($result) {
    			// 积分/红包赠送
    			$getUserId = $row['user_id'];
    			$info = RC_DB::table('platform_config')->where('account_id', $wechat_id)->where('ext_code', 'mp_userbind')->first();
    			$this->give_point($openid, $info, $getUserId);
    			
    			return ecjia_front::$controller->showmessage('恭喜您，关联成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('wechat/mobile_profile/init', array('openid' => $openid, 'uuid' => $uuid))));
    		} else {
    			return ecjia_front::$controller->showmessage('抱歉，关联失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}

    		$_SESSION['user_id']   = $row['user_id'];
    		$_SESSION['user_name'] = $row['user_name'];
    		$_SESSION['email']     = $row['email'];
    		$_SESSION['last_ip']   = RC_Ip::client_ip();
    		$_SESSION['last_time'] = RC_Time::gmtime();
    		$data = array(
    			'last_login' => RC_Time::gmtime(),
    			'last_ip'    => RC_Ip::client_ip()
    		);
    		RC_DB::table('users')->where('user_id', $row['user_id'])->update($data);
    	} else {
    		return ecjia_front::$controller->showmessage('您输入账号信息不正确，绑定失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}	
    }
    
    
    /**
     * 积分赠送
     */
    public function give_point($openid, $info, $getUserId) {
    	if (!empty($info)) {
    		//插件配置信息
    		$config = array();
    		$config = unserialize($info['ext_config']);
    		foreach ($config as $k => $v) {
    			if ($v['name'] == 'point_status') {
    				$point_status = $v['value'];
    			}
    			if ($v['name'] == 'point_interval') {
    				$point_interval = $v['value'];
    			}
    			if ($v['name'] == 'point_num') {
    				$point_num = $v['value'];
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
    		
    		// 开启积分赠送
    		if (isset($point_status) && $point_status == 1) {
    			$wechat_point_db = RC_Loader::load_app_model('wechat_point_model', 'wechat');
    			$where = 'openid = "' . $openid . '" and createtime > (UNIX_TIMESTAMP(NOW())- ' .$point_interval . ') and keywords = "'.$info['ext_code'].'" ';
    			$num = $wechat_point_db->where($where)->count('*');
    			if ($num < $point_num) {
    				$this->do_point($openid, $info, $point_value, $getUserId);
    			}
    		}

    		//开启赠送红包
    		if (isset($bonus_status) && $bonus_status == 1) {
    			$data['bonus_type_id'] = $bonus_id;
    			$data['bonus_sn'] = 0;
    			$data['user_id'] = $getUserId;
    			$data['used_time'] = 0;
    			$data['order_id'] = 0;
    			$data['emailed'] = 0;
    			RC_DB::table('user_bonus')->insertGetId($data);
    		}
    	}
    }
    
    /**
     * 执行赠送积分
     */
    public function do_point($openid, $info, $point_value, $getUserId) {
    	$rank_points = RC_DB::TABLE('users')->where('user_id', $getUserId)->pluck('rank_points');
    	$count_points = intval($rank_points) + intval($point_value);
    	$point = array(
    		'rank_points' => $count_points
    	);
    	RC_DB::table('users')->where('user_id', $getUserId)->update($point);
    	// 积分记录
    	$data['user_id']      =  $getUserId;
    	$data['user_money']   =  0;
    	$data['frozen_money'] =  0;
    	$data['rank_points']  =  $point_value;
    	$data['pay_points']   =  0;
    	$data['change_time']  =  RC_Time::gmtime();
    	$data['change_desc']  = '绑定积分赠送';
    	$data['change_type']  =  ACT_OTHER;
    	$log_id = RC_DB::table('account_log')->insertGetId($data);
    	 
    	// 从表记录
    	$data1['log_id']     = $log_id;
    	$data1['openid']     = $openid;
    	$data1['keywords']   = $info['ext_code'];
    	$data1['createtime'] = RC_Time::gmtime();
    	RC_DB::table('wechat_point')->insertGetId($data1);
    }
}
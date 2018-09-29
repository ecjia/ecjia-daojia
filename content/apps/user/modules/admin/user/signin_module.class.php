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
 * 管理员登录
 * @author will
 */
class admin_user_signin_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		
		$username	= $this->requestData('username');
		$password	= $this->requestData('password');
		$device		= $this->requestData('device', array());
		if (empty($username) || empty($password)) {
			$result = new ecjia_error('login_error', __('您输入的帐号信息不正确。'));
			return $result;
		}

		//$db_user = RC_Model::model('user/admin_user_model');
		/* 收银台请求判断处理*/
		$codes = array('8001', '8011');
		//if (!empty($device) && is_array($device) && in_array($device['code'], $codes)) {
		//	$adviser_info = RC_Model::model('achievement/adviser_model')->find(array('username' => $username));
		//	if (empty($adviser_info)) {
		//		$result = new ecjia_error('login_error', __('您输入的帐号信息不正确。'));
		//		return $result;
		//	}
		//	$admin_info = $db_user->field(array('user_name', 'ec_salt'))->find(array('user_id' => $adviser_info['admin_id']));
		//	$username	= $admin_info['user_name'];
		//	$ec_salt	= $admin_info['ec_salt'];
		//} else {
			//$ec_salt = $db_user->where(array('user_name' => $username))->get_field('ec_salt');
			$ec_salt = RC_DB::table('admin_user')->where('user_name', $username)->pluck('ec_salt');
		//}
		
	
		/* 检查密码是否正确 */
		if (!empty($ec_salt)) {
			//$row = $db_user->field('user_id, user_name, email, password, last_login, action_list, last_login, suppliers_id, ec_salt, seller_id, role_id, ru_id')
			//			->find(array('user_name' => $username, 'password' => md5(md5($password).$ec_salt)));
			$row = RC_DB::table('admin_user')->where('user_name', $username)->where('password', md5(md5($password).$ec_salt))->select('user_id', 'user_name', 'email', 'password', 'last_login', 'action_list', 'suppliers_id', 'ec_salt', 'role_id')->first();
		} else {
			//$row = $db_user->field('user_id, user_name, email, password, last_login, action_list, last_login, suppliers_id, ec_salt, seller_id, role_id, ru_id')
			//			->find(array('user_name' => $username, 'password' => md5($password)));
			$row = RC_DB::table('admin_user')->where('user_name', $username)->where('password', md5($password))->select('user_id', 'user_name', 'email', 'password', 'action_list', 'last_login', 'suppliers_id', 'ec_salt', 'role_id')->first();
		}
		
		if ($row) {
			// 登录成功
			/* 设置session信息 */
			$_SESSION['admin_id']	        = $row['user_id'];
			$_SESSION['admin_name']	        = $row['user_name'];
			$_SESSION['action_list']	    = $row['action_list'];
			$_SESSION['last_check_order']	= $row['last_login'];
			$_SESSION['suppliers_id']	    = $row['suppliers_id'];
			
			if (!empty($row['seller_id'])) {
				$_SESSION['seller_id']	= $row['seller_id'];
			}
			
			/* 获取device_id*/
			//$device_id = RC_Model::model('mobile/mobile_device_model')->where(array('device_udid' => $device['udid'], 'device_client' => $device['client'], 'device_code' => $device['code']))->get_field('id');
			$device_id = RC_DB::table('mobile_device')
								->where('device_udid', $device['udid'])
								->where('device_client', $device['client'])
								->where('device_code', $device['code'])
								->pluck('id');
			$_SESSION['device_id']	= $device_id;

			$codes = array('8001', '8011');
			if (in_array($device['code'], $codes)) {
				$_SESSION['adviser_id']	= $row['id'];
				$_SESSION['seller_id']	= $row['seller_id'];
				$_SESSION['admin_name']	= $row['username'];
			}
			
			if (empty($row['ec_salt'])) {
				$ec_salt = rand(1, 9999);
				$new_possword = md5(md5($this->requestData('password')) . $ec_salt);
				$data = array(
						'ec_salt'	=> $ec_salt,
						'password'	=> $new_possword
				);
				//$db_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);
				RC_DB::table('admin_user')->where('user_id', $_SESSION['admin_id'])->update($data);
			}
		
			if ($row['action_list'] == 'all' && empty($row['last_login'])) {
				$_SESSION['shop_guide'] = true;
			}
		
			$data = array(
					'last_login' 	=> RC_Time::gmtime(),
					'last_ip'		=> RC_Ip::client_ip(),
			);
			//$db_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);
			RC_DB::table('admin_user')->where('user_id', $_SESSION['admin_id'])->update($data);
			
			$out = array(
					'session' => array(
						'sid' => RC_Session::session_id(),
						'uid' => $_SESSION['admin_id']
					),
			);
			$db_role = RC_Loader::load_model('role_model');
			$role_name = $db_role->where(array('role_id' => $row['role_id']))->get_field('role_name');
			
			$out['userinfo'] = array(
					'id' 			=> $row['user_id'],
					'username'		=> $row['user_name'],
					'email'			=> $row['email'],
					'last_login' 	=> RC_Time::local_date(ecjia::config('time_format'), $row['last_login']),
					'last_ip'		=> RC_Ip::area($row['last_ip']),
					'role_name'		=> !empty($role_name) ? $role_name : '',
					'avator_img'	=> RC_Uri::admin_url('statics/images/admin_avatar.png'),
			);
			
			if (in_array($device['code'], $codes)) {
				$out['userinfo']['username'] = $adviser_info['username'];
				$out['userinfo']['email']	 = $adviser_info['email'];
			}
			
			//修正关联设备号
			$result = ecjia_app::validate_application('mobile');
			if (!is_ecjia_error($result)) {
				$device = $this->requestData('device', array());
				if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
					//$db_mobile_device = RC_Model::model('mobile/mobile_device_model');
					//$device_data = array(
					//		'device_udid'	=> $device['udid'],
					//		'device_client'	=> $device['client'],
					//		'device_code'	=> $device['code']
					//);
					RC_DB::table('mobile_device')->where('device_udid', $device['udid'])->where('device_client', $device['client'])->where('device_code', $device['code'])->update(array('user_id' => $_SESSION['admin_id'], 'is_admin' => 1));
				}
			}
			
			return $out;
		} else {
			$result = new ecjia_error('login_error', __('您输入的帐号信息不正确。'));
			return $result;
		}
	    
	}
}

// end
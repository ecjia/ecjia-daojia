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
 * 二维码登录验证
 * @author will.chen
 */
class validate_module extends api_front implements api_interface {

	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();	
		
		$code = $this->requestData('code');
		if (empty($code)) {
			return new ecjia_error(101, '参数错误');
		}
		$db = RC_Model::model('mobile/qrcode_validate_model');
		
        if ($_SESSION['user_id'] > 0  || $_SESSION['admin_id'] > 0) {
        	$result = $db->find(array('uuid' => $code));
        	/* 已过期*/
	        if ($result['status'] != 1) {
				return array('code_status' => 104, 'message' => '二维码已过期！');
			} else {
				$device_name = array('8001' => '收银台', '1006' => 'TV');
				$message     = ecjia::config('shop_name').$device_name[$result['device_code']].'请求登录，是否授权？';
				return array('code_status' => 101, 'message' => $message);
			}
        }
		
		$device	= $this->device;
		$where  = array(
				'uuid'		    => $code,
				'device_udid'   => $device['udid'],
				'device_client' => $device['client'],
				'device_code'	=> $device['code'],
				'expires_in'    => array('gt' => RC_Time::gmtime()), 
		);
		$result = $db->find($where);
		
		
		if ($result['status'] == 2) {
			/* 管理员登陆*/
			if ($result['is_admin']) {
				$userinfo = admin_login($result['user_id']);
			} else {
				$userinfo = user_login($result['user_id']);
			} 
			if (empty($userinfo)) {
				return array('code_status' => 104);
			}
			/* 更改二维码状态：设为失效*/
			$db->where($where)->update(array('status' => 3));
			$userinfo['code_status'] = 102;
			$userinfo['message']     = '';
			return $userinfo;
		} elseif ($result['status'] == 0) {
			return array('code_status' => 100, 'message' => '');
		} elseif ($result['status'] == 1) {
			return array('code_status' => 101, 'message' => '');
		}else {
			return array('code_status' => 104, 'message' => '');
		}
		
	}
}

function user_login($uid) {
	
	RC_Loader::load_app_func('admin_user','user');
	RC_Loader::load_app_func('cart','cart');
	$user_info = EM_user_info($uid);
	if (empty($user_info)) {
		return array();
	}
	RC_Session::set('user_id', $row['user_id']);
	RC_Session::set('user_name', $row['user_name']);
	RC_Session::set('email', $row['email']);
	
	$user = array(
			'session' => array(
					'sid' => RC_Session::session_id(),
					'uid' => $_SESSION['user_id']
			),
	
			'user'   => $user_info
	);
	define('SESS_ID', RC_Session::session_id());
	update_user_info();
	recalculate_price();
	
	//修正咨询信息
	if($_SESSION['user_id'] > 0) {
		$device           = $this->requestData('device', array());
		$device_id        = $device['udid'];
		$device_client    = $device['client'];
		$db_term_relation = RC_Model::model('goods/term_relationship_model');
			
		$object_id = $db_term_relation->where(array(
				'object_type'	=> 'ecjia.feedback',
				'object_group'	=> 'feedback',
				'item_key2'		=> 'device_udid',
				'item_value2'	=> $device_id ))
				->get_field('object_id', true);
		//更新未登录用户的咨询
		$db_term_relation->where(array('item_key2' => 'device_udid', 'item_value2' => $device_id))->update(array('item_key2' => '', 'item_value2' => ''));
			
		if(!empty($object_id)) {
			$db = RC_Model::model('feedback/feedback_model');
			$db->where(array('msg_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name']));
			$db->where(array('parent_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name']));
		}
		
		//修正关联设备号
		$result = ecjia_app::validate_application('mobile');
		if (!is_ecjia_error($result)) {
			if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
				$db_mobile_device = RC_Model::model('mobile/mobile_device_model');
				$device_data = array(
						'device_udid'	=> $device['udid'],
						'device_client'	=> $device['client'],
						'device_code'	=> $device['code']
				);
				$db_mobile_device->where($device_data)->update(array('user_id' => $_SESSION['user_id']));
			}
		}
	}
	return $user;
}

function admin_login($uid)
{
	$db_admin_user = RC_Loader::load_sys_model('admin_user_model');
	$row           = $db_admin_user->find(array('user_id' => $uid));
	if (empty($row)) {
		return array();
	}
	RC_Session::set('admin_id', $row['user_id']);
	RC_Session::set('admin_name', $row['user_name']);
	RC_Session::set('action_list', $row['action_list']);
	RC_Session::set('last_check_order', $row['last_login']);// 用于保存最后一次检查订单的时间
	RC_Session::set('suppliers_id', $row['suppliers_id']);
	RC_Session::set('action_list', $row['action_list']);
	if (!empty($row['ru_id'])) {
		RC_Session::set('ru_id', $row['ru_id']);
	}

	if ($row['action_list'] == 'all' && empty($row['last_login'])) {
		$_SESSION['shop_guide'] = true;
	}

	$data = array(
			'last_login' 	=> RC_Time::gmtime(),
			'last_ip'		=> RC_Ip::client_ip(),
	);
	$db_admin_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);

	$userinfo = array(
			'session'       => array(
				'sid'       => RC_Session::session_id(),
				'uid'       => $_SESSION['admin_id']
			),
	);
	$role_db   = RC_Loader::load_model('role_model');
	$role_name = $role_db->where(array('role_id' => $row['role_id']))->get_field('role_name');
	$userinfo['userinfo'] = array(
			'id' 			=> $row['user_id'],
			'username'		=> $row['user_name'],
			'email'			=> $row['email'],
			'last_login' 	=> RC_Time::local_date(ecjia::config('time_format'), $row['last_login']),
			'last_ip'		=> RC_Ip::area($row['last_ip']),
			'role_name'		=> !empty($role_name) ? $role_name : '',
			'avator_img'	=> RC_Uri::admin_url('statics/images/admin_avatar.png'),
	);
	
	//修正关联设备号
	$result = ecjia_app::validate_application('mobile');
	if (!is_ecjia_error($result)) {
		$device = $this->requestData('device', array());
		if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
			$db_mobile_device = RC_Model::model('mobile/mobile_device_model');
			$device_data = array(
					'device_udid'	=> $device['udid'],
					'device_client'	=> $device['client'],
					'device_code'	=> $device['code']
			);
			$db_mobile_device->where($device_data)->update(array('user_id' => $_SESSION['admin_id'], 'is_admin' => 1));
		}
	}
	return $userinfo;
}

// end
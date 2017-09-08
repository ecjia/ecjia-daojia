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

class wxbind_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();
    	$device       = $this->device;
		$iv      	  = trim($this->requestData('iv'));
		$encrypteddata= trim($this->requestData('encrypteddata'));
		$uuid	  	  = trim($this->requestData('uuid'));
		$token        = $this->token;
		
		if (empty($iv) || empty($encrypteddata) || empty($uuid) ) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}

		$openid = $_SESSION['openid'];
		$session_key = $_SESSION['session_key'];
		
		//获取小程序的weappid,即小程序自增id
		$WeappUUID =  new Ecjia\App\Weapp\WeappUUID($uuid);
		$weappId   = $WeappUUID->getWeappID();
		
		//获取用户解密数据
		$WeappUser = new Ecjia\App\Weapp\WeappUser($WeappUUID);
		$data = $WeappUser->decryptedData($session_key, $encrypteddata, $iv);

		/*更新用户数据*/
		if (!empty($data)) {
			$WechatUserRepository = new Ecjia\App\Weapp\Repositories\WechatUserRepository($weappId);
			$update = $WechatUserRepository->updateUser($data);
			
			if (!$update) {
				return new ecjia_error('update_userinfo_fail', '更新用户数据失败');
			}
		}
		
		//转换数据格式
		$data = array(
			'openid' 	=> $data['openId'],
			'nickname' 	=> $data['nickName'],
			'sex' 		=> $data['gender'],
			'language' 	=> $data['language'],
			'city' 		=> $data['city'],
			'province' 	=> $data['province'],
			'country' 	=> $data['country'],
			'headimgurl'=> $data['avatarUrl'],
			'privilege' => '',
			'unionid' 	=> $data['unionId'],
		);
		
		//绑定会员
		$connect_user = RC_Api::api('connect', 'connect_user_bind', array('connect_code' => 'sns_wechat', 'open_id' => $data['unionid'], 'profile' => $data));
		if (is_ecjia_error($connect_user)) {
			return $connect_user;
		} 
		
		//获取会员信息
		$user_info = RC_Api::api('user', 'user_info', array('user_id' => $connect_user->getUserId()));
		if (is_ecjia_error($user_info)) {
			return $user_info;
		}
		
		//设置session,设置cookie
		RC_Loader::load_app_class('integrate', 'user', false);
		$user = integrate::init_users();
		$user->set_session($user_info['user_name']);
		$user->set_cookie($user_info['user_name']);
		
		//修正咨询信息
		feedback_batch_userid($_SESSION['user_id'], $_SESSION['user_name'], $device);
		
		//同步会员信息
		RC_Loader::load_app_func('admin_user', 'user');
		$user_info = EM_user_info($_SESSION['user_id']);
		
		update_user_info(); // 更新用户信息
		RC_Loader::load_app_func('cart','cart');
		recalculate_price(); // 重新计算购物车中的商品价格
		
		//修正关联设备号
		$result = ecjia_app::validate_application('mobile');
		if (!is_ecjia_error($result)) {
			if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
				$db_mobile_device = RC_Model::model('mobile/mobile_device_model');
				$device_data = array(
						'device_udid'	=> $device['udid'],
						'device_client'	=> $device['client'],
						'device_code'	=> $device['code'],
						'user_type'		=> 'user',
				);
				$db_mobile_device->where($device_data)->update(array('user_id' => $_SESSION['user_id'], 'update_time' => RC_Time::gmtime()));
			}
		}
		
		//返回token及会员信息
		$out = array(
				'token' => RC_Session::session_id(),
				'user'	=> $user_info
		);
		return $out;
	}
}


/**
 * 修正咨询信息
 * @param string $user_id
 * @param string $device
 */
function feedback_batch_userid($user_id, $user_name, $device) {
	$device_udid	  = $device['udid'];
	$device_client	  = $device['client'];
	$db_term_relation = RC_Model::model('term_relationship_model');

	$object_id = $db_term_relation->where(array(
			'object_type'	=> 'ecjia.feedback',
			'object_group'	=> 'feedback',
			'item_key2'		=> 'device_udid',
			'item_value2'	=> $device_udid
	))->get_field('object_id', true);
	//更新未登录用户的咨询
	$db_term_relation->where(array('item_key2' => 'device_udid', 'item_value2' => $device_udid))->update(array('item_key2' => '', 'item_value2' => ''));

	if (!empty($object_id)) {
		$db = RC_Model::model('feedback/feedback_model');
		$db->where(array('msg_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $user_id, 'user_name' => $user_name));
		$db->where(array('parent_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $user_id, 'user_name' => $user_name));
	}
}

// end
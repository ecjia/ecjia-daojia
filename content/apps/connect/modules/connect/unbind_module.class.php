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
 *用户解绑关联的第三方账号
 */
class connect_unbind_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();	
		$connect_code = $this->requestData('connect_code'); //sns_qq是QQ，sns_wechat微信
		$smscode	  = $this->requestData('smscode');
		$type_arr	  = config('app-connect::connect_platform_code');
		
// 		$api_version = $this->request->header('api-version');
		 
		$user_id = $_SESSION['user_id'];
		if ($user_id <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		//用户信息
		$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
		if (is_ecjia_error($user_info)) {
			return $user_info;
		}
		
		//检查短信验证码
		$result = $this->check_smscode($smscode, $user_info);
		if (is_ecjia_error($result)) {
			return $result;
		}
		//1.30版本以前解绑是统一解绑
// 		if (version_compare($api_version, '1.30', '<')) {
// 			return $this->berforeVersion($connect_code, $smscode, $user_info);
// 		}
		
		if (empty($connect_code) || empty($smscode) || !in_array($connect_code, $type_arr)) {
			return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'connect'), __CLASS__));
		}
		
		$connect_user_info = RC_DB::table('connect_user')->where('connect_code', $connect_code)->where('user_type', 'user')->where('user_id', $user_id)->first();
		
		//解绑
		RC_DB::table('connect_user')
			->where('connect_code', $connect_code)
			->where('user_type', 'user')
			->where('user_id', $user_id)->delete();
			
		//微信解绑，wechat_user处理
		$connect_wechat_code = config('app-connect::connect_wechat_code');
		if (in_array($connect_code, $connect_wechat_code)) {
			//当前平台是否绑定了微信钱包，是的话，删除绑定的微信钱包
			$wechat_user_bank = RC_DB::table('withdraw_user_bank')->where('user_id', $user_id)->where('user_type', 'user')->where('bank_type', 'wechat')->first();
			if (!empty($wechat_user_bank) && $wechat_user_bank['bank_branch_name'] == $connect_code) {
				RC_DB::table('withdraw_user_bank')->where('id', $wechat_user_bank['id'])->delete();
			}
			
			//没有绑定的微信其他平台，处理wechat_user
			$wechat_count = RC_DB::table('connect_user')->whereIn('connect_code', $connect_wechat_code)->where('user_type', 'user')->where('user_id', $user_id)->count();
			if ($wechat_count == 0) {
				if($connect_user_info) {
					RC_DB::table('wechat_user')->where('unionid', $connect_user_info['union_id'])->where('ect_uid', $connect_user_info['user_id'])->update(['ect_uid' => 0]);
				} else {
					//找不到unionid 解绑平台下账号
					$account = RC_DB::table('platform_account')->where('shop_id', 0)->get();
					if($account) {
						foreach ($account as $row) {
							RC_DB::table('wechat_user')->where('wechat_id', $row['id'])->where('ect_uid', $connect_user_info['user_id'])->update(['ect_uid' => 0]);
						}
					}
				
				}
			}
		
		}

        return array();

	}
	
	
	/**
	 * 验证验证码
	 */
	private function check_smscode($smscode, $user_info)
	{
		//判断校验码是否过期
		if ($_SESSION['captcha']['sms']['user_unbind_connect']['sendtime'] + 1800 < RC_Time::gmtime()) {
			//过期
			return new ecjia_error('code_timeout', __('验证码已过期，请重新获取！', 'connect'));
		}
		//判断校验码是否正确
		if ($smscode != $_SESSION['captcha']['sms']['user_unbind_connect']['code'] ) {
			return new ecjia_error('code_error', __('验证码错误，请重新填写！', 'connect'));
		}
			
		//校验其他信息
		if ($user_info['mobile_phone'] != $_SESSION['captcha']['sms']['user_unbind_connect']['value']) {
			return new ecjia_error('msg_error', __('接受验证码手机号与用户绑定手机号不同！', 'connect'));
		}
		return true;
	}
	
	/**
	 * 1.30以下第三方账号解绑，统一解绑
	 */
	protected function berforeVersion($connect_code, $smscode, $user_info)
	{
		$type_arr	  = array('sns_qq', 'sns_wechat');
		if (empty($connect_code) || empty($smscode) || !in_array($connect_code, $type_arr)) {
			return new ecjia_error('invalid_parameter', __('参数无效', 'connect').' connect_unbind_module');
		}
		
		//解绑关联第三方账号
		if($connect_code == 'sns_qq') {
			RC_DB::table('connect_user')
			->where('connect_platform', 'qq')
			->where('user_type', 'user')
			->where('user_id', $user_info['user_id'])->delete();
			RC_DB::table('connect_user')
			->where('connect_code', $connect_code)
			->where('user_type', 'user')
			->where('user_id', $user_info['user_id'])->delete();
		} else if ($connect_code == 'sns_wechat') {
			$user_info = RC_DB::table('connect_user')
			->where('connect_platform', 'wechat')
			->where('user_type', 'user')
			->where('user_id', $user_info['user_id'])->first();
			RC_DB::table('connect_user')
			->where('connect_platform', 'wechat')
			->where('user_type', 'user')
			->where('user_id', $user_info['user_id'])->delete();
			RC_DB::table('connect_user')
			->where('connect_code', $connect_code)
			->where('user_type', 'user')
			->where('user_id', $user_info['user_id'])->delete();
			if($user_info) {
				RC_DB::table('wechat_user')->where('unionid', $user_info['union_id'])->where('ect_uid', $user_info['user_id'])->update(['ect_uid' => 0]);
			} else {
				//找不到unionid 解绑平台下账号
				$account = RC_DB::table('platform_account')->where('shop_id', 0)->get();
				if($account) {
					foreach ($account as $row) {
						RC_DB::table('wechat_user')->where('wechat_id', $row['id'])->where('ect_uid', $user_info['user_id'])->update(['ect_uid' => 0]);
					}
				}
		
			}
		}
		
		return array();
	}
}

// end
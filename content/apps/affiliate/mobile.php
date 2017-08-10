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

class mobile extends ecjia_front {
	public function __construct() {	
		parent::__construct();	
		$front_url = RC_App::apps_url('statics/front', __FILE__);
		$front_url = str_replace('sites/api/', '', $front_url);
  		/* js与css加载路径*/
  		$this->assign('front_url', $front_url);
  		$this->assign('title', ecjia::config('shop_name'). '邀请好友注册得奖励');
	}
	
	public function init() {
		
		$invite_code = isset($_GET['invite_code']) ? trim($_GET['invite_code']) : '';
		$urlscheme = ecjia::config('mobile_shop_urlscheme');
		if (preg_match('/ECJiaBrowse/', $_SERVER['HTTP_USER_AGENT'])) {
			header("location: ".$urlscheme."app?open_type=signup&invite_code=".$invite_code);
			exit();
		}
		$affiliate_note = "请输入您的电话并下载移动商城应用程序";
		
		
		/*是否有设置下载地址*/
		if (stripos($_SERVER['HTTP_USER_AGENT'], "iPhone")) {
			$url = ecjia::config('mobile_iphone_download');
		} elseif (stripos($_SERVER['HTTP_USER_AGENT'], "Android")) {
			$url = ecjia::config('mobile_android_download');
		}
		
		if (empty($url)) {
			$this->assign('is_h5', 1);
			$affiliate_note = "请输入您的电话并立即注册";
		}
		
		/* 推荐处理 */
		$affiliate = unserialize(ecjia::config('affiliate'));
		if (isset($affiliate['on']) && $affiliate['on'] == 1 && $affiliate['intviee_reward']['intivee_reward_value'] > 0) {
			if ($affiliate['intviee_reward']['intivee_reward_type'] == 'bonus') {
				$reward_value = RC_Model::model('affiliate/affiliate_bonus_type_model')->where(array('type_id' => $affiliate['intviee_reward']['intivee_reward_value']))->get_field('type_money');
				$reward_value = price_format($reward_value);
				$reward_type = '红包';
			} elseif ($affiliate['intviee_reward']['intivee_reward_type'] == 'integral') {
				$reward_value = $affiliate['intviee_reward']['intivee_reward_value'];
				$reward_type = '积分';
			} elseif ($affiliate['intviee_reward']['intivee_reward_type'] == 'balance') {
				$reward_value = price_format($affiliate['intviee_reward']['intivee_reward_value']);
				$reward_type = '现金';
			}
			
			if ($affiliate['intviee_reward']['intivee_reward_by'] == 'signup') {
				$affiliate_note .= "，完成注册后，您将获得".$reward_value.$reward_type."奖励";
			} else {
				$affiliate_note .= "，完成注册首次下单后，您将获得".$reward_value.$reward_type."奖励";
			}
		}
		$data = array(
			'object_type'	=> 'ecjia.affiliate',
			'object_group'	=> 'user_invite_code',
			'meta_key'		=> 'invite_code',
			'meta_value'	=> $invite_code
		);
		$user_id = RC_Model::model('term_meta_model')->where($data)->get_field('object_id');
		if (!empty($user_id)) {
			$user_name = RC_Model::model('affiliate/affiliate_users_model')->where(array('user_id' => $user_id))->get_field('user_name');
			$note = $user_name."为您推荐[ ".ecjia::config('shop_name')." ]移动商城";
			$this->assign('note', $note);
		}
		
		$this->assign('invite_code', $invite_code);
		$this->assign('affiliate_note', $affiliate_note);
		
		$this->display('affiliate.dwt');
	}
	
	public function invite() {
		/* 推荐处理 */
		$affiliate = unserialize(ecjia::config('affiliate'));
		if (isset($affiliate['on']) && $affiliate['on'] == 1) {
			$invite_code = isset($_POST['invite_code']) ? trim($_POST['invite_code']) : '';
			$mobile_phone = isset($_POST['mobile_phone']) ? trim($_POST['mobile_phone']) : '';
			
			
			$count = RC_Model::model('affiliate/affiliate_users_model')->where(array('mobile_phone' => $mobile_phone))->count();
			
			if (!empty($invite_code) && !empty($mobile_phone) && $count <= 0) {
				$data = array(
					'object_type'	=> 'ecjia.affiliate',
					'object_group'	=> 'user_invite_code',
					'meta_key'		=> 'invite_code',
					'meta_value'	=> $invite_code,
				);
				$invite_id = RC_Model::model('term_meta_model')->where($data)->get_field('object_id');
				
				if (!empty($invite_id)) {
					if (!empty($affiliate['config']['expire'])) {
						if ($affiliate['config']['expire_unit'] == 'hour') {
							$c = $affiliate['config']['expire'] * 1;
						} elseif ($affiliate['config']['expire_unit'] == 'day') {
							$c = $affiliate['config']['expire'] * 24;
						} elseif ($affiliate['config']['expire_unit'] == 'week') {
							$c = $affiliate['config']['expire'] * 24 * 7;
						} else {
							$c = 1;
						}
					} else {
						$c = 24; // 过期时间为 1 天
					}
					$time = RC_Time::gmtime() + $c*3600;
					
					/* 判断在有效期内是否已被邀请*/
					$is_invitee = RC_Model::model('affiliate/invitee_record_model')->where(array(
						'invitee_phone' => $mobile_phone,
						'invite_type'	=> 'signup',
						'expire_time'	=> array('gt' => RC_Time::gmtime())
					))->find();
					
					if (empty($is_invitee)) {
						RC_Model::model('affiliate/invitee_record_model')->insert(array(
								'invite_id'		=> $invite_id,
								'invitee_phone' => $mobile_phone,
								'invite_type'	=> 'signup',
								'is_registered' => 0,
								'expire_time'	=> $time,
								'add_time'		=> RC_Time::gmtime()
						));
					}
				}
			}
		}
	
		if (stripos($_SERVER['HTTP_USER_AGENT'], "iPhone")) {
			$url = ecjia::config('mobile_iphone_download');
		} elseif (stripos($_SERVER['HTTP_USER_AGENT'], "Android")) {
			$url = ecjia::config('mobile_android_download');
		}
		
		$urlscheme = ecjia::config('mobile_shop_urlscheme');
		$app_url = $urlscheme."app?open_type=signup&invite_code=".$invite_code;
		
		if (empty($url)) {
			$url = RC_Uri::url('user/privilege/register');
		}
		
		if ( $count > 0) {
			return ecjia_front::$controller->showmessage('该手机号已注册！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => $url, 'app' => $app_url));
		}
		
		if (isset($is_invitee) && !empty($is_invitee)) {
			return	ecjia_front::$controller->showmessage('您已被邀请过，请勿重复提交！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => $url, 'app' => $app_url));
		}
		
		return ecjia_front::$controller->showmessage('提交成功！', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('url' => $url, 'app' => $app_url));
	}
	
	public function qrcode_image() {
		$code = $_GET['invite_code'];
		$value = RC_Uri::site_url().'/index.php?m=affiliate&c=mobile&a=init&invite_code='. $code;
		
		// 二维码
		// 纠错级别：L、M、Q、H
		$errorCorrectionLevel = 'L';
		// 点的大小：1到10
		$matrixPointSize = 10;
		RC_Loader::load_app_class('QRcode', 'affiliate');
		$img = QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize, 2);

		echo $img;
	}
}

// end
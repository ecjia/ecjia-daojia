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
 * 推荐邀请用户
 * @author zrl
 */
class invite_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	$this->authSession();
        $mobile       = $this->requestData('mobile');
        $invite_code  = $this->requestData('invite_code');
        $sms_code     = $this->requestData('sms_code');
        
        if (empty($mobile) || empty($invite_code) || empty($sms_code)) {
        	return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
        }
        //手机号码格式判断
        $str = '/^1[345678]{1}\d{9}$/';
        if(!preg_match($str, $mobile)){
        	new ecjia_error('mobile_wrong', '手机号码格式不正确！');
        }
        //验证短信验证码
        //判断校验码是否过期
        if ($_SESSION['bindcode_lifetime'] + 1800 < RC_Time::gmtime()) {
        	//过期
        	$result = new ecjia_error('code_timeout', __('验证码已过期，请重新获取！'));
        	return $result;
        }
        //判断校验码是否正确
        if ($sms_code != $_SESSION['bind_code'] ) {
        	$result = new ecjia_error('code_error', __('验证码错误，请重新填写！'));
        	return $result;
        }
        	
        //校验其他信息
        if ($mobile != $_SESSION['bind_value']) {
        	$result = new ecjia_error('msg_error', __('信息错误，请重新获取验证码'));
        	return $result;
        }
        /* 推荐处理 */
        $affiliate = unserialize(ecjia::config('affiliate'));
        if (isset($affiliate['on']) && $affiliate['on'] == 1) {
        	$count = RC_DB::table('users')->where('mobile_phone', $mobile)->count();
        	if ($count > 0) {
        		return new ecjia_error('mobile_registered', '该手机号已注册！');
        	}
        	if (!empty($invite_code) && !empty($mobile) && $count <= 0) {
        		$invite_user_id = Ecjia\App\Affiliate\UserInviteCode::getUserId($invite_code);
        
        		if (!empty($invite_user_id)) {
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
        			$is_invitee = RC_DB::table('invitee_record')
        			->where('invitee_phone', $mobile)
        			->where('invite_type', 'signup')
        			->where('expire_time', '>', RC_Time::gmtime())
        			->first();
        			if (!empty($is_invitee)) {
        				return new ecjia_error('mobile_invited', '您已被邀请过，请勿重复提交！');
        			}else {
        				RC_DB::table('invitee_record')->insert(array(
        				'invite_id'		=> $invite_user_id,
        				'invitee_phone' => $mobile,
        				'invite_type'	=> 'signup',
        				'is_registered' => 0,
        				'expire_time'	=> $time,
        				'add_time'		=> RC_Time::gmtime()
        				));
        				unset($_SESSION['bind_code']);
        				unset($_SESSION['bindcode_lifetime']);
        				unset($_SESSION['bind_value']);
        				unset($_SESSION['bind_type']);
        				
        				return array();
        			}
        		}
        	}
        } else {
        	return new ecjia_error('affiliate_reward_off', '未开启推荐奖励！');
        }
    }
}

// end

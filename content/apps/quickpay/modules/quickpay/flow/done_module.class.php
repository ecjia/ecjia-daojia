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

class quickpay_flow_done_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		/**
         * goods_amount    //消费金额
         * exclude_amount  //不可参与优惠金额
         * activity_id     //活动id
         * discount   	   //活动优惠金额
         * bonus_id  	   //红包id
         * bonus           //红包金额
         * integral        //积分数量
         * inv_type       //integral_money
         * order_amount   //实付金额
         * pay_id    	  //支付方式id
         * surplus		  //余额
         */
    	
    	$this->authSession();
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	
    	RC_Loader::load_app_class('quickpay_activity', 'quickpay', false);
    	
    	$user_id = $_SESSION['user_id'];
    	$device = $this->device;
    	
    	$activity_id	= $this->requestData('activity_id', 0);
    	$goods_amount 	= $this->requestData('goods_amount', '0.00');   //消费金额
    	$exclude_amount = $this->requestData('exclude_amount', '0.00'); //不可参与优惠的金额
    	$bonus_id		= $this->requestData('bonus_id', 0);			//红包id
    	$integral		= $this->requestData('integral', 0);			//积分数
    	$store_id		= $this->requestData('store_id', 0);			//店铺id
    	
    	if ($goods_amount > 0 && $exclude_amount > 0) {
    		if ($exclude_amount > $goods_amount) {
    			return new ecjia_error('exclude_amount_error', '不可参与活动金额不能大于消费金额！');
    		}
    	}
    	
		if (empty($goods_amount) || empty($store_id)) {
			return new ecjia_error( 'invalid_parameter', sprintf(__('请求接口%s参数无效', 'quickpay'), __CLASS__));
		}
		$goods_amount = sprintf("%.2f", $goods_amount);
    	/*商家买单功能是否开启*/
		$quickpay_enabled = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'quickpay_enabled')->pluck('value');
		if (empty($quickpay_enabled)) {
			return new ecjia_error('quickpay_enabled_error', '此商家未开启优惠买单功能！');
		}
		
		/*初始化订单信息*/
		$order = array();
		$order = array(
				'goods_amount'		=> $goods_amount,
				'surplus'   		=> $this->requestData('surplus', 0.00),
				'integral'     		=> $integral,
				'bonus_id'     		=> $bonus_id,
				'bonus'				=> 0,
				'integral_money'	=> 0,
				'discount'			=> 0,
				'user_id'      		=> $_SESSION['user_id'],
				'add_time'     		=> RC_Time::gmtime(),
				'order_status'  	=> \Ecjia\App\Quickpay\Enums\QuickpayOrderEnum::UNCONFIRMED,
				'order_amount'		=> $goods_amount, 
		);

		if (!empty($activity_id) && $activity_id > 0) {
			/*获取买单活动信息*/
			$quickpay_activity_info = RC_DB::table('quickpay_activity')->where('id', $activity_id)->first();
			if (empty($quickpay_activity_info)) {
				return new ecjia_error('activity_not_exists', '活动信息不存在');
			}
			
			if ($quickpay_activity_info['enabled'] == '0') {
				return new ecjia_error('activity_closed', '此活动已关闭！');
			}
			$order['activity_type'] = $quickpay_activity_info['activity_type'];
			$order['activity_id'] = $quickpay_activity_info['id'];
			$order['store_id'] = $quickpay_activity_info['store_id'];
			
			/*活动时间限制处理*/
			$time = RC_Time::gmtime();
			if (($time > $quickpay_activity_info['end_time']) || ($quickpay_activity_info['start_time'] > $time)) {
				return new ecjia_error('activity_error', '活动还未开始或已结束');
			}
			
			/*活动可优惠金额获取*/
			$discount = quickpay_activity::get_quickpay_discount(array('activity_type' => $quickpay_activity_info['activity_type'], 'activity_value' => $quickpay_activity_info['activity_value'], 'goods_amount' => $goods_amount, 'exclude_amount' => $exclude_amount));
				
			/*活动可优惠金额处理*/
			$order['discount'] = sprintf("%.2f", $discount);
			if ($order['order_amount'] >= $order['discount']) {
				$order['order_amount'] -= $order['discount'];
			} else {
				$order['discount'] = $order['order_amount'];
				$order['order_amount'] -= $order['discount'];
			}
			
			
			/*红包是否可用*/
			if ($bonus_id > 0) {
				$bonus_info = RC_Api::api('bonus', 'bonus_info', array('bonus_id' => $bonus_id));
				if (is_ecjia_error($bonus_info)) {
					return $bonus_info;
				}
				if (empty($bonus_info)){
					return new ecjia_error('bonus_error', '红包信息不存在！');
				}
				$time = RC_Time::gmtime();
				if (($time < $bonus_info['use_start_date']) || ($bonus_info['use_end_date'] < $time) || ($bonus_info['store_id'] != 0 && $bonus_info['store_id'] != $quickpay_activity_info['store_id']) || $bonus_info['user_id'] != $user_id || $bonus_info['order_id'] > 0) {
					$order['bonus_id'] = 0;
					$order['bonus'] = 0.00;
				} else{
					$order['bonus_id'] = $bonus_id;
					$order['bonus'] = $bonus_info['type_money'];
					//使用红包金额不可超过订单金额
					if ($order['order_amount'] >= $bonus_info['type_money']) {
						$order['order_amount'] -= $bonus_info['type_money'];
					} else {
						$order['bonus'] = $order['order_amount'];
						$order['order_amount'] -= $order['bonus'];
					}
				}
					
			}
			
			if ($integral > 0) {
				/*会员可用积分数*/
				$user_integral = RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->pluck('pay_points');
				if ($integral > $user_integral) {
					return new ecjia_error('integral_error', '使用积分不可超过会员总积分数！');
				}
				$order['integral_money'] = quickpay_activity::integral_of_value($integral);
				//使用积分抵扣金额不可超过订单金额
				if ($order['order_amount'] >= $order['integral_money']) {
					$order['order_amount'] -= $order['integral_money'];
				} else {
					$order['integral_money'] = $order['order_amount'];
					$order['integral']		 = quickpay_activity::value_of_integral($order['integral_money']);
					$order['order_amount'] -= $order['integral_money'];
				}
			}
			
			
			/*自定义时间限制处理，当前时间不可用时，订单可正常提交,只是优惠金额是0；红包和积分也为0*/
			if ($quickpay_activity_info['limit_time_type'] == 'customize') {
				if (!quickpay_activity::customize_activity_is_available($quickpay_activity_info)) {
					$discount = 0.00;
					$order['integral'] = 0;
					$order['integral_money'] = 0.00;
					$order['bonus_id'] = 0;
					$order['bonus'] = 0.00;
				}
			}
		} else {
			$order['activity_type'] = 'normal';
			$order['activity_id'] = 0;
			$order['bonus_id'] = 0;
			$order['bonus'] = 0.00;
			$order['integral'] = 0;
			$order['integral_money'] = 0.00;
			$order['discount'] = 0.00;
		}
		
		$formated_discount = ecjia_price_format($order['discount'], false);
		
		$order['store_id'] = $store_id;
		/*订单编号*/
		$order['order_sn'] = ecjia_order_quickpay_sn();
		$order['order_type'] = 'quickpay';
		
		/*会员信息*/
		$user_id = $_SESSION['user_id'];
		if ($user_id > 0){
			$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
			if (is_ecjia_error($user_info)) {
				return $user_info;
			}
			$order['user_name'] 	= $user_info['user_name'];
			$order['user_mobile'] 	= $user_info['mobile_phone'];
			$order['user_type'] 	= 'user';
		}
		
		/*订单来源*/
		$order['from_ad'] = ! empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
		$order['referer'] = ! empty($device['device']['client']) ? $device['device']['client'] : 'mobile';
		
    	/*实付金额*/
		//$order['order_amount'] = $goods_amount - ($discount + $order['integral_money'] + $order['bonus']);
    	
    	$order['order_amount'] = number_format($order['order_amount'], 2, '.', '');
    	/*插入订单数据*/
    	$db_order_info = RC_DB::table('quickpay_orders');
    	$new_order_id	= $db_order_info->insertGetId($order);
    	
    	$order['order_id'] = $new_order_id;
    	
    	/* 处理积分、红包 */
    	if ($order['user_id'] > 0 && $order['integral'] > 0) {
    		$params = array(
    				'user_id'		=> $order['user_id'],
    				'pay_points'	=> $order['integral'] * (- 1),
    				'change_desc'	=> sprintf(__('支付订单 %s', 'quickpay'), $order['order_sn']),
    				'from_type'		=> 'order_use_integral',
    				'from_value'	=> $order['order_sn']
    		);
    		$result = RC_Api::api('user', 'account_change_log', $params);
    		if (is_ecjia_error($result)) {
    			return new ecjia_error('integral_error', __('积分使用失败！', 'quickpay'));
    		}
    	}
    	
    	if ($order['bonus_id'] > 0 && $order['bonus'] > 0) {
    		RC_Api::api('bonus', 'use_bonus', array('bonus_id' => $order['bonus_id'], 'order_id' => $new_order_id, 'order_sn' => $order['order_sn']));
    	}
    	
    	/* 给商家发邮件 */
    	/* 增加是否给客服发送邮件选项 */
    	if (ecjia::config('send_service_email') && ecjia::config('service_email') != '') {
    		$tpl_name = 'remind_of_new_order';
    		$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
    		$order['consignee'] = $order['user_name'];
    		$order['mobile'] = $order['user_mobile'];
    		ecjia_front::$controller->assign('order', $order);
    		ecjia_front::$controller->assign('shop_name', ecjia::config('shop_name'));
    		ecjia_front::$controller->assign('send_date', date(ecjia::config('time_format')));
    	
    		$content = ecjia_front::$controller->fetch_string($tpl['template_content']);
    		RC_Mail::send_mail(ecjia::config('shop_name'), ecjia::config('service_email'), $tpl['template_subject'], $content, $tpl['is_html']);
    	}
    	
    	$store_name = RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');
    	$shop_logo = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'shop_logo')->pluck('value');
    	
    	$order_info = array(
    			'order_sn'   => $order['order_sn'],
    			'order_id'   => $order['order_id'],
    			'store_id'   => $store_id,
    			'store_name' => $store_name,
    			'store_logo' =>  !empty($shop_logo) ? RC_Upload::upload_url($shop_logo) : '',
    			'order_info' => array(
    					'order_amount'           => $order['order_amount'],
    					'formatted_order_amount' => price_format($order['order_amount']),
    					'order_id'               => $order['order_id'],
    					'order_sn'               => $order['order_sn']
    			)
    	);
    	
    	return $order_info;
    }
}

// end
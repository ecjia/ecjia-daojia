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
 * 收银台收款购物流结算
 * @author
 */
class admin_cashier_quickpay_flow_done_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		/**
         * goods_amount    //消费金额
         * exclude_amount  //不可参与优惠金额
         * activity_id     //活动id
         * discount   	   //活动优惠金额
         * inv_type       //integral_money
         * order_amount   //实付金额
         * pay_id    	  //支付方式id
         * surplus		  //余额
         */
    	
    	$this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
    	
    	RC_Loader::load_app_class('cashdesk_quickpay_activity', 'quickpay', false);
    	
    	$activity_id		= $this->requestData('activity_id', 0);
    	$goods_amount 		= $this->requestData('goods_amount', '0.00');
    	$exclude_amount 	= $this->requestData('exclude_amount', '0.00');
    	$store_id			= $this->requestData('store_id', 0);
    	
    	if ($goods_amount > 0 && $exclude_amount > 0) {
    		if ($exclude_amount > $goods_amount) {
    			return new ecjia_error('exclude_amount_error', __('不可参与活动金额不能大于消费金额！', 'cashier'));
    		}
    	}
    	if (empty($store_id)) {
    		$store_id = $_SESSION['store_id'];
    	}
    	
		if (empty($goods_amount) || empty($store_id)) {
			return new ecjia_error( 'invalid_parameter', __('参数无效', 'cashier'));
		}
		$goods_amount = sprintf("%.2f", $goods_amount);
    	
		/*初始化订单信息*/
		$order = array();
		$order = array(
				'goods_amount'		=> $goods_amount,
				'surplus'   		=> $this->requestData('surplus', 0.00),
				'user_id'      		=> 0,
				'add_time'     		=> RC_Time::gmtime(),
				'order_status'  	=> \Ecjia\App\Quickpay\Enums\QuickpayOrderEnum::UNCONFIRMED,
		);

		if (!empty($activity_id) && $activity_id > 0) {
			/*获取买单活动信息*/
			$quickpay_activity_info = RC_DB::table('quickpay_activity')->where('id', $activity_id)->first();
			if (empty($quickpay_activity_info)) {
				return new ecjia_error('activity_not_exists', __('活动信息不存在', 'cashier'));
			}
			
			if ($quickpay_activity_info['enabled'] == '0') {
				return new ecjia_error('activity_closed', __('此活动已关闭！', 'cashier'));
			}
			$order['activity_type'] = $quickpay_activity_info['activity_type'];
			$order['activity_id'] = $quickpay_activity_info['id'];
			$order['store_id'] = $quickpay_activity_info['store_id'];
			
			/*活动时间限制处理*/
			$time = RC_Time::gmtime();
			if (($time > $quickpay_activity_info['end_time']) || ($quickpay_activity_info['start_time'] > $time)) {
				return new ecjia_error('activity_error', __('活动还未开始或已结束', 'cashier'));
			}
			
			/*活动可优惠金额获取*/
			$discount = cashdesk_quickpay_activity::get_quickpay_discount(array('activity_type' => $quickpay_activity_info['activity_type'], 'activity_value' => $quickpay_activity_info['activity_value'], 'goods_amount' => $goods_amount, 'exclude_amount' => $exclude_amount));
			
			/*自定义时间限制处理，当前时间不可用时，订单可正常提交,只是优惠金额是0；红包和积分也为0*/
			if ($quickpay_activity_info['limit_time_type'] == 'customize') {
				/*每周限制时间*/
				if (!empty($quickpay_activity_info['limit_time_weekly'])){
					$w = date('w');
					$current_week = quickpay_activity::current_week($w);
					$limit_time_weekly = Ecjia\App\Quickpay\Weekly::weeks($quickpay_activity_info['limit_time_weekly']);
					$weeks_str = cashdesk_quickpay_activity::get_weeks_str($limit_time_weekly);
						
					if (!in_array($current_week, $limit_time_weekly)){
						$discount = 0.00;
						$order['integral_money'] = 0.00;
						$order['bonus'] = 0.00;
					}
				}
			
				/*每天限制时间段*/
				if (!empty($quickpay_activity_info['limit_time_daily'])) {
					$limit_time_daily = unserialize($quickpay_activity_info['limit_time_daily']);
					foreach ($limit_time_daily as $val) {
						$arr[] = cashdesk_quickpay_activity::is_in_timelimit(array('start' => $val['start'], 'end' => $val['end']));
					}
					if (!in_array(0, $arr)) {
						$discount = 0.00;
						$order['integral_money'] = 0.00;
						$order['bonus'] = 0.00;
					}
				}
				/*活动限制日期*/
				if (!empty($quickpay_activity_info['limit_time_exclude'])) {
					$limit_time_exclude = explode(',', $quickpay_activity_info['limit_time_exclude']);
					$current_date = RC_Time::local_date(ecjia::config('date_format'), time);
					$current_date = array($current_date);
					if (in_array($current_date, $limit_time_exclude) || $current_date == $limit_time_exclude) {
						$discount = 0.00;
						$order['integral_money'] = 0.00;
						$order['bonus'] = 0.00;
					}
				}
			
			}
		} else {
			$order['activity_type'] = 'normal';
			$order['activity_id'] = 0;
			$order['bonus_id'] = 0;
			$order['bonus'] = 0.00;
			$order['integral_money'] = 0.00;
			$discount = 0.00;
		}
		
		/*活动可优惠金额处理*/
		$order['discount'] = sprintf("%.2f", $discount);
		$formated_discount = price_format($order['discount'], false);
		
		$order['store_id'] = $store_id;
		/*订单编号*/
		$order['order_sn'] = ecjia_order_quickpay_sn();
		$order['order_type'] = 'cashdesk-receipt';//收银台收款
		
		$order['user_type'] 	= 'merchant';
		
		/*订单来源*/
		$order['from_ad'] = ! empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
		$order['referer'] = 'ecjia-cashdesk';
		
    	/*实付金额*/
		$order['order_amount'] = $goods_amount - ($discount + $order['integral_money'] + $order['bonus']);
    	
    	/* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
    	if ($order['order_amount'] <= 0) {
    		$order['order_status']	= \Ecjia\App\Quickpay\Enums\QuickpayPayEnum::PAID;
    		$order['pay_time']		= RC_Time::gmtime();
    		$order['order_amount']	= 0;
    	}
    	$order['order_amount'] = number_format($order['order_amount'], 2, '.', '');
    	/*插入订单数据*/
    	$db_order_info = RC_DB::table('quickpay_orders');
    	$new_order_id	= $db_order_info->insertGetId($order);
    	
    	$order['order_id'] = $new_order_id;
    	
    	/*收银员订单操作记录*/
    	$device_info = RC_DB::table('mobile_device')->where('id', $_SESSION['device_id'])->first();
    	$device		  = $this->device;
    	$device_type  = Ecjia\App\Cashier\CashierDevice::get_device_type($device['code']);
    	$cashier_record = array(
    			'store_id' 			=> $_SESSION['store_id'],
    			'staff_id'			=> $_SESSION['staff_id'],
    			'order_id'	 		=> $new_order_id,
    			'order_type' 		=> 'ecjia-cashdesk',
    			'mobile_device_id'	=> empty($_SESSION['device_id']) ? 0 : $_SESSION['device_id'],
    			'device_sn'			=> empty($device_info['device_udid']) ? '' : $device_info['device_udid'],
    			'device_type'		=> $device_type,
    			'action'   	 		=> 'receipt', //收款
    			'create_at'	 		=> RC_Time::gmtime(),
    	);
    	RC_DB::table('cashier_record')->insert($cashier_record);
    	
    	
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
    					'order_sn'               => $order['order_sn'],
    					'pay_fee'				 => '',
    					'formatted_pay_fee'		 => '',
    			)
    	);
    	
    	return $order_info;
    }
}

// end
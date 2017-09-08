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
use Ecjia\System\Notifications\OrderPay;
defined('IN_ECJIA') or exit('No permission resources.');


/**
 * 余额支付后处理订单的接口
 * @author royalwang
 */
class orders_user_account_paid_api extends Component_Event_Api {
	
    /**
     * @param  $options['user_id'] 会员id
     *         $options['order_id'] 订单id
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || !isset($options['user_id']) 
	        || !isset($options['order_id'])) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
	    
	    $result = $this->user_account_paid($options['user_id'], $options['order_id']);
	    
	    if (is_ecjia_error($result)) {
	    	return $result;
	    } else {
	    	return true;
	    }
	    
	}
	
	/**
	 * 余额支付
	 *
	 * @access  public
	 * @param   integer $user_id 用户id
	 * @param   integer $order_id 订单id
	 * @return  void
	 */
	private function user_account_paid($user_id, $order_id) {
		RC_Loader::load_app_func('admin_order', 'orders');
		
		/* 订单详情 */
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		if ($user_id != $order_info['user_id']) {
			return new ecjia_error('error_order_detail', RC_Lang::get('orders::order.error_order_detail'));
		}
		/* 会员详情*/
		$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));

		/* 检查订单是否已经付款 */
		if ($order_info['pay_status'] == PS_PAYED && $order_info['pay_time']) {
			return new ecjia_error('order_paid', RC_Lang::get('orders::order.pay_repeat_message'));
		}
		
		/* 检查订单金额是否大于余额 */
		if ($order_info['order_amount'] > ($user_info['user_money'] + $user_info['credit_line'])) {
			return new ecjia_error('balance_less', RC_Lang::get('orders::order.not_enough_balance'));
		}
		
		/* 更新订单表支付后信息 */
		$data = array(
			'order_status'    => OS_CONFIRMED,
			'confirm_time'    => RC_Time::gmtime(),
			'pay_status'      => PS_PAYED,
			'pay_time'        => RC_Time::gmtime(),
			'order_amount'    => 0,
			'surplus'         => $order_info['order_amount'],
		);
		
		/*更新订单状态及信息*/
		update_order($order_info['order_id'], $data);
		
		
		/* 处理余额变动信息 */
		if ($order_info['user_id'] > 0 && $data['surplus'] > 0) {
			$options = array(
				'user_id'       => $order_info['user_id'],
				'user_money'    => $order_info['order_amount'] * (-1),
				'change_desc'	=> sprintf(RC_Lang::get('orders::order.pay_order'), $order_info['order_sn'])
			);
			RC_Api::api('user', 'account_change_log', $options);
			/* 插入支付日志 */
// 			$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
// 			$payment_method->insert_pay_log($order_info['order_id'], $order_info['order_amount'], PAY_SURPLUS);
		}
		
		order_action($order_info['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_PAYED, '', RC_Lang::get('orders::order.buyers'));
		
// 		$db = RC_DB::table('payment_record');
// 		$db->where('order_sn', $order_info['order_sn'])->where('pay_status', 'buy')->update(array('pay_time' => RC_Time::gmtime(), 'pay_status' => 1));
		
		RC_Api::api('affiliate', 'invite_reward', array('user_id' => $order_info['user_id'], 'invite_type' => 'orderpay'));
		
		$data = array(
			'order_status'	=> RC_Lang::get('orders::order.ps.'.PS_PAYED),
			'order_id'		=> $order_info['order_id'],
			'message'		=> RC_Lang::get('orders::order.notice_merchant_message'),
			'add_time'		=> RC_Time::gmtime(),
		);
		RC_DB::table('order_status_log')->insert($data);
		
		
		RC_DB::table('order_status_log')->insert(array(
			'order_status'	=> RC_Lang::get('cart::shopping_flow.merchant_process'),
			'order_id'		=> $order_info['order_id'],
			'message'		=> '订单已通知商家，等待商家处理',
			'add_time'		=> RC_Time::gmtime(),
		));
		
		
	    /* 客户付款短信提醒 */
        $staff_user = RC_DB::table('staff_user')->where('store_id', $order_info['store_id'])->where('parent_id', 0)->first();
		if (!empty($staff_user['mobile'])) {
			//发送短信
			$options = array(
				'mobile' => $staff_user['mobile'],
				'event'	 => 'sms_order_payed',
				'value'  =>array(
					'order_sn'		=> $order_info['order_sn'],
					'consignee' 	=> $order_info['consignee'],
					'telephone'  	=> $order_info['mobile'],
					'order_amount'	=> $order_info['order_amount'],
					'service_phone' => ecjia::config('service_phone'),
				),
			);
			RC_Api::api('sms', 'send_event_sms', $options);
		}
		
		/* 客户付款通知（默认通知店长）*/
		/* 获取店长的记录*/
// 		$devic_info = $staff_user = array();
// 		$staff_user = RC_DB::table('staff_user')->where('store_id', $order_info['store_id'])->where('parent_id', 0)->first();
		if (!empty($staff_user)) {
// 			$devic_info = RC_Api::api('mobile', 'device_info', array('user_type' => 'merchant', 'user_id' => $staff_user['user_id']));
			$options = array(
				'user_id'   => $staff_user['user_id'],
				'user_type' => 'merchant',
				'event'     => 'order_payed',
				'value' => array(
						'order_sn'     => $order_info['order_sn'],
						'consignee'    => $order_info['consignee'],
						'telephone'    => $order_info['mobile'],
						'order_amount' => $order_info['order_amount'],
						'service_phone'=> ecjia::config('service_phone'),
				),
				'field' => array(
						'open_type' => 'admin_message',
				),
			);
			RC_Api::api('push', 'push_event_send', $options);
		}
		
// 		if (!is_ecjia_error($devic_info) && !empty($devic_info)) {
// 			$push_event = RC_Model::model('push/push_event_viewmodel')->where(array('event_code' => 'order_pay', 'is_open' => 1, 'status' => 1, 'mm.app_id is not null', 'mt.template_id is not null', 'device_code' => $devic_info['device_code'], 'device_client' => $devic_info['device_client']))->find();
			 
// 			if (!empty($push_event)) {
// 				/* 通知记录*/
				$orm_staff_user_db = RC_Model::model('express/orm_staff_user_model');
				$staff_user_ob = $orm_staff_user_db->find($staff_user['user_id']);
				
				$order_data = array(
					'title'	=> '客户付款',
					'body'	=> '您有一笔新订单，订单号为：'.$order_info['order_sn'],
					'data'	=> array(
						'order_id'		=> $order_info['order_id'],
						'order_sn'		=> $order_info['order_sn'],
						'order_amount'	=> $order_info['order_amount'],
						'formatted_order_amount' => price_format($order_info['order_amount']),
						'consignee'		=> $order_info['consignee'],
						'mobile'		=> $order_info['mobile'],
						'address'		=> $order_info['address'],
						'order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $order_info['add_time']),
					),
				);
				 
				$push_order_pay = new OrderPay($order_data);
				RC_Notification::send($staff_user_ob, $push_order_pay);

// 				RC_Loader::load_app_class('push_send', 'push', false);
// 				ecjia_admin::$controller->assign('order', $order_info);
// 				$content = ecjia_admin::$controller->fetch_string($push_event['template_content']);
		
// 				if ($devic_info['device_client'] == 'android') {
// 					$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_ANDROID)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
// 				} elseif ($devic_info['device_client'] == 'iphone') {
// 					$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_IPHONE)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
// 				}
// 			}
// 		}
		return true;
    }
}

// end
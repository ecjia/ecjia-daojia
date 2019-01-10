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
use Ecjia\System\Notifications\OrderPlaced;
use Ecjia\App\Orders\Notifications\OrderPickup;
defined('IN_ECJIA') or exit('No permission resources.');


/**
 * 下单完成，相关方法执行(判断错误回退方法单独处理)
 * @author 
 */
class cart_flow_done_do_something_api extends Component_Event_Api {

    /**
     * @param $order
     * 
     * 发送短信
     * 推送
     * 通知
     * 订单日志
     * @return array
     */
	public function call(&$options) {

		$order = $options;

		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment_info = $payment_method->payment_info_by_id($order['pay_id']);
		
		/*发票识别码和抬头类型*/
		$inv_tax_no = isset($order['inv_tax_no']) ? $order['inv_tax_no'] : '';
		
		if (!empty($order['inv_payee'])) {
		    $inv_payee = explode(',', $order['inv_payee']);
		    $order['inv_payee'] = $inv_payee['0'];
		    $inv_title_type = 'personal';
		} else {
		    $order['inv_payee'] = '';
		}
		
		if (!empty($inv_title_type)) {
		    if ($inv_title_type == 'personal') {
		        $inv_title_type_new = 'PERSONAL';
		    } elseif ($inv_title_type == 'enterprise') {
		        $inv_title_type_new = 'CORPORATION';
		    }
		    $finance_invoice_info = RC_DB::table('finance_invoice')->where('title_type', $inv_title_type_new)->where('user_id', $_SESSION['user_id'])->where('tax_register_no', $inv_tax_no)->first();
		    if (empty($finance_invoice_info)) {
		        /*插入财务发票表*/
		        $inv_data = array(
		            'user_id' 			=> $_SESSION['user_id'],
		            'title_name' 		=> $order['inv_payee'],
		            'title_type' 		=> $inv_title_type_new,
		            'user_mobile' 		=> $order['mobile'],
		            'tax_register_no'	=> $inv_tax_no,
		            'user_address'		=> $order['address'],
		            'add_time'			=> RC_Time::gmtime(),
		            'is_default'		=> 1,
		            'status'		    => 0,
		        );
		        RC_DB::table('finance_invoice')->insert($inv_data);
		    }
		}
		
		/* 增加是否给客服发送邮件选项 */
		$service_email = ecjia::config('service_email');
		if (ecjia::config('send_service_email') && !empty($service_email)) {
		    try {
		        $tpl_name = 'remind_of_new_order';
		        $tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
		        
		        ecjia_front::$controller->assign('order', $order);
		        ecjia_front::$controller->assign('goods_list', $order['goods_list']);
		        ecjia_front::$controller->assign('shop_name', ecjia::config('shop_name'));
		        ecjia_front::$controller->assign('send_date', date(ecjia::config('time_format')));
		        
		        $content = ecjia_front::$controller->fetch_string($tpl['template_content']);
		        RC_Mail::send_mail(ecjia::config('shop_name'), ecjia::config('service_email'), $tpl['template_subject'], $content, $tpl['is_html']);
		    } catch (PDOException $e) {
		        RC_Logger::getlogger('error')->error($e);
		    }
		}
		
		$shipping_info = ecjia_shipping::getPluginDataById($order['shipping_id']);
		/*如果订单金额为0，并且配送方式为上门取货时发送提货码*/
		if (($order['order_amount'] + $order['surplus']) == '0.00' && $shipping_info == 'ship_cac') {
		    /*短信给用户发送收货验证码*/
		    $userinfo = RC_DB::table('users')->where('user_id', $order['user_id'])->select('user_name', 'mobile_phone')->first();
		    $mobile = $userinfo['mobile_phone'];
		    if (!empty($mobile)) {
		        $db_term_meta = RC_DB::table('term_meta');
		        $max_code = $db_term_meta->where('object_type', 'ecjia.order')->where('object_group', 'order')->where('meta_key', 'receipt_verification')->max('meta_value');
		        $max_code = $max_code ? ceil($max_code/10000) : 1000000;
		        $code = $max_code . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
		        
		        $orm_user_db = RC_Model::model('orders/orm_users_model');
		        $user_ob = $orm_user_db->find($order['user_id']);
		        
		        try {
		            //发送短信
		            $options = array(
		                'mobile' => $mobile,
		                'event'	 => 'sms_order_pickup',
		                'value'  =>array(
		                    'order_sn'  	=> $order['order_sn'],
		                    'user_name' 	=> $order['consignee'],
		                    'code'  		=> $code,
		                    'service_phone' => ecjia::config('service_phone'),
		                ),
		            );
		            RC_Api::api('sms', 'send_event_sms', $options);
		            //消息通知
		            $order_pickup_data = array(
		                'title'	=> '订单收货验证码',
		                'body'	=> '尊敬的'.$userinfo['user_name'].'，您在我们网站已成功下单。订单号：'.$order['order_sn'].'，收货验证码为：'.$code.'。请保管好您的验证码，以便收货验证',
		                'data'	=> array(
		                    'user_id'				=> $order['user_id'],
		                    'user_name'				=> $userinfo['user_name'],
		                    'order_id'				=> $new_order_id,
		                    'order_sn'				=> $order['order_sn'],
		                    'code'					=> $code,
		                ),
		            );
		            
		            $push_orderpickup_data = new OrderPickup($order_pickup_data);
		            RC_Notification::send($user_ob, $push_orderpickup_data);
		            
		        } catch (PDOException $e) {
		            RC_Logger::getLogger('info')->error($e);
		        }
		        $meta_data = array(
		            'object_type'	=> 'ecjia.order',
		            'object_group'	=> 'order',
		            'object_id'		=> $new_order_id,
		            'meta_key'		=> 'receipt_verification',
		            'meta_value'	=> $code,
		        );
		        $db_term_meta->insert($meta_data);
		    }
		}
		
		//订单log
		RC_DB::table('order_status_log')->insert(array(
			'order_status'	=> RC_Lang::get('cart::shopping_flow.label_place_order'),
			'order_id'		=> $order['order_id'],
			'message'		=> '下单成功，订单号：'.$order['order_sn'],
			'add_time'		=> RC_Time::gmtime(),
		));

		if (!$payment_info['is_cod'] && $order['order_amount'] > 0) {
			RC_DB::table('order_status_log')->insert(array(
				'order_status'	=> RC_Lang::get('cart::shopping_flow.unpay'),
				'order_id'		=> $order['order_id'],
				'message'		=> '请尽快支付该订单，超时将会自动取消订单',
				'add_time'		=> RC_Time::gmtime(),
			));
		}
		
		//自动接单
		if($payment_info['is_cod'] && $order['order_status'] == '1') {
			RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
			OrderStatusLog::orderpaid_autoconfirm(array('order_id' => $new_order_id));
		}
		
		/* 货到付款，默认打印订单 */
		if($payment_info['pay_code'] == 'pay_cod') {
		    try {
		        $res = with(new Ecjia\App\Orders\OrderPrint($order['order_id'], $order['store_id']))->doPrint(true);
		        if (is_ecjia_error($res)) {
		            RC_Logger::getLogger('error')->error($res->get_error_message());
		        }
		    } catch (PDOException $e) {
		        RC_Logger::getlogger('error')->error($e);
		    }
		}
		
		if($order['store_id']) {
		    /* 如果需要，发短信 */
		    $staff_user = RC_DB::table('staff_user')->where('store_id', $order['store_id'])->where('parent_id', 0)->first();
		    if (!empty($staff_user['mobile'])) {
		        try {
		            //发送短信
		            $options = array(
		                'mobile' => $staff_user['mobile'],
		                'event'	 => 'sms_order_placed',
		                'value'  =>array(
		                    'order_sn'		=> $order['order_sn'],
		                    'consignee' 	=> $order['consignee'],
		                    'telephone'  	=> $order['mobile'],
		                    'order_amount'  => $order['order_amount'],
		                    'service_phone' => ecjia::config('service_phone'),
		                ),
		            );
		            RC_Api::api('sms', 'send_event_sms', $options);
		        } catch (PDOException $e) {
		            RC_Logger::getLogger('info')->error($e);
		        }
		    }
		    
		    /* 客户下单通知（默认通知店长）*/
		    /* 获取店长的记录*/
		    $staff_user = RC_DB::table('staff_user')->where('store_id', $order['store_id'])->where('parent_id', 0)->first();
		    if (!empty($staff_user)) {
		        /* 通知记录*/
		        $orm_staff_user_db = RC_Model::model('express/orm_staff_user_model');
		        $staff_user_ob = $orm_staff_user_db->find($staff_user['user_id']);
		        try {
		            $order_data = array(
		                'title'	=> '客户下单',
		                'body'	=> '您有一笔新订单，订单号为：'.$order['order_sn'],
		                'data'	=> array(
		                    'order_id'		         => $order['order_id'],
		                    'order_sn'		         => $order['order_sn'],
		                    'order_amount'	         => $order['order_amount'],
		                    'formatted_order_amount' => price_format($order['order_amount']),
		                    'consignee'		         => $order['consignee'],
		                    'mobile'		         => $order['mobile'],
		                    'address'		         => $order['address'],
		                    'order_time'	         => RC_Time::local_date(ecjia::config('time_format'), $order['add_time']),
		                ),
		            );
		            
		            $push_order_placed = new OrderPlaced($order_data);
		            RC_Notification::send($staff_user_ob, $push_order_placed);
		        } catch (PDOException $e) {
		            RC_Logger::getLogger('info')->error($e);
		        }
		        
		        try {
		            //新的推送消息方法
		            $options = array(
		                'user_id'   => $staff_user['user_id'],
		                'user_type' => 'merchant',
		                'event'     => 'order_placed',
		                'value' => array(
		                    'order_sn'     => $order['order_sn'],
		                    'consignee'    => $order['consignee'],
		                    'telephone'    => $order['mobile'],
		                    'order_amount' => $order['order_amount'],
		                    'service_phone'=> ecjia::config('service_phone'),
		                ),
		                'field' => array(
		                    'open_type' => 'admin_message',
		                ),
		            );
		            RC_Api::api('push', 'push_event_send', $options);
		        } catch (PDOException $e) {
		            RC_Logger::getLogger('info')->error($e);
		        }
		    }
		}
		
		return $order;
	}
}

// end
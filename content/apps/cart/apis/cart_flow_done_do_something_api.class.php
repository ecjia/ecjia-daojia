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
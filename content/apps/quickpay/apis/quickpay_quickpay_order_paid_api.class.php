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
 * 买单订单支付后处理订单的接口
 * @author zrl
 */
class quickpay_quickpay_order_paid_api extends Component_Event_Api {
	
    /**
     * @param  order_sn  订单编号
     * @param  money     支付金额
     *
     * @return array
     */
	public function call(&$options) {
	    if (! array_get($options, 'order_sn') || ! array_get($options, 'money') ) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }

	    /* 改变订单状态 */
	    return $this->order_paid($options['order_sn'], PS_PAYED);
	}
	
	/**
	 * 修改订单的支付状态
	 *
	 * @access  public
	 * @param   string  $log_id     支付编号
	 * @param   integer $pay_status 状态
	 * @return  void
	 */
	private function order_paid($order_sn, $pay_status = PS_PAYED) {
		RC_Loader::load_app_class('quickpay_activity', 'quickpay', false);
	    /* 取得订单信息 */
	    $order = RC_DB::table('quickpay_orders')->selectRaw('order_id, store_id, user_id, order_sn, user_name, user_mobile, goods_amount, order_amount, add_time')
	    										->where('order_sn', $order_sn)->first();
	    $order_id = $order['order_id'];
	    $order_sn = $order['order_sn'];
	    
	    /* 修改订单状态为已付款 */
	    $data = array(
	        'order_status' => Ecjia\App\Quickpay\Status::CONFIRMED,
	    	'pay_status'   => Ecjia\App\Quickpay\Status::PAID,
	        'pay_time'     => RC_Time::gmtime(),
	        'order_amount' => $order['order_amount'],
	    );
	    //RC_DB::table('order_info')->where('order_id', $order_id)->update($data);
	    RC_DB::table('quickpay_orders')->where('order_id', $order_id)->update($data);
	    
	    /* 记录订单操作记录 */
	    $options = array(
	    		'order_id' 			=> $order_id,
	    		'action_user_id' 	=> $_SESSION['user_id'],
	    		'action_user_name'	=> RC_Lang::get('orders::order.buyers'),
	    		'action_user_type'	=> 'user',
	    		'order_status'		=> Ecjia\App\Quickpay\Status::CONFIRMED,
	    		'pay_status'		=> Ecjia\App\Quickpay\Status::PAID,
	    		'action_note'		=> ''
	    		
	    );
	    quickpay_activity::quickpay_order_action($options);
	    
	    RC_DB::table('order_status_log')->insert(array(
    	    'order_status'	=> RC_Lang::get('orders::order.ps.'.PS_PAYED),
    	    'order_id'		=> $order_id,
    	    'message'		=> RC_Lang::get('orders::order.notice_merchant_message'),
    	    'add_time'		=> RC_Time::gmtime(),
	    ));
	    RC_DB::table('order_status_log')->insert(array(
    	    'order_status'	=> RC_Lang::get('cart::shopping_flow.merchant_process'),
    	    'order_id'		=> $order_id,
    	    'message'		=> '订单已通知商家，等待商家处理',
    	    'add_time'		=> RC_Time::gmtime(),
	    ));
	    
	    /*门店自提，无需物流（收银台）时发送提货验证码；*/
	    if ($order['shipping_id'] > 0) {
	    	$shipping_info = RC_DB::table('shipping')->where('shipping_id', $order['shipping_id'])->first();
	    	if ($shipping_info['shipping_code'] == 'ship_cac') {
	    		/*短信给用户发送收货验证码*/
	    		if (ecjia::config('sms_shop_mobile') != '') {
	    			$db_term_meta = RC_DB::table('term_meta');
	    			$max_code = $db_term_meta->where('object_type', 'ecjia.order')->where('object_group', 'order')->where('meta_key', 'receipt_verification')->max('meta_value');
	    			 
	    			$max_code = $max_code ? ceil($max_code/10000) : 1000000;
	    			$code = $max_code . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
	    			 
	    			$options = array(
	    					'mobile' => $order['user_mobile'],
	    					'event'	 => 'sms_order_pickup',
	    					'value'  =>array(
	    							'order_sn'  	=> $order['order_sn'],
	    							'user_name' 	=> $order['user_name'],
	    							'code'  		=> $code,
	    							'service_phone' => ecjia::config('service_phone'),
	    					),
	    			);
	    			RC_Api::api('sms', 'send_event_sms', $options);
	    			 
	    			$meta_data = array(
	    					'object_type'	=> 'ecjia.order',
	    					'object_group'	=> 'order',
	    					'object_id'		=> $order_id,
	    					'meta_key'		=> 'receipt_verification',
	    					'meta_value'	=> $code,
	    			);
	    			$db_term_meta->insert($meta_data);
	    		}
	    	}
	    }
	    
	    /* 客户付款通知（默认通知店长）*/
	    /* 获取店长的记录*/
	    $staff_user = RC_DB::table('staff_user')->where('store_id', $order['store_id'])->where('parent_id', 0)->first();
	    if (!empty($staff_user)) {

	    	$options = array(
    			'user_id'   => $staff_user['user_id'],
    			'user_type' => 'merchant',
    			'event'     => 'order_payed',
    			'value' => array(
    					'order_sn'     => $order['order_sn'],
    					'consignee'    => $order['user_name'],
    					'telephone'    => $order['user_mobile'],
    					'order_amount' => $order['order_amount'],
    					'service_phone' => ecjia::config('service_phone'),
    			),
    			'field' => array(
    					'open_type' => 'admin_message',
    			),
	    	);
	    	RC_Api::api('push', 'push_event_send', $options);
	    }

	    /* 通知记录*/
	    $orm_staff_user_db = RC_Model::model('express/orm_staff_user_model');
	    $staff_user_ob = $orm_staff_user_db->find($staff_user['user_id']);
	    
	    $order_data = array(
	    		'title'	=> '客户付款',
	    		'body'	=> '您有一笔新订单，订单号为：'.$order['order_sn'],
	    		'data'	=> array(
	    				'order_id'		=> $order['order_id'],
	    				'order_sn'		=> $order['order_sn'],
	    				'order_amount'	=> $order['order_amount'],
	    				'formatted_order_amount' => price_format($order['order_amount']),
	    				'consignee'		=> $order['user_name'],
	    				'mobile'		=> $order['user_mobile'],
	    				//'address'		=> $order['address'],
	    				'order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $order['add_time']),
	    		),
	    );
	    
	    $push_order_pay = new OrderPay($order_data);
	    RC_Notification::send($staff_user_ob, $push_order_pay);
	    
	    $store_name = RC_DB::TABLE('store_franchisee')->where('store_id', $order['store_id'])->pluck('merchants_name');
        /* 客户付款短信提醒 */
        if (!empty($staff_user['mobile'])) {
            $options = array(
                'mobile' => $staff_user['mobile'],
                'event'	 => 'sms_quickpay_order_payed',
                'value'  =>array(
                    'order_sn'  	=> $order['order_sn'],
                	'store_name'	=> $store_name,	
                    'user_name' 	=> $order['user_name'],
                	'goods_amount'	=> $order['goods_amount'],
                	'discount'		=> $order['discount'],
                    'order_amount'	=> $order['order_amount'],
                	'telephone'  	=> $order['user_mobile'],
                ),
            );
            RC_Api::api('sms', 'send_event_sms', $options);
        }
    }
}

// end
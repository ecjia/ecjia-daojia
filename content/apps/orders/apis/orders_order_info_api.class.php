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
 * 订单详情接口
 * @author royalwang
 */
class orders_order_info_api extends Component_Event_Api {
    /**
     * @param  $options['order_id'] 订单ID
     *         $options['order_sn'] 订单号
     *
     * @return array
     */
	public function call(&$options) {
	    if (!is_array($options) || (!isset($options['order_id']) && !isset($options['order_sn']))) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
		return $this->order_info($options['order_id'], $options['order_sn'], $options['store_id'], $options['user_id']);
	}

	/**
	 * 取得订单信息
	 * @param   int	 $order_id   订单id（如果order_id > 0 就按id查，否则按sn查）
	 * @param   string  $order_sn   订单号
	 * @return  array   订单信息（金额都有相应格式化的字段，前缀是formated_）
	 */
	private function order_info($order_id, $order_sn = '', $store_id = 0, $user_id = 0) {
	    $db_order_info = RC_DB::table('order_info');
	    /* 计算订单各种费用之和的语句 */
	    $total_fee = " (goods_amount - discount + tax + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee) AS total_fee ";
	    $order_id = intval($order_id);

	    $db_order_info->selectRaw('*, '.$total_fee);
	    if ($order_id > 0) {
	        $db_order_info->where('order_id', $order_id);
	    } else {
	        $db_order_info->where('order_sn', $order_sn);
	    }
        if(!empty($store_id)){
            $db_order_info->where('store_id', $store_id);
        }
        $db_order_info->where('is_delete', 0);
	    $order = $db_order_info->first();

	    /* 格式化金额字段 */
	    if ($order) {
	        $order['formated_goods_amount']		= price_format($order['goods_amount'], false);
	        $order['formated_discount']			= price_format($order['discount'], false);
	        $order['formated_tax']				= price_format($order['tax'], false);
	        $order['formated_shipping_fee']		= price_format($order['shipping_fee'], false);
	        $order['formated_insure_fee']		= price_format($order['insure_fee'], false);
	        $order['formated_pay_fee']			= price_format($order['pay_fee'], false);
	        $order['formated_pack_fee']			= price_format($order['pack_fee'], false);
	        $order['formated_card_fee']			= price_format($order['card_fee'], false);
	        $order['formated_total_fee']		= price_format($order['total_fee'], false);
	        $order['formated_money_paid']		= price_format($order['money_paid'], false);
	        $order['formated_bonus']			= price_format($order['bonus'], false);
	        $order['formated_integral_money']	= price_format($order['integral_money'], false);
	        $order['formated_surplus']			= price_format($order['surplus'], false);
	        $order['formated_order_amount']		= price_format(abs($order['order_amount']), false);
	        $order['formated_add_time']			= RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
	        $order['formated_pay_time']			= !empty($order['pay_time']) ? RC_Time::local_date(ecjia::config('time_format'), $order['pay_time']) : '';
	        $order['formated_shipping_time']	= !empty($order['shipping_time']) ? RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']) : '';
	        
	        // 检查订单是否属于该用户
	        if ($user_id > 0 && $user_id != $order['user_id']) {
	        	return new ecjia_error('orders_error', '未找到相应订单！');
	        }
	        
// 	        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
	        if ($order['pay_id'] > 0) {
	        	$payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
	        }
	        
	        if (in_array($order['order_status'], array(OS_CONFIRMED, OS_SPLITED)) &&
	        in_array($order['shipping_status'], array(SS_RECEIVED)) &&
	        in_array($order['pay_status'], array(PS_PAYED, PS_PAYING)))
	        {
	        	$order['label_order_status'] = '已完成';
	        	$order['order_status_code'] = 'finished';
	        }
	        elseif (in_array($order['shipping_status'], array(SS_SHIPPED)))
	        {
	        	$order['label_order_status'] = '待收货';
	        	$order['order_status_code'] = 'shipped';
	        }
	        elseif (in_array($order['order_status'], array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) &&
	        		in_array($order['pay_status'], array(PS_UNPAYED)) &&
	        		(in_array($order['shipping_status'], array(SS_SHIPPED, SS_RECEIVED)) || !$payment['is_cod']))
	        {
	        	$order['label_order_status'] = '待付款';
	        	$order['order_status_code'] = 'await_pay';
	        }
	        elseif (in_array($order['order_status'], array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
	        		in_array($order['shipping_status'], array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) &&
	        		(in_array($order['pay_status'], array(PS_PAYED, PS_PAYING)) || $payment['is_cod']))
	        {
	        	$order['label_order_status'] = '待发货';
	        	$order['order_status_code'] = 'await_ship';
	        }
	        elseif (in_array($order['order_status'], array(OS_CANCELED))) {
	        	$order['label_order_status'] = '已取消';
	        	$order['order_status_code'] = 'canceled';
	        }
	        
	        /* 对发货号处理 */
	        if (! empty($order['invoice_no'])) {
	        	$shipping_code = RC_Model::model('shipping/shipping_model')->field('shipping_code')->find('shipping_id = ' . $order['shipping_id']);
	        	$shipping_code = $shipping_code['shipping_code'];
	        }
	        
	        /* 只有未确认才允许用户修改订单地址 */
	        if ($order['order_status'] == OS_UNCONFIRMED) {
	        	$order['allow_update_address'] = 1; // 允许修改收货地址
	        } else {
	        	$order['allow_update_address'] = 0;
	        }
	        
	        /* 获取订单中实体商品数量 */
	        $order['exist_real_goods'] = RC_DB::table('order_goods')->where('order_id', $order_id)->where('is_real', 1)->count();
	        
// 	        $pay_method = RC_Loader::load_app_class('payment_method', 'payment');
// 	        // 获取需要支付的log_id
// 	        $order['log_id'] = $pay_method->get_paylog_id($order['order_id'], $pay_type = PAY_ORDER);
	        
	        $order['user_name'] = $_SESSION['user_name'];
	        
	        /* 无配送时的处理 */
	        $order['shipping_id'] == - 1 and $order['shipping_name'] = RC_Lang::get('orders::order.shipping_not_need');
	        
	        /* 其他信息初始化 */
	        $order['how_oos_name'] = $order['how_oos'];
	        $order['how_surplus_name'] = $order['how_surplus'];
	        
	        /* 确认时间 支付时间 发货时间 */
// 	        if ($order['confirm_time'] > 0 && ($order['order_status'] == OS_CONFIRMED || $order['order_status'] == OS_SPLITED || $order['order_status'] == OS_SPLITING_PART)) {
// 	        	$order['confirm_time'] =  RC_Time::local_date(ecjia::config('time_format'), $order['confirm_time']);
// 	        } else {
// 	        	$order['confirm_time'] = '';
// 	        }
// 	        if ($order['pay_time'] > 0 && $order['pay_status'] != PS_UNPAYED) {
// 	        	$order['pay_time'] =  RC_Time::local_date(ecjia::config('time_format'), $order['pay_time']);
// 	        } else {
// 	        	$order['pay_time'] = '';
// 	        }
// 	        if ($order['shipping_time'] > 0 && in_array($order['shipping_status'], array(
// 	        		SS_SHIPPED,
// 	        		SS_RECEIVED
// 	        ))) {
// 	        	$order['shipping_time'] = RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']);
// 	        } else {
// 	        	$order['shipping_time'] = '';
// 	        }
	    }
	    
	    return $order;
	}
}

// end
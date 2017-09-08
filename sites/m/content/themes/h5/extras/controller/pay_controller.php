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
 * 支付控制器代码
 */
class pay_controller {
    public static function init() {
        $order_id = !empty($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $pay_id = !empty($_GET['pay_id']) ? intval($_GET['pay_id']) : 0;
        $pay_code = !empty($_GET['pay_code']) ? trim($_GET['pay_code']) : '';
        $tips_show = !empty($_GET['tips_show']) ? trim($_GET['tips_show']) : 0;
        
        if (empty($order_id)) {
			return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }
        
        $token = ecjia_touch_user::singleton()->getToken();
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$token));
        
        if (!ecjia_front::$controller->is_cached('pay.dwt', $cache_id)) {
        	if ($pay_id && $pay_code) {
        		//修改支付方式，更新订单
        		$params = array(
        			'token' => $token,
        			'order_id' => $order_id,
        			'pay_id' => $pay_id,
        		);
        		$response = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_UPDATE)->data($params)->run();
        		if (is_ecjia_error($response)) {
        			return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        		}
        	}
        	/*获取订单信息*/
        	$params_order = array('token' => $token, 'order_id' => $order_id);
        	$detail = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();
        	if (is_ecjia_error($detail)) {
        	    return ecjia_front::$controller->showmessage($detail->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        	}
        	//支付方式信息
        	$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        	$payment_info = $payment_method->payment_info_by_id($detail['pay_id']);
        	
        	//获得订单支付信息
        	$params = array(
        		'token' 	=> $token,
        		'order_id'	=> $order_id,
        	);
        	$rs_pay = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_PAY)->data($params)->run();
        	if (is_ecjia_error($rs_pay)) {
        		return ecjia_front::$controller->showmessage($rs_pay->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        	}
        	
        	if (isset($rs_pay) && $rs_pay['payment']['error_message']) {
        		ecjia_front::$controller->assign('pay_error', $rs_pay['payment']['error_message']);
        	}
        	 
        	$order = $rs_pay['payment'];
        	//免费商品直接余额支付
        	if ($order['order_amount'] !== 0) {
	        	$need_other_payment = 0;
	        	if ($order ['pay_code'] == 'pay_balance') {
	        		if ($rs_pay['payment']['error_message']) {
	        			$need_other_payment = 1;
	        		}
	        	}
	        	/* 调起微信支付*/
	        	else if ( $pay_code == 'pay_wxpay' || $payment_info['pay_code'] == 'pay_wxpay') {
	        		// 取得支付信息，生成支付代码
// 	        		$payment_config = $payment_method->unserialize_config($payment_info['pay_config']);
	        		 
// 	        		$handler = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
	        		$handler = with(new Ecjia\App\Payment\PaymentPlugin)->channel($payment_info['pay_code']);
	        		$handler->set_orderinfo($detail);
	        		$handler->set_mobile(false);
	        		$handler->setPaymentRecord(new Ecjia\App\Payment\Repositories\PaymentRecordRepository());
	        		$rs_pay = $handler->get_code(Ecjia\App\Payment\PayConstant::PAYCODE_PARAM);
	        		if (is_ecjia_error($rs_pay)) {
	        		    return ecjia_front::$controller->showmessage($rs_pay->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
	        		}
	        		$order = $rs_pay;
	        		ecjia_front::$controller->assign('pay_button', $rs_pay['private_data']['pay_online']);
	        		unset($order['pay_online']);
	        		$need_other_payment = 1;
	        	} else {
	        		//其他支付方式
	        		$not_need_otherpayment_arr = array('pay_cod');
	        		if (in_array($order ['pay_code'], $not_need_otherpayment_arr)) {
	        			$need_other_payment = 0;
	        		} else {
	        			$need_other_payment = 1;
	        		}
	        		$order['pay_online'] = array_get($order, 'pay_online', array_get($order, 'private_data.pay_online'));
	        	}
	        	 
	        	if ($need_other_payment && $order['order_pay_status'] == 0) {
	        		$params = array(
	        			'token' => $token,
	        		);
	        		$rs_payment = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_PAYMENT)->data($params)->run();
	        		if (is_ecjia_error($rs_payment)) {
	        			return ecjia_front::$controller->showmessage($rs_payment->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
	        		}
	        		$payment_list = touch_function::change_array_key($rs_payment['payment'], 'pay_code');
	        			
	        		/*根据浏览器过滤支付方式，微信自带浏览器过滤掉支付宝支付，其他浏览器过滤掉微信支付*/
	        		if (!empty($payment_list)) {
	        			if (cart_function::is_weixin() == true) {
	        				foreach ($payment_list as $key => $val) {
	        					if ($val['pay_code'] == 'pay_alipay') {
	        						unset($payment_list[$key]);
	        					}
	        				}
	        			} else {
	        				foreach ($payment_list as $key => $val) {
	        					if ($val['pay_code'] == 'pay_wxpay') {
	        						unset($payment_list[$key]);
	        					}
	        				}
	        			}
	        		}
	        	
	        		//过滤当前支付方式
	        		unset($payment_list[$pay_code]);
	        		unset($payment_list[$payment_info['pay_code']]);
	        		//非自营过滤货到付款
	        		if ($detail['manage_mode'] != 'self') {
	        			unset($payment_list['pay_cod']);
	        		}
	        		ecjia_front::$controller->assign('payment_list', $payment_list);
	        	}
        	} else {
        		$order['pay_status'] = 'success';
        		unset($order['pay_online']);
        	}
        	
        	if ($order['pay_code'] != 'pay_balance') {
        		$order['formated_order_amount'] = price_format($order['order_amount']);
        	}
        	$order['order_id'] = $order_id;
        	
        	ecjia_front::$controller->assign('detail', $detail);
        	ecjia_front::$controller->assign('data', $order);
        	ecjia_front::$controller->assign('pay_online', $order['pay_online']);
        	ecjia_front::$controller->assign('tips_show', $tips_show);
        	
        	//生成返回url cookie
        	RC_Cookie::set('pay_response_index', RC_Uri::url('touch/index/init'));
        	RC_Cookie::set('pay_response_order', RC_Uri::url('user/order/order_detail', array('order_id' => $order_id, 'type' => 'detail')));
        }
        
        ecjia_front::$controller->display('pay.dwt', $cache_id);
    }
    
    public static function notify() {
		$msg = '支付成功';
		ecjia_front::$controller->assign('msg', $msg);
		$order_type = isset($_GET['order_type']) ? trim($_GET['order_type']) : '';
		$url['index'] = RC_Cookie::get('pay_response_index');
		$url['order'] = RC_Cookie::get('pay_response_order');
		
		$url = array(
		    'index' => RC_Cookie::get('pay_response_index') ? RC_Cookie::get('pay_response_index') : str_replace('notify/', '', RC_Uri::url('touch/index/init')),
		    'order' => RC_Cookie::get('pay_response_order') ? RC_Cookie::get('pay_response_order') : str_replace('notify/', '', RC_Uri::url('touch/user/order_list')),
		);
		ecjia_front::$controller->assign('url', $url);
		ecjia_front::$controller->assign('order_type', $order_type);
        ecjia_front::$controller->display('pay_notify.dwt');
    }
}

// end
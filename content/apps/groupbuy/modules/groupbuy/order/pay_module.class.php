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
 * 订单支付
 * @author royalwang
 * 16-12-09 增加支付状态
 */
class groupbuy_order_pay_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	$user_id = $_SESSION['user_id'];
    	
    	if ($user_id < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}
    	
		$order_id	= $this->requestData('order_id', 0);
		$is_mobile	= $this->requestData('is_mobile', true);
		$wxpay_open_id = $this->requestData('wxpay_open_id', null);
		
		if (!$order_id) {
			return new ecjia_error('invalid_parameter', __('参数无效', 'groupbuy'));
		}
		
		/* 订单详情 */
		$order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		if (is_ecjia_error($order)) {
			return $order;
		}
		
		if ($_SESSION['user_id'] != $order['user_id']) {
			return new ecjia_error('error_order_detail', __('订单不属于该用户', 'groupbuy'));
		}
		
		if ($order['extension_code'] == 'group_buy' && $order['extension_id'] > 0) {
			RC_Loader::load_app_func('admin_goods', 'goods');
			$group_buy = group_buy_info($order['extension_id']);
				
			$now = RC_Time::gmtime();
			//团购活动有没保证金
			if ($group_buy['deposit'] > 0) {
				//有保证金
				//1.活动结束未处理
				//2.活动失败结束
				if ($group_buy['is_finished'] == 0) {
					if ($now < $group_buy['start_date'] || $now > $group_buy['end_date']) {
						return new ecjia_error('groupbuy_activity_error', '抱歉，团购活动未开始或已结束！');
					}
				} elseif ($group_buy['is_finished'] == GBS_FAIL) {
					return new ecjia_error('groupbuy_activity_failed', '抱歉，团购活动失败结束，如已支付过保证金将会退回余额！');
				}
			} else {
				//没有保证金
				//1.活动结束未处理
				//2.活动失败结束
				if ($group_buy['is_finished'] == 0) {
					if ($now < $group_buy['start_date'] || $now > $group_buy['end_date']) {
						return new ecjia_error('groupbuy_activity_error', __('抱歉，团购活动未开始或已结束！', 'groupbuy'));
					}
				} elseif ($group_buy['is_finished'] == GBS_FAIL) {
					return new ecjia_error('groupbuy_activity_failed', __('抱歉，团购活动失败结束！', 'groupbuy'));
				}
			}
		}
		
		//添加微信支付需要的OPEN_ID
		if ($wxpay_open_id) {
		    $order['open_id'] = $wxpay_open_id;
		}
		
		//支付方式信息
		RC_Logger::getLogger('info')->info('order-pay');
		RC_Logger::getLogger('info')->info($order);
		
		$handler = with(new Ecjia\App\Payment\PaymentPlugin)->channel(intval($order['pay_id']));
		if (is_ecjia_error($handler)) {
		    return $handler;
		}
		
		/* 插入支付流水记录*/
		RC_Api::api('payment', 'save_payment_record', [
    		'order_sn' 		 => $order['order_sn'],
    		'total_fee'      => $order['order_amount'],
    		'pay_code'       => $handler->getCode(),
    		'pay_name'		 => $handler->getName(),
    		'trade_type'	 => 'buy',
		]);
		
		$handler->set_orderinfo($order);
		$handler->set_mobile($is_mobile);
		$handler->setPaymentRecord(new Ecjia\App\Payment\Repositories\PaymentRecordRepository());
		
		$result = $handler->get_code(Ecjia\App\Payment\PayConstant::PAYCODE_PARAM);
        if (is_ecjia_error($result)) {
            return $result;
        } else {
            $order['payment'] = $result;
        }

        //增加支付状态
        $order['payment']['order_pay_status'] = $order['pay_status'];//0 未付款，1付款中，2已付款
        
        $cod_fee = 0;
        if (intval($order['shipping_id']) > 0) {
            $shipping = RC_Api::api('shipping', 'shipping_area_info', array(
            	'shipping_id' => $order['shipping_id'],
            	'store_id'     => $order['store_id'],
            	'country'      => $order['country'],
            	'province'     => $order['province'],
            	'city'         => $order['city'],
            	'district'     => $order['district'],
            ));
            
            if (! is_ecjia_error($shipping)) {
                if (array_get($shipping, 'shipping.support_cod')) {
                    $cod_fee = array_get($shipping, 'area.pay_fee');
                }
            }
        }
        
        $payment_list = RC_Api::api('payment', 'available_payments', array('store_id' => $order['store_id'], 'cod_fee' => $cod_fee));

        $other = collect($payment_list)->flatMap(function ($item) use ($order) {
            if ($item['pay_id'] == $order['pay_id']) {
                return array();
            }
            
            return array($item);
        })->all();

        return array('payment' => $order['payment'], 'others' => $other);
	}
}

// end
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
 * 取消订单
 * @author royalwang
 */
class cancel_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
		$user_id = $_SESSION['user_id'];
		if ($user_id < 1 ) {
		    return new ecjia_error(100, 'Invalid session');
		}
		
		$order_id = $this->requestData('order_id', 0);
		if($user_id < 1 || $order_id <1) {
		    return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		$result = cancel_order($order_id, $user_id);
		if (!is_ecjia_error($result)) {
			
			return array();
		} else {
			return $result;
		}
	}
}

/**
 * 取消一个用户订单
 *
 * @access public
 * @param int $order_id
 *            订单ID
 * @param int $user_id
 *            用户ID
 * @return void
 */
function cancel_order ($order_id, $user_id = 0) {
    $db = RC_Model::model('orders/order_info_model');
    /* 查询订单信息，检查状态 */
    $order = $db->field('user_id, order_id, order_sn , surplus , integral , bonus_id, order_status, shipping_status, pay_status')->find(array('order_id' => $order_id));

    if (empty($order)) {
        return new ecjia_error('order_exist', RC_Lang::get('orders::order.order_not_exist'));
    }

    // 如果用户ID大于0，检查订单是否属于该用户
    if ($user_id > 0 && $order['user_id'] != $user_id) {
        return new ecjia_error('no_priv', RC_Lang::get('orders::order.no_priv'));
    }

    //TODO:未付款前都可取消，付款后取消暂不考虑
    // 订单状态只能是“未确认”或“已确认”
//     if ($order['order_status'] != OS_UNCONFIRMED && $order['order_status'] != OS_CONFIRMED) {
//         return new ecjia_error('current_os_not_unconfirmed', RC_Lang::get('orders::order.current_os_not_unconfirmed'));
//     }

    // 订单一旦确认，不允许用户取消
//     if ($order['order_status'] == OS_CONFIRMED) {
//         return new ecjia_error('current_os_already_confirmed', RC_Lang::get('orders::order.current_os_already_confirmed'));
//     }

    // 发货状态只能是“未发货”
    if ($order['shipping_status'] != SS_UNSHIPPED) {
        return new ecjia_error('current_ss_not_cancel', RC_Lang::get('orders::order.current_ss_not_cancel'));
    }

    // 如果付款状态是“已付款”、“付款中”，不允许取消，要取消和商家联系
    if ($order['pay_status'] != PS_UNPAYED) {
        return new ecjia_error('current_ps_not_cancel', RC_Lang::get('orders::order.current_ps_not_cancel'));
    }

    // 将用户订单设置为取消
    $query = $db->where(array('order_id' => $order_id))->update(array('order_status' => OS_CANCELED));
    if ($query) {
        RC_Loader::load_app_func('admin_order', 'orders');
        /* 记录log */
        order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, RC_Lang::get('orders::order.buyer_cancel'), 'buyer');
        /* 退货用户余额、积分、红包 */
        if ($order['user_id'] > 0 && $order['surplus'] > 0) {
        	$options = array(
        		'user_id'		=> $order['user_id'],
        		'user_money'	=> $order['surplus'],
        		'change_desc'	=> sprintf(RC_Lang::get('orders::order.return_surplus_on_cancel'), $order['order_sn'])
        	);
        	$result = RC_Api::api('user', 'account_change_log',$options);
        	if (is_ecjia_error($result)) {
        		return $result;
        	}
        }
        if ($order['user_id'] > 0 && $order['integral'] > 0) {
            $options = array(
            	'user_id'		=> $order['user_id'],
            	'pay_points'	=> $order['integral'],
            	'change_desc'	=> sprintf(RC_Lang::get('orders::order.return_integral_on_cancel'), $order['order_sn'])
            );
            $result = RC_Api::api('user', 'account_change_log', $options);
            if (is_ecjia_error($result)) {
            	return $result;
            }
        }
        if ($order['user_id'] > 0 && $order['bonus_id'] > 0) {
        	RC_Loader::load_app_func('admin_bonus', 'bonus');
            change_user_bonus($order['bonus_id'], $order['order_id'], false);
        }

        /* 如果使用库存，且下订单时减库存，则增加库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
            change_order_goods_storage($order['order_id'], false, 1);
        }

        /* 修改订单 */
        $arr = array(
            'bonus_id' => 0,
            'bonus' => 0,
            'integral' => 0,
            'integral_money' => 0,
            'surplus' => 0
        );
        update_order($order['order_id'], $arr);
        RC_DB::table('order_status_log')->insert(array(
	        'order_status'	=> RC_Lang::get('orders::order.order_cancel'),
	        'order_id'		=> $order['order_id'],
	        'message'		=> '您的订单已取消成功！',
	        'add_time'		=> RC_Time::gmtime(),
        ));
        return true;
    } else {
        return new ecjia_error('database_query_error', $db->error());
    }
}

// end
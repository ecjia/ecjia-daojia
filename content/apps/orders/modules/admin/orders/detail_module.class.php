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
 * 订单详情
 * @author will
 */
class detail_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		$result = $this->admin_priv('order_view');
 		if (is_ecjia_error($result)) {
 			return $result;
 		}
		$order_id = $this->requestData('id', 0);
		$order_sn = $this->requestData('order_sn');

 		if (empty($order_id) && empty($order_sn)) {
 			return new ecjia_error(101, '参数错误');
		}
		RC_Loader::load_app_func('admin_order', 'orders');

		/* 订单详情 */
		$order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'order_sn' => $order_sn, 'store_id' => $_SESSION['store_id']));

		$order['label_order_source'] = '';
		/*订单来源返回处理*/
		if (!empty($order['referer'])) {
		    $order['label_order_source'] = $order['referer'];
		    unset($order['referer']);
		}
		
		if ($order === false) {
			return new ecjia_error(8, 'fail');
		}
		if (is_ecjia_error($order)) {
 			return $order;
		}
		
		/*发票抬头和发票识别码处理*/
		if (!empty($order['inv_payee'])) {
			if (strpos($order['inv_payee'],",") > 0) {
				$inv = explode(',', $order['inv_payee']);
				$order['inv_payee'] = $inv['0'];
				$order['inv_tax_no'] = $inv['1'];
				$order['inv_title_type'] = 'enterprise';
			} else {
				$order['inv_tax_no'] = '';
				$order['inv_title_type'] = 'personal';
			}
		}
		
		$db_user = RC_Model::model('user/users_model');
		$user_name = $db_user->where(array('user_id' => $order['user_id']))->get_field('user_name');

		$order['user_name'] = empty($user_name) ? __('匿名用户') : $user_name;
		//收货人地址
		$db_region = RC_Model::model('shipping/region_model');
		$region_name = $db_region->where(array('region_id' => array('in'=>$order['country'], $order['province'], $order['city'], $order['district'])))->order('region_type')->select();
		$order['country_id']  = $order['country'];
		$order['country']     = $region_name[0]['region_name'];
		$order['province_id'] = $order['province'];
		$order['province']    = $region_name[1]['region_name'];
		$order['city_id']     = $order['city'];
		$order['city']        = $region_name[2]['region_name'];
		$order['district_id'] = $order['district'];
		$order['district']    = isset($region_name[3]) ? $region_name[3]['region_name'] : '';

		$order['invoice_no']            = !empty($order['invoice_no']) ? explode('<br>', $order['invoice_no']) : array();
		
// 		$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
		if ($order['pay_id'] > 0) {
		    $payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
		}
		if (in_array($order['order_status'], array(OS_CONFIRMED, OS_SPLITED)) &&
		    in_array($order['shipping_status'], array(SS_RECEIVED)) &&
		    in_array($order['pay_status'], array(PS_PAYED, PS_PAYING)))
		{
		    $label_order_status = '已完成';
		    $status_code = 'finished';
		}
		elseif (in_array($order['shipping_status'], array(SS_SHIPPED)))
		{
		    $label_order_status = '已发货';
		    $status_code = 'shipped';
		}
		elseif (in_array($order['order_status'], array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) &&
		    in_array($order['pay_status'], array(PS_UNPAYED)) &&
		    (in_array($order['shipping_status'], array(SS_SHIPPED, SS_RECEIVED)) || !$payment['is_cod']))
		{
		    $label_order_status = '待付款';
		    $status_code = 'await_pay';
		}
		elseif (in_array($order['order_status'], array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
		    in_array($order['shipping_status'], array(SS_UNSHIPPED, SS_SHIPPED_PART, SS_PREPARING, SS_SHIPPED_ING, OS_SHIPPED_PART)) &&
		    (in_array($order['pay_status'], array(PS_PAYED, PS_PAYING)) || $payment['is_cod']))
		{
		    $label_order_status = '待发货';
		    $status_code = 'await_ship';
		}
		elseif (in_array($order['order_status'], array(OS_CANCELED))) {
		    $label_order_status = '已关闭';
		    $status_code = 'canceled';
		}
		
		$order['label_order_status']	= $label_order_status;
		$order['order_status_code']		= $status_code;
		
		
		$order['sub_orders'] = array();
		$db_orderinfo_view = RC_Model::model('orders/order_info_viewmodel');
		$total_fee = "(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) as total_fee";
		$result = ecjia_app::validate_application('seller');
		if (!is_ecjia_error($result)) {
			$sub_orders_result = $db_orderinfo_view->join(null)->field(array('oi.*,'.$total_fee))->where(array('main_order_id' => $order['order_id']))->select();
			if (!empty($sub_orders_result)) {
				$goods_db = RC_Model::model('goods/goods_model');
				$db_order_goods = RC_Model::model('orders/order_goods_model');
				foreach ($sub_orders_result as $val) {
					$seller_name = RC_Model::model('seller/seller_shopinfo_model')->where(array('id' => $val['seller_id']))->get_field('shop_name');
					$order_goods = $db_order_goods->where(array('order_id' => $val['order_id']))->select();

					$order_status = ($val['order_status'] != '2' || $val['order_status'] != '3') ? RC_Lang::get('orders::order.os.'.$val['order_status']) : '';
					$order_status = $val['order_status'] == '2' ? __('已取消') : $order_status;
					$order_status = $val['order_status'] == '3' ? __('无效') : $order_status;

					$goods_lists = array();
					if (!empty($order_goods)) {
						foreach ($order_goods as $v) {

							$goods_info = $goods_db->find(array('goods_id' => $v['goods_id']));

							$goods_lists[] = array(
								'id'			=> $v['goods_id'],
								'name'			=> $v['goods_name'],
								'seller_name'	=> !empty($seller_name) ? $seller_name : '自营',
								'shop_price'	=> price_format($v['goods_price'], false),
								'goods_sn'		=> $v['goods_sn'],
								'number'		=> $v['goods_number'],
								'img' => array(
									'thumb'	=> !empty($goods_info['goods_img']) ? RC_Upload::upload_url($goods_info['goods_img']) : '',
									'url'	=> !empty($goods_info['original_img']) ? RC_Upload::upload_url($goods_info['original_img']) : '',
									'small'	=> !empty($goods_info['goods_thumb']) ? RC_Upload::upload_url($goods_info['goods_thumb']) : '',
								),
							);
						}
					}


					$order['sub_orders'][] = array(
						'order_id'	=> $val['order_id'],
						'order_sn'	=> $val['order_sn'],
						'total_fee' => $val['total_fee'],
						'formated_total_fee' 		=> price_format($val['total_fee'], false),
						'formated_integral_money'	=> price_format($val['integral_money'], false),
						'formated_bonus'			=> price_format($val['bonus'], false),
						'formated_shipping_fee'		=> price_format($val['shipping_fee'], false),
						'formated_discount'			=> price_format($val['discount'], false),
						'status'					=> $order_status.','.RC_Lang::get('orders::order.ps.'.$val['pay_status']).','.RC_Lang::get('orders::order.ss.'.$val['shipping_status']),
						'create_time' 				=> RC_Time::local_date(ecjia::config('date_format'), $val['add_time']),
						'goods_items' 				=> $goods_lists
					);
				}
			}
		}
		$ordergoods_viewdb = RC_Model::model('orders/order_goods_goods_viewmodel');
		$goods_list = $ordergoods_viewdb->where(array('order_id' => $order['order_id']))->select();
		if (!empty($goods_list)) {
			foreach ($goods_list as $k =>$v) {
				$goods_list[$k] = array(
					'id'					=> $v['goods_id'],
					'name'					=> $v['goods_name'],
					'goods_number'			=> $v['goods_number'],
					'subtotal'				=> price_format($v['subtotal'], false),
					'goods_attr'			=> trim($v['goods_attr']),
					'formated_shop_price' 	=> price_format($v['goods_price'], false),
					'img' => array(
						'thumb'	=> !empty($v['goods_img']) ? RC_Upload::upload_url($v['goods_img']) : '',
						'url'	=> !empty($v['original_img']) ? RC_Upload::upload_url($v['original_img']) : '',
						'small'	=> !empty($v['goods_thumb']) ? RC_Upload::upload_url($v['goods_thumb']) : '',
					)
				);
			}
		}

		$order['goods_items'] = $goods_list;


		/* 取得订单操作记录 */
		$act_list = array();
		$db_order_action = RC_Model::model('orders/order_action_model');
		$data = $db_order_action->where(array('order_id' => $order['order_id']))->order(array('log_time' => 'asc' ,'action_id' => 'asc'))->select();
        if(!empty($data)) {
			foreach ($data as $key => $row) {
				$row['order_status']	= RC_Lang::get('orders::order.os.'.$row['order_status']);
				$row['pay_status']		= RC_Lang::get('orders::order.ps.'.$row['pay_status']);
				$row['shipping_status']	= RC_Lang::get('orders::order.ss.'.$row['shipping_status']);
				$row['order_status']	= strip_tags($row['order_status']);//处理html标签
				$row['action_time']		= RC_Time::local_date(ecjia::config('time_format'), $row['log_time']);
                $act_list[]				= array(
					'action_time'		=> $row['action_time'],
					'log_description'	=> $row['action_user'].' 操作此订单，变更状态为：'.$row['order_status'].'、'.$row['pay_status'].'、'.$row['shipping_status'].(!empty($row['action_note']) ? '，理由是'.$row['action_note'] : '。'),
                    'order_status'      => $row['order_status'],
    				'pay_status'		=> $row['pay_status'],
    				'shipping_status'	=> $row['shipping_status'],
			   );
			}
		}
		$order['action_logs']   = $act_list;
		return $order;
	}
}

// end
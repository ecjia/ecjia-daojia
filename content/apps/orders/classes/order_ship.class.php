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
 * 订单发货
 */
class order_ship {
	
	/**
	 * 订单发货
	 * 
	 */
	public static function delivery_ship($order_id, $delivery_id, $invoice_no, $action_note) {
		RC_Logger::getLogger('error')->info('订单发货处理【订单id|'.$order_id.'】');
		RC_Loader::load_app_func('global', 'orders');
		RC_Loader::load_app_func('admin_order', 'orders');
		$db_delivery = RC_Loader::load_app_model('delivery_viewmodel','orders');
		$db_delivery_order		= RC_Loader::load_app_model('delivery_order_model','orders');
		$db_goods				= RC_Loader::load_app_model('goods_model','goods');
		$db_products			= RC_Loader::load_app_model('products_model','goods');
		/* 取得参数 */
		$delivery				= array();
		$order_id				= intval(trim($order_id));			// 订单id
		$delivery_id			= intval(trim($delivery_id));		// 发货单id
		$delivery['invoice_no']	= isset($invoice_no) ? trim($invoice_no) : '';
		$action_note			= isset($action_note) ? trim($action_note) : '';
	
		/* 根据发货单id查询发货单信息 */
		if (!empty($delivery_id)) {
			$delivery_id = intval($delivery_id);
			$delivery_order = delivery_order_info($delivery_id);
		}
		
		if (empty($delivery_order)) {
			return new ecjia_error('delivery_error', __('无法找到对应发货单！'));
		}
	
		/* 查询订单信息 */
		$order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'order_sn' => ''));
		
		/* 检查此单发货商品库存缺货情况 */
		$virtual_goods			= array();
	
		$delivery_stock_result = RC_DB::table('delivery_goods as dg')
		->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
		->leftJoin('products as p', RC_DB::raw('dg.product_id'), '=', RC_DB::raw('p.product_id'))
		->select(RC_DB::raw('dg.goods_id'), RC_DB::raw('dg.is_real'), RC_DB::raw('dg.product_id'), RC_DB::raw('SUM(dg.send_number) AS sums'), RC_DB::raw("IF(dg.product_id > 0, p.product_number, g.goods_number) AS storage"), RC_DB::raw('g.goods_name'), RC_DB::raw('dg.send_number'))
		->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
		->groupBy(RC_DB::raw('dg.product_id'))
		->get();
	
	
		/* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
		if(!empty($delivery_stock_result)) {
			foreach ($delivery_stock_result as $value) {
				if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) &&
				((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
						(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
					RC_Logger::getLogger('error')->info('缺货处理a');
					return new ecjia_error('act_good_vacancy', sprintf(RC_Lang::lang('act_good_vacancy'), $value['goods_name']));
				}
	
				/* 虚拟商品列表 virtual_card */
				if ($value['is_real'] == 0) {
					$virtual_goods[] = array(
							'goods_id'		=> $value['goods_id'],
							'goods_name'	=> $value['goods_name'],
							'num'			=> $value['send_number']
					);
				}
			}
		} else {
			$delivery_stock_result = RC_DB::table('delivery_goods as dg')
			->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
			->select(RC_DB::raw('dg.goods_id'), RC_DB::raw('dg.is_real'), RC_DB::raw('SUM(dg.send_number) AS sums'), RC_DB::raw('g.goods_number'), RC_DB::raw('g.goods_name'), RC_DB::raw('dg.send_number'))
			->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
			->groupBy(RC_DB::raw('dg.goods_id'))
			->get();
	
			foreach ($delivery_stock_result as $value) {
				if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) &&
				((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
						(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
					RC_Logger::getLogger('error')->info('缺货处理b');
					return new ecjia_error('act_good_vacancy', sprintf(RC_Lang::lang('act_good_vacancy'), $value['goods_name']));
				}
	
				/* 虚拟商品列表 virtual_card*/
				if ($value['is_real'] == 0) {
					$virtual_goods[] = array(
							'goods_id'		=> $value['goods_id'],
							'goods_name'	=> $value['goods_name'],
							'num'			=> $value['send_number']
					);
				}
			}
		}
	
		/* 如果使用库存，且发货时减库存，则修改库存 */
		if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
			foreach ($delivery_stock_result as $value) {
				/* 商品（实货）、超级礼包（实货） */
				if ($value['is_real'] != 0) {
					/* （货品） */
					if (!empty($value['product_id'])) {
						$data = array(
								'product_number' => $value['storage'] - $value['sums'],
						);
						$db_products->where(array('product_id' => $value['product_id']))->update($data);
					} else {
						$data = array(
								'goods_number' => $value['storage'] - $value['sums'],
						);
						$db_goods->where(array('goods_id' => $value['goods_id']))->update($data);
					}
				}
			}
		}
	
		/* 修改发货单信息 */
		$invoice_no = str_replace(',', '<br>', $delivery['invoice_no']);
		$invoice_no = trim($invoice_no, '<br>');
		$_delivery['invoice_no']	= $invoice_no;
		$_delivery['status']		= 0;	/* 0，为已发货 */
		$result = $db_delivery_order->where(array('delivery_id' => $delivery_id))-> update($_delivery);
	
		if (!$result) {
			return new ecjia_error('act_false', RC_Lang::lang('act_false'));
		}
	
		/* 标记订单为已确认 “已发货” */
		/* 更新发货时间 */
		$order_finish				= get_all_delivery_finish($order_id);
	
		$shipping_status			= ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
		$arr['shipping_status']		= $shipping_status;
		$arr['shipping_time']		= RC_Time::gmtime(); // 发货时间
		$arr['invoice_no']			= trim($order['invoice_no'] . '<br>' . $invoice_no, '<br>');
		update_order($order_id, $arr);
	
		/* 发货单发货记录log */
// 		order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], '收银台发货', null, 1);
		// 记录管理员操作
		if ($_SESSION['store_id'] > 0) {
			RC_Api::api('merchant', 'admin_log', array('text' => '发货，订单号是'.$order['order_sn'].'【来源掌柜】', 'action' => 'setup', 'object' => 'order'));
		} else {
			ecjia_admin::admin_log('发货，订单号是'.$order['order_sn'].'【来源掌柜】', 'setup', 'order'); // 记录日志
		}
	
	
		RC_Logger::getLogger('error')->info('判断是否全部发货'.$order_finish);
	
	
		/* 如果当前订单已经全部发货 */
		if ($order_finish) {
			RC_Logger::getLogger('error')->info('订单发货，积分红包处理');
			/* 如果订单用户不为空，计算积分，并发给用户；发红包 */
			if ($order['user_id'] > 0) {
				 
				 
				/* 取得用户信息 */
				$user = user_info($order['user_id']);
				/* 计算并发放积分 */
				$integral = integral_to_give($order);
				$integral_name = ecjia::config('integral_name');
				if (empty($integral_name)) {
					$integral_name = '积分';
				}
				$options = array(
						'user_id'		=> $order['user_id'],
						'rank_points'	=> intval($integral['rank_points']),
						'pay_points'	=> intval($integral['custom_points']),
						'change_desc'	=>'订单'.$order['order_sn'].'赠送的'.$integral_name,
						'from_type'		=> 'order_give_integral',
						'from_value'	=> $order['order_sn'],
				);
				RC_Api::api('user', 'account_change_log',$options);
				/* 发放红包 */
				send_order_bonus($order_id);
			}
		}
	
		return true;
	}
}	


// end
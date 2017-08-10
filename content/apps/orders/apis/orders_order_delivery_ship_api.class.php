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
 * 订单发货接口
 * @author will.chen
 */
class orders_order_delivery_ship_api extends Component_Event_Api {
    /**
     * @param  $options['order_id'] 订单ID
     *         $options['order_sn'] 订单号
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || (!isset($options['order_id']) 
	        && !isset($options['order_sn']))) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
		return $this->order_info($options['order_id'], $options['order_sn']);
	}
	
	private function delivery_ship() {
		$db_delivery_goods = RC_DB::table('delivery_goods as dg');
		/* 定义当前时间 */
		define('GMTIME_UTC', RC_Time::gmtime()); // 获取 UTC 时间戳
		/* 取得参数 */
		$delivery				= array();
		$order_id				= intval(trim($_POST['order_id']));			// 订单id
		$delivery_id			= intval(trim($_POST['delivery_id']));		// 发货单id
		$delivery['invoice_no']	= isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '';
		$action_note			= !empty($_POST['action_note']) ? trim($_POST['action_note']) : '';
		
		/* 根据发货单id查询发货单信息 */
		if (!empty($delivery_id)) {
			$delivery_order = delivery_order_info($delivery_id);
		} else {
			return $this->showmessage(RC_Lang::get('orders::order.no_delivery_order'), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR);
		}
		if (empty($delivery_order)) {
			return $this->showmessage(RC_Lang::get('orders::order.no_delivery_order'), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR);
		}
		/* 查询订单信息 */
		$order = order_info($order_id);
		
		/* 检查此单发货商品库存缺货情况 */
		$virtual_goods			= array();
		$delivery_stock_result = $db_delivery_goods
			->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
			->leftJoin('products as p', RC_DB::raw('dg.product_id'), '=', RC_DB::raw('p.product_id'))
			->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
			->selectRaw('dg.goods_id, dg.is_real, dg.product_id, SUM(dg.send_number) AS sums, IF(dg.product_id > 0, p.product_number, g.goods_number) AS storage, g.goods_name, dg.send_number')
			->groupby(RC_DB::raw('dg.product_id'))
			->get();
			
		/* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
		if (!empty($delivery_stock_result)) {
			foreach ($delivery_stock_result as $value) {
				if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) &&
				((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
						(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
						
					/* 操作失败 */
					$links[] = array('text' => RC_Lang::get('orders::order.order_info'), 'href' => RC_Uri::url('orders/admin_order_delivery/delivery_info', 'delivery_id=' . $delivery_id));
					return $this->showmessage(sprintf(RC_Lang::get('orders::order.act_goods_vacancy'), $value['goods_name']), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
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
			
			$delivery_stock_result = $db_delivery_goods
				->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
				->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
				->selectRaw('dg.goods_id, dg.is_real, SUM(dg.send_number) AS sums, g.goods_number, g.goods_name, dg.send_number')
				->groupby(RC_DB::raw('dg.product_id'))
				->get();
		
			foreach ($delivery_stock_result as $value) {
				if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) &&
				((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
						(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
					/* 操作失败 */
					$links[] = array('text' => RC_Lang::get('orders::order.order_info'), 'href' => RC_Uri::url('orders/order_delilvery/delivery_info', 'delivery_id=' . $delivery_id));
					return $this->showmessage(sprintf(RC_Lang::get('orders::order.act_goods_vacancy'), $value['goods_name']), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
					break;
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
		
		/* 发货 */
		/* 处理虚拟卡 商品（虚货） */
		if (is_array($virtual_goods) && count($virtual_goods) > 0) {
			foreach ($virtual_goods as $virtual_value) {
				//虚拟商品不支持
// 				virtual_card_shipping($virtual_value,$order['order_sn'], $msg, 'split');
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
						RC_DB::table('products')->where('product_id', $value['product_id'])->update($data);
					} else {
						$data = array(
							'goods_number' => $value['storage'] - $value['sums'],
						);
						RC_DB::table('goods')->where('goods_id', $value['goods_id'])->update($data);
					}
				}
			}
		}
		
		/* 修改发货单信息 */
		$invoice_no = str_replace(',', '<br>', $delivery['invoice_no']);
		$invoice_no = trim($invoice_no, '<br>');
		$_delivery['invoice_no']	= $invoice_no;
		$_delivery['status']		= 0;	/* 0，为已发货 */
		$result = RC_DB::table('delivery_order')->where('delivery_id', $delivery_id)->update($_delivery);
		
		if (!$result) {
			/* 操作失败 */
			$links[] = array('text' => RC_Lang::get('orders::order.delivery_sn') . RC_Lang::get('orders::order.detail'), 'href' => RC_Uri::url('orders/admin_order_delivery/delivery_info','delivery_id=' . $delivery_id));
			return $this->showmessage(RC_Lang::get('orders::order.act_false'), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
		}
		
		/* 标记订单为已确认 “已发货” */
		/* 更新发货时间 */
		$order_finish				= get_all_delivery_finish($order_id);
		$shipping_status			= ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
		$arr['shipping_status']		= $shipping_status;
		$arr['shipping_time']		= GMTIME_UTC; // 发货时间
		$arr['invoice_no']			= trim($order['invoice_no'] . '<br>' . $invoice_no, '<br>');
		update_order($order_id, $arr);
		
		/* 发货单发货记录log */
		order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note, null, 1);
		ecjia_admin::admin_log(RC_Lang::get('orders::order.op_ship').' '.RC_Lang::get('orders::order.order_is').$order['order_sn'], 'setup', 'order');
		
		/* 如果当前订单已经全部发货 */
		if ($order_finish) {
			/* 如果订单用户不为空，计算积分，并发给用户；发红包 */
			if ($order['user_id'] > 0) {
				/* 取得用户信息 */
				$user = user_info($order['user_id']);
				/* 计算并发放积分 */
				$integral = integral_to_give($order);
				$options = array(
					'user_id'		=> $order['user_id'],
					'rank_points'	=> intval($integral['rank_points']),
					'pay_points'	=> intval($integral['custom_points']),
					'change_desc'	=> sprintf(RC_Lang::get('orders::order.order_gift_integral'), $order['order_sn'])
				);
				RC_Api::api('user', 'account_change_log',$options);
				/* 发放红包 */
				send_order_bonus($order_id);
			}
		
			/* 发送邮件 */
			$cfg = ecjia::config('send_ship_email');
			if ($cfg == '1') {
				$order['invoice_no'] = $invoice_no;
				$tpl_name = 'deliver_notice';
				$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
		
				$this->assign('order', $order);
				$this->assign('send_time', RC_Time::local_date(ecjia::config('time_format')));
				$this->assign('shop_name', ecjia::config('shop_name'));
				$this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
				$this->assign('confirm_url', SITE_URL . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
				$this->assign('send_msg_url', SITE_URL . RC_Uri::url('user/admin/message_list','order_id=' . $order['order_id']));
		
				$content = $this->fetch_string($tpl['template_content']);
		
				if (!RC_Mail::send_mail($order['consignee'], $order['email'] , $tpl['template_subject'], $content, $tpl['is_html'])) {
					return $this->showmessage(RC_Lang::get('orders::order.send_mail_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			
			/* 如果需要，发短信 */
			if (!empty($order['mobile'])) {
			    //发送短信
			    $user_name = RC_DB::TABLE('users')->where('user_id', $order['user_id'])->pluck('user_name');
			    $options = array(
			        'mobile' => $order['mobile'],
			        'event'	 => 'sms_order_shipped',
			        'value'  =>array(
			            'user_name'    => $user_name,
			            'order_sn'     => $order['order_sn'],
			            'consignee'    => $order['consignee'],
			            'service_phone'=> ecjia::config('service_phone'),
			        ),
			    );
			    RC_Api::api('sms', 'send_event_sms', $options);
			}
		}
	}
}

// end
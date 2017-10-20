<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 验单
 * @author will
 *
 */
class check_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		$device = $this->device;
		if ($device['device_code'] != '8001') {
			$result = $this->admin_priv('order_view');
			if (is_ecjia_error($result)) {
				return $result;
			}
		}
		
 		$verification_code = $this->requestData('verify_code');
 		$id = $this->requestData('order_id', 0);
 		if (empty($verification_code)) {
 			return new ecjia_error('invalid_parameter', '参数错误');
 		}
 		$db_term_meta = RC_Loader::load_model('term_meta_model');
 		$meta_where = array(
 				'object_type'	=> 'ecjia.order',
 				'object_group'	=> 'order',
 				'meta_key'		=> 'receipt_verification',
 				'meta_value'	=> $verification_code,
 		);
 		$order_count = $db_term_meta->where($meta_where)->count();
 		if ($order_count > 1) {
 			return new ecjia_error('repeat_error', '验证码重复，请与管理员联系！');
 		}
 		
 		$order_id = $db_term_meta->where($meta_where)->get_field('object_id');
 		if (empty($order_id)) {
 			return new ecjia_error('verification_code_error', '验证码错误！');
		}
		
		if ($id == 0) {
			return array('order_id' => $order_id);
		}
		if ($id != $order_id) {
			return new ecjia_error('verification_code_error', '验证码错误！');
		}
		/* 查询订单信息 */
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'order_sn' => ''));
		/* 判断发货情况*/
		if ($order_info['shipping_status'] > SS_UNSHIPPED) {
			return new ecjia_error('order_shipped', __('该订单已发货！无法进行此操作'));
		} else {
		    $action_note = '验单';
			/* 进行确认*/
			RC_Api::api('orders', 'order_operate', array('order_id' => $order_id, 'order_sn' => '', 'operation' => 'confirm', 'note' => array('action_note' => $action_note)));
			/* 进行付款*/
			RC_Api::api('orders', 'order_operate', array('order_id' => $order_id, 'order_sn' => '', 'operation' => 'pay', 'note' => array('action_note' => $action_note)));
			/* 配货*/
			RC_Api::api('orders', 'order_operate', array('order_id' => $order_id, 'order_sn' => '', 'operation' => 'prepare', 'note' => array('action_note' => $action_note)));
			/* 分单（生成发货单）*/
			$result = RC_Api::api('orders', 'order_operate', array('order_id' => $order_id, 'order_sn' => '', 'operation' => 'split', 'note' => array('action_note' => $action_note)));
				
			if (is_ecjia_error($result)) {
				return $result;
			}
			/* 发货*/
			$db_delivery_order	= RC_Loader::load_app_model('delivery_order_model', 'orders');
			$delivery_id = $db_delivery_order->where(array('order_sn' => array('like' => '%'.$order_info['order_sn'].'%')))->order(array('delivery_id' => 'desc'))->get_field('delivery_id');
				
			$result = delivery_ship($order_id, $delivery_id);
			/* 货到付款再次进行付款*/
			RC_Api::api('orders', 'order_operate', array('order_id' => $order_id, 'order_sn' => '', 'operation' => 'pay', 'note' => array('action_note' => $action_note)));
			/* 确认收货*/
			RC_Api::api('orders', 'order_operate', array('order_id' => $order_id, 'order_sn' => '', 'operation' => 'receive', 'note' => array('action_note' => $action_note)));
			
			/*收银员订单操作记录*/
			$device_info = RC_DB::table('mobile_device')->where('id', $_SESSION['device_id'])->first();
			$cashier_record = array(
					'store_id' 			=> $_SESSION['store_id'],
					'staff_id'			=> $_SESSION['staff_id'],
					'order_id'	 		=> $order_id,
					'order_type' 		=> 'ecjia-cashdesk',
					'mobile_device_id'	=> $_SESSION['device_id'],
					'device_sn'			=> $device_info['device_udid'],
					'device_type'		=> 'ecjia-cashdesk',
					'action'   	 		=> 'check_order', //验单
					'create_at'	 		=> RC_Time::gmtime(),
			);
			RC_DB::table('cashier_record')->insert($cashier_record);
			
 			//员工日志
			/* 查询订单信息 */
			$order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'order_sn' => ''));
			if ($_SESSION['store_id'] > 0) {
			    RC_Api::api('merchant', 'admin_log', array('text'=>'验单，订单号：'.$order['order_sn'].'【来源掌柜】', 'action'=>'edit', 'object'=>'order'));
			} else {
			    ecjia_admin::admin_log('验单，订单号：'.$order['order_sn'].'【来源掌柜】', 'edit', 'order'); // 记录日志
			}
		}
		
		
		return array();
		
	}
}


function delivery_ship($order_id, $delivery_id) {
	RC_Loader::load_app_func('function', 'orders');
	RC_Loader::load_app_func('order', 'orders');
	$db_delivery = RC_Loader::load_app_model('delivery_viewmodel','orders');
	$db_delivery_order		= RC_Loader::load_app_model('delivery_order_model','orders');
	$db_goods				= RC_Loader::load_app_model('goods_model','goods');
	$db_products			= RC_Loader::load_app_model('products_model','goods');
	RC_Lang::load('order');
	/* 定义当前时间 */
	define('GMTIME_UTC', RC_Time::gmtime()); // 获取 UTC 时间戳
	/* 取得参数 */
	$delivery				= array();
	$order_id				= intval(trim($order_id));			// 订单id
	$delivery_id			= intval(trim($delivery_id));		// 发货单id
	$delivery['invoice_no']	= isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '';
	$action_note			= isset($_POST['action_note']) ? trim($_POST['action_note']) : '';

	/* 根据发货单id查询发货单信息 */
	if (!empty($delivery_id)) {
		$delivery_order = delivery_order_info($delivery_id);
	} else {
		return new ecjia_error('delivery_id_error', __('无法找到对应发货单！'));
		// 		$this->showmessage( __('无法找到对应发货单！') , ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR);
	}
	if (empty($delivery_order)) {
		return new ecjia_error('delivery_error', __('无法找到对应发货单！'));
	}
	// 	/* 查询订单信息 */
	// 	$order = order_info($order_id);
	/* 查询订单信息 */
	$order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'order_sn' => ''));


	/* 检查此单发货商品库存缺货情况 */
	$virtual_goods			= array();
	$delivery_stock_result	= $db_delivery->join(array('goods', 'products'))->where(array('dg.delivery_id' => $delivery_id))->group('dg.product_id')->select();

	/* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
	if(!empty($delivery_stock_result)) {
		foreach ($delivery_stock_result as $value) {
			if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) &&
			((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
					(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
				return new ecjia_error('act_good_vacancy', sprintf(RC_Lang::lang('act_good_vacancy'), $value['goods_name']));
				// 				/* 操作失败 */
				// 				$links[] = array('text' => RC_Lang::lang('order_info'), 'href' => RC_Uri::url('orders/admin_order_delivery/delivery_info', 'delivery_id=' . $delivery_id));
				// 				$this->showmessage(sprintf(RC_Lang::lang('act_good_vacancy'), $value['goods_name']), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
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
		$db_delivery->view = array(
				'goods' => array(
						'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'		=> 'g',
						'field'		=> 'dg.goods_id, dg.is_real, SUM(dg.send_number) AS sums, g.goods_number, g.goods_name, dg.send_number',
						'on'		=> 'dg.goods_id = g.goods_id ',
				)
		);

		$delivery_stock_result = $db_delivery->where(array('dg.delivery_id' => $delivery_id))->group('dg.goods_id')->select();

		foreach ($delivery_stock_result as $value) {
			if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) &&
			((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
					(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
				return new ecjia_error('act_good_vacancy', sprintf(RC_Lang::lang('act_good_vacancy'), $value['goods_name']));
				// 				/* 操作失败 */
				// 				$links[] = array('text' => RC_Lang::lang('order_info'), 'href' => RC_Uri::url('orders/order_delilvery/delivery_info', 'delivery_id=' . $delivery_id));
				// 				$this->showmessage(sprintf(RC_Lang::lang('act_good_vacancy'), $value['goods_name']), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
				// 				break;
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
		RC_Loader::load_app_func('common', 'goods');
		foreach ($virtual_goods as $virtual_value) {
			virtual_card_shipping($virtual_value,$order['order_sn'], $msg, 'split');
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
		// 		/* 操作失败 */
		// 		$links[] = array('text' => RC_Lang::lang('delivery_sn') . RC_Lang::lang('detail'), 'href' => RC_Uri::url('orders/admin_order_delivery/delivery_info','delivery_id=' . $delivery_id));
		// 		$this->showmessage(RC_Lang::lang('act_false'), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
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
	ecjia_admin::admin_log('发货，订单号是'.$order['order_sn'], 'setup', 'order');

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
					'change_desc'	=> sprintf(RC_Lang::lang('order_gift_integral'), $order['order_sn'])
			);
			RC_Api::api('user', 'account_change_log',$options);
			/* 发放红包 */
			send_order_bonus($order_id);
		}

		/* 发送邮件 */
		$cfg = ecjia::config('send_ship_email');
		if ($cfg == '1') {
			$order['invoice_no'] = $invoice_no;
			//$tpl = get_mail_template('deliver_notice');
			$tpl_name = 'deliver_notice';
			$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);

			ecjia_admin::$controller->assign('order'			, $order);
			ecjia_admin::$controller->assign('send_time'		, RC_Time::local_date(ecjia::config('time_format')));
			ecjia_admin::$controller->assign('shop_name'		, ecjia::config('shop_name'));
			ecjia_admin::$controller->assign('send_date'		, RC_Time::local_date(ecjia::config('date_format')));
			ecjia_admin::$controller->assign('confirm_url'		, SITE_URL . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
			ecjia_admin::$controller->assign('send_msg_url'	, SITE_URL . RC_Uri::url('user/admin/message_list','order_id=' . $order['order_id']));

			$content = ecjia_admin::$controller->fetch_string($tpl['template_content']);

			if (!RC_Mail::send_mail($order['consignee'], $order['email'] , $tpl['template_subject'], $content, $tpl['is_html'])) {
				// 				$this->showmessage(RC_Lang::lang('send_mail_fail') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$result = ecjia_app::validate_application('sms');
		if (!is_ecjia_error($result)) {
			/* 如果需要，发短信 */
			if (ecjia::config('sms_order_shipped') == '1' && $order['mobile'] != '') {
				//发送短信
				$tpl_name = 'order_shipped_sms';
				$tpl   = RC_Api::api('sms', 'sms_template', $tpl_name);
				if (!empty($tpl)) {
					ecjia_admin::$controller->assign('order_sn', $order['order_sn']);
					ecjia_admin::$controller->assign('shipped_time', RC_Time::local_date(RC_Lang::lang('sms_time_format')));
					ecjia_admin::$controller->assign('mobile', $order['mobile']);

					$content = ecjia_admin::$controller->fetch_string($tpl['template_content']);

					$options = array(
							'mobile' 		=> $order['mobile'],
							'msg'			=> $content,
							'template_id' 	=> $tpl['template_id'],
					);
					$response = RC_Api::api('sms', 'sms_send', $options);
				}
			}
		}
	}

	return true;
}


// end
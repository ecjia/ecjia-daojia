<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台售后申请单生成
 * @author zrl
 *
 */
class refund_refund_apply_api extends Component_Event_Api {
    /**
     * @param  array $options['order_id']	订单id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', '调用api文件,refund_apply,参数无效');
		}
		return $this->generate_refund_order($options);
	}
	
	
	/**
	 * 售后申请单生成
	 * @param   array $options	条件参数
	 * @return  int   售后申请id
	 */
	
	private function generate_refund_order($options) {
		$device = $options['device'];
		$order_id = $options['order_id'];
		//当前订单是否可申请售后
		$order_info = $options['order_info'];
		if (in_array($order_info['pay_status'], array(PS_UNPAYED))
		|| in_array($order_info['order_status'], array(OS_CANCELED, OS_INVALID))
		|| ($order_info['is_delete'] == '1')
		) {
			return new ecjia_error('error_apply', '当前订单不可申请售后！');
		}
		
		//查询当前订单有没申请过售后
		RC_Loader::load_app_class('order_refund', 'refund', false);
		//过滤掉已取消的和退款处理成功的，保留在处理中的申请
		$order_refund_info = order_refund::currorder_refund_info($order_id);
		if (!empty($order_refund_info)) {
			$refund_id = $order_refund_info['refund_id'];
			//已存在处理中的申请或退款成功的申请
			if (($order_refund_info['status'] == Ecjia\App\Refund\RefundStatus::UNCHECK)
			|| ($order_refund_info['status'] == Ecjia\App\Refund\RefundStatus::REFUSED)
			|| (($order_refund_info['status'] == Ecjia\App\Refund\RefundStatus::AGREE) && ($order_refund_info['refund_staus'] == Ecjia\App\Refund\RefundStatus::UNTRANSFER))
			|| (($order_refund_info['status'] == Ecjia\App\Refund\RefundStatus::AGREE) && ($order_refund_info['refund_staus'] == Ecjia\App\Refund\RefundStatus::TRANSFERED))
			) {
				return new ecjia_error('error_apply', '当前订单已申请了售后！');
			} 
		} else {
			//退款编号
			$refund_sn = ecjia_order_refund_sn();
			//配送方式信息
			if (!empty($order_info['shipping_id'])) {
				$shipping_id = intval($order_info['shipping_id']);
				$shipping_info = ecjia_shipping::pluginData($shipping_id);
				$shipping_code = $shipping_info['shipping_code'];
				$shipping_name = $shipping_info['shipping_name'];
			} else {
				$shipping_code = NULL;
				$shipping_name = '无需物流';
			}
			//支付方式信息
			if (!empty($order_info['pay_id'])) {
				$payment_info = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order_info['pay_id']);
				$pay_code = $payment_info['pay_code'];
				$pay_name = $payment_info['pay_name'];
			} else {
				$pay_code = NULL;
				$pay_name = '';
			}
			$refund_type = $options['refund_type'];
			
			//订单的配送状态，订单是否配送了
			if ($order_info['shipping_status'] > SS_UNSHIPPED) {
				$shipping_whether = 1;
			} else {
				$shipping_whether = 0;
			}
			
			$refund_data = array(
					'store_id'			=> $order_info['store_id'],
					'user_id'			=> !empty($order_info['user_id']) ? $order_info['user_id'] : 0,
					'user_name'			=> !empty($order_info['user_name']) ? $order_info['user_name'] : '',
					'refund_type'		=> $refund_type,
					'refund_sn'			=> $refund_sn,
					'order_id'			=> $order_id,
					'order_sn'			=> $order_info['order_sn'],
					'shipping_code'		=> $shipping_code,
					'shipping_name'		=> $shipping_name,
					'shipping_fee'		=> $order_info['shipping_fee'],
					'shipping_whether' 	=> $shipping_whether,
					'insure_fee'		=> $order_info['insure_fee'],
					'pay_code'			=> $pay_code,
					'pay_name'			=> $payment_info['pay_name'],
					'goods_amount'		=> $order_info['goods_amount'],
					'pay_fee'			=> $order_info['pay_fee'],
					'pack_id'			=> $order_info['pack_id'],
					'pack_fee'			=> $order_info['pack_fee'],
					'card_id'			=> $order_info['card_id'],
					'card_fee'			=> $order_info['card_fee'],
					'bonus_id'			=> $order_info['bonus_id'],
					'bonus'				=> $order_info['bonus'],
					'surplus'			=> $order_info['surplus'],
					'integral'			=> $order_info['integral'],
					'integral_money'	=> $order_info['integral_money'],
					'discount'			=> $order_info['discount'],
					'inv_tax'			=> $order_info['tax'],
					'order_amount'		=> $order_info['order_amount'],
					'money_paid'		=> $order_info['money_paid'],
					'status'			=> 0,//待审核
					'refund_content'	=> $options['refund_content'],
					'refund_reason'		=> $options['refund_reason'],
					'return_status'		=> 1,//买家未发货
					'add_time'			=> RC_Time::gmtime(),
					//'referer'			=> ! empty($order_info['referer']) ? $device['client'] : 'mobile'
			);
			if (!empty($options['is_cashdesk'])) {
				$refund_data['referer'] = 'ecjia-cashdesk';
			} else {
				$refund_data['referer'] = 'mobile';
			}
			
			//插入售后申请表数据
			$refund_id = RC_DB::table('refund_order')->insertGetId($refund_data);
			
			if ($refund_id) {
				//退商品
				if ($refund_type == 'return') {
					//获取订单的发货单列表
					$delivery_list = order_refund::currorder_delivery_list($order_id);
					if (!empty($delivery_list)) {
						foreach ($delivery_list as $row) {
							//获取发货单的发货商品列表
							$delivery_goods_list   = order_refund::delivery_goodsList($row['delivery_id']);
							if (!empty($delivery_goods_list)) {
								foreach ($delivery_goods_list as $res) {
									$refund_goods_data = array(
											'refund_id'		=> $refund_id,
											'goods_id'		=> $res['goods_id'],
											'product_id'	=> $res['product_id'],
											'goods_name'	=> $res['goods_name'],
											'goods_sn'		=> $res['goods_sn'],
											'is_real'		=> $res['is_real'],
											'send_number'	=> $res['send_number'],
											'goods_attr'	=> $res['goods_attr'],
											'brand_name'	=> $res['brand_name']
									);
									$refund_goods_id = RC_DB::table('refund_goods')->insertGetId($refund_goods_data);
									/* 如果使用库存，则增加库存（不论何时减库存都需要） */
									if (ecjia::config('use_storage') == '1') {
										if ($res['send_number'] > 0) {
											RC_DB::table('goods')->where('goods_id', $res['goods_id'])->increment('goods_number', $res['send_number']);
										}
									}
								}
							}
						}
					}
						
					/* 修改订单的发货单状态为退货 */
					$delivery_order_data = array(
							'status' => 1,
					);
					RC_DB::table('delivery_order')->where('order_id', $order_info['order_id'])->whereIn('status', array(0,2))->update($delivery_order_data);
						
					/* 将订单的商品发货数量更新为 0 */
					$order_goods_data = array(
							'send_number' => 0,
					);
						
					RC_DB::table('order_goods')->where('order_id', $order_info['order_id'])->update($order_goods_data);
				}
			}
			
			//更改订单状态
			RC_DB::table('order_info')->where('order_id', $order_id)->update(array('order_status' => OS_RETURNED));
			//订单操作记录log
			order_refund::order_action($order_id, OS_RETURNED, $order_info['shipping_status'], $order_info['pay_status'], '商家收银台退款', '商家');
			//订单状态log记录
			$pra = array('order_status' => '申请退款', 'order_id' => $order_id, 'message' => '收银台退款申请已提交成功！');
			order_refund::order_status_log($pra);
			
			//售后申请状态记录
			$opt = array('status' => '申请退款', 'refund_id' => $refund_id, 'message' => '收银台退款申请已提交成功！');
			order_refund::refund_status_log($opt);
			
			return $refund_id;
		}
	}
}

// end
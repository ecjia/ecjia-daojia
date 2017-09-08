<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 商家今日订单列表
 * @author zrl
 *
 */
class today_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		$result = $this->admin_priv('order_view');
		
		if (is_ecjia_error($result)) {
			return $result;
		}
		
		$type		= $this->requestData('type');
		$time = RC_Time::gmtime();
		$last_refresh_time = $this->requestData('last_refresh_time');
		
		if (empty($last_refresh_time)) {
			$last_refresh_time = RC_Time::local_date(ecjia::config('date_format'), $time);
		}
		
		$start_date = RC_Time::local_strtotime(RC_Time::local_date(ecjia::config('date_format'), $time));
		$end_date = $start_date + 86399;
		$last_refresh_time = RC_Time::local_strtotime($last_refresh_time);
		
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		
		$order_query = RC_Loader::load_app_class('order_query', 'orders');
		$db = RC_Loader::load_app_model('order_info_model', 'orders');
		$db_view = RC_Loader::load_app_model('order_info_viewmodel', 'orders');
		
		$where = array();
		$where1 = array();
		$has_new_order = 0;
		
		$where1['oi.add_time'] = array('egt' => $start_date, 'elt' => $end_date);
		if (!empty($last_refresh_time) && $type == 'payed') {
			$where1['oi.pay_time'] = array('egt' => $last_refresh_time, 'elt'=> $time);
		}
		
		if (!empty($type)) {
			switch ($type) {
				case 'await_pay':
					$where = $order_query->order_await_pay('oi.');
					break;
				case 'payed' :
					$where = $order_query->order_await_ship('oi.');
					break;
				case 'await_ship':
					$where = $order_query->order_await_ship('oi.');
					break;
				case 'shipped':
					$where = $order_query->order_shipped('oi.');
					break;
				case 'finished':
					$where = $order_query->order_finished('oi.');
					break;
				case 'refund':
					$where = $order_query->order_refund('oi.');
					break;
				case 'closed' :
					$where = array_merge($order_query->order_invalid('oi.'),$order_query->order_canceled('oi.'));
					break;
			}
		}
		if (!empty($where1)) {
			$where = array_merge($where1, $where);
		}
		
		$total_fee = "(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) as total_fee";
		$field = 'oi.order_id, oi.order_sn, oi.integral, oi.consignee, oi.mobile, oi.tel, oi.order_status, oi.pay_status, oi.shipping_status, oi.pay_id, oi.pay_name, '.$total_fee.', oi.integral_money, oi.bonus, oi.shipping_fee, oi.discount, oi.money_paid, oi.surplus, oi.order_amount, oi.add_time, og.goods_number, og.goods_id,  og.goods_name, oi.store_id, g.goods_img, g.goods_thumb, g.original_img';
			
		$db_orderinfo_view = RC_Loader::load_app_model('order_info_viewmodel', 'orders');
		$result = ecjia_app::validate_application('store');
		if (!is_ecjia_error($result)) {
			$db_orderinfo_view->view = array(
					'order_goods' => array(
							'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
							'alias'	=> 'og',
							'on'	=> 'oi.order_id = og.order_id'
					),
					'goods' => array(
							'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
							'alias'	=> 'g',
							'on'	=> 'g.goods_id = og.goods_id'
					),
			);
		
			if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
				$where['oi.store_id'] = $_SESSION['store_id'];
			}

			/*获取记录条数*/
			$record_count = $db_orderinfo_view->join(array('order_goods'))->where($where)->count('DISTINCT oi.order_id');
			/*已付款刷新是否有新订单*/
			if (!empty($last_refresh_time) && ($type == 'payed')) {
				$has_new_order = 0;
				if (!empty($record_count)){
					$has_new_order = 1;
				}
				unset($where['oi.pay_time']);
				$record_count = $db_orderinfo_view->join(null)->where($where)->count('oi.order_id');
			}

			//实例化分页
			$page_row = new ecjia_page($record_count, $size, 6, '', $page);

			$order_id_group = $db_orderinfo_view->field('oi.order_id')->join(array('order_goods'))->where($where)->limit($page_row->limit())->order(array('oi.add_time' => 'desc'))->group('oi.order_id')->select();

			if (empty($order_id_group)) {
				$data = array();
			} else {
				foreach ($order_id_group as $val) {
					$where['oi.order_id'][] = $val['order_id'];
				}
				$data = $db_orderinfo_view->field($field)->join(array('order_info', 'order_goods', 'goods'))->where($where)->order(array('oi.add_time' => 'desc'))->select();
			}
		
		} else {
			$db_orderinfo_view->view = array(
					'order_goods' => array(
							'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
							'alias'	=> 'og',
							'on'	=> 'oi.order_id = og.order_id'
					),
					'goods' => array(
							'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
							'alias'	=> 'g',
							'on'	=> 'g.goods_id = og.goods_id'
					),
			);
			/*获取记录条数*/
			$record_count = $db_orderinfo_view->join(null)->where($where)->count('oi.order_id');
			/*已付款刷新是否有新订单*/
			if (!empty($last_refresh_time) && ($type == 'payed')) {
				$has_new_order = 0;
				if (!empty($record_count)){
					$has_new_order = 1;
				}
				unset($where['oi.pay_time']);
				$record_count = $db_orderinfo_view->join(null)->where($where)->count('oi.order_id');
			}
			//实例化分页
			$page_row = new ecjia_page($record_count, $size, 6, '', $page);
		
			$order_id_group = $db_orderinfo_view->join(null)->where($where)->order(array('oi.add_time' => 'desc'))->get_field('order_id', true);
			if (empty($order_id_group)) {
				$data = array();
			} else {
				$where['oi.order_id'] =  $order_id_group;
				$data = $db_orderinfo_view->field($field)->join(array('order_goods', 'goods'))->where($where)->limit($page_row->limit())->order(array('oi.add_time' => 'desc'))->select();
			}
		}

		
		RC_Lang::load('orders/order');

		$order_list = array();
		if (!empty($data)) {
			$order_id = $goods_number = 0;
			$seller_name = array();
			foreach ($data as $val) {
				if ($order_id == 0 || $val['order_id'] != $order_id ) {
					$goods_number = 0;
					$order_status = ($val['order_status'] != '2' || $val['order_status'] != '3') ? RC_Lang::lang('os/'.$val['order_status']) : '';
					$order_status = $val['order_status'] == '2' ? __('已取消') : $order_status;
					$order_status = $val['order_status'] == '3' ? __('无效') : $order_status;
					
// 					$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
					if ($val['pay_id'] > 0) {
						$payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($val['pay_id']);
					}
					
					$goods_lists = array();
					$goods_lists[] = array(
							'goods_id'	=> $val['goods_id'],
							'name'		=> $val['goods_name'],
							'goods_number' => $val['goods_number'],
							'img'		=> array(
									'thumb'	=> !empty($val['goods_img'])  ? RC_Upload::upload_url($val['goods_img'])	:  RC_Uri::admin_url('statics/images/nopic.png'),
									'url'	=> !empty($val['original_img'])  ? RC_Upload::upload_url($val['original_img'])  :  RC_Uri::admin_url('statics/images/nopic.png'),
									'small'	=> !empty($val['goods_thumb']) ? RC_Upload::upload_url($val['goods_thumb'])   :  RC_Uri::admin_url('statics/images/nopic.png') 
							)
					);
					
					if (in_array($val['order_status'], array(OS_CONFIRMED, OS_SPLITED)) &&
					in_array($val['shipping_status'], array(SS_RECEIVED)) &&
					in_array($val['pay_status'], array(PS_PAYED, PS_PAYING)))
					{
						$label_order_status = '已完成';
						$status_code = 'finished';
					}
					elseif (in_array($val['shipping_status'], array(SS_SHIPPED)))
					{
						$label_order_status = '已发货';
						$status_code = 'shipped';
					}
					elseif (in_array($val['order_status'], array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) &&
							in_array($val['pay_status'], array(PS_UNPAYED)) &&
							(in_array($val['shipping_status'], array(SS_SHIPPED, SS_RECEIVED)) || !$payment['is_cod']))
					{
						$label_order_status = '待付款';
						$status_code = 'await_pay';
					}
					elseif (in_array($val['order_status'], array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
							in_array($val['shipping_status'], array(SS_UNSHIPPED, SS_SHIPPED_PART, SS_PREPARING, SS_SHIPPED_ING, OS_SHIPPED_PART)) &&
							(in_array($val['pay_status'], array(PS_PAYED, PS_PAYING)) || $payment['is_cod']))
					{
						if (!in_array($val['pay_status'], array(PS_PAYED)) && $type == 'payed') {
							continue;
						}
						$label_order_status = '待发货';
						$status_code = 'await_ship';
					}
					elseif (in_array($val['order_status'], array(OS_CANCELED))) {
						$label_order_status = '已关闭';
						$status_code = 'canceled';
					}
						
					$goods_number = $val['goods_number'];
					$order_list[$val['order_id']] = array(
							'order_id'	=> intval($val['order_id']),
							'order_sn'	=> $val['order_sn'],
							'total_fee' => $val['total_fee'],
							'pay_name'	=> $val['pay_name'],
							'consignee' => $val['consignee'],
							'mobile'	=> empty($val['mobile']) ? $val['tel'] : $val['mobile'],
							'formated_total_fee' 		=> price_format($val['total_fee'], false),
							'order_amount'				=> $val['order_amount'],
							'surplus'					=> $val['surplus'],
							'money_paid'				=> $val['money_paid'],
							'formated_order_amount'		=> price_format($val['order_amount'], false),
							'formated_surplus'			=> price_format($val['surplus'], false),
							'formated_money_paid'		=> price_format($val['money_paid'], false),
							'formated_integral_money'	=> price_format($val['integral_money'], false),
							'integral'					=> intval($val['integral']),
							'formated_bonus'			=> price_format($val['bonus'], false),
							'formated_shipping_fee'		=> price_format($val['shipping_fee'], false),
							'formated_discount'			=> price_format($val['discount'], false),
							'status'					=> $order_status.','.RC_Lang::lang('ps/'.$val['pay_status']).','.RC_Lang::lang('ss/'.$val['shipping_status']),
							'label_order_status'		=> $label_order_status,
							'order_status_code'			=> $status_code,
							'goods_number'				=> intval($goods_number),
							'create_time' 				=> RC_Time::local_date(ecjia::config('date_format'), $val['add_time']),
							'goods_items' 				=> $goods_lists
					);
					
					$order_id = $val['order_id'];
				} else {
					$goods_number += $val['goods_number'];
					$order_list[$val['order_id']]['goods_number'] = $goods_number;
					$order_list[$val['order_id']]['goods_items'][] = array(
							'goods_id'	=> $val['goods_id'],
							'name'		=> $val['goods_name'],
							'goods_number' => intval($val['goods_number']),
							'img'		=> array(
									'thumb'	=> !empty($val['goods_img'])	? RC_Upload::upload_url($val['goods_img'])	: RC_Uri::admin_url('statics/images/nopic.png'),
									'url'	=> !empty($val['original_img'])  ? RC_Upload::upload_url($val['original_img'])  : RC_Uri::admin_url('statics/images/nopic.png'),
									'small'	=> !empty($val['goods_thumb'])  ? RC_Upload::upload_url($val['goods_thumb'])   : RC_Uri::admin_url('statics/images/nopic.png')
							)
					);
				}
		    }
		}
		$order_list = array_merge($order_list);
		
		$pager = array(
				'total'	=> $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);

		return array('data' => array('order_list' => $order_list, 'has_new_order' => $has_new_order), 'pager' => $pager);
	} 
}


// end
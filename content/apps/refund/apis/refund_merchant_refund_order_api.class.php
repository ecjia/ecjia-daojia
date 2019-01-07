<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 商家售后列表
 * @author zrl
 *
 */
class refund_merchant_refund_order_api extends Component_Event_Api {
    /**
     * @param  array $options['store_id']	店铺id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', '调用api文件,merchant_refund_order,参数无效');
		}
		return $this->store_refund_order_list($options);
	}
	
	
	/**
	 * 售后列表
	 * @param   array $options	条件参数
	 * @return  array   售后列表
	 */
	
	private function store_refund_order_list($options) {
		RC_Loader::load_app_class('order_refund', 'refund', false);
		
		$db = RC_DB::table('refund_order');
		
		if (!empty($options['store_id'])) {
			$db->where('store_id', $options['store_id']);
		}
		
		$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
		
		$cancel_status = Ecjia\App\Refund\RefundStatus::ORDER_CANCELED;
		$db->where('status', '<>', $cancel_status);
		
		if (!empty($options['referer'])) {
			$db->where('referer', $options['referer']);
		}
		if (!empty($options['start_date']) && !empty($options['end_date'])) {
			$start = RC_Time::local_strtotime($options['start_date']);
			$end   = RC_Time::local_strtotime($options['end_date']) + 85399;
			$db->where('add_time', '>=', $start)->where('add_time', '<=', $end);
		}
		
		$count = $db->select('refund_id')->count();

		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$list = $db->take($size)->skip($page_row->start_id - 1)->select('*')->orderBy('add_time', 'desc')->get();
		
		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		if (!empty($list)) {
			foreach ($list as $row) {
				$row['store_name'] 				= $row['store_id'] > 0 ? RC_DB::table('store_franchisee')->where('store_id', $row['store_id'])->pluck('merchants_name') : '';
				$row['label_refund_type']		= $row['refund_type'] == 'refund' ? '仅退款' : '退货退款';
				$row['formated_add_time']		= RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
				$row['formated_refund_time']	= !empty($row['refund_time']) ? RC_Time::local_date(ecjia::config('time_format'), $row['add_time']) : '';
				if ($row['status'] == Ecjia\App\Refund\RefundStatus::ORDER_CANCELED) {
					$row['service_status_code'] = 'canceled';
					$row['label_service_status']= '已取消';
				} elseif (($row['status'] == Ecjia\App\Refund\RefundStatus::ORDER_AGREE && $row['refund_status'] == Ecjia\App\Refund\RefundStatus::PAY_TRANSFERED)) {
					$row['service_status_code'] = 'refunded';
					$row['label_service_status']= '已退款';
				}elseif ($row['status'] == Ecjia\App\Refund\RefundStatus::ORDER_REFUSED) {
					$row['service_status_code'] = 'refused';
					$row['label_service_status']= '已拒绝';
				} else{
					$row['service_status_code'] = 'going';
					$row['label_service_status']= '进行中';
				}
				//售后申请退货商品信息
				$goods_list = order_refund::get_order_goods_list($row['order_id']);
				$row['goods_list'] = $goods_list;
				//支付方式id
				if (!empty($row['pay_code'])) {
					$pay_id = RC_DB::table('payment')->where('pay_code', $row['pay_code'])->pluck('pay_id');
				} else {
					$pay_id = 0;
				}
				$row['pay_id'] = $pay_id;
				$lists[] = $row;
			}
		}
		
		return array('list' => $lists, 'page' => $pager);
	}
}

// end
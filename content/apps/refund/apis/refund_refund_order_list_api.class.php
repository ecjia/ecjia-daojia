<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 售后列表
 * @author zrl
 *
 */
class refund_refund_order_list_api extends Component_Event_Api {
    /**
     * @param  array $options['order_id']	订单id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', '调用api文件,refund_order_list,参数无效');
		}
		return $this->refund_order_list($options);
	}
	
	
	/**
	 * 售后列表
	 * @param   array $options	条件参数
	 * @return  array   售后列表
	 */
	
	private function refund_order_list($options) {
		RC_Loader::load_app_class('order_refund', 'refund', false);
		
		$db = RC_DB::table('refund_order');
		
		if (!empty($options['order_id'])) {
			$db->where('order_id', $options['order_id']);
		}
		
		$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
		
		//$cancel_status = Ecjia\App\Refund\RefundStatus::CANCELED;
		//$db->where('status', '<>', $cancel_status);
		
		if (!empty($options['user_id'])) {
			$db->where('user_id', $options['user_id']);
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
				$row['store_name'] 			= $row['store_id'] > 0 ? RC_DB::table('store_franchisee')->where('store_id', $row['store_id'])->pluck('merchants_name') : '';
				$row['label_refund_type']	= $row['refund_type'] == 'refund' ? '仅退款' : '退货退款';
				$row['formated_add_time']		= RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
				if ($row['status'] == Ecjia\App\Refund\RefundStatus::CANCELED) {
					$row['service_status_code'] = 'canceled';
					$row['label_service_status']= '已取消';
				} elseif (($row['status'] == Ecjia\App\Refund\RefundStatus::AGREE && $row['refund_status'] == Ecjia\App\Refund\RefundStatus::TRANSFERED)) {
					$row['service_status_code'] = 'refunded';
					$row['label_service_status']= '已退款';
				}elseif ($row['status'] == Ecjia\App\Refund\RefundStatus::REFUSED) {
					$row['service_status_code'] = 'refused';
					$row['label_service_status']= '已拒绝';
				} else{
					$row['service_status_code'] = 'going';
					$row['label_service_status']= '进行中';
				}
				$lists[] = $row;
			}
		}
		
		return array('list' => $lists, 'page' => $pager);
	}
}

// end
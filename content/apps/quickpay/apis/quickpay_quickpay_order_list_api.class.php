<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 买单订单列表
 * @author zrl
 *
 */
class quickpay_quickpay_order_list_api extends Component_Event_Api {
    /**
     * @param  array $options['store_id']	店铺id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', '调用api文件,quickpay_order_list,参数无效');
		}
		return $this->quickpay_order_list($options);
	}
	
	
	/**
	 * 买单订单列表
	 * @param   array $options	条件参数
	 * @return  array   买单订单列表
	 */
	
	private function quickpay_order_list($options) {
		RC_Loader::load_app_class('quickpay_activity', 'quickpay', false);
		
		$db = RC_DB::table('quickpay_orders');
		
		if (!empty($options['store_id'])) {
			$db->where('store_id', $options['store_id']);
		}
		
		$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
		
		$deleted_status = Ecjia\App\Quickpay\Status::DELETED;
		
		$db->where('order_type', 'quickpay');
		$db->where('order_status', '<>', $deleted_status);
		
		if (!empty($options['user_id'])) {
			$db->where('user_id', $options['user_id']);
		}
		
		$count = $db->select('order_id')->count();
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$list = $db->take($size)->skip($page_row->start_id - 1)->select('*')->orderBy('add_time', 'desc')->get();
		
		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$list[$key]['store_name'] = $val['store_id'] > 0 ? RC_DB::table('store_franchisee')->where('store_id', $val['store_id'])->pluck('merchants_name') : '';
				$list[$key]['store_logo'] = $val['store_id'] > 0 ? RC_DB::table('merchants_config')->where('store_id', $val['store_id'])->where('code', 'shop_logo')->pluck('value') : '';
				$status = quickpay_activity::get_label_order_status($val['order_status'], $val['pay_status'], $val['verification_status']);
				$list[$key]['order_status_str'] = $status['order_status_str'];
				$list[$key]['label_order_status'] = $status['label_order_status'];
				$total_discount = $val['integral_money'] + $val['bonus'] + $val['discount'];
				$list[$key]['total_discount'] = $total_discount;
				$list[$key]['formated_total_discount'] = price_format($total_discount);
			}
		}
		
		return array('list' => $list, 'page' => $pager);
	}
		
	/**
	 * 获取限制星期
	 */
	public function get_format_limit_weekly($limit_time_weekly){
		$limit_time_weekly  = Ecjia\App\Quickpay\Weekly::weeks($limit_time_weekly);
		$week_list = $this->get_week_list();
		foreach ($week_list as $k => $v) {
			if (in_array($v, $limit_time_weekly)) {
				$week[] = $k;
			}
		}
		if (!empty($week)) {
			if ($limit_time_weekly == array(1,2,4,8,16)) {
				$str = '周一至周五全天可用';
			} elseif ($limit_time_weekly == array(1,2,4,8,16,32,64)) {
				$str = '周一至周日全天可用';
			} else {
				$str = implode(',', $week);
			}
		}
		return $str;
	}
	
	/**
	 * 获取每天限制时间段
	 */
	public function get_format_limit_daily($limit_time_daily){
		$limit_time_daily = unserialize($limit_time_daily);
		foreach ($limit_time_daily as $val) {
			$days[] = $val['start'].'-'.$val['end'];
		}
		if (!empty($days)) {
			asort($days);
			$str = implode(',', $days);
		}
		
		return $str;
	}
}

// end
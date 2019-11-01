<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台收款订单记录
 * @author zrl
 *
 */
class quickpay_cashier_quickpay_order_list_api extends Component_Event_Api {
    /**
     * @param  array $options['store_id']	店铺id
     * @return array|ecjia_error
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'quickpay'), __CLASS__));
		}
		return $this->cashier_quickpay_order_list($options);
	}
	
	
	/**
	 * 买单订单列表
	 * @param   array $options	条件参数
	 * @return  array   买单订单列表
	 */
	
	private function cashier_quickpay_order_list($options) {
		RC_Loader::load_app_class('quickpay_activity', 'quickpay', false);
		
		$dbview = RC_DB::table('quickpay_orders as qo')->leftJoin('cashier_record as cr', RC_DB::raw('qo.order_id'), '=', RC_DB::raw('cr.order_id'));
		
		if (!empty($options['store_id'])) {
			$dbview->where(RC_DB::raw('qo.store_id'), $options['store_id']);
		}
		
		if (!empty($options['order_type'])) {
			if ($options['order_type'] == 'user') {
				$dbview->where((RC_DB::raw('qo.referer')), '!=', 'ecjia-cashdesk');
			} elseif ($options['order_type'] == 'cashdesk') {
				$dbview->where(RC_DB::raw('qo.referer'), 'ecjia-cashdesk');
			}
		}
		
		$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
		
		$deleted_status = \Ecjia\App\Quickpay\Enums\QuickpayOrderEnum::DELETED;
		$canceled_status = \Ecjia\App\Quickpay\Enums\QuickpayOrderEnum::CANCELED;
		
		$dbview->where(RC_DB::raw('qo.order_status'), '<>', $deleted_status);
		$dbview->where(RC_DB::raw('qo.order_status'), '<>', $canceled_status);
		$dbview->where(RC_DB::raw('cr.order_type'), 'quickpay')->where(RC_DB::raw('cr.action'), 'receipt');
		
		if (!empty($options['start_date']) && !empty($options['end_date'])) {
			$dbview->where(RC_DB::raw('qo.add_time'), '>=', $options['start_date']);
			$dbview->where(RC_DB::raw('qo.add_time'), '<=', $options['end_date']);
		}
		//收银台和pos机区分设备；店铺某个设备的订单
		if (!empty($options['mobile_device_id'])) {
			$dbview->where(RC_DB::raw('cr.mobile_device_id'), $options['mobile_device_id']);
		}
		//收银通订单不区分设备；店铺所有收银通订单
		if (!empty($options['device_type'])) {
			$dbview->where(RC_DB::raw('cr.device_type'), $options['device_type']);
		}
		$count = $dbview->count(RC_DB::raw('DISTINCT cr.order_id'));
		
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$list = $dbview->take($size)->skip($page_row->start_id - 1)->select(RC_DB::raw('qo.*, cr.action, cr.create_at, cr.mobile_device_id, cr.order_type'))->orderBy(RC_DB::raw('cr.create_at'), 'desc')->get();
		
		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$list[$key]['store_name'] 				= $val['store_id'] > 0 ? RC_DB::table('store_franchisee')->where('store_id', $val['store_id'])->value('merchants_name') : '';
				$list[$key]['store_logo'] 				= $val['store_id'] > 0 ? RC_DB::table('merchants_config')->where('store_id', $val['store_id'])->where('code', 'shop_logo')->value('value') : '';
				$status 								= quickpay_activity::get_label_order_status($val['order_status'], $val['pay_status'], $val['verification_status']);
				$list[$key]['order_status_str'] 		= $status['order_status_str'];
				$list[$key]['label_order_status'] 		= $status['label_order_status'];
				$total_discount 						= $val['integral_money'] + $val['bonus'] + $val['discount'];
				$list[$key]['total_discount'] 			= $total_discount;
				$list[$key]['formated_total_discount'] 	= $total_discount > 0 ? price_format($total_discount, false) : '';
			}
		}
		
		return array('list' => $list, 'page' => $pager);
	}
}

// end
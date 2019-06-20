<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 买单活动列表
 * @author zrl
 *
 */
class quickpay_quickpay_activity_list_api extends Component_Event_Api {
    /**
     * @param  array $options['store_id']	店铺id
     * @return array|ecjia_error
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'quickpay'), __CLASS__));
		}
		return $this->quickpay_activity_list($options);
	}
	
	
	/**
	 * 买单活动列表
	 * @param   array $options	条件参数
	 * @return  array   买单活动列表
	 */
	
	private function quickpay_activity_list($options) {
		$db = RC_DB::table('quickpay_activity');
		
		if (!empty($options['store_id'])) {
			$db->where('store_id', $options['store_id']);
		}
		
		
		$time = RC_Time::gmtime();
		$db->where('start_time', '<=', $time);
		$db->where('end_time', '>=', $time);
		$db->where('enabled', 1);
		
		//是按分页返回
		if (trim($options['is_page']) == 'no') {
			$list = $db->select('*')->get();
			$pager = array();
		} else {
			$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
			$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
				
			$count = $db->select('id')->count();
			$page_row = new ecjia_page($count, $size, 6, '', $page);
				
			$list = $db->take($size)->skip($page_row->start_id - 1)->select('*')->get();
			$pager = array(
					'total' => $page_row->total_records,
					'count' => $page_row->total_records,
					'more'	=> $page_row->total_pages <= $page ? 0 : 1,
			);
		}
		
		$week_list = $this->get_week_list();
		
		if (!empty($list)) {
			foreach($list as $key => $val) {
				//$list[$key]['total_order_count'] = RC_DB::table('quickpay_orders')->where('activity_id', $val['id'])->count('order_id');
				
				/*活动类型处理*/
				if ($val['activity_type'] == 'discount') {
					$list[$key]['label_activity_type'] = __('价格折扣', 'quickpay');
				} elseif ($val['activity_type'] == 'everyreduced') {
					$list[$key]['label_activity_type'] = __('每满多少减多少,最高减多少', 'quickpay');
				} elseif ($val['activity_type'] == 'reduced') {
					$list[$key]['label_activity_type'] = __('满多少减多少', 'quickpay');
				}
				
				/*每周可用星期处理*/
				if (!empty($val['limit_time_weekly'])) {
					$list[$key]['limit_time_weekly_str'] = $this->get_format_limit_weekly($val['limit_time_weekly']);
				}
				/*每天限时时间段处理*/
				if (!empty($val['limit_time_daily'])) {
					$list[$key]['limit_time_daily_str'] = $this->get_format_limit_daily($val['limit_time_daily']);
				}
				/*开始和结束时间处理*/
				$list[$key]['formated_start_time'] = RC_Time::local_date(ecjia::config('date_format'), $val['start_time']);
				$list[$key]['formated_end_time'] = RC_Time::local_date(ecjia::config('date_format'), $val['end_time']);
			}
		}
		
		return array('list' => $list, 'page' => $pager);
	}
	
	/**
	 * 获取周
	 */
	public function get_week_list(){
		$week_list = array(
			'星期一'	=> Ecjia\App\Quickpay\Weekly::Monday,
			'星期二'	=> Ecjia\App\Quickpay\Weekly::Tuesday,
			'星期三'	=> Ecjia\App\Quickpay\Weekly::Wednesday,
			'星期四' => Ecjia\App\Quickpay\Weekly::Thursday,
			'星期五' => Ecjia\App\Quickpay\Weekly::Friday,
			'星期六' => Ecjia\App\Quickpay\Weekly::Saturday,
			'星期日' => Ecjia\App\Quickpay\Weekly::Sunday,
		);
		return $week_list;
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
				$str = '周一至周五可用';
			} elseif ($limit_time_weekly == array(1,2,4,8,16,32,64)) {
				$str = '周一至周日可用';
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
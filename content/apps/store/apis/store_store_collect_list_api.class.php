<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收藏的店铺列表
 * @author zrl
 *
 */
class store_store_collect_list_api extends Component_Event_Api {
    /**
     * @param  array $options['user_id']	用户id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', '调用api文件,store_collect_list,参数无效');
		}
		return $this->store_collect_list($options);
	}
	
	
	/**
	 * 收藏的店铺列表
	 * @param   array $options	条件参数
	 * @return  array   收藏的店铺列表
	 */
	
	private function store_collect_list($options) {
		$location = $options['location'];
		
		$dbview = RC_DB::table('collect_store as cs')->leftJoin('store_franchisee as sf', RC_DB::raw('cs.store_id'), '=', RC_DB::raw('sf.store_id'));
		
		if (!empty($options['user_id'])) {
			$dbview->where(RC_DB::raw('cs.user_id'), $options['user_id']);
		}
		
		$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
				
		$count = $dbview->select(RC_DB::raw('cs.rec_id'))->count();
		$page_row = new ecjia_page($count, $size, 6, '', $page);

		$field = 'cs.rec_id, cs.add_time as collect_time, sf.*';
		
		$list = $dbview->take($size)->skip($page_row->start_id - 1)->select(RC_DB::raw($field))->get();
		
		$pager = array(
				'total' => $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		RC_Loader::load_app_func('merchant', 'merchant');
		$favourable_list = [];
		$quickpay_activity_list_new = array();
		$list_new = [];
		
		if (!empty($list)) {
			foreach ($list as $key => $row) {
				//店铺设置信息
				$config = RC_DB::table('merchants_config')->where('store_id', $row['store_id'])->select('code', 'value')->get();
				foreach ($config as $key => $value) {
					$store_config[$value['code']] = $value['value'];
				}
				
				//店铺优惠活动
				$favourable_result = RC_Api::api('favourable', 'store_favourable_list', array('store_id' => $row['store_id']));
				if (!empty($favourable_result)) {
					foreach ($favourable_result as $val) {
						if ($val['act_range'] == '0') {
							$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
							);
						} else {
							$act_range_ext = explode(',', $val['act_range_ext']);
							switch ($val['act_range']) {
								case 1 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								case 2 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								case 3 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								default:
									break;
							}
						}
					}
				}
				
				/*店铺闪惠活动列表*/
				$quickpay_activity_list = RC_Api::api('quickpay', 'quickpay_activity_list', array('store_id' => $row['store_id']));
				if (is_ecjia_error($quickpay_activity_list)) {
					return $quickpay_activity_list;
				}
				if (!empty($quickpay_activity_list['list'])) {
					foreach ($quickpay_activity_list['list'] as $v) {
						$quickpay_activity_list_new[] = array(
								'activity_id' 	=> $v['id'],
								'title' 		=> $v['title'],
								'activity_type' => $v['activity_type'],
								'label_activity_type' => $v['label_activity_type'],
						);
					}
				}
				
				//店铺距离
				$distance = $this->getDistance($location['latitude'], $location['longitude'], $row['latitude'], $row['longitude']);
				
				$row['store_logo'] 				= empty($store_config['shop_logo']) ? '' : RC_Upload::upload_url($store_config['shop_logo']);
				$row['store_notice']			= empty($store_config['shop_notice']) ? '' : $store_config['shop_notice'];
				$row['label_trade_time'] 		= get_store_trade_time($row['store_id']);
				$row['favourable_list']			= $favourable_list;
				$row['allow_use_quickpay']		= empty($store_config['quickpay_enabled']) ?  '0' : 1;
				$row['quickpay_activity_list']	= $quickpay_activity_list_new;
				$row['distance']  				= $distance;
				$list_new[] = $row;
			}
		}
		
		return array('list' => $list_new, 'page' => $pager);
	}
	
	/**
	 * 计算两组经纬度坐标 之间的距离
	 * @param params ：lat1 纬度1； lng1 经度1； lat2 纬度2； lng2 经度2； len_type （1:m or 2:km);
	 * @return return m or km
	 */
	private function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 1) {
		$EARTH_RADIUS = 6378.137;
		$PI = 3.1415926;
		$radLat1 = $lat1 * $PI / 180.0;
		$radLat2 = $lat2 * $PI / 180.0;
		$a = $radLat1 - $radLat2;
		$b = ($lng1 * $PI / 180.0) - ($lng2 * $PI / 180.0);
		$s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
		$s = $s * $EARTH_RADIUS;
		$s = round($s * 1000);
		if ($len_type > 1) {
			$s /= 1000;
		}
	
		return round($s, $decimal);
	}
}

// end
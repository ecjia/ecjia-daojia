<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 选择到店退货返还方式
 * @author zrl
 *
 */
class refund_refund_returnway_shop_api extends Component_Event_Api {
    /**
     * @param  array $options['refund_id']	退款申请id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', '调用api文件,returnway_shop,参数无效');
		}
		return $this->returnway_shop($options);
	}
	
	
	/**
	 * 选择到店退货返还方式
	 * @param   array $options	条件参数
	 * @return  bool   
	 */
	
	private function returnway_shop($options) {
		
		RC_Loader::load_app_class('order_refund', 'refund', false);
		
		$refund_id = $options['refund_id'];

		$refund_info = RC_DB::table('refund_order')->where('refund_id', $refund_id)->first();
		if (empty($refund_info)) {
			return new ecjia_error('not_exists_info', __('不存在的信息！', 'refund'));
		}
		
		//收件地址默认为店铺地址
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $refund_info['store_id'])->select('merchants_name', 'city', 'district', 'street', 'address')->first();
		/*商家电话*/
		$store_service_phone = RC_DB::table('merchants_config')->where('store_id', $refund_info['store_id'])->where('code', 'shop_kf_mobile')->pluck('value');
		//店铺地址
		$storeaddress = ecjia_region::getRegionName($store_info['city']).ecjia_region::getRegionName($store_info['district']).ecjia_region::getRegionName($store_info['street']).$store_info['address'];
		
		$store_name = $store_info['merchants_name'];
		$contact_phone = $store_service_phone;
		$store_address = $storeaddress;
		
		$shop = array(
				'return_way_code' 	=> 'shop',
				'return_way_name' 	=> '到店退货',
				'store_address' 	=> !empty($store_address) ? $store_address : '',
				'store_name'		=> empty($store_name) ? '' : $store_name,
				'contact_phone' 	=> empty($contact_phone) ? '' : $contact_phone
		);
		
		$shop = serialize($shop);
		
		if ($refund_info['return_status'] != Ecjia\App\Refund\RefundStatus::SHIP_SHIPPED) {
			$update_data = array('return_shipping_type' => 'shop', 'return_time'=> RC_Time::gmtime(), 'return_shipping_value' => $shop, 'return_status' => 2);
			RC_DB::table('refund_order')->where('refund_id', $refund_id)->update($update_data);
			//售后状态log记录
			$pra = array('status' => '返还退货商品', 'refund_id' => $refund_info['order_id'], 'message' => '买家已返还退货商品！');
			order_refund::refund_status_log($pra);
		}
		return true;
	}
}

// end
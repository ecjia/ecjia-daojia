<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 团购商品列表
 * @author zrl
 *
 */
class groupbuy_goods_list_module extends api_front implements api_interface {
	
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		/* 获取数量 */
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		$location	 = $this->requestData('location', array());
		
		/*经纬度为空判断*/
		if ((is_array($location) && !empty($location['longitude']) && !empty($location['latitude']))) {
			$geohash = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
			$store_id_arr = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code));
		} else {
			$data = array();
			$data['list'] = array();
			$data['pager'] = array(
					"total" => 0,
					"count" => 0,
					"more"	=> 0
			);
			return array('data' => $data['list'], 'pager' => $data['pager']);
		}
		
		$options = array(
				'size'			=> $size,
				'page'			=> $page,
				'store_id'		=> $store_id_arr,
		);
		
		$groupbuy_goods_list = RC_Api::api('groupbuy', 'groupbuy_goods_list', $options);
		
		if (is_ecjia_error($groupbuy_goods_list)) {
			return $groupbuy_goods_list;
		}
    	
		return array('data' => $groupbuy_goods_list['list'], 'pager' => $groupbuy_goods_list['page']);
    }
}


// end
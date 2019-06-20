<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 店铺团购商品列表
 * @author zrl
 *
 */
class merchant_groupbuy_goods_list_module extends api_front implements api_interface {
	
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		/* 获取数量 */
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		$store_id	 = $this->requestData('store_id', 0);
		
		if (empty($store_id)) {
			return new ecjia_error( 'invalid_parameter', sprintf(__('请求接口%s参数无效', 'merchant'), __CLASS__));
		}
		
		$options = array(
				'page'		=> $page,
				'size'		=> $size,
				'store_id'	=> array($store_id)
		);
		
		$groupbuy_goods_list = RC_Api::api('groupbuy', 'groupbuy_goods_list', $options);
		if (is_ecjia_error($groupbuy_goods_list)) {
			return $groupbuy_goods_list;
		}

    	return array('data' => $groupbuy_goods_list['list'], 'pager' => $groupbuy_goods_list['page']);
    	
    }
}


// end
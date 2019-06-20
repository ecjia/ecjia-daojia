<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 商家今日热点列表
 * @author zrl
 *
 */
class merchant_mobile_toutiao_module extends api_front implements api_interface {

	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
    	$user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	$store_id = $this->requestData('store_id', '0');
    	
    	if (empty($store_id)) {
    		return new ecjia_error( 'invalid_parameter', sprintf(__('请求接口%s参数无效', 'toutiao'), __CLASS__));
    	}
		
    	$db = RC_DB::table('merchant_news');
    	$db->where('group_id', 0)->where('status', 1)->where('store_id', $store_id);
    	
		/* 查询今日热点总数*/
		$count = $db->count();
		
		/* 获取数量 */
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		$result = $db->orderBy('id', 'desc')->take($size)->skip($page_row->start_id - 1)->get();
		
		$list = array();
		if ( !empty ($result)) {
			foreach ($result as $val) {
				if (substr($val['image'], 0, 4) == 'http' || substr($val['image'],0, 9) == 'ecjiaopen') {
					$image = $val['image'];
				} else {
					$image = empty($val['image']) ? '' : RC_Upload::upload_url($val['image']);
				}
				$list[$val['id']][] = array(
						'id'			=> $val['id'],
						'group_id'		=> $val['group_id'],
						'title'			=> $val['title'],
						'description' 	=> $val['description'],
						'image'			=> $image,
						'content_url' 	=> RC_Uri::url('toutiao/mobile/preview', array('id' => $val['id'])),
						'formatted_create_time' 	=> Ecjia\App\Toutiao\ToutiaoManager::FormatedTime($val['create_time']),
				);
				
				$child_result = RC_DB::table('merchant_news')->where('group_id', $val['id'])->where('store_id', $store_id)->get();
				if ( !empty($child_result)) {
					foreach ($child_result as $v) {
						if (substr($v['image'], 0, 4) == 'http' || substr($v['image'],0, 9) == 'ecjiaopen') {
							$child_image = $v['image'];
						} else {
							$child_image = empty($v['image']) ? '' : RC_Upload::upload_url(). '/' .$v['image'];
						}
						$list[$v['group_id']][] = array(
								'id'			=> $v['id'],
								'group_id'		=> $v['group_id'],
								'title'			=> $v['title'],
								'description' 	=> $v['description'],
								'image'			=> $child_image,
								'content_url' 	=> RC_Uri::url('toutiao/mobile/preview', array('id' => $v['id'])),
								'formatted_create_time' 	=> Ecjia\App\Toutiao\ToutiaoManager::FormatedTime($v['create_time']),
						);
					}
				}
			}
		}
		
		$list = array_merge($list);
		$pager = array(
				"total" => $page_row->total_records,
				"count" => $page_row->total_records,
				"more"	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		$store_name = Ecjia\App\Store\StoreFranchisee::StoreName($store_id);
		$store_logo = Ecjia\App\Store\StoreFranchisee::StoreLogo($store_id);
		
		$store_info = array('store_id' => $store_id, 'store_name' => $store_name, 'store_logo' => $store_logo);
		
		$result = array('list' => $list, 'store_info' => $store_info);
		
		return array('data' => $result, 'pager' => $pager);
		
	}
}



// end
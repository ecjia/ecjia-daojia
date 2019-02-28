<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 专题详情内容
 * @author will.chen
 *
 */
class topic_info_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	

    	$topic_id = $this->requestData('topic_id', 0);

    	if (empty($topic_id)) {
    		return new ecjia_error('invalid_parameter', '调用接口topic_info_module参数无效！');
    	}
    	$type = $this->requestData('type');
    	$size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 1);
    	$sort_type = $this->requestData('sort_by', '');
    	
    	$topic = RC_Api::api('topic', 'topic_info', array('topic_id' => $topic_id));
    	
    	$topic_info = array(
    			'topic_id'			=> $topic['topic_id'],
    			'topic_title'		=> $topic['title'],
    			'topic_description' => empty($topic['description']) ? '' : trim($topic['description']),
    			'topic_image'		=> $topic['topic_img']
    	);
		$topic_cats = $goods_group = array();
		$topic_info['topic_type'] = $topic_info['goods_item'] = array();
		if (is_array($topic['topic_cat_name']) && !empty($topic['topic_cat_name'])) {
			foreach ( $topic['topic_cat_name'] as $k => $v) {
				foreach ($v as $vv) {
					$tmp = explode('|', $vv);
					$topic_cats[$k][$tmp[1]] = $tmp[0];
					if (!in_array($k, $topic_info['topic_type']) && $k != 'default') {
						$topic_info['topic_type'][] = $k;
					}
					if ($k == $type && !empty($type)) {
						$goods_group[] = $tmp[1];
					} elseif (empty($type)) {
						$goods_group[] = $tmp[1];
					}
				}
			}
		}
		
    	if (!empty($goods_group)) {
    		$goods_list = $this->get_goods_list($goods_group, $sort_type, $page, $size);
    		$topic_info['goods_item'] = $goods_list['data'];
    	} else {
    		$topic_info['goods_item'] = array();
    		$goods_list['page'] = array(
    			"total" => 0,
    			"count" => 0,
    			"more" => 0,
    		);
    	}
    	return array('data' => $topic_info, 'pager' => $goods_list['page']);
    }
    
    /**
     * 专题商品
     * @param array $goods_group_id 专题商品id数组
     * @param string $order_by  专题商品排序
     * @param int $page  当前页数
     * @param int $size  当前页数量
     * @return array 
     */
    private function get_goods_list($goods_group_id, $sort_type, $page, $size) {
    	
    	$user_rank = $_SESSION['user_rank'];
    	
    	$dbveiw = RC_DB::table('goods as g')
    	->leftJoin('member_price as mp', function ($join) {
    		$join->on(RC_DB::raw('mp.goods_id'), '=', RC_DB::raw('g.goods_id'))
    		->where(RC_DB::raw('mp.user_rank'), '=', ".$user_rank.");
    	});
    	
    	$dbveiw->where(RC_DB::raw('g.is_delete'), 0)->where(RC_DB::raw('g.is_on_sale'), 1)->where(RC_DB::raw('g.is_alone_sale'), 1);
    	if (ecjia::config('review_goods') == 1) {
    		$dbveiw->where(RC_DB::raw('g.review_status'), '>', 2);
    	}
    	
    	if (!empty($goods_group_id)) {
    		$dbveiw->whereIn(RC_DB::raw('g.goods_id'), $goods_group_id);
    	}
    	
    	switch ($sort_type) {
    		case 'hot' :
    			$dbveiw->orderBy(RC_DB::raw('g.is_hot'), 'DESC')->orderBy(RC_DB::raw('g.sort_order'), 'asc')->orderBy(RC_DB::raw('g.goods_id'), 'desc');
    			break;
    		case 'price_desc' :
    			$dbveiw->orderBy(RC_DB::raw('g.shop_price'), 'desc')->orderBy(RC_DB::raw('g.sort_order'), 'asc')->orderBy(RC_DB::raw('g.goods_id'), 'desc');
    			break;
    		case 'price_asc' :
    			$dbveiw->orderBy(RC_DB::raw('g.shop_price'), 'asc')->orderBy(RC_DB::raw('g.sort_order'), 'asc')->orderBy(RC_DB::raw('g.goods_id'), 'desc');
    			break;
    		case 'new' :
    			$dbveiw->orderBy(RC_DB::raw('g.is_new'), 'asc')->orderBy(RC_DB::raw('g.sort_order'), 'asc')->orderBy(RC_DB::raw('g.goods_id'), 'desc');
    			break;
    		default :
    			$dbveiw->orderBy(RC_DB::raw('g.sort_order'), 'asc')->orderBy(RC_DB::raw('g.goods_id'), 'desc');
    			break;
    	}
    	 
    	/* 获得符合条件的商品总数 */
    	$count = $dbveiw->count(RC_DB::raw('g.goods_id'));
    	 
    	//实例化分页
    	$page_row = new ecjia_page($count, $size, 6, '', $page);
    	 
    	$discount = $_SESSION['discount'];
    	$field = "g.goods_id, g.goods_name, g.goods_sn, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price,".
    			"IFNULL(mp.user_price, g.shop_price * '".$discount."') AS shop_price, ".
    			"g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.original_img, g.goods_brief, g.goods_type ";
    	
    	$data = $dbveiw->select(RC_DB::raw($field))->take($size)->skip($page->start_id - 1)->get();
    	 
    	if (!empty($data) && is_array($data)) {
    		$list = array();
    		foreach ($data as $key => $val) {
    			/*促销价格*/
    			if ($val ['promote_price'] > 0) {
    				$promote_price = Ecjia\App\Goods\BargainPrice::bargain_price ($val['promote_price'], $val['promote_start_date'], $val['promote_end_date']);
    			} else {
    				$promote_price = 0;
    			}
    			
    			$list[] = array(
    					'id'								=> intval($val['goods_id']),
    					'name'								=> empty($val['goods_name']) ? '' : $val['goods_name'],
    					'goods_sn'							=> empty($val['goods_sn']) ? '' : $val['goods_sn'],
    					'market_price'						=> sprintf("%.2f",$val['market_price']),
    					'formatted_market_price'			=> ecjia_price_format($val['market_price'], false),
    					'shop_price'						=> sprintf("%.2f",$val['shop_price']),
    					'formatted_shop_price'				=> ecjia_price_format($val['shop_price'], false),
    					'promote_price'						=> $promote_price > 0 ? $promote_price : '',
    					'formatted_promote_price'			=> $promote_price > 0 ? ecjia_price_format($promote_price, false) : '',
    					'promote_start_date'				=> $val['promote_start_date'],
    					'promote_end_date'					=> $val['promote_end_date'],
    					'formatted_promote_start_date'		=> $val['promote_start_date'] > 0 ? RC_Time::local_date('Y/m/d H:i:s', $val['promote_start_date']) : '',
    					'formatted_promote_end_date'		=> $val['promote_end_date'] > 0 ? RC_Time::local_date('Y/m/d H:i:s', $val['promote_end_date']) : '',
		    			'img'								=> array(
									    							'small' => empty($val['goods_thumb']) ? '' : RC_Upload::upload_url($val['goods_thumb']),
									    							'url'	=> empty($val['original_img']) ? '' : RC_Upload::upload_url($val['original_img']),
									    							'thumb' => empty($val['goods_img']) ? '' : RC_Upload::upload_url($val['goods_img']),
									    					),
    			);
    		}
    	}
    	$pager = array(
    			"total" => $page_row->total_records,
    			"count" => $page_row->total_records,
    			"more" 	=> $page_row->total_pages <= $page ? 0 : 1,
    	);
    	 
    	return array('data' => $list, 'page' => $pager);
    }
}



// end
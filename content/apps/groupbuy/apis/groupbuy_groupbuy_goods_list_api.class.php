<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 团购商品列表
 * @author zrl
 *
 */
class groupbuy_groupbuy_goods_list_api extends Component_Event_Api {
    /**
     * @param  array $options['store_id']	店铺id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', '调用api文件,groupbuy_goods_list,参数无效');
		}
		return $this->groupbuy_goods_list($options);
	}
	
	
	/**
	 * 团购商品列表
	 * @param   array $options	条件参数
	 * @return  array   团购商品列表
	 */
	
	private function groupbuy_goods_list($options) {
		$db_goods_activity = RC_DB::table('goods_activity as ga')
		->leftJoin('goods as g', RC_DB::raw('ga.goods_id'), '=', RC_DB::raw('g.goods_id'));
		
		$db_goods_activity
		->where(RC_DB::raw('ga.act_type'),GAT_GROUP_BUY)
		->where(RC_DB::raw('ga.start_time'),'<=', RC_Time::gmtime())
		->where(RC_DB::raw('ga.end_time'),'>=', RC_Time::gmtime())
		->whereRaw('g.goods_id is not null')
		->where(RC_DB::raw('g.is_delete'),0)
		->where(RC_DB::raw('g.is_on_sale'),1)
		->where(RC_DB::raw('g.is_alone_sale'),1);
		
		if (!empty($options['store_id'])) {
			$db_goods_activity->whereIn(RC_DB::raw('g.store_id'), $options['store_id']);
		}
		
		if (ecjia::config('review_goods') == 1) {
			$db_goods_activity->where(RC_DB::raw('g.review_status'), '>', 2);
		}
		
		$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
		
		$count = $db_goods_activity->count(RC_DB::raw('ga.act_id'));
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$res = $db_goods_activity
    		->select(RC_DB::raw('ga.*,g.shop_price, g.market_price, g.goods_brief, g.goods_thumb, g.goods_img, g.original_img'))
    		->take($size)->skip($page_row->start_id - 1)->orderBy(RC_DB::raw('ga.act_id'),'desc')
    		->get();
		
		$list = array();
		if (!empty($res)) {
			foreach ($res as $val) {
				$ext_info = unserialize($val['ext_info']);
				$price_ladder = $ext_info['price_ladder'];
				if (!is_array($price_ladder) || empty($price_ladder)) {
					$price_ladder = array(array('amount' => 0, 'price' => 0));
				} else {
					foreach ($price_ladder AS $key => $amount_price) {
						$price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
					}
				}
				$cur_price  = $price_ladder[0]['price'];    // 初始化
				$list[] = array(
								'id'					=> $val['goods_id'],
								'name'					=> $val['goods_name'],
								'market_price'			=> $val['market_price'],
								'formated_market_price'	=> price_format($val['market_price'], false),
								'shop_price'			=> $val['shop_price'],
								'formated_shop_price'	=> price_format($val['shop_price'], false),
								'promote_price'			=> $cur_price,
								'formated_promote_price'=> price_format($cur_price, false),
								'promote_start_date'	=> RC_Time::local_date('Y/m/d H:i:s', $val['start_time']),
								'promote_end_date'		=> RC_Time::local_date('Y/m/d H:i:s', $val['end_time']),
								'img'					=> array(
																'small'	=> empty($val['goods_thumb']) ? '' : RC_Upload::upload_url($val['goods_thumb']),
																'thumb'	=> empty($val['goods_img']) ? '' : RC_Upload::upload_url($val['goods_img']),
																'url'	=> empty($val['original_img'])? '' : RC_Upload::upload_url($val['original_img'])	
													    	),
								'goods_activity_id'		=> $val['act_id'],
								'activity_type'			=> 'GROUPBUY_GOODS'
						  );
			}
		}
		
		$pager = array(
				'total' => $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		return array('list' => $list, 'page' => $pager);
	}
}

// end
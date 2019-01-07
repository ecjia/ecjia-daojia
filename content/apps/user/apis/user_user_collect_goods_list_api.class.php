<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 用户收藏商品列表
 * @author zrl
 *
 */
class user_user_collect_goods_list_api extends Component_Event_Api {
    /**
     * $options['user_id']	用户id（必填）
     * @param  array 
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options) || empty($options['user_id'])) {
			return new ecjia_error('invalid_parameter', '调用api文件,user_collect_goods_list,参数无效');
		}
		return $this->user_collect_goodslist($options);
	}
	
	
	/**
	 * 用户收藏商品列表
	 * @param   array $options	条件参数
	 * @return  array   用户收藏商品列表
	 */
	
	private function user_collect_goodslist($options) {
		$db = RC_DB::table('collect_goods as cg')
					->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('cg.goods_id'))
					->leftJoin('store_franchisee as sf', RC_DB::raw('g.store_id'), '=', RC_DB::raw('sf.store_id'));
		
		$db->where(RC_DB::raw('cg.user_id'), $options['user_id']);
		
		$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
		
		$count = $db->count(RC_DB::raw('cg.rec_id'));
		
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$field = 'cg.*, sf.merchants_name, g.store_id, g.goods_name, g.market_price, g.shop_price, g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.original_img';
		
		$list = $db->take($size)->skip($page_row->start_id - 1)->select(RC_DB::raw($field))->get();
		$pager = array(
				'total' => $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		return array('list' => $list, 'page' => $pager);
	}
}

// end
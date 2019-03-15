<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 配送单列表
 * @author zrl
 *
 */
class express_express_order_list_api extends Component_Event_Api {
    /**
     * @param  array $options	配送员id
     * @param  int $options['staff_id']	配送员id
     * @param  int $options['store_id']	店铺id
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', __('调用api文件,express_order_list,参数无效', 'express'));
		}
		return $this->express_order_list($options);
	}
	
	
	/**
	 * 配送单列表
	 * @param   array $options	条件参数
	 * @return  array   配送单列表
	 */
	
	private function express_order_list($options) {
		
		$db = RC_DB::table('express_order');
		
		if (!empty($options['staff_id'])) {
			$db->where('staff_id', $options['staff_id']);
		}
		
		$size  	  = empty($options['size']) 		? 15 : intval($options['size']);
		$page 	  = empty($options['page']) 		? 1 : intval($options['page']);
		
		$count = $db->select('express_id')->count();

		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$list = $db->take($size)->skip($page_row->start_id - 1)->select('*')->orderBy('add_time', 'desc')->get();
		
		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		if (!empty($list)) {
			foreach ($list as $row) {
		    	switch ($row['status']) {
		    		case '0' :
		    			$status = 'wait_assign';
		    			$label_express_status = __('待指派', 'express');
		    			break;
		    		case '1' :
		    			$status = 'wait_pickup';
		    			$label_express_status = __('待取货', 'express');
		    			break;
		    		case '2' :
		    			$status = 'sending';
		    			$label_express_status = __('配送中', 'express');
		    			break;
		    		case '5' :
		    			$status = 'finished';
		    			$label_express_status = __('已完成', 'express');
		    			break;
		    	}		    	
		    	$row['express_status'] = $status;
		    	$row['label_express_status'] = $label_express_status;
				$lists[] = $row;
			}
		}
		
		return array('list' => $lists, 'page' => $pager);
	}
}

// end
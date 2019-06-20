<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台挂单列表
 * @author zrl
 * 
 */
class admin_cashier_pendorder_list_module  extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        $device = $this->device;
        $size 			= $this->requestData('pagination.count', 15);
        $page 			= $this->requestData('pagination.page', 1);
        
        $size			= !empty($size) ? intval($size) : 15;
        $page			= !empty($page) ? intval($page) : 1;
        
        RC_Loader::load_app_func('cart', 'cart');
        
		recalculate_price($device);
		$flow_type = \Ecjia\App\Cart\Enums\CartEnum::CART_CASHDESK_GOODS;
		
		$db = RC_DB::table('cashier_pendorder');
		//当前收银员的挂单列表
		if (!empty($_SESSION['staff_id'])) {
			$db->where('cashier_user_id', $_SESSION['staff_id']);
		}
		
		$count = $db->count('pendorder_id');
		 
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		 
		$rows = $db->take($size)
		->skip($page_row->start_id - 1)->orderBy('pendorder_time', 'desc')->get();

		$pager = array(
				'total' => $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		if (empty($count)) {
			$data = [];
			$pager = array('total' => 0, 'count' => 0, 'more' => 0);
			return array('data' => $data, 'pager' => $pager);
		}
		
		/* 对商品信息赋值 */
		RC_Loader::load_app_class('cart_cashdesk', 'cart', false);
		$list = [];
		$goods_list_new = [];
		if (!empty($rows)) {
			foreach ($rows as  $key => $val) {
				$goods_list = cart_cashdesk::cashdesk_cart_goods($flow_type, array(), $val['pendorder_id']); // 取得商品列表，计算合计
				
				$rows[$key]['goods_items'] = [];
				$rows[$key]['total'] = '0.00';
				
				if (!empty($goods_list)) {
					foreach ($goods_list as $k => $v) {
						$rows[$key]['total'] += $v['subtotal'];
						$rows[$key]['total_goods_number'] += $v['goods_number'];
						$rows[$key]['goods_items'][] = array(
								'rec_id' 					=> intval($v['rec_id']),
								'user_id'					=> intval($v['user_id']),
								'store_id'					=> intval($v['store_id']),
								'goods_id'					=> intval($v['goods_id']),
								'goods_sn'					=> $v['goods_sn'],
								'goods_name'				=> $v['goods_name'],
								'goods_price'				=> $v['goods_price'],
								'market_price'				=> $v['market_price'],
								'formated_goods_price'		=> $v['formated_goods_price'],
								'formated_market_price'		=> $v['formated_market_price'],
								'goods_number'				=> $v['goods_number'],
								'goods_attr'				=> $v['goods_attr_new'],
								'goods_attr_id'				=> empty($v['$goods_attr_id']) ? '' : $v['$goods_attr_id'],
								'subtotal'					=> $v['subtotal'],
								'formated_subtotal'			=> $v['formated_subtotal'],
								'img'						=> $v['img'],
						);
					}
					
				}
			}
		}
		if ($rows) {
			foreach ($rows as $result) {
				$pendorder_list[] = array(
						'pendorder_id' 		=> intval($result['pendorder_id']),
						'pendorder_sn'		=> trim($result['pendorder_sn']),
						'total'				=> sprintf("%.2f", $result['total']),
						'formated_total'	=> price_format($result['total'], false),
						'pend_time'			=> RC_Time::local_date(ecjia::config('time_format'), $result['pendorder_time']),
						'goods_items'		=> $result['goods_items'],
						'total_goods_number'=> $result['total_goods_number']
				);
			}
		}
		return array('data' => $pendorder_list, 'pager' => $pager);
	}
}

// end
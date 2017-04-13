<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 取得某订单应该赠送的积分数
 * @author wutifang
 *
 */
class orders_order_integral_api extends Component_Event_Api {
	
    /**
     * @param  $options['order_id'] 订单ID
     *         $options['order_sn'] 订单号
     *
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options)) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
		return $this->integral_to_give($options);
	}
	
	/**
	 * 取得某订单应该赠送的积分数
	 * @param   array   $order  订单
	 * @return  int     积分数
	 */
	private function integral_to_give($order) {
		$db_order_goods_view = RC_Loader::load_app_model('order_order_goods_viewmodel', 'orders');
		/* 判断是否团购 */
		if ($order['extension_code'] == 'group_buy') {
			$group_buy = RC_Api::api('promotion', 'group_buy_info', array('group_buy_id' => $order['extension_id']));
			return array('custom_points' => $group_buy['gift_integral'], 'rank_points' => $order['goods_amount']);
		} else {
			return $db_order_goods_view->join('goods')->field('SUM(o.goods_number * IF(g.give_integral > -1, g.give_integral, o.goods_price)) AS custom_points, SUM(o.goods_number * IF(g.rank_integral > -1, g.rank_integral, o.goods_price)) AS rank_points')->where("o.goods_id = g.goods_id AND o.order_id = ".$order['order_id']." AND o.goods_id > 0 AND o.parent_id = 0 AND o.is_gift = 0 AND o.extension_code != 'package_buy'")->find();
		}
	}
}


// end
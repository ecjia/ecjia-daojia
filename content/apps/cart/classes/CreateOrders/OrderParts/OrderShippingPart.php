<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 13:32
 */

namespace Ecjia\App\Cart\CreateOrders\OrderParts;


use Ecjia\App\Cart\CreateOrders\OrderPartAbstract;

class OrderShippingPart extends OrderPartAbstract
{

    protected $part_key = 'shipping';

    protected $shipping_id;

    public function __construct(array $shipping_id)
    {
        $this->shipping_id = $shipping_id;
    }

	/**
	 * 配送方式检验
	 *  @param array $shipping_id
     *  @return \ecjia_error
	 */
	public function check_shipping_id()
	{
		//TODO 待处理
		
// 		$get_cart_goods = Ecjia\App\Cart\CartFunction::cart_list($options['flow_type'], $options['user_id'], $options['cart_id']);
		
// 		if (count($get_cart_goods) == 0) {
// 			return new ecjia_error('not_found_cart_goods', __('购物车中没有您选择的商品', 'cart'));
// 		}
		
// 		/* 判断是不是实体商品*/
// 		foreach ($get_cart_goods as $val) {
// 			/* 统计实体商品的个数 */
// 			if ($val['is_real']) {
// 				$is_real_good = 1;
// 			}
// 		}
		
// 		if ($is_real_good) {
// 			//配送方式不可为空判断
// 			if (empty($order['shipping_id'])) {
// 				return new ecjia_error('pls_choose_ship_way', __('请选择配送方式！', 'cart'));
// 			} else {
// 				if (is_array($order['shipping_id'])) {
// 					foreach ($order['shipping_id'] as $ship_val) {
// 						if (empty($ship_val)) {
// 							return new ecjia_error('pls_choose_ship_way', __('请选择配送方式！', 'cart'));
// 						}
// 						$ship_val_str = explode('-', $ship_val);
// 						if (empty($ship_val_str['0']) || empty($ship_val_str['1'])) {
// 							return new ecjia_error('pls_choose_ship_way', __('请选择配送方式！', 'cart'));
// 						}
// 					}
// 				}
// 			}
// 		}
	}
	
	/**
	 * 配送总费用
	 */
	public function total_shipping_fee()
	{
		//TODO 待处理
		/*配送费用*/
// 		if (!empty($order['shipping_id']) && is_array($order['shipping_id']) && $total['real_goods_count'] > 0) {
// 			$total['shipping_fee'] 	= self::get_total_shipping_fee($cart_goods_list, $order['shipping_id']);
// 		}
	}
	
	/**
	 * 多店铺配送总费用
	 */
	public  function get_total_shipping_fee($cart_goods_list, $shipping_ids) {
		$shipping_fee = 0;
		 
		//TODO 待处理
// 		if (!empty($cart_goods_list['cart_list']) && !empty($shipping_ids) && is_array($shipping_ids)) {
// 			foreach ($cart_goods_list['cart_list'] as $val) {
// 				if ($val['shipping']) {
// 					foreach ($val['shipping'] as $k => $v) {
// 						foreach ($shipping_ids as $ship_val) {
// 							if ($ship_val) {
// 								$ship = explode('-', $ship_val);
// 								if ($ship['0'] == $val['store_id'] && $ship['1'] == $v['shipping_id']) {
// 									if ($v['shipping_code'] == 'ship_cac') {
// 										$v['shipping_fee'] = 0;
// 									}
// 									$shipping_fee += $v['shipping_fee'];
// 								}
// 							}
// 						}
// 					}
// 				}
// 			}
// 		}
		return $shipping_fee;
	}
}
<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 收银台购物车
 */
class cart_cashdesk {
	
	/**
	 * 取得购物车商品
	 * @param   int     $type   类型：默认普通商品
	 * @return  array   购物车商品数组
	 */
	public static function cashdesk_cart_goods($type = CART_GENERAL_GOODS, $cart_id = array(), $pendorder_id = 0) {
	
		$db = RC_Loader::load_app_model('cart_goods_viewmodel', 'cart');
	
		$cart_where = array('rec_type' => $type);
		if (!empty($cart_id)) {
			$cart_where = array_merge($cart_where,  array('rec_id' => $cart_id));
		}
		if (!empty($pendorder_id)) {
			$cart_where = array_merge($cart_where,  array('pendorder_id' => $pendorder_id));
		}
		if (!empty($_SESSION['store_id'])) {
			$cart_where = array_merge($cart_where, array('c.store_id' => $_SESSION['store_id']));
		}
		$field = 'g.store_id, goods_img, original_img, goods_thumb, c.rec_id, c.user_id, c.goods_id, c.goods_name, c.goods_sn, c.goods_number, c.market_price, c.goods_price, c.goods_attr, c.is_real, c.extension_code, c.parent_id, c.is_gift, c.is_shipping, c.goods_price * c.goods_number|subtotal, goods_weight as goodsWeight, c.goods_attr_id';
		if ($_SESSION['user_id']) {
			$cart_where = array_merge($cart_where, array('c.user_id' => $_SESSION['user_id']));
			$arr        = $db->field($field)->where($cart_where)->select();
		} else {
			$cart_where = array_merge($cart_where, array('session_id' => SESS_ID));
			$arr        = $db->field($field)->where($cart_where)->select();
		}
	
		$db_goods_attr = RC_Loader::load_app_model('goods_attr_model', 'goods');
		$db_goods = RC_Loader::load_app_model('goods_model', 'goods');
		$order_info_viewdb = RC_Loader::load_app_model('order_info_viewmodel', 'orders');
		$order_info_viewdb->view = array(
				'order_goods' => array(
						'type'	  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'   => 'g',
						'on'	  => 'oi.order_id = g.order_id '
				)
		);
		/* 格式化价格及礼包商品 */
		foreach ($arr as $key => $value) {
			$goods = $db_goods->field(array('is_xiangou', 'xiangou_start_date', 'xiangou_end_date', 'xiangou_num'))->find(array('goods_id' => $value['goods_id']));
			/* 限购判断*/
			if ($goods['is_xiangou'] > 0) {
				$xiangou = array(
						'oi.add_time >=' . $goods['xiangou_start_date'] . ' and oi.add_time <=' .$goods['xiangou_end_date'],
						'g.goods_id'	=> $value['goods_id'],
						'oi.user_id'	=> $_SESSION['user_id'],
				);
				$xiangou_info = $order_info_viewdb->join(array('order_goods'))->field(array('sum(goods_number) as number'))->where($xiangou)->find();
	
				if ($xiangou_info['number'] + $value['goods_number'] > $goods['xiangou_num']) {
					return new ecjia_error('xiangou_error', __('该商品已限购'));
				}
			}
	
			$arr[$key]['formated_market_price'] = price_format($value['market_price'], false);
			$arr[$key]['formated_goods_price']  = $value['goods_price'] > 0 ? price_format($value['goods_price'], false) : __('免费');
			$arr[$key]['formated_subtotal']     = price_format($value['subtotal'], false);
	
			/* 查询规格 */
			// 		if (trim($value['goods_attr']) != '' && $value['group_id'] == '') {//兼容官网套餐问题增加条件group_id
			// 			$value['goods_attr_id'] = empty($value['goods_attr_id']) ? '' : explode(',', $value['goods_attr_id']);
			// 			$attr_list = $db_goods_attr->field('attr_value')->in(array('goods_attr_id' => $value['goods_attr_id']))->select();
			// 			foreach ($attr_list AS $attr) {
			// 				$arr[$key]['goods_name'] .= ' [' . $attr['attr_value'] . '] ';
			// 			}
			// 		}
	
			// 		$arr[$key]['goods_attr'] = array();
			// 		if (!empty($value['goods_attr'])) {
			// 			$goods_attr = explode("\n", $value['goods_attr']);
			// 			$goods_attr = array_filter($goods_attr);
				
			// 			foreach ($goods_attr as  $v) {
			// 				$a = explode(':',$v);
			// 				if (!empty($a[0]) && !empty($a[1])) {
			// 					$arr[$key]['goods_attr'][] = array('name'=>$a[0], 'value'=>$a[1]);
			// 				}
			// 			}
			// 		}
			$store_group[] = $value['store_id'];
			$goods_attr_gourp = array();
			if (!empty($value['goods_attr'])) {
				$goods_attr = explode("\n", $value['goods_attr']);
				$goods_attr = array_filter($goods_attr);
				foreach ($goods_attr as  $v) {
					$a = explode(':',$v);
					if (!empty($a[0]) && !empty($a[1])) {
						$goods_attr_gourp[] = array('name' => $a[0], 'value' => $a[1]);
					}
				}
			}
			$arr[$key]['goods_attr_new'] = empty($value['goods_attr']) ? '' : trim($value['goods_attr']);
			$arr[$key]['attr'] =  $value['goods_attr'];
			$arr[$key]['goods_attr'] =  $goods_attr_gourp;
	
	
			RC_Loader::load_app_func('global', 'goods');
			$arr[$key]['img'] = array(
					'thumb'	=> get_image_path($value['goods_id'], $value['goods_img'], true),
					'url'	=> get_image_path($value['goods_id'], $value['original_img'], true),
					'small' => get_image_path($value['goods_id'], $value['goods_thumb'], true),
			);
			unset($arr[$key]['goods_thumb']);
			unset($arr[$key]['goods_img']);
			unset($arr[$key]['original_img']);
			if ($value['extension_code'] == 'package_buy') {
				$arr[$key]['package_goods_list'] = get_package_goods($value['goods_id']);
			}
			$arr[$key]['store_name'] = RC_DB::table('store_franchisee')->where('store_id', $value['store_id'])->pluck('merchants_name');
		}
		return $arr;
	}
	
	
}	


// end
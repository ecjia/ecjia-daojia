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

namespace Ecjia\App\Refund;

use RC_DB;
use RC_Api;
use ecjia;
use RC_Loader;
use order_refund;


/**
 * 申请退款返回商品库存
 */
class RefundBackGoodsStock
{	
	/**
	 * 售后订单信息获取
	 */
	public static function refund_back_stock($refund_id){
		//返回库存
		if (ecjia::config('use_storage') == '1') {//判断是否有开启使用库存
			//减库存的时机
			if (ecjia::config('stock_dec_time') == SDT_PLACE){ 
				//如果是下单时减库存，订单所有商品需返还库存
				self::_backOrderGoodsStock($refund_id);
			} else {
				//如果是发货时减库存，订单已发货商品需返还库存
				self::_backOrderShipedGoods($refund_id);
			}
		}
		
	}
	
	/**
	 * 返还退款订单所有商品库存
	 */
	private static function _backOrderGoodsStock($refund_id)
	{
		//退款订单信息
		$refund_order = RC_Api::api('refund', 'refund_order_info', array('refund_id' => $refund_id));
		//订单商品
		$order_goods = self::_refundOrderGoods($refund_order['order_id']);
		if (!empty($order_goods)) {
			foreach ($order_goods as $value) {
				//货品库存增加
				if ($value['product_id'] > 0) {
					RC_DB::table('products')->where('product_id', $value['product_id'])->increment('product_number', $value['goods_number']);
				} else {
					RC_DB::table('goods')->where('goods_id', $value['goods_id'])->increment('goods_number', $value['goods_number']);
				}
			}
		}
	}
	
	/**
	 * 返还退款订单已发货的商品库存
	 */
	private static function _backOrderShipedGoods($refund_id)
	{
		//退款订单信息
		$refund_order = RC_Api::api('refund', 'refund_order_info', array('refund_id' => $refund_id));
		//获取订单的发货单列表
		RC_Loader::load_app_class('order_refund', 'refund', false);
		$delivery_list = order_refund::currorder_delivery_list($refund_order['order_id']);
		if (!empty($delivery_list)) {
			foreach ($delivery_list as $row) {
				//获取发货单的发货商品列表
				$delivery_goods_list   = order_refund::delivery_goodsList($row['delivery_id']);
				if (!empty($delivery_goods_list)) {
					foreach ($delivery_goods_list as $res) {
						$refund_goods_data = array(
								'refund_id'		=> $refund_id,
								'goods_id'		=> $res['goods_id'],
								'product_id'	=> $res['product_id'],
								'goods_name'	=> $res['goods_name'],
								'goods_sn'		=> $res['goods_sn'],
								'is_real'		=> $res['is_real'],
								'send_number'	=> $res['send_number'],
								'goods_attr'	=> $res['goods_attr'],
								'brand_name'	=> $res['brand_name']
						);
						$refund_goods_id = RC_DB::table('refund_goods')->insertGetId($refund_goods_data);
						if ($res['send_number'] > 0) {
							//货品库存增加
							if ($res['product_id'] > 0) {
								RC_DB::table('products')->where('product_id', $res['product_id'])->increment('product_number', $res['send_number']);
							} else {
								RC_DB::table('goods')->where('goods_id', $res['goods_id'])->increment('goods_number', $res['send_number']);
							}
						}
					}
				}
			}
		}
		
		
		/* 修改订单的发货单状态为退货 */
		$delivery_order_data = array(
				'status' => 1,
		);
		RC_DB::table('delivery_order')->where('order_id', $refund_order['order_id'])->whereIn('status', array(0,2))->update($delivery_order_data);
			
		/* 将订单的商品发货数量更新为 0 */
		$order_goods_data = array(
				'send_number' => 0,
		);
			
		RC_DB::table('order_goods')->where('order_id', $refund_order['order_id'])->update($order_goods_data);
	}
	
	/**
	 * 退款订单商品
	 */
	private static function _refundOrderGoods($order_id)
	{
		$orderGoods = [];
		$orderGoods = RC_DB::table('order_goods')->where('order_id', $order_id)->get();
	
		return $orderGoods;
	}
}

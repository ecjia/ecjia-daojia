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
 * 订单信息处理
 *
 */
class OrderInfo
{	
	/**
	 * 售后订单获取相对应的普通订单
	 */
	public static function get_order_info($order_id){
		if (!empty($order_id)) {
			$order_info = RC_DB::table('order_info')->where('order_id', $order_id)
			->select('order_id','order_sn','pay_name','pay_time','add_time','shipping_status',
					'consignee','province','city','district','street','address','mobile',
					'goods_amount','shipping_fee','pay_fee','pack_fee','insure_fee','card_fee','tax','integral_money','bonus','discount')
					->first();
			$order_info['province']	= ecjia_region::getRegionName($order_info['province']);
			$order_info['city']     = ecjia_region::getRegionName($order_info['city']);
			$order_info['district'] = ecjia_region::getRegionName($order_info['district']);
			$order_info['street']   = ecjia_region::getRegionName($order_info['street']);
			if ($order_info['add_time']) {
				$order_info['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $order_info['add_time']);
			}
			if ($order_info['pay_time']) {
				$order_info['pay_time'] = RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']);
			}
			$order_info['goods_amount_price'] = price_format($order_info['goods_amount']);
			$order_info['shipping_fee_price'] = price_format($order_info['shipping_fee']);
			$order_info['pay_fee_price'] = price_format($order_info['pay_fee']);
			$order_info['pack_fee_price'] = price_format($order_info['pack_fee']);
			$order_info['insure_fee_price'] = price_format($order_info['insure_fee']);
			$order_info['card_fee_price'] = price_format($order_info['card_fee']);
			$order_info['tax_price'] = price_format($order_info['tax']);
			$order_info['integral_money_price'] = price_format($order_info['integral_money']);
			$order_info['bonus_price'] = price_format($order_info['bonus']);
			$order_info['discount_price'] = price_format($order_info['discount']);
			
		}
		return $order_info;
	}
	
	/**
	 * 普通订单实付金额计算
	 * 实付金额 = 商品总金额 + 发票税额 + 配送费用 + 保价费用 + 支付费用 + 包装费用 + 贺卡费用 - 积分金额 - 红包金额 -折扣 
	 * 接口：实付金额 = $item->goods_amount + $item->shipping_fee + $item->insure_fee + $item->pay_fee + $item->pack_fee + $item->card_fee + $item->tax - $item->integral_money - $item->bonus - $item->discount;
	 */
	public static function order_money_total($order_id){
		if (!empty($order_id)) {
			$order_info = RC_DB::table('order_info')->where('order_id', $order_id)
			->select('order_id','order_sn','pay_name','pay_time','add_time','shipping_status',
					'consignee','province','city','district','street','address','mobile',
					'goods_amount','shipping_fee','pay_fee','pack_fee','insure_fee','card_fee','tax','integral_money','bonus','discount')
					->first();
			$order_money_total = price_format($order_info['goods_amount'] + $order_info['tax'] + $order_info['shipping_fee'] + $order_info['insure_fee'] + $order_info['pay_fee'] + $order_info['pack_fee'] +  $order_info['card_fee'] - $order_info['integral_money'] - $order_info['bonus'] - $order_info['discount']);
		}
		return $order_money_total;
	}
	
	/**
	 * 送货商品信息列表
	 */
	public static function get_goods_list($order_id){
		if (!empty($order_id)) {
			$goods_list = RC_DB::table('order_goods')->where('order_id', $order_id)->select('goods_id', 'goods_name' ,'goods_price','goods_number')->get();
			foreach ($goods_list as $key => $val) {
				$goods_list[$key]['goods_price']  = price_format($val['goods_price']);
				$goods_list[$key]['image']  = RC_DB::table('goods')->where('goods_id', $val['goods_id'])->pluck('goods_thumb');
			}
			$disk = RC_Filesystem::disk();
			foreach ($goods_list as $key => $val) {
				if (!$disk->exists(RC_Upload::upload_path($val['image'])) || empty($val['image'])) {
					$goods_list[$key]['image'] = RC_Uri::admin_url('statics/images/nopic.png');
				} else {
					$goods_list[$key]['image'] = RC_Upload::upload_url($val['image']);
				}
			}
		}
		return $goods_list;
	}
}

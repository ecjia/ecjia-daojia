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
namespace Ecjia\App\Cart\CartFlow;

use RC_DB;
use RC_Time;


/**
 *生成订单
 */
class CreateOrder
{
	/**
	 *单店订单生成
	 *@param array $cart_goods 单店购物车商品
	 *@param array $order 订单信息
	 */
	public static function generate_order($cart_goods, $order) {
		
		$cart_goods		= $cart_goods['cart_list'];
		
		$inv_tax_no 	= $order['inv_tax_no'];
		$inv_title_type = $order['inv_title_type'];
		$temp_amout 	= $order['temp_amout'];   //店铺商品金额除去店铺优惠活动抵扣，剩下可以用红包抵扣的商品金额
		//配送方式id处理
		$ship_id = explode('-', $order['shipping_id']['0']);
		$shipping_id = $ship_id['1'];
		 
		if ($shipping_id > 0) {
			$shipping = \ecjia_shipping::pluginData(intval($shipping_id));
			$order['shipping_name'] = addslashes($shipping['shipping_name']);
			$order['shipping_id'] = $shipping['shipping_id'];
		}
		//期望送达时间处理
		if (!empty($order['expect_shipping_time']) && is_array($order['expect_shipping_time'])) {
			$expect_shipping_time = explode('|', $order['expect_shipping_time']['0']);
			$order['expect_shipping_time'] = empty($expect_shipping_time['1']) ? '' : $expect_shipping_time['1'];
		}
		//店铺id
		$order['store_id'] = intval($cart_goods['0']['store_id']);
		$cart_goods = $cart_goods['0']['goods_list'];
	
		foreach ($cart_goods as $row) {
			$goods_arr = array(
					'goods_id' 			=> $row['goods_id'],
					'goods_name' 		=> $row['goods_name'],
					'goods_sn' 			=> $row['goods_sn'],
					'product_id' 		=> empty($row['product_id']) ? 0 : $row['product_id'],
					'goods_number' 		=> $row['goods_number'],
					'market_price' 		=> $row['market_price'],
					'goods_price' 		=> $row['goods_price'],
					'goods_attr' 		=> empty($row['attr']) ? '' : $row['attr'],
					'is_real' 			=> $row['is_real'],
					'extension_code' 	=> empty($row['extension_code']) ? '' : $row['extension_code'],
					'goods_attr_id' 	=> empty($row['goods_attr_id']) ? '' : $row['goods_attr_id'],
			);
	
			$order_goods_recids[] = RC_DB::table('order_goods')->insertGetId($goods_arr);
		}
		//过滤掉订单表没有的字段
		unset($order['need_inv']);
		unset($order['need_insure']);
		unset($order['address_id']);
		unset($order['address_name']);
		unset($order['audit']);
		unset($order['longitude']);
		unset($order['latitude']);
		unset($order['address_info']);
		unset($order['cod_fee']);
		unset($order['inv_tax_no']);
		unset($order['inv_title_type']);
		unset($order['temp_amout']);
		 
		//判断订单类型
		if(empty($order['extension_code']) && !empty($order['shipping_id'])) {
			$shipping_info = \ecjia_shipping::getPluginDataById($order['shipping_id']);
			if($shipping_info['shipping_code'] == 'ship_cac') {
				$order['extension_code'] = 'storepickup';
			}
		}
	
		$new_order_id = 0;
		$error_no = 0;
		do {
			try {
				$order['order_sn'] = ecjia_order_buy_sn(); //获取新订单号
				$new_order_id = RC_DB::table('order_info')->insertGetId($order);
	
			} catch(\Exception $e) {
				$error = $e->getMessage();
				if($error) {
					if(stripos($error, "1062 Duplicate entry")) {
						$error_no = 1;
					} else {
						$error_no = 0;
						return new \ecjia_error('order_error', __('订单生成失败', 'cart'));
					}
				}
			}
	
		} while ($error_no == 1); //如果是订单号重复则重新提交数据
	
		if ($new_order_id <= 0) {
			return new \ecjia_error('order_error', __('订单生成失败', 'cart'));
		}
		foreach ($order_goods_recids as $rec_id) {
			$data = array('order_id' => $new_order_id);
			RC_DB::table('order_goods')->where('rec_id', $rec_id)->update($data);
		}
		if(!RC_DB::table('order_goods')->where('order_id', $new_order_id)->count()) {
			RC_DB::table('order_info')->where('order_id', $new_order_id)->delete();
		}
	
		$order['order_id'] = $new_order_id;
	
		/* 如果使用库存，且下订单时减库存，则减少库存 */
		if (\ecjia::config('use_storage') == '1' && \ecjia::config('stock_dec_time') == SDT_PLACE) {
			$result = \Ecjia\App\Cart\CartFunction::change_order_goods_storage($new_order_id, true, SDT_PLACE);
			if (is_ecjia_error($result)) {
				/* 库存不足删除已生成的订单（并发处理）*/
				RC_DB::table('order_info')->where('order_id', $new_order_id)->delete();
				RC_DB::table('order_goods')->where('order_id', $new_order_id)->delete();
				return $result;
			}
		}
	
		/* 处理余额、积分、红包 */
		if ($order['user_id'] > 0 && $order['integral'] > 0) {
			$integral_name = \ecjia::config('integral_name');
			if (empty($integral_name)) {
				$integral_name = __('积分', 'cart');
			}
			$params = array(
					'user_id'		=> $order['user_id'],
					'pay_points'	=> $order['integral'] * (- 1),
					'change_desc'	=> sprintf(__('支付订单 %s', 'cart'), $order['order_sn']),
					'from_type'		=> 'order_use_integral',
					'from_value'	=> $order['order_sn']
			);
			$result = \RC_Api::api('user', 'account_change_log', $params);
			if (is_ecjia_error($result)) {
	
			}
		}
		/* $temp_amout 店铺商品金额除去店铺优惠活动抵扣金额，剩下可以用红包抵扣的商品金额*/
		if ($order['bonus_id'] > 0 && $temp_amout > 0) {
			\RC_Api::api('bonus', 'use_bonus', array('bonus_id' => $order['bonus_id'], 'order_id' => $new_order_id));
		}
	
		//其他
		$order['goods_list'] = $cart_goods;
		$order['inv_tax_no'] 		= $inv_tax_no;
		$order['inv_title_type'] 	= $inv_title_type;
		\RC_Api::api('cart', 'flow_done_do_something', $order);
		 
		return $order;
	}
	
	
	/**
	 *多店订单生成及分单
	 *@param array $cart_goods_list 多店购物车商品
	 *@param array $order 订单信息
	 *param array $max_integral 订单最多可使用的积分
	 */
	public static function generate_separate_order($cart_goods_list, $order, $max_integral = 0) {
		
		$cart_goods_list = $cart_goods_list['cart_list'];
		
		$expect_shipping_time = $order['expect_shipping_time'];
		$separate_order_goods = [];
		$shippings = [];
		$goods_amount = [];
		foreach ($cart_goods_list as $store) {
			foreach ($store['goods_list'] as $rows) {
				$goods_arr = array(
						'goods_id' 			=> $rows['goods_id'],
						'goods_name' 		=> $rows['goods_name'],
						'goods_sn' 			=> $rows['goods_sn'],
						'product_id' 		=> empty($rows['product_id']) ? 0 : $rows['product_id'],
						'goods_number' 		=> $rows['goods_number'],
						'market_price' 		=> $rows['market_price'],
						'goods_price' 		=> $rows['goods_price'],
						'goods_attr' 		=> empty($rows['attr']) ? '' : $rows['attr'],
						'is_real' 			=> $rows['is_real'],
						'extension_code' 	=> empty($rows['extension_code']) ? '' : $rows['extension_code'],
						'goods_attr_id' 	=> empty($rows['goods_attr_id']) ? '' : $rows['goods_attr_id'],
				);
				//分单商品数据
				$separate_order_goods[$store['store_id']][] = $goods_arr;
	
				$goods_amount[$store['store_id']] += $rows['goods_price'] * $rows['goods_number'];
			}
	
			foreach ($store['shipping'] as $ship_row) {
				foreach ($order['shipping_id'] as $ship_val) {
					$ship_str = explode('-', $ship_val);
					if ($store['store_id'] == $ship_str['0'] && $ship_row['shipping_id'] == $ship_str['1']) {
						$shipping_arr = array(
								'shipping_id' 			=> $ship_row['shipping_id'],
								'shipping_code' 		=> $ship_row['shipping_code'],
								'shipping_name' 		=> $ship_row['shipping_name'],
								'shipping_fee' 			=> $ship_row['shipping_fee'],
								'insure_fee' 			=> 0,
								'store_id'				=> $store['store_id'],
								'discount'				=> sprintf("%.2f", $store['total']['discount']),
						);
						$shippings[$store['store_id']] = $shipping_arr;
					}
				}
			}
		}
		 
		//红包
		$bonus = \Ecjia\App\Bonus\UserAvaliableBonus::bonusInfo($order['bonus_id']);
	
		//支付手续费 发票税费   余额  遍历时计算
	
		$new_order_id = 0;
		$order_info_array_keys = ['order_sn', 'user_id', 'order_status', 'pay_status', 'pay_id',
		'pay_name', 'shippings', 'how_oos', 'how_surplus', 'inv_type', 'inv_payee', 'inv_no', 'inv_content',
		'goods_amount', 'shipping_fee', 'insure_fee', 'pay_fee', 'money_paid', 'surplus', 'integral', 'integral_money',
		'bonus', 'order_amount', 'bonus_id', 'tax', 'discount', 'add_time', 'confirm_time', 'pay_time',
		'postscript', 'consignee', 'country', 'province', 'city', 'district', 'street', 'address',
		'longitude', 'latitude', 'zipcode', 'tel', 'mobile', 'email', 'from_ad', 'referer',
		'extension_code', 'extension_id', 'separate_order_goods', 'is_separate'
				];
		foreach ($order as $key => $row) {
			if(!in_array($key, $order_info_array_keys)) {
				unset($order[$key]);
			}
		}
		$order['shippings'] = serialize($shippings);
		$order['separate_order_goods'] = serialize($separate_order_goods);
		 
		$error_no = 0;
		do {
			try {
				$order['order_sn'] = ecjia_order_separate_sn(); //获取分单订单号
				$new_order_id = RC_DB::table('separate_order_info')->insertGetId($order);
			} catch(\Exception $e) {
				$error = $e->getMessage();
				if($error) {
					if(stripos($error, "1062 Duplicate entry")) {
						$error_no = 1;
					} else {
						$error_no = 0;
						return new \ecjia_error('order_error', __('订单生成失败', 'cart'));
					}
				}
			}
	
		} while ($error_no == 1); //如果是订单号重复则重新提交数据
	
		$order['order_id'] = $new_order_id;
	
		//分单
		$surplus 		= $order['surplus'];
		$integral 		= $order['integral'];
		$integral_money = $order['integral_money'];
		$discount 		= $order['discount'];
		$tax 			= $order['tax'];
		$pay_fee 		= $order['pay_fee'];
		$store_number 	= count($separate_order_goods);
		$i = 0;
	
		//子订单
		foreach ($shippings as $key => $row) {
			$i +=1;
			$row = $order;
			unset($row['order_id']);unset($row['order_sn']);unset($row['shippings']);
			unset($row['separate_order_goods']);unset($row['is_separate']);unset($row['log_id']);
	
			//order_info
			//重置部分费用字段
			$row['tax'] = 0;
			$row['pay_fee'] = 0;
			$row['integral'] = 0;
			$row['integral_money'] = 0;
			$row['expect_shipping_time'] = '';
	
			$row['separate_order_sn'] 	= $order['order_sn'];//获取主订单sn
			$row['store_id']			= $shippings[$key]['store_id'];
			$row['shipping_id']			= $shippings[$key]['shipping_id'];
			$row['shipping_name'] 		= isset($shippings[$key]['shipping_name']) ? $shippings[$key]['shipping_name'] : '';
			$row['shipping_fee'] 		= $shippings[$key]['shipping_fee'];
			$row['discount'] 			= $shippings[$key]['discount'];
			$row['goods_amount'] 		= $goods_amount[$key]; //商品总金额
			$row['order_amount'] 		= $row['goods_amount'] + $row['shipping_fee'] + $row['tax'] + $row['pay_fee'] - $row['discount'];
	
			//红包按所属店铺分配
			if ($bonus['store_id'] == $shippings[$key]['store_id']) {
				$row['bonus'] 				= $order['bonus'];
				$row['bonus_id'] 			= $order['bonus_id'];
			} else {
				$row['bonus'] 				= 0.00;
				$row['bonus_id'] 			= 0;
			}
			if ($row['order_amount'] > $row['bonus']) {
				$row['order_amount'] -= $row['bonus'];
			}
	
			//发票税费
			if($tax) {
				//按各店铺订单金额计算比例
				if($i < $store_number) {
					$row['tax'] = \Ecjia\App\Cart\CartFlow\MultiStoreOrderFee::get_tax_fee($order['inv_type'], $row['goods_amount']);
					$tax -= $row['tax'];
				} else {
					$row['tax'] = $tax;
				}
				$row['order_amount'] += $row['tax'];//重新计算总价
			}
			//发票税费 end
	
			//期望送达时间处理
			if ($expect_shipping_time && is_array($expect_shipping_time)) {
				foreach ($expect_shipping_time as $ship_time) {
					$ship_time_str = explode('|', $ship_time);
					if ($row['store_id'] == $ship_time_str['0']) {
						$row['expect_shipping_time'] = $ship_time_str['1'];
					}
				}
			}
	
			//积分 start
			//共可用数量，本店可用数量
			if ($integral_money > 0) {
				//积分只能使用整数个
				if ($i < $store_number) {
					$integral_rate = \Ecjia\App\Cart\CartFlow\MultiStoreOrderFee::get_integral_store($separate_order_goods[$key]) / $max_integral;
					if($integral_rate) {
						$row['integral'] = round($integral * $integral_rate);
						$row['integral_money'] = \Ecjia\App\Cart\CartFunction::value_of_integral($row['integral']);
						$integral -= $row['integral'];
						$integral_money -= $row['integral_money'];
					}
	
				} else {
					$row['integral'] = $integral;
					$row['integral_money'] = $integral_money;
				}
				if ($row['order_amount'] > $row['integral_money']) {
					$row['order_amount'] = $row['order_amount'] - $row['integral_money'];
				}
			} else {
				$row['integral_money'] = 0;
				$row['integral'] = 0;
			}
			//积分 end
	
			//支付手续费
			if($pay_fee) {
				//按各店铺订单金额计算比例
				if($i < $store_number) {
					$row['pay_fee'] = \Ecjia\App\Cart\CartFlow\MultiStoreOrderFee::pay_fee($order['pay_id'], $row['order_amount']);
					$pay_fee -= $row['pay_fee'];
				} else {
					$row['pay_fee'] = $pay_fee;
				}
				$row['order_amount'] += $row['pay_fee'];//重新计算总价
			}
			//支付手续费 end
	
	
			//余额 start 分店铺订单使用
			if ($surplus > 0) {
				if ($surplus >= $row['order_amount']) {
					$surplus = $surplus - $row['order_amount'];
					$row['surplus'] = $row['order_amount']; //订单金额等于当前使用余额
					$row['order_amount'] = 0;
				} else {
					$row['order_amount'] = $row['order_amount'] - $surplus;
					$row['surplus'] = $surplus;
					$surplus = 0;
				}
			} else {
				$row['surplus'] = 0;
			}
			//余额 end
	
			$row['order_amount'] = number_format($row['order_amount'], 2, '.', ''); //格式化价格为一个数字
	
			$row['order_status'] = OS_UNCONFIRMED;
			$row['confirm_time'] = 0;
			$row['pay_status'] = PS_UNPAYED;
			$row['pay_time'] = 0;
	
			//判断订单类型
			if(empty($row['extension_code']) && $row['shipping_id']) {
				$shipping_info = \ecjia_shipping::getPluginDataById(intval($row['shipping_id']));
				if($shipping_info['shipping_code'] == 'ship_cac') {
					$row['extension_code'] = 'storepickup';
				}
			}
	
			$error_no = 0;
			$new_order_id_child = 0;
			do {
				try {
					$row['order_sn'] = ecjia_order_buy_sn();
					$new_order_id_child = RC_DB::table('order_info')->insertGetId($row);
				} catch(\Exception $e) {
					$error = $e->getMessage();
					if($error) {
						if(stripos($error, "1062 Duplicate entry")) {
							$error_no = 1;
						} else {
							$error_no = 0;
							return new \ecjia_error('child_order_error', __('子订单生成失败', 'cart'));
						}
					}
				}
			} while ($error_no == 1062); //如果是订单号重复则重新提交数据
	
			//order_goods
			if ($new_order_id_child) {
				$row['order_id'] = $new_order_id_child;
				foreach ($separate_order_goods[$key] as $goods) {
					$goods['order_id'] = $new_order_id_child;
					RC_DB::table('order_goods')->insert($goods);
				}
	
				/* 如果使用库存，且下订单时减库存，则减少库存 */
				if (\ecjia::config('use_storage') == '1' && \ecjia::config('stock_dec_time') == SDT_PLACE) {
					$result = \Ecjia\App\Cart\CartFunction::change_order_goods_storage($new_order_id_child, true, SDT_PLACE);
					if (is_ecjia_error($result)) {
						/* 库存不足删除已生成的订单（并发处理） will.chen*/
						RC_DB::table('order_info')->where('order_id', $new_order_id_child)->delete();
						RC_DB::table('order_goods')->where('order_id', $new_order_id_child)->delete();
						return $result;
					}
				}
	
				/* 处理积分、红包 */
				if ($row['user_id'] > 0 && $row['integral'] > 0) {
					$integral_name = \ecjia::config('integral_name');
					if (empty($integral_name)) {
						$integral_name = __('积分', 'cart');
					}
					$params = array(
							'user_id'		=> $row['user_id'],
							'pay_points'	=> $row['integral'] * (- 1),
							'change_desc'	=> sprintf(__('支付订单 %s', 'cart'), $row['order_sn']),
							'from_type'		=> 'order_use_integral',
							'from_value'	=> $row['order_sn']
					);
					$result = \RC_Api::api('user', 'account_change_log', $params);
					if (is_ecjia_error($result)) {
	
					}
				}
				 
				//$temp_amout
				$temp_amout = $row['goods_amount'] - $row['discount'];
				if ($row['bonus_id'] > 0 && $temp_amout > 0 ) {
					\RC_Api::api('bonus', 'use_bonus', array('bonus_id' => $row['bonus_id'], 'order_id' => $new_order_id_child));
				}
	
				//其他
				$row['goods_list'] = $separate_order_goods[$key];
				
				/* 订单生成后，发送短信、 推送、 通知、 订单日志等操作*/
				\RC_Api::api('cart', 'flow_done_do_something', $row);
			} else {
				return new \ecjia_error('create_order_error', __('生成订单失败', 'cart'));
			}
		}
		RC_DB::table('separate_order_info')->where('order_sn', $order['order_sn'])->update(['is_separate' => 1]);
	
		return $order;
	}
	
	
	
}

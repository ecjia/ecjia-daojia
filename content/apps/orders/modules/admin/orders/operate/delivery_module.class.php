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
 * 订单进行发货
 * @author will
 *
 */
class delivery_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();

        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$result_view = $this->admin_priv('order_view'); 
		$result_edit = $this->admin_priv('order_ss_edit');
		if (is_ecjia_error($result_view)) {
			return $result_view;
		} elseif (is_ecjia_error($result_edit)) {
			return $result_edit;
		}

		$order_id		= $this->requestData('order_id', 0);
		$invoice_no		= $this->requestData('invoice_no');
		/* 发货数量*/
		$send_number	= $this->requestData('send_number');//array('123' => 1);rec_id,num

		$action_note	= $this->requestData('action_note', '');
		if (empty($order_id)) {
			return new ecjia_error('invalid_parameter', '参数错误');
		}
		/*验证订单是否属于此入驻商*/
        if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
		    $ru_id_group = RC_Model::model('orders/order_info_model')->where(array('order_id' => $order_id))->group('store_id')->get_field('store_id', true);
		    if (count($ru_id_group) > 1 || $ru_id_group[0] != $_SESSION['store_id']) {
		        return new ecjia_error('no_authority', '对不起，您没权限对此订单进行操作！');
		    }
		}
		
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		
		if (empty($order_info)) {
			return new ecjia_error('invalid_parameter', '参数错误');
		}
		
		/*配送方式为o2o速递时，自动生成运单号*/
		$shipping_info = RC_DB::table('shipping')->where('shipping_id', $order_info['shipping_id'])->first();
		if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
			$rand1 = mt_rand(100000,999999);
			$rand2 = mt_rand(1000000,9999999);
			$invoice_no = $rand1.$rand2;
		}
		
		/* 订单是否已全部分单检查 */
		if ($order_info['order_status'] == OS_SPLITED) {
			return new ecjia_error('already_splited', '订单已全部发货！');
		}
		
		RC_Loader::load_app_func('global', 'orders');
		RC_Loader::load_app_func('admin_order', 'orders');
		/* 取得订单商品 */
		$_goods = get_order_goods(array('order_id' => $order_id));
		$goods_list = $_goods['goods_list'];
		
		/* 检查此单发货数量填写是否正确 合并计算相同商品和货品 */
		if (!empty($send_number) && !empty($goods_list)) {
			$goods_no_package = array();
			foreach ($goods_list as $key => $value) {
				/* 去除 此单发货数量 等于 0 的商品 */
				if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
					// 如果是货品则键值为商品ID与货品ID的组合
					$_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);
		
					// 统计此单商品总发货数 合并计算相同ID商品或货品的发货数
					if (empty($goods_no_package[$_key])) {
						$goods_no_package[$_key] = $send_number[$value['rec_id']];
					} else {
						$goods_no_package[$_key] += $send_number[$value['rec_id']];
					}
		
					//去除
					if ($send_number[$value['rec_id']] <= 0) {
					    if ($send_number[$value['rec_id']]) {
					        unset($send_number[$value['rec_id']], $goods_list[$key]);
					    } else {
					        unset($goods_list[$key]);
					    }
						continue;
					}
				} else {
					/* 组合超值礼包信息 */
					$goods_list[$key]['package_goods_list'] = package_goods($value['package_goods_list'], $value['goods_number'], $value['order_id'], $value['extension_code'], $value['goods_id']);
		
					/* 超值礼包 */
					foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
						// 如果是货品则键值为商品ID与货品ID的组合
						$_key = empty($pg_value['product_id']) ? $pg_value['goods_id'] : ($pg_value['goods_id'] . '_' . $pg_value['product_id']);
		
						//统计此单商品总发货数 合并计算相同ID产品的发货数
						if (empty($goods_no_package[$_key])) {
							$goods_no_package[$_key] = $send_number[$value['rec_id']][$pg_value['g_p']];
						} else {
							//否则已经存在此键值
							$goods_no_package[$_key] += $send_number[$value['rec_id']][$pg_value['g_p']];
						}
		
						//去除
						if ($send_number[$value['rec_id']][$pg_value['g_p']] <= 0) {
							unset($send_number[$value['rec_id']][$pg_value['g_p']], $goods_list[$key]['package_goods_list'][$pg_key]);
						}
					}
		
					if (count($goods_list[$key]['package_goods_list']) <= 0) {
						unset($send_number[$value['rec_id']], $goods_list[$key]);
						continue;
					}
				}
		
				/* 发货数量与总量不符 */
				if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
					$sended = order_delivery_num($order_id, $value['goods_id'], $value['product_id']);
					if (($value['goods_number'] - $sended - $send_number[$value['rec_id']]) < 0) {
						return new ecjia_error('act_ship_num', '此单发货数量不能超出订单商品数量！');
					}
				} else {
					/* 超值礼包 */
					foreach ($goods_list[$key]['package_goods_list'] as $pg_key => $pg_value) {
						if (($pg_value['order_send_number'] - $pg_value['sended'] - $send_number[$value['rec_id']][$pg_value['g_p']]) < 0) {
							return new ecjia_error('act_ship_num', '此单发货数量不能超出订单商品数量！');
						}
					}
				}
			}
		}
		
		/* 对上一步处理结果进行判断 兼容 上一步判断为假情况的处理 */
		if (empty($send_number) || empty($goods_list)) {
			return new ecjia_error('shipping_empty', '没有可发货的商品！');
		}
		
		/* 检查此单发货商品库存缺货情况 */
		/* $goods_list已经过处理 超值礼包中商品库存已取得 */
		$virtual_goods = array();
		$package_virtual_goods = array();
		foreach ($goods_list as $key => $value) {
			// 商品（超值礼包）
			if ($value['extension_code'] == 'package_buy') {
				foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
					if ($pg_value['goods_number'] < $goods_no_package[$pg_value['g_p']] &&
					((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
							(ecjia::config('use_storage') == '0' && $pg_value['is_real'] == 0))) {
						return new ecjia_error('act_good_vacancy', '商品已缺货！');
					}
		
					/* 商品（超值礼包） 虚拟商品列表 package_virtual_goods*/
					if ($pg_value['is_real'] == 0) {
						$package_virtual_goods[] = array(
								'goods_id'		=> $pg_value['goods_id'],
								'goods_name'	=> $pg_value['goods_name'],
								'num'			=> $send_number[$value['rec_id']][$pg_value['g_p']]
						);
					}
				}
			} elseif ($value['extension_code'] == 'virtual_card' || $value['is_real'] == 0) {
				// 商品（虚货）
				$num = RC_Model::model('goods/virtual_card_model')->where(array('goods_id' => $value['goods_id'], 'is_saled' => 0))->count();
					
				if (($num < $goods_no_package[$value['goods_id']]) && !(ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE)) {
					return new ecjia_error('virtual_card_oos', '虚拟卡已缺货！');
				}
		
				/* 虚拟商品列表 virtual_card*/
				if ($value['extension_code'] == 'virtual_card') {
					$virtual_goods[$value['extension_code']][] = array('goods_id' => $value['goods_id'], 'goods_name' => $value['goods_name'], 'num' => $send_number[$value['rec_id']]);
				}
			} else {
				// 商品（实货）、（货品）
				//如果是货品则键值为商品ID与货品ID的组合
				$_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);
		
				/* （实货） */
				if (empty($value['product_id'])) {
					$num = RC_Model::model('goods/goods_model')->where(array('goods_id' => $value['goods_id']))->get_field('goods_number');
				} else {
					/* （货品） */
					$num = RC_Model::model('goods/products_model')->where(array('goods_id' => $value['goods_id'], 'product_id' => $value['product_id']))->get_field('product_number');
				}
		
				if (($num < $goods_no_package[$_key]) && ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) {
					return new ecjia_error('act_good_vacancy', '商品已缺货！');
				}
			}
		}
		
		
		/* 过滤字段项 */
		$filter_fileds = array(
				'order_sn', 'add_time', 'store_id', 'user_id', 'how_oos', 'shipping_id', 'shipping_name', 'shipping_fee',
				'consignee', 'address', 'country', 'province', 'city', 'district', 'sign_building', 'longitude', 'latitude',
				'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'insure_fee',
				'agency_id', 'delivery_sn', 'action_user', 'update_time',
				'suppliers_id', 'status', 'order_id', 'shipping_name'
		);
		$_delivery = array();
		foreach ($filter_fileds as $value) {
			$_delivery[$value] = $order_info[$value];
		}
		
		/* 生成发货单 */
		/* 获取发货单号和流水号 */
		$_delivery['delivery_sn']	= get_delivery_sn();
		$delivery_sn				= $_delivery['delivery_sn'];
		/* 获取当前操作员 */
		$_delivery['action_user']	= $_SESSION['admin_name'];
		/* 获取发货单生成时间 */
		$_delivery['update_time']	= RC_Time::gmtime();
		$delivery_time				= $_delivery['update_time'];
		
		$_delivery['add_time']		= RC_Model::model('orders/order_info_model')->where(array('order_id' => $order_id))->get_field('add_time');

		/*掌柜发货时将用户地址转为坐标存入delivery_order表*/
		if (empty($order_info['longitude']) || empty($order_info['latitude'])) {
			$db_region = RC_Model::model('region_model');
			$region_name = $db_region->where(array('region_id' => array('in' => $order_info['province'], $order_info['city'])))->order('region_type')->select();
		
			$province_name	= $region_name[0]['region_name'];
			$city_name		= $region_name[1]['region_name'];
			$consignee_address = $province_name.'省'.$city_name.'市'.$order_info['address'];
			$consignee_address = urlencode($consignee_address);
		
			//腾讯地图api 地址解析（地址转坐标）
			$keys = ecjia::config('map_qq_key');
			$shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$consignee_address."&key=".$keys);
			$shop_point = json_decode($shop_point['body'], true);
			if (isset($shop_point['result']) && !empty($shop_point['result']['location'])) {
				$_delivery['longitude']	= $shop_point['result']['location']['lng'];
				$_delivery['latitude']	= $shop_point['result']['location']['lat'];
			}
		}
		
		/* 获取发货单所属供应商 */
		// 		$delivery['suppliers_id']	= $suppliers_id;
		/* 设置默认值 */
		$_delivery['status']		= 2; // 正常
		$_delivery['order_id']		= $order_id;
		
		
		/* 发货单入库 */
		$delivery_id = RC_Model::model('orders/delivery_order_model')->insert($_delivery);
		/* 记录日志 */
		if ($_SESSION['store_id'] > 0) {
		    RC_Api::api('merchant', 'admin_log', array('text' => '订单号是 '.$order_info['order_sn'].'【来源掌柜】', 'action' => 'produce', 'object' => 'delivery_order'));
		} else {
		    ecjia_admin::admin_log('订单号是 '.$order_info['order_sn'].'【来源掌柜】', 'produce', 'delivery_order'); // 记录日志
		}
		if ($delivery_id) {
			$delivery_goods = array();
			//发货单商品入库
			if (!empty($goods_list)) {
				foreach ($goods_list as $value) {
					// 商品（实货）（虚货）
					if (empty($value['extension_code']) || $value['extension_code'] == 'virtual_card') {
						$delivery_goods = array(
								'delivery_id'	=> $delivery_id,
								'goods_id'		=> $value['goods_id'],
								'product_id'	=> $value['product_id'],
								'product_sn'	=> $value['product_sn'],
								'goods_id'		=> $value['goods_id'],
								'goods_name'	=> addslashes($value['goods_name']),
								'brand_name'	=> addslashes($value['brand_name']),
								'goods_sn'		=> $value['goods_sn'],
								'send_number'	=> $send_number[$value['rec_id']],
								'parent_id'		=> 0,
								'is_real'		=> $value['is_real'],
								'goods_attr'	=> addslashes($value['goods_attr'])
						);
		
						/* 如果是货品 */
						if (!empty($value['product_id'])) {
							$delivery_goods['product_id'] = $value['product_id'];
						}
						$query = RC_Model::model('orders/delivery_goods_model')->insert($delivery_goods);
					} elseif ($value['extension_code'] == 'package_buy') {
						// 商品（超值礼包）
						foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
							$delivery_pg_goods = array(
									'delivery_id'		=> $delivery_id,
									'goods_id'			=> $pg_value['goods_id'],
									'product_id'		=> $pg_value['product_id'],
									'product_sn'		=> $pg_value['product_sn'],
									'goods_name'		=> $pg_value['goods_name'],
									'brand_name'		=> '',
									'goods_sn'			=> $pg_value['goods_sn'],
									'send_number'		=> $send_number[$value['rec_id']][$pg_value['g_p']],
									'parent_id'			=> $value['goods_id'], // 礼包ID
									'extension_code'	=> $value['extension_code'], // 礼包
									'is_real'			=> $pg_value['is_real']
							);
							$query = RC_Model::model('orders/delivery_goods_model')->insert($delivery_pg_goods);
						}
					}
				}
			}
		} else {
			return new ecjia_error('shipping_error', '发货失败！');
		}
		unset($filter_fileds, $delivery, $_delivery, $order_finish);
		
		/* 订单信息更新处理 */
		if (true) {
			/* 订单信息 */
			$_sended = & $send_number;
			foreach ($_goods['goods_list'] as $key => $value) {
				if ($value['extension_code'] != 'package_buy') {
					unset($_goods['goods_list'][$key]);
				}
			}
			foreach ($goods_list as $key => $value) {
				if ($value['extension_code'] == 'package_buy') {
					unset($goods_list[$key]);
				}
			}
			$_goods['goods_list'] = $goods_list + $_goods['goods_list'];
			unset($goods_list);
		
			/* 更新订单的虚拟卡 商品（虚货） */
			$_virtual_goods = isset($virtual_goods['virtual_card']) ? $virtual_goods['virtual_card'] : '';
			update_order_virtual_goods($order_id, $_sended, $_virtual_goods);
		
			/* 更新订单的非虚拟商品信息 即：商品（实货）（货品）、商品（超值礼包）*/
			update_order_goods($order_id, $_sended, $_goods['goods_list']);
		
			/* 标记订单为已确认 “发货中” */
			/* 更新发货时间 */
			$order_finish = get_order_finish($order_id);
			$shipping_status = SS_SHIPPED_ING;
			if ($order_info['order_status'] != OS_CONFIRMED && $order_info['order_status'] != OS_SPLITED && $order_info['order_status'] != OS_SPLITING_PART) {
				$arr['order_status']	= OS_CONFIRMED;
				$arr['confirm_time']	= GMTIME_UTC;
			}
		
			$arr['order_status']		= $order_finish ? OS_SPLITED : OS_SPLITING_PART; // 全部分单、部分分单
			$arr['shipping_status']		= $shipping_status;
			update_order($order_id, $arr);
		}
		/* 记录log */
		order_action($order_info['order_sn'], $arr['order_status'], $shipping_status, $order_info['pay_status'], $action_note);
		
		$order_info['invoice_no'] = $invoice_no;
		$delivery_result = delivery_order($delivery_id, $order_info);
		if (!is_ecjia_error($delivery_result)) {
		    create_express_order($delivery_id);
		}
		
		return $delivery_result;
	} 
}

function delivery_order($delivery_id, $order) {
	
	/* 发货处理*/
	$delivery_order = delivery_order_info($delivery_id);
	/* 检查此单发货商品库存缺货情况 */
	$virtual_goods			= array();
	$delivery_stock_result	= RC_Model::model('orders/delivery_viewmodel')->join(array('goods', 'products'))->where(array('dg.delivery_id' => $delivery_id))->group(array('dg.product_id', 'dg.goods_id'))->select();
	
	/* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
	if(!empty($delivery_stock_result)) {
		foreach ($delivery_stock_result as $value) {
			if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) &&
			((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
					(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
				return new ecjia_error('act_good_vacancy', '['.$value['goods_name'].']'.'商品已缺货');
			}
	
			/* 虚拟商品列表 virtual_card */
			if ($value['is_real'] == 0) {
				$virtual_goods[] = array(
						'goods_id'		=> $value['goods_id'],
						'goods_name'	=> $value['goods_name'],
						'num'			=> $value['send_number']
				);
			}
		}
	} else {
		$db_delivery = RC_Model::model('orders/delivery_viewmodel');
		$db_delivery->view = array(
				'goods' => array(
						'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'		=> 'g',
						'field'		=> 'dg.goods_id, dg.is_real, SUM(dg.send_number) AS sums, g.goods_number, g.goods_name, dg.send_number',
						'on'		=> 'dg.goods_id = g.goods_id ',
				)
		);
	
		$delivery_stock_result = $db_delivery->where(array('dg.delivery_id' => $delivery_id))->group('dg.goods_id')->select();
	
		foreach ($delivery_stock_result as $value) {
			if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) &&
			((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
					(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
				
				return new ecjia_error('act_good_vacancy', '['.$value['goods_name'].']'.'商品已缺货');
				
			}
	
			/* 虚拟商品列表 virtual_card*/
			if ($value['is_real'] == 0) {
				$virtual_goods[] = array(
						'goods_id'		=> $value['goods_id'],
						'goods_name'	=> $value['goods_name'],
						'num'			=> $value['send_number']
				);
			}
		}
	}
	
	/* 发货 */
	/* 处理虚拟卡 商品（虚货） */
	if (is_array($virtual_goods) && count($virtual_goods) > 0) {
		foreach ($virtual_goods as $virtual_value) {
			virtual_card_shipping($virtual_value, $order['order_sn'], $msg, 'split');
		}
	}
	
	/* 如果使用库存，且发货时减库存，则修改库存 */
	if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
		foreach ($delivery_stock_result as $value) {
			/* 商品（实货）、超级礼包（实货） */
			if ($value['is_real'] != 0) {
				/* （货品） */
				if (!empty($value['product_id'])) {
					$data = array(
							'product_number' => $value['storage'] - $value['sums'],
					);
					RC_Model::model('goods/products_model')->where(array('product_id' => $value['product_id']))->update($data);
				} else {
					$data = array(
							'goods_number' => $value['storage'] - $value['sums'],
					);
					RC_Model::model('goods/goods_model')->where(array('goods_id' => $value['goods_id']))->update($data);
				}
			}
		}
	}
	
	/* 修改发货单信息 */
	$invoice_no = str_replace(',', '<br>', $order['invoice_no']);
	$invoice_no = trim($invoice_no, '<br>');
	$_delivery['invoice_no']	= $invoice_no;
	$_delivery['status']		= 0;	/* 0，为已发货 */
	
	$result = RC_Model::model('orders/delivery_order_model')->where(array('delivery_id' => $delivery_id))-> update($_delivery);
	
	if (!$result) {
		return new ecjia_error('act_false', '发货失败！');
	}
	
	/* 标记订单为已确认 “已发货” */
	/* 更新发货时间 */
	$order_finish				= get_all_delivery_finish($order['order_id']);
	$shipping_status			= ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
	$arr['shipping_status']		= $shipping_status;
	$arr['shipping_time']		= RC_Time::gmtime(); // 发货时间
	if ($order['invoice_no'] != $invoice_no) {
	    $arr['invoice_no']			= trim($order['invoice_no'] . '<br>' . $invoice_no, '<br>');
	} else {
	    $arr['invoice_no']			= trim($order['invoice_no'], '<br>');
	}
	update_order($order['order_id'], $arr);
	
	/* 发货单发货记录log */
	order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], '', '', 1);
	
	/*当订单配送方式为o2o速递时,记录o2o速递物流信息*/
	if ($order['shipping_id'] > 0) {
		$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
		$shipping_info = $shipping_method->shipping_info($order['shipping_id']);
		if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
			$data = array(
					'express_code' => $shipping_info['shipping_code'],
					'track_number' => $arr['invoice_no'],
					'time'		   => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()),
					'context'	   => '您的订单已配备好，等待配送员取货',
			);
			RC_DB::table('express_track_record')->insert($data);
		}
	}
	
	// 记录管理员操作
	if ($_SESSION['store_id'] > 0) {
	    RC_Api::api('merchant', 'admin_log', array('text' => '发货，订单号是'.$order['order_sn'].'【来源掌柜】', 'action' => 'setup', 'object' => 'order'));
	} else {
	    ecjia_admin::admin_log('发货，订单号是'.$order['order_sn'].'【来源掌柜】', 'setup', 'order'); // 记录日志
	}
	
	/* 如果当前订单已经全部发货 */
	if ($order_finish) {
		/* 如果订单用户不为空，计算积分，并发给用户；发红包 */
		if ($order['user_id'] > 0) {
			/* 取得用户信息 */
			$user = user_info($order['user_id']);
			/* 计算并发放积分 */
			$integral = integral_to_give($order);
			$options = array(
					'user_id'		=> $order['user_id'],
					'rank_points'	=> intval($integral['rank_points']),
					'pay_points'	=> intval($integral['custom_points']),
					'change_desc'	=> sprintf('订单 %s 赠送的积分', $order['order_sn'])
			);
			RC_Api::api('user', 'account_change_log',$options);
			/* 发放红包 */
			send_order_bonus($order['order_id']);
		}
	
		/* 发送邮件 */
		$cfg = ecjia::config('send_ship_email');
		if ($cfg == '1') {
			$order['invoice_no'] = $invoice_no;
			$tpl_name = 'deliver_notice';
			$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
			if (empty($tpl)) {
				ecjia_api::$controller->assign('order'			, $order);
				ecjia_api::$controller->assign('send_time'		, RC_Time::local_date(ecjia::config('time_format')));
				ecjia_api::$controller->assign('shop_name'		, ecjia::config('shop_name'));
				ecjia_api::$controller->assign('send_date'		, RC_Time::local_date(ecjia::config('date_format')));
				ecjia_api::$controller->assign('confirm_url'	, SITE_URL . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
				ecjia_api::$controller->assign('send_msg_url'	, SITE_URL . RC_Uri::url('user/admin/message_list','order_id=' . $order['order_id']));
				
				$content = ecjia_api::$controller->fetch_string($tpl['template_content']);
				
				RC_Mail::send_mail($order['consignee'], $order['email'] , $tpl['template_subject'], $content, $tpl['is_html']);
			}
		}
		
		/* 如果需要，发短信 */
		if (!empty($order['mobile'])) {
		    $order['invoice_no'] = $invoice_no;
		    //发送短信
		    $user_name = RC_DB::TABLE('users')->where('user_id', $order['user_id'])->pluck('user_name');
		    $options = array(
		        'mobile' => $order['mobile'],
		        'event'	 => 'sms_order_shipped',
		        'value'  =>array(
		            'user_name'    => $user_name,
		            'order_sn'     => $order['order_sn'],
		            'consignee'    => $order['consignee'],
		            'service_phone'=> ecjia::config('service_phone'),
		        ),
		    );
		    RC_Api::api('sms', 'send_event_sms', $options);
		}
	}
	return array();
}


function create_express_order($delivery_id) {
    $delivery_order = delivery_order_info($delivery_id);
    /* 判断发货单，生成配送单*/
    $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
    $shipping_info = $shipping_method->shipping_info($delivery_order['shipping_id']);
    if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
//         $staff_id = isset($_POST['staff_id']) ? intval($_POST['staff_id']) : 0;
//         $express_from = !empty($staff_id) ? 'assign' : 'grab';
        $staff_id = 0;
        $express_from = 'grab';
        $express_data = array(
            'express_sn' 	=> date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'order_sn'		=> $delivery_order['order_sn'],
            'order_id'		=> $delivery_order['order_id'],
            'delivery_id'	=> $delivery_order['delivery_id'],
            'delivery_sn'	=> $delivery_order['delivery_sn'],
            'store_id'		=> $delivery_order['store_id'],
            'user_id'		=> $delivery_order['user_id'],
            'consignee'		=> $delivery_order['consignee'],
            'address'		=> $delivery_order['address'],
            'country'		=> $delivery_order['country'],
            'province'		=> $delivery_order['province'],
            'city'			=> $delivery_order['city'],
            'district'		=> $delivery_order['district'],
            'email'			=> $delivery_order['email'],
            'mobile'		=> $delivery_order['mobile'],
            'best_time'		=> $delivery_order['best_time'],
            'remark'		=> '',
            'shipping_fee'	=> '5.00',
            'commision'		=> '',
            'add_time'		=> RC_Time::gmtime(),
            'longitude'		=> $delivery_order['longitude'],
            'latitude'		=> $delivery_order['latitude'],
            'from'			=> $express_from,
            'status'		=> $express_from == 'grab' ? 0 : 1,
            'staff_id'		=> $staff_id,
        );
    
        if ($staff_id > 0) {
            $express_data['receive_time'] = RC_Time::gmtime();
            $staff_info = RC_DB::table('staff_user')->where('user_id', $staff_id)->first();
            $express_data['express_user']	= $staff_info['name'];
            $express_data['express_mobile']	= $staff_info['mobile'];
        }
    
        $store_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
    
        if (!empty($store_info['longitude']) && !empty($store_info['latitude'])) {
        	//腾讯地图api距离计算
          	$key = ecjia::config('map_qq_key');
	        $url = "http://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$store_info['latitude'].",".$store_info['longitude']."&to=".$delivery_order['latitude'].",".$delivery_order['longitude']."&key=".$key;
	        $distance_json = file_get_contents($url);
	     	$distance_info = json_decode($distance_json, true);
	     	$express_data['distance'] = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
        }
    
        $exists_express_order = RC_DB::table('express_order')->where('delivery_sn', $delivery_order['delivery_sn'])->where('store_id', $_SESSION['store_id'])->first();
        if ($exists_express_order) {
            unset($express_data['add_time']);
            $express_data['update_time'] = RC_Time::gmtime();
            RC_DB::table('express_order')->where('express_id', $exists_express_order['express_id'])->update($express_data);
            $express_id = $exists_express_order['express_id'];
        } else {
            $express_id = RC_DB::table('express_order')->insert($express_data);
        }
    }
}
// end
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
 * 购物流检查订单
 * @author royalwang
 */
class flow_checkOrder_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}

    	$address_id = $this->requestData('address_id', 0);
		$rec_id		= $this->requestData('rec_id');
		$location 	= $this->requestData('location', array());
		
		if (empty($rec_id)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'cart'), __CLASS__));
		}
		$cart_id = array();
		if (!empty($rec_id)) {
			$cart_id = explode(',', $rec_id);
		}
		RC_Loader::load_app_class('cart', 'cart', false);

		/* 取得购物类型 */
		$rec_type = RC_DB::table('cart')->whereIn('rec_id', $cart_id)->lists('rec_type');
		$rec_type = array_unique($rec_type);
		if (count($rec_type) > 1) {
			return new ecjia_error( 'error_rec_type', __('购物车类型不一致！', cart));
		} else {
			$rec_type = $rec_type['0'];
			if ($rec_type == 1) {
				$flow_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS;
			} else {
				$flow_type = \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS;
			}
		}
		/* 团购标志 */
		if ($flow_type == \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS) {
			$is_group_buy = 1;
			$order_activity_type = 'group_buy';
		} elseif ($flow_type == \Ecjia\App\Cart\Enums\CartEnum::CART_EXCHANGE_GOODS) {
			/* 积分兑换商品 */
			$is_exchange_goods = 1;
		} else {
			//正常购物流程  清空其他购物流程情况
			$_SESSION['flow_order']['extension_code'] = '';
			$order_activity_type = 'default';
		}
		
		/* 检查购物车中是否有商品 */
		$get_cart_goods = RC_Api::api('cart', 'cart_list', array('cart_id' => $cart_id, 'flow_type' => $flow_type, 'store_group' => ''));
		
		if(is_ecjia_error($get_cart_goods)) {
		    return $get_cart_goods;
		}
		if (count($get_cart_goods['goods_list']) == 0) {
		    return new ecjia_error('not_found_cart_goods', __('购物车中还没有商品', 'cart'));
		}
		
		if (count($get_cart_goods['goods_list']) != count($cart_id)) {
		    return new ecjia_error('delivery_beyond_error', __('有部分商品不在送货范围内！', 'cart'));
		}
		
		/* 对是否允许修改购物车赋值 */
		if ($flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS || ecjia::config('one_step_buy') == '1') {
		    $allow_edit_cart = 0 ;
		} else {
		    $allow_edit_cart = 1 ;
		}

		/* 获取用户收货地址*/
		if ($address_id > 0) {
			$consignee = RC_DB::table('user_address')->where('address_id', $address_id)->where('user_id', $_SESSION['user_id'])->first();
			$_SESSION['address_id'] = $address_id;
		} else {
			if (isset($_SESSION['address_id'])) {
				$consignee = RC_DB::table('user_address')->where('address_id', $_SESSION['address_id'])->where('user_id', $_SESSION['user_id'])->first();
			} else {
				$consignee = cart::get_consignee($_SESSION['user_id']);
			}
		}
		
		//检查该地址是否在该店铺配送范围内 
		if (!empty($consignee)) {
		    $local = RC_Api::api('user', 'neighbors_address_store', array('address' => $consignee, 'store_id' => $get_cart_goods['goods_list'][0]['store_id']));
			if (!$local) {
				$consignee = array();
			}
		}

		$store_id_group = array();

		/* 取得订单信息*/
		$order = cart::flow_order_info();
		$store_group = array();
		$cart_goods  = array();
		foreach ($get_cart_goods['goods_list'] as $row) {
			$store_group[] = $row['store_id'];
			$goods_attr_gourp = array();
			if (!empty($row['goods_attr'])) {
				$goods_attr = explode("\n", $row['goods_attr']);
				$goods_attr = array_filter($goods_attr);
				foreach ($goods_attr as  $v) {
					$a = explode(':',$v);
					if (!empty($a[0]) && !empty($a[1])) {
						$goods_attr_gourp[] = array('name' => $a[0], 'value' => $a[1]);
					}
				}
			}

			$cart_goods[] = array(
				'seller_id'		=> intval($row['store_id']),
				'seller_name'	=> $row['store_name'],
				'store_id'		=> intval($row['store_id']),
				'store_name'	=> $row['store_name'],
				'rec_id'		=> intval($row['rec_id']),
				'goods_id'		=> intval($row['goods_id']),
				'goods_sn'		=> $row['goods_sn'],
				'goods_name'	=> $row['goods_name'],
				'goods_price'	=> $row['goods_price'],
				'market_price'	=> $row['market_price'],
				'formated_goods_price'	=> $row['formatted_goods_price'],
				'formated_market_price' => $row['formatted_market_price'],
				'goods_number'	=> intval($row['goods_number']),
				'subtotal'		=> $row['subtotal'],
				'goods_attr_id' => $row['goods_attr_id'],
				'attr'			=> $row['goods_attr'],
				'is_real'		=> $row['is_real'],
				'goods_attr'	=> $goods_attr_gourp,
				'img' => array(
					'thumb'	=> !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : '',
					'url'	=> !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : '',
					'small'	=> !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : '',
				)
			);
		}

		$store_group = array_unique($store_group);
		if (count($store_group) > 1) {
			return new ecjia_error('pls_single_shop_for_settlement', __('请单个店铺进行结算!', 'cart'));
		} else {
			$order['store_id'] = $store_group[0];
			$store_id =  $store_group[0];
		}

		/* 计算订单的费用 */
		$cod_fee    = 0;
		$total = cart::order_fee($order, $cart_goods, $consignee, $cart_id);
		if (!empty($consignee)) {
		    /* 取得配送列表 */
		    $region            = array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district'], $consignee['street']);
		    $shipping_list     = ecjia_shipping::availableUserShippings($region, $order['store_id']);

		    if ($flow_type == \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS) {
                $cart_weight_price = cart::cart_weight_price(\Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS);
            } else {
                $cart_weight_price = cart::cart_weight_price(\Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS, $cart_id);
            }

		    $insure_disabled   = true;
		    $cod_disabled      = true;
		    
		    $shipping_count_where[] = " (`extension_code` IS NULL or `extension_code` != 'package_buy') ";
		    if (!empty($cart_id)) {
		        $shipping_count_where['rec_id'] = $cart_id;
		    }
		    
		    $db_cart = RC_Model::model('cart/cart_model');
		    // 查看购物车中是否全为免运费商品，若是则把运费赋为零
		    if ($_SESSION['user_id']) {
		        $shipping_count_where['user_id'] = $_SESSION['user_id'];
		    } 
		    $shipping_count_where['is_shipping'] = array('neq' => 1);
		    $shipping_count       = $db_cart->where($shipping_count_where)->count();
		    
		    
		    /* ===== 计算收件人距离 ===== */
		    // 收件人地址，带坐标 $consignee
		    // 获取到店家的地址，带坐标
		    $store_info = RC_DB::table('store_franchisee')->where('store_id', $get_cart_goods['goods_list'][0]['store_id'])->where('shop_close', '0')->first();
		    // 计算店家距离收件人距离 $distance
		    if (!empty($store_info['longitude']) && !empty($store_info['latitude'])) {
		    	//腾讯地图api距离计算
		        $from = ['latitude' => $store_info['latitude'], 'longitude' => $store_info['longitude']];
		        $to = ['latitude' => $consignee['latitude'], 'longitude' => $consignee['longitude']];
		        $distance = Ecjia\App\User\Location::getDistance($from, $to);
		    }
		    /* ===== 计算收件人距离 ===== */
		    
		    $ck = array();
		    foreach ($shipping_list AS $key => $val) {
		        if (isset($ck[$val['shipping_id']])) {
		            unset($shipping_list[$key]);
		            continue;
		        }
		        $ck[$val['shipping_id']] = $val['shipping_id'];
		    
		        $shipping_cfg = ecjia_shipping::unserializeConfig($val['configure']);
		    
		        // O2O的配送费用计算传参调整
		        if ($val['shipping_code'] == 'ship_o2o_express' || $val['shipping_code'] == 'ship_ecjia_express') {
		        	$shipping_fee = ($shipping_count == 0 AND $cart_weight_price['free_shipping'] == 1) ? 0 : ecjia_shipping::fee($val['shipping_area_id'], $distance, $cart_weight_price['amount'], $cart_weight_price['number']);
		        } else {
		        	$shipping_fee = ($shipping_count == 0 AND $cart_weight_price['free_shipping'] == 1) ? 0 : ecjia_shipping::fee($val['shipping_area_id'], $cart_weight_price['weight'], $cart_weight_price['amount'], $cart_weight_price['number']);
		        }
		        $shipping_list[$key]['shipping_fee']        = $shipping_fee;
		        $shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee, false);
		        $shipping_list[$key]['free_money']          = price_format($shipping_cfg['free_money'], false);
		        $shipping_list[$key]['insure_formated']     = strpos($val['insure'], '%') === false ? price_format($val['insure'], false) : $val['insure'];
		    
		        /* 当前的配送方式是否支持保价 */
		        if ($val['shipping_id'] == $order['shipping_id']) {
		            $insure_disabled = ($val['insure'] == 0);
		            $cod_disabled    = ($val['support_cod'] == 0);
		        }
		    
		        /* o2o*/
		        if ($val['shipping_code'] == 'ship_o2o_express' || $val['shipping_code'] == 'ship_ecjia_express') {
		            /* 获取最后可送的时间（当前时间+需提前下单时间）*/
		            $time = RC_Time::local_date('H:i', RC_Time::gmtime() + $shipping_cfg['last_order_time'] * 60);
		    
		            if (empty($shipping_cfg['ship_time'])) {
		                unset($shipping_list[$key]);
		                continue;
		            }
		            $shipping_list[$key]['shipping_date'] = array();
		            $ship_date = 0;
		            
		            if (empty($shipping_cfg['ship_days'])) {
		            	$shipping_cfg['ship_days'] = 7;
		            }
		            
		            while ($shipping_cfg['ship_days']) {
		                foreach ($shipping_cfg['ship_time'] as $k => $v) {
		    
		                    if ($v['end'] > $time || $ship_date > 0) {
		                        $shipping_list[$key]['shipping_date'][$ship_date]['date'] = RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('+'.$ship_date.' day'));
		                        $shipping_list[$key]['shipping_date'][$ship_date]['time'][] = array(
		                            'start_time' 	=> $v['start'],
		                            'end_time'		=> $v['end'],
		                        );
		                    }
		                }
		    
		                $ship_date ++;
		    
		                if (count($shipping_list[$key]['shipping_date']) >= $shipping_cfg['ship_days']) {
		                    break;
		                }
		            }
		            $shipping_list[$key]['shipping_date'] = array_merge($shipping_list[$key]['shipping_date']);
		    
		        }
		    }
		    $shipping_list = array_values($shipping_list);
		    
		    
		    if ($order['shipping_id'] == 0) {
		        $cod        = true;
		        $cod_fee    = 0;
		    } else {
		        $shipping = ecjia_shipping::pluginData($order['shipping_id']);
		        
		        $cod      = $shipping['support_cod'];
		        if ($cod){
		            /* 如果是团购，且保证金大于0，不能使用货到付款 */
		            if ($flow_type == \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS) {
		                $group_buy_id = $_SESSION['extension_id'];
		                if ($group_buy_id <= 0) {
		                    return new ecjia_error('groupbuy_not_support_cod', __('如果是团购，且保证金大于0，不能使用货到付款', 'cart'));
		                }
		                RC_Loader::load_app_func('admin_goods', 'goods');
		                $group_buy = group_buy_info($group_buy_id);
		                if (empty($group_buy)) {
                            return new ecjia_error('invalid_parameter', __('参数错误', 'cart'));
		                }
		                if ($group_buy['deposit'] > 0) {
		                    $cod = false;
		                    $cod_fee = 0;
		                    /* 赋值保证金 */
		                    $gb_deposit = $group_buy['deposit'];
		                }
		            }
		            if ($cod) {
		                $shipping_area_info = ecjia_shipping::shippingArea($order['shipping_id'], $region, $order['store_id']);
		                
		                $cod_fee            = $shipping_area_info['pay_fee'];
		            }
		        }
		    }
		} else {
		    $shipping_list = array();
		}
		
		/* 取得支付列表 */
		$payment_list = RC_Api::api('payment', 'available_payments', array('store_id' => $order['store_id'], 'cod_fee' => $cod_fee));
		
		$user_info = RC_Api::api('user', 'user_info', array('user_id' => $_SESSION['user_id']));
		
		if (is_ecjia_error($user_info)) {
			return $user_info;
		}
		
		/* 保存 session */
		$_SESSION['flow_order'] = $order;

		$out = array();
		$out['goods_list']		= $cart_goods;//商品
		$out['consignee']		= $consignee;//收货地址
		$out['shipping_list']	= $shipping_list;//快递信息
		$out['payment_list']	= $payment_list;//支付信息
		
		//根据店铺id，店铺有没设置运费模板，查找店铺设置的运费模板关联的快递
		$shipping_area_list = RC_DB::table('shipping_area')->select('shipping_id')->where('store_id', $store_id)->groupBy('shipping_id')->get();
		
		if (!empty($shipping_area_list)) {
			foreach ($shipping_area_list as $key => $val) {
				$shipping_code[] =  RC_DB::table('shipping')->where('shipping_id', $val['shipping_id'])->value('shipping_code');
			}
			
			$count = count($shipping_code);
			if ($count > 1) {
				if (in_array('ship_cac', $shipping_code)) {
					$out['checkorder_mode']	= 'default_storepickup';//运费模板关联的快递有配送上门也有上门取货
				} else {
					$out['checkorder_mode']	= 'default';
				}
				
			} elseif ($count == 1) {
				if ($shipping_code['0'] == 'ship_cac') {
					$out['checkorder_mode']	= 'storepickup'; //运费模板关联的快递只有一个且是上门取货
					$ship_id = $shipping_area_list['0']['shipping_id'];
				} else {
					$out['checkorder_mode']	= 'default';//运费模板关联的快递只有一个且是配送上门
				}
			}
		} else {
			$out['shipping_list'] = array();
			$out['checkorder_mode']	= 'default';  //没有任何配送方式，订单结算模式只有配送上门
		}
		
		if ($order_activity_type == 'group_buy') {
			if ($out['checkorder_mode'] == 'storepickup' || $out['checkorder_mode'] == 'default_storepickup') {
				$out['checkorder_mode']	= 'default';
			}
		} 
		
		/* 如果使用积分，取得用户可用积分及本订单最多可以使用的积分 */
		if ((ecjia_config::has('use_integral') || ecjia::config('use_integral') == '1')
				&& $_SESSION['user_id'] > 0
				&& $user_info['pay_points'] > 0
				&& ($flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS && $flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_EXCHANGE_GOODS))
		{
			// 能使用积分
			$allow_use_integral = 1;
			$order_max_integral = cart::flow_available_points($cart_id);
			$user_pay_points 	= $user_info['pay_points'] > 0 ? $user_info['pay_points'] : 0;
			$order_max_integral = min($order_max_integral, $user_pay_points);
		} else {
			$allow_use_integral = 0;
			$order_max_integral = 0;
		}
		$out['allow_use_integral'] = $allow_use_integral;//积分 是否使用积分
		$out['order_max_integral'] = $order_max_integral;//订单最大可使用积分
			/* 如果使用红包，取得用户可以使用的红包及用户选择的红包 */
		if ((ecjia_config::has('use_bonus') || ecjia::config('use_bonus') == '1')
				&& ($flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_GROUP_BUY_GOODS && $flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_EXCHANGE_GOODS))
		{
			// 取得用户可用红包
			$pra = array(
				'user_id' 			=> $_SESSION['user_id'],
				//'store_id' 			=> array($order['store_id'], 0),
				'min_goods_amount'	=> $total['goods_price']
			);
			//商家小程序只能使用商家红包
			if ($this->device['code'] == '6016') {
				$pra['store_id'] = [$order['store_id']];
			} else {
				$pra['store_id'] = [$order['store_id'], 0];
			}
			$user_bonus = Ecjia\App\Bonus\UserAvaliableBonus::GetUserBonus($pra);
			$user_bonus_list = array();
			if (!empty($user_bonus)) {
				foreach ($user_bonus AS $key => $val) {
					/*app 2.8新增字段处理*/
					$user_bonus_list[$key]['bonus_id']                 = $val['bonus_id'];
					$user_bonus_list[$key]['bonus_name']               = $val['type_name'];
					$user_bonus_list[$key]['bonus_amount']             = $val['type_money'];
					$user_bonus_list[$key]['formatted_bonus_amount']   = price_format($val['type_money']);
					$user_bonus_list[$key]['request_amount']           = $val['min_goods_amount'];
					$user_bonus_list[$key]['formatted_request_amount'] = price_format($val['min_goods_amount']);
					$user_bonus_list[$key]['bonus_status']             = 0;
					$user_bonus_list[$key]['formatted_bonus_status']   = __('未使用', 'cart');
					$user_bonus_list[$key]['start_date']               = $val['use_start_date'];
					$user_bonus_list[$key]['end_date']                 = $val['use_end_date'];
					$user_bonus_list[$key]['formatted_start_date']     = RC_Time::local_date(ecjia::config('date_format'), $val['use_start_date']);
					$user_bonus_list[$key]['formatted_end_date']       = RC_Time::local_date(ecjia::config('date_format'), $val['use_end_date']);
					$user_bonus_list[$key]['seller_id']                = $val['store_id'];
					$user_bonus_list[$key]['seller_name']              = $val['merchants_name'];
				}
				$bonus_list = array_merge($user_bonus_list);
			}
			// 能使用红包
			$allow_use_bonus = 1;
		} else {
			$allow_use_bonus = 0;
		}
		$out['allow_use_bonus']		= $allow_use_bonus;//是否使用红包
		$out['bonus']				= !empty($bonus_list) ? $bonus_list : array();//红包
		$out['allow_can_invoice']	= ecjia::config('can_invoice');//能否开发票
		/* 如果能开发票，取得发票内容列表 */
		if ((ecjia_config::has('can_invoice') && ecjia::config('can_invoice') == '1') && ecjia_config::has('invoice_content') && $flow_type != \Ecjia\App\Cart\Enums\CartEnum::CART_EXCHANGE_GOODS)
		{
			$inv_content_list = explode("\n", str_replace("\r", '', ecjia::config('invoice_content')));
			
			$inv_type_list = array();
			$invoice_type  = ecjia::config('invoice_type');
			$invoice_type = unserialize($invoice_type);
			foreach ($invoice_type['type'] as $key => $type) {
				if (!empty($type)) {
					$inv_type_list[$type] = array(
						'label'      => $type . ' [' . floatval($invoice_type['rate'][$key]) . '%]',
						'label_type' => $type,
						'rate'       => floatval($invoice_type['rate'][$key])
					);
				}
			}
		}
		$out['inv_content_list']	= empty($inv_content_list) ? null : $inv_content_list;//发票内容项
		$out['inv_type_list']		= $inv_type_list;//发票类型及税率
		$out['your_integral']		= $user_info['pay_points'] > 0 ? $user_info['pay_points'] : 0;//用户可用积分
		$out['discount']			= number_format($total['discount'], 2, '.', '');//用户享受折扣数
		$out['discount_formated']	= $total['discount_formated'];

		if (!empty($out['consignee'])) {
			$out['consignee']['id'] = $out['consignee']['address_id'];
			unset($out['consignee']['address_id']);
			unset($out['consignee']['user_id']);
			unset($out['consignee']['address_id']);
			$ids = array($out['consignee']['province'], $out['consignee']['city'], $out['consignee']['district'], $out['consignee']['street']);
			$ids = array_filter($ids);
			
			$data = array();
			if (!empty($ids)) {
				$data = ecjia_region::getRegions($ids);
			}
			
			$a_out = array();
			if (!empty($data)) {
				foreach ($data as $key => $val) {
					$a_out[$val['region_id']] = $val['region_name'];
				}
			}
			$country = ecjia_region::getCountryName($out['consignee']['country']);
			
			$out['consignee']['country_name']	= $country;
			$out['consignee']['province_name']	= isset($a_out[$out['consignee']['province']]) 	? $a_out[$out['consignee']['province']] : '';
			$out['consignee']['city_name']		= isset($a_out[$out['consignee']['city']]) 		? $a_out[$out['consignee']['city']] 	: '';
			$out['consignee']['district_name']	= isset($a_out[$out['consignee']['district']]) 	? $a_out[$out['consignee']['district']] : '';
			$out['consignee']['street_name']	= isset($a_out[$out['consignee']['street']]) 	? $a_out[$out['consignee']['street']] : '';
		}
		if (!empty($out['inv_content_list'])) {
			$temp = array();
			foreach ($out['inv_content_list'] as $key => $value) {
				$temp[] = array('id'=>$key, 'value'=>$value);
			}
			$out['inv_content_list'] = $temp;
		}
		if (!empty($out['inv_type_list'])) {
			$temp = array();
			$i = 1;
			foreach ($out['inv_type_list'] as $key => $value) {
				$temp[] = array(
					'id'	       => $i,
					'value'	       => $value['label'],
					'label_value'  => $value['label_type'],
					'rate'	       => $value['rate']);
				$i++;
			}
			$out['inv_type_list'] = $temp;
		}

		/*商家运费模板关联的配送方式只有一个，且此配送方式为上门取货时，返回值结构处理同门店提货接口storepickup/flow/checkOrder一样*/
		if ($out['checkorder_mode'] == 'storepickup') {
			$out_new = array();
			$out_new['user_info'] 		= array();
			$out_new['goods_list']  	= array();
			$out_new['store_info']  	= array();
			$out_new['bonus']			= array();
			$out_new['checkorder_mode']	= 'storepickup';
			if (!empty($user_info)) {
				$out_new['user_info'] = array(
						'user_id'	=> intval($user_info['user_id']),
						'user_name'	=> empty($user_info['user_name']) ? '' : $user_info['user_name'],
						'mobile'	=> empty($user_info['mobile_phone']) ? '' : $user_info['mobile_phone'],
						'integral'	=> $user_info['pay_points'] > 0 ? intval($user_info['pay_points']) : 0,
				);
			}
			
			if (!empty($out['goods_list'])) {
				foreach ($out['goods_list'] as $row) {
					$out_new['goods_list'][] = array(
							'store_id' 				=> $row['seller_id'],
							'store_name'			=> $row['seller_name'],
							'rec_id'				=> $row['rec_id'],
							'goods_id'				=> $row['goods_id'],
							'goods_name'			=> $row['goods_name'],
							'goods_sn'				=> $row['goods_sn'],
							'goods_number'			=> $row['goods_number'],
							'market_price'			=> $row['market_price'],
							'goods_price'			=> $row['goods_price'],
							'goods_attr'			=> $row['goods_attr'],
							'is_real'				=> $row['is_real'],
							'subtotal'				=> $row['subtotal'],
							'goods_attr_id'			=> $row['goods_attr_id'],
							'attr'					=> $row['attr'],
							'is_real'				=> $row['is_real'],
							'formated_market_price'	=> $row['formated_market_price'],
							'formated_goods_price'	=> $row['formated_goods_price'],
							'formated_subtotal'		=> price_format($row['subtotal'], false),
							'img'					=> $row['img'],
					);
				}
			}
			
			/*店铺信息*/
			$shop_kf_mobile = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'shop_kf_mobile')->value('value');
			$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->select(RC_DB::raw('merchants_name, province, city, district, street, address, longitude, latitude'))->first();
			$store_address = ecjia_region::getRegionName($store_info['province']).ecjia_region::getRegionName($store_info['city']).ecjia_region::getRegionName($store_info['district']).ecjia_region::getRegionName($store_info['street']).$store_info['address'];
			$out_new['store_info'] = array('store_name' => $store_info['merchants_name'], 'store_address' => $store_address, 'shop_kf_mobile' => $shop_kf_mobile, 'location' => array('longitude' => $store_info['longitude'], 'latitude' => $store_info['latitude']));
			
			$out_new['payment_list']		= $out['payment_list'];//支付信息
			$out_new['allow_use_integral'] 	= $out['allow_use_integral'];//积分 是否使用积分
			$out_new['order_max_integral'] 	= $out['order_max_integral'];//订单最大可使用积分
			$out_new['allow_use_bonus']		= $out['allow_use_bonus'];//是否使用红包
			
			if (!empty($out['bonus'])) {
				foreach ($out['bonus'] as $res ) {
					$out_new['bonus'][] = array(
							'bonus_id' 					=> $res['bonus_id'],
							'bonus_name' 				=> $res['bonus_name'],
							'bonus_amount' 				=> $res['bonus_amount'],
							'formatted_bonus_amount' 	=> $res['formatted_bonus_amount'],
							'start_date' 				=> $res['start_date'],
							'end_date' 					=> $res['end_date'],
							'formatted_start_date' 		=> $res['formatted_start_date'],
							'formatted_end_date' 		=> $res['formatted_end_date'],
							'request_amount' 			=> $res['request_amount'],
							'formatted_request_amount' 	=> $res['formatted_request_amount'],
							'label_min_amount' 			=> sprintf(__('满%s可使用', 'cart'), $res['request_amount']),
					);
				}
			}
			
			$out_new['allow_can_invoice']	= ecjia::config('can_invoice');//能否开发票
			$out_new['inv_content_list']	= empty($out['inv_content_list']) ? array() : $out['inv_content_list'];//发票内容项
			$out_new['inv_type_list']		= empty($out['inv_type_list']) 	  ? array() : $out['inv_type_list'];
			$out_new['your_integral']		= $out['your_integral'];
			$out_new['discount']			= $out['discount'];
			$out_new['discount_formated']	= $out['discount_formated'];
			
			$expect_pickup_date = array();
			$expect_pickup_date = cart::get_ship_cac_date_by_store($store_id, $ship_id);
			$out_new['expect_pickup_date'] = $expect_pickup_date;
			
			return $out_new;
		} 
		
		//去掉系统使用的字段
		if (!empty($out['shipping_list'])) {
			foreach ($out['shipping_list'] as $key => $value) {
				unset($out['shipping_list'][$key]['configure']);
				unset($out['shipping_list'][$key]['shipping_desc']);
			}
		}
		
		return $out;
	}
}

// end
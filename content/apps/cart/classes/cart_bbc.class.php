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
 * 到家商城购物车类
 * @author 
 */
class cart_bbc {
    
	/**
	 * 到家商城购物车列表格式化处理
	 * @param array $cart_result
	 */
    public static function formated_bbc_cart_list($cart_result = array(), $user_rank = 0, $user_id = 0) 
    {
    	$cart_goods = array('cart_list' => array(), 'total' => $cart_result['total'], 'cart_store_ids' => array());
    	
        if (!empty($cart_result['goods_list'])) {
	       	 foreach ($cart_result['goods_list'] as $row) {
	            if (!isset($cart_goods['cart_list'][$row['store_id']])) {
	                $cart_goods['cart_list'][$row['store_id']] = array(
	                    'store_id'		=> intval($row['store_id']),
	                    'store_name'	=> $row['store_name'],
	                    'manage_mode'   => $row['manage_mode'],
	                    'is_disabled'   => 0,
	                    'disabled_label'=> "",
	                	'store_checked_rec_id' => array()
	                );
	            }
	            $goods_attrs = [];
	            /* 查询规格 */
	            if (trim($row['goods_attr']) != '') {
	                $goods_attr = explode("\n", $row['goods_attr']);
	                $goods_attr = array_filter($goods_attr);
	                foreach ($goods_attr as $v) {
	                    $a = explode(':', $v);
	                    if (!empty($a[0]) && !empty($a[1])) {
	                        $goods_attrs[] = array('name' => $a[0], 'value' => $a[1]);
	                    }
	                }
	            }
	    
	            //goods_list
	            $cart_goods['cart_list'][$row['store_id']]['goods_list'][] = array(
	                'rec_id'	            => intval($row['rec_id']),
	                'goods_id'	            => intval($row['goods_id']),
	                'goods_sn'	            => $row['goods_sn'],
	                'goods_name'	        => rc_stripslashes($row['goods_name']),
	                'goods_price'	        => $row['goods_price'],
	                'market_price'	        => $row['market_price'],
	                'formated_goods_price'	=> $row['formatted_goods_price'],
	                'formated_market_price' => $row['formatted_market_price'],
	                'goods_number'	        => intval($row['goods_number']),
	                'subtotal'		        => $row['subtotal'],
	                'attr'			        => $row['goods_attr'],
	                'goods_attr_id'         => $row['goods_attr_id'],
	            	'extension_code'		=> $row['extension_code'],
	            	'is_real'				=> $row['is_real'],
	            	'product_id'			=> $row['product_id'],
	                'goods_attr'	        => $goods_attrs,
	                'is_checked'	        => $row['is_checked'],
	                'is_disabled'           => $row['is_disabled'],
	                'disabled_label'        => $row['disabled_label'],
	                'is_shipping'			=> $row['is_shipping'],
					'img' 					=> array(
													'thumb'	=> empty($row['goods_img']) ? '' : RC_Upload::upload_url($row['goods_img']),
								                    'url'	=> empty($row['original_img']) ? '' : RC_Upload::upload_url($row['original_img']),
								                    'small'	=> empty($row['goods_thumb']) ? '' : RC_Upload::upload_url($row['goods_thumb']),
								                )
	            );
	            //选中的某一店铺购物车id
	            if ($row['is_checked'] == 1) {
	            	$cart_goods['cart_list'][$row['store_id']]['store_checked_rec_id'][] = $row['rec_id'];
	            }
	        }
    	}
    	
    	$cart_goods['cart_list'] = array_merge($cart_goods['cart_list']);
    	
    	//店铺优惠活动
    	$total_discount = 0;
    	foreach ($cart_goods['cart_list'] as &$seller) {
    		/*获取店铺选中购物车所满足的优惠活动*/
    		$store_discount_result = [];
    		if ($seller['store_checked_rec_id']) {
    			$store_discount_result = self::bbc_cart_store_discount(array('store_id' => $seller['store_id'], 'user_id' => $user_id,'user_rank' => $user_rank, 'rec_id' => $seller['store_checked_rec_id']));
    			/* 用于统计购物车中实体商品和虚拟商品的个数 */
    			$virtual_goods_count = 0;
    			$real_goods_count    = 0;
    			//店铺小计
    			$total = array(
    					'goods_price'  => 0, // 本店售价合计（有格式）
    					'market_price' => 0, // 市场售价合计（有格式）
    					'saving'       => 0, // 节省金额（有格式）
    					'save_rate'    => 0, // 节省百分比
    					'goods_amount' => 0, // 本店售价合计（无格式）
    					'goods_number' => 0, // 商品总件数
    					'discount'     => 0
    			);
    			foreach ($seller['goods_list'] as $goods) {
    				if ($goods['is_checked'] == 1) {
    					$total['goods_price']  += $goods['goods_price'] * $goods['goods_number'];
    					$total['market_price'] += $goods['market_price'] * $goods['goods_number'];
    				}
    				$total['goods_number'] += $goods['goods_number'];
    			}
    			//判断优惠超过商品总价时
    			if ($store_discount_result['store_cart_discount'] > $total['goods_price']) {
    				$store_discount_result['store_cart_discount'] = $total['goods_price'];
    			}
    			
    			$total['goods_amount'] = $total['goods_price']; //此处商品金额小计为已减去优惠金额的
    			$total['saving']       = price_format($total['market_price'] - $total['goods_price'], false);
    			if ($total['market_price'] > 0) {
    				$total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) *
    						100 / $total['market_price']).'%' : 0;
    			}
    			
    			$total['unformatted_goods_price']     = sprintf("%.2f", $total['goods_price']);
    			$total['goods_price']  			      = price_format($total['goods_price'], false);
    			$total['unformatted_market_price']    = sprintf("%.2f", $total['market_price']);
    			$total['market_price'] 				  = price_format($total['market_price'], false);
    			$total['real_goods_count']    		  = $real_goods_count;
    			$total['virtual_goods_count'] 		  = $virtual_goods_count;
    			
    			$total['discount']			= $store_discount_result['store_cart_discount'];//用户享受折扣数
    			$total['discount_formated']	= ecjia_price_format($total['discount'], false);
    			
    			$seller['total'] = $total;
    			
    			if (!empty($store_discount_result['store_cart_discount'])) {
    				$total_discount += $store_discount_result['store_cart_discount'];
    			}
    			$seller['favourable_activity'] = $store_discount_result['store_fav_activity'];
    			unset($seller['store_checked_rec_id']);
    			$cart_store_ids[] = $seller['store_id'];
    		}
    	}
    	$cart_goods['total']['discount'] = sprintf("%.2f", $total_discount);
    	$cart_goods['total']['formated_discount'] = ecjia_price_format($total_discount, false);
    	$cart_goods['cart_store_ids'] = $cart_store_ids;
    	
    	return $cart_goods;
    }
    
    
    /**
     * 选中的店铺购物车id满足的优惠活动，返回最优活动
     */
    public static function bbc_cart_store_discount($options)
    {
    	//店铺优惠活动
    	$now = RC_Time::gmtime();
    	$user_rank = ',' . $options['user_rank'] . ',';
    	$db	  = RC_DB::table('favourable_activity');
    	$favourable_list = $db->where('store_id', $options['store_id'])
    						  ->where('start_time', '<=', $now)
    						  ->where('end_time', '>=', $now)
    						  ->whereRaw('CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%"')
    						  ->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))
    						  ->get();
    	
    	if (empty($favourable_list)) {
    		return array();
    	}
    	/* 查询购物车商品 */
    	$field = "c.rec_id, c.goods_id, c.goods_price * c.goods_number AS subtotal, g.store_id";
    	$dbview = RC_DB::table('cart as c')->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'));
    	
    	$dbview->where(RC_DB::raw('c.parent_id'), 0)->where(RC_DB::raw('c.is_gift'), 0)->where(RC_DB::raw('c.rec_type'), CART_GENERAL_GOODS)->where(RC_DB::raw('g.is_on_sale'),1)->where(RC_DB::raw('g.is_delete'), 0);
    	
    	$goods_list = $dbview->where('user_id', $options['user_id'])
    					->whereIn('rec_id', $options['rec_id'])
    					->select(RC_DB::raw($field))
    					->get();
    	
    	if (empty($goods_list)) {
    		return array();
    	}
    	
    	/* 店铺购物车选中的rec_id*/
    	$rec_id = $options['rec_id'];
    	
    	$favourable_group = array();
    	
    	if (!empty($favourable_list)) {
    		foreach ($favourable_list as $key => $favourable) {
    			/* 初始化折扣 */
    			$cart_discount = 0;  /* 店铺购物车选中优惠折扣信息,最优惠的*/
    			$total_amount = 0;
    			
    			$is_favourable	= false;
    			$favourable_group[$key] = array(
    					'activity_id'	=> $favourable['act_id'],
    					'activity_name'	=> $favourable['act_name'],
    					'min_amount'	=> $favourable['min_amount'],
    					'max_amount'	=> $favourable['max_amount'],
    					'fav_discount'	=> $favourable['act_type_ext'],
    					'act_type'		=> $favourable['act_type'],
    					'type'			=> $favourable['act_type'] == '1' ? 'price_reduction' : 'price_discount',
    					'type_label'	=> $favourable['act_type'] == '1' ? __('满减', 'cart') : __('满折', 'cart'),
    					'can_discount'	=> 0,
    			);
    			if ($favourable['act_range'] == FAR_ALL) {
    				foreach ($goods_list as $goods) {
    					//判断店铺和平台活动
    					if($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0){
    						$favourable_group[$key]['rec_id'][] = $goods['rec_id'];
    						$amount_sort[$key] = $favourable['min_amount'];
    						/* 计算费用 */
    						$total_amount += $goods['subtotal'];
    					}
    				}
    				if (!isset($favourable_group[$key]['rec_id'])) {
    					unset($favourable_group[$key]);
    				}
    				/* 判断活动，及金额满足条件（超过最大值剔除）*/
    				if (!empty($favourable_group[$key]) && ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0)) {
    					/* 如果未选择商品*/
    					if ($total_amount == 0) {
    						if ($favourable['act_type'] == '1') {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可减'.$favourable['act_type_ext'];
    						} else {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可打'. $favourable['act_type_ext']/10 .'折';
    						}
    					} elseif ($total_amount < $favourable['min_amount']) {
    						if ($favourable['act_type'] == '1') {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].'可减'.$favourable['act_type_ext'].'，还差'.($favourable['min_amount']-$total_amount);
    						} else {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可打'. $favourable['act_type_ext']/10 .'折';
    						}
    					} else {
    						if ($favourable['act_type'] == '1') {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可减'.$favourable['act_type_ext'];
    							$cart_discount += $favourable['act_type_ext'];
    							$cart_discount_temp[$key] = $favourable['act_type_ext'];
    							$favourable_group[$key]['can_discount'] = sprintf("%.2f", $cart_discount);
    						} else {
    							$discount = $total_amount - ($total_amount*$favourable['act_type_ext']/100);
    							$favourable_group[$key]['label_discount'] = '已购满'.$total_amount.',已减'. $discount;
    							$cart_discount += $total_amount - ($total_amount*$favourable['act_type_ext']/100);
    							$favourable_group[$key]['can_discount'] = sprintf("%.2f", $cart_discount);
    							$cart_discount_temp[$key] = $cart_discount;
    						}
    					}
    				} else {
    					unset($favourable_group[$key]);
    				}
    			} elseif ($favourable['act_range'] == FAR_GOODS) {
    				foreach ($goods_list as $goods) {
    					if ($favourable['store_id'] == $goods['store_id'] || $favourable['store_id'] == 0) {
    						if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
    							$favourable_group[$key]['rec_id'][] = $goods['rec_id'];
    							$amount_sort[$key] = $favourable['min_amount'];
    							$total_amount += $goods['subtotal'];
    						}
    					}
    				}
    				if (!isset($favourable_group[$key]['rec_id'])) {
    					unset($favourable_group[$key]);
    				}
    				/* 判断活动，及金额满足条件（超过最大值剔除）*/
    				if (!empty($favourable_group[$key]) && ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0)) {
    					/* 如果未选择商品*/
    					if ($total_amount == 0) {
    						if ($favourable['act_type'] == '1') {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可减'.$favourable['act_type_ext'];
    						} else {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可打'. $favourable['act_type_ext']/10 .'折';
    						}
    					} elseif ($total_amount < $favourable['min_amount']) {
    						if ($favourable['act_type'] == '1') {
    							$favourable_group[$key]['label_discount'] = '已购满'.$favourable['min_amount'].'可减'.$favourable['act_type_ext'].'，还差'.($favourable['min_amount']-$total_amount);
    						} else {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可打'. $favourable['act_type_ext']/10 .'折';
    						}
    					} else {
    						if ($favourable['act_type'] == '1') {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可减'.$favourable['act_type_ext'];
    							$cart_discount += $favourable['act_type_ext'];
    							$favourable_group[$key]['can_discount'] = sprintf("%.2f", $cart_discount);
    							$cart_discount_temp[$key] = $favourable['act_type_ext'];
    						} else {
    							$discount = $total_amount - ($total_amount*$favourable['act_type_ext']/100);
    							$favourable_group[$key]['label_discount'] = '已购满'.$total_amount.',已减'. $discount;
    							$cart_discount += $total_amount - ($total_amount*$favourable['act_type_ext']/100);
    							$favourable_group[$key]['can_discount'] = sprintf("%.2f", $cart_discount);
    							$cart_discount_temp[$key] = $cart_discount;
    						}
    					}
    				} else {
    					unset($favourable_group[$key]);
    				}
    			} else {
    				continue;
    			}
    		}
    		$cart_discount = max($cart_discount_temp);
    		//优惠金额不能超过订单本身
    		if ($total_amount && $discount > $total_amount) {
    			$cart_discount = $total_amount;
    		}
    		 
    		//获取最优惠的活动信息
    		$best_fav = self::get_best_fav($favourable_group);
    		
    		return array('store_fav_activity' => $best_fav, 'store_cart_discount' => $cart_discount);
    	}
    }
    
    /**
     * 获取最优活动
     * @param array $favourable_group
     */
    public static function get_best_fav($favourable_group = array())
    {
    	$best_fav = [];
    	
    	if ($favourable_group) {
    		$favourable_group_new = [];
    		foreach ($favourable_group as $key => $val) {
    			$favourable_group_new[$val['activity_id']] =  $val['can_discount'];
    		}
    		$max_activity_id = array_search(max($favourable_group_new),$favourable_group_new);
    		foreach ($favourable_group as $k => $v) {
    			if ($max_activity_id == $v['activity_id']) {
    				$best_fav = $v;
    			}
    		}
    	}
    	return $best_fav;
    }
    
    /**
     * 商家购物车划分，含配送方式
     */
    public static function store_cart_goods($cart_goods = array(), $consignee = array())
    {
    	if (!empty($cart_goods['cart_list'])) {
    		foreach ($cart_goods['cart_list'] as $key => $val) {
    			$store_shipping_list = self::store_shipping_list($val['goods_list'], $consignee, $val['store_id']);
    			$val['shipping'] = $store_shipping_list;
    			$val['goods_amount'] = sprintf("%.2f", $val['total']['goods_amount']);
    			unset($val['total']);
    			unset($val['favourable_activity']);
    			$store_cart_goods [] = $val;
    		}
    	}
    	return $store_cart_goods;
    }
    
    /**
     * 商家购物车划分，含配送方式，优惠活动
     */
    public static function store_cart_goods_discount($cart_goods = array(), $consignee = array())
    {
    	if (!empty($cart_goods['cart_list'])) {
    		foreach ($cart_goods['cart_list'] as $key => $val) {
    			$store_shipping_list = self::store_shipping_list($val['goods_list'], $consignee, $val['store_id']);
    			$val['shipping'] = $store_shipping_list;
    			$val['goods_amount'] = sprintf("%.2f", $val['total']['goods_amount']);
    			$store_cart_goods [] = $val;
    		}
    	}
    	return $store_cart_goods;
    }
    
    /**
     * 商家配送方式列表
     */
    public static function store_shipping_list($store_goods_list, $consignee, $store_id)
    {	
    	$region = array($consignee['country'], $consignee['province'], $consignee['city'], $consignee['district'], $consignee['street']);
    	if (empty($store_goods_list)) {
    		return [];
    	}
    	$is_free_ship = 0;
    	$shipping_count = 0;
    	$cart_weight_price['weight'] 		= 0;
    	$cart_weight_price['amount'] 		= 0;
    	$cart_weight_price['number'] 		= 0;
    	
    	foreach ($store_goods_list as $key => $goods) {
    		if($goods['is_shipping'] == 1) {
    			$shipping_count ++;
    		}
    	
    		$cart_weight_price['weight'] += floatval($goods['goodsWeight']) * $goods['goods_number'];
    		$cart_weight_price['amount'] += floatval($goods['goods_price']) * $goods['goods_number'];
    		$cart_weight_price['number'] += $goods['goods_number'];
    	}
    	if($shipping_count == count($store_goods_list)) {
    		//全部包邮
    		$is_free_ship = 1;
    	}
    	
    	$shipping_list = ecjia_shipping::availableUserShippings($region, $store_id);
    	$shipping_list_new = [];
    	
    	if($shipping_list) {
    		RC_Loader::load_app_class('cart', 'cart', false);
    		foreach ($shipping_list as $key => $row) {
    			// O2O的配送费用计算传参调整 参考flow/checkOrder
    			if (in_array($row['shipping_code'], ['ship_o2o_express','ship_ecjia_express'])) {
    				//配送费
    				$shipping_fee = self::o2o_shipping_fee($cart_weight_price, $is_free_ship, $store_id, $consignee, $row);
    				//配送时间
    				$shipping_cfg = ecjia_shipping::unserializeConfig($row['configure']);
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
    				
    			} else {
    				$shipping_fee = $is_free_ship ? 0 : ecjia_shipping::fee($row['shipping_area_id'], $cart_weight_price['weight'], $cart_weight_price['amount'], $cart_weight_price['number']);
    			}
    			//上门取货 自提插件 获得提货时间
    			if($row['shipping_code'] == 'ship_cac') {
    				$shipping_list[$key]['expect_pickup_date'] = cart::get_ship_cac_date_by_store($store_id, $row['shipping_id']);
    				$shipping_list[$key]['expect_pickup_date_default'] = $shipping_list[$key]['expect_pickup_date'][0]['date'] . ' ' . $shipping_list[$key]['expect_pickup_date'][0]['time'][0]['start_time'] . '-' . $shipping_list[$key]['expect_pickup_date'][0]['time'][0]['end_time'];
    			}
    	
    			$shipping_list[$key]['shipping_fee']        = $shipping_fee;
    			$shipping_list[$key]['format_shipping_fee'] = ecjia_price_format($shipping_fee, false);
    			unset($shipping_list[$key]['shipping_desc']);
    			unset($shipping_list[$key]['configure']);
    		}
    	}
    	$shipping_list = array_values($shipping_list);
    	return $shipping_list;
    }
    
    /**
     * 商家配送及或众包配送费获取
     */
    public static function o2o_shipping_fee($cart_weight_price, $is_free_ship, $store_id, $consignee, $shipping_val)
    {
    	$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->where('shop_close', '0')->first();
    	$from = ['latitude' => $store_info['latitude'], 'longitude' => $store_info['longitude']];
    	$to = ['latitude' => $consignee['location']['latitude'], 'longitude' => $consignee['location']['longitude']];
    	$distance = Ecjia\App\User\Location::getDistance($from, $to);
    	$shipping_fee = $is_free_ship ? 0 : ecjia_shipping::fee($shipping_val['shipping_area_id'], $distance, $cart_weight_price['amount'], $cart_weight_price['number']);
    	 return $shipping_fee;
    }
    
    
    /**
     * 获得多店费用信息
     *
     * @access  public
     * @param   array   $order
     * @param   array   $goods
     * @param   array   $consignee
     * @return  array
     */
    public static function order_fee_multiple_store($order, $cart_goods, $consignee, $cart_id = array(), $cart_goods_list = [], $store_ids = [], $cart_goods_format) {
    	RC_Loader::load_app_func('global', 'goods');
    	RC_Loader::load_app_func('cart', 'cart');
    	RC_Loader::load_app_class('cart', 'cart', false);
    	/* 初始化订单的扩展code */
    	if (!isset($order['extension_code'])) {
    		$order['extension_code'] = '';
    	}
    	$total = array('real_goods_count' => 0, 'gift_amount' => 0, 'goods_price' => 0, 'market_price' => 0, 'discount' => 0, 'pack_fee' => 0, 'card_fee' => 0, 'shipping_fee' => 0, 'shipping_insure' => 0, 'integral_money' => 0, 'bonus' => 0, 'surplus' => 0, 'cod_fee' => 0, 'pay_fee' => 0, 'tax' => 0);
    	$weight = 0;
    	/* 商品总价 */
    	foreach ($cart_goods as $key => $val) {
    		/* 统计实体商品的个数 */
    		if ($val['is_real']) {
    			$total['real_goods_count']++;
    		}
    		$total['goods_price']  += $val['goods_price'] * $val['goods_number'];
    		$total['market_price'] += $val['market_price'] * $val['goods_number'];
    	}
    	$total['saving'] 				= $total['market_price'] - $total['goods_price'];
    	$total['save_rate'] 			= $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;
    	$total['goods_price_formated'] 	= ecjia_price_format($total['goods_price'], false);
    	$total['market_price_formated'] = ecjia_price_format($total['market_price'], false);
    	$total['saving_formated'] 		= ecjia_price_format($total['saving'], false);
    	
    	/* 折扣 */
    	if ($order['extension_code'] != 'group_buy') {
    		$total['discount'] = $cart_goods_format['total']['discount'];
    		if ($total['discount'] > $total['goods_price']) {
    			$total['discount'] = $total['goods_price'];
    		}
    	}
    	$total['discount_formated'] = $cart_goods_format['total']['formated_discount'];
    	
    	/* 税额 */
    	if (!empty($order['need_inv']) && $order['inv_type'] != '') {
    		$total['tax'] = cart::get_tax_fee($order['inv_type'], $total['goods_price']);
    	}
    	$total['tax_formated'] 		= ecjia_price_format($total['tax'], false);
    	$total['card_fee_formated'] = ecjia_price_format($total['card_fee'], false);
    	
    	RC_Loader::load_app_func('admin_bonus', 'bonus');
    	/* 红包 */
    	if (!empty($order['bonus_id'])) {
    		$bonus = bonus_info($order['bonus_id']);
    		$total['bonus'] = $bonus['type_money'];
    	}
    	$total['bonus_formated'] = ecjia_price_format($total['bonus'], false);
    	/* 线下红包 */
    	if (!empty($order['bonus_kill'])) {
    		$bonus = bonus_info(0, $order['bonus_kill']);
    		$total['bonus_kill'] = $order['bonus_kill'];
    		$total['bonus_kill_formated'] = ecjia_price_format($total['bonus_kill'], false);
    	}
    	/* 配送费用 */
    	$shipping_cod_fee = NULL;
    	if ($order['shipping_id'] > 0 && $total['real_goods_count'] > 0) {
    		$region['country'] 		= $consignee['country'];
    		$region['province'] 	= $consignee['province'];
    		$region['city'] 		= $consignee['city'];
    		$region['district'] 	= $consignee['district'];
    		$region['street'] 		= $consignee['street'];
    		$total['shipping_fee'] 	= self::get_total_shipping_fee($cart_goods_list, $order['shipping_id']);
    	}
    	$total['shipping_fee_formated'] = ecjia_price_format($total['shipping_fee'], false);
    	$total['shipping_insure_formated'] = ecjia_price_format($total['shipping_insure'], false);
    	// 购物车中的商品能享受红包支付的总额
    	$bonus_amount = compute_discount_amount($cart_id);
    	// 红包和积分最多能支付的金额为商品总额
    	$max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $bonus_amount;
    	/* 计算订单总额 */
    	if ($order['extension_code'] == 'group_buy') {
    		RC_Loader::load_app_func('admin_goods', 'goods');
    		$group_buy = group_buy_info($order['extension_id']);
    	}
    	if ($order['extension_code'] == 'group_buy' && $group_buy['deposit'] > 0) {
    		$total['amount'] = $total['goods_price'];
    	} else {
    		$total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] + $total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];
    		// 减去红包金额
    		$use_bonus = min($total['bonus'], $max_amount);
    		// 实际减去的红包金额
    		if (isset($total['bonus_kill'])) {
    			$use_bonus_kill = min($total['bonus_kill'], $max_amount);
    			$total['amount'] -= $price = number_format($total['bonus_kill'], 2, '.', '');
    			// 还需要支付的订单金额
    		}
    		$total['bonus'] = $use_bonus;
    		$total['bonus_formated'] = ecjia_price_format($total['bonus'], false);
    		$total['amount'] -= $use_bonus;
    		// 还需要支付的订单金额
    		$max_amount -= $use_bonus;
    		// 积分最多还能支付的金额
    	}
    	/* 余额 */
    	$order['surplus'] = $order['surplus'] > 0 ? $order['surplus'] : 0;
    	if ($total['amount'] > 0) {
    		if (isset($order['surplus']) && $order['surplus'] > $total['amount']) {
    			$order['surplus'] = $total['amount'];
    			$total['amount'] = 0;
    		} else {
    			$total['amount'] -= floatval($order['surplus']);
    		}
    	} else {
    		$order['surplus'] = 0;
    		$total['amount'] = 0;
    	}
    	$total['surplus'] = $order['surplus'];
    	$total['surplus_formated'] = ecjia_price_format($order['surplus'], false);
    	/* 积分 */
    	$order['integral'] = $order['integral'] > 0 ? $order['integral'] : 0;
    	if ($total['amount'] > 0 && $max_amount > 0 && $order['integral'] > 0) {
    		$integral_money = cart::value_of_integral($order['integral']);
    		// 使用积分支付
    		$use_integral = min($total['amount'], $max_amount, $integral_money);
    		// 实际使用积分支付的金额
    		$total['amount'] -= $use_integral;
    		$total['integral_money'] = $use_integral;
    		$order['integral'] = cart::integral_of_value($use_integral);
    	} else {
    		$total['integral_money'] = 0;
    		$order['integral'] = 0;
    	}
    	$total['integral'] = $order['integral'];
    	$total['integral_formated'] = ecjia_price_format($total['integral_money'], false);
    	/* 保存订单信息 */
    	$_SESSION['flow_order'] = $order;
    	$se_flow_type = isset($_SESSION['flow_type']) ? $_SESSION['flow_type'] : '';
    	/* 支付费用 */
    	if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != CART_EXCHANGE_GOODS)) {
    		$total['pay_fee'] = cart::pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
    	}
    	$total['pay_fee_formated'] = ecjia_price_format($total['pay_fee'], false);
    	$total['amount'] += $total['pay_fee'];
    	// 订单总额累加上支付费用
    	$total['amount_formated'] = ecjia_price_format($total['amount'], false);
    	/* 取得可以得到的积分和红包 */
    	if ($order['extension_code'] == 'group_buy') {
    		$total['will_get_integral'] = $group_buy['gift_integral'];
    	} elseif ($order['extension_code'] == 'exchange_goods') {
    		$total['will_get_integral'] = 0;
    	} else {
    		$total['will_get_integral'] = cart::get_give_integral($cart_id);
    	}
    	$total['will_get_bonus'] 		= $order['extension_code'] == 'exchange_goods' ? 0 : ecjia_price_format(get_total_bonus(), false);
    	$total['formated_goods_price'] 	= ecjia_price_format($total['goods_price'], false);
    	$total['formated_market_price'] = ecjia_price_format($total['market_price'], false);
    	$total['formated_saving'] 		= ecjia_price_format($total['saving'], false);
    
    	return $total;
    }
    
    /**
     * 多点铺配送总费用  
     */
    public static function get_total_shipping_fee($cart_goods_list, $shipping_ids) {
    	$shipping_fee = 0;
    	if (!empty($cart_goods_list) && !empty($shipping_ids) && is_array($shipping_ids)) {
    		foreach ($cart_goods_list as $val) {
    			if ($val['shipping']) {
    				foreach ($val['shipping'] as $k => $v) {
    					foreach ($shipping_ids as $ship_val) {
    						if ($ship_val) {
    							$ship = explode('-', $ship_val);
    							if ($ship['0'] == $val['store_id'] && $ship['1'] == $v['shipping_id']) {
    								if ($v['shipping_code'] == 'ship_cac') {
    									$v['shipping_fee'] = 0;
    								}
    								$shipping_fee += $v['shipping_fee'];
    							}
    						}
    					}
    				}
    			}
    		}
    	}
    	return $shipping_fee;
    }
    
    /**
	 *单店订单生成
	 *@param array $cart_goods 单店购物车商品
	 *@param array 订单信息
     */
    public static function generate_order($cart_goods, $order) {
    	
    	$inv_tax_no 	= $order['inv_tax_no'];
    	$inv_title_type = $order['inv_title_type'];
    	$temp_amout 	= $order['temp_amout'];
    	//配送方式id处理
    	$ship_id = explode('-', $order['shipping_id']['0']);
    	$shipping_id = $ship_id['1'];
    	
    	if ($shipping_id > 0) {
    		$shipping = ecjia_shipping::pluginData(intval($shipping_id));
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
    	if(empty($order['extension_code']) && $order['shipping_id']) {
    		$shipping_info = ecjia_shipping::getPluginDataById($order['shipping_id']);
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
    
    		} catch(Exception $e) {
    			$error = $e->getMessage();
    			if($error) {
    				if(stripos($error, "1062 Duplicate entry")) {
    					$error_no = 1;
    				} else {
    					$error_no = 0;
    					return new ecjia_error('order_error', __('订单生成失败', 'cart'));
    				}
    			}
    		}
    
    	} while ($error_no == 1); //如果是订单号重复则重新提交数据
    
    	if ($new_order_id <= 0) {
    		return new ecjia_error('order_error', __('订单生成失败', 'cart'));
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
    	if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
    		$result = cart::change_order_goods_storage($new_order_id, true, SDT_PLACE);
    		if (is_ecjia_error($result)) {
    			/* 库存不足删除已生成的订单（并发处理） will.chen*/
    			RC_DB::table('order_info')->where('order_id', $new_order_id)->delete();
    			RC_DB::table('order_goods')->where('order_id', $new_order_id)->delete();
    			return $result;
    		}
    	}
    
    	/* 处理余额、积分、红包 */
    	if ($order['user_id'] > 0 && $order['integral'] > 0) {
    		$integral_name = ecjia::config('integral_name');
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
			$result = RC_Api::api('user', 'account_change_log', $params);
			if (is_ecjia_error($result)) {
				
			}
    	}
    	//$temp_amout
    	if ($order['bonus_id'] > 0 && $temp_amout > 0) {
    		RC_Api::api('bonus', 'use_bonus', array('bonus_id' => $order['bonus_id'], 'order_id' => $new_order_id));
    	}
    
    	//其他
    	$order['goods_list'] = $cart_goods;
    	$order['inv_tax_no'] 		= $inv_tax_no;
    	$order['inv_title_type'] 	= $inv_title_type;
    	RC_Api::api('cart', 'flow_done_do_something', $order);
    
    	return $order;
    }
    
    /**
	 *多店订单生成及分单
	 *@param array $cart_goods_list 多店购物车商品
	 *@param array $order 订单信息
	 *param array $max_integral 订单最多可使用的积分
     */
    public static function generate_separate_order($cart_goods_list, $order, $max_integral = 0) {
    	RC_Loader::load_app_class('cart', 'cart', false);
    	RC_Loader::load_app_class('bonus', 'bonus', false);
    	
    	$expect_shipping_time = $order['expect_shipping_time'];
    	$separate_order_goods = [];
    	$shippings = [];
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
    	$bonus = bonus::bonus_info($order['bonus_id']);
    
    	//积分
    	$integral_stores = [];
    	if($order['integral']) {
    		//积分优先满足第一店铺使用
    	}
    
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
    		} catch(Exception $e) {
    			$error = $e->getMessage();
    			if($error) {
    				if(stripos($error, "1062 Duplicate entry")) {
    					$error_no = 1;
    				} else {
    					$error_no = 0;
    					return new ecjia_error('order_error', __('订单生成失败', 'cart'));
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
    				$row['tax'] = cart::get_tax_fee($order['inv_type'], $row['goods_amount']);
    				$tax -= $row['tax'];
    			} else {
    				$row['tax'] = $tax;
    			}
    			$row['order_amount'] += $row['tax'];//重新计算总价
    		}
    		//发票税费 end
    
    		//配送方式ids
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
    				$integral_rate = self::get_integral_store($separate_order_goods[$key]) / $max_integral;
    				if($integral_rate) {
    					$row['integral'] = round($integral * $integral_rate);
    					$row['integral_money'] = cart::value_of_integral($row['integral']);
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
    				$row['pay_fee'] = cart::pay_fee($order['pay_id'], $row['order_amount']);
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
    
    		/* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
    		if ($row['order_amount'] <= 0) {
    			$row['order_amount'] = 0;
    			$row['order_status'] = OS_CONFIRMED;
    			$row['confirm_time'] = RC_Time::gmtime();
    			$row['pay_status'] = PS_PAYED;
    			$row['pay_time'] = RC_Time::gmtime();
    		} else {
    			$row['order_status'] = OS_UNCONFIRMED;
    			$row['confirm_time'] = 0;
    			$row['pay_status'] = PS_UNPAYED;
    			$row['pay_time'] = 0;
    		}
    
    		//判断订单类型
    		if(empty($row['extension_code']) && $row['shipping_id']) {
    			$shipping_info = ecjia_shipping::getPluginDataById(intval($row['shipping_id']));
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
    			} catch(Exception $e) {
    				$error = $e->getMessage();
    				if($error) {
    					if(stripos($error, "1062 Duplicate entry")) {
    						$error_no = 1;
    					} else {
    						$error_no = 0;
    						return new ecjia_error('child_order_error', __('子订单生成失败', 'cart'));
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
    			if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
    				$result = cart::change_order_goods_storage($new_order_id, true, SDT_PLACE);
    				if (is_ecjia_error($result)) {
    					/* 库存不足删除已生成的订单（并发处理） will.chen*/
    					RC_DB::table('order_info')->where('order_id', $new_order_id)->delete();
    					RC_DB::table('order_goods')->where('order_id', $new_order_id)->delete();
    					return $result;
    				}
    			}
    
    			/* 处理积分、红包 */
    			if ($row['user_id'] > 0 && $row['integral'] > 0) {
    				$integral_name = ecjia::config('integral_name');
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
    				$result = RC_Api::api('user', 'account_change_log', $params);
    				if (is_ecjia_error($result)) {
    				
    				}
    			}
    			
    			//$temp_amout TODO
    			$temp_amout = $row['goods_amount'] - $row['discount'];
    			if ($row['bonus_id'] > 0 && $temp_amout > 0 ) {
    				RC_Api::api('bonus', 'use_bonus', array('bonus_id' => $row['bonus_id'], 'order_id' => $new_order_id_child));
    			}
    
    			//其他
    			$row['goods_list'] = $separate_order_goods[$key];
    			RC_Api::api('cart', 'flow_done_do_something', $row);
    		} else {
    			return new ecjia_error('create_order_error', __('生成订单失败', 'cart'));
    		}
    	}
    	RC_DB::table('separate_order_info')->where('order_sn', $order['order_sn'])->update(['is_separate' => 1]);
    
    	return $order;
    }
    
    /**
     * 获取结算时店铺商品可用积分
     * @param array $cart_goods_store
     * @return number
     */
    public static function get_integral_store($cart_goods_store) {
    	//单店可用积分
    	$store_integral = 0;
    
    	foreach ($cart_goods_store as $row) {
    		$integral = 0;
    		$goods = RC_DB::table('goods')->where('goods_id', $row['goods_id'])->first();
    		if(empty($goods['integral']) || empty($row['goods_price'])) {
    			continue;
    		}
    		//取价格最小值，防止积分抵扣超过商品价格(并未计算优惠) -flow_available_points()
    		$val_min = min($goods['integral'], $row['goods_price']);
    		$val_min = $val_min * $row['goods_number'];
    		if ($val_min < 1 && $val_min > 0) {
    			$val = $val_min;
    		} else {
    			$val = intval($val_min);
    		}
    		if($val <= 0) {
    			continue;
    		}
    		$integral = cart::integral_of_value($val);
    		$store_integral += $integral;
    	}
    
    	return $store_integral;
    
    }
}

// end
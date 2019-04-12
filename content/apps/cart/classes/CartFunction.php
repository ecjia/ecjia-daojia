<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-05
 * Time: 17:00
 */
namespace Ecjia\App\Cart;

use Ecjia\App\Goods\GoodsFunction;
use RC_Loader;
use RC_DB;
use cart;
use ecjia;

class CartFunction
{

    /**
     * 重新计算购物车中的商品价格：目的是当用户登录时享受会员价格，当用户退出登录时不享受会员价格
     * 如果商品有促销，价格不变
     * @access public
     * @return void
     * @update 180719 选择性更新内容
     */
    public static function recalculate_price($device = array())
    {
        $db_cart = RC_Loader::load_app_model('cart_model', 'cart');
        $dbview = RC_Loader::load_app_model('cart_good_member_viewmodel', 'cart');
        $codes = config('app-cashier::cashier_device_code');
        if (!empty($device)) {
            if (in_array($device['code'], $codes)) {
                $rec_type = CART_CASHDESK_GOODS;
            }
        } else {
            $rec_type = CART_GENERAL_GOODS;
        }

        $discount = $_SESSION['discount'];
        $user_rank = $_SESSION['user_rank'];

        $db = RC_DB::table('cart as c')
            ->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->leftJoin('member_price as mp', function($join) use ($user_rank) {
                $join->where(RC_DB::raw('mp.goods_id'), '=', RC_DB::raw('g.goods_id'))
                    ->where(RC_DB::raw('mp.user_rank'), '=', $user_rank);
            })
            ->select(RC_DB::raw("c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date, IFNULL(mp.user_price, g.shop_price * $discount) AS member_price"));

        /* 取得有可能改变价格的商品：除配件和赠品之外的商品 */
        // @update 180719 选择性更新内容mark_changed=1
        if ($_SESSION['user_id']) {
// 		$res = $dbview->join(array(
// 			'goods',
// 			'member_price'
// 		))
// 		->where('c.mark_changed =1 AND c.user_id = "' . $_SESSION['user_id'] . '" AND c.parent_id = 0 AND c.is_gift = 0 AND c.goods_id > 0 AND c.rec_type = "' . $rec_type . '" ')
// 		->select();


            $res = $db
                ->where(RC_DB::raw('c.mark_changed'), 1)
                ->where(RC_DB::raw('c.user_id'), $_SESSION['user_id'])
                ->where(RC_DB::raw('c.parent_id'), 0)
                ->where(RC_DB::raw('c.is_gift'), 0)
                ->where(RC_DB::raw('c.goods_id'), '>', 0)
                ->where(RC_DB::raw('c.rec_type'), $rec_type)
                ->get();

        } else {
// 		$res = $dbview->join(array(
// 			'goods',
// 			'member_price'
// 		))
// 		->where('c.mark_changed =1 AND c.session_id = "' . SESS_ID . '" AND c.parent_id = 0 AND c.is_gift = 0 AND c.goods_id > 0 AND c.rec_type = "' . $rec_type . '" ')
// 		->select();

            $res = $db
                ->where(RC_DB::raw('c.mark_changed'), 1)
                ->where(RC_DB::raw('c.session_id'), SESS_ID)
                ->where(RC_DB::raw('c.parent_id'), 0)
                ->where(RC_DB::raw('c.is_gift'), 0)
                ->where(RC_DB::raw('c.goods_id'), '>', 0)
                ->where(RC_DB::raw('c.rec_type'), $rec_type)
                ->get();
        }


        if (! empty($res)) {
            RC_Loader::load_app_func('global', 'goods');
            foreach ($res as $row) {
                $attr_id = empty($row['goods_attr_id']) ? array() : explode(',', $row['goods_attr_id']);
                $goods_price = GoodsFunction::get_final_price($row['goods_id'], $row['goods_number'], true, $attr_id);
                $data = array(
                    'goods_price' => $goods_price > 0 ? $goods_price : 0.00,
                    'mark_changed' => 0
                );
                if ($_SESSION['user_id']) {
                    $db_cart->where('goods_id = ' . $row['goods_id'] . ' AND user_id = "' . $_SESSION['user_id'] . '" AND rec_id = "' . $row['rec_id'] . '"')->update($data);
                } else {
                    $db_cart->where('goods_id = ' . $row['goods_id'] . ' AND session_id = "' . SESS_ID . '" AND rec_id = "' . $row['rec_id'] . '"')->update($data);
                }
            }
        }
        /* 删除赠品，重新选择 */

        if ($_SESSION['user_id']) {
            $db_cart->where('user_id = "' . $_SESSION['user_id'] . '" AND is_gift > 0')->delete();
        } else {
            $db_cart->where('session_id = "' . SESS_ID . '" AND is_gift > 0')->delete();
        }
    }
	
    /**
     * 获取购物车商品
     */
    public static function cart_list($flow_type = CART_GENERAL_GOODS,  $user_id, $cart_id = [], $store_id = [])
    {
    	$dbview_cart = RC_DB::table('cart as c')
    		->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
    		->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('c.store_id'));
    	
    	$dbview_cart->where(RC_DB::raw('c.rec_type'), '=', $flow_type);
    	$dbview_cart->where(RC_DB::raw('s.shop_close'), '=', '0');
    	
    	/* 符合店铺条件*/
    	if (!empty($store_id) && is_array($store_id)) {
    		$dbview_cart->whereIn(RC_DB::raw('c.store_id'), $store_id);
    	}
    	
    	/* 指定购物车 */
    	if (!empty($cart_id) && is_array($cart_id)) {
    		$dbview_cart->whereIn(RC_DB::raw('c.rec_id'), $cart_id);
    	}
    	
    	if ($user_id) {
    		$dbview_cart->where(RC_DB::raw('c.user_id'), $user_id);
    	}
    	
    	$data = $dbview_cart
    	->select(RC_DB::raw("c.*,IF(c.parent_id, c.parent_id, c.goods_id) AS pid, g.goods_number as g_goods_number, g.is_on_sale, g.is_delete"))
    	->orderBy('add_time', 'desc')->orderBy('rec_id', 'desc')
    	->get();
    	
    	$cart_goods_list = [];
    	
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			$row['is_disabled'] = 0;
    			$row['disabled_label'] = '';
    			//判断库存
    			if ($row['g_goods_number'] < $row['goods_number'] || $row['g_goods_number'] < 1) {
    				$row['is_disabled'] = 1;
    				$row['disabled_label'] = __('库存不足', 'cart');
    			}
    			//判断上架状态
    			if ($row['is_on_sale'] == 0 || $row['is_delete'] == '1') {
    				$row['is_disabled'] = 1;
    				$row['disabled_label'] = __('商品已下架', 'cart');
    			}
    			//不可用状态，取消选中
    			if ($row['is_disabled'] == 1) {
    				$row['is_checked'] = 0;
    				 
    				RC_Loader::load_app_class('cart', 'cart', false);
    				cart::flow_check_cart_goods(array('id' => $row['rec_id'], 'is_checked' => 0));
    			}
    			 
    			$row['subtotal']     	= $row['goods_price'] * $row['goods_number'];
    			$row['formatted_subtotal']     	= ecjia_price_format($row['goods_price'] * $row['goods_number'], false);
    			/* 返回未格式化价格*/
    			$row['goods_price']		= $row['goods_price'];
    			$row['market_price']	= $row['market_price'];
    		
    			$row['formatted_goods_price']  	= ecjia_price_format($row['goods_price'], false);
    			$row['formatted_market_price'] 	= ecjia_price_format($row['market_price'], false);
    		
    			/* 查询规格 */
    			if (trim($row['goods_attr']) != '') {
    				$row['goods_attr'] = addslashes(str_replace('\n', '', $row['goods_attr']));
    			}
    		
    			$row['attr_number'] = 1;//有货
    			if (ecjia::config('use_storage') == 1) {
    				if($row['product_id']) {
    					//product_id变动TODO
    					$product_info = RC_DB::table('products')
    					->where('goods_id', $row['goods_id'])
    					->where('product_id', $row['product_id'])
    					->first();
    					if ($product_info && $row['goods_number'] > $product_info['product_number']) {
    						$row['attr_number'] = 0;
    					}
    				} else {
    					if($row['goods_number'] > $row['g_goods_number']) {
    						$row['attr_number'] = 0;
    					}
    				}
    			}
    			
    			$row['is_checked']	= $row['is_checked'];
    			$row['goods_name']  = rc_stripslashes($row['goods_name']);
    			$cart_goods_list[] = $row;
    		}
    	}
    	return $cart_goods_list;
    }
    
    /**
     * 计算积分的价值（能抵多少钱）
     * @param   int	 $integral   积分
     * @return  float   积分价值
     */
    public static function value_of_integral($integral) {
    	$scale = floatval(ecjia::config('integral_scale'));
    	return $scale > 0 ? round($integral / 100 * $scale, 2) : 0;
    }
    
    /**
     * 计算指定的金额需要多少积分
     *
     * @access  public
     * @param   integer $value  金额
     * @return  void
     */
    public static function integral_of_value($value) {
    	$scale = floatval(ecjia::config('integral_scale'));
    	return $scale > 0 ? round($value / $scale * 100) : 0;
    }
    
    
    /**
     * 改变订单中商品库存
     * @param   int	 $order_id   订单号
     * @param   bool	$is_dec	 是否减少库存
     * @param   bool	$storage	 减库存的时机，1，下订单时；0，发货时；
     */
    public static function change_order_goods_storage($order_id, $is_dec = true, $storage = 0) {
    	$db 		= RC_DB::table('order_goods');
    	$db_package = RC_DB::table('package_goods');
    	$db_goods	= RC_DB::table('goods');
    
    	/* 查询订单商品信息  */
    	switch ($storage) {
    		case 0 :
    			$data = $db->select(RC_DB::raw('goods_id, SUM(send_number) as num, MAX(extension_code) as extension_code, product_id'))
    			->where('order_id', $order_id)->where('is_real', 1)->groupBy('goods_id')->groupBy('product_id')->get();
    			break;
    
    		case 1 :
    			$data = $db->select(RC_DB::raw('goods_id, SUM(goods_number) as num, MAX(extension_code) as extension_code, product_id'))
    			->where('order_id', $order_id)->where('is_real', 1)->groupBy('goods_id')->groupBy('product_id')->get();
    			break;
    	}
    
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			if ($row['extension_code'] != "package_buy") {
    				if ($is_dec) {
    					$result = self::change_goods_storage($row['goods_id'], $row['product_id'], - $row['num']);
    				} else {
    					$result = self::change_goods_storage($row['goods_id'], $row['product_id'], $row['num']);
    				}
    			} else {
    				$data = $db_package->select('goods_id', 'goods_number')->where('package_id', $row['goods_id'])->get();
    				if (!empty($data)) {
    					foreach ($data as $row_goods) {
    						$is_goods	= $db_goods->select('is_real')->where('goods_id', $row_goods['goods_id'])->first();
    						if ($is_dec) {
    							$result = self::change_goods_storage($row_goods['goods_id'], $row['product_id'], - ($row['num'] * $row_goods['goods_number']));
    						} elseif ($is_goods['is_real']) {
    							$result = self::change_goods_storage($row_goods['goods_id'], $row['product_id'], ($row['num'] * $row_goods['goods_number']));
    						}
    					}
    				}
    			}
    		}
    	}
    	return $result;
    }
    
    /**
     * 商品库存增与减 货品库存增与减
     *
     * @param   int	$good_id		 商品ID
     * @param   int	$product_id	  货品ID
     * @param   int	$number		  增减数量，默认0；
     *
     * @return  bool			   true，成功；false，失败；
     */
    public static function change_goods_storage($goods_id, $product_id, $number = 0) {
    	if ($number == 0) {
    		return true; // 值为0即不做、增减操作，返回true
    	}
    	if (empty($goods_id) || empty($number)) {
    		return false;
    	}
    	/* 处理货品库存 */
    	$products_query = true;
    	if (!empty($product_id)) {
    		$product_number = RC_DB::table('products')->where('goods_id', $goods_id)->where('product_id', $product_id)->pluck('product_number');
    		if ($product_number < abs($number)) {
    			return new \ecjia_error('low_stocks', __('库存不足', 'cart'));
    		}
    		$products_query = RC_DB::table('products')->where('goods_id', $goods_id)->where('product_id', $product_id)->increment('product_number', $number);
    	} else {
    		$goods_number = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_number');
    		if ($goods_number < abs($number) ) {
    			return new \ecjia_error('low_stocks', __('库存不足', 'cart'));
    		}
    		/* 处理商品库存 */
    		$query = RC_DB::table('goods')->where('goods_id',$goods_id)->increment('goods_number', $number);
    	}
    
    	if ($query || $products_query) {
    		$goods_info  = RC_DB::table('goods')->where('goods_id', $goods_id)->select('goods_name', 'goods_number', 'warn_number', 'store_id')->first();
    		$mobile      = RC_DB::table('staff_user')->where('store_id', $goods_info['store_id'])->where('parent_id', 0)->pluck('mobile');
    		$store_name  = RC_DB::table('store_franchisee')->where('store_id', $goods_info['store_id'])->pluck('merchants_name');
    			
    		//发货警告库存发送短信
    		$send_time = \RC_Cache::app_cache_get('sms_goods_stock_warning_sendtime', 'orders');
    		$now_time  = \RC_Time::gmtime();
    
    		if($now_time > $send_time + 86400) {
    			if (!empty($mobile) && $goods_info['goods_number'] <= $goods_info['warn_number']) {
    				$options = array(
    						'mobile' => $mobile,
    						'event'     => 'sms_goods_stock_warning',
    						'value'  =>array(
    								'store_name'   => $store_name,
    								'goods_name'   => $goods_info['goods_name'],
    								'goods_number' => $goods_info['goods_number']
    						),
    				);
    				$response = \RC_Api::api('sms', 'send_event_sms', $options);
    				if (!is_ecjia_error($response)) {
    					\RC_Cache::app_cache_set('sms_goods_stock_warning_sendtime', $now_time, 'orders', 10080);
    				}
    			}
    		}
    		return true;
    	} else {
    		return false;
    	}
    }
    
    

    /**
     * 获取上门自提时间
     * @param Y integer $store_id
     * @param N integer $shipping_cac_id
     */
    public static function get_ship_cac_date_by_store($store_id = 0, $shipping_cac_id = 0, $show_all_time = 0) {
    	$expect_pickup_date = [];
    	 
    	//根据店铺id，店铺有没设置运费模板，查找店铺设置的运费模板关联的快递
    	if(empty($shipping_cac_id)) {
    		$shipping_cac_id = RC_DB::table('shipping')->where('shipping_code', 'ship_cac')->pluck('shipping_id');
    	}
    	 
    	if (!empty($shipping_cac_id)) {
    		$shipping_area_list = RC_DB::table('shipping_area')->where('shipping_id', $shipping_cac_id)->where('store_id', $store_id)->groupBy('shipping_id')->get();
    		 
    		if (!empty($shipping_area_list)) {
    			$shipping_cfg = \ecjia_shipping::unserializeConfig($shipping_area_list['0']['configure']);
    			if (!empty($shipping_cfg['pickup_time'])) {
    				/* 获取最后可取货的时间（当前时间）*/
    				$time = \RC_Time::local_date('H:i', \RC_Time::gmtime());
    				if (empty($shipping_cfg['pickup_time'])) {
    					return $expect_pickup_date;
    				}
    				$pickup_date = 0;
    				/*取货日期*/
    				if (empty($shipping_cfg['pickup_days'])) {
    					$shipping_cfg['pickup_days'] = 7;
    				}
    				while ($shipping_cfg['pickup_days']) {
    					$pickup = [];
    					 
    					foreach ($shipping_cfg['pickup_time'] as $k => $v) {
    						if($show_all_time) {
    							$pickup['date'] = \RC_Time::local_date('Y-m-d', \RC_Time::local_strtotime('+'.$pickup_date.' day'));
    							$pickup['time'][] = array(
    									'start_time' 	=> $v['start'],
    									'end_time'		=> $v['end'],
    									'is_disabled'   => ($v['end'] < $time && $pickup_date == 0) ? 1 : 0,
    							);
    						} else {
    							if ($v['end'] > $time || $pickup_date > 0) {
    								$pickup['date'] = \RC_Time::local_date('Y-m-d', \RC_Time::local_strtotime('+'.$pickup_date.' day'));
    								$pickup['time'][] = array(
    										'start_time' 	=> $v['start'],
    										'end_time'		=> $v['end'],
    								);
    							}
    						}
    					}
    					if (!empty($pickup['date']) && !empty($pickup['time'])) {
    						$expect_pickup_date[] = $pickup;
    					}
    					$pickup_date ++;
    					 
    					if (count($expect_pickup_date) >= $shipping_cfg['pickup_days']) {
    						break;
    					}
    				}
    			}
    		}
    	}
    	 
    	return $expect_pickup_date;
    }
    
    
    
    
}
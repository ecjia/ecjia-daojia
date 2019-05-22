<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 19:02
 */

namespace Ecjia\App\Cart\CartFlow;


use Ecjia\App\Cart\Models\CartModel;
use Ecjia\App\User\Models\UserRankModel;
use Ecjia\App\Favourable\Models\FavourableActivityModel;
use \RC_Api;
use RC_Time;

/**
 *店铺选中的购物车满足的最优惠店铺优惠活动
 */
class CartStoreFavourable
{

    /**
     * @var CartModel
     */
    protected $model;

    public function __construct($cart_data, $store_id, $user_id)
    {
        $this->cart_data = $cart_data;
        $this->store_id  = $store_id;
        $this->user_id   = $user_id;
        
        /**
         * $this->model->goods 这是购物车商品的数据模型
         */
        
        /**
         * $this->model->store_franchisee 购物车店铺数据模型 
         */
    }
	
    /**
     * 店铺选中的购物车列表
     */
    public function storeCartData()
    {
    	$store_cart_list = [];
    	
    	$store_cart_list = $this->cart_data->map(function($item){
    		if($item['is_checked'] == 1){
				return $item;
			}
        });
    	$res = $store_cart_list->all();
    	return $res;
    }
    
    /**
     * 店铺选中的购物车满足的最优惠店铺优惠活动
     */
    public function StoreCartFavourableActivity()
    {
    	$store_favourable_list = [];
    	 //店铺选中的购物车
    	 $store_checked_cart = $this->storeCartData();
    	 //用户等级
    	 $user_rank = $this->getNowUserRank($this->user_id);
    	 //满足用户等级的所有店铺活动
    	 $favourable_list = $this->storeFavourableActivity($user_rank);
    	 
    	 if (empty($favourable_list) || empty($store_checked_cart)) {
    	 	return [];
    	 }
    	 
    	 $store_favourable_list = $this->favourableActivity($store_checked_cart, $favourable_list);
    	 return $store_favourable_list;
    }
    
    /**
     * 优惠活动数据格式处理
     */
    protected function favourableActivity($goods_list, $favourable_list)
    {
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
    					'type_label'	=> $favourable['act_type'] == '1' ? __('满减') : __('满折'),
    					'can_discount'	=> 0,
                        'rec_id'        => [],
    			);
    			if ($favourable['act_range'] == FAR_ALL) {
    				foreach ($goods_list as $goods) {
    					//判断店铺和平台活动
                        if ($goods['rec_id']) {
                            $favourable_group[$key]['rec_id'][] = $goods['rec_id'];
                        }
    					$amount_sort[$key] = $favourable['min_amount'];
    					/* 计算费用 */
    					$total_amount += $goods['subtotal'];
    				}
    				if (!isset($favourable_group[$key]['rec_id'])) {
    					unset($favourable_group[$key]);
    				}
    				/* 判断活动，及金额满足条件（超过最大值剔除）*/
    				if (!empty($favourable_group[$key]) && ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0)) {
    					/*如果未选择商品*/
    				 	if ($total_amount == 0) {
				    		if ($favourable['act_type'] == '1') { //满减活动
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
    					if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
    						if ($goods['goods_id']) {
                                $favourable_group[$key]['rec_id'][] = $goods['rec_id'];
                            }
    						$amount_sort[$key] = $favourable['min_amount'];
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
    							$favourable_group[$key]['label_discount'] = '已购满'.$favourable['min_amount'].'可减'.$favourable['act_type_ext'].'，还差'.($favourable['min_amount']-$total_amount);
    						} else {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可打'. $favourable['act_type_ext']/10 .'折';
    						}
    					} else {
    						if ($favourable['act_type'] == '1') {
    							$favourable_group[$key]['label_discount'] = '购满'.$favourable['min_amount'].',可减'.$favourable['act_type_ext'];
    							$cart_discount += $favourable['act_type_ext'];
    							$favourable_group[$key]['can_discount'] = sprintf("%.2f", $cart_discount);
    							$cart_discount_temp[] = $favourable['act_type_ext'];
    						} else {
    							$discount = $total_amount - ($total_amount*$favourable['act_type_ext']/100);
    							$favourable_group[$key]['label_discount'] = '已购满'.$total_amount.',已减'. $discount;
    							$cart_discount += $total_amount - ($total_amount*$favourable['act_type_ext']/100);
    							$favourable_group[$key]['can_discount'] = sprintf("%.2f", $cart_discount);
    							$cart_discount_temp[] = $cart_discount;
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
    		
//     		if (!empty($amount_sort) && !empty($favourable_group)) {
//     			array_multisort($amount_sort, SORT_ASC, $favourable_group);
//     		}
    		 
    		//获取最优惠的活动信息
    		//$best_fav_key = array_search(max($cart_discount_temp),$cart_discount_temp);
    		$best_fav = $this->get_best_fav($favourable_group);
    		
    		return array('store_fav_activity' => $best_fav, 'store_cart_discount' => $cart_discount);
    	}
    }
    
    /**
     * 获取最优活动
     * @param array $favourable_group
     */
    protected function get_best_fav($favourable_group = array())
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
     * 获取用户等级
     */
    protected function getNowUserRank($user_id)
    {
    	$user_info = \RC_Api::api('user', 'user_info', ['user_id' => $user_id]);
    	if (is_ecjia_error($user_info) || empty($user_info)) {
    		$user_info['user_rank'] = 0;
    	}
    	$user_rank = 0;
    	if ($user_info['user_rank'] == 0) {
    		//重新计算会员等级
    		$now_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user_id));
    	} else {
    		//用户等级更新，不用计算，直接读取
    		$now_rank = UserRankModel::where('rank_id', $user_info['user_rank'])->first();
    	}
    	$user_rank = $now_rank['rank_id'];
    	return $user_rank;
    }
    
    /**
     * 满足用户等级的店铺优惠活动
     */
    protected function storeFavourableActivity($user_rank)
    {
    	//店铺优惠活动
    	$favourable_list = [];
        $now = RC_Time::gmtime();
        $user_rank = ',' . $user_rank . ',';
        $favourable_list = FavourableActivityModel::where('store_id', $this->store_id)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->whereRaw('CONCAT(",", user_rank, ",") LIKE "%' . $user_rank . '%"')
            ->whereIn('act_type', array(FAT_DISCOUNT, FAT_PRICE))
            ->get()->toArray();
        return $favourable_list;
    }
    
    /**
     * 店铺购物车小计
     */
    public function storeCartTotalPrice()
    {
    	 
    }
    
    /**
     * 店铺配送方式列表
     */
    protected function storeShippingList()
    {
    	
    }
    
    /**
     * 商家配送或众包配送配送费
     */
    protected function o2oShippingFee()
    {
    	
    }
}
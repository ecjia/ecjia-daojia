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
/**
 *商品促销类
 */

namespace Ecjia\App\Goods\GoodsActivity;

use \Ecjia\App\Goods\Models\GoodsModel;
use \Ecjia\App\Goods\Models\GoodsActivityRecordsModel;

class GoodsPromotion
{

    protected $goods_id;

    protected $product_id;

    protected $user_id;

    protected $model;

    protected $products;


    public function __construct($goods_id, $product_id = 0, $user_id = 0)
    {
        $this->goods_id 	= $goods_id;
        $this->product_id 	= $product_id;
        $this->user_id 		= $user_id;

        $this->model = $this->getGoodsPromotionInfo();

        if (!is_null($this->model)) {
             $this->products = (new ProductPromotion($this->model, $this->product_id))->getProductPromotion();
        } else {
        	$this->products  = [];
        }
    }

    /**
     * 商品促销信息
     */
    public function getGoodsPromotionInfo()
    {
    	$time 	= \RC_Time::gmtime();
    	
        $data = GoodsModel::where('goods_id', $this->goods_id)
            ->where('promote_start_date', '<=', $time)
            ->where('promote_end_date', '>=', $time)
            ->first();
        
        return $data;
    }
    
    public function isPromote()
    {
    	if ($this->model) {
    		if (empty($this->product_id)) {
    			//商品促销
    			if ($this->model->promote_price > 0 && $this->model->is_promote == '1' && $this->model->promote_limited > 0) {
    				return true;
    			}
    		} else {
    			//货品促销
    			if ($this->products->promote_price > 0 && $this->products->is_promote == '1' && $this->products->promote_limited > 0) {
    				return true;
    			}
    		}
    	} else {
    		return false;
    	}
    }
    
    /**
     * 获取货品促销信息
     */
    public function getProductPromotion()
    {
    	$data = $this->products;
    	return $data;
    }

    /**
     * 获取促销限购用户剩余可购买次数
     * @return int
     */
    public function getLimitOverCount($goods_num)
    {
    	if ($this->model) {
    		if (empty($this->product_id)) {
    			//商品促销
    			$user_left_num = $this->goodsLimitUserLeftNum($goods_num);
    		} else {
    			//货品促销
    			$user_left_num = $this->productsLimitUserLeftNum($goods_num);
    		}
    	} else {
    		$user_left_num = -1;
    	}
    	
    	return intval($user_left_num);
    }
    
    /**
     * 购买数量大于限购可购买数量或者限购可购买数量等于0时，
     * 更新购物车商品价格；
     * 此时$promote_price按0处理
     * @param int $cart_id
     * @param int $goods_id
     * @param int $goods_num
     * @param string $is_spec_price
     * @param array $spec
     * @param int $product_id
     */
    public function updateCartGoodsPrice($cart_id, $goods_id, $goods_num = '1', $is_spec_price = false, $spec = array(), $product_id = 0)
    {
    	$discount = $_SESSION['discount'];
    	$user_rank = $_SESSION['user_rank'];
    	
    	$db_goodsview = \RC_DB::table('goods as g')
    						->leftJoin('member_price as mp', function($join) use ($user_rank) {
				                $join->on(\RC_DB::raw('mp.goods_id'), '=', \RC_DB::raw('g.goods_id'))
				                    ->where(\RC_DB::raw('mp.user_rank'), '=', $user_rank);
				            });
    	
    	$final_price	= 0; // 商品最终购买价格
    	$volume_price	= 0; // 商品优惠价格
    	$promote_price	= 0; // 商品促销价格
    	$user_price		= 0; // 商品会员价格
    	
    	// 取得商品优惠价格列表
    	$price_list = \Ecjia\App\Goods\GoodsFunction::get_volume_price_list ($goods_id, '1');
    	
    	if (! empty ( $price_list )) {
    		foreach ( $price_list as $value ) {
    			if ($goods_num >= $value ['number']) {
    				$volume_price = $value ['price'];
    			}
    		}
    	}
    	$field = "IFNULL(mp.user_price, g.shop_price * '" . $_SESSION['discount'] . "') AS shop_price";
    	// 取得商品促销价格列表
    	$goods = $db_goodsview->select(\RC_DB::raw($field))->where(\RC_DB::raw('g.goods_id'), $goods_id)->where(\RC_DB::raw('g.is_delete'), 0)->first();
    	
    	//商品会员价格
    	$user_price = $goods['shop_price'];
    	
    	//是货品情况
    	if (!empty($product_id)) {
    		$product_info = \RC_DB::table('products')->where('product_id', $product_id)->first();
    			
    		$product_shop_price = $product_info['product_shop_price'] > 0 ? $product_info['product_shop_price']*$_SESSION['discount'] : 0;
    		//货品会员价格存在替换商品会员等级价
    		$product_user_price = $product_shop_price > 0 ? $product_shop_price : $user_price;
    		$user_price = $product_user_price;
    	}
    	
    	// 比较商品的促销价格，会员价格，优惠价格
    	if (empty ( $volume_price ) && empty ( $promote_price )) {
    		// 如果优惠价格，促销价格都为空则取会员价格
    		$final_price = $user_price;
    	} elseif (! empty ( $volume_price ) && empty ( $promote_price )) {
    		// 如果优惠价格为空时不参加这个比较。
    		$final_price = min ( $volume_price, $user_price );
    	} elseif (empty ( $volume_price ) && ! empty ( $promote_price )) {
    		// 如果促销价格为空时不参加这个比较。
    		$final_price = min ( $promote_price, $user_price );
    	} elseif (! empty ( $volume_price ) && ! empty ( $promote_price )) {
    		// 取促销价格，会员价格，优惠价格最小值
    		$final_price = min ( $volume_price, $promote_price, $user_price );
    	} else {
    		$final_price = $user_price;
    	}
    	
    	// 如果需要加入规格价格
    	if ($is_spec_price) {
    		if (! empty ( $spec )) {
    			if ($product_id > 0) {
    				//货品未设置自定义价格的话，按商品价格加上属性价格;商品价格 + 属性货品价格
    				if ($product_shop_price <= 0) {
    					$spec_price = self::spec_price ( $spec );
    					$final_price += $spec_price;
    				}
    			}
    		}
    	}
    	//更新商品最终购买价格
    	\RC_DB::table('cart')->where('rec_id', $cart_id)->update(array('goods_price' => $final_price, 'goods_number' => $goods_num, 'is_promote' => 0));
    }
    
    /**
     * 更新购买记录和限购剩余总数
     * @param array $order_goods
     */
    public function updatePromotionBuyNum($order_goods)
    {
    	if ($this->model) {
    		if (empty($this->product_id)) {
    			//商品促销
    			$this->updateGoodsPromotionBuyNum($order_goods);
    		} else {
    			//货品促销
    			$this->updateProductsPromotionBuyNum($order_goods);
    		}
    	}
    }
    
    /**
     * 更新商品购买记录和限购剩余总数
     * @param array $order_goods
     */
    private function updateGoodsPromotionBuyNum($order_goods)
    {
    	//满足商品促销且促销限购剩余数量大于0
    	if ($this->model->is_promote == '1' && $this->model->promote_price > 0 && $this->model->promote_limited > 0) {
    		//用户限购数大于0且下单用户存在
    		if ($this->model->promote_user_limited > 0 && $this->user_id > 0) {
    			//更新购买记录表
    			$goodsActivityRecords = $this->goodsActivityRecordsInfo();
    			//已经购买的数量  + 现在下单订单数小于等于用户限购数时更新
    			if (($goodsActivityRecords['buy_num'] + $order_goods['goods_number']) <= $this->model->promote_user_limited) {
    				$new_num = $goodsActivityRecords['buy_num'] + $order_goods['goods_number'];
    				 
    				$data = ['buy_num' => $new_num, 'update_time' => \RC_Time::gmtime()];
    				 
    				//更新购买记录
    				GoodsActivityRecordsModel::where('activity_id', 0)
    				->where('activity_type', 'promotion')
    				->where('user_id', $this->user_id)
    				->where('goods_id', $this->goods_id)
    				->where('product_id', $this->product_id)
    				->update($data);
    				//用户购买限购数有效；未超过限购数
    				$this->model->decrement('promote_limited', $order_goods['goods_number']);
    			}
    			//用户购买限购数有效；未超过限购数
//     			if ($new_num <= $this->model->promote_user_limited) {
//     				$this->model->decrement('promote_limited', $order_goods['goods_number']);
//     			}
    		} else {
    			//更新限购总数剩余数量（用户不限购时，直接减）
    			if ($this->model->promote_limited >= $order_goods['goods_number']) {
    				$this->model->decrement('promote_limited', $order_goods['goods_number']);
    			}
    		}
    	}
    }
    
    /**
     * 更新货品促销限购数及购买记录
     * @param array $order_goods
     */
    private function updateProductsPromotionBuyNum($order_goods)
    {
    	//满足促销且促销限购剩余数量大于0
    	if ($this->products->is_promote == '1' && $this->products->promote_price > 0 && $this->products->promote_limited > 0) {
    		
    		//用户限购数大于0且下单用户存在
    		if ($this->products->promote_user_limited > 0 && $this->user_id > 0) {
    			//更新购买记录表
    			$goodsActivityRecords = $this->goodsActivityRecordsInfo();
    			
    			//已经购买的数量  + 现在下单订单数小于等于用户限购数时更新
    			if (($goodsActivityRecords['buy_num'] + $order_goods['goods_number']) <= $this->products->promote_user_limited) {
    				$new_num = $goodsActivityRecords['buy_num'] + $order_goods['goods_number'];
    				 
    				$data = ['buy_num' => $new_num, 'update_time' => \RC_Time::gmtime()];
    				//更新购买记录
    				GoodsActivityRecordsModel::where('activity_id', 0)
    				->where('activity_type', 'promotion')
    				->where('user_id', $this->user_id)
    				->where('goods_id', $this->goods_id)
    				->where('product_id', $this->product_id)
    				->update($data);
    				//用户购买限购数有效；未超过限购数
    				$this->products->decrement('promote_limited', $order_goods['goods_number']);
    			}
    			//用户购买限购数有效；未超过限购数
//     			if ($new_num <= $this->products->promote_user_limited) {
//     				$this->products->decrement('promote_limited', $order_goods['goods_number']);
//     			}
    		} else {
    			//更新限购总数剩余数量（用户不限购时，直接减）
    			if ($this->products->promote_limited >= $order_goods['goods_number']) {
    				$this->products->decrement('promote_limited', $order_goods['goods_number']);
    			}
    		}
    	}
    }
    
    /**
     * 满足促销时间段的购买信息
     * @return array
     */
    private function goodsActivityRecords()
    {
    	$starttime = $this->model->promote_start_date;
    	$endtime = $this->model->promote_end_date;
    	$time = \RC_Time::gmtime();
    	 
    	$time_limit = $endtime - $starttime;
    	 
    	if ($time_limit == $time) {
    		$time_limit = $starttime;
    	}
    	
    	$goods_activity_records = GoodsActivityRecordsModel::where('activity_id', 0)
	    	->where('activity_type', 'promotion')
	    	->where('user_id', $this->user_id)
	    	->where('goods_id', $this->goods_id)
	    	->where('product_id', $this->product_id)
	    	->where('update_time', '<=', $time)
	    	->where('add_time', '>=', $time_limit)
	    	->first();
    	
    	return $goods_activity_records;
    }
    
    /**
     * 获取商品促销用户限购剩余可购买次数（-1代表用户不限购）
     * @pra $goods_num 商品总共加入购物车数量
     * @return int
     */
    private function goodsLimitUserLeftNum($goods_num)
    {
		if($goods_num > 0) {
			//满足促销且用户限购
			if ($this->model->is_promote == '1' && $this->model->promote_price > 0 && $this->model->promote_limited > 0) {
				//用户限购数大于0
				if ($this->model->promote_user_limited > 0) {
					$goods_activity_records = $this->goodsActivityRecords();
					//找到数据，说明在有效时间内
					if (!empty($goods_activity_records)) {
						//限定时间已购买的次数
						$has_buyed_count = $goods_activity_records->buy_num;
					}
					//找不到数据，说明活动已经过有效时间，可以重置购买时间和购买次数
					else {
						$this->resetPromotionLimitOverCount();
							
						$has_buyed_count = 0;
					}
					//剩余可购买的次数
					$left_num = $this->model->promote_user_limited - $has_buyed_count;
					$left_num = max(0, $left_num);
				} else {//用户限购数等于0
					if (($this->model->promote_limited >= $goods_num || $this->model->promote_limited <= $goods_num) && $this->model->promote_user_limited == '0') {
						//限购总数大于等于或者小于购买数，用户不限购时，剩余可购买限购数等于限购总数
						$left_num = $this->model->promote_limited;
					}
				}
			} else {
				$left_num = -1; //没限制（按普通商品购买）
			}
		}
    	return $left_num;
    }
    
    /**
     * 获取货品促销用户限购剩余可购买次数（-1代表用户不限购）
     * @pra $goods_num 商品总共加入购物车数量
     * @return int
     */
    private function productsLimitUserLeftNum($goods_num)
    {
    	if ($goods_num > 0) {
    		//满足促销且用户限购且总限购剩余数量大于0
    		if ($this->products->is_promote == '1' && $this->products->promote_price > 0 && $this->products->promote_limited > 0) {
    			//用户限购数大于0
    			if ($this->model->promote_user_limited > 0) {
    				$goods_activity_records = $this->goodsActivityRecords();
    				//找到数据，说明在有效时间内
    				if (!empty($goods_activity_records)) {
    					//限定时间已购买的总数
    					$has_buyed_count = $goods_activity_records->buy_num;
    				}
    				//找不到数据，说明已经过活动有效时间，可以重置购买时间和购买次数
    				else {
    					$this->resetPromotionLimitOverCount();
    					 
    					$has_buyed_count = 0;
    				}
    				//剩余可购买的次数
    				$left_num = $this->products->promote_user_limited - $has_buyed_count;
    				 
    				$left_num = max(0, $left_num);
    			} elseif (($this->products->promote_limited < $goods_num || $this->products->promote_limited >= $goods_num) && $this->products->promote_user_limited == '0') {
    				//用户不限购时，剩余可购买限购数等于限购总数
    				$left_num = $this->products->promote_limited;
    			}
    		}else {
	    		$left_num = -1; //没限制（按普通商品购买）
	    	}
    	}
    	return $left_num;
    }
    
    
    /**
     * 重置用户的剩余购买次数
     * @param $openid
     */
    private function resetPromotionLimitOverCount()
    {
    	$time = \RC_Time::gmtime();
    	//用户存在，记录或更新用户购买记录
    	if ($this->user_id > 0) {
    		$info = $this->goodsActivityRecordsInfo();
    		
    		if (! empty($info)) {
    			GoodsActivityRecordsModel::where('user_id', $this->user_id)->where('goods_id', $this->goods_id)->where('product_id', $this->product_id)->update(['add_time' => $time, 'update_time' => $time, 'buy_num' => 0]);
    		} else {
    			GoodsActivityRecordsModel::insert(
    			[
	    			'activity_id'	=> 0,
	    			'activity_type'	=> 'promotion',
	    			'goods_id' 		=> $this->goods_id,
	    			'product_id'	=> $this->product_id,
	    			'user_id'		=> $this->user_id,
	    			'buy_num'		=> 0,
	    			'add_time'		=> $time,
	    			'update_time'	=> $time,
    			]
    			);
    		}
    	}
    }
    
    /**
     * 获得指定的规格的价格
     *
     * @access public
     * @param mix $spec
     *        	规格ID的数组或者逗号分隔的字符串
     * @return void
     */
    private function spec_price($spec) {
    	if (! empty ( $spec )) {
    		if (is_array ( $spec )) {
    			foreach ( $spec as $key => $val ) {
    				$spec [$key] = addslashes ( $val );
    			}
    		} else {
    			$spec = addslashes ( $spec );
    		}
    		$db = \RC_DB::table('goods_attr');
    		$rs = $db->whereIn('goods_attr_id', $spec)->select(\RC_DB::raw('sum(attr_price) as attr_price'))->first();
    		$price = $rs['attr_price'];
    	} else {
    		$price = 0;
    	}
    
    	return $price;
    }
    
    /**
     * 商品活动购买记录信息
     * @return array
     */
    public function goodsActivityRecordsInfo()
    {
    	$info = GoodsActivityRecordsModel::where('activity_id', 0)->where('activity_type', 'promotion')->where('user_id', $this->user_id)->where('goods_id', $this->goods_id)->where('product_id', $this->product_id)->first();
    	
    	return $info;
    }
}
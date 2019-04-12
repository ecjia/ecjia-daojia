<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:22
 */
namespace Ecjia\App\Goods\Product;

use \Ecjia\App\Goods\Models\GoodsModel;
use \Ecjia\App\Goods\Models\ProductsModel;

/**
 * Class GoodsProduct
 * 商品货品价格处理类
 *
 * @package Ecjia\App\Goods\Product
 */
class GoodsProductPrice
{
    protected $goods_id;
    
    protected $goods_products;

    protected $model;
    
    protected $products_model;
    
    protected $user_rank;
    
    protected $user_rank_discount;
    
    protected $goods_specification;
    
    protected $goods_info;
    
    public function __construct($goods_id)
    {
        $this->goods_id = $goods_id;
        $this->model = new GoodsModel();
        $this->products_model = new ProductsModel();
    }
    
    
    public function setUserRank($user_rank)
    {
    	$this->user_rank = $user_rank;
    
    	return $this;
    }
    
    public function setUserRankDiscount($user_rank_discount)
    {
    	$this->user_rank_discount = $user_rank_discount;
    
    	return $this;
    }
    
    public function setGoodsSpecification($GoodsSpecification)
    {
    	$this->goods_specification = $GoodsSpecification;
    
    	return $this;
    }
    
    public function getUserRank()
    {
    	return $this->user_rank > 0 ? $this->user_rank : 0;
    }
    
    public function getUserRankDiscount()
    {
    	return !empty($this->user_rank_discount) ? $this->user_rank_discount : 1;
    }
    
    public function getGoodsProducts()
    {
    	$goods_product = $this->products_model->where('goods_id', $this->goods_id)->get();
    	
    	$this->goods_products = !empty($goods_product) ? $goods_product : [];
    	
    	return $this;
    }
    
    public function setGoodsInfo()
    {
    	$goods_info = $this->model->where('goods_id', $this->goods_id)->first();
    	
    	$this->goods_info = empty($goods_info) ? [] : $goods_info;
    	
    	return $this;
    }
    
    public function getData()
    {
    	//商品规格
    	$specification = $this->goods_specification;
    	
    	//商品规格分组
    	foreach ($specification as $key => $val)  {
    		if ($val['value']) {
    			foreach ($val['value'] as $spec) {
    				$arr[$key][] = $spec['id'];
    			}
    		}
    	}
    	//商品规格属性id重组处理
    	$spec_combine_arr = $this->_combination($arr); 
    	foreach ($spec_combine_arr as $goods_attr) {
    		$goods_attr_string = implode('|', $goods_attr);
    		$product_goods_attrs[] = $goods_attr_string;
    	}
    	
    	
    	//商品货品
    	$product_attr_ids = [];
    	if (!empty($this->goods_products)) {
    		$product_attr_ids = $this->goods_products->map(function($item) {
    			$product_attr_ids = $item['goods_attr'];
    			return $product_attr_ids;
    		})->toArray();
    	}
    	
    	$data = [];
    	
    	if (!empty($product_goods_attrs)) {
    		$collection = collect($product_goods_attrs)->map(function($item) use ($product_attr_ids) {
    			return $this->mapGoodsProductCollection($item, $product_attr_ids);
    		});
    		
    		$data = $collection->toArray();
    	}
    	
    	return $data;
    }
    
    public function mapGoodsProductCollection($attr_id, $product_attr_ids)
    {
    	//商品会员等级价格
    	$user_price = \RC_DB::table('member_price')->where('goods_id', $this->model->goods_id)->where('user_rank', $this->getUserRank())->pluck('user_price');
		
    	//商品促销价格
    	$goods_promote_price = $this->filterPromotePrice($this->goods_info->shop_price, $this->goods_info->is_promote);
    	
		if (in_array($attr_id, $product_attr_ids)) { //有货品情况
			//获取货品信息
			$product_info = $this->products_model->where('goods_id', $this->goods_id)->where('goods_attr', $attr_id)->first();
			
			$product_shop_price = $product_info->product_shop_price;
			//货品会员等级价格
			$product_shop_price = $product_shop_price > 0 ? $product_shop_price*$this->user_rank_discount : $user_price;
			
			//货品促销价
			$product_promote_price = $this->filterPromotePrice($product_info->promote_price, $product_info->is_promote);
			//货品促销价格存在，替换商品促销价格
			$promote_price = $product_promote_price > 0 ? $product_promote_price : $goods_promote_price;
			
			//商品设置是SKU价格（商品价格 + 属性货品价格）
			if (\ecjia::config('sku_price_mode') == 'goods_sku') {
				$product_goods_attr = explode('|', $attr_id);
				$attr_list = \RC_DB::table('goods_attr')->select('attr_value', 'attr_price')->whereIn('goods_attr_id', $product_goods_attr)->get();
				$total_attr_price = 0;
				foreach ($attr_list AS $attr) {
					$total_attr_price += $attr['attr_price'];
				}
				if ($total_attr_price > 0) {
					$product_shop_price += $total_attr_price;
					$promote_price = ($promote_price > 0) ? ($promote_price + $total_attr_price) : 0;
				}
			}
			
			$data = [
				'product_id' 					=> $product_info->product_id,
				'product_name' 					=> $product_info->product_name ? $product_info->product_name : '',
				'product_sn' 					=> $product_info->product_sn,
				'product_goods_attr' 			=> $product_info->goods_attr,
				'product_number'				=> $product_info->product_number,
				'promote_user_limited'			=> $promote_price > 0 ? $product_info->promote_user_limited : 0,
				'promote_limited'				=> $promote_price > 0 ? $product_info->promote_limited : 0,
				'product_shop_price'			=> sprintf("%.2f", $product_shop_price),
				'formatted_product_shop_price'	=> ecjia_price_format($product_shop_price, false),
				'promote_price'					=> $promote_price,
				'formatted_promote_price'		=> $promote_price > 0 ? ecjia_price_format($promote_price, false) : '',
				'img'							=> [
														'thumb' =>  $product_info->product_thumb ? \RC_Upload::upload_url($product_info->product_thumb) : '',
														'small' =>  $product_info->product_img ? \RC_Upload::upload_url($product_info->product_img) : '',
														'url'	=> 	$product_info->product_original_img ? \RC_Upload::upload_url($product_info->product_original_img) : '',
													],
			];
		} else {
			//没有货品，但有规格情况，价格处理
			$product_shop_price = $this->goods_info->shop_price;
			//会员等级价格
			$product_shop_price = $user_price > 0 ? $user_price : $product_shop_price*$this->user_rank_discount;
			
			//促销价
			$promote_price = $goods_promote_price;
			
			//商品设置是SKU价格（商品价格 + 属性货品价格）
			if (\ecjia::config('sku_price_mode') == 'goods_sku') {
				$product_goods_attr = explode('|', $attr_id);
				$attr_list = \RC_DB::table('goods_attr')->select('attr_value', 'attr_price')->whereIn('goods_attr_id', $product_goods_attr)->get();
				$total_attr_price = 0;
				foreach ($attr_list AS $attr) {
					$total_attr_price += $attr['attr_price'];
				}
				if ($total_attr_price > 0) {
					$product_shop_price += $total_attr_price;
					$promote_price = ($promote_price > 0) ? ($promote_price + $total_attr_price) : 0;
				}
			}
			
			$data = [
				'product_id' 					=> 0,
				'product_name'					=> '',
				'product_sn' 					=> '',
				'product_goods_attr' 			=> $attr_id,
				'product_number'				=> 0,
				'promote_user_limited'			=> $promote_price > 0 ? $this->goods_info->promote_user_limited : 0,
				'promote_limited'				=> $promote_price > 0 ? $this->goods_info->promote_limited : 0,
				'product_shop_price'			=> sprintf("%.2f", $product_shop_price),
				'formatted_product_shop_price'	=> ecjia_price_format($product_shop_price, false),	
				'promote_price'					=> $promote_price,
				'formatted_promote_price'		=> $promote_price > 0 ? ecjia_price_format($promote_price, false) : '',
				'img'							=> [],
			];
		}
    	
		return $data;
    }
    
    public function _combination(array $options)
    {
    	$rows = [];
    
    	foreach ($options as $option => $items) {
    		if (count($rows) > 0) {
    			// 2、将第一列作为模板
    			$clone = $rows;
    
    			// 3、置空当前列表，因为只有第一列的数据，组合是不完整的
    			$rows = [];
    
    			// 4、遍历当前列，追加到模板中，使模板中的组合变得完整
    			foreach ($items as $item) {
    				$tmp = $clone;
    				foreach ($tmp as $index => $value) {
    					$value[$option] = $item;
    					$tmp[$index] = $value;
    				}
    
    				// 5、将完整的组合拼回原列表中
    				$rows = array_merge($rows, $tmp);
    			}
    		} else {
    			// 1、先计算出第一列
    			foreach ($items as $item) {
    				$rows[][$option] = $item;
    			}
    		}
    	}
    
    	return $rows;
    }
    
    
/**
	 * 促销价处理
	 * @param unknown $promote_price
	 * @return Ambigous <number, float>
	 */
    protected function filterPromotePrice($promote_price, $is_promote = 0)
    {
    	if ($promote_price > 0 && $is_promote == 1) {
    		$promote_price = \Ecjia\App\Goods\BargainPrice::bargain_price($promote_price, $this->goods_info->promote_start_date, $this->goods_info->promote_end_date);
    	} else {
    		$promote_price = 0;
    	}
    	
    	return $promote_price;
    }

}
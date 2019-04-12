<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-03
 * Time: 19:00
 */

namespace Ecjia\App\Goods\GoodsSearch\Formats;


use Ecjia\App\Goods\Models\GoodsModel;

class GoodsApiFormatted
{

    protected $model;
    
    protected $user_rank_discount;
    
    protected $user_rank;
    
    public function __construct(GoodsModel $model, $user_rank_discount = 1, $user_rank = 0)
    {
        $this->model = $model;
        $this->user_rank_discount = $user_rank_discount;
        $this->user_rank = $user_rank;
    }

    public function toArray()
    {
    	$store_logo = \Ecjia\App\Store\StoreFranchisee::StoreLogo($this->model->store_id);
    	//市场价
    	$market_price = $this->model->market_price;
    	
    	//会员等级价格
    	$user_price = \RC_DB::table('member_price')->where('goods_id', $this->model->goods_id)->where('user_rank', $this->user_rank)->pluck('user_price');
    	$shop_price = $user_price > 0 ? $user_price : $this->model->shop_price*$this->user_rank_discount;
    	
    	//促销价格
    	$promote_price = $this->filterPromotePrice($this->model->product_id ? $this->model->product_promote_price : $this->model->promote_price);
    	 
    	//商品设置是SKU价格（商品价格 + 属性货品价格）
    	if (\ecjia::config('sku_price_mode') == 'goods_sku') {
    		$total_attr_price = 0;
    		if ($this->model->product_id > 0) {
    			//货品有自己价格的话，替换商品价格
    			$shop_price = $this->model->product_shop_price > 0 ? $this->model->product_shop_price*$this->user_rank_discount : $shop_price;
    			
    			$product_goods_attr = explode('|', $this->model->product_goods_attr);
    			$attr_list = \RC_DB::table('goods_attr')->select('attr_value', 'attr_price')->whereIn('goods_attr_id', $product_goods_attr)->get();
    			foreach ($attr_list AS $attr) {
    				$total_attr_price += $attr['attr_price'];
    			}
    			if ($total_attr_price > 0) {
    				$market_price += $total_attr_price;
    				$shop_price += $total_attr_price;
    				$promote_price = ($promote_price > 0) ? ($promote_price + $total_attr_price) : 0;
    			}
    		}
    	}
    	
    	$activity_type = ($this->model->shop_price > $promote_price && $promote_price > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
    	/* 计算节约价格*/
    	$saving_price = ($this->model->shop_price > $promote_price && $promote_price > 0) ? $this->model->shop_price - $promote_price : (($this->model->market_price > 0 && $this->model->market_price > $this->model->shop_price) ? $this->model->market_price - $this->model->shop_price : 0);
    	
    	//商品规格属性
    	$properties = \Ecjia\App\Goods\GoodsFunction::get_goods_properties($this->model->goods_id);
    	$pro = empty($properties['pro']) ? [] : $this->formatProperties($properties['pro']);
    	$spe = empty($properties['specification']) ? [] : $this->formatSpecification($properties['spe']);
    	
    	
    	
        return [
            //store info
            'store_id' 					=> $this->model->store_id,
            'store_name'				=> $this->model->store->merchants_name,
            'store_logo'				=> $store_logo,
            'manage_mode' 				=> $this->model->store->manage_mode,
            'seller_id'					=> $this->model->store_id,
            'seller_name'				=> $this->model->store->merchants_name,
            'seller_logo'				=> $store_logo,
            //goods info
            'goods_id' 					=> $this->model->goods_id,
            'goods_name' 				=> $this->filterGoodsName($this->model->goods_name),
            'id'						=> $this->model->goods_id,
            'name'	   					=> $this->filterGoodsName($this->model->goods_name),
            'goods_sn' 					=> $this->filterGoodsSn($this->model->goods_sn),
            'market_price'				=> ecjia_price_format($market_price, false),
            'unformatted_market_price'  => sprintf("%.2f", $market_price),
            'shop_price'				=> ecjia_price_format($shop_price, false),
            'unformatted_shop_price'    => sprintf("%.2f", $shop_price),
            'promote_price' 			=> $promote_price > 0 ? ecjia_price_format($promote_price, false) : '',
            'promote_start_date'        => \RC_Time::local_date('Y/m/d H:i:s O', $this->model->promote_start_date),
            'promote_end_date'          => \RC_Time::local_date('Y/m/d H:i:s O', $this->model->promote_end_date),
            'unformatted_promote_price' => sprintf("%.2f", $promote_price),
            'product_id' 				=> $this->filterProductId($this->model->product_id),
            'product_goods_attr'		=> $this->filterProductGoodsAttr($this->model->product_goods_attr),
            'goods_barcode' 			=> $this->filterGoodsBarcode($this->model->goods_barcode),
            'activity_type' 			=> $activity_type,
            'object_id'     			=> 0,
            'saving_price'  			=> sprintf("%.2f", $saving_price),
            'formatted_saving_price'    => $saving_price > 0 ? sprintf(__('已省%s元', 'goods'), $saving_price) : '',
			'properties'				=> $pro,
			'specification'				=> $this->model->product_id > 0 ? [] : array_values($properties['spe']),
			
            //picture info
	        'img' 						=> $this->filterGoodsImg($this->model->product_id),
			
        ];
    }

    /**
     * 商品主图信息处理
     * @param int $product_id
     * @return array
     */
    protected function filterGoodsImg($product_id)
    {
    	$img = [
    		'thumb' => $this->model->goods_thumb ? \RC_Upload::upload_url($this->model->goods_thumb) : '',
    		'url'     => $this->model->original_img ? \RC_Upload::upload_url($this->model->original_img) : '',
    		'small'   => $this->model->goods_img ? \RC_Upload::upload_url($this->model->goods_img) : '',
    	];
    	if ($product_id > 0) {
    		if (!empty($this->model->product_thumb)) {
    			$img['thumb'] = \RC_Upload::upload_url($this->model->product_thumb);
    		}
    		if (!empty($this->model->product_original_img)) {
    			$img['url'] = \RC_Upload::upload_url($this->model->product_original_img);
    		}
    		if (!empty($this->model->product_img)) {
    			$img['small'] = \RC_Upload::upload_url($this->model->product_img);
    		}
    	}
    	
    	return $img;
    }
    
	/**
	 * 促销价处理
	 * @param unknown $promote_price
	 * @return Ambigous <number, float>
	 */
    protected function filterPromotePrice($promote_price)
    {
    	if ($promote_price > 0) {
    		$promote_price = \Ecjia\App\Goods\BargainPrice::bargain_price($promote_price, $this->model->promote_start_date, $this->model->promote_end_date);
    	} else {
    		$promote_price = 0;
    	}
    	
    	return $promote_price;
    }
    
    protected function filterGoodsBarcode($goods_barcode)
    {
        return $goods_barcode;
    }

    protected function filterGoodsSn($goods_sn)
    {
        return $this->model->product_sn ?: $goods_sn;
    }

    /**
     * 过滤product_name
     * @param $goods_name
     * @return mixed
     */
    protected function filterGoodsName($goods_name)
    {
        return $this->model->product_name ?: $goods_name;
    }

    /**
     * 过滤product_id
     * @param $product_id
     * @return int
     */
    protected function filterProductId($product_id)
    {
        return $product_id ?: 0;
    }
    
    /**
     * 过滤货品属性id
     * @param $product_goods_attr
     * @return string
     */
    protected function filterProductGoodsAttr($product_goods_attr)
    {
    	return $product_goods_attr ?: '';
    }
    
    /**
     * 处理商品属性
     * @param $pro
     * @return array
     */
    protected function formatProperties($pro)
    {
    	$outData = [];
    	if (!empty($pro)) {
    		foreach ($pro as $key => $value) {
    			// 处理分组
    			foreach ($value as $k => $v) {
    				$v['value']                 = strip_tags($v['value']);
    				$outData[]				    = $v;
    			}
    		}
    	}
    	return $outData;
    }
    
    /**
     * 处理商品规格
     * @param $pro
     * @return array
     */
    protected function formatSpecification($spe)
    {
    	$outData = [];
    	if (!empty($spe)) {
    		foreach ($spe as $key => $value) {
    			if (!empty($value['values'])) {
    				$value['value'] = $value['values'];
    				unset($value['values']);
    			}
    			$outData[] = $value;
    		}
    	}
    	return $outData;
    }
}
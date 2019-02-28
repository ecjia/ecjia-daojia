<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-20
 * Time: 18:22
 */

namespace Ecjia\App\Cart\CartFlow;


class CartStorePrice
{

    protected $prices = [];
    
    protected $discount = [];
    
    protected $store_id;

    public function __construct($store_id)
    {
        $this->store_id = $store_id;
    }

    /**
     * 添加价格
     * @param CartPrice $price
     */
    public function addPrice(CartPrice $price)
    {
        $this->prices[] = $price;
    }
	
    /**
     * 添加优惠折扣
     * @param CartPrice $price
     */
    public function addDiscount(array $discount)
    {
    	$this->discount = $discount;
    }
    
    /**
     * 店铺购物车价格计算
     */
    public function computeTotalPrice()
    {
        $goods_price = collect($this->prices)->sum(function($item) {
            $total = $item->computeTotalPrice();
            return $total['goods_price'];
        });

        $goods_quantity = collect($this->prices)->sum(function($item) {
            $total = $item->computeTotalPrice();
            return $total['goods_number'];
        });
        
        $market_price = collect($this->prices)->sum(function($item) {
        	$total = $item->computeTotalPrice();
        	return $total['market_price'];
        });
		
        $discount =  $this->discount['store_cart_discount'];
        
        $total['goods_amount'] = sprintf("%.2f", $goods_price);
        $total['goods_number'] = $goods_quantity;
        $total['saving']       = ecjia_price_format($market_price - $goods_price, false);
        if ($market_price > 0) {
            $total['save_rate'] = $market_price ? round(($market_price - $goods_price) * 100 / $market_price).'%' : 0;
        }
        $total['unformatted_goods_price']  	= sprintf("%.2f", $goods_price);
        $total['goods_price']  				= ecjia_price_format($goods_price, false);
        $total['unformatted_market_price'] 	= sprintf("%.2f", $market_price);
        $total['market_price'] 				= ecjia_price_format($market_price, false);
        $total['real_goods_count']    		= $goods_quantity;
        $total['discount'] 					= sprintf("%.2f", $discount);
        $total['formated_discount'] 		= ecjia_price_format($discount, false);
        
        return $total;
    }

}
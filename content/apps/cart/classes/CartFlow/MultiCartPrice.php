<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-20
 * Time: 18:50
 */

namespace Ecjia\App\Cart\CartFlow;


class MultiCartPrice
{

    protected $prices = [];

    public function __construct()
    {

    }

    /**
     * 添加价格
     * @param array $price
     */
    public function addPrice(array $price)
    {
        $this->prices[] = $price;
    }

    /**
     * 购物车总计
     */
    public function computeTotalPrice()
    {
        $goods_price = collect($this->prices)->sum(function($item) {
            return $item['goods_amount'];
        });

        $goods_quantity = collect($this->prices)->sum(function($item) {
            return $item['goods_number'];
        });
		
        $market_price = collect($this->prices)->sum(function($item) {
        	return $item['unformatted_market_price'];
        });

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

        return $total;
    }




}
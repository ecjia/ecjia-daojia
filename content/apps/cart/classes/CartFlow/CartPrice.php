<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:59
 */

namespace Ecjia\App\Cart\CartFlow;


use Ecjia\App\Cart\Models\CartModel;

class CartPrice
{

    /**
     * @var CartModel
     */
    protected $model;
    protected $total = [];
    
    public function __construct(CartModel $model)
    {
        $this->model = $model;

        /**
         * $this->model->goods 这是购物车商品的数据模型
         */
        
        /**
         * $this->model->store_franchisee 这是购物车店铺数据模型 
         */
    }
    
    

    /**
     * 购物车总计
     */
    public function computeTotalPrice()
    {
    	/* 用于统计购物车中实体商品和虚拟商品的个数 */
    	$virtual_goods_count = 0;
    	$real_goods_count    = 0;
    	/* 统计实体商品和虚拟商品的个数 */
    	if ($this->model->is_real) {
    		$real_goods_count++;
    	} else {
    		$virtual_goods_count++;
    	}
    	$this->total['real_goods_count'] 	= $real_goods_count;
    	$this->total['virtual_goods_count'] = $virtual_goods_count;
    	
    	$this->total['goods_price'] = '0.00';
    	if ($this->model->is_checked == 1) {
    		$this->total['goods_price']  += $this->model->goods_price * $this->model->goods_number;
    		$this->total['market_price'] += $this->model->market_price * $this->model->goods_number;
    	}
    	$this->total['goods_number'] = $this->model->goods_number;
    	
    	$this->total['goods_amount'] = $this->total['goods_price'];
    	
    	$this->total['goods_price'] 			= sprintf("%.2f", $this->total['goods_price']);
    	$this->total['formatted_goods_price']  	= ecjia_price_format($this->total['goods_price'], false);
    	$this->total['market_price']			= sprintf("%.2f", $this->total['market_price']);
    	$this->total['formatted_market_price'] 	= ecjia_price_format($this->total['market_price'], false);
    	
    	return $this->total;
    }

	/**
	 * 订单总费用
	 */
    public function totalOrderFee()
    {
    	
    }
}
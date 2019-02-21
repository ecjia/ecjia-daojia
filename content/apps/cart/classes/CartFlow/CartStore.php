<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 19:02
 */

namespace Ecjia\App\Cart\CartFlow;


use Ecjia\App\Cart\Models\CartModel;

class CartStore
{

    /**
     * @var CartModel
     */
    protected $model;

    public function __construct(CartModel $model)
    {
        $this->model = $model;

        /**
         * $this->model->goods 这是购物车商品的数据模型
         */
        
        /**
         * $this->model->store_franchisee 购物车店铺数据模型 
         */
    }
	
    /**
     * 店铺购物车列表
     */
    public function storeCartData()
    {
    	
    }
    
    /**
     * 店铺购物车小计
     */
    public function storeCartTotalPrice()
    {
    	 
    }
    
    /**
     * 店铺选中的购物车满足的最优惠店铺优惠活动
     */
    protected function checkedStoreCartFav()
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
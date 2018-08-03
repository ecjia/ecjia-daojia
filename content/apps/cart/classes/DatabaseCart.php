<?php

namespace Ecjia\App\Cart;

use Royalcms\Component\Shoppingcart\Contracts\Cartable;

class DatabaseCart implements Cartable 
{
    
    /**
     * 创建或者查找一个购物车
     */
    public function cart($user_id)
    {
        
    }
    
    /**
     * 将商品添加到购物车当中
     */
    public function add($cart_id, $good_id, $count, $price, $color, $size)
    {
        
    }
    
    
    /**
     * 获取购物车中的所有商品
     * @param $cart_id
     * @return mixed
     */
    public function getAllItems($cart_id)
    {
        
    }
    
    
    /**
     * 获取一个特定的购物车项
     * @param $item_id
     * @return mixed
     */
    public function getItem($item_id)
    {
        
    }
    
    
    /**
     * 计算购物车内商品的数量
     * @param $cart_id
     * @return int
     */
    public function count($cart_id)
    {
        
    }
    
    /**
     * 计算购物车的总价格
     * @param $cart_id
     * @return int
     */
    public function totalPrice($cart_id)
    {
        
    }
    
    
    /**
     * 更新商品的数目
     * @param $item_id
     * @param $qty
     * @return mixed
     */
    public function updateQty($item_id, $qty)
    {
        
    }
    
    
    /**
     * 删除一个购物车项
     * @param $item_id
     * @return bool
     */
    public function removeItem($item_id)
    {
        
    }
    
    
    /**
     * 更新一件商品的属性
     * @param $item_id
     * @param $attributes
     */
    public function updateItem($item_id, $attributes)
    {
        
    }
    
    
    /**
     *  清空购物车
     * @param $cart_id
     * @return mixed
     */
    public function removeAllItem($cart_id)
    {
        
    }
    
    
    /**
     * 更新购物车信息，主要总价格和商品数量
     * @param $cart_id
     * @return bool
     */
    public function updateCart($cart_id)
    {
        
    }
    
    
    /**
     * 根据店铺 id 获取购物车列表
     * @param $cart_id
     * @return mixed
     */
    public function getCart($cart_id)
    {
        
    }
    
}

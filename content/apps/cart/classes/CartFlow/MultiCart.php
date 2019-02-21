<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-20
 * Time: 18:45
 */

namespace Ecjia\App\Cart\CartFlow;


class MultiCart
{

    protected $carts = [];


    public function __construct()
    {

    }


    public function addCart(Cart $cart)
    {
        $this->carts[] = $cart;
    }


    /**
     * 获得购物车中的商品
     */
    public function getGoodsCollection()
    {

//        dd($this->carts);
        $cart_price = new MultiCartPrice();

        $result = collect($this->carts)->map(function($item) use ($cart_price) {
            $data = $item->getGoodsCollection();
            $cart_price->addPrice($data['total']);
            return $data;
        });

        $total = $cart_price->computeTotalPrice();

        return array('carts' => $result, 'total' => $total);
    }

}
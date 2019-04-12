<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-27
 * Time: 10:04
 */

namespace Ecjia\App\Cart\CreateOrders\OrderParts;


use Ecjia\App\Cart\CreateOrders\OrderPartAbstract;

class SpecialCartPart extends OrderPartAbstract
{

    protected $part_key = 'cart';


    public function __construct($cart)
    {
        $this->data = $cart;
    }

}
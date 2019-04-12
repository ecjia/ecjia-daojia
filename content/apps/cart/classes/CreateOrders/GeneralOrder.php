<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 13:25
 */

namespace Ecjia\App\Cart\CreateOrders;


use Royalcms\Component\Container\Container;

class GeneralOrder extends Container
{

    /**
     * 添加订单处理对象
     * @param OrderPartAbstract $part
     */
    public function addOrderPart(OrderPartAbstract $part)
    {
        $this->instance($part->getPartKey(), $part);
    }

    /**
     * 移除订单处理对象
     * @param OrderPartAbstract $part
     */
    public function removeOrderPart(OrderPartAbstract $part)
    {
        $this->forgetInstance($part->getPartKey());
    }

    /**
     * 通过指定key移除订单处理对象
     * @param $key
     */
    public function removeOrderPartForKey($key)
    {
        $this->forgetInstance($key);
    }


}
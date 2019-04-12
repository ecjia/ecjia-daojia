<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-27
 * Time: 09:37
 */

namespace Ecjia\App\Cart\CreateOrders;


abstract class OrderPartAbstract
{

    protected $part_key;

    protected $data;

    /**
     * @return mixed
     */
    public function getPartKey()
    {
        return $this->part_key;
    }

    /**
     * @param mixed $part_key
     * @return OrderPartAbstract
     */
    public function setPartKey($part_key)
    {
        $this->part_key = $part_key;
        return $this;
    }




}
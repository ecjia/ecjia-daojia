<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 13:32
 */

namespace Ecjia\App\Cart\CreateOrders\OrderParts;


use Ecjia\App\Cart\CreateOrders\OrderPartAbstract;

class OrderStorePart extends OrderPartAbstract
{

    protected $part_key = 'store';

    protected $store_id;

    public function __construct($store_id)
    {
        $this->store_id = $store_id;
    }

	

}
<?php

namespace Ecjia\App\Orders;

use \Ecjia\App\Orders\Order\Consignee;

class Order
{
    /**
     * 收货人
     * @var \Ecjia\App\Orders\Order\Consignee;
     */
    protected $consignee;


    public function __construct()
    {

    }

    /**
     *
     * @param Consignee $consignee
     * @return \Ecjia\App\Orders\Order
     */
    public function setConsignee(Consignee $consignee)
    {
        $this->consignee = $consignee;

        return $this;
    }

    /**
     *
     * @return \Ecjia\App\Orders\Order\Consignee;
     */
    public function getConsignee()
    {
        return $this->consignee;
    }


}
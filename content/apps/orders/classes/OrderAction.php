<?php

namespace Ecjia\App\Orders;


class OrderAction
{
    
    protected $order_id;
    
    
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }
    
    
    
    
}
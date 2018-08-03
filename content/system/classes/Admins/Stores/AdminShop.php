<?php

namespace Ecjia\System\Admins\Stores;

use ecjia;
use Ecjia\System\Frameworks\Contracts\ShopInterface;

class AdminShop implements ShopInterface
{
    protected $storeid;
    
    public function __construct($storeid)
    {
        $this->storeid = $storeid;
    }
    
    public function getStoreName()
    {
        return ecjia::config('shop_name');
    }
    
    
    public function getSotreId() 
    {
        return $this->storeid;
    }
    
}
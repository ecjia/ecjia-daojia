<?php

namespace Ecjia\App\Merchant\Frameworks\Stores;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use Ecjia\System\Frameworks\Contracts\ShopInterface;

class MerchantShop extends AbstractRepository implements ShopInterface
{
    protected $model = 'Ecjia\App\Merchant\Models\StoreFranchiseeModel';
    
    protected $shop;
    
    
    public function __construct($storeid)
    {
        parent::__construct();
        
        $this->shop = $this->find($storeid);
    }
    
    public function getStoreName()
    {
        return $this->shop->merchants_name;
    }
    
    
    public function getSotreId() 
    {
        return $this->shop->store_id;
    }
    
}
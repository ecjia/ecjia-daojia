<?php

namespace Ecjia\App\Affiliate\Models;

use Royalcms\Component\Database\Eloquent\Model;

class AffiliateOrderCommissionModel extends Model
{

    protected $table = 'affiliate_order_commission';
    
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
			'store_id',
			'affiliate_store_id',
			'order_type',
			'order_id',
			'order_sn',
			'order_amount',
			'platform_commission',
			'percent_value',
			'agent_amount',
			'status',
			'add_time'
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

	
    /**
     * 一对一
     * 获取分佣记录对应的店铺信息
     */
    public function store_franchisee_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\StoreFranchiseeModel', 'store_id', 'store_id');
    }
    
    /**
     * 一对一
     * 获取分佣记录对应的普通订单信息
     */
    public function order_info_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\OrderInfoModel', 'order_id', 'order_id');
    }
    
    /**
     * 一对一
     * 获取分佣记录对应的买单订单信息
     */
    public function quickpay_orders_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\QuickpayOrdersModel', 'order_id', 'order_id');
    }
    
}
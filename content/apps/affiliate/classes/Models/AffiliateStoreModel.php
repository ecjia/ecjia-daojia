<?php

namespace Ecjia\App\Affiliate\Models;

use Royalcms\Component\Database\Eloquent\Model;

class AffiliateStoreModel extends Model
{

    protected $table = 'affiliate_store';
    
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
		'affiliate_store_id',
		'user_id',
		'store_id',
		'store_preaudit_id',
		'add_time'
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    
    /**
     * 一对多
     * 代理商推荐的店铺关联信息集合
     */
    public function affiliate_store_record_collection()
    {
    	return $this->hasMany('Ecjia\App\Affiliate\Models\AffiliateStoreRecordModel', 'affiliate_store_id', 'id');
    }

    /**
     * 一对一
     * 代理商关联的会员信息
     */
    public function users_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\UsersModel', 'user_id', 'user_id');
    }
    
    /**
     * 一对多
     * 代理商的分佣记录集合
     */
    public function affiliate_order_commission_collection()
    {
    	return $this->hasMany('Ecjia\App\Affiliate\Models\AffiliateOrderCommissionModel', 'affiliate_store_id', 'id');
    }
}
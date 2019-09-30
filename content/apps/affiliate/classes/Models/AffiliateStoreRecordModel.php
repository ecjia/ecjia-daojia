<?php

namespace Ecjia\App\Affiliate\Models;

use Royalcms\Component\Database\Eloquent\Model;

class AffiliateStoreRecordModel extends Model
{

    protected $table = 'affiliate_store_record';
    
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    
    /**
     * 一对一
     * 店铺推荐人信息
     */
    public function affiliate_store_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\AffiliateStoreModel', 'affiliate_store_id', 'id');
    }
    
    /**
     * 一对一
     * 对应店铺信息
     */
    public function store_franchisee_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\StoreFranchiseeModel', 'store_id', 'store_id');
    }

}
<?php

namespace Ecjia\App\Affiliate\Models;

use Royalcms\Component\Database\Eloquent\Model;

class AffiliateDistributorModel extends Model
{

    protected $table = 'affiliate_distributor';

    protected $primaryKey = 'user_id';

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
     * 获取用户信息
     */
    public function user_model()
    {
        return $this->belongsTo('Ecjia\App\User\Models\UserModel', 'user_id', 'user_id');
    }

    /**
     * 一对一
     * 获取等级信息
     */
    public function affiliate_grade_model()
    {
        return $this->belongsTo('Ecjia\App\Affiliate\Models\AffiliateGradeModel', 'grade_id', 'grade_id');
    }
    

}
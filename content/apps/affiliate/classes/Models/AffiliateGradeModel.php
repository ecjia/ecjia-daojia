<?php

namespace Ecjia\App\Affiliate\Models;

use Royalcms\Component\Database\Eloquent\Model;

class AffiliateGradeModel extends Model
{

    protected $table = 'affiliate_grade';

    protected $primaryKey = 'grade_id';

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
     * 获取商品信息
     */
    public function goods_model()
    {
        return $this->belongsTo('Ecjia\App\Goods\Models\GoodsModel', 'goods_id', 'goods_id');
    }
    

}
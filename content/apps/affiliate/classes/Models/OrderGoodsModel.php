<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/24
 * Time: 17:33
 */

namespace Ecjia\App\Affiliate\Models;

use Royalcms\Component\Database\Eloquent\Model;

class OrderGoodsModel extends Model
{

    protected $table = 'order_goods';

    protected $primaryKey = 'rec_id';

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
     * 订单商品对应的商品信息
     */
    public function goods_model()
    {
    	return $this->belongsTo('Ecjia\App\Affiliate\Models\GoodsModel', 'goods_id', 'goods_id');
    }

    /**
     * 一对多
     * 订单商品对应佣金
     */
    public function affiliate_grade_price_collection() {
        return $this->hasMany('Ecjia\App\Affiliate\Models\AffiliateGradePriceModel', 'goods_id', 'goods_id');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:34
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;

class LinkGoodsModel extends Model
{

    protected $table = 'link_goods';

    //protected $primaryKey = 'brand_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'goods_id',
        'link_goods_id',
        'is_double',
        'admin_id',
        'sort_order'
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 一对一
     * 获取关联商品信息
     */
    public function goods_model()
    {
    	return $this->belongsTo('Ecjia\App\Goods\Models\GoodsModel', 'link_goods_id', 'goods_id');
    }
	
}
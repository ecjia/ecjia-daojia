<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodsGalleryModel extends Model
{

    protected $table = 'goods_gallery';

    protected $primaryKey = 'img_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'goods_id',
        'product_id',
        'img_url',
        'img_desc',
        'thumb_url',
        'img_original',
        'sort_order',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * 一对一，关联商品信息
     */
    public function goods_model()
    {
    	return $this->hasMany('Ecjia\App\Goods\Models\GoodsModel', 'goods_id', 'goods_id');
    }

    /**
     * 一对一，关联货品信息
     */
    public function products_model()
    {
        return $this->hasMany('Ecjia\App\Goods\Models\ProductsModel', 'product_id', 'product_id');
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goods\Models;

use Royalcms\Component\Database\Eloquent\Model;

class ProductsModel extends Model
{

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'goods_id',
        'goods_attr',
        'product_sn',
        'product_number',
        'is_promote',
        'promote_price',
        'promote_start_date',
        'promote_end_date',
        'promote_user_limited',
        'product_name',
        'product_shop_price',
        'product_bar_code',
        'product_thumb',
        'product_img',
        'product_original_img',
        'product_desc',
        'goodslib_product_id',
        'goodslib_update_time',
        'supplier_product_id',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * 一对多
     * 货品相册集合
     */
    public function goods_gallery_collection()
    {
    	return $this->hasMany('Ecjia\App\Goods\Models\GoodsGalleryModel', 'product_id', 'product_id');
    }

}
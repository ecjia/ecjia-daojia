<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goodslib\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodslibProductsModel extends Model
{

    protected $table = 'goodslib_products';

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
        'product_shop_price',
        'product_bar_code',
        'product_thumb',
        'product_img',
        'product_original_img',
        'product_desc',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    
    /**
     * 一对多
     * 商品库货品相册
     */
    public function goodslib_gallery_collection()
    {
    	return $this->hasMany('Ecjia\App\Goodslib\Models\GoodslibGalleryModel', 'product_id', 'product_id');
    }
}
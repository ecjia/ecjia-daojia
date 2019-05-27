<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goodslib\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodslibAttrModel extends Model
{

    protected $table = 'goodslib_attr';

    protected $primaryKey = 'goods_attr_id';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'cat_type',
        'goods_id',
        'attr_id',
        'attr_value',
        'color_value',
        'attr_price',
        'attr_sort',
        'attr_img_flie',
        'attr_gallery_flie',
        'attr_img_site',
        'attr_checked'
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 一对一
     * 商品参数/规格的属性信息
     */
    public function attribute_model()
    {
        return $this->belongsTo('Ecjia\App\Goodslib\Models\AttributeModel', 'attr_id', 'attr_id');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:16
 */

namespace Ecjia\App\Goodslib\Models;

use Royalcms\Component\Database\Eloquent\Model;

class GoodslibGalleryModel extends Model
{

    protected $table = 'goodslib_gallery';

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

}
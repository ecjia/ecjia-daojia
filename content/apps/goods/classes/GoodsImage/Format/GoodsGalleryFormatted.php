<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 14:31
 */

namespace Ecjia\App\Goods\GoodsImage\Format;

use RC_Time;

class GoodsGalleryFormatted extends GoodsImageFormatted
{

    protected $goods_image;


    protected $type = 'gallery';

    /**
     * 商品分隔符
     * @var String
     */
    protected $goods_separator = '_P_';

    /**
     * 商品缩略图分隔符
     * @var String
     */
    protected $goods_thumb_separator = '_thumb_P_';

}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 14:35
 */

namespace Ecjia\App\Goods\GoodsImage\Format;


use Ecjia\App\Goods\GoodsImage\GoodsImageFormattedInterface;

class ProductImageFormatted extends GoodsImageFormatted
{

    protected $type = 'product';

    public function __construct(GoodsImageFormattedInterface $goods_image, $root_dir = null)
    {
        parent::__construct($goods_image, $root_dir);

        $this->goods_source_postion = $this->filePathPrefix('product_source_img/') . $this->spliceFileName();
        $this->goods_image_postion = $this->filePathPrefix('product_img/') . $this->spliceFileName();
        $this->goods_thumb_postion = $this->filePathPrefix('product_thumb_img/') . $this->spliceFileName(true);

    }

    /**
     * 拼接文件名
     */
    protected function spliceFileName($is_thumb = false)
    {
        if ($is_thumb) {
            return $this->goods_image->getProductId() . $this->goods_thumb_separator . $this->random_name . '.' . $this->goods_image->getExtensionName();
        } else {
            return $this->goods_image->getProductId() . $this->goods_separator . $this->random_name . '.' . $this->goods_image->getExtensionName();
        }
    }

}
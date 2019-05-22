<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 14:31
 */

namespace Ecjia\App\Goods\GoodsImage\Format;

use RC_Time;

class GoodsImageFormatted
{

    protected $root_dir = 'images/';

    /**
     * @var \Ecjia\App\Goods\GoodsImage\Goods\GoodsImage
     */
    protected $goods_image;

    protected $type = 'goods';

    /**
     * 商品分隔符
     * @var String
     */
    protected $goods_separator = '_G_';

    /**
     * 商品缩略图分隔符
     * @var String
     */
    protected $goods_thumb_separator = '_thumb_G_';

    /**
     * 原图位置
     * @var String
     */
    protected $goods_source_postion;

    /**
     * 缩略图位置
     * @var String
     */
    protected $goods_thumb_postion;

    /**
     * 商品图位置
     * @var String
     */
    protected $goods_image_postion;

    /**
     * 随机名
     * @var String
     */
    protected $random_name;

    public function __construct($goods_image, $root_dir = null)
    {
        $this->goods_image = $goods_image;

        if (!is_null($root_dir)) {
            $this->root_dir = $root_dir;
        }

        $this->random_name = $this->generateRandomName();

        $this->goods_source_postion = $this->filePathPrefix('source_img/') . $this->spliceFileName();
        $this->goods_image_postion = $this->filePathPrefix('goods_img/') . $this->spliceFileName();
        $this->goods_thumb_postion = $this->filePathPrefix('thumb_img/') . $this->spliceFileName(true);
    }

    /**
     * 生成随机文件名
     */
    public function generateRandomName()
    {
        $rand_name = RC_Time::gmtime() . sprintf("%03d", mt_rand(1,999));
        return $rand_name;
    }

    /**
     * 拼接文件名
     */
    protected function spliceFileName($is_thumb = false)
    {
        if ($is_thumb) {
            return $this->goods_image->getGoodsId() . $this->goods_thumb_separator . $this->random_name . '.' . $this->goods_image->getExtensionName();
        } else {
            return $this->goods_image->getGoodsId() . $this->goods_separator . $this->random_name . '.' . $this->goods_image->getExtensionName();
        }
    }

    public function filePathPrefix($path = '')
    {
        $sub_dir = date('Ym', RC_Time::gmtime());

        $path = $this->root_dir . $sub_dir . '/' . $path;

        return $path;
    }

    /**
     * 获取原图图片路径
     * @return String
     */
    public function getSourcePostion()
    {
        return $this->goods_source_postion;
    }

    /**
     * 获取缩略图图片路径
     * @return String
     */
    public function getThumbPostion()
    {
        return $this->goods_thumb_postion;
    }

    /**
     * 获取商品图片路径
     * @return String
     */
    public function getGoodsimgPostion()
    {
        return $this->goods_image_postion;
    }


}
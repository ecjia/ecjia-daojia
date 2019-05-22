<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 09:28
 */

namespace Ecjia\App\Goods\GoodsImage\Goods;


use Ecjia\App\Goods\GoodsImage\Format\GoodsGalleryFormatted;
use Ecjia\App\Goods\Models\GoodsGalleryModel;
use ecjia;
use ecjia_error;

class GoodsGallery extends GoodsImage
{

    /**
     * 设置是否自动生成缩略图
     * @var bool
     */
    protected $auto_generate_thumb = true;

    public function __construct($goods_id, $product_id = 0, $fileinfo = null)
    {
        parent::__construct($goods_id, $product_id, $fileinfo);


        $this->image_format = new GoodsGalleryFormatted($this);
    }


    /**
     * 更新图片到数据库
     */
    public function updateToDatabase($img_desc = null)
    {
        if (is_null($img_desc)) {
            $img_desc = $this->getFileName();
        }

        list($original_path, $img_path, $thumb_path) = $this->saveImageToDisk();

        if (!$original_path || !$img_path) {
            return new ecjia_error('upload_goods_gallery_error', __('商品图片路径无效', 'goods'));
        }

        /* 不保留商品原图的时候删除原图 */
        if (! ecjia::config('retain_original_img') && !empty($original_path)) {
            $this->disk->deletePath($original_path);
            $original_path = '';
        }

        //存入数据库中
        $data = array(
            'goods_id' 		=> $this->goods_id,
            'product_id' 	=> $this->product_id,
            'img_url' 		=> $img_path,
            'img_desc' 		=> $img_desc,
            'thumb_url' 	=> $thumb_path,
            'img_original' 	=> $original_path,
        );

        $model = GoodsGalleryModel::create($data);

        return $model;
    }

}
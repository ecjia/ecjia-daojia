<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 09:27
 */

namespace Ecjia\App\Goods\GoodsImage\Product;


use Ecjia\App\Goods\GoodsImage\Format\ProductImageFormatted;
use Ecjia\App\Goods\Models\ProductsModel;
use Ecjia\App\Goods\GoodsImage\Goods\GoodsImage;
use ecjia_error;
use ecjia;

class ProductImage extends GoodsImage
{



    public function __construct($goods_id, $product_id = 0, $fileinfo = null)
    {
        parent::__construct($goods_id, $product_id, $fileinfo);


        $this->image_format = new ProductImageFormatted($this);
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
            return new ecjia_error('upload_products_gallery_error', __('货品图片路径无效', 'goods'));
        }

        //存入数据库中
        $model = ProductsModel::where('goods_id', $this->goods_id)->where('product_id', $this->product_id)->select('goods_id', 'product_id', 'product_original_img', 'product_img', 'product_thumb')->first();
        if (! empty($model)) {
            $this->clearOldImage($model);

            /* 不保留商品原图的时候删除原图 */
            if (! ecjia::config('retain_original_img') && !empty($original_path)) {
                $this->disk->deletePath($original_path);
                $original_path = '';
            }

            $model->product_original_img = $original_path;
            $model->product_img = $img_path;
            $model->product_thumb = $thumb_path;
            $model->save();
        }

        /* 复制一份相册图片 */
        /* 添加判断是否自动生成相册图片 */
        if (ecjia::config('auto_generate_gallery')) {
            $data = (new ProductGallery($this->goods_id, $this->product_id, $this->fileinfo))->updateToDatabase($img_desc);
            if (is_ecjia_error($data)) {
                //复制失败不中断请求
                ecjia_log_warning('货品相册复制失败', $data, 'goods');
            }
        }

        return true;
    }

    /**
     * 清理旧图片
     * @param ProductsModel $model
     */
    protected function clearOldImage($model)
    {
        /* 先存储新的图片，再删除原来的图片 */
        if ($model['product_thumb']) {
            $this->disk->delete($model['product_thumb']);
        }

        if ($model['product_img']) {
            $this->disk->delete($model['product_img']);
        }

        if ($model['product_original_img']) {
            $this->disk->delete($model['product_original_img']);
        }
    }

}
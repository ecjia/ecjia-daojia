<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 09:28
 */

namespace Ecjia\App\Goodslib\GoodsImage\Product;


use Ecjia\App\Goodslib\Models\GoodslibProductsModel;
use ecjia_error;

class ProductThumb extends ProductImage
{

    /**
     *  保存图片到磁盘
     */
    public function saveImageToDisk()
    {
        $thumb_path = $this->image_format->getThumbPostion();

        $original_path = $img_path = null;

        // 保存原图，缩略图不加水印
        $this->disk->writeForSourcePath($this->getFilePath(), $thumb_path);

        //返回 [原图，处理过的图片，缩略图]
        return [$original_path, $img_path, $thumb_path];
    }

    /**
     * 更新图片到数据库
     */
    public function updateToDatabase($img_desc = null)
    {
        //$img_desc 用不到，不需要存储

        list($original_path, $img_path, $thumb_path) = $this->saveImageToDisk();

        if (!empty($thumb_path)) {
            return new ecjia_error('upload_goods_thumb_error', __('商品缩略图路径无效', 'goods'));
        }

        //存入数据库中
        $data = array(
            'thumb_url' 	=> $thumb_path,
        );

        $model = GoodslibProductsModel::where('goods_id', $this->goods_id)->where('product_id', $this->product_id)->select('goods_id', 'product_id', 'product_thumb')->first();
        if (! empty($model)) {
            $this->clearOldImage($model);

            $model->product_thumb = $thumb_path;
            $model->save();
        }

        return true;
    }

    /**
     * 清理旧图片
     * @param GoodslibProductsModel $model
     */
    protected function clearOldImage($model)
    {
        /* 先存储新的图片，再删除原来的图片 */
        if ($model['product_thumb']) {
            $this->disk->delete($model['product_thumb']);
        }
    }

}
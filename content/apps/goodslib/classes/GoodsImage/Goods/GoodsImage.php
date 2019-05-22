<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 09:27
 */

namespace Ecjia\App\Goodslib\GoodsImage\Goods;


use Ecjia\App\Goods\GoodsImage\Format\GoodsImageFormatted;
use Ecjia\App\Goodslib\Models\GoodslibModel;
use ecjia;
use ecjia_error;

class GoodsImage extends \Ecjia\App\Goods\GoodsImage\Goods\GoodsImage
{

    /**
     * 设置是否自动生成缩略图
     * @var bool
     */
    protected $auto_generate_thumb = false;

    /**
     * 商品上传的目录位置
     * @var string
     */
    protected $root_dir = 'goodslib/';

    public function __construct($goods_id, $product_id = 0, $fileinfo = null)
    {
        parent::__construct($goods_id, $product_id, $fileinfo);


        $this->image_format = new GoodsImageFormatted($this, $this->root_dir);
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

        //存入数据库中
        $model = GoodslibModel::where('goods_id', $this->goods_id)->select('goods_id', 'original_img', 'goods_img', 'goods_thumb')->first();
        if (! empty($model)) {
            $this->clearOldImage($model);

            /* 不保留商品原图的时候删除原图 */
            if (! ecjia::config('retain_original_img') && !empty($original_path)) {
                $this->disk->delete($original_path);
                $original_path = '';
            }

            $model->original_img = $original_path;
            $model->goods_img = $img_path;
            $model->goods_thumb = $thumb_path;
            $model->save();
        }

        /* 复制一份相册图片 */
        /* 添加判断是否自动生成相册图片 */
        if (ecjia::config('auto_generate_gallery')) {
            $data = (new GoodsGallery($this->goods_id, $this->product_id, $this->fileinfo))->updateToDatabase($img_desc);
            if (is_ecjia_error($data)) {
                //复制失败不中断请求
                ecjia_log_warning('商品相册复制失败', $data, 'goods');
            }
        }

        return true;
    }

    /**
     * 清理旧图片
     * @param GoodslibModel $model
     */
    protected function clearOldImage($model)
    {
        /* 先存储新的图片，再删除原来的图片 */
        if ($model['goods_thumb']) {
            $this->disk->delete($model['goods_thumb']);
        }

        if ($model['goods_img']) {
            $this->disk->delete($model['goods_img']);
        }

        if ($model['original_img']) {
            $this->disk->delete($model['original_img']);
        }
    }

}
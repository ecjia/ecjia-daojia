<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 09:27
 */

namespace Ecjia\App\Goods\GoodsImage\Goods;


use Ecjia\App\Goods\GoodsImage\Format\GoodsImageFormatted;
use Ecjia\App\Goods\GoodsImage\GoodsImageFormattedInterface;
use Ecjia\App\Goods\Models\GoodsModel;
use ecjia;
use ecjia_error;
use Ecjia\App\Goods\GoodsImage\StorageDisk;

class GoodsImage implements GoodsImageFormattedInterface
{
    /**
     * @var int goods_id
     */
    protected $goods_id;

    /**
     * @var int product_id
     */
    protected $product_id;

    /**
     * @var array 上传成功后的信息
     */
    protected $fileinfo;

    /**
     * @var GoodsImageFormatted
     */
    protected $image_format;


    protected $disk;

    /**
     * 设置是否自动生成缩略图
     * @var bool
     */
    protected $auto_generate_thumb = false;


    public function __construct($goods_id, $product_id = 0, $fileinfo = null)
    {
        $this->goods_id = $goods_id;

        $this->product_id = $product_id;

        $this->fileinfo = $fileinfo;

        $this->image_format = new GoodsImageFormatted($this);

        $this->disk = new StorageDisk();
    }

    /**
     * 获取商品ID
     * @return int
     */
    public function getGoodsId()
    {
        return $this->goods_id;
    }

    /**
     * 获取货品ID
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * 获取上传文件的扩展名
     * @return string
     */
    public function getExtensionName()
    {
        return $this->fileinfo['ext'];
    }

    /**
     * 获取上传文件的原始文件名
     * @return string
     */
    public function getFileName()
    {
        return $this->fileinfo['name'];
    }

    /**
     * 获取上传后的文件原始路径
     * @return string
     */
    public function getFilePath()
    {
        return $this->fileinfo['tmpname'];
    }

    /**
     *  保存图片到磁盘
     */
    public function saveImageToDisk()
    {
        /* 重新格式化图片名称 */
        $img_path = $this->image_format->getGoodsimgPostion();
        $original_path = $this->image_format->getSourcePostion();

        // 生成缩略图
        $thumb_path = '';
        if ($this->auto_generate_thumb) {
            $thumb_path = $this->saveThumbImageToDisk();
        }

        // 添加水印
        $this->disk->addWatermark($this->getFilePath(), $img_path, null, null, null, $this->getExtensionName());

        // 保存原图
        $this->disk->writeForSourcePath($this->getFilePath(), $original_path);

        //返回 [原图，处理过的图片，缩略图]
        return [$original_path, $img_path, $thumb_path];
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
        $model = GoodsModel::where('goods_id', $this->goods_id)->select('goods_id', 'original_img', 'goods_img', 'goods_thumb')->first();
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
     * @param GoodsModel $model
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

    /**
     * 保存缩略图到磁盘
     * 返回缩略图路径
     * @return string
     */
    public function saveThumbImageToDisk()
    {
        $thumb_path = $this->image_format->getThumbPostion();

        $this->disk->makeThumb($this->getFilePath(), $thumb_path, null, null, $this->getExtensionName());

        return $thumb_path;
    }

    /**
     * 设置是否需要自动生成缩略图，默认为自动生成缩略图
     * @param bool $bool
     */
    public function setAutoGenerateThumb($bool)
    {
        if (is_bool($bool)) {
            $this->auto_generate_thumb = $bool;
        }
    }

}
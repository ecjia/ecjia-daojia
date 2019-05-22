<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 15:34
 */

namespace Ecjia\App\Goods\GoodsImage;

use RC_Storage;
use RC_Image;

class StorageDisk
{
    /**
     * @var \Royalcms\Component\Contracts\Filesystem\Filesystem | \Royalcms\Component\Storage\Contracts\StorageInterface
     */
    protected $disk;

    public function __construct()
    {
        $this->disk = RC_Storage::disk();
    }

    /**
     * 写入文件
     */
    public function wirte($path, $content)
    {
        return $this->disk->write($path, $content);
    }

    /**
     * 写入文件，来自源文件
     * @param $source_path
     * @param $path
     */
    public function writeForSourcePath($source_path, $path)
    {
        $content = file_get_contents($source_path);
        $this->wirte($path, $content);
    }

    /**
     * 删除文件，传上传目录的相对文件
     */
    public function delete($path)
    {
        return $this->disk->delete($path);
    }

    /**
     * 删除文件，传本地文件绝对路径
     */
    public function deletePath($path)
    {
        return $this->disk->delete($path);
    }

    /**
     * 创建图片的缩略图
     *
     * @param string $img 原始图片的路径
     * @param string $thumbname 生成图片的文件名
     * @param int $thumb_width 缩略图宽度
     * @param int $thumb_height 缩略图高度
     * @return mixed 如果成功返回缩略图的路径，失败则返回false
     */
    public function makeThumb($path, $thumb_img, $thumb_width = 0, $thumb_height = 0, $extension = null)
    {
        $makeThumb = new MakeGoodsThumbImage($path, $extension);

        if ($thumb_width && $thumb_height) {
            $makeThumb->setSize($thumb_width, $thumb_height);
        }

        $data = $makeThumb->make();

        $this->wirte($thumb_img, $data);
    }

    /**
     * 为图片增加水印
     *
     * @param       string      $path            原始图片文件名，包含完整路径
     * @param       string      $newpath         加水印后的图片文件名，包含完整路径。如果为空则覆盖源文件
     * @param       string      $watermark          水印图片的完整路径
     * @param       int         $watermark_place    水印位置代码 0 无，默认；1 左上，2 右上，3 居中，4 左下，5 右下
     * @return      mixed       如果成功则返回文件路径，否则返回false
     */
    public function addWatermark($path, $newpath, $watermark = null, $watermark_place = null, $watermark_alpha = 0.65, $extension = null)
    {
        $makeWatermark = new MakeGoodsWatermarkImage($path, $extension);

        if ($watermark) {
            $makeWatermark->setWatermark($watermark);
        }

        if ($watermark_place) {
            $makeWatermark->setWatermarkPlace($watermark_place);
        }

        if ($watermark_alpha) {
            $makeWatermark->setWatermarkAlpha($watermark_alpha);
        }

        $data = $makeWatermark->make();

        $this->wirte($newpath, $data);
    }

    /**
     * 获取上传图片的绝对路径
     * @param string $path 数据库中存储的地址
     * @return string|boolean
     */
    public function getPath($path)
    {
        return $this->disk->path($path);
    }

    /**
     * 获取上传图片的绝对地址
     * @param string $path 数据库中存储的地址
     * @return string|boolean
     */
    public function getUrl($path)
    {
        return $this->disk->url($path);
    }


}
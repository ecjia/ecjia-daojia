<?php


namespace Ecjia\App\Goods\GoodsImage;

use Ecjia\App\Goods\GoodsImage\Format\GoodsGalleryFormatted;
use Ecjia\App\Goods\GoodsImage\Format\GoodsImageFormatted;
use Ecjia\App\Goods\GoodsImage\Format\ProductGalleryFormatted;
use Ecjia\App\Goods\GoodsImage\Format\ProductImageFormatted;
use RC_File;
use RC_Storage;
use RC_Upload;
use League\Flysystem\FileNotFoundException;

class CopyGoodsImage implements GoodsImageFormattedInterface
{
    protected $goods_id;
    protected $product_id;

    protected $extension_name;

    public function __construct($goods_id, $product_id = 0)
    {
        $this->goods_id = $goods_id;
        $this->product_id = $product_id;
    }


    public function getGoodsId()
    {
        return $this->goods_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getExtensionName()
    {
        return $this->extension_name;
    }

    /**
     * 复制商品图片，三张一起操作
     *
     * @param string $original_path    原图
     * @param string $img_path         商品图片
     * @param string $thumb_path       缩略图片
     *
     * @return []
     */
    public function copyGoodsImage($original_path, $img_path, $thumb_path)
    {
        $this->extension_name = RC_File::extension($original_path);

        $image_format = new GoodsImageFormatted($this);

        return $this->copyImage($image_format, $original_path, $img_path, $thumb_path);
    }

    public function copyGoodsGallery($original_path, $img_path, $thumb_path)
    {
        $this->extension_name = RC_File::extension($original_path);

        $image_format = new GoodsGalleryFormatted($this);

        return $this->copyImage($image_format, $original_path, $img_path, $thumb_path);
    }

    /**
     * 复制商品图片，三张一起操作
     *
     * @param string $original_path    原图
     * @param string $img_path         商品图片
     * @param string $thumb_path       缩略图片
     *
     * @return []
     */
    public function copyProductImage($original_path, $img_path, $thumb_path)
    {
        $this->extension_name = RC_File::extension($original_path);

        $image_format = new ProductImageFormatted($this);

        return $this->copyImage($image_format, $original_path, $img_path, $thumb_path);
    }

    public function copyProductGallery($original_path, $img_path, $thumb_path)
    {
        $this->extension_name = RC_File::extension($original_path);

        $image_format = new ProductGalleryFormatted($this);

        return $this->copyImage($image_format, $original_path, $img_path, $thumb_path);
    }

    /**
     * @param GoodsImageFormatted $image_format
     * @param $original_path
     * @param $img_path
     * @param $thumb_path
     * @return array
     */
    protected function copyImage($image_format, $original_path, $img_path, $thumb_path)
    {
        $new_original_path = $image_format->getSourcePostion();
        $new_img_path = $image_format->getGoodsimgPostion();
        $new_thumb_path = $image_format->getThumbPostion();

        $disk = RC_Storage::disk();

        if (!empty($original_path)) {
            try {
                $disk->copy($original_path, $new_original_path);
            }
            catch (FileNotFoundException $e) {
                $new_original_path = '';
                ecjia_log_warning($e->getMessage());
            }
        } else {
            $new_original_path = '';
        }

        if (!empty($img_path)) {
            try {
                $disk->copy($original_path, $new_img_path);
            }
            catch (FileNotFoundException $e) {
                $new_img_path = '';
                ecjia_log_warning($e->getMessage());
            }
        } else {
            $new_img_path = '';
        }

        if (!empty($thumb_path)) {
            try {
                $disk->copy($original_path, $new_thumb_path);
            }
            catch (FileNotFoundException $e) {
                $new_thumb_path = '';
                ecjia_log_warning($e->getMessage());
            }
        } else {
            $new_thumb_path = '';
        }

        return [$new_original_path, $new_img_path, $new_thumb_path];
    }

    /**
     * 群发消息 内容上传图片（不是封面上传）
     * @param  string $content
     * @return
     */
    public static function copyDescriptionContentImages($content)
    {

        $content = rc_stripslashes($content);
        $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png|\.bmp|\.jpeg]))[\'|\"].*?[\/]?>/";
        preg_match_all($pattern, $content, $match);

        $images = $match[1];

        $disk = RC_Storage::disk();

        if (count($images) > 0) {
            foreach ($images as $img) {
                if (strpos($img, RC_Upload::upload_url()) !== false) {

                    $filename = str_replace(RC_Upload::upload_url(), rtrim(RC_Upload::upload_path(), '/'), $img);

                    $newname = self::generateNewFileName($filename);

                    try {
                        if ($disk->copy($filename, $newname)) {

                            $replace = RC_Upload::upload_url($newname);

                            $content = str_replace($img, $replace, $content);
                        }
                    }
                    catch (FileNotFoundException $e) {
                        ecjia_log_warning($e->getMessage());
                    }

                }
            }
        }
        return $content;
    }

    /**
     * 生成新的文件名
     * @param $path
     * @return string
     */
    public static function generateNewFileName($path)
    {
        $newpath = dirname(dirname($path));
        $filename = basename($path);
        $extname = RC_File::extension($filename);

        $new_filename = RC_Upload::random_filename() . ".{$extname}";

        $newpath = $newpath . date('Ymd') . '/' . $new_filename;

        return $newpath;
    }

}
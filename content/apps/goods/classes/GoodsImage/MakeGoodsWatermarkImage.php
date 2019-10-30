<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-06
 * Time: 18:36
 */

namespace Ecjia\App\Goods\GoodsImage;

use phpseclib\Crypt\Base;
use RC_Image;
use RC_File;
use ecjia;
use ecjia_error;

class MakeGoodsWatermarkImage
{
    protected $path;

    /**
     * @var string
     */
    protected $watermark_place;

    /**
     * @var float 水印文件透明度
     */
    protected $watermark_alpha;

    /**
     * @var string 水印文件路径
     */
    protected $watermark;

    protected $image_width;

    protected $image_height;

    public function __construct($path, $extension = null)
    {
        $this->path = $path;
        $this->extension = $extension;

        $this->watermark = ecjia::config('watermark');
        $this->watermark_place = ecjia::config('watermark_place');
        $this->watermark_alpha = ecjia::config('watermark_alpha');

        $this->image_width = ecjia::config('image_width');
        $this->image_height = ecjia::config('image_height');
    }

    public function getExtension()
    {
        if (is_null($this->extension)) {
            $ext = pathinfo($this->path, PATHINFO_EXTENSION);
            if ($ext) {
                $this->extension = $ext;
            } else {
                $this->extension = 'jpg';
            }
        }

        return $this->extension;
    }

    public function setWatermark($watermark)
    {
        $this->watermark = $watermark;

        return $this;
    }

    public function setWatermarkAlpha($watermark_alpha)
    {
        $this->watermark_alpha = $watermark_alpha * 100;

        return $this;
    }

    public function setWatermarkPlace($watermark_place)
    {
        /**
         * top-left (default) 1
         * top
         * top-right 2
         * left
         * center 3
         * right
         * bottom-left 4
         * bottom
         * bottom-right 5
         */

        switch ($watermark_place) {
            case 0:
            case 1:
                $place = 'top-left';
                break;

            case 2:
                $place = 'top-left';
                break;

            case 3:
                $place = 'center';
                break;

            case 4:
                $place = 'bottom-left';
                break;

            case 5:
                $place = 'bottom-right';
                break;

            default:
                $place = 'bottom-right';
        }

        $this->watermark_place = $place;

        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     */
    public function setSize($width, $height)
    {
        $this->image_width = $width;
        $this->image_height = $height;

        return $this;
    }


    /**
     * 生成
     */
    public function make()
    {
        $image = RC_Image::make($this->path);

        if(! empty($this->watermark))
        {
            $this->watermark = \RC_Upload::upload_path($this->watermark);
        }

        //缩略图片大小
        $image->resize($this->image_width, $this->image_height, function ($constraint) {
            $constraint->upsize();
        });

        if (!empty($this->watermark)) {

            // 插入水印, 水印位置在原图片的右下角
            $watermark = RC_Image::make($this->watermark)->opacity($this->watermark_alpha);

            $image->insert($watermark, $this->watermark_place);
        }

        $data = $image->encode($this->getExtension(), 90);

        return $data->getEncoded();
    }


}
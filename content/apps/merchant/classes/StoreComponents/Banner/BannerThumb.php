<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/21
 * Time: 11:12
 */

namespace Ecjia\App\Merchant\StoreComponents\Banner;

use RC_Upload;
use RC_Image;
use RC_Storage;
use RC_File;

class BannerThumb
{

    protected $suffix = '_thumb';

    protected $store_id;

    protected $store_banner;

    /**
     * 缩略图宽度
     * @var int
     */
    protected $thumb_width = 450;

    /**
     * 缩略图高度
     * @var int
     */
    protected $thumb_height = 150;

    public function __construct($banner)
    {
        $banner = str_replace(RC_Upload::upload_url(), '', $banner);
        $this->store_banner = $banner;
    }

    /**
     * 获取店铺Banner的图片路径
     */
    public function getStoreBannerPath()
    {
        return RC_Upload::upload_path($this->store_banner);
    }

    /**
     * 获取店铺Banner的图片URL
     */
    public function getStoreBannerUrl()
    {
        return RC_Upload::upload_url($this->store_banner);
    }

    /**
     * 获取店铺Banner的缩略图的图片路径
     */
    public function hasStoreBannerThumbPath()
    {
        if (RC_Storage::disk()->exists($this->getStoreBannerThumbPath())) {
            return true;
        }
        return false;
    }

    /**
     * 获取店铺Banner的缩略图的图片路径
     */
    public function getStoreBannerThumbPath()
    {
        if (empty($this->transformBannerThumbFileName())) {
            return $this->transformBannerThumbFileName();
        }
        return RC_Upload::upload_path($this->transformBannerThumbFileName());
    }

    /**
     * 获取店铺Banner的缩略图的图片URL
     */
    public function getStoreBannerThumbUrl()
    {
        if (! RC_Storage::disk()->exists($this->getStoreBannerThumbPath())) {
            return $this->getStoreBannerUrl();
        }
        return RC_Upload::upload_url($this->transformBannerThumbFileName());
    }

    /**
     * 转换缩略图文件名
     *
     * @return string
     */
    protected function transformBannerThumbFileName()
    {
        if (empty($this->store_banner)) {
            return null;
        }
        return str_replace('.', $this->suffix . '.', $this->store_banner);
    }

    /**
     * 创建缩略图文件
     */
    public function createBannerThumbFile()
    {
        $path = ltrim($this->getStoreBannerPath(), '/');
        if (RC_Storage::disk()->exists($path)) {
            $content = RC_Storage::disk()->read($path);
            $img = RC_Image::make($content);
            
            $img->resize($this->thumb_width, $this->thumb_height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $content = $img->encode(RC_File::extension($path));

            $content = $content->getEncoded();

            //上传临时文件到指定目录
            RC_Storage::disk()->write($this->transformBannerThumbFileName(), $content);
        }

        return $this;
    }


    public function removeBannerThumbFile()
    {
        if (RC_Storage::disk()->exists($this->transformBannerThumbFileName())) {
            return RC_Storage::disk()->delete($this->transformBannerThumbFileName());
        }

        return false;
    }


    /**
     * 生成临时文件路径
     * @return string
     */
    protected function getTempPath()
    {
        $tempDir = storage_path() . '/temp/merchant_banners/';
        if (!RC_File::exists($tempDir)) {
            RC_File::makeDirectory($tempDir, 0777, true);
        }

        $tmpfname = tempnam($tempDir, 'thumb_');
        return $tmpfname;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/28
 * Time: 13:58
 */

namespace Royalcms\Component\Upload\Uploader;

/**
 * 常用图片文件上传类
 * Class ImageUploader
 * @package Royalcms\Component\Upload
 */
class NewImageUploader extends NewUploader
{

    /**
     * 默认上传文件扩展类型
     * @var array
     */
    protected $default_filetypes = array(
        'jpg'  => 'image/jpg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'bmp'  => 'image/bmp',
        'wbmp' => 'image/vnd.wap.wbmp',
        'svg'  => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
    );


    /**
     * 设置上传配置选项
     */
    protected function settingUploadConfig()
    {
        $file_ext = array_keys($this->default_filetypes);
        $this->allowed_type($file_ext);

        $file_mime = array_values($this->default_filetypes);
        $this->allowed_mime($file_mime);
    }





}
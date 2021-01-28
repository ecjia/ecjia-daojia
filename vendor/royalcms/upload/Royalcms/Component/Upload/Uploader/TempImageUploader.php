<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/28
 * Time: 13:58
 */

namespace Royalcms\Component\Upload\Uploader;

use Royalcms\Component\Upload\Process\NewUploadProcess;

/**
 * 常用图片文件上传类
 * Class ImageUploader
 * @package Royalcms\Component\Upload
 */
class TempImageUploader extends NewImageUploader
{

    /**
     * 上传单个文件
     *
     * @param array $file 文件
     * @return array|bool 上传成功后的文件信息
     */
    public function upload($file, $callback = null)
    {
        if (empty($file)) {
            $this->add_error('not_found_file', __('没有上传的文件！', 'royalcms-upload'));
            return false;
        }

        $file['test'] = true;
        $info = (new NewUploadProcess($this))->upload($file, $callback);

        return empty($info) ? false : $info;
    }

    /**
     * 批量上传文件
     *
     * @param array $files 文件名称数组
     */
    public function batchUpload(array $files, $callback = null)
    {
        if (empty($files)) {
            $this->add_error('not_found_file', __('没有上传的文件！', 'royalcms-upload'));
            return false;
        }

        /* 逐个检测并上传文件 */
        $info = array();

        // 验证文件
        foreach ($files as $key => $file) {
            $file['test'] = true;
            $info[$key] = (new NewUploadProcess($this))->upload($file, $callback);
        }

        return empty($info) ? false : $info;
    }

}
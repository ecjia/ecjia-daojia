<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/28
 * Time: 15:13
 */

namespace Royalcms\Component\Upload\Uploader;

use Royalcms\Component\Upload\Process\NewUploadProcess;

class NewUploader extends Uploader
{

    protected $uploader;

    public function __construct(array $config = array())
    {
        parent::__construct($config);

        $this->uploader = royalcms('uploader');
    }

    /**
     * 上传单个文件
     *
     * @param string $file 文件
     * @return array|bool 上传成功后的文件信息
     */
    public function upload($file, $callback = null)
    {

        if (! $this->getRequest()->hasFile($file)) {
            $this->add_error('not_found_file', __('没有上传的文件！', 'royalcms'));
            return false;
        }

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
            $this->add_error('not_found_file', __('没有上传的文件！', 'royalcms'));
            return false;
        }

        /* 逐个检测并上传文件 */
        $info = array();

        // 验证文件
        foreach ($files as $file) {
            $info[$file] = (new NewUploadProcess($this))->upload($file, $callback);
        }

        return empty($info) ? false : $info;
    }


    /**
     * @see NewUploader::batchUpload()
     * @deprecated 5.6.0
     * @param null $files
     * @return array|bool
     */
    public function batch_upload($files = null)
    {
        $files = array_keys($_FILES);

        return $this->batchUpload($files);
    }

}
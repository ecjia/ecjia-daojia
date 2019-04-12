<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/30
 * Time: 17:21
 */

namespace Royalcms\Component\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class UploadProcessAbstract
{

    /**
     * @var \Royalcms\Component\Upload\Uploader\Uploader
     */
    protected $uploader;

    /**
     * NewUploadProcess constructor.
     * @param $uploader
     */
    public function __construct($uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * 返回UploadedFile对象
     * @param $file string|array|UploadedFile
     * @return UploadedFile
     */
    public function getUploadFile($file)
    {
        if ($file instanceof UploadedFile) {
            $upload_file = $file;
        }
        elseif (is_array($file) && isset($file['name'])) {
            $upload_file = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['size'], $file['error'], $file['test']);
        }
        else {
            $upload_file = $this->uploader->getRequest()->file($file);
        }

        return $upload_file;
    }


    /**
     * 单个文件上传
     * @param string|UploadedFile $file $_FILES的key或UploadedFile
     * @return bool|array
     */
    abstract public function upload($file, $callback = null);

}
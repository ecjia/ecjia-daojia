<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/28
 * Time: 14:39
 */

namespace Royalcms\Component\Upload\Process;

use RC_Format;
use RC_Uploader;
use Royalcms\Component\Upload\UploadProcessAbstract;
use Royalcms\Component\Upload\UploadResult;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NewUploadProcess extends UploadProcessAbstract
{

    /**
     * 单个文件上传
     * @param string|UploadedFile $file $_FILES的key或UploadedFile
     * @return bool|array
     */
    public function upload($file, $callback = null)
    {
        $upload_file = $this->getUploadFile($file);

        /* 文件上传检测 */
        if (! $this->uploader->checkedUploadFile($upload_file)) {
            return false;
        }

        $name     = $upload_file->getClientOriginalName();

        /* 获取上传文件后缀，允许上传无后缀文件 */
        $ext      = $upload_file->getClientOriginalExtension();
        $tmp_name = $upload_file->getRealPath();

        /* 生成保存文件名 */
        $savename = $this->uploader->generateFilename($name, '');
        if (empty($savename)) {
            return false;
        }

        /* 检测并创建子目录 */
        $subpath = $this->uploader->generateSubDirname($name);
        if (false !== $subpath) {
            $save_path = RC_Format::path_join(ltrim($this->uploader->save_path, '/'), $subpath);
        } else {
            $save_path = $this->uploader->save_path;
        }

        $result = new UploadResult();
        $result->setType($upload_file->getClientMimeType())->setSize($upload_file->getClientSize());
        $result->setName($name)->setSavePath($save_path);
        $result->setTmpName($tmp_name);

        if (! empty($ext)) {
            $result->setExtension($ext)->setSaveName($savename.'.'.$ext);
        }

        /* 获取文件hash */
        if ($this->uploader->hash) {
            $result->setHashMd5(md5_file($tmp_name))->setHashSha1(sha1_file($tmp_name));
        }

        $fileinfo = $result->toCompatibleArray();

        $filename = RC_Uploader::fromUpload()->toFolder($this->uploader->save_path)
            ->setReplace($this->uploader->replace)
            ->setUploadSaveCallback(function ($provider, $filename) use ($fileinfo) {

                $saving_callback = $this->uploader->getUploadSavingCallback();

                return $saving_callback($fileinfo, $filename);
            })
            ->renameTo($savename)
            ->upload($upload_file, $callback);

        if ($filename) {

            $this->uploader->uploadedSuccessProcess($fileinfo);

            return $fileinfo;
        }

        return false;
    }


}
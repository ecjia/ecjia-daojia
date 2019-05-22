<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/28
 * Time: 14:39
 */

namespace Royalcms\Component\Upload\Process;

use BadMethodCallException;
use RC_Format;
use RC_Uploader;
use Royalcms\Component\Upload\Events\UploadFileSucceeded;
use Royalcms\Component\Upload\UploadProcessAbstract;
use Royalcms\Component\Upload\UploadResult;
use Royalcms\Component\Uploader\InvalidFileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NewUploadProcess extends UploadProcessAbstract
{

    /**
     * 单个文件上传
     * @param array|string|UploadedFile $file $_FILES的key或UploadedFile
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

        $filename = $this->uploader($result, $upload_file, $callback);

        if ($filename) {

            $this->uploader->uploadedSuccessProcess($fileinfo);

            event(new UploadFileSucceeded($result));

            return $fileinfo;
        } else {
            return false;
        }

    }

    /**
     * @param UploadResult $result
     * @param UploadedFile $upload_file
     * @param null $callback
     * @return mixed
     */
    protected function uploader(UploadResult $result, UploadedFile $upload_file, $callback = null)
    {
        $fileinfo = $result->toCompatibleArray();
        $savename = $result->getSaveNameWithOutExtension();

        try {
            $uploader = RC_Uploader::fromUpload()->toFolder($this->uploader->save_path)
                ->setReplace($this->uploader->replace)
                ->renameTo($savename);

            if ($this->uploader->getUploadSavingCallback()) {
                $uploader->setUploadSavingCallback(function ($provider, $filename) use ($fileinfo) {

                    $saving_callback = $this->uploader->getUploadSavingCallback();

                    return call_user_func($saving_callback, $fileinfo, $filename);
                });
            }

            $filename = $uploader->upload($upload_file, $callback);

            if ($filename === false) {
                $this->uploader->add_error('file_upload_saving_error', __('写入文件失败！', 'royalcms-upload'));
                return false;
            }

            return $filename;
        }
        catch (InvalidFileException $e) {
            $this->uploader->add_error('file_upload_saving_error', $e->getMessage());
            return false;
        }
        catch (BadMethodCallException $e) {
            $this->uploader->add_error('file_upload_saving_error', $e->getMessage());
            return false;
        }

    }


}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/28
 * Time: 14:39
 */

namespace Royalcms\Component\Upload\Process;

use RC_Format;
use Royalcms\Component\Upload\Uploader\Uploader;
use Royalcms\Component\Upload\UploadProcessAbstract;
use Royalcms\Component\Upload\UploadResult;

class UploadProcess extends UploadProcessAbstract
{

    public function __construct(Uploader $uploader)
    {
        parent::__construct($uploader);
    }

    /**
     * 单个文件上传
     * @param array $file
     * @return bool|array
     */
    public function upload($file, $callback = null)
    {
        $upload_file = $this->getUploadFile($file);

        /* 文件上传检测 */
        if (!$this->uploader->checkedUploadFile($upload_file)) {
            return false;
        }

        $name     = $upload_file->getClientOriginalName();

        /* 获取上传文件后缀，允许上传无后缀文件 */
        $ext      = $upload_file->getClientOriginalExtension();
        $tmp_name = $upload_file->getRealPath();

        /* 生成保存文件名 */
        $savename = $this->uploader->generateFilename($name, '');
        if (false == $savename) {
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

        /* 保存文件 并记录保存成功的文件 */
        $fileinfo = $result->toCompatibleArray();
        if ($this->save($fileinfo, $this->uploader->replace)) {

            $this->uploader->uploadedSuccessProcess($fileinfo);

            return $fileinfo;
        } else {
            return false;
        }

    }

    /**
     * Get the full filename.
     *
     * @param  \Royalcms\Component\Uploader\Contracts\Provider  $provider
     * @return string
     */
    protected function getFullFileName($file)
    {
        $filename = RC_Format::path_join(RC_Format::trailingslashit($this->uploader->root_path) . ltrim($file['savepath'], '/'), $file['savename']);

        return $filename;
    }

    /**
     * 保存指定文件
     *
     * @param array $file 保存的文件信息
     * @param boolean $replace 同名文件是否覆盖
     * @return boolean 保存状态，true-成功，false-失败
     */
    protected function save($file, $replace = true)
    {
        $filename = $this->getFullFileName($file);

        /* 不覆盖同名文件 */
        if (! $replace) {
            if ($this->uploader->getStorageDisk()->exists($filename)) {
                $this->uploader->add_error('a_file_with_the_same_name', sprintf(__('存在同名文件%s', 'royalcms-upload'), $file['savename']));
                return false;
            }
        }

        /* 判断目录是否存在，不存在就创建 */
        if (!$this->uploader->getStorageDisk()->is_dir(dirname($filename))) {
            $this->uploader->getStorageDisk()->mkdir(dirname($filename));
        }

        /* 移动文件 */
        if (is_callable($this->uploader->getUploadSavingCallback())) {

            $saving_callback = $this->uploader->getUploadSavingCallback();

            return $saving_callback($file, $filename);
        }
        else {

            if (! $this->uploader->getStorageDisk()->move_uploaded_file($file['tmpname'], $filename)) {
                $this->uploader->add_error('file_upload_saving_error', __('文件上传保存错误！', 'royalcms-upload'));
                return false;
            }

            return true;

        }
    }


}
<?php

namespace Royalcms\Component\Upload\Uploader;

use RC_Format;
use RC_Storage;
use Royalcms\Component\Upload\UploaderAbstract;
use Royalcms\Component\Upload\Facades\Upload;
use Royalcms\Component\Upload\Process\UploadProcess;
use Royalcms\Component\Upload\Process\NewUploadProcess;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Royalcms\Component\Http\Request;

/**
 * 通用文件上传类
 * Class Uploader
 * @package Royalcms\Component\Upload
 */
class Uploader extends UploaderAbstract
{
    /**
     * 生成文件名回调函数
     * @var callable
     */
    protected $filename_callback;

    /**
     * 生成子目录名回调函数
     * @var callable
     */
    protected $sub_dirname_callback;

    /**
     * 上传成功后的回调函数
     * @var callable
     */
    protected $upload_success_callback;

    /**
     * 上传后保存的回调函数
     * @var callable
     */
    protected $upload_saving_callback;

    /**
     * 默认上传文件扩展类型
     * @var array
     */
    protected $default_filetypes = array();

    /**
     * The HTTP Request instance.
     *
     * @var \Royalcms\Component\Http\Request
     */
    protected $request;

    /**
     * 构造方法，用于构造上传实例
     *
     * @param array $config 配置
     * @param string $driver 要使用的上传驱动 LOCAL-本地上传驱动，FTP-FTP上传驱动
     */
    public function __construct()
    {
        parent::__construct();

        $this->options['root_path'] = Upload::upload_path();

        $this->options['max_size'] = config('upload.max_size');

        $this->settingUploadConfig();
    }

    /**
     * @param \Royalcms\Component\Http\Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Royalcms\Component\Http\Request
     */
    public function getRequest()
    {
        if (is_null($this->request)) {
            $this->request = royalcms('request');
        }

        return $this->request;
    }

    /**
     * 设置上传配置选项
     */
    protected function settingUploadConfig()
    {
        $default_file_types = config('upload.default_file_types');

        $file_ext = array_keys($default_file_types);
        $this->allowed_type($file_ext);

        $file_mime = array_values($default_file_types);
        $this->allowed_mime($file_mime);

        /* 调整配置，把字符串配置参数转换为数组 */
        if (!empty($this->mimes)) {
            $this->mimes = array_map('strtolower', $this->mimes);
        }

        if (!empty($this->exts)) {
            $this->exts = array_map('strtolower', $this->exts);
        }
    }

    /**
     * 上传单个文件
     *
     * @param array|string $file 文件数组
     * @return array|bool 上传成功后的文件信息
     */
    public function upload($file, $callback = null)
    {
        if (empty($file)) {
            $this->add_error('not_found_file', __('没有上传的文件！', 'royalcms-upload'));
            return false;
        }

        $file = $this->fixPhpFilesArray($file);

        if (isset($file['name'])) {
            $info = (new UploadProcess($this))->upload($file, $callback);
        }
        else {
            $info = $this->batchUpload($file, $callback);
        }

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

        $files = $this->fixPhpFilesArray($files);

        // 验证文件
        foreach ($files as $key => $file) {
            $info[$key] = (new UploadProcess($this))->upload($file, $callback);
        }

        return empty($info) ? false : $info;
    }

    /**
     * @param $file \Symfony\Component\HttpFoundation\File\UploadedFile
     * @return bool
     */
    public function checkedUploadFile($upload_file)
    {
        if (! ($upload_file instanceof UploadedFile)) {
            $this->add_error('not_found_file', __('没有上传的文件！', 'royalcms-upload'));
            return false;
        }

        /* 检查是否合法上传 */
        if (! $upload_file->isValid()) {
            $this->add_error('is_uploaded_file_by_tmp_name', __('非法上传文件！', 'royalcms-upload'));
            return false;
        }

        /* 检查文件大小 */
        if (! $this->check_size($upload_file->getClientSize())) {
            $this->add_error('upload_file_size_not_match', __('上传文件大小不符！', 'royalcms-upload'));
            return false;
        }

        /* 检查文件Mime类型 */
        if (! $this->check_mime($upload_file->getClientMimeType())) {
            $this->add_error('upload_file_mime_not_match', __('上传文件MIME类型不允许！', 'royalcms-upload'));
            return false;
        }


        /* 获取上传文件后缀，允许上传无后缀文件 */
        /* 检查文件后缀 */
        if (! $this->check_ext($upload_file->getClientOriginalExtension())) {
            $this->add_error('upload_file_ext_not_match', __('上传文件后缀不允许！', 'royalcms-upload'));
            return false;
        }

        /* 通过检测 */
        return true;
    }


    /**
     * 批量上传文件
     *
     * @param array $_FILES 文件名称数组
     * @param \callback $callback
     */
    public function multiUpload($files = null, $callback = null)
    {
        if (is_null($files)) {
            $files = $_FILES;
        }

        foreach ($files as $key => $file) {
            $info[$key] = $this->batchUpload($file);
        }

        return empty($info) ? false : $info;
    }

    /**
     * 批量上传文件
     *
     * @param array $_FILES 文件名称数组
     * @param \callback $callback
     */
    public function multiUploadByFiles($callback = null)
    {
        $files = $_FILES;

        foreach ($files as $key => $file) {
            $info[$key] = $this->batchUpload($file);
        }

        return empty($info) ? false : $info;
    }

    /**
     * 批量上传文件
     *
     * @see Uploader::batchUpload()
     * @deprecated 5.6.0
     * @param array|bool $files 文件信息数组，通常是 $_FILES数组
     */
    public function batch_upload($files = null)
    {
        if (is_null($files)) {
            $files = $_FILES;
        }

        $count = count($files);

        /* 逐个检测并上传文件 */
        $info = array();

        if ($count === 1) {
            foreach ($files as $key => $file) {
                $info = $this->batchUpload($file);
            }
        } else {
            $info = $this->multiUploadByFiles();
        }

        return empty($info) ? false : $info;
    }

    /**
     * 检查上传的文件
     *
     * @param array $file 文件信息 $_FILES[key]
     * @return bool
     */
    public function check_upload_file($file)
    {
        if ($file instanceof UploadedFile) {
            $upload_file = $file;
        }
        elseif (is_array($file) && isset($file['name'])) {
            $upload_file = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['size'], $file['error']);
        }
        else {
            $upload_file = $this->getRequest()->file($file);
        }

        return $this->checkedUploadFile($upload_file);
    }

    /**
     * 获取指定的文件Path
     *
     * @param  string $key
     * @return mixed
     */
    public function get_position($info, $relative = true)
    {
        $position = RC_Format::trailingslashit($info['savepath']) . $info['savename'];

        if (!$relative) {
            return RC_Format::trailingslashit($this->root_path) . $position;
        } else {
            return $position;
        }
    }

    /**
     * 删除指定文件
     * @param string $file 上传目录的文件相对路径
     */
    public function remove($file)
    {
        $file_path = RC_Format::path_join(RC_Format::trailingslashit($this->root_path), $file);
        return RC_Storage::disk()->delete($file_path);
    }

    /**
     * @var array
     */
    private static $fileKeys = array('error', 'name', 'size', 'tmp_name', 'type');

    /**
     * Fixes a malformed PHP $_FILES array.
     *
     * PHP has a bug that the format of the $_FILES array differs, depending on
     * whether the uploaded file fields had normal field names or array-like
     * field names ("normal" vs. "parent[child]").
     *
     * This method fixes the array to look like the "normal" $_FILES array.
     *
     * It's safe to pass an already converted array, in which case this method
     * just returns the original array unmodified.
     *
     * @param array $data
     *
     * @return array
     */
    protected function fixPhpFilesArray($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $keys = array_keys($data);
        sort($keys);

        if (self::$fileKeys != $keys || !isset($data['name']) || !is_array($data['name'])) {
            return $data;
        }

        $files = $data;
        foreach (self::$fileKeys as $k) {
            unset($files[$k]);
        }

        foreach ($data['name'] as $key => $name) {
            $files[$key] = $this->fixPhpFilesArray(array(
                'error' => $data['error'][$key],
                'name' => $name,
                'type' => $data['type'][$key],
                'tmp_name' => $data['tmp_name'][$key],
                'size' => $data['size'][$key],
            ));
        }

        return $files;
    }

    /**
     * 将上传文件整理为标准数组
     *
     * @param array|null $files
     * @return array
     */
    protected function format_files($files)
    {
        $file_arr = array();
        $n        = 0;
        foreach ($files as $key => $file) {
            if (is_array($file['name'])) {
                $keys  = array_keys($file);
                $count = count($file['name']);
                for ($i = 0; $i < $count; $i++) {
                    $file_arr[$n]['key'] = $key;
                    foreach ($keys as $_key) {
                        $file_arr[$n][$_key] = $file[$_key][$i];
                    }
                    $n++;
                }
            } else {
                $file_arr = $files;
                break;
            }
        }
        return $file_arr;
    }

    /**
     * @param $callback
     */
    public function add_filename_callback($callback)
    {
        if (is_callable($callback)) {
            $this->filename_callback = $callback;
        }
    }

    /**
     * @param $callback
     */
    public function add_sub_dirname_callback($callback)
    {
        if (is_callable($callback)) {
            $this->sub_dirname_callback = $callback;
        }
    }

    /**
     * @param $callback
     */
    public function add_upload_success_callback($callback)
    {
        if (is_callable($callback)) {
            $this->upload_success_callback = $callback;
        }
    }

    /**
     * @param $callback
     */
    public function add_saving_callback($callback)
    {
        if (is_callable($callback)) {
            $this->upload_saving_callback = $callback;
        }
    }

    /**
     * 根据指定的规则获取文件或目录名称
     *
     * @param callable $callback 回调函数，用于生成文件名
     * @param string $filename 原文件名
     * @return string 目录及文件名称
     */
    public function generateFilename($filename, $extname = null)
    {
        if (is_callable($this->filename_callback)) {
            $savename = call_user_func($this->filename_callback, $filename);
        } else {
            /* 解决pathinfo中文文件名BUG */
            $savename = substr(pathinfo("_{$filename}", PATHINFO_FILENAME), 1);
        }

        /* 文件保存后缀，支持强制更改文件后缀 */
        $extname = empty($this->save_ext) ? $extname : $this->save_ext;

        if (empty($extname)) {
            return $savename;
        }

        return $savename . '.' . $extname;
    }

    /**
     * 根据指定的规则生成子目录名称
     *
     * @param callable $callback 回调函数，用于生成文件名
     * @param string $filename 原文件名
     * @return string 目录及文件名称
     */
    public function generateSubDirname($filename)
    {
        if ($this->auto_sub_dirs && is_callable($this->sub_dirname_callback)) {
            return call_user_func($this->sub_dirname_callback, $filename);
        } else {
            return '';
        }
    }

    /**
     * 上传成功后对文件的信息处理
     *
     * @param array $file
     */
    public function uploadedSuccessProcess($file)
    {
        if (is_callable($this->upload_success_callback)) {
            return call_user_func($this->upload_success_callback, $file);
        }

        return false;
    }

    /**
     * 上传后保存的回调函数
     * @return callable
     */
    public function getUploadSavingCallback()
    {
        return $this->upload_saving_callback;
    }

}
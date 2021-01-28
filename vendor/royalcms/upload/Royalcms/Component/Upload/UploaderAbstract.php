<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/28
 * Time: 13:05
 */

namespace Royalcms\Component\Upload;

use Royalcms\Component\Error\Error;
use Royalcms\Component\Contracts\Filesystem\Filesystem as FilesystemContract;

/**
 * 文件上传抽象类
 *
 * @property array $exts 上传文件类型扩展选项
 * @property array $mimes 上传文件类型MIME选项
 * @property integer $max_size 上传的文件大小限制 (0:不做限制)
 * @property string $save_ext 文件保存后缀，空则使用原后缀
 * @property bool $replace 存在同名是否覆盖
 * @property bool $hash 是否生成hash编码
 * @property bool $auto_sub_dirs 自动子目录保存文件
 * @property string $root_path 上传目录根路径
 * @property string $save_path 保存的路径，相对于上传目录的相对路径
 */
abstract class UploaderAbstract
{

    /**
     * @var \Royalcms\Component\Error\Error
     */
    protected $rc_error;

    protected $error_codes = array(
        UPLOAD_ERR_INI_SIZE     => 'upload_err_ini_size',
        UPLOAD_ERR_FORM_SIZE    => 'upload_err_form_size',
        UPLOAD_ERR_PARTIAL      => 'upload_err_partial',
        UPLOAD_ERR_NO_FILE      => 'upload_err_no_file',
        UPLOAD_ERR_NO_TMP_DIR   => 'upload_err_no_tmp_dir',
        UPLOAD_ERR_CANT_WRITE   => 'upload_err_cant_write',
        UPLOAD_ERR_EXTENSION    => 'upload_err_extension',
    );


    /**
     * 默认上传配置
     *
     * @var array
     */
    protected $options = array(
        // 文件保存后缀，空则使用原后缀
        'save_ext'          => null,
        // 存在同名是否覆盖
        'replace'           => false,
        // 是否生成hash编码
        'hash'              => true,
        // 自动子目录保存文件
        'auto_sub_dirs'     => true,
        // 上传的文件大小限制 (0:不做限制)
        'max_size'          => 0,
        // 上传目录根路径
        'root_path'         => null,
        // 保存的路径，相对于上传目录的相对路径
        'save_path'         => null,
        // 允许上传的文件后缀
        'exts'              => array(),
        // 允许上传的文件MiMe类型
        'mimes'             => array(),
    );

    /**
     * 文件存储系统对象
     * @var \Royalcms\Component\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    public function __construct()
    {
        $this->rc_error = new Error();

        $this->disk = \RC_Storage::disk();
    }

    public function __get($name)
    {
        return $this->options[$name];
    }

    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->options[$name]);
    }

    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @param \Royalcms\Component\Contracts\Filesystem\Filesystem $disk
     */
    public function setStorageDisk(FilesystemContract $disk)
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
     */
    public function getStorageDisk()
    {
        return $this->disk;
    }

    /**
     * 获取错误信息，参数为null，返回全部
     * @param null $error
     * @return array|string
     */
    public function getErrorMessages($error = null)
    {
        $errors_message = array(
            UPLOAD_ERR_INI_SIZE     => __('上传文件超过PHP.ini配置文件允许的大小', 'royalcms-upload'),
            UPLOAD_ERR_FORM_SIZE    => __('文件超过表单限制大小', 'royalcms-upload'),
            UPLOAD_ERR_PARTIAL      => __('文件只有部分上传', 'royalcms-upload'),
            UPLOAD_ERR_NO_FILE      => __('没有上传文件', 'royalcms-upload'),
            UPLOAD_ERR_NO_TMP_DIR   => __('没有上传临时文件夹', 'royalcms-upload'),
            UPLOAD_ERR_CANT_WRITE   => __('写入临时文件夹出错', 'royalcms-upload'),
            UPLOAD_ERR_EXTENSION    => __('非法的文件扩展名', 'royalcms-upload'),
        );

        if (is_null($error)) {
            return $errors_message;
        }

        return array_get($errors_message, $error);
    }

    /**
     * 获取转译后的错误代号
     * @param $error
     * @return string
     */
    public function getErrorCode($error)
    {
        return array_get($this->error_codes, $error);
    }

    public function error()
    {
        return $this->rc_error->get_error_message();
    }

    public function add_error($error_code, $error_message)
    {
        $this->rc_error->add($error_code, $error_message);
    }

    public function errors()
    {
        return $this->rc_error;
    }


    /**
     * 设定允许添加的文件类型
     *
     * @param string|array $type （小写）示例：gif,jpg,jpeg,png
     * @return void
     */
    public function allowed_type($type)
    {
        if (is_array($type)) {
            $this->exts = $type;
        } elseif (is_string($type)) {
            $this->exts = explode(',', $type);
        }
    }

    /**
     * 允许的文件MIME类型
     *
     * @param string|array $mime
     */
    public function allowed_mime($mime)
    {
        if (is_array($mime)) {
            $this->mimes = $mime;
        } elseif (is_string($mime)) {
            $this->mimes = explode(',', $mime);
        }
    }

    /**
     * 允许的大小
     *
     * @param mixed $size
     * @return void
     */
    public function allowed_size($size)
    {
        $this->max_size = $size;
    }


    /**
     * 检查上传的文件后缀是否合法
     *
     * @param string $ext 后缀
     */
    public function check_ext($ext)
    {
        return empty($this->exts) ? true : in_array(strtolower($ext), $this->exts);
    }

    /**
     * 检查文件大小是否合法
     *
     * @param integer $size 数据
     */
    public function check_size($size)
    {
        return !($size > $this->max_size) || (0 == $this->max_size);
    }

    /**
     * 检查上传的文件MIME类型是否合法
     *
     * @param string $mime 数据
     */
    public function check_mime($mime)
    {
        return empty($this->mimes) ? true : in_array(strtolower($mime), $this->mimes);
    }


    /**
     * 上传单个文件
     *
     * @param array|string $file 文件数组
     * @return array|bool 上传成功后的文件信息
     */
    abstract public function upload($file);


    /**
     * 批量上传文件
     *
     * @param array $files 文件名称数组
     * @param \callback $callback
     */
    abstract public function batchUpload(array $files, $callback = null);


    /**
     * 批量上传文件
     *
     * @param array $_FILES 文件名称数组
     * @param \callback $callback
     */
    public function multiUploadByFiles($callback = null)
    {
        //...
    }


}
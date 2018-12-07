<?php namespace Royalcms\Component\Upload;

use Royalcms\Component\Error\Error;
use Royalcms\Component\Support\Format;
use RC_Hook;
use RC_Storage;
use Royalcms\Component\Support\Facades\Config;

/**
 * 文件上传抽象类
 */
class Uploader
{
    private $errors;
    
    private $errors_message = array(
        UPLOAD_ERR_INI_SIZE     => '上传文件超过PHP.ini配置文件允许的大小',
        UPLOAD_ERR_FORM_SIZE    => '文件超过表单限制大小',
        UPLOAD_ERR_PARTIAL      => '文件只有部分上传',
        UPLOAD_ERR_NO_FILE      => '没有上传文件',
        UPLOAD_ERR_NO_TMP_DIR   => '没有上传临时文件夹',
        UPLOAD_ERR_CANT_WRITE   => '写入临时文件夹出错',
        UPLOAD_ERR_EXTENSION    => '非法的文件扩展名',
    );
    
    private $errors_code = array(
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
    private $options = array(
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
     * @var $filesystem
     */
    private $filesystem;
    
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
     * 构造方法，用于构造上传实例
     *
     * @param array $config
     *            配置
     * @param string $driver
     *            要使用的上传驱动 LOCAL-本地上传驱动，FTP-FTP上传驱动
     */
    public function __construct($config = array())
    {
        $this->errors = new Error();
        
        $this->options['root_path'] = Upload::upload_path();
        /* 获取配置 */
        $this->options = array_merge($this->options, $config);
        
        $file_ext = Config::get('filesystems.upload.file_ext');
        $file_ext = is_array($file_ext) ? $file_ext : explode(',', $file_ext);
        $file_ext = array_merge(array('jpg', 'jpeg', 'png', 'gif', 'bmp'), $file_ext);
        $this->allowed_type($file_ext);
        
        $file_mime = Config::get('filesystems.upload.file_mime');
        $file_mime = is_array($file_mime) ? $file_mime : explode(',', $file_mime);
        $file_mime = array_merge(array('image/gif', 'image/jpeg', 'image/png', 'image/x-png', 'image/pjpeg'), $file_mime);
        $this->allowed_mime($file_mime);
        
        /* 调整配置，把字符串配置参数转换为数组 */
        if (! empty($this->options['mimes'])) {
            if (is_string($this->mimes)) {
                $this->options['mimes'] = explode(',', $this->mimes);
            }
            $this->options['mimes'] = array_map('strtolower', $this->mimes);
        }
        if (! empty($this->options['exts'])) {
            if (is_string($this->exts)) {
                $this->options['exts'] = explode(',', $this->exts);
            }
            $this->options['exts'] = array_map('strtolower', $this->exts);
        }
        
        $this->options['max_size'] = Config::get('filesystems.upload.max_size');
        
        $this->filesystem = RC_Storage::disk();
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
    
    
    /**
     * 上传单个文件
     *
     * @param array $file
     *            文件数组
     * @return array 上传成功后的文件信息
     */
    public function upload($file)
    {
        if (empty($file)) {
            $this->errors->add('not_found_file', '没有上传的文件！');
            return false;
        }
        
        $info = array();
        
        // 对上传文件数组信息处理
        $files = $this->format_files(array($file));
        
        $info = $this->upload_single($file);
        
        return empty($info) ? false : $info;
    }
    
    /**
     * 批量上传文件
     *
     * @param 文件信息数组 $files，通常是 $_FILES数组
     */
    public function batch_upload($files = null)
    {
        if (null === $files) {
            $files = $_FILES;
        }
    
        if (empty($files)) {
            $this->errors->add('not_found_file', '没有上传的文件！');
            return false;
        }
    
        /* 逐个检测并上传文件 */
        $info = array();
        // 对上传文件数组信息处理
        $files = $this->format_files($files);
        // 验证文件
        foreach ($files as $key => $file) {
            $info[$key] = $this->upload_single($file);
        }
    
        return empty($info) ? false : $info;
    }
    
    /**
     * 检查上传的文件
     *
     * @param array $file
     *            文件信息
     */
    public function check_upload_file($file)
    {
        /* 文件上传失败，捕获错误代码 */
        if ($file['error']) {
            $this->errors->add($this->errors_code[$file['error']], $this->errors_message[$file['error']]);
            return false;
        }
    
        /* 检查是否合法上传 */
        if (empty($file['name']) || ! is_uploaded_file($file['tmp_name'])) {
            $this->errors->add('is_uploaded_file_by_tmp_name', '非法上传文件！');
            return false;
        }
    
        /* 检查文件大小 */
        if (! $this->check_size($file['size'])) {
            $this->errors->add('upload_file_size_not_match', '上传文件大小不符！');
            return false;
        }
    
        /* 检查文件Mime类型 */
        // TODO:FLASH上传的文件获取到的mime类型都为application/octet-stream
        if (! $this->check_mime($file['type'])) {
            $this->errors->add('upload_file_mime_not_match', '上传文件MIME类型不允许！');
            return false;
        }
    
        /* 获取上传文件后缀，允许上传无后缀文件 */
        $file['ext'] = pathinfo($file['name'], PATHINFO_EXTENSION);
        /* 检查文件后缀 */
        if (! $this->check_ext($file['ext'])) {
            $this->errors->add('upload_file_ext_not_match', '上传文件后缀不允许！');
            return false;
        }
    
        /* 通过检测 */
        return true;
    }
    
    /**
     * 设定允许添加的文件类型
     *
     * @author Garbin
     * @param string $type
     *            （小写）示例：gif,jpg,jpeg,png
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
     * @param array $mime
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
     * @author Garbin
     * @param mixed $size
     * @return void
     */
    public function allowed_size($size)
    {
        $this->max_size = $size;
    }
    
    /**
     * 获取指定的文件Path
     *
     * @param  string  $key
     * @return mixed
     */
    public function get_position($info, $relative = true) {
        $position = Format::trailingslashit($info['savepath']) . $info['savename'];
        
        if (! $relative) {
            return Format::trailingslashit($this->root_path) . $position;
        } else {
            return $position;
        }
    }
    
    /**
     * 删除指定文件
     * @param array $file 上传目录的文件相对路径
     */
    public function remove($file) {
        $file_path =  Format::path_join(Format::trailingslashit($this->root_path), $file);
        return $this->filesystem->delete($file_path);
    }
    
    /**
     * 单个文件上传
     * @param array $file
     * @return boolean|string
     */
    protected function upload_single($file) {
        $file['name'] = strip_tags($file['name']);
        
        /* 获取上传文件后缀，允许上传无后缀文件 */
        $file['ext'] = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        /* 文件上传检测 */
        if (! $this->check_upload_file($file)) {
            return false;
        }
        
        /* 获取文件hash */
        if ($this->hash) {
            $file['md5'] = md5_file($file['tmp_name']);
            $file['sha1'] = sha1_file($file['tmp_name']);
        }
        
        /* 生成保存文件名 */
        $savename = $this->generate_filename($file['name'], $file['ext']);
        if (false == $savename) {
            return false;
        } else {
            $file['savename'] = $savename;
        }
        
        /* 检测并创建子目录 */
        $subpath = $this->generate_sub_dirname($file['name']);
        if (false !== $subpath) {
            $file['savepath'] = Format::path_join(ltrim($this->save_path, '/'), $subpath);
        }
        
        $file['tmpname'] = $file['tmp_name'];
        
        /* 保存文件 并记录保存成功的文件 */
        if ($this->save($file, $this->replace)) {
            unset($file['error'], $file['tmp_name']);
            $this->uploaded_success_process($file);
            return $file;
        } else {
            return false;
        }
    }
    
    /**
     * 保存指定文件
     *
     * @param array $file
     *            保存的文件信息
     * @param boolean $replace
     *            同名文件是否覆盖
     * @return boolean 保存状态，true-成功，false-失败
     */
    protected function save($file, $replace = true)
    {
        $filename = Format::path_join(Format::trailingslashit($this->root_path) . ltrim($file['savepath'], '/'), $file['savename']);
    
        /* 不覆盖同名文件 */
        if (! $replace && $this->filesystem->is_file($filename)) {
            $this->errors->add('a_file_with_the_same_name', '存在同名文件' . $file['savename']);
            return false;
        }
    
        /* 判断目录是否存在，不存在就创建 */
        if (! $this->filesystem->is_dir(dirname($filename))) {
            $this->filesystem->mkdir(dirname($filename));
        }
    
        /* 移动文件 */
        if (is_callable($this->upload_saving_callback)) {
            unset($file['error'], $file['tmp_name']);
            $saving_callback = $this->upload_saving_callback;
            return $saving_callback($file, $filename);
        } else {
            if (! $this->filesystem->move_uploaded_file($file['tmp_name'], $filename)) {
                $this->errors->add('file_upload_saving_error', '文件上传保存错误！');
                return false;
            }
            return true;
        }
    }
    
    /**
     * 将上传文件整理为标准数组
     *
     * @param string|null $files
     * @return boolean Ambigous , unknown>
     */
    protected function format_files($files)
    {
        $file_arr = array();
        $n = 0;
        foreach ($files as $key => $file) {
            if (is_array($file['name'])) {
                $keys = array_keys($file);
                $count = count($file['name']);
                for ($i = 0; $i < $count; $i ++) {
                    $file_arr[$n]['key'] = $key;
                    foreach ($keys as $_key) {
                        $file_arr[$n][$_key] = $file[$_key][$i];
                    }
                    $n ++;
                }
            } else {
                $file_arr = $files;
                break;
            }
        }
        return $file_arr;
    }
    
    /**
     * 检查上传的文件后缀是否合法
     *
     * @param string $ext
     *            后缀
     */
    protected function check_ext($ext)
    {
        return empty($this->exts) ? true : in_array(strtolower($ext), $this->exts);
    }
    
    /**
     * 检查文件大小是否合法
     *
     * @param integer $size
     *            数据
     */
    protected function check_size($size)
    {
        return ! ($size > $this->max_size) || (0 == $this->max_size);
    }
    
    /**
     * 检查上传的文件MIME类型是否合法
     *
     * @param string $mime
     *            数据
     */
    protected function check_mime($mime)
    {
        return empty($this->mimes) ? true : in_array(strtolower($mime), $this->mimes);
    }
    
    public function add_filename_callback($callback) {
        if (is_callable($callback)) {
            $this->filename_callback = $callback;
        }
    }
    
    public function add_sub_dirname_callback($callback) {
        if (is_callable($callback)) {
            $this->sub_dirname_callback = $callback;
        }
    }
    
    public function add_upload_success_callback($callback) {
        if (is_callable($callback)) {
            $this->upload_success_callback = $callback;
        }
    }
    
    public function add_saving_callback($callback) {
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
    protected function generate_filename($filename, $extname) {
        if (is_callable($this->filename_callback)) 
        {
            $savename = call_user_func($this->filename_callback, $filename);
        }
        else
        {
            /* 解决pathinfo中文文件名BUG */
            $savename = substr(pathinfo("_{$filename}", PATHINFO_FILENAME), 1);
        }
        
        /* 文件保存后缀，支持强制更改文件后缀 */
        $extname = empty($this->save_ext) ? $extname : $this->save_ext;
        
        return $savename . '.' . $extname;
    }
    
    /**
     * 根据指定的规则生成子目录名称
     *
     * @param callable $callback 回调函数，用于生成文件名
     * @param string $filename 原文件名
     * @return string 目录及文件名称
     */
    protected function generate_sub_dirname($filename) {
        if ($this->auto_sub_dirs && is_callable($this->sub_dirname_callback))
        {
            return call_user_func($this->sub_dirname_callback, $filename);
        }
        else 
        {
            return '';
        }
    }
    
    /**
     * 上传成功后对文件的信息处理
     *
     * @param array $file
     */
    protected function uploaded_success_process($file)
    {
        if (is_callable($this->upload_success_callback)) {
            return call_user_func($this->upload_success_callback, $file);
        }
    
        return false;
    }
   

    /**
     * Handle PHP uploads in WordPress, sanitizing file names, checking extensions for mime type,
     * and moving the file to the appropriate directory within the uploads directory.
     *
     * @since 4.0.0
     *
     * @see rc_handle_upload_error
     *
     * @param array  $file      Reference to a single element of $_FILES. Call the function once for
     *                          each uploaded file.
     * @param array  $overrides An associative array of names => values to override default variables.
     * @param string $time      Time formatted in 'yyyy/mm'.
     * @param string $action    Expected value for $_POST['action'].
     * @return array On success, returns an associative array of file attributes. On failure, returns
     *               $overrides['upload_error_handler'](&$file, $message ) or array( 'error'=>$message ).
     */
    protected function _handle_upload( &$file, $overrides, $time, $action ) {
        // The default error handler.
        if ( ! function_exists( 'rc_handle_upload_error' ) ) {
            function rc_handle_upload_error( &$file, $message ) {
                return array( 'error' => $message );
            }
        }
    
        /**
         * The dynamic portion of the hook name, $action, refers to the post action.
         *
         * @since 2.9.0 as 'wp_handle_upload_prefilter'
         * @since 4.0.0 Converted to a dynamic hook with $action
         *
         * @param array $file An array of data for a single file.
         */
        $file = RC_Hook::apply_filters( "{$action}_prefilter", $file );
    
        // You may define your own function and pass the name in $overrides['upload_error_handler']
        $upload_error_handler = 'wp_handle_upload_error';
        if ( isset( $overrides['upload_error_handler'] ) ) {
            $upload_error_handler = $overrides['upload_error_handler'];
        }
    
        // You may have had one or more 'wp_handle_upload_prefilter' functions error out the file. Handle that gracefully.
        if ( isset( $file['error'] ) && ! is_numeric( $file['error'] ) && $file['error'] ) {
            return $upload_error_handler( $file, $file['error'] );
        }
    
        // Install user overrides. Did we mention that this voids your warranty?
    
        // You may define your own function and pass the name in $overrides['unique_filename_callback']
        $unique_filename_callback = null;
        if ( isset( $overrides['unique_filename_callback'] ) ) {
            $unique_filename_callback = $overrides['unique_filename_callback'];
        }
    
        /*
         * This may not have orignially been intended to be overrideable,
        * but historically has been.
        */
        if ( isset( $overrides['upload_error_strings'] ) ) {
            $upload_error_strings = $overrides['upload_error_strings'];
        } else {
            // Courtesy of php.net, the strings that describe the error indicated in $_FILES[{form field}]['error'].
            $upload_error_strings = array(
                false,
                __( 'The uploaded file exceeds the upload_max_filesize directive in php.ini.' ),
                __( 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.' ),
                __( 'The uploaded file was only partially uploaded.' ),
                __( 'No file was uploaded.' ),
                '',
                __( 'Missing a temporary folder.' ),
                __( 'Failed to write file to disk.' ),
                __( 'File upload stopped by extension.' )
            );
        }
    
        // All tests are on by default. Most can be turned off by $overrides[{test_name}] = false;
        $test_form = isset( $overrides['test_form'] ) ? $overrides['test_form'] : true;
        $test_size = isset( $overrides['test_size'] ) ? $overrides['test_size'] : true;
    
        // If you override this, you must provide $ext and $type!!
        $test_type = isset( $overrides['test_type'] ) ? $overrides['test_type'] : true;
        $mimes = isset( $overrides['mimes'] ) ? $overrides['mimes'] : false;
    
        $test_upload = isset( $overrides['test_upload'] ) ? $overrides['test_upload'] : true;
    
        // A correct form post will pass this test.
        if ( $test_form && ( ! isset( $_POST['action'] ) || ( $_POST['action'] != $action ) ) ) {
            return call_user_func( $upload_error_handler, $file, __( 'Invalid form submission.' ) );
        }
        // A successful upload will pass this test. It makes no sense to override this one.
        if ( isset( $file['error'] ) && $file['error'] > 0 ) {
            return call_user_func( $upload_error_handler, $file, $upload_error_strings[ $file['error'] ] );
        }
    
        $test_file_size = 'wp_handle_upload' === $action ? $file['size'] : filesize( $file['tmp_name'] );
        // A non-empty file will pass this test.
        if ( $test_size && ! ( $test_file_size > 0 ) ) {
            if ( is_multisite() ) {
                $error_msg = __( 'File is empty. Please upload something more substantial.' );
            } else {
                $error_msg = __( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.' );
            }
            return call_user_func( $upload_error_handler, $file, $error_msg );
        }
    
        // A properly uploaded file will pass this test. There should be no reason to override this one.
        $test_uploaded_file = 'wp_handle_upload' === $action ? @ is_uploaded_file( $file['tmp_name'] ) : @ is_file( $file['tmp_name'] );
        if ( $test_upload && ! $test_uploaded_file ) {
            return call_user_func( $upload_error_handler, $file, __( 'Specified file failed upload test.' ) );
        }
    
        // A correct MIME type will pass this test. Override $mimes or use the upload_mimes filter.
        if ( $test_type ) {
            $wp_filetype = wp_check_filetype_and_ext( $file['tmp_name'], $file['name'], $mimes );
            $ext = empty( $wp_filetype['ext'] ) ? '' : $wp_filetype['ext'];
            $type = empty( $wp_filetype['type'] ) ? '' : $wp_filetype['type'];
            $proper_filename = empty( $wp_filetype['proper_filename'] ) ? '' : $wp_filetype['proper_filename'];
    
            // Check to see if wp_check_filetype_and_ext() determined the filename was incorrect
            if ( $proper_filename ) {
                $file['name'] = $proper_filename;
            }
            if ( ( ! $type || !$ext ) && ! current_user_can( 'unfiltered_upload' ) ) {
                return call_user_func( $upload_error_handler, $file, __( 'Sorry, this file type is not permitted for security reasons.' ) );
            }
            if ( ! $type ) {
                $type = $file['type'];
            }
        } else {
            $type = '';
        }
    
        /*
         * A writable uploads dir will pass this test. Again, there's no point
        * overriding this one.
        */
        if ( ! ( ( $uploads = rc_upload_dir( $time ) ) && false === $uploads['error'] ) ) {
            return call_user_func( $upload_error_handler, $file, $uploads['error'] );
        }
    
        $filename = rc_unique_filename( $uploads['path'], $file['name'], $unique_filename_callback );
    
        // Move the file to the uploads dir.
        $new_file = $uploads['path'] . "/$filename";
        if ( 'rc_handle_upload' === $action ) {
            $move_new_file = @ move_uploaded_file( $file['tmp_name'], $new_file );
        } else {
            $move_new_file = @ rename( $file['tmp_name'], $new_file );
        }
    
        if ( false === $move_new_file ) {
            if ( 0 === strpos( $uploads['basedir'], ABSPATH ) ) {
                $error_path = str_replace( ABSPATH, '', $uploads['basedir'] ) . $uploads['subdir'];
            } else {
                $error_path = basename( $uploads['basedir'] ) . $uploads['subdir'];
            }
            return $upload_error_handler( $file, sprintf( __('The uploaded file could not be moved to %s.' ), $error_path ) );
        }
    
        // Set correct file permissions.
        $stat = stat( dirname( $new_file ));
        $perms = $stat['mode'] & 0000666;
        @ chmod( $new_file, $perms );
    
        // Compute the URL.
        $url = $uploads['url'] . "/$filename";
    
        /* @TODO 多站点处理
        if ( is_multisite() ) {
            delete_transient( 'dirsize_cache' );
        }
         * 
         */
    
        /**
         * Filter the data array for the uploaded file.
         *
         * @since 2.1.0
         *
         * @param array  $upload {
         *     Array of upload data.
         *
         *     @type string $file Filename of the newly-uploaded file.
         *     @type string $url  URL of the uploaded file.
         *     @type string $type File type.
         * }
         * @param string $context The type of upload action. Values include 'upload' or 'sideload'.
         */
        return RC_Hook::apply_filters( 'rc_handle_upload', array(
            'file' => $new_file,
            'url'  => $url,
            'type' => $type
        ), 'rc_handle_sideload' === $action ? 'sideload' : 'upload' ); 
    }
    
    /**
     * Wrapper for _handle_upload(), passes 'rc_handle_sideload' action
     *
     * @since 2.6.0
     *
     * @see _handle_upload()
     *
     * @param array      $file      An array similar to that of a PHP $_FILES POST array
     * @param array|bool $overrides Optional. An associative array of names=>values to override default
     *                              variables. Default false.
     * @param string     $time      Optional. Time formatted in 'yyyy/mm'. Default null.
     * @return array On success, returns an associative array of file attributes. On failure, returns
     *               $overrides['upload_error_handler'](&$file, $message ) or array( 'error'=>$message ).
     */
    public function handle_sideload( &$file, $overrides = false, $time = null ) {
        /*
         *  $_POST['action'] must be set and its value must equal $overrides['action']
        *  or this:
        */
        $action = 'rc_handle_sideload';
        if ( isset( $overrides['action'] ) ) {
            $action = $overrides['action'];
        }
        return $this->_handle_upload( $file, $overrides, $time, $action );
    }
    
    /**
     * Wrapper for _handle_upload(), passes 'rc_handle_upload' action.
     *
     * @since 2.0.0
     *
     * @see _handle_upload()
     *
     * @param array      $file      Reference to a single element of $_FILES. Call the function once for
     *                              each uploaded file.
     * @param array|bool $overrides Optional. An associative array of names=>values to override default
     *                              variables. Default false.
     * @param string     $time      Optional. Time formatted in 'yyyy/mm'. Default null.
     * @return array On success, returns an associative array of file attributes. On failure, returns
     *               $overrides['upload_error_handler'](&$file, $message ) or array( 'error'=>$message ).
     */
    public function handle_upload( &$file, $overrides = false, $time = null ) {
        /*
         *  $_POST['action'] must be set and its value must equal $overrides['action']
         *  or this:
         */
        $action = 'rc_handle_upload';
        if ( isset( $overrides['action'] ) ) {
            $action = $overrides['action'];
        }
    
        return $this->_handle_upload( $file, $overrides, $time, $action );
    }
    
    public function error() {
        return $this->errors->get_error_message();
    }
    
    public function errors() {
        return $this->errors;
    }
    
}
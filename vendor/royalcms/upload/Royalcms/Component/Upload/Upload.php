<?php namespace Royalcms\Component\Upload;

use Royalcms\Component\Foundation\Uri;
use Royalcms\Component\Support\Format;
use Royalcms\Component\DateTime\Time;
use Royalcms\Component\Support\Facades\Config;
use RC_Hook;
use Royalcms\Component\Support\Facades\File;

/**
 * 上传类静态操作方法
 *
 * @author royalwang
 *        
 */
class Upload
{

    /**
     * 获取上传对象
     *
     * @param string $type            
     * @param array $options            
     * @return upload_file
     */
    public static function uploader($type, $options = array())
    {
        $uploader = new Uploader($options); // 实例化上传类
        $uploader->add_sub_dirname_callback(array( __CLASS__, 'upload_sub_dir' ));
        $uploader->add_filename_callback(array( __CLASS__, 'random_filename' ));
        return $uploader;
    }

    /**
     * 生成随机的文件名
     */
    public static function random_filename()
    {
        $value = RC_Hook::apply_filters('upload_default_random_filename', '');
        if (!$value) {
            $seedstr = explode(" ", microtime(), 5);
            $seed = $seedstr[0] * 10000;
            srand($seed);
            $random = rand(1000, 10000);
            $value = date("YmdHis", time()) . $random;
        }
        return $value;
    }

    /**
     * Get an array containing the current upload directory's path and url.
     *
     * Checks the 'upload_path' option, which should be from the web root folder,
     * and if it isn't empty it will be used. If it is empty, then the path will be
     * 'SITE_CONTENT_PATH/uploads'. If the 'UPLOADS' constant is defined, then it will
     * override the 'upload_path' option and 'WP_CONTENT_DIR/uploads' path.
     *
     * The upload URL path is set either by the 'upload_url_path' option or by using
     * the 'SITE_CONTENT_URL' constant and appending '/uploads' to the path.
     *
     * If the 'uploads_use_yearmonth_folders' is set to true (checkbox if checked in
     * the administration settings panel), then the time will be used. The format
     * will be year first and then month.
     *
     * If the path couldn't be created, then an error will be returned with the key
     * 'error' containing the error message. The error suggests that the parent
     * directory is not writable by the server.
     *
     * On success, the returned array will have many indices:
     * 'path' - base directory and sub directory or full path to upload directory.
     * 'url' - base url and sub directory or absolute URL to upload directory.
     * 'subdir' - sub directory if uploads use year/month folders option is on.
     * 'basedir' - path without subdir.
     * 'baseurl' - URL path without subdir.
     * 'error' - set to false.
     *
     * @since 3.0.0
     *       
     * @param string $time
     *            Optional. Time formatted in 'yyyy/mm'.
     * @return array See above for description.
     */
    public static function upload_dir($type = '', $time = null)
    {
        $siteurl = Uri::site_url();
        $upload_path = trim(Config::get('filesystems.upload.path'));
        
        if (empty($upload_path) || 'content/uploads' == $upload_path) {
            $dir = Format::untrailingslashit(self::upload_path());
        } elseif (0 !== strpos($upload_path, SITE_PATH)) {
            // $dir is absolute, $upload_path is (maybe) relative to SITE_PATH
            $dir = Format::path_join(SITE_PATH, $upload_path);
        } else {
            $dir = $upload_path;
        }
        
        if (! $url = Config::get('filesystems.upload.url_path')) {
            if (empty($upload_path) || ('content/uploads' == $upload_path) || ($upload_path == $dir)) {
                $url = SITE_UPLOAD_URL;
            } else {
                $url = Format::trailingslashit($siteurl) . $upload_path;
            }   
        }
        
        $basedir = $dir;
        $baseurl = $url;
        
        if ($type) {
            $type = trim($type, "/\\");
            $basedir = $dir = $dir . DIRECTORY_SEPARATOR . $type;
            $baseurl = $url = $url . "/$type";
        }
        
        $subdir = self::upload_sub_dir($time);
        $dir .= $subdir;
        $url .= $subdir;
        
        /**
         * Filter the uploads directory data.
         *
         * @since 3.0.0
         *       
         * @param array $uploads
         *            Array of upload directory data with keys of 'path',
         *            'url', 'subdir, 'basedir', and 'error'.
         */
        $uploads = RC_Hook::apply_filters('upload_dir', array(
            'path' => $dir,
            'url' => $url,
            'subdir' => $subdir,
            'basedir' => $basedir,
            'baseurl' => $baseurl,
            'error' => false
        ));
        
        // Make sure we have an uploads dir
        if (! File::makeDirectory($uploads['path'])) {
            if (0 === strpos($uploads['basedir'], SITE_PATH)) {
                $error_path = str_replace(SITE_PATH, '', $uploads['basedir']) . $uploads['subdir'];
            } else {
                $error_path = basename($uploads['basedir']) . $uploads['subdir'];
            }  
            
            $message = sprintf('Unable to create directory %s. Is its parent directory writable by the server?', $error_path);
            $uploads['error'] = $message;
        }
        
        return $uploads;
    }

    public static function upload_sub_dir($time = null)
    {
        $subdir = '';
        if (Config::get('filesystems.upload.use_yearmonth_folders')) {
            // Generate the yearly and monthly dirs
            if (! $time) {
                $time = Time::local_date('Y-m-d', SYS_TIME);
            }
            
            $y = substr($time, 0, 4);
            $m = substr($time, 5, 2);
            $subdir = Format::untrailingslashit(DIRECTORY_SEPARATOR . $y . DIRECTORY_SEPARATOR . $m);
        }
        
        /**
         * Filter the uploads directory data.
         *
         * @since 3.0.0
         *       
         * @param array $uploads
         *            Array of upload directory data with keys of 'path',
         *            'url', 'subdir, 'basedir', and 'error'.
         */
        return RC_Hook::apply_filters('upload_sub_dir', $subdir, $time);
    }

    /**
     * Return relative path to an uploaded file.
     *
     * The path is relative to the current upload dir.
     *
     * @since 3.0.0
     *       
     * @param string $path
     *            Full path to the file
     * @return string relative path on success, unchanged path on failure.
     */
    public static function relative_upload_path($path)
    {
        $new_path = $path;
        
        $uploads = self::upload_dir();
        if (0 === strpos($new_path, $uploads['basedir'])) {
            $new_path = str_replace($uploads['basedir'], '', $new_path);
            $new_path = ltrim($new_path, '/');
        }
        
        /**
         * Filter the relative path to an uploaded file.
         *
         * @since 3.0.0
         *       
         * @param string $new_path
         *            Relative path to the file.
         * @param string $path
         *            Full path to the file.
         */
        return RC_Hook::apply_filters('relative_upload_path', $new_path, $path);
    }
    
    
    /**
     * Retrieve the url to the admin area for the current site.
     *
     * @since 3.0.0
     *
     * @param string $path
     *            Optional path relative to the admin url.
     * @param string $scheme
     *            The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Admin url link with optional path appended.
     */
    public static function upload_url($path = '', $scheme = 'admin') {
        $url = rtrim(SITE_UPLOAD_URL, '/');
        
        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }
        
        /**
         * Filter the admin area URL.
         *
         * @since 3.0.0
         *
         * @param string $url
         *            The complete admin area URL including scheme and path.
         * @param string $path
         *            Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('upload_url', $url, $path);
    }
    
    
    /**
     * Retrieve the url to the upload area for the current site.
     *
     * @since 3.0.0
     *
     * @param string $path
     *            Optional path relative to the upload url.
     * @return string Admin url link with optional path appended.
     */
    public static function upload_path($path = '') {
        $upload_root = SITE_UPLOAD_PATH;
        
        if ($path && is_string($path)) {
            $upload_root = rtrim($upload_root, DIRECTORY_SEPARATOR);
            $upload_root .= DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
        }
        
        /**
         * Filter the upload area URL.
         *
         * @since 3.0.0
         *
         * @param string $url
         *            The complete upload area URL including scheme and path.
         * @param string $path
         *            Path relative to the admin area URL. Blank string if no path is specified.
         */
        return RC_Hook::apply_filters('upload_path', $upload_root, $path);
    }

}

// end
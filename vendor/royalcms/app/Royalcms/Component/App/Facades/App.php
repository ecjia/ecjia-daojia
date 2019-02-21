<?php 

namespace Royalcms\Component\App\Facades;

use RC_Hook;
use Royalcms\Component\Support\Facades\Lang;
use Royalcms\Component\Support\Facades\Cache as RC_Cache;
use Royalcms\Component\Foundation\Uri;
use Royalcms\Component\Support\Format;
use Royalcms\Component\Support\Facades\Facade;

/**
 * APP快捷操作类
 */
class App extends Facade
{
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() 
    { 
        return 'app'; 
    }
    
    
    /**
     * 别名映射
     * key(别名) => value(应用标识)
     * @var array
     */
    private static $alias_map = array();
    
    /**
     * 标识映射
     * key(应用标识) => value(目录名)
     * @var array
    */
    private static $identifier_map = array();
    
    
    /**
     * 扫描App Bundles
     */
    public static function scan_bundles() {
        $bundles = array();
    
        /**
         * load the Route app to the applications bundle info.
         *
         * @since 3.1.0
         *
         * @param array $bundles
         *                  多维数组，示例如下：
         *                  array(
         *                      array('alias' => '', 'identifier' => '', 'directory' => ''),
         *                      array('alias' => '', 'identifier' => '', 'directory' => ''),
         *                  )
        */
        $bundles = RC_Hook::apply_filters('app_scan_bundles', $bundles);
        if (!empty($bundles)) {
            foreach ($bundles as $bundle) {
                self::$alias_map[$bundle['alias']] = $bundle['identifier'];
                self::$identifier_map[$bundle['identifier']] = $bundle['directory'];
            }
        }
    }
    
    /**
     * 获取app bundle信息
     * @param string $alias
     * @return array array($app_id, $app_floder, $alias)
     */
    public static function get_bundle($alias) {
        $bundle = array('alias' => $alias);

        if (isset(self::$alias_map[$alias])) {
            $bundle['identifier'] = self::$alias_map[$alias];
        } else {
            $bundle['identifier'] = $alias;
        }
    
        if (isset(self::$identifier_map[$bundle['identifier']])) {
            $bundle['directory'] = self::$identifier_map[$bundle['identifier']];
        } else {
            $bundle['directory'] = $alias;
        }
    
        return $bundle;
    }

    public static function get_alias() {
        return self::$alias_map;
    }
    
    
    public static function get_identifier() {
        return self::$identifier_map;
    }
    
    protected static $cache_key;
    
    /**
     * Check the applications directory and check package info file with application data.
     *
     * @since 3.2.0
     *
     * @return array Key is the application file path and the value is an array of the application data.
     */
    public static function get_apps($application_identifier = '') {
        if (defined('RC_SITE')) {
            $cache_key = 'applications' . constant('RC_SITE');
        } else {
            $cache_key = 'applications';
        }

        $cache_applications = RC_Cache::app_cache_get($cache_key, 'system');
        if ( $cache_applications ) {
            if ($application_identifier && isset($cache_applications[ $application_identifier ])) {
                return $cache_applications[ $application_identifier ];
            } else {
                return $cache_applications;
            }
        }        

        $rc_apps = array ();
        $app_roots = array(
            RC_APP_PATH,
            SITE_APP_PATH
        );
    
        foreach ($app_roots as $app_root) {
            if (file_exists($app_root)) {
                $apps_dir = @opendir( $app_root);
                while (false !== ($file = @readdir($apps_dir))) {
                    if (substr($file, 0, 1) !== '.') {
                        $package = self::get_app_package($file, false, false); //Do not apply markup/translate as it'll be cached.
                        if ( empty ( $package['identifier'] ) )
                            continue;
                        
                        $rc_apps[$package['identifier']] = $package;
                    }
                }
                @closedir($apps_dir);
            }

            uasort( $rc_apps, array(__CLASS__, '_sort_uname_callback') );
        }
    
        RC_Cache::app_cache_set($cache_key, $rc_apps, 'system');
    
        return $rc_apps;
    }
    
    
    /**
     * Callback to sort array by a 'Name' key.
     *
     * @since 3.2.0
     * @access private
     */
    public static function _sort_uname_callback($a, $b) {
        return strnatcasecmp( $a['name'], $b['name'] );
    }
    
    /**
     * 获取应用包信息
     *
     * @param string $id
     * @return boolean NULL
     */
    public static function get_app_package($app_dir, $markup = true, $translate = true) {
        $package = self::get_package_data($app_dir);
        
        if ( $package && $translate ) {
//            $lang_namespace = $package['directory'] . '::package.';
//            $package['format_name'] = Lang::get($lang_namespace . $package['name']);
//            $package['format_description'] = Lang::get($lang_namespace . $package['description']);
//            if (empty($package['format_name'])) {
//                $package['format_name'] = $package['name'];
//            }
//            if (empty($package['format_description'])) {
//                $package['format_description'] = $package['description'];
//            }

            $package['format_name'] = __($package['name'], $package['directory']);
            $package['format_description'] = __($package['description'], $package['directory']);

        } else {

            $package['format_name'] = $package['name'];
            $package['format_description'] = $package['description'];
        }
        
        return $package;
    }
    
    /**
     * 获取package.cfg.php配置信息
     * @param string $app_dir
     * @return NULL
     */
    public static function get_package_data($app_dir) {
        $package_file = royalcms('path').'/apps/'.$app_dir.'/configs/package.php';
        if (!file_exists($package_file)) {
            $package_file = royalcms('path.content').'/apps/'.$app_dir.'/configs/package.php';
        }
        if (!file_exists($package_file)) {
            return null;
        }
        
        return include $package_file;
    }

    /**
     * Retrieve the url to the applications directory or to a specific file within that directory.
     * You can hardcode the application slug in $path or pass __FILE__ as a second argument to get the correct folder name.
     *
     * @since 3.0.0
     *       
     * @param string $path
     *            Optional. Path relative to the applications url.
     * @param string $app
     *            Optional. The application file that you want to be relative to - i.e. pass in __FILE__
     * @return string Applications url link with optional path appended.
     */
    public static function apps_url($path = '', $app = '')
    {
        if (defined('RC_SITE') && strpos($app, 'sites' . DS . RC_SITE)) {
            $url = Uri::content_url() . '/apps';
        } else {
            $url = Uri::home_content_url() . '/apps';
        }
        
        $url = Uri::set_url_scheme($url);
        
        if (! empty($app) && is_string($app)) {
            $folder = dirname(self::app_basename($app));
            if ('.' != $folder)
                $url .= '/' . ltrim($folder, '/');
        }
        
        if ($path && is_string($path))
            $url .= '/' . ltrim($path, '/');
        
        /**
         * Filter the URL to the applications directory.
         *
         * @since 3.0.0
         *       
         * @param string $url
         *            The complete URL to the applications directory including scheme and path.
         * @param string $path
         *            Path relative to the URL to the applications directory. Blank string
         *            if no path is specified.
         * @param string $plugin
         *            The application file path to be relative to. Blank string if no plugin
         *            is specified.
         */
        return RC_Hook::apply_filters('apps_url', $url, $path, $app);
    }

    /**
     * Gets the URL directory path (with trailing slash) for the application __FILE__ passed in
     *
     * @since 3.0.0
     *       
     * @param string $file
     *            The filename of the plugin (__FILE__)
     * @return string the URL path of the directory that contains the application
     */
    public static function app_dir_url($file)
    {
        return Format::trailingslashit(self::apps_url('', $file));
    }

    /**
     * Gets the filesystem directory path (with trailing slash) for the application __FILE__ passed in
     *
     * @since 3.0.0
     *       
     * @param string $file
     *            The filename of the application (__FILE__)
     * @return string the filesystem path of the directory that contains the application
     */
    public static function app_dir_path($file)
    {
        return Format::trailingslashit(dirname($file));
    }

    /**
     * Gets the basename of a plugin.
     *
     * This method extracts the name of a application from its filename.
     *
     * @since 1.5.0
     *       
     * @access private
     *        
     * @param string $file
     *            The filename of application.
     * @return string The name of a application.
     * @uses WP_PLUGIN_DIR
     */
    public static function app_basename($file)
    {
        if (defined('RC_SITE') && strpos($file, 'sites' . DS . RC_SITE)) {
            $realdir = SITE_APP_PATH;
            $dir = Format::normalize_path(SITE_APP_PATH);
        } else {
            $realdir = RC_APP_PATH;
            $dir = Format::normalize_path(RC_APP_PATH);
        }
        
        if (strpos($file, $realdir) === 0) {
            $file = substr($file, strlen($realdir));
        }
        
        $file = Format::normalize_path($file);
        
        $file = preg_replace('#^' . preg_quote($dir, '#') . '/#', '', $file); // get relative path from plugins dir
        $file = trim($file, '/');
        return $file;
    }
    
    
    /**
     * Clears the Plugins cache used by get_apps() and by default, the Plugin Update cache.
     *
     * @since 3.0.0
     *
     * @param bool $clear_update_cache Whether to clear the Plugin updates cache
     */
    public static function clean_applications_cache( $clear_update_cache = true ) {
        if ( $clear_update_cache ) {
        }
        if (defined('RC_SITE')) {
            $cache_key = 'applications' . constant('RC_SITE');
        } else {
            $cache_key = 'applications';
        }
        RC_Cache::app_cache_delete($cache_key, 'system');
    }
    
    /**
     * 通过别名返回App的具体文件夹名称
     * @param string $alias
     * @return string|NULL
     */
    public static function app_dir_name($alias) {
        $alias_directory = self::alias_directory();
        if (isset($alias_directory[$alias])) {
            return $alias_directory[$alias];
        }
        return null;
    }
    
    public static function has_alias($alias) {
        $alias_directory = self::alias_directory();
        if (isset($alias_directory[$alias])) {
            return true;
        }
        return false;
    }
    
    public static function alias_directory() {
        static $alias_directory = array();
        $bundles = array();
        
        if (RC_Hook::has_filter('app_scan_bundles')) {
            $bundles = RC_Hook::apply_filters('app_scan_bundles', $bundles);
            if (!empty($bundles)) {
                foreach ($bundles as $bundle) {
                    $alias_directory[$bundle['alias']] = $bundle['directory'];
                }
            }
        } else {
            $alias_directory = \RC_Config::get('app');
        }

        return RC_Hook::apply_filters('app_alias_directory_handle', $alias_directory);
    }
}

// end
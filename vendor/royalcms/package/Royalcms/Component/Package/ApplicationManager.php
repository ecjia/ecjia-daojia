<?php namespace Royalcms\Component\Package;

use RC_Hook;

class ApplicationManager {
    
    /**
     * 扫描App Bundles
     */
    public static function scanApplication() {
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
    
    /**
     * Check the applications directory and check package info file with application data.
     *
     * @since 3.2.0
     *
     * @return array Key is the application file path and the value is an array of the application data.
     */
    public static function get_apps($application_identifier = '') {
        $cache_applications = \RC_Cache::app_cache_get('applications', 'system');
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
    
        \RC_Cache::app_cache_set('applications', $rc_apps, 'system');
    
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
        $package = \RC_Loader::load_app_config('package', $app_dir);
    
        if ( $package && $translate ) {
            \RC_Lang::load($package['directory'] . '/package');
            $package['format_name'] = \RC_Lang::lang($package['name']);
            $package['format_description'] = \RC_Lang::lang($package['description']);
            if (empty($package['format_name'])) {
                $package['format_name'] = $package['name'];
            }
            if (empty($package['format_description'])) {
                $package['format_description'] = $package['description'];
            }
        }
    
        return $package;
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
    
        \RC_Cache::app_cache_delete('applications', 'system');
    }
    
}
<?php namespace Royalcms\Component\Foundation;

use Royalcms\Component\Support\Facades\Config;

/**
 * RC Loader Class or Function
 *
 * @author royalwang
 * @since 4.0
 */
class Loader extends RoyalcmsObject
{

    /**
     * *****************************************************
     * 类加载
     * *****************************************************
     */
    /**
     * 加载系统类方法
     *
     * @param string $classname
     *            类名
     * @param string $path
     *            扩展地址
     * @param intger $initialize
     *            是否初始化
     */
    public static function load_sys_class($classname, $initialize = true)
    {
//         $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
//         $class = basename($classname);
        
//         $info = explode(DIRECTORY_SEPARATOR, $classname);
//         if (is_array($info) && count($info) > 1) {
//             $path = dirname($classname);
//             $path = 'classes' . DIRECTORY_SEPARATOR . $path;
//         } else {
//             $path = '';
//             $path = 'classes';
//         } 
        
//         return self::_load_class($class, $path, 'sys', null, $initialize);
        //@todo
        return \RC_Package::package('system')->loadClass($classname, $initialize);
    }
    
    /**
     * 加载应用类方法
     *
     * @param string $classname
     *            类名
     * @param string $m
     *            模块
     * @param intger $initialize
     *            是否初始化
     */
    public static function load_app_class($classname, $m = null, $initialize = true)
    {
        $m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
        if (empty($m))
            return false;
        
        return \RC_Package::package('app::'.$m)->loadClass($classname, $initialize);
        
//         $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
//         $class = basename($classname);
        
//         $info = explode(DIRECTORY_SEPARATOR, $classname);
//         if (is_array($info) && count($info) > 1) {
//             $path = dirname($classname);
//             $path = $m . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $path;
//         } else {
//             $path = '';
//             $path = $m . DIRECTORY_SEPARATOR . 'classes';
//         }
        
//         return self::_load_class($class, $path, 'app', $m, $initialize);
    }

    /**
     * 加载插件类方法
     *
     * @param string $classname
     *            类名
     * @param string $dir
     *            模块
     * @param intger $initialize
     *            是否初始化
     */
    public static function load_plugin_class($classname, $plugin_dir, $initialize = true)
    {
        $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
        $class = basename($classname);
        
        $info = explode(DIRECTORY_SEPARATOR, $classname);
        if (is_array($info) && count($info) > 1) {
            $path = $plugin_dir . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . dirname($classname);
        } else {
            $path = $plugin_dir . DIRECTORY_SEPARATOR . 'classes';
        }
        return self::_load_class($class, $path, 'plugin', $plugin_dir, $initialize);
    }

    /**
     * 是否有自己的扩展文件
     *
     * @param string $filepath
     *            路径
     */
    public static function my_path($filepath)
    {
        $path = pathinfo($filepath);
        if (file_exists($path['dirname'] . DIRECTORY_SEPARATOR . 'MY_' . $path['basename'])) {
            return $path['dirname'] . DIRECTORY_SEPARATOR . 'MY_' . $path['basename'];
        } else {
            return false;
        }
    }

    /**
     * 加载类文件函数
     *
     * @param string $classname
     *            类名
     * @param string $path
     *            扩展地址
     * @param intger $initialize
     *            是否初始化
     */
    private static function _load_class($classname, $path = '', $type = 'sys', $app = null, $initialize = true)
    {
        static $classes = array();
        if (empty($path)) {
            $path = 'classes';
        }
            
        $key = md5($path . $classname . $type . $initialize);
        if (isset($classes[$key])) {
            if (!empty($classes[$key])) {
                return $classes[$key];
            } else {
                return true;
            }
        }

        if ($type == 'sys') {
            $include_file = SITE_SYSTEM_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php';
            if (file_exists($include_file)) {
                include_once $include_file;
                $name = $classname;
                $my_path = self::my_path($include_file);
                if ($my_path) {
                    include_once $my_path;
                    $name = 'MY_' . $classname;
                }
                if ($initialize) {
                    $classes[$key] = new $name();
                } else {
                    $classes[$key] = true;
                }
                return $classes[$key];
            } else {
                return false;
            }
        } 
        else
        if ($type == 'plugin') {
            if (empty($app)) {
                return false;
            }
            
            $plugin_path = RC_PLUGIN_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php';
            if (self::exists_site_plugin($app)) {
                $plugin_path = SITE_PLUGIN_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php';
            }
            
            if (file_exists($plugin_path)) {
                include_once $plugin_path;
                $name = $classname;
                $my_path = self::my_path($plugin_path);
                if ($my_path) {
                    include_once $my_path;
                    $name = 'MY_' . $classname;
                }
                if ($initialize) {
                    $classes[$key] = new $name();
                } else {
                    $classes[$key] = true;
                }
                return $classes[$key];
            } else {
                return false;
            }
        } 
        else {
            $app_path = RC_APP_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php';
            if (self::exists_site_app($app)) {
                $app_path = SITE_APP_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php';
            }

            if (file_exists($app_path)) {
                include_once $app_path;
                $name = $classname;
                $my_path = self::my_path($app_path);
                if ($my_path) {
                    include_once $my_path;
                    $name = 'MY_' . $classname;
                }
                if ($initialize) {
                    $classes[$key] = new $name();
                } else {
                    $classes[$key] = true;
                }
                return $classes[$key];
            } else {
                return false;
            }
        }
    }

    /**
     * 加载系统数据模型
     *
     * @param string $classname
     *            类名
     */
    public static function load_model($classname)
    {
        return \RC_Package::package('system')->loadModel($classname);
        
//         return self::_load_class($classname, 'model');
    }
    
    /**
     * 加载系统数据模型
     *
     * @param string $classname
     *            类名
     */
    public static function load_sys_model($classname)
    {
//         return self::load_model($classname);
        //@todo
        return \RC_Package::package('system')->loadModel($classname);
    }

    /**
     * 加载应用数据模型
     *
     * @param string $classname
     *            类名
     */
    public static function load_app_model($classname, $m = '')
    {
        $m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
        if (empty($m)) return false;
        
        return \RC_Package::package('app::'.$m)->loadModel($classname);
        
//         return self::_load_class($classname, $m . DIRECTORY_SEPARATOR . 'model', 'app', $m);
    }

    /**
     * 加载系统模块库
     *
     * @param string $classname
     *            类名
     */
    public static function load_module($classname, $initialize = true)
    {
        return \RC_Package::package('system')->loadModule($classname, $initialize);
        
//         $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
//         $class = basename($classname);
        
//         $info = explode(DIRECTORY_SEPARATOR, $classname);
//         if (is_array($info) && count($info) > 1) {
//             $path = dirname($classname);
//             $path = 'modules' . DIRECTORY_SEPARATOR . $path;
//         } else {
//             $path = 'modules';
//         }
        
//         return self::_load_class($class, $path);
    }

    /**
     * 加载应用模块库
     *
     * @param string $classname
     *            类名
     */
    public static function load_app_module($classname, $m = '', $initialize = true)
    {
        $m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
        if (empty($m)) return false;
        
        return \RC_Package::package('app::'.$m)->loadModule($classname, $initialize);
        
//         $classname = str_replace(".", DIRECTORY_SEPARATOR, $classname);
//         $class = basename($classname);
        
//         $info = explode(DIRECTORY_SEPARATOR, $classname);
//         if (is_array($info) && count($info) > 1) {
//             $path = dirname($classname);
//             $path = $m . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $path;
//         } else {
//             $path = '';
//             $path = $m . DIRECTORY_SEPARATOR . 'modules';
//         }
        
//         return self::_load_class($class, $path, 'app', $m, $initialize);
    }

    /**
     * 加载应用配置文件
     *
     * @param string $cfgname            
     * @param string $m            
     * @return boolean Ambigous unknown>
     */
    public static function load_app_config($cfgname, $m = '', $return = true)
    {
        $m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
        if (empty($m)) return false;

        return \RC_Package::package('app::'.$m)->loadConfig($cfgname);
//         return self::_load_config($cfgname, $m . DIRECTORY_SEPARATOR . 'configs', 'app', $m, $return);
    }

    /**
     * 加载系统配置文件
     *
     * @param string $cfgname            
     * @param string $m            
     * @return boolean Ambigous unknown>
     */
    public static function load_sys_config($cfgname, $return = true)
    {
//         return self::_load_config($cfgname, null, 'sys', null, $return);
        //@todo
        return \RC_Package::package('system')->loadConfig($cfgname);
    }

    /**
     * 加载插件配置文件
     *
     * @param string $cfgname            
     * @param string $m            
     * @return boolean Ambigous unknown>
     */
    public static function load_plugin_config($cfgname, $m = '', $return = true)
    {
        if (empty($m))
            return false;
        return self::_load_config($cfgname, $m, 'plugin', $m, $return);
    }


    /**
     * 加载配置文件函数
     *
     * @param string $confname
     *            类名
     * @param string $path
     *            扩展地址
     */
    private static function _load_config($confname, $path = '', $type = 'sys', $app = null, $return = true)
    {
        static $confs = array();
        if (empty($path))
            $path = 'configs';
        $key = md5($path . $confname);
        if (isset($confs[$key])) {
            if (! empty($confs[$key])) {
                return $confs[$key];
            } else {
                return true;
            }
        }
        
        if ($type == 'sys') {
            if (file_exists(SITE_SYSTEM_PATH . $path . DIRECTORY_SEPARATOR . $confname . '.cfg.php')) {
                $name = include_once SITE_SYSTEM_PATH . $path . DIRECTORY_SEPARATOR . $confname . '.cfg.php';
                if ($return) {
                    $confs[$key] = $name;
                } else {
                    $confs[$key] = true;
                }
                return $confs[$key];
            } else {
                return false;
            }
        } else
        if ($type == 'plugin') {
            if (file_exists(SITE_PLUGIN_PATH . $path . DIRECTORY_SEPARATOR . $confname . '.cfg.php')) {
                $name = include_once SITE_PLUGIN_PATH . $path . DIRECTORY_SEPARATOR . $confname . '.cfg.php';
                if ($return) {
                    $confs[$key] = $name;
                } else {
                    $confs[$key] = true;
                }
                return $confs[$key];
            } else {
                return false;
            }
        } elseif ($type == 'widget') {
            if (file_exists(SITE_WIDGET_PATH . $path . DIRECTORY_SEPARATOR . $confname . '.cfg.php')) {
                $name = include_once SITE_WIDGET_PATH . $path . DIRECTORY_SEPARATOR . $confname . '.cfg.php';
                if ($return) {
                    $confs[$key] = $name;
                } else {
                    $confs[$key] = true;
                }
                return $confs[$key];
            } else {
                return false;
            }
        } 
        else {
            $app_path = RC_APP_PATH . $path . DIRECTORY_SEPARATOR . $confname . '.cfg.php';
            if (self::exists_site_app($app)) {
                $app_path = SITE_APP_PATH . $path . DIRECTORY_SEPARATOR . $confname . '.cfg.php';
            }
            
            if (file_exists($app_path)) {
                $name = include_once $app_path;
                if ($return) {
                    $confs[$key] = $name;
                } else {
                    $confs[$key] = true;
                }
                return $confs[$key];
            } else {
                return false;
            }
        }
    }

    /**
     * 加载应用语言文件
     *
     * @param string $filename            
     * @param string $m            
     * @return boolean Ambigous unknown>
     */
    public static function load_app_lang($filename, $m = '')
    {
        $m = (empty($m) && defined('ROUTE_M')) ? ROUTE_M : $m;
        if (empty($m))
            return array();
        return self::_load_lang($filename, $m . DIRECTORY_SEPARATOR . 'languages', 'app', $m);
    }

    /**
     * 加载系统语言文件
     *
     * @param string $filename            
     * @param string $m            
     * @return boolean Ambigous unknown>
     */
    public static function load_sys_lang($filename)
    {
        return self::_load_lang($filename);
    }

    /**
     * 加载插件语言文件
     *
     * @param string $filename            
     * @param string $m            
     * @return boolean Ambigous unknown>
     */
    public static function load_plugin_lang($filename, $m = '')
    {
        if (empty($m))
            return array();
        return self::_load_lang($filename, $m . DIRECTORY_SEPARATOR . 'languages', 'plugin', $m);
    }
    
    
    /**
     * 加载主题语言文件
     *
     * @param string $filename
     * @return boolean Ambigous unknown>
     */
    public static function load_theme_lang($filename)
    {
        return self::_load_lang($filename, 'languages', 'theme');
    }


    /**
     * 加载语言文件函数
     *
     * @param string $confname
     *            类名
     * @param string $path
     *            扩展地址
     */
    private static function _load_lang($filename, $path = '', $type = 'sys', $app = null)
    {
//         \RC_Logger::getLogger('debug')->debug($filename.' : '.$path.' : '.$type.' : '.$app);
        static $langs = array();
        if (empty($path)) {
            $path = 'languages';
        }
        $cur_lang = 'zh-cn';
        $path .= DIRECTORY_SEPARATOR . $cur_lang;
        $key = md5($path . $filename . $type);
        if (isset($langs[$key])) {
            if (! empty($langs[$key])) {
                return $langs[$key];
            } else {
                return array();
            }
        }
        
        if ($type == 'sys') {
            $sys_path = SITE_SYSTEM_PATH . $path . DIRECTORY_SEPARATOR . $filename . '.lang.php';
            if (file_exists($sys_path)) {
                $LANG = array();
                include_once $sys_path;
                $langs[$key] = $LANG;
                return $langs[$key];
            } else {
                return array();
            }
        } else
        if ($type == 'plugin') {
            $plugin_path = RC_PLUGIN_PATH . $path . DIRECTORY_SEPARATOR . $filename . '.lang.php';
            if (self::exists_site_plugin($app)) {
                $plugin_path = SITE_PLUGIN_PATH . $path . DIRECTORY_SEPARATOR . $filename . '.lang.php';
            }
            if (file_exists($plugin_path)) {
                $LANG = array();
                include_once $plugin_path;
                $langs[$key] = $LANG;
                return $langs[$key];
            } else {
                return array();
            }
        } elseif ($type == 'theme') {
            $plugin_path = Theme::get_template_directory() . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $filename . '.lang.php';
            if (file_exists($plugin_path)) {
                $LANG = array();
                include_once $plugin_path;
                $langs[$key] = $LANG;
                return $langs[$key];
            } else {
                return array();
            }
        } 
        else {
            $app_path = RC_APP_PATH . $path . DIRECTORY_SEPARATOR . $filename . '.lang.php';
            if (self::exists_site_app($app)) {
                $app_path = SITE_APP_PATH . $path . DIRECTORY_SEPARATOR . $filename . '.lang.php';
            }
            if (file_exists($app_path)) {
                $LANG = array();
                include_once $app_path;
                $langs[$key] = $LANG;
                return $langs[$key];
            } else {
                return array();
            }
        }
    }
    
    /**
     * 加载系统的函数库
     *
     * @param string $func
     *            函数库名
     */
    public static function load_sys_func($func)
    {
//         return self::_load_func($func);
        //@todo
        return \RC_Package::package('system')->loadFunction($func);
    }

    /**
     * 加载应用函数库
     *
     * @param string $func
     *            函数库名
     * @param string $m
     *            模型名
     */
    public static function load_app_func($func, $m = '')
    {
        $m = empty($m) && defined('ROUTE_M') ? ROUTE_M : $m;
        if (empty($m)) return false;
        
        return \RC_Package::package('app::'.$m)->loadFunction($func);
        
//         return self::_load_func($func, $m . DIRECTORY_SEPARATOR . 'functions', 'app', $m);
    }

    /**
     * 自动加载autoload目录下函数库
     *
     * @param string $func
     *            函数库名
     */
    public static function auto_load_func($path = '')
    {
        return self::_auto_load_func($path);
    }

//     /**
//      * 加载函数库
//      *
//      * @param string $func
//      *            函数名
//      * @param string $path
//      *            地址
//      */
//     private static function _load_func($func, $path = '', $type = 'sys', $app = NULL)
//     {
//         static $funcs = array();
//         if (empty($path))
//             $path = 'functions';
//         $path .= DIRECTORY_SEPARATOR . $func . '.func.php';
//         $key = md5($path . $func . $type);
//         if (isset($funcs[$key]))
//             return true;

//         if ($type == 'sys') {
//             if (file_exists(SITE_SYSTEM_PATH . $path)) {
//                 include SITE_SYSTEM_PATH . $path;
//             } else {
//                 $funcs[$key] = false;
//                 return false;
//             }
//         } 
//         else {
//             $app_path = RC_APP_PATH . $path;
//             if (self::exists_site_app($app)) {
//                 $app_path = SITE_APP_PATH . $path;
//             }
            
//             if (file_exists($app_path)) {
//                 include $app_path;
//             } else {
//                 $funcs[$key] = false;
//                 return false;
//             }
//         }
//         $funcs[$key] = true;
//         return true;
//     }

    /**
     * 加载函数库
     *
     * @param string $func
     *            函数库名
     * @param string $path
     *            地址
     */
    private static function _auto_load_func($path = '')
    {
        if (empty($path)) {
            $path = ROYALCMS_PATH . 'autoload';
        }
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $path .= DIRECTORY_SEPARATOR . '*.php';
        $auto_funcs = glob($path);
        foreach ($auto_funcs as $func_path) {
            include_once $func_path;
        }
    }

    /**
     * api
     */
    public static function load_api($api_key, $parms = array())
    {
        $keys = explode('.', $api_key);
        $app = $keys[0];
        $class = $app . '_' . $keys[1] . '_api';
        $key = $keys[1];
        
        if ($app == 'system' || $app == Config::get('system.admin_entrance') || $app == 'demo') {
//             $system_api = self::_load_class($class, 'apis', 'sys', $app);
            $system_api = \RC_Package::package('system')->loadApi($key);
            if ($system_api) {
                return $system_api->call($parms);
            }
        } else {
//             $app_api = self::_load_class($class, $app . DIRECTORY_SEPARATOR . 'apis', 'app', $app);
            $app_api = \RC_Package::package('app::'.$app)->loadApi($key);
            if ($app_api) {
                return $app_api->call($parms);
            }
        }
        
        return false;
    }

    /**
     * vendor
     *
     * @param string $classname
     *            类名
     *            eg: RC_Loader::load_vendor('smarty/Smarty.class');
     * @return boolean (只引入文件)
     */
    public static function load_vendor($filename)
    {
        $classname = str_replace("/", DIRECTORY_SEPARATOR, $filename);
        $class = basename($classname);
        $info = explode(DIRECTORY_SEPARATOR, $classname);
        if (is_array($info) && count($info) > 1) {
            $path = dirname($classname);
        } else {
            $path = '';
        }
        
        static $files = array();
        $key = md5($path . $class);
        if (isset($files[$key])) {
            if (! empty($files[$key])) {
                return $files[$key];
            } else {
                return true;
            }
        }
        
        if (file_exists(VENDOR_PATH . $path . DIRECTORY_SEPARATOR . $class . '.php')) {
            include_once VENDOR_PATH . $path . DIRECTORY_SEPARATOR . $class . '.php';
            $files[$key] = true;
            return $files[$key];
        } else {
            return false;
        }
    }
    
    
    /**
     * loading theme file
     *
     * @param string $filename
     *            模板目录下文件路径和文件名
     *            eg: RC_Loader::load_vendor('smarty/Smarty.class.php');
     * @return boolean (只引入文件)
     */
    public static function load_theme($filename)
    {
        $filename = str_replace('/', DIRECTORY_SEPARATOR, $filename);
        $filename = ltrim($filename, '/');

        static $files = array();
        $key = md5(Theme::get_template_directory() . DIRECTORY_SEPARATOR . $filename);
        if (isset($files[$key])) {
            if (! empty($files[$key])) {
                return $files[$key];
            } else {
                return true;
            }
        }
        $filepath = Theme::get_template_directory() . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($filepath)) {
            include_once $filepath;
            $files[$key] = true;
            return $files[$key];
        } else {
            return false;
        }
    }

    /**
     * 判断是否存在同名的站点APP，站点APP具体优先使用
     *
     * @param string $m            
     * @return boolean
     */
    public static function exists_site_app($m)
    {
        if (empty($m)) {
            return false;
        }
        
        if (SITE_APP_PATH == RC_APP_PATH) {
            return false;
        }
        
        $path = SITE_APP_PATH . $m;
        if (file_exists($path)) {
            return true;
        }
        
        return false;
    }

    /**
     * 判断是否存在同名的站点PLUGIN，站点PLUGIN具体优先使用
     *
     * @param string $m            
     * @return boolean
     */
    public static function exists_site_plugin($dir)
    {
        if (empty($dir)) {
            return false;
        }
        
        if (SITE_PLUGIN_PATH == RC_PLUGIN_PATH) {
            return false;
        }
        
        $path = SITE_PLUGIN_PATH . $dir;
        if (file_exists($path)) {
            return true;
        }
        
        return false;
    }


    /**
     * 判断是否存在同名的站点System，站点System具体优先使用
     *
     * @return boolean
     */
    public static function exists_site_system()
    {
        $path = SITE_CONTENT_PATH . 'system';
        if (file_exists($path)) {
            return true;
        }
        
        return false;
    }
}

// end
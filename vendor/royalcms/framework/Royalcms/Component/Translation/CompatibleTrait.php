<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/15
 * Time: 1:51 PM
 */

namespace Royalcms\Component\Translation;

use RC_Config;
use RC_Loader;

trait CompatibleTrait
{

    /**
     * 语言包数组
     *
     * @var 3.0
     */
    private static $lang = array();

    /**
     * 语言包名称
     *
     * @var 3.0
     */
    private static $packname = array();

    /**
     * 语言包初始化，用于清除语言包数据
     */
    public static function init()
    {
        self::$lang = array();
        self::$packname = array();
    }

    /**
     * 载入语言包文件进内存
     *
     * @param string $file
     *            语言包文件名称 格式：file or file/file or array('file', 'file/file')
     */
    public static function load($file)
    {
        $lang_files = array();

        if (is_array($file)) {
            $lang_files = $file;
        } elseif (is_string($file)) {
            $lang_files = array(
                $file
            );
        } else {
            return false;
        }

        foreach ($lang_files as $lang_file) {
            $file_arr = array();
            $lang_file_name = $lang_file;

            if (strpos($lang_file, '/')) {
                $file_arr = explode('/', $lang_file);
            }

            if (! empty($file_arr[0])) {
                $m = $file_arr[0];
            }

            if (! empty($file_arr[1])) {
                $lang_file_name = $file_arr[1];
            }

            $m = empty($m) ? ROUTE_M : $m;
            if (empty($m)) {
                continue;
            }

            if ($m != RC_Config::get('system.admin_entrance') && $m != 'system') {
                self::$lang = array_merge(self::$lang, RC_Loader::load_app_lang($lang_file_name, $m));
            } else {
                self::$lang = array_merge(self::$lang, RC_Loader::load_sys_lang($lang_file_name));
            }

            self::$packname[] = $lang_file;
        }

        return self::$lang;
    }

    /**
     * 载入语言包文件进内存
     *
     * @param string $file
     *            语言包文件名称 格式：file or file/file or array('file', 'file/file')
     */
    public static function load_plugin($file)
    {
        $lang_files = array();

        if (is_array($file)) {
            $lang_files = $file;
        } elseif (is_string($file)) {
            $lang_files = array(
                $file
            );
        } else {
            return false;
        }

        foreach ($lang_files as $lang_file) {
            $file_arr = array();
            $lang_file_name = '';

            if (strpos($lang_file, '/')) {
                $file_arr = explode('/', $lang_file);
            } else {
                $plugin_dir = $lang_file;
            }

            if (! empty($file_arr[0])) {
                $plugin_dir = $file_arr[0];
            }

            if (! empty($file_arr[1])) {
                $lang_file_name = $file_arr[1];
            }

            $lang_file_name = empty($lang_file_name) ? 'plugin' : $lang_file_name;
            if (empty($plugin_dir)) {
                continue;
            }

            self::$lang = array_merge(self::$lang, RC_Loader::load_plugin_lang($lang_file_name, $plugin_dir));

            self::$packname[] = $lang_file;
        }

        return self::$lang;
    }

    /**
     * 载入语言包文件进内存
     *
     * @param string $file
     *            语言包文件名称 格式：file or file/file or array('file', 'file/file')
     */
    public static function load_widget($file)
    {
        $lang_files = array();

        if (is_array($file)) {
            $lang_files = $file;
        } elseif (is_string($file)) {
            $lang_files = array(
                $file
            );
        } else {
            return false;
        }

        foreach ($lang_files as $lang_file) {
            $file_arr = array();
            $lang_file_name = '';

            if (strpos($lang_file, '/')) {
                $file_arr = explode('/', $lang_file);
            } else {
                $plugin_dir = $lang_file;
            }

            if (! empty($file_arr[0])) {
                $plugin_dir = $file_arr[0];
            }

            if (! empty($file_arr[1])) {
                $lang_file_name = $file_arr[1];
            }

            $lang_file_name = empty($lang_file_name) ? 'widget' : $lang_file_name;
            if (empty($plugin_dir)) {
                continue;
            }

            self::$lang = array_merge(self::$lang, RC_Loader::load_widget_lang($lang_file_name, $plugin_dir));

            self::$packname[] = $lang_file;
        }

        return self::$lang;
    }


    /**
     * 载入语言包文件进内存
     *
     * @param string $file
     *            语言包文件名称 格式：file or array('file1', 'file2')
     */
    public static function load_theme($file)
    {
        $lang_files = array();

        if (is_array($file)) {
            $lang_files = $file;
        } elseif (is_string($file)) {
            $lang_files = array(
                $file
            );
        } else {
            return false;
        }

        foreach ($lang_files as $lang_file) {
            $lang_file_name = $lang_file;
            $lang_file_name = empty($lang_file_name) ? 'theme' : $lang_file_name;

            self::$lang = array_merge(self::$lang, RC_Loader::load_theme_lang($lang_file_name));
            self::$packname[] = $lang_file;
        }

        return self::$lang;
    }

    /**
     * 语言包调用方法, 最多支持5维数组
     * name1: str1
     * name2: str1/str2/str3
     *
     * @param string $key
     */
    public static function lang($name = null)
    {
        if (is_null($name)) {
            return self::$lang;
        }

        $arr = explode('/', $name);
        $value = '';

        // name = str1 时
        if (count($arr) == 1 && isset(self::$lang[$arr[0]])) {
            $value = self::$lang[$arr[0]];
        }

        // name = str1/str2 时
        elseif (count($arr) == 2 && is_array(self::$lang[$arr[0]]) && isset(self::$lang[$arr[0]][$arr[1]])) {
            $value = self::$lang[$arr[0]][$arr[1]];
        }

        // name = str1/str2/str3 时
        elseif (count($arr) == 3 && is_array(self::$lang[$arr[0]][$arr[1]]) && isset(self::$lang[$arr[0]][$arr[1]][$arr[2]])) {
            $value = self::$lang[$arr[0]][$arr[1]][$arr[2]];
        }

        // name = str1/str2/str3/str4
        elseif (count($arr) == 4 && is_array(self::$lang[$arr[0]][$arr[1]][$arr[2]]) && isset(self::$lang[$arr[0]][$arr[1]][$arr[2]][$arr[3]])) {
            $value = self::$lang[$arr[0]][$arr[1]][$arr[2]][$arr[3]];
        }

        // name = str1/str2/str3/str4/str5
        elseif (count($arr) == 5 && is_array(self::$lang[$arr[0]][$arr[1]][$arr[2]][$arr[3]]) && isset(self::$lang[$arr[0]][$arr[1]][$arr[2]][$arr[3]])) {
            $value = self::$lang[$arr[0]][$arr[1]][$arr[2]][$arr[3]];
        }

        return $value;
    }

    /**
     * 判断语言包 key 是否存在, 最多支持5维数组
     *
     * @param string $name
     */
    public static function has($name)
    {
        $arr = explode('/', $name);
        $bool = false;

        // name = str1 时
        if (count($arr) == 1 && isset(self::$lang[$arr[0]])) {
            $bool = true;
        }

        // name = str1/str2 时
        elseif (count($arr) == 2 && is_array(self::$lang[$arr[0]]) && isset(self::$lang[$arr[0]][$arr[1]])) {
            $bool = true;
        }

        // name = str1/str2/str3 时
        elseif (count($arr) == 3 && is_array(self::$lang[$arr[0]][$arr[1]]) && isset(self::$lang[$arr[0]][$arr[1]][$arr[2]])) {
            $bool = true;
        }

        // name = str1/str2/str3/str4
        elseif (count($arr) == 4 && is_array(self::$lang[$arr[0]][$arr[1]][$arr[2]]) && isset(self::$lang[$arr[0]][$arr[1]][$arr[2]][$arr[3]])) {
            $bool = true;
        }

        // name = str1/str2/str3/str4/str5
        elseif (count($arr) == 5 && is_array(self::$lang[$arr[0]][$arr[1]][$arr[2]][$arr[3]]) && isset(self::$lang[$arr[0]][$arr[1]][$arr[2]][$arr[3]])) {
            $bool = true;
        }

        return $bool;
    }

}
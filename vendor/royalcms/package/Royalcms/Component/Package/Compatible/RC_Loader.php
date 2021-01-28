<?php

/**
 * Class RC_Loader
 *
 * @method static bool load_sys_class($classname, $initialize = true) 加载系统类方法
 * @method static bool load_app_class($classname, $m = null, $initialize = true) 加载应用类方法
 * @method static bool load_plugin_class($classname, $plugin_dir, $initialize = true) 加载插件类方法
 * @method static bool my_path($filepath) 是否有自己的扩展文件
 * @method static bool load_model($classname) 加载系统数据模型
 * @method static bool load_sys_model($classname) 加载系统数据模型
 * @method static bool load_app_model($classname, $m = null) 加载应用数据模型
 * @method static bool load_module($classname, $initialize = true) 加载系统模块库
 * @method static bool load_app_module($classname, $m = null, $initialize = true) 加载应用模块库
 * @method static bool load_app_config($cfgname, $m = null, $return = true) 加载应用配置文件
 * @method static bool load_sys_config($cfgname, $return = true) 加载系统配置文件
 * @method static bool load_plugin_config($cfgname, $m = '', $return = true) 加载插件配置文件
 * @method static bool|array load_app_lang($filename, $m = null) 加载应用语言文件
 * @method static bool|array load_sys_lang($filename) 加载系统语言文件
 * @method static bool|array load_plugin_lang($filename, $m = null) 加载插件语言文件
 * @method static bool|array load_theme_lang($filename) 加载主题语言文件
 * @method static bool load_sys_func($func) 加载系统的函数库
 * @method static bool load_app_func($func, $m = null) 加载应用函数库
 * @method static bool auto_load_func($path = null) 自动加载autoload目录下函数库
 * @method static bool load_api($api_key, $parms = []) loading api file
 * @method static bool load_vendor($filename) loading vendor file
 * @method static bool load_theme($filename) loading theme file
 * @method static bool exists_site_app($m) 判断是否存在同名的站点APP，站点APP具体优先使用
 * @method static bool exists_site_plugin($dir) 判断是否存在同名的站点PLUGIN，站点PLUGIN具体优先使用
 * @method static bool exists_site_system() 判断是否存在同名的站点System，站点System具体优先使用
 */
class RC_Loader
{

}
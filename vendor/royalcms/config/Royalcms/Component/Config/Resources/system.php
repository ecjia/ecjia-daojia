<?php
return array(
    /*
     ******************************** 基本配置 ********************************
     */
    //网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8 timezone
    'timezone' 						=> 'Etc/GMT-8', 		
    //是否Gzip压缩后输出
    'gzip' 							=> 0,


    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Royalcms encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */
    'auth_key' 						=> env('AUTH_KEY', 'SomeRandomString'),
    'cipher'                        => 'AES-256-CBC',
    
    
    //调试显示
    'debug_display'                 => false, 
    'debug'                         => false,
    'admin_entrance'                => 'admincp',
    'admin_enable'                  => true,


    /*
     ********************************URL路由*******************************
     */
    // 基于https协议
    'url_https' => false,
    //URL重写模式
    'url_rewrite'					=> false,		
    //URL模式（normal：普通模式 pathinfo：PATHINFO模式 cli：命令行模式）
    'url_mode'						=> 'normal',	
    // PATHINFO分隔符
    'url_pathinfo_dli' => '/',
    // 兼容模式GET变量
    'url_pathinfo_var' => 'r',
    // 伪静态扩展名
    'url_pathinfo_suf' => '',
    // 应用变量名
    'url_var_app' => 'm',
    // 控制器变量名
    'url_var_control' => 'c',
    // 动作变量名
    'url_var_method' => 'a',
    // PJAX变量名
    'url_var_lang' => 'lang',
		
		
    /*
     ******************************** 模板参数 *******************************
     */   
    //风格
    'tpl_style'                     => 'default',  
    // 信息提示模板
    'tpl_message'                   => 'showmessage.dwt.php',

	'tpl_usedfront'					=> true,
    // 模版文件扩展名
    'tpl_fix'   => '.php',
    // 模板引擎:royalcms,smarty
    'tpl_engine' => 'smarty',
    // 左标签
    'tpl_tag_left' => '{',
    // 右标签
    'tpl_tag_right' => '}',
    
    
    /*
     * ****************************** 表单TOKEN令牌 *******************************
     */
    // 令牌状态
    'token_on' => true,
    // 令牌的表单name
	'token_name' => 'formhash',
    
    /*
     * ******************************分页处理*******************************
     */
    // 分页GET变量
    'page_var' => 'page',
    // 页码数量
    'page_row' => 10,
    // 每页显示条数
    'page_show_row' => 10,
    // 页码风格
    'page_style' => 2,
    // 分页文字设置
    'page_desc' => array(
            'pre'   => '上一页',
            'next'  => '下一页',
            'first' => '首页',
            'end'   => '尾页',
            'unit'  => '条',
    ),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    
    'locale' => 'zh_CN',

    'fallback_locale' => 'zh_CN',

    /*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

    'url' => 'http://localhost',

    /*
	|--------------------------------------------------------------------------
	| Logging Configuration
	|--------------------------------------------------------------------------
	|
	| Here you may configure the log settings for your application. Out of
	| the box, Laravel uses the Monolog PHP logging library. This gives
	| you a variety of powerful log handlers / formatters to utilize.
	|
	| Available Settings: "single", "daily", "syslog", "errorlog"
	|
	*/

    'log' => 'daily',

    'log_max_files' => 5,
    
    /*
    |--------------------------------------------------------------------------
    | Service Provider Manifest
    |--------------------------------------------------------------------------
    |
    | The service provider manifest is used by Laravel to lazy load service
    | providers which are not needed for each request, as well to keep a
    | list of all of the services. Here, you may set its storage spot.
    |
    */
    // @todo
//    'manifest' => storage_path().'/meta',
    
);

// end
<?php
return array(
    /*
     ******************************** 基本配置 ********************************
     */
    //网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8 timezone
    'timezone' 						=> 'Etc/GMT-8', 		
    //是否Gzip压缩后输出
    'gzip' 							=> 0, 					
    //密钥
    'auth_key' 						=> '', 
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
    
    'manifest' => storage_path().'/meta',
    
    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */
    
    'aliases' => array(
        'Royalcms'             => 'Royalcms\Component\Support\Facades\Royalcms',
        'royalcms'             => 'Royalcms\Component\Support\Facades\Royalcms',
        'Royalcmd'             => 'Royalcms\Component\Support\Facades\Royalcmd',
        'royalcmd'             => 'Royalcms\Component\Support\Facades\Royalcmd',
        'ClassLoader'          => 'Royalcms\Component\Support\ClassLoader',
        'ClassManager'         => 'Royalcms\Component\ClassLoader\ClassManager',
        

        'URL'                  => 'Royalcms\Component\Support\Facades\URL',
        
        'Route'                => 'Royalcms\Component\Support\Facades\Route',
        
        'File'                 => 'Royalcms\Component\Support\Facades\File',
        'RC_File'              => 'Royalcms\Component\Support\Facades\File',
        
        'RC_Error'             => 'Royalcms\Component\Support\Facades\Error',
        'RC_View'              => 'Royalcms\Component\Support\Facades\View',
        'RC_Validator'         => 'Royalcms\Component\Support\Facades\Validator',
        'RC_Redirect'          => 'Royalcms\Component\Support\Facades\Redirect',
        'RC_Debugbar'          => 'Royalcms\Component\Debugbar\Facades\Debugbar',
        'RC_Controller'        => 'Royalcms\Component\Routing\Controller',
        'RC_Request'           => 'Royalcms\Component\Support\Facades\Request',
        'RC_Response'          => 'Royalcms\Component\Support\Facades\Response',
        'RC_Cookie'            => 'Royalcms\Component\Support\Facades\Cookie',
        'RC_Lang'              => 'Royalcms\Component\Support\Facades\Lang',
        'RC_String'            => 'Royalcms\Component\Support\Str',
        'RC_Crypt'             => 'Royalcms\Component\Support\Facades\Crypt',
        'RC_Log'               => 'Royalcms\Component\Support\Facades\Log',
        'RC_Logger'            => 'Royalcms\Component\Support\Facades\Logger',
        'RC_LogViewer'         => 'Royalcms\Component\LogViewer\Facades\LogViewer',
        'RC_Config'            => 'Royalcms\Component\Support\Facades\Config',
        'RC_Cache'             => 'Royalcms\Component\Foundation\Cache',
        'RC_Session'           => 'Royalcms\Component\Support\Facades\Session',
        'RC_DB'                => 'Royalcms\Component\Support\Facades\DB',
        'RC_Eloquent'          => 'Royalcms\Component\Database\Eloquent\Model',
        'RC_Schema'            => 'Royalcms\Component\Support\Facades\Schema',
        'RC_Seeder'            => 'Royalcms\Component\Database\Seeder',
        'RC_Queue'             => 'Royalcms\Component\Support\Facades\Queue',
        'RC_Paginator'         => 'Royalcms\Component\Support\Facades\Paginator',
        'RC_Mail'              => 'Royalcms\Component\Support\Facades\Mail',
        'RC_Event'             => 'Royalcms\Component\Support\Facades\Event',
        'RC_Variable'          => 'Royalcms\Component\Support\Facades\Variable',
        'RC_Storage'           => 'Royalcms\Component\Support\Facades\Storage',
        'RC_Filesystem'        => 'Royalcms\Component\Support\Facades\Filesystem',
        'RC_Json'              => 'Royalcms\Component\Support\Json',
        'RC_Hook'              => 'Royalcms\Component\Support\Facades\Hook',
        'RC_Ip'                => 'Royalcms\Component\IpAddress\Ip',
        'RC_Upload'            => 'Royalcms\Component\Upload\Upload',
        'RC_Time'              => 'Royalcms\Component\DateTime\Time',
        'RC_Timer'             => 'Royalcms\Component\Timer\Facades\Timer',
        'RC_Format'            => 'Royalcms\Component\Support\Format',
        'RC_Package'           => 'Royalcms\Component\Support\Facades\Package',
        'RC_Error'             => 'Royalcms\Component\Error\Error',
        'RC_ENV'               => 'Royalcms\Component\Support\Facades\Environment',
        'RC_Hash'              => 'Royalcms\Component\Support\Facades\Hash',
        'RC_Password'          => 'Royalcms\Component\Support\Facades\Password',
        'RC_Redis'             => 'Royalcms\Component\Support\Facades\Redis',
        'RC_Notification'      => 'Royalcms\Component\Support\Facades\Notification',

        
        
        'RC_Object'            => 'Royalcms\Component\Foundation\Object',
        'RC_Model'             => 'Royalcms\Component\Model\ModelManage',
        'RC_Http'              => 'Royalcms\Component\HttpRequest\HttpRequest',        
        'RC_Uuid'              => 'Royalcms\Component\Uuid\Uuid',        
        
    
        //     'Form'            => 'Royalcms\Component\Support\Facades\Form',
        
        //     'HTML'            => 'Royalcms\Component\Support\Facades\HTML',
    //     'Input'           => 'Royalcms\Component\Support\Facades\Input',

//         'SSH'             => 'Royalcms\Component\Support\Facades\SSH',
    
    
        
        
        
        'RC_Array'          => 'Royalcms\Component\Foundation\ArrayHelper',
        'RC_Kses'           => 'Royalcms\Component\Foundation\Kses',
        'RC_Loader'         => 'Royalcms\Component\Foundation\Loader',
        'RC_Locale'         => 'Royalcms\Component\Foundation\Locale',
        'RC_Route'          => 'Royalcms\Component\Foundation\Route',
        'RC_Api'            => 'Royalcms\Component\Foundation\Api',
        'RC_App'            => 'Royalcms\Component\Foundation\App',
        'RC_Plugin'         => 'Royalcms\Component\Foundation\Plugin',
        'RC_Theme'          => 'Royalcms\Component\Foundation\Theme',
        'RC_Token'          => 'Royalcms\Component\Foundation\Token',
        'RC_Uri'            => 'Royalcms\Component\Foundation\Uri',
        'RC_Validate'       => 'Royalcms\Component\Foundation\Validate',
        'RC_Widget'         => 'Royalcms\Component\Foundation\Widget',
        'RC_Xml'            => 'Royalcms\Component\Foundation\Xml',
        
    ),
    
    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */
    
    'providers' => array(
        'Royalcms\Component\Encryption\EncryptionServiceProvider',
        'Royalcms\Component\Filesystem\FilesystemServiceProvider',
        'Royalcms\Component\FilesystemKernel\FilesystemServiceProvider',
        'Royalcms\Component\Cache\CacheServiceProvider',
        'Royalcms\Component\Log\LogServiceProvider',
        'Royalcms\Component\Cookie\CookieServiceProvider',
        'Royalcms\Component\Session\SessionServiceProvider',
        'Royalcms\Component\Routing\RoutingServiceProvider',
        'Royalcms\Component\Hook\HookServiceProvider',
        'Royalcms\Component\Timer\TimerServiceProvider',
        'Royalcms\Component\Script\ScriptServiceProvider',
        'Royalcms\Component\Foundation\Providers\PhpinfoServiceProvider',
        'Royalcms\Component\Translation\TranslationServiceProvider',
        'Royalcms\Component\Error\ErrorServiceProvider',
        'Royalcms\Component\Package\PackageServiceProvider',
        'Royalcms\Component\Database\DatabaseServiceProvider',
        'Royalcms\Component\Database\SeedServiceProvider',
        'Royalcms\Component\Database\MigrationServiceProvider',
        'Royalcms\Component\Mail\MailServiceProvider',
        'Royalcms\Component\Queue\QueueServiceProvider',
        'Royalcms\Component\Variable\VariableServiceProvider',
        'Royalcms\Component\Pagination\PaginationServiceProvider',
        'Royalcms\Component\Validation\ValidationServiceProvider',
        'Royalcms\Component\Notifications\NotificationServiceProvider',
        'Royalcms\Component\SmartyView\SmartyServiceProvider',
        'Royalcms\Component\Sentry\SentryServiceProvider',
        'Royalcms\Component\Rewrite\RewriteServiceProvider',
        'Royalcms\Component\Purifier\PurifierServiceProvider',
        'Royalcms\Component\LogViewer\LogViewerServiceProvider',
        

    
        // Command
        'Royalcms\Component\Foundation\Providers\RoyalcmdServiceProvider',
        'Royalcms\Component\Foundation\Providers\ConsoleSupportServiceProvider',
        'Royalcms\Component\Database\MigrationServiceProvider',
        //     'Royalcms\Component\Session\CommandsServiceProvider',
        //   'Royalcms\Component\Debugbar\DebugbarServiceProvider',
    
    
    //     'Royalcms\Component\View\ViewServiceProvider',
//         'Royalcms\Component\Routing\ControllerServiceProvider',
        
    
    //     'Royalcms\Component\Hashing\HashServiceProvider',
    //     'Royalcms\Component\Html\HtmlServiceProvider',

    //     'Royalcms\Component\Redis\RedisServiceProvider',
    //     'Royalcms\Component\Remote\RemoteServiceProvider',
    //     'Royalcms\Component\Workbench\WorkbenchServiceProvider',
    ),
    
    
);

// end
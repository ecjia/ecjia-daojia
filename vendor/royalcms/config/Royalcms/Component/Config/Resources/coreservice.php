<?php

return array(
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
        'Artisan'              => 'Royalcms\Component\Support\Facades\Artisan',
        'artisan'              => 'Royalcms\Component\Support\Facades\Artisan',
        'ClassLoader'          => 'Royalcms\Component\Support\ClassLoader',
        'ClassManager'         => 'Royalcms\Component\ClassLoader\ClassManager',
    
        // Support Facades
        'URL'                  => 'Royalcms\Component\Support\Facades\URL',
        'File'                 => 'Royalcms\Component\Support\Facades\File',

        'RC_Bus'               => 'Royalcms\Component\Support\Facades\Bus',
        'RC_Cache'             => 'Royalcms\Component\Support\Facades\Cache',
        'RC_Cookie'            => 'Royalcms\Component\Support\Facades\Cookie',
        'RC_Crypt'             => 'Royalcms\Component\Support\Facades\Crypt',
        'RC_Config'            => 'Royalcms\Component\Support\Facades\Config',
        'RC_Event'             => 'Royalcms\Component\Support\Facades\Event',
        'RC_File'              => 'Royalcms\Component\Support\Facades\File',
        'RC_DB'                => 'Royalcms\Component\Support\Facades\DB',
        'RC_Hash'              => 'Royalcms\Component\Support\Facades\Hash',
        'RC_Lang'              => 'Royalcms\Component\Support\Facades\Lang',
        'RC_Log'               => 'Royalcms\Component\Support\Facades\Log',
        'RC_Logger'            => 'Royalcms\Component\Support\Facades\Logger',
        'RC_Notification'      => 'Royalcms\Component\Support\Facades\Notification',
        'RC_Paginator'         => 'Royalcms\Component\Support\Facades\Paginator',
        'RC_Redirect'          => 'Royalcms\Component\Support\Facades\Redirect',
        'RC_Request'           => 'Royalcms\Component\Support\Facades\Request',
        'RC_Input'             => 'Royalcms\Component\Support\Facades\Input',
        'RC_Response'          => 'Royalcms\Component\Support\Facades\Response',
        'RC_Session'           => 'Royalcms\Component\Support\Facades\Session',
        'RC_Schema'            => 'Royalcms\Component\Support\Facades\Schema',
        'RC_Queue'             => 'Royalcms\Component\Support\Facades\Queue',
        'RC_Password'          => 'Royalcms\Component\Support\Facades\Password',
        'RC_Route'             => 'Royalcms\Component\Support\Facades\Route',
        'RC_Filesystem'        => 'Royalcms\Component\Storage\Facades\Storage',
        'RC_Validator'         => 'Royalcms\Component\Support\Facades\Validator',
        'RC_View'              => 'Royalcms\Component\Support\Facades\View',

        
        // Component Facades
        'RC_Debugbar'          => 'Royalcms\Component\Debugbar\Facades\Debugbar',
        'RC_LogViewer'         => 'Royalcms\Component\LogViewer\Facades\LogViewer',
        'RC_Mail'              => 'Royalcms\Component\Mail\Facades\Mail',
        'RC_Timer'             => 'Royalcms\Component\Timer\Facades\Timer',
        'RC_Gettext'           => 'Royalcms\Component\Gettext\Facades\Gettext',
        'RC_Locale'            => 'Royalcms\Component\Gettext\Facades\Gettext',
        'RC_Hook'              => 'Royalcms\Component\Hook\Facades\Hook',
        'RC_Package'           => 'Royalcms\Component\Package\Facades\Package',
        'RC_Error'             => 'Royalcms\Component\Error\Facades\Error',
        'RC_ENV'               => 'Royalcms\Component\Environment\Facades\Environment',
        'RC_Variable'          => 'Royalcms\Component\Variable\Facades\Variable',
        'RC_App'               => 'Royalcms\Component\App\Facades\App',
        'RC_Widget'            => 'Royalcms\Component\Widget\Facades\Widget',

        //other
        'RC_String'            => 'Royalcms\Component\Support\Str',
        'RC_Array'             => 'Royalcms\Component\Support\Arr',
        'RC_Json'              => 'Royalcms\Component\Support\Json',
        'RC_Controller'        => 'Royalcms\Component\Routing\Controller',
        'RC_Ip'                => 'Royalcms\Component\IpAddress\Ip',
        'RC_Time'              => 'Royalcms\Component\DateTime\Time',
        'RC_Model'             => 'Royalcms\Component\Model\ModelManage',
        'RC_Http'              => 'Royalcms\Component\HttpRequest\HttpRequest',
        'RC_Uuid'              => 'Royalcms\Component\Uuid\Uuid',
        'RC_Eloquent'          => 'Royalcms\Component\Database\Eloquent\Model',
        'RC_Seeder'            => 'Royalcms\Component\Database\Seeder',
        'RC_Format'            => 'Royalcms\Component\Support\Format',
        
    
        // Foundation
        'RC_Object'            => 'Royalcms\Component\Foundation\RoyalcmsObject',
        'RC_Kses'              => 'Royalcms\Component\Foundation\Kses',
        'RC_Loader'            => 'Royalcms\Component\Foundation\Loader',
        'RC_Api'               => 'Royalcms\Component\Foundation\Api',
        'RC_Plugin'            => 'Royalcms\Component\Foundation\Plugin',
        'RC_Theme'             => 'Royalcms\Component\Foundation\Theme',
        'RC_Token'             => 'Royalcms\Component\Foundation\Token',
        'RC_Uri'               => 'Royalcms\Component\Foundation\Uri',
        'RC_Validate'          => 'Royalcms\Component\Foundation\Validate',
        'RC_Xml'               => 'Royalcms\Component\Foundation\Xml',
        

        // Compatible
        'Component_Database_Database'           => 'Royalcms\Component\Model\Database\Database',
        'Component_Database_Factory'            => 'Royalcms\Component\Model\Database\DatabaseFactory',
        'Component_Database_Interface'          => 'Royalcms\Component\Model\Database\DatabaseInterface',
        'Component_Database_Mysql'              => 'Royalcms\Component\Model\Database\Mysql',
        'Component_Database_Mysqli'             => 'Royalcms\Component\Model\Database\Mysqli',
        'Component_Database_Pdo'                => 'Royalcms\Component\Model\Database\Pdo',
        'Component_Model_Model'                 => 'Royalcms\Component\Model\Model',
        'Component_Model_Null'                  => 'Royalcms\Component\Model\NullModel',
        'Component_Model_Relation'              => 'Royalcms\Component\Model\RelationModel',
        'Component_Model_View'                  => 'Royalcms\Component\Model\ViewModel',

        'Component_WeChat_ErrorCode'            => 'Royalcms\Component\WeChat\ErrorCode',
        'Component_WeChat_ParameterBag'         => 'Royalcms\Component\WeChat\ParameterBag',
        'Component_WeChat_Prpcrypt'             => 'Royalcms\Component\WeChat\Prpcrypt',
        'Component_WeChat_Request'              => 'Royalcms\Component\WeChat\Request',
        'Component_WeChat_Response'             => 'Royalcms\Component\WeChat\Response',
        'Component_WeChat_Utility'              => 'Royalcms\Component\WeChat\Utility',
        'Component_WeChat_WeChat'               => 'Royalcms\Component\WeChat\WeChat',
        'Component_WeChat_WeChatAPI'            => 'Royalcms\Component\WeChat\WeChatAPI',
        'Component_WeChat_WeChatCorp'           => 'Royalcms\Component\WeChat\WeChatCorp',
        'Component_WeChat_WeChatCorpAPI'        => 'Royalcms\Component\WeChat\WeChatCorpAPI',

        'Component_Error_ErrorDisplay'          => 'Royalcms\Component\Error\ErrorDisplay',

        'Component_Page_Page'                   => 'Royalcms\Component\Page\Page',
        'Component_Page_Default'                => 'Royalcms\Component\Page\DefaultPage',

        'Component_ImageEditor_Editor'          => 'Royalcms\Component\ImageEditor\Editor',
        'Component_ImageEditor_GD'              => 'Royalcms\Component\ImageEditor\GD',
        'Component_ImageEditor_Imagick'         => 'Royalcms\Component\ImageEditor\Imagick',

        'Component_Editor_Editor'               => 'Royalcms\Component\Editor\Editor',
        'Component_Editor_Quicktags'            => 'Royalcms\Component\Editor\Quicktags',
        'Component_Editor_Tinymce'              => 'Royalcms\Component\Editor\Tinymce',

        'Component_Widget_Control'              => 'Royalcms\Component\Widget\WidgetController',
        'Component_Widget_Factory'              => 'Royalcms\Component\Widget\Factory',
        'Component_Widget_Widget'               => 'Royalcms\Component\Widget\Widget',

        //     'Form'            => 'Royalcms\Component\Support\Facades\Form',
        //     'HTML'            => 'Royalcms\Component\Support\Facades\HTML',

    ),
    
    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | [router event exception] providers loaded.
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */
    
    'providers' => array(

        'Royalcms\Component\Bus\BusServiceProvider',
        'Royalcms\Component\Filesystem\FilesystemServiceProvider',
        'Royalcms\Component\Database\DatabaseServiceProvider',
        'Royalcms\Component\Database\SeedServiceProvider',
        'Royalcms\Component\Database\MigrationServiceProvider',
        'Royalcms\Component\Cache\CacheServiceProvider',
        'Royalcms\Component\Encryption\EncryptionServiceProvider',
        'Royalcms\Component\Log\LogServiceProvider',
        'Royalcms\Component\Routing\ControllerServiceProvider',
        'Royalcms\Component\Cookie\CookieServiceProvider',
        'Royalcms\Component\Session\SessionServiceProvider',
        'Royalcms\Component\Translation\TranslationServiceProvider',
        'Royalcms\Component\Pagination\PaginationServiceProvider',
        'Royalcms\Component\Validation\ValidationServiceProvider',
        'Royalcms\Component\Notifications\NotificationServiceProvider',
        'Royalcms\Component\Queue\QueueServiceProvider',
        'Royalcms\Component\Mail\MailServiceProvider',
        'Royalcms\Component\View\ViewServiceProvider',


        'Royalcms\Component\Gettext\GettextServiceProvider',
        'Royalcms\Component\Hook\HookServiceProvider',
        'Royalcms\Component\Package\PackageServiceProvider',
        'Royalcms\Component\App\AppServiceProvider',
        'Royalcms\Component\Variable\VariableServiceProvider',
        'Royalcms\Component\Rewrite\RewriteServiceProvider',
        'Royalcms\Component\Storage\StorageServiceProvider',
        'Royalcms\Component\Timer\TimerServiceProvider',
        'Royalcms\Component\Script\ScriptServiceProvider',
        'Royalcms\Component\Error\ErrorServiceProvider',
        'Royalcms\Component\DefaultRoute\DefaultRouteServiceProvider',


        // Foundation
        'Royalcms\Component\Foundation\Providers\FoundationServiceProvider',

        // Command
        'Royalcms\Component\Foundation\Providers\ArtisanServiceProvider',
        'Royalcms\Component\Foundation\Providers\ComposerServiceProvider',
        'Royalcms\Component\Foundation\Providers\ConsoleSupportServiceProvider',



        //   'Royalcms\Component\Debugbar\DebugbarServiceProvider',
    
    

        //     'Royalcms\Component\Hashing\HashServiceProvider',
        //     'Royalcms\Component\Html\HtmlServiceProvider',
    
        //     'Royalcms\Component\Redis\RedisServiceProvider',
        //     'Royalcms\Component\Remote\RemoteServiceProvider',
        //     'Royalcms\Component\Workbench\WorkbenchServiceProvider',

        'Royalcms\Component\Sentry\SentryServiceProvider',
    ),
);

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
        'RC_Storage'           => 'Royalcms\Component\Storage\Facades\Storage',
        'RC_Filesystem'        => 'Royalcms\Component\Support\Facades\Storage',
        'RC_Json'              => 'Royalcms\Component\Support\Json',
        'RC_Hook'              => 'Royalcms\Component\Support\Facades\Hook',
        'RC_Ip'                => 'Royalcms\Component\IpAddress\Ip',
        'RC_Upload'            => 'Royalcms\Component\Upload\Upload',
        'RC_Time'              => 'Royalcms\Component\DateTime\Time',
        'RC_Timer'             => 'Royalcms\Component\Timer\Facades\Timer',
        'RC_Format'            => 'Royalcms\Component\Support\Format',
        'RC_Package'           => 'Royalcms\Component\Support\Facades\Package',
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
        'Royalcms\Component\Storage\StorageServiceProvider',
        'Royalcms\Component\Gettext\GettextServiceProvider',
    
    
    
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
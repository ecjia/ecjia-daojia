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
        'Royalcms'     => 'Royalcms\Component\Support\Facades\Royalcms',
        'royalcms'     => 'Royalcms\Component\Support\Facades\Royalcms',
        'Artisan'      => 'Royalcms\Component\Support\Facades\Artisan',
        'artisan'      => 'Royalcms\Component\Support\Facades\Artisan',
        'ClassLoader'  => 'Royalcms\Component\Support\ClassLoader',
        'ClassManager' => 'Royalcms\Component\ClassLoader\ClassManager',

        // Support Facades
        'URL'          => 'Royalcms\Component\Support\Facades\URL',
        'File'         => 'Royalcms\Component\Support\Facades\File',

        'RC_Bus'                       => 'Royalcms\Component\Support\Facades\Bus',
        'RC_Cache'                     => 'Royalcms\Component\Support\Facades\Cache',
        'RC_Cookie'                    => 'Royalcms\Component\Support\Facades\Cookie',
        'RC_Crypt'                     => 'Royalcms\Component\Support\Facades\Crypt',
        'RC_Config'                    => 'Royalcms\Component\Support\Facades\Config',
        'RC_Event'                     => 'Royalcms\Component\Support\Facades\Event',
        'RC_File'                      => 'Royalcms\Component\Support\Facades\File',
        'RC_DB'                        => 'Royalcms\Component\Support\Facades\DB',
        'RC_Hash'                      => 'Royalcms\Component\Support\Facades\Hash',
        'RC_Lang'                      => 'Royalcms\Component\Support\Facades\Lang',
        'RC_Log'                       => 'Royalcms\Component\Support\Facades\Log',
        'RC_Logger'                    => 'Royalcms\Component\Support\Facades\Logger',
        'RC_Notification'              => 'Royalcms\Component\Support\Facades\Notification',
        'RC_Paginator'                 => 'Royalcms\Component\Support\Facades\Paginator',
        'RC_Redirect'                  => 'Royalcms\Component\Support\Facades\Redirect',
        'RC_Request'                   => 'Royalcms\Component\Support\Facades\Request',
        'RC_Input'                     => 'Royalcms\Component\Support\Facades\Input',
        'RC_Response'                  => 'Royalcms\Component\Support\Facades\Response',
        'RC_Session'                   => 'Royalcms\Component\Support\Facades\Session',
        'RC_Schema'                    => 'Royalcms\Component\Support\Facades\Schema',
        'RC_Queue'                     => 'Royalcms\Component\Support\Facades\Queue',
        'RC_Password'                  => 'Royalcms\Component\Support\Facades\Password',
        'RC_Route'                     => 'Royalcms\Component\Support\Facades\Route',
        'RC_Filesystem'                => 'Royalcms\Component\Storage\Facades\Storage',
        'RC_Validator'                 => 'Royalcms\Component\Support\Facades\Validator',
        'RC_View'                      => 'Royalcms\Component\Support\Facades\View',
        'RC_Mail'                      => 'Royalcms\Component\Support\Facades\Mail',


        // Component Facades
        'RC_Debugbar'                  => 'Royalcms\Component\Debugbar\Facades\Debugbar',
        'RC_Timer'                     => 'Royalcms\Component\Timer\Facades\Timer',
        'RC_Gettext'                   => 'Royalcms\Component\Gettext\Facades\Gettext',
        'RC_Locale'                    => 'Royalcms\Component\Gettext\Facades\Gettext',
        'RC_Hook'                      => 'Royalcms\Component\Hook\Facades\Hook',
        'RC_Package'                   => 'Royalcms\Component\Package\Facades\Package',
        'RC_Error'                     => 'Royalcms\Component\Error\Facades\Error',
        'RC_ENV'                       => 'Royalcms\Component\Environment\Facades\Environment',
        'RC_Variable'                  => 'Royalcms\Component\Variable\Facades\Variable',
        'RC_Widget'                    => 'Royalcms\Component\Widget\Facades\Widget',
        'RC_Uri'                       => 'Royalcms\Component\Url\Facades\Uri',
        'RC_Url'                       => 'Royalcms\Component\Url\Url',
        'RC_Theme'                     => 'Royalcms\Component\Theme\Facades\Theme',
        'RC_Plugin'                    => 'Royalcms\Component\Plugin\Facades\Plugin',

        //other
        'RC_String'                    => 'Royalcms\Component\Support\Str',
        'RC_Array'                     => 'Royalcms\Component\Support\Arr',
        'RC_Json'                      => 'Royalcms\Component\Support\Json',
        'RC_Controller'                => 'Royalcms\Component\Routing\Controller',
        'RC_Ip'                        => 'Royalcms\Component\IpAddress\Ip',
        'RC_Time'                      => 'Royalcms\Component\DateTime\Time',
        'RC_Model'                     => 'Royalcms\Component\Model\ModelManage',
        'RC_Http'                      => 'Royalcms\Component\HttpRequest\HttpRequest',
        'RC_Uuid'                      => 'Royalcms\Component\Uuid\Uuid',
        'RC_Eloquent'                  => 'Royalcms\Component\Database\Eloquent\Model',
        'RC_Seeder'                    => 'Royalcms\Component\Database\Seeder',
        'RC_Format'                    => 'Royalcms\Component\Support\Format',


        // Foundation
        'RC_Object'                    => 'Royalcms\Component\Foundation\RoyalcmsObject',
        'RC_Kses'                      => 'Royalcms\Component\Foundation\Kses',
        'RC_Token'                     => 'Royalcms\Component\Foundation\Token',
        'RC_Validate'                  => 'Royalcms\Component\Foundation\Validate',
        'RC_Xml'                       => 'Royalcms\Component\Foundation\Xml',


        // Compatible
        'Component_Database_Database'       => 'Royalcms\Component\Model\Database\Database',
        'Component_Database_Factory'        => 'Royalcms\Component\Model\Database\DatabaseFactory',
        'Component_Database_Interface'      => 'Royalcms\Component\Model\Database\DatabaseInterface',
        'Component_Database_Mysql'          => 'Royalcms\Component\Model\Database\Mysql',
        'Component_Database_Mysqli'         => 'Royalcms\Component\Model\Database\Mysqli',
        'Component_Database_Pdo'            => 'Royalcms\Component\Model\Database\Pdo',
        'Component_Model_Model'             => 'Royalcms\Component\Model\Model',
        'Component_Model_Null'              => 'Royalcms\Component\Model\NullModel',
        'Component_Model_Relation'          => 'Royalcms\Component\Model\RelationModel',
        'Component_Model_View'              => 'Royalcms\Component\Model\ViewModel',
        'Component_Error_ErrorDisplay'      => 'Royalcms\Component\Error\ErrorDisplay',
        'Component_ImageEditor_Editor'      => 'Royalcms\Component\ImageEditor\Editor',
        'Component_ImageEditor_GD'          => 'Royalcms\Component\ImageEditor\GD',
        'Component_ImageEditor_Imagick'     => 'Royalcms\Component\ImageEditor\Imagick',
        'Component_Editor_Editor'           => 'Royalcms\Component\Editor\Editor',
        'Component_Editor_Quicktags'        => 'Royalcms\Component\Editor\Quicktags',
        'Component_Editor_Tinymce'          => 'Royalcms\Component\Editor\Tinymce',
        'Component_Event_Event'             => 'Royalcms\Component\Event\Event',
        'Component_Event_Api'               => 'Royalcms\Component\Event\Api',
        
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
        'Royalcms\Component\Database\DatabaseServiceProvider',
        'Royalcms\Component\Cache\CacheServiceProvider',
        'Royalcms\Component\Log\LogServiceProvider',
        'Royalcms\Component\Encryption\EncryptionServiceProvider',
        'Royalcms\Component\Routing\ControllerServiceProvider',
        'Royalcms\Component\Cookie\CookieServiceProvider',
        'Royalcms\Component\Session\SessionServiceProvider',
        'Royalcms\Component\Translation\TranslationServiceProvider',
        'Royalcms\Component\Pagination\PaginationServiceProvider',
        'Royalcms\Component\Validation\ValidationServiceProvider',
        'Royalcms\Component\Notifications\NotificationServiceProvider',
        'Royalcms\Component\Redis\RedisServiceProvider',
        'Royalcms\Component\Queue\QueueServiceProvider',
        'Royalcms\Component\Mail\MailServiceProvider',
        'Royalcms\Component\View\ViewServiceProvider',

        // Foundation
        'Royalcms\Component\Foundation\Providers\FoundationServiceProvider',

        // Command
        'Royalcms\Component\Foundation\Providers\ConsoleSupportServiceProvider',
    ),
);

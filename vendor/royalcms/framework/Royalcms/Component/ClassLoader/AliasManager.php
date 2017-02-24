<?php namespace Royalcms\Component\ClassLoader;

class AliasManager
{
    /**
     * Registers PhpParser\Autoloader as an SPL autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader instead of appending
     */
    static public function register($prepend = false) {
        if (self::$registered === true) {
            return;
        }
    
        spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
        self::$registered = true;
    }
    
    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     */
    static public function autoload($class) {
        if (isset(self::$nonNamespacedAliases[$class])) {
            // Register all aliases at once to avoid dependency issues
            self::registerNonNamespacedAliases($class);
        }
    }
    
    private static function registerNonNamespacedAliases($alias) {
        return class_alias(self::$nonNamespacedAliases[$alias], $alias);
    }
    
    /** @var bool Whether the autoloader has been registered. */
    private static $registered = false;
    
    private static $nonNamespacedAliases = array(
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
        
        'Component_Widget_Control'              => 'Royalcms\Component\Widget\Control',
        'Component_Widget_Factory'              => 'Royalcms\Component\Widget\Factory',
        'Component_Widget_Widget'               => 'Royalcms\Component\Widget\Widget',
    );
}

// end
<?php namespace Royalcms\Component\Memcache;
/**
 * Factory for communication with Memcache Server
 *
 */
class CommandFactory
{
    private static $_object = array();

    /* No explicit call of constructor */
    private function __construct() {}

    /* No explicit call of clone() */
    private function __clone() {}

    /**
     * Accessor to command class instance by command type
     *
     * @param String $command Type of command
     *
     * @return void
     */
    public static function instance($command)
    {
        /* Importing configuration */
        $config = royalcms('config')->get('memcache::config');

        /* Instance does not exists */
        if(!isset(self::$_object[$config[$command]]) || ($config[$command] != 'Server'))
        {
            /* Switching by API */
            switch($config[$command])
            {
                case 'Memcache':
                    /* PECL Memcache API */
                    self::$_object['Memcache'] = new MemcacheHandler();
                    break;

                case 'Memcached':
                    /* PECL Memcached API */
                    self::$_object['Memcached'] = new MemcachedHandler();
                    break;

                case 'Server':
                default:
                    /* Server API (eg communicating directly with the memcache server) */
                    self::$_object['Server'] = new ServerHandler();
                    break;
            }
        }
        return self::$_object[$config[$command]];
    }

    /**
     * Accessor to command class instance by type
     *
     * @param String $command Type of command
     *
     * @return void
     */
    public static function api($api)
    {
        /* Instance does not exists */
        if (!isset(self::$_object[$api]) || ($api != 'Server'))
        {
            /* Switching by API */
            switch($api)
            {
                case 'Memcache':
                    /* PECL Memcache API */
                    self::$_object['Memcache'] = new MemcacheHandler();
                    break;

                case 'Memcached':
                    /* PECL Memcached API */
                    self::$_object['Memcached'] = new MemcachedHandler();
                    break;

                case 'Server':
                default:
                    /* Server API (eg communicating directly with the memcache server) */
                    self::$_object['Server'] = new ServerHandler();
                    break;
            }
        }
        return self::$_object[$api];
    }
}

// end
<?php namespace Royalcms\Component\Memcache;
/**
 * Sending command to memcache server via PECL memcache API http://pecl.php.net/package/memcache
 * 
 */
class MemcachedHandler implements CommandInterface
{
    private static $_ini;
    private static $_memcache;

    /**
     * Constructor
     *
     * @param Array $ini Array from ini_parse
     *
     * @return void
     */
    public function __construct()
    {
        if (!extension_loaded('memcached')) {
            throw new \ErrorException('Memcached not support!');
        }
        
        # Importing configuration
        self::$_ini = royalcms('config')->get('memcache::config');
        
        # Initializing
        self::$_memcache = new \Memcached();
    }

    /**
     * Send stats command to server
     * Return the result if successful or false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     *
     * @return Array|Boolean
     */
    public function stats($server, $port)
    {
        # Adding server
        self::$_memcache->addServer($server, $port);

        # Executing command
        if(($return = self::$_memcache->getStats()) != false)
        {
            # Delete server key based
            $stats = $return[$server.':'.$port];

            # Adding value that miss
            $stats['delete_hits'] = '';
            $stats['delete_misses'] = '';
            $stats['incr_hits'] = '';
            $stats['incr_misses'] = '';
            $stats['decr_hits'] = '';
            $stats['decr_misses'] = '';
            $stats['cas_hits'] = '';
            $stats['cas_misses'] = '';
            $stats['cas_badval'] = '';

            return $stats;
        }
        return false;
    }

    /**
     * Send stats settings command to server
     * Return the result if successful or false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     *
     * @return Array|Boolean
     */
    public function settings($server, $port)
    {
        return false;
    }

    /**
     * Send stats items command to server to retrieve slabs stats
     * Return the result if successful or false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     *
     * @return Array|Boolean
     */
    public function slabs($server, $port)
    {
        throw new \Exception('PECL Memcache does not support slabs stats, use Server or Memcache instead');
    }

    /**
     * Send stats cachedump command to server to retrieve slabs items
     * Return the result if successful or false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param Interger $slab Slab ID
     *
     * @return Array|Boolean
     */
    public function items($server, $port, $slab)
    {
        throw new \Exception('PECL Memcache does not support slabs items stats, use Server or Memcache instead');
    }

    /**
     * Send get command to server to retrieve an item
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to retrieve
     *
     * @return String
     */
    public function get($server, $port, $key)
    {
        # Adding server
        self::$_memcache->addServer($server, $port);

        # Executing command : get
        if(($item = self::$_memcache->get($key)) != false)
        {
            return print_r($item, true);
        }
        return self::$_memcache->getResultMessage();
    }
    
    /**
     * Set an item
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to store
     * @param Mixed $data Data to store
     * @param Integer $duration Duration
     *
     * @return String
     */
    function set($server, $port, $key, $data, $duration)
    {
    # Adding server
        self::$_memcache->addServer($server, $port);
    
        # Checking duration
        if ($duration == '') { $duration = 0; }
    
        # Executing command : set
        self::$_memcache->set($key, $data, $duration);
        return self::$_memcache->getResultMessage();
    }

    /**
     * Add an item
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to store
     * @param Mixed $data Data to store
     * @param Integer $duration Duration
     *
     * @return String
     */
    function add($server, $port, $key, $data, $duration)
    {
        # Adding server
        self::$_memcache->addServer($server, $port);

        # Checking duration
        if ($duration == '') { $duration = 0; }

        # Executing command : set
        self::$_memcache->add($key, $data, $duration);
        return self::$_memcache->getResultMessage();
    }
    
    /**
     * Replace an item
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to store
     * @param Mixed $data Data to store
     * @param Integer $duration Duration
     *
     * @return String
     */
    function replace($server, $port, $key, $data, $duration)
    {
        # Adding server
        self::$_memcache->addServer($server, $port);
    
        # Checking duration
        if ($duration == '') { $duration = 0; }
    
        # Executing command : set
        self::$_memcache->replace($key, $data, $duration);
        return self::$_memcache->getResultMessage();
    }

    /**
     * Delete an item
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to delete
     *
     * @return String
     */
    public function delete($server, $port, $key)
    {
        # Adding server
        self::$_memcache->addServer($server, $port);

        # Executing command : delete
        self::$_memcache->delete($key);
        return self::$_memcache->getResultMessage();
    }

    /**
     * Increment the key by value
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to increment
     * @param Integer $value Value to increment
     *
     * @return String
     */
    function increment($server, $port, $key, $value)
    {
        # Adding server
        self::$_memcache->addServer($server, $port);

        # Executing command : increment
        if(($result = self::$_memcache->increment($key, $value)) != false)
        {
            return $result;
        }
        return self::$_memcache->getResultMessage();
    }

    /**
     * Decrement the key by value
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to decrement
     * @param Integer $value Value to decrement
     *
     * @return String
     */
    function decrement($server, $port, $key, $value)
    {
        # Adding server
        self::$_memcache->addServer($server, $port);

        # Executing command : decrement
        if(($result = self::$_memcache->decrement($key, $value)) != false)
        {
            return $result;
        }
        return self::$_memcache->getResultMessage();
    }

    /**
     * Flush all items on a server
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param Integer $delay Delay before flushing server
     *
     * @return String
     */
    public function flush($server, $port, $delay)
    {
        # Adding server
        self::$_memcache->addServer($server, $port);

        # Executing command : delete
        self::$_memcache->flush($delay);
        return self::$_memcache->getResultMessage();
    }

    /**
     * Search for item
     * Return all the items matching parameters if successful, false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to search
     *
     * @return Array
     */
    function search($server, $port, $search)
    {
        throw new \Exception('PECL Memcached does not support search function, use Server instead');
    }

    /**
     * Execute a telnet command on a server
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $command Command to execute
     *
     * @return String
     */
    function telnet($server, $port, $command)
    {
        throw new \Exception('PECL Memcached does not support telnet, use Server instead');
    }
}

// end
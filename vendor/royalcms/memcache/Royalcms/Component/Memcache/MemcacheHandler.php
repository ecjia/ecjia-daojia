<?php namespace Royalcms\Component\Memcache;

/**
 * Sending command to memcache server via PECL memcache API http://pecl.php.net/package/memcache
 *
 */
class MemcacheHandler implements CommandInterface
{
    private static $_ini;
    private static $_memcache;
    
    protected $resultMessage;

    /**
     * Constructor
     *
     * @param Array $ini Array from ini_parse
     *
     * @return void
     */
    public function __construct()
    {
        if (!extension_loaded('memcache')) {
            throw new \ErrorException('Memcache not support!');
        }
        
        /* Importing configuration */
        self::$_ini = royalcms('config')->get('memcache::config');

        /* Initializing */
        self::$_memcache = new \Memcache();
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
        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command */
        $return = self::$_memcache->getExtendedStats();
        if ($return)
        {
            /* Delete server key based */
            $stats = $return[$server.':'.$port];
            return $stats;
        }
        return false;
    }
    
    /**
     * Send sizes command to server
     * Return the result if successful or false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     *
     * @return Array|Boolean
     */
    public function sizes($server, $port)
    {
        /* Adding server */
        self::$_memcache->addServer($server, $port);
    
        /* Executing command */
        $return = self::$_memcache->getExtendedStats('sizes');
        if ($return)
        {
            /* Delete server key based */
            $stats = $return[$server.':'.$port];
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
        /* Initializing */
        $slabs = array();

        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command : slabs */
        $slabs = self::$_memcache->getStats('slabs');
        if ($slabs)
        {
            /* Finding uptime */
            $stats = $this->stats($server, $port);
            $slabs['uptime'] = $stats['uptime'];
            unset($stats);

            /* Executing command : items */
            $result = self::$_memcache->getStats('items');
            if($result)
            {
                /* Indexing by slabs */
                foreach($result['items'] as $id => $items)
                {
                    foreach($items as $key => $value)
                    {
                        $slabs[$id]['items:' . $key] = $value;
                    }
                }
                return $slabs;
            }
        }
        return false;
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
        /* Initializing */
        $items = false;

        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command : slabs stats */
        $items = self::$_memcache->getStats('cachedump', $slab, self::$_ini['max_item_dump']);
        return $items;
    }
    
    /**
     * Send stats cachedump command to server to retrieve slabs items
     * Return the result if successful or false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param Interger $slab Slab ID
     * @param Interger $maxnum Max num
     *
     * @return Array|Boolean
     */
    public function cachedump($server, $port, $slab, $maxnum)
    {
        /* Initializing */
        $items = false;
        
        /* Adding server */
        self::$_memcache->addServer($server, $port);
        
        /* Executing command : slabs stats */
        $items = self::$_memcache->getStats('cachedump', $slab, $maxnum);
        return $items;
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
        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command : get */
        $item = self::$_memcache->get($key);
        return $item;
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
        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command : set */
        if (self::$_memcache->set($key, $data, 0, $duration)) 
        {
            return true;
        } 
        else 
        {
            $this->resultMessage = 'ERROR';
            return false;
        }
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
        /* Adding server */
        self::$_memcache->addServer($server, $port);
    
        /* Executing command : set */
        if (self::$_memcache->add($key, $data, 0, $duration))
        {
            return true;
        } 
        else 
        {
            $this->resultMessage = 'ERROR';
            return false;
        }
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
        /* Adding server */
        self::$_memcache->addServer($server, $port);
    
        /* Executing command : replace */
        if (self::$_memcache->replace($key, $data, 0, $duration))
        {
            return true;
        }
        else 
        {
            $this->resultMessage = 'ERROR';
            return false;
        }
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
        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command : delete */
        if (self::$_memcache->delete($key))
        {
            return true;
        }
        else 
        {
            $this->resultMessage = 'NOT_FOUND';
            return false;
        }
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
        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command : increment */
        $result = self::$_memcache->increment($key, $value);
        if ($result)
        {
            return $result;
        }
        else 
        {
            $this->resultMessage = 'NOT_FOUND';
            return false;
        }
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
        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command : decrement */
        $result = self::$_memcache->decrement($key, $value);
        if ($result)
        {
            return $result;
        }
        else 
        {
            $this->resultMessage = 'NOT_FOUND';
            return false;
        }
    }

    /**
     * Flush all items on a server
     * Warning, delay won't work with Memcache API
     * Return the result
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param Integer $delay Delay before flushing server
     *
     * @return String
     */
    function flush($server, $port, $delay)
    {
        /* Adding server */
        self::$_memcache->addServer($server, $port);

        /* Executing command : flush_all */
        if (self::$_memcache->flush())
        {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Search for item
     * Return all the items matching parameters if successful, false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to search
     * @param String $level Level of Detail
     * @param String $more More action
     *
     * @return array
     */
    function search($server, $port, $search, $level = false, $more = false)
    {
        throw new \Exception('PECL Memcache does not support search function, use Server instead');
        
        return false;
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
        throw new \Exception('PECL Memcache does not support telnet, use Server instead');
        
        return false;
    }
    
    public function getResultMessage()
    {
        return $this->resultMessage;
    }
    
    
    public function getMemcache()
    {
        return self::$_memcache;
    }
}

// end
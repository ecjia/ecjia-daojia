<?php namespace Royalcms\Component\Memcache;
/**
 * Sending command to memcache server
 * 
 */
class ServerHandler implements CommandInterface
{
    private static $_ini;
    private static $_log;

    /**
     * Constructor
     *
     * @param Array $ini Array from ini_parse
     *
     * @return void
     */
    public function __construct()
    {
        /* Importing configuration */
        self::$_ini = royalcms('config')->get('memcache::config');
    }

    /**
     * Executing a Command on a MemCache Server
     * With the help of http://github.com/memcached/memcached/blob/master/doc/protocol.txt
     * Return the response, or false otherwise
     *
     * @param String $command Command
     * @param String $server Server Hostname
     * @param Integer $port Server Port
     *
     * @return String|Boolean
     */
    public function exec($command, $server, $port)
    {
        /* Variables */
        $buffer = '';
        $handle = null;
        
        /* Socket Opening */
        if (!($handle = @fsockopen($server, $port, $errno, $errstr, self::$_ini['connection_timeout'])))
        {
            /* Adding error to log */
            self::$_log = utf8_encode($errstr);
            royalcms('memcache')->getDataError()->add(utf8_encode($errstr));
            return false;
        }
        
        /* Sending Command ... */
        fwrite($handle, $command . "\r\n");

        /* Getting first line */
        $buffer = fgets($handle);

        /* Checking if result is valid */
        if ($this->end($buffer, $command))
        {
            /* Closing socket */
            fclose($handle);

            /* Adding error to log */
            self::$_log = $buffer;

            return $buffer;
        }

        /* Reading Results */
        while ((!feof($handle)))
        {
            /* Getting line */
            $line = fgets($handle);

            $buffer .= $line;

            /* Checking for end of MemCache command */
            if ($this->end($line, $command))
            {
                break;
            }
        }
        /* Closing socket */
        fclose($handle);

        return $buffer;
    }

    /**
     * Check if response is at the end from memcached server
     * Return true if response end, true otherwise
     *
     * @param String $buffer Buffer received from memcached server
     * @param String $command Command issued to memcached server
     *
     * @return Boolean
     */
    private function end($buffer, $command)
    {
        /* incr or decr also return integer */
        if ((preg_match('/^(incr|decr)/', $command)))
        {
            if (preg_match('/^(END|ERROR|SERVER_ERROR|CLIENT_ERROR|NOT_FOUND|[0-9]*)/', $buffer))
            {
                return true;
            }
        }
        else
        {
            /* Checking command response end */
            if (preg_match('/^(END|DELETED|OK|ERROR|SERVER_ERROR|CLIENT_ERROR|NOT_FOUND|STORED|RESET|TOUCHED)/', $buffer))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Parse result to make an array
     *
     * @param String $string String to parse
     * @param Boolean $string (optionnal) Parsing stats ?
     *
     * @return Array
     */
    public function parse($string, $stats = true)
    {
        /* Variable */
        $return = array();

        /* Exploding by \r\n */
        $lines = preg_split('/\r\n/', $string);

        /* Stats */
        if ($stats)
        {
            /* Browsing each line */
            foreach ($lines as $line)
            {
                $data = preg_split('/ /', $line);
                if (isset($data[2]))
                {
                    $return[$data[1]] = $data[2];
                }
            }
        }
        /* Items */
        else
        {
            /* Browsing each line */
            foreach ($lines as $line)
            {
                $data = preg_split('/ /', $line);
                if (isset($data[1]))
                {
                    $return[$data[1]] = array(substr($data[2], 1), $data[4]);
                }
            }
        }
        return $return;
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
        /* Executing command */
        $return = $this->exec('stats', $server, $port);
        if ($return)
        {
            return $this->parse($return);
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
        /* Executing command */
        $return = $this->exec('stats settings', $server, $port);
        if ($return)
        {
            return $this->parse($return);
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
        /* Executing command */
        $return = $this->exec('stats sizes', $server, $port);
        if ($return)
        {
            return $this->parse($return);
        }
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

        /* Finding uptime */
        $stats = $this->stats($server, $port);
        $slabs['uptime'] = $stats['uptime'];
        unset($stats);

        /* Executing command : slabs stats */
        $result = $this->exec('stats slabs', $server, $port);
        if ($result)
        {
            /* Parsing result */
            $result = $this->parse($result);
            $slabs['active_slabs'] = $result['active_slabs'];
            $slabs['total_malloced'] = $result['total_malloced'];
            unset($result['active_slabs']);
            unset($result['total_malloced']);

            /* Indexing by slabs */
            foreach($result as $key => $value)
            {
                $key = preg_split('/:/', $key);
                $slabs[$key[0]][$key[1]] = $value;
            }

            /* Executing command : items stats */
            if(($result = $this->exec('stats items', $server, $port)) != false)
            {
                /* Parsing result */
                $result = $this->parse($result);

                /* Indexing by slabs */
                foreach($result as $key => $value)
                {
                    $key = preg_split('/:/', $key);
                    $slabs[$key[1]]['items:' . $key[2]] = $value;
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
        
        /* Executing command : stats cachedump */
        $result = $this->exec('stats cachedump ' . $slab . ' ' . self::$_ini['max_item_dump'], $server, $port);
        if ($result)
        {
            /* Parsing result */
            $items = $this->parse($result, false);
        }
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
    
        /* Executing command : stats cachedump */
        $result = $this->exec('stats cachedump ' . $slab . ' ' . $maxnum, $server, $port);
        if ($result)
        {
            /* Parsing result */
            $items = $this->parse($result, false);
        }
        return $items;
    }

    /**
     * Send get command to server to retrieve an item
     * Return the result if successful or false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to retrieve
     *
     * @return String
     */
    public function get($server, $port, $key)
    {
        /* Executing command : get */
        $string = $this->exec('get ' . $key, $server, $port);
        if ($string)
        {
            $string = preg_replace('/^VALUE ' . preg_quote($key, '/') . '[0-9 ]*\r\n/', '', $string);
            if (ord($string[0]) == 0x78 && in_array(ord($string[1]), array(0x01, 0x5e, 0x9c, 0xda))) {
                return gzuncompress($string);
            }
            return $string;
        }
        else 
        {
            return false;
        }
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
        /* Formatting data */
        $data = preg_replace('/\r/', '', $data);

        /* Executing command : set */
        $result = $this->exec('set ' . $key . ' 0 ' . $duration . ' ' . strlen($data) . "\r\n" . $data, $server, $port);
        if ($result)
        {
            return $result;
        } 
        else 
        {
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
        /* Formatting data */
        $data = preg_replace('/\r/', '', $data);
    
        /* Executing command : set */
        $result = $this->exec('add ' . $key . ' 0 ' . $duration . ' ' . strlen($data) . "\r\n" . $data, $server, $port);
        if ($result)
        {
            return $result;
        } 
        else 
        {
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
        /* Formatting data */
        $data = preg_replace('/\r/', '', $data);
    
        /* Executing command : set */
        $result = $this->exec('replace ' . $key . ' 0 ' . $duration . ' ' . strlen($data) . "\r\n" . $data, $server, $port);
        if ($result)
        {
            return $result;
        }
        else 
        {
            return false;
        }
    }

    /**
     * Delete an item
     * Return true if successful, false otherwise
     *
     * @param String $server Hostname
     * @param Integer $port Hostname Port
     * @param String $key Key to delete
     *
     * @return String
     */
    public function delete($server, $port, $key)
    {
        /* Executing command : delete */
        $result = $this->exec('delete ' . $key, $server, $port);
        if ($result)
        {
            return $result;
        }
        else 
        {
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
        /* Executing command : increment */
        $result = $this->exec('incr ' . $key . ' ' . $value, $server, $port);
        if ($result)
        {
            return $result;
        }
        else 
        {
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
        /* Executing command : decrement */
        $result = $this->exec('decr ' . $key . ' ' . $value, $server, $port);
        if ($result)
        {
            return $result;
        }
        else 
        {
            return false;
        }
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
    function flush($server, $port, $delay)
    {
        /* Executing command : flush_all */
        $result = $this->exec('flush_all ' . $delay, $server, $port);
        if ($result)
        {
            return $result;
        }
        else 
        {
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
        $slabs = array();
        $items = false;
        
        # Executing command : stats
        if (($level == 'full') && ($result = $this->exec('stats', $server, $port))) {
            # Parsing result
            $result = $this->parse($result);
            $infinite = (isset($result['time'], $result['uptime'])) ? ($result['time'] - $result['uptime']) : 0;
        }

        /* Executing command : slabs stats */
        $result = $this->exec('stats slabs', $server, $port);
        if ($result)
        {
            /* Parsing result */
            $result = $this->parse($result);
            unset($result['active_slabs']);
            unset($result['total_malloced']);
            /* Indexing by slabs */
            foreach($result as $key => $value)
            {
                $key = preg_split('/:/', $key);
                $slabs[$key[0]] = true;
            }
        }

        /* Exploring each slabs */
        foreach ($slabs as $slab => $unused)
        {
            /* Executing command : stats cachedump */
            $result = $this->exec('stats cachedump ' . $slab . ' 0', $server, $port);
            if ($result)
            {
                /* Parsing result */
                preg_match_all('/^ITEM ((?:.*)' . preg_quote($search, '/') . '(?:.*)) \[([0-9]*) b; ([0-9]*) s\]\r\n/imU', $result, $matchs, PREG_SET_ORDER);

                foreach ($matchs as $item) {
                    /* Search & Delete */
                    if ($more == 'delete') {
                        $items[] = $item[1] . ' : ' . $this->delete($server, $port, $item[1]);
                        /* Basic search */
                    } else {
                        /* Detail level */
                        if ($level == 'full') {
                            $items[] = $item[1] . ' : [' . trim(AnalysisUtils::byteResize($item[2])) . 'b, expire in ' . (($item[3] == $infinite) ? '&#8734;' : AnalysisUtils::uptime($item[3] - time(), true)) . ']';
                        } else {
                            $items[] = $item[1];
                        }
                    }
                }
            }
            unset($slabs[$slab]);
        }

        if (is_array($items))
        {
            sort($items);
        }

        return $items;
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
        /* Executing command */
        $result = $this->exec($command, $server, $port);
        if ($result)
        {
            return $result;
        }
        else 
        {
            return false;
        }
    }
    
    public function getResultMessage()
    {
        return self::$_log;
    }
    
    
    public function getMemcache()
    {
        return $this;
    }
}

// end
<?php

namespace Royalcms\Component\Memcache;

/**
 * Error container
 *
 */
class DataError
{
    private static $_errors = array();

    /**
     * Add an error to the container
     * Return true if successful, false otherwise
     *
     * @param String $error Error message
     *
     * @return Boolean
     */
    public function add($error)
    {
        return array_push(self::$_errors, $error);
    }

    /**
     * Return last Error message
     *
     * @return Mixed
     */
    public function last()
    {
        return (isset(self::$_errors[count(self::$_errors) - 1])) ? self::$_errors[count(self::$_errors) - 1] : null;
    }

    /**
     * Return errors count
     *
     * @return Integer
     */
    public function count()
    {
        return count(self::$_errors);
    }
    
    
    public function all()
    {
        return self::$_errors;
    }
    
}

// end
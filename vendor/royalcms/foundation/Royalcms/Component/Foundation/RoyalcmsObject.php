<?php namespace Royalcms\Component\Foundation;

use Exception;
use BadMethodCallException;

abstract class RoyalcmsObject
{
    protected static $registered_instance = array();
    
    /**
     * Create instance
     *
     * @return  $this
     */
    public static function make()
    {
        $key = get_called_class();
        $instance = new static();
        self::$registered_instance[$key][] = $instance;
        return $instance;
    }
    
    public static function singleton() {
        $key = get_called_class();
        if (! isset(static::$registered_instance[$key]['singleton'])) {
            self::$registered_instance[$key]['singleton'] = new static();
        }
        return self::$registered_instance[$key]['singleton'];
    }
    
    public static function allInstance() {
        return self::$registered_instance;
    }

    public function __toString()
    {
        echo get_class($this);
    }
    
    public function __set($name, $value)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . ucfirst($name))) {
            throw new BadMethodCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }
    
    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . ucfirst($name))) {
            throw new BadMethodCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }
    
    public function __isset($name)
    {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        } else {
            return false;
        }
    }
    
    public function __unset($name)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        } elseif (method_exists($this, 'get' . ucfirst($name))) {
            throw new BadMethodCallException('Unsetting read-only property: ' . get_class($this) . '::' . $name);
        }
    }
    
    public function __call($name, $params)
    {
        throw new BadMethodCallException('Calling unknown method: ' . get_class($this) . "::{$name}()");
    }
    
    public static function __callstatic($name, $params)
    {
        throw new BadMethodCallException('Calling unknown method: ' . __CLASS__ . "::{$name}()");
    }
}

class UnknownPropertyException extends Exception {}

// end
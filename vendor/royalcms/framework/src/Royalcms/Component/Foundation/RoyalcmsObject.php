<?php

namespace Royalcms\Component\Foundation;

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

    /**
     * @return static
     */
    public static function singleton()
    {
        $key = get_called_class();
        if (! isset(static::$registered_instance[$key]['singleton'])) {
            self::$registered_instance[$key]['singleton'] = new static();
        }
        return self::$registered_instance[$key]['singleton'];
    }

    /**
     * @return array[static]
     */
    public static function allInstance()
    {
        return self::$registered_instance;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        echo get_class($this);
    }

    /**
     * @param $name
     * @param $value
     * @throws BadMethodCallException
     * @throws UnknownPropertyException
     */
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

    /**
     * @param $name
     * @return mixed
     * @throws BadMethodCallException
     * @throws UnknownPropertyException
     */
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

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        } else {
            return false;
        }
    }

    /**
     * @param $name
     * @throw BadMethodCallException
     */
    public function __unset($name)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            $this->$setter(null);
        } elseif (method_exists($this, 'get' . ucfirst($name))) {
            throw new BadMethodCallException('Unsetting read-only property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @param $name
     * @param $params
     * @throw BadMethodCallException
     */
    public function __call($name, $params)
    {
        throw new BadMethodCallException('Calling unknown method: ' . get_class($this) . "::{$name}()");
    }

    /**
     * @param $name
     * @param $params
     * @throw BadMethodCallException
     */
    public static function __callstatic($name, $params)
    {
        throw new BadMethodCallException('Calling unknown method: ' . __CLASS__ . "::{$name}()");
    }
}

// end
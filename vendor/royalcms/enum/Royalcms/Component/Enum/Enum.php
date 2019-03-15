<?php

namespace Royalcms\Component\Enum;

use BadMethodCallException;
use ReflectionClass;
use UnexpectedValueException;

/**
 * Basic class for php enum.
 */
abstract class Enum
{
    /**
     * Name of current Enum data.
     *
     * @var string
     */
    protected $name;

    /**
     * Value of current Enum data.
     *
     * @var int|string
     */
    protected $value;

    /**
     * Map of Enum values.
     *
     * const name => value
     *
     * @var array
     */
    protected $valueMap = [];

    /**
     * Map of Enum names.
     *
     * value => const name
     *
     * @var array
     */
    protected $nameMap = [];

    /**
     * Constant name dictionary.
     *
     * const name => display value
     *
     * @var array
     */
    protected $nameDict = [];

    /**
     * Save instance.
     *
     * @var array
     */
    private static $__instance = [];


    /**
     * @var array
     */
    abstract protected function __statusMap();

    /**
     * Create const list for current class.
     */
    public function __construct($value = null)
    {
        // const name -> value
        $this->valueMap = (new ReflectionClass(static::class))->getConstants();

        // unset($this->valueMap['__DICT']);

        // value -> const name
        $this->nameMap = array_flip($this->valueMap);

        if (! is_null($value)) {
            $this->name = $this->_valueToName($value);
            $this->value = $value;
        }

        // constname -> display text
        foreach ($this->nameMap as $k => $v) {
            $this->nameDict[$v] = array_get($this->__statusMap(), $k);
        }
    }

    /**
     * Checks if the given constant name exists in the enum.
     *
     * @param  string $constName
     * @return boolean
     */
    protected function _hasName($constName)
    {
        return in_array($constName, $this->nameMap, true);
    }

    /**
     * Checks if the given value exists in the enum.
     *
     * @param  mixed $value
     * @param  boolean $strict
     * @return boolean
     */
    protected function _hasValue($value, $strict = true)
    {
        return in_array($value, $this->valueMap, $strict);
    }

    /**
     * Translate the given constant name to the value.
     *
     * @param  string $constName
     * @throws UnexpectedValueException
     * @return mixed
     */
    protected function _nameToValue($constName)
    {
        if (! $this->_hasName($constName)) {
            throw new UnexpectedValueException("Const {$constName} is not in Enum " . static::class);
        }

        return $this->valueMap[$constName];
    }

    /**
     * Translate the given value to the constant name.
     *
     * @param  mixed $value
     * @throws UnexpectedValueException
     * @return string
     */
    protected function _valueToName($value)
    {
        if (! $this->_hasValue($value)) {
            throw new UnexpectedValueException("Value {$value} is not in Enum " . static::class);
        }

        return $this->nameMap[$value];
    }

    /**
     * Translate the given constant name to the display value.
     *
     * @param  string $constName
     * @return string
     */
    protected function _transName($constName)
    {
        if ($this->_hasName($constName)) {
            return $this->nameDict[$constName];
        }

        return $constName;
    }

    /**
     * Translate the given value to the display value.
     *
     * @param  mixed $value
     * @return string
     */
    protected function _transValue($value)
    {
        if ($this->_hasValue($value)) {
            return array_get($this->__statusMap(), $value);
        }

        return $value;
    }

    /** getters */

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    protected function _getMap()
    {
        return $this->valueMap;
    }

    protected function _getNameMap()
    {
        return $this->nameMap;
    }

    protected function _getDict()
    {
        return $this->__statusMap();
    }

    protected function _getNameDict()
    {
        return $this->nameDict;
    }

    /**
     * Create new instance for current class.
     *
     * @return static
     */
    private static function createInstance()
    {
        return new static;
    }

    /**
     * Get current class instance from the static attribute.
     *
     * @return \Royalcms\Component\Enum\Enum
     */
    public static function getInstance()
    {
        if (empty(self::$__instance[static::class])) {
            self::$__instance[static::class] = self::createInstance();
        }

        return self::$__instance[static::class];
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * Call the helper method which starts with underscore.
     *
     * example:
     *
     * 1. (new Enum(1))->hasName('CONST_NAME')
     *    Actually called: $xxxEnum->_hasName('CONST_NAME')
     *
     * 2. (new Enum(1))->getDict()
     *    Actually called: $xxxEnum->_getDict()
     *
     * @param  string $method
     * @param  array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (! method_exists($this, $invoking = '_' . $method)) {
            throw new BadMethodCallException('Method ' . $invoking . ' does not exists');
        }

        return call_user_func_array([$this, $invoking], $arguments);
    }

    /**
     * Call some helper method statically.
     * Overloading to __call
     *
     * example:
     *
     * 1. xxxEnum::hasName('CONST_NAME')
     *    Actually called: $xxxEnum->_hasName('CONST_NAME')
     *
     * 2. xxxEnum::getDict()
     *    Actually called: $xxxEnum->_getDict()
     *
     * @see __call()
     *
     * @param  string $method
     * @param  array $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([self::getInstance(), $method], $arguments);
    }
}

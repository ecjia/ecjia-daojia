<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

<<<<<<< HEAD
=======
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

>>>>>>> v2-test
/**
 * ParameterBag is a container for key/value pairs.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ParameterBag implements \IteratorAggregate, \Countable
{
    /**
     * Parameter storage.
<<<<<<< HEAD
     *
     * @var array
     */
    protected $parameters;

    /**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     */
    public function __construct(array $parameters = array())
=======
     */
    protected $parameters;

    public function __construct(array $parameters = [])
>>>>>>> v2-test
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the parameters.
     *
<<<<<<< HEAD
     * @return array An array of parameters
     */
    public function all()
    {
        return $this->parameters;
=======
     * @param string|null $key The name of the parameter to return or null to get them all
     *
     * @return array An array of parameters
     */
    public function all(/*string $key = null*/)
    {
        $key = \func_num_args() > 0 ? func_get_arg(0) : null;

        if (null === $key) {
            return $this->parameters;
        }

        if (!\is_array($value = $this->parameters[$key] ?? [])) {
            throw new BadRequestException(sprintf('Unexpected value for parameter "%s": expecting "array", got "%s".', $key, get_debug_type($value)));
        }

        return $value;
>>>>>>> v2-test
    }

    /**
     * Returns the parameter keys.
     *
     * @return array An array of parameter keys
     */
    public function keys()
    {
        return array_keys($this->parameters);
    }

    /**
     * Replaces the current parameters by a new set.
<<<<<<< HEAD
     *
     * @param array $parameters An array of parameters
     */
    public function replace(array $parameters = array())
=======
     */
    public function replace(array $parameters = [])
>>>>>>> v2-test
    {
        $this->parameters = $parameters;
    }

    /**
     * Adds parameters.
<<<<<<< HEAD
     *
     * @param array $parameters An array of parameters
     */
    public function add(array $parameters = array())
=======
     */
    public function add(array $parameters = [])
>>>>>>> v2-test
    {
        $this->parameters = array_replace($this->parameters, $parameters);
    }

    /**
     * Returns a parameter by name.
     *
<<<<<<< HEAD
     * @param string $path    The key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function get($path, $default = null, $deep = false)
    {
        if (!$deep || false === $pos = strpos($path, '[')) {
            return array_key_exists($path, $this->parameters) ? $this->parameters[$path] : $default;
        }

        $root = substr($path, 0, $pos);
        if (!array_key_exists($root, $this->parameters)) {
            return $default;
        }

        $value = $this->parameters[$root];
        $currentKey = null;
        for ($i = $pos, $c = strlen($path); $i < $c; ++$i) {
            $char = $path[$i];

            if ('[' === $char) {
                if (null !== $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "[" at position %d.', $i));
                }

                $currentKey = '';
            } elseif (']' === $char) {
                if (null === $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "]" at position %d.', $i));
                }

                if (!is_array($value) || !array_key_exists($currentKey, $value)) {
                    return $default;
                }

                $value = $value[$currentKey];
                $currentKey = null;
            } else {
                if (null === $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "%s" at position %d.', $char, $i));
                }

                $currentKey .= $char;
            }
        }

        if (null !== $currentKey) {
            throw new \InvalidArgumentException(sprintf('Malformed path. Path must end with "]".'));
        }

        return $value;
=======
     * @param mixed $default The default value if the parameter key does not exist
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return \array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
>>>>>>> v2-test
    }

    /**
     * Sets a parameter by name.
     *
<<<<<<< HEAD
     * @param string $key   The key
     * @param mixed  $value The value
     */
    public function set($key, $value)
=======
     * @param mixed $value The value
     */
    public function set(string $key, $value)
>>>>>>> v2-test
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Returns true if the parameter is defined.
     *
<<<<<<< HEAD
     * @param string $key The key
     *
     * @return bool true if the parameter exists, false otherwise
     */
    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
=======
     * @return bool true if the parameter exists, false otherwise
     */
    public function has(string $key)
    {
        return \array_key_exists($key, $this->parameters);
>>>>>>> v2-test
    }

    /**
     * Removes a parameter.
<<<<<<< HEAD
     *
     * @param string $key The key
     */
    public function remove($key)
=======
     */
    public function remove(string $key)
>>>>>>> v2-test
    {
        unset($this->parameters[$key]);
    }

    /**
     * Returns the alphabetic characters of the parameter value.
     *
<<<<<<< HEAD
     * @param string $key     The parameter key
     * @param string $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return string The filtered value
     */
    public function getAlpha($key, $default = '', $deep = false)
    {
        return preg_replace('/[^[:alpha:]]/', '', $this->get($key, $default, $deep));
=======
     * @return string The filtered value
     */
    public function getAlpha(string $key, string $default = '')
    {
        return preg_replace('/[^[:alpha:]]/', '', $this->get($key, $default));
>>>>>>> v2-test
    }

    /**
     * Returns the alphabetic characters and digits of the parameter value.
     *
<<<<<<< HEAD
     * @param string $key     The parameter key
     * @param string $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return string The filtered value
     */
    public function getAlnum($key, $default = '', $deep = false)
    {
        return preg_replace('/[^[:alnum:]]/', '', $this->get($key, $default, $deep));
=======
     * @return string The filtered value
     */
    public function getAlnum(string $key, string $default = '')
    {
        return preg_replace('/[^[:alnum:]]/', '', $this->get($key, $default));
>>>>>>> v2-test
    }

    /**
     * Returns the digits of the parameter value.
     *
<<<<<<< HEAD
     * @param string $key     The parameter key
     * @param string $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return string The filtered value
     */
    public function getDigits($key, $default = '', $deep = false)
    {
        // we need to remove - and + because they're allowed in the filter
        return str_replace(array('-', '+'), '', $this->filter($key, $default, $deep, FILTER_SANITIZE_NUMBER_INT));
=======
     * @return string The filtered value
     */
    public function getDigits(string $key, string $default = '')
    {
        // we need to remove - and + because they're allowed in the filter
        return str_replace(['-', '+'], '', $this->filter($key, $default, \FILTER_SANITIZE_NUMBER_INT));
>>>>>>> v2-test
    }

    /**
     * Returns the parameter value converted to integer.
     *
<<<<<<< HEAD
     * @param string $key     The parameter key
     * @param int    $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return int The filtered value
     */
    public function getInt($key, $default = 0, $deep = false)
    {
        return (int) $this->get($key, $default, $deep);
=======
     * @return int The filtered value
     */
    public function getInt(string $key, int $default = 0)
    {
        return (int) $this->get($key, $default);
>>>>>>> v2-test
    }

    /**
     * Returns the parameter value converted to boolean.
     *
<<<<<<< HEAD
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     * @param bool   $deep    If true, a path like foo[bar] will find deeper items
     *
     * @return bool The filtered value
     */
    public function getBoolean($key, $default = false, $deep = false)
    {
        return $this->filter($key, $default, $deep, FILTER_VALIDATE_BOOLEAN);
=======
     * @return bool The filtered value
     */
    public function getBoolean(string $key, bool $default = false)
    {
        return $this->filter($key, $default, \FILTER_VALIDATE_BOOLEAN);
>>>>>>> v2-test
    }

    /**
     * Filter key.
     *
<<<<<<< HEAD
     * @param string $key     Key
     * @param mixed  $default Default = null
     * @param bool   $deep    Default = false
     * @param int    $filter  FILTER_* constant
     * @param mixed  $options Filter options
     *
     * @see http://php.net/manual/en/function.filter-var.php
     *
     * @return mixed
     */
    public function filter($key, $default = null, $deep = false, $filter = FILTER_DEFAULT, $options = array())
    {
        $value = $this->get($key, $default, $deep);

        // Always turn $options into an array - this allows filter_var option shortcuts.
        if (!is_array($options) && $options) {
            $options = array('flags' => $options);
        }

        // Add a convenience check for arrays.
        if (is_array($value) && !isset($options['flags'])) {
            $options['flags'] = FILTER_REQUIRE_ARRAY;
=======
     * @param mixed $default Default = null
     * @param int   $filter  FILTER_* constant
     * @param mixed $options Filter options
     *
     * @see https://php.net/filter-var
     *
     * @return mixed
     */
    public function filter(string $key, $default = null, int $filter = \FILTER_DEFAULT, $options = [])
    {
        $value = $this->get($key, $default);

        // Always turn $options into an array - this allows filter_var option shortcuts.
        if (!\is_array($options) && $options) {
            $options = ['flags' => $options];
        }

        // Add a convenience check for arrays.
        if (\is_array($value) && !isset($options['flags'])) {
            $options['flags'] = \FILTER_REQUIRE_ARRAY;
        }

        if ((\FILTER_CALLBACK & $filter) && !(($options['options'] ?? null) instanceof \Closure)) {
            trigger_deprecation('symfony/http-foundation', '5.2', 'Not passing a Closure together with FILTER_CALLBACK to "%s()" is deprecated. Wrap your filter in a closure instead.', __METHOD__);
            // throw new \InvalidArgumentException(sprintf('A Closure must be passed to "%s()" when FILTER_CALLBACK is used, "%s" given.', __METHOD__, get_debug_type($options['options'] ?? null)));
>>>>>>> v2-test
        }

        return filter_var($value, $filter, $options);
    }

    /**
     * Returns an iterator for parameters.
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }

    /**
     * Returns the number of parameters.
     *
     * @return int The number of parameters
     */
    public function count()
    {
<<<<<<< HEAD
        return count($this->parameters);
=======
        return \count($this->parameters);
>>>>>>> v2-test
    }
}

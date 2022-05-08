<<<<<<< HEAD
<?php
=======
<?php declare(strict_types=1);
>>>>>>> v2-test
/*
 * This file is part of the Recursion Context package.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<< HEAD

namespace SebastianBergmann\RecursionContext;

=======
namespace SebastianBergmann\RecursionContext;

use const PHP_INT_MAX;
use const PHP_INT_MIN;
use function array_pop;
use function array_slice;
use function count;
use function is_array;
use function is_object;
use function random_int;
use function spl_object_hash;
use SplObjectStorage;

>>>>>>> v2-test
/**
 * A context containing previously processed arrays and objects
 * when recursively processing a value.
 */
final class Context
{
    /**
     * @var array[]
     */
    private $arrays;

    /**
<<<<<<< HEAD
     * @var \SplObjectStorage
=======
     * @var SplObjectStorage
>>>>>>> v2-test
     */
    private $objects;

    /**
<<<<<<< HEAD
     * Initialises the context
     */
    public function __construct()
    {
        $this->arrays  = array();
        $this->objects = new \SplObjectStorage;
=======
     * Initialises the context.
     */
    public function __construct()
    {
        $this->arrays  = [];
        $this->objects = new SplObjectStorage;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __destruct()
    {
        foreach ($this->arrays as &$array) {
            if (is_array($array)) {
                array_pop($array);
                array_pop($array);
            }
        }
>>>>>>> v2-test
    }

    /**
     * Adds a value to the context.
     *
<<<<<<< HEAD
     * @param  array|object             $value The value to add.
     * @return int|string               The ID of the stored value, either as
     *                                        a string or integer.
     * @throws InvalidArgumentException Thrown if $value is not an array or
     *                                        object
=======
     * @param array|object $value the value to add
     *
     * @throws InvalidArgumentException Thrown if $value is not an array or object
     *
     * @return bool|int|string the ID of the stored value, either as a string or integer
     *
     * @psalm-template T
     * @psalm-param T $value
     * @param-out T $value
>>>>>>> v2-test
     */
    public function add(&$value)
    {
        if (is_array($value)) {
            return $this->addArray($value);
        }

<<<<<<< HEAD
        else if (is_object($value)) {
=======
        if (is_object($value)) {
>>>>>>> v2-test
            return $this->addObject($value);
        }

        throw new InvalidArgumentException(
            'Only arrays and objects are supported'
        );
    }

    /**
     * Checks if the given value exists within the context.
     *
<<<<<<< HEAD
     * @param  array|object             $value The value to check.
     * @return int|string|false         The string or integer ID of the stored
     *                                        value if it has already been seen, or
     *                                        false if the value is not stored.
     * @throws InvalidArgumentException Thrown if $value is not an array or
     *                                        object
=======
     * @param array|object $value the value to check
     *
     * @throws InvalidArgumentException Thrown if $value is not an array or object
     *
     * @return false|int|string the string or integer ID of the stored value if it has already been seen, or false if the value is not stored
     *
     * @psalm-template T
     * @psalm-param T $value
     * @param-out T $value
>>>>>>> v2-test
     */
    public function contains(&$value)
    {
        if (is_array($value)) {
            return $this->containsArray($value);
        }

<<<<<<< HEAD
        else if (is_object($value)) {
=======
        if (is_object($value)) {
>>>>>>> v2-test
            return $this->containsObject($value);
        }

        throw new InvalidArgumentException(
            'Only arrays and objects are supported'
        );
    }

    /**
<<<<<<< HEAD
     * @param  array    $array
=======
>>>>>>> v2-test
     * @return bool|int
     */
    private function addArray(array &$array)
    {
        $key = $this->containsArray($array);

        if ($key !== false) {
            return $key;
        }

<<<<<<< HEAD
        $this->arrays[] = &$array;

        return count($this->arrays) - 1;
    }

    /**
     * @param  object $object
     * @return string
     */
    private function addObject($object)
=======
        $key            = count($this->arrays);
        $this->arrays[] = &$array;

        if (!isset($array[PHP_INT_MAX]) && !isset($array[PHP_INT_MAX - 1])) {
            $array[] = $key;
            $array[] = $this->objects;
        } else { /* cover the improbable case too */
            do {
                $key = random_int(PHP_INT_MIN, PHP_INT_MAX);
            } while (isset($array[$key]));

            $array[$key] = $key;

            do {
                $key = random_int(PHP_INT_MIN, PHP_INT_MAX);
            } while (isset($array[$key]));

            $array[$key] = $this->objects;
        }

        return $key;
    }

    /**
     * @param object $object
     */
    private function addObject($object): string
>>>>>>> v2-test
    {
        if (!$this->objects->contains($object)) {
            $this->objects->attach($object);
        }

        return spl_object_hash($object);
    }

    /**
<<<<<<< HEAD
     * @param  array     $array
     * @return int|false
     */
    private function containsArray(array &$array)
    {
        $keys = array_keys($this->arrays, $array, true);
        $hash = '_Key_' . microtime(true);

        foreach ($keys as $key) {
            $this->arrays[$key][$hash] = $hash;

            if (isset($array[$hash]) && $array[$hash] === $hash) {
                unset($this->arrays[$key][$hash]);

                return $key;
            }

            unset($this->arrays[$key][$hash]);
        }

        return false;
    }

    /**
     * @param  object       $value
     * @return string|false
=======
     * @return false|int
     */
    private function containsArray(array &$array)
    {
        $end = array_slice($array, -2);

        return isset($end[1]) && $end[1] === $this->objects ? $end[0] : false;
    }

    /**
     * @param object $value
     *
     * @return false|string
>>>>>>> v2-test
     */
    private function containsObject($value)
    {
        if ($this->objects->contains($value)) {
            return spl_object_hash($value);
        }

        return false;
    }
}

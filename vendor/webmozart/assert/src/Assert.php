<?php

/*
 * This file is part of the webmozart/assert package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\Assert;

<<<<<<< HEAD
use BadMethodCallException;
use InvalidArgumentException;
=======
use ArrayAccess;
use BadMethodCallException;
use Closure;
use Countable;
use DateTime;
use DateTimeImmutable;
use Exception;
use InvalidArgumentException;
use ResourceBundle;
use SimpleXMLElement;
use Throwable;
>>>>>>> v2-test
use Traversable;

/**
 * Efficient assertions to validate the input/output of your methods.
 *
<<<<<<< HEAD
 * @method static void nullOrString($value, $message = '')
 * @method static void nullOrStringNotEmpty($value, $message = '')
 * @method static void nullOrInteger($value, $message = '')
 * @method static void nullOrIntegerish($value, $message = '')
 * @method static void nullOrFloat($value, $message = '')
 * @method static void nullOrNumeric($value, $message = '')
 * @method static void nullOrBoolean($value, $message = '')
 * @method static void nullOrScalar($value, $message = '')
 * @method static void nullOrObject($value, $message = '')
 * @method static void nullOrResource($value, $type = null, $message = '')
 * @method static void nullOrIsCallable($value, $message = '')
 * @method static void nullOrIsArray($value, $message = '')
 * @method static void nullOrIsTraversable($value, $message = '')
 * @method static void nullOrIsInstanceOf($value, $class, $message = '')
 * @method static void nullOrNotInstanceOf($value, $class, $message = '')
 * @method static void nullOrIsEmpty($value, $message = '')
 * @method static void nullOrNotEmpty($value, $message = '')
 * @method static void nullOrTrue($value, $message = '')
 * @method static void nullOrFalse($value, $message = '')
 * @method static void nullOrEq($value, $value2, $message = '')
 * @method static void nullOrNotEq($value,$value2,  $message = '')
 * @method static void nullOrSame($value, $value2, $message = '')
 * @method static void nullOrNotSame($value, $value2, $message = '')
 * @method static void nullOrGreaterThan($value, $value2, $message = '')
 * @method static void nullOrGreaterThanEq($value, $value2, $message = '')
 * @method static void nullOrLessThan($value, $value2, $message = '')
 * @method static void nullOrLessThanEq($value, $value2, $message = '')
 * @method static void nullOrRange($value, $min, $max, $message = '')
 * @method static void nullOrOneOf($value, $values, $message = '')
 * @method static void nullOrContains($value, $subString, $message = '')
 * @method static void nullOrStartsWith($value, $prefix, $message = '')
 * @method static void nullOrStartsWithLetter($value, $message = '')
 * @method static void nullOrEndsWith($value, $suffix, $message = '')
 * @method static void nullOrRegex($value, $pattern, $message = '')
 * @method static void nullOrAlpha($value, $message = '')
 * @method static void nullOrDigits($value, $message = '')
 * @method static void nullOrAlnum($value, $message = '')
 * @method static void nullOrLower($value, $message = '')
 * @method static void nullOrUpper($value, $message = '')
 * @method static void nullOrLength($value, $length, $message = '')
 * @method static void nullOrMinLength($value, $min, $message = '')
 * @method static void nullOrMaxLength($value, $max, $message = '')
 * @method static void nullOrLengthBetween($value, $min, $max, $message = '')
 * @method static void nullOrFileExists($value, $message = '')
 * @method static void nullOrFile($value, $message = '')
 * @method static void nullOrDirectory($value, $message = '')
 * @method static void nullOrReadable($value, $message = '')
 * @method static void nullOrWritable($value, $message = '')
 * @method static void nullOrClassExists($value, $message = '')
 * @method static void nullOrSubclassOf($value, $class, $message = '')
 * @method static void nullOrImplementsInterface($value, $interface, $message = '')
 * @method static void nullOrPropertyExists($value, $property, $message = '')
 * @method static void nullOrPropertyNotExists($value, $property, $message = '')
 * @method static void nullOrMethodExists($value, $method, $message = '')
 * @method static void nullOrMethodNotExists($value, $method, $message = '')
 * @method static void nullOrKeyExists($value, $key, $message = '')
 * @method static void nullOrKeyNotExists($value, $key, $message = '')
 * @method static void nullOrUuid($values, $message = '')
 * @method static void allString($values, $message = '')
 * @method static void allStringNotEmpty($values, $message = '')
 * @method static void allInteger($values, $message = '')
 * @method static void allIntegerish($values, $message = '')
 * @method static void allFloat($values, $message = '')
 * @method static void allNumeric($values, $message = '')
 * @method static void allBoolean($values, $message = '')
 * @method static void allScalar($values, $message = '')
 * @method static void allObject($values, $message = '')
 * @method static void allResource($values, $type = null, $message = '')
 * @method static void allIsCallable($values, $message = '')
 * @method static void allIsArray($values, $message = '')
 * @method static void allIsTraversable($values, $message = '')
 * @method static void allIsInstanceOf($values, $class, $message = '')
 * @method static void allNotInstanceOf($values, $class, $message = '')
 * @method static void allNull($values, $message = '')
 * @method static void allNotNull($values, $message = '')
 * @method static void allIsEmpty($values, $message = '')
 * @method static void allNotEmpty($values, $message = '')
 * @method static void allTrue($values, $message = '')
 * @method static void allFalse($values, $message = '')
 * @method static void allEq($values, $value2, $message = '')
 * @method static void allNotEq($values,$value2,  $message = '')
 * @method static void allSame($values, $value2, $message = '')
 * @method static void allNotSame($values, $value2, $message = '')
 * @method static void allGreaterThan($values, $value2, $message = '')
 * @method static void allGreaterThanEq($values, $value2, $message = '')
 * @method static void allLessThan($values, $value2, $message = '')
 * @method static void allLessThanEq($values, $value2, $message = '')
 * @method static void allRange($values, $min, $max, $message = '')
 * @method static void allOneOf($values, $values, $message = '')
 * @method static void allContains($values, $subString, $message = '')
 * @method static void allStartsWith($values, $prefix, $message = '')
 * @method static void allStartsWithLetter($values, $message = '')
 * @method static void allEndsWith($values, $suffix, $message = '')
 * @method static void allRegex($values, $pattern, $message = '')
 * @method static void allAlpha($values, $message = '')
 * @method static void allDigits($values, $message = '')
 * @method static void allAlnum($values, $message = '')
 * @method static void allLower($values, $message = '')
 * @method static void allUpper($values, $message = '')
 * @method static void allLength($values, $length, $message = '')
 * @method static void allMinLength($values, $min, $message = '')
 * @method static void allMaxLength($values, $max, $message = '')
 * @method static void allLengthBetween($values, $min, $max, $message = '')
 * @method static void allFileExists($values, $message = '')
 * @method static void allFile($values, $message = '')
 * @method static void allDirectory($values, $message = '')
 * @method static void allReadable($values, $message = '')
 * @method static void allWritable($values, $message = '')
 * @method static void allClassExists($values, $message = '')
 * @method static void allSubclassOf($values, $class, $message = '')
 * @method static void allImplementsInterface($values, $interface, $message = '')
 * @method static void allPropertyExists($values, $property, $message = '')
 * @method static void allPropertyNotExists($values, $property, $message = '')
 * @method static void allMethodExists($values, $method, $message = '')
 * @method static void allMethodNotExists($values, $method, $message = '')
 * @method static void allKeyExists($values, $key, $message = '')
 * @method static void allKeyNotExists($values, $key, $message = '')
 * @method static void allUuid($values, $message = '')
=======
 * @mixin Mixin
>>>>>>> v2-test
 *
 * @since  1.0
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class Assert
{
<<<<<<< HEAD
    public static function string($value, $message = '')
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a string. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert string $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function string($value, $message = '')
    {
        if (!\is_string($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a string. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function stringNotEmpty($value, $message = '')
    {
        self::string($value, $message);
        self::notEmpty($value, $message);
    }

    public static function integer($value, $message = '')
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an integer. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert non-empty-string $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function stringNotEmpty($value, $message = '')
    {
        static::string($value, $message);
        static::notEq($value, '', $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert int $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function integer($value, $message = '')
    {
        if (!\is_int($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an integer. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function integerish($value, $message = '')
    {
        if (!is_numeric($value) || $value != (int) $value) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an integerish value. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert numeric $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function integerish($value, $message = '')
    {
        if (!\is_numeric($value) || $value != (int) $value) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an integerish value. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function float($value, $message = '')
    {
        if (!is_float($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a float. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert float $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function float($value, $message = '')
    {
        if (!\is_float($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a float. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function numeric($value, $message = '')
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a numeric. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert numeric $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function numeric($value, $message = '')
    {
        if (!\is_numeric($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a numeric. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function boolean($value, $message = '')
    {
        if (!is_bool($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a boolean. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert int $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function natural($value, $message = '')
    {
        if (!\is_int($value) || $value < 0) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a non-negative integer. Got: %s',
                static::valueToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert bool $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function boolean($value, $message = '')
    {
        if (!\is_bool($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a boolean. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function scalar($value, $message = '')
    {
        if (!is_scalar($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a scalar. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert scalar $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function scalar($value, $message = '')
    {
        if (!\is_scalar($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a scalar. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function object($value, $message = '')
    {
        if (!is_object($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an object. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert object $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function object($value, $message = '')
    {
        if (!\is_object($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an object. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function resource($value, $type = null, $message = '')
    {
        if (!is_resource($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a resource. Got: %s',
                self::typeToString($value)
            ));
        }

        if ($type && $type !== get_resource_type($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a resource of type %2$s. Got: %s',
                self::typeToString($value),
=======
    /**
     * @psalm-pure
     * @psalm-assert resource $value
     *
     * @param mixed       $value
     * @param string|null $type    type of resource this should be. @see https://www.php.net/manual/en/function.get-resource-type.php
     * @param string      $message
     *
     * @throws InvalidArgumentException
     */
    public static function resource($value, $type = null, $message = '')
    {
        if (!\is_resource($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a resource. Got: %s',
                static::typeToString($value)
            ));
        }

        if ($type && $type !== \get_resource_type($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a resource of type %2$s. Got: %s',
                static::typeToString($value),
>>>>>>> v2-test
                $type
            ));
        }
    }

<<<<<<< HEAD
    public static function isCallable($value, $message = '')
    {
        if (!is_callable($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a callable. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert callable $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isCallable($value, $message = '')
    {
        if (!\is_callable($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a callable. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function isArray($value, $message = '')
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an array. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert array $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isArray($value, $message = '')
    {
        if (!\is_array($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an array. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function isTraversable($value, $message = '')
    {
        if (!is_array($value) && !($value instanceof Traversable)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a traversable. Got: %s',
                self::typeToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert iterable $value
     *
     * @deprecated use "isIterable" or "isInstanceOf" instead
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isTraversable($value, $message = '')
    {
        @\trigger_error(
            \sprintf(
                'The "%s" assertion is deprecated. You should stop using it, as it will soon be removed in 2.0 version. Use "isIterable" or "isInstanceOf" instead.',
                __METHOD__
            ),
            \E_USER_DEPRECATED
        );

        if (!\is_array($value) && !($value instanceof Traversable)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a traversable. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert array|ArrayAccess $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isArrayAccessible($value, $message = '')
    {
        if (!\is_array($value) && !($value instanceof ArrayAccess)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an array accessible. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function isInstanceOf($value, $class, $message = '')
    {
        if (!($value instanceof $class)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an instance of %2$s. Got: %s',
                self::typeToString($value),
=======
    /**
     * @psalm-pure
     * @psalm-assert countable $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isCountable($value, $message = '')
    {
        if (
            !\is_array($value)
            && !($value instanceof Countable)
            && !($value instanceof ResourceBundle)
            && !($value instanceof SimpleXMLElement)
        ) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a countable. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isIterable($value, $message = '')
    {
        if (!\is_array($value) && !($value instanceof Traversable)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an iterable. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert ExpectedType $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function isInstanceOf($value, $class, $message = '')
    {
        if (!($value instanceof $class)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an instance of %2$s. Got: %s',
                static::typeToString($value),
>>>>>>> v2-test
                $class
            ));
        }
    }

<<<<<<< HEAD
    public static function notInstanceOf($value, $class, $message = '')
    {
        if ($value instanceof $class) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an instance other than %2$s. Got: %s',
                self::typeToString($value),
=======
    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert !ExpectedType $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function notInstanceOf($value, $class, $message = '')
    {
        if ($value instanceof $class) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an instance other than %2$s. Got: %s',
                static::typeToString($value),
>>>>>>> v2-test
                $class
            ));
        }
    }

<<<<<<< HEAD
    public static function isEmpty($value, $message = '')
    {
        if (!empty($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an empty value. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-param array<class-string> $classes
     *
     * @param mixed                $value
     * @param array<object|string> $classes
     * @param string               $message
     *
     * @throws InvalidArgumentException
     */
    public static function isInstanceOfAny($value, array $classes, $message = '')
    {
        foreach ($classes as $class) {
            if ($value instanceof $class) {
                return;
            }
        }

        static::reportInvalidArgument(\sprintf(
            $message ?: 'Expected an instance of any of %2$s. Got: %s',
            static::typeToString($value),
            \implode(', ', \array_map(array('static', 'valueToString'), $classes))
        ));
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert ExpectedType|class-string<ExpectedType> $value
     *
     * @param object|string $value
     * @param string        $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function isAOf($value, $class, $message = '')
    {
        static::string($class, 'Expected class as a string. Got: %s');

        if (!\is_a($value, $class, \is_string($value))) {
            static::reportInvalidArgument(sprintf(
                $message ?: 'Expected an instance of this class or to this class among his parents %2$s. Got: %s',
                static::typeToString($value),
                $class
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-template UnexpectedType of object
     * @psalm-param class-string<UnexpectedType> $class
     * @psalm-assert !UnexpectedType $value
     * @psalm-assert !class-string<UnexpectedType> $value
     *
     * @param object|string $value
     * @param string        $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function isNotA($value, $class, $message = '')
    {
        static::string($class, 'Expected class as a string. Got: %s');

        if (\is_a($value, $class, \is_string($value))) {
            static::reportInvalidArgument(sprintf(
                $message ?: 'Expected an instance of this class or to this class among his parents other than %2$s. Got: %s',
                static::typeToString($value),
                $class
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-param array<class-string> $classes
     *
     * @param object|string $value
     * @param string[]      $classes
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function isAnyOf($value, array $classes, $message = '')
    {
        foreach ($classes as $class) {
            static::string($class, 'Expected class as a string. Got: %s');

            if (\is_a($value, $class, \is_string($value))) {
                return;
            }
        }

        static::reportInvalidArgument(sprintf(
            $message ?: 'Expected an any of instance of this class or to this class among his parents other than %2$s. Got: %s',
            static::typeToString($value),
            \implode(', ', \array_map(array('static', 'valueToString'), $classes))
        ));
    }

    /**
     * @psalm-pure
     * @psalm-assert empty $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isEmpty($value, $message = '')
    {
        if (!empty($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an empty value. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function notEmpty($value, $message = '')
    {
        if (empty($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a non-empty value. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert !empty $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notEmpty($value, $message = '')
    {
        if (empty($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a non-empty value. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function null($value, $message = '')
    {
        if (null !== $value) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected null. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert null $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function null($value, $message = '')
    {
        if (null !== $value) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected null. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function notNull($value, $message = '')
    {
        if (null === $value) {
            throw new InvalidArgumentException(
=======
    /**
     * @psalm-pure
     * @psalm-assert !null $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notNull($value, $message = '')
    {
        if (null === $value) {
            static::reportInvalidArgument(
>>>>>>> v2-test
                $message ?: 'Expected a value other than null.'
            );
        }
    }

<<<<<<< HEAD
    public static function true($value, $message = '')
    {
        if (true !== $value) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to be true. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert true $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function true($value, $message = '')
    {
        if (true !== $value) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to be true. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function false($value, $message = '')
    {
        if (false !== $value) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to be false. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert false $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function false($value, $message = '')
    {
        if (false !== $value) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to be false. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function eq($value, $value2, $message = '')
    {
        if ($value2 != $value) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value equal to %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($value2)
=======
    /**
     * @psalm-pure
     * @psalm-assert !false $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notFalse($value, $message = '')
    {
        if (false === $value) {
            static::reportInvalidArgument(
                $message ?: 'Expected a value other than false.'
            );
        }
    }

    /**
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function ip($value, $message = '')
    {
        if (false === \filter_var($value, \FILTER_VALIDATE_IP)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to be an IP. Got: %s',
                static::valueToString($value)
            ));
        }
    }

    /**
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function ipv4($value, $message = '')
    {
        if (false === \filter_var($value, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to be an IPv4. Got: %s',
                static::valueToString($value)
            ));
        }
    }

    /**
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function ipv6($value, $message = '')
    {
        if (false === \filter_var($value, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to be an IPv6. Got: %s',
                static::valueToString($value)
            ));
        }
    }

    /**
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function email($value, $message = '')
    {
        if (false === \filter_var($value, FILTER_VALIDATE_EMAIL)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to be a valid e-mail address. Got: %s',
                static::valueToString($value)
            ));
        }
    }

    /**
     * Does non strict comparisons on the items, so ['3', 3] will not pass the assertion.
     *
     * @param array  $values
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function uniqueValues(array $values, $message = '')
    {
        $allValues = \count($values);
        $uniqueValues = \count(\array_unique($values));

        if ($allValues !== $uniqueValues) {
            $difference = $allValues - $uniqueValues;

            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an array of unique values, but %s of them %s duplicated',
                $difference,
                (1 === $difference ? 'is' : 'are')
            ));
        }
    }

    /**
     * @param mixed  $value
     * @param mixed  $expect
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function eq($value, $expect, $message = '')
    {
        if ($expect != $value) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value equal to %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($expect)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function notEq($value, $value2, $message = '')
    {
        if ($value2 == $value) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a different value than %s.',
                self::valueToString($value2)
=======
    /**
     * @param mixed  $value
     * @param mixed  $expect
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notEq($value, $expect, $message = '')
    {
        if ($expect == $value) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a different value than %s.',
                static::valueToString($expect)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function same($value, $value2, $message = '')
    {
        if ($value2 !== $value) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value identical to %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($value2)
=======
    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param mixed  $expect
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function same($value, $expect, $message = '')
    {
        if ($expect !== $value) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value identical to %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($expect)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function notSame($value, $value2, $message = '')
    {
        if ($value2 === $value) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value not identical to %s.',
                self::valueToString($value2)
=======
    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param mixed  $expect
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notSame($value, $expect, $message = '')
    {
        if ($expect === $value) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value not identical to %s.',
                static::valueToString($expect)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function greaterThan($value, $limit, $message = '')
    {
        if ($value <= $limit) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value greater than %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($limit)
=======
    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param mixed  $limit
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function greaterThan($value, $limit, $message = '')
    {
        if ($value <= $limit) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value greater than %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($limit)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function greaterThanEq($value, $limit, $message = '')
    {
        if ($value < $limit) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value greater than or equal to %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($limit)
=======
    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param mixed  $limit
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function greaterThanEq($value, $limit, $message = '')
    {
        if ($value < $limit) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value greater than or equal to %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($limit)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function lessThan($value, $limit, $message = '')
    {
        if ($value >= $limit) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value less than %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($limit)
=======
    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param mixed  $limit
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function lessThan($value, $limit, $message = '')
    {
        if ($value >= $limit) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value less than %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($limit)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function lessThanEq($value, $limit, $message = '')
    {
        if ($value > $limit) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value less than or equal to %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($limit)
=======
    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param mixed  $limit
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function lessThanEq($value, $limit, $message = '')
    {
        if ($value > $limit) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value less than or equal to %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($limit)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function range($value, $min, $max, $message = '')
    {
        if ($value < $min || $value > $max) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value between %2$s and %3$s. Got: %s',
                self::valueToString($value),
                self::valueToString($min),
                self::valueToString($max)
=======
    /**
     * Inclusive range, so Assert::(3, 3, 5) passes.
     *
     * @psalm-pure
     *
     * @param mixed  $value
     * @param mixed  $min
     * @param mixed  $max
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function range($value, $min, $max, $message = '')
    {
        if ($value < $min || $value > $max) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value between %2$s and %3$s. Got: %s',
                static::valueToString($value),
                static::valueToString($min),
                static::valueToString($max)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function oneOf($value, array $values, $message = '')
    {
        if (!in_array($value, $values, true)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected one of: %2$s. Got: %s',
                self::valueToString($value),
                implode(', ', array_map(array(__CLASS__, 'valueToString'), $values))
=======
    /**
     * A more human-readable alias of Assert::inArray().
     *
     * @psalm-pure
     *
     * @param mixed  $value
     * @param array  $values
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function oneOf($value, array $values, $message = '')
    {
        static::inArray($value, $values, $message);
    }

    /**
     * Does strict comparison, so Assert::inArray(3, ['3']) does not pass the assertion.
     *
     * @psalm-pure
     *
     * @param mixed  $value
     * @param array  $values
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function inArray($value, array $values, $message = '')
    {
        if (!\in_array($value, $values, true)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected one of: %2$s. Got: %s',
                static::valueToString($value),
                \implode(', ', \array_map(array('static', 'valueToString'), $values))
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function contains($value, $subString, $message = '')
    {
        if (false === strpos($value, $subString)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($subString)
=======
    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $subString
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function contains($value, $subString, $message = '')
    {
        if (false === \strpos($value, $subString)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($subString)
            ));
        }
    }

    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $subString
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notContains($value, $subString, $message = '')
    {
        if (false !== \strpos($value, $subString)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: '%2$s was not expected to be contained in a value. Got: %s',
                static::valueToString($value),
                static::valueToString($subString)
            ));
        }
    }

    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notWhitespaceOnly($value, $message = '')
    {
        if (\preg_match('/^\s*$/', $value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a non-whitespace string. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function startsWith($value, $prefix, $message = '')
    {
        if (0 !== strpos($value, $prefix)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to start with %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($prefix)
=======
    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $prefix
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function startsWith($value, $prefix, $message = '')
    {
        if (0 !== \strpos($value, $prefix)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to start with %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($prefix)
            ));
        }
    }

    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $prefix
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notStartsWith($value, $prefix, $message = '')
    {
        if (0 === \strpos($value, $prefix)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value not to start with %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($prefix)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function startsWithLetter($value, $message = '')
    {
        $valid = isset($value[0]);

        if ($valid) {
            $locale = setlocale(LC_CTYPE, 0);
            setlocale(LC_CTYPE, 'C');
            $valid = ctype_alpha($value[0]);
            setlocale(LC_CTYPE, $locale);
        }

        if (!$valid) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to start with a letter. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function startsWithLetter($value, $message = '')
    {
        static::string($value);

        $valid = isset($value[0]);

        if ($valid) {
            $locale = \setlocale(LC_CTYPE, 0);
            \setlocale(LC_CTYPE, 'C');
            $valid = \ctype_alpha($value[0]);
            \setlocale(LC_CTYPE, $locale);
        }

        if (!$valid) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to start with a letter. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function endsWith($value, $suffix, $message = '')
    {
        if ($suffix !== substr($value, -self::strlen($suffix))) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to end with %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($suffix)
=======
    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $suffix
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function endsWith($value, $suffix, $message = '')
    {
        if ($suffix !== \substr($value, -\strlen($suffix))) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to end with %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($suffix)
            ));
        }
    }

    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $suffix
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notEndsWith($value, $suffix, $message = '')
    {
        if ($suffix === \substr($value, -\strlen($suffix))) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value not to end with %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($suffix)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function regex($value, $pattern, $message = '')
    {
        if (!preg_match($pattern, $value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'The value %s does not match the expected pattern.',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $pattern
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function regex($value, $pattern, $message = '')
    {
        if (!\preg_match($pattern, $value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'The value %s does not match the expected pattern.',
                static::valueToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $pattern
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function notRegex($value, $pattern, $message = '')
    {
        if (\preg_match($pattern, $value, $matches, PREG_OFFSET_CAPTURE)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'The value %s matches the pattern %s (at offset %d).',
                static::valueToString($value),
                static::valueToString($pattern),
                $matches[0][1]
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function alpha($value, $message = '')
    {
        $locale = setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C');
        $valid = !ctype_alpha($value);
        setlocale(LC_CTYPE, $locale);

        if ($valid) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain only letters. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function unicodeLetters($value, $message = '')
    {
        static::string($value);

        if (!\preg_match('/^\p{L}+$/u', $value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain only Unicode letters. Got: %s',
                static::valueToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function alpha($value, $message = '')
    {
        static::string($value);

        $locale = \setlocale(LC_CTYPE, 0);
        \setlocale(LC_CTYPE, 'C');
        $valid = !\ctype_alpha($value);
        \setlocale(LC_CTYPE, $locale);

        if ($valid) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain only letters. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function digits($value, $message = '')
    {
        $locale = setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C');
        $valid = !ctype_digit($value);
        setlocale(LC_CTYPE, $locale);

        if ($valid) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain digits only. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function digits($value, $message = '')
    {
        $locale = \setlocale(LC_CTYPE, 0);
        \setlocale(LC_CTYPE, 'C');
        $valid = !\ctype_digit($value);
        \setlocale(LC_CTYPE, $locale);

        if ($valid) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain digits only. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function alnum($value, $message = '')
    {
        $locale = setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C');
        $valid = !ctype_alnum($value);
        setlocale(LC_CTYPE, $locale);

        if ($valid) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain letters and digits only. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function alnum($value, $message = '')
    {
        $locale = \setlocale(LC_CTYPE, 0);
        \setlocale(LC_CTYPE, 'C');
        $valid = !\ctype_alnum($value);
        \setlocale(LC_CTYPE, $locale);

        if ($valid) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain letters and digits only. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function lower($value, $message = '')
    {
        $locale = setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C');
        $valid = !ctype_lower($value);
        setlocale(LC_CTYPE, $locale);

        if ($valid) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain lowercase characters only. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert lowercase-string $value
     *
     * @param string $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function lower($value, $message = '')
    {
        $locale = \setlocale(LC_CTYPE, 0);
        \setlocale(LC_CTYPE, 'C');
        $valid = !\ctype_lower($value);
        \setlocale(LC_CTYPE, $locale);

        if ($valid) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain lowercase characters only. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function upper($value, $message = '')
    {
        $locale = setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C');
        $valid = !ctype_upper($value);
        setlocale(LC_CTYPE, $locale);

        if ($valid) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain uppercase characters only. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-pure
     * @psalm-assert !lowercase-string $value
     *
     * @param string $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function upper($value, $message = '')
    {
        $locale = \setlocale(LC_CTYPE, 0);
        \setlocale(LC_CTYPE, 'C');
        $valid = !\ctype_upper($value);
        \setlocale(LC_CTYPE, $locale);

        if ($valid) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain uppercase characters only. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function length($value, $length, $message = '')
    {
        if ($length !== self::strlen($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain %2$s characters. Got: %s',
                self::valueToString($value),
=======
    /**
     * @psalm-pure
     *
     * @param string $value
     * @param int    $length
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function length($value, $length, $message = '')
    {
        if ($length !== static::strlen($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain %2$s characters. Got: %s',
                static::valueToString($value),
>>>>>>> v2-test
                $length
            ));
        }
    }

<<<<<<< HEAD
    public static function minLength($value, $min, $message = '')
    {
        if (self::strlen($value) < $min) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain at least %2$s characters. Got: %s',
                self::valueToString($value),
=======
    /**
     * Inclusive min.
     *
     * @psalm-pure
     *
     * @param string    $value
     * @param int|float $min
     * @param string    $message
     *
     * @throws InvalidArgumentException
     */
    public static function minLength($value, $min, $message = '')
    {
        if (static::strlen($value) < $min) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain at least %2$s characters. Got: %s',
                static::valueToString($value),
>>>>>>> v2-test
                $min
            ));
        }
    }

<<<<<<< HEAD
    public static function maxLength($value, $max, $message = '')
    {
        if (self::strlen($value) > $max) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain at most %2$s characters. Got: %s',
                self::valueToString($value),
=======
    /**
     * Inclusive max.
     *
     * @psalm-pure
     *
     * @param string    $value
     * @param int|float $max
     * @param string    $message
     *
     * @throws InvalidArgumentException
     */
    public static function maxLength($value, $max, $message = '')
    {
        if (static::strlen($value) > $max) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain at most %2$s characters. Got: %s',
                static::valueToString($value),
>>>>>>> v2-test
                $max
            ));
        }
    }

<<<<<<< HEAD
    public static function lengthBetween($value, $min, $max, $message = '')
    {
        $length = self::strlen($value);

        if ($length < $min || $length > $max) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a value to contain between %2$s and %3$s characters. Got: %s',
                self::valueToString($value),
=======
    /**
     * Inclusive , so Assert::lengthBetween('asd', 3, 5); passes the assertion.
     *
     * @psalm-pure
     *
     * @param string    $value
     * @param int|float $min
     * @param int|float $max
     * @param string    $message
     *
     * @throws InvalidArgumentException
     */
    public static function lengthBetween($value, $min, $max, $message = '')
    {
        $length = static::strlen($value);

        if ($length < $min || $length > $max) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a value to contain between %2$s and %3$s characters. Got: %s',
                static::valueToString($value),
>>>>>>> v2-test
                $min,
                $max
            ));
        }
    }

<<<<<<< HEAD
    public static function fileExists($value, $message = '')
    {
        self::string($value);

        if (!file_exists($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'The file %s does not exist.',
                self::valueToString($value)
=======
    /**
     * Will also pass if $value is a directory, use Assert::file() instead if you need to be sure it is a file.
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function fileExists($value, $message = '')
    {
        static::string($value);

        if (!\file_exists($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'The file %s does not exist.',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function file($value, $message = '')
    {
        self::fileExists($value, $message);

        if (!is_file($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'The path %s is not a file.',
                self::valueToString($value)
=======
    /**
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function file($value, $message = '')
    {
        static::fileExists($value, $message);

        if (!\is_file($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'The path %s is not a file.',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function directory($value, $message = '')
    {
        self::fileExists($value, $message);

        if (!is_dir($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'The path %s is no directory.',
                self::valueToString($value)
=======
    /**
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function directory($value, $message = '')
    {
        static::fileExists($value, $message);

        if (!\is_dir($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'The path %s is no directory.',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function readable($value, $message = '')
    {
        if (!is_readable($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'The path %s is not readable.',
                self::valueToString($value)
=======
    /**
     * @param string $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function readable($value, $message = '')
    {
        if (!\is_readable($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'The path %s is not readable.',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function writable($value, $message = '')
    {
        if (!is_writable($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'The path %s is not writable.',
                self::valueToString($value)
=======
    /**
     * @param string $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function writable($value, $message = '')
    {
        if (!\is_writable($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'The path %s is not writable.',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function classExists($value, $message = '')
    {
        if (!class_exists($value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an existing class name. Got: %s',
                self::valueToString($value)
=======
    /**
     * @psalm-assert class-string $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function classExists($value, $message = '')
    {
        if (!\class_exists($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an existing class name. Got: %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function subclassOf($value, $class, $message = '')
    {
        if (!is_subclass_of($value, $class)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected a sub-class of %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($class)
=======
    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert class-string<ExpectedType>|ExpectedType $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function subclassOf($value, $class, $message = '')
    {
        if (!\is_subclass_of($value, $class)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a sub-class of %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($class)
            ));
        }
    }

    /**
     * @psalm-assert class-string $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function interfaceExists($value, $message = '')
    {
        if (!\interface_exists($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an existing interface name. got %s',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function implementsInterface($value, $interface, $message = '')
    {
        if (!in_array($interface, class_implements($value))) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected an implementation of %2$s. Got: %s',
                self::valueToString($value),
                self::valueToString($interface)
=======
    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $interface
     * @psalm-assert class-string<ExpectedType> $value
     *
     * @param mixed  $value
     * @param mixed  $interface
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function implementsInterface($value, $interface, $message = '')
    {
        if (!\in_array($interface, \class_implements($value))) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an implementation of %2$s. Got: %s',
                static::valueToString($value),
                static::valueToString($interface)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function propertyExists($classOrObject, $property, $message = '')
    {
        if (!property_exists($classOrObject, $property)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected the property %s to exist.',
                self::valueToString($property)
=======
    /**
     * @psalm-pure
     * @psalm-param class-string|object $classOrObject
     *
     * @param string|object $classOrObject
     * @param mixed         $property
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function propertyExists($classOrObject, $property, $message = '')
    {
        if (!\property_exists($classOrObject, $property)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected the property %s to exist.',
                static::valueToString($property)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function propertyNotExists($classOrObject, $property, $message = '')
    {
        if (property_exists($classOrObject, $property)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected the property %s to not exist.',
                self::valueToString($property)
=======
    /**
     * @psalm-pure
     * @psalm-param class-string|object $classOrObject
     *
     * @param string|object $classOrObject
     * @param mixed         $property
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function propertyNotExists($classOrObject, $property, $message = '')
    {
        if (\property_exists($classOrObject, $property)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected the property %s to not exist.',
                static::valueToString($property)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function methodExists($classOrObject, $method, $message = '')
    {
        if (!method_exists($classOrObject, $method)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected the method %s to exist.',
                self::valueToString($method)
=======
    /**
     * @psalm-pure
     * @psalm-param class-string|object $classOrObject
     *
     * @param string|object $classOrObject
     * @param mixed         $method
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function methodExists($classOrObject, $method, $message = '')
    {
        if (!(\is_string($classOrObject) || \is_object($classOrObject)) || !\method_exists($classOrObject, $method)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected the method %s to exist.',
                static::valueToString($method)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function methodNotExists($classOrObject, $method, $message = '')
    {
        if (method_exists($classOrObject, $method)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected the method %s to not exist.',
                self::valueToString($method)
=======
    /**
     * @psalm-pure
     * @psalm-param class-string|object $classOrObject
     *
     * @param string|object $classOrObject
     * @param mixed         $method
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function methodNotExists($classOrObject, $method, $message = '')
    {
        if ((\is_string($classOrObject) || \is_object($classOrObject)) && \method_exists($classOrObject, $method)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected the method %s to not exist.',
                static::valueToString($method)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function keyExists($array, $key, $message = '')
    {
        if (!array_key_exists($key, $array)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected the key %s to exist.',
                self::valueToString($key)
=======
    /**
     * @psalm-pure
     *
     * @param array      $array
     * @param string|int $key
     * @param string     $message
     *
     * @throws InvalidArgumentException
     */
    public static function keyExists($array, $key, $message = '')
    {
        if (!(isset($array[$key]) || \array_key_exists($key, $array))) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected the key %s to exist.',
                static::valueToString($key)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function keyNotExists($array, $key, $message = '')
    {
        if (array_key_exists($key, $array)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Expected the key %s to not exist.',
                self::valueToString($key)
=======
    /**
     * @psalm-pure
     *
     * @param array      $array
     * @param string|int $key
     * @param string     $message
     *
     * @throws InvalidArgumentException
     */
    public static function keyNotExists($array, $key, $message = '')
    {
        if (isset($array[$key]) || \array_key_exists($key, $array)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected the key %s to not exist.',
                static::valueToString($key)
            ));
        }
    }

    /**
     * Checks if a value is a valid array key (int or string).
     *
     * @psalm-pure
     * @psalm-assert array-key $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function validArrayKey($value, $message = '')
    {
        if (!(\is_int($value) || \is_string($value))) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected string or integer. Got: %s',
                static::typeToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function uuid($value, $message = '')
    {
        $value = str_replace(array('urn:', 'uuid:', '{', '}'), '', $value);
=======
    /**
     * Does not check if $array is countable, this can generate a warning on php versions after 7.2.
     *
     * @param Countable|array $array
     * @param int             $number
     * @param string          $message
     *
     * @throws InvalidArgumentException
     */
    public static function count($array, $number, $message = '')
    {
        static::eq(
            \count($array),
            $number,
            \sprintf(
                $message ?: 'Expected an array to contain %d elements. Got: %d.',
                $number,
                \count($array)
            )
        );
    }

    /**
     * Does not check if $array is countable, this can generate a warning on php versions after 7.2.
     *
     * @param Countable|array $array
     * @param int|float       $min
     * @param string          $message
     *
     * @throws InvalidArgumentException
     */
    public static function minCount($array, $min, $message = '')
    {
        if (\count($array) < $min) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an array to contain at least %2$d elements. Got: %d',
                \count($array),
                $min
            ));
        }
    }

    /**
     * Does not check if $array is countable, this can generate a warning on php versions after 7.2.
     *
     * @param Countable|array $array
     * @param int|float       $max
     * @param string          $message
     *
     * @throws InvalidArgumentException
     */
    public static function maxCount($array, $max, $message = '')
    {
        if (\count($array) > $max) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an array to contain at most %2$d elements. Got: %d',
                \count($array),
                $max
            ));
        }
    }

    /**
     * Does not check if $array is countable, this can generate a warning on php versions after 7.2.
     *
     * @param Countable|array $array
     * @param int|float       $min
     * @param int|float       $max
     * @param string          $message
     *
     * @throws InvalidArgumentException
     */
    public static function countBetween($array, $min, $max, $message = '')
    {
        $count = \count($array);

        if ($count < $min || $count > $max) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an array to contain between %2$d and %3$d elements. Got: %d',
                $count,
                $min,
                $max
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert list $array
     *
     * @param mixed  $array
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isList($array, $message = '')
    {
        if (!\is_array($array) || $array !== \array_values($array)) {
            static::reportInvalidArgument(
                $message ?: 'Expected list - non-associative array.'
            );
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert non-empty-list $array
     *
     * @param mixed  $array
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isNonEmptyList($array, $message = '')
    {
        static::isList($array, $message);
        static::notEmpty($array, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template T
     * @psalm-param mixed|array<T> $array
     * @psalm-assert array<string, T> $array
     *
     * @param mixed  $array
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isMap($array, $message = '')
    {
        if (
            !\is_array($array) ||
            \array_keys($array) !== \array_filter(\array_keys($array), '\is_string')
        ) {
            static::reportInvalidArgument(
                $message ?: 'Expected map - associative array with string keys.'
            );
        }
    }

    /**
     * @psalm-pure
     * @psalm-template T
     * @psalm-param mixed|array<T> $array
     * @psalm-assert array<string, T> $array
     * @psalm-assert !empty $array
     *
     * @param mixed  $array
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isNonEmptyMap($array, $message = '')
    {
        static::isMap($array, $message);
        static::notEmpty($array, $message);
    }

    /**
     * @psalm-pure
     *
     * @param string $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function uuid($value, $message = '')
    {
        $value = \str_replace(array('urn:', 'uuid:', '{', '}'), '', $value);
>>>>>>> v2-test

        // The nil UUID is special form of UUID that is specified to have all
        // 128 bits set to zero.
        if ('00000000-0000-0000-0000-000000000000' === $value) {
            return;
        }

<<<<<<< HEAD
        if (!preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $value)) {
            throw new InvalidArgumentException(sprintf(
                $message ?: 'Value "%s" is not a valid UUID.',
                self::valueToString($value)
=======
        if (!\preg_match('/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/', $value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Value %s is not a valid UUID.',
                static::valueToString($value)
>>>>>>> v2-test
            ));
        }
    }

<<<<<<< HEAD
    public static function __callStatic($name, $arguments)
    {
        if ('nullOr' === substr($name, 0, 6)) {
            if (null !== $arguments[0]) {
                $method = lcfirst(substr($name, 6));
                call_user_func_array(array('static', $method), $arguments);
=======
    /**
     * @psalm-param class-string<Throwable> $class
     *
     * @param Closure $expression
     * @param string  $class
     * @param string  $message
     *
     * @throws InvalidArgumentException
     */
    public static function throws(Closure $expression, $class = 'Exception', $message = '')
    {
        static::string($class);

        $actual = 'none';

        try {
            $expression();
        } catch (Exception $e) {
            $actual = \get_class($e);
            if ($e instanceof $class) {
                return;
            }
        } catch (Throwable $e) {
            $actual = \get_class($e);
            if ($e instanceof $class) {
                return;
            }
        }

        static::reportInvalidArgument($message ?: \sprintf(
            'Expected to throw "%s", got "%s"',
            $class,
            $actual
        ));
    }

    /**
     * @throws BadMethodCallException
     */
    public static function __callStatic($name, $arguments)
    {
        if ('nullOr' === \substr($name, 0, 6)) {
            if (null !== $arguments[0]) {
                $method = \lcfirst(\substr($name, 6));
                \call_user_func_array(array('static', $method), $arguments);
>>>>>>> v2-test
            }

            return;
        }

<<<<<<< HEAD
        if ('all' === substr($name, 0, 3)) {
            self::isTraversable($arguments[0]);

            $method = lcfirst(substr($name, 3));
=======
        if ('all' === \substr($name, 0, 3)) {
            static::isIterable($arguments[0]);

            $method = \lcfirst(\substr($name, 3));
>>>>>>> v2-test
            $args = $arguments;

            foreach ($arguments[0] as $entry) {
                $args[0] = $entry;

<<<<<<< HEAD
                call_user_func_array(array('static', $method), $args);
=======
                \call_user_func_array(array('static', $method), $args);
>>>>>>> v2-test
            }

            return;
        }

        throw new BadMethodCallException('No such method: '.$name);
    }

<<<<<<< HEAD
=======
    /**
     * @param mixed $value
     *
     * @return string
     */
>>>>>>> v2-test
    protected static function valueToString($value)
    {
        if (null === $value) {
            return 'null';
        }

        if (true === $value) {
            return 'true';
        }

        if (false === $value) {
            return 'false';
        }

<<<<<<< HEAD
        if (is_array($value)) {
            return 'array';
        }

        if (is_object($value)) {
            return get_class($value);
        }

        if (is_resource($value)) {
            return 'resource';
        }

        if (is_string($value)) {
=======
        if (\is_array($value)) {
            return 'array';
        }

        if (\is_object($value)) {
            if (\method_exists($value, '__toString')) {
                return \get_class($value).': '.self::valueToString($value->__toString());
            }

            if ($value instanceof DateTime || $value instanceof DateTimeImmutable) {
                return \get_class($value).': '.self::valueToString($value->format('c'));
            }

            return \get_class($value);
        }

        if (\is_resource($value)) {
            return 'resource';
        }

        if (\is_string($value)) {
>>>>>>> v2-test
            return '"'.$value.'"';
        }

        return (string) $value;
    }

<<<<<<< HEAD
    protected static function typeToString($value)
    {
        return is_object($value) ? get_class($value) : gettype($value);
=======
    /**
     * @param mixed $value
     *
     * @return string
     */
    protected static function typeToString($value)
    {
        return \is_object($value) ? \get_class($value) : \gettype($value);
>>>>>>> v2-test
    }

    protected static function strlen($value)
    {
<<<<<<< HEAD
        if (!function_exists('mb_detect_encoding')) {
            return strlen($value);
        }

        if (false === $encoding = mb_detect_encoding($value)) {
            return strlen($value);
        }

        return mb_strwidth($value, $encoding);
=======
        if (!\function_exists('mb_detect_encoding')) {
            return \strlen($value);
        }

        if (false === $encoding = \mb_detect_encoding($value)) {
            return \strlen($value);
        }

        return \mb_strlen($value, $encoding);
    }

    /**
     * @param string $message
     *
     * @throws InvalidArgumentException
     *
     * @psalm-pure this method is not supposed to perform side-effects
     */
    protected static function reportInvalidArgument($message)
    {
        throw new InvalidArgumentException($message);
>>>>>>> v2-test
    }

    private function __construct()
    {
    }
}

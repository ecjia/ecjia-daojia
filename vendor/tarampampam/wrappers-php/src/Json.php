<?php

declare(strict_types=1);

namespace Tarampampam\Wrappers;

use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;

/**
 * JSON encode/decode wrapper (methods throws exceptions on errors).
 */
class Json
{
    /**
     * Returns the JSON representation of a value.
     *
     * @link http://php.net/manual/en/function.json-encode.php
     *
     * @param mixed $value   The value being encoded. Can be any type except a resource
     * @param int   $options Options bitmask
     * @param int   $depth   Set the maximum depth. Must be greater than zero
     *
     * @throws JsonEncodeDecodeException
     *
     * @return string
     */
    public static function encode($value, int $options = 0, int $depth = 512): string
    {
        if ($options & JSON_PRETTY_PRINT_2_SPACES) {
            $options |= JSON_PRETTY_PRINT;
        }

        if ($options & JSON_EMPTY_ARRAYS_TO_OBJECTS) {
            $value = static::emptyArraysToObjects($value);
        }

        $json = \json_encode($value, $options, $depth);

        // `is_string()` is required because `json_encode()` can returns `false`
        if (($error_code = \json_last_error()) !== JSON_ERROR_NONE || ! \is_string($json)) {
            throw static::jsonErrorToException($error_code);
        }

        if ($options & JSON_PRETTY_PRINT_2_SPACES) {
            $json = (string) \preg_replace_callback('/^ +/m', static function ($m) {
                return \str_repeat(' ', \mb_strlen($m[0]) / 2);
            }, $json);
        }

        return $json;
    }

    /**
     * Decodes a JSON string.
     *
     * This method only works with UTF-8 encoded strings.
     *
     * By default returns data as associative array.
     *
     * @link http://php.net/manual/en/function.json-decode.php
     *
     * @param string $json_string The json string being decoded
     * @param bool   $assoc       When TRUE, returned objects will be converted into associative arrays
     * @param int    $depth       User specified recursion depth
     * @param int    $options     Bitmask of JSON decode options
     *
     * @throws JsonEncodeDecodeException
     *
     * @return array<mixed>|object|bool|null|string|float|int
     */
    public static function decode(string $json_string, bool $assoc = true, int $depth = 512, int $options = 0)
    {
        $data = \json_decode($json_string, $assoc, $depth, $options);

        if (($error_code = \json_last_error()) !== JSON_ERROR_NONE) {
            throw static::jsonErrorToException($error_code);
        }

        return $data;
    }

    /**
     * Converts JSON decode error into exception.
     *
     * @param int|null $json_error_code
     *
     * @return JsonEncodeDecodeException
     */
    public static function jsonErrorToException(?int $json_error_code): JsonEncodeDecodeException
    {
        switch ($json_error_code) {
            case JSON_ERROR_DEPTH:
                return JsonEncodeDecodeException::depth();

            case JSON_ERROR_STATE_MISMATCH:
                return JsonEncodeDecodeException::stateMismatch();

            case JSON_ERROR_CTRL_CHAR:
                return JsonEncodeDecodeException::ctrlChar();

            case JSON_ERROR_SYNTAX:
                return JsonEncodeDecodeException::syntax();

            case JSON_ERROR_UTF8:
                return JsonEncodeDecodeException::utf8();

            case JSON_ERROR_RECURSION:
                return JsonEncodeDecodeException::recursion();

            case JSON_ERROR_INF_OR_NAN:
                return JsonEncodeDecodeException::infOrNan();

            case JSON_ERROR_UNSUPPORTED_TYPE:
                return JsonEncodeDecodeException::unsupportedType();

            case 9: // JSON_ERROR_INVALID_PROPERTY_NAME: // Available since PHP 7.0.0
                return JsonEncodeDecodeException::invalidPropertyName();

            case 10: // JSON_ERROR_UTF16: // Available since PHP 7.0.0
                return JsonEncodeDecodeException::utf16();
        }

        return JsonEncodeDecodeException::unknown();
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected static function emptyArraysToObjects($value)
    {
        if (\is_array($value)) {
            return \count($value) === 0
                ? (object) $value
                : \array_map(static function ($v) {
                    return self::emptyArraysToObjects($v);
                }, $value); // recursive
        }

        if (\is_object($value)) {
            $new_object = new \stdClass;

            foreach (\get_object_vars($value) as $object_key => $object_value) {
                $new_object->{$object_key} = \is_array($object_value) || \is_object($object_value)
                    ? static::emptyArraysToObjects($object_value)
                    : $object_value;
            }

            return $new_object;
        }

        return $value;
    }
}

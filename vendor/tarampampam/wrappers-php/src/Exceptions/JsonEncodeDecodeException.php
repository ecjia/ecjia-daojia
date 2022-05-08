<?php

declare(strict_types=1);

namespace Tarampampam\Wrappers\Exceptions;

use Exception;

class JsonEncodeDecodeException extends Exception
{
    /**
     * @see JSON_ERROR_DEPTH
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function depth(int $code = 1, ?Exception $previous = null): self
    {
        return new self('The maximum stack depth has been exceeded', $code, $previous);
    }

    /**
     * @see JSON_ERROR_STATE_MISMATCH
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function stateMismatch(int $code = 2, ?Exception $previous = null): self
    {
        return new self('Invalid or malformed JSON', $code, $previous);
    }

    /**
     * @see JSON_ERROR_CTRL_CHAR
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function ctrlChar(int $code = 3, ?Exception $previous = null): self
    {
        return new self('Control character error, possibly incorrectly encoded', $code, $previous);
    }

    /**
     * @see JSON_ERROR_SYNTAX
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function syntax(int $code = 4, ?Exception $previous = null): self
    {
        return new self('Syntax error', $code, $previous);
    }

    /**
     * @see JSON_ERROR_UTF8
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function utf8(int $code = 5, ?Exception $previous = null): self
    {
        return new self('Malformed UTF-8 characters, possibly incorrectly encoded', $code, $previous);
    }

    /**
     * @see JSON_ERROR_RECURSION
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function recursion(int $code = 6, ?Exception $previous = null): self
    {
        return new self('One or more recursive references in the value to be encoded', $code, $previous);
    }

    /**
     * @see JSON_ERROR_INF_OR_NAN
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function infOrNan(int $code = 7, ?Exception $previous = null): self
    {
        return new self('One or more NAN or INF values in the value to be encoded', $code, $previous);
    }

    /**
     * @see JSON_ERROR_UNSUPPORTED_TYPE
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function unsupportedType(int $code = 8, ?Exception $previous = null): self
    {
        return new self('A value of a type that cannot be encoded was given', $code, $previous);
    }

    /**
     * @see JSON_ERROR_INVALID_PROPERTY_NAME
     *
     * Available since PHP 7.0.0
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function invalidPropertyName(int $code = 9, ?Exception $previous = null): self
    {
        return new self('A property name that cannot be encoded was given', $code, $previous);
    }

    /**
     * @see JSON_ERROR_UTF16
     *
     * Available since PHP 7.0.0
     *
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function utf16(int $code = 10, ?Exception $previous = null): self
    {
        return new self('Malformed UTF-16 characters, possibly incorrectly encoded', $code, $previous);
    }

    /**
     * @param int            $code
     * @param Exception|null $previous
     *
     * @return self
     */
    public static function unknown(int $code = 0, ?Exception $previous = null): self
    {
        return new self('Unknown error', $code, $previous);
    }
}

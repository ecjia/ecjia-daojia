<?php namespace Royalcms\Component\Support;

use InvalidArgumentException;

class Json
{
    /**
     * Encodes the given value into a JSON string.
     *
     * @param $value
     * @param int $options
     * @return string
     * @throws InvalidParamException if there is any encoding error
     */
    public static function encode($value, $options = null)
    {
        if ($options === null) {
            $options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
        }

        $json = json_encode($value, $options);

        static::handleJsonError(json_last_error());

        return $json;
    }

    /**
     * Decodes the given JSON string into a PHP data structure.
     * @param string $json the JSON string to be decoded
     * @param boolean $asArray whether to return objects in terms of associative arrays.
     * @return mixed the PHP data
     * @throws InvalidParamException if there is any decoding error
     */
    public static function decode($json, $asArray = true)
    {
        if (is_array($json)) {
            throw new InvalidArgumentException('Invalid JSON data.');
        }
        $decode = json_decode((string) $json, $asArray);

        static::handleJsonError(json_last_error());

        return $decode;
    }
    
    /**
     * Verify JSON string is legal
     * @param string $json
     * @return boolean
     */
    public static function validate($json) {
        try {
            self::decode($json);
            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    protected static function handleJsonError($lastError)
    {
        switch ($lastError) {
            case JSON_ERROR_NONE:
                break;
            case JSON_ERROR_DEPTH:
                throw new InvalidArgumentException('The maximum stack depth has been exceeded.');
            case JSON_ERROR_CTRL_CHAR:
                throw new InvalidArgumentException('Control character error, possibly incorrectly encoded.');
            case JSON_ERROR_SYNTAX:
                throw new InvalidArgumentException('Syntax error.');
            case JSON_ERROR_STATE_MISMATCH:
                throw new InvalidArgumentException('Invalid or malformed JSON.');
            case JSON_ERROR_UTF8:
                throw new InvalidArgumentException('Malformed UTF-8 characters, possibly incorrectly encoded.');
            default:
                throw new InvalidArgumentException('Unknown JSON decoding error.');
        }
    }
}

// end
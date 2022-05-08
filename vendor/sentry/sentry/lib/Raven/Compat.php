<?php

/*
 * This file is part of Raven.
 *
 * (c) Sentry Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Raven_Compat
{
    public static function gethostname()
    {
        if (function_exists('gethostname')) {
            return gethostname();
        }

        return self::_gethostname();
    }

    public static function _gethostname()
    {
        return php_uname('n');
    }

<<<<<<< HEAD
    public static function hash_hmac($algo, $data, $key, $raw_output=false)
=======
    public static function hash_hmac($algo, $data, $key, $raw_output = false)
>>>>>>> v2-test
    {
        if (function_exists('hash_hmac')) {
            return hash_hmac($algo, $data, $key, $raw_output);
        }

        return self::_hash_hmac($algo, $data, $key, $raw_output);
    }

    /**
     * Implementation from 'KC Cloyd'.
<<<<<<< HEAD
     * See http://nl2.php.net/manual/en/function.hash-hmac.php
     */
    public static function _hash_hmac($algo, $data, $key, $raw_output=false)
=======
     *
     * @param string $algo       Name of selected hashing algorithm
     * @param string $data       Message to be hashed
     * @param string $key        Shared secret key used for generating the HMAC variant of the message digest
     * @param bool   $raw_output Must be binary
     * @return string
     * @doc http://php.net/manual/en/function.hash-hmac.php
     */
    public static function _hash_hmac($algo, $data, $key, $raw_output = false)
>>>>>>> v2-test
    {
        $algo = strtolower($algo);
        $pack = 'H'.strlen($algo('test'));
        $size = 64;
        $opad = str_repeat(chr(0x5C), $size);
        $ipad = str_repeat(chr(0x36), $size);

        if (strlen($key) > $size) {
            $key = str_pad(pack($pack, $algo($key)), $size, chr(0x00));
        } else {
            $key = str_pad($key, $size, chr(0x00));
        }

        $keyLastPos = strlen($key) - 1;
        for ($i = 0; $i < $keyLastPos; $i++) {
            $opad[$i] = $opad[$i] ^ $key[$i];
            $ipad[$i] = $ipad[$i] ^ $key[$i];
        }

        $output = $algo($opad.pack($pack, $algo($ipad.$data)));

        return ($raw_output) ? pack($pack, $output) : $output;
    }

    /**
     * Note that we discard the options given to be compatible
     * with PHP < 5.3
<<<<<<< HEAD
     */
    public static function json_encode($value, $options=0)
    {
        if (function_exists('json_encode')) {
            return json_encode($value);
        }

        return self::_json_encode($value);
=======
     *
     * @param mixed $value
     * @param int   $options
     * @param int   $depth Set the maximum depth
     * @return string
     */
    public static function json_encode($value, $options = 0, $depth = 512)
    {
        if (function_exists('json_encode')) {
            if (PHP_VERSION_ID < 50300) {
                return json_encode($value);
            } elseif (PHP_VERSION_ID < 50500) {
                return json_encode($value, $options);
            } else {
                return json_encode($value, $options, $depth);
            }
        }

        // @codeCoverageIgnoreStart
        return self::_json_encode($value, $depth);
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param mixed $value
     * @param int   $depth Set the maximum depth
     * @return string|false
     */
    public static function _json_encode($value, $depth = 513)
    {
        if (extension_loaded('xdebug')) {
            ini_set('xdebug.max_nesting_level', 2048);
        }
        return self::_json_encode_lowlevel($value, $depth);
>>>>>>> v2-test
    }

    /**
     * Implementation taken from
     * http://www.mike-griffiths.co.uk/php-json_encode-alternative/
<<<<<<< HEAD
     */
    public static function _json_encode($value)
    {
        static $jsonReplaces = array(
            array('\\', '/', "\n", "\t", "\r", "\b", "\f", '"'),
            array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
=======
     *
     * @param mixed $value
     * @param int   $depth Set the maximum depth
     * @return string|false
     */
    private static function _json_encode_lowlevel($value, $depth)
    {
        static $jsonReplaces = array(
            array('\\', '/', "\n", "\t", "\r", "\f", '"'),
            array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\f', '\"'));
>>>>>>> v2-test

        if (is_null($value)) {
            return 'null';
        }
        if ($value === false) {
            return 'false';
        }
        if ($value === true) {
            return 'true';
        }

        if (is_scalar($value)) {
<<<<<<< HEAD

=======
>>>>>>> v2-test
            // Always use '.' for floats.
            if (is_float($value)) {
                return floatval(str_replace(',', '.', strval($value)));
            }
            if (is_string($value)) {
                return sprintf('"%s"',
                    str_replace($jsonReplaces[0], $jsonReplaces[1], $value));
            } else {
                return $value;
            }
<<<<<<< HEAD
=======
        } elseif ($depth <= 1) {
            return false;
>>>>>>> v2-test
        }

        $isList = true;
        for ($i = 0, reset($value); $i<count($value); $i++, next($value)) {
            if (key($value) !== $i) {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList) {
            foreach ($value as $v) {
<<<<<<< HEAD
                $result[] = self::_json_encode($v);
=======
                $this_value = self::_json_encode($v, $depth - 1);
                if ($this_value === false) {
                    return false;
                }
                $result[] = $this_value;
>>>>>>> v2-test
            }

            return '[' . join(',', $result) . ']';
        } else {
            foreach ($value as $k => $v) {
<<<<<<< HEAD
                $result[] = self::_json_encode($k) . ':' . self::_json_encode($v);
=======
                $this_value = self::_json_encode($v, $depth - 1);
                if ($this_value === false) {
                    return false;
                }
                $result[] = self::_json_encode($k, $depth - 1).':'.$this_value;
>>>>>>> v2-test
            }

            return '{' . join(',', $result) . '}';
        }
    }
<<<<<<< HEAD
=======

    public static function strlen($string)
    {
        if (extension_loaded('mbstring')) {
            return mb_strlen($string, 'UTF-8');
        }

        return strlen($string);
    }

    public static function substr($string, $start, $length)
    {
        if (extension_loaded('mbstring')) {
            return mb_substr($string, $start, $length, 'UTF-8');
        }

        return substr($string, $start, $length);
    }
>>>>>>> v2-test
}

<?php

if (! function_exists('curl_reset')) {
    /**
     * curl_reset — 重置一个 libcurl 会话句柄的所有的选项
     * 兼容php5.5以下没有这个函数的使用
     *
     * @param  resource  $value 由 curl_init() 返回的 cURL 句柄。
     */
    function curl_reset(& $ch)
    {
        $ch = curl_init();
    }
}

if (! function_exists('curl_file_create')) {
    /**
     * curl_file_create — 创建一个 CURLFile 对象
     * 兼容php5.5以下没有这个函数的使用
     *
     * @param  resource  $value
     */
    function curl_file_create($filename, $mimetype = '', $postname = '') {
        return "@$filename;filename="
        . ($postname ?: basename($filename))
        . ($mimetype ? ";type=$mimetype" : '');
    }
}

if ( !function_exists('array_column') )
{
    /**
     * Pluck a certain field out of each object in a list.
     *
     * This has the same functionality and prototype of
     * array_column() (PHP 5.5) but also supports objects.
     *
     * @since 3.2.0 $index_key parameter added.
     *
     * @param array      $input      List of objects or arrays
     * @param int|string $column_key     Field from the object to place instead of the entire object
     * @param int|string $index_key Optional. Field from the object to use as keys for the new array.
     *                              Default null.
     * @return array Array of found values. If $index_key is set, an array of found values with keys
     *               corresponding to $index_key.
     */
    function array_column( $input, $column_key, $index_key = null ) {
        $list = [];
        if ( ! $index_key ) {
            /*
             * This is simple. Could at some point wrap array_column()
            * if we knew we had an array of arrays.
            */
            foreach ( $input as $key => $value ) {
                if ( is_object( $value ) ) {
                    $list[ $key ] = $value->$column_key;
                } else {
                    $list[ $key ] = $value[ $column_key ];
                }
            }
            return $list;
        }

        /*
         * When index_key is not set for a particular item, push the value
        * to the end of the stack. This is how array_column() behaves.
        */
        $newlist = array();
        foreach ( $list as $value ) {
            if ( is_object( $value ) ) {
                if ( isset( $value->$index_key ) ) {
                    $newlist[ $value->$index_key ] = $value->$column_key;
                } else {
                    $newlist[] = $value->$column_key;
                }
            } else {
                if ( isset( $value[ $index_key ] ) ) {
                    $newlist[ $value[ $index_key ] ] = $value[ $column_key ];
                } else {
                    $newlist[] = $value[ $column_key ];
                }
            }
        }

        return $newlist;
    }
}

if ( !function_exists('rc_parse_url') )
{
    /**
     * A wrapper for PHP's parse_url() function that handles consistency in the return
     * values across PHP versions.
     *
     * PHP 5.4.7 expanded parse_url()'s ability to handle non-absolute url's, including
     * schemeless and relative url's with :// in the path. This function works around
     * those limitations providing a standard output on PHP 5.2~5.4+.
     *
     * Secondly, across various PHP versions, schemeless URLs starting containing a ":"
     * in the query are being handled inconsistently. This function works around those
     * differences as well.
     *
     * Error suppression is used as prior to PHP 5.3.3, an E_WARNING would be generated
     * when URL parsing failed.
     *
     * @since 4.4.0
     * @since 4.7.0 The $component parameter was added for parity with PHP's parse_url().
     *
     * @param string $url       The URL to parse.
     * @param int    $component The specific component to retrieve. Use one of the PHP
     *                          predefined constants to specify which one.
     *                          Defaults to -1 (= return all parts as an array).
     *                          @see http://php.net/manual/en/function.parse-url.php
     * @return mixed False on parse failure; Array of URL components on success;
     *               When a specific component has been requested: null if the component
     *               doesn't exist in the given URL; a sting or - in the case of
     *               PHP_URL_PORT - integer when it does. See parse_url()'s return values.
     */
    function rc_parse_url( $url, $component = -1 ) {
        $to_unset = array();
        $url = strval( $url );
    
        if ( '//' === substr( $url, 0, 2 ) ) {
            $to_unset[] = 'scheme';
            $url = 'placeholder:' . $url;
        } elseif ( '/' === substr( $url, 0, 1 ) ) {
            $to_unset[] = 'scheme';
            $to_unset[] = 'host';
            $url = 'placeholder://placeholder' . $url;
        }
    
        $parts = @parse_url( $url );
    
        if ( false === $parts ) {
            // Parsing failure.
            return $parts;
        }
    
        // Remove the placeholder values.
        foreach ( $to_unset as $key ) {
            unset( $parts[ $key ] );
        }
    
        return _get_component_from_parsed_url_array( $parts, $component );
    }
}

if ( !function_exists('_rc_translate_php_url_constant_to_key') )
{
    /**
     * Translate a PHP_URL_* constant to the named array keys PHP uses.
     *
     * @internal
     *
     * @since 4.7.0
     *
     * @see   http://php.net/manual/en/url.constants.php
     *
     * @param int $constant PHP_URL_* constant.
     * @return string|bool The named key or false.
     */
    function _rc_translate_php_url_constant_to_key( $constant ) {
        $translation = array(
            PHP_URL_SCHEME   => 'scheme',
            PHP_URL_HOST     => 'host',
            PHP_URL_PORT     => 'port',
            PHP_URL_USER     => 'user',
            PHP_URL_PASS     => 'pass',
            PHP_URL_PATH     => 'path',
            PHP_URL_QUERY    => 'query',
            PHP_URL_FRAGMENT => 'fragment',
        );

        if ( isset( $translation[ $constant ] ) ) {
            return $translation[ $constant ];
        } else {
            return false;
        }
    }
}

if ( !function_exists('_get_component_from_parsed_url_array') )
{
    /**
     * Retrieve a specific component from a parsed URL array.
     *
     * @internal
     *
     * @since 4.7.0
     *
     * @param array|false $url_parts The parsed URL. Can be false if the URL failed to parse.
     * @param int    $component The specific component to retrieve. Use one of the PHP
     *                          predefined constants to specify which one.
     *                          Defaults to -1 (= return all parts as an array).
     *                          @see http://php.net/manual/en/function.parse-url.php
     * @return mixed False on parse failure; Array of URL components on success;
     *               When a specific component has been requested: null if the component
     *               doesn't exist in the given URL; a sting or - in the case of
     *               PHP_URL_PORT - integer when it does. See parse_url()'s return values.
     */
    function _get_component_from_parsed_url_array( $url_parts, $component = -1 ) {
        if ( -1 === $component ) {
            return $url_parts;
        }

        $key = _rc_translate_php_url_constant_to_key( $component );
        if ( false !== $key && is_array( $url_parts ) && isset( $url_parts[ $key ] ) ) {
            return $url_parts[ $key ];
        } else {
            return null;
        }
    }
}

if ( !function_exists('curl_file_create') ) 
{
    function curl_file_create($filename, $mimetype = 'application/octet-stream', $postname = 'name') {
        return new \Royalcms\Component\Requests\Utility\CURLFile($filename, $mimetype, $postname);
    }
}

if ( !class_exists('\CURLFile'))
{
    $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
    $loader->alias('CURLFile', 'Royalcms\Component\Requests\Utility\CURLFile');
}


if ( !function_exists( 'random_int' ) ) {
    // random_int was introduced in PHP 7.0
    require VENDOR_PATH . 'paragonie/random_compat/lib/random.php';
}

// PHP 5 >= 5.5.0, PHP 7
if ( !function_exists('boolval')) {
    function boolval($val) {
        return (bool) $val;
    }
}

// PHP 5 >= 5.5.0, PHP 7
if ( !function_exists('json_last_error_msg')) {
    function json_last_error_msg() {
        static $ERRORS = array(
            JSON_ERROR_NONE => 'No error',
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
            JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX => 'Syntax error',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
        );

        $error = json_last_error();
        return isset($ERRORS[$error]) ? $ERRORS[$error] : 'Unknown error';
    }
}

// PHP 5 >= 5.6.0, PHP 7
if (!function_exists('hash_equals')) {

    /**
     * Timing attack safe string comparison
     *
     * Compares two strings using the same time whether they're equal or not.
     * This function should be used to mitigate timing attacks; for instance, when testing crypt() password hashes.
     *
     * @param string $known_string The string of known length to compare against
     * @param string $user_string The user-supplied string
     * @return boolean Returns TRUE when the two strings are equal, FALSE otherwise.
     */
    function hash_equals($known_string, $user_string)
    {
        if (func_num_args() !== 2) {
            // handle wrong parameter count as the native implentation
            trigger_error('hash_equals() expects exactly 2 parameters, ' . func_num_args() . ' given', E_USER_WARNING);
            return null;
        }
        if (is_string($known_string) !== true) {
            trigger_error('hash_equals(): Expected known_string to be a string, ' . gettype($known_string) . ' given', E_USER_WARNING);
            return false;
        }
        $known_string_len = strlen($known_string);
        $user_string_type_error = 'hash_equals(): Expected user_string to be a string, ' . gettype($user_string) . ' given'; // prepare wrong type error message now to reduce the impact of string concatenation and the gettype call
        if (is_string($user_string) !== true) {
            trigger_error($user_string_type_error, E_USER_WARNING);
            // prevention of timing attacks might be still possible if we handle $user_string as a string of diffent length (the trigger_error() call increases the execution time a bit)
            $user_string_len = strlen($user_string);
            $user_string_len = $known_string_len + 1;
        } else {
            $user_string_len = $known_string_len + 1;
            $user_string_len = strlen($user_string);
        }
        if ($known_string_len !== $user_string_len) {
            $res = $known_string ^ $known_string; // use $known_string instead of $user_string to handle strings of diffrent length.
            $ret = 1; // set $ret to 1 to make sure false is returned
        } else {
            $res = $known_string ^ $user_string;
            $ret = 0;
        }
        for ($i = strlen($res) - 1; $i >= 0; $i--) {
            $ret |= ord($res[$i]);
        }
        return $ret === 0;
    }

}
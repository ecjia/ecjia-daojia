<?php
/**
 * common.php 公共函数库
 * @package Royalcms
 */

if ( ! function_exists('callable_type'))
{
    /**
     * The callable types and normalizations are given in the table below:
     *
     *  Callable                        | Normalization                   | Type
     * ---------------------------------+---------------------------------+--------------
     *  function (...) use (...) {...}  | function (...) use (...) {...}  | 'closure'
     *  $object                         | $object                         | 'invocable'
     *  "function"                      | "function"                      | 'function'
     *  "class::method"                 | ["class", "method"]             | 'static'
     *  ["class", "parent::method"]     | ["parent of class", "method"]   | 'static'
     *  ["class", "self::method"]       | ["class", "method"]             | 'static'
     *  ["class", "method"]             | ["class", "method"]             | 'static'
     *  [$object, "parent::method"]     | [$object, "parent::method"]     | 'object'
     *  [$object, "self::method"]       | [$object, "method"]             | 'object'
     *  [$object, "method"]             | [$object, "method"]             | 'object'
     * ---------------------------------+---------------------------------+--------------
     *  other callable                  | idem                            | 'unknown'
     * ---------------------------------+---------------------------------+--------------
     *  not a callable                  | null                            | false
     *
     * If the "strict" parameter is set to true, additional checks are
     * performed, in particular:
     *  - when a callable string of the form "class::method" or a callable array
     *    of the form ["class", "method"] is given, the method must be a static one,
     *  - when a callable array of the form [$object, "method"] is given, the
     *    method must be a non-static one.
     *
     */
    function callable_type($callable, $strict = true, callable& $norm = null) {
        if (!is_callable($callable)) {
            switch (true) {
                case is_object($callable):
                    $norm = $callable;
                    return 'Closure' === get_class($callable) ? 'closure' : 'invocable';
                case is_string($callable):
                    $m    = null;
                    if (preg_match('~^(?<class>[a-z_][a-z0-9_]*)::(?<method>[a-z_][a-z0-9_]*)$~i', $callable, $m)) {
                        list($left, $right) = [$m['class'], $m['method']];
                        if (!$strict || with(new \ReflectionMethod($left, $right))->isStatic()) {
                            $norm = [$left, $right];
                            return 'static';
                        }
                    } else {
                        $norm = $callable;
                        return 'function';
                    }
                    break;
                case is_array($callable):
                    $m = null;
                    if (preg_match('~^(:?(?<reference>self|parent)::)?(?<method>[a-z_][a-z0-9_]*)$~i', $callable[1], $m)) {
                        if (is_string($callable[0])) {
                            if ('parent' === strtolower($m['reference'])) {
                                list($left, $right) = [get_parent_class($callable[0]), $m['method']];
                            } else {
                                list($left, $right) = [$callable[0], $m['method']];
                            }
                            if (!$strict || with(new \ReflectionMethod($left, $right))->isStatic()) {
                                $norm = [$left, $right];
                                return 'static';
                            }
                        } else {
                            if ('self' === strtolower($m['reference'])) {
                                list($left, $right) = [$callable[0], $m['method']];
                            } else {
                                list($left, $right) = $callable;
                            }
                            if (!$strict || ! with(new \ReflectionMethod($left, $right))->isStatic()) {
                                $norm = [$left, $right];
                                return 'object';
                            }
                        }
                    }
                    break;
            }
            $norm = $callable;
            return 'unknown';
        }
        $norm = null;
        return false;
    }
}

if ( ! function_exists('rc_addslashes'))
{
    /**
     * 返回经addslashes处理过的字符串或数组或对象
     *
     * @param string|array|object $string 需要处理的字符串或数组或对象
     * @return mixed
     */
    function rc_addslashes($string)
    {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = rc_addslashes($val);
            }
        } elseif (is_object($string) == true) {
            foreach ($string as $key => $val) {
                $string->$key = rc_addslashes($val);
            }
        } else {
            $string = addslashes($string);
        }
    
        return $string;
    }
}

if ( ! function_exists('rc_stripslashes'))
{
    /**
     * 返回经stripslashes处理过的字符串或数组或对象
     *
     * @param string|array|object $string 需要处理的字符串或数组或对象
     * @return mixed
     */
    function rc_stripslashes($string)
    {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = rc_stripslashes($val);
            }
        } elseif (is_object($string) == true) {
            foreach ($string as $key => $val) {
                $string->$key = rc_stripslashes($val);
            }
        } else {
            $string = stripslashes($string);
        }
    
        return $string;
    }
}


if ( ! function_exists('rc_htmlspecialchars')) 
{
    /**
     * 返回经addslashe处理过的字符串或数组或对象
     *
     * @param string|array|object $string 需要处理的字符串或数组或对象
     * @return mixed
     */
    function rc_htmlspecialchars($string)
    {
        if (!is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = strip_tags($val);
            }
        } elseif (is_object($string) == true) {
            foreach ($string as $key => $val) {
                $string->$key = strip_tags($val);
            }
        } else {
            $string = htmlspecialchars($string);
        }
    
        return $string;
    }
}


if ( ! function_exists('rc_unslash'))
{
    /**
     * Remove slashes from a string or array of strings.
     *
     * This should be used to remove slashes from data passed to core API that
     * expects data to be unslashed.
     *
     * @since 3.6.0
     *
     * @param string|array $value String or array of strings to unslash.
     * @return string|array Unslashed $value
     */
    function rc_unslash( $value ) {
        return rc_stripslashes( $value );
    }   
}


if ( ! function_exists('safe_replace'))
{
    /**
     * 安全过滤函数
     *
     * @param
     *            $string
     * @return string
     */
    function safe_replace($string)
    {
        $string = str_replace('%20', '', $string);
        $string = str_replace('%27', '', $string);
        $string = str_replace('%2527', '', $string);
        $string = str_replace('*', '', $string);
        $string = str_replace('"', '&quot;', $string);
        $string = str_replace("'", '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace(';', '', $string);
        $string = str_replace('<', '&lt;', $string);
        $string = str_replace('>', '&gt;', $string);
        $string = str_replace("{", '', $string);
        $string = str_replace('}', '', $string);
        return $string;
    }
}

if ( ! function_exists('safe_remove'))
{
    /**
     * 安全过滤函数
     *
     * @param
     *            $string
     * @return string
     */
    function safe_remove($string)
    {
        $string = str_replace('%20', '', $string);
        $string = str_replace('%27', '', $string);
        $string = str_replace('%2527', '', $string);
        $string = str_replace('*', '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace("'", '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace(';', '', $string);
        $string = str_replace('<', '', $string);
        $string = str_replace('>', '', $string);
        $string = str_replace("{", '', $string);
        $string = str_replace('}', '', $string);
        $string = str_replace('\\', '', $string);
        $string = str_replace('/', '', $string);
        $string = str_replace('[', '', $string);
        $string = str_replace(']', '', $string);
        return $string;
    }
}

if ( ! function_exists('trim_unsafe_control_chars'))
{
    /**
     * 过滤ASCII码从0-28的控制字符
     *
     * @return String
     */
    function trim_unsafe_control_chars($str)
    {
        $rule = '/[' . chr(1) . '-' . chr(8) . chr(11) . '-' . chr(12) . chr(14) . '-' . chr(31) . ']*/';
        return str_replace(chr(0), '', preg_replace($rule, '', $str));
    }
}


if ( ! function_exists('mbstring_binary_safe_encoding'))
{
    /**
     * Set the mbstring internal encoding to a binary safe encoding when func_overload
     * is enabled.
     *
     * When mbstring.func_overload is in use for multi-byte encodings, the results from
     * strlen() and similar functions respect the utf8 characters, causing binary data
     * to return incorrect lengths.
     *
     * This function overrides the mbstring encoding to a binary-safe encoding, and
     * resets it to the users expected encoding afterwards through the
     * `reset_mbstring_encoding` function.
     *
     * It is safe to recursively call this function, however each
     * `mbstring_binary_safe_encoding()` call must be followed up with an equal number
     * of `reset_mbstring_encoding()` calls.
     *
     * @since 3.2.0
     *
     * @see reset_mbstring_encoding()
     *
     * @param bool $reset Optional. Whether to reset the encoding back to a previously-set encoding.
     *                    Default false.
     */
    function mbstring_binary_safe_encoding( $reset = false ) {
        static $encodings = array();
        static $overloaded = null;
    
        if ( is_null( $overloaded ) )
            $overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );
    
        if ( false === $overloaded )
            return;
    
        if ( ! $reset ) {
            $encoding = mb_internal_encoding();
            array_push( $encodings, $encoding );
            mb_internal_encoding( 'ISO-8859-1' );
        }
    
        if ( $reset && $encodings ) {
            $encoding = array_pop( $encodings );
            mb_internal_encoding( $encoding );
        }
    }
}

if ( ! function_exists('reset_mbstring_encoding'))
{
    /**
     * Reset the mbstring internal encoding to a users previously set encoding.
     *
     * @see mbstring_binary_safe_encoding()
     *
     * @since 3.2.0
     */
    function reset_mbstring_encoding() {
        mbstring_binary_safe_encoding( true );
    }
}

if ( ! function_exists('_jump'))
{
    /**
     * 跳转网址
     *
     * @param string $url
     *            跳转urlg
     * @param int $time
     *            跳转时间
     * @param string $msg
     */
    function _jump($url, $time = 0, $msg = '')
    {
        $url = RC_Uri::url($url);
        if (! headers_sent()) {
            $time == 0 ? header("Location:" . $url) : header("refresh:{$time};url={$url}");
            exit($msg);
        } else {
            echo "<meta http-equiv='refresh' content='{$time};URL={$url}'>";
            if ($time)
                exit($msg);
        }
    }
}

if ( ! function_exists('_dump'))
{
    /**
     * 调试输出数据
     *
     * @param var $var
     *            变量或对象
     * @param boolean $output
     *            输出方式 0 不输出, 1 界面输出, 2 注释输出, 3 txt中断输出
     */
    function _dump($var, $output = 0)
    {
        static $infos = array();
    
        $backtrace = debug_backtrace();
        $file = $backtrace[0]['file'];
        $line = $backtrace[0]['line'];
        $type = gettype($var);
        unset($backtrace);
    
        ob_start();
        if (is_bool($var)) {
            var_dump($var);
            $content = $a = ob_get_contents();
        } elseif (is_null($var)) {
            var_dump(NULL);
            $content = $a = ob_get_contents();
        } else {
            $content = print_r($var, true);
        }
        ob_end_clean();
    
    
        $infos[] = array(
            'file' => $file,
            'line' => $line,
            'type' => $type,
            'content' => $content,
        );
    
    
        if ($output === 1 || $output === 2 || $output === 3 || $output === 4) {
            foreach ($infos as $key => $info) {
                if ($output === 1) {
                    $str = '<pre style="padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;">';
                    $str .= "\r\n";
                    $str .= '<strong>FILE</strong>: ' . $info['file'] . " <br />";
                    $str .= '<strong>LINE</strong>: ' . $info['line'] . " <br />";
                    $str .= '<strong>TYPE</strong>: ' . $info['type'] . " <br />";
                    $str .= '<strong>CONTENT</strong>: ' . trim($info['content'], "\r\n");
                    $str .= "\r\n";
                    $str .= "</pre>";
                } elseif ($output === 2) {
                    $str = "<!-- DEBUG Notes Information Start \r\n";
                    $str .= 'FILE: ' . $info['file'] . " \r\n";
                    $str .= 'LINE: ' . $info['line'] . " \r\n";
                    $str .= 'TYPE: ' . $info['type'] . " \r\n";
                    $str .= 'CONTENT: ' . trim($info['content'], "\r\n");
                    $str .= "\r\n";
                    $str .= "// DEBUG Notes Information End -->\r\n";
                } elseif ($output === 3) {
                    $str = 'FILE: ' . $info['file'] . " \r\n";
                    $str .= 'LINE: ' . $info['line'] . " \r\n";
                    $str .= 'TYPE: ' . $info['type'] . " \r\n";
                    $str .= 'CONTENT: ' . trim($info['content'], "\r\n");
                    $str .= "\r\n";
                    $str .= '================================';
                    $str .= "\r\n";
                } elseif ($output === 4) {
                    $str = '<script type="text/javascript">';
                    $str .= "console.log('";
                    $str .= "%cDUMP {$key}\\n', 'font-size:1em',";
                    $str .= " '\\nFILE:" . $info['file'] . '\\nLINE:' . $info['line'] . '\\nTYPE:' . $info['type'] . '\\nCONTENT:' . str_replace(array("\r\n", "\r", "\n"), "\\n", $info['content']);
                    $str .= "');";
                    $str .= "</script>";
                }
    
                echo $str;
            }
    
            if ($output === 1 || $output === 3) {
                exit(0);
            }
        }
    }
}

if ( ! function_exists('_404'))
{
    /**
     * 404错误
     *
     * @param string $msg
     *            提示信息
     * @param string $url
     *            跳转url
     */
    function _404($msg = '')
    {
        if (RC_Hook::has_action('handle_404_error')) {
            RC_Hook::do_action('handle_404_error');
        } else {
            Royalcms\Component\Error\ErrorDisplay::http_error(404, $msg);
        }
    }
}

if ( ! function_exists('_500'))
{
    /**
     * 404错误
     *
     * @param string $msg
     *            提示信息
     * @param string $url
     *            跳转url
     */
    function _500($msg = '')
    {
        if (RC_Hook::has_action('handle_500_error')) {
            RC_Hook::do_action('handle_500_error');
        } else {
            Royalcms\Component\Error\ErrorDisplay::http_error(500, $msg);
        }
    }
}

if ( ! function_exists('_halt'))
{
    /**
     * 错误中断
     *
     * @param
     *            string | array $error 错误内容
     */
    function _halt($error)
    {
        rc_die($error);
    }
}

if ( ! function_exists('_default'))
{
    /**
     * 获得变量值
     *
     * @param string $var_name
     *            变量名
     * @param mixed $value
     *            值
     * @return mixed
     */
    function _default($var_name, $value = "")
    {
        return isset($var_name) ? $var_name : $value;
    }
}

if ( ! function_exists('_http_status'))
{
    /**
     * HTTP状态信息设置
     *
     * @param Number $code
     *            状态码
     */
    function _http_status($code)
    {
        $status = array(
            200 => 'OK', // Success 2xx
            // Redirection 3xx
            301 => 'Moved Permanently',
            302 => 'Moved Temporarily ',
            // Client Error 4xx
            400 => 'Bad Request',
            403 => 'Forbidden',
            404 => 'Not Found',
            // Server Error 5xx
            500 => 'Internal Server Error',
            503 => 'Service Unavailable'
        );
        if (isset($status[$code])) {
            header('HTTP/1.1 ' . $code . ' ' . $status[$code]);
            header('Status:' . $code . ' ' . $status[$code]); // FastCGI模式
        }
    }
}

if ( ! function_exists('_request'))
{
    /**
     * 请求方式
     *
     * @param string $method
     *            类型
     * @param string $varName
     *            变量名
     * @param bool $html
     *            实体化
     * @return mixed
     */
    function _request($method, $varName = null, $html = true)
    {
        $method = strtolower($method);
        switch ($method) {
            case 'ispost':
            case 'isget':
            case 'ishead':
            case 'isdelete':
            case 'isput':
                return strtolower($_SERVER['REQUEST_METHOD']) == strtolower(substr($method, 2));
            case 'get':
                $data = & $_GET;
                break;
            case 'post':
                $data = & $_POST;
                break;
            case 'request':
                $data = & $_REQUEST;
                break;
            case 'Session':
                $data = & $_SESSION;
                break;
            case 'cookie':
                $data = & $_COOKIE;
                break;
            case 'server':
                $data = & $_SERVER;
                break;
            case 'globals':
                $data = & $GLOBALS;
                break;
            default:
                rc_throw_exception('abc');
        }
        // 获得所有数据
        if (is_null($varName))
            return $data;
        if (isset($data[$varName]) && $html) {
            $data[$varName] = htmlspecialchars($data[$varName]);
        }
        return isset($data[$varName]) ? $data[$varName] : null;
    }
}

if ( ! function_exists('is_ie'))
{
    /**
     * IE浏览器判断
     */
    function is_ie()
    {
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if ((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false))
            return false;
        if (strpos($useragent, 'msie ') !== false)
            return true;
        return false;
    }
}

if ( ! function_exists('is_email'))
{
    /**
     * 验证输入的邮件地址是否合法
     *
     * @access public
     * @param string $email
     *            需要验证的邮件地址
     * @return bool
     */
    function is_email($email)
    {
        $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
        if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
            if (preg_match($chars, $email))
                return true;
        }
        return false;
    }
}

if ( ! function_exists('is_time'))
{
    /**
     * 检查是否为一个合法的时间格式
     *
     * @access public
     * @param string $time
     * @return void
     */
    function is_time($time)
    {
        $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';
        return preg_match($pattern, $time);
    }
}

if ( ! function_exists('is_utf8'))
{
    /**
     * 判断字符串是否为utf8编码，英文和半角字符返回ture
     *
     * @param
     *            $string
     * @return bool
     */
    function is_utf8($string)
    {
        return preg_match('%^(?:
					[\x09\x0A\x0D\x20-\x7E] # ASCII
					| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
					| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
					| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
					| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
					| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
					| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
					| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
					)*$%xs', $string);
    }
}

if ( ! function_exists('is_ssl'))
{
    /**
     * 是否为SSL协议
     *
     * @return boolean
     */
    function is_ssl()
    {
        if (isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
            return true;
        } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists('is_pjax'))
{
    /**
     * 是否为PJAX请求
     *
     * @return boolean
     */
    function is_pjax()
    {
        return array_key_exists('HTTP_X_PJAX', $_SERVER) && ($_SERVER['HTTP_X_PJAX'] === 'true');
    }
}

if ( ! function_exists('is_ajax'))
{
    /**
     * 是否为AJAX提交
     *
     * @return boolean
     */
    function is_ajax()
    {
        if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists('is_rtl'))
{
    /**
     * Checks if current locale is RTL.
     *
     * @since 3.0.0
     * @return bool Whether locale is RTL.
     */
    function is_rtl() {
        // 'ltr'
        return false;
    }
}

if ( ! function_exists('is_rc_error'))
{
    /**
     * Check whether variable is a \Royalcms\Component\Error\Error.
     *
     * Returns true if $thing is an object of the ecjia_error class.
     *
     * @since 1.0.0
     *
     * @param mixed $thing Check if unknown variable is a RC_Error object.
     * @return bool True, if RC_Error. False, if not RC_Error.
     */
    function is_rc_error($thing) {
        return RC_Error::is_error($thing);
    }
}

if ( ! function_exists('rc_server_protocol'))
{
    /**
     * Return the HTTP protocol sent by the server.
     *
     * @since 4.4.0
     *
     * @return string The HTTP protocol. Default: HTTP/1.0.
     */
    function rc_server_protocol() {
        $protocol = $_SERVER['SERVER_PROTOCOL'];
        if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {
            $protocol = 'HTTP/1.0';
        }
        return $protocol;
    }
}

if ( ! function_exists('rc_allowed_protocols'))
{
    /**
     * Retrieve a list of protocols to allow in HTML attributes.
     *
     * @since 3.3.0
     * @see wp_kses()
     * @see esc_url()
     *
     * @return array Array of allowed protocols
     */
    function rc_allowed_protocols()
    {
        static $protocols;
    
        if (empty($protocols)) {
            $protocols = array(
                'http',
                'https',
                'ftp',
                'ftps',
                'mailto',
                'news',
                'irc',
                'gopher',
                'nntp',
                'feed',
                'telnet',
                'mms',
                'rtsp',
                'svn',
                'tel',
                'fax',
                'xmpp'
            );
    
            /**
             * Filter the list of protocols allowed in HTML attributes.
             *
             * @since 3.0.0
             *
             * @param array $protocols
             *            Array of allowed protocols e.g. 'http', 'ftp', 'tel', and more.
            */
            $protocols = RC_Hook::apply_filters('kses_allowed_protocols', $protocols);
        }
    
        return $protocols;
    }
}

if ( ! function_exists('rc_parse_str'))
{
    /**
     * Parses a string into variables to be stored in an array.
     *
     * Uses {@link http://www.php.net/parse_str parse_str()} and stripslashes if
     * {@link http://www.php.net/magic_quotes magic_quotes_gpc} is on.
     *
     * @since 2.2.1
     *
     * @param string $string
     *            The string to be parsed.
     * @param array $array
     *            Variables will be stored in this array.
     */
    function rc_parse_str($string, &$array)
    {
        parse_str($string, $array);
        if (get_magic_quotes_gpc()) {
            $array = rc_stripslashes($array);
        }
        /**
         * Filter the array of variables derived from a parsed string.
         *
         * @since 2.3.0
         *
         * @param array $array
         *            The array populated with variables.
         */
        $array = RC_Hook::apply_filters('rc_parse_str', $array);
    }
}

if ( ! function_exists('rc_parse_args'))
{
    /**
     * Merge user defined arguments into defaults array.
     *
     * This function is used throughout WordPress to allow for both string or array
     * to be merged into another array.
     *
     * @since 2.2.0
     *
     * @param string|array $args
     *            Value to merge with $defaults
     * @param array $defaults
     *            Array that serves as the defaults.
     * @return array Merged user defined values with defaults.
     */
    function rc_parse_args($args, $defaults = '')
    {
        if (is_object($args))
            $r = get_object_vars($args);
        elseif (is_array($args))
        $r = & $args;
        else
            rc_parse_str($args, $r);
    
        if (is_array($defaults))
            return array_merge($defaults, $r);
        return $r;
    }
}

if ( ! function_exists('rc_create_uuid'))
{
    /**
     * 获得唯一uuid值
     *
     * @param string $sep
     *            分隔符
     * @return string
     */
    function rc_create_uuid($sep = '')
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); // optional for php 4.2.0 and up.
            $id = strtoupper(md5(uniqid(rand(), true)));
            $sep = ''; // "-"
            $uuid = substr($id, 0, 8) . $sep . substr($id, 8, 4) . $sep . substr($id, 12, 4) . $sep . substr($id, 16, 4) . $sep . substr($id, 20, 12);
            return $uuid;
        }
    }
}

if ( ! function_exists('rc_print_const'))
{
    /**
     * 用户定义常量
     *
     * @param bool $view
     *            是否显示
     * @return array
     */
    function rc_print_const($view = true)
    {
        $define = get_defined_constants(true);
        $const = $define['user'];
        if ($view) {
            print_r($const);
        } else {
            return $const;
        }
    }
}

if ( ! function_exists('rc_user_crlf'))
{
    /**
     * 获得用户操作系统的换行符
     *
     * @access public
     * @return string
     */
    function rc_user_crlf()
    {
        /* LF (Line Feed, 0x0A, \N) 和 CR(Carriage Return, 0x0D, \R) */
        if (stristr($_SERVER['HTTP_USER_AGENT'], 'Win')) {
            $the_crlf = "\r\n";
        } elseif (stristr($_SERVER['HTTP_USER_AGENT'], 'Mac')) {
            $the_crlf = "\r"; // for old MAC OS
        } else {
            $the_crlf = "\n";
        }
    
        return $the_crlf;
    }
}

if ( ! function_exists('rc_extension_exists'))
{
    /**
     * 验证扩展是否加载
     *
     * @param string $ext
     * @return bool
     */
    function rc_extension_exists($ext)
    {
        $ext = strtolower($ext);
        $loaded_extensions = get_loaded_extensions();
        return in_array($ext, RC_Array::transform_value_case($loaded_extensions));
    }
}

if ( ! function_exists('rc_throw_exception'))
{
    /**
     * 抛出异常
     *
     * @param string $msg
     *            错误信息
     * @param int $code
     *            编码
     * @throws
     *
     *
     */
    function rc_throw_exception($msg, $code = 0)
    {
        /**
         * 加载异常类
         * 默认异常类 Component_Error_Exception
         */
        $class = RC_Hook::apply_filters('load_exception_class', 'Exception');
    
        if (class_exists($class, false)) {
            throw new $class($msg, $code, true);
        } else {
            rc_die($msg);
        }
    }
}

if ( ! function_exists('rc_call_class_func'))
{
    /**
     * 类方法调用
     *
     * @param string $class
     * @param string $func
     * @param array $args
     */
    function rc_call_class_func($class, $func, $args = array())
    {
        if (empty($class) || empty($func)) {
            return;
        }
    
        if (is_string($args)) {
            $args = array(
                $args
            );
        }
        return call_user_func_array(array(
            $class,
            $func
        ), $args);
    }
}

if ( ! function_exists('rc_random'))
{
    /**
     * 产生随机字符串
     *
     * @param int $length
     *            输出长度
     * @param string $chars
     *            可选的 ，默认为 0123456789
     * @return string 字符串
     */
    function rc_random($length, $chars = '0123456789')
    {
        $hash = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }
}

if ( ! function_exists('rc_fix_server_vars'))
{
    /**
     * Fix `$_SERVER` variables for various setups.
     *
     * @since 3.0.0
     * @access private
     *
     * @global string $PHP_SELF The filename of the currently executing script,
     *                          relative to the document root.
     */
    function rc_fix_server_vars() {
        global $PHP_SELF;
    
        $default_server_values = array(
            'SERVER_SOFTWARE' => '',
            'REQUEST_URI' => '',
        );
    
        $_SERVER = array_merge( $default_server_values, $_SERVER );
    
        // Fix for IIS when running with PHP ISAPI
        if ( empty( $_SERVER['REQUEST_URI'] ) || ( php_sapi_name() != 'cgi-fcgi' && preg_match( '/^Microsoft-IIS\//', $_SERVER['SERVER_SOFTWARE'] ) ) ) {
    
            // IIS Mod-Rewrite
            if ( isset( $_SERVER['HTTP_X_ORIGINAL_URL'] ) ) {
                $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
            }
            // IIS Isapi_Rewrite
            else if ( isset( $_SERVER['HTTP_X_REWRITE_URL'] ) ) {
                $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
            } else {
                // Use ORIG_PATH_INFO if there is no PATH_INFO
                if ( !isset( $_SERVER['PATH_INFO'] ) && isset( $_SERVER['ORIG_PATH_INFO'] ) )
                    $_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
    
                // Some IIS + PHP configurations puts the script-name in the path-info (No need to append it twice)
                if ( isset( $_SERVER['PATH_INFO'] ) ) {
                    if ( $_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME'] )
                        $_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
                    else
                        $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
                }
    
                // Append the query string if it exists and isn't null
                if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
                    $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
                }
            }
        }
    
        // Fix for PHP as CGI hosts that set SCRIPT_FILENAME to something ending in php.cgi for all requests
        if ( isset( $_SERVER['SCRIPT_FILENAME'] ) && ( strpos( $_SERVER['SCRIPT_FILENAME'], 'php.cgi' ) == strlen( $_SERVER['SCRIPT_FILENAME'] ) - 7 ) )
            $_SERVER['SCRIPT_FILENAME'] = $_SERVER['PATH_TRANSLATED'];
    
        // Fix for Dreamhost and other PHP as CGI hosts
        if ( strpos( $_SERVER['SCRIPT_NAME'], 'php.cgi' ) !== false )
            unset( $_SERVER['PATH_INFO'] );
    
        // Fix empty PHP_SELF
        $PHP_SELF = $_SERVER['PHP_SELF'];
        if ( empty( $PHP_SELF ) )
            $_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( '/(\?.*)?$/', '', $_SERVER["REQUEST_URI"] );
    }
}

if ( ! function_exists('rc_tempnam'))
{
    /**
     * Returns a filename of a Temporary unique file.
     * Please note that the calling function must unlink() this itself.
     *
     * The filename is based off the passed parameter or defaults to the current unix timestamp,
     * while the directory can either be passed as well, or by leaving it blank, default to a writable temporary directory.
     *
     * @since 2.6.0
     *
     * @param string $filename (optional) Filename to base the Unique file off
     * @param string $dir (optional) Directory to store the file in
     * @return string a writable filename
     */
    function rc_tempnam($filename = '', $dir = '') {
        if ( empty($dir) )
            $dir = rc_get_temp_dir();
        $filename = basename($filename);
        if ( empty($filename) )
            $filename = time();
    
        $filename = preg_replace('|\..*$|', '.tmp', $filename);
        $filename = $dir . rc_unique_filename($dir, $filename);
        touch($filename);
        return $filename;
    }
}

if ( ! function_exists('rc_unique_filename'))
{
    /**
     * Get a filename that is sanitized and unique for the given directory.
     *
     * If the filename is not unique, then a number will be added to the filename
     * before the extension, and will continue adding numbers until the filename is
     * unique.
     *
     * The callback is passed three parameters, the first one is the directory, the
     * second is the filename, and the third is the extension.
     *
     * @since 2.5.0
     *
     * @param string   $dir                      Directory.
     * @param string   $filename                 File name.
     * @param callback $unique_filename_callback Callback. Default null.
     * @return string New filename, if given wasn't unique.
     */
    function rc_unique_filename( $dir, $filename, $unique_filename_callback = null ) {
        // Sanitize the file name before we begin processing.
        $filename = RC_Format::sanitize_file_name($filename);
    
        // Separate the filename into a name and extension.
        $info = pathinfo($filename);
        $ext = !empty($info['extension']) ? '.' . $info['extension'] : '';
        $name = basename($filename, $ext);
    
        // Edge case: if file is named '.ext', treat as an empty name.
        if ( $name === $ext )
            $name = '';
    
        /*
         * Increment the file number until we have a unique file to save in $dir.
        * Use callback if supplied.
        */
        if ( $unique_filename_callback && is_callable( $unique_filename_callback ) ) {
            $filename = call_user_func( $unique_filename_callback, $dir, $name, $ext );
        } else {
            $number = '';
    
            // Change '.ext' to lower case.
            if ( $ext && strtolower($ext) != $ext ) {
                $ext2 = strtolower($ext);
                $filename2 = preg_replace( '|' . preg_quote($ext) . '$|', $ext2, $filename );
    
                // Check for both lower and upper case extension or image sub-sizes may be overwritten.
                while ( file_exists($dir . "/$filename") || file_exists($dir . "/$filename2") ) {
                    $new_number = $number + 1;
                    $filename = str_replace( "$number$ext", "$new_number$ext", $filename );
                    $filename2 = str_replace( "$number$ext2", "$new_number$ext2", $filename2 );
                    $number = $new_number;
                }
                return $filename2;
            }
    
            while ( file_exists( $dir . "/$filename" ) ) {
                if ( '' == "$number$ext" )
                    $filename = $filename . ++$number . $ext;
                else
                    $filename = str_replace( "$number$ext", ++$number . $ext, $filename );
            }
        }
    
        return $filename;
    }
}

if ( ! function_exists('rc_get_temp_dir'))
{
    /**
     * Determine a writable directory for temporary files.
     *
     * Function's preference is the return value of sys_get_temp_dir(),
     * followed by your PHP temporary upload directory, followed by RC_CONTENT_DIR,
     * before finally defaulting to /tmp/
     *
     * In the event that this function does not find a writable location,
     * It may be overridden by the RC_TEMP_DIR constant in your wp-config.php file.
     *
     * @since 2.5.0
     *
     * @return string Writable temporary directory.
     */
    function rc_get_temp_dir() {
        static $temp;
        if ( defined('RC_TEMP_DIR') )
            return RC_Format::trailingslashit(RC_TEMP_DIR);
    
        if ( $temp )
            return RC_Format::trailingslashit( $temp );
    
        if ( function_exists('sys_get_temp_dir') ) {
            $temp = sys_get_temp_dir();
            if ( @is_dir( $temp ) && rc_is_writable( $temp ) )
                return RC_Format::trailingslashit( $temp );
        }
    
        $temp = ini_get('upload_tmp_dir');
        if ( @is_dir( $temp ) && rc_is_writable( $temp ) )
            return RC_Format::trailingslashit( $temp );
    
        $temp = RC_CONTENT_DIR . '/';
        if ( is_dir( $temp ) && rc_is_writable( $temp ) )
            return $temp;
    
        $temp = '/tmp/';
        return $temp;
    }
}

if ( ! function_exists('rc_is_writable'))
{
    /**
     * Determine if a directory is writable.
     *
     * This function is used to work around certain ACL issues in PHP primarily
     * affecting Windows Servers.
     *
     * @since 3.6.0
     *
     * @see rc_win_is_writable()
     *
     * @param string $path Path to check for write-ability.
     * @return bool Whether the path is writable.
     */
    function rc_is_writable( $path ) {
        if ( 'WIN' === strtoupper( substr( PHP_OS, 0, 3 ) ) )
            return rc_win_is_writable( $path );
        else
            return @is_writable( $path );
    }
}

if ( ! function_exists('rc_win_is_writable'))
{
    /**
     * Workaround for Windows bug in is_writable() function
     *
     * PHP has issues with Windows ACL's for determine if a
     * directory is writable or not, this works around them by
     * checking the ability to open files rather than relying
     * upon PHP to interprate the OS ACL.
     *
     * @since 3.2.0
     *
     * @see http://bugs.php.net/bug.php?id=27609
     * @see http://bugs.php.net/bug.php?id=30931
     *
     * @param string $path Windows path to check for write-ability.
     * @return bool Whether the path is writable.
     */
    function rc_win_is_writable( $path ) {
    
        if ( $path[strlen( $path ) - 1] == '/' ) // if it looks like a directory, check a random file within the directory
            return rc_win_is_writable( $path . uniqid( mt_rand() ) . '.tmp');
        else if ( is_dir( $path ) ) // If it's a directory (and not a file) check a random file within the directory
            return rc_win_is_writable( $path . '/' . uniqid( mt_rand() ) . '.tmp' );
    
        // check tmp file for read/write capabilities
        $should_delete_tmp_file = !file_exists( $path );
        $f = @fopen( $path, 'a' );
        if ( $f === false )
            return false;
        fclose( $f );
        if ( $should_delete_tmp_file )
            unlink( $path );
        return true;
    }
}

if ( ! function_exists('rc_validate_boolean'))
{
    /**
     * Alternative to filter_var( $var, FILTER_VALIDATE_BOOLEAN ).
     *
     * @since 4.0.0
     *
     * @param mixed $var Boolean value to validate.
     * @return bool Whether the value is validated.
     */
    function rc_validate_boolean( $var ) {
        if ( is_bool( $var ) ) {
            return $var;
        }
    
        if ( 'false' === $var ) {
            return false;
        }
    
        return (bool) $var;
    }
}

if ( ! function_exists('rc_list_pluck'))
{
    /**
     * Pluck a certain field out of each object in a list.
     *
     * This has the same functionality and prototype of
     * array_column() (PHP 5.5) but also supports objects.
     *
     * @since 3.1.0
     * @since 4.0.0 $index_key parameter added.
     *
     * @param array      $list      List of objects or arrays
     * @param int|string $field     Field from the object to place instead of the entire object
     * @param int|string $index_key Optional. Field from the object to use as keys for the new array.
     *                              Default null.
     * @return array Array of found values. If $index_key is set, an array of found values with keys
     *               corresponding to $index_key.
     */
    function rc_list_pluck( $list, $field, $index_key = null ) {
        return array_column($list, $field, $index_key);
    }
}

if ( ! function_exists('rc_suspend_cache_addition'))
{
    /**
     * Temporarily suspend cache additions.
     *
     * Stops more data being added to the cache, but still allows cache retrieval.
     * This is useful for actions, such as imports, when a lot of data would otherwise
     * be almost uselessly added to the cache.
     *
     * Suspension lasts for a single page load at most. Remember to call this
     * function again if you wish to re-enable cache adds earlier.
     *
     * @since 3.3.0
     *
     * @param bool $suspend Optional. Suspends additions if true, re-enables them if false.
     * @return bool The current suspend setting
     */
    function rc_suspend_cache_addition( $suspend = null ) {
        static $_suspend = false;
    
        if ( is_bool( $suspend ) )
            $_suspend = $suspend;
    
        return $_suspend;
    }
}

if ( ! function_exists('rc_suspend_cache_invalidation'))
{
    /**
     * Suspend cache invalidation.
     *
     * Turns cache invalidation on and off. Useful during imports where you don't wont to do
         * invalidations every time a post is inserted. Callers must be sure that what they are
         * doing won't lead to an inconsistent cache when invalidation is suspended.
         *
         * @since 2.7.0
         *
         * @param bool $suspend Optional. Whether to suspend or enable cache invalidation. Default true.
         * @return bool The current suspend setting.
         */
     function rc_suspend_cache_invalidation( $suspend = true ) {
         global $_rc_suspend_cache_invalidation;
    
         $current_suspend = $_rc_suspend_cache_invalidation;
         $_rc_suspend_cache_invalidation = $suspend;
         return $current_suspend;
     }
}

if ( ! function_exists('rc_is_stream')) {
    /**
     * Test if a given path is a stream URL
     *
     * @since 3.5.0
     *
     * @param string $path The resource path or URL.
     * @return bool True if the path is a stream URL.
     */
    function rc_is_stream($path)
    {
        if (false === strpos($path, '://')) {
            // $path isn't a stream
            return false;
        }

        $wrappers = stream_get_wrappers();
        $wrappers = array_map('preg_quote', $wrappers);
        $wrappers_re = '(' . join('|', $wrappers) . ')';

        return preg_match("!^$wrappers_re://!", $path) === 1;
    }
}

if ( ! function_exists('__return_true'))
{
     /**
      * Returns true.
      *
      * Useful for returning true to filters easily.
      *
      * @since 3.0.0
      * @see __return_false()
      * @return bool true
      */
     function __return_true()
     {
         return true;
     }
}

if ( ! function_exists('__return_false'))
{
    /**
     * Returns false.
     *
     * Useful for returning false to filters easily.
     *
     * @since 3.0.0
     * @see __return_true()
     * @return bool false
     */
    function __return_false()
    {
        return false;
    }
}

if ( ! function_exists('__return_zero'))
{
    /**
     * Returns 0.
     *
     * Useful for returning 0 to filters easily.
     *
     * @since 3.0.0
     * @return int 0
     */
    function __return_zero()
    {
        return 0;
    }
}

if ( ! function_exists('__return_empty_array'))
{
    /**
     * Returns an empty array.
     *
     * Useful for returning an empty array to filters easily.
     *
     * @since 3.0.0
     * @return array Empty array
     */
    function __return_empty_array()
    {
        return array();
    }
}

if ( ! function_exists('__return_null'))
{
    /**
     * Returns null.
     *
     * Useful for returning null to filters easily.
     *
     * @since 3.4.0
     * @return null
     */
    function __return_null()
    {
        return null;
    } 
}

if ( ! function_exists('__return_empty_string'))
{
    /**
     * Returns an empty string.
     *
     * Useful for returning an empty string to filters easily.
     *
     * @since 3.7.0
     * @see __return_null()
     * @return string Empty string
     */
    function __return_empty_string()
    {
        return '';
    }
}

if ( ! function_exists('_doing_it_wrong'))
{
    /**
     * Marks something as being incorrectly called.
     *
     * There is a hook doing_it_wrong_run that will be called that can be used
     * to get the backtrace up to what file and function called the deprecated
     * function.
     *
     * The current behavior is to trigger a user error if WP_DEBUG is true.
     *
     * @since 3.1.0
     * @access private
     *
     * @param string $function The function that was called.
     * @param string $message A message explaining what has been done incorrectly.
     * @param string $version The version of WordPress where the message was added.
     */
    function _doing_it_wrong( $function, $message, $version ) {
    
        /**
         * Fires when the given function is being used incorrectly.
         *
         * @since 3.1.0
         *
         * @param string $function The function that was called.
         * @param string $message  A message explaining what has been done incorrectly.
         * @param string $version  The version of WordPress where the message was added.
         */
        RC_Hook::do_action( 'doing_it_wrong_run', $function, $message, $version );
    
        /**
         * Filter whether to trigger an error for _doing_it_wrong() calls.
         *
         * @since 3.1.0
         *
         * @param bool $trigger Whether to trigger the error for _doing_it_wrong() calls. Default true.
        */
        if ( RC_DEBUG && RC_Hook::apply_filters( 'doing_it_wrong_trigger_error', true ) ) {
            if ( function_exists( '__' ) ) {
                $version = is_null( $version ) ? '' : sprintf( __( '(This message was added in version %s.)' ), $version );
                $message .= ' ' . __( 'Please see for more information.' );
                trigger_error( sprintf( __( '%1$s was called <strong>incorrectly</strong>. %2$s %3$s' ), $function, $message, $version ) );
            } else {
                $version = is_null( $version ) ? '' : sprintf( '(This message was added in version %s.)', $version );
                $message .= ' Please see for more information.';
                trigger_error( sprintf( '%1$s was called <strong>incorrectly</strong>. %2$s %3$s', $function, $message, $version ) );
            }
        }
    }
}

if ( ! function_exists('_deprecated_function'))
{
    /**
     * Mark a function as deprecated and inform when it has been used.
     *
     * There is a hook deprecated_function_run that will be called that can be used
     * to get the backtrace up to what file and function called the deprecated
     * function.
     *
     * The current behavior is to trigger a user error if RC_DEBUG is true.
     *
     * This function is to be used in every function that is deprecated.
     *
     * @since 2.5.0
     * @access private
     *
     * @param string $function    The function that was called.
     * @param string $version     The version of WordPress that deprecated the function.
     * @param string $replacement Optional. The function that should have been called. Default null.
     */
    function _deprecated_function( $function, $version, $replacement = null ) {
    
        /**
         * Fires when a deprecated function is called.
         *
         * @since 2.5.0
         *
         * @param string $function    The function that was called.
         * @param string $replacement The function that should have been called.
         * @param string $version     The version of WordPress that deprecated the function.
         */
        RC_Hook::do_action( 'deprecated_function_run', $function, $replacement, $version );
    
        /**
         * Filter whether to trigger an error for deprecated functions.
         *
         * @since 2.5.0
         *
         * @param bool $trigger Whether to trigger the error for deprecated functions. Default true.
        */
        if ( config('system.debug') && RC_Hook::apply_filters( 'deprecated_function_trigger_error', true ) ) {
            if ( function_exists( '__' ) ) {
                if ( ! is_null( $replacement ) ) {
                    trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.'), $function, $version, $replacement ) );
                } else {
                    trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.'), $function, $version ) );
                }
            } else {
                if ( ! is_null( $replacement ) ) {
                    trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.', $function, $version, $replacement ) );
                } else {
                    trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.', $function, $version ) );
                }
            }
        }
    }
}

if ( ! function_exists('_deprecated_file'))
{
    /**
     * Mark a file as deprecated and inform when it has been used.
     *
     * There is a hook deprecated_file_included that will be called that can be used
     * to get the backtrace up to what file and function included the deprecated
     * file.
     *
     * The current behavior is to trigger a user error if WP_DEBUG is true.
     *
     * This function is to be used in every file that is deprecated.
     *
     * @since 2.5.0
     * @access private
     *
     * @param string $file        The file that was included.
     * @param string $version     The version of WordPress that deprecated the file.
     * @param string $replacement Optional. The file that should have been included based on ABSPATH.
     *                            Default null.
     * @param string $message     Optional. A message regarding the change. Default empty.
     */
    function _deprecated_file( $file, $version, $replacement = null, $message = '' ) {
    
        /**
         * Fires when a deprecated file is called.
         *
         * @since 2.5.0
         *
         * @param string $file        The file that was called.
         * @param string $replacement The file that should have been included based on ABSPATH.
         * @param string $version     The version of WordPress that deprecated the file.
         * @param string $message     A message regarding the change.
         */
        RC_Hook::do_action( 'deprecated_file_included', $file, $replacement, $version, $message );
    
        /**
         * Filter whether to trigger an error for deprecated files.
         *
         * @since 2.5.0
         *
         * @param bool $trigger Whether to trigger the error for deprecated files. Default true.
        */
        if ( RC_DEBUG && RC_Hook::apply_filters( 'deprecated_file_trigger_error', true ) ) {
            $message = empty( $message ) ? '' : ' ' . $message;
            if ( function_exists( '__' ) ) {
                if ( ! is_null( $replacement ) ) {
                    trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.'), $file, $version, $replacement ) . $message );
                } else {
                    trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.'), $file, $version ) . $message );
                }
            } else {
                if ( ! is_null( $replacement ) ) {
                    trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.', $file, $version, $replacement ) . $message );
                } else {
                    trigger_error( sprintf( '%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.', $file, $version ) . $message );
                }
            }
        }
    }
}

if ( ! function_exists('_deprecated_argument'))
{
    /**
     * Mark a function argument as deprecated and inform when it has been used.
     *
     * This function is to be used whenever a deprecated function argument is used.
     * Before this function is called, the argument must be checked for whether it was
     * used by comparing it to its default value or evaluating whether it is empty.
     * For example:
     * <code>
     * if ( ! empty( $deprecated ) ) {
     * 	_deprecated_argument( __FUNCTION__, '3.0' );
     * }
     * </code>
     *
     * There is a hook deprecated_argument_run that will be called that can be used
     * to get the backtrace up to what file and function used the deprecated
     * argument.
     *
     * The current behavior is to trigger a user error if WP_DEBUG is true.
     *
     * @since 3.0.0
     * @access private
     *
     * @param string $function The function that was called.
     * @param string $version  The version of WordPress that deprecated the argument used.
     * @param string $message  Optional. A message regarding the change. Default null.
     */
    function _deprecated_argument( $function, $version, $message = null ) {
    
        /**
         * Fires when a deprecated argument is called.
         *
         * @since 3.0.0
         *
         * @param string $function The function that was called.
         * @param string $message  A message regarding the change.
         * @param string $version  The version of WordPress that deprecated the argument used.
         */
        RC_Hook::do_action( 'deprecated_argument_run', $function, $message, $version );
    
        /**
         * Filter whether to trigger an error for deprecated arguments.
         *
         * @since 3.0.0
         *
         * @param bool $trigger Whether to trigger the error for deprecated arguments. Default true.
        */
        if ( RC_DEBUG && RC_Hook::apply_filters( 'deprecated_argument_trigger_error', true ) ) {
            if ( function_exists( '__' ) ) {
                if ( ! is_null( $message ) ) {
                    trigger_error( sprintf( __('%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s! %3$s'), $function, $version, $message ) );
                } else {
                    trigger_error( sprintf( __('%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s with no alternative available.'), $function, $version ) );
                }
            } else {
                if ( ! is_null( $message ) ) {
                    trigger_error( sprintf( '%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s! %3$s', $function, $version, $message ) );
                } else {
                    trigger_error( sprintf( '%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s with no alternative available.', $function, $version ) );
                }
            }
        }
    }
}

if (! function_exists('_deprecated_hook'))
{
    /**
     * Marks a deprecated action or filter hook as deprecated and throws a notice.
     *
     * Use the {@see 'deprecated_hook_run'} action to get the backtrace describing where
     * the deprecated hook was called.
     *
     * Default behavior is to trigger a user error if `WP_DEBUG` is true.
     *
     * This function is called by the do_action_deprecated() and apply_filters_deprecated()
     * functions, and so generally does not need to be called directly.
     *
     * @since 4.6.0
     * @access private
     *
     * @param string $hook        The hook that was used.
     * @param string $version     The version of Royalcms that deprecated the hook.
     * @param string $replacement Optional. The hook that should have been used.
     * @param string $message     Optional. A message regarding the change.
     */
    function _deprecated_hook( $hook, $version, $replacement = null, $message = null ) {
        /**
         * Fires when a deprecated hook is called.
         *
         * @since 4.6.0
         *
         * @param string $hook        The hook that was called.
         * @param string $replacement The hook that should be used as a replacement.
         * @param string $version     The version of WordPress that deprecated the argument used.
         * @param string $message     A message regarding the change.
         */
        RC_Hook::do_action( 'deprecated_hook_run', $hook, $replacement, $version, $message );

        /**
         * Filters whether to trigger deprecated hook errors.
         *
         * @since 4.6.0
         *
         * @param bool $trigger Whether to trigger deprecated hook errors. Requires
         *                      `RC_DEBUG` to be defined true.
         */
        if ( RC_DEBUG && RC_Hook::apply_filters( 'deprecated_hook_trigger_error', true ) ) {
            $message = empty( $message ) ? '' : ' ' . $message;
            if ( ! is_null( $replacement ) ) {
                /* translators: 1: ECJia hook name, 2: version number, 3: alternative hook name */
                trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.' ), $hook, $version, $replacement ) . $message );
            } else {
                /* translators: 1: ECJia hook name, 2: version number */
                trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.' ), $hook, $version ) . $message );
            }
        }
    }
}

if ( ! function_exists('rc_absint'))
{
    /**
     * Convert a value to non-negative integer.
     *
     * @since 2.5.0
     *
     * @param mixed $maybeint Data you wish to have converted to a non-negative integer.
     * @return int A non-negative integer.
     */
    function rc_absint( $maybeint ) {
        return abs( intval( $maybeint ) );
    }
}

if ( ! function_exists('rc_showmessage'))
{
    function rc_showmessage($message) {
        $version = Royalcms\Component\Foundation\Royalcms::VERSION;
        return <<<RCMSG
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex,nofollow" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Royalcms - Error reporting...</title>
<style>
    html{color:#000;background:#FFF;}body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin:0;padding:0;}table{border-collapse:collapse;border-spacing:0;}fieldset,img{border:0;}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}li{list-style:none;}caption,th{text-align:left;}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}q:before,q:after{content:'';}abbr,acronym{border:0;font-variant:normal;}sup{vertical-align:text-top;}sub{vertical-align:text-bottom;}input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit;}input,textarea,select{*font-size:100%;}legend{color:#000;}
    html { background: #eee; padding: 10px }
    img { border: 0; }
    #sf-resetcontent { width:100%; max-width:970px; margin:0 auto; }
    .sf-reset { font: 11px Verdana, Arial, sans-serif; color: #333 }
    .sf-reset .clear { clear:both; height:0; font-size:0; line-height:0; }
    .sf-reset .clear_fix:after { display:block; height:0; clear:both; visibility:hidden; }
    .sf-reset .clear_fix { display:inline-block; }
    .sf-reset * html .clear_fix { height:1%; }
    .sf-reset .clear_fix { display:block; }
    .sf-reset, .sf-reset .block { margin: auto }
    .sf-reset abbr { border-bottom: 1px dotted #000; cursor: help; }
    .sf-reset p { font-size:14px; line-height:20px; color:#868686; padding-bottom:0; }
    .sf-reset strong { font-weight:bold; }
    .sf-reset a { color:#6c6159; }
    .sf-reset a img { border:none; }
    .sf-reset a:hover { text-decoration:underline; }
    .sf-reset em { font-style:italic; }
    .sf-reset h1, .sf-reset h2 { font: 20px Georgia, "Times New Roman", Times, serif }
    .sf-reset h2 span { background-color: #fff; color: #333; padding: 6px; float: left; margin-right: 10px; }
    .sf-reset .traces li { font-size:12px; padding: 2px 4px; list-style-type:decimal; margin-left:20px; }
    .sf-reset .block { background-color:#FFFFFF; padding:10px 28px; margin-bottom:20px; -webkit-border-bottom-right-radius: 16px; -webkit-border-bottom-left-radius: 16px; -moz-border-radius-bottomright: 16px; -moz-border-radius-bottomleft: 16px; border-bottom-right-radius: 16px; border-bottom-left-radius: 16px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; border-left:1px solid #ccc;}
    .sf-reset .block_exception { background-color:#ddd; color: #333; padding:20px; -webkit-border-top-left-radius: 16px; -webkit-border-top-right-radius: 16px; -moz-border-radius-topleft: 16px; -moz-border-radius-topright: 16px; border-top-left-radius: 16px; border-top-right-radius: 16px; border-top:1px solid #ccc; border-right:1px solid #ccc; border-left:1px solid #ccc; overflow: hidden; word-wrap: break-word;}
    .sf-reset li a { background:none; color:#868686; text-decoration:none; }
    .sf-reset li a:hover { background:none; color:#313131; text-decoration:underline; }
    .sf-reset ol { padding: 10px 0; }
    .sf-reset h1 { background-color:#FFFFFF; padding: 15px 28px; margin-bottom: 20px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; border: 1px solid #ccc;}
</style>
</head>
<body>
<div id="sf-resetcontent" class="sf-reset">
	<h1>{$message}</h1>
	Current royalcms version: {$version}
</div>
</body>
</html>        
RCMSG;
    }
}

if ( ! function_exists('rc_die'))
{
    /**
     * Kill Royalcms execution and display HTML message with error message.
     *
     * This function complements the die() PHP function. The difference is that
     * HTML will be displayed to the user. It is recommended to use this function
     * only, when the execution should not continue any further. It is not
     * recommended to call this function very often and try to handle as many errors
     * as possible silently.
     *
     * @since 2.0.4
     *
     * @param string $message Error message.
     * @param string $title Error title.
     * @param string|array $args Optional arguments to control behavior.
     */
    function rc_die( $message = '', $title = '', $args = array() ) {
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            /**
             * Filter callback for killing WordPress execution for AJAX requests.
             *
             * @since 3.4.0
             *
             * @param callback $function Callback function name.
             */
            $function = RC_Hook::apply_filters( 'rc_die_ajax_handler', '_ajax_rc_die_handler' );
        } elseif ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
            /**
             * Filter callback for killing WordPress execution for XML-RPC requests.
             *
             * @since 3.4.0
             *
             * @param callback $function Callback function name.
             */
            $function = RC_Hook::apply_filters( 'rc_die_xmlrpc_handler', '_xmlrpc_rc_die_handler' );
        } else {
            /**
             * Filter callback for killing WordPress execution for all non-AJAX, non-XML-RPC requests.
             *
             * @since 3.0.0
             *
             * @param callback $function Callback function name.
             */
            $function = RC_Hook::apply_filters( 'rc_die_handler', '_default_rc_die_handler' );
        }
    
        call_user_func( $function, $message, $title, $args );
    }
}

if ( ! function_exists('_default_rc_die_handler'))
{
    /**
     * Kill WordPress execution and display HTML message with error message.
     *
     * This is the default handler for wp_die if you want a custom one for your
     * site then you can overload using the wp_die_handler filter in wp_die
     *
     * @since 3.0.0
     * @access private
     *
     * @param string $message Error message.
     * @param string $title Error title.
     * @param string|array $args Optional arguments to control behavior.
     */
    function _default_rc_die_handler( $message, $title = '', $args = array() ) {
        $defaults = array( 'response' => 500 );
        $r = rc_parse_args($args, $defaults);
    
        $have_gettext = function_exists('__');
    
        if ( is_string( $message ) ) {
            $message = "<p>$message</p>";
        }
    
        if ( isset( $r['back_link'] ) && $r['back_link'] ) {
            $back_text = $have_gettext? __('&laquo; Back') : '&laquo; Back';
            $message .= "\n<p><a href='javascript:history.back()'>$back_text</a></p>";
        }
    
        echo rc_showmessage($message);
    
        die();
    }
}

if ( ! function_exists('_xmlrpc_rc_die_handler'))
{
    /**
     * Kill WordPress execution and display XML message with error message.
     *
     * This is the handler for wp_die when processing XMLRPC requests.
     *
     * @since 3.2.0
     * @access private
     *
     * @param string $message Error message.
     * @param string $title Error title.
     * @param string|array $args Optional arguments to control behavior.
     */
    function _xmlrpc_rc_die_handler( $message, $title = '', $args = array() ) {
        global $wp_xmlrpc_server;
        $defaults = array( 'response' => 500 );
    
        $r = rc_parse_args($args, $defaults);
    
        if ( $wp_xmlrpc_server ) {
            $error = new Component_IXR_Error( $r['response'] , $message);
            $wp_xmlrpc_server->output( $error->getXml() );
        }
        die();
    }
}

if ( ! function_exists('_ajax_rc_die_handler'))
{
    /**
     * Kill WordPress ajax execution.
     *
     * This is the handler for wp_die when processing Ajax requests.
     *
     * @since 3.4.0
     * @access private
     *
     * @param string $message Optional. Response to print.
     */
    function _ajax_rc_die_handler( $message = '' ) {
        if ( is_scalar( $message ) )
            die( (string) $message );
        die( '0' );
    }
}

if ( ! function_exists('_scalar_rc_die_handler'))
{
    /**
     * Kill WordPress execution.
     *
     * This is the handler for wp_die when processing APP requests.
     *
     * @since 3.4.0
     * @access private
     *
     * @param string $message Optional. Response to print.
     */
    function _scalar_rc_die_handler( $message = '' ) {
        if ( is_scalar( $message ) )
            die( (string) $message );
        die();
    }
}

if ( ! function_exists('esc_html_x'))
{
    /**
     * Translate string with gettext context, and escapes it for safe use in HTML output.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text.
     */
    function esc_html_x($text, $context, $domain = 'default')
    {
        return RC_Format::esc_html(RC_Locale::translate_with_gettext_context($text, $context, $domain));
    }
}

if ( ! function_exists('esc_attr_x'))
{
    /**
     * Translate string with gettext context, and escapes it for safe use in an attribute.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text
     */
    function esc_attr_x($text, $context, $domain = 'default')
    {
        return RC_Format::esc_attr(RC_Locale::translate_with_gettext_context($text, $context, $domain));
    }
}

if ( ! function_exists('esc_html_e'))
{
    /**
     * Display translated text that has been escaped for safe use in HTML output.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     */
    function esc_html_e($text, $domain = 'default')
    {
        echo RC_Format::esc_html(RC_Locale::translate($text, $domain));
    }
}

if ( ! function_exists('esc_attr_e'))
{
    /**
     * Display translated text that has been escaped for safe use in an attribute.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     */
    function esc_attr_e($text, $domain = 'default')
    {
        echo RC_Format::esc_attr(RC_Locale::translate($text, $domain));
    }
}

if ( ! function_exists('esc_html__'))
{
    /**
     * Retrieve the translation of $text and escapes it for safe use in HTML output.
     *
     * If there is no translation, or the text domain isn't loaded, the original text is returned.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text
     */
    function esc_html__($text, $domain = 'default')
    {
        return RC_Format::esc_html(RC_Locale::translate($text, $domain));
    }
}

if ( ! function_exists('esc_attr__'))
{
    /**
     * Retrieve the translation of $text and escapes it for safe use in an attribute.
     *
     * If there is no translation, or the text domain isn't loaded, the original text is returned.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text on success, original text on failure.
     */
    function esc_attr__($text, $domain = 'default')
    {
        return RC_Format::esc_attr(RC_Locale::translate($text, $domain));
    }
}

if ( ! function_exists('_ex'))
{
    /**
     * Display translated string with gettext context.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated context string without pipe.
     */
    function _ex($text, $context, $domain = 'default')
    {
        echo _x($text, $context, $domain);
    }
}

if ( ! function_exists('_x'))
{
    /**
     * Retrieve translated string with gettext context.
     *
     * Quite a few times, there will be collisions with similar translatable text
     * found in more than two places, but with different translated context.
     *
     * By including the context in the pot file, translators can translate the two
     * strings differently.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated context string without pipe.
     */
    function _x($text, $context, $domain = 'default')
    {
        return RC_Locale::translate_with_gettext_context($text, $context, $domain);
    }
}

if ( ! function_exists('_e'))
{
    /**
     * Display translated text.
     *
     * @since 3.0.0
     *
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     */
    function _e($text, $domain = 'default')
    {
        echo RC_Locale::translate($text, $domain);
    }
}

if ( ! function_exists('__'))
{
    /**
     * Retrieve the translation of $text. If there is no translation,
     * or the text domain isn't loaded, the original text is returned.
     *
     * @since 3.0.0
     *
     * @param string $text   Text to translate.
     * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text.
     */
    function __($text, $domain = 'default')
    {
        return RC_Locale::translate($text, $domain);
    }
}


if ( ! function_exists('link_to'))
{
    /**
     * Generate a HTML link.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    function link_to($url, $title = null, $attributes = array(), $secure = null)
    {
        return royalcms('html')->link($url, $title, $attributes, $secure);
    }
}

if ( ! function_exists('link_to_asset'))
{
    /**
     * Generate a HTML link to an asset.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    function link_to_asset($url, $title = null, $attributes = array(), $secure = null)
    {
        return royalcms('html')->linkAsset($url, $title, $attributes, $secure);
    }
}

if ( ! function_exists('link_to_route'))
{
    /**
     * Generate a HTML link to a named route.
     *
     * @param  string  $name
     * @param  string  $title
     * @param  array   $parameters
     * @param  array   $attributes
     * @return string
     */
    function link_to_route($name, $title = null, $parameters = array(), $attributes = array())
    {
        return royalcms('html')->linkRoute($name, $title, $parameters, $attributes);
    }
}

if ( ! function_exists('link_to_action'))
{
    /**
     * Generate a HTML link to a controller action.
     *
     * @param  string  $action
     * @param  string  $title
     * @param  array   $parameters
     * @param  array   $attributes
     * @return string
     */
    function link_to_action($action, $title = null, $parameters = array(), $attributes = array())
    {
        return royalcms('html')->linkAction($action, $title, $parameters, $attributes);
    }
}

/**
 * compat.php 兼容函数库
 * @package Royalcms
 */

if ( !function_exists('iconv') )
{
    /**
     * iconv 编码转换
     */
    function iconv($in_charset, $out_charset, $str)
    {
        $in_charset = strtoupper($in_charset);
        $out_charset = strtoupper($out_charset);
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($str, $out_charset, $in_charset);
        } else {
            $in_charset = strtoupper($in_charset);
            $out_charset = strtoupper($out_charset);
            if ($in_charset == 'UTF-8' && ($out_charset == 'GBK' || $out_charset == 'GB2312')) {
                return Royalcms\Component\Convert\Charset::utf8_to_gbk($str);
            }
            if (($in_charset == 'GBK' || $in_charset == 'GB2312') && $out_charset == 'UTF-8') {
                return Royalcms\Component\Convert\Charset::gbk_to_utf8($str);
            }
            return $str;
        }
    }
}


if (!function_exists('debug')) {
    /**
     * Adds one or more messages to the MessagesCollector
     *
     * @param  mixed ...$value
     * @return string
     */
    function debug($value)
    {
        $debugbar = royalcms('debugbar');
        foreach (func_get_args() as $value) {
            $debugbar->addMessage($value, 'debug');
        }
    }
}

if (!function_exists('start_measure')) {
    /**
     * Starts a measure
     *
     * @param string $name Internal name, used to stop the measure
     * @param string $label Public name
     */
    function start_measure($name, $label = null)
    {
        royalcms('debugbar')->startMeasure($name, $label);
    }
}

if (!function_exists('stop_measure')) {
    /**
     * Stop a measure
     *
     * @param string $name Internal name, used to stop the measure
     */
    function stop_measure($name)
    {
        royalcms('debugbar')->stopMeasure($name);
    }
}

if (!function_exists('add_measure')) {
    /**
     * Adds a measure
     *
     * @param string $label
     * @param float $start
     * @param float $end
     */
    function add_measure($label, $start, $end)
    {
        royalcms('debugbar')->addMeasure($label, $start, $end);
    }
}

if (!function_exists('measure')) {
    /**
     * Utility function to measure the execution of a Closure
     *
     * @param string $label
     * @param \Closure $closure
     */
    function measure($label, \Closure $closure)
    {
        royalcms('debugbar')->measure($label, $closure);
    }
}

if (! function_exists('base64url_encode')) {
    /**
     * 使用base64 加密在URL安全传递
     * @param string $data
     * @return string
     */
    function base64url_encode($data) {   
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    }
}

if (! function_exists('base64url_decode')) {
    /**
     * 使用base64 解密在URL安全传递
     * @param string $data
     * @return string
     */
    function base64url_decode($data) {   
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    }
}

if (! function_exists('remove_route_var')) {
    /**
     * 移出$_GET中路由变量参数
     */
    function remove_route_var() {
        $module = config('route.module');
        $controller = config('route.controller');
        $action = config('route.action');

        unset($_GET[$module]);
        unset($_GET[$controller]);
        unset($_GET[$action]);
    }
    
}

// end
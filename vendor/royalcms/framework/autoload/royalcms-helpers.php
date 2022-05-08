<?php
/**
 * royalcms-helpers 公共函数库
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
        }
        elseif (is_object($string) === true) {
            foreach ($string as $key => $val) {
                $string->$key = rc_addslashes($val);
            }
        }
        else {
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
        }
        elseif (is_object($string) === true) {
            foreach ($string as $key => $val) {
                $string->$key = rc_stripslashes($val);
            }
        }
        else {
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
        }
        elseif (is_object($string) === true) {
            foreach ($string as $key => $val) {
                $string->$key = strip_tags($val);
            }
        }
        else {
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

if ( ! function_exists('rc_stripslashes_deep'))
{
    /**
     * Navigates through an array, object, or scalar, and removes slashes from the values.
     *
     * @since 2.0.0
     *
     * @param mixed $value The value to be stripped.
     * @return mixed Stripped value.
     */
    function rc_stripslashes_deep( $value ) {
        return map_deep( $value, 'stripslashes_from_strings_only' );
    }
}

if ( ! function_exists('stripslashes_from_strings_only'))
{
    /**
     * Callback function for `rc_stripslashes_deep()` which strips slashes from strings.
     *
     * @since 4.4.0
     *
     * @param mixed $value The array or string to be stripped.
     * @return mixed $value The stripped value.
     */
    function stripslashes_from_strings_only( $value ) {
        return is_string( $value ) ? stripslashes( $value ) : $value;
    }
}

if ( ! function_exists('rc_urlencode_deep'))
{
    /**
     * Navigates through an array, object, or scalar, and encodes the values to be used in a URL.
     *
     * @since 2.2.0
     *
     * @param mixed $value The array or string to be encoded.
     * @return mixed $value The encoded value.
     */
    function rc_urlencode_deep( $value ) {
        return map_deep( $value, 'urlencode' );
    }
}

if ( ! function_exists('rc_urldecode_deep'))
{
    /**
     * Navigates through an array, object, or scalar, and decodes URL-encoded values
     *
     * @since 4.4.0
     *
     * @param mixed $value The array or string to be decoded.
     * @return mixed $value The decoded value.
     */
    function rc_urldecode_deep( $value ) {
        return map_deep( $value, 'urldecode' );
    }
}

if ( ! function_exists('rc_rawurlencode_deep'))
{
    /**
     * Navigates through an array, object, or scalar, and raw-encodes the values to be used in a URL.
     *
     * @since 3.4.0
     *
     * @param mixed $value The array or string to be encoded.
     * @return mixed $value The encoded value.
     */
    function rc_rawurlencode_deep( $value ) {
        return map_deep( $value, 'rawurlencode' );
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

if ( ! function_exists('simple_remove_xss'))
{
    /**
     * XSS（跨站脚本攻击）可以用于窃取其他用户的Cookie信息，要避免此类问题，可以采用如下解决方案：
        1.直接过滤所有的JavaScript脚本；
        2.转义Html元字符，使用htmlentities、htmlspecialchars等函数；
        3.系统的扩展函数库提供了XSS安全过滤的remove_xss方法；
        4.对URL访问的一些系统变量做XSS处理。
     *
     * 移除Html代码中的XSS攻击
     *
     * @param $val
     * @return string
     */
    function simple_remove_xss($val)
    {
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
        // this prevents some character re-spacing such as <javascript>
        // note that you have to handle splits with
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

        // straight replacements, the user should never need these since they're normal characters
        // this prevents like <IMG SRC=@avascript:alert('XSS')>
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';

        for ($i = 0; $i < strlen($search); $i++) {
            // ;? matches the ;, which is optional
            // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

            // @ @ search for the hex values
            $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val);
            // @ @ 0{0,7} matches '0' zero to seven times
            $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val);
        }

        // now the only remaining whitespace attacks are, and later since they *are* allowed in some inputs
        $ra1 = array('expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);

        $found = true; // keep replacing as long as the previous round replaced something

        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(&#0{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
                $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
                if ($val_before == $val) {
                    // no replacements were made, so exit the loop
                    $found = false;
                }
            }
        }

        return $val;
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
        {
            $overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );
        }
    
        if ( false === $overloaded )
        {
            return;
        }
    
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
     * @param string $url 跳转urlg
     * @param int $time 跳转时间
     * @param string $msg
     */
    function _jump($url, $time = 0, $msg = '')
    {
        $url = RC_Uri::url($url);
        if (! headers_sent()) {
            $time == 0 ? header("Location:" . $url) : header("refresh:{$time};url={$url}");
            exit($msg);
        }
        else {
            echo "<meta http-equiv='refresh' content='{$time};URL={$url}'>";
            if ($time)
            {
                exit($msg);
            }
        }
    }
}

if ( ! function_exists('_dump'))
{
    /**
     * 调试输出数据
     *
     * @param mixed $var 变量或对象
     * @param boolean $output 输出方式 0 不输出, 1 界面输出, 2 注释输出, 3 txt中断输出
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
        }
        elseif (is_null($var)) {
            var_dump(NULL);
            $content = $a = ob_get_contents();
        }
        else {
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

if ( ! function_exists('is_ie'))
{
    /**
     * IE浏览器判断
     */
    function is_ie()
    {
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if ((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false))
        {
            return false;
        }

        if (strpos($useragent, 'msie ') !== false)
        {
            return true;
        }

        return false;
    }
}

if ( ! function_exists('is_email'))
{
    /**
     * 验证输入的邮件地址是否合法
     *
     * @param string $email 需要验证的邮件地址
     *
     * @return bool
     */
    function is_email($email)
    {
        $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
        if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
            if (preg_match($chars, $email)) {
                return true;
            }
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
        }
        elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
            return true;
        }
        else {
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
        }
        else {
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
     * @param int $length 输出长度
     * @param string $chars 可选的 ，默认为 0123456789
     *
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
            }
            else {
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
        {
            $_SERVER['SCRIPT_FILENAME'] = $_SERVER['PATH_TRANSLATED'];
        }
    
        // Fix for Dreamhost and other PHP as CGI hosts
        if ( strpos( $_SERVER['SCRIPT_NAME'], 'php.cgi' ) !== false )
        {
            unset( $_SERVER['PATH_INFO'] );
        }
    
        // Fix empty PHP_SELF
        $PHP_SELF = $_SERVER['PHP_SELF'];
        if ( empty( $PHP_SELF ) )
        {
            $_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( '/(\?.*)?$/', '', $_SERVER["REQUEST_URI"] );
        }
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
        {
            return rc_win_is_writable( $path );
        }
        else
        {
            return @is_writable( $path );
        }
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
        {
            return rc_win_is_writable( $path . uniqid( mt_rand() ) . '.tmp');
        }
        else if ( is_dir( $path ) ) // If it's a directory (and not a file) check a random file within the directory
        {
            return rc_win_is_writable( $path . '/' . uniqid( mt_rand() ) . '.tmp' );
        }
    
        // check tmp file for read/write capabilities
        $should_delete_tmp_file = !file_exists( $path );
        $f = @fopen( $path, 'a' );
        if ( $f === false )
        {
            return false;
        }
        fclose( $f );
        if ( $should_delete_tmp_file )
        {
            unlink( $path );
        }
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
        {
            $_suspend = $suspend;
        }
    
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

if (! function_exists('map_deep')) {
    /**
     * Maps a function to all non-iterable elements of an array or an object.
     *
     * This is similar to `array_walk_recursive()` but acts upon objects too.
     *
     * @since 5.16.0
     *
     * @param mixed    $value    The array, object, or scalar.
     * @param callable $callback The function to map onto $value.
     * @return mixed The value with the callback applied to all non-arrays and non-objects inside it.
     */
    function map_deep( $value, $callback ) {
        if ( is_array( $value ) ) {
            foreach ( $value as $index => $item ) {
                $value[ $index ] = map_deep( $item, $callback );
            }
        } elseif ( is_object( $value ) ) {
            $object_vars = get_object_vars( $value );
            foreach ( $object_vars as $property_name => $property_value ) {
                $value->$property_name = map_deep( $property_value, $callback );
            }
        } else {
            $value = call_user_func( $callback, $value );
        }

        return $value;
    }
}

if (! function_exists('call_user_func_args')) {
    function call_user_func_args($class, array $parameters)
    {
        return call_user_func_instance_args($class, $parameters);
    }
}

if (! function_exists('call_user_func_instance_args')) {
    function call_user_func_instance_args($class, array $parameters)
    {
        $reflect = new ReflectionClass($class);
        $instance = $reflect->newInstanceArgs($parameters);
        return $instance;
    }
}

if ( ! function_exists('array_head'))
{
    /**
     * Get the first element of an array. Useful for method chaining.
     *
     * @param  array  $array
     * @return mixed
     */
    function array_head($array)
    {
        return reset($array);
    }
}

if ( ! function_exists('array_last'))
{
    /**
     * Get the last element from an array.
     *
     * @param  array  $array
     * @return mixed
     */
    function array_last($array)
    {
        return end($array);
    }
}

if (! function_exists('preg_replace_sub')) {
    /**
     * Replace a given pattern with each value in the array in sequentially.
     *
     * @param  string  $pattern
     * @param  array   $replacements
     * @param  string  $subject
     * @return string
     */
    function preg_replace_sub($pattern, & $replacements, $subject)
    {
        return preg_replace_callback($pattern, function ($match) use (& $replacements) {
            foreach ($replacements as $key => $value) {
                return array_shift($replacements);
            }
        }, $subject);
    }
}

// end
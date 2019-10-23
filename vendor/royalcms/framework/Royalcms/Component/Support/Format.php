<?php

namespace Royalcms\Component\Support;

use Royalcms\Component\Support\Facades\Config;
use RC_Hook;
use Royalcms\Component\Support\Facades\Lang;
use RC_Locale;

class Format
{

    /**
     * 日期格式化
     *
     * @param int $timestamp
     * @param int $showtime
     */
    public static function date($timestamp, $showtime = 0)
    {
        if (empty($timestamp)) {
            return false;
        }
            
        $times = intval($timestamp);
        if (! $times) {
            return true;
        }
            
        $lang = Config::get('system.lang');
        if ($lang == 'zh-cn') {
            $str = $showtime ? date('Y-m-d H:i:s', $times) : date('Y-m-d', $times);
        } else {
            $str = $showtime ? date('m/d/Y H:i:s', $times) : date('m/d/Y', $times);
        }
        return $str;
    }

    /**
     * 获取当前星期
     *
     * @param int $timestamp
     */
    public static function week($timestamp)
    {
        $times = intval($timestamp);
        if (! $times) {
            return true;
        }
            
        $weekarray = array(
            Lang::lang('Sunday'),
            Lang::lang('Monday'),
            Lang::lang('Tuesday'),
            Lang::lang('Wednesday'),
            Lang::lang('Thursday'),
            Lang::lang('Friday'),
            Lang::lang('Saturday')
        );
        return $weekarray[date("w", $timestamp)];
    }

    /**
     * Appends a trailing slash.
     *
     * Will remove trailing forward and backslashes if it exists already before adding
     * a trailing forward slash. This prevents double slashing a string or path.
     *
     * The primary use of this is for paths and thus should be used for paths. It is
     * not restricted to paths and offers no specific path support.
     *
     * @since 3.2.0
     *       
     * @param string $string What to add the trailing slash to.
     * @return string String with trailing slash added.
     */
    public static function trailingslashit($string)
    {
        return self::untrailingslashit($string) . '/';
    }

    /**
     * Removes trailing forward slashes and backslashes if they exist.
     *
     * The primary use of this is for paths and thus should be used for paths. It is
     * not restricted to paths and offers no specific path support.
     *
     * @since 3.2.0
     *       
     * @param string $string
     *            What to remove the trailing slashes from.
     * @return string String without the trailing slashes.
     */
    public static function untrailingslashit($string)
    {
        return rtrim($string, '/\\');
    }

    /**
     * Normalize a filesystem path.
     *
     * On windows systems, replaces backslashes with forward slashes
     * and forces upper-case drive letters.
     * Allows for two leading slashes for Windows network shares, but
     * ensures that all other duplicate slashes are reduced to a single.
     *
     * @since 3.9.0
     * @since 4.4.0 Ensures upper-case drive letters on Windows systems.
     * @since 4.5.0 Allows for Windows network shares.
     * @since 4.9.7 Allows for PHP file wrappers.
     *
     * @param string $path Path to normalize.
     * @return string Normalized path.
     */
    public static function normalize_path($path)
    {
        $wrapper = '';
        if ( rc_is_stream( $path ) ) {
            list( $wrapper, $path ) = explode( '://', $path, 2 );
            $wrapper .= '://';
        }

        // Standardise all paths to use /
        $path = str_replace( '\\', '/', $path );

        // Replace multiple slashes down to a singular, allowing for network shares having two slashes.
        $path = preg_replace( '|(?<=.)/+|', '/', $path );

        // Windows paths should uppercase the drive letter
        if ( ':' === substr( $path, 1, 1 ) ) {
            $path = ucfirst( $path );
        }

        return $wrapper . $path;
    }

    /**
     * Join two filesystem paths together (e.g.
     * 'give me $path relative to $base').
     *
     * If the $path is absolute, then it the full path is returned.
     *
     * @since 3.2.0
     *       
     * @param string $base            
     * @param string $path            
     * @return string The path with the base or absolute path.
     */
    public static function path_join($base, $path)
    {
        if (self::path_is_absolute($path))
            return $path;
        
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Test if a give filesystem path is absolute ('/foo/bar', 'c:\windows').
     *
     * @since 3.2.0
     *       
     * @param string $path File path
     * @return bool True if path is absolute, false is not absolute.
     */
    public static function path_is_absolute($path)
    {
        // this is definitive if true but fails if $path does not exist or contains a symbolic link
        if (realpath($path) == $path) {
            return true;
        }
        
        if (strlen($path) == 0 || $path[0] == '.') {
            return false;
        }
            
        // windows allows absolute paths like this
        if (preg_match('#^[a-zA-Z]:\\\\#', $path)) {
            return true;
        }
            
        // a path starting with / or \ is absolute; anything else is relative
        return ($path[0] == '/' || $path[0] == '\\');
    }

    /**
     * 根据大小返回标准单位 KB MB GB等
     */
    public static function format_size($size, $decimals = 2)
    {
        switch (true) {
            case $size >= pow(1024, 3):
                return round($size / pow(1024, 3), $decimals) . " GB";
            case $size >= pow(1024, 2):
                return round($size / pow(1024, 2), $decimals) . " MB";
            case $size >= pow(1024, 1):
                return round($size / pow(1024, 1), $decimals) . " KB";
            default:
                return $size . 'B';
        }
    }
    
    
    /**
     *  将含有单位的数字转成字节
     *
     * @access  public
     * @param   string      $val        带单位的数字
     *
     * @return  int         $val
     */
    public static function format_bytes($val)
    {
        $val = trim($val);
        $last = strtolower($val{strlen($val)-1});
        switch($last) {
        	case 'g':
        	    $val *= 1024;
        	case 'm':
        	    $val *= 1024;
        	case 'k':
        	    $val *= 1024;
        }
    
        return $val;
    }

    /**
     * 将文本格式成适合js输出的字符串
     *
     * @param string $string
     *            需要处理的字符串
     * @param intval $isjs
     *            是否执行字符串格式化，默认为执行
     * @return string 处理后的字符串
     */
    public static function format_js($string, $isjs = 1)
    {
        $string = addslashes(str_replace(array(
            "\r",
            "\n"
        ), array(
            '',
            ''
        ), $string));
        return $isjs ? 'document.write("' . $string . '");' : $string;
    }

    /**
     * 格式化文本域内容
     *
     * @param $string 文本域内容            
     * @return string
     */
    public static function format_textarea($string)
    {
        $string = nl2br(str_replace(' ', '&nbsp;', $string));
        return $string;
    }

    /**
     * 转义 javascript 代码标记
     *
     * @param
     *            $str
     * @return mixed
     */
    public static function format_script($str)
    {
        $str = preg_replace('/\<([\/]?)script([^\>]*?)\>/si', '&lt;\\1script\\2&gt;', $str);
        $str = preg_replace('/\<([\/]?)iframe([^\>]*?)\>/si', '&lt;\\1iframe\\2&gt;', $str);
        $str = preg_replace('/\<([\/]?)frame([^\>]*?)\>/si', '&lt;\\1frame\\2&gt;', $str);
        $str = preg_replace('/]]\>/si', ']] >', $str);
        return $str;
    }

    /**
     * Checks and cleans a URL.
     *
     * A number of characters are removed from the URL. If the URL is for displaying
     * (the default behaviour) ampersands are also replaced. The 'clean_url' filter
     * is applied to the returned cleaned URL.
     *
     * @since 3.2.0
     * @uses kses_bad_protocol() To only permit protocols in the URL set
     *       via $protocols or the common ones set in the function.
     *      
     * @param string $url
     *            The URL to be cleaned.
     * @param array $protocols
     *            Optional. An array of acceptable protocols.
     *            Defaults to 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'svn' if not set.
     * @param string $_context
     *            Private. Use esc_url_raw() for database usage.
     * @return string The cleaned $url after the 'clean_url' filter is applied.
     */
    public static function esc_url($url, $protocols = null, $_context = 'display')
    {
        $original_url = $url;
        
        if ('' == $url) {
            return $url;
        }

        $url = str_replace( ' ', '%20', $url );
        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\[\]\\x80-\\xff]|i', '', $url);

        if ( 0 !== stripos( $url, 'mailto:' ) ) {
            $strip = array('%0d', '%0a', '%0D', '%0A');
            $url = self::_deep_replace($strip, $url);
        }

        $url = str_replace(';//', '://', $url);
        /* If the URL doesn't appear to contain a scheme, we
         * presume it needs http:// prepended (unless a relative
         * link starting with /, # or ? or a php file).
         */
        if ( strpos($url, ':') === false && ! in_array( $url[0], array( '/', '#', '?' ) ) &&
            ! preg_match('/^[a-z0-9-]+?\.php/i', $url) )
        {
            $url = 'http://' . $url;
        }
            
        // Replace ampersands and single quotes only when displaying.
        if ( 'display' == $_context ) {
            $url = \RC_Kses::normalize_entities( $url );
            $url = str_replace( '&amp;', '&#038;', $url );
            $url = str_replace( "'", '&#039;', $url );
        }

        if ( ( false !== strpos( $url, '[' ) ) || ( false !== strpos( $url, ']' ) ) ) {

            $parsed = rc_parse_url( $url );
            $front  = '';

            if ( isset( $parsed['scheme'] ) ) {
                $front .= $parsed['scheme'] . '://';
            } elseif ( '/' === $url[0] ) {
                $front .= '//';
            }

            if ( isset( $parsed['user'] ) ) {
                $front .= $parsed['user'];
            }

            if ( isset( $parsed['pass'] ) ) {
                $front .= ':' . $parsed['pass'];
            }

            if ( isset( $parsed['user'] ) || isset( $parsed['pass'] ) ) {
                $front .= '@';
            }

            if ( isset( $parsed['host'] ) ) {
                $front .= $parsed['host'];
            }

            if ( isset( $parsed['port'] ) ) {
                $front .= ':' . $parsed['port'];
            }

            $end_dirty = str_replace( $front, '', $url );
            $end_clean = str_replace( array( '[', ']' ), array( '%5B', '%5D' ), $end_dirty );
            $url       = str_replace( $end_dirty, $end_clean, $url );

        }
        
        if ('/' === $url[0]) {
            $good_protocol_url = $url;
        } else {
            if ( ! is_array( $protocols ) )
            {
                $protocols = rc_allowed_protocols();
            }

            $good_protocol_url = \RC_Kses::bad_protocol( $url, $protocols );
            if ( strtolower( $good_protocol_url ) != strtolower( $url ) )
            {
                return '';
            }
        }
        
        /**
         * Filter a string cleaned and escaped for output as a URL.
         *
         * @since 3.2.0
         *       
         * @param string $good_protocol_url
         *            The cleaned URL to be returned.
         * @param string $original_url
         *            The URL prior to cleaning.
         * @param string $_context
         *            If 'display', replace ampersands and single quotes only.
         */
        return RC_Hook::apply_filters('clean_url', $good_protocol_url, $original_url, $_context);
    }

    /**
     * Performs esc_url() for database usage.
     *
     * @since 3.2.0
     * @uses esc_url()
     *      
     * @param string $url
     *            The URL to be cleaned.
     * @param array $protocols
     *            An array of acceptable protocols.
     * @return string The cleaned URL.
     */
    public static function esc_url_raw($url, $protocols = null)
    {
        return self::esc_url($url, $protocols, 'db');
    }

    /**
     * Perform a deep string replace operation to ensure the values in $search are no longer present
     *
     * Repeats the replacement operation until it no longer replaces anything so as to remove "nested" values
     * e.g. $subject = '%0%0%0DDD', $search ='%0D', $result ='' rather than the '%0%0DD' that
     * str_replace would return
     *
     * @since 3.2.1
     * @access private
     *        
     * @param string|array $search
     *            The value being searched for, otherwise known as the needle. An array may be used to designate multiple needles.
     * @param string $subject
     *            The string being searched and replaced on, otherwise known as the haystack.
     * @return string The string with the replaced svalues.
     */
    public static function _deep_replace($search, $subject)
    {
        $subject = (string) $subject;
        
        $count = 1;
        while ($count) {
            $subject = str_replace($search, '', $subject, $count);
        }
        
        return $subject;
    }

    /**
     * Navigates through an array and encodes the values to be used in a URL.
     *
     *
     * @since 2.2.0
     *       
     * @param array|string $value
     *            The array or string to be encoded.
     * @return array string The encoded array (or string from the callback).
     */
    public static function urlencode_deep($value)
    {
        $value = is_array($value) ? array_map(array(
            __CLASS__,
            'urlencode_deep'
        ), $value) : urlencode($value);
        return $value;
    }

    /**
     * Navigates through an array and raw encodes the values to be used in a URL.
     *
     * @since 3.2.0
     *       
     * @param array|string $value
     *            The array or string to be encoded.
     * @return array string The encoded array (or string from the callback).
     */
    public static function rawurlencode_deep($value)
    {
        return is_array($value) ? array_map(array(
            __CLASS__,
            'rawurlencode_deep'
        ), $value) : rawurlencode($value);
    }

    /**
     * Escaping for HTML attributes.
     *
     * @since 3.2.0
     *       
     * @param string $text            
     * @return string
     */
    public static function esc_attr($text)
    {
        $safe_text = self::_check_invalid_utf8($text);
        $safe_text = self::_specialchars($safe_text, ENT_QUOTES);
        /**
         * Filter a string cleaned and escaped for output in an HTML attribute.
         *
         * Text passed to esc_attr() is stripped of invalid or special characters
         * before output.
         *
         * @since 3.2.6
         *       
         * @param string $safe_text
         *            The text after it has been escaped.
         * @param string $text
         *            The text prior to being escaped.
         */
        return RC_Hook::apply_filters('attribute_escape', $safe_text, $text);
    }

    /**
     * Escape single quotes, htmlspecialchar " < > &, and fix line endings.
     *
     * Escapes text strings for echoing in JS. It is intended to be used for inline JS
     * (in a tag attribute, for example onclick="..."). Note that the strings have to
     * be in single quotes. The filter 'js_escape' is also applied here.
     *
     * @since 3.2.0
     *       
     * @param string $text
     *            The text to be escaped.
     * @return string Escaped text.
     */
    public static function esc_js($text)
    {
        $safe_text = self::_check_invalid_utf8($text);
        $safe_text = self::_specialchars($safe_text, ENT_COMPAT);
        $safe_text = preg_replace('/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes($safe_text));
        $safe_text = str_replace("\r", '', $safe_text);
        $safe_text = str_replace("\n", '\\n', addslashes($safe_text));
        /**
         * Filter a string cleaned and escaped for output in JavaScript.
         *
         * Text passed to esc_js() is stripped of invalid or special characters,
         * and properly slashed for output.
         *
         * @since 3.2.0
         *       
         * @param string $safe_text
         *            The text after it has been escaped.
         * @param string $text
         *            The text prior to being escaped.
         */
        return RC_Hook::apply_filters('js_escape', $safe_text, $text);
    }

    /**
     * Escaping for HTML blocks.
     *
     * @since 3.2.0
     *       
     * @param string $text            
     * @return string
     */
    public static function esc_html($text)
    {
        $safe_text = self::_check_invalid_utf8($text);
        $safe_text = self::_specialchars($safe_text, ENT_QUOTES);
        /**
         * Filter a string cleaned and escaped for output in HTML.
         *
         * Text passed to esc_html() is stripped of invalid or special characters
         * before output.
         *
         * @since 3.2.0
         *       
         * @param string $safe_text
         *            The text after it has been escaped.
         * @param string $text
         *            The text prior to being escaped.
         */
        return RC_Hook::apply_filters('esc_html', $safe_text, $text);
    }

    /**
     * Escaping for textarea values.
     *
     * @since 3.2.0
     *       
     * @param string $text            
     * @return string
     */
    public static function esc_textarea($text)
    {
        $safe_text = htmlspecialchars($text, ENT_QUOTES, RC_CHARSET);
        /**
         * Filter a string cleaned and escaped for output in a textarea element.
         *
         * @since 3.2.0
         *       
         * @param string $safe_text
         *            The text after it has been escaped.
         * @param string $text
         *            The text prior to being escaped.
         */
        return RC_Hook::apply_filters('esc_textarea', $safe_text, $text);
    }

    /**
     * Checks for invalid UTF8 in a string.
     *
     * @since 3.2.0
     *       
     * @param string $string
     *            The text which is to be checked.
     * @param boolean $strip
     *            Optional. Whether to attempt to strip out invalid UTF8. Default is false.
     * @return string The checked text.
     */
    public static function _check_invalid_utf8($string, $strip = false)
    {
        $string = (string) $string;
        
        if (0 === strlen($string)) {
            return '';
        }
        
        // Store the site charset as a static to avoid multiple calls to get_option()
        static $is_utf8;
        if (! isset($is_utf8)) {
            $is_utf8 = in_array(RC_CHARSET, array(
                'utf8',
                'utf-8',
                'UTF8',
                'UTF-8'
            ));
        }
        if (! $is_utf8) {
            return $string;
        }
        
        // Check for support for utf8 in the installed PCRE library once and store the result in a static
        static $utf8_pcre;
        if (! isset($utf8_pcre)) {
            $utf8_pcre = @preg_match('/^./u', 'a');
        }
        // We can't demand utf8 in the PCRE installation, so just return the string in those cases
        if (! $utf8_pcre) {
            return $string;
        }
        
        // preg_match fails when it encounters invalid UTF8 in $string
        if (1 === @preg_match('/^./us', $string)) {
            return $string;
        }
        
        // Attempt to strip the bad chars if requested (not recommended)
        if ($strip && function_exists('iconv')) {
            return iconv('utf-8', 'utf-8', $string);
        }
        
        return '';
    }

    /**
     * Converts a number of special characters into their HTML entities.
     *
     * Specifically deals with: &, <, >, ", and '.
     *
     * $quote_style can be set to ENT_COMPAT to encode " to
     * &quot;, or ENT_QUOTES to do both. Default is ENT_NOQUOTES where no quotes are encoded.
     *
     * @since 3.2.0
     * @access private
     *        
     * @param string $string
     *            The text which is to be encoded.
     * @param mixed $quote_style
     *            Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
     * @param string $charset
     *            Optional. The character encoding of the string. Default is false.
     * @param boolean $double_encode
     *            Optional. Whether to encode existing html entities. Default is false.
     * @return string The encoded text with HTML entities.
     */
    public static function _specialchars($string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false)
    {
        $string = (string) $string;
        
        if (0 === strlen($string)) {
            return '';
        }
            
        // Don't bother if there are no specialchars - saves some processing
        if (! preg_match('/[&<>"\']/', $string)) {
            return $string;
        }
            
        // Account for the previous behaviour of the function when the $quote_style is not an accepted value
        if (empty($quote_style)) {
            $quote_style = ENT_NOQUOTES;
        } elseif (! in_array($quote_style, array(
            0,
            2,
            3,
            'single',
            'double'
        ), true)) {
            $quote_style = ENT_QUOTES;
        } 
            
        // Store the site charset as a static to avoid multiple calls to wp_load_alloptions()
        if (! $charset) {
            $charset = RC_CHARSET;
        }
        
        if (in_array($charset, array(
            'utf8',
            'utf-8',
            'UTF8'
        ))) {
            $charset = 'UTF-8';
        }   
        
        $_quote_style = $quote_style;
        
        if ($quote_style === 'double') {
            $quote_style = ENT_COMPAT;
            $_quote_style = ENT_COMPAT;
        } elseif ($quote_style === 'single') {
            $quote_style = ENT_NOQUOTES;
        }
        
        // Handle double encoding ourselves
        if ($double_encode) {
            $string = @htmlspecialchars($string, $quote_style, $charset);
        } else {
            // Decode &amp; into &
            $string = self::_specialchars_decode($string, $_quote_style);
            
            // Guarantee every &entity; is valid or re-encode the &
            // $string = kses_normalize_entities( $string );
            
            // Now re-encode everything except &entity;
            $string = preg_split('/(&#?x?[0-9a-z]+;)/i', $string, - 1, PREG_SPLIT_DELIM_CAPTURE);
            
            for ($i = 0; $i < count($string); $i += 2) {
                $string[$i] = @htmlspecialchars($string[$i], $quote_style, $charset);
            } 
            
            $string = implode('', $string);
        }
        
        // Backwards compatibility
        if ('single' === $_quote_style) {
            $string = str_replace("'", '&#039;', $string);
        }
        
        return $string;
    }

    /**
     * Converts a number of HTML entities into their special characters.
     *
     * Specifically deals with: &, <, >, ", and '.
     *
     * $quote_style can be set to ENT_COMPAT to decode " entities,
     * or ENT_QUOTES to do both " and '. Default is ENT_NOQUOTES where no quotes are decoded.
     *
     * @since 3.2.0
     *       
     * @param string $string
     *            The text which is to be decoded.
     * @param mixed $quote_style
     *            Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old _rc_specialchars() values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
     * @return string The decoded text without HTML entities.
     */
    public static function _specialchars_decode($string, $quote_style = ENT_NOQUOTES)
    {
        $string = (string) $string;
        
        if (0 === strlen($string)) {
            return '';
        }
        
        // Don't bother if there are no entities - saves a lot of processing
        if (strpos($string, '&') === false) {
            return $string;
        }
        
        // Match the previous behaviour of _wp_specialchars() when the $quote_style is not an accepted value
        if (empty($quote_style)) {
            $quote_style = ENT_NOQUOTES;
        } elseif (! in_array($quote_style, array(
            0,
            2,
            3,
            'single',
            'double'
        ), true)) {
            $quote_style = ENT_QUOTES;
        }
        
        // More complete than get_html_translation_table( HTML_SPECIALCHARS )
        $single = array(
            '&#039;' => '\'',
            '&#x27;' => '\''
        );
        $single_preg = array(
            '/&#0*39;/' => '&#039;',
            '/&#x0*27;/i' => '&#x27;'
        );
        $double = array(
            '&quot;' => '"',
            '&#034;' => '"',
            '&#x22;' => '"'
        );
        $double_preg = array(
            '/&#0*34;/' => '&#034;',
            '/&#x0*22;/i' => '&#x22;'
        );
        $others = array(
            '&lt;' => '<',
            '&#060;' => '<',
            '&gt;' => '>',
            '&#062;' => '>',
            '&amp;' => '&',
            '&#038;' => '&',
            '&#x26;' => '&'
        );
        $others_preg = array(
            '/&#0*60;/' => '&#060;',
            '/&#0*62;/' => '&#062;',
            '/&#0*38;/' => '&#038;',
            '/&#x0*26;/i' => '&#x26;'
        );
        
        if ($quote_style === ENT_QUOTES) {
            $translation = array_merge($single, $double, $others);
            $translation_preg = array_merge($single_preg, $double_preg, $others_preg);
        } elseif ($quote_style === ENT_COMPAT || $quote_style === 'double') {
            $translation = array_merge($double, $others);
            $translation_preg = array_merge($double_preg, $others_preg);
        } elseif ($quote_style === 'single') {
            $translation = array_merge($single, $others);
            $translation_preg = array_merge($single_preg, $others_preg);
        } elseif ($quote_style === ENT_NOQUOTES) {
            $translation = $others;
            $translation_preg = $others_preg;
        }
        
        // Remove zero padding on numeric entities
        $string = preg_replace(array_keys($translation_preg), array_values($translation_preg), $string);
        
        // Replace characters according to translation table
        return strtr($string, $translation);
    }

    /**
     * Strip close comment and close php tags from file headers used by WP.
     * See http://core.trac.wordpress.org/ticket/8497
     *
     * @since 3.2.0
     *       
     * @param string $str            
     * @return string
     */
    public static function _cleanup_header_comment($str)
    {
        return trim(preg_replace('/\s*(?:\*\/|\?>).*/', '', $str));
    }
    
    
    /**
     * Replaces common plain text characters into formatted entities
     *
     * As an example,
     * <code>
     * 'cause today's effort makes it worth tomorrow's "holiday"...
     * </code>
     * Becomes:
     * <code>
     * &#8217;cause today&#8217;s effort makes it worth tomorrow&#8217;s &#8220;holiday&#8221;&#8230;
     * </code>
     * Code within certain html blocks are skipped.
     *
     * @since 3.2.0
     * @uses $wp_cockneyreplace Array of formatted entities for certain common phrases
     *
     * @param string $text The text to be formatted
     * @return string The string replaced with html entities
     */
    private static $cockneyreplace;
    public static function texturize($text) {
        static $static_characters, $static_replacements, $dynamic_characters, $dynamic_replacements,
        $default_no_texturize_tags, $default_no_texturize_shortcodes;
    
        // No need to set up these static variables more than once
        if ( ! isset( $static_characters ) ) {
            /* translators: opening curly double quote */
            $opening_quote = _x( '&#8220;', 'opening curly double quote' );
            /* translators: closing curly double quote */
            $closing_quote = _x( '&#8221;', 'closing curly double quote' );
    
            /* translators: apostrophe, for example in 'cause or can't */
            $apos = _x( '&#8217;', 'apostrophe' );
    
            /* translators: prime, for example in 9' (nine feet) */
            $prime = _x( '&#8242;', 'prime' );
            /* translators: double prime, for example in 9" (nine inches) */
            $double_prime = _x( '&#8243;', 'double prime' );
    
            /* translators: opening curly single quote */
            $opening_single_quote = _x( '&#8216;', 'opening curly single quote' );
            /* translators: closing curly single quote */
            $closing_single_quote = _x( '&#8217;', 'closing curly single quote' );
    
            /* translators: en dash */
            $en_dash = _x( '&#8211;', 'en dash' );
            /* translators: em dash */
            $em_dash = _x( '&#8212;', 'em dash' );
    
            $default_no_texturize_tags = array('pre', 'code', 'kbd', 'style', 'script', 'tt');
            $default_no_texturize_shortcodes = array('code');
    
            // if a plugin has provided an autocorrect array, use it
            if ( isset($wp_cockneyreplace) ) {
                $cockney = array_keys(self::$cockneyreplace);
                $cockneyreplace = array_values(self::$cockneyreplace);
            } elseif ( "'" != $apos ) { // Only bother if we're doing a replacement.
                $cockney = array( "'tain't", "'twere", "'twas", "'tis", "'twill", "'til", "'bout", "'nuff", "'round", "'cause" );
                $cockneyreplace = array( $apos . "tain" . $apos . "t", $apos . "twere", $apos . "twas", $apos . "tis", $apos . "twill", $apos . "til", $apos . "bout", $apos . "nuff", $apos . "round", $apos . "cause" );
            } else {
                $cockney = $cockneyreplace = array();
            }
    
            $static_characters = array_merge( array( '---', ' -- ', '--', ' - ', 'xn&#8211;', '...', '``', '\'\'', ' (tm)' ), $cockney );
            $static_replacements = array_merge( array( $em_dash, ' ' . $em_dash . ' ', $en_dash, ' ' . $en_dash . ' ', 'xn--', '&#8230;', $opening_quote, $closing_quote, ' &#8482;' ), $cockneyreplace );
    
            /*
             * Regex for common whitespace characters.
            *
            * By default, spaces include new lines, tabs, nbsp entities, and the UTF-8 nbsp.
            * This is designed to replace the PCRE \s sequence.  In #WP22692, that sequence
            * was found to be unreliable due to random inclusion of the A0 byte.
            */
            $spaces = '[\r\n\t ]|\xC2\xA0|&nbsp;';
    
    
            // Pattern-based replacements of characters.
            $dynamic = array();
    
            // '99 '99s '99's (apostrophe)
            if ( "'" !== $apos ) {
                $dynamic[ '/\'(?=\d)/' ] = $apos;
            }
    
            // Single quote at start, or preceded by (, {, <, [, ", or spaces.
            if ( "'" !== $opening_single_quote ) {
                $dynamic[ '/(?<=\A|[([{<"]|' . $spaces . ')\'/' ] = $opening_single_quote;
            }
    
            // 9" (double prime)
            if ( '"' !== $double_prime ) {
                $dynamic[ '/(?<=\d)"/' ] = $double_prime;
            }
    
            // 9' (prime)
            if ( "'" !== $prime ) {
                $dynamic[ '/(?<=\d)\'/' ] = $prime;
            }
    
            // Apostrophe in a word.  No spaces or double primes.
            if ( "'" !== $apos ) {
                $dynamic[ '/(?<!' . $spaces . ')\'(?!\'|' . $spaces . ')/' ] = $apos;
            }
    
            // Double quote at start, or preceded by (, {, <, [, or spaces, and not followed by spaces.
            if ( '"' !== $opening_quote ) {
                $dynamic[ '/(?<=\A|[([{<]|' . $spaces . ')"(?!' . $spaces . ')/' ] = $opening_quote;
            }
    
            // Any remaining double quotes.
            if ( '"' !== $closing_quote ) {
                $dynamic[ '/"/' ] = $closing_quote;
            }
    
            // Single quotes followed by spaces or a period.
            if ( "'" !== $closing_single_quote ) {
                $dynamic[ '/\'(?=\Z|\.|' . $spaces . ')/' ] = $closing_single_quote;
            }
    
            $dynamic_characters = array_keys( $dynamic );
            $dynamic_replacements = array_values( $dynamic );
        }
    
        // Transform into regexp sub-expression used in _wptexturize_pushpop_element
        // Must do this every time in case plugins use these filters in a context sensitive manner
        /**
         * Filter the list of HTML elements not to texturize.
         *
         * @since 3.2.0
         *
         * @param array $default_no_texturize_tags An array of HTML element names.
         */
        $no_texturize_tags = '(' . implode( '|', RC_Hook::apply_filters( 'no_texturize_tags', $default_no_texturize_tags ) ) . ')';
        /**
         * Filter the list of shortcodes not to texturize.
         *
         * @since 3.2.0
         *
         * @param array $default_no_texturize_shortcodes An array of shortcode names.
         */
        $no_texturize_shortcodes = '(' . implode( '|', RC_Hook::apply_filters( 'no_texturize_shortcodes', $default_no_texturize_shortcodes ) ) . ')';
    
        $no_texturize_tags_stack = array();
        $no_texturize_shortcodes_stack = array();
    
        $textarr = preg_split('/(<.*>|\[.*\])/Us', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
    
        foreach ( $textarr as &$curl ) {
            if ( empty( $curl ) ) {
                continue;
            }
    
            // Only call _wptexturize_pushpop_element if first char is correct tag opening
            $first = $curl[0];
            if ( '<' === $first ) {
                self::_texturize_pushpop_element($curl, $no_texturize_tags_stack, $no_texturize_tags, '<', '>');
            } elseif ( '[' === $first ) {
                self::_texturize_pushpop_element($curl, $no_texturize_shortcodes_stack, $no_texturize_shortcodes, '[', ']');
            } elseif ( empty($no_texturize_shortcodes_stack) && empty($no_texturize_tags_stack) ) {
    
                // This is not a tag, nor is the texturization disabled static strings
                $curl = str_replace($static_characters, $static_replacements, $curl);
    
                // regular expressions
                $curl = preg_replace($dynamic_characters, $dynamic_replacements, $curl);
    
                // 9x9 (times)
                if ( 1 === preg_match( '/(?<=\d)x\d/', $text ) ) {
                    // Searching for a digit is 10 times more expensive than for the x, so we avoid doing this one!
                    $curl = preg_replace( '/\b(\d+)x(\d+)\b/', '$1&#215;$2', $curl );
                }
            }
    
            // Replace each & with &#038; unless it already looks like an entity.
            $curl = preg_replace('/&([^#])(?![a-zA-Z1-4]{1,8};)/', '&#038;$1', $curl);
        }
        return implode( '', $textarr );
    }
    
    /**
     * Search for disabled element tags. Push element to stack on tag open and pop
     * on tag close. Assumes first character of $text is tag opening.
     *
     * @since 3.2.0
     * @access private
     *
     * @param string $text Text to check. First character is assumed to be $opening
     * @param array $stack Array used as stack of opened tag elements
     * @param string $disabled_elements Tags to match against formatted as regexp sub-expression
     * @param string $opening Tag opening character, assumed to be 1 character long
     * @param string $closing Tag closing character
     */
    public static function _texturize_pushpop_element($text, &$stack, $disabled_elements, $opening = '<', $closing = '>') {
        // Check if it is a closing tag -- otherwise assume opening tag
        if (strncmp($opening . '/', $text, 2)) {
            // Opening? Check $text+1 against disabled elements
            if (preg_match('/^' . $disabled_elements . '\b/', substr($text, 1), $matches)) {
                /*
                 * This disables texturize until we find a closing tag of our type
                * (e.g. <pre>) even if there was invalid nesting before that
                *
                * Example: in the case <pre>sadsadasd</code>"baba"</pre>
                *          "baba" won't be texturize
                */
    
                array_push($stack, $matches[1]);
            }
        } else {
            // Closing? Check $text+2 against disabled elements
            $c = preg_quote($closing, '/');
            if (preg_match('/^' . $disabled_elements . $c . '/', substr($text, 2), $matches)) {
                $last = array_pop($stack);
    
                // Make sure it matches the opening tag
                if ( $last != $matches[1] ) {
                    array_push( $stack, $last );
                }
            }
        }
    }
    
    
    /**
     * Sanitizes a title, or returns a fallback title.
     *
     * Specifically, HTML and PHP tags are stripped. Further actions can be added
     * via the plugin API. If $title is empty and $fallback_title is set, the latter
     * will be used.
     *
     * @since 3.2.0
     *
     * @param string $title The string to be sanitized.
     * @param string $fallback_title Optional. A title to use if $title is empty.
     * @param string $context Optional. The operation for which the string is sanitized
     * @return string The sanitized string.
     */
    public static function sanitize_title( $title, $fallback_title = '', $context = 'save' ) {
        $raw_title = $title;
    
        if ( 'save' == $context ) {
            $title = self::remove_accents($title);
        }   
    
        /**
         * Filter a sanitized title string.
         *
         * @since 3.2.0
         *
         * @param string $title     Sanitized title.
         * @param string $raw_title The title prior to sanitization.
         * @param string $context   The context for which the title is being sanitized.
        */
        $title = RC_Hook::apply_filters( 'sanitize_title', $title, $raw_title, $context );
    
        if ( '' === $title || false === $title ) {
            $title = $fallback_title;
        } 
    
        return $title;
    }
    
    /**
     * Sanitizes a filename, replacing whitespace with dashes.
     *
     * Removes special characters that are illegal in filenames on certain
     * operating systems and special characters requiring special escaping
     * to manipulate at the command line. Replaces spaces and consecutive
     * dashes with a single dash. Trims period, dash and underscore from beginning
     * and end of filename.
     *
     * @since 2.1.0
     *
     * @param string $filename The filename to be sanitized
     * @return string The sanitized filename
     */
    public static function sanitize_file_name( $filename ) {
        $filename_raw = $filename;
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", chr(0));
        /**
         * Filter the list of characters to remove from a filename.
         *
         * @since 2.8.0
         *
         * @param array  $special_chars Characters to remove.
         * @param string $filename_raw  Filename as it was passed into sanitize_file_name().
        */
        $special_chars = RC_Hook::apply_filters( 'sanitize_file_name_chars', $special_chars, $filename_raw );
        $filename = preg_replace( "#\x{00a0}#siu", ' ', $filename );
        $filename = str_replace($special_chars, '', $filename);
        $filename = str_replace( array( '%20', '+' ), '-', $filename );
        $filename = preg_replace('/[\s-]+/', '-', $filename);
        $filename = trim($filename, '.-_');
    
        // Split the filename into a base and extension[s]
        $parts = explode('.', $filename);
    
        // Return if only one extension
        if ( count( $parts ) <= 2 ) {
            /**
             * Filter a sanitized filename string.
             *
             * @since 2.8.0
             *
             * @param string $filename     Sanitized filename.
             * @param string $filename_raw The filename prior to sanitization.
             */
            return RC_Hook::apply_filters( 'sanitize_file_name', $filename, $filename_raw );
        }
    
        // Process multiple extensions
        $filename = array_shift($parts);
        $extension = array_pop($parts);
        // @todo
        //$mimes = get_allowed_mime_types();
        $mimes = array();
        /*
         * Loop over any intermediate extensions. Postfix them with a trailing underscore
        * if they are a 2 - 5 character long alpha string not in the extension whitelist.
        */
        foreach ( (array) $parts as $part) {
            $filename .= '.' . $part;
    
            if ( preg_match('/^[a-zA-Z]{2,5}\d?$/', $part) ) {
                $allowed = false;
                foreach ( $mimes as $ext_preg => $mime_match ) {
                    $ext_preg = '!^(' . $ext_preg . ')$!i';
                    if ( preg_match( $ext_preg, $part ) ) {
                        $allowed = true;
                        break;
                    }
                }
                if ( !$allowed )
                    $filename .= '_';
            }
        }
        $filename .= '.' . $extension;
        /** This filter is documented in wp-includes/formatting.php */
        return RC_Hook::apply_filters('sanitize_file_name', $filename, $filename_raw);
    }
    
    
    /**
     * Converts all accent characters to ASCII characters.
     *
     * If there are no accent characters, then the string given is just returned.
     *
     * @since 3.2.0
     *
     * @param string $string Text that might have accent characters
     * @return string Filtered string with replaced "nice" characters.
     */
    public static function remove_accents($string) {
        if ( !preg_match('/[\x80-\xff]/', $string) ) {
            return $string;
        }
    
        if (self::seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
                chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
                chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
                chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
                chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
                chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
                chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
                chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
                chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
                chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
                chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
                chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
                chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
                chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
                chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
                chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
                chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
                chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
                chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
                chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
                chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
                chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
                chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
                chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
                chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
                chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
                chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
                chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
                chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
                chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
                chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
                chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
                // Decompositions for Latin Extended-A
                chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
                chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
                chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
                chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
                chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
                chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
                chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
                chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
                chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
                chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
                chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
                chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
                chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
                chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
                chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
                chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
                chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
                chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
                chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
                chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
                chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
                chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
                chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
                chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
                chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
                chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
                chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
                chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
                chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
                chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
                chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
                chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
                chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
                chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
                chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
                chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
                chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
                chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
                chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
                chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
                chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
                chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
                chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
                chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
                chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
                chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
                chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
                chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
                chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
                chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
                chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
                chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
                chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
                chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
                chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
                chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
                chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
                chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
                chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
                chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
                chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
                chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
                chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
                chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
                // Decompositions for Latin Extended-B
                chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
                chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
                // Euro Sign
                chr(226).chr(130).chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194).chr(163) => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
                chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
                // grave accent
                chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
                chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
                chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
                chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
                chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
                chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
                chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
                // hook
                chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
                chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
                chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
                chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
                chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
                chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
                chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
                chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
                chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
                chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
                chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
                chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
                // tilde
                chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
                chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
                chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
                chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
                chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
                chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
                chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
                chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
                // acute accent
                chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
                chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
                chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
                chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
                chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
                chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
                // dot below
                chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
                chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
                chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
                chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
                chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
                chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
                chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
                chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
                chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
                chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
                chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
                chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                chr(201).chr(145) => 'a',
                // macron
                chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
                // acute accent
                chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
                // caron
                chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
                chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
                chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
                chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
                chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
                // grave accent
                chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
            );
    
            // Used for locale-specific rules
            $locale = RC_Locale::get_locale();
    
            if ( 'de_DE' == $locale ) {
                $chars[ chr(195).chr(132) ] = 'Ae';
                $chars[ chr(195).chr(164) ] = 'ae';
                $chars[ chr(195).chr(150) ] = 'Oe';
                $chars[ chr(195).chr(182) ] = 'oe';
                $chars[ chr(195).chr(156) ] = 'Ue';
                $chars[ chr(195).chr(188) ] = 'ue';
                $chars[ chr(195).chr(159) ] = 'ss';
            } elseif ( 'da_DK' === $locale ) {
                $chars[ chr(195).chr(134) ] = 'Ae';
                $chars[ chr(195).chr(166) ] = 'ae';
                $chars[ chr(195).chr(152) ] = 'Oe';
                $chars[ chr(195).chr(184) ] = 'oe';
                $chars[ chr(195).chr(133) ] = 'Aa';
                $chars[ chr(195).chr(165) ] = 'aa';
            }
    
            $string = strtr($string, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
            .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
            .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
            .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
            .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
            .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
            .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
            .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
            .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
            .chr(252).chr(253).chr(255);
    
            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
    
            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }
    
        return $string;
    }
    
    
    /**
     * Checks to see if a string is utf8 encoded.
     *
     * NOTE: This function checks for 5-Byte sequences, UTF8
     *       has Bytes Sequences with a maximum length of 4.
     *
     * @author bmorel at ssi dot fr (modified)
     * @since 3.2.0
     *
     * @param string $str The string to be checked
     * @return bool True if $str fits a UTF-8 model, false otherwise.
     */
    public static function seems_utf8($str) {
        $length = strlen($str);
        for ($i=0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80) $n = 0; # 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
            elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
            elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
            elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
            elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
            else return false; # Does not match any model
            for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }
    
    
    
    /**
     * Sanitizes an HTML classname to ensure it only contains valid characters.
     *
     * Strips the string down to A-Z,a-z,0-9,_,-. If this results in an empty
     * string then it will return the alternative value supplied.
     *
     * @todo Expand to support the full range of CDATA that a class attribute can contain.
     *
     * @since 3.2.0
     *
     * @param string $class The classname to be sanitized
     * @param string $fallback Optional. The value to return if the sanitization ends up as an empty string.
     * 	Defaults to an empty string.
     * @return string The sanitized value
     */
    public static function sanitize_html_class( $class, $fallback = '' ) {
        //Strip out any % encoded octets
        $sanitized = preg_replace( '|%[a-fA-F0-9][a-fA-F0-9]|', '', $class );
    
        //Limit to A-Z,a-z,0-9,_,-
        $sanitized = preg_replace( '/[^A-Za-z0-9_-]/', '', $sanitized );
    
        if ( '' == $sanitized ) {
            $sanitized = $fallback;
        }
    
        /**
         * Filter a sanitized HTML class string.
         *
         * @since 3.2.0
         *
         * @param string $sanitized The sanitized HTML class.
         * @param string $class     HTML class before sanitization.
         * @param string $fallback  The fallback string.
         */
        return RC_Hook::apply_filters( 'sanitize_html_class', $sanitized, $class, $fallback );
    }
    
    
    
    /**
     * URL过滤
     * @param   string  $url  参数字符串，一个urld地址,对url地址进行校正
     * @return  返回校正过的url;
     */
    public static function sanitize_url($url , $check = 'http://')
    {
        if (strpos( $url, $check ) === false) {
            $url = $check . $url;
        }
        return $url;
    }
    
    
    /**
     * Sanitizes a string key.
     *
     * Keys are used as internal identifiers. Lowercase alphanumeric characters, dashes and underscores are allowed.
     *
     * @since 3.0.0
     *
     * @param string $key String key
     * @return string Sanitized key
     */
    public static function sanitize_key( $key ) {
        $raw_key = $key;
        $key = strtolower( $key );
        $key = preg_replace( '/[^a-z0-9_\-]/', '', $key );
    
        /**
         * Filter a sanitized key string.
         *
         * @since 3.0.0
         *
         * @param string $key     Sanitized key.
         * @param string $raw_key The key prior to sanitization.
        */
        return RC_Hook::apply_filters( 'sanitize_key', $key, $raw_key );
    }
    
    /**
     * Strips out all characters that are not allowable in an email.
     *
     * @since 1.5.0
     *
     * @param string $email Email address to filter.
     * @return string Filtered email address.
     */
    public static function sanitize_email( $email ) {
        // Test for the minimum length the email can be
        if ( strlen( $email ) < 3 ) {
            /**
             * Filter a sanitized email address.
             *
             * This filter is evaluated under several contexts, including 'email_too_short',
             * 'email_no_at', 'local_invalid_chars', 'domain_period_sequence', 'domain_period_limits',
             * 'domain_no_periods', 'domain_no_valid_subs', or no context.
             *
             * @since 2.8.0
             *
             * @param string $email   The sanitized email address.
             * @param string $email   The email address, as provided to sanitize_email().
             * @param string $message A message to pass to the user.
             */
            return RC_Hook::apply_filters( 'sanitize_email', '', $email, 'email_too_short' );
        }
    
        // Test for an @ character after the first position
        if ( strpos( $email, '@', 1 ) === false ) {
            /** This filter is documented in wp-includes/formatting.php */
            return RC_Hook::apply_filters( 'sanitize_email', '', $email, 'email_no_at' );
        }
    
        // Split out the local and domain parts
        list( $local, $domain ) = explode( '@', $email, 2 );
    
        // LOCAL PART
        // Test for invalid characters
        $local = preg_replace( '/[^a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]/', '', $local );
        if ( '' === $local ) {
            /** This filter is documented in wp-includes/formatting.php */
            return RC_Hook::apply_filters( 'sanitize_email', '', $email, 'local_invalid_chars' );
        }
    
        // DOMAIN PART
        // Test for sequences of periods
        $domain = preg_replace( '/\.{2,}/', '', $domain );
        if ( '' === $domain ) {
            /** This filter is documented in wp-includes/formatting.php */
            return RC_Hook::apply_filters( 'sanitize_email', '', $email, 'domain_period_sequence' );
        }
    
        // Test for leading and trailing periods and whitespace
        $domain = trim( $domain, " \t\n\r\0\x0B." );
        if ( '' === $domain ) {
            /** This filter is documented in wp-includes/formatting.php */
            return RC_Hook::apply_filters( 'sanitize_email', '', $email, 'domain_period_limits' );
        }
    
        // Split the domain into subs
        $subs = explode( '.', $domain );
    
        // Assume the domain will have at least two subs
        if ( 2 > count( $subs ) ) {
            /** This filter is documented in wp-includes/formatting.php */
            return RC_Hook::apply_filters( 'sanitize_email', '', $email, 'domain_no_periods' );
        }
    
        // Create an array that will contain valid subs
        $new_subs = array();
    
        // Loop through each sub
        foreach ( $subs as $sub ) {
            // Test for leading and trailing hyphens
            $sub = trim( $sub, " \t\n\r\0\x0B-" );
    
            // Test for invalid characters
            $sub = preg_replace( '/[^a-z0-9-]+/i', '', $sub );
    
            // If there's anything left, add it to the valid subs
            if ( '' !== $sub ) {
                $new_subs[] = $sub;
            }
        }
    
        // If there aren't 2 or more valid subs
        if ( 2 > count( $new_subs ) ) {
            /** This filter is documented in wp-includes/formatting.php */
            return RC_Hook::apply_filters( 'sanitize_email', '', $email, 'domain_no_valid_subs' );
        }
    
        // Join valid subs into the new domain
        $domain = join( '.', $new_subs );
    
        // Put the email back together
        $email = $local . '@' . $domain;
    
        // Congratulations your email made it!
        /** This filter is documented in wp-includes/formatting.php */
        return RC_Hook::apply_filters( 'sanitize_email', $email, $email, null );
    }
    
    
    /**
     * Check whether serialized data is of string type.
     *
     * @since 2.0.5
     *
     * @param string $data Serialized data.
     * @return bool False if not a serialized string, true if it is.
     */
    public static function is_serialized_string( $data ) {
        // if it isn't a string, it isn't a serialized string.
        if ( ! is_string( $data ) ) {
            return false;
        }
        $data = trim( $data );
        if ( strlen( $data ) < 4 ) {
            return false;
        } elseif ( ':' !== $data[1] ) {
            return false;
        } elseif ( ';' !== substr( $data, -1 ) ) {
            return false;
        } elseif ( $data[0] !== 's' ) {
            return false;
        } elseif ( '"' !== substr( $data, -2, 1 ) ) {
            return false;
        } else {
            return true;
        }
    }
    
    
    /**
     * Serialize data, if needed.
     *
     * @since 2.0.5
     *
     * @param string|array|object $data Data that might be serialized.
     * @return mixed A scalar data
     */
    public static function maybe_serialize( $data ) {
        if ( is_array( $data ) || is_object( $data ) ) {
            return serialize( $data );
        }
    
        // Double serialization is required for backward compatibility.
        // See http://core.trac.wordpress.org/ticket/12930
        if ( self::is_serialized( $data, false ) ) {
            return serialize( $data );
        }
    
        return $data;
    }
    
    
    /**
     * Unserialize value only if it was serialized.
     *
     * @since 2.0.0
     *
     * @param string $original Maybe unserialized original, if is needed.
     * @return mixed Unserialized data can be any type.
     */
    public static function maybe_unserialize( $original ) {
        // don't attempt to unserialize data that wasn't serialized going in
        if ( self::is_serialized( $original ) ) {
            return @unserialize( $original );
        }
        return $original;
    }
    
    
    /**
     * Check value to find if it was serialized.
     *
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     *
     * @since 2.0.5
     *
     * @param string $data   Value to check to see if was serialized.
     * @param bool   $strict Optional. Whether to be strict about the end of the string. Default true.
     * @return bool False if not serialized and true if it was.
     */
    public static function is_serialized( $data, $strict = true ) {
        // if it isn't a string, it isn't serialized.
        if ( ! is_string( $data ) ) {
            return false;
        }
        $data = trim( $data );
        if ( 'N;' == $data ) {
            return true;
        }
        if ( strlen( $data ) < 4 ) {
            return false;
        }
        if ( ':' !== $data[1] ) {
            return false;
        }
        if ( $strict ) {
            $lastc = substr( $data, -1 );
            if ( ';' !== $lastc && '}' !== $lastc ) {
                return false;
            }
        } else {
            $semicolon = strpos( $data, ';' );
            $brace     = strpos( $data, '}' );
            // Either ; or } must exist.
            if ( false === $semicolon && false === $brace )
                return false;
            // But neither must be in the first X characters.
            if ( false !== $semicolon && $semicolon < 3 )
                return false;
            if ( false !== $brace && $brace < 4 )
                return false;
        }
        $token = $data[0];
        switch ( $token ) {
        	case 's' :
        	    if ( $strict ) {
        	        if ( '"' !== substr( $data, -2, 1 ) ) {
        	            return false;
        	        }
        	    } elseif ( false === strpos( $data, '"' ) ) {
        	        return false;
        	    }
        	    // or else fall through
        	case 'a' :
        	case 'O' :
        	    return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
        	case 'b' :
        	case 'i' :
        	case 'd' :
        	    $end = $strict ? '$' : '';
        	    return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
        }
        return false;
    }
    
    public static function removeEmoji($text) {
    
        $clean_text = "";
    
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);
    
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
    
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
    
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
    
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
    
        return $clean_text;
    }
    
    public static function filterEmoji($str)
    {
        $str = preg_replace_callback( '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);
    
        return $str;
    }
}

// end
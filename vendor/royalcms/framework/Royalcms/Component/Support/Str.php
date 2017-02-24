<?php namespace Royalcms\Component\Support;

class Str {

	/**
	 * The registered string macros.
	 *
	 * @var array
	 */
	protected static $macros = array();

	/**
	 * Transliterate a UTF-8 value to ASCII.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function ascii($value)
	{
		return \Patchwork\Utf8::toAscii($value);
	}

	/**
	 * Convert a value to camel case.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function camel($value)
	{
		return lcfirst(static::studly($value));
	}

	/**
	 * Determine if a given string contains a given substring.
	 *
	 * @param  string  $haystack
	 * @param  string|array  $needles
	 * @return bool
	 */
	public static function contains($haystack, $needles)
	{
		foreach ((array) $needles as $needle)
		{
			if ($needle != '' && strpos($haystack, $needle) !== false) return true;
		}

		return false;
	}

	/**
	 * Determine if a given string ends with a given substring.
	 *
	 * @param string  $haystack
	 * @param string|array  $needles
	 * @return bool
	 */
	public static function endsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle)
		{
			if ($needle == substr($haystack, -strlen($needle))) return true;
		}

		return false;
	}

	/**
	 * Cap a string with a single instance of a given value.
	 *
	 * @param  string  $value
	 * @param  string  $cap
	 * @return string
	 */
	public static function finish($value, $cap)
	{
		$quoted = preg_quote($cap, '/');

		return preg_replace('/(?:'.$quoted.')+$/', '', $value).$cap;
	}

	/**
	 * Determine if a given string matches a given pattern.
	 *
	 * @param  string  $pattern
	 * @param  string  $value
	 * @return bool
	 */
	public static function is($pattern, $value)
	{
		if ($pattern == $value) return true;

		$pattern = preg_quote($pattern, '#');

		// Asterisks are translated into zero-or-more regular expression wildcards
		// to make it convenient to check if the strings starts with the given
		// pattern such as "library/*", making any string check convenient.
		$pattern = str_replace('\*', '.*', $pattern).'\z';

		return (bool) preg_match('#^'.$pattern.'#', $value);
	}

	/**
	 * Return the length of the given string.
	 *
	 * @param  string  $value
	 * @return int
	 */
	public static function length($value)
	{
		return mb_strlen($value);
	}

	/**
	 * Limit the number of characters in a string.
	 *
	 * @param  string  $value
	 * @param  int     $limit
	 * @param  string  $end
	 * @return string
	 */
	public static function limit($value, $limit = 100, $end = '...')
	{
		if (mb_strlen($value) <= $limit) return $value;

		return rtrim(mb_substr($value, 0, $limit, 'UTF-8')).$end;
	}

	/**
	 * Convert the given string to lower-case.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function lower($value)
	{
		return mb_strtolower($value);
	}

	/**
	 * Limit the number of words in a string.
	 *
	 * @param  string  $value
	 * @param  int     $words
	 * @param  string  $end
	 * @return string
	 */
	public static function words($value, $words = 100, $end = '...')
	{
		preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);

		if ( ! isset($matches[0])) return $value;

		if (strlen($value) == strlen($matches[0])) return $value;

		return rtrim($matches[0]).$end;
	}

	/**
	 * Parse a Class@method style callback into class and method.
	 *
	 * @param  string  $callback
	 * @param  string  $default
	 * @return array
	 */
	public static function parseCallback($callback, $default)
	{
		return static::contains($callback, '@') ? explode('@', $callback, 2) : array($callback, $default);
	}

	/**
	 * Get the plural form of an English word.
	 *
	 * @param  string  $value
	 * @param  int  $count
	 * @return string
	 */
	public static function plural($value, $count = 2)
	{
		return Pluralizer::plural($value, $count);
	}

	/**
	 * Generate a more truly "random" alpha-numeric string.
	 *
	 * @param  int     $length
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	public static function random($length = 16)
	{
		if (function_exists('openssl_random_pseudo_bytes'))
		{
			$bytes = openssl_random_pseudo_bytes($length * 2);

			if ($bytes === false)
			{
				throw new \RuntimeException('Unable to generate random string.');
			}

			return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
		}

		return static::quickRandom($length);
	}

	/**
	 * Generate a "random" alpha-numeric string.
	 *
	 * Should not be considered sufficient for cryptography, etc.
	 *
	 * @param  int     $length
	 * @return string
	 */
	public static function quickRandom($length = 16)
	{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
	}

	/**
	 * Convert the given string to upper-case.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function upper($value)
	{
		return mb_strtoupper($value);
	}

	/**
	 * Convert the given string to title case.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function title($value)
	{
		return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
	}

	/**
	 * Get the singular form of an English word.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function singular($value)
	{
		return Pluralizer::singular($value);
	}

	/**
	 * Generate a URL friendly "slug" from a given string.
	 *
	 * @param  string  $title
	 * @param  string  $separator
	 * @return string
	 */
	public static function slug($title, $separator = '-')
	{
		$title = static::ascii($title);

		// Convert all dashes/underscores into separator
		$flip = $separator == '-' ? '_' : '-';

		$title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);

		// Remove all characters that are not the separator, letters, numbers, or whitespace.
		$title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($title));

		// Replace all separator characters and whitespace by a single separator
		$title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);

		return trim($title, $separator);
	}

	/**
	 * Convert a string to snake case.
	 *
	 * @param  string  $value
	 * @param  string  $delimiter
	 * @return string
	 */
	public static function snake($value, $delimiter = '_')
	{
		$replace = '$1'.$delimiter.'$2';

		return ctype_lower($value) ? $value : strtolower(preg_replace('/(.)([A-Z])/', $replace, $value));
	}

	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param  string  $haystack
	 * @param  string|array  $needles
	 * @return bool
	 */
	public static function startsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle)
		{
			if ($needle != '' && strpos($haystack, $needle) === 0) return true;
		}

		return false;
	}

	/**
	 * Convert a value to studly caps case.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public static function studly($value)
	{
		$value = ucwords(str_replace(array('-', '_'), ' ', $value));

		return str_replace(' ', '', $value);
	}

	/**
	 * Register a custom string macro.
	 *
	 * @param  string    $name
	 * @param  callable  $macro
	 * @return void
	 */
	public static function macro($name, $macro)
	{
		static::$macros[$name] = $macro;
	}

	/**
	 * Dynamically handle calls to the string class.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 *
	 * @throws \BadMethodCallException
	 */
	public static function __callStatic($method, $parameters)
	{
		if (isset(static::$macros[$method]))
		{
			return call_user_func_array(static::$macros[$method], $parameters);
		}

		throw new \BadMethodCallException("Method {$method} does not exist.");
	}
	
	
	/**
	 * 字符截取 支持UTF8/GBK
	 *
	 * @param string $string
	 * @param integer $length
	 * @param string $dot
	 */
	public static function str_cut($string, $length, $dot = '...')
	{
	    return self::limit($string, $length, $dot);
	    
// 	    $strlen = strlen($string);
// 	    if ($strlen <= $length)
// 	        return $string;
// 	    $string = str_replace(array(
// 	        '&nbsp;',
// 	        '&amp;',
// 	        '&quot;',
// 	        '&#039;',
// 	        '&ldquo;',
// 	        '&rdquo;',
// 	        '&mdash;',
// 	        '&lt;',
// 	        '&gt;',
// 	        '&middot;',
// 	        '&hellip;'
// 	    ), array(
// 	        ' ',
// 	        '&',
// 	        '"',
// 	        "'",
// 	        '“',
// 	        '”',
// 	        '—',
// 	        '<',
// 	        '>',
// 	        '·',
// 	        '…'
// 	    ), $string);
// 	    $strcut = '';
// 	    if (strtolower(RC_CHARSET) == 'utf-8') {
// 	        $n = $tn = $noc = 0;
// 	        while ($n < $strlen) {
// 	            $t = ord($string[$n]);
// 	            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
// 	                $tn = 1;
// 	                $n ++;
// 	                $noc ++;
// 	            } elseif (194 <= $t && $t <= 223) {
// 	                $tn = 2;
// 	                $n += 2;
// 	                $noc += 2;
// 	            } elseif (224 <= $t && $t < 239) {
// 	                $tn = 3;
// 	                $n += 3;
// 	                $noc += 2;
// 	            } elseif (240 <= $t && $t <= 247) {
// 	                $tn = 4;
// 	                $n += 4;
// 	                $noc += 2;
// 	            } elseif (248 <= $t && $t <= 251) {
// 	                $tn = 5;
// 	                $n += 5;
// 	                $noc += 2;
// 	            } elseif ($t == 252 || $t == 253) {
// 	                $tn = 6;
// 	                $n += 6;
// 	                $noc += 2;
// 	            } else {
// 	                $n ++;
// 	            }
// 	            if ($noc >= $length)
// 	                break;
// 	        }
// 	        if ($noc > $length)
// 	            $n -= $tn;
// 	        $strcut = substr($string, 0, $n);
// 	    } else {
// 	        $dotlen = strlen($dot);
// 	        $maxi = $length - $dotlen - 1;
// 	        for ($i = 0; $i < $maxi; $i ++) {
// 	            $strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++ $i] : $string[$i];
// 	        }
// 	    }
// 	    $strcut = str_replace(array(
// 	        '&',
// 	        '"',
// 	        "'",
// 	        '<',
// 	        '>'
// 	    ), array(
// 	        '&amp;',
// 	        '&quot;',
// 	        '&#039;',
// 	        '&lt;',
// 	        '&gt;'
// 	    ), $strcut);
// 	    return $strcut . $dot;
	}
	
	/**
	 * 查询字符是否存在于某字符串
	 *
	 * @param $haystack 字符串
	 * @param $needle 要查找的字符
	 * @return bool
	 */
	public static function str_exists($haystack, $needle)
	{
	    return ! (strpos($haystack, $needle) === FALSE);
	}
	
	/**
	 * unicode转字符串
	 *
	 * @param string $uncode
	 * @return mixed
	 */
	public static function unicode2string($uncode)
	{
	    $uncode = str_replace('u', '\u', $uncode);
	    return json_decode('"' . $uncode . '"');
	}
	
	/**
	 * 转换为unicode
	 *
	 * @param string $word
	 * @return mixed
	 */
	public static function unicode_encode($word)
	{
	    $word0 = iconv('gbk', 'utf-8', $word);
	    $word1 = iconv('utf-8', 'gbk', $word0);
	    $word = ($word1 == $word) ? $word0 : $word;
	    $word = json_encode($word);
	    $word = preg_replace_callback('/\\\\u(\w{4})/', create_function('$hex', 'return \'&#\'.hexdec($hex[1]).\';\';'), substr($word, 1, strlen($word) - 2));
	    return $word;
	}
	
	/**
	 * unicode解析
	 *
	 * @param string $uncode
	 * @return mixed
	 */
	public static function unicode_decode($uncode)
	{
	    $word = json_decode(preg_replace_callback('/&#(\d{5});/', create_function('$dec', 'return \'\\u\'.dechex($dec[1]);'), '"' . $uncode . '"'));
	    return $word;
	}
	
	/**
	 * 计算字符串的长度（汉字按照两个字符计算）
	 *
	 * @param string $str 字符串
	 *
	 * @return int
	 */
	public static function str_len($str)
	{
	    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
	
	    if ($length) {
	        return strlen($str) - $length + intval($length / 3) * 2;
	    } else {
	        return strlen($str);
	    }
	}
	
	/**
	 * 截取UTF-8编码下字符串的函数
	 *
	 * @param string $str 被截取的字符串
	 * @param int $length 截取的长度
	 * @param bool $append 是否附加省略号
	 *
	 * @return string
	 */
	public static function sub_str($str, $length = 0, $append = true)
	{
	    $str = trim($str);
	    $strlength = strlen($str);
	
	    if ($length == 0 || $length >= $strlength) {
	        return $str;
	    } elseif ($length < 0) {
	        $length = $strlength + $length;
	        if ($length < 0) {
	            $length = $strlength;
	        }
	    }
	
	    if (function_exists('mb_substr')) {
	        $newstr = mb_substr($str, 0, $length, RC_CHARSET);
	    } elseif (function_exists('iconv_substr')) {
	        $newstr = iconv_substr($str, 0, $length, RC_CHARSET);
	    } else {
	        // $newstr = trim_right(substr($str, 0, $length));
	        $newstr = substr($str, 0, $length);
	    }
	
	    if ($append && $str != $newstr) {
	        $newstr .= '...';
	    }
	
	    return $newstr;
	}
	
	/**
	 * 将default.abc类的字符串转为$default['abc']
	 *
	 * @author Garbin
	 * @param string $str
	 * @return string
	 */
	public static function str_to_key($str, $owner = '')
	{
	    if (! $str) {
	        return '';
	    }
	    if ($owner) {
	        return $owner . '[\'' . str_replace('.', '\'][\'', $str) . '\']';
	    } else {
	        $parts = explode('.', $str);
	        $owner = '$' . $parts[0];
	        unset($parts[0]);
	        return self::str_to_key(implode('.', $parts), $owner);
	    }
	}

}

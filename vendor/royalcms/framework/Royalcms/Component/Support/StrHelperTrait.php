<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/15
 * Time: 2:33 PM
 */

namespace Royalcms\Component\Support;

trait StrHelperTrait
{

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
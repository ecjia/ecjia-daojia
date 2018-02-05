<?php

namespace Royalcms\Component\Convert;

if (defined('CODE_TABLE_DIR')) define('CODE_TABLE_DIR', dirname(__FILE__) . DS . 'encoding' . DS);

/**
 * 编码转换类
 *
 * @author royalwang
 *        
 */
class Charset
{

    private static $UC2GBTABLE = null;

    private static $CODETABLE = null;

    private static $BIG5_DATA = null;

    private static $GB_DATA = null;

    /**
     * UTF8转GBK编码
     *
     * @param unknown $utfstr            
     * @return string
     */
    public static function utf8_to_gbk($utfstr)
    {
        $okstr = '';
        if (empty(self::$UC2GBTABLE)) {
            $filename = CODE_TABLE_DIR . 'gb-unicode.table';
            $fp = fopen($filename, 'rb');
            while ((bool) ($l = fgets($fp, 15))) {
                self::$UC2GBTABLE[hexdec(substr($l, 7, 6))] = hexdec(substr($l, 0, 6));
            }
            fclose($fp);
        }
        
        $okstr = '';
        $ulen = strlen($utfstr);
        for ($i = 0; $i < $ulen; $i ++) {
            $c = $utfstr[$i];
            $cb = decbin(ord($utfstr[$i]));
            if (strlen($cb) == 8) {
                $csize = strpos(decbin(ord($cb)), '0');
                for ($j = 0; $j < $csize; $j ++) {
                    $i ++;
                    $c .= $utfstr[$i];
                }
                $c = self::utf8_to_unicode($c);
                if (isset(self::$UC2GBTABLE[$c])) {
                    $c = dechex(self::$UC2GBTABLE[$c] + 0x8080);
                    $okstr .= chr(hexdec($c[0] . $c[1])) . chr(hexdec($c[2] . $c[3]));
                } else {
                    $okstr .= '&#' . $c . ';';
                }
            } else {
                $okstr .= $c;
            }
        }
        $okstr = trim($okstr);
        return $okstr;
    }

    /**
     * GBK转UTF8编码
     *
     * @param unknown $gbstr            
     * @return string
     */
    public static function gbk_to_utf8($gbstr)
    {
        if (empty(self::$CODETABLE)) {
            $filename = CODE_TABLE_DIR . 'gb-unicode.table';
            $fp = fopen($filename, 'rb');
            while ((bool) ($l = fgets($fp, 15))) {
                self::$CODETABLE[hexdec(substr($l, 0, 6))] = substr($l, 7, 6);
            }
            fclose($fp);
        }
        $ret = '';
        $utf8 = '';
        while ($gbstr) {
            if (ord(substr($gbstr, 0, 1)) > 0x80) {
                $thisW = substr($gbstr, 0, 2);
                $gbstr = substr($gbstr, 2, strlen($gbstr));
                $utf8 = '';
                @$utf8 = self::unicode_to_utf8(hexdec(self::$CODETABLE[hexdec(bin2hex($thisW)) - 0x8080]));
                if ($utf8 != '') {
                    for ($i = 0; $i < strlen($utf8); $i += 3)
                        $ret .= chr(substr($utf8, $i, 3));
                }
            } else {
                $ret .= substr($gbstr, 0, 1);
                $gbstr = substr($gbstr, 1, strlen($gbstr));
            }
        }
        return $ret;
    }

    /**
     * BIG5转GBK编码
     *
     * @param unknown $text            
     * @return string
     */
    public static function big5_to_gbk($text)
    {
        if (empty(self::$BIG5_DATA)) {
            $filename = CODE_TABLE_DIR . 'big5-gb.table';
            $fp = fopen($filename, 'rb');
            self::$BIG5_DATA = fread($fp, filesize($filename));
            fclose($fp);
        }
        $max = strlen($text) - 1;
        for ($i = 0; $i < $max; $i ++) {
            $h = ord($text[$i]);
            if ($h >= 0x80) {
                $l = ord($text[$i + 1]);
                if ($h == 161 && $l == 64) {
                    $gbstr = '　';
                } else {
                    $p = ($h - 160) * 510 + ($l - 1) * 2;
                    $gbstr = self::$BIG5_DATA[$p] . self::$BIG5_DATA[$p + 1];
                }
                $text[$i] = $gbstr[0];
                $text[$i + 1] = $gbstr[1];
                $i ++;
            }
        }
        return $text;
    }

    /**
     * GBK转BIG5编码
     *
     * @param unknown $text            
     * @return string
     */
    public static function gbk_to_big5($text)
    {
        if (empty(self::$GB_DATA)) {
            $filename = CODE_TABLE_DIR . 'gb-big5.table';
            $fp = fopen($filename, 'rb');
            self::$GB_DATA = fread($fp, filesize($filename));
            fclose($fp);
        }
        $max = strlen($text) - 1;
        for ($i = 0; $i < $max; $i ++) {
            $h = ord($text[$i]);
            if ($h >= 0x80) {
                $l = ord($text[$i + 1]);
                if ($h == 161 && $l == 64) {
                    $big = '　';
                } else {
                    $p = ($h - 160) * 510 + ($l - 1) * 2;
                    $big = self::$GB_DATA[$p] . self::$GB_DATA[$p + 1];
                }
                $text[$i] = $big[0];
                $text[$i + 1] = $big[1];
                $i ++;
            }
        }
        return $text;
    }

    /**
     * UNICODE转UTF8编码
     *
     * @param unknown $c            
     * @return Ambigous <string, boolean, unknown>
     */
    public static function unicode_to_utf8($c)
    {
        $str = '';
        if ($c < 0x80) {
            $str .= $c;
        } elseif ($c < 0x800) {
            $str .= (0xC0 | $c >> 6);
            $str .= (0x80 | $c & 0x3F);
        } elseif ($c < 0x10000) {
            $str .= (0xE0 | $c >> 12);
            $str .= (0x80 | $c >> 6 & 0x3F);
            $str .= (0x80 | $c & 0x3F);
        } elseif ($c < 0x200000) {
            $str .= (0xF0 | $c >> 18);
            $str .= (0x80 | $c >> 12 & 0x3F);
            $str .= (0x80 | $c >> 6 & 0x3F);
            $str .= (0x80 | $c & 0x3F);
        }
        return $str;
    }

    /**
     * UTF8转UNICODE编码
     *
     * @param unknown $c            
     * @return number boolean
     */
    public static function utf8_to_unicode($c)
    {
        switch (strlen($c)) {
            case 1:
                return ord($c);
            case 2:
                $n = (ord($c[0]) & 0x3f) << 6;
                $n += ord($c[1]) & 0x3f;
                return $n;
            case 3:
                $n = (ord($c[0]) & 0x1f) << 12;
                $n += (ord($c[1]) & 0x3f) << 6;
                $n += ord($c[2]) & 0x3f;
                return $n;
            case 4:
                $n = (ord($c[0]) & 0x0f) << 18;
                $n += (ord($c[1]) & 0x3f) << 12;
                $n += (ord($c[2]) & 0x3f) << 6;
                $n += ord($c[3]) & 0x3f;
                return $n;
        }
    }
    
    
    /**
     * 实现多种字符编码方式
     * @param $input 需要编码的字符串
     * @param $_output_charset 输出的编码格式
     * @param $_input_charset 输入的编码格式
     * return 编码后的字符串
     */
    public static function charset_encode($input, $_output_charset, $_input_charset) {
        $output = "";
        if (!isset($_output_charset)){
            $_output_charset  = $_input_charset;
        }
        if ($_input_charset == $_output_charset || $input == null) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset, $_output_charset, $input);
        } else {
            die("sorry, you have no libs support for charset change.");
        }
        return $output;
    }
    
    
    /**
     * 实现多种字符解码方式
     * @param $input 需要解码的字符串
     * @param $_output_charset 输出的解码格式
     * @param $_input_charset 输入的解码格式
     * return 解码后的字符串
     */
    public static function charset_decode($input, $_input_charset, $_output_charset) {
        $output = "";
        if (!isset($_input_charset)) {
            $_input_charset  = $_output_charset;
        }
        if ($_input_charset == $_output_charset || $input ==null) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input, $_output_charset, $_input_charset);
        } elseif (function_exists("iconv")) {
            $output = iconv($_input_charset, $_output_charset, $input);
        } else {
            die("sorry, you have no libs support for charset changes.");
        }
        return $output;
    }

}

// end
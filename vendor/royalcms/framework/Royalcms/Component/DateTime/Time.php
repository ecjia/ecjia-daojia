<?php namespace Royalcms\Component\DateTime;

use Royalcms\Component\Support\Facades\Hook;

/**
 * 时间处理类
 */
class Time
{

    /**
     * 获得当前格林威治时间的时间戳
     *
     * @return integer
     */
    public static function gmtime()
    {
        return (SYS_TIME - date('Z'));
    }
    
    /**
     * 获得当前格林威治时间的自定义格式时间
     *
     * @param string $format
     *  
     * @return string
     */
    public static function gmdate($format)
    {
        $time = self::gmtime();
        
        return date($format, $time);
    }

    /**
     * 获得服务器的时区
     *
     * @return integer
     */
    public static function server_timezone()
    {
        if (function_exists('date_default_timezone_get')) {
            $timezone = date_default_timezone_get();
        } else {
            $timezone = date('Z') / 3600;
        }
        
        /**
         * Filter the resulting URL after setting the scheme.
         *
         * @since 3.0.0 
         *       
         * @param string $url
         *            The complete URL including scheme and path.
         * @param string $scheme
         *            Scheme applied to the URL. One of 'http', 'https', or 'relative'.
         * @param string $orig_scheme
         *            Scheme requested for the URL. One of 'http', 'https' or 'relative'.
         */
        return Hook::apply_filters('set_server_timezone', $timezone);
    }

    /**
     * 生成一个用户自定义时区日期的GMT时间戳
     *
     * @access public
     * @param int $hour            
     * @param int $minute            
     * @param int $second            
     * @param int $month            
     * @param int $day            
     * @param int $year            
     *
     * @return void
     */
    public static function local_mktime($hour = NULL, $minute = NULL, $second = NULL, $month = NULL, $day = NULL, $year = NULL)
    {
        $timezone = self::server_timezone();
        
        /**
         * $time = mktime($hour, $minute, $second, $month, $day, $year) - date('Z') + (date('Z') - $timezone * 3600)
         * 先用mktime生成时间戳，再减去date('Z')转换为GMT时间，然后修正为用户自定义时间。以下是化简后结果
         */
        $time = mktime($hour, $minute, $second, $month, $day, $year) - $timezone * 3600;
        
        return $time;
    }

    /**
     * 将GMT时间戳格式化为用户自定义时区日期
     *
     * @param string $format            
     * @param integer $time
     *            该参数必须是一个GMT的时间戳
     *            
     * @return string
     */
    public static function local_date($format, $time = null)
    {
        $timezone = self::server_timezone();
        
        if ($time === null) {
            $time = self::gmtime();
        } elseif ($time <= 0) {
            return '';
        }
        
        $time += ($timezone * 3600);
        
        return date($format, $time);
    }
    
    /**
     * 将GMT时间戳格式化为用户自定义时区时间戳
     *
     * @param integer $time
     *            该参数必须是一个GMT的时间戳
     *
     * @return string
     */
    public static function local_time($time = null)
    {
        $timezone = self::server_timezone();
    
        if ($time === null) {
            $time = self::gmtime();
        } elseif ($time <= 0) {
            return '';
        }
    
        $time += ($timezone * 3600);
    
        return $time;
    }

    /**
     * 转换字符串形式的时间表达式为GMT时间戳
     *
     * @param string $str            
     *
     * @return integer
     */
    public static function gmstr2time($str, $now = null)
    {
        if ($now === null) {
            $now = self::gmtime();
        }
        $time = strtotime($str, $now);
        
        if ($time > 0) {
            $time -= date('Z');
        }
        
        return $time;
    }

    /**
     * 将一个用户自定义时区的日期转为GMT时间戳
     *
     * @access public
     * @param string $str            
     *
     * @return integer
     */
    public static function local_strtotime($str, $now = null)
    {
        $timezone = self::server_timezone();
        if ($now === null) {
            $now = self::gmtime();
        }
        /**
         * $time = mktime($hour, $minute, $second, $month, $day, $year) - date('Z') + (date('Z') - $timezone * 3600)
         * 先用mktime生成时间戳，再减去date('Z')转换为GMT时间，然后修正为用户自定义时间。以下是化简后结果
         */
        $time = strtotime($str, $now) - $timezone * 3600;
        
        return $time;
    }

    /**
     * 获得用户所在时区指定的时间戳
     *
     * @param $timestamp integer
     *            该时间戳必须是一个服务器本地的时间戳
     *            
     * @return array
     */
    public static function local_gettime($timestamp = null)
    {
        $tmp = self::local_getdate($timestamp);
        return $tmp[0];
    }

    /**
     * 获得用户所在时区指定的日期和时间信息
     *
     * @param $timestamp integer
     *            该时间戳必须是一个服务器本地的时间戳
     *            
     * @return array
     */
    public static function local_getdate($timestamp = null)
    {
        $timezone = self::server_timezone();
        
        /* 如果时间戳为空，则获得服务器的当前时间 */
        if ($timestamp === null) {
            $timestamp = self::gmtime();
        }
        
        /* 得到该时间的格林威治时间 */ 
        $gmt = $timestamp - date('Z'); 
        /* 转换为用户所在时区的时间戳 */ 
        $local_time = $gmt + ($timezone * 3600); 
        
        return getdate($local_time);
    }
}

// end
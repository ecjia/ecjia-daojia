<?php namespace Royalcms\Component\DateTime;

use RC_Hook;

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
        return RC_Hook::apply_filters('set_server_timezone', $timezone);
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


    /**
     * 根据相差的天数获取所有连续的时间段
     * @param $diffDay
     * @param string $dateFormat
     * @return array
     */
    public static function getContinuesDayDiffDay($diffDay, $dateFormat = 'Y-m-d')
    {
        $today = date('Y-m-d');
        $timeLabel = [];
        for ($i=1;$i<=$diffDay;$i++){
            $diff = $diffDay - $i;
            $mday = date($dateFormat,strtotime("$today -$diff day"));
            array_push($timeLabel,$mday);
        }
        //转化查询条件
        $year = date('Y');
        $startDay = str_replace('.','-',$timeLabel[0]);
        $endDay = str_replace('.','-',$timeLabel[$diffDay-1]);
        $startTime = strtotime($startDay." 00:00:00");
        $endTime = strtotime($endDay." 23:59:59");
        return [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'time_label' => $timeLabel,
        ];
    }

    /**
     * 根据开始和结束时间获取所有连续的时间段
     * @param string $startDay 开始日期 格式：Y-m-d
     * @param string $endDay 开始日期 格式：Y-m-d
     * @param string $dateFormat
     * @return array
     */
    public static function getContinuesDayByRange($startDay, $endDay, $dateFormat = 'Y-m-d')
    {
        $timeLabel = [];
        if (strtotime($startDay) > strtotime($endDay)) {
            $tmp = $startDay;
            $endDay = $tmp;
            $startDay = $endDay;
        }
        if ($startDay == $endDay) {
            array_push($timeLabel,$startDay);

            $startTime = strtotime($startDay." 00:00:00");
            $endTime = strtotime($endDay." 23:59:59");
            $timeLabel =  [
                'start_time' => $startTime,
                'end_time' => $endTime,
                'time_label' => $timeLabel,
            ];
            return $timeLabel;
        }

        $targetDay = $startDay;
        while ($targetDay != $endDay){
            array_push($timeLabel,$targetDay);
            $targetDay = date($dateFormat,strtotime("$targetDay +1 day"));
        }

        array_push($timeLabel,$endDay);

        //增加
        $startTime = strtotime($startDay." 00:00:00");
        $endTime = strtotime($endDay." 23:59:59");
        $timeLabel =  [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'time_label' => $timeLabel,
        ];
        return $timeLabel;
    }

    /**
     * 根据日期获取本月的开始时间和结束时间
     * @param $date   Y-m    2017-10
     * @return array
     */
    public static function getMonthDaysByDate($date)
    {
        $data = [];
        $timestamp = strtotime( $date );
        $data['start_time'] = date( 'Y-m-01 00:00:00', $timestamp );
        $mdays = date( 't', $timestamp );
        $data['end_time'] = date( 'Y-m-' . $mdays . ' 23:59:59', $timestamp );
        return $data;
    }

    /**
     * 获取两个月份之间连续的月份
     * @param $start
     * @param $end
     * @return array
     */
    public static function  prDates($start, $end)
    {
        // 两个日期之间的所有日期
        $time_start = strtotime($start); // 自动为00:00:00 时分秒 两个时间之间的年和月份
        $time_end = strtotime($end);
        $monarr[] = $start; // 当前月;
        while( ($time_start = strtotime('+1 month', $time_start)) <= $time_end){
            array_push($monarr,date('Y-m', $time_start));// 取得递增月
        }
        return $monarr;
    }


    /**
     * 时间友好型提示风格化（即微博中的XXX小时前、昨天等等）
     * 即微博中的 XXX 小时前、昨天等等, 时间超过 $time_limit 后返回按 out_format 的设定风格化时间戳
     * @param  int
     * @param  int
     * @param  string
     * @param  array
     * @param  int
     * @return string
     */
    public static function getFriendlyTime($timestamp, $timeLimit = 604800, $out_format = 'Y/m/d', $formats = null, $now = null)
    {
        /*if (get_setting('time_style') == 'N')
        {
            return date($out_format, $timestamp);
        }*/

        if (!$timestamp)
        {
            return false;
        }

        if ($formats == null)
        {
            $formats = [
                'YEAR' =>'%s 年前',
                'MONTH' => '%s 月前',
                'DAY' => '%s 天前',
                'HOUR' => '%s 小时前',
                'MINUTE' => '%s 分钟前',
                'SECOND' => '%s 秒前'
            ];
        }

        $now = $now == null ? time() : $now;
        $seconds = $now - $timestamp;

        if ($seconds == 0)
        {
            $seconds = 1;
        }

        if (!$timeLimit OR $seconds > $timeLimit)
        {
            return date($out_format, $timestamp);
        }

        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $months = floor($days / 30);
        $years = floor($months / 12);

        if ($years > 0)
        {
            $diffFormat = 'YEAR';
        }
        else
        {
            if ($months > 0)
            {
                $diffFormat = 'MONTH';
            }
            else
            {
                if ($days > 0)
                {
                    $diffFormat = 'DAY';
                }
                else
                {
                    if ($hours > 0)
                    {
                        $diffFormat = 'HOUR';
                    }
                    else
                    {
                        $diffFormat = ($minutes > 0) ? 'MINUTE' : 'SECOND';
                    }
                }
            }
        }

        $dateDiff = null;

        switch ($diffFormat)
        {
            case 'YEAR' :
                $dateDiff = sprintf($formats[$diffFormat], $years);
                break;
            case 'MONTH' :
                $dateDiff = sprintf($formats[$diffFormat], $months);
                break;
            case 'DAY' :
                $dateDiff = sprintf($formats[$diffFormat], $days);
                break;
            case 'HOUR' :
                $dateDiff = sprintf($formats[$diffFormat], $hours);
                break;
            case 'MINUTE' :
                $dateDiff = sprintf($formats[$diffFormat], $minutes);
                break;
            case 'SECOND' :
                $dateDiff = sprintf($formats[$diffFormat], $seconds);
                break;
        }

        return $dateDiff;
    }


    /**
     * 获取星期几
     * @param $date
     * @return
     */
    public static function getWeekDay($date)
    {
        //强制转换日期格式
        $dateStr=date('Y-m-d',strtotime($date));
        //封装成数组
        $arr=explode("-", $dateStr);
        //参数赋值
        //年
        $year=$arr[0];

        //月，输出2位整型，不够2位右对齐
        $month=sprintf('%02d',$arr[1]);
        //日，输出2位整型，不够2位右对齐
        $day=sprintf('%02d',$arr[2]);

        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;

        //转换成时间戳
        $strap = mktime($hour,$minute,$second,$month,$day,$year);

        //获取数字型星期几
        $numberWk=date("w",$strap);

        //自定义星期数组
        $weekArr=array(7,1,2,3,4,5,6);

        //获取数字对应的星期
        return $weekArr[$numberWk];
    }

    /**
     * 获取指定日期前后相同时间天数的范围时间
     * @param int $dayDiff
     * @param string $day
     * @param string $dateFormat
     * @return array
     */
    public static function getPointDaySameRangeContinuesTime($dayDiff = 0,$day = "", $dateFormat = "Y-m-d")
    {
        $day = $day?$day:date($dateFormat);
        $startTime = date($dateFormat,strtotime("$day -$dayDiff day"));
        $endTime = date($dateFormat,strtotime("$day +$dayDiff day"));
        $result = self::getContinuesDayByRange($startTime,$endTime,$dateFormat = 'Y-m-d');
        return $result;
    }


    /**
     * 获取两个日期之间相差的天数
     * @param string $day1 第一个日期，格式为Y-m-d
     * @param string $day2 第二个日期，格式为Y-m-d
     * @return integer
     */
    public static function getDiffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);
        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }


    /**
     * 根据日期和相差的天数获取结束的天数
     * @param $day
     * @param $diffDay
     * @param bool $isBefore
     * @return false|string
     */
    public static function getEndDayByDayAndDiff($day, $diffDay, $isBefore = false)
    {
        $operator = $isBefore ? "-" : "+";
        $endDay = date('Y-m-d',strtotime("$day $operator $diffDay day"));
        return $endDay;
    }


    /**
     * 根据时间戳返回日期型时间戳
     * @param $time
     * @return int
     */
    public static function dateTime($time)
    {
        return strtotime(date('Y-m-d', $time));
    }

    /**
     * @param $num
     * @return integer
     */
    public static function getFriendlyNumber($num)
    {
        if ($num >= 10000) {
            $num = round($num / 10000 ,1)  .'万';
        }
        return $num;
    }

    /**
     * 判断两个时间是否同一天
     * @param string $date1 Y-m-d
     * @param string $date2 Y-m-d
     * @return bool
     */
    public static function isSameDay($date1, $date2)
    {
        $day1 = self::dateTime(strtotime($date1)) ;
        $day2 = self::dateTime(strtotime($date2));
        return $day1 == $day2;
    }

    /**
     * 转换秒钟为分钟
     * @param $seconds
     * @return string
     */
    public static function convertSecondToTime($seconds)
    {
        $reminded = strval($seconds % 60);
        $minute = strval(($seconds - $reminded) / 60);
        if (strlen($minute) < 2) {
            $minute = '0'.$minute;
        }
        if (strlen($reminded) < 2) {
            $reminded = '0'.$reminded;
        }
        $time = $minute.":".$reminded;
        return $time;
    }

    /**
     * 获取时间的毫秒数
     * @return float
     */
    public static function millisecond()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }

}

// end
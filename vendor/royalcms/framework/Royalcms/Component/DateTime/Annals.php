<?php namespace Royalcms\Component\DateTime;

/**
 * @file
 *
 * 农历公历互转,生肖,星座
 */

class Annals {

    //以1912为公历元年的修正表
    protected static $longlife = array(
        '132637048', '133365036', '053365225', '132900044', '131386034', '022778122', //1912-1917
        '132395041', '071175231', '131175050', '132635038', '052891127', '131701046', //1918-1923
        '131748035', '042741223', '130694043', '132391032', '021327122', '131175040', //1924-1929
        '061623129', '133402047', '133402036', '051769125', '131453044', '130694034', //1930-1935
        '032158223', '132350041', '073213230', '133221049', '133402038', '063466226', //1936-1941
        '132901045', '131130035', '042651224', '130605043', '132349032', '023371121', //1942-1947
        '132709040', '072901128', '131738047', '132901036', '051333226', '131210044', //1948-1953
        '132651033', '031111223', '131323042', '082714130', '133733048', '131706038', //1954-1959
        '062794127', '132741045', '131206035', '042734124', '132647043', '131318032', //1960-1965
        '033878120', '133477039', '071461129', '131386047', '132413036', '051245126', //1966-1971
        '131197045', '132637033', '043405122', '133365041', '083413130', '132900048', //1972-1977
        '132922037', '062394227', '132395046', '131179035', '042711124', '132635043', //1978-1983
        '102855132', '131701050', '131748039', '062804128', '132742047', '132359036', //1984-1989
        '051199126', '131175045', '131611034', '031866122', '133749040', '081717130', //1990-1995
        '131452049', '132742037', '052413127', '132350046', '133222035', '043477123', //1996-2001
        '133402042', '133493031', '021877121', '131386039', '072747128', '130605048', //2002-2007
        '132349037', '053243125', '132709044', '132890033', '042986122', '132901040', //2008-2013
        '091373130', '131210049', '132651038', '061303127', '131323046', '132707035', //2014-2019
        '041941124', '131706042', '132773031',                                        //2020-2022
    );
    
    //获取信息
    public static function getAnnals($year, $month, $day) {
        $return = self::getLunar($year, $month, $day);
        $return['animal'] = self::getAnimal($return['lunar']['year']);
        $return['constellation'] = self::getConstellation($return['gregorian']['month'], $return['gregorian']['day']);
        
        return $return;
    }
    
    /**
     * 根据农历年份获取他的生肖
     *
     * @param int $year
     */
    public static function getAnimal($year) {
        static $animals = array('鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪');
        return $year ? $animals[($year+8)%12] : '';
    }
    
    /**
     * 根据公历月日获取星座
     *
     * @param int $month
     * @param int $day
     */
    public static function getConstellation($month, $day = 1) {
        $constellations = array(
            1  => array(20 => '水瓶座'),
            2  => array(19 => '双鱼座'),
            3  => array(21 => '白羊座'),
            4  => array(20 => '金牛座'),
            5  => array(21 => '双子座'),
            6  => array(22 => '巨蟹座'),
            7  => array(23 => '狮子座'),
            8  => array(23 => '处女座'),
            9  => array(23 => '天秤座'),
            10 => array(24 => '天蝎座'),
            11 => array(23 => '射手座'),
            12 => array(22 => '摩羯座'),            
        );
        if (!$month || $month < 1 || $month > 12) {
            return '';
        }
        list($start, $name) = each($constellations[$month]);
        if ($day < $start) {
            $month--;            
            list($start, $name) = each($constellations[$month ? $month : 12]);
        }
        
        return $name;
    }
    
    /**
     * 获取农历
     */
    public static function getLunar($year, $month, $day) {
        //格式化一下
        $year  = (int) $year;
        $month = (int) $month;
        $day   = (int) $day;
        //返回的结果
        $return = array(
            'gregorian' => array('year'=>$year, 'month'=>$month, 'day'=>$day, 'age'=>''),
            'lunar'     => array('year'=>$year, 'month'=>$month, 'day'=>$day, 'leap'=>false),
        );
        //默认月的天数
        $month_day = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);        
        //非法年份
        if (!$year || !$month || $year < 1912 || $year >= count(self::$longlife) + 1912) {            
            return $return;
        }
        $return['gregorian']['age'] = date('Y') - $year;
        //闰年
        if (self::isLeapYear($year)) {
            $month_day[2] = 29;
        }
        //解析longlife
        $longlife = self::processLonglife($year);
        //计算距离元旦的天数
        $days = 0;
        while (--$month) {
            $days += $month_day[$month];
        }
        $days += $day;
        //如果小于元旦天数差,则为上一年
        if ($days <= $longlife['diff_days']) {
            $year--;
            $days -= $longlife['diff_days'];
            $longlife = self::processLonglife($year);
            for ($i = 12; $i >= 1; $i--) {
                $days += $longlife['month_size'][$i];
                if ($days > 0)  break;
            }
            $return['lunar']['year']  = $year;
            $return['lunar']['month'] = $i;
            $return['lunar']['day']   = $days;
        }
        else {
            $days =  $days - $longlife['diff_days'];
            //顺序减去农历月的天数, 如果有闰月,就减到闰月
            $max = $longlife['leap_month'] > 12 ? 12 : $longlife['leap_month'];
            for ($i = 1; $i <= $max; $i++) {
                $days -= $longlife['month_size'][$i];
                if ($days <= 0) break;
            }
            //没有闰月或闰月之前
            if ($days <= 0) {
                $return['lunar']['year']  = $year;
                $return['lunar']['month'] = $i;
                $return['lunar']['day']   = $days + $longlife['month_size'][$i];
            }
            else {
                $longlife['month_size'][$longlife['leap_month']] = $longlife['leap_days'];
                for ($i = $longlife['leap_month']; $i <= 12; $i++) {
                    $days -= $longlife['month_size'][$i];
                    if ($days <= 0) break;
                }
                $return['lunar']['year']  = $year;
                $return['lunar']['month'] = $i;
                $return['lunar']['day']   = $days + $longlife['month_size'][$i];
                $return['lunar']['leap']  = $i == $longlife['leap_month'];
            }
        }
        
        return $return;
    }
    
    /**
     * 获取公历
     */
    public static function getGregorian($year, $month, $day, $leap = false) {
        //格式化一下
        $year  = (int) $year;
        $month = (int) $month;
        $day   = (int) $day;
        //返回的结果
        $return = array(
            'gregorian' => array('year'=>$year, 'month'=>$month, 'day'=>$day, 'age'=>''),
            'lunar'     => array('year'=>$year, 'month'=>$month, 'day'=>$day, 'leap'=>$leap),
        );
        //默认月的天数
        $month_day = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);        
        //非法年份
        if (!$year || !$month || $year < 1912 || $year >= count(self::$longlife) + 1912) {
            return $return;
        }
        //闰年
        if (self::isLeapYear($year)) {
            $month_day[2] = 29;
        }
        //解析longlife
        $longlife = self::processLonglife($year);
        //累计农历天数
        $days = $day;
        //如果传入的month为负值,则认为是闰月
        if ($month < 0) {
            $month = abs($month);
            $return['lunar']['month'] = $month;
            $return['lunar']['leap']  = true;
        }
        //闰月的话,加上闰的月天数
        if ($return['lunar']['leap']) {
            $days += $longlife['month_size'][$month];
        }
        //累加农历天数
        for ($i = 1; $i < $month; $i++) {
            $days += $longlife['month_size'][$i];
        }
        $days += $longlife['diff_days'];
        //有闰月且大于这个闰月,则加上闰月的天数
        if ($longlife['leap_month'] <= 12 && $month > $longlife['leap_month']) {
            $days += $longlife['leap_days'];
        }
        //累减公历天数
        for ($i = 1; $i <= 12; $i++) {
            $days -= $month_day[$i];
            if ($days <= 0) break;
        }
        //还有剩余天数,则表示下一年
        if ($days > 0) {
            $year++;
            $month_day[2] = self::isLeapYear($year) ? 29 : 28;
            for ($i = 1; $i <= 12; $i++) {
                $days -= $month_day[$i];
                if ($days <= 0) break;
            }
        }
        $return['gregorian']['year']  = $year;
        $return['gregorian']['month'] = $i;
        $return['gregorian']['day']   = $days + $month_day[$i];
        $return['gregorian']['age']   = date('Y') - $year;
        
        return $return;
    }
    
    /**
     * 是否为闰年
     */
    protected static function isLeapYear($year) {
        return ($year % 4 == 0) && (($year % 100 <> 0) || ($year % 400 == 0));
    }
    
    /**
     * 解析longlife字串
     *
     * 1-2 为闰月月份 13为没有闰月
     * 3-6 农历月的大小月二进制转十进制的结果
     * 7   闰月的天数
     * 8-9 公历1月1日与农历1月1日的天数差
     */
    protected static function processLonglife($year) {
        $longlife = array();
        $year     = $year - 1912;
        $string   = self::$longlife[$year];
        //闰月
        $longlife['leap_month'] = (int) substr($string,0,2);
        //大小月
        $month_size = sprintf('%012s', (string) decbin(substr($string,2,4)));
        for ($i = 1; $i <= 12; $i++) {
            $longlife['month_size'][$i] = $month_size[$i-1] + 29;
        }
        //闰月天数
        switch (substr($string,6,1)) {
            case 1:
                $longlife['leap_days'] = 29;
                break;
            case 2:
                $longlife['leap_days'] = 30;
                break;
            default:
                $longlife['leap_days'] = 0;
        }
        //元旦天数差
        $longlife['diff_days'] = (int) substr($string,7,2);
        
        return $longlife;
    }
    
}

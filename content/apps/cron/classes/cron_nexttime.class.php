<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

class cron_nexttime
{
    protected $day;
    protected $week;
    protected $hour;
    protected $minute;
    
    /**
     * 年 1999
     * @var string
     */
    private $now_year;
    
    /**
     * 月 01-12
     * @var string
     */
    private $now_month;
    
    /**
     * 日 01-31
     * @var string
     */
    private $now_day;
    
    /**
     * 周 0-6
     * @var string
     */
    private $now_week;
    
    /**
     * 小时 00-23
     * @var string
     */
    private $now_hour;
    
    /**
     * 分钟 00-59
     * @var string
     */
    private $now_minute;
    
    /**
     * 秒 00-59
     * @var string
     */
    private $now_second;
    
    /**
     * $cron数组元素
     * day 
     * week
     * hour
     * m
     * @param array $cron
     */
    public function __construct(array $cron)
    {
        $this->day    = array_get($cron, 'day', 0);
        $this->week   = array_get($cron, 'week', '');
        $this->hour   = array_get($cron, 'hour', 0);
        $this->minute = array_get($cron, 'm');
        
        $timestamp = RC_Time::gmtime();
        
        $this->now_year   = RC_Time::local_date('Y', $timestamp); // 年 1999
        $this->now_month  = RC_Time::local_date('n', $timestamp); // 月 01-12
        $this->now_day    = RC_Time::local_date('j', $timestamp); // 日 01-31
        $this->now_week   = RC_Time::local_date('w', $timestamp); // 周 0-6
        $this->now_hour   = RC_Time::local_date('G', $timestamp); // 小时 00-23
        $this->now_minute = RC_Time::local_date('i', $timestamp); // 分钟 00-59
        $this->now_second = RC_Time::local_date('s', $timestamp); // 秒 00-59
    }
    
    
    public function everyMonth() 
    {
        $syear 	= $this->now_year;
        $smonth = $this->now_month;
        $sday 	= $this->day;
        $shour 	= $this->hour;
        list($minutes_original, $minutes) = $this->parseMinute();
        
        if($sday < $this->now_day){
        	$smonth = $this->now_month+1;
        }
 
        if ($this->now_day ==$sday && count($minutes) > 0 && $this->now_hour == $this->hour) {
        	$sminute = reset($minutes);
        	$sday = $this->day;
        } else {
        	$sminute = reset($minutes_original);
        	
        	if($this->now_day ==$sday && $shour < $this->now_hour) {
        		$smonth = $this->now_month+1;
        	}
        	
        	if($this->now_day ==$sday && $shour == $this->now_hour && $sminute < $this->now_minute) {
        		$smonth = $this->now_month+1;
        	}
        }

        $ssecond = 0;
        
        return $this->makeDateTime($syear, $smonth, $sday, $shour, $sminute, $ssecond);
    }
    
    
    public function everyWeek()
    {
        $syear  = $this->now_year;
        $smonth = $this->now_month;
        $sday   = $this->now_day + $this->week - $this->now_week + 7;
        $shour  = $this->hour;
        
        list($minutes_original, $minutes) = $this->parseMinute();

        if (count($minutes) > 0 && $this->now_hour == $this->hour) {
            $sminute = reset($minutes);
            
            $sday = $this->now_day;
            
        } else {
            $sminute = reset($minutes_original);
            
            $sday = $this->now_day;
        }
        
        $week_day = $this->week - $this->now_week + 7;
        
        if ($this->week > $this->now_week ) {
            $sday += $this->week - $this->now_week;
            $sminute = reset($minutes_original);
        } 
        elseif ($this->week == $this->now_week) {
            if ($this->hour > $this->now_hour) {
                $sday += $this->week - $this->now_week;
            }
            elseif ($this->hour == $this->now_hour) {
                if ($sminute > $this->now_minute) {
                    
                } 
                else if ($sminute == $this->now_minute) {
                    $sminute = reset($minutes);
                }
                else {
                    $sday += $week_day;
                } 
            }
            else {
                $sday += $week_day;
            }
            
            
        } else {
            $sminute = reset($minutes_original);
            $sday += $week_day;
        }
        
        
        $ssecond = 0;
        
        return $this->makeDateTime($syear, $smonth, $sday, $shour, $sminute, $ssecond);
    }
    
    
    public function everyDay()
    {
        $syear  = $this->now_year;
        $smonth = $this->now_month;
        $sday   = $this->now_day;
        $shour  = $this->hour;
        
        list($minutes_original, $minutes) = $this->parseMinute();
        
        if ($shour < $this->now_hour) {
        	$sday++;
        }
        if (count($minutes) > 0 && $this->now_hour == $this->hour) {
        	$sminute = reset($minutes);
        } else {
            $sminute = reset($minutes_original);
            if($shour == $this->now_hour && $sminute < $this->now_minute) {
            	$sday++;
            }
        }
        
        $ssecond = 0;
        
        return $this->makeDateTime($syear, $smonth, $sday, $shour, $sminute, $ssecond);
    }
    
    protected function parseMinute()
    {
        if ( ! $this->minute) {
            return array(array(0), array());
        }
        
        $marray = $marray_original = explode(',', $this->minute);
        foreach ($marray as $k => $v){
            if ($v <= $this->now_minute){
                unset($marray[$k]);
            }
        }
        
        sort($marray);
        sort($marray_original);
        
        return array($marray_original, $marray);
    }
    
    /**
     * 生成时间
     * 
     * @param string $year
     * @param string $month
     * @param string $day
     * @param string $hour
     * @param string $minute
     * @param string $second
     * @return string
     */
    protected function makeDateTime($year, $month, $day, $hour, $minute, $second)
    {
        $day = intval($day) < 10 ? '0'.$day : $day;
        
        $minute = intval($minute) < 10 ? '0'.$minute : $minute;
        $second = intval($second) < 10 ? '0'.$second : $second;
        
        $time = RC_Time::local_strtotime("$year-$month-$day $hour:$minute:$second");
        return $time;
    }
    
    public function getNextTime()
    {
        if ($this->day && $this->week === '') 
        {
            $nexttime = $this->everyMonth();
        }
        else if ($this->week === '' && empty($this->day))
        {
        	$nexttime = $this->everyDay();
        }  
        else if ($this->week !== '' && empty($this->day)) 
        {
            $nexttime = $this->everyWeek();
        }
        
        return $nexttime;
    }
    
    
    public static function make($cron)
    {
        $instance = new static($cron);
        return $instance;
    }
}

// end
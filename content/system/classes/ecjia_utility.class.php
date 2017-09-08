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
/**
 * ECJIA 管理中心公用函数库
 */
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_utility {
    
    /**
     * 获得系统是否启用了 gzip
     *
     * @access public
     *
     * @return boolean
     */
    
    public static function gzip_enabled($enabled_gzip)
    {
        return ecjia::config('enable_gzip') && $enabled_gzip;
    }
    
    /**
     * 判断是否为搜索引擎蜘蛛
     *
     * @access public
     * @return string
     */
    public static function is_spider($record = true)
    {
        static $spider = null;
    
        if ($spider !== null) {
            return $spider;
        }
    
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $spider = '';
            return false;
        }
    
        $searchengine_bot = array(
            'googlebot',
            'mediapartners-google',
            'baiduspider+',
            'msnbot',
            'yodaobot',
            'yahoo! slurp;',
            'yahoo! slurp china;',
            'iaskspider',
            'sogou web spider',
            'sogou push spider'
        );
    
        $searchengine_name = array(
            'GOOGLE',
            'GOOGLE ADSENSE',
            'BAIDU',
            'MSN',
            'YODAO',
            'YAHOO',
            'Yahoo China',
            'IASK',
            'SOGOU',
            'SOGOU'
        );
    
        $spider = strtolower($_SERVER['HTTP_USER_AGENT']);
    
        foreach ($searchengine_bot as $key => $value) {
            if (strpos($spider, $value) !== false) {
                $spider = $searchengine_name[$key];
                if ($record === true) {
                    RC_Api::api('stats', 'spider_record', array('searchengine' => $spider));
                }
                return $spider;
            }
        }
    
        $spider = '';
    
        return false;
    }
    
    /**
     * 获得浏览器名称和版本
     *
     * @access public
     * @return string
     */
    public static function get_user_browser()
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return '';
        }
    
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = '';
        $browser_ver = '';
    
        if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
            $browser = 'Internet Explorer';
            $browser_ver = $regs[1];
        } elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
            $browser = 'FireFox';
            $browser_ver = $regs[1];
        } elseif (preg_match('/Maxthon/i', $agent, $regs)) {
            $browser = '(Internet Explorer ' . $browser_ver . ') Maxthon';
            $browser_ver = '';
        } elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
            $browser = 'Opera';
            $browser_ver = $regs[1];
        } elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)) {
            $browser = 'OmniWeb';
            $browser_ver = $regs[2];
        } elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)) {
            $browser = 'Netscape';
            $browser_ver = $regs[2];
        } elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
            $browser = 'Safari';
            $browser_ver = $regs[1];
        } elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)) {
            $browser = '(Internet Explorer ' . $browser_ver . ') NetCaptor';
            $browser_ver = $regs[1];
        } elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)) {
            $browser = 'Lynx';
            $browser_ver = $regs[1];
        }
    
        if (! empty($browser)) {
            return addslashes($browser . ' ' . $browser_ver);
        } else {
            return 'Unknow browser';
        }
    }
    
    /**
     * 站点数据
     */
    public static function get_site_info()
    {
        $shop_country = ecjia_region::instance()->region_name(ecjia::config('shop_country'));
        $shop_province = ecjia_region::instance()->region_name(ecjia::config('shop_province'));
        $shop_city = ecjia_region::instance()->region_name(ecjia::config('shop_city'));
    	$orders_stats = RC_Api::api('orders', 'orders_stats');
        $goods_stats = RC_Api::api('goods', 'goods_stats');
    	$user_stats = RC_Api::api('user', 'user_stats');
        
        $data = array(
            'shop_url'      => RC_Uri::site_url(),
            'shop_name'     => ecjia::config('shop_name'),
            'shop_title'    => ecjia::config('shop_title'),
            'shop_desc'     => ecjia::config('shop_desc'),
            'shop_keywords' => ecjia::config('shop_keywords'),
            'shop_type'     => RC_Config::get('site.shop_type'),
            'country'       => $shop_country,
            'province'      => $shop_province,
            'city'          => $shop_city,
            'address'       => ecjia::config('shop_address'),
            'qq'            => ecjia::config('qq'),
            'ww'            => ecjia::config('ww'),
            'wechat'        => ecjia::config('ym'),
            'weibo'         => ecjia::config('msn'),
            'email'         => ecjia::config('service_email'),
            'phone'         => ecjia::config('service_phone'),
            'icp'           => ecjia::config('icp_number'),
            'ip'            => RC_Ip::server_ip(),
            'version'       => VERSION,
            'release'       => RELEASE,
            'language'      => ecjia::config('lang'),
            'php_ver'       => PHP_VERSION,
            'mysql_ver'     => RC_Model::make()->database_version(),
            'charset'       => strtoupper(RC_CHARSET),
            'orders_count'  => $orders_stats['total'], //订单的数量
            'orders_amount' => $orders_stats['amount'], //应付款金额的总和
            'goods_count'   => $goods_stats['total'], //未删除、能够被单独销售并且是实物的商品数量的总和
            'user_count'    => $user_stats['total'], //用户的数量
            'template'      => ecjia::config('template'), //是否使用默认模板
            'style'         => ecjia::config('stylename'), //样式名字
            'patch'         => '', //补丁的版本
        );
        return $data;
    }
    
    public static function build_notice_data() {
        
        $data = array(
            'shop_url'      => RC_Uri::site_url(), //网址
            'shop_type'     => RC_Config::get('site.shop_type'),
            'version'       => VERSION, //版本号
            'release'       => RELEASE, //发布日期
            'language'      => ecjia::config('lang'), //语言种类
            'php_ver'       => PHP_VERSION, // php服务器版本
            'mysql_ver'     => RC_Model::make()->database_version(), // mysql服务器版本,log：说明你开启了binlog
            'template'      => ecjia::config('template'), //是否使用默认模板
            'style'         => ecjia::config('stylename'), //样式名字
            'charset'       => strtoupper(RC_CHARSET), //字符编码
            'patch'         => '', //补丁的版本
        );
        
        return $data;
    }
    
    
    public static function site_admin_notice() {
        // 21600
        $cloud = ecjia_cloud::instance()->api('product/update/notice')->data(self::build_notice_data())->cacheTime(21600)->run();
        if ($cloud->getStatus() == ecjia_cloud::STATUS_ERROR) {
            $data = array();
        } else {
            $data = $cloud->getReturnData();
        }
        return $data;
    }
    
    public static function site_admin_news() {
        // 21600
        $cloud = ecjia_cloud::instance()->api('product/update/news')->data(self::build_notice_data())->cacheTime(21600)->run();
        if ($cloud->getStatus() == ecjia_cloud::STATUS_ERROR) {
            $data = array();
        } else {
            $data = $cloud->getReturnData();
        }
        return $data;
    }
    
    /**
     * 后台菜单排序
     * @param admin_menu $a
     * @param admin_menu $b
     * @return number
     */
    public static function admin_menu_by_sort(admin_menu $a, admin_menu $b) {
        if ($a->sort == $b->sort) {
            return 0;
        } else {
            return ($a->sort > $b->sort) ? 1 : -1;
        }
    }
    
    /**
     * 生成随机的数字串
     * @return string
     */
    public static function random_filename() {
        $str = '';
        for($i = 0; $i < 9; $i++) {
            $str .= mt_rand(0, 9);
        }
    
        return RC_Time::gmtime() . $str;
    }
    
    /**
     * 信息提示模板
     * @param string $msg
     * @param string $url
     */
    public static function message_template($msg, $url) {
        $site_url = RC_Uri::site_url();
        $message = <<<EOF
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ECJIA - 操作提示</title>
	<style type="text/css">
		* {
			margin: 0px;
			padding: 0px;
		}
		html {
			background: none repeat scroll 0 0 #f1f1f1;
		}
		body {
			background: none repeat scroll 0 0 #fff;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
			color: #444;
			font-family: "Open Sans",sans-serif;
			margin: 2em auto;
			max-width: 700px;
			padding: 1em 2em;
		}
		#error-page {
			margin-top: 50px;
		}
		#error-page .error-message {
			font-size: 14px;
			line-height: 1.5;
			margin: 25px 0 20px;
		}
		#error-page h2{
			color: #666;
		}
		#error-page a,
		#error-page a:after {
			color: #08c;
			margin-right: 10px;
			text-decoration: none;
		}
		#error-page a:hover{
			text-decoration: underline;
		}
	</style>
</head>
<body id="error-page">
	<div class="error-message">
		<h2>操作提示</h2>
		<div>
			<p>{$msg}</p>
			<a href="javascript:{$url}">返回</a>
			<a href="{$site_url}">返回首页</a>
		</div>
	</div>
</body>
</html>
EOF;
        
        return $message;    
    }
}

// end
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
class pc_function {
    //获取头部和尾部信息
    public static function get_general_info() {
        $shop_logo_url = '';
        $shop_logo = ecjia::config('shop_logo');

        $disk = RC_Filesystem::disk();
        if (!empty($shop_logo) && $disk->exists(RC_Upload::upload_path($shop_logo))) {
            $shop_logo_url = RC_Upload::upload_url($shop_logo);
        }
        $merchant_url = RC_Uri::url('franchisee/merchant/init');
        $merchant_url = str_replace('index.php', 'sites/merchant/index.php', $merchant_url);
        $merchant_login = RC_Uri::url('staff/privilege/login');
        $merchant_login = str_replace('index.php', 'sites/merchant/index.php', $merchant_login);
        $company_name = ecjia::config('company_name');
        $shop_address = ecjia::config('shop_address');
        $regions = array();
        if (ecjia_config::has('mobile_recommend_city')) {
            $mobile_recommend_city = explode(',', ecjia::config('mobile_recommend_city'));
            $region_data = RC_DB::table('region')->whereIn('region_id', $mobile_recommend_city)->get();
            if (!empty($region_data)) {
                foreach ($region_data as $val) {
                    $regions[] = array('id' => $val['region_id'], 'name' => $val['region_name']);
                }
            }
        }
        $shop_info = RC_DB::table('article')->select('article_id', 'title')->where('cat_id', 0)->where('article_type', 'shop_info')->orderby('article_id', 'asc')->get();
        if (!empty($shop_info)) {
            foreach ($shop_info as $key => $val) {
                $url = RC_Uri::url('merchant/merchant/shopinfo', array('id' => $val['article_id']));
                $shop_info[$key]['url'] = str_replace('index.php', 'sites/merchant/index.php', $url);
            }
        }
        $shop_wechat_qrcode = ecjia::config('shop_wechat_qrcode');
        $shop_wechat_qrcode = !empty($shop_wechat_qrcode) ? RC_Upload::upload_url() . '/' . $shop_wechat_qrcode : '';
        
        if (empty($_COOKIE['city_id'])) {
            $ipInfos = self::GetIpLookup();
            if (!isset($ipInfos['city']) || empty($ipInfos['city'])) {
                $ipInfos['city'] = !empty($regions) ? $regions[0]['name'] : '上海';
            }
            $city_detail = RC_DB::table('region')->where('region_name', 'like', '%' . mysql_like_quote($ipInfos['city']) . '%')->where('region_type', 2)->first();
            setcookie("city_id", $city_detail['region_id'], RC_Time::gmtime() + 3600 * 24 * 7);
            setcookie("city_name", $city_detail['region_name'], RC_Time::gmtime() + 3600 * 24 * 7);
            $_COOKIE['city_id'] = $city_detail['region_id'];
            $_COOKIE['city_name'] = $city_detail['region_name'];
            
            setcookie("location_id", $city_detail['region_id'], RC_Time::gmtime() + 3600 * 24 * 7);
            setcookie("location_address", $city_detail['region_name'], RC_Time::gmtime() + 3600 * 24 * 7);
            $_COOKIE['location_id'] = $city_detail['region_id'];
            $_COOKIE['location_address'] = $city_detail['region_name'];
        } 
        
        $kf_qq = '';
        if (ecjia_config::has('qq')) {
        	$kf_qq = explode(',', ecjia::config('qq'));
        	$kf_qq = $kf_qq[0];
        }
        $data = array(
        	'shop_logo' 		=> $shop_logo_url, 
        	'merchant_url' 		=> $merchant_url, 
        	'merchant_login' 	=> $merchant_login, 
        	'company_name' 		=> $company_name, 
        	'shop_address' 		=> $shop_address, 
        	'region_list' 		=> $regions, 
        	'shop_weibo_url' 	=> ecjia::config('shop_weibo_url'), 
        	'shop_wechat_qrcode'	=> $shop_wechat_qrcode, 
        	'shop_info' 		 	=> $shop_info, 
        	'company_name' 			=> ecjia::config('company_name'), 
        	'powered' 				=> 'Powered&nbsp;by&nbsp;<a href="https:\\/\\/ecjia.com" target="_blank">ECJia</a>', 
        	'service_phone' 		=> ecjia::config('service_phone'), 
        	'city_id' 				=> !empty($_COOKIE['city_id']) ? intval($_COOKIE['city_id']) : 0, 
        	'city_name' 			=> !empty($_COOKIE['city_name']) ? trim($_COOKIE['city_name']) : '',
        	'http_host'				=> isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',
        	'kf_qq'					=> $kf_qq,
        	'location_id'			=>	$_COOKIE['location_id'],
        	'location_address' 		=>	$_COOKIE['location_address'],
        );
        
        $data['close_choose_city'] = 0;
        if (isset($_COOKIE['close_choose_city'])) {
        	$data['close_choose_city'] = 1;
        }
        return $data;
    }
    
    public static function get_child_tree($cat_id) {
        $cat_list = RC_DB::table('merchants_category')->selectRaw('cat_id, cat_name, parent_id')->where('parent_id', $cat_id)->where('is_show', 1)->orderBy('sort_order', 'asc')->get();
        $cat_arr = array();
        if (!empty($cat_list)) {
            foreach ($cat_list as $key => $val) {
                $cat_arr[] = array('cat_id' => $val['cat_id'], 'cat_name' => $val['cat_name']);
            }
        }
        return $cat_arr;
    }
    
    public static function GetIp() {
        $realip = '';
        $unknown = 'unknown';
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arr as $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realip = $ip;
                        break;
                    }
                }
            } else {
                if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)) {
                    $realip = $_SERVER['HTTP_CLIENT_IP'];
                } else {
                    if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
                        $realip = $_SERVER['REMOTE_ADDR'];
                    } else {
                        $realip = $unknown;
                    }
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else {
                if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)) {
                    $realip = getenv("HTTP_CLIENT_IP");
                } else {
                    if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)) {
                        $realip = getenv("REMOTE_ADDR");
                    } else {
                        $realip = $unknown;
                    }
                }
            }
        }
        $realip = preg_match("/[\\d\\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
        return $realip;
    }
    
    public static function GetIpLookup($ip = '') {
        if (empty($ip)) {
            $ip = self::GetIp();
        }
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        if (empty($res)) {
            return false;
        }
        $jsonMatches = array();
        preg_match('#\\{.+?\\}#', $res, $jsonMatches);
        if (!isset($jsonMatches[0])) {
            return false;
        }
        $json = json_decode($jsonMatches[0], true);
        if (isset($json['ret']) && $json['ret'] == 1) {
            $json['ip'] = $ip;
            unset($json['ret']);
        } else {
            return false;
        }
        return $json;
    }
    
    public static function get_cat_info($cat_id, $select_id) {
    	$cat_info = RC_DB::table('category')->where('cat_id', $cat_id)->first();
    	if ($cat_info['parent_id'] != 0) {
    		if (!empty($select_id)) {
    			$cat_info = RC_DB::table('category')->where('cat_id', $cat_info['parent_id'])->first();
    		}
    		$cat_info = RC_DB::table('category')->where('cat_id', $cat_info['parent_id'])->first();
    	}
    	$cat_info['child_cat'] = RC_DB::table('category')->where('parent_id', $cat_info['cat_id'])->where('is_show', 1)->orderBy('sort_order', 'asc')->get();
    	if (!empty($cat_info['child_cat'])) {
    		foreach ($cat_info['child_cat'] as $k => $v) {
    			$cat_info['child_cat'][$k]['children'] = RC_DB::table('category')->where('parent_id', $v['cat_id'])->where('is_show', 1)->orderBy('sort_order', 'asc')->get();
    		}
    	}
    	return $cat_info;
    }
    
    /**
     * 获取指定分类的str 例：分类1,分类2,分类3
     */
    public static function get_cat_str($cat_id = 0, $i = 3) {
    	if (empty($cat_id)) {
    		return '';
    	}
    	$cat_info = RC_DB::table('category')->where('cat_id', $cat_id)->select('parent_id', 'cat_name', 'cat_id')->first();
    	if ($i == 2) {
    		$arr['cat_id'] = $cat_info['parent_id'];
    		$arr['select_id'] = $cat_id;
    	} else {
    		$arr['cat_id'] = $cat_id;
    	}
    	$str = '<a href="'.RC_Uri::url('goods/index/init', $arr).'">'.$cat_info['cat_name'].'</a>';
    	if (!empty($cat_info['parent_id'])) {
    		$i--;
    		$html_tmp = self::get_cat_str($cat_info['parent_id'], $i);
    		if (!empty($html_tmp)) {
    			$str .= ','.$html_tmp;
    		}
    	}
    	return $str;
    }
    
    /**
     * 获取指定分类的html 例：分类1>分类2>分类3
     */
    public static function get_cat_html($str) {
    	$cat_list = explode(',', $str);
    	
    	$i = '<i class="iconfont icon-jiantou-right"></i>';
    	$html = '全部分类';
    	foreach (array_reverse($cat_list) as $k => $v) {
    		if ($k <= 2 && !empty($v)) {
    			$html .= $i.$v;
    		}
    	}    		
    	return $html;
    }
    
    /**
     * 获得商品总数和店铺总数
     *
     * @access public
     * @param
     *            s integer $isdelete
     * @param
     *            s integer $real_goods
     * @param
     *            s integer $conditions
     * @return array
     */
    public static function search_count($is_delete = 0, $real_goods = 1, $conditions = '', $keywords) {
    	/* 过滤条件 */
    	$param_str 	= '-' . $is_delete . '-' . $real_goods;
    	$filter ['keywords'] 		= $keywords;

    	$where = $filter ['cat_id'] > 0 ? " AND " . get_children($filter ['cat_id']) : '';
    
    	/* 关键字 */
    	if (!empty ($filter ['keywords'])) {
    		$where .= " AND (goods_sn LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR goods_name LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR keywords LIKE '%" . mysql_like_quote($filter ['keywords']) . "%')";
    	}
    
    	if ($real_goods > -1) {
    		$where .= " AND is_real='$real_goods'";
    	}
    
    	$db_goods = RC_DB::table('goods as g')
    		->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'))
    		->where(RC_DB::raw('s.status'), 1);

    	$where .= " AND (is_on_sale='" . 1 . "')";
    	$where .= " AND (is_alone_sale='" . 1 . "')";
//     	$where .= " AND (g.is_hot='" . 1 . "')";
    	$where .= " AND (s.city = '".$_COOKIE['city_id']."')";
    	$where .= " AND (s.shop_close = '". 0 ."')";
    	$where .= " AND (g.is_delete = '". 0 ."')";
    	$where .= " AND (g.review_status > '". 2 ."')";
    	
    	$where .= $conditions;
    
    	$db_goods = RC_DB::table('goods as g')
    		->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'))
    		->where(RC_DB::raw('s.status'), 1);
    	/* 记录总数 */
    	$count['goods_count'] = $db_goods->whereRaw('is_delete = ' . $is_delete . '' . $where)->count('goods_id');
		$count['store_count'] = RC_DB::table('store_franchisee')
			->where('city', $_COOKIE['city_id'])
			->where('shop_close', 0)
			->where('merchants_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%')
			->count();
    	
    	return $count;
    }
}
//end
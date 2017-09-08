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

/**
 * Touch主控制器
 */
class touch_controller {

    /**
     * 首页信息
     */
    public static function init() {
        ecjia_front::$controller->assign('more_sales', RC_Uri::url('goods/index/promotion'));
        ecjia_front::$controller->assign('more_news', RC_Uri::url('goods/index/new'));
        ecjia_front::$controller->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
        
        $url = RC_Uri::url('touch/index/init');
        touch_function::redirect_referer_url($url);
        
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$_COOKIE['city_id'].'-'.$_COOKIE['longitude'].'-'.$_COOKIE['latitude'].'-'.$_COOKIE['close_download']));
        if (!ecjia_front::$controller->is_cached('index.dwt', $cache_id)) {
	        $arr = array(
	        	'location' => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
	            'city_id' => $_COOKIE['city_id']
	        );
	        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::HOME_DATA)->data($arr)->run();
	
	        //处理ecjiaopen url
	        if (!is_ecjia_error($data) && !empty($data)) {
	        	foreach ($data as $k => $v) {
	        		if ($k == 'player' || $k == 'mobile_menu') {
	        			foreach ($v as $key => $val) {
	        				if (strpos($val['url'], 'ecjiaopen://') === 0) {
	        					$data[$k][$key]['url'] = with(new ecjia_open($val['url']))->toHttpUrl();
	        				}
	        			}
	        		} elseif ($k == 'adsense_group' || $k == 'promote_goods') {
	        			foreach ($v as $key => $val) {
	        				if (isset($val['adsense'])) {
	        					foreach ($val['adsense'] as $k_k => $v_v) {
	        						if (strpos($v_v['url'], 'ecjiaopen://') === 0) {
	        							$data[$k][$key]['adsense'][$k_k]['url'] = with(new ecjia_open($v_v['url']))->toHttpUrl();
	        						}
	        					}
	        				}
	        				if ($k == 'adsense_group') {
	        					$data['adsense_group'][$key]['count'] = count($val['adsense']);
	        				}
	        				if ($k == 'promote_goods') {
	        					$data['promote_goods'][$key]['promote_end_date'] = RC_Time::local_strtotime($val['promote_end_date']);
	        				}
	        			}
	        		}
	        	}
	        	//首页菜单
	        	ecjia_front::$controller->assign('navigator', $data['mobile_menu']);
	        	
	        	//首页广告
	        	ecjia_front::$controller->assign('adsense_group', $data['adsense_group']);
	        	
	        	//首页促销商品
	        	ecjia_front::$controller->assign('promotion_goods', $data['promote_goods']);
	        	
	        	//新品推荐
	        	ecjia_front::$controller->assign('new_goods', $data['new_goods']);
	        	
	        	ecjia_front::$controller->assign('cycleimage', $data['player']);
	        }
	
	        ecjia_front::$controller->assign('page_header', 'index');
	        ecjia_front::$controller->assign('searchs', user_function::insert_search());
	        ecjia_front::$controller->assign('shop_pc_url', ecjia::config('shop_pc_url'));
	        ecjia_front::$controller->assign('copyright', ecjia::config('wap_copyright'));
	        ecjia_front::$controller->assign('active', 'index');
	        ecjia_front::$controller->assign('address', 'address');
	        
	        ecjia_front::$controller->assign('searchs', user_function::get_search($store_id));
	        ecjia_front::$controller->assign('searchs_count', count(user_function::get_search($store_id)));
	        
	        ecjia_front::$controller->assign('down_url', RC_Uri::url('mobile/mobile/download'));
	        if (isset($_COOKIE['close_download'])) {
	        	ecjia_front::$controller->assign('close_download', $_COOKIE['close_download']);
	        }
	        
	        //下载推广是否开启
	        $config = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CONFIG)->run();
	        if (!is_ecjia_error($config)) {
	        	if ($config['wap_app_download_show'] && $config['wap_app_download_img']) {
	        		ecjia_front::$controller->assign('download_app_switch', 1);
	        		ecjia_front::$controller->assign('app_download_img', $config['wap_app_download_img']);
	        	}
	        }
	        
	        ecjia_front::$controller->assign_title();
	        ecjia_front::$controller->assign_lang();
	        
	        $paramater = array(
	        	'pagination' 	=> array('count' => 6, 'page' => 1),
	        	'location' 		=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
	        	'city_id'       => $_COOKIE['city_id']
	        );
	        
	        $response = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_LIST)->data($paramater)->hasPage()->run();
	        if (!is_ecjia_error($response)) {
	        	list($data, $paginated) = $response;
	        	$data = merchant_function::format_distance($data);
	        
	        	if (isset($paginated['more']) && $paginated['more'] == 0) $is_last = 1;
	        	ecjia_front::$controller->assign('data', $data);
	        	ecjia_front::$controller->assign('is_last', $is_last);
	        }
        }
        ecjia_front::$controller->display('index.dwt', $cache_id);
    }
   
    /**
     * ajax获取商品
     */
    public static function ajax_goods() {
        $type = htmlspecialchars($_GET['type']);
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $paramater = array(
        	'action_type' 	=> $type,	
 			'pagination' 	=> array('count' => $limit, 'page' => $page),
			'location' 		=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
            'city_id'       => $_COOKIE['city_id']
        );

        $response = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SUGGESTLIST)->data($paramater)->hasPage()->run();
        if (!is_ecjia_error($response)) {
			list($data, $paginated) = $response;
			
        	ecjia_front::$controller->assign('goods_list', $data);
        	ecjia_front::$controller->assign_lang();
        	$sayList = ecjia_front::$controller->fetch('index.dwt');
        	
        	if (isset($paginated['more']) && $paginated['more'] == 0) $data['is_last'] = 1;
        	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $sayList, 'is_last' => $data['is_last']));
        }
    }

    /**
     * ajax获取推荐店铺
     */
    public static function ajax_suggest_store() {
    	$limit = 6;
    	$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	
    	$paramater = array(
    		'pagination' 	=> array('count' => $limit, 'page' => $page),
    		'location' 		=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
            'city_id'       => $_COOKIE['city_id']
    	);
    		
    	$cache_id = sprintf('%X', crc32($limit.'-'.$page.'-'.$_COOKIE['longitude'].'-'.$_COOKIE['latitude'].'-'.$_COOKIE['city_id']));
    	$response = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_LIST)->data($paramater)->hasPage()->run();
    	if (!is_ecjia_error($response)) {
    		list($data, $paginated) = $response;
    		$data = merchant_function::format_distance($data);
    		
    		ecjia_front::$controller->assign('data', $data);
    		ecjia_front::$controller->assign_lang();
    		
    		$sayList = '';
    		if (!empty($data)) {
    			$sayList = ecjia_front::$controller->fetch('library/suggest_store.lbi', $cache_id);
    		}
    		if (isset($paginated['more']) && $paginated['more'] == 0) $data['is_last'] = 1;
    		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $sayList, 'is_last' => $data['is_last']));
    	}
    }
    
    /**
     * 搜索
     */
    public static function search() {
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$_COOKIE ['ECJia'] ['search']));
    	
    	if (!ecjia_front::$controller->is_cached('search.dwt', $cache_id)) {
    		$keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';
    		ecjia_front::$controller->assign('keywords', $keywords);
    		
    		$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
    		ecjia_front::$controller->assign('store_id', $store_id);
    		
    		ecjia_front::$controller->assign('searchs', user_function::get_search($store_id));
    		ecjia_front::$controller->assign('searchs_count', count(user_function::get_search($store_id)));
    		ecjia_front::$controller->assign_title('搜索');
    	}
        ecjia_front::$controller->display('search.dwt', $cache_id);
    }

    /**
     * 清除搜索
     */
    public static function del_search($store_id = 0) {
    	$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
    	$ecjia_search = 'ECJia[search]';
    	if (!empty($store_id)) {
    		$ecjia_search .= '['.$store_id.']';
    	} else {
    		$ecjia_search .= '[other]';
    	}
        setcookie($ecjia_search, '', 1);
        
        $pjaxurl = '';
        if ($store_id <= 0) {
        	$pjaxurl = RC_Uri::url('touch/index/search');
        }
        return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }
}

// end
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
 * 文章模块控制器代码
 */
class article_controller {
    /**
     *  帮助中心页
     */
    public static function init() {
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
    	
    	if (!ecjia_front::$controller->is_cached('article_init.dwt', $cache_id)) {
    		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_HELP)->run();
    		if (!is_ecjia_error($data)) {
    			ecjia_front::$controller->assign('data', $data);
    		}
    		ecjia_front::$controller->assign_title('帮助中心');
    		ecjia_front::$controller->assign('title', '帮助中心');
    	}
        ecjia_front::$controller->display('article_init.dwt', $cache_id);
    }
    
    /**
     * 文章详情
     */
    public static function detail() {
        $title = trim($_GET['title']);
        $article_id = intval($_GET['aid']);
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
        
        if (!ecjia_front::$controller->is_cached('article_detail.dwt', $cache_id)) {
        	ecjia_front::$controller->assign('title', $title);
        	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_HELP_DETAIL)->data(array('article_id' => $article_id))->run();
        	
        	if (!is_ecjia_error($data) && !empty($data)) {
        		$res = array();
        		preg_match('/<body>([\s\S]*?)<\/body>/', $data, $res);
        		$bodystr = trim($res[0]);
        		if ($bodystr != '<body></body>') {
        			ecjia_front::$controller->assign('data', $bodystr);
        		}
        	}
        	ecjia_front::$controller->assign_title($title);
        }
        ecjia_front::$controller->display('article_detail.dwt', $cache_id);
    }
    
    /**
     * 网店信息内容
     */
    public static function shop_detail() {
        $title = trim($_GET['title']);
        $article_id = intval($_GET['article_id']);
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
        
        if (!ecjia_front::$controller->is_cached('article_shop_detail.dwt', $cache_id)) {
        	$shop_detail = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_INFO_DETAIL)->data(array('article_id' => $article_id))->run();
        	if (!is_ecjia_error($shop_detail) && !empty($shop_detail)) {
        		$res = array();
        		preg_match('/<body>([\s\S]*?)<\/body>/', $shop_detail, $res);
        		$bodystr = trim($res[0]);
        		if ($bodystr != '<body></body>') {
        			ecjia_front::$controller->assign('data', $bodystr);
        		}
        	}
        	ecjia_front::$controller->assign('title', $title);
        	ecjia_front::$controller->assign_title($title);
        }

        ecjia_front::$controller->display('article_shop_detail.dwt', $cache_id);
    }
    
    /**
     *  发现首页
     */
    public static function article_index() {
    	//文章分类及轮播图
    	$article_cat = ecjia_touch_manager::make()->api(ecjia_touch_api::ARTICLE_HOME_CYCLEIMAGE)->data(array('city_id' => $_COOKIE['city_id']))->run();
    	
    	//处理ecjiaopen url
    	if (!is_ecjia_error($article_cat) && !empty($article_cat)) {
    		foreach ($article_cat as $k => $v) {
    			if ($k == 'player') {
    				foreach ($v as $key => $val) {
    					if (strpos($val['url'], 'ecjiaopen://') === 0) {
    						$article_cat[$k][$key]['url'] = with(new ecjia_open($val['url']))->toHttpUrl();
    					}
    				}
    			}
    		}
    		ecjia_front::$controller->assign('cycleimage', $article_cat['player']);
    	
    		if (!empty($article_cat['category'])) {
    			ecjia_front::$controller->assign('article_cat', $article_cat['category']);
    		}
    	}
    	
    	//新人有礼url
    	$token = ecjia_touch_user::singleton()->getToken();
    	$signup_reward_url =  RC_Uri::url('user/mobile_reward/init', array('token' => $token));
    	ecjia_front::$controller->assign('signup_reward_url', $signup_reward_url);
    	
    	//菜单选中
    	ecjia_front::$controller->assign('active', 'discover');
    	ecjia_front::$controller->assign_title('发现');
    		
    	ecjia_front::$controller->display('discover_init.dwt');
    }
    
    /**
     * 发现文章详情
     */
    public static function article_detail() {
    	$article_id = !empty($_GET['article_id']) ? intval($_GET['article_id']) : 0;
    	$token = ecjia_touch_user::singleton()->getToken();
    	$article_param = array(
    		'token' 		=> $token,
    		'article_id'	=> $article_id
    	);
    	$article_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ARTICLE_DETAIL)->data($article_param)->run();
    	if (!is_ecjia_error($article_info) && !empty($article_info)) {
    		list($data, $info) = $article_info;
    		$res = array();
    		if (!empty($data['content'])) {
    			$data['content'] = stripslashes($data['content']);
    		}
    		preg_match('/<body>([\s\S]*?)<\/body>/', $data['content'], $res);
    		$bodystr = trim($res[0]);
    		if ($bodystr != '<body></body>') {
    			ecjia_front::$controller->assign('content', $bodystr);
    		}
    		ecjia_front::$controller->assign('data', $data);
    	}
    	ecjia_front::$controller->assign('article_id', $article_id);
    	    	
    	ecjia_front::$controller->display('discover_article.dwt');
    }
    
    /**
     * 评论文章
     */
    public static function add_comment() {
    	$type = !empty($_POST['type']) ? trim($_POST['type']) : '';
    	if (!ecjia_touch_user::singleton()->isSignin()) {
    		$url = RC_Uri::site_url() . substr($_SERVER['HTTP_REFERER'], strripos($_SERVER['HTTP_REFERER'], '/'));
    		$referer_url = RC_Uri::url('user/privilege/login', array('referer_url' => urlencode($url)));
    		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('referer_url' => $referer_url));
    	}
    	
    	if (empty($type)) {
    		$article_id = !empty($_GET['article_id']) ? intval($_GET['article_id']) : 0;
    		$content = !empty($_POST['val']) ? trim($_POST['val']) : '';
    		if (empty($content)) {
    			return ecjia_front::$controller->showmessage('请输入评论内容', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		$article_param = array(
    			'token' => ecjia_touch_user::singleton()->getToken(),
    			'article_id' => $article_id,
    			'content' => $content,
    		);
    		$response = ecjia_touch_manager::make()->api(ecjia_touch_api::ARTICLE_COMMENT_CREATE)->data($article_param)->run();
    		if (is_ecjia_error($response)) {
    			return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}	
    	}
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    /**
     * 文章点赞/取消点赞
     */
    public static function like_article() {
    	if (!ecjia_touch_user::singleton()->isSignin()) {
    		$url = RC_Uri::site_url() . substr($_SERVER['HTTP_REFERER'], strripos($_SERVER['HTTP_REFERER'], '/'));
    		$referer_url = RC_Uri::url('user/privilege/login', array('referer_url' => urlencode($url)));
    		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('referer_url' => $referer_url));
    	}
    	
    	$article_id = !empty($_GET['article_id']) ? intval($_GET['article_id']) : 0;
    	$type = !empty($_POST['type']) ? trim($_POST['type']) : '';
    	 
    	$article_param = array(
    		'token' => ecjia_touch_user::singleton()->getToken(),
    		'article_id' => $article_id,
    	);
    	
    	if ($type == 'add') {
    		$response = ecjia_touch_manager::make()->api(ecjia_touch_api::ARTICLE_LIKE_ADD)->data($article_param)->run();
    	} elseif ($type == 'cancel') {
    		$response = ecjia_touch_manager::make()->api(ecjia_touch_api::ARTICLE_LIKE_CANCEL)->data($article_param)->run();
    	}
    	if (is_ecjia_error($response)) {
    		return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    /**
     * 获取文章列表
     */
    public static function ajax_article_list() {
    	$limit = !empty($_GET['size']) > 0 	? intval($_GET['size']) : 10;
    	$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	$action_type = $_GET['action_type'];
    	
    	if ($action_type == 'stickie') {
    		//精选文章
    		$article_param = array(
    			'type' => 'stickie',
    			'pagination' => array('count' => $limit, 'page' => $page),
    		);
    		$response = ecjia_touch_manager::make()->api(ecjia_touch_api::ARTICLE_SUGGESTLIST)->data($article_param)->hasPage()->run();
    	} else {
    		$article_param = array(
    			'cat_id' => $action_type,
    			'pagination' => array('count' => $limit, 'page' => $page),
    		);
    		$response = ecjia_touch_manager::make()->api(ecjia_touch_api::ARTICLE_LIST)->data($article_param)->hasPage()->run();
    	}
    	
    	$say_list = '';
    	$is_last = 1;
    	if (!is_ecjia_error($response)) {
    		list($data, $paginated) = $response;
    		ecjia_front::$controller->assign('data', $data);
    		$say_list = ecjia_front::$controller->fetch('library/article_list.lbi');
    		
    		if (isset($paginated['more']) && $paginated['more'] == 1) $is_last = 0;
    		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
    	}
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
    }
    
    /**
     * 获取评论列表
     */
    public static function ajax_comment_list() {
    	$pages = !empty($_GET['page']) ? intval($_GET['page']) : 1;
    	$limit = !empty($_GET['size']) > 0 	? intval($_GET['size']) : 10;
    	$article_id = !empty($_GET['article_id']) ? intval($_GET['article_id']) : 0;
    	 
    	$article_param = array(
    		'article_id' => $article_id,
    		'pagination' => array('count' => $limit, 'page' => $pages),
    	);
    	$response = ecjia_touch_manager::make()->api(ecjia_touch_api::ARTICLE_COMMENTS)->data($article_param)->hasPage()->run();
    	
    	$say_list = '';
    	$is_last = 1;
    	if (!is_ecjia_error($response)) {
    		list($data, $paginated) = $response;
    		
    		ecjia_front::$controller->assign('data', $data);
    		$say_list = ecjia_front::$controller->fetch('library/article_comment.lbi');
    		
    		if (isset($paginated['more']) && $paginated['more'] == 1) $is_last = 0;
    		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
    	}
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
    }
}

// end
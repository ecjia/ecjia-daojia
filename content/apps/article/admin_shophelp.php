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
 * ECJIA 帮助信息管理程序
 *  @author songqian
 */
class admin_shophelp extends ecjia_admin {
    public function __construct() {
		parent::__construct();
		
 		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('shophelp_list', RC_App::apps_url('statics/js/shophelp_list.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		RC_Script::localize_script('shophelp_list', 'js_lang', config('app-article::jslang.shophelp_page'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('帮助分类', 'article'), RC_Uri::url('article/admin_shophelp/init')));
	}

	/**
	 * 网店帮助分类
	 */
	public function init() {
		$this->admin_priv('shophelp_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('帮助分类', 'article')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述', 'article'),
			'content'	=> '<p>' . __('欢迎访问ECJia智能后台网店帮助列表页面，系统中所有的网店帮助都会显示在此列表中。', 'article') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息：') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:网店帮助" target="_blank">关于网店帮助列表帮助文档</a>', 'article') . '</p>'   
		);
		
		$this->assign('action_link', array('text' => __('添加新帮助文章', 'article'), 'href' => RC_Uri::url('article/admin_shophelp/add/')));
		$this->assign('ur_here', __('帮助分类', 'article'));
		
		$this->assign('list', $this->get_shophelp_list());
		$this->assign('form_action', RC_Uri::url('article/admin_shophelp/add_catname'));
		
		$this->display('shophelp_cat_list.dwt');
	}

	/**
	 * 分类下的文章
	 */
	public function list_article() {
		$this->admin_priv('shophelp_manage');
	
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述', 'article'),
			'content'	=> '<p>' . __('欢迎访问ECJia智能后台网店帮助文章列表页面，系统中指定分类下的网店帮助文章都会显示在此列表中。', 'article') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息：', 'article') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:网店帮助#.E6.9F.A5.E7.9C.8B.E5.B8.AE.E5.8A.A9.E6.96.87.E7.AB.A0" target="_blank">关于网店帮助文章帮助文档</a>', 'article') . '</p>'
		);
		
		$cat_id = intval($_GET['cat_id']);
		$cat_name = RC_DB::table('article_cat')->where('cat_id', $cat_id)->pluck('cat_name');
        
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($cat_name));
		
		$this->assign('ur_here', $cat_name.__(' 列表', 'article'));
		$this->assign('action_linkadd', array('text' => __('添加帮助文章', 'article'), 'href' => RC_Uri::url('article/admin_shophelp/add', array('cat_id' => $cat_id))));
		$this->assign('back_helpcat', array('text' => __('帮助分类', 'article'), 'href' => RC_Uri::url('article/admin_shophelp/init')));
		 
		$this->assign('list', $this->get_shophelp_article($cat_id));
		$this->assign('cat_id', $cat_id);
		
		$this->display('shophelp_article_list.dwt');
	}
	
	/**
	 * 添加文章
	 */
	public function add() {
		$this->admin_priv('shophelp_manage');
		
		$cat_id = intval($_GET['cat_id']);
		$cat_name = RC_DB::table('article_cat')->where('cat_id', $cat_id)->pluck('cat_name');

		$this->assign('cat_name', $cat_name);
		$this->assign('ur_here', __('添加帮助文章', 'article'));
		$this->assign('action_link', array('text' => __('帮助文章列表', 'article'), 'href' => RC_Uri::url('article/admin_shophelp/list_article', array('cat_id' => $cat_id))));

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($cat_name, RC_Uri::url('article/admin_shophelp/list_article', array('cat_id' => $cat_id))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加帮助文章', 'article')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述', 'article'),
			'content'	=> '<p>' . __('欢迎访问ECJia智能后台添加帮助文章页面，可以在此页面添加帮助文章信息。', 'article') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息：', 'article') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:网店帮助#.E6.B7.BB.E5.8A.A0.E5.B8.AE.E5.8A.A9.E6.96.87.E7.AB.A0" target="_blank">关于添加帮助文章帮助文档</a>', 'article') . '</p>'
		);
		
		$this->assign('cat_id', $cat_id);
		$this->assign('form_action', RC_Uri::url('article/admin_shophelp/insert'));
		
		$this->display('shophelp_info.dwt');
	}
	
	public function insert() {
		$this->admin_priv('shophelp_manage', ecjia::MSGTYPE_JSON);
		
		$title 			= !empty($_POST['title']) 			? trim($_POST['title']) 			: '';
		$cat_id 		= !empty($_POST['cat_id']) 			? intval($_POST['cat_id']) 			: 0;
		$is_only = RC_DB::table('article')->where('title', $title)->where('cat_id', $cat_id)->count();
		
		if ($is_only != 0) {
			return $this->showmessage(sprintf(__('此文章主题已经存在！', 'article'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array(
			'title'		   	=> $title,
			'cat_id'	   	=> $cat_id,
			'article_type' 	=> 'shop_help',
			'content'	   	=> !empty($_POST['content']) ? $_POST['content'] : '',
			'keywords'	   	=> !empty($_POST['keywords']) ? trim($_POST['keywords']) : '',
			'description'  	=> !empty($_POST['description']) ? trim($_POST['description']) : '',
			'add_time'	   	=> RC_Time::gmtime(),
			'author'	   	=> '_SHOPHELP',
			'article_approved' => 1
		);
		$id = RC_DB::table('article')->insertGetId($data);
		
		//释放article_list缓存
		$orm_article_db = RC_Model::model('article/orm_article_model');
		$cache_article_list_key = 'article_list_';
		$cache_id_list = sprintf('%X', crc32($cache_article_list_key));
		$orm_article_db->delete_cache_item($cache_id_list);
		
		$cat_name = RC_DB::table('article_cat')->where('cat_id', $cat_id)->pluck('cat_name');
		ecjia_admin::admin_log($title.'，'.__('所属帮助分类是', 'article').$cat_name, 'add', 'shophelp');
		
		$links[] = array('text' => __('返回帮助文章列表', 'article'), 'href' => RC_Uri::url('article/admin_shophelp/list_article', array('cat_id' => $cat_id)));
		$links[] = array('text' => __('继续添加帮助文章', 'article'), 'href' => RC_Uri::url('article/admin_shophelp/add', array('cat_id' => $cat_id)));
		return $this->showmessage(__('文章添加成功', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('article/admin_shophelp/edit', array('id' => $id, 'cat_id' => $cat_id))));
	}
	
	/**
	 * 编辑文章
	 */
	public function edit() {
		$this->admin_priv('shophelp_manage');
		
		$article_id   = !empty($_GET['id'])       ? intval($_GET['id'])       : 0;
		$cat_id       = !empty($_GET['cat_id'])   ? intval($_GET['cat_id'])   : 0;
		
		$cat_name = RC_DB::table('article_cat')->where('cat_id', $cat_id)->pluck('cat_name');
		$article = RC_DB::table('article')->where('article_id', $article_id)->first();
		if (!empty($article['content'])) {
			$article['content'] = stripslashes($article['content']);
		}
		
		$this->assign('cat_id', $cat_id);
		$this->assign('ur_here', __('编辑帮助文章', 'article'));
		$this->assign('action_link', array('text' => __('帮助文章列表', 'article'), 'href'=> RC_Uri::url('article/admin_shophelp/list_article', array('cat_id' => $cat_id))));
		$this->assign('article', $article);
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($cat_name, RC_Uri::url('article/admin_shophelp/list_article', array('cat_id' => $article['cat_id']))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑帮助文章', 'article')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述', 'article'),
			'content'	=> '<p>' . __('欢迎访问ECJia智能后台编辑帮助文章页面，可以在此页面编辑相应的帮助文章信息。', 'article') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息：', 'article') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:网店帮助#.E7.BC.96.E8.BE.91.E5.B8.AE.E5.8A.A9.E6.96.87.E7.AB.A0" target="_blank">关于编辑帮助文章帮助文档</a>', 'article') . '</p>'   
		);
		
		$this->assign('form_action', RC_Uri::url('article/admin_shophelp/update'));
		$this->display('shophelp_info.dwt');
	}
	
	public function update() {
		$this->admin_priv('shophelp_manage', ecjia::MSGTYPE_JSON);
		
		$cat_id    = !empty($_POST['cat_id']) 		? intval($_POST['cat_id']) 	: 0;
		$id        = !empty($_POST['id']) 			? intval($_POST['id']) 		: 0;
		$title     = !empty($_POST['title']) 		? trim($_POST['title']) 	: '';
		
	    $is_only = RC_DB::table('article')->where('title', $title)->where('cat_id', $cat_id)->where('article_id', '!=', $id)->count();
		if ($is_only != 0) {
			return $this->showmessage(sprintf(__('此文章主题已经存在！', 'article'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'title'        	=> $title,
			'cat_id'       	=> $cat_id,
			'article_type' 	=> 'shop_help',
			'content'      	=> !empty($_POST['content']) ? $_POST['content'] : '',
			'keywords'     	=> !empty($_POST['keywords']) ? trim($_POST['keywords']) : '',
			'description'	=> !empty($_POST['description']) ? trim($_POST['description']) : '',
			'article_approved' 	=> 1
		);
		
		RC_DB::table('article')->where('article_id', $id)->update($data);
	    $cat_name = RC_DB::table('article_cat')->where('cat_id', $cat_id)->pluck('cat_name');
	    
	    //释放article_list缓存
	    $orm_article_db = RC_Model::model('article/orm_article_model');
	    $cache_article_list_key = 'article_list_';
	    $cache_id_list = sprintf('%X', crc32($cache_article_list_key));
	    $orm_article_db->delete_cache_item($cache_id_list);
	    
// 		ecjia_admin::admin_log($title.'，'.__('所属帮助分类是', 'article').$cat_name, 'edit', 'shophelp');
	    ecjia_admin::admin_log(sprintf(__('%s 所属帮助分类是: %s', 'article'), $title, $cat_name), 'edit', 'shophelp');
		
		return $this->showmessage(sprintf(__('文章 %s 编辑成功', 'article'), $title), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin_shophelp/edit', array('id' => $id, 'cat_id' => $cat_id))));
	}
	
	/**
	 * 编辑分类的名称
	 */
	public function edit_catname() {
		$this->admin_priv('shophelp_manage', ecjia::MSGTYPE_JSON);
		
		$id       = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
		$cat_name = !empty($_POST['value']) ? trim($_POST['value']) : '';
		
		if (empty($cat_name)) {
			return $this->showmessage(__('请输入分类名', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$count = RC_DB::table('article_cat')->where('cat_name', $cat_name)->where('cat_id', '!=', $id)->count();
		if ($count) {
			return $this->showmessage(__('此分类名已经存在！', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			RC_DB::table('article_cat')->where('cat_id', $id)->update(array('cat_name' => $cat_name));
			
	    	//释放article_list缓存
	    	$orm_article_db = RC_Model::model('article/orm_article_model');
	    	$cache_article_list_key = 'article_list_';
	    	$cache_id_list = sprintf('%X', crc32($cache_article_list_key));
	    	$orm_article_db->delete_cache_item($cache_id_list);
	    	
	        ecjia_admin::admin_log($cat_name, 'edit', 'shophelpcat');
			return $this->showmessage(__('编辑成功', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($cat_name)));
		}
	}
	
	/**
	 * 编辑分类的排序
	 */
	public function edit_cat_order() {
		$this->admin_priv('shophelp_manage', ecjia::MSGTYPE_JSON);
		$id 	= !empty($_POST['pk']) 		? intval($_POST['pk']) 	: 0;
		$order 	= !empty($_POST['value']) 	? trim($_POST['value']) : '';

		if (!is_numeric($order)) {
			return $this->showmessage(__('请输入一个整数', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			RC_DB::table('article_cat')->where('cat_id', $id)->update(array('sort_order' => $order));
			return $this->showmessage(__('编辑成功', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('article/admin_shophelp/init')) );
		}
	}
	
	/**
	 * 删除分类
	 */
	public function remove() {
		$this->admin_priv('shophelp_manage', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;

		$count = RC_DB::table('article')->where('cat_id', $id)->count();
		if ($count != 0) {
			return $this->showmessage(__('编辑成功', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
		    $cat_name = RC_DB::table('article_cat')->where('cat_id', $id)->pluck('cat_name');
		    //释放article_list缓存
		    $orm_article_db = RC_Model::model('article/orm_article_model');
		    $cache_article_list_key = 'article_list_';
		    $cache_id_list = sprintf('%X', crc32($cache_article_list_key));
		    $orm_article_db->delete_cache_item($cache_id_list);
			ecjia_admin::admin_log($cat_name, 'remove', 'shophelpcat');
			
			RC_DB::table('article_cat')->where('cat_id', $id)->delete();
			return $this->showmessage(__('删除分类成功', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 删除分类下的某文章
	 */
	public function remove_art() {
		$this->admin_priv('shophelp_manage', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$info = RC_DB::table('article')->where('article_id', $id)->first();
		
		RC_DB::table('article')->where('article_id', $id)->delete();
	    $cat_name = RC_DB::table('article_cat')->where('cat_id', $info['cat_id'])->pluck('cat_name');
	    
	    //释放article_list缓存
	    $orm_article_db = RC_Model::model('article/orm_article_model');
	    $cache_article_list_key = 'article_list_';
	    $cache_id_list = sprintf('%X', crc32($cache_article_list_key));
	    $orm_article_db->delete_cache_item($cache_id_list);

// 	    ecjia_admin::admin_log($info['title'].'，'.__('所属帮助分类是', 'article').$cat_name, 'remove', 'shophelp');
	    ecjia_admin::admin_log(sprintf(__('%s 所属帮助分类是: %s', 'article'), $info['title'], $cat_name), 'remove', 'shophelp');
		return $this->showmessage(__('删除文章成功', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 添加一个新分类
	 */
	public function add_catname() {
		$this->admin_priv('shophelp_manage', ecjia::MSGTYPE_JSON);
		
		$cat_name = !empty($_POST['cat_name']) ? trim($_POST['cat_name']) : '';
		if (!empty($cat_name)) {
			$count = RC_DB::table('article_cat')->where('cat_name', $cat_name)->count();
		    if ($count != 0) {
				return $this->showmessage(__('此分类名已经存在！', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$data = array(
					'cat_name'  => $cat_name,
					'cat_type'  => 'shop_help',
				);
				RC_DB::table('article_cat')->insert($data);
				//释放article_list缓存
				$orm_article_db = RC_Model::model('article/orm_article_model');
				$cache_article_list_key = 'article_list_';
				$cache_id_list = sprintf('%X', crc32($cache_article_list_key));
				$orm_article_db->delete_cache_item($cache_id_list);
				
				ecjia_admin::admin_log($cat_name, 'add', 'shophelpcat');				
				return $this->showmessage(sprintf(__('添加 %s 分类成功', 'article'), $cat_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin_shophelp/init')));
			}
		} else {
			return $this->showmessage(__('请输入分类名', 'article'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 获得网店帮助文章分类
	 * @return array
	 */
	private function get_shophelp_list() {
		$data = RC_DB::table('article_cat')
			->select('cat_id', 'cat_name', 'sort_order')
			->where('cat_type', 'shop_help')
			->orderby('sort_order', 'asc')
			->get();
		
		$list = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$list[] = $rows;
			}
		}
		return $list;
	}
	
	/**
	 * 获取网店帮助分类下的文章列表
	 */
	private function get_shophelp_article($cat_id) {
		$count = RC_DB::table('article')->where('cat_id', $cat_id)->count();
		$page = new ecjia_page($count, 15, 5);

		$data = RC_DB::table('article')
			->select('article_id', 'title', 'article_type', 'add_time')
			->where('cat_id', $cat_id)
			->orderby('article_id', 'desc')
			->take(15)
			->skip($page->start_id-1)
			->get();
		
		$list = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				if (!empty($rows['add_time'])) {
					$rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
				}
				$list[] = $rows;
			}
		}
		return array('item' => $list, 'page' => $page->show(15), 'desc' => $page->page_desc(), 'num' => $count);
	}
}

// end
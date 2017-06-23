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
 * ECJIA 文章分类管理程序 
 * @author songqian
 */
class admin_articlecat extends ecjia_admin {
    private $db_article_cat;
    private $db_article;
    
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_class('article_cat', 'article', false);
		$this->db_article_cat	= RC_Model::model('article/article_cat_model');
		$this->db_article		= RC_Model::model('article/article_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('article_cat_info', RC_App::apps_url('statics/js/article_cat_info.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		$js_lang = array(
			'cat_name_required'	=> RC_Lang::get('article::article.cat_name_required'),
		);
		RC_Script::localize_script('article_cat_info', 'js_lang', $js_lang);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.cat'), RC_Uri::url('article/admin_articlecat/init')));
	}
		
	/**
	 * 分类列表
	 */
	public function init() {
		$this->admin_priv('article_cat_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.cat')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('article::article.overview'),
			'content'	=> '<p>' . RC_Lang::get('article::article.article_cat_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章分类" target="_blank">'.RC_Lang::get('article::article.about_article_cat').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('system::system.02_articlecat_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('system::system.articlecat_add'), 'href' => RC_Uri::url('article/admin_articlecat/add')));
		
		$articlecat = article_cat::article_cat_list(0, 0, false, 0, 'article');
		if (!empty($articlecat)) {
			foreach ($articlecat as $key => $cat) {
				$articlecat[$key]['type_name'] = RC_Lang::get('article::article.type_name.'.$cat['cat_type']);
			}
			$this->assign('articlecat', $articlecat);
		}
		
		$this->display('articlecat_list.dwt');
	}
	
	/**
	 * 添加文章分类
	 */
	public function add() {
		$this->admin_priv('article_cat_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.articlecat_add')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('article::article.overview'),
			'content'	=> '<p>' . RC_Lang::get('article::article.add_cat_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章分类#.E6.B7.BB.E5.8A.A0.E6.96.87.E7.AB.A0.E5.88.86.E7.B1.BB" target="_blank">'.RC_Lang::get('article::article.about_add_cat').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('system::system.articlecat_add'));
		$this->assign('action_link', array('text' => RC_Lang::get('system::system.02_articlecat_list'), 'href' => RC_Uri::url('article/admin_articlecat/init')));
		
		$this->assign('cat_select', article_cat::article_cat_list(0, 0, true, 0, 'article'));
		$this->assign('form_action', RC_Uri::url('article/admin_articlecat/insert'));
		
		$this->display('articlecat_info.dwt');
	}
	
	public function insert() {
		$this->admin_priv('article_cat_update', ecjia::MSGTYPE_JSON);
		
		$cat_name     = !empty($_POST['cat_name'])    ? trim($_POST['cat_name'])      : '';
		$cat_desc     = !empty($_POST['cat_desc'])    ? trim($_POST['cat_desc'])      : '';
		$keywords     = !empty($_POST['keywords'])    ? trim($_POST['keywords'])      : '';
		$sort_order   = !empty($_POST['sort_order'])  ? intval($_POST['sort_order'])  : 0;  
		$parent_id    = !empty($_POST['parent_id'])   ? intval($_POST['parent_id'])   : 0;
		
        if ($this->db_article_cat->article_cat_count(array('cat_name' => $cat_name)) > 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::article.catname_exist'), stripslashes($cat_name)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$cat_type = 'article';
// 		if ($parent_id > 0) {
//             $p_cat_type = $this->db_article_cat->article_cat_field($parent_id, 'cat_type');
// 		    $p_cat_type = $p_cat_type['cat_type'];
// 			if ($p_cat_type == 2 || $p_cat_type == 3 || $p_cat_type == 5) {
// 				return $this->showmessage(RC_Lang::get('article::article.not_allow_add'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
// 			} else if ($p_cat_type == 4) {
// 				$cat_type = 5;
// 			}
// 		}
		$show_in_nav = !empty($_POST['show_in_nav']) ? intval($_POST['show_in_nav']) : 0;
		$data = array(
			'cat_name'	  => $cat_name,
			'cat_type' 	  => $cat_type,
			'cat_desc' 	  => $cat_desc,
			'keywords' 	  => $keywords,
			'parent_id'   => $parent_id,
			'sort_order'  => $sort_order,
			'show_in_nav' => $show_in_nav,
		);
		$id = $this->db_article_cat->article_cat_manage($data);
		
		if ($show_in_nav == 1) {
            $vieworder = RC_DB::table('nav')->where('type', 'middle')->max('vieworder');
            
		    $vieworder += 2;
			//显示在自定义导航栏中
			$data = array(
				'name' 		=> $cat_name,
				'ctype'   	=> 'a',
				'cid' 		=> $id,
				'ifshow' 	=> '1',
				'vieworder'	=> $vieworder,
				'opennew' 	=> '0',
				'url' 		=>  build_uri('article_cat', array('acid' => $id), $cat_name),
				'type' 		=> 'middle',
			);
            RC_DB::table('nav')->insert($data);
		}
		
		ecjia_admin::admin_log($cat_name, 'add', 'articlecat');
		$links[] = array('text' => RC_Lang::get('article::article.continue_add'), 'href' => RC_Uri::url('article/admin_articlecat/add'));
		$links[] = array('text' => RC_Lang::get('article::article.back_cat_list'), 'href' => RC_Uri::url('article/admin_articlecat/init'));
		return $this->showmessage(RC_Lang::get('article::article.catadd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('article/admin_articlecat/edit', array('id' => $id))));		
	}
	
	/**
	 * 编辑文章分类
	 */
	public function edit() {
		$this->admin_priv('article_cat_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.articlecat_edit')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('article::article.overview'),
			'content'	=> '<p>' . RC_Lang::get('article::article.edit_cat_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章分类#.E7.BC.96.E8.BE.91.E6.96.87.E7.AB.A0.E5.88.86.E7.B1.BB" target="_blank">'.RC_Lang::get('article::article.about_edit_cat').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('article::article.articlecat_edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('system::system.02_articlecat_list'), 'href' => RC_Uri::url('article/admin_articlecat/init')));
		
        $cat = $this->db_article_cat->article_cat_info($_GET['id']);
		if ($cat['cat_type'] == 2 || $cat['cat_type'] == 3 || $cat['cat_type'] ==4) {
			$this->assign('disabled', 1);
		}
		$options  = article_cat::article_cat_list(0, $cat['parent_id'], false);
		$select   = '';
		$selected = $cat['parent_id'];
		$id = intval($_GET['id']);
		if (!empty($options)) {
			foreach ($options as $var) {
				if (intval($var['cat_id']) == $id) {
					continue;
				}
				$select .= '<option value="' . $var['cat_id'] . '" ';
				$select .= ' cat_type="' . $var['cat_type'] . '" ';
				$select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
				$select .= '>';
				if ($var['level'] > 0) {
					$select .= str_repeat('&nbsp;', $var['level'] * 4);
				}
				$select .= htmlspecialchars($var['cat_name']) . '</option>';
			}
			unset($options);
		}
		$this->assign('cat', $cat);
		$this->assign('cat_select', $select);
		$this->assign('form_action', RC_Uri::url('article/admin_articlecat/update'));
		
		$this->display('articlecat_info.dwt');
	}

	public function update() {
		$this->admin_priv('article_cat_update', ecjia::MSGTYPE_JSON);
		
		$cat_name     = !empty($_POST['cat_name'])        ? trim($_POST['cat_name'])      : '';
		$cat_desc     = !empty($_POST['cat_desc'])        ? trim($_POST['cat_desc'])      : '';
		$keywords     = !empty($_POST['keywords'])        ? trim($_POST['keywords'])      : '';
		$sort_order   = !empty($_POST['sort_order'])      ? intval($_POST['sort_order'])  : 0;
		$show_in_nav  = !empty($_POST['show_in_nav'])     ? intval($_POST['show_in_nav']) : 0;
		
		$id          = intval($_POST['id']);
		$parent_id   = intval($_POST['parent_id']);

        if ($this->db_article_cat->article_cat_count(array('cat_name' => $cat_name, 'cat_id' => array('neq' => $id))) > 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::article.catname_exist'), stripslashes($cat_name)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (!isset($parent_id)) {
			$parent_id = 0;
		}

        $row = $this->db_article_cat->article_cat_info($id);
		//$cat_type = $row['cat_type'];
        $cat_type = 'article';
		
// 		if ($cat_type == 3 || $cat_type == 4) {
// 			$parent_id = $row['parent_id'];
// 		}
		
		/* 检查设定的分类的父分类是否合法 */
		$child_cat = article_cat::article_cat_list($id, 0, false, 0, 'article');
		if (!empty($child_cat)) {
			foreach ($child_cat as $child_data) {
				$catid_array[] = $child_data['cat_id'];
			}
		}
		if (in_array($parent_id, $catid_array)) {
			return $this->showmessage(sprintf(RC_Lang::get('article::article.parent_id_err'), stripslashes($cat_name)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
// 		if ($cat_type == 1 || $cat_type == 5) {
// 			if ($parent_id > 0) {
// 			    $p_cat_type = $this->db_article_cat->article_cat_field($parent_id, 'cat_type');
			     
// 				if ($p_cat_type == 4) {
// 					$cat_type = 5;
// 				} else {
// 					$cat_type = 1;
// 				}
// 			} else {
// 				$cat_type = 1;
// 			}
// 		}
		
        $info = $this->db_article_cat->article_cat_info($id);
		$data = array(
			'cat_name'	  => $cat_name,
			'cat_desc'	  => $cat_desc,
			'keywords'	  => $keywords,
			'parent_id'	  => $parent_id,
			'cat_type'	  => $cat_type,
			'sort_order'  => $sort_order,
			'show_in_nav' => $show_in_nav,
		);
       	$this->db_article_cat->article_cat_manage($data, array('cat_id' => $id));
        ecjia_admin::admin_log($cat_name, 'edit', 'articlecat');
        
		if ($cat_name != $info['cat_name']) {
			//如果分类名称发生了改变
			$data = array('name' => $cat_name);
		    RC_DB::table('nav')->where('ctype', 'a')->where('cid', $id)->where('type', 'middle')->update($data);
		}

		if ($show_in_nav != $info['show_in_nav']) {
			if ($show_in_nav == 1) {
				$nid = RC_DB::table('nav')->where('ctype', 'a')->where('cid', $id)->where('type', 'middle')->first();
				//不存在
				if (empty($nid)) {
				    $vieworder = RC_DB::table('nav')->where('type', 'middle')->max('vieworder');
				    
					$vieworder += 2;
					$uri = build_uri('article_cat', array('acid'=> $id), $cat_name);
					$data = array(
						'name' 		=> $cat_name,
						'ctype'	 	=> 'a',
						'cid' 		=> $id,
						'ifshow' 	=> '1',
						'vieworder' => $vieworder,
						'opennew' 	=> '0',
						'url' 		=> $uri,
						'type' 		=> 'middle',
					);
                  	RC_DB::table('nav')->insert($data);
				} else {
					$data = array('ifshow' => 1);
					RC_DB::table('nav')->where('ctype', 'a')->where('cid', $id)->where('type', 'middle')->update($data);
				}
			} else {
				//去除
				$data = array('ifshow' => 0);
          		RC_DB::table('nav')->where('ctype', 'a')->where('cid', $id)->where('type', 'middle')->update($data);
			}
		}
		$links[] = array('text' => RC_Lang::get('article::article.back_cat_list'), 'href' => RC_Uri::url('article/admin_articlecat/init'));
		
		return $this->showmessage(sprintf(RC_Lang::get('article::article.catedit_succed'), $cat_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('article/admin_articlecat/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑文章分类的排序
	 */
	public function edit_sort_order() {
		$this->admin_priv('article_cat_update', ecjia::MSGTYPE_JSON);
		
		$id    = intval($_POST['pk']);
		$order = intval($_POST['value']);
		if (!is_numeric($order)) {
			return $this->showmessage(RC_Lang::get('article::article.enter_int'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
		    if ($this->db_article_cat->article_cat_manage(array('sort_order' => $order), array('cat_id' => $id))) {
				return $this->showmessage(RC_Lang::get('article::article.catedit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('article/admin_articlecat/init')) );
			} else {
				return $this->showmessage(RC_Lang::get('article::article.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 删除文章分类
	 */
	public function remove() {
		$this->admin_priv('article_cat_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		/* 还有子分类，不能删除 */
		$count = $this->db_article_cat->article_cat_count(array('parent_id' => $id));
		if ($count > 0) {
			return $this->showmessage(RC_Lang::get('article::article.is_fullcat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}else {
			/* 非空的分类不允许删除 */
			$query = $this->db_article->article_count(array('cat_id' => $id));
			if ($query > 0) {
				return $this->showmessage(sprintf(RC_Lang::get('article::article.not_emptycat')), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$cat_name = $this->db_article_cat->article_cat_field($id, 'cat_name');

				$this->db_article_cat->article_cat_delete($id);
				RC_DB::table('nav')->where('ctype', 'a')->where('cid', $id)->where('type', 'middle')->delete();
				
				ecjia_admin::admin_log($cat_name, 'remove', 'articlecat');
				return $this->showmessage(RC_Lang::get('article::article.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}
	}
	
	/**
	 *快捷编辑改分类是否在导航栏上面显示
	 */
	public function toggle_show_in_nav() {
		$this->admin_priv('article_cat_update', ecjia::MSGTYPE_JSON);
		
		$id  = intval($_POST['id']);
		$val = intval($_POST['val']);
       	
       	RC_DB::table('article_cat')->where('cat_id', $id)->update(array('show_in_nav' => $val));
        if ($val == 1) {
        	$nid = RC_DB::table('nav')->where('ctype', 'a')->where('cid', $id)->where('type', 'middle')->first();
        	if (empty($nid)) {
				//不存在
               	$vieworder = RC_DB::table('nav')->where('type', 'middle')->max('vieworder');
                    
				$vieworder += 2;	
				$catname = $this->db_article_cat->article_cat_field($id, 'cat_name');
					
				$uri  = build_uri('article_cat', array('acid' => $id), $catname);
				$data = array(
					'name'		=> $catname,
					'ctype'		=> 'a',
					'cid'		=> $id,
					'ifshow'	=> '1',
					'vieworder' => $vieworder,
					'opennew'	=> '0',
					'url'		=> $uri,
					'type'		=> 'middle',
				);
				RC_DB::table('nav')->insert($data);
			} else {
				$data = array('ifshow' => 1);
				RC_DB::table('nav')->where('ctype', 'a')->where('cid', $id)->where('type', 'middle')->update($data);
			}
		} else {
			//去除
			$data = array('ifshow' => 0);
			RC_DB::table('nav')->where('ctype', 'a')->where('cid', $id)->where('type', 'middle')->update($data);
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
	}
}

// end
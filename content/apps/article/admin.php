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
 * ECJIA 管理中心文章处理程序文件
 *  @author songqian
 */
class admin extends ecjia_admin {
	private $db_article;
	private $db_article_cat;
	private $db_article_view;
	
	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_class('article_cat', 'article', false);
		RC_Loader::load_app_func('admin_article');
		RC_Loader::load_app_func('global');
		assign_adminlog_contents();
		
		$this->db_article 			= RC_Model::model('article/article_model');
		$this->db_article_cat		= RC_Model::model('article/article_cat_model');
		$this->db_article_view		= RC_Model::model('article/article_viewmodel');
		
		/* 加载所需js */
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('article_list', RC_App::apps_url('statics/js/article_list.js', __FILE__));
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		
		RC_Script::localize_script('article_list', 'js_lang', RC_Lang::get('article::article.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.article_list'), RC_Uri::url('article/admin/init')));
	}

	/**
	 * 文章列表
	 */
	public function init() {
		$this->admin_priv('article_manage');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.article_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('article::article.overview'),
			'content'	=> '<p>' . RC_Lang::get('article::article.article_list_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章列表" target="_blank">'.RC_Lang::get('article::article.about_article_list').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('article::article.article_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('system::system.article_add'), 'href' => RC_Uri::url('article/admin/add')));
		
		$result = ecjia_app::validate_application('goods');
		if (!is_ecjia_error($result)) {
			$this->assign('has_goods', 'has_goods');
		}
		
		/* 文章筛选时保留筛选的分类cat_id */
		$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		$this->assign('cat_select', article_cat::article_cat_list(0, $cat_id, false));
	
		/* 取得过滤条件 */
		$filter = array();
		$this->assign('filter', $filter);
		
		$article_list = $this->get_articles_list();
		$this->assign('article_list', $article_list);
		
		$this->assign('form_action', RC_Uri::url('article/admin/batch'));
		$this->assign('search_action', RC_Uri::url('article/admin/init'));

		$this->display('article_list.dwt');
	}

	/**
	 * 添加文章页面
	 */
	public function add() {
		$this->admin_priv('article_update');
		
		RC_Script::enqueue_script('dropper-jq', RC_Uri::admin_url('statics/lib/dropper-upload/jquery.fs.dropper.js'), array(), false, true);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('system::system.article_add')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('article::article.overview'),
			'content'	=> '<p>' . RC_Lang::get('article::article.add_article_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:添加文章" target="_blank">'.RC_Lang::get('article::article.about_add_article').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('system::system.article_add'));
		$this->assign('action_link', array('text' => RC_Lang::get('article::article.article_list'), 'href' => RC_Uri::url('article/admin/init')));
		$article = array();
		$article['is_open'] = 1;
		$this->assign('article', $article);
		$this->assign('cat_select', article_cat::article_cat_list(0, 0, false));
		
		$this->assign('form_action', RC_Uri::url('article/admin/insert'));

		$this->display('article_info.dwt');
	}

	/**
	 * 添加文章
	 */
	public function insert() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);

		$title 	      = !empty($_POST['title'])           ? trim($_POST['title'])         : '';
		$cat_id       = !empty($_POST['article_cat'])     ? intval($_POST['article_cat']) : 0;
		$article_type = !empty($_POST['article_type'])    ? intval($_POST['article_type']): 0;
		$is_open      = !empty($_POST['is_open'])         ? intval($_POST['is_open'])     : 0;
		$author       = !empty($_POST['author'])          ? trim($_POST['author'])        : '';
		$author_email = !empty($_POST['author_email'])    ? trim($_POST['author_email'])  : '';
		$keywords     = !empty($_POST['keywords'])        ? trim($_POST['keywords'])      : '';
		$content      = !empty($_POST['content'])         ? trim($_POST['content'])       : '';
		$link_url     = !empty($_POST['link_url'])        ? trim($_POST['link_url'])      : '';
		$description  = !empty($_POST['description'])     ? trim($_POST['description'])   : '';
    		
		$is_only = $this->db_article->article_count(array('title' => $title));
		if ($is_only > 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::article.title_exist'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		} else {
			$file_name = '';
			//获取上传文件的信息
			$file = !empty($_FILES['file']) ? $_FILES['file'] : '';
			//判断用户是否选择了文件
			if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
				$upload = RC_Upload::uploader('file', array('save_path' => 'data/article', 'auto_sub_dirs' => true));
				$upload->allowed_type(array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'txt', 'doc', 'docx', 'pdf', 'zip', 'rar'));
				$upload->allowed_mime(array('image/jpeg', 'image/png', 'image/gif', 'image/x-png', 'image/pjpeg',
				    'application/x-MS-bmp', 'text/plain', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				    'application/pdf', 'application/zip', 'application/x-rar-compressed'));
				
				$image_info = $upload->upload($file);
				/* 判断是否上传成功 */
				if (!empty($image_info)) {
					$file_name = $upload->get_position($image_info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}

			$extname = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
			if (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname) && empty($content)) {
				$open_type = 1;
			} elseif (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname) && !empty($content)) {
				$open_type = 2;
			} else {
				$open_type = 0;
			}

			$data = array(
				'title'        => $title,
				'cat_id'  	   => $cat_id,
				'article_type' => $article_type,
				'is_open'  	   => $is_open,
				'author'  	   => $author,
				'author_email' => $author_email,
				'keywords'     => $keywords,
				'content'      => $content,
				'add_time'     => RC_Time::gmtime(),
				'file_url'     => $file_name,
				'open_type'    => $open_type,
				'link'         => $link_url,
				'description'  => $description,
			);
			$article_id = $this->db_article->article_manage($data);
			/*释放文章缓存*/
			$orm_article_db = RC_Model::model('article/orm_article_model');
			$cache_article_info_key = 'article_info_'.$article_id;
			$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
			$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
			
			ecjia_admin::admin_log($title, 'add', 'article');

			$links[] = array('text' => RC_Lang::get('article::article.back_article_list'), 'href'=> RC_Uri::url('article/admin/init'));
			$links[] = array('text' => RC_Lang::get('article::article.continue_article_add'), 'href'=> RC_Uri::url('article/admin/add'));
			return $this->showmessage(RC_Lang::get('article::article.articleadd_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('article/admin/edit', array('id' => $article_id))));
		}
	}

	/**
	 * 添加自定义栏目
	 */
	public function insert_term_meta() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);

		$article_id   = !empty($_POST['article_id'])  ? intval($_POST['article_id'])              : 0;
		$key          = !empty($_POST['key'])         ? htmlspecialchars(trim($_POST['key']))     : '';
		$value        = !empty($_POST['value'])       ? htmlspecialchars(trim($_POST['value']))   : '';

		$data = array(
			'object_id'		=> $article_id,
			'object_type'	=> 'ecjia.article',
			'object_group'	=> 'article',
			'meta_key'		=> $key,
			'meta_value'	=> $value,
		);
		RC_DB::table('term_meta')->insertGetId($data);
		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		$cache_article_info_key = 'article_info_'.$article_id;
		$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
		$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存

		$res = array(
			'key'        => $key,
			'value'      => $value,
			'pjaxurl'    => RC_Uri::url('article/admin/edit', array('id' => $article_id))
		);
		return $this->showmessage(RC_Lang::get('article::article.add_custom_columns_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $res);
	}

	/**
	 * 更新自定义栏目
	 */
	public function update_term_meta() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);

	    $article_id = !empty($_POST['article_id']) ? intval($_POST['article_id']) : 0;
		$meta_id    = !empty($_POST['meta_id'])    ? intval($_POST['meta_id'])    : 0;

		if (empty($meta_id)) {
			return $this->showmessage(RC_Lang::get('article::article.miss_parameters_faild'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$key	= !empty($_POST['key'])     ? htmlspecialchars(trim($_POST['key']))     : '';
		$value	= !empty($_POST['value'])   ? htmlspecialchars(trim($_POST['value']))   : '';

		$data = array(
			'object_id'		=> $article_id,
			'object_type'	=> 'ecjia.article',
			'object_group'	=> 'article',
			'meta_key'		=> $key,
			'meta_value'	=> $value,
		);
		RC_DB::table('term_meta')->where('meta_id', $meta_id)->update($data);
		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		$cache_article_info_key = 'article_info_'.$article_id;
		$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
		$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
		
		$res = array(
			'key'		=> $key,
			'value'		=> $value,
			'pjaxurl'	=> RC_Uri::url('article/admin/edit', array('id' => $article_id))
		);
		return $this->showmessage(RC_Lang::get('article::article.update_custom_columns_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $res);
	}

	/**
	 * 删除自定义栏目
	 */
	public function remove_term_meta() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);
		
		$meta_id = !empty($_GET['meta_id']) ? intval($_GET['meta_id']) : 0;
		$article_id = RC_DB::table('term_meta')->where('meta_id', $meta_id)->where('object_type', 'ecjia.article')->where('object_group', 'article')->pluck('object_id');
		RC_DB::table('term_meta')->where('meta_id', $meta_id)->delete();
		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		$cache_article_info_key = 'article_info_'.$article_id;
		$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
		$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
		
		return $this->showmessage(RC_Lang::get('article::article.drop_custom_columns_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑
	 */
	public function edit() {
		$this->admin_priv('article_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.article_edit')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('article::article.overview'),
			'content'	=> '<p>' . RC_Lang::get('article::article.edit_article_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章列表#.E6.96.87.E7.AB.A0.E7.BC.96.E8.BE.91" target="_blank">'.RC_Lang::get('article::article.about_edit_article').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('article::article.article_edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('article::article.article_list'), 'href' => RC_Uri::url('article/admin/init')));
		
		$result = ecjia_app::validate_application('goods');
		if (!is_ecjia_error($result)) {
			$this->assign('has_goods', 'has_goods');
		}
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$article = $this->db_article->article_find($id);
		if (!empty($article['content'])) {
			$article['content'] = stripslashes($article['content']);
		}
		
		$extname = strtolower(substr($article['file_url'], strrpos($article['file_url'], '.') + 1));
		$img_arr = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
		if ($article['file_url']) {
			if (!in_array($extname, $img_arr)) {
				$article['image_url'] = RC_Uri::admin_url('statics/images/ecjiafile.png');
				$article['is_file'] = true;
			} else {
				$article['image_url'] = RC_Upload::upload_url($article['file_url']);
			}
		}
		
		$data_term_meta = RC_DB::table('term_meta')->select('meta_id', 'meta_key', 'meta_value')
			->where('object_id', $id)
			->where('object_type', 'ecjia.article')
			->where('object_group', 'article')
			->get();
		$this->assign('data_term_meta', $data_term_meta);
		
		$term_meta_key_list = RC_DB::table('term_meta')->select('meta_key')
			->where('object_id', $id)
			->where('object_type', 'ecjia.article')
			->where('object_group', 'article')
			->groupby('meta_key')
			->get();
		$this->assign('term_meta_key_list', $term_meta_key_list);
	
		$this->assign('action',	'edit');
		$this->assign('cat_select', article_cat::article_cat_list(0, $article['cat_id'], false));
		$this->assign('article', $article);
		$this->assign('form_action', RC_Uri::url('article/admin/update'));

		$this->display('article_info.dwt');
	}

	public function update() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);
	
		$id           = !empty($_POST['id']) 			  ? intval($_POST['id'])          : 0;
		$title 	      = !empty($_POST['title'])           ? trim($_POST['title'])         : '';
		$cat_id       = !empty($_POST['article_cat'])     ? intval($_POST['article_cat']) : 0;
		$article_type = !empty($_POST['article_type'])    ? intval($_POST['article_type']): 0;
		$is_open      = !empty($_POST['is_open'])         ? intval($_POST['is_open'])     : 0;
		$author       = !empty($_POST['author'])          ? trim($_POST['author'])        : '';
		$author_email = !empty($_POST['author_email'])    ? trim($_POST['author_email'])  : '';
		$keywords     = !empty($_POST['keywords'])        ? trim($_POST['keywords'])      : '';
		$content      = !empty($_POST['content'])         ? trim($_POST['content'])       : '';
		$link_url     = !empty($_POST['link_url'])        ? trim($_POST['link_url'])      : '';
		$description  = !empty($_POST['description'])     ? trim($_POST['description'])   : '';
		
		$is_only = $this->db_article->article_count(array('title' => $title, 'article_id' => array('neq' => $id)));
		
		if ($is_only != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::article.title_exist'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$old_file_name = $this->db_article->article_field($id, 'file_url');

			//获取上传文件的信息
			$file = !empty($_FILES['file']) ? $_FILES['file'] : '';
			//判断用户是否选择了文件
			if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
				$upload = RC_Upload::uploader('file', array('save_path' => 'data/article', 'auto_sub_dirs' => true));
			    $upload->allowed_type(array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'txt', 'doc', 'docx', 'pdf', 'zip', 'rar'));
			    $upload->allowed_mime(array('image/jpeg', 'image/png', 'image/gif', 'image/x-png', 'image/pjpeg',
			    'application/x-MS-bmp', 'text/plain', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			    'application/pdf', 'application/zip', 'application/x-rar-compressed'));
			    
				$image_info = $upload->upload($file);
				/* 判断是否上传成功 */
				if (!empty($image_info)) {
					$file_name = $upload->get_position($image_info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
				$file_name = $old_file_name;
			}
			
			$extname = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
			if (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname) && empty($content)) {
				$open_type = 1;
			} elseif (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname) && !empty($content)) {
				$open_type = 2;
			} else {
				$open_type = 0;
			}
			$data = array(
			    'article_id'   => $id,
				'title'        => $title,
				'cat_id'  	   => $cat_id,
				'article_type' => $article_type,
				'is_open'  	   => $is_open,
				'author'  	   => $author,
				'author_email' => $author_email,
				'keywords'     => $keywords,
				'content'      => $content,
				'file_url'     => $file_name,
				'open_type'    => $open_type,
				'link'         => $link_url,
				'description'  => $description,
			);
			$query = $this->db_article->article_manage($data);
			
			/*释放文章缓存*/
			$orm_article_db = RC_Model::model('article/orm_article_model');
			$cache_article_info_key = 'article_info_'.$id;
			$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
			$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
			
			if ($query) {
			    ecjia_admin::admin_log($title, 'edit', 'article');
			    
				$note = sprintf(RC_Lang::get('article::article.articleedit_succeed'), stripslashes($title));
				return $this->showmessage($note, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array( 'pjaxurl' => RC_Uri::url('article/admin/edit', array('id' => $id))));
			} else {
				return $this->showmessage(RC_Lang::get('article::article.articleedit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 预览
	 */
	public function preview() {
		$this->admin_priv('article_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.preview_article')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('article::article.overview'),
			'content'	=> '<p>' . RC_Lang::get('article::article.preview_article_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章列表#.E9.A2.84.E8.A7.88.E6.96.87.E7.AB.A0" target="_blank">'.RC_Lang::get('article::article.about_preview_article').'</a>') . '</p>'
		);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		
		$this->assign('ur_here', RC_Lang::get('article::article.preview_article'));
		$this->assign('action_linkedit', array('text' => RC_Lang::get('article::article.article_editbtn'), 'href' => RC_Uri::url('article/admin/edit', array('id' => $id))));
		$this->assign('action_link', array('text' => RC_Lang::get('article::article.back_article_list'), 'href' => RC_Uri::url('article/admin/init')));
		
		$article = $this->db_article->article_find($id);
		$article['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $article['add_time']);
		
		$this->assign('article', $article);
		$this->assign('cat_select', article_cat::article_cat_list(0, $article['cat_id']));

		$this->display('preview.dwt');
	}

	/**
	 * 关联商品
	 */
	public function link_goods() {
		$this->admin_priv('article_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.edit_link_goods')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('article::article.overview'),
			'content'	=> '<p>' . RC_Lang::get('article::article.link_goods_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章列表#.E5.85.B3.E8.81.94.E5.95.86.E5.93.81" target="_blank">'.RC_Lang::get('article::article.about_link_goods').'</a>') . '</p>'
		);
		
		$this->assign('action_link', array('href' => RC_Uri::url('article/admin/init'), 'text' => RC_Lang::get('article::article.article_list')));
		$this->assign('ur_here', RC_Lang::get('article::article.edit_link_goods'));
		
		$article_id = !empty($_GET['id']) ? $_GET['id'] : '';
		$linked_goods = RC_DB::table('goods_article')
			->leftJoin('goods', 'goods.goods_id', '=', 'goods_article.goods_id')
			->where('goods_article.article_id', $article_id)
			->select('goods.goods_id', 'goods.goods_name')
			->get();

		$this->assign('link_goods_list', $linked_goods);
		
		$this->assign('cat_list', RC_Api::api('goods', 'get_goods_category'));
		$this->assign('brand_list', RC_Api::api('goods', 'get_goods_brand'));

		$this->display('link_goods.dwt');
	}

	/**
	 * 添加商品关联
	 */
	public function insert_link_goods() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);

		$article_id		= !empty($_GET['id']) 			? intval($_GET['id']) 	: 0;
		$linked_array 	= !empty($_GET['linked_array']) ? $_GET['linked_array'] : '';

		RC_DB::table('goods_article')->where('article_id', $article_id)->delete();

		$data = array();
		if (!empty($linked_array)) {
			foreach ($linked_array AS $val) {
				$data[] = array(
					'article_id'   => $article_id,
					'goods_id'     => $val['goods_id'],
					'admin_id'     => $_SESSION['admin_id'],
				);
			}
		}
		
		if (!empty($data)) {
			RC_DB::table('goods_article')->insert($data);
		}
		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		$cache_article_info_key = 'article_info_'.$article_id;
		$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
		$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
		
		$title = $this->db_article->article_field($article_id, 'title');

		ecjia_admin::admin_log(RC_Lang::get('article::article.tab_goods').'，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
		return $this->showmessage(RC_Lang::get('article::article.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin/link_goods', array('id' => $article_id))));
	}

	/**
	 * 编辑文章标题
	 */
	public function edit_title() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);

		$id    	= !empty($_POST['pk'])    ? intval($_POST['pk'])      : 0;
		$title 	= !empty($_POST['value']) ? trim($_POST['value'])     : '';
		$cat_id = !empty($_POST['name'])  ? intval($_POST['name'])    : 0;

		if (empty($title)) {
			return $this->showmessage(RC_Lang::get('article::article.article_title_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($this->db_article->article_count(array('title' => $title, 'cat_id' => $cat_id)) != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::article.title_exist'), $title), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
		    $data = array(
		        'article_id'  => $id,
		        'title'       => $title
		    );
			$query = $this->db_article->article_manage($data);
			/*释放文章缓存*/
			$orm_article_db = RC_Model::model('article/orm_article_model');
			$cache_article_info_key = 'article_info_'.$id;
			$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
			$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
	
			if ($query) {
				ecjia_admin::admin_log($title, 'edit', 'article');
				return $this->showmessage(sprintf(RC_Lang::get('article::article.edit_title_success'), $title), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($title)));
			} else {
				return $this->showmessage(RC_Lang::get('article::article.articleedit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}

	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);

		$id   = !empty($_POST['id'])  ? intval($_POST['id'])  : 0;
		$val  = !empty($_POST['val']) ? intval($_POST['val']) : 0;
		
		$data = array(
		    'article_id'  => $id,
		    'is_open'     => $val
		);
		$this->db_article->article_manage($data);
		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		$cache_article_info_key = 'article_info_'.$id;
		$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
		$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存

		$title = $this->db_article->article_field($id, 'title');

		if ($val == 1) {
			ecjia_admin::admin_log(RC_Lang::get('article::article.display_article').'，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
		} else {
			ecjia_admin::admin_log(RC_Lang::get('article::article.hide_article').'，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
		}
		return $this->showmessage(RC_Lang::get('article::article.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin/init')));
	}

	/**
	 * 删除文章主题
	 */
	public function remove() {
		$this->admin_priv('article_delete', ecjia::MSGTYPE_JSON);

		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$article_info = $this->db_article->article_find($id);

		if (!empty($old_url) && strpos($article_info['file_url'], 'http://') === false && strpos($article_info['file_url'], 'https://') === false) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $article_info['file_url']);
		}

		if ($this->db_article->article_delete($id)) {
			RC_DB::table('comment')->where('comment_type', 1)->where('id_value', $id)->delete();
			/*释放文章缓存*/
			$orm_article_db = RC_Model::model('article/orm_article_model');
			$cache_article_info_key = 'article_info_'.$id;
			$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
			$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
			
			ecjia_admin::admin_log(addslashes($article_info['title']), 'remove', 'article');
			return $this->showmessage(RC_Lang::get('article::article.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('article::article.edit_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 删除附件
	 */
	public function delfile() {
		$this->admin_priv('article_delete', ecjia::MSGTYPE_JSON);

		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$old_url = $this->db_article->article_field($id, 'file_url');

		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path() . $old_url);
		
		$data = array(
		    'article_id'  => $id,
		    'file_url'    => '',
		    'open_type'   => 0
		);
		$this->db_article->article_manage($data);
		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		$cache_article_info_key = 'article_info_'.$id;
		$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
		$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
		
		
		return $this->showmessage(RC_Lang::get('article::article.delete_attachment_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin/edit', array('id' => $id))));
	}

	/**
	 * 批量操作
	 */
	public function batch() {
		$action = !empty($_GET['sel_action']) ? trim($_GET['sel_action']) : 'move_to';
		$article_ids = !empty($_POST['article_id']) ? $_POST['article_id'] : '';

		if ($action == 'button_remove') {
			$this->admin_priv('article_delete', ecjia::MSGTYPE_JSON);
		} else {
			$this->admin_priv('article_manage', ecjia::MSGTYPE_JSON);
		}
		$info = $this->db_article->article_batch($article_ids, 'select');
		
		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		
		if (!empty($article_ids)) {
			switch ($action) {
				//批量删除
				case 'button_remove':
					$this->db_article->article_batch($article_ids, 'delete');

					$disk = RC_Filesystem::disk();
					foreach ($info as $v) {
						if (!empty($v['file_url']) && strpos($v['file_url'], 'http://') === false && strpos($v['file_url'], 'https://') === false) {
							$disk->delete(RC_Upload::upload_path() . $v['file_url']);
						}
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['article_id'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						
						ecjia_admin::admin_log($v['title'], 'batch_remove', 'article');
					}

					return $this->showmessage(RC_Lang::get('article::article.batch_handle_ok_del'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin/init')));
					break;

				//批量隐藏
				case 'button_hide' :
					$data = array( 'is_open' => '0', );
					$this->db_article->article_batch($article_ids, 'update', $data);

					foreach ($info as $v) {
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['article_id'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						
						ecjia_admin::admin_log(RC_Lang::get('article::article.hide_article').'，'.RC_Lang::get('article::article.article_title_is').$v['title'], 'batch_setup', 'article');
					}
					return $this->showmessage(RC_Lang::get('article::article.batch_handle_ok_hide'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin/init')));
					break;


				//批量显示
				case 'button_show' :
					$data = array( 'is_open' => '1', );
					$this->db_article->article_batch($article_ids, 'update', $data);

					foreach ($info as $v) {
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['article_id'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						
						ecjia_admin::admin_log(RC_Lang::get('article::article.hide_article').'，'.RC_Lang::get('article::article.article_title_is').$v['title'], 'batch_setup', 'article');
					}
					return $this->showmessage(RC_Lang::get('article::article.batch_handle_ok_show'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin/init')));
					break;

				//批量转移分类
				case 'move_to' :
					$target_cat = intval($_GET['target_cat']);
					if ($target_cat <= 0) {
						return $this->showmessage(RC_Lang::get('article::article.no_select_act'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
					if (!is_array($article_ids)){
						$article_ids = explode(',', $article_ids);
					}
					$data = array('cat_id' => $target_cat);
					$this->db_article->article_batch($article_ids, 'update', $data);
					
					$cat_name = $this->db_article_cat->article_cat_field($target_cat, 'cat_name');

					foreach ($info as $v) {
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['article_id'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						
						ecjia_admin::admin_log(RC_Lang::get('article::article.move_article').$v['title'].RC_Lang::get('article::article.to_category').$cat_name, 'batch_setup', 'article');
					}

					return $this->showmessage(RC_Lang::get('article::article.batch_handle_ok_move'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin/init')));
					break;

				default :
					break;
			}
		}
	}
	
	/**
	 * 搜索商品，仅返回名称及ID
	 */
	public function get_goods_list() {
	    $filter = $_GET['JSON'];
	    $arr = RC_Api::api('goods', 'get_goods_list', $filter);
	    $opt = array();
	    if (!empty($arr)) {
	        foreach ($arr AS $key => $val) {
	            $opt[] = array(
	                'value' => $val['goods_id'],
	                'text'  => $val['goods_name'],
	                'data'  => $val['shop_price']
	            );
	        }
	    }
	    return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $opt));
	}
	
	/**
	 * 获取文章列表
	 */
	private function get_articles_list() {
		$filter = array();
		$filter['keywords']   = empty($_GET['keywords'])      ? ''                : trim($_GET['keywords']);
		$filter['cat_id']     = empty($_GET['cat_id'])        ? 0                 : intval($_GET['cat_id']);
		$filter['sort_by']    = empty($_GET['sort_by'])       ? 'a.article_id'    : trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order'])    ? 'DESC'            : trim($_GET['sort_order']);
	
		$db_article = RC_DB::table('article as a')
			->leftJoin('article_cat as ac', RC_DB::raw('ac.cat_id'), '=', RC_DB::raw('a.cat_id'));
		
		//不获取系统帮助文章的过滤
		$db_article->where(RC_DB::raw('a.cat_id'), '!=', '0')->where(RC_DB::raw('ac.cat_type'), '!=', 5);
		
		if (!empty($filter['keywords'])) {
			$db_article ->where(RC_DB::raw('title'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
		}
		if ($filter['cat_id'] && ($filter['cat_id'] > 0)) {
			$db_article ->whereIn(RC_DB::raw('a.cat_id'), article_cat::get_children_list($filter['cat_id']));
		}
		
		$count = $db_article->select('article_id')->count();
		$page = new ecjia_page($count, 15, 5);
		
		$result = $db_article->select(RC_DB::raw('a.*'), RC_DB::raw('ac.cat_id'), RC_DB::raw('ac.cat_name'), RC_DB::raw('ac.cat_type'), RC_DB::raw('ac.sort_order'))
			->orderby(RC_DB::raw($filter['sort_by']), $filter['sort_order'])
			->take(15)->skip($page->start_id-1)->get();
	
		$arr = array();
		if (!empty($result)) {
			foreach ($result as $rows) {
				if (isset($rows['add_time'])) {
					$rows['date'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
				}
				$arr[] = $rows;
			}
		}
		return array('arr' => $arr, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

// end
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
		RC_Loader::load_app_class('article_list', 'article', false);
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
		RC_Script::enqueue_script('comment_list', RC_App::apps_url('statics/js/comment_list.js', __FILE__));
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
		$publishby = trim($_GET['publishby']);
		if (!empty($publishby)) {
			$href = RC_Uri::url('article/admin/add', array('publishby' => $publishby));
		} else {
			$href = RC_Uri::url('article/admin/add');
		}
		$this->assign('ur_here', RC_Lang::get('article::article.article_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('system::system.article_add'), 'href' => $href));
		
		$result = ecjia_app::validate_application('goods');
		if (!is_ecjia_error($result)) {
			$this->assign('has_goods', 'has_goods');
		}
		
		/* 文章筛选时保留筛选的分类cat_id */
		$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		$this->assign('cat_select', article_cat::article_cat_list(0, $cat_id, false, 0, 'article'));
	
		/* 取得过滤条件 */
		$filter = array();		
		$article_list = $this->get_articles_list();
		$this->assign('article_list', $article_list);
		$this->assign('type_count', $article_list['count']);
		$this->assign('suggest_type_count', $article_list['suggest_type_count']);
		$this->assign('filter', $article_list['filter']);
		if (isset($_GET['publishby']) && ($_GET['publishby'] == 'store')) {
			$this->assign('form_action', RC_Uri::url('article/admin/batch', array('publishby' =>'store')));
			$this->assign('search_action', RC_Uri::url('article/admin/init', array('publishby' => 'store')));
		} else {
			$this->assign('form_action', RC_Uri::url('article/admin/batch'));
			$this->assign('search_action', RC_Uri::url('article/admin/init'));
		}
		$this->assign('type', $_GET['type']);	
		$this->assign('suggest_type', $_GET['suggest_type']);
		$this->assign('publishby', $publishby);
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
		$publishby = trim($_GET['publishby']);
		$this->assign('ur_here', RC_Lang::get('system::system.article_add'));
		if (!empty($publishby)) {
			$href = RC_Uri::url('article/admin/init', array('publishby' => $publishby));
		} else {
			$href = RC_Uri::url('article/admin/init');
		}
		$this->assign('action_link', array('text' => RC_Lang::get('article::article.article_list'), 'href' => $href));
		$article = array();
		$article['article_approved'] = 1;
		//加载配置中分类数据
		$article_type = RC_Loader::load_app_config('article_type');
		$this->assign('article_type', $article_type);

		$this->assign('article', $article);
		$this->assign('cat_select', article_cat::article_cat_list(0, 0, false, 0, 'article'));
		
		$this->assign('form_action', RC_Uri::url('article/admin/insert'));
		$this->assign('publishby',$publishby);
		$this->display('article_info.dwt');
	}

	/**
	 * 添加文章
	 */
	public function insert() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);

		$title 	      		= !empty($_POST['title'])           ? trim($_POST['title'])         : '';
		$cat_id       		= !empty($_POST['article_cat'])     ? intval($_POST['article_cat']) : 0;
		$article_type 		= !empty($_POST['article_type'])    ? trim($_POST['article_type'])  : 'article';
		$article_approved   = !empty($_POST['article_approved'])? trim($_POST['article_approved'])     : 0;
		$author       		= !empty($_POST['author'])          ? trim($_POST['author'])        : '';
		$author_email 		= !empty($_POST['author_email'])    ? trim($_POST['author_email'])  : '';
		$keywords     		= !empty($_POST['keywords'])        ? trim($_POST['keywords'])      : '';
		$content      		= !empty($_POST['content'])         ? trim($_POST['content'])       : '';
		$link_url     		= !empty($_POST['link_url'])        ? trim($_POST['link_url'])      : '';
		$description  		= !empty($_POST['description'])     ? trim($_POST['description'])   : '';
		$suggest_type  		= !empty($_POST['suggest_type'])     ? trim($_POST['suggest_type'])   : 0;
		$publishby  		= !empty($_POST['publishby'])     ? trim($_POST['publishby'])   : '';
		
		if (empty($description)) {
			return $this->showmessage('文章描述不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		}
		
		/*文章类型相关条件*/
		if (($article_type == 'article') && empty($content)) {
			return $this->showmessage('文章类型为普通文章时，文章内容不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		}
		if (($article_type == 'redirect') && (strstr($link_url, 7) == false)) {
			return $this->showmessage('文章类型为跳转链接时，外部链接不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		}
			
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

			//$extname = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
			//if (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname) && empty($content)) {
			//	$open_type = 1;
			//} elseif (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname) && !empty($content)) {
			//	$open_type = 2;
			//} else {
			//	$open_type = 0;
			//}
			
			if (isset($_FILES['cover_image']['error']) && $_FILES['cover_image']['error'] == 0 || ! isset($_FILES['cover_image']['error']) && isset($_FILES['cover_image']['tmp_name']) && $_FILES['cover_image']['tmp_name'] != 'none') {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/article', 'auto_sub_dirs' => false));
				$image_info = $upload->upload($_FILES['cover_image']);
				if (!empty($image_info)) {
					$cover_image = $upload->get_position($image_info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			/*文章类型相关条件*/
			if (($article_type == 'download') && empty($file_name)) {
				return $this->showmessage('文章类型为点击标题直接下载时，上传文件不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			}
			if (($article_type == 'related') && (empty($file_name) || empty($content))) {
				return $this->showmessage('文章类型为内容底部相关下载时，文章内容和上传文件都不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			}
			$data = array(
				'title'        		=> $title,
				'cat_id'  	   		=> $cat_id,
				'article_type' 		=> $article_type,
				'article_approved' 	=> $article_approved,
				'author'  	   		=> $author,
				'author_email' 		=> $author_email,
				'keywords'     		=> $keywords,
				'content'      		=> $content,
				'add_time'     		=> RC_Time::gmtime(),
				'file_url'     		=> $file_name,
				'cover_image'  		=> $cover_image,
				'link'         		=> $link_url,
				'description'  		=> $description,
				'suggest_type'		=> $suggest_type
			);
			
			$article_id = $this->db_article->article_manage($data);
			/*释放文章缓存*/
			$orm_article_db = RC_Model::model('article/orm_article_model');
			$cache_article_info_key = 'article_info_'.$article_id;
			$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
			$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
			
			ecjia_admin::admin_log($title, 'add', 'article');
			if (!empty($publishby)) {
				$hrefinit = RC_Uri::url('article/admin/init', array('publishby' => $publishby));
				$hrefadd =  RC_Uri::url('article/admin/add', array('publishby' => $publishby));
				$pjaxurl = RC_Uri::url('article/admin/edit', array('id' => $article_id, 'publishby' => $publishby));
 			} else {
 				$hrefinit = RC_Uri::url('article/admin/init');
 				$hrefadd =  RC_Uri::url('article/admin/add');
 				$pjaxurl = RC_Uri::url('article/admin/edit', array('id' => $article_id));
 			}
			$links[] = array('text' => RC_Lang::get('article::article.back_article_list'), 'href'=> $hrefinit);
			$links[] = array('text' => RC_Lang::get('article::article.continue_article_add'), 'href'=> $hrefadd);
			return $this->showmessage(RC_Lang::get('article::article.articleadd_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => $pjaxurl));
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
		
		$publishby = trim($_GET['publishby']);
		if (!empty($publishby)) {
			$href_link	= RC_Uri::url('article/admin/init', array('publishby' => $publishby));
		} else {
			$href_link	= RC_Uri::url('article/admin/init');
		}
		
		$this->assign('ur_here', RC_Lang::get('article::article.article_edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('article::article.article_list'), 'href' => $href_link));
		
		$result = ecjia_app::validate_application('goods');
		if (!is_ecjia_error($result)) {
			$this->assign('has_goods', 'has_goods');
		}
		//加载配置中分类数据
		$article_type = RC_Loader::load_app_config('article_type');
		$this->assign('article_type', $article_type);
		
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
		$this->assign('cat_select', article_cat::article_cat_list(0, $article['cat_id'], false, 0, 'article'));
		$this->assign('article', $article);
		$this->assign('form_action', RC_Uri::url('article/admin/update'));
		$this->assign('publishby', $publishby);
		$this->display('article_info.dwt');
	}

	public function update() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);
	
		$id           		= !empty($_POST['id']) 			  ? intval($_POST['id'])          : 0;
		$title 	      		= !empty($_POST['title'])           ? trim($_POST['title'])         : '';
		$cat_id       		= !empty($_POST['article_cat'])     ? intval($_POST['article_cat']) : 0;
		$article_type 		= !empty($_POST['article_type'])    ? trim($_POST['article_type'])  : 'article';
		$article_approved   = !empty($_POST['article_approved'])? trim($_POST['article_approved'])     : 0;
		$author       		= !empty($_POST['author'])          ? trim($_POST['author'])        : '';
		$author_email 		= !empty($_POST['author_email'])    ? trim($_POST['author_email'])  : '';
		$keywords     		= !empty($_POST['keywords'])        ? trim($_POST['keywords'])      : '';
		$content      		= !empty($_POST['content'])         ? trim($_POST['content'])       : '';
		$link_url     		= !empty($_POST['link_url'])        ? trim($_POST['link_url'])      : '';
		$description  		= !empty($_POST['description'])     ? trim($_POST['description'])   : '';
		$suggest_type  		= !empty($_POST['suggest_type'])     ? trim($_POST['suggest_type'])   : 0;
		$publishby  		= !empty($_POST['publishby'])     ? trim($_POST['publishby'])   : '';
		
		
		if (empty($description)) {
			return $this->showmessage('文章描述不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		}
		
		/*文章类型相关条件*/
		if (($article_type == 'article') && empty($content)) {
			return $this->showmessage('文章类型为普通文章时，文章内容不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		}
		if (($article_type == 'redirect') && (strstr($link_url, 7) == false)) {
			return $this->showmessage('文章类型为跳转链接时，外部链接不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		}
		
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
			
			//$extname = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
			//if (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname) && empty($content)) {
			//	$open_type = 1;
			//} elseif (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'), $extname) && !empty($content)) {
			//	$open_type = 2;
			//} else {
			//	$open_type = 0;
			//}
			
			/*文章封面*/
			$old_pic = RC_DB::TABLE('article')->where('article_id', $id)->pluck('cover_image');
			if (isset($_FILES['cover_image']['error']) && $_FILES['cover_image']['error'] == 0 || ! isset($_FILES['cover_image']['error']) && isset($_FILES['cover_image']['tmp_name']) && $_FILES['cover_image']['tmp_name'] != 'none') {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/article', 'auto_sub_dirs' => false));
				$image_info = $upload->upload($_FILES['cover_image']);
				if (!empty($image_info)) {
					$upload->remove($old_pic);
					$cover_image = $upload->get_position($image_info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
				$cover_image = $old_pic;
			}
			/*文章类型相关条件*/
			if (($article_type == 'download') && empty($file_name)) {
				return $this->showmessage('文章类型为点击标题直接下载时，上传文件不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			}
			if (($article_type == 'related') && (empty($file_name) || empty($content))) {
				return $this->showmessage('文章类型为内容底部相关下载时，文章内容和上传文件都不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			}
			$data = array(
			    'article_id'   		=> $id,
				'title'        		=> $title,
				'cat_id'  	   		=> $cat_id,
				'article_type' 		=> $article_type,
				'article_approved'  => $article_approved,
				'author'  	   		=> $author,
				'author_email' 		=> $author_email,
				'keywords'     		=> $keywords,
				'content'      		=> $content,
				'file_url'     		=> $file_name,
				'link'         		=> $link_url,
				'cover_image'		=> $cover_image,
				'description'  		=> $description,
				'suggest_type'		=> $suggest_type,
				'edit_time'			=> RC_Time::gmtime()
			);
			$query = $this->db_article->article_manage($data);
			
			/*释放文章缓存*/
			$orm_article_db = RC_Model::model('article/orm_article_model');
			$cache_article_info_key = 'article_info_'.$id;
			$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
			$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
			
			if (!empty($publishby)) {
				$pjaxurl = RC_Uri::url('article/admin/edit', array('id' => $id, array('publishby' => $publishby)));
			} else {
				$pjaxurl = RC_Uri::url('article/admin/edit', array('id' => $id));
			}
			
			if ($query) {
			    ecjia_admin::admin_log($title, 'edit', 'article');
			    
				$note = sprintf(RC_Lang::get('article::article.articleedit_succeed'), stripslashes($title));
				return $this->showmessage($note, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array( 'pjaxurl' => $pjaxurl));
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
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		
		RC_Hook::do_action('article_admin_priview_handler', $id);

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
		
		$publishby = trim($_GET['publishby']);
		if (!empty($publishby)) {
			$href_linkedit = RC_Uri::url('article/admin/edit', array('id' => $id, 'publishby' => $publishby));
			$href_link	= RC_Uri::url('article/admin/init', array('publishby' => $publishby));
		} else {
			$href_linkedit = RC_Uri::url('article/admin/edit', array('id' => $id));
			$href_link	= RC_Uri::url('article/admin/init');
		}
		
		$this->assign('ur_here', RC_Lang::get('article::article.preview_article'));
		$this->assign('action_linkedit', array('text' => RC_Lang::get('article::article.article_editbtn'), 'href' => $href_linkedit));
		$this->assign('action_link', array('text' => RC_Lang::get('article::article.back_article_list'), 'href' => $href_link));
		
		$article = $this->db_article->article_find($id);
		$article['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $article['add_time']);
		$article['content'] = preg_replace('/\\\"/', '"', $article['content']);
		$this->assign('article', $article);
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
		
		$publishby = trim($_GET['publishby']);
		if (!empty($publishby)) {
			$href	= RC_Uri::url('article/admin/init', array('publishby' => $publishby));
		} else {
			$href	= RC_Uri::url('article/admin/init');
		}
		
		$this->assign('action_link', array('href' => $href, 'text' => RC_Lang::get('article::article.article_list')));
		$this->assign('ur_here', RC_Lang::get('article::article.edit_link_goods'));
		
		$article_id = !empty($_GET['id']) ? $_GET['id'] : '';
		$linked_goods = RC_DB::table('goods_article')
			->leftJoin('goods', 'goods.goods_id', '=', 'goods_article.goods_id')
			->where('goods_article.article_id', $article_id)
			->select('goods.goods_id', 'goods.goods_name')
			->get();

		$this->assign('link_goods_list', $linked_goods);
		$this->assign('publishby', $publishby);
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
		$publishby  	= !empty($_GET['publishby'])     ? trim($_GET['publishby'])   : '';
		
		RC_DB::table('goods_article')->where('article_id', $article_id)->delete();

		$data = array();
		if (!empty($linked_array)) {
			foreach ($linked_array AS $val) {
				$data[] = array(
					'article_id'   => $article_id,
					'goods_id'     => $val['goods_id'],
					'admin_id'	   => 0
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
		if (!empty($publishby)) {
			$pjaxurl = RC_Uri::url('article/admin/link_goods', array('id' => $article_id, 'publishby' => $publishby));
		} else {
			$pjaxurl = RC_Uri::url('article/admin/link_goods', array('id' => $article_id));
		}
		
		return $this->showmessage(RC_Lang::get('article::article.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
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
	 * 文章列表更新文章的状态
	 */
	public function check() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);
	
		$id		 			= !empty($_GET['id']) 		? intval($_GET['id'])		: 0;
		$publishby 			= !empty($_GET['publishby'])	? trim($_GET['publishby'])	: '';
		$type				= !empty($_GET['type'])	? trim($_GET['type'])	: '';
		$allow 				= !empty($_POST['check']) 	? $_POST['check']			: '';
		$article_approved	= $_POST['article_approved'];
		$title = RC_DB::table('article')->where('article_id', $id)->pluck('title');
		
		if (isset($publishby) && $publishby === 'store') {
			$pjaxurl = RC_Uri::url('article/admin/init', array('publishby' => 'store', 'type' => $type));
		} else {
			$pjaxurl = RC_Uri::url('article/admin/init', array('type' => $type));
		}
	
		if ($allow == 'allow') {
			/*审核通过*/
			$data = array(
					'article_id' 		=> $id,
					'article_approved'  => '1'
			);
			RC_DB::table('article')->where('article_id', $id)->update($data);
			$message = '成功切换文章状态';
			ecjia_admin::admin_log('通过文章，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
		} elseif ($allow == 'forbid' || $allow == 'no_rubbish' || $allow == 'no_trash') {
			/*切换为待审核*/
			$data = array(
					'article_id' 		=> $id,
					'article_approved'  => '0'
			);
			RC_DB::table('article')->where('article_id', $id)->update($data);
			$message = '成功切换文章状态';
			if ($allow == 'forbid') {
				ecjia_admin::admin_log('设为待审核文章，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
			} elseif ($allow == 'no_rubbish' || $allow == 'no_trash') {
				ecjia_admin::admin_log('还原文章，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
			} 
		} elseif ($allow == "rubbish_article") {
			/*垃圾文章*/
			$data = array(
					'article_id' 		=> $id,
					'article_approved'  => 'spam'
			);
			RC_DB::table('article')->where('article_id', $id)->update($data);
			$message = '成功设置文章为垃圾文章';
			ecjia_admin::admin_log('设为垃圾文章，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
		} elseif ($allow == "trashed_article") {
			/*文章移到回收站*/
			$data = array(
					'article_id' 		=> $id,
					'article_approved'  => 'trash'
			);
			RC_DB::table('article')->where('article_id', $id)->update($data);
			$message = '移除文章至回收站成功';
			ecjia_admin::admin_log('文章移到回收站，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
		}

		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
	}
	
	/**
	 * 文章是否置顶
	 */
	public function top() {
		$this->admin_priv('article_update', ecjia::MSGTYPE_JSON);
	
		$id		 			= !empty($_GET['id']) 		? intval($_GET['id'])		: 0;
		$publishby 			= !empty($_GET['publishby'])	? trim($_GET['publishby'])	: '';
		$type				= !empty($_GET['type'])	? trim($_GET['type'])	: '';
		$allow 				= !empty($_POST['check']) 	? $_POST['check']			: '';
		$title = RC_DB::table('article')->where('article_id', $id)->pluck('title');
		if (isset($publishby) && $publishby === 'store') {
			$pjaxurl = RC_Uri::url('article/admin/init', array('publishby' => 'store', 'type' => $type));
		} else {
			$pjaxurl = RC_Uri::url('article/admin/init', array('type' => $type));
		}
	
		if ($allow == 'allow') {
			/*审核通过*/
			$data = array(
					'article_id' 		=> $id,
					'suggest_type'  	=> 'stickie'
			);
			RC_DB::table('article')->where('article_id', $id)->update($data);
			$message = '成功切换文章是否置顶';
			ecjia_admin::admin_log('设为置顶文章，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
		} elseif ($allow == 'forbid') {
			/*切换为待审核*/
			$data = array(
					'article_id' 		=> $id,
					'suggest_type'  	=> '0'
			);
			RC_DB::table('article')->where('article_id', $id)->update($data);
			$message = '成功切换文章是否置顶';
			if ($allow == 'forbid') {
				ecjia_admin::admin_log('设为默认文章，'.RC_Lang::get('article::article.article_title_is').$title, 'setup', 'article');
			} 
		} 
	
		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
	}
	
	
	
	
	/**
	 * 删除文章
	 */
	public function remove() {
		$this->admin_priv('article_delete', ecjia::MSGTYPE_JSON);

		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$article_info = $this->db_article->article_find($id);
		$old_file_url = $article_info['file_url'];
		$old_cover_image_url = $article_info['cover_image'];
		if ((!empty($old_file_url) || !empty($old_cover_image_url)) && strpos($article_info['file_url'], 'http://') === false && strpos($article_info['file_url'], 'https://') === false) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $article_info['file_url']);
			$disk->delete(RC_Upload::upload_path() . $article_info['cover_image']);
		}

		if ($this->db_article->article_delete($id)) {
			/*删除文章评论*/
			$discuss_comments_ids = RC_DB::table('discuss_comments')->where('id_value', $id)->where('comment_type', 'article')->lists('id');
			if (!empty($discuss_comments_ids)) {
				RC_DB::table('discuss_comments')->whereIn('id', $discuss_comments_ids)->delete();
			} 
			/*删除文章点赞*/
			$discuss_likes_ids = RC_DB::table('discuss_likes')->where('id_value', $id)->where('like_type', 'article')->lists('id');
			if (!empty($discuss_likes_ids)) {
				RC_DB::table('discuss_likes')->whereIn('id', $discuss_comments_ids)->delete();
			}
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
		
		$publishby = trim($_GET['publishby']);
		
		if (isset($publishby) && $publishby == 'store') {
			$pjaxurl =  RC_Uri::url('article/admin/init', array('publishby' => 'store'));
		} else {
			$pjaxurl =  RC_Uri::url('article/admin/init');
		}
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
						if (!empty($v['cover_image']) && strpos($v['cover_image'], 'http://') === false && strpos($v['cover_image'], 'https://') === false) {
							$disk->delete(RC_Upload::upload_path() . $v['cover_image']);
						}
						
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['article_id'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						
						ecjia_admin::admin_log($v['title'], 'batch_remove', 'article');
					}
					
					/*删除文章评论*/
					$article_ids_new = explode(',', $article_ids);
					$discuss_comments_ids = RC_DB::table('discuss_comments')->whereIn('id_value', $article_ids_new)->where('comment_type', 'article')->lists('id');
					if (!empty($discuss_comments_ids)) {
						RC_DB::table('discuss_comments')->whereIn('id', $discuss_comments_ids)->delete();
					}
					/*删除文章点赞*/
					$discuss_likes_ids = RC_DB::table('discuss_likes')->whereIn('id_value', $article_ids_new)->where('like_type', 'article')->lists('id');
					if (!empty($discuss_likes_ids)) {
						RC_DB::table('discuss_likes')->whereIn('id', $discuss_likes_ids)->delete();
					}
					return $this->showmessage(RC_Lang::get('article::article.batch_handle_ok_del'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
					break;

				//批量移到回收站
				case 'button_hide' :
					$data = array( 'article_approved' => 'trash', );
					$this->db_article->article_batch($article_ids, 'update', $data);

					foreach ($info as $v) {
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['article_id'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						
						ecjia_admin::admin_log('批量移除文章到回收站，'.RC_Lang::get('article::article.article_title_is').$v['title'], 'batch_setup', 'article');
					}
					return $this->showmessage('批量移除文章到回收站成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
					break;


				//批量显示
				case 'button_show' :
					$data = array( 'article_approved' => '1', );
					$this->db_article->article_batch($article_ids, 'update', $data);

					foreach ($info as $v) {
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['article_id'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						
						ecjia_admin::admin_log('批量审核通过文章，'.RC_Lang::get('article::article.article_title_is').$v['title'], 'batch_setup', 'article');
					}
					return $this->showmessage('批量审核通过文章成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
					break;
					
				//批量显示
				case 'button_rubbish' :
					$data = array( 'article_approved' => 'spam', );
					$this->db_article->article_batch($article_ids, 'update', $data);
				
					foreach ($info as $v) {
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['article_id'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
				
						ecjia_admin::admin_log('批量设置文章为垃圾文章，'.RC_Lang::get('article::article.article_title_is').$v['title'], 'batch_setup', 'article');
					}
					return $this->showmessage('批量设置文章为垃圾文章成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
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

					return $this->showmessage(RC_Lang::get('article::article.batch_handle_ok_move'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
					break;

				default :
					break;
			}
		}
	}
	

	/**
	 * 某篇文章评论列表
	 */
	public function comments() {
		$this->admin_priv('article_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.comment_list')));
		//ecjia_screen::get_current_screen()->add_help_tab(array(
		//'id'		=> 'overview',
		//'title'		=> RC_Lang::get('article::article.overview'),
		//'content'	=> '<p>' . RC_Lang::get('article::article.article_list_help') . '</p>'
		//		));
	
		//ecjia_screen::get_current_screen()->set_help_sidebar(
		//'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
		//'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章列表" target="_blank">'.RC_Lang::get('article::article.about_article_list').'</a>') . '</p>'
		//		);
		$id = $_GET['id'];
		$publishby = trim($_GET['publishby']);
		if (!empty($publishby)) {
			$href = RC_Uri::url('article/admin/init', array('publishby' => $publishby));
			$href_form_action = RC_Uri::url('article/admin/comment_batch', array('publishby' => $publishby));
			$href_search_action = RC_Uri::url('article/admin/comments', array('id' => $id, 'publishby' => $publishby));
		} else {
			$href = RC_Uri::url('article/admin/init');
			$href_form_action = RC_Uri::url('article/admin/comment_batch');
			$href_search_action = RC_Uri::url('article/admin/comments');
		}
		
		$this->assign('ur_here', RC_Lang::get('article::article.comment_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('article::article.article_list'), 'href' => $href));
		/* 取得过滤条件 */
		$comment_list = $this->get_comment_list($id);
		$this->assign('comment_list', $comment_list);
		
		$this->assign('type_count', $comment_list['count']);
		$this->assign('filter', $comment_list['filter']);
		$this->assign('form_action', $href_form_action);
		$this->assign('type', $_GET['type']);
		$this->assign('id', $_GET['id']);
		$this->assign('publishby', $publishby);
		$this->assign('search_action', $href_search_action);
		$this->display('comments.dwt');
	}
	
	/**
	 * 章评论列表（全部）
	 */
	public function article_comment_list() {
		$this->admin_priv('article_comment_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.comment_list')));
		//ecjia_screen::get_current_screen()->add_help_tab(array(
		//'id'		=> 'overview',
		//'title'		=> RC_Lang::get('article::article.overview'),
		//'content'	=> '<p>' . RC_Lang::get('article::article.article_list_help') . '</p>'
		//		));
	
		//ecjia_screen::get_current_screen()->set_help_sidebar(
		//'<p><strong>' . RC_Lang::get('article::article.more_info') . '</strong></p>' .
		//'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:文章列表" target="_blank">'.RC_Lang::get('article::article.about_article_list').'</a>') . '</p>'
		//		);
		
		$publishby = trim($_GET['publishby']);

		$href = RC_Uri::url('article/admin/article_comment_list');
		$href_form_action = RC_Uri::url('article/admin/comment_batch');
		$href_search_action = RC_Uri::url('article/admin/article_comment_list');
		
		$this->assign('ur_here', RC_Lang::get('article::article.article_comment'));
		/* 取得过滤条件 */
		$comment_list = $this->get_comment_list();
		$this->assign('comment_list', $comment_list);
	
		$this->assign('type_count', $comment_list['count']);
		$this->assign('filter', $comment_list['filter']);
		$this->assign('form_action', $href_form_action);
		$this->assign('type', $_GET['type']);
		$this->assign('publishby', $publishby);
		$this->assign('search_action', $href_search_action);
		$this->display('article_comment_list.dwt');
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
	 * 评论状态审核
	 */
	public function comment_check() {
		$this->admin_priv('article_comment_update', ecjia::MSGTYPE_JSON);
	
		$id		 			= !empty($_GET['id']) 		? intval($_GET['id'])		: 0;
		$article_id		 	= !empty($_GET['article_id']) 		? intval($_GET['article_id'])		: 0;
		$publishby 			= !empty($_GET['publishby'])	? trim($_GET['publishby'])	: '';
		$type				= !empty($_GET['type'])	? trim($_GET['type'])	: '';
		$allow 				= !empty($_POST['check']) 	? $_POST['check']			: '';
		$article_approved	= $_POST['article_approved'];
		$content = RC_DB::table('discuss_comments')->where('id', $id)->pluck('content');
		if (isset($publishby) && $publishby === 'store') {
			$pjaxurl = RC_Uri::url('article/admin/comments', array('publishby' => 'store', 'id' => $article_id, 'type' => $type));
		} elseif(isset($publishby) && $publishby === 'total_comments') {
			$pjaxurl = RC_Uri::url('article/admin/article_comment_list', array('publishby' => 'total_comments', 'type' => $type));
		} else {
			$pjaxurl = RC_Uri::url('article/admin/comments', array('type' => $type, 'id' => $article_id));
		}
		
		if ($allow == 'allow') {
			/*审核通过*/
			$data = array(
					'id' 		=> $id,
					'comment_approved'  => '1'
			);
			RC_DB::table('discuss_comments')->where('id', $id)->update($data);
			/*更新文章评论数*/
			article_list::update_comment_count($article_id);
			$message = '成功切换评论状态';
			ecjia_admin::admin_log('通过评论，'.RC_Lang::get('article::article.comment_content_is').$content, 'setup', 'article_comment');
		} elseif ($allow == 'forbid' || $allow == 'no_rubbish' || $allow == 'no_trashed') {
			/*切换为待审核*/
			$data = array(
					'id' 		=> $id,
					'comment_approved'  => '0'
			);
			RC_DB::table('discuss_comments')->where('id', $id)->update($data);
			/*更新文章评论数*/
			article_list::update_comment_count($article_id);
			$message = '成功切换评论状态';
			if ($allow == 'forbid') {
				ecjia_admin::admin_log('设为待审核评论，'.RC_Lang::get('article::article.comment_content_is').$content, 'setup', 'article_comment');
			} elseif ($allow == 'no_rubbish' || $allow == 'no_trash') {
				ecjia_admin::admin_log('还原评论，'.RC_Lang::get('article::article.comment_content_is').$content, 'setup', 'article_comment');
			}
		} elseif ($allow == "rubbish_comment") {
			/*垃圾评论*/
			$data = array(
					'id' 		=> $id,
					'comment_approved'  => 'spam'
			);
			RC_DB::table('discuss_comments')->where('id', $id)->update($data);
			/*更新文章评论数*/
			article_list::update_comment_count($article_id);
			$message = '成功设置评论为垃圾评论';
			ecjia_admin::admin_log('设为垃圾评论，'.RC_Lang::get('article::article.comment_content_is').$content, 'setup', 'article_comment');
		} elseif ($allow == "trashed_comment") {
			/*评论移到回收站*/
			$data = array(
					'id' 		=> $id,
					'comment_approved'  => 'trash'
			);
			RC_DB::table('discuss_comments')->where('id', $id)->update($data);
			/*更新文章评论数*/
			article_list::update_comment_count($article_id);
			$message = '移除评论至回收站成功';
			ecjia_admin::admin_log('评论移到回收站，'.RC_Lang::get('article::article.comment_content_is').$content, 'setup', 'article_comment');
		}
		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		$cache_article_info_key = 'article_info_'.$article_id;
		$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
		$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
	}
	
	
	
	
	/**
	 * 文章评论批量操作
	 */
	public function comment_batch() {
		$action 	= !empty($_GET['sel_action']) ? trim($_GET['sel_action']) : 'move_to';
		$ids 		= !empty($_POST['id']) ? $_POST['id'] : '';
		$ids    	= explode(',', $ids);
		$article_id = !empty($_GET['article_id']) ? $_GET['article_id'] : 0;
		$type	 	= !empty($_GET['type']) ? $_GET['type'] : '';
		$publishby	= !empty($_GET['publishby']) ? trim($_GET['publishby']) : '';
		
		if ($action == 'button_remove') {
			$this->admin_priv('article_comment_delete', ecjia::MSGTYPE_JSON);
		} else {
			$this->admin_priv('article_comment_update', ecjia::MSGTYPE_JSON);
		}
		$info = RC_DB::table('discuss_comments')
				->whereIn('id', $ids)->selectRaw('content,comment_approved, id_value')->get();

		/*释放文章缓存*/
		$orm_article_db = RC_Model::model('article/orm_article_model');
		if (!empty($publishby)) {
			if ($publishby == 'store') {
				$href = RC_Uri::url('article/admin/comments', array('id' => $article_id, 'type'=>$type, 'publishby' => $publishby));
			} elseif ($publishby == 'total_comments') {
				$href = RC_Uri::url('article/admin/article_comment_list', array('type'=>$type, 'publishby' => $publishby));
			}
		} else {
			$href = RC_Uri::url('article/admin/comments', array('id' => $article_id, 'type'=>$type));
		}
		
		if (!empty($ids)) {
			switch ($action) {
				//批量删除
				case 'button_remove':
					RC_DB::table('discuss_comments')->whereIn('id', $ids)->delete();
					foreach ($info as $v) {
						/*更新文章评论数*/
						article_list::update_comment_count($v['id_value']);
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['id_value'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						ecjia_admin::admin_log('评论内容是：'.substr($v['content'], 0, 20), 'batch_remove', 'article_comment');
					}
					return $this->showmessage(RC_Lang::get('article::article.batch_handle_ok_del'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $href));
					break;
	
					//批量移到回收站
				case 'button_hide' :
					$data = array( 'comment_approved' => 'trash', );
					RC_DB::table('discuss_comments')->whereIn('id', $ids)->update($data);
	
					foreach ($info as $v) {
						/*更新文章评论数*/
						article_list::update_comment_count($v['id_value']);
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['id_value'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						ecjia_admin::admin_log('批量移除文章评论到回收站，'.RC_Lang::get('article::article.comment_is').substr($v['content'], 0, 20), 'batch_setup', 'article_comment');
					}
					return $this->showmessage('批量移除文章评论到回收站成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $href));
					break;
	
	
					//批量通过
				case 'button_show' :
					$data = array( 'comment_approved' => '1', );
					RC_DB::table('discuss_comments')->whereIn('id', $ids)->update($data);
					foreach ($info as $v) {
						/*更新文章评论数*/
						article_list::update_comment_count($v['id_value']);
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['id_value'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						ecjia_admin::admin_log('批量审核通过文章评论，'.RC_Lang::get('article::article.comment_is').substr($v['content'], 0, 20), 'batch_setup', 'article_comment');
					}
					return $this->showmessage('批量审核通过文章评论成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $href));
					break;
						
					//批量显示
				case 'button_rubbish' :
					$data = array( 'comment_approved' => 'spam', );
					RC_DB::table('discuss_comments')->whereIn('id', $ids)->update($data);
					foreach ($info as $v) {
						/*更新文章评论数*/
						article_list::update_comment_count($v['id_value']);
						/*释放文章缓存*/
						$cache_article_info_key = 'article_info_'.$v['id_value'];
						$cache_id_info = sprintf('%X', crc32($cache_article_info_key));
						$orm_article_db->delete_cache_item($cache_id_info);//释放article_info缓存
						ecjia_admin::admin_log('批量设置文章评论为垃圾评论，'.RC_Lang::get('article::article.comment_is').substr($v['content'], 0, 20), 'batch_setup', 'article_comment');
					}
					return $this->showmessage('批量设置文章评论为垃圾评论成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $href));
					break;
	
				default :
					break;
			}
		}
	}
	
	
	/**
	 * 删除某一条评论
	 */
	public function comment_remove() {
		$this->admin_priv('article_comment_delete', ecjia::MSGTYPE_JSON);
		$id = intval($_GET['id']);
		/*评论的当前状态*/
		$current_comment_approved = RC_DB::table('discuss_comments')->where('id', $id)->pluck('comment_approved');
		$current_comment_approved = trim($current_comment_approved);
		$article_id = intval($_GET['article_id']);
		RC_DB::table('discuss_comments')->where('id', $id)->delete();
		/*更新文章评论数*/
		article_list::update_comment_count($article_id);
		ecjia_admin::admin_log('', 'remove', 'users_comment');
		return $this->showmessage('删除文章评论成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取文章评论列表
	 */
	public function get_comment_list($article_id) {
		$filter = array();
		$filter['keywords']   = empty($_GET['keywords'])      ? ''                : trim($_GET['keywords']);
		$filter['cat_id']     = empty($_GET['cat_id'])        ? 0                 : intval($_GET['cat_id']);
		$filter['sort_by']    = empty($_GET['sort_by'])       ? 'dc.add_time'     : trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order'])    ? 'DESC'            : trim($_GET['sort_order']);
		$filter['type']   	  = empty($_GET['type'])      	  ? ''                : trim($_GET['type']);
		$filter['article_id'] = empty($_GET['id'])      	  ?  0                : intval($_GET['id']);
	
		$db_discuss_comments = RC_DB::table('discuss_comments as dc')
							   ->leftJoin('article as a', RC_DB::raw('dc.id_value'), '=', RC_DB::raw('a.article_id'));
		
		$db_discuss_comments->where('comment_type', 'article');
		if (isset($filter['article_id']) && $filter['article_id'] > 0) {
			$db_discuss_comments->where(RC_DB::raw('dc.id_value'), $filter['article_id']);
		}
		if (!empty($filter['keywords'])) {
			$db_discuss_comments ->whereRaw('(dc.user_name like  "%' . mysql_like_quote($filter['keywords']) . '%" or dc.content like "%'.mysql_like_quote($filter['keywords']).'%" or a.title like "%'.mysql_like_quote($filter['keywords']).'%")');
		}
	
		$type_count = $db_discuss_comments->select(RC_DB::raw('count(*) as count'),
				RC_DB::raw('SUM(IF(dc.comment_approved = 1, 1, 0)) as has_checked'),
				RC_DB::raw('SUM(IF(dc.comment_approved = 0 and dc.comment_approved !="spam" and dc.comment_approved !="trash", 1, 0)) as wait_check'),
				RC_DB::raw('SUM(IF(dc.comment_approved = "trash", 1, 0)) as trash'),
				RC_DB::raw('SUM(IF(dc.comment_approved = "spam", 1, 0)) as rubbish_comments'))->first();
	
		if ($filter['type'] == 'has_checked') {
			$db_discuss_comments->where(RC_DB::raw('dc.comment_approved'), 1);
		}
	
		if ($filter['type'] == 'wait_check') {
			$db_discuss_comments->where(RC_DB::raw('dc.comment_approved'), 0);
		}
	
		if ($filter['type'] == 'trash') {
			$db_discuss_comments->where(RC_DB::raw('dc.comment_approved'), 'trash');
		}
	
		if ($filter['type'] == 'rubbish_comments') {
			$db_discuss_comments->where(RC_DB::raw('dc.comment_approved'), 'spam');
		}
	
		$count = $db_discuss_comments->select('dc.id')->count();
		$page = new ecjia_page($count, 15, 5);
	
		$result = $db_discuss_comments->select(RC_DB::raw('dc.*, a.title'))
		->orderby(RC_DB::raw($filter['sort_by']), $filter['sort_order'])
		->take(15)->skip($page->start_id-1)->get();
	
		$arr = array();
		if (!empty($result)) {
			foreach ($result as $rows) {
				if (isset($rows['add_time'])) {
					$rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
					//$row['url'] = RC_Uri::url('article/admin/preview', array('id' => $row['id_value']));
				}
				$arr[] = $rows;
			}
		}

		return array('arr' => $arr, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'filter' => $filter, 'count' => $type_count);
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
		$filter['type']   	  = empty($_GET['type'])      	  ? ''                : trim($_GET['type']);
		$filter['suggest_type']= empty($_GET['suggest_type']) ? ''         : trim($_GET['suggest_type']);
		$publishby = trim($_GET['publishby']);
		
		$db_article = RC_DB::table('article as a')
			->leftJoin('article_cat as ac', RC_DB::raw('ac.cat_id'), '=', RC_DB::raw('a.cat_id'))
			->leftJoin('store_franchisee as sf', RC_DB::raw('a.store_id'), '=', RC_DB::raw('sf.store_id'));
		
		//不获取系统帮助文章的过滤
		$db_article->where(RC_DB::raw('a.cat_id'), '!=', '0')->where(RC_DB::raw('ac.cat_type'), 'article');
		
		if(!empty($publishby) && $publishby == 'store') {
			$db_article->where(RC_DB::raw('a.store_id'), '>', '0');
		} else {
			$db_article->where(RC_DB::raw('a.store_id'), '=', '0');
		}
		
		if (!empty($filter['keywords'])) {
			if (!empty($publishby) && $publishby == 'store') {
				$db_article ->whereRaw('(a.title  like  "%'.mysql_like_quote($filter['keywords']).'%"  or sf.merchants_name like "%'.mysql_like_quote($filter['keywords']).'%")');
			} else {
				$db_article ->where(RC_DB::raw('title'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
			}
			
		}
		if ($filter['cat_id'] && ($filter['cat_id'] > 0)) {
			$db_article ->whereIn(RC_DB::raw('a.cat_id'), article_cat::get_children_list($filter['cat_id']));
		}
		
		$type_count = $db_article->select(RC_DB::raw('count(*) as count'),
				RC_DB::raw('SUM(IF(a.article_approved = 1, 1, 0)) as has_checked'),
				RC_DB::raw('SUM(IF(a.article_approved = 0 and a.article_approved !="spam" and a.article_approved !="trash", 1, 0)) as wait_check'),
				RC_DB::raw('SUM(IF(a.article_approved = "trash", 1, 0)) as trash'),
				RC_DB::raw('SUM(IF(a.article_approved = "spam", 1, 0)) as rubbish_article'))->first();
		
		$suggest_type_count = $db_article->select(
				RC_DB::raw('SUM(IF(a.suggest_type = 0 and a.suggest_type !="stickie", 1, 0)) as default_count'),
				RC_DB::raw('SUM(IF(a.suggest_type = "stickie", 1, 0)) as top'))->first();
		
		if ($filter['type'] == 'has_checked') {
			$db_article->where(RC_DB::raw('a.article_approved'), 1);
		}
		
		if ($filter['type'] == 'wait_check') {
			$db_article->where(RC_DB::raw('a.article_approved'), 0);
		}
		
		if ($filter['type'] == 'trash') {
			$db_article->where(RC_DB::raw('a.article_approved'), 'trash');
		}
		
		if ($filter['type'] == 'rubbish_article') {
			$db_article->where(RC_DB::raw('a.article_approved'), 'spam');
		}

		if ($filter['suggest_type'] == 'default') {
			$db_article->where(RC_DB::raw('a.suggest_type'), '0');
		}
		
		if ($filter['suggest_type'] == 'top') {
			$db_article->where(RC_DB::raw('a.suggest_type'), 'stickie');
		}
		
		$count = $db_article->select('article_id')->count();
		$page = new ecjia_page($count, 15, 5);
		
		$result = $db_article->selectRaw('a.*, ac.cat_id, ac.cat_name, ac.cat_type, ac.sort_order,sf.merchants_name')
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
		return array('arr' => $arr, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'filter' => $filter, 'count' => $type_count, 'suggest_type_count' => $suggest_type_count);
	}
}

// end
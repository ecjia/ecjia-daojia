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
 * ECJIA 商家公告/系统信息
 */
class admin_notice extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('admin_article');
		RC_Loader::load_app_func('global', 'article');
		assign_adminlog_contents();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') , array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		RC_Script::enqueue_script('store_notice', RC_App::apps_url('statics/js/store_notice.js', __FILE__), array(), false, true);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$article_type = !empty($_GET['article_type']) ? trim($_GET['article_type']) : 'merchant_notice';
		$data = get_cat_type_info($article_type, $id);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($data['text'], $data['url']));
	}
	
	/**
	 * 商家公告文章列表
	 */
	public function init() {
		$this->admin_priv('store_notice_manage');
		
		$article_type = !empty($_GET['article_type']) ? trim($_GET['article_type']) : 'merchant_notice';
		$data = get_cat_type_info($article_type);
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($data['text']));
		
		$this->assign('ur_here', $data['text']);
		$this->assign('action_link', array('text' => $data['text_add'], 'href'=> $data['url_add']));
		$this->assign('list', $this->get_notice_list());
		
		$this->display('article_notice_list.dwt');
	}
	
	/**
	 * 添加商家公告
	 */
	public function add() {
		$this->admin_priv('store_notice_manage');
		
		$article_type = !empty($_GET['article_type']) ? trim($_GET['article_type']) : 'merchant_notice';
		$data = get_cat_type_info($article_type);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($data['text_add']));
		
		$this->assign('ur_here', $data['text']);
		$this->assign('action_link', array('text' => $data['text'], 'href'=> $data['url']));
		
		$this->assign('form_action', $data['url_insert']);
		$this->display('article_notice_info.dwt');
	}
	
	public function insert() {
		$this->admin_priv('store_notice_manage', ecjia::MSGTYPE_JSON);
		
		$title    	= !empty($_POST['title'])       ? trim($_POST['title'])         : '';
		$content  	= !empty($_POST['content'])     ? trim($_POST['content'])       : '';
		$keywords	= !empty($_POST['keywords'])    ? trim($_POST['keywords'])      : '';
		$desc    	= !empty($_POST['description']) ? trim($_POST['description'])   : '';
		$file		= !empty($_FILES['file']) 		? $_FILES['file'] 				: '';
		$article_type = !empty($_GET['article_type']) ? trim($_GET['article_type'])	: 'merchant_notice';
		
 		$is_only = RC_DB::table('article as a')
     			->where('title', $title)
     			->where(RC_DB::raw('a.article_type'), $article_type)
     			->count();
 			
		if ($is_only != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::article.title_exist'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$file_name = '';
		//判断用户是否选择了文件
		if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
			$upload = RC_Upload::uploader('file', array('save_path' => 'data/article', 'auto_sub_dirs' => true));
			$upload->allowed_type(array('jpg', 'jpeg', 'png', 'gif', 'bmp'));
			$upload->allowed_mime(array('image/jpeg', 'image/png', 'image/gif', 'image/x-png', 'image/pjpeg'));
			$image_info = $upload->upload($file);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$file_name = $upload->get_position($image_info);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$data = array(
			'title' 	   	=> $title,
			'cat_id'   		=> 0,
			'content'  		=> $content,
			'keywords'  	=> $keywords,
			'file_url'		=> $file_name,
			'description'  	=> $desc,
			'add_time' 		=> RC_Time::gmtime(),
			'article_type'  => $article_type,
			'article_approved' => 1,
		);
		$id = RC_DB::table('article')->insertGetId($data);

		if ($article_type == 'merchant_notice') {
			$object = 'merchant_notice';
		} elseif ($article_type == 'system') {
			$object = 'system_info';
		}
		
		ecjia_admin::admin_log($title, 'add', $object);
		return $this->showmessage(sprintf(RC_Lang::get('article::shopinfo.articleadd_succeed'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin_notice/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑商家公告
	 */
	public function edit() {
		$this->admin_priv('store_notice_manage');
	
		$id = intval($_GET['id']);
		$info = RC_DB::table('article as a')
			->where(RC_DB::raw('a.article_id'), $id)
			->selectRaw('a.*')
			->first();
		
		$article_type = !empty($_GET['article_type']) ? trim($_GET['article_type']) : $info['article_type'];
		$data = get_cat_type_info($article_type);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($data['text']));
		
		$this->assign('ur_here', $data['text']);
		$this->assign('action_link', array('text' => $data['text'], 'href'=> $data['url']));

		if (!empty($info['content'])) {
			$info['content'] = stripslashes($info['content']);
		}
		$disk = RC_Filesystem::disk();
		if (!empty($info['file_url']) && $disk->exists(RC_Upload::upload_path($info['file_url']))) {
			$info['image_url'] = RC_Upload::upload_url($info['file_url']);
		} else {
			$info['image_url'] = RC_Uri::admin_url('statics/images/nopic.png');
		}
		$this->assign('article', $info);
		$this->assign('form_action', $data['url_update']);
		
		$this->display('article_notice_info.dwt');
	}
	
	public function update() {
		$this->admin_priv('store_notice_manage', ecjia::MSGTYPE_JSON);
		
		$title    	= !empty($_POST['title'])       ? trim($_POST['title'])         : '';
		$content  	= !empty($_POST['content'])     ? trim($_POST['content'])       : '';
		$keywords 	= !empty($_POST['keywords'])    ? trim($_POST['keywords'])      : '';
		$desc     	= !empty($_POST['description']) ? trim($_POST['description'])   : '';
		$id       	= !empty($_POST['id'])          ? intval($_POST['id'])          : 0;
		$file		= !empty($_FILES['file']) 		? $_FILES['file'] 				: '';
		$article_type = !empty($_GET['article_type']) ? trim($_GET['article_type']) : 'merchant_notice';
		
		$is_only = RC_DB::table('article as a')
			->where('title', $title)
			->where(RC_DB::raw('a.article_type'), $article_type)
			->where(RC_DB::raw('a.article_id'), '!=', $id)
			->count();
		
		if ($is_only != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::article.title_exist'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$old_file_name = RC_DB::table('article')->where('article_id', $id)->pluck('file_url');
		//判断用户是否选择了文件
		if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
			$upload = RC_Upload::uploader('file', array('save_path' => 'data/article', 'auto_sub_dirs' => true));
			$upload->allowed_type(array('jpg', 'jpeg', 'png', 'gif', 'bmp'));
			$upload->allowed_mime(array('image/jpeg', 'image/png', 'image/gif', 'image/x-png', 'image/pjpeg'));
			$image_info = $upload->upload($file);

			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$file_name = $upload->get_position($image_info);
				$upload->remove($old_file_name);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$file_name = $old_file_name;
		}

		$data = array(
			'title'       	=> $title,
			'content'     	=> $content,
			'keywords'    	=> $keywords,
			'file_url'		=> $file_name,
			'description' 	=> $desc,
			'add_time'    	=> RC_Time::gmtime(),
			'article_type'  => $article_type,
			'article_approved' => 1,
		);

		RC_DB::table('article')->where('article_id', $id)->update($data);
		
		if ($article_type == 'merchant_notice') {
			$object = 'merchant_notice';
		} elseif ($article_type == 'system') {
			$object = 'system_info';
		}
		ecjia_admin::admin_log($title, 'edit', $object);
		
		return $this->showmessage(sprintf(RC_Lang::get('article::shopinfo.articleedit_succeed'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('article/admin_notice/edit', array('id' => $id))));
	}
	
	/**
	 * 删除文章
	 */
	public function remove() {
		$this->admin_priv('store_notice_manage', ecjia::MSGTYPE_JSON);
		
		$id   = intval($_GET['id']);
		$info = RC_DB::table('article')->where('article_id', $id)->first();
		
		$disk = RC_Filesystem::disk();
		if (RC_DB::table('article')->where('article_id', $id)->delete()) {
			if (!empty($info['file_url']) && $disk->exists(RC_Upload::upload_path() . $info['file_url'])) {
				$disk->delete(RC_Upload::upload_path() . $info['file_url']);
			}
			
			if ($info['article_type'] == 'merchant_notice') {
				$object = 'merchant_notice';
			} elseif ($info['article_type'] == 'system') {
				$object = 'system_info';
			}
			ecjia_admin::admin_log(addslashes($info['title']), 'remove', $object);
		}
		return $this->showmessage(sprintf(RC_Lang::get('article::shopinfo.remove_success'), $info['title']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 删除附件
	 */
	public function del_file() {
		$this->admin_priv('store_notice_manage', ecjia::MSGTYPE_JSON);
	
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$old_url = RC_DB::table('article')->where('article_id', $id)->pluck('file_url');
	
		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path() . $old_url);
	
		$data = array(
			'file_url' => '',
		);
		RC_DB::table('article')->where('article_id', $id)->update($data);
	
		return $this->showmessage(RC_Lang::get('article::article.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin_notice/edit', array('id' => $id))));
	}
	
	/**
	 * 获取文章列表
	 */
	private function get_notice_list($cat_id = 0) {
		$article_type = !empty($_GET['article_type']) ? trim($_GET['article_type']) : 'merchant_notice';

		$db_article = RC_DB::table('article as a');
		if (!empty($article_type)) {
			$db_article->where(RC_DB::raw('a.article_type'), $article_type);
		}
		
	    $data = $db_article
     			->orderBy(RC_DB::raw('a.add_time'), 'desc')
     			->get();
	    
	    $list = array();
	    if (!empty($data)) {
	        foreach ($data as $rows) {
	            $rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
	            $list[] = $rows;
	        }
	    }
	    return $list;
	}
}

// end
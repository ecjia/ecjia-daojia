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
 * ECJia今日热点管理控制器
 */
class admin_mobile_news extends ecjia_admin {
	private $db_mobile_news;

	public function __construct() {
		parent::__construct();

		$this->db_mobile_news = RC_Model::model('mobile/mobile_news_model');

		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Style::enqueue_style('mobile_news', RC_App::apps_url('statics/css/mobile.css', __FILE__), array(), false, false);
		RC_Script::enqueue_script('mobile_news', RC_App::apps_url('statics/js/mobile_news.js', __FILE__), array(), false, false);
		
		RC_Script::localize_script('mobile_news', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_news'), RC_Uri::url('mobile/admin_mobile_news/init')));
	}

	/**
	 * 今日热点页面加载
	 */
	public function init () {
		$this->admin_priv('mobile_news_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_news')));
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_news_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.add_mobile_news'), 'href' => RC_Uri::url('mobile/admin_mobile_news/add')));
		
		$mobile_news = $this->get_mobile_news_list();
		$this->assign('mobile_news', $mobile_news);
		
		$this->display('mobile_news.dwt');
	}

	/**
	 * 添加展示页面
	 */
	public function add() {
		$this->admin_priv('mobile_news_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.add_mobile_news')));
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.add_mobile_news'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_news_list'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_news/insert'));
		
		$this->display('mobile_news_edit.dwt');
	}

	/**
	 * 添加执行
	 */
	public function insert() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);
		
		$post = $_POST;
		if (!empty($post)) {
			$group_id = 0;
			foreach ($post['title'] as $key => $val) {
				$image_url = '';
				/* 处理上传的LOGO图片 */
				if ((isset($_FILES['image_url']['error'][$key]) && $_FILES['image_url']['error'][$key] == 0) ||(!isset($_FILES['image_url']['error'][$key]) && isset($_FILES['image_url']['tmp_name'][$key]) && $_FILES['image_url']['tmp_name'][$key] != 'none')) {
					$upload = RC_Upload::uploader('image', array('save_path' => 'data/mobile_news', 'auto_sub_dirs' => false));
					$file = array(
						'name'		=> $_FILES['image_url']['name'][$key],
						'type'		=> $_FILES['image_url']['type'][$key],
						'tmp_name'	=> $_FILES['image_url']['tmp_name'][$key],
						'error'		=> $_FILES['image_url']['error'][$key],
						'size'		=> $_FILES['image_url']['size'][$key]
					);
					$info = $upload->upload($file);
					if (!empty($info)) {
						$image_url = $upload->get_position($info);
					} else {
						return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				} else {
					return $this->showmessage(RC_Lang::get('mobile::mobile.upload_file_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}

				$data = array (
					'group_id'		=> $group_id,
					'title'			=> $post['title'][$key],
					'description'	=> $post['description'][$key],
					'content_url'	=> $post['content_url'][$key],
					'image'			=> $image_url,
					'type'			=> 'article',
					'create_time'	=> RC_Time::gmtime(),
				);

				if ($key == 0) {
					$group_id = $this->db_mobile_news->mobile_news_manage($data);
				} else {
					$this->db_mobile_news->mobile_news_manage($data);
				}
				ecjia_admin::admin_log($data['title'], 'add', 'mobile_news');
			}
		}

		$links[] = array('text' => RC_Lang::get('mobile::mobile.return_mobile_news_list'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init'));
		return $this->showmessage(RC_Lang::get('mobile::mobile.add_mobile_news_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', 'id='.$group_id)));
	}

	/**
	 * 编辑显示页面
	 */
	public function edit() {
		$this->admin_priv('mobile_news_update');
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.edit_mobile_news'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.edit_mobile_news')));
		
		$id = $_GET['id'];
		$mobile_news = RC_DB::table('mobile_news')->where('id', $id)->orWhere('group_id', $id)->orderby('id', 'asc')->get();

		if (!empty($mobile_news)) {
			foreach ($mobile_news as $key => $val) {
				if ($val['group_id'] == 0) {
					$mobile_news_status = $val['status'];
				}
				if (substr($val['image'], 0, 4) != 'http') {
					$mobile_news[$key]['image'] = RC_Upload::upload_url() . '/' . $val['image'];
				}
			}
		}

		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_news_list'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_news/update'));
		$this->assign('mobile_news', $mobile_news);
		$this->assign('mobile_news_id', $id);
		$this->assign('mobile_news_status', $mobile_news_status);
		
		$this->display('mobile_news_edit.dwt');
	}

	/**
	 * 编辑及提交处理
	 */
	public function update() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);
		
		$post 		= $_POST;
		$group_id 	= !empty($_POST['group_id']) 	? $_POST['group_id'] 	: 0;
		$id 		= !empty($_POST['id']) 			? intval($_POST['id']) 	: 0;
		
		$group_news = RC_DB::table('mobile_news')->where('id', $id)->orWhere('group_id', $id)->lists('id');
		
		if (!empty($post)) {
			foreach ($post['title'] as $key => $val) {
				$data = array (
					'group_id'		=> $key == $id ? 0 : $id,
					'title'			=> $post['title'][$key],
					'description'	=> $post['description'][$key],
					'content_url'	=> $post['content_url'][$key],
					'type'			=> 'article',
				);

				/* 处理上传的LOGO图片 */
				if ((isset($_FILES['image_url']['error'][$key]) && $_FILES['image_url']['error'][$key] == 0) ||(!isset($_FILES['image_url']['error'][$key]) && isset($_FILES['image_url']['tmp_name'][$key]) && $_FILES['image_url']['tmp_name'][$key] != 'none')) {
					$upload = RC_Upload::uploader('image', array('save_path' => 'data/mobile_news', 'auto_sub_dirs' => false));
					$file = array(
						'name'		=> $_FILES['image_url']['name'][$key],
						'type'		=> $_FILES['image_url']['type'][$key],
						'tmp_name'	=> $_FILES['image_url']['tmp_name'][$key],
						'error'		=> $_FILES['image_url']['error'][$key],
						'size'		=> $_FILES['image_url']['size'][$key]
					);
					$info = $upload->upload($file);
					if (!empty($info)) {
						$image = $this->db_mobile_news->mobile_news_field(array('id' => $key), 'image');
						$upload->remove($image);
						$image_url 		= $upload->get_position($info);
						$data['image'] 	= $image_url;
					} else {
						return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}

				if (in_array($key, $group_news)) {
					$this->db_mobile_news->mobile_news_manage($data, array('id' => $key));
					ecjia_admin::admin_log($data['title'], 'edit', 'mobile_news');
				} else {
					$data['create_time'] = RC_Time::gmtime();
					$this->db_mobile_news->mobile_news_manage($data);
					ecjia_admin::admin_log($data['title'], 'edit', 'mobile_news');
				}
			}
		}
		$links[] = array('text' => RC_Lang::get('mobile::mobile.mobile_news_list'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init'));
		return $this->showmessage(RC_Lang::get('mobile::mobile.edit_mobile_news_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', array('id' => $id))));
	}

	/**
	 * 删除今日热点
	 */
	public function remove() {
		$this->admin_priv('mobile_news_delete', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$info = RC_DB::table('mobile_news')->where('id', $id)->orWhere('group_id', $id)->get();
		
		foreach ($info as $v) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $v['image']);
		}
		$title = $this->db_mobile_news->mobile_news_field(array('id' => $id), 'title');
		
		RC_DB::table('mobile_news')->where('id', $id)->orWhere('group_id', $id)->delete();

		ecjia_admin::admin_log($title, 'remove', 'mobile_news');
		return $this->showmessage(RC_Lang::get('mobile::mobile.remove_mobile_news_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 发布
	 */
	public function issue() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);

		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$this->db_mobile_news->mobile_news_manage(array('status' => 1), array('id' => $id, 'group_id' => 0));
		
		return $this->showmessage(RC_Lang::get('mobile::mobile.issue_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', array('id' => $id))));
	}

	/**
	 * 取消发布
	 */
	public function unissue() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$this->db_mobile_news->mobile_news_manage(array('status' => 0), array('id' => $id, 'group_id'=> 0));
		
		return $this->showmessage(RC_Lang::get('mobile::mobile.cancel_issue_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', array('id' => $id))));
	}
	
	/**
	 * 获取今日热点列表
	 * @return array
	 */
	private function get_mobile_news_list() {
		$db_mobile_news = RC_Model::model('mobile/mobile_news_model');
		
		$db_mobile_news = RC_DB::table('mobile_news');
		$db_mobile_news->where('group_id', 0)->where('type', 'article');
		
		$count  = $db_mobile_news->count();
		$page   = new ecjia_page($count, 10, 5);
		$result = $db_mobile_news->orderby('id', 'asc')->take(10)->skip($page->start_id-1)->get();
		
	
		$mobile_news = array();
		if (!empty($result)) {
			foreach ($result as $key => $val) {
				$db_mobile_child = RC_DB::table('mobile_news');
				if (!empty($val['image'])) {
					if (substr($val['image'], 0, 4) != 'http') {
						$val['image'] = RC_Upload::upload_url() . '/' . $val['image'];
					}
				}
				$mobile_news[$key] = array(
					'id'			=> $val['id'],
					'title'			=> $val['title'],
					'description' 	=> $val['description'],
					'image'		  	=> $val['image'],
					'content_url' 	=> $val['content_url'],
					'create_time' 	=> RC_Time::local_date(ecjia::config('time_format'), $val['create_time']),
				);
			
				$child_result = $db_mobile_child->where('group_id', $val['id'])->where('type', 'article')->orderby('id', 'asc')->get();
				
				if (!empty($child_result)) {
					foreach ($child_result as $v) {
						if (!empty($v['iamge'])) {
							if (substr($v['image'], 0, 4) != 'http') {
								$v['image'] = RC_Upload::upload_url() . '/' . $v['image'];
							}
						}
						$mobile_news[$key]['children'][] = array(
							'id'			=> $v['id'],
							'title'			=> $v['title'],
							'description' 	=> $v['description'],
							'image'		  	=> $v['image'],
							'content_url' 	=> $v['content_url'],
							'create_time' 	=> RC_Time::local_date(ecjia::config('time_format'), $v['create_time']),
						);
					}
				}
			}
		}
		return array('item' => $mobile_news, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

// end

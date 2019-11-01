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
 * ECJIA 广告管理程序
 * @author songqian
 */
class admin extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, 1);
		
		RC_Script::enqueue_script('group', RC_App::apps_url('statics/js/group.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('ad_position', RC_App::apps_url('statics/js/ad_position.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('adsense', RC_App::apps_url('statics/js/adsense.js', __FILE__), array(), false, 1);
		RC_Style::enqueue_style('adsense', RC_App::apps_url('statics/styles/adsense.css', __FILE__), array());

		RC_Script::localize_script('group', 'js_lang', config('app-adsense::jslang.adsense_page'));


		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('广告列表', 'adsense'), RC_Uri::url('adsense/admin/init', ['position_id' => $_GET['position_id']])));
	}
	
	/**
	 * 广告列表页面
	 */
	public function init() {
		$this->admin_priv('adsense_manage');
		
		$position_id = intval($_GET['position_id']);
		if (empty($position_id)) {
		    return $this->showmessage(__("丢失广告位参数【position_id】", 'adsense'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => [['text' => '返回广告位列表', 'href' => RC_Uri::url('adsense/admin_position/init')]]));
		}
		
		$this->assign('position_id', $position_id);
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('广告列表', 'adsense')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => __('概述', 'adsense'),
			'content' => '<p>' . __('欢迎访问ECJia智能后台广告列表页面，系统中所有的广告都会显示在此列表中', 'adsense') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . __('更多信息：', 'adsense') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告列表" target="_blank">关于广告列表帮助文档</a>', 'adsense') . '</p>');
		$this->assign('search_action', RC_Uri::url('adsense/admin/init'));
		
		$show_client = array_get($_GET, 'show_client', 0);
		$media_type = array_get($_GET, 'media_type', -1);
		$city_id = array_get($_GET, 'city_id', 0);
		
		$this->assign('media_type', $media_type);

		$this->assign('ur_here', __('广告列表', 'adsense'));
		$this->assign('back_position_list', array('text' => __('广告位列表', 'adsense'),'href' => RC_Uri::url('adsense/admin_position/init',array('city_id' => $city_id))));
		$this->assign('action_link', array('text' => __('添加广告', 'adsense'),'href' => RC_Uri::url('adsense/admin/add',array('position_id' => $position_id, 'show_client' => $show_client))));
		
		//获取投放平台
		$ad = new Ecjia\App\Adsense\Repositories\AdRepository('adsense');
		$client_list = $ad->getAllClients();
		$this->assign('client_list', $client_list);
		
		$ad_db = RC_DB::table('ad');
		if ($media_type >= 0) {
			$ad_db->where('media_type', '=', $media_type);
			$filter = ['media_type' => $media_type];
			$show_client_number = RC_DB::table('ad')->where('position_id', $position_id)->where('show_client', 0)->where('media_type', $media_type)->count();
		} else {
		    $filter = [];
			$show_client_number = RC_DB::table('ad')->where('position_id', $position_id)->where('show_client', 0)->count();
		}
			
		$available_clients = $ad->getAdClients($position_id, $filter);
		if ($show_client_number > 0) {
			array_unshift($available_clients,$show_client_number);
		}
		$this->assign('available_clients', $available_clients);
	
		if (empty($show_client) && !empty($available_clients)) {
			$show_client = $client_list[head(array_keys($available_clients))];
		}
		$this->assign('show_client', $show_client);
			
			
		//对应的广告列表
		if (empty($show_client)) {
			$ads_list = $ad_db->where('position_id', $position_id)->where('show_client', 0)->select('ad_id', 'ad_name', 'ad_code', 'media_type', 'start_time', 'start_time', 'end_time', 'enabled', 'sort_order', 'click_count')->get();
		} else {
			$ads_list = $ad->getAdsFilter($position_id, $show_client, null, $filter);
		}
			
		foreach ($ads_list as $key => $val) {
			$ads_list[$key]['start_time'] = RC_Time::local_date('Y-m-d', $val['start_time']);
			$ads_list[$key]['end_time']   = RC_Time::local_date('Y-m-d', $val['end_time']);
		}
		$this->assign('ads_list', $ads_list);	

		$position_data = RC_DB::table('ad_position')->where('position_id', $position_id)->first();
		$this->assign('position_data', $position_data);

        return $this->display('adsense_list.dwt');
	}
	
	/**
	 * 添加新广告页面
	 */
	public function add() {
		$this->admin_priv('adsense_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加广告', 'adsense')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => __('概述', 'adsense'),
			'content' => '<p>' . __('欢迎访问ECJia智能后台添加广告页面，在此页面可以进行添加广告操作。', 'adsense') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . __('更多信息：', 'adsense') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告列表#.E6.B7.BB.E5.8A.A0.E5.B9.BF.E5.91.8A" target="_blank">关于添加广告帮助文档</a>', 'adsense') . '</p>');
		
		$show_client =intval($_GET['show_client']);
		$this->assign('show_client', $show_client);
		
		$position_id = intval($_GET['position_id']);
		$this->assign('ur_here', __('添加广告', 'adsense'));
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin/init',array('position_id' => $position_id, 'show_client' => $show_client)), 'text' => __('广告列表', 'adsense')));
		
		$position_list = $this->get_position_select_list();
		$this->assign('position_list', $position_list);
		
		$this->assign('action', 'insert');
		
		$client_list = \Ecjia\App\Adsense\Client::displayClients();
		$this->assign('client_list', $client_list);

		$ads['start_time'] = date('Y-m-d');
		$ads['end_time'] = date('Y-m-d', time() + 30 * 86400);
		$ads['enabled'] = 1;
		$ads['position_id'] = $position_id;
		$this->assign('ads', $ads);
		
		$position_data = RC_DB::table('ad_position')->where('position_id', $position_id)->first();
		$this->assign('position_data', $position_data);
		
		$this->assign('form_action', RC_Uri::url('adsense/admin/insert'));

        return $this->display('adsense_info.dwt');
	}
	
	/**
	 * 新广告的处理
	 */
	public function insert() {
		$this->admin_priv('adsense_update');
		
		$id 	= !empty($_POST['id']) ? intval($_POST['id']) : 0;
		$type 	= !empty($_POST['type']) ? intval($_POST['type']) : 0;
		$ad_name = !empty($_POST['ad_name']) ? trim($_POST['ad_name']) : '';
		$media_type = !empty($_POST['media_type']) ? intval($_POST['media_type']) : 0;
		if ($media_type === 0) {
			$ad_link = !empty($_POST['ad_link']) ? trim($_POST['ad_link']) : '';
		} else {
			$ad_link = !empty($_POST['ad_link2']) ? trim($_POST['ad_link2']) : '';
		}
		/* 获得广告的开始时期与结束日期 */
		$start_time = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time']) : '0';
		$end_time = !empty($_POST['end_time']) ? RC_Time::local_strtotime($_POST['end_time']) : '0';
		/* 查看广告名称是否有重复 */
		$query = RC_DB::table('ad')->where('ad_name', $ad_name)->count();
		if (isset($_POST['ad_name'])) {
			if ($query > 0) {
				return $this->showmessage(__('该广告名称已经存在！', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(__('请输入广告名称', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 添加图片类型的广告 */
		if ($media_type === 0) {
			if (isset($_FILES['ad_img']['error']) && $_FILES['ad_img']['error'] == 0 || ! isset($_FILES['ad_img']['error']) && isset($_FILES['ad_img']['tmp_name']) && $_FILES['ad_img']['tmp_name'] != 'none') {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/adsense', 'auto_sub_dirs' => false));
				$image_info = $upload->upload($_FILES['ad_img']);
				if (!empty($image_info)) {
					$ad_code = $upload->get_position($image_info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		} elseif ($media_type === 2) {
			if (!empty($_POST['ad_code'])) {
				$ad_code = $_POST['ad_code'];
			} else {
				return $this->showmessage(__('广告的代码不能为空！', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} elseif ($media_type === 3) {
			if (!empty($_POST['ad_text'])) {
				$ad_code = $_POST['ad_text'];
			} else {
				return $this->showmessage(__('广告的内容不能为空！', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$ad_code = isset($ad_code) ? $ad_code : '';
		$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
		if (empty($_POST['show_client'])) {
			return $this->showmessage(__('请选择投放平台', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$show_client = Ecjia\App\Adsense\Client::clientSelected($_POST['show_client']);
		}
		$position = intval($_POST['position_id']);
		$data = array(
			'position_id' => $position,
			'media_type'  => $media_type,
			'ad_name'     => $ad_name,
			'ad_link'     => $ad_link,
			'ad_code'     => $ad_code,
			'start_time'  => $start_time,
			'end_time'    => $end_time,
			'link_man'    => !empty($_POST['link_man']) ? $_POST['link_man'] : '',
			'link_email'  => !empty($_POST['link_email']) ? $_POST['link_email'] : '',
			'link_phone'  => !empty($_POST['link_phone']) ? $_POST['link_phone'] : '',
			'click_count' => 0,
			'show_client' => $show_client,
			'enabled'     => !empty($_POST['enabled']) ? $_POST['enabled'] : '' ,
			'sort_order'  => $sort_order,
		);
		$ad_id = RC_DB::table('ad')->insertGetId($data);
		/* 释放广告位缓存 */
		$ad_postion_db = RC_Model::model('adsense/orm_ad_position_model');
		$cache_key = sprintf('%X', crc32('adsense_position-' . $_POST['position_id']));
		$ad_postion_db->delete_cache_item($cache_key);
		ecjia_admin::admin_log($ad_name, 'add', 'ads');
		
		return $this->showmessage(__('添加广告成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin/edit', array('ad_id' => $ad_id,'position_id' => $position))));
	}
	
	/**
	 * 广告编辑页面
	 */
	public function edit() {
		$this->admin_priv('adsense_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑广告', 'adsense')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => __('概述', 'adsense'),
			'content' => '<p>' . __('欢迎访问ECJia智能后台编辑广告页面，在此页面可以进行编辑广告操作。', 'adsense') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . __('更多信息：', 'adsense') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告列表#.E7.BC.96.E8.BE.91.E5.B9.BF.E5.91.8A" target="_blank">关于编辑广告帮助文档</a>', 'adsense') . '</p>');
		
		$ad_id =intval($_GET['ad_id']);
		$position_id =intval($_GET['position_id']);
		$show_client =intval($_GET['show_client']);
		$this->assign('show_client', $show_client);
		
		$this->assign('ur_here', __('编辑广告', 'adsense'));
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin/init', array('position_id' => $position_id,'show_client' => $show_client)), 'text' => __('广告列表', 'adsense')));
		
		$ads_arr = RC_DB::table('ad')->where('ad_id', $ad_id)->first();
		$ads_arr['start_time'] = RC_Time::local_date('Y-m-d', $ads_arr['start_time']);
		$ads_arr['end_time']   = RC_Time::local_date('Y-m-d', $ads_arr['end_time']);
		
		/* 标记为图片链接还是文字链接 */
		if (!empty($ads_arr['ad_code'])) {
			if (strpos($ads_arr['ad_code'], 'http://') === false) {
				$ads_arr['type'] = 1;
				$ads_arr['url'] = RC_Upload::upload_url($ads_arr['ad_code']);
			} else {
				$ads_arr['type'] = 0;
				$ads_arr['url'] = $ads_arr['ad_code'];
			}
		} else {
			$ads_arr['type'] = 0;
		}
		if ($ads_arr['media_type'] === 0) {
			if (strpos($ads_arr['ad_code'], 'http://') === false) {
				$src = $ads_arr['ad_code'];
				$this->assign('img_src', $src);
			} else {
				$src = $ads_arr['ad_code'];
				$this->assign('url_src', $src);
			}
		}
		if ($ads_arr['media_type'] === 0) {
			$this->assign('media_type', __('图片', 'adsense'));
		} elseif ($ads_arr['media_type'] === 2) {
			$this->assign('media_type', __('代码', 'adsense'));
		} elseif ($ads_arr['media_type'] === 3) {
			$this->assign('media_type', __('文字', 'adsense'));
		}
		
		$client_list = \Ecjia\App\Adsense\Client::displayClients();
		$this->assign('client_list', $client_list);
		
		$ads_arr['show_client'] = Ecjia\App\Adsense\Client::clients($ads_arr['show_client']);
		$this->assign('ads', $ads_arr);
		
		$position_list = $this->get_position_select_list();
		$this->assign('position_list', $position_list);
		
		$this->assign('form_action', RC_Uri::url('adsense/admin/update'));
		
		$position_data = RC_DB::table('ad_position')->where('position_id', $position_id)->first();
		$this->assign('position_data', $position_data);

        return $this->display('adsense_info.dwt');
	}
	
	/**
	 * 广告编辑的处理
	 */
	public function update() {
		$this->admin_priv('adsense_update', ecjia::MSGTYPE_JSON);
		
		$type 		= !empty($_POST['media_type']) 	? intval($_POST['media_type']) 	: 0;
		$id 		= !empty($_POST['id']) 			? intval($_POST['id']) 			: 0;
		$ad_name	= !empty($_POST['ad_name']) 	? trim($_POST['ad_name']) 		: '';
		$enabled    = intval($_POST['enabled']);
		
		if ($type === 0) {
			$ad_link = !empty($_POST['ad_link']) ? trim($_POST['ad_link']) : '';
		} else {
			$ad_link = !empty($_POST['ad_link2']) ? trim($_POST['ad_link2']) : '';
		}
		$start_time = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time']) : '0';
		$end_time = !empty($_POST['end_time']) ? RC_Time::local_strtotime($_POST['end_time']) : '0';
		$query = RC_DB::table('ad')->where('ad_name', $ad_name)->where('ad_id', '!=', $id)->count();
		if (!empty($ad_name)) {
			if ($query > 0) {
				return $this->showmessage(__('该广告名称已经存在！', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(__('请输入广告名称', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 获取旧的LOGO地址,并删除 */
		$ad_info = RC_DB::table('ad')->where('ad_id', $id)->first();
		$ad_logo = $ad_info['ad_code'];
		/* 编辑图片类型的广告 */
		if ($type == 0) {
			if ($this->request->hasFile('ad_img')) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/adsense', 'auto_sub_dirs' => false));
				$image_info = $upload->upload($_FILES['ad_img']);
				/* 如果要修改链接图片, 删除原来的图片 */
				if (!empty($image_info)) {
					if (strpos($ad_logo, 'http://') === false && strpos($ad_logo, 'https://') === false) {
						$upload->remove($ad_logo);
					}
					/* 获取新上传的LOGO的链接地址 */
					$ad_code = $upload->get_position($image_info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
				$ad_code = $ad_logo;
			}
		} elseif ($type == 2) {
			if (!empty($_POST['ad_code'])) {
				$ad_code = $_POST['ad_code'];
			} else {
				return $this->showmessage(__('广告的代码不能为空！', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} elseif ($type == 3) {
			if (!empty($_POST['ad_text'])) {
				$ad_code = $_POST['ad_text'];
			} else {
				return $this->showmessage(__('广告的内容不能为空！', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$ad_code = isset($ad_code) ? $ad_code : '';
		$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
		if (empty($_POST['show_client'])) {
			return $this->showmessage(__('请选择投放平台', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$show_client = Ecjia\App\Adsense\Client::clientSelected($_POST['show_client']);
		}
		$position_id = intval($_POST['position_id']);
		
		$show_client_value = intval($_POST['show_client_value']);
	
		$old_enabled = RC_DB::table('ad')->where('ad_id', $id)->value('enabled');
		$now_end_time = $_POST['end_time'];
		$now = RC_Time::local_date('Y-m-d', RC_Time::gmtime());
	
		if ($now > $now_end_time && $old_enabled != $enabled) {
			return $this->showmessage(__('该广告已过期暂无法进行开启/关闭操作', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$data = array(
				'position_id' 	=> $position_id,
				'ad_name' 		=> $ad_name,
				'ad_link' 		=> $ad_link,
				'ad_code' 		=> $ad_code,
				'start_time' 	=> $start_time,
				'end_time' 		=> $end_time,
				'link_man' 		=> !empty($_POST['link_man']) ? $_POST['link_man'] : '',
				'link_email' 	=> !empty($_POST['link_email']) ? $_POST['link_email'] : '',
				'link_phone' 	=> !empty($_POST['link_phone']) ? $_POST['link_phone'] : '',
				'enabled' 		=> $enabled,
				'sort_order' 	=> $sort_order,
				'show_client'   => $show_client,
			);
			/* 释放广告位缓存 */
			$ad_postion_db = RC_Model::model('adsense/orm_ad_position_model');
			$new_cache_key = sprintf('%X', crc32('adsense_position-' . $_POST['position_id']));
			$ad_postion_db->delete_cache_item($new_cache_key);
			$old_cache_key = sprintf('%X', crc32('adsense_position-' . $ad_info['position_id']));
			$ad_postion_db->delete_cache_item($old_cache_key);
			
			/* 更新数据 */
			RC_DB::table('ad')->where('ad_id', $id)->update($data);
			ecjia_admin::admin_log($ad_name, 'edit', 'ads');
			return $this->showmessage(__('编辑成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin/edit', array('ad_id' => $id, 'position_id' => $position_id))));
		}
	}
		
	/**
	 * 删除广告
	 */
	public function remove() {
		$this->admin_priv('adsense_delete', ecjia::MSGTYPE_JSON);
		
		$ad_id = intval($_GET['ad_id']);
		$info = RC_DB::table('ad')->where('ad_id', $ad_id)->first();
		
		if (strpos($info['ad_code'], 'http://') === false && strpos($info['ad_code'], 'https://') === false) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $info['ad_code']);
		}
		RC_DB::table('ad')->where('ad_id', $ad_id)->delete();
		
		$ad_postion_db = RC_Model::model('adsense/orm_ad_position_model');
		$cache_key = sprintf('%X', crc32('adsense_position-' . $info['position_id']));
		$ad_postion_db->delete_cache_item($cache_key);
		ecjia_admin::admin_log($info['ad_name'], 'remove', 'ads');
		
		return $this->showmessage(__('删除成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin/init', array('position_id' => $info['position_id']))));
	}
	
	/**
	 * 删除附件
	 */
	public function delfile() {
		$this->admin_priv('adsense_delete', ecjia::MSGTYPE_JSON);

		$ad_id = intval($_GET['ad_id']);
		$position_id = intval($_GET['position_id']);
		$show_client = intval($_GET['show_client']);
		
		$old_url = RC_DB::table('ad')->where('ad_id', $ad_id)->value('ad_code');

		$disk = RC_Storage::disk();
		$disk->delete(RC_Upload::upload_path($old_url));
		$data = array(
			'ad_code' => '' 
		);
		RC_DB::table('ad')->where('ad_id', $ad_id)->update($data);
		
		return $this->showmessage(__('删除成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin/edit', array('ad_id' => $ad_id, 'position_id' => $position_id, 'show_client' => $show_client))));
	}
	
	/**
	 * 编辑广告名称
	 */
	public function edit_ad_name() {
		$this->admin_priv('adsense_update');
	
		$id = intval($_POST['pk']);
		$ad_name = trim($_POST['value']);
		if (!empty($ad_name)) {
			if (RC_DB::table('ad')->where('ad_name', $ad_name)->count() != 0) {
				return $this->showmessage(sprintf(__('该广告名称已经存在！', 'adsense'), $ad_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$data = array(
					'ad_name' => $ad_name
				);
				RC_DB::table('ad')->where('ad_id', $id)->update($data);
				ecjia_admin::admin_log($ad_name, 'edit', 'ads');
				return $this->showmessage(__('编辑成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($ad_name)));
			}
		} else {
			return $this->showmessage(__('请输入广告名称', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('adsense_update');
			
		$id       = intval($_POST['id']);
		$val      = intval($_POST['val']);
		$position_id  = intval($_GET['position_id']);
		$show_client  = intval($_GET['show_client']);
		
		$end_time = RC_Time::local_date('Y-m-d', RC_DB::table('ad')->where('ad_id', $id)->value('end_time'));
		$now = RC_Time::local_date('Y-m-d', RC_Time::gmtime());
		if ($now > $end_time) {
			return $this->showmessage(__('该广告已过期暂无法进行开启/关闭操作', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			RC_DB::table('ad')->where('ad_id', $id)->update(array('enabled'=> $val));
			return $this->showmessage(__('切换成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin/init', array('position_id' => $position_id, 'show_client' => $show_client))));
		}
	}
	
	/**
	 * 编辑排序
	 */
	public function edit_sort() {
		$this->admin_priv('adsense_update');
	
		$id    		  = intval($_POST['pk']);
		$sort_order   = intval($_POST['value']);
		$show_client  = intval($_GET['show_client']);
		$position_id   = intval($_GET['position_id']);
			
		RC_DB::table('ad')->where('ad_id', $id)->update(array('sort_order'=> $sort_order));
		return $this->showmessage(__('编辑排序成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin/init', array('position_id' => $position_id, 'show_client' => $show_client))));
	}

	
	/**
	 * 获取广告位置下拉列表
	 */
	private function get_position_select_list() {
		$data = RC_DB::table('ad_position')->where('type','adsense')->select('position_id', 'position_name', 'ad_width', 'ad_height')->orderBy('position_id', 'desc')->get();
		$position_list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$position_list[$row['position_id']] = addslashes($row['position_name']) . ' [' . $row['ad_width'] . 'x' . $row['ad_height'] . ']';
			}
		}
		return $position_list;
	}
	
}

// end
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
 * ECJIA 广告位置管理程序
 * @author songqian
 */
class admin_position extends ecjia_admin {
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
		
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		RC_Script::enqueue_script('adsense', RC_App::apps_url('statics/js/adsense.js', __FILE__));
		RC_Script::enqueue_script('ad_position', RC_App::apps_url('statics/js/ad_position.js', __FILE__));
		$js_lang = array(
			'position_name_required' => RC_Lang::get('adsense::adsense.position_name_required'),
			'ad_width_required' => RC_Lang::get('adsense::adsense.ad_width_required'),
			'ad_height_required' => RC_Lang::get('adsense::adsense.ad_height_required') 
		);
		RC_Script::localize_script('ad_position', 'js_lang', $js_lang);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('adsense::adsense.ads_position'), RC_Uri::url('adsense/admin_position/init')));
	}
	
	/**
	 * 广告位置列表页面
	 */
	public function init() {
		$this->admin_priv('ad_position_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('adsense::adsense.ads_position')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => RC_Lang::get('adsense::adsense.overview'),
			'content' => '<p>' . RC_Lang::get('adsense::adsense.position_list_help') . '</p>' 
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . RC_Lang::get('adsense::adsense.more_info') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置" target="_blank">' . RC_Lang::get('adsense::adsense.about_position_list') . '</a>') . '</p>');
		
		$this->assign('ur_here', RC_Lang::get('adsense::adsense.position_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('adsense::adsense.position_add'), 'href' => RC_Uri::url('adsense/admin_position/add')));
		$this->assign('search_action', RC_Uri::url('adsense/admin_position/init'));
		
		$position_list = $this->get_ad_position_list();
		$this->assign('position_list', $position_list);
		$this->display('adsense_position_list.dwt');
	}
	
	/**
	 * 添加广告位页面
	 */
	public function add() {
		$this->admin_priv('ad_position_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('adsense::adsense.position_add')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => RC_Lang::get('adsense::adsense.overview'),
			'content' => '<p>' . RC_Lang::get('adsense::adsense.position_add_help') . '</p>' 
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . RC_Lang::get('adsense::adsense.more_info') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置#.E6.B7.BB.E5.8A.A0.E5.B9.BF.E5.91.8A.E4.BD.8D.E7.BD.AE" target="_blank">' . RC_Lang::get('adsense::adsense.about_add_position') . '</a>') . '</p>');
		
		$this->assign('ur_here', RC_Lang::get('adsense::adsense.position_add'));
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_position/init'), 'text' => RC_Lang::get('adsense::adsense.position_list')));
		$this->assign('posit_arr', array('position_style' => '<table cellpadding="0" cellspacing="0">' . "\n" . '{foreach from=$ads item=ad}' . "\n" . '<tr><td>{$ad}</td></tr>' . "\n" . '{/foreach}' . "\n" . '</table>'));
		$this->assign('action', 'insert');
		$this->assign('form_action', RC_Uri::url('adsense/admin_position/insert'));
		$this->display('adsense_position_info.dwt');
	}
	
	/**
	 * 添加广告位页面
	 */
	public function insert() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
		$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
		$ad_width = !empty($_POST['ad_width']) ? intval($_POST['ad_width']) : 0;
		$ad_height = !empty($_POST['ad_height']) ? intval($_POST['ad_height']) : 0;
		$position_style = !empty($_POST['position_style']) ? $_POST['position_style'] : '';
		
		/* 查看广告位是否有重复 */
		if (RC_DB::table('ad_position')->where('position_name', $position_name)->count() == 0) {
			$data = array(
				'position_name' => $position_name,
				'ad_width' => $ad_width,
				'ad_height' => $ad_height,
				'position_desc' => $position_desc,
				'position_style' => $position_style 
			);
			$position_id = RC_DB::table('ad_position')->insertGetId($data);
			ecjia_admin::admin_log($position_name, 'add', 'ads_position');
			$links[] = array('text' => RC_Lang::get('adsense::adsense.back_position_list'), 'href' => RC_Uri::url('adsense/admin_position/init'));
			$links[] = array('text' => RC_Lang::get('adsense::adsense.continue_add_position'), 'href' => RC_Uri::url('adsense/admin_position/add'));
			return $this->showmessage(RC_Lang::get('adsense::adsense.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('adsense/admin_position/edit', array('id' => $position_id))));
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.posit_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 广告位编辑页面
	 */
	public function edit() {
		$this->admin_priv('ad_position_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('adsense::adsense.position_edit')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => RC_Lang::get('adsense::adsense.overview'),
			'content' => '<p>' . RC_Lang::get('adsense::adsense.position_edit_help') . '</p>' 
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . RC_Lang::get('adsense::adsense.more_info') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置#.E7.BC.96.E8.BE.91.E5.B9.BF.E5.91.8A.E4.BD.8D.E7.BD.AE" target="_blank">' . RC_Lang::get('adsense::adsense.about_edit_position') . '</a>') . '</p>');
		$this->assign('ur_here', RC_Lang::get('adsense::adsense.position_edit'));
		$this->assign('action_link', array(
			'href' => RC_Uri::url('adsense/admin_position/init'),
			'text' => RC_Lang::get('adsense::adsense.position_list') 
		));
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$posit_arr = RC_DB::table('ad_position')->where('position_id', $id)->first();
		$this->assign('posit_arr', $posit_arr);
		$this->assign('action', 'update');
		$this->assign('form_action', RC_Uri::url('adsense/admin_position/update'));
		$this->display('adsense_position_info.dwt');
	}
	
	/**
	 * 广告位编辑处理
	 */
	public function update() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$position_name 	= !empty($_POST['position_name']) 	? trim($_POST['position_name']) 					: '';
		$position_desc 	= !empty($_POST['position_desc']) 	? nl2br(htmlspecialchars($_POST['position_desc'])) 	: '';
		$ad_width 		= !empty($_POST['ad_width']) 		? intval($_POST['ad_width']) 						: 0;
		$ad_height 		= !empty($_POST['ad_height']) 		? intval($_POST['ad_height']) 						: 0;
		$position_style = !empty($_POST['position_style']) 	? $_POST['position_style'] 							: '';
		$position_id 	= !empty($_POST['id']) 				? intval($_POST['id']) 								: 0;
		
		$count = RC_DB::table('ad_position')->where('position_name', $position_name)->where('position_id', '!=', $position_id)->count();
		if ($count == 0) {
			$data = array(
				'position_name' 	=> $position_name,
				'ad_width' 			=> $ad_width,
				'ad_height' 		=> $ad_height,
				'position_desc' 	=> $position_desc,
				'position_style' 	=> $position_style 
			);
			RC_DB::table('ad_position')->where('position_id', $position_id)->update($data);
			ecjia_admin::admin_log($position_name, 'edit', 'ads_position');
			return $this->showmessage(RC_Lang::get('adsense::adsense.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.posit_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑广告位置名称
	 */
	public function edit_position_name() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$position_name = trim($_POST['value']);
		if (!empty($position_name)) {
			if (RC_DB::table('ad_position')->where('position_name', $position_name)->count() != 0) {
				return $this->showmessage(sprintf(RC_Lang::get('adsense::adsense.posit_name_exist'), $position_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$data = array(
					'position_name' => $position_name 
				);
				RC_DB::table('ad_position')->where('position_id', $id)->update($data);
				ecjia_admin::admin_log($position_name, 'edit', 'ads_position');
				return $this->showmessage(RC_Lang::get('adsense::adsense.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($position_name)));
			}
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.ad_name_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑广告位宽
	 */
	public function edit_ad_width() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$ad_width = trim($_POST['value']);
		if (!empty($ad_width)) {
			if (!preg_match('/^[\\.0-9]+$/', $ad_width)) {
				return $this->showmessage(RC_Lang::get('adsense::adsense.width_number'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($ad_width > 1024 || $ad_width < 1) {
				return $this->showmessage(RC_Lang::get('adsense::adsense.width_value'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$data = array(
				'ad_width' => $ad_width 
			);
			RC_DB::table('ad_position')->where('position_id', $id)->update($data);
			ecjia_admin::admin_log($ad_width, 'edit', 'ads_position');
			return $this->showmessage(RC_Lang::get('adsense::adsense.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($ad_width)));
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.ad_width_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑广告位宽
	 */
	public function edit_ad_height() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$ad_height = trim($_POST['value']);
		if (!empty($ad_height)) {
			if (!preg_match('/^[\\.0-9]+$/', $ad_height)) {
				return $this->showmessage(RC_Lang::get('adsense::adsense.height_number'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($ad_height > 1024 || $ad_height < 1) {
				return $this->showmessage(RC_Lang::get('adsense::adsense.height_value'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$data = array(
				'ad_height' => $ad_height 
			);
			RC_DB::table('ad_position')->where('position_id', $id)->update($data);
			ecjia_admin::admin_log($ad_height, 'edit', 'ads_position');
			return $this->showmessage(RC_Lang::get('adsense::adsense.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($ad_height)));
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.ad_height_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除广告位置
	 */
	public function remove() {
		$this->admin_priv('ad_position_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		if (RC_DB::table('ad')->where('position_id', $id)->count() != 0) {
			return $this->showmessage(RC_Lang::get('adsense::adsense.not_del_adposit'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$position_name = RC_DB::table('ad_position')->where('position_id', $id)->pluck('position_name');
			ecjia_admin::admin_log($position_name, 'remove', 'ads_position');
			RC_DB::table('ad_position')->where('position_id', $id)->delete();
		}
		return $this->showmessage(RC_Lang::get('adsense::adsense.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取广告位置列表
	 */
	private function get_ad_position_list() {
		$db_ad_position = RC_DB::table('ad_position');
		
		$filter = $where = array();
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		if ($filter['keywords']) {
			$db_ad_position->where('position_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
		}
		$count = $db_ad_position->count();
		$page = new ecjia_page($count, 10, 5);
		$db_ad_position->orderby('position_id', 'desc')->take(10)->skip($page->start_id - 1);
		$data = $db_ad_position->get();
		
		$arr = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$position_desc = !empty($rows['position_desc']) ? RC_String::sub_str($rows['position_desc'], 50, true) : '';
				$rows['position_desc'] = nl2br(htmlspecialchars($position_desc));
				$arr[] = $rows;
			}
		}
		return array('item' => $arr, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

// end
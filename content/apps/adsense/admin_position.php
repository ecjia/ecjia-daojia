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
		
		Ecjia\App\Adsense\Helper::assign_adminlog_content();
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		
		RC_Script::enqueue_script('group', RC_App::apps_url('statics/js/group.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('ad_position', RC_App::apps_url('statics/js/ad_position.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('adsense', RC_App::apps_url('statics/js/adsense.js', __FILE__), array(), false, 1);
		RC_Style::enqueue_style('adsense', RC_App::apps_url('statics/styles/adsense.css', __FILE__), array());

		RC_Script::localize_script('group', 'js_lang', config('app-adsense::jslang.adsense_page'));


        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('广告位管理', 'adsense'), RC_Uri::url('adsense/admin_position/init')));
	}
	
	/**
	 * 广告位置列表页面
	 */
	public function init() {
		$this->admin_priv('ad_position_manage');
			
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('广告位管理', 'adsense')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => __('概述', 'adsense'),
			'content' => '<p>' . __('欢迎访问ECJia智能后台广告位置列表页面，系统中所有的广告位置都会显示在此列表中。', 'adsense') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . __('更多信息：', 'adsense') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置" target="_blank">' . __('关于广告位置列表帮助文档', 'adsense') . '</a>') . '</p>');
		
		$this->assign('ur_here', __('广告位置列表', 'adsense'));
		$this->assign('action_link', array('text' => __('添加广告位', 'adsense'), 'href' => RC_Uri::url('adsense/admin_position/add')));
		
		//获取城市
		$citymanage = new Ecjia\App\Adsense\CityManage('adsense');
		$city_list = $citymanage->getAllCitys();
		$this->assign('city_list', $city_list);
		
		//获取当前城市ID
		$city_id = $citymanage->getCurrentCity(trim($_GET['city_id']));
		$this->assign('city_id', $city_id);
		
		$sort_by   = trim($_GET['sort_by']);
		$sort_order= trim($_GET['sort_order']);
		if (!empty($sort_by)) {
			$orderBy = array($sort_by => $sort_order);
		} else {
			$orderBy = array();
		}
		
		//获取广告位列表
		$position = new Ecjia\App\Adsense\PositionManage('adsense', $city_id);
		$data = $position->getAllPositions($orderBy);
		$this->assign('data', $data);
		$this->assign('search_action', RC_Uri::url('adsense/admin_position/init'));
		
		$this->display('adsense_position_list.dwt');
	}
	
	/**
	 * 添加广告位页面
	 */
	public function add() {
		$this->admin_priv('ad_position_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加广告位', 'adsense')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => __('概述', 'adsense'),
			'content' => '<p>' . __('欢迎访问ECJia智能后台添加广告位置页面，在此页面可以进行添加广告位置操作。', 'adsense') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . __('更多信息：', 'adsense') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置#.E6.B7.BB.E5.8A.A0.E5.B9.BF.E5.91.8A.E4.BD.8D.E7.BD.AE" target="_blank">关于添加广告位置帮助文档</a>', 'adsense') . '</p>');
		
		$this->assign('ur_here', __('添加广告位', 'adsense'));
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_position/init'), 'text' => __('广告位列表', 'adsense')));
		
		//$city_list = $this->get_business_city();
		$city_list	 = $this->get_business_city();
		$this->assign('city_list', $city_list);
		
		$this->assign('action', 'insert');
		$this->assign('form_action', RC_Uri::url('adsense/admin_position/insert'));
		
		$this->display('adsense_position_info.dwt');
	}
	
	/**
	 * 添加广告位页面
	 */
	public function insert() {
    	$this->admin_priv('ad_position_update');
    	
    	$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
    	$position_code = !empty($_POST['position_code_ifnull']) ? trim($_POST['position_code_ifnull']) : '';
    	$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    	$ad_width      = !empty($_POST['ad_width']) ? intval($_POST['ad_width']) : 0;
    	$ad_height     = !empty($_POST['ad_height']) ? intval($_POST['ad_height']) : 0;
    	$max_number    = !empty($_POST['max_number']) ? intval($_POST['max_number']) : 0;
    	$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
    	
    	$city_id       = isset($_POST['city_id']) ? trim($_POST['city_id']) : 0;
    	$city_name     = ecjia_region::getRegionName($city_id);
    	if (!$city_name) {
    		$city_name = __('默认', 'adsense');
    	}
    	$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('city_id', $city_id)->where('type', 'adsense')->count();
    	if ($query > 0) {
    		return $this->showmessage(__('该广告位代号在当前城市中已存在', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$data = array(
    		'position_name' => $position_name,
    		'position_code' => $position_code,
    		'ad_width'      => $ad_width,
    		'ad_height'     => $ad_height,
    		'max_number'    => $max_number,
    		'position_desc' => $position_desc,
    		'city_id' 		=> $city_id,
    		'city_name' 	=> $city_name,
    		'type' 			=> 'adsense',
    		'sort_order' 	=> $sort_order,
    	);
    	$position_id = RC_DB::table('ad_position')->insertGetId($data);
    	ecjia_admin::admin_log($position_name, 'add', 'ads_position');
    	return $this->showmessage(__('添加广告位成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_position/edit', array('position_id' => $position_id))));
    }
	
	/**
	 * 广告位编辑页面
	 */
	public function edit() {
		$this->admin_priv('ad_position_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑广告位', 'adsense')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => __('概述', 'adsense'),
			'content' => '<p>' . __('欢迎访问ECJia智能后台编辑广告位置页面，在此页面可以进行编辑广告位置操作。', 'adsense') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . __('更多信息：', 'adsense') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置#.E7.BC.96.E8.BE.91.E5.B9.BF.E5.91.8A.E4.BD.8D.E7.BD.AE" target="_blank">关于编辑广告位置帮助文档</a>', 'adsense') . '</p>');
		$this->assign('ur_here', __('编辑广告位', 'adsense'));
		$this->assign('action_link', array(
			'href' => RC_Uri::url('adsense/admin_position/init'),
			'text' => __('广告位置列表', 'adsense')
		));
		$position_id = intval($_GET['position_id']);
		$data = RC_DB::table('ad_position')->where('position_id', $position_id)->first();
		$this->assign('data', $data);
		
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_position/init', array('city_id' => $data['city_id'])), 'text' => '广告位列表'));
		 
		//$city_list = $this->get_select_city();
		$city_list	 = $this->get_business_city();
		$this->assign('city_list', $city_list);
		
		$this->assign('form_action', RC_Uri::url('adsense/admin_position/update'));
		
		$this->display('adsense_position_info.dwt');
	}
	
	/**
	 * 广告位编辑处理
	 */
	public function update() {
    	$this->admin_priv('ad_position_update');
    	 
    	$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
    	$position_code_value = !empty($_POST['position_code_value']) ? trim($_POST['position_code_value']) : '';
    	$position_code_ifnull = !empty($_POST['position_code_ifnull']) ? trim($_POST['position_code_ifnull']) : '';
    	
    	if (!empty($position_code_ifnull)) {
    		$position_code = $position_code_ifnull;
    	} else {
    		$position_code = $position_code_value;
    	}
    	
    	$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    	$ad_width      = !empty($_POST['ad_width']) ? intval($_POST['ad_width']) : 0;
    	$ad_height     = !empty($_POST['ad_height']) ? intval($_POST['ad_height']) : 0;
    	$max_number    = !empty($_POST['max_number']) ? intval($_POST['max_number']) : 0;
    	$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
    	
    	$city_id       = isset($_POST['city_id']) ? trim($_POST['city_id']) : 0;
    	$city_name     = ecjia_region::getRegionName($city_id);
    	if (!$city_name) {
    		$city_name = __('默认', 'adsense');
    	}
    	$position_id = intval($_POST['position_id']);
    	$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('type', 'adsense')->where('city_id', $city_id)->where('position_id', '!=', $position_id)->count();
    	if ($query > 0) {
    		return $this->showmessage(__('该广告位代号在当前城市中已存在', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$data = array(
    		'position_name' => $position_name,
    		'position_code' => $position_code,
    		'ad_width'      => $ad_width,
    		'ad_height'     => $ad_height,
    		'max_number'    => $max_number,
    		'position_desc' => $position_desc,
    		'city_id' 		=> $city_id,
    		'city_name' 	=> $city_name,
    		'sort_order' 	=> $sort_order,
    	);
    	
    	RC_DB::table('ad_position')->where('position_id', $position_id)->update($data);
    	ecjia_admin::admin_log($position_name, 'edit', 'ads_position');
    	return $this->showmessage(__('编辑广告位成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_position/edit', array('position_id' => $position_id, 'city_id' => $city_id))));
    }

	/**
	 * 删除广告位置
	 */
	public function remove() {
		$this->admin_priv('ad_position_delete');
	
		$id = intval($_GET['id']);
		if (RC_DB::table('ad')->where('position_id', $id)->count() != 0) {
			return $this->showmessage(__('该广告位已经有广告存在，不能删除！', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$position_name = RC_DB::table('ad_position')->where('position_id', $id)->pluck('position_name');
			ecjia_admin::admin_log($position_name, 'remove', 'ads_position');
			RC_DB::table('ad_position')->where('position_id', $id)->delete();
			return $this->showmessage(__('删除成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_position/init')));
		}
	}
	
	public function copy() {
		$this->admin_priv('ad_position_update');
		
		$position_id = intval($_GET['position_id']);
		$position_code = RC_DB::table('ad_position')->where('position_id', $position_id)->pluck('position_code');
		 
		$position_name = trim($_GET['position_name']);
		$position_desc = $_GET['position_desc'];
		$ad_width      = intval($_GET['ad_width']);
		$ad_height     = intval($_GET['ad_height']);
		$max_number    = intval($_GET['max_number']);
		$sort_order    = intval($_GET['sort_order']);
		
		$city_id = trim($_GET['city_id']);
		$city_name     = ecjia_region::getRegionName($city_id);
		if (!$city_name) {
			$city_name = __('默认', 'adsense');
		}
		 
		$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('city_id', $city_id)->where('type', 'adsense')->count();
		if ($query > 0) {
			return $this->showmessage(__('请重新选择城市，该广告位代号在当前城市中已存在', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$data = array(
    		'position_name' => $position_name,
    		'position_code' => $position_code,
    		'position_desc' => $position_desc,
    		'ad_width'      => $ad_width,
    		'ad_height'     => $ad_height,
    		'max_number'    => $max_number,
    		'city_id' 		=> $city_id,
    		'city_name' 	=> $city_name,
    		'type' 			=> 'adsense',
    		'sort_order' 	=> $sort_order,
    	);
	
		$position_id = RC_DB::table('ad_position')->insertGetId($data);
		ecjia_admin::admin_log($position_name, 'copy', 'ads_position');
		return $this->showmessage(__('复制成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_position/edit', array('position_id' => $position_id,'city_id' => $city_id))));
	}
	
	/**
	 * 编辑广告位置名称
	 */
	public function edit_position_name() {
		$this->admin_priv('ad_position_update');
	
		$id = intval($_POST['pk']);
		$position_name = trim($_POST['value']);
		if (!empty($position_name)) {
			if (RC_DB::table('ad_position')->where('position_name', $position_name)->count() != 0) {
				return $this->showmessage(sprintf(__('此广告位已经存在了！', 'adsense'), $position_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$data = array(
						'position_name' => $position_name
				);
				RC_DB::table('ad_position')->where('position_id', $id)->update($data);
				ecjia_admin::admin_log($position_name, 'edit', 'ads_position');
				return $this->showmessage(__('编辑成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_position/init')));
			}
		} else {
			return $this->showmessage(__('请输入广告位名称', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑排序
	 */
	public function edit_sort() {
		$this->admin_priv('ad_position_update');
	
		$id    = intval($_POST['pk']);
		$sort_order   = intval($_POST['value']);
		$city_id      = trim($_GET['city_id']);
		RC_DB::table('ad_position')->where('position_id', $id)->update(array('sort_order'=> $sort_order));
		$group_position_id  = intval($_GET['group_position_id']);
		if ($group_position_id) {
			return $this->showmessage(__('编辑排序成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin_group/group_position_list', array('position_id' => $group_position_id, 'city_id' => $city_id))));
		}else{
			return $this->showmessage(__('编辑排序成功', 'adsense'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin_position/init', array('position_id' => $id, 'city_id' => $city_id))));
		}
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
		
		$db_ad_position->where(RC_DB::raw('type'), 'adsense');
		
		$count = $db_ad_position->count();
		$page = new ecjia_page($count, 10, 5);
		$data = $db_ad_position
				->orderby('position_id', 'desc')
				->take(10)
				->skip($page->start_id - 1)
				->get();
		
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
	
	/**
	 * 获取热门城市
	 */
	private function get_select_city() {
		$data = ecjia_region::getRegions(explode(',', ecjia::config('mobile_recommend_city')));
		$regions = array ();
		if (!empty($data)) {
			foreach ($data as $row) {
				$regions[$row['region_id']] = addslashes($row['region_name']);
			}
		}
		return $regions;
	}
	
	/**
	 * 获取经营城市
	 */
	private function get_business_city() {
		$data = RC_DB::table('store_business_city')->orderBy(RC_DB::raw('index_letter'), 'asc')->get();
		$regions = [];
		if (!empty($data)) {
			foreach ($data as $row) {
				$regions[$row['business_city']] = addslashes($row['business_city_name']);
			}
		}
		return $regions;
	}
	
	private function get_city_list() {
		$city_list = RC_DB::table('ad_position')->where('type', 'adsense')->select(RC_DB::raw('distinct city_id,city_name'))->orderBy('city_id', 'asc')->get();
		foreach ($city_list as $key => $val) {
			$count = RC_DB::table('ad_position')->where('type', 'adsense')->where('city_id', $val['city_id'])->count();
			$city_list[$key]['count']=$count;
		}
		return $city_list;
	}
}

// end
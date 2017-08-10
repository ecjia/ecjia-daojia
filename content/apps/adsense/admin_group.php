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

class admin_group extends ecjia_admin {
    
    public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Loader::load_app_func('global');
		assign_adminlog_contents();
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
			
		RC_Script::enqueue_script('group', RC_App::apps_url('statics/js/group.js', __FILE__));
		RC_Script::enqueue_script('ad_position', RC_App::apps_url('statics/js/ad_position.js', __FILE__));
		RC_Script::enqueue_script('adsense', RC_App::apps_url('statics/js/adsense.js', __FILE__));
		RC_Style::enqueue_style('adsense', RC_App::apps_url('statics/styles/adsense.css', __FILE__), array());
		RC_Style::enqueue_style('group', RC_App::apps_url('statics/styles/group.css', __FILE__), array());

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('广告组', RC_Uri::url('adsense/admin_group/init')));
	}

	
	public function init() {
		$this->admin_priv('ad_group_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('广告组'));
		$this->assign('ur_here', '广告组');
		
		//获取城市
		$citymanage = new Ecjia\App\Adsense\CityManage('group');
		$city_list = $citymanage->getAllCitys();
		$this->assign('city_list', $city_list);
		
		//获取当前城市ID
		$city_id = $citymanage->getCurrentCity(intval($_GET['city_id']));
		$this->assign('city_id', $city_id);
		
		//获取广告组列表
		$position = new Ecjia\App\Adsense\PositionManage('group', $city_id);
		$data = $position->getAllPositions();
		foreach ($data as $key => $val) {
			$count = RC_DB::table('ad_position')->where('group_id', $val['position_id'])->count();
			$data[$key]['count'] = $count;
		}
		$this->assign('data', $data);
		
		$this->display('adsense_group_list.dwt');
	}
	
	public function add() {
		$this->admin_priv('ad_group_update');
		 
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加广告组'));
		$this->assign('ur_here', '添加广告组');
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_group/init'), 'text' => '广告组'));
		 
		$city_list = $this->get_select_city();
		$this->assign('city_list', $city_list);
		
		$this->assign('form_action', RC_Uri::url('adsense/admin_group/insert'));
		 
		$this->display('adsense_group_info.dwt');
	}
	
	
	public function insert() {
		$this->admin_priv('ad_group_update');
		 
		$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
		$position_code = !empty($_POST['position_code']) ? trim($_POST['position_code']) : '';
		$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
		$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
		$city_id       = !empty($_POST['city_id']) ? intval($_POST['city_id']) : 0;
		$city_name     = RC_DB::TABLE('region')->where('region_id', $city_id)->pluck('region_name');
		if (!$city_name) {
			$city_name = '默认';
		}
		$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('city_id', $city_id)->where('type', 'group')->count();
		if ($query > 0) {
			return $this->showmessage('该广告组代号在当前城市中已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		 
		$data = array(
				'position_name' => $position_name,
				'position_code' => $position_code,
				'position_desc' => $position_desc,
				'city_id' 		=> $city_id,
				'city_name' 	=> $city_name,
				'type' 			=> 'group',
				'sort_order' 	=> $sort_order,
		);
		
		$position_id = RC_DB::table('ad_position')->insertGetId($data);
		ecjia_admin::admin_log($position_name, 'add', 'group_position');
		return $this->showmessage('添加广告组成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_group/edit', array('position_id' => $position_id, 'city_id' => $city_id))));
	}
	
	public function edit() {
		$this->admin_priv('ad_group_update');
		 
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑广告组'));
		$this->assign('ur_here', '编辑广告组');

		$city_id = $_GET['city_id'];
		$this->assign('city_id', $city_id);
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_group/init',array('city_id' => $city_id)), 'text' => '广告组'));

		 
		$city_list = $this->get_select_city();
		$this->assign('city_list', $city_list);
		
		$position_id = intval($_GET['position_id']);
		$data = RC_DB::table('ad_position')->where('position_id', $position_id)->first();
		$this->assign('data', $data);
		 
		$this->assign('form_action', RC_Uri::url('adsense/admin_group/update'));
	
		$this->display('adsense_group_info.dwt');
	}
	
	public function update() {
		$this->admin_priv('ad_group_update');
	
		$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
		$position_code = !empty($_POST['position_code']) ? trim($_POST['position_code']) : '';
		$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
		$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
		
		$city_id       = intval($_POST['city_id']);
		$city_name     = RC_DB::TABLE('region')->where('region_id', $city_id)->pluck('region_name');
		if (!$city_name) {
			$city_name = '默认';
		}
		$position_id   = intval($_POST['position_id']);
		$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('type', 'group')->where('city_id', $city_id)->where('position_id', '!=', $position_id)->count();
		if ($query > 0) {
			return $this->showmessage('该广告组代号在当前城市中已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		 
		$data = array(
			'position_name' => $position_name,
			'position_desc' => $position_desc,
			'city_id' 		=> $city_id,
			'city_name' 	=> $city_name,
			'sort_order' 	=> $sort_order,
		);
		 
		RC_DB::table('ad_position')->where('position_id', $position_id)->update($data);
		ecjia_admin::admin_log($position_name, 'edit', 'group_position');
		return $this->showmessage('编辑广告组成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_group/edit', array('position_id' => $position_id,'city_id' => $city_id))));
	}
	
	public function copy() {
		$this->admin_priv('ad_group_update');
	
		$position_id = intval($_GET['position_id']);
		$position_code = RC_DB::TABLE('ad_position')->where('position_id', $position_id)->pluck('position_code');
		$position_name = trim($_GET['position_name']);
		$position_desc = $_GET['position_desc'];
		$sort_order    = intval($_GET['sort_order']);
		
		$city_id = intval($_GET['city_id']);
		$city_name     = RC_DB::TABLE('region')->where('region_id', $city_id)->pluck('region_name');
		if (!$city_name) {
			$city_name = '默认';
		}
		$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('city_id', $city_id)->where('type', 'group')->count();
		if ($query > 0) {
			return $this->showmessage('请重新选择城市，该广告组代号在当前城市中已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$data = array(
			'position_name' => $position_name,
			'position_code' => $position_code,
			'position_desc' => $position_desc,
			'city_id' 		=> $city_id,
			'city_name' 	=> $city_name,
			'type' 			=> 'group',
			'sort_order' 	=> $sort_order,
		);
	
		$position_id = RC_DB::table('ad_position')->insertGetId($data);
		ecjia_admin::admin_log($position_name, 'copy', 'group_position');
		return $this->showmessage('复制成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_group/edit', array('position_id' => $position_id,'city_id' => $city_id))));
	}
	
	/**
	 * 删除广告组
	 */
	public function remove() {
		$this->admin_priv('ad_group_delete');
		$group_position_id = intval($_GET['group_position_id']);
		$city_id = intval($_GET['city_id']);

		if (RC_DB::table('ad_position')->where('group_id', $group_position_id)->count() > 0) {
			if ($_GET['key']) {
				return $this->showmessage('该广告组已进行广告位编排，不能删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR,array('pjaxurl' => RC_Uri::url('adsense/admin_group/constitute',array('city_id' => $city_id, 'position_id' => $group_position_id))));
			} else {
				return $this->showmessage('该广告组已进行广告位编排，不能删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR,array('pjaxurl' => RC_Uri::url('adsense/admin_group/group_position_list',array('city_id' => $city_id, 'position_id' => $group_position_id))));
			}
		} else {
			$position_name = RC_DB::table('ad_position')->where('position_id', $group_position_id)->pluck('position_name');
			ecjia_admin::admin_log($position_name, 'remove', 'group_position');
			RC_DB::table('ad_position')->where('position_id', $group_position_id)->delete();
			return $this->showmessage('删除广告组成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_group/init')));
		}
	}
	
	public function constitute() {
		$this->admin_priv('ad_group_update');
		 
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('组合广告组'));
		$this->assign('ur_here', '组合广告组');

		$city_id = intval($_GET['city_id']);
		$this->assign('city_id', $city_id);
		
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_group/init',array('city_id' => $city_id)), 'text' => '广告组'));

		$position_id = intval($_GET['position_id']);
		$this->assign('position_id', $position_id);
		
		$position_data = RC_DB::table('ad_position')->where('position_id', $position_id)->first();
		$this->assign('position_data', $position_data);

		//指定地区下面的广告位列表-左边
		$arr =RC_DB::TABLE('ad_position')->where('city_id', $city_id)->where('type', 'adsense')->select('position_name', 'position_id', 'sort_order')->get();
		$optarray = array();
		if (!empty($arr)) {
			foreach ($arr AS $key => $val) {
				$optarray[] = array(
					'position_id' => $val['position_id'],
					'position_name'  => $val['position_name'],
				);
			}
		}
		$this->assign('opt', $optarray);
	
		//选择广告组中的广告位-右边
		$group_position_list = RC_DB::table('ad_position')
		->where('group_id', $position_id)
		->select('position_id', 'position_name')
		->orderBy('sort_order','asc')
		->get();
		
		$this->assign('group_position_list', $group_position_list);
		
		$this->display('adsense_group_constitute.dwt');
	
	}
	
	public function constitute_insert() {
		$this->admin_priv('ad_group_update');
		
		$city_id = intval($_GET['city_id']);
		
		$group_position_id	= intval($_GET['position_id']);//广告组id
		$position_name = RC_DB::TABLE('ad_position')->where('position_id', $group_position_id)->pluck('position_name');
		$data = array('group_id' => 0);
		RC_DB::table('ad_position')->where('group_id', $group_position_id)->update($data);
		
		$linked_array = $_GET['linked_array'];
		if (!empty($linked_array)) {
			foreach ($linked_array as $key => $val) {
				$data= array('group_id' => $group_position_id ,'sort_order' => intval($key));
				RC_DB::table('ad_position')->where('position_id', intval($val))->update($data);
			}
		}
		ecjia_admin::admin_log($position_name, 'constitute', 'group_position');
		return $this->showmessage('编排广告位成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_group/constitute', array('position_id' => $group_position_id,'city_id' => $city_id))));
	}
	
	
	public function update_sort() {
		$this->admin_priv('ad_group_update');
		
		$position_array = $_GET['position_array'];
		if (!empty($position_array)) {
			foreach ($position_array as $row) {
				$data= array('sort_order' => $row['position_sort']);
				RC_DB::table('ad_position')->where('position_id', $row['position_id'])->update($data);
			}
		}		
	}
	
	public function group_position_list() {
	
		$this->admin_priv('ad_group_manage');
			
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('组合列表'));
		$this->assign('ur_here', '组合列表');
		
		$city_id = intval($_GET['city_id']);
		$this->assign('city_id', $city_id);
		
		$group_position_id = intval($_GET['position_id']);
		$this->assign('position_id', $group_position_id);
		
		$position_data = RC_DB::table('ad_position')->where('position_id', $group_position_id)->first();
		$this->assign('position_data', $position_data);
				
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_group/init',array('city_id' => $city_id)), 'text' => '广告组'));
		$this->assign('edit_action_link', array('href' => RC_Uri::url('adsense/admin_group/constitute',array('city_id' => $city_id, 'position_id' => $group_position_id)), 'text' => '进行组合'));
	
		$filter['sort_by']    = empty($_GET['sort_by']) ? 'sort_order' : trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order']) ? 'asc' : trim($_GET['sort_order']);
		
		$data = RC_DB::table('ad_position')
		->where('group_id', $group_position_id)
		->select('position_id', 'position_name','position_code','position_desc','ad_width','ad_height','sort_order')
		->orderBy($filter['sort_by'], $filter['sort_order'])
		->get();
		$this->assign('data', $data);
		
		$this->display('adsense_group_position_list.dwt');
	}
		
	/**
	 * 获取热门城市
	 */
	private function get_select_city() {
		$data = explode(',', ecjia::config('mobile_recommend_city'));
		$data = RC_DB::table('region')->whereIn('region_id', $data)->get();
		$regions = array ();
		if (!empty($data)) {
			foreach ($data as $row) {
				$regions[$row['region_id']] = addslashes($row['region_name']);
			}
		}
		return $regions;
	}  
}
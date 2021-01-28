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
 * 商家经营城市管理
 */
class admin_store_business_city extends ecjia_admin {
	
	public function __construct() {
		
		parent::__construct();
		RC_Loader::load_app_func('global');
		Ecjia\App\Store\Helper::assign_adminlog_content();
		
		
		//全局JS和CSS
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-validate');
		
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Script::enqueue_script('region', RC_Uri::admin_url('statics/lib/ecjia_js/ecjia.region.js'));
		
		RC_Script::enqueue_script('store_business_city', RC_App::apps_url('statics/js/store_business_city.js', __FILE__), array(), false, 1);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家经营城市', 'store'), RC_Uri::url('store/admin_store_business_city/init')));
	}
	
	/**
	 * 商家经营城市列表
	 */
	public function init() {
	    $this->admin_priv('store_business_city_manage');
		
	    ecjia_screen::get_current_screen()->remove_last_nav_here();
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('经营城市列表', 'store')));
	   
	    $business_city_list = RC_DB::table('store_business_city')->orderBy('index_letter', 'asc')->get();
	    if (!empty($business_city_list)) {
	    	foreach ($business_city_list as $key => $val) {
	    		if (!empty($val['business_district'])) {
	    			$business_district = explode(',', $val['business_district']);
	    			foreach ($business_district as $res) {
	    				$district_name = ecjia_region::getRegionName($res);
	    				$business_city_list[$key]['business_district_name'][] = array('district_id' => $res, 'district_name' => $district_name);
	    			}
	    		}
	    	}
	    }
	  	
	    $this->assign('business_city_list', $business_city_list);
		
	    $this->assign('ur_here',__('经营城市列表', 'store'));
	    $this->assign('action_link', array('text' => __('添加经营城市', 'store'),'href'=>RC_Uri::url('store/admin_store_business_city/add')));
        return $this->display('store_business_city_list.dwt');
	}

	
	/**
	 * 添加经营城市
	 */
	public function add() {
		$this->admin_priv('store_business_city_manage');
		
		$provinces = ecjia_region::getSubarea(ecjia::config('shop_country'));//获取当前国家的所有省份
		$this->assign('province', $provinces);
	
		$data = $this->fetch('store_business_city_add.dwt');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	/**
	 * 
	 * 添加经营城市的处理
	 */
	public function insert() {
		$this->admin_priv('store_business_city_manage', ecjia::MSGTYPE_JSON);
		
		$business_city_alias    = trim($_POST['business_city_alias']);
		$index_letter		    = strtoupper($_POST['index_letter']);
		$province				= trim($_POST['province']);
		$city    				= trim($_POST['city']);
		$district    			= trim($_POST['district']);

		if ( empty($city) || empty($province)) {
			return $this->showmessage(__('请选择地区！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/*所添加城市是否已存在*/
		if (!empty($city)) {
			$city_count = RC_DB::table('store_business_city')->where('business_city', $city)->count();
			if ($city_count > 0) {
				return $this->showmessage(__('当前添加的经营城市已存在！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$business_city_name = ecjia_region::getRegionName($city);
		
		if (empty($index_letter)) {
			$index_letter = $this->getFirstCharter($business_city_name);
		}
		
		$data = array(
				'business_city' 		=> $city,
				'business_city_name'	=> $business_city_name,
				'business_city_alias'	=> $business_city_alias,
				'index_letter'			=> $index_letter,
				'business_district'		=> ''
		);
		
		 RC_DB::table('store_business_city')->insert($data);
		 ecjia_admin::admin_log(sprintf(__('添加经营城市：%s', 'store'), $business_city_name), 'add', 'store_business_city');
		return $this->showmessage(__('添加经营城市成功！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_store_business_city/init')));
	}
	
	
	/**
	 * 编辑经营城市
	 */
	public function edit() {
		$this->admin_priv('store_business_city_manage');
	
		$city_id = trim($_GET['city_id']);
		$business_city = $this->get_business_city_info($city_id);
		$this->assign('business_city', $business_city);
		$data = $this->fetch('store_business_city_edit.dwt');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	
	/**
	 * 更新经营城市
	 */
	public function update() {
		$this->admin_priv('store_business_city_manage');
	
		$city_id 				= trim($_POST['city_id']);
		$business_city_alias 	= trim($_POST['business_city_alias']);
		$index_letter		    = strtoupper($_POST['index_letter']);
		RC_DB::table('store_business_city')->where('business_city', $city_id)->update(array('business_city_alias' => $business_city_alias, 'index_letter' => $index_letter));
		$business_city_name = ecjia_region::getRegionName($city_id);
		//记录log
		ecjia_admin::admin_log(__('编辑经营城市：', 'store') . $business_city_name, 'edit', 'store_business_city');
		return $this->showmessage(__('编辑经营城市成功！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_store_business_city/init')));
	}
	
	/**
	 * 删除经营城市
	 */
	public function remove() {
		$this->admin_priv('store_business_city_drop');
	
		$city_id = trim($_GET['city_id']);
		RC_DB::table('store_business_city')->where('business_city', $city_id)->delete();
		//记录log
		$business_city_name = ecjia_region::getRegionName($city_id);
		ecjia_admin::admin_log(sprintf(__('删除经营城市：%s', 'store'), $business_city_name), 'remove', 'store_business_city');
		return $this->showmessage(__('删除经营城市成功！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 添加经营地区
	 */
	public function add_business_district() {
		$this->admin_priv('store_business_city_manage');
	
		$city_id = trim($_GET['city_id']);
		
		$business_city_info = $this->get_business_city_info($city_id);
		/*经营地区处理*/
		$business_district = array();
		if (!empty($business_city_info['business_district'])) {
			$business_district = explode(',', $business_city_info['business_district']);
		}
		$this->assign('business_city_info', $business_city_info);
		$district = ecjia_region::getSubarea($city_id);
		if (!empty($district) && !empty($business_district)) {
			foreach ($district as $key => $row) {
				if (in_array($row['region_id'], $business_district)) {
					$district[$key]['cando'] = 1;
				} else {
					$district[$key]['cando'] = 0;
				}
				$district_ids[] = $row['region_id'];
			}
			if ($district_ids == $business_district) {
				$this->assign('select_all', true);
			}
		}
		$this->assign('district_list', $district);
		
		$data = $this->fetch('store_business_district_add.dwt');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	/**
	 *
	 * 添加经营地区的处理
	 */
	public function insert_district() {
		$this->admin_priv('store_business_city_manage', ecjia::MSGTYPE_JSON);
	
		$city_id 		= trim($_POST['city_id']);
		$district    	= empty($_POST['region_id']) ? array() : $_POST['region_id'];
		
		if ( empty($city_id) || empty($district)) {
			return $this->showmessage(__('请选择地区！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/*所添加地区是否已存在*/
		if (!empty($district)) {
			$business_district = implode(',', $district);
			RC_DB::table('store_business_city')->where('business_city', $city_id)->update(array('business_district' => $business_district));
			//记录log
			foreach ($district as $key => $val) {
				$district_names[] = ecjia_region::getRegionName($val);
			}
			$district_name_str = explode(',', $district_names);
			ecjia_admin::admin_log(sprintf(__('添加经营地区：%s', 'store'), $district_name_str), 'add', 'store_business_city');
		}
		return $this->showmessage(__('添加经营城市成功！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_store_business_city/init')));
	}
	
	/**
	 * 删除经营地区
	 */
	public function remove_business_district() {
		$this->admin_priv('store_business_city_drop');
	
		$city_id 		= trim($_GET['city_id']);
		$district_id 	= trim($_GET['district_id']);
		
		$business_city_info 	= $this->get_business_city_info($city_id);
		
		if (!empty($business_city_info['business_district']) && !empty($district_id)) {
			$business_district = explode(',', $business_city_info['business_district']);
			foreach ($business_district as $key => $val) {
				if ($val == $district_id) {
					unset($business_district[$key]);
				}
			}
			$business_district_last = implode(',', $business_district);
			RC_DB::table('store_business_city')->where('business_city', $city_id)->update(array('business_district' => $business_district_last));
			//记录log
			$district_name = ecjia_region::getRegionName($district_id);
			ecjia_admin::admin_log(sprintf(__('删除经营地区：%s', 'store'), $district_name), 'remove', 'store_business_city');
		}
		
		return $this->showmessage(__('删除经营地区成功！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取经营城市信息
	 */
	private function get_business_city_info($city_id) {
		$business_city_info = array();
		if (!empty($city_id)) {
			$business_city_info = RC_DB::table('store_business_city')->where('business_city', $city_id)->first();
		}
		return $business_city_info;
	}
	
	private function getFirstCharter($str){
		if(empty($str)){return '';}
		$fchar=ord($str{0});
		if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
		$s1=iconv('UTF-8','gb2312',$str);
		$s2=iconv('gb2312','UTF-8',$s1);
		$s=$s2==$str?$s1:$str;
		$asc=ord($s{0})*256+ord($s{1})-65536;
		if($asc>=-20319&&$asc<=-20284) return 'A';
		if($asc>=-20283&&$asc<=-19776) return 'B';
		if($asc>=-19775&&$asc<=-19219) return 'C';
		if($asc>=-19218&&$asc<=-18711) return 'D';
		if($asc>=-18710&&$asc<=-18527) return 'E';
		if($asc>=-18526&&$asc<=-18240) return 'F';
		if($asc>=-18239&&$asc<=-17923) return 'G';
		if($asc>=-17922&&$asc<=-17418) return 'H';
		if($asc>=-17417&&$asc<=-16475) return 'J';
		if($asc>=-16474&&$asc<=-16213) return 'K';
		if($asc>=-16212&&$asc<=-15641) return 'L';
		if($asc>=-15640&&$asc<=-15166) return 'M';
		if($asc>=-15165&&$asc<=-14923) return 'N';
		if($asc>=-14922&&$asc<=-14915) return 'O';
		if($asc>=-14914&&$asc<=-14631) return 'P';
		if($asc>=-14630&&$asc<=-14150) return 'Q';
		if($asc>=-14149&&$asc<=-14091) return 'R';
		if($asc>=-14090&&$asc<=-13319) return 'S';
		if($asc>=-13318&&$asc<=-12839) return 'T';
		if($asc>=-12838&&$asc<=-12557) return 'W';
		if($asc>=-12556&&$asc<=-11848) return 'X';
		if($asc>=-11847&&$asc<=-11056) return 'Y';
		if($asc>=-11055&&$asc<=-10247) return 'Z';
		return null;
	}
}

//end
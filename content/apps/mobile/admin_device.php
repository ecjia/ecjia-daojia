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
 * ECJIA 移动设备管理
*/
class admin_device extends ecjia_admin {
	private $db_device;
	
	public function __construct() {
		parent::__construct();

		/* 数据模型加载 */
		$this->db_device = RC_Model::model('mobile/mobile_device_model');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Script::enqueue_script('media-editor', RC_Uri::vendor_url('tinymce/tinymce.min.js'), array(), false, true);
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('device', RC_App::apps_url('statics/js/device.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		
		RC_Script::localize_script('device', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_device_manage'), RC_Uri::url('mobile/admin_device/init')));
	}
	
	/**
	 * 移动设备列表
	 */
	public function init() {
		$this->admin_priv('device_manage');
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_device_list'));
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_device_manage')));
		
		$device_list = $this->get_device_list();
		$this->assign('device_list', $device_list);
		$this->assign('search_action', RC_Uri::url('mobile/admin_device/init'));
				
		$this->display('device_list.dwt');
	}

	/**
	 * 移至回收站
	 */
	public function trash()  {
		$this->admin_priv('device_delete', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$deviceval = intval($_GET['deviceval']);
		$success = $this->db_device->device_update($id, array('in_status' => 1));
		
		$info = $this->db_device->device_find($id);
		
	    if ($info['device_client'] == 'android') {
            $info['device_client'] = 'Android';
        } elseif ($info['device_client'] == 'iphone') {
            $info['device_client'] = 'iPhone';
        } elseif ($info['device_client'] == 'ipad') {
            $info['device_client'] = 'iPad';
        }
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'trash', 'mobile_device');
		if ($success){
			return $this->showmessage(RC_Lang::get('mobile::mobile.trash_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
		} else {
			return $this->showmessage(RC_Lang::get('mobile::mobile.trash_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 从回收站还原
	 */
	public function returndevice()  {
		$this->admin_priv('device_update', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$success = $this->db_device->device_update($id, array('in_status' => 0));
		
		$info = $this->db_device->device_find($id);
	    if ($info['device_client'] == 'android') {
            $info['device_client'] = 'Android';
        } elseif ($info['device_client'] == 'iphone') {
            $info['device_client'] = 'iPhone';
        } elseif ($info['device_client'] == 'ipad') {
            $info['device_client'] = 'iPad';
        }
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'restore', 'mobile_device');
		if ($success){
			return $this->showmessage(RC_Lang::get('mobile::mobile.restore_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('mobile::mobile.restore_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除移动设备
	 */
	public function remove()  {
		$this->admin_priv('device_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$deviceval = intval($_GET['deviceval']);
		
		$info = $this->db_device->device_find($id);
	    if ($info['device_client'] == 'android') {
            $info['device_client'] = 'Android';
        } elseif ($info['device_client'] == 'iphone') {
            $info['device_client'] = 'iPhone';
        } elseif ($info['device_client'] == 'ipad') {
            $info['device_client'] = 'iPad';
        }
		
		$success = $this->db_device->device_delete($id);
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'remove', 'mobile_device');
		
		if ($success){
			return $this->showmessage(RC_Lang::get('mobile::mobile.del_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
		} else {
			return $this->showmessage(RC_Lang::get('mobile::mobile.del_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 批量删除设备
	 */
	public function batch(){
		$action    = trim ($_GET['sel_action']);
		$deviceval = intval($_GET['deviceval']);
		
		if ($action == 'del') {
			$this->admin_priv('device_delete', ecjia::MSGTYPE_JSON);
		} else {
			$this->admin_priv('device_update', ecjia::MSGTYPE_JSON);
		}
		$ids  = $_POST['id'];
		$ids  = explode(',', $ids);
		$info = $this->db_device->device_select($ids, true);
		
		foreach ($info as $k => $rows) {
		    if ($rows['device_client'] == 'android') {
                $info[$k]['device_client'] = 'Android';
            } elseif ($rows['device_client'] == 'iphone') {
                $info[$k]['device_client'] = 'iPhone';
            } elseif ($rows['device_client'] == 'ipad'){
                $info[$k]['device_client'] = 'iPad';
            }
		}
		
		switch ($action) {
			case 'trash':
				$data = array(
					'in_status' => 1
				);
				$this->db_device->device_update($ids, $data, true);
				
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_trash', 'mobile_device');
				}
				break;
				
			case 'returndevice':
				$data = array(
					'in_status' => 0
				);
				$this->db_device->device_update($ids, $data, true);
				
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_restore', 'mobile_device');
				}
				break;
					
			case 'del':
				$this->db_device->device_delete($ids, true);
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_remove', 'mobile_device');
				}
				break;
				
			default :
				break;
		}
		return $this->showmessage(RC_Lang::get('mobile::mobile.batch_handle_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
	}
	
	/**
	 * 预览
	 */
	public function preview() {
		$this->admin_priv('device_detail');
	
		$id = intval($_GET['id']);
	
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.view_device_info'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_device_list'), 'href' => RC_Uri::url('mobile/admin_device/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.view_device_info')));

		$device                = $this->db_device->device_find($id);
		$device['add_time']    = RC_Time::local_date(ecjia::config('time_format'), $device['add_time']);
		$device['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $device['update_time']);
		
	    if ($device['device_client'] == 'android') {
            $device['device_client'] = 'Android';
        } elseif ($device['device_client'] == 'iphone') {
            $device['device_client'] = 'iPhone';
        } elseif ($device['device_client'] == 'ipad') {
            $device['device_client'] = 'iPad';
        }
		$this->assign('device', $device);

		$this->display('preview.dwt');
	}
	
	/**
	 * 编辑设备别名
	 */
	public function edit_device_alias() {
		$this->admin_priv('device_update', ecjia::MSGTYPE_JSON);
	
		$id           = intval($_POST['pk']);
		$device_alias = !empty($_POST['value']) ? trim($_POST['value']) : '';
		
		if (empty($device_alias)) {
			return $this->showmessage(RC_Lang::get('mobile::mobile.device_alias_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$query = $this->db_device->device_update($id, array('device_alias' => $device_alias));
		if ($query) {
			$info = $this->db_device->device_find($id);
		    if ($info['device_client'] == 'android') {
	            $info['device_client'] = 'Android';
	        } elseif ($info['device_client'] == 'iphone') {
	            $info['device_client'] = 'iPhone';
	        } elseif ($info['device_client'] == 'ipad') {
	            $info['device_client'] = 'iPad';
	        }
			ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_udid']).'，'.sprintf(RC_Lang::get('mobile::mobile.edit_device_alias_as'), $device_alias), 'setup', 'mobile_device');
			return $this->showmessage(RC_Lang::get('mobile::mobile.edit_device_alias_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('mobile::mobile.edit_device_alias_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 取得设备列表
	 *
	 * @return  array
	 */
	private function get_device_list() {
		$device_db = RC_DB::table('mobile_device');
		
		$where = $filter = array();
		$filter['keywords'] 	= empty($_GET['keywords']) 	? '' 	: trim($_GET['keywords']);
		$filter['deviceval']	= empty($_GET['deviceval']) ? 0 	: intval($_GET['deviceval']);
	
		if ($filter['keywords']) {
			$device_db->where('device_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
		}
		
		$msg_count = $device_db
			->selectRaw("SUM(IF(in_status=0,1,0)) AS count,
				SUM(IF(device_client='android' and device_code !='8001' and in_status = 0,1,0)) AS android,
				SUM(IF(device_client='iphone' and in_status = 0,1,0)) AS iphone,
				SUM(IF(device_client='ipad' and in_status = 0,1,0)) AS ipad,
				SUM(IF(device_client='android' and device_code='8001' and in_status = 0,1,0)) AS cashier,
				SUM(IF(in_status = 1,1,0)) AS trashed")
			->first();
		
		$msg_count = array(
			'count'		=> empty($msg_count['count']) 	? 0 : $msg_count['count'],
			'android'	=> empty($msg_count['android']) ? 0 : $msg_count['android'],
			'iphone'	=> empty($msg_count['iphone']) 	? 0 : $msg_count['iphone'],
			'ipad'	    => empty($msg_count['ipad']) 	? 0 : $msg_count['ipad'],
			'cashier'	=> empty($msg_count['cashier']) ? 0 : $msg_count['cashier'],
			'trashed'	=> empty($msg_count['trashed']) ? 0 : $msg_count['trashed']
		);
	
		$android = 'android';
		if ($filter['deviceval'] == 1) {
			$device_db->where('device_client', $android)->where('device_code', '!=', 8001)->where('in_status', 0);
		}
	
		$iphone = 'iphone';
		if ($filter['deviceval'] == 2) {
			$device_db->where('device_client', $iphone)->where('in_status', 0);
		}
	
		$ipad = 'ipad';
		if ($filter['deviceval'] == 3) {
			$device_db->where('device_client', $ipad)->where('in_status', 0);
		}
	
		$cashier = 'android';
		if ($filter['deviceval'] == 4) {
			$device_db->where('device_client', $cashier)->where('device_code', 8001)->where('in_status', 0);
		}
		
		if ($filter['deviceval'] == 0) {
			$device_db->where('in_status', 0);
		}
		
		if ($filter['deviceval'] == 5) {
			$device_db->where('in_status', 1);
		}

		$count = $device_db->count('id');
		$page = new ecjia_page($count, 10, 5);
	
		$data = $device_db->select('*')->orderby('id', 'desc')->take(10)->skip($page->start_id-1)->get();
		
		$arr = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
				if ($rows['device_client'] == 'android') {
					$rows['device_client'] = 'Android';
				} elseif ($rows['device_client'] == 'iphone') {
					$rows['device_client'] = 'iPhone';
				} elseif ($rows['device_client'] == 'ipad'){
					$rows['device_client'] = 'iPad';
				}
				$arr[] = $rows;
			}
		}
		return array('device_list' => $arr, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
	}
}

// end
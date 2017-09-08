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
 * ECJia 计划任务
 * @author wutifang
 */
class admin_plugin extends ecjia_admin {
	private $db_crons;
	
	private $cron_method;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_crons = RC_Loader::load_app_model('crons_model', 'cron');
		
		$this->cron_method = RC_Package::package('app::cron')->loadClass('cron_method');
		RC_Package::package('app::cron')->loadClass('cron_helper');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/*加载全局JS及CSS*/
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('cron', RC_App::apps_url('statics/css/cron.css', __FILE__));
		RC_Script::enqueue_script('cron', RC_App::apps_url('statics/js/cron.js', __FILE__));
		
		RC_Script::localize_script('cron', 'js_lang', RC_Lang::get('cron::cron.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('cron::cron.cron'), RC_Uri::url('cron/admin_plugin/init')));
		ecjia_screen::get_current_screen()->set_parentage('cron', 'cron/admin_plugin.php');
	}
	
	//列表页
	public function init () {
		$this->admin_priv('cron_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('cron::cron.cron')));
		$this->assign('ur_here', RC_Lang::get('cron::cron.cron'));

		$db_cron = RC_DB::table('crons');
		$count['type'] = isset($_GET['type']) ? $_GET['type'] : '';
		if (!empty($count['type'])) {
			$db_cron->where('enable', 0);
		}else{
			$db_cron->where('enable', 1);
		}
		$data = $db_cron->get();
		$filter_count = RC_DB::table('crons')->select(RC_DB::raw('SUM(IF(enable = 1, 1, 0)) as enabled'), RC_DB::raw('SUM(IF(enable =0 , 1, 0)) as disabled'))->first();
		$count['enabled'] 	= $filter_count['enabled'] > 0 ? $filter_count['enabled'] : 0;
		$count['disabled']  = $filter_count['disabled'] > 0 ? $filter_count['disabled'] : 0;
		
		$this->assign('count', $count);
		$data or $data = array();
		$modules = array();
		if (isset($data)) {
			foreach ($data as $_key => $_value) {
				$modules[$_key]['code'] 		= $_value['cron_code'];
				$modules[$_key]['name'] 		= $_value['cron_name'];
				$modules[$_key]['desc'] 		= $_value['cron_desc'];
				$modules[$_key]['cron_order'] 	= $_value['cron_order'];
				$modules[$_key]['nextime'] 		= RC_Time::local_date('Y-m-d H:i:s', $_value['nextime']);
				$modules[$_key]['thistime'] 	= $_value['thistime'] ? RC_Time::local_date('Y-m-d H:i:s', $_value['thistime']) : '-';
				$modules[$_key]['enabled'] 		= $_value['enable'];
				$modules[$_key]['install'] 		= '1';
			}
		} else {
			$modules[$_key]['install'] = '0';
		}
		$this->assign('modules', $modules);
		
		$this->display('cron_list.dwt');
	}
	
	
	/**
	 * 禁用计划任务
	 */
	public function disable() {
		$this->admin_priv('cron_update', ecjia::MSGTYPE_JSON);
		
		$code = trim($_GET['code']);
		$data = array(
			'enable' => 0
		);
		$cron_disable = $this->db_crons->crons_update(array('cron_code' => $code), $data);
		$cron_name = $this->db_crons->crons_field(array('cron_code' => $code), 'cron_name');
		
		ecjia_admin::admin_log($cron_name, 'disable', 'cron');
		
		return $this->showmessage(RC_Lang::get('cron::cron.cron_disabled'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/init')));
	}
	
	/**
	 * 启用计划任务
	 */
	public function enable() {
		$this->admin_priv('cron_update', ecjia::MSGTYPE_JSON);
		
		$code = trim($_GET['code']);
		$data = array(
			'enable' => 1
		);
		$cron_enable = $this->db_crons->crons_update(array('cron_code' => $code), $data);
		$cron_name = $this->db_crons->crons_field(array('cron_code' => $code), 'cron_name');
		
		ecjia_admin::admin_log($cron_name, 'enable', 'cron');
		
		return $this->showmessage(RC_Lang::get('cron::cron.cron_enable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/init')));
	}
	
	public function edit() {
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('cron::cron.edit_cron')));
		$this->assign('ur_here', RC_Lang::get('cron::cron.edit_cron'));
		$this->assign('action_link', array('text' => RC_Lang::get('cron::cron.cron'), 'href' => RC_Uri::url('cron/admin_plugin/init')));
		
		$this->admin_priv('cron_update');
		if (empty($_POST['step'])) {
			$code = trim($_GET['code']);
			$cron = $this->db_crons->crons_find(array('cron_code' => $code));
			
			if (empty($cron)) {
				$links[] = array('text' => RC_Lang::get('cron::cron.back_list'), 'href' => RC_Uri::url('cron/admin_plugin/init'));
			}
			/* 取相应插件信息 */
			//todo
			RC_Lang::load($code);
			$modules[0] = RC_Loader::load_app_config($code);
			$data = $modules[0];
			
			/* 取得配置信息 */
			$cron_config = unserialize($cron['cron_config']);
			
			$code_list = array();
			if (!empty($cron_config)) {
				foreach ($cron_config AS $key => $value) {
					$code_list[$value['name']] = $value['value'];
				}
			}
			
			$cron_handle = $this->cron_method->pluginInstance($code);
			$cron_config_file = $cron_handle->loadConfig();
			$cron['cron_config'] = $cron_handle->makeFormData($code_list);
			$cron['cron_act']   = 'edit';
			$cron['cronweek']   = $cron['week'] == '0' ? 7 : $cron['week'];
			$cron['cronday']    = $cron['day'];
			$cron['cronhour']   = $cron['hour'];
			$cron['cronminute'] = $cron['minute'];
			$cron['run_once'] && $cron['autoclose'] = 'checked';
			list($day, $week, $hours) = cron_helper::get_dwh();

			$this->assign('cron', $cron);
			$this->assign('days', $day);
			$this->assign('week', $week);
			$this->assign('hours', $hours);
			$this->assign('minute', RC_Lang::get('cron::cron.minute'));
			$this->assign('app_lists', $this->app_list($cron['alow_files']));
			$this->assign('cron_config_file', $cron_config_file);
			$this->display('cron_edit.dwt');
		} elseif ($_POST['step'] == 2) {
			
			$code = trim($_GET['code']);
				
			$links[] = array('text' => RC_Lang::get('cron::cron.back_list'), 'href' => RC_Uri::url('cron/admin_plugin/init'));
			
			$cron_config = array();
			if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
				$temp = count($_POST['cfg_value']);
				for ($i = 0; $i < $temp; $i++) {
					$cron_config[] = array(
							'name'  => trim($_POST['cfg_name'][$i]),
							'type'  => trim($_POST['cfg_type'][$i]),
							'value' => trim($_POST['cfg_value'][$i])
					);
				}
			}
			$cron_config = serialize($cron_config);
			$cron_minute = cron_helper::get_minute($_POST['cron_minute']);
				
			if ($_POST['ttype'] == 'day') {
				$cron_day = $_POST['cron_day'];
				$cron_week = '';
			} elseif ($_POST['ttype'] == 'week') {
				$cron_day = 0;
				$cron_week = $_POST['cron_week'];
			
				if ($cron_week == 7) {
					$cron_week = 0;
				}
			
			} else {
				$cron_day = 0;
				$cron_week = '';
			}
			
			$cron_name = !empty($_POST['cron_name']) ? $_POST['cron_name'] : '';
			$cron_desc = !empty($_POST['cron_desc']) ? $_POST['cron_desc'] : '';
			$cron_run_once = !empty($_POST['cron_run_once']) ? $_POST['cron_run_once'] : 0;
			$allow_ip = !empty($_POST['allow_ip']) ? $_POST['allow_ip'] : '';
			$alow_files = isset($_POST['alow_files']) ? implode(',', $_POST['alow_files']) : "";
				
			$cron_hour = $_POST['cron_hour'];
			$cron = array('day' =>  $cron_day, 'week' => $cron_week, 'hour' => $cron_hour, 'm' => $cron_minute);
			
			RC_Package::package('app::cron')->loadClass('cron_nexttime', false);
			$next = cron_nexttime::make($cron)->getNextTime();
			
			$data = array(
				'cron_name'		=> $cron_name,
				'cron_desc'		=> $cron_desc,
				'cron_config'	=> $cron_config,
				'nextime' 		=> $next,
				'day' 			=> $cron_day,
				'week' 			=> $cron_week,
				'hour' 			=> $cron_hour,
				'minute' 		=> $cron_minute,
				'run_once' 		=> $cron_run_once,
				'allow_ip' 		=> $allow_ip,
				'alow_files' 	=> $alow_files
			);
			$cron_update = $this->db_crons->crons_update(array('cron_id' => $_POST['cron_id']), $data);
			
			ecjia_admin::admin_log($cron_name, 'edit', 'cron');
			if ($cron_update) {
				$this->showmessage(RC_Lang::get('cron::cron.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/edit', array('code' => $code))));
			} else {
				$this->showmessage(RC_Lang::get('cron::cron.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
		}
	}
	
	/**
	 * 执行计划任务测试
	 */
	public function run() {
		$this->admin_priv('cron_run', ecjia::MSGTYPE_JSON);
		
		ini_set('memory_limit', -1);
		set_time_limit(0);
		
		$cron = $this->db_crons->crons_find(array('cron_code' => $_GET['code']));
		if (empty($cron)) {
		    return $this->showmessage('Cron script not found.', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$handler = $this->cron_method->pluginInstance($cron['cron_code'], unserialize($cron['cron_config']));
		if (!$handler) {
		    return $this->showmessage($cron['cron_code'] . ' plugin not found!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$error = $handler->run();
		if (is_ecjia_error($error)) {
		    return $this->showmessage($error->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

 		$cron_name = $cron['cron_name'];
		$timestamp = RC_Time::gmtime();
		
		$data = array(
			'cron_code' => $_GET['code'],
			'thistime'  => $timestamp
		);
		
		$this->db_crons->crons_update(array('cron_code' => $_GET['code']), $data);
		ecjia_admin::admin_log($cron_name, 'run', 'cron');
		
		return $this->showmessage(RC_Lang::get('cron::cron.do_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/init')));
	}
	
	protected function app_list($alow_files) {
	    $apps = ecjia_app::installed_apps();
	    $alow_files = explode(',', $alow_files);
	    
	    $app_list = array();
	    foreach ($apps as $app) {
	        $app_list[] = array(
	        	'code' => $app['directory'],
	            'name' => $app['format_name'],
	            'checked' => in_array($app['directory'], $alow_files) ? 1 : 0,
	        );
	    }
	    return $app_list;
	}
}

//end
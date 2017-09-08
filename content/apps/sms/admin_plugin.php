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
 * 短信渠道
 * by wutifang
 */
class admin_plugin extends ecjia_admin {
	private $sms_method;
	
	public function __construct() {
		parent::__construct();

		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('sms_channel', RC_App::apps_url('statics/js/sms_channel.js', __FILE__));
		RC_Script::localize_script('sms_channel', 'js_lang', RC_Lang::get('sms::sms.js_lang'));
		
		$this->sms_method = RC_Package::package('app::sms')->loadClass('sms_method');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_channel'), RC_Uri::url('sms/admin_plugin/init')));
		ecjia_screen::get_current_screen()->set_parentage('sms', 'sms/admin_plugin.php');
	}
	
	/**
	 * 渠道列表
	 */
	public function init() {
	    $this->admin_priv('sms_channel_manage');
	    
	    $this->assign('ur_here', RC_Lang::get('sms::sms.sms_channel'));
	    ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_channel')));

		$list_data = $this->get_channel_list();
		$this->assign('list', $list_data);
		
		$this->display('sms_channel.dwt');
	}
	


	/**
	 * 查询账户余额
	 */
	public function check_balance() {
		$this->admin_priv('sms_channel_manage', ecjia::MSGTYPE_JSON);

		$channel = trim($_GET['code']);
		
		$handle = with(new Ecjia\App\Sms\SmsPlugin)->channel($channel);
		if ($handle->checkBalance()) {
			$result = \Ecjia\App\Sms\SmsManager::make()->balance($channel);
			if (is_ecjia_error($result)) {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$balance_label = sprintf(RC_Lang::get('sms::sms.surplus'), "<strong>{$result->getBalance()}</strong>");
				return $this->showmessage('查询成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $balance_label));
			}
		} else {
			return $this->showmessage('抱歉，该插件暂且还不支持余额查询', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	
	/**
	 * 编辑渠道
	 */
	public function edit() {
		$this->admin_priv('sms_channel_update');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.edit_sms_channel')));
		
		$this->assign('action_link', array('text' => RC_Lang::get('sms::sms.sms_channel'), 'href' => RC_Uri::url('sms/admin_plugin/init')));
		$this->assign('ur_here', RC_Lang::get('sms::sms.edit_sms_channel'));
		$this->assign('form_action', RC_Uri::url('sms/admin_plugin/update'));
		
		$channel_code = !empty($_GET['code']) ? trim($_GET['code']) : '';
		$channel_info = RC_DB::table('notification_channels')->where('channel_code', $channel_code)->first();

		/* 取得配置信息 */
		if (is_string($channel_info['channel_config'])) {
			$channel_config = unserialize($channel_info['channel_config']);
			
			/* 取出已经设置属性的code */
			$code_list = array();
			if (!empty($channel_config)) {
				foreach ($channel_config AS $key => $value) {
					$code_list[$value['name']] = $value['value'];
				}
			}
			$sms_handle = $this->sms_method->pluginInstance($channel_code);
			
			$sms_config_file = $sms_handle->loadConfig();
			$channel_info['channel_config'] = $sms_handle->makeFormData($code_list);
		}
		$this->assign('channel', $channel_info);
		
		$this->display('sms_channel_edit.dwt');
	}
	
	/**
	 * 提交编辑渠道
	 */
	public function update() {
		$this->admin_priv('sms_channel_update', ecjia::MSGTYPE_JSON);
		
		$name = !empty($_POST['channel_name']) ? trim($_POST['channel_name']) : '';
		$code = trim($_POST['channel_code']);
		$type = trim($_POST['channel_type']);
		$id   = !empty($_POST['channel_id']) ? intval($_POST['channel_id']) : 0;
		
		/* 检查输入 */
		if (empty($name)) {
			return $this->showmessage(RC_Lang::get('sms::sms.channel_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$count = RC_DB::table('notification_channels')->where('channel_name', $name)->where('channel_code', '!=', $code)->where('channel_type', $type)->count();
		if ($count > 0) {
			return $this->showmessage(RC_Lang::get('sms::sms.name_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 取得配置信息 */
		$config = array();
		if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
			for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
				$config[] = array(
					'name'  => trim($_POST['cfg_name'][$i]),
					'type'  => trim($_POST['cfg_type'][$i]),
					'value' => trim($_POST['cfg_value'][$i])
				);
			}
		}
		
		$config = serialize($config);
		if (!empty($id)) {
			/* 编辑 */
			$array = array(
				'channel_name'   => $name,
				'channel_desc'   => trim($_POST['channel_desc']),
				'channel_config' => $config,
			);
			RC_DB::table('notification_channels')->where('channel_code', $code)->update($array);
		
			/* 记录日志 */
			ecjia_admin::admin_log($name, 'edit', 'sms_channel');
			return $this->showmessage(RC_Lang::get('sms::sms.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			$count = RC_DB::table('notification_channels')->where('channel_code', $code)->where('channel_type', $type)->count();
			if ($count > 0) {
				/* 该渠道已经安装过, 将该渠道的状态设置为 enable */
				$data = array(
					'channel_name'   	=> $name,
					'channel_desc'   	=> trim($_POST['channel_desc']),
					'channel_config' 	=> $config,
					'enabled'    		=> '1'
				);
				RC_DB::table('notification_channels')->where('channel_code', $code)->update($data);
			} else {
				/* 该渠道没有安装过, 将该渠道的信息添加到数据库 */
				$data = array(
					'channel_code'     	=> $code,
					'channel_name'     	=> $name,
					'channel_desc'     	=> trim($_POST['channel_desc']),
					'channel_config'	=> $config,
					'enabled'      		=> '1',
				);
				RC_DB::table('notification_channels')->insertGetId($data);
			}
				
			/* 记录日志 */
			ecjia_admin::admin_log($name, 'edit', 'sms_channel');
			$refresh_url = RC_Uri::url('sms/admin_plugin/edit', array('code' => $code, 'type' => $type));
				
			return $this->showmessage(RC_Lang::get('sms::sms.install_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
		}
	}
	
	/**
	 * 启用/禁用渠道
	 */
	public function switch_state() {
		$this->admin_priv('sms_channel_update', ecjia::MSGTYPE_JSON);
	
		$code = trim($_GET['code']);
		$enabled = !empty($_GET['enabled']) ? intval($_GET['enabled']) : 0;
		$data = array(
			'enabled' => $enabled
		);
	
		RC_DB::table('notification_channels')->where('channel_code', $code)->update($data);
		$channel_info = RC_DB::table('notification_channels')->where('channel_code', $code)->first();
		
		if ($enabled == 1) {
			$action = 'use';
			$message = RC_Lang::get('sms::sms.enabled');
		} elseif ($enabled == 0) {
			$action = 'stop';
			$message = RC_Lang::get('sms::sms.disabled');
		}
		ecjia_admin::admin_log($channel_info['channel_name'], $action, 'sms_channel');
	
		$refresh_url = RC_Uri::url('sms/admin_plugin/init');
		return $this->showmessage(RC_Lang::get('sms::sms.plugin')."<strong> ".$message." </strong>", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
	}
	
	/**
	 * 编辑名称
	 */
	public function edit_name() {
		$this->admin_priv('sms_channel_update', ecjia::MSGTYPE_JSON);
		
		$channel_id  = intval($_POST['pk']);
		$channel_name = trim($_POST['value']);
		$type = !empty($_GET['type']) ? trim($_GET['type']) : 'sms';
		
		/* 检查名称是否为空 */
		if (empty($channel_name) || $channel_id == 0 ) {
			return $this->showmessage(RC_Lang::get('sms::sms.name_is_null'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			/* 检查名称是否重复 */
			if (RC_DB::table('notification_channels')->where('channel_name', $channel_name)->where('channel_id', '!=', $channel_id)->where('channel_type', $type)->count() > 0) {
				return $this->showmessage(RC_Lang::get('sms::sms.name_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				RC_DB::table('notification_channels')->where('channel_id', $channel_id)->update(array('channel_name' => stripcslashes($channel_name)));
		
				ecjia_admin::admin_log(stripcslashes($channel_name), 'edit', 'sms_channel');
				return $this->showmessage(RC_Lang::get('sms::sms.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}
	}
	
	/**
	 * 修改排序
	 */
	public function edit_order() {
		$this->admin_priv('sms_channel_update', ecjia::MSGTYPE_JSON);
	
		if (!is_numeric($_POST['value'])) {
			return $this->showmessage(RC_Lang::get('sms::sms.number_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			/* 取得参数 */
			$channel_id    	= intval($_POST['pk']);
			$channel_sort	= intval($_POST['value']);
			
			RC_DB::table('notification_channels')->where('channel_id', $channel_id)->update(array('sort_order' => $channel_sort));
				
			$channel_info = RC_DB::table('notification_channels')->where('channel_id', $channel_id)->first();
			
			ecjia_admin::admin_log(stripcslashes($channel_info['channel_name']).'，排序值为'.$channel_sort, 'edit', 'sms_channel_sort');
			return $this->showmessage(RC_Lang::get('sms::sms.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin_plugin/init')));
		}
	}
	
	/**
	 * 获取渠道列表
	 */
	private function get_channel_list() {
		$type = !empty($_GET['type']) ? trim($_GET['type']) : 'sms';
		
		$db_channel = RC_DB::table('notification_channels');
		if (!empty($type)) {
			$db_channel->where('channel_type', $type);
		}
		
		$count = $db_channel->count();
		$page = new ecjia_page($count, 10, 5);
		
		$data = $db_channel->take(10)->skip($page->start_id-1)->orderBy('sort_order', 'asc')->get();
		return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}

}
	
//end
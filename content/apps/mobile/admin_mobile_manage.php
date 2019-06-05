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
 * ECJIA移动应用配置模块
 */
class admin_mobile_manage extends ecjia_admin {
	//private $db_mobile_manage;
	
	public function __construct() {
		parent::__construct();
		
		//$this->db_mobile_manage = RC_Model::model('mobile/mobile_manage_model');
		
		Ecjia\App\Mobile\Helper::assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');
		
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('clipboard.min', RC_App::apps_url('statics/js/clipboard.min.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('mobile_manage', RC_App::apps_url('statics/js/mobile_manage.js', __FILE__), array(), false, 1);
		RC_Script::localize_script('mobile_manage', 'js_lang', config('app-mobile::jslang.mobile_page'));
		
		RC_Style::enqueue_style('mobile_manage', RC_App::apps_url('statics/css/mobile_manage.css', __FILE__), array(), false, false);
		
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('移动产品', 'mobile'), RC_Uri::url('mobile/admin_mobile_manage/init')));
	}
					
	/**
	 * 移动应用配置页面
	 */
	public function init() {
		$this->admin_priv('mobile_manage');

		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('移动产品', 'mobile')));
		$this->assign('ur_here', __('移动产品', 'mobile'));
		
		//获取已激活
		$data = RC_DB::table('mobile_manage')->select('platform')->get();
		$activation_list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$activation_list[] = $row['platform'];
			}
			$activation_list = array_unique($activation_list);
		}
		$this->assign('activation_list', $activation_list);
		
        $group_list = array();
        $factory = new Ecjia\App\Mobile\ApplicationFactory();
        $pruduct_data = $factory->getPlatformsWithGroup();
        
        foreach ($pruduct_data as $group => $lists) {
            $group_list[] = array(
                'group' => $group,
                'label' => \Ecjia\App\Mobile\ApplicationPlatformGroup::getGroupLabel($group),
                'sort' => \Ecjia\App\Mobile\ApplicationPlatformGroup::getGroupSort($group),
                'data' => $lists,
            );
        }
        $group_list = array_sort($group_list, 'sort');
		$this->assign('pruduct_data', $group_list);

		return $this->display('mobile_manage_list.dwt');
	}
	
	/**
	 * 移动应用配置页面
	 */
	public function client_list() {
		$this->admin_priv('mobile_manage');
	
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端管理', 'mobile')));
	
		$this->assign('ur_here', __('客户端管理', 'mobile'));
		$this->assign('action_link', array('text' => __('移动产品', 'mobile'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/init')));
	
		//信息配置项
		$code = trim($_GET[code]);
		$factory = new Ecjia\App\Mobile\ApplicationFactory();
		$pruduct_info = $factory->platform($code);
		
		$config['code'] = $pruduct_info->getCode();
		$config['description'] = $pruduct_info->getDescription();
		$config['name'] = $pruduct_info->getName();
		$this->assign('config', $config);

		$data = $pruduct_info->getClients();
		$database = RC_DB::table('mobile_manage')
		->where('platform', $code)
		->select('app_id', 'device_client', 'status', 'app_name')
		->get();
		
		foreach ($database as $key => $val) {
			$database[$val['device_client']] = $val;
			unset($database[$key]);
		}
		foreach ($data as $k => $v) {
			if (array_key_exists($v['device_client'], $database)) {
				$data[$k]['app_id'] = $database[$v['device_client']]['app_id'];
				$data[$k]['status'] = $database[$v['device_client']]['status'];
				$data[$k]['app_name'] = $database[$v['device_client']]['app_name'];
			}
		}
		$this->assign('data', $data);
		
		$ok_img = RC_App::apps_url('statics/images/ok.png', __FILE__);
		$error_img = RC_App::apps_url('statics/images/error.png', __FILE__);
		$Android_img = RC_App::apps_url('statics/images/android.png', __FILE__);
		$iPhone_img = RC_App::apps_url('statics/images/iphone.png', __FILE__);
		$wechant_client = RC_App::apps_url('statics/images/wechant_client.png', __FILE__);
		$h5 = RC_App::apps_url('statics/images/h5_client.png', __FILE__);
		$local = RC_App::apps_url('statics/images/cityo2olocal.png', __FILE__);
		$this->assign('ok_img', $ok_img);
		$this->assign('error_img', $error_img);
		$this->assign('Android_img', $Android_img);
		$this->assign('iPhone_img', $iPhone_img);
		$this->assign('wechant_client', $wechant_client);
		$this->assign('h5', $h5);
		$this->assign('local', $local);
	
		return $this->display('mobile_client_list.dwt');
	}
	
	//激活
	public function open() {
		$this->admin_priv('mobile_manage');
		
		$code = $_GET['code'];
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端管理', 'mobile'), RC_Uri::url('mobile/admin_mobile_manage/client_list',array('code' => $code))));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('激活客户端', 'mobile')
        ));

		$this->assign('ur_here', __('激活客户端', 'mobile'));
		$this->assign('action_link', array('text' => __('客户端管理', 'mobile'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/client_list',array('code' => $code))));
		
		$code = trim($_GET['code']);
		$device_code   = trim($_GET['device_code']);
		$device_client = trim($_GET['device_client']);
		$this->assign('code', $code);
		$this->assign('device_code', $device_code);
		$this->assign('device_client', $device_client);
		
		//获取默认应用名称（产品名称-客户端名称）
		$factory = new Ecjia\App\Mobile\ApplicationFactory();
		$pruduct_info = $factory->platform($code);
		$name = $pruduct_info->getName();
		$Clients = $pruduct_info->getClients();
		foreach($Clients as $key => $val){
			if(in_array($device_code, $val)){
				 $data = $val;
			}
		}
		$this->assign('name', $name.'-'.$data['device_name']);
		
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_manage/open_insert'));
		
		return $this->display('mobile_manage_activation.dwt');
	}
	
	public function open_insert() {
		$this->admin_priv('mobile_manage');
		
		$name = trim($_POST['name']);
		$bundleid = $_POST['bundleid'];
		$code = trim($_POST['code']);
		$device_code   = trim($_POST['device_code']);
		$device_client = trim($_POST['device_client']);
		
		$key = Ecjia\App\Mobile\ClientManage::generateAppKey();
		$secret = Ecjia\App\Mobile\ClientManage::generateAppSecret();

		$data = array(
			'app_name'		=> $name,	
			'bundle_id'		=> $bundleid,
			'app_key' 		=> $key,
			'app_secret'	=> $secret,
			'device_code'	=> $device_code,
			'device_client'	=> $device_client,
			'platform'    	=> $code,
			'status'	  	=> 1,
			'add_time'    	=> RC_Time::gmtime(),
		);
		$id = RC_DB::table('mobile_manage')->insertGetId($data);
		return $this->showmessage(__('激活客户端成功', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/edit', array('app_id'=> $id, 'code' => $code))));
	
	}
	
	/**
	 * 获取客户端管理列表
	 * @return array
	 */
	private function get_mobile_manage_list($code) {
		$db_mobile_manage = RC_DB::table('mobile_manage');
	
		$count = $db_mobile_manage->count();
		$page  = new ecjia_page ($count, 10, 5);
		$mobile_manage_list = $db_mobile_manage
		->where('platform', $code)
		->orderBy('app_id', 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		
		$mobile_client = array('iphone' => 'iPhone', 'android' => 'Android');
		if (!empty($mobile_manage_list)) {
			foreach ($mobile_manage_list as $key => $val) {
				$mobile_manage_list[$key]['device_client'] 	= $mobile_client[$val['device_client']];
				$mobile_manage_list[$key]['add_time'] 		= RC_Time::local_date(ecjia::config('date_format'), $val['add_time']);
			}
		}
		return array('item' => $mobile_manage_list, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}

	/**
	 * 编辑显示页面
	 */
	public function edit() {
		$this->admin_priv('mobile_manage');
		
		$code = $_GET['code'];
        $app_id   = intval($_GET['app_id']);
        $app_id = RC_Hook::apply_filters('mobile_config_appid_filter', $app_id, $code, 'config_client');
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('客户端管理', 'mobile'), RC_Uri::url('mobile/admin_mobile_manage/client_list',array('code' => $code))));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('查看客户端', 'mobile')));
		$this->assign('ur_here', __('基本信息', 'mobile'));
		$this->assign('action_link', array('text' => __('客户端管理', 'mobile'), 'href' => RC_Uri::url('mobile/admin_mobile_manage/client_list',array('code' => $code))));
		
		$manage_data = RC_DB::table('mobile_manage')->where('app_id', $app_id)->first();
		$device_info = (new \Ecjia\App\Mobile\ApplicationFactory())->client($manage_data['device_code']);
		$manage_data['device_name'] = $device_info->getDeviceName();
		$this->assign('manage_data', $manage_data);
		
		$this->assign('action', 'edit');
		
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_manage/update'));
		
		return $this->display('mobile_manage_info.dwt');
	}
	
	/**
	 * 开启客户端
	 */
	public function open_status() {
		$this->admin_priv('mobile_manage');
		
		$code = trim($_GET['code']);
		$id   = intval($_GET['id']);
		
		RC_DB::table('mobile_manage')->where('app_id', $id)->update(array('status'=> '1'));
		
		return $this->showmessage(__('开启客户端成功', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/edit', array('app_id'=>$id, 'code'=>$code))));
	}
	
	/**
	 * 关闭客户端
	 */
	public function close_status() {
		$this->admin_priv('mobile_manage');
		
		$code = trim($_GET['code']);
		$id   = intval($_GET['id']);
		
		RC_DB::table('mobile_manage')->where('app_id', $id)->update(array('status'=> '0'));
		
		return $this->showmessage(__('关闭客户端成功', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/edit', array('app_id'=>$id, 'code'=>$code))));
	}
	
	
	/**
	 * 编辑应用名称
	 */
	public function edit_app_name() {
		$this->admin_priv('mobile_manage');
		
		$id		  = intval($_POST['pk']);
		$app_name = trim($_POST['value']);
		$code     = trim($_GET['code']);

		RC_DB::table('mobile_manage')->where('app_id', $id)->update(array('app_name' => $app_name));
	
		return $this->showmessage(__('更新应用名称成功', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/edit', array('app_id'=>$id, 'code'=>$code))));
	}
	
	/**
	 * 编辑应用包名
	 */
	public function edit_bag_name() {
		$this->admin_priv('mobile_manage');
	
		$id		  = intval($_POST['pk']);
		$bag_name = trim($_POST['value']);
		$code     = trim($_GET['code']);
		
		RC_DB::table('mobile_manage')->where('app_id', $id)->update(array('bundle_id' => $bag_name));
	
		return $this->showmessage(__('更新应用名称成功', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/edit', array('app_id' => $id, 'code' => $code))));
	}
	
	/**
	 * 删除
	 */
	public function remove() {
		$this->admin_priv('mobile_manage');
		
	    $code   = trim($_GET['code']);
		$app_id = intval($_GET['app_id']);
		RC_DB::table('mobile_manage')->where('app_id', $app_id)->delete();
		
		return $this->showmessage(__('删除客户端成功', 'mobile'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_manage/client_list', array('code' => $code))));
	}
}

//end
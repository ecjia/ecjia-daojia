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
 * 店铺收银设备管理
 */
class mh_cashier_device extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		Ecjia\App\Cashier\Helper::assign_adminlog_content();
		
        RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');
        
        RC_Script::enqueue_script('mh_cashier_device', RC_App::apps_url('statics/js/mh_cashier_device.js', __FILE__), array(), false, 1);
        RC_Script::localize_script('mh_cashier_device', 'js_lang', config('app-cashier::jslang.cashier_device_page'));

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收银设备管理', 'cashier'), RC_Uri::url('cashier/mh_cashier_device/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('merchant', 'merchant/mh_cashier_device.php');
	}

	/**
	 * 店铺收银设备列表
	 */
	public function init() {
		$this->admin_priv('mh_cashier_device_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收银设备', 'cashier')));

		$this->assign('ur_here', __('收银设备', 'cashier'));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_device/add'), 'text' => __('添加收银设备', 'cashier')));
        
		$cashier_device_list = $this->cashier_device_list();
		
		$app_url =  RC_App::apps_url('statics/images', __FILE__);
		$this->assign('app_url', $app_url);
		
		$this->assign('search_action', RC_Uri::url('cashier/mh_cashier_device/init'));
		$this->assign('cashier_device_list', $cashier_device_list);
		
		$this->display('cashier_device_list.dwt');
	}
	
	/**
	 * 添加收银设备
	 */
	public function add() {
		// 检查权限
		$this->admin_priv('mh_cashier_device_update');
	
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收银设备列表', 'cashier')));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_device/init'), 'text' => __('收银设备列表', 'cashier')));
	
		$this->assign('ur_here', __('添加收银设备', 'cashier'));
	
		$this->assign('form_action', RC_Uri::url('cashier/mh_cashier_device/insert'));
	
		$app_url =  RC_App::apps_url('statics/images', __FILE__);
		$this->assign('app_url', $app_url);
		
		$this->display('cashier_device_info.dwt');
	}
	
	/**
	 * 添加条码秤数据处理
	 */
	public function insert() {
		// 检查权限
		$this->admin_priv('mh_cashier_device_update', ecjia::MSGTYPE_JSON);
		
		$device_name 		= !empty($_POST['device_name'])  ? trim($_POST['device_name']) : '';
		$device_mac 		= !empty($_POST['device_mac'])  ? trim($_POST['device_mac']) : '';
		$product_sn 		= !empty($_POST['product_sn'])  ? trim($_POST['product_sn']) : '';
		$device_type 		= !empty($_POST['device_type'])  ? trim($_POST['device_type']) : '';
		$device_sn	 		= !empty($_POST['device_sn'])  ? trim($_POST['device_sn']) : '';
		$keyboard_sn		= !empty($_POST['keyboard_sn'])  ? trim($_POST['keyboard_sn']) : '';
		$status 			= empty($_POST['status']) ? 0 : $_POST['status'];
		$cashier_type 		= empty($_POST['cashier_type']) ? 'cashier-desk' : trim($_POST['cashier_type']);
		
		if (empty($device_name)) {
			return $this->showmessage(__('请输入设备名称！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($device_mac)) {
			return $this->showmessage(__('请填写设备MAC地址！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($product_sn)) {
			return $this->showmessage(__('请填写产品序列号！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($device_type)) {
			return $this->showmessage(__('请选择机型！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($device_sn)) {
			return $this->showmessage(__('请填写设备号！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//店铺内收银设备号不可重复
		$count = RC_DB::table('cashier_device')->where('store_id', $_SESSION['store_id'])->where('device_sn', $device_sn)->count();
		if ($count > 0) {
			return $this->showmessage(__('设备号已存在，请重新输入！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
				'device_name' 		=> $device_name,
				'device_mac'	   	=> $device_mac,
				'product_sn'		=> $product_sn,
				'device_type'		=> $device_type,
				'cashier_type'		=> $cashier_type,
				'device_sn'			=> $device_sn,
				'keyboard_sn'		=> $keyboard_sn,
				'status'			=> $status,
				'store_id'			=> $_SESSION['store_id'],
				'add_time'			=> RC_Time::gmtime()
		);
		
		$id = RC_DB::table('cashier_device')->insertGetId($data);
	
		/* 记录日志 */
		ecjia_merchant::admin_log($device_name, 'add', 'cashier_device');
		return $this->showmessage(__('添加收银设备成功！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cashier/mh_cashier_device/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑收银设备
	 */
	public function edit() {
		$this->admin_priv('mh_cashier_device_update');
	
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收银设备列表', 'cashier'), RC_Uri::url('cashier/mh_cashier_device/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑收银设备', 'cashier')));
	
		$this->assign('ur_here', __('编辑收银设备', 'cashier'));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_device/init'), 'text' => __('收银设备列表', 'cashier')));
		$id = $_GET['id'];
		/* 条码秤信息 */
		$cashier_device_info = RC_DB::table('cashier_device')->where('id', $id)->where('store_id', $_SESSION['store_id'])->first();
	
		$this->assign('cashier_device_info', $cashier_device_info);
		$this->assign('id', $id);
		
		$app_url =  RC_App::apps_url('statics/images', __FILE__);
		$this->assign('app_url', $app_url);
		
		$this->assign('form_action', RC_Uri::url('cashier/mh_cashier_device/update'));
		$this->display('cashier_device_info.dwt');
	}
	
	/**
	 * 编辑收银设备数据处理
	 */
	public function update() {
		$this->admin_priv('mh_cashier_device_update', ecjia::MSGTYPE_JSON);
	
		$id = $_POST['id'];
		$device_name 		= !empty($_POST['device_name'])  ? trim($_POST['device_name']) : '';
		$device_mac 		= !empty($_POST['device_mac'])  ? trim($_POST['device_mac']) : '';
		$product_sn 		= !empty($_POST['product_sn'])  ? trim($_POST['product_sn']) : '';
		$device_type 		= !empty($_POST['device_type'])  ? trim($_POST['device_type']) : '';
		$device_sn 			= !empty($_POST['device_sn'])  ? trim($_POST['device_sn']) : '';
		$keyboard_sn		= !empty($_POST['keyboard_sn'])  ? trim($_POST['keyboard_sn']) : '';
		$status 			= empty($_POST['status']) ? 0 : $_POST['status'];
		$cashier_type 		= empty($_POST['cashier_type']) ? 'cashier-desk' : trim($_POST['cashier_type']);
		
		if (empty($device_name)) {
			return $this->showmessage(__('请输入设备名称！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($device_mac)) {
			return $this->showmessage(__('请填写设备MAC地址！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($product_sn)) {
			return $this->showmessage(__('请填写产品序列号！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($device_type)) {
			return $this->showmessage(__('请选择机型！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($device_sn)) {
			return $this->showmessage(__('请填写设备号！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//店铺内设备号不可重复
		$count = RC_DB::table('cashier_device')->where('store_id', $_SESSION['store_id'])->where('device_sn', $device_sn)->where('id', '!=', $id)->count();
		if ($count > 0) {
			return $this->showmessage(__('设备号已存在！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
				'device_name' 		=> $device_name,
				'device_mac'	   	=> $device_mac,
				'product_sn'		=> $product_sn,
				'device_type'		=> $device_type,
				'cashier_type'		=> $cashier_type,
				'device_sn'			=> $device_sn,
				'keyboard_sn'		=> $keyboard_sn,
				'status'			=> $status,
				'update_time'			=> RC_Time::gmtime()
		);
		RC_DB::table('cashier_device')->where('id', $id)->where('store_id', $_SESSION['store_id'])->update($data);
		/* 记录日志 */
		ecjia_merchant::admin_log($device_name, 'edit', 'cashier_device');
		
		return $this->showmessage(__('编辑收银设备成功', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cashier/mh_cashier_device/edit', array('id' => $id))));
	}
	
	/**
	 * 收银设备是否开启切换
	 */
	public function toggle_status() {
		$this->admin_priv('mh_cashier_device_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['id']);
		$status = intval($_POST['val']);
	
		$data = array(
				'status' 	=> $status,
				'update_time'			=> RC_Time::gmtime()
		);
		RC_DB::table('cashier_device')->where('id', $id)->where('store_id', $_SESSION['store_id'])->update($data);
	
		return $this->showmessage(__('已成功切状态', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 移除收银设备
	 */
	public function remove() {
		$this->admin_priv('mh_cashier_device_delete', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$device_name = RC_DB::table('cashier_device')->where('id', $id)->pluck('device_name');
	
		RC_DB::table('cashier_device')->where('id', $id)->where('store_id', $_SESSION['store_id'])->delete();
	
		ecjia_merchant::admin_log(addslashes($device_name), 'remove', 'cashier_device');
		return $this->showmessage(__('移除收银设备成功！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取收银设备列表
	 */
	private function cashier_device_list() {
		$store_id = $_SESSION['store_id'];
		$db = RC_DB::table('cashier_device');
	
		$keywords = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
	
		$db->where('store_id', $store_id);
		
		if (!empty($keywords)) {
			$db->where(function($query) use ($keywords) {
				$query->where('device_name', 'like', '%'.mysql_like_quote($keywords).'%')->orWhere('device_sn', 'like', '%'.mysql_like_quote($keywords).'%');
			});
		}
		
		$count = $db->count();
		$page = new ecjia_merchant_page($count,10, 5);
		
		$data = $db
		->orderby('id', 'asc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		
		return array('list' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

//end
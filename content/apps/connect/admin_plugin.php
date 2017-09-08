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
 * 帐号 Connect 后台管理
 */
class admin_plugin extends ecjia_admin {

	private $db_user;	
	private $connect_account;
	private $db_connect;
	
	public function __construct() {
		parent::__construct();
		
		$this->connect_account = RC_Loader::load_app_class('connect_account');
		$this->db_user = RC_Loader::load_app_model('users_model');
		$this->db_connect = RC_Loader::load_app_model('connect_model');

		/* 加载所全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('connect', RC_App::apps_url('statics/js/connect.js', __FILE__), array(), false, true);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('connect::connect.connect'), RC_Uri::url('connect/admin_plugin/init')));
		
		$js_lang = array(
			'name_required'	=> RC_Lang::get('connect::connect.pls_name'),
			'desc_required'	=> RC_Lang::get('connect::connect.pls_desc'),
		);
		RC_Script::localize_script('connect', 'js_lang', $js_lang);
		ecjia_screen::get_current_screen()->set_parentage('connect', 'connect/admin_plugin.php');
	}
	
	/**
	 * 连接号码列表
	 */
	public function init() {
	    $this->admin_priv('connect_users_manage');
	    
	    ecjia_screen::get_current_screen()->remove_last_nav_here();
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('connect::connect.connect')));
		$this->assign('ur_here', RC_Lang::get('connect::connect.connect_list'));
		
		$listdb = $this->connect_list();
		$this->assign('listdb', $listdb);
		
		$this->display('connect_list.dwt');
	}
	
	/**
	 * 编辑页面
	 */
	public function edit() {
		$this->admin_priv('connect_users_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('connect::connect.edit')));
		$this->assign('ur_here', RC_Lang::get('connect::connect.edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('connect::connect.connect_list'), 'href' => RC_Uri::url('connect/admin_plugin/init')));
		
		if (isset($_GET['code'])) {
		    $connect_code = trim($_GET['code']);
		} else {
		    return $this->showmessage(RC_Lang::get('connect::connect.invalid_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 查询该连接方式内容 */
		$connect = $this->db_connect->where(array('connect_code' => $connect_code, 'enabled' => 1))->find();
		if (empty($connect)) {
		    return $this->showmessage(RC_Lang::get('connect::connect.connect_type'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}

		/* 取得配置信息 */
		if (is_string($connect['connect_config'])) {
		    $connect_config = unserialize($connect['connect_config']);
		    /* 取出已经设置属性的code */
		    $code_list = array();
		    if (!empty($connect_config)) {
		        foreach ($connect_config as $key => $value) {
		            $code_list[$value['name']] = $value['value'];
		        }
		    }

		    $payment_handle = with(new Ecjia\App\Connect\ConnectPlugin)->channel($connect_code);
		    $connect['connect_config'] = $payment_handle->makeFormData($code_list);
		}

		$this->assign('connect', $connect);

		$this->assign('form_action', RC_Uri::url('connect/admin_plugin/update'));
	
		$this->assign_lang();
		$this->display('connect_edit.dwt');
	}
	
	/**
	 * 编辑处理
	 */
	public function update() {
		$this->admin_priv('connect_users_update', ecjia::MSGTYPE_JSON);
	
		$connect_name = trim($_POST['connect_name']);
		$connect_desc = trim($_POST['connect_desc']);
		
		$oldname      = trim($_POST['oldname']);
		$code         = trim($_POST['connect_code']);
		
		if ($connect_name != $oldname) {
			$query = $this->db_connect->where(array('connect_name' => $connect_name))->count();
			if ($query > 0) {
				return $this->showmessage(RC_Lang::get('connect::connect.confirm_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		/* 取得配置信息 */
		$connect_config = array();
		if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
		    	
		    for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
		        $connect_config[] = array(
		            'name'  => trim($_POST['cfg_name'][$i]),
		            'type'  => trim($_POST['cfg_type'][$i]),
		            'value' => trim($_POST['cfg_value'][$i])
		        );
		    }
		}
		
		$connect_config = serialize($connect_config);
		
		if ($_POST['id']) {
		    /* 编辑 */
		    $data = array(
		        'connect_name'   => $connect_name,
		        'connect_desc'   => trim($_POST['connect_desc']),
		        'connect_config' => $connect_config,
		    );
		    $this->db_connect->where(array('connect_code' => $code))->update($data);
		
		    return $this->showmessage(RC_Lang::get('system::navigator.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
		    $data_one = $this->db_connect->where(array('connect_code' => $code))->count();
		    	
		    if ($data_one > 0) {
		        /* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
		        $data = array(
		            'connect_name'   => $connect_name,
		            'connect_desc'   => $connect_desc,
		            'connect_config' => $connect_config,
		            'enabled'        => '1'
		        );
		        $this->db_connect->where(array('connect_code' => $code))->update($data);
		    } else {
		        /* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */
		        $data =array(
		            'connect_code' 		=> $code,
		            'connect_name' 		=> $connect_name,
		            'connect_desc' 		=> $connect_desc,
		            'connect_config' 	=> $connect_config,
		            'enabled'  			=> '1',
		        );
		
		        $this->db_connect->insert($data);
		    }
		}
	
		$links[] = array('text' =>RC_Lang::get('system::system.go_back'), 'href'=>RC_Uri::url('connect/admin_plugin/init'));
		return $this->showmessage(RC_Lang::get('connect::connect.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('connect/admin_plugin/edit', array('id' => $_POST['id']))));
	}
	
	/**
	 * 修改名称
	 */
	public function edit_name() {
		$this->admin_priv('connect_users_update', ecjia::MSGTYPE_JSON);

		$connect_id   = intval($_POST['pk']);
		$connect_name = trim($_POST['value']);
	
		/* 检查名称是否为空 */
		if (empty($connect_name)) {
			return $this->showmessage(RC_Lang::get('connect::connect.empty_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		} else {
			if( $this->db_connect->where(array('connect_name' => $connect_name, 'connect_id' => array('neq' => $connect_id)))->count() > 0) {
				return $this->showmessage(RC_Lang::get('connect::connect.confirm_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			} else {
				$this->db_connect->where(array('connect_id' => $connect_id ))->update(array('connect_name' => $connect_name));
				return $this->showmessage(RC_Lang::get('connect::connect.edit_name_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}
	}
	
	/**
	 * 修改排序
	 */
	public function edit_order() {
		$this->admin_priv('connect_users_update', ecjia::MSGTYPE_JSON);
	
		if (!is_numeric($_POST['value']) ) {
			return $this->showmessage(RC_Lang::get('connect::connect.confirm_number'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$connect_id    = intval($_POST['pk']);
			$connect_order = intval($_POST['value']);
	
			$this->db_connect->where(array('connect_id' => $connect_id))->update(array('connect_order' => $connect_order));
			return $this->showmessage(RC_Lang::get('connect::connect.sort_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('connect/admin_plugin/init')));
		}
	}
	
	/**
	 * 禁用
	 */
	public function disable() {
		$this->admin_priv('connect_users_disable', ecjia::MSGTYPE_JSON);
	
		$id   = trim($_GET['id']);
		$data = array(
			'enabled' => 0
		);
		$this->db_connect->where(array('connect_id' => $id))->update($data);
	
// 		ecjia_admin::admin_log($id, 'disable', 'payment');
		return $this->showmessage(RC_Lang::get('connect::connect.disable_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('connect/admin_plugin/init')));
	}
	
	/**
	 * 启用
	 */
	public function enable() {
		$this->admin_priv('connect_users_enable', ecjia::MSGTYPE_JSON);
	
		$id   = trim($_GET['id']);
		$data = array(
			'enabled' => 1
		);
		$this->db_connect->where(array('connect_id' => $id))->update($data);

// 		ecjia_admin::admin_log($id, 'enable', 'payment');
		return $this->showmessage(RC_Lang::get('connect::connect.enable_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('connect/admin_plugin/init')));
	}
	
	private function connect_list() {
		$db_topic = RC_Loader::load_app_model('connect_model');
		
		$filter   = array();
		
		$count    = $db_topic->count();
		$filter ['record_count'] = $count;
		$page     = new ecjia_page($count, 10, 5);
	
		$arr      = array ();
		$data     = $db_topic->order(array('connect_order'=> 'desc'))->limit($page->limit())->select();
		if (isset($data)) {
			foreach ($data as $rows) {
				$arr[] = $rows;
			}
		}
		return array('connect_list' => $arr, 'filter'=>$filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

// end
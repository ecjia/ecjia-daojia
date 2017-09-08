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
 * ECJIA 支付方式管理
 */
class admin_plugin extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');		
		
		/* 支付方式 列表页面 js/css */

		RC_Script::enqueue_script('payment_admin', RC_App::apps_url('statics/js/payment_admin.js',__FILE__),array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::localize_script('payment_admin', 'js_lang', RC_Lang::get('payment::payment.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('支付方式'), RC_Uri::url('payment/admin_plugin/init')));
		ecjia_screen::get_current_screen()->set_parentage('payment', 'payment/admin_plugin.php');
	}

	/**
	 * 支付方式列表
	 */
	public function init() {
		$this->admin_priv('payment_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('payment::payment.payment')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('payment::payment.overview'),
			'content'	=> '<p>' . RC_Lang::get('payment::payment.payment_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . RC_Lang::get('payment::payment.more_info') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:支付方式" target="_blank">'. RC_Lang::get('payment::payment.about_payment_list') .'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('payment::payment.payment'));
		
		$plugins = ecjia_config::instance()->get_addon_config('payment_plugins', true, true);
		/* 不能用，该数据查询会把特殊字符双重转义*/
// 		$data = RC_DB::table('payment')->orderBy('pay_order')->get();
		$data = RC_Model::model('payment/payment_model')->order(array('pay_order' => 'asc'))->select();
		$data or $data = array();
		$modules = array();
		foreach($data as $_key => $_value) {
		    if (isset($plugins[$_value['pay_code']])) {
		    	$modules[$_key]['id'] 			= $_value['pay_id'];
		        $modules[$_key]['code'] 		= $_value['pay_code'];
		        $modules[$_key]['name'] 		= $_value['pay_name'];
		        $modules[$_key]['pay_fee'] 		= $_value['pay_fee'];
		        $modules[$_key]['is_cod'] 		= $_value['is_cod'];
		        $modules[$_key]['desc'] 		= $_value['pay_desc'];
		        $modules[$_key]['pay_order'] 	= $_value['pay_order'];
		        $modules[$_key]['enabled'] 		= $_value['enabled'];
		    }
		}
		$this->assign('modules', $modules);
		
		$this->display('payment_channel.dwt');
	}

	/**
	 * 禁用支付方式
	 */
	public function disable() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
				
		$code = trim($_GET['code']);
		$data = array(
			'enabled' => 0
		);
		RC_DB::table('payment')->where('pay_code', $code)->update($data);
		
		$pay_name = RC_DB::table('payment')->where('pay_code', $code)->pluck('pay_name');
		
		ecjia_admin::admin_log($pay_name, 'stop', 'payment');
		
		$refresh_url = RC_Uri::url('payment/admin_plugin/init');
		return $this->showmessage(RC_Lang::get('payment::payment.plugin')."<strong> ".RC_Lang::get('payment::payment.disabled')." </strong>", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
	}
	
	/**
	 * 启用支付方式
	 */
	public function enable() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		$code = trim($_GET['code']);
		$data = array(
			'enabled' => 1
		);
		
		RC_DB::table('payment')->where('pay_code', $code)->update($data);
		
		
		$pay_name = RC_DB::table('payment')->where('pay_code', $code)->pluck('pay_name');
		
		ecjia_admin::admin_log($pay_name, 'use', 'payment');
		
		$refresh_url = RC_Uri::url('payment/admin_plugin/init');
		return $this->showmessage(RC_Lang::get('payment::payment.plugin')."<strong> ".RC_Lang::get('payment::payment.enabled')." </strong>", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
	}
	
	/**
	 * 编辑支付方式 code={$code}
	 */
	public function edit() {
		$this->admin_priv('payment_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('payment::payment.edit_payment')));
		$this->assign('action_link', array('text' => RC_Lang::get('payment::payment.payment'), 'href' => RC_Uri::url('payment/admin_plugin/init')));
		$this->assign('ur_here', RC_Lang::get('payment::payment.edit_payment'));
		
		if (isset($_GET['code'])) {
		    $pay_code = trim($_GET['code']); 
		} else {
		    return $this->showmessage(__('invalid parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 查询该支付方式内容 */
		$pay = RC_DB::table('payment')->where('pay_code', $pay_code)->where('enabled', 1)->first();
		
		if (empty($pay)) {
		    return $this->showmessage(RC_Lang::get('payment::payment.payment_not_available'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 取得配置信息 */
		if (is_string($pay['pay_config'])) {
		    $pay_config = unserialize($pay['pay_config']);
		    /* 取出已经设置属性的code */
		    $code_list = array();
		    if (!empty($pay_config)) {
		        foreach ($pay_config as $key => $value) {
		            $code_list[$value['name']] = $value['value'];
		        }
		    }

		    $payment_handle = with(new Ecjia\App\Payment\PaymentPlugin)->channel($pay_code);
		    $pay['pay_config'] = $payment_handle->makeFormData($code_list);
		}
		
		/* 如果以前没设置支付费用，编辑时补上 */
		if (!isset($pay['pay_fee'])) {
		    $pay['pay_fee'] = 0;
		}	
		$this->assign('pay', $pay);
		$this->assign('form_action', RC_Uri::url('payment/admin_plugin/save'));
		
		$this->display('payment_edit.dwt');
	}
	
	/**
	 * 提交支付方式 post
	 */
	public function save() {	
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		$name = trim($_POST['pay_name']);
		$code = trim($_POST['pay_code']);
		/* 检查输入 */
		if (empty($name)) {
			return $this->showmessage(RC_Lang::get('payment::payment.payment_name') . RC_Lang::get('system::system.empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = RC_DB::table('payment')->where('pay_name', $name)->where('pay_code', '!=', $code)->count();
		if ($data > 0) {
			return $this->showmessage(RC_Lang::get('payment::payment.payment_name'). RC_Lang::get('payment::payment.repeat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 取得配置信息 */
		$pay_config = array();
		if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
			for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
				$pay_config[] = array(
					'name'  => trim($_POST['cfg_name'][$i]),
					'type'  => trim($_POST['cfg_type'][$i]),
					'value' => trim($_POST['cfg_value'][$i])
				);
			}
		}
		
		$pay_config = serialize($pay_config);
		/* 取得和验证支付手续费 */
		$pay_fee = empty($_POST['pay_fee'])? 0: intval($_POST['pay_fee']);

		if ($_POST['pay_id']) {
			/* 编辑 */
			$array = array(
				'pay_name'   => $name,
				'pay_desc'   => trim($_POST['pay_desc']),
				'pay_config' => $pay_config,
				'pay_fee'    => $pay_fee
			);
			RC_DB::table('payment')->where('pay_code', $code)->update($array);
			 
			/* 记录日志 */
			ecjia_admin::admin_log($name, 'edit', 'payment');
			return $this->showmessage(RC_Lang::get('payment::payment.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			$data_one = RC_DB::table('payment')->where('pay_code', $code)->count();
			if ($data_one > 0) {
				/* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
				$data = array(
					'pay_name'   => $name,
					'pay_desc'   => trim($_POST['pay_desc']),
					'pay_config' => $pay_config,
					'pay_fee'    => $pay_fee,
					'enabled'    => '1'						
				);
			    RC_DB::table('payment')->where('pay_code', $code)->update($data);
			    
			} else {
				/* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */				
				$data = array(
				    'pay_code'     => $code,
					'pay_name'     => $name,
					'pay_desc'     => trim($_POST['pay_desc']),
					'pay_config'   => $pay_config,
					'is_cod'       => intval($_POST['is_cod']),
					'pay_fee'      => $pay_fee,
					'enabled'      => '1',
					'is_online'    => intval($_POST['is_online'])
				);
	           	RC_DB::table('payment')->insertGetId($data);
			}
			
			/* 记录日志 */
			ecjia_admin::admin_log($name, 'edit', 'payment');
			$refresh_url = RC_Uri::url('payment/admin_plugin/edit', array('code' => $code));
			
			return $this->showmessage(RC_Lang::get('payment::payment.install_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
		}			
	}
	
	/**
	 * 修改支付方式名称
	 */
	public function edit_name() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		/* 取得参数 */
		$pay_id  = intval($_POST['pk']);
		$pay_name = trim($_POST['value']);
		
		/* 检查名称是否为空 */
		if (empty($pay_name) || $pay_id==0 ) {
			return $this->showmessage(RC_Lang::get('payment::payment.name_is_null'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			/* 检查名称是否重复 */
			if (RC_DB::table('payment')->where('pay_name', $pay_name)->where('pay_id', '!=', $pay_id)->count() > 0) {
				return $this->showmessage(RC_Lang::get('payment::payment.name_exists') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			} else {
				RC_DB::table('payment')->where('pay_id', $pay_id)->update(array('pay_name' => stripcslashes($pay_name)));
				
				ecjia_admin::admin_log(stripcslashes($pay_name), 'edit', 'payment');
				return $this->showmessage(RC_Lang::get('payment::payment.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}
	}
	

	/**
	 * 修改支付方式排序
	 */
	public function edit_order() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		if ( !is_numeric($_POST['value']) ) {
			return $this->showmessage('请输入合法数字', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			/* 取得参数 */
			$pay_id    = intval($_POST['pk']);
			$pay_order = intval($_POST['value']);
		
			RC_DB::table('payment')->where('pay_id', $pay_id)->update(array('pay_order' => $pay_order));
			
			return $this->showmessage(RC_Lang::get('payment::payment.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_uri::url('payment/admin_plugin/init')) );
		}
	}
	
	/**
	 * 修改支付方式费用
	 */
	public function edit_pay_fee() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		/* 取得参数 */
		$pay_id  = intval($_POST['pk']);
		$pay_fee = trim($_POST['value']);
		
		if (empty($pay_fee) && !($pay_fee === '0')) {
			return $this->showmessage(RC_Lang::get('payment::payment.invalid_pay_fee') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$pay_insure = make_semiangle($pay_fee); //全角转半角
			if (strpos($pay_insure, '%') === false) { //不包含百分号
				if ( !is_numeric($pay_fee) ) {
					return $this->showmessage('请输入合法数字或百分比%', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				} else {
					$pay_fee = floatval($pay_insure);
				}
			}
			else {
				$pay_fee = floatval($pay_insure) . '%';
			}
			$pay_name = RC_DB::table('pay_id', $pay_id)->pluck('pay_name');
			RC_DB::table('payment')->where('pay_id', $pay_id)->update(array('pay_fee' => stripcslashes($pay_fee)));
			
			ecjia_admin::admin_log($pay_name.'，'.'修改费用为 '.$pay_fee, 'setup', 'payment');
			return $this->showmessage(RC_Lang::get('payment::payment.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
}

// end
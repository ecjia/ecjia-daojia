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
 * ECJIA 配送方式管理程序
 */
class admin extends ecjia_admin {
	private $db_shipping;

	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_shipping 	= RC_Model::model('shipping/shipping_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');

		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		
		RC_Script::enqueue_script('ecjia.utils');
		RC_Script::enqueue_script('ecjia.common');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Loader::load_app_class('shipping_factory', null, false);
		
        //时间控件
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
        RC_Script::enqueue_script('bootstrap-timepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		
		RC_Script::enqueue_script('shopping_admin', RC_App::apps_url('statics/js/shipping_admin.js', __FILE__));
		RC_Script::enqueue_script('shipping', RC_App::apps_url('statics/js/shipping.js', __FILE__));
		
		RC_Script::localize_script('shipping', 'js_lang', RC_Lang::get('shipping::shipping.js_lang'));
		RC_Script::localize_script('shopping_admin', 'js_lang', RC_Lang::get('shipping::shipping.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping.shipping'), RC_Uri::url('shipping/admin/init')));
	}

	/**
	 * 配送方式列表  get
	 */
	public function init() { 
		$this->admin_priv('ship_manage');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping.shipping')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('shipping::shipping.overview'),
			'content'	=> '<p>' . RC_Lang::get('shipping::shipping.shipping_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('shipping::shipping.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">'. RC_Lang::get('shipping::shipping.about_shipping_list') .'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('shipping::shipping.shipping'));
		
		//替换数据库获取数据方式
		$data = $this->db_shipping->shipping_select(array('shipping_id', 'shipping_code', 'shipping_name', 'shipping_desc', 'insure', 'support_cod', 'shipping_order', 'enabled'), '', 'shipping_order');
		$data or $data = array();
		
		$plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);
			
		/* 插件已经安装了，获得名称以及描述 */
		$modules = array();
		foreach ($data as $_key => $_value) {
			if (isset($plugins[$_value['shipping_code']])) {
				$modules[$_key]['id']      			= $_value['shipping_id'];
				$modules[$_key]['code']      		= $_value['shipping_code'];
				$modules[$_key]['name']    			= $_value['shipping_name'];
				$modules[$_key]['desc']    			= $_value['shipping_desc'];
				$modules[$_key]['cod']     			= $_value['support_cod'];
				$modules[$_key]['shipping_order'] 	= $_value['shipping_order'];
				$modules[$_key]['insure_fee']  		= $_value['insure'];
				$modules[$_key]['enabled'] 			= $_value['enabled'];
				 
				/* 判断该派送方式是否支持保价 支持报价的允许在页面修改保价费 */
				$shipping_handle = new shipping_factory($_value['shipping_code']);
				$config          = $shipping_handle->configure_config();
		
				/* 只能根据配置判断是否支持保价  只有配置项明确说明不支持保价，才是不支持*/
				if (isset($config['insure']) && ($config['insure'] === false)) {
					$modules[$_key]['is_insure'] = false;
				} else {
					$modules[$_key]['is_insure'] = true;
				}
			}
		}
		$this->assign('modules', $modules);
		
		$this->display('shipping_list.dwt');
	}
	
	
	/**
	 * 编辑配送方式 code={$code}
	 */
	public function edit() {
		$this->admin_priv('ship_update');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping.edit_shipping')));
		$this->assign('action_link', array('text' => RC_Lang::get('shipping::shipping.shipping'), 'href' => RC_Uri::url('shipping/admin/init')));
		$this->assign('ur_here', RC_Lang::get('shipping::shipping.edit_shipping'));
	
		if (isset($_GET['code'])) {
			$shipping_code = trim($_GET['code']);
		} else {
			return $this->showmessage(__('invalid parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 查询该支付方式内容 */
		$shipping = $this->db_shipping->shipping_find(array('shipping_code' => $shipping_code, 'enabled' => 1));
		if (empty($shipping)) {
			return $this->showmessage(RC_Lang::get('shipping::shipping.shipping_not_available'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
			
		$this->assign('form_action', RC_Uri::url('shipping/admin/save'));
		$this->assign('shipping', $shipping);
	
		$this->display('shipping_edit.dwt');
	}
	
	/**
	 * 提交配送方式post
	 */
	public function save() {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
	
		$name = trim($_POST['shipping_name']);
		$code = trim($_POST['shipping_code']);
		if (empty($name)) {
			return $this->showmessage(RC_Lang::get('shipping::shipping.shipping_name') . RC_Lang::get('system::system.empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$data = $this->db_shipping->is_only(array('shipping_name' => $name, 'shipping_code' => array('neq' => $code)));
		if ($data > 0) {
			return $this->showmessage(RC_Lang::get('shipping::shipping.shipping_name'). RC_Lang::get('shipping::shipping.repeat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$array = array(
			'shipping_name'   => $name,
			'shipping_desc'   => trim($_POST['shipping_desc']),
		);
		$this->db_shipping->shipping_update(array('shipping_code' => $code), $array);

		/* 记录日志 */
		ecjia_admin::admin_log($name, 'edit', 'shipping');
		return $this->showmessage(RC_Lang::get('shipping::shipping.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('shipping/admin/edit', array('code' => $code))));
	}
	
	/**
	 * 禁用配送方式 ajax-get
	 */
	public function disable() {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
	
		$code = trim($_GET['code']); 
		$data = array('enabled' => 0);
		$this->db_shipping->shipping_update(array('shipping_code' => $code), $data);

		$refresh_url = RC_Uri::url('shipping/admin/init');
		$shipping_name = $this->db_shipping->shipping_field(array('shipping_code' => $code), 'shipping_name');

		ecjia_admin::admin_log($shipping_name, 'stop', 'shipping');
		return $this->showmessage(RC_Lang::get('shipping::shipping.plugin').' <strong>'.RC_Lang::get('shipping::shipping.disabled').'</strong>', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS , array( 'refresh_url' => $refresh_url));
	}
	
	/**
	 * 启用配送方式 ajax-get
	 */
	public function enable() {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
	
		$code = trim($_GET['code']);
		$data = array('enabled' => 1);
		$this->db_shipping->shipping_update(array('shipping_code' => $code), $data);

		$refresh_url = RC_Uri::url('shipping/admin/init');
		$shipping_name = $this->db_shipping->shipping_field(array('shipping_code' => $code), 'shipping_name');
		
		ecjia_admin::admin_log($shipping_name, 'use', 'shipping');
		return $this->showmessage(RC_Lang::get('shipping::shipping.plugin').' <strong>'.RC_Lang::get('shipping::shipping.enabled').'</strong>', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS , array( 'refresh_url' => $refresh_url));
	}
	
	
	/**
	 * 模板Flash编辑器
	 */
	public function print_index() {	
		$this->admin_priv('ship_update');
		
		$shipping_id = !empty($_GET['shipping_id']) ? intval($_GET['shipping_id']) : 0;
		/* 检查该插件是否已经安装 取值 */ 
		$shipping_data = $this->db_shipping->shipping_find(array('shipping_id' => $shipping_id));

		if ($shipping_data) {
			/* 判断模板图片位置 */
			if (!empty($shipping_data['print_bg']) && trim($shipping_data['print_bg']) !='') {
				$uploads_dir_info    = RC_Upload::upload_dir();
				$shipping_data['print_bg'] = $uploads_dir_info['baseurl'] . $shipping_data['print_bg'];
			} else {
				/* 使用插件默认快递单图片 */
				$plugin_handle = new shipping_factory($shipping_data['shipping_code']);
				$config = $plugin_handle->configure_config();
				$shipping_data['print_bg'] = $config['print_bg'];
			}
			$shipping_data['shipping_print'] = !empty($shipping_data['shipping_print']) ? $shipping_data['shipping_print'] : '';
		}
		$links = array(
			'recovery'         => RC_Uri::url('shipping/admin/recovery_default_template'),
			'print_img_upload' => RC_Uri::url('shipping/admin/print_upload'),
			'print_img_del'    => RC_Uri::url('shipping/admin/print_del'),
			'do_edit'          => RC_Uri::url('shipping/admin/do_edit_print_template')	
		);
		$this->assign('post_links',  $links);
		$this->assign('shipping',    $shipping_data);
		$this->assign('shipping_id', $shipping_id);
		$this->assign('lang_lable_box', RC_Lang::get('shipping::shipping.lable_box'));
		$this->assign('lang_js_languages', RC_Lang::get('shipping::shipping.js_languages'));
	
		$this->display('print_index.dwt');
	}
	
	/**
	 * 模板Flash编辑器
	 */
	public function recovery_default_template() {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
		
		$shipping_id = !empty($_POST['shipping_id']) ? intval($_POST['shipping_id']) : 0;
		/* 取配送代码 */
		$shipping_data = $this->db_shipping->shipping_find(array('shipping_id' => $shipping_id), array('shipping_code', 'print_bg'));

		if( isset($shipping_data['shipping_code']) ) {
			$plugin_handle = new shipping_factory($shipping_data['shipping_code']);
			$config        = $plugin_handle->configure_config();
			$data = array(
				'print_bg'     => '',
				'config_lable' => $config['config_lable']
			);
			$this->db_shipping->shipping_update(array('shipping_code' => $shipping_data['shipping_code']), $data);
			/* 如果存在之前的上传的图片，删除图片 */
			if ($shipping_data['print_bg'] != '') {
				$uploads_dir_info    = RC_Upload::upload_dir();
				$data_file_to_delete = $uploads_dir_info['basedir'] . $shipping_data['print_bg'];
				if( is_file($data_file_to_delete) == TRUE ) {
					chmod($data_file_to_delete, 0666);
					unlink($data_file_to_delete);
				}
			}
			$refresh_url = RC_Uri::url('shipping/admin/edit_print_template', array('shipping_id' => $shipping_id ));
			return $this->showmessage(RC_Lang::get('shipping::shipping.recovery_default') . RC_Lang::get('shipping::shipping.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS , array( 'refresh_url' => $refresh_url));
		} else {
			return $this->showmessage(RC_Lang::get('shipping::shipping.recovery_default') . RC_Lang::get('shipping::shipping.attradd_faild'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		}
	}
	
	function move_upload_file($file_name, $target_name = '') {
		if (function_exists("move_uploaded_file")) { 
			if (move_uploaded_file($file_name, $target_name)) { 
				@chmod($target_name, 0755);
				return true;
			}
			else if (copy($file_name, $target_name)) {
				@chmod($target_name, 0755);
				return true;
			}
		}
		elseif (copy($file_name, $target_name)) { 
			@chmod($target_name, 0755);
			return true;
		}
		return false;
	}
	/**
	 * 模板Flash编辑器 上传图片
	 */
	public function print_upload() { 
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
		
		//设置上传文件类型
		$allow_suffix = array('jpg', 'png', 'jpeg'); 
		$shipping_id = !empty($_POST['shipping_id']) ? intval($_POST['shipping_id']) : 0;
		$uploads_dir_info = RC_Upload::upload_dir();
		//接收上传文件
		if (!empty($_FILES['bg']['name'])) {
			/*在前端已做对文件上传类型的限制*/
			if (!RC_File::file_suffix($_FILES['bg']['name'], $allow_suffix)) {
				$url = RC_Uri::url('shipping/admin/edit_print_template', array('shipping_id' => $shipping_id )) ;
				$this->header("Location: $url\n");
  				return $this->showmessage(RC_Lang::get('shipping::shipping.js_languages.upload_falid') .implode(',', $allow_suffix), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			} else {
				$name = date('Ymd');
				for ($i = 0; $i < 6; $i++) {
					$name .= chr(mt_rand(97, 122));
				}
				$name .= '.' . end(explode('.', $_FILES['bg']['name']));
				
				$target =  $uploads_dir_info['basedir'] . '/images/receipt/';
				if (!is_dir($target)) {
					mkdir($target, 0777, true); // 使用最大权限0777创建文件
				}
				$target = $target. $name;
				if ($this->move_upload_file($_FILES['bg']['tmp_name'], $target)) {
					$src = '/images/receipt/' . $name;
				}
				/* 如果之前存在上传的图片，先删除 */
				$ship_date = $this->db_shipping->shipping_select('', array('shipping_id' => $shipping_id));
				if ($ship_date) {
					if (isset($ship_date['print_bg'])) {
						$uploads_dir_info = RC_Upload::upload_dir();
						@unlink($uploads_dir_info['basedir']. $ship_date['print_bg']);
					}
				}
				$data = array( 'print_bg' => $src );
				$res = $this->db_shipping->shipping_update(array('shipping_id' => $shipping_id), $data);

				if($res) {
					$url = RC_Uri::url('shipping/admin/edit_print_template', array('shipping_id' => $shipping_id)) ;
					$this->header("Location: $url\n");
				} else {
					return $this->showmessage(RC_Lang::get('shipping::shipping.upload_shipping_bg'). RC_Lang::get('shipping::shipping.attradd_faild'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		} else {
			return $this->showmessage(RC_Lang::get('shipping::shipping.upload_shipping_bg'). RC_Lang::get('shipping::shipping.attradd_faild'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 模板Flash编辑器 删除图片
	 */
	public function print_del() {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
		
		$shipping_id = !empty($_POST['shipping_id']) ? intval($_POST['shipping_id']) : 0;
		$ship_date = $this->db_shipping->shipping_find(array('shipping_id' => $shipping_id), 'print_bg');

		if ($ship_date) {
			if ($ship_date['print_bg'] != '') {
				$uploads_dir_info = RC_Upload::upload_dir();
				@unlink($uploads_dir_info['basedir']. $ship_date['print_bg']);
				
				$data = array('print_bg' => '');
				$res = $this->db_shipping->shipping_update(array('shipping_id' => $shipping_id), $data);

				return $this->showmessage(RC_Lang::get('shipping::shipping.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				return $this->showmessage(RC_Lang::get('shipping::shipping.use_again_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}	
		} else {
			return $this->showmessage(RC_Lang::get('shipping::shipping.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑打印模板
	 */
	public function edit_print_template($shipid=0) {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('shipping::shipping.overview'),
			'content'	=> '<p>' . RC_Lang::get('shipping::shipping.edit_template_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('shipping::shipping.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">'. RC_Lang::get('shipping::shipping.about_edit_template') .'</a>') . '</p>'
		);
		
		$shipping_id = !empty($_GET['shipping_id']) ? intval($_GET['shipping_id']) : ( $shipid > 0 ? $shipid: 0);
		$shipping_data = $this->db_shipping->shipping_find(array('shipping_id' => $shipping_id));

		if ($shipping_data) {
			$shipping_data['shipping_print']	= !empty($shipping_data['shipping_print']) 	? $shipping_data['shipping_print'] 	: '';
			$shipping_data['print_model'] 		= !empty($shipping_data['print_model']) 	? $shipping_data['print_model']	  	: 1; //兼容以前版本
			$this->assign('shipping', $shipping_data);
			
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping.edit_template')));
			
			$this->assign('ur_here', RC_Lang::get('shipping::shipping.edit_template'));
			$this->assign('action_link', array('text' => RC_Lang::get('shipping::shipping.shipping'), 'href' => RC_Uri::url('shipping/admin/init')));
			$this->assign('shipping_id', $shipping_id);
			
			$this->display('shipping_template.dwt');
		} else {
			return $this->showmessage(RC_Lang::get('shipping::shipping.no_shipping_install'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		}
	}
	
	/**
	 * 编辑打印模板
	 */
	public function do_edit_print_template() {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
				
		$print_model = !empty($_POST['print_model']) ? intval($_POST['print_model']) : 0;
		$shipping_id = !empty($_POST['shipping_id']) ? intval($_POST['shipping_id']) : 0;
		/* 处理不同模式编辑的表单 */
		if ($print_model == 2) {
			$data = array(
				'config_lable' => trim($_POST['config_lable']),
				'print_model'  => $print_model
			);
			$this->db_shipping->shipping_update(array('shipping_id' => $shipping_id), $data);

		} elseif ($print_model == 1) {
			//代码模式
			$template = !empty($_POST['shipping_print']) ? trim($_POST['shipping_print']) : '';
			$data = array(
				'shipping_print' 	=> $template,
				'print_model'  		=> $print_model
			);
			$this->db_shipping->shipping_update(array('shipping_id' => $shipping_id), $data);
		}
		
		ecjia_admin::admin_log(addslashes($_POST['shipping_name']), 'edit', 'shipping_print_template');
		return $this->showmessage(RC_Lang::get('shipping::shipping.edit_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 编辑配送方式名称
	 */
	public function edit_name() {	
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
			
		/* 取得参数 */
		$shipping_id  	= intval($_POST['pk']);
		$shipping_name 	= trim($_POST['value']);
		/* 检查名称是否为空 */
		if (empty($shipping_name) || $shipping_id == 0 ) {
			return $this->showmessage(RC_Lang::get('shipping::shipping.no_shipping_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		} else {
			/* 检查名称是否重复 */
			$old_name=$this->db_shipping->shipping_field(array('shipping_id' => $shipping_id), 'shipping_name');
			/* 名称是否有修改 */
			if ($old_name==$shipping_name ) {
				return $this->showmessage(RC_Lang::get('shipping::shipping.repeat_shipping_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			} else {
				/* 名称是否重复 */
				if ($this->db_shipping->is_only(array('shipping_name' => $shipping_name, 'shipping_id' => array('neq' => $shipping_id))) != 0) {

					return $this->showmessage(RC_Lang::get('shipping::shipping.repeat_shipping_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
				} else {
					$this->db_shipping->shipping_update(array('shipping_id' => $shipping_id), array('shipping_name' => $shipping_name));
					
					ecjia_admin::admin_log(addslashes($shipping_name), 'edit', 'shipping');
					return $this->showmessage(RC_Lang::get('shipping::shipping.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
				}
			}
		}
	}
		
	/**
	 * 修改配送方式保价费
	 */
	public function edit_insure() {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
				
		$shipping_id 	 = intval($_POST['pk']);
		$shipping_insure = trim($_POST['value']);
		
		if (empty($shipping_insure) && !($shipping_insure === '0')) {
			return $this->showmessage(RC_Lang::get('shipping::shipping.no_shipping_insure'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		else {
			$shipping_insure = make_semiangle($shipping_insure); //全角转半角
			if (strpos($shipping_insure, '%') === false) {
				if (!is_numeric($_POST['value'])) { 
					return $this->showmessage(RC_Lang::get('shipping::shipping.enter_valid_number'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				} else {
					$shipping_insure = floatval($shipping_insure);
				}
			}
			else {
				$shipping_insure = floatval($shipping_insure) . '%';
			}
			/* 检查该插件是否支持保价   在此不做检查，在页面上进行控制，不支持保价的不允许修改*/
			$this->db_shipping->shipping_update(array('shipping_id' => $shipping_id), array('insure' => $shipping_insure));

			return $this->showmessage(RC_Lang::get('shipping::shipping.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	

	/**
	 * 修改配送方式排序
	 */
	public function edit_order() {
		$this->admin_priv('ship_update', ecjia::MSGTYPE_JSON);
		
		if (!is_numeric($_POST['value'])) {
			return $this->showmessage(RC_Lang::get('shipping::shipping.format_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			/* 取得参数 */
			$shipping_id    = intval($_POST['pk']);
			$shipping_order = intval($_POST['value']);
			
			$this->db_shipping->shipping_update(array('shipping_id' => $shipping_id), array('shipping_order' => $shipping_order));
			return $this->showmessage(RC_Lang::get('shipping::shipping.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('shipping/admin/init')));
		}
	}
}	

// end
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
 * ECJia 配送区域管理程序
 */
class mh_area extends ecjia_merchant {
	private $db_shipping;
	private $db_region;
	private $db_shipping_area;
	private $db_shipping_area_region;
	
	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('global');
		RC_Loader::load_app_class('shipping_factory', null, false);
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');	
		RC_Script::enqueue_script('merchant_shipping', RC_App::apps_url('statics/js/merchant_shipping.js', __FILE__));
		RC_Style::enqueue_style('merchant_shipping', RC_App::apps_url('statics/css/merchant_shipping.css', __FILE__), array(), false, false);
		
      	//时间控件
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
		
		$this->db_shipping 				= RC_Model::model('shipping/shipping_model');
		$this->db_shipping_area 		= RC_Model::model('shipping/shipping_area_model');
		$this->db_region 				= RC_Model::model('shipping/region_model');
		$this->db_shipping_area_region 	= RC_Model::model('shipping/shipping_area_region_model');
		
		RC_Script::localize_script('merchant_shipping', 'js_lang', RC_Lang::get('shipping::shipping.js_lang'));
		RC_Script::localize_script('shopping_admin', 'js_lang', RC_Lang::get('shipping::shipping.js_lang'));
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('shipping', 'shipping/mh_area.php');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('我的配送', RC_Uri::url('shipping/merchant/init')));
	}
	
	/**
	 * 配送区域列表
	 */
	public function init() {
		$this->admin_priv('ship_merchant_manage');
		
		$shipping_id = !empty($_GET['shipping_id']) ? intval($_GET['shipping_id']) : 0;
		$args = array('shipping_id' => $shipping_id);
		$args['keywords'] = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';

		$ship_areas_list = $this->db_shipping_area->get_shipareas_list($args);

		$shipping_name = $this->db_shipping->shipping_field(array('shipping_id' => $shipping_id), 'shipping_name');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($shipping_name));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('shipping::shipping_area.overview'),
			'content'	=> '<p>' . RC_Lang::get('shipping::shipping_area.shipping_area_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('shipping::shipping_area.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">'. RC_Lang::get('shipping::shipping_area.about_shipping_area') .'</a>') . '</p>'
		);
		
		$code = !empty($_GET['code']) ? trim($_GET['code']) : '';
		
		$this->assign('code',	$code);
		$this->assign('areas',	$ship_areas_list);
		$this->assign('ur_here', $shipping_name);
		
		$this->assign('action_link', array('href' => RC_Uri::url('shipping/mh_area/add', array('shipping_id' => $shipping_id, 'code' => $code)), 'text' => RC_Lang::get('shipping::shipping_area.new_area')));
		$this->assign('shipping_method', array('href' => RC_Uri::url('shipping/merchant/init'), 'text' => '我的配送'));
		
		$this->assign('shipping_id', $shipping_id);
		$this->assign('form_action', RC_Uri::url('shipping/mh_area/multi_remove', array('shipping_id' => $shipping_id, 'code' => $code)));
		$this->assign('search_action', RC_Uri::url('shipping/mh_area/init'));

		$this->display('shipping_area_list.dwt');
	}
	
	/**
	 * 新建配送区域
	 * 
	 */
	public function add() {
	    $this->admin_priv('ship_merchant_update');
		
		$shipping_id 	= !empty($_GET['shipping_id']) 	? intval($_GET['shipping_id']) 	: 0;
		$code 			= !empty($_GET['code']) 		? trim($_GET['code']) 			: '';
		
		$shipping_data  = $this->db_shipping->shipping_find(array('shipping_id' => $shipping_id), array('shipping_name', 'shipping_code', 'support_cod'));

		$fields = array();
		$shipping_handle = new shipping_factory($shipping_data['shipping_code']);
		$fields = $shipping_handle->form_format($fields, true);
		
		$count = count($fields);
		$fields[$count]['name']     = "free_money";
		$fields[$count]['value']    = "0";
		$fields[$count]['label']    = RC_Lang::get('shipping::shipping_area.free_money');
		
		/* 如果支持货到付款，则允许设置货到付款支付费用 */
		if ($shipping_data['support_cod']) {
			$count++;
			$fields[$count]['name']     = "pay_fee";
			$fields[$count]['value']    = "0";
			$fields[$count]['label']    = RC_Lang::get('shipping::shipping_area.pay_fee');
		}
		
		$shipping_area['shipping_id']   = 0;
		$shipping_area['free_money']    = 0;

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($shipping_data['shipping_name'], RC_Uri::url('shipping/mh_area/init', array('shipping_id' => $shipping_id, 'code' => $code))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping_area.new_area')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('shipping::shipping_area.overview'),
			'content'	=> '<p>' . RC_Lang::get('shipping::shipping_area.add_area_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('shipping::shipping_area.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">'. RC_Lang::get('shipping::shipping_area.about_add_area') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('shipping::shipping_area.new_area'));		
		$this->assign('shipping_area', array('shipping_id' => $shipping_id, 'shipping_code' => $shipping_data['shipping_code']));
		
		$this->assign('fields', $fields);
		$this->assign('form_action', 'insert');
		$this->assign('countries', $this->db_region->get_regions());

		$this->assign('action_link', array('text' => $shipping_data['shipping_name'].RC_Lang::get('shipping::shipping_area.list'), 'href' => RC_Uri::url('shipping/mh_area/init', array('shipping_id' => $shipping_id, 'code' => $code ))));
		$this->assign('default_country', ecjia::config('shop_country'));
		$this->assign('region_get_url', RC_Uri::url('shipping/region/init'));
		$this->assign('form_action', RC_Uri::url('shipping/mh_area/insert', array('shipping_id' => $shipping_id, 'code' => $code)));
		
		$this->display('shipping_area_info.dwt');
	}
	
	public function insert() {
	    $this->admin_priv('ship_merchant_update', ecjia::MSGTYPE_JSON);
	    
	    $shipping_id 		= !empty($_GET['shipping_id']) ? intval($_GET['shipping_id']) : 0;
	    $shipping_area_name = !empty($_POST['shipping_area_name']) ? trim($_POST['shipping_area_name']) : '';
	    $code 				= !empty($_GET['code']) ? trim($_GET['code']) : '';

		/* 检查同类型的配送方式下有没有重名的配送区域 */	
		$area_count = $this->db_shipping_area->is_only(array('shipping_id' => $shipping_id, 'shipping_area_name' => $shipping_area_name, 'store_id' => $_SESSION['store_id']));

		if ($area_count > 0) {
		    return $this->showmessage(RC_Lang::get('shipping::shipping_area.repeat_area_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$shipping_data = $this->db_shipping->shipping_find(array('shipping_id' => $shipping_id), array('shipping_code', 'support_cod', 'shipping_name'));

			$config = array();
			$shipping_handle = new shipping_factory($shipping_data['shipping_code']);
			$config = $shipping_handle->form_format($config, true);
			if (!empty($config)) {
    			foreach ($config AS $key => $val) {
    				$config[$key]['name']   = $val['name'];
    				$config[$key]['value']  = $_POST[$val['name']];
    			}
			}
			
			$count = count($config);
			$config[$count]['name']     = 'free_money';
			$config[$count]['value']    = empty($_POST['free_money']) ? '0' : trim($_POST['free_money']);
			$count++;
			$config[$count]['name']     = 'fee_compute_mode';
			$config[$count]['value']    = empty($_POST['fee_compute_mode']) ? '' : trim($_POST['fee_compute_mode']);
			
			/* 如果支持货到付款，则允许设置货到付款支付费用 */
			if ($shipping_data['support_cod']) {
				$count++;
				$config[$count]['name']     = 'pay_fee';
				$config[$count]['value']    =  make_semiangle(empty($_POST['pay_fee']) ? '0' : trim($_POST['pay_fee']));
			}
			
			if ($shipping_data['shipping_code'] == 'ship_o2o_express') {
					
				$time = array();
				foreach ($_POST['start_ship_time'] as $k => $v) {
					$time[$k]['start']	= $v;
					$time[$k]['end']	= $_POST['end_ship_time'][$k];
				}
				
				
				$config[$count]['name']     = 'express_money';
				$config[$count]['value']    = empty($_POST['express_money']) ? 0 : floatval($_POST['express_money']);
				$count++;
				$config[$count]['name']     = 'ship_days';
				$config[$count]['value']    = empty($_POST['ship_days']) ? '' : intval($_POST['ship_days']);
				$count++;
				$config[$count]['name']     = 'last_order_time';
				$config[$count]['value']    = empty($_POST['last_order_time']) ? '' : trim($_POST['last_order_time']);
				$count++;
				$config[$count]['name']     = 'ship_time';
				$config[$count]['value']    = empty($time) ? '' : $time;
			}

			$data = array(
				'shipping_area_name'    => $shipping_area_name,
				'shipping_id'           => $shipping_id,
				'configure'             => serialize($config)
			);
			if (isset($_SESSION['store_id'])) {
				$data['store_id'] = $_SESSION['store_id'];
			}
			
			$area_id = $this->db_shipping_area->shipping_area_manage($data);

			/* 添加选定的城市和地区 */
			if (isset($_POST['regions']) && is_array($_POST['regions'])) {
				foreach ($_POST['regions'] as $key => $val) {
					$data = array(
						'shipping_area_id' 	=> $area_id,
					    'region_id' 		=> $val
					);
					$this->db_shipping_area_region->shipping_area_region_insert($data);
				}
			}
			
			ecjia_merchant::admin_log($shipping_area_name.'，'.RC_Lang::get('shipping::shipping_area.shipping_way').$shipping_data['shipping_name'], 'add', 'shipping_area');
			$links[] = array('text' => RC_Lang::get('shipping::shipping_area.add_continue'), 'href' => RC_Uri::url('shipping/mh_area/add', array('shipping_id' => $shipping_id, 'code' => $code)));
			
			$refresh_url = RC_Uri::url('shipping/mh_area/edit', array('id' => $area_id, 'shipping_id' => $shipping_id, 'code' => $code));
			return $this->showmessage(RC_Lang::get('shipping::shipping_area.add_area_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'refresh_url' => $refresh_url));
		}
	}
	
	/**
	 * 编辑配送区域
	 */
	public function edit() {
		$this->admin_priv('ship_merchant_update');
		
		$dbview = RC_Model::model('shipping/shipping_viewmodel');

		$shipping_id 	= !empty($_GET['shipping_id']) 	? intval($_GET['shipping_id']) 	: 0;
		$ship_area_id 	= !empty($_GET['id']) 			? intval($_GET['id']) 			: 0;
		$code 			= !empty($_GET['code']) 		? trim($_GET['code']) 			: '';
		
		$shipping_data = $dbview->shipping_area_find(array('a.shipping_area_id' => $ship_area_id, 'a.store_id' => $_SESSION['store_id']), 's.shipping_name, s.shipping_code, s.support_cod, a.*', 'shipping_area');
		if (empty($shipping_data)) {
			return $this->showmessage('未找到相关配送区域！', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
		$fields = unserialize ($shipping_data['configure']);

		/* 如果配送方式支持货到付款并且没有设置货到付款支付费用，则加入货到付款费用 */
		if ($shipping_data['support_cod'] && $fields[count($fields) - 1]['name'] != 'pay_fee') {
			$fields[] = array (
				'name' => 'pay_fee',
				'value' => 0 
			);
		}
		
		$shipping_handle = new shipping_factory($shipping_data['shipping_code']);
		$fields = $shipping_handle->form_format($fields, true);
		if (! empty( $fields )) {
			foreach ($fields as $key => $val ) {
				/* 替换更改的语言项 */
				if ($val['name'] == 'basic_fee') {
					$val['name'] = 'base_fee';
				}

				if ($val['name'] == 'item_fee') {
					$item_fee = 1;
				}
				if ($val['name'] == 'fee_compute_mode') {
					$this->assign( 'fee_compute_mode', $val ['value'] );
					unset( $fields [$key] );
				} else {
					$fields[$key]['name'] = $val['name'];
					$fields[$key]['label'] = empty($val['label']) ? RC_Lang::get('shipping::shipping_area.'.$val['name']) : $val['label'];
				}
				
				if ($shipping_data['shipping_code'] == 'ship_o2o_express' && (in_array($val['name'], array('ship_days', 'last_order_time', 'ship_time', 'express_money')))) {
					if ($val['name'] == 'ship_time') {
						$o2o_shipping_time = array();
						foreach ($val['value'] as $v) {
							$o2o_shipping_time[] = $v;
						}
				
						$this->assign('o2o_shipping_time', $o2o_shipping_time);
					}
					if ($val['name'] == 'ship_days') {
						$this->assign('ship_days', $val['value']);
					}
					if ($val['name'] == 'last_order_time') {
						$this->assign('last_order_time', $val['value']);
					}
					if ($val['name'] == 'express_money') {
						$this->assign('express_money', $val['value']);
					}
					unset($fields [$key]);
				}
			}
		} 
		if (empty( $item_fee )&& !empty( $fields )) {
			$field = array (
				'name' 	=> 'item_fee',
				'value' => '0',
				'label' => ecjia_config::has(RC_Lang::get('shipping::shipping_area.item_fee')) ? '' : RC_Lang::get('shipping::shipping_area.item_fee') 
			);
			array_unshift($fields, $field );
		}
		$regions = array ();

		$region_data = RC_DB::table('area_region')->leftJoin('region', 'area_region.region_id', '=', 'region.region_id')
			->select('area_region.region_id', 'region.region_name')->where('area_region.shipping_area_id', $ship_area_id)->get();
		
		if (!empty($region_data)) {
			foreach ($region_data as $key => $val) {
				if (empty($val['region_name'])) {
					$regions[$val['region_id']] = '<lable  style="color:red">' .RC_Lang::get('shipping::shipping_area.removed_region'). '</lable>';
				} else{
					$regions[$val['region_id']] = $val['region_name'];
				}
			}
		}
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here( $shipping_data['shipping_name'], RC_Uri::url('shipping/mh_area/init', array('shipping_id' => $shipping_data['shipping_id']))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping_area.edit_area')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('shipping::shipping_area.overview'),
			'content'	=> '<p>' . RC_Lang::get('shipping::shipping_area.edit_area_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('shipping::shipping_area.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">'. RC_Lang::get('shipping::shipping_area.about_edit_area') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('shipping::shipping_area.edit_area'));
		$this->assign('area_id', $ship_area_id );
		$this->assign('fields', $fields );
		$this->assign('shipping_area', $shipping_data );
		$this->assign('regions', $regions );
		$this->assign('action_link', array('text' => $shipping_data['shipping_name'].RC_Lang::get('shipping::shipping_area.list'), 'href' => RC_Uri::url('shipping/mh_area/init', array('shipping_id' => $shipping_data['shipping_id'], 'code' => $code))));
		
		$this->assign('countries', $this->db_region->get_regions());
		$this->assign('default_country', 1);
		$this->assign('region_get_url', RC_Uri::url('shipping/region/init'));//区域联动使用
		$this->assign('form_action', RC_Uri::url('shipping/mh_area/update', array('shipping_id' => $shipping_id, 'code' => $code)));
		
		$this->assign_lang();
		$this->display('shipping_area_info.dwt');
	}
	
	public function update() {
		$this->admin_priv('ship_merchant_update', ecjia::MSGTYPE_JSON);
		
		/* 检查同类型的配送方式下有没有其他重名的配送区域 */
		$shipping_id 		= !empty($_GET['shipping_id']) ? intval($_GET['shipping_id']) : 0;
		$shipping_area_name = trim($_POST['shipping_area_name']);
		$shipping_area_id 	= !empty($_POST['id']) 	? intval($_POST['id']) 	: 0;
		$code 				= !empty($_GET['code']) ? trim($_GET['code']) 	: '';
		
		$ship_area_count = $this->db_shipping_area->is_only(array('shipping_id' => $shipping_id, 'shipping_area_name' => $shipping_area_name, 'shipping_area_id' => array('neq' => $shipping_area_id), 'store_id' => $_SESSION['store_id']));
		/*判断该配送区域是否属于该商户*/ 
		$shipping_area = $this->db_shipping_area->where(array('shipping_area_id' => $shipping_area_id, 'store_id' => $_SESSION['store_id']))->find();
		if (empty($shipping_area)) {
			return $this->showmessage('未找到相关配送区域！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($ship_area_count > 0) {
			return $this->showmessage(RC_Lang::get('shipping::shipping_area.repeat_area_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$shipping_data = $this->db_shipping->shipping_find(array('shipping_id' => $shipping_id), array('shipping_code', 'shipping_name', 'support_cod'));

			$shipping_data['configure'] = $this->db_shipping_area->shipping_area_field(array('shipping_id' => $shipping_id, 'shipping_area_name' => $shipping_area_name), 'configure');

			$config = unserialize ( $shipping_data ['configure'] );
			$shipping_handle = new shipping_factory($shipping_data['shipping_code']);
			$config = $shipping_handle->form_format($config, false);
			if (!empty($config)) {
				foreach ($config as $key => $val) {
					$config[$key]['name']   = $val['name'];
					$config[$key]['value']  = trim($_POST[$val['name']]);
				}
			}
			
			$count = count($config);
			$config[$count]['name']		= 'free_money';
			$config[$count]['value']  	= empty($_POST['free_money']) ? '0' : trim($_POST['free_money']);
			$count++;
			$config[$count]['name']		= 'fee_compute_mode';
			$config[$count]['value']	= empty($_POST['fee_compute_mode']) ? '' : trim($_POST['fee_compute_mode']);
			
			if ($shipping_data['support_cod']) {
				$count++;
				$config[$count]['name']     = 'pay_fee';
				$config[$count]['value']    =  make_semiangle(empty($_POST['pay_fee']) ? '0' : trim($_POST['pay_fee']));
			}
			
			if ($shipping_data['shipping_code'] == 'ship_o2o_express') {
				$time = array();
				foreach ($_POST['start_ship_time'] as $k => $v) {
					$time[$k]['start']	= $v;
					$time[$k]['end']	= $_POST['end_ship_time'][$k];
				}
				
				$config[$count]['name']     = 'express_money';
				$config[$count]['value']    = empty($_POST['express_money']) ? 0 : floatval($_POST['express_money']);
				$count++;
				$config[$count]['name']     = 'ship_days';
				$config[$count]['value']    = empty($_POST['ship_days']) ? '' : intval($_POST['ship_days']);
				$count++;
				$config[$count]['name']     = 'last_order_time';
				$config[$count]['value']    = empty($_POST['last_order_time']) ? '' : trim($_POST['last_order_time']);
				$count++;
				$config[$count]['name']     = 'ship_time';
				$config[$count]['value']    = empty($time) ? '' : $time;
			}
			
			$data = array(
				'shipping_area_name' 	=> $shipping_area_name,
				'configure'          	=> serialize($config)
			);	
			$this->db_shipping_area->where(array('shipping_area_id' => $shipping_area_id, 'store_id' => $_SESSION['store_id']))->update($data);

			
			ecjia_merchant::admin_log($shipping_area_name.'，'.RC_Lang::get('shipping::shipping_area.shipping_way').$shipping_data['shipping_name'], 'edit', 'shipping_area');
		
			/* 过滤掉重复的region */
			$selected_regions = array();
			if (isset($_POST['regions'])) {
				foreach ($_POST['regions'] as $region_id) {
					$selected_regions[$region_id] = $region_id;
				}
			}
		
			// 查询所有区域 region_id => parent_id	
			$data_region = $this->db_region->region_select(array('region_id', 'parent_id'));

		    foreach ($data_region as $key => $val) {
		    	$region_list[$val['region_id']] = $val['parent_id'];
		    }
			
			// 过滤掉上级存在的区域
			foreach ($selected_regions as $region_id) {
				$id = $region_id;
				while ( $region_list[$id] != 0 ) {
					$id = $region_list[$id];
					if (isset($selected_regions[$id])) {
						unset($selected_regions[$region_id]);
						break;
					}
				}
			}
			/* 清除原有的城市和地区 */

			$this->db_shipping_area_region->shipping_area_region_remove($shipping_area_id);

			/* 添加选定的城市和地区 */
			foreach ($selected_regions as $key => $val) {
				$data = array(
					'shipping_area_id' => $shipping_area_id,
					'region_id'        => $val
				);
				$this->db_shipping_area_region->shipping_area_region_insert($data);
			}
		
			$refresh_url = RC_Uri::url('shipping/mh_area/edit', array('id' => $shipping_area_id, 'shipping_id' => $shipping_id, 'code' => $code));
			return $this->showmessage(RC_Lang::get('shipping::shipping_area.edit_area') . "&nbsp;" .$shipping_area_name . "&nbsp;" . RC_Lang::get('shipping::shipping.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('refresh_url' => $refresh_url));
		}
	}
	
	/**
	 * 删除配送区域
	 */
	public function remove_area() { 
		$this->admin_priv('ship_merchant_delete', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		if ($id > 0) {
			$row = $this->db_shipping_area->shipping_area_find(array('shipping_area_id' => $id, 'store_id' => $_SESSION['store_id']));
			if (empty($row)) {
				return $this->showmessage('未找到相关配送区域！' , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$shipping_name = $this->db_shipping->shipping_field(array('shipping_id' => $row['shipping_id']), 'shipping_name');

			if (isset($row['shipping_area_id'])) {
				$this->db_shipping_area_region->shipping_area_region_remove($id);
				$this->db_shipping_area->shipping_area_remove(array('shipping_area_id' => $id));

				ecjia_merchant::admin_log($row['shipping_area_name'].'，'.RC_Lang::get('shipping::shipping_area.shipping_way').$shipping_name, 'remove', 'shipping_area');
				return $this->showmessage(RC_Lang::get('shipping::shipping_area.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		} else {
			return $this->showmessage(RC_Lang::get('shipping::shipping_area.remove_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 批量删除配送区域 pjax-post
	 */
	public function multi_remove() {
		$this->admin_priv('ship_merchant_delete', ecjia::MSGTYPE_JSON);
		
		$ids 			= !empty($_POST['area_ids']) 	? trim($_POST['area_ids']) 		: '';
		$shipping_id 	= !empty($_GET['shipping_id']) 	? intval($_GET['shipping_id']) 	: 0;
		$code 			= !empty($_GET['code']) 		? trim($_GET['code']) 			: '';
		$ids = explode(',', $ids);
		
		$row = $this->db_shipping_area->where(array('shipping_area_id' => $ids, 'store_id' => $_SESSION['store_id']))->select();
		$ids = $this->db_shipping_area->where(array('shipping_area_id' => $ids, 'store_id' => $_SESSION['store_id']))->get_field('shipping_area_id', true);
	
		if (!empty($ids)) {
			$this->db_shipping_area_region->shipping_area_region_remove($ids, true);
			$this->db_shipping_area->shipping_area_batch(array('shipping_area_id' => $ids), 'delete');
			
			if (!empty($row)) {
				foreach ($row as $v) {
					$shipping_name = $this->db_shipping->shipping_field(array('shipping_id' => $v['shipping_id']), 'shipping_name');
					ecjia_merchant::admin_log($v['shipping_area_name'].'，'.RC_Lang::get('shipping::shipping_area.shipping_way').$shipping_name, 'batch_remove', 'shipping_area');
				}
			}
			$refresh_url = RC_Uri::url('shipping/mh_area/init', array('shipping_id' => $shipping_id, 'code' => $code));
			return $this->showmessage(RC_Lang::get('shipping::shipping_area.batch_delete'). RC_Lang::get('shipping::shipping.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS , array('pjaxurl' => $refresh_url));
		} else {
			return $this->showmessage(RC_Lang::get('shipping::shipping_area.batch_no_select_falid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end
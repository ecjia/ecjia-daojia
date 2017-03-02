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
 * 开启向导入口
 * @author royalwang
 */
class admin extends ecjia_admin {
	private $db_region;
	private $db_shipping;
	private $db_shipping_area;
	private $db_shipping_area_region;
	private $db_payment;

	private $db_category;
	private $db_brand;
	private $db_goods;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_class('shipping_factory', 'shipping', false);
		RC_Loader::load_app_class('goods_image_data', 'goods', false);
		
		$this->db_region 				= RC_Loader::load_model('region_model');
		$this->db_shipping 				= RC_Loader::load_app_model('shipping_model', 'shipping');
		$this->db_shipping_area 		= RC_Loader::load_app_model('shipping_area_model', 'shipping');
		$this->db_shipping_area_region 	= RC_Loader::load_app_model('shipping_area_region_model', 'shipping');
		$this->db_payment 				= RC_Loader::load_app_model('payment_model', 'payment');
		
		$this->db_category 		= RC_Loader::load_app_model('category_model', 'goods');
		$this->db_brand 		= RC_Loader::load_app_model('brand_model', 'goods');
		$this->db_goods 		= RC_Loader::load_app_model('goods_model', 'goods');
		
		RC_Loader::load_app_func('global', 'goods');
		RC_Loader::load_app_func('global', 'shopguide');
		assign_adminlog_contents();
        
		RC_Style::enqueue_style('jquery-stepy');
		RC_Script::enqueue_script('jquery-validate');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-stepy');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-region');
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('jquery-dataTables-sorting');
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		
		RC_Script::enqueue_script('shopguide', RC_App::apps_url('statics/js/shopguide.js', __FILE__), array(), false, false);
		$shopguide_lang = array(
			'next_step'				=> RC_Lang::get('shopguide::shopguide.next_step'),
			'shop_name_required'	=> RC_Lang::get('shopguide::shopguide.shop_name_required'),
			'area_name_required' 	=> RC_Lang::get('shopguide::shopguide.area_name_required'),
			'goods_cat_required'	=> RC_Lang::get('shopguide::shopguide.goods_cat_required'),
			'goods_name_required'	=> RC_Lang::get('shopguide::shopguide.goods_name_required'),
			'store_cat_required'	=> RC_Lang::get('shopguide::shopguide.store_cat_required'),
			'pls_select'			=> RC_Lang::get('shopguide::shopguide.pls_select'),
		);
		RC_Script::localize_script('shopguide', 'js_lang', $shopguide_lang );
	}
	
    public function init() {
    	$this->admin_priv('shopguide_setup');
    	
		if (isset($_GET['step']) && $_GET['step'] > 1) {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide'), RC_Uri::url('shopguide/admin/init')));
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide')));
		}
    	
    	$this->assign('countries', $this->db_region->get_regions());
		if (ecjia::config('shop_country') > 0) {
			$this->assign('provinces', $this->db_region->get_regions(1, ecjia::config('shop_country')));
			if (ecjia::config('shop_province')) {
				$this->assign('cities', $this->db_region->get_regions(2, ecjia::config('shop_province')));
			}
		}
		
		$data['shop_name'] 		= ecjia::config('shop_name');
		$data['shop_title'] 	= ecjia::config('shop_title');
		$this->assign('data', $data);
		
		$shipping_list = RC_Api::api('shipping', 'shipping_list');
		$this->assign('shipping_list', $shipping_list);
		
		$pay_list = RC_Api::api('payment', 'pay_list');
		$this->assign('pay_list', $pay_list);
		
		$this->assign('ur_here', RC_Lang::get('shopguide::shopguide.shopguide'));
		$this->display('shop_guide.dwt');
    }
    
    public function step_post() {
    	$this->admin_priv('shopguide_setup', ecjia::MSGTYPE_JSON);
    	
    	$step = !empty($_GET['step']) ? intval($_GET['step']) : 1;
    	if ($step == 1) {
    		$shop_name 		= empty($_POST['shop_name']) 		? '' : $_POST['shop_name'] ;
    		$shop_title 	= empty($_POST['shop_title']) 		? '' : $_POST['shop_title'] ;
    		$shop_country 	= empty($_POST['shop_country']) 	? '' : intval($_POST['shop_country']);
    		$shop_province 	= empty($_POST['shop_province']) 	? '' : intval($_POST['shop_province']);
    		$shop_city 		= empty($_POST['shop_city']) 		? '' : intval($_POST['shop_city']);
    		$shop_address 	= empty($_POST['shop_address']) 	? '' : $_POST['shop_address'] ;
    		$shipping 		= empty($_POST['shipping']) 		? '' : $_POST['shipping'];
    		$payment 		= empty($_POST['payment']) 			? '' : $_POST['payment'];

    		$shipping_area_name = !empty($_POST['shipping_area_name']) ? trim($_POST['shipping_area_name']) : '';
    		
    		if (!empty($shop_name)) {
    			ecjia_config::instance()->write_config('shop_name', $shop_name);
    		} else {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.shop_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		 
    		if (!empty($shop_title)) {
    			ecjia_config::instance()->write_config('shop_title', $shop_title);
    		}
    		 
    		if (!empty($shop_address)) {
    			ecjia_config::instance()->write_config('shop_address', $shop_address);
    		}
    		 
    		if (!empty($shop_country)) {
    			ecjia_config::instance()->write_config('shop_country', $shop_country);
    		}
    		 
    		if (!empty($shop_province)) {
    			ecjia_config::instance()->write_config('shop_province', $shop_province);
    		}
    		 
    		if (!empty($shop_city)) {
    			ecjia_config::instance()->write_config('shop_city', $shop_city);
    		}

    		//添加配送区域
    		if ($shipping) {
    			if (empty($shipping_area_name)) {
    				return $this->showmessage(RC_Lang::get('shopguide::shopguide.area_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			} 
    			
	    		/* 检查同类型的配送方式下有没有重名的配送区域 */
	    		$area_count = $this->db_shipping_area->is_only(array('shipping_id' => $shipping, 'shipping_area_name' => $shipping_area_name));
	    		if ($area_count > 0) {
	    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.area_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    		} else {
	    			$shipping_data = $this->db_shipping->shipping_find(array('shipping_id' => $shipping), array('shipping_code', 'support_cod', 'shipping_name'));
	    			
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
	    			
	    			$data = array(
	    				'shipping_area_name'	=> $shipping_area_name,
	    				'shipping_id'           => $shipping,
	    				'configure'             => serialize($config)
	    			);
	    			$area_id = $this->db_shipping_area->shipping_area_manage($data);

	    			if (isset($_POST['shipping_district'])) {
	    				$region_id = intval($_POST['shipping_district']);
	    			} elseif ($_POST['shipping_city']) {
	    				$region_id = intval($_POST['shipping_city']);
	    			} elseif ($_POST['shipping_province']) {
	    				$region_id = intval($_POST['shipping_province']);
	    			} elseif ($_POST['shipping_country']) {
	    				$region_id = intval($_POST['shipping_country']);
	    			}
	    			
	    			/* 添加选定的城市和地区 */
					$arr = array(
						'shipping_area_id' 	=> $area_id,
					    'region_id' 		=> $region_id
					);
					$this->db_shipping_area_region->shipping_area_region_insert($arr);
	    		}
    		}
    		
    		//支付方式
    		if ($payment) {
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
    			$pay_config  = serialize($pay_config);
    			$array       = array('pay_config' => $pay_config);	
    			$this->db_payment->where(array('pay_code' => $payment))->update($array);
    		}
    		
    		ecjia_config::instance()->clear_cache();
    		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('shopguide/admin/init', array('step' => 2))));
    		
    	} elseif ($step == 2) {
    		$cat_name = empty($_POST['cat_name']) ? '' : trim($_POST['cat_name']);
    		$store_cat = empty($_POST['store_cat']) ? '' : trim($_POST['store_cat']);
    		
    		if (empty($cat_name)) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.goods_cat_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		if (empty($store_cat)) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.store_cat_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		$count = $this->db_category->where(array('cat_name' => $cat_name, 'parent_id' => 0))->count();
    		if ($count > 0) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.cat_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		$store_count = RC_DB::table('store_category')->where('cat_name', $cat_name)->where('parent_id', 0)->count();
    		if ($count > 0) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.store_count_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		//添加平台商品分类
    		$this->db_category->category_manage(array('cat_name' => $cat_name, 'parent_id' => 0, 'is_show' => 1));
    		
    		//添加店铺分类
    		$data = array('cat_name' => $store_cat, 'parent_id' => 0, 'is_show' => 1);
    		RC_DB::table('store_category')->insert($data);
    		
    		//添加操作日志
    		ecjia_admin::admin_log($cat_name, 'add', 'category');
    		ecjia_admin::admin_log($store_cat, 'add', 'store_category');
    		
    		return $this->showmessage(RC_Lang::get('shopguide::shopguide.complete'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('shopguide/admin/init', array('step' => 3))));
    	}
    }
    
    //获取支付方式信息
    public function get_pay() {
    	$code = !empty($_POST['code']) ? trim($_POST['code']) : '';
    	$pay  = RC_Api::api('payment', 'pay_info', array('code' => $code));
    	
    	return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $pay));
    }
}

// end
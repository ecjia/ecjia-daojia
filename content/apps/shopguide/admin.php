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
		RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url('/statics/lib/dropper-upload/jquery.fs.dropper.js'), array(), false, true);
		
		RC_Script::enqueue_script('shopguide', RC_App::apps_url('statics/js/shopguide.js', __FILE__), array(), false, false);
		RC_Style::enqueue_style('shopguide', RC_App::apps_url('statics/css/shopguide.css', __FILE__), array());
		
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
    	$step = isset($_GET['step']) ? $_GET['step'] : 1;
    	$type = isset($_GET['type']) ? $_GET['type'] : '';
    	
		if ($step > 1) {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide'), RC_Uri::url('shopguide/admin/init')));
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide')));
		}
		$data['shop_name']		= ecjia::config('shop_name');
		$data['shop_title'] 	= ecjia::config('shop_title');
		
		$data['shop_country'] 	= ecjia::config('shop_country');
		$data['shop_province'] 	= ecjia::config('shop_province');
		$data['shop_city'] 		= ecjia::config('shop_city');
		$data['shop_address'] 	= ecjia::config('shop_address');
		
		$data['company_name'] 	= ecjia::config('company_name');
		$data['service_phone'] 	= ecjia::config('service_phone');
		
		$data['qq'] 			= ecjia::config('qq');
		$data['ym'] 			= ecjia::config('ym');
		$data['msn'] 			= ecjia::config('msn');
		$data['service_email'] 	= ecjia::config('service_email');
		$data['shop_logo']		= ecjia::config('shop_logo');
		if (!empty($data['shop_logo'])) {
			$data['shop_logo'] = RC_Upload::upload_url().'/'.$data['shop_logo'];
		}
		
    	$this->assign('countries', $this->db_region->get_regions());
		if ($data['shop_country'] > 0) {
			$this->assign('provinces', $this->db_region->get_regions(1, $data['shop_country']));
			if ($data['shop_province']) {
				$this->assign('cities', $this->db_region->get_regions(2, $data['shop_province']));
			}
		}
		
		$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
		$store_cat_id = isset($_GET['store_cat_id']) ? intval($_GET['store_cat_id']) : 0;
		
		$this->assign('cat_id', $cat_id);
		$this->assign('store_cat_id', $store_cat_id);
		
		if ($step == 2 && $type == 'prev') {
			$data['cat_name'] = RC_DB::table('category')->where('cat_id', $cat_id)->pluck('cat_name');
			$data['store_cat_name'] = RC_DB::table('store_category')->where('cat_id', $store_cat_id)->pluck('cat_name');
		}
		
		if ($step == 3) {
			$shipping_list = RC_DB::table('shipping')
				->select('shipping_id', 'shipping_name', 'shipping_code', 'enabled')
				->get();
			if (!empty($shipping_list)) {
				$this->assign('shipping_list', $shipping_list);
			}
			
			$payment_list = RC_DB::table('payment')->get();
			if (!empty($payment_list)) {
				$this->assign('payment_list', $payment_list);
			}
		}

		$this->assign('data', $data);
		$this->assign('step', $step);
		$this->assign('app_url', RC_App::apps_url('statics/images', __FILE__));
		
		$this->assign('ur_here', RC_Lang::get('shopguide::shopguide.shopguide'));
		$this->display('shop_guide.dwt');
    }
    
    public function step_post() {
    	$this->admin_priv('shopguide_setup', ecjia::MSGTYPE_JSON);
    	
    	$step = !empty($_GET['step']) ? intval($_GET['step']) : 1;
    	if ($step == 1) {
    		$shop_name 		= empty($_POST['shop_name']) 		? '' : $_POST['shop_name'];
    		$shop_title 	= empty($_POST['shop_title']) 		? '' : $_POST['shop_title'];
    		$shop_country 	= empty($_POST['shop_country']) 	? '' : intval($_POST['shop_country']);
    		$shop_province 	= empty($_POST['shop_province']) 	? '' : intval($_POST['shop_province']);
    		$shop_city 		= empty($_POST['shop_city']) 		? '' : intval($_POST['shop_city']);
    		$shop_address 	= empty($_POST['shop_address']) 	? '' : $_POST['shop_address'];
    		$company_name	= empty($_POST['company_name']) 	? '' : $_POST['company_name'];
    		$service_phone  = empty($_POST['service_phone'])	? '' : $_POST['service_phone'];
    		$qq  			= empty($_POST['qq'])				? '' : $_POST['qq'];				//qq号码
    		$ym  			= empty($_POST['ym'])				? '' : $_POST['ym'];				//微信号码
    		$msn  			= empty($_POST['msn'])				? '' : $_POST['msn'];				//微博号码
    		$service_email	= empty($_POST['service_email'])	? '' : $_POST['service_email'];		//电子邮件
    		
    		if (isset($_FILES['shop_logo'])) {
    			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets/'.ecjia::config('template'), 'auto_sub_dirs' => true));
    			$image_info = $upload->upload($_FILES['shop_logo']);
    			if (empty($image_info)) {
    				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			} else {
    				$file_name = $upload->get_position($image_info);
    				ecjia_config::instance()->write_config('shop_logo', $file_name);
    			}
    		}
    		
    		if (!empty($shop_name)) {
    			ecjia_config::instance()->write_config('shop_name', $shop_name);
    		} else {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.shop_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		 
    		if (!empty($shop_title)) {
    			ecjia_config::instance()->write_config('shop_title', $shop_title);
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
    		
    		if (!empty($shop_address)) {
    			ecjia_config::instance()->write_config('shop_address', $shop_address);
    		}
    		
    		if (!empty($company_name)) {
    			ecjia_config::instance()->write_config('company_name', $company_name);
    		}
    		
    		if (!empty($service_phone)) {
    			ecjia_config::instance()->write_config('service_phone', $service_phone);
    		}
    		
    		if (!empty($qq)) {
    			ecjia_config::instance()->write_config('qq', $qq);
    		}
    		
    		if (!empty($ym)) {
    			ecjia_config::instance()->write_config('ym', $ym);
    		}
    		
    		if (!empty($msn)) {
    			ecjia_config::instance()->write_config('msn', $msn);
    		}
    		
    		if (!empty($service_email)) {
    			ecjia_config::instance()->write_config('service_email', $service_email);
    		}
    		
    		ecjia_config::instance()->clear_cache();
    		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('shopguide/admin/init', array('step' => 2))));
    		
    	} elseif ($step == 2) {
    		$cat_name = empty($_POST['cat_name']) ? '' : trim($_POST['cat_name']);
    		$store_cat = empty($_POST['store_cat']) ? '' : trim($_POST['store_cat']);
    		
    		$cat_id = empty($_POST['cat_id']) ? 0 : intval($_POST['cat_id']);
    		$store_cat_id = empty($_POST['store_cat_id']) ? 0 : intval($_POST['store_cat_id']);
    		
    		if (empty($cat_name)) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.goods_cat_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		if (empty($store_cat)) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.store_cat_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}

    		$count = RC_DB::table('category')->where('cat_name', $cat_name)->where('parent_id', 0)->where('cat_id', '!=', $cat_id)->count();
    		if ($count > 0) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.cat_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		$store_count = RC_DB::table('store_category')->where('cat_name', $store_cat)->where('parent_id', 0)->where('cat_id', '!=', $store_cat_id)->count();
    		if ($store_count > 0) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.store_cat_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		if (!empty($cat_id)) {
    			//更新平台分类
    			RC_DB::table('category')->where('cat_id', $cat_id)->update(array('cat_name' => $cat_name));
    		} else {
    			//添加平台商品分类
    			$cat_id = RC_DB::table('category')->insertGetId(array('cat_name' => $cat_name, 'parent_id' => 0, 'is_show' => 1));
    		}
    		
    		if (!empty($store_cat_id)) {
    			//更新店铺分类
    			RC_DB::table('store_category')->where('cat_id', $store_cat_id)->update(array('cat_name' => $store_cat));
    		} else {
    			//添加店铺分类
    			$data = array('cat_name' => $store_cat, 'parent_id' => 0, 'is_show' => 1);
    			$store_cat_id = RC_DB::table('store_category')->insertGetId($data);
    		}
    		
    		//添加操作日志
    		ecjia_admin::admin_log($cat_name, 'add', 'category');
    		ecjia_admin::admin_log($store_cat, 'add', 'store_category');
    		
    		$arr['step'] = 3;
    		if (!empty($cat_id)) {
    			$arr['cat_id'] = $cat_id;
    		}
    		if (!empty($store_cat_id)) {
    			$arr['store_cat_id'] = $store_cat_id;
    		}
    		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('shopguide/admin/init', $arr)));
    	} elseif ($step == 3) {
    		return $this->showmessage(RC_Lang::get('shopguide::shopguide.complete'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('shopguide/admin/init', array('step' => 4))));
    	}
    }
    
    public function drop_logo () {
    	$this->admin_priv('shopguide_setup', ecjia::MSGTYPE_JSON);
    	$shop_logo = ecjia::config('shop_logo');
    	$disk = RC_Filesystem::disk();
    	$disk->delete(RC_Upload::upload_path() . $shop_logo);
    	
    	ecjia_config::instance()->write_config('shop_logo', '');
    	return $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
}

// end
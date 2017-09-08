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
 * 入驻商家管理
 */
class admin extends ecjia_admin {
	private $db_region;
	public function __construct() {
		parent::__construct();

		$this->db_region = RC_Model::model('store/region_model');
		RC_Loader::load_app_func('global');
		RC_Loader::load_app_func('merchant_store');
		assign_adminlog_content();

		//全局JS和CSS
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-editable.min',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');

		RC_Style::enqueue_style('splashy');

        RC_Script::enqueue_script('jquery-range', RC_App::apps_url('statics/js/jquery.range.js', __FILE__));
        RC_Style::enqueue_style('range', RC_App::apps_url('statics/css/range.css', __FILE__), array());
        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        RC_Script::enqueue_script('store', RC_App::apps_url('statics/js/store.js', __FILE__));
		RC_Script::enqueue_script('store_log', RC_App::apps_url('statics/js/store_log.js', __FILE__));
		RC_Script::enqueue_script('commission_info',RC_App::apps_url('statics/js/commission.js' , __FILE__));
		RC_Script::enqueue_script('region',RC_Uri::admin_url('statics/lib/ecjia-js/ecjia.region.js'));
		RC_Script::enqueue_script('qq_map', 'https://map.qq.com/api/js?v=2.exp');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('store::store.store'), RC_Uri::url('store/admin/init')));
	}

	/**
	 * 自营商家
	 */
	public function init() {
	    $this->admin_priv('store_self_manage');

	    ecjia_screen::get_current_screen()->remove_last_nav_here();
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('自营店铺'));

	    $this->assign('ur_here', '自营店铺列表');
		$manage_mode = 'self';
	    $store_list = $this->store_list($manage_mode);
	    $cat_list   = $this->get_cat_select_list();

	    $this->assign('cat_list', $cat_list);
	    $this->assign('store_list', $store_list);
	    $this->assign('filter', $store_list['filter']);
	    $this->assign('action_link', array('text' => '添加自营商家', 'href'=>RC_Uri::url('store/admin/add')));
	    $this->assign('manage_mode', $manage_mode);
	    
	    $this->assign('search_action',RC_Uri::url('store/admin/init'));

	    $this->display('store_list.dwt');
	}
	
	/**
	 * 入驻商家列表
	 */
	public function join() {
		$this->admin_priv('store_affiliate_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('入驻商家'));
		$this->assign('ur_here', '入驻商家列表');
		
		$manage_mode = 'join';
		$store_list = $this->store_list($manage_mode);
		$cat_list   = $this->get_cat_select_list();
	
		$this->assign('cat_list', $cat_list);
		$this->assign('store_list', $store_list);
		$this->assign('filter', $store_list['filter']);
		$this->assign('manage_mode', $manage_mode);
	
		$this->assign('search_action',RC_Uri::url('store/admin/join'));
	
		$this->display('store_list.dwt');
	}

	
	/**
	 * 添加自营商家
	 */
	public function add() {
	    $this->admin_priv('store_affiliate_add', ecjia::MSGTYPE_JSON);
	    
	    $this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加自营商家'));
	    $this->assign('ur_here', '添加自营商家');
	    
	    $cat_list = $this->get_cat_select_list();
	    $province   = $this->db_region->get_regions(1, 1);
	    $city       = $this->db_region->get_regions(2, $store['province']);
	    $district   = $this->db_region->get_regions(3, $store['city']);
	    
	    $this->assign('province', $province);
	    $this->assign('city', $city);
	    $this->assign('district', $district);
	    $this->assign('form_action', RC_Uri::url('store/admin/insert'));
	    
	    $this->assign('cat_list', $cat_list);
	    
	    $this->display('store_add.dwt');
	}
	
	/**
	 * 添加自营商家
	 */
	public function insert() {
	    $this->admin_priv('store_affiliate_add', ecjia::MSGTYPE_JSON);
	    
	    $store_id = intval($_POST['store_id']);

	    $data = array(
	        'cat_id'   	   				=> !empty($_POST['store_cat']) 		    ? $_POST['store_cat']          : 0,
	        'merchants_name'   			=> !empty($_POST['merchants_name'])     ? $_POST['merchants_name']     : '',
	        'shop_keyword'      		=> !empty($_POST['shop_keyword']) 	    ? $_POST['shop_keyword']       : '',
	        'email'      				=> !empty($_POST['email']) 				? $_POST['email']              : '',
	        'contact_mobile'    		=> !empty($_POST['contact_mobile']) 	? $_POST['contact_mobile']     : '',
	        'address'      				=> !empty($_POST['address']) 			? $_POST['address']            : '',
	        'province'					=> !empty($_POST['province'])			? $_POST['province']           : 0,
	        'city'						=> !empty($_POST['city'])				? $_POST['city']               : 0,
	        'district'					=> !empty($_POST['district'])			? $_POST['district']           : 0,
	        'longitude'					=> !empty($_POST['longitude'])			? $_POST['longitude']          : '',
	        'latitude'					=> !empty($_POST['latitude'])			? $_POST['latitude']           : '',
	        'manage_mode'				=> 'self',
	        'shop_close'				=> isset($_POST['shop_close'])			? $_POST['shop_close']         : 1,
	    );
	    
	    if (empty($data['merchants_name'])) {
	        return $this->showmessage('店铺名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if ( empty($data['cat_id'])) {
	        return $this->showmessage('请选择商家分类', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if (empty($data['contact_mobile'])) {
	        return $this->showmessage('联系手机不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $chars = "/^1(3|4|5|7|8)\d{9}$/";
	    if (!preg_match($chars, $data['contact_mobile'])) {
	        return $this->showmessage('手机号码格式错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if ( empty($data['email'])) {
	        return $this->showmessage('邮箱不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if ( empty($data['province']) || empty($data['city']) || empty($data['district'])) {
	        return $this->showmessage('请选择地区', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if ( empty($data['address'])) {
	        return $this->showmessage('请填写通讯地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if ( empty($data['latitude']) || empty($data['longitude']) ) {
	        return $this->showmessage('请获取坐标', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $is_exist = RC_DB::table('store_franchisee')->where('merchants_name', $data['merchants_name'])->get();
	    if ($is_exist) {
	        return $this->showmessage('店铺名称已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $is_exist = RC_DB::table('store_franchisee')->where('contact_mobile', $data['contact_mobile'])->get();
	    if ($is_exist) {
	        return $this->showmessage('联系手机已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $is_exist = RC_DB::table('staff_user')->where('mobile', $data['contact_mobile'])->get();
	    if ($is_exist) {
	        return $this->showmessage('联系手机员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $is_exist = RC_DB::table('store_franchisee')->where('email', $data['email'])->get();
	    if ($is_exist) {
	        return $this->showmessage('邮箱已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $is_exist = RC_DB::table('staff_user')->where('email', $data['email'])->get();
	    if ($is_exist) {
	        return $this->showmessage('邮箱员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $geohash         = RC_Loader::load_app_class('geohash', 'store');
	    $geohash_code    = $geohash->encode($data['latitude'] , $data['longitude']);
	    $geohash_code    = substr($geohash_code, 0, 10);
	    $data['geohash'] = $geohash_code;
	    
	    $store_id = RC_DB::table('store_franchisee')->insertGetId($data);
	    if ($store_id) {
	        //审核通过产生店铺中的code
	        $merchant_config = array(
	            'shop_logo' ,                 // 默认店铺页头部LOGO
	            'shop_nav_background',        // 店铺导航背景图
	            'shop_banner_pic' ,           // app banner图
	            'shop_kf_mobile' ,            // 客服手机号码
	            'shop_trade_time' ,           // 营业时间
	            'shop_description' ,          // 店铺描述
	            'shop_notice'   ,             // 店铺公告
	            'shop_review_goods',          // 店铺商品审核状态，平台开启审核时店铺优先级高于平台设置
	            'express_assign_auto',		  // o2o配送自动派单开关
	        );
	        $merchants_config = RC_DB::table('merchants_config');
	        foreach ($merchant_config as $val) {
	            $count= $merchants_config->where(RC_DB::raw('store_id'), $store_id)->where(RC_DB::raw('code'), $val)->count();
	            if ($count == 0) {
	                $merchants_config->insert(array('store_id' => $store_id, 'code' => $val));
	            }
	        }
	        
	        //审核通过产生一个主员工的资料
	        $password	= rand(100000,999999);
	        $salt = rand(1, 9999);
	        $data_staff = array(
	            'mobile' 		=> $data['contact_mobile'],
	            'store_id' 		=> $store_id,
	            'name' 			=> $data['merchants_name'].'店长',
	            'nick_name' 	=> '',
	            'user_ident' 	=> 'SC001',
	            'email' 		=> $data['email'],
	            'password' 		=> md5(md5($password) . $salt),
	            'salt'			=> $salt,
	            'add_time' 		=> RC_Time::gmtime(),
	            'last_ip' 		=> '',
	            'action_list' 	=> 'all',
	            'todolist' 		=> '',
	            'parent_id' 	=> 0,
	            'avatar' 		=> '',
	            'introduction' 	=> '',
	        );
	        $staff = RC_DB::table('staff_user')->insertGetId($data_staff);
	        if (! $staff) {
	            return $this->showmessage('店长账号添加失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	        //短信发送通知
	        $options = array(
        		'mobile' => $data['contact_mobile'],
        		'event'	 => 'sms_self_merchant',
        		'value'  =>array(
        			'shop_name' => ecjia::config('shop_name'),
        			'account'	=> $data['contact_mobile'],
        			'password'	=> $password,
        			'service_phone'=> ecjia::config('service_phone'),
        		),
	        );
	        $response = RC_Api::api('sms', 'send_event_sms', $options);
	        if (is_ecjia_error($response)) {
	        	return $this->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	    } else {
	        return $this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
		ecjia_admin::admin_log('添加商家：'.$data['merchants_name'], 'add', 'store');
		return $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/edit', array('store_id' => $store_id, 'step' => 'base'))));
	    
	}
	/**
	 * 编辑入驻商
	 */
	public function edit() {
		$this->admin_priv('store_affiliate_update', ecjia::MSGTYPE_JSON);

		$this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑入驻商'));

		$store_id = intval($_GET['store_id']);
        $menu     = set_store_menu($store_id);
		$store    = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
		$store['apply_time']	= RC_Time::local_date(ecjia::config('time_format'), $store['apply_time']);
		$store['confirm_time']	= RC_Time::local_date(ecjia::config('time_format'), $store['confirm_time']);
		$store['expired_time']	= RC_Time::local_date('Y-m-d', $store['expired_time']);
		$cat_list = $this->get_cat_select_list();
		$certificates_list = array(
				'1' => RC_Lang::get('store::store.people_id'),
				'2' => RC_Lang::get('store::store.passport'),
				'3' => RC_Lang::get('store::store.hong_kong_and_macao_pass')
		);

		$province   = $this->db_region->get_regions(1, 1);
		$city       = $this->db_region->get_regions(2, $store['province']);
		$district   = $this->db_region->get_regions(3, $store['city']);

        $this->assign('province', $province);
		$this->assign('city', $city);
		$this->assign('district', $district);

		$this->assign('cat_list', $cat_list);
		$this->assign('menu', $menu);
		$this->assign('certificates_list', $certificates_list);

		$store['shop_review_goods'] = get_merchant_config($store_id, 'shop_review_goods');
		$this->assign('store', $store);
		$this->assign('form_action', RC_Uri::url('store/admin/update'));
		$this->assign('longitudeForm_action', RC_Uri::url('store/admin/get_longitude'));
		$this->assign('step', $_GET['step']);
		$this->assign('ur_here', $store['merchants_name']. ' - ' .RC_Lang::get('store::store.store_update'));

		$this->display('store_edit.dwt');
	}

	/**
	 * 编辑入驻商数据更新
	 */
	public function update() {
		$this->admin_priv('store_affiliate_update', ecjia::MSGTYPE_JSON);

		$store_id = intval($_POST['store_id']);
		$step     = trim($_POST['step']);
		if (! in_array($step, array('base', 'identity', 'bank', 'pic'))) {
		    return $this->showmessage('操作异常，请检查', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();

		if (!$store_info) {
		    return $this->showmessage('店铺信息不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if ($step == 'base') {
		    $data = array(
		        'cat_id'   	   				=> !empty($_POST['store_cat']) 		    ? $_POST['store_cat']          : '',
		        'merchants_name'   			=> !empty($_POST['merchants_name'])     ? $_POST['merchants_name']     : '',
		        'shop_keyword'      		=> !empty($_POST['shop_keyword']) 	    ? $_POST['shop_keyword']       : '',
		        'email'      				=> !empty($_POST['email']) 				? $_POST['email']              : '',
		        'contact_mobile'    		=> !empty($_POST['contact_mobile']) 	? $_POST['contact_mobile']     : '',
		        'address'      				=> !empty($_POST['address']) 			? $_POST['address']            : '',
		        'province'					=> !empty($_POST['province'])			? $_POST['province']           : '',
		        'city'						=> !empty($_POST['city'])				? $_POST['city']               : '',
		        'district'					=> !empty($_POST['district'])			? $_POST['district']           : '',
		        'longitude'					=> !empty($_POST['longitude'])			? $_POST['longitude']          : '',
		        'latitude'					=> !empty($_POST['latitude'])			? $_POST['latitude']           : '',
		        'manage_mode'				=> !empty($_POST['manage_mode'])		? $_POST['manage_mode']        : 'join',
		        'shop_close'				=> isset($_POST['shop_close'])			? $_POST['shop_close']         : 1,
		        'expired_time'              => !empty($_POST['expired_time'])		? RC_Time::local_strtotime($_POST['expired_time']) : 0,
		    );

			if($_POST['shop_close'] == '1'){
				clear_cart_list($store_id);
			}
		    if ($store_info['identity_status'] != 2 && $data['shop_close'] == 0 && ecjia::config('store_identity_certification') == 1) {
		        return $this->showmessage('未认证通过不能开启店铺', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
		    if (empty($data['merchants_name'])) {
		        return $this->showmessage('店铺名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
		    if (empty($data['contact_mobile'])) {
		        return $this->showmessage('联系手机不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
		    if ( empty($data['email'])) {
		        return $this->showmessage('邮箱不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
		    
		    $is_exist = RC_DB::table('store_franchisee')->where('store_id', '<>', $store_id)->where('merchants_name', $data['merchants_name'])->get();
		    if ($is_exist) {
		        return $this->showmessage('店铺名称已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
		    $is_exist = RC_DB::table('store_franchisee')->where('store_id', '<>', $store_id)->where('contact_mobile', $data['contact_mobile'])->get();
		    if ($is_exist) {
		        return $this->showmessage('联系手机已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
		    $is_exist = RC_DB::table('store_franchisee')->where('store_id', '<>', $store_id)->where('email', $data['email'])->get();
		    if ($is_exist) {
		        return $this->showmessage('邮箱已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
		    $is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('mobile', $data['contact_mobile'])->get();
		    if ($is_exist) {
		        return $this->showmessage('联系手机员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
		    $is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('email', $data['email'])->get();
		    if ($is_exist) {
		        return $this->showmessage('邮箱员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    }
            $geohash         = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code    = $geohash->encode($_POST['latitude'] , $_POST['longitude']);
            $geohash_code    = substr($geohash_code, 0, 10);
            $data['geohash'] = $geohash_code;

            set_merchant_config($store_id, 'shop_review_goods', $_POST['shop_review_goods']);
			
            $store_franchisee_db = RC_Model::model('store/orm_store_franchisee_model');
            /* 释放app缓存*/
            $store_cache_array = $store_franchisee_db->get_cache_item('store_list_cache_key_array');
            if (!empty($store_cache_array)) {
            	foreach ($store_cache_array as $val) {
            		$store_franchisee_db->delete_cache_item($val);
            	}
            	$store_franchisee_db->delete_cache_item('store_list_cache_key_array');
            }
            
		} else if ($step == 'identity') {
		    $data = array(
		        'responsible_person'		=> !empty($_POST['responsible_person'])     ? $_POST['responsible_person']   : '',
		        'company_name'      		=> !empty($_POST['company_name']) 		    ? $_POST['company_name']         : '',
		        'identity_type'     		=> !empty($_POST['identity_type']) 		    ? $_POST['identity_type']        : '',
		        'identity_number'   		=> !empty($_POST['identity_number']) 	    ? $_POST['identity_number']      : '',
		        'business_licence'      	=> !empty($_POST['business_licence']) 		? $_POST['business_licence']     : '',
		    );
		} else if ($step == 'bank') {
		    $data = array(
		        'bank_account_name'  		=> !empty($_POST['bank_account_name']) 	    ? $_POST['bank_account_name']    : '',
		        'bank_name'      	  	 	=> !empty($_POST['bank_name']) 				? $_POST['bank_name']            : '',
		        'bank_branch_name'     		=> !empty($_POST['bank_branch_name']) 		? $_POST['bank_branch_name']     : '',
		        'bank_account_number'  		=> !empty($_POST['bank_account_number'])	? $_POST['bank_account_number']  : '',
		        'bank_address'         		=> !empty($_POST['bank_address']) 			? $_POST['bank_address']         : '',
		    );
		} else if ($step == 'pic') {
		    if (!empty($_FILES['one']['name'])) {
		        $upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
		        $info = $upload->upload($_FILES['one']);
		        if (!empty($info)) {
		            $business_licence_pic = $upload->get_position($info);
		            $upload->remove($store_info['business_licence_pic']);
		        } else {
		            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		    } else {
		        $business_licence_pic = $store_info['business_licence_pic'];
		    }

		    if (!empty($_FILES['two']['name'])) {
		        $upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
		        $info = $upload->upload($_FILES['two']);
		        if (!empty($info)) {
		            $identity_pic_front = $upload->get_position($info);
		            $upload->remove($store_info['identity_pic_front']);
		        } else {
		            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		    } else {
		        $identity_pic_front = $store_info['identity_pic_front'];
		    }

		    if (!empty($_FILES['three']['name'])) {
		        $upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
		        $info = $upload->upload($_FILES['three']);
		        if (!empty($info)) {
		            $identity_pic_back = $upload->get_position($info);
		            $upload->remove($store_info['identity_pic_back']);
		        } else {
		            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		    } else {
		        $identity_pic_back = $store_info['identity_pic_back'];
		    }

		    if (!empty($_FILES['four']['name'])) {
		        $upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
		        $info = $upload->upload($_FILES['four']);
		        if (!empty($info)) {
		            $personhand_identity_pic = $upload->get_position($info);
		            $upload->remove($store_info['personhand_identity_pic']);
		        } else {
		            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		    } else {
		        $personhand_identity_pic = $store_info['personhand_identity_pic'];
		    }

		    $data = array(
		        'identity_pic_front'		=> $identity_pic_front,
		        'identity_pic_back' 		=> $identity_pic_back,
		        'personhand_identity_pic' 	=> $personhand_identity_pic,
		        'business_licence_pic' 		=> $store_info['validate_type']  == 2 ? $business_licence_pic : null,
		    );
		}



		/* $data = array(
			'cat_id'   	   				=> !empty($_POST['store_cat']) 		? $_POST['store_cat'] : '',
			'merchants_name'   			=> !empty($_POST['merchants_name']) ? $_POST['merchants_name'] : '',
			'shop_keyword'      		=> !empty($_POST['shop_keyword']) 	? $_POST['shop_keyword'] : '',
			'responsible_person'		=> !empty($_POST['responsible_person']) ? $_POST['responsible_person'] : '',
			'company_name'      		=> !empty($_POST['company_name']) 		? $_POST['company_name'] : '',
			'email'      				=> !empty($_POST['email']) 				? $_POST['email'] : '',
			'contact_mobile'    		=> !empty($_POST['contact_mobile']) 	? $_POST['contact_mobile'] : '',
			'address'      				=> !empty($_POST['address']) 			? $_POST['address'] : '',
			'identity_type'     		=> !empty($_POST['identity_type']) 		? $_POST['identity_type'] : '',
			'identity_number'   		=> !empty($_POST['identity_number']) 	? $_POST['identity_number'] : '',
			'identity_pic_front'		=> $identity_pic_front,
			'identity_pic_back' 		=> $identity_pic_back,
			'personhand_identity_pic' 	=> $personhand_identity_pic,
			'bank_account_name'  		=> !empty($_POST['bank_account_name']) 	? $_POST['bank_account_name'] : '',
			'business_licence_pic' 		=> $store_info['validate_type']  == 2 ? $business_licence_pic : null,
			'business_licence'      	=> !empty($_POST['business_licence']) 		? $_POST['business_licence'] : '',
			'bank_name'      	  	 	=> !empty($_POST['bank_name']) 				? $_POST['bank_name'] : '',
			'bank_branch_name'     		=> !empty($_POST['bank_branch_name']) 		? $_POST['bank_branch_name'] : '',
			'bank_account_number'  		=> !empty($_POST['bank_account_number'])	? $_POST['bank_account_number'] : '',
			'province'					=> !empty($_POST['province'])				? $_POST['province'] : '',
			'city'						=> !empty($_POST['city'])					? $_POST['city'] : '',
		    'district'					=> !empty($_POST['district'])				? $_POST['district'] : '',
			'bank_address'         		=> !empty($_POST['bank_address']) 			? $_POST['bank_address'] : '',
		); */

		$sn =  RC_DB::table('store_franchisee')->where('store_id', $store_id)->update($data);
		ecjia_admin::admin_log(RC_Lang::get('store::store.edit_store').' '.RC_Lang::get('store::store.store_title_lable').$store_info['merchants_name'], 'update', 'store');
		return $this->showmessage(RC_Lang::get('store::store.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,
		    array('pjaxurl' => RC_Uri::url('store/admin/edit', array('store_id' => $store_id, 'step' => $step))));
	}

	/**
	 * 查看商家详细信息
	 */
	public function preview() {
		$this->admin_priv('store_affiliate_manage');
		$store_id = intval($_GET['store_id']);
		
		$store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
		if ($store['manage_mode']== 'self' && $_SESSION['action_list'] == 'all') {
			$this->assign('action_link_self',array('href' => RC_Uri::url('store/admin/autologin',array('store_id' => $store_id)),'text' => '进入商家后台'));
		}
		$this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('基本信息'));

       
        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $menu = set_store_menu($store_id, 'preview');


		$store['apply_time']	= RC_Time::local_date(ecjia::config('time_format'), $store['apply_time']);
		$store['confirm_time']	= RC_Time::local_date(ecjia::config('time_format'), $store['confirm_time']);
		$store['expired_time']	= RC_Time::local_date('Y-m-d', $store['expired_time']);

		$store['province']      = RC_DB::table('region')->where('region_id', $store['province'])->pluck('region_name');
		$store['city']          = RC_DB::table('region')->where('region_id', $store['city'])->pluck('region_name');
		$store['district']      = RC_DB::table('region')->where('region_id', $store['district'])->pluck('region_name');

		$this->assign('ur_here', $store['merchants_name']);
		$store['cat_name'] = RC_DB::table('store_category')->where('cat_id', $store['cat_id'])->select('cat_name')->pluck();
		if ($store['percent_id']) {
		    $store['percent_value'] = RC_DB::table('store_percent')->where('percent_id', $store['percent_id'])->select('percent_value')->pluck();
		}
		
		$this->assign('store', $store);
		$this->assign('menu', $menu);
		
		$this->display('store_preview.dwt');
	}
	
	//自营商家自动登录
	public function autologin() {
		$store_id = intval($_GET['store_id']);
		$store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
		if ($store['manage_mode']=='self' && $_SESSION['action_list'] == 'all') {
			$cookie_name = RC_Config::get('session.session_admin_name');
			$authcode_array = array(
				'admin_token' => RC_Cookie::get($cookie_name),
				'store_id'    => $store_id,
				'time' 		  => RC_Time::gmtime()
			);
			$authcode_str = http_build_query($authcode_array);
			$authcode = RC_Crypt::encrypt($authcode_str);
			$url = str_replace("index.php","sites/merchant/index.php", RC_Uri::url('staff/privilege/autologin')).'&authcode='.$authcode;
			return $this->redirect($url);
		}
	}

	//店铺设置
	public function store_set() {
	    $this->admin_priv('store_set_manage');

        $this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('店铺设置'));
        $store_id = intval($_GET['store_id']);
        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $this->assign('ur_here', $store['merchants_name'].' - 店铺设置');
        $this->assign('store_name', $store['merchants_name']);
        $menu = set_store_menu($store_id, 'store_set');

        $store_info = get_merchant_info($store_id, $arr);
        $this->assign('menu', $menu);
        $this->assign('store_info', $store_info);
	    $this->display('store_set.dwt');
	}

	//店铺设置修改
	public function store_set_edit() {
	    $this->admin_priv('store_set_update');

        $this->assign('action_link',array('href' => RC_Uri::url('store/admin/store_set', array('store_id' => $_GET['store_id'])),'text' => '店铺设置'));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑入驻商'));
        $store_id = intval($_GET['store_id']);
        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $this->assign('store_name', $store['merchants_name']);
        $menu = set_store_menu($store_id, 'store_set');

        $store_info = get_merchant_info($store_id, $arr);
        $this->assign('menu', $menu);
        $this->assign('store_info', $store_info);
        $this->assign('form_action', RC_Uri::url('store/admin/store_set_update'));
        $this->assign('ur_here', $store['merchants_name']. ' - ' .RC_Lang::get('store::store.store_update'));
        $this->display('store_merchant_edit.dwt');
	}

	//店铺设置修改
	public function store_set_update() {
	    $this->admin_priv('store_set_update', ecjia::MSGTYPE_JSON);

        $store_id = intval($_POST['store_id']);
        if(empty($store_id)){
            return $this->showmessage('参数错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $shop_kf_mobile         = empty($_POST['shop_kf_mobile'])	? '' : htmlspecialchars($_POST['shop_kf_mobile']);
        $shop_description       = empty($_POST['shop_description'])	? '' : htmlspecialchars($_POST['shop_description']);
        $shop_trade_time        = empty($_POST['shop_trade_time'])	? '' : htmlspecialchars($_POST['shop_trade_time']);
        $shop_notice            = empty($_POST['shop_notice'])		? '' : htmlspecialchars($_POST['shop_notice']);

        $merchant_config = array();

        // 店铺导航背景图
        if(!empty($_FILES['shop_nav_background']) && empty($_FILES['error']) && !empty($_FILES['shop_nav_background']['name'])){
        	$merchants_config['shop_nav_background'] = store_file_upload_info('shop_nav_background', '', $shop_nav_background, $store_id);
        }
        // 默认店铺页头部LOGO
        if(!empty($_FILES['shop_logo']) && empty($_FILES['error']) && !empty($_FILES['shop_logo']['name'])){
            $merchants_config['shop_logo'] = store_file_upload_info('shop_logo', '', $shop_logo, $store_id);
            
            //删除生成的店铺二维码
            $disk = RC_Filesystem::disk();
            $store_qrcode = 'data/qrcodes/merchants/merchant_'.$store_id.'.png';
            if ($disk->exists(RC_Upload::upload_path($store_qrcode))) {
            	$disk->delete(RC_Upload::upload_path().$store_qrcode);
            }
        }

        // APPbanner图
        if(!empty($_FILES['shop_banner_pic']) && empty($_FILES['error']) && !empty($_FILES['shop_banner_pic']['name'])){
            $merchants_config['shop_banner_pic'] = store_file_upload_info('shop_banner', 'shop_banner_pic', $shop_banner_pic, $store_id);
        }
        // 如果没有上传店铺LOGO 提示上传店铺LOGO
        $shop_logo = get_merchant_config($store_id, 'shop_logo');

        if(empty($shop_logo) && empty($merchants_config['shop_logo'])){
            return $this->showmessage('请上传店铺LOGO', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $merchants_config['shop_description'] = $shop_description;// 店铺描述
        $time = array();
        if(!empty($shop_trade_time)){
            $shop_time      = explode(',', $shop_trade_time);
            //营业时间验证
            if($shop_time[0] >= 1440) {
                return $this->showmessage('营业开始时间不能为次日', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if($shop_time[1] - $shop_time[0] > 1440) {
                return $this->showmessage('营业时间最多为24小时', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if(($shop_time[1] - $shop_time[0] == 1440) && ($shop_time[0] != 0)) {
                return $this->showmessage('24小时营业请选择0-24', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $s_h = ($shop_time[0] / 60);
            $s_i = ($shop_time[0] % 60);
            $e_h = ($shop_time[1] / 60);
            $e_i = ($shop_time[1] % 60);
            $start_h        = empty($s_h)? '00' : intval($s_h);
            $start_i        = empty($s_i)? '00' : intval($s_i);
            $end_h          = empty($e_h)? '00' : intval($e_h);
            $end_i          = empty($e_i)? '00' : intval($e_i);
            $start_time     = $shop_time[0] == 0 ? '00:00' : $start_h.":".$start_i;
            $end_time       = $end_h.":".$end_i;
            $time['start']  = $start_time;
            $time['end']    = $end_time;
            $shop_trade_time = serialize($time);
            if($shop_trade_time != get_merchant_config('shop_trade_time')){
                $merchants_config['shop_trade_time'] = $shop_trade_time;// 营业时间
            }
        }
       	$merchants_config['shop_notice'] = $shop_notice;// 店铺公告
        $merchants_config['shop_kf_mobile'] = $shop_kf_mobile;// 客服电话
        
        if (!empty($merchants_config)) {
            $merchant = set_merchant_config($store_id, '', '', $merchants_config);
        } else {
            return $this->showmessage('您没有做任何修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (!empty($merchant)) {
        	$store_franchisee_db = RC_Model::model('store/orm_store_franchisee_model');
        	/* 释放app缓存*/
        	$store_cache_array = $store_franchisee_db->get_cache_item('store_list_cache_key_array');
        	if (!empty($store_cache_array)) {
        		foreach ($store_cache_array as $val) {
        			$store_franchisee_db->delete_cache_item($val);
        		}
        		$store_franchisee_db->delete_cache_item('store_list_cache_key_array');
        	}
            // 记录日志
            ecjia_admin::admin_log('修改店铺基本信息', 'edit', 'merchant');
            return $this->showmessage('编辑成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/store_set_edit', array('store_id' => $store_id))));
        }
	}

	/**
	 * 资质认证
	 */
	public function auth() {
	    $this->admin_priv('store_auth_manage');

	    $this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('资质认证'));
	    $store_id = intval($_GET['store_id']);
	    if (empty($store_id)) {
	        return $this->showmessage(__('请选择您要操作的店铺'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }

	    $menu = set_store_menu($store_id, 'auth');

	    $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();

	    $this->assign('ur_here', $store['merchants_name']. ' - 资质认证');
	    $this->assign('form_action', RC_Uri::url('store/admin/auth_update'));
	    $this->assign('store', $store);
	    $this->assign('menu', $menu);
	    $this->display('store_auth.dwt');
	}

	public function auth_update() {
	    $this->admin_priv('store_auth_manage', ecjia::MSGTYPE_JSON);

	    $store_id = intval($_POST['store_id']);
	    if(empty($store_id)) {
	        return $this->showmessage('参数错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }

	    //0、待审核，1、审核中，2、审核通过，3、拒绝通过',
	    $data = array();
	    if (isset($_POST['check_ing'])) {
	        $data['identity_status'] = 1;
	    }
	    if (isset($_POST['check_no'])) {
	        $data['identity_status'] = 3;
	    }
	    if (isset($_POST['check_yes'])) {
	        $data['identity_status'] = 2;
	    }

	    if (RC_DB::table('store_franchisee')->where('store_id', $store_id)->update($data)) {
	        return $this->showmessage('操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/auth', array('store_id' => $store_id))));
	    } else {
	        return $this->showmessage('操作失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	}

	/**
	 * 查看员工
	 */
	public function view_staff() {
		$this->admin_priv('store_staff_manage');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('store::store.view_staff')));

		$store_id     = intval($_GET['store_id']);
		$main_staff   = RC_DB::table('staff_user')->where('store_id', $store_id)->where('parent_id', 0)->first();
		$store        = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
		$parent_id    = $main_staff['user_id'];
        $menu         = set_store_menu($store_id, 'view_staff');
		$staff_list   = RC_DB::table('staff_user')->where('parent_id', $parent_id)->get();
		
        $main_staff['avatar'] = !empty($main_staff['avatar'])? RC_Upload::upload_url($main_staff['avatar']) : RC_App::apps_url('statics/images/ecjia_avatar.jpg', __FILE__);
        $main_staff['add_time'] = RC_Time::local_date('Y-m-d', $main_staff['add_time']);
        foreach($staff_list as $key => $val){
            $staff_list[$key]['add_time'] = RC_Time::local_date('Y-m-d', $val['add_time']);
        }

		$this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
		$this->assign('ur_here',$store['merchants_name'].' - '.RC_Lang::get('store::store.view_staff'));
		$this->assign('main_staff', $main_staff);
		$this->assign('staff_list', $staff_list);
		$this->assign('current_url', RC_Uri::current_url());

		$this->assign('store', $store);
		$this->assign('menu', $menu);
		$this->display('store_staff.dwt');
	}
	
	public function edit_staff() {
	    $this->admin_priv('store_staff_edit');
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑店长'));
	    
	    $store_id     = intval($_GET['store_id']);
	    $main_staff   = intval($_GET['main_staff']);
	    $store        = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
	    if (empty($store)) {
	        return $this->showmessage('店铺信息不存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
	    $this->assign('ur_here',$store['merchants_name'].' - 编辑店长');
	    
	    $this->assign('store', $store);
	    $menu         = set_store_menu($store_id, 'view_staff');
	    $this->assign('menu', $menu);
	    
	    if ($main_staff == 1) {
	        //店长
	        $info   = RC_DB::table('staff_user')->where('store_id', $store_id)->where('parent_id', 0)->first();
	    }
	    $this->assign('info', $info);
	    $this->assign('form_action',  RC_Uri::url('store/admin/update_staff'));
	    
	    $this->display('store_staff_edit.dwt');
	}
	
	public function update_staff() {
	    $this->admin_priv('store_staff_edit');
	    
	    $store_id     = intval($_POST['store_id']);
	    $staff_id   = intval($_POST['staff_id']);
	    $user_name = trim($_POST['user_name']);
	    $mobile = trim($_POST['contact_mobile']);
	    $email = trim($_POST['email']);
	    $user_ident = trim($_POST['user_ident']);
	    $nick_name = trim($_POST['nick_name']);
	    $introduction = trim($_POST['introduction']);
	    $store        = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
	    if (empty($user_name)) {
	        return $this->showmessage('店铺信息不存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    if (empty($user_name)) {
	        return $this->showmessage('姓名不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    if (empty($mobile)) {
	        return $this->showmessage('联系手机不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $chars = "/^1(3|4|5|7|8)\d{9}$/";
	    if (!preg_match($chars, $mobile)) {
	        return $this->showmessage('手机号码格式错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if ( empty($email)) {
	        return $this->showmessage('邮箱不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('mobile', $mobile)->get();
	    if ($is_exist) {
	        return $this->showmessage('联系手机员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('email', $email)->get();
	    if ($is_exist) {
	        return $this->showmessage('邮箱员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $data = array(
	        'mobile' => $mobile,
	        'name' => $user_name,
	        'email' => $email,
	        'user_ident' => $user_ident,
	        'nick_name' => $nick_name,
	        'introduction' => $introduction
	    );
	    
	    $rs = RC_DB::table('staff_user')->where('store_id', $store_id)->where('user_id', $staff_id)->update($data);
	    if ($rs) {
	        return $this->showmessage('更新成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/view_staff', array('store_id' => $store_id))));
	    } else {
	        return $this->showmessage('更新失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    
	}
	
	public function reset_staff() {
	    $this->admin_priv('store_staff_reset');
	    
	    $store_id     = intval($_GET['store_id']);
	    $main_staff   = intval($_GET['main_staff']);
	    if ($main_staff == 1) {
	        //店长
	        $info   = RC_DB::table('staff_user')->where('store_id', $store_id)->where('parent_id', 0)->first();
	    }
	    
	    if(info) {
	        $password = rand(100000,999999);
	        //短信发送通知
	        $options = array(
	            'mobile' => $info['mobile'],
	            'event'	 => 'sms_staff_reset_password',
	            'value'  =>array(
	                'user_name' => $info['name'],
	                'account'	=> $info['mobile'],
	                'password'	=> $password,
	                'service_phone' => ecjia::config('service_phone'),
	            ),
	        );
	        RC_Api::api('sms', 'send_event_sms', $options);
	        $salt = rand(1, 9999);
	        $data_staff = array(
	            'password' 		=> md5(md5($password) . $salt),
	            'salt'			=> $salt,
	        );
	        $rs = RC_DB::table('staff_user')->where('store_id', $store_id)->where('user_id', $info['user_id'])->update($data_staff);
	        
	        if ($rs) {
	            return $this->showmessage('重置成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/view_staff', array('store_id' => $store_id))));
	        } else {
	            return $this->showmessage('重置失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	    }
	}

	/**
	 * 锁定商家
	 */
	public function status() {
		$this->admin_priv('store_affiliate_lock');

		$this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));

		$store_id = $_GET['store_id'];
		$status   = $_GET['status'];
		if($status == 1) {
			$this->assign('ur_here', '锁定店铺');
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('锁定店铺'));
		} else {
			$this->assign('ur_here', '店铺解锁');
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('店铺解锁'));
		}
		$this->assign('status', $status);
		$this->assign('form_action',RC_Uri::url('store/admin/status_update', array('store_id' => $store_id, 'status' => $status)));

		$this->display('store_lock.dwt');
	}

	/**
	 * 锁定解锁商家操作
	 */
	public function status_update() {
		$this->admin_priv('store_affiliate_lock', ecjia::MSGTYPE_JSON);

		$store_id = $_GET['store_id'];
		$status   = $_GET['status'];

		if ($status == 1) {
			$status_new = 2;
			$status_label = '锁定';
		} elseif ($status == 2) {
			$status_new = 1;
			$status_label = '解锁';
		}
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
		RC_DB::table('store_franchisee')->where('store_id', $store_id)->update(array('status' => $status_new));
		
		$store_franchisee_db = RC_Model::model('store/orm_store_franchisee_model');
		/* 释放app缓存*/
		$store_cache_array = $store_franchisee_db->get_cache_item('store_list_cache_key_array');
		if (!empty($store_cache_array)) {
			foreach ($store_cache_array as $val) {
				$store_franchisee_db->delete_cache_item($val);
			}
			$store_franchisee_db->delete_cache_item('store_list_cache_key_array');
		}
		
		clear_cart_list($store_id);
		ecjia_admin::admin_log('店铺'.$status_label.' '.RC_Lang::get('store::store.store_title_lable').$store_info['merchants_name'], 'update', 'store');
		return $this->showmessage('操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
	}

	/**
	 * 获取商家店铺经纬度
	 */
	public function get_longitude() {
		$detail_address = !empty($_POST['detail_address']) ? urlencode($_POST['detail_address']) : '';
		$store_id       = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		if (empty($detail_address)) {
			return $this->showmessage('详细地址不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$key 		= ecjia::config('map_qq_key');
		$location 	= RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$detail_address."&key=".$key);
        $location  	= json_decode($location['body'], true);
		$location 	= $location['result']['location'];
		$longitude 	= $location['lng'];
		$latitude 	= $location['lat'];
		//获取geohash值
		$geohash = RC_Loader::load_app_class('geohash', 'store');
		$geohash_code = $geohash->encode($location['lat'] , $location['lng']);
		$geohash_code = substr($geohash_code, 0, 10);
		RC_DB::table('store_franchisee')->where('store_id', $store_id)->update(array('longitude' => $longitude, 'latitude' => $latitude, 'geohash' => $geohash_code));
		$data = array('longitude' => $longitude, 'latitude' => $latitude, 'geohash' => $geohash_code);
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $data));
	}


	//获取入驻商列表信息
	private function store_list($manage_mode) {
		$db_store_franchisee = RC_DB::table('store_franchisee as sf');

		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		$filter['type'] = empty($_GET['type']) ? '' : trim($_GET['type']);
		$filter['cat'] = empty($_GET['cat']) ? null : trim($_GET['cat']);
		
		$db_store_franchisee->where('manage_mode', $manage_mode);
		
		if ($filter['keywords']) {
		    $db_store_franchisee->where(function ($query) use ( $filter) {
		        $query->where('merchants_name', 'like', '%'.mysql_like_quote($filter['keywords']).'%')
		        ->orWhere('contact_mobile', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		    });
		}
		if ($filter['cat']) {
		    if ($filter['cat'] == -1) {
		        $db_store_franchisee->whereRaw('sf.cat_id=0');
		    } else {
		        $db_store_franchisee->whereRaw('sf.cat_id='.$filter['cat']);
		    }
		}

		$filter_type = $db_store_franchisee
            		->select(RC_DB::raw('count(*) as count_all'),
            		    RC_DB::raw('SUM(status = 1) as count_unlock'),
            		    RC_DB::raw('SUM(status = 2) as count_locking'))
        		    ->first();

		$filter['count_all'] = $filter_type['count_all'] ? $filter_type['count_all'] : 0;
		$filter['count_unlock'] = $filter_type['count_unlock'] ? $filter_type['count_unlock'] : 0;
		$filter['count_locking'] = $filter_type['count_locking'] ? $filter_type['count_locking'] : 0;
		if (!empty($filter['type'])) {
		    $db_store_franchisee->where('status', $filter['type']);
		}
		if ($filter['type'] == 1) {
		    $count = $filter_type['count_unlock'];
		} else if ($filter['type'] == 2) {
		    $count = $filter_type['count_locking'];
		} else {
		    $count = $filter_type['count_all'];
		}

		$page = new ecjia_page($count, 20, 5);

		$data = $db_store_franchisee
        		->leftJoin('store_category as sc', RC_DB::raw('sf.cat_id'), '=', RC_DB::raw('sc.cat_id'))
        		->selectRaw('sf.store_id,sf.merchants_name,sf.manage_mode,sf.contact_mobile,sf.responsible_person,sf.confirm_time,sf.company_name,sf.sort_order,sc.cat_name,sf.status')
        		->orderby('store_id', 'asc')
        		->take($page->page_size)
        		->skip($page->start_id-1)
        		->get();

		$res = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['confirm_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['confirm_time']);
				$res[] = $row;
			}
		}

		return array('store_list' => $res, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}

	/**
	 * 获取店铺分类表
	 */
	private function get_cat_select_list() {
		$data = RC_DB::table('store_category')
        		->select('cat_id', 'cat_name')
        		->orderBy('cat_id', 'desc')
        		->get();
		$cat_list = array();
		if (!empty($data)) {
			foreach ($data as $row ) {
				$cat_list[$row['cat_id']] = $row['cat_name'];
			}
		}
		return $cat_list;
	}

	/**
	 * 获取指定地区的子级地区
	 */
	public function get_region(){
		$type           = !empty($_GET['type'])   ? intval($_GET['type'])               : 0;
		$parent         = !empty($_GET['parent']) ? intval($_GET['parent'])             : 0;
		$arr['regions'] = $this->db_region->get_regions($type, $parent);
		$arr['type']    = $type;
		$arr['target']  = !empty($_GET['target']) ? stripslashes(trim($_GET['target'])) : '';
		$arr['target']  = htmlspecialchars($arr['target']);
		echo json_encode($arr);
	}

	//查看配送方式
	public function shipping() {
	    $this->admin_priv('store_shipping_manage');

	    RC_Loader::load_app_class('shipping_factory', 'shipping', false);

	    $this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('配送方式'));
	    $store_id = intval($_GET['store_id']);
	    if (empty($store_id)) {
	        return $this->showmessage(__('请选择您要操作的店铺'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }

	    $menu = set_store_menu($store_id, 'shipping');
	    
	    //全部
	    $shipping_all = RC_DB::table('shipping')
                	    ->orderBy(RC_DB::raw('shipping_order'))
                	    ->where(RC_DB::raw('enabled'), 1)
                	    ->get();
	    
	    //本店
	    $shipping_enable = RC_DB::table('shipping_area')
                	        ->where(RC_DB::raw('store_id'), '=', $store_id)
                    	    ->select('shipping_id')
                    	    ->groupBy(RC_DB::raw('shipping_id'))
                    	    ->get();
	    $shipping_enable = array_column($shipping_enable, 'shipping_id');
	    
	    $plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);
	    
	    /* 插件已经安装了，获得名称以及描述 */
	    $enabled_modules = $disabled_modules = array();
	    
	    //已启用
	    foreach ($shipping_all as $_key => $_value) {
	        if (isset($plugins[$_value['shipping_code']])) {
	            if (in_array($_value['shipping_id'], $shipping_enable)) {
	                $enable_disable = 'enabled';
	            } else {
	                $enable_disable = 'disabled';
	            }
	            
	            $all_modules[$enable_disable][$_key]['id']      			= $_value['shipping_id'];
	            $all_modules[$enable_disable][$_key]['code']      		    = $_value['shipping_code'];
	            $all_modules[$enable_disable][$_key]['name']    			= $_value['shipping_name'];
	            $all_modules[$enable_disable][$_key]['desc']    			= $_value['shipping_desc'];
	            $all_modules[$enable_disable][$_key]['cod']     			= $_value['support_cod'];
	            $all_modules[$enable_disable][$_key]['shipping_order'] 	    = $_value['shipping_order'];
	            $all_modules[$enable_disable][$_key]['insure_fee']  		= $_value['insure'];
	            $all_modules[$enable_disable][$_key]['enabled'] 			= $_value['enabled'];
	            	
	            /* 判断该派送方式是否支持保价 支持报价的允许在页面修改保价费 */
	            $shipping_handle = new shipping_factory($_value['shipping_code']);
	            $config          = $shipping_handle->configure_config();
	    
	            /* 只能根据配置判断是否支持保价  只有配置项明确说明不支持保价，才是不支持*/
	            if (isset($config['insure']) && ($config['insure'] === false)) {
	                $all_modules[$enable_disable][$_key]['is_insure'] = false;
	            } else {
	                $all_modules[$enable_disable][$_key]['is_insure'] = true;
	            }
	        }
	    }
	    
	    $this->assign('enabled', $all_modules['enabled']);
	   
	    $this->assign('disabled', $all_modules['disabled']);

		$store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();

	    $this->assign('ur_here', $store['merchants_name'].' - 配送方式');
	    $this->assign('form_action', RC_Uri::url('store/admin/auth_update'));
	    $this->assign('store', $store);
	    $this->assign('store_id', $store_id);
	    $this->assign('menu', $menu);
	    $this->display('store_shipping.dwt');

	}

    /**
	 * 查看店铺日志
	 */
    public function view_log(){
        $this->admin_priv('store_log_manage');

        $this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('查看日志'));
        $store_id = intval($_GET['store_id']);
        if(empty($store_id)){
            return $this->showmessage(__('请选择您要操作的店铺'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $menu = set_store_menu($store_id, 'view_log');
        $store_jslang = array(
			'choose_delet_time'	=> __('请先选择删除日志的时间！'),
			'delet_ok_1'		=> __('确定删除'),
			'delet_ok_2'		=> __('的日志吗？'),
			'ok'				=> __('确定'),
			'cancel'			=> __('取消')
		);
		RC_Script::localize_script('store', 'store', $store_jslang );

        $merchants_name = RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');

        $this->assign('ur_here', $merchants_name.' - 查看日志');

        $logs = $this->get_admin_logs($_REQUEST,$store_id);
        $user_id    = !empty($_REQUEST['userid']) ? intval($_REQUEST['userid']) : 0;
        $ip         = !empty($_REQUEST['ip']) ? $_REQUEST['ip'] : '';
        $keyword    = !empty($_REQUEST['keyword']) ? trim(htmlspecialchars($_REQUEST['keyword'])) : '';

        $this->assign('user_id',    $user_id);
        $this->assign('ip',         $ip);
        $this->assign('keyword',    $keyword);
		/* 查询IP地址列表 */
		$ip_list = array();
		$data = RC_DB::table('staff_log')->selectRaw('distinct ip_address')->get();
		if (!empty($data)) {
			foreach ($data as $row) {
				$ip_list[] = $row['ip_address'];
			}
		}

		/* 查询管理员列表 */
		$user_list = array();
		$userdata = RC_DB::table('staff_user')->where(RC_DB::raw('store_id'), $store_id)->get();
		if (!empty($userdata)) {
			foreach ($userdata as $row) {
				if (!empty($row['user_id']) && !empty($row['name'])) {
					$user_list[$row['user_id']] = $row['name'];
				}
			}
		}

		$this->assign('form_search_action', RC_Uri::url('store/admin/view_log', array('store_id' => $store_id)));

		$this->assign('logs', $logs);
		$this->assign('menu', $menu);
		$this->assign('ip_list', $ip_list);
		$this->assign('user_list', $user_list);
        $this->display('staff_log.dwt');
    }

    public function check_log() {
        $this->admin_priv('store_preaudit_check_log');

        $store_id = intval($_GET['store_id']);

        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $this->assign('ur_here',$store['merchants_name'].' - '.'审核申请日志');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('审核申请日志'));
        $this->assign('action_link',array('href' => RC_Uri::url('store/admin/init'),'text' => RC_Lang::get('store::store.store_list')));

        $log = get_check_log($store_id, 2, 1, 15);

        $this->assign('log_list', $log);
        $menu = set_store_menu($store_id, 'check_log');
        $this->assign('menu', $menu);
        $this->display('store_preaudit_check_log.dwt');
    }

    /**
	 *  获取管理员操作记录
	 *  @param array $_GET , $_POST, $_REQUEST 参数
	 * @return array 'list', 'page', 'desc'
	 */
	private function get_admin_logs($args = array(),$store_id) {
		$db_staff_log = RC_DB::table('staff_log as sl')
						->leftJoin('staff_user as su', RC_DB::raw('sl.user_id'), '=', RC_DB::raw('su.user_id'));

		$user_id  = !empty($args['user_id']) ? intval($args['user_id']) : 0;
		$ip       = !empty($args['ip']) ? $args['ip'] : '';


		$filter = array();
		$filter['sort_by']      = !empty($args['sort_by']) ? safe_replace($args['sort_by']) :  RC_DB::raw('sl.log_id');
		$filter['sort_order']   = !empty($args['sort_order']) ? safe_replace($args['sort_order']) : 'DESC';

		$keyword = !empty($args['keyword']) ? trim(htmlspecialchars($args['keyword'])) : '';

		//查询条件
		$where = array();
		if (!empty($ip)) {
			$db_staff_log->where(RC_DB::raw('sl.ip_address'), $ip);
		}

		if(!empty($keyword)) {
			$db_staff_log->where(RC_DB::raw('sl.log_info'), 'like', '%'.$keyword.'%');
		}

		if (!empty($user_id)) {
			$db_staff_log->where(RC_DB::raw('su.user_id'), $user_id);
		}
        $db_staff_log->where(RC_DB::raw('sl.store_id'), $store_id);

		$count = $db_staff_log->count();
		$page = new ecjia_page($count, 15, 5);
		$data = $db_staff_log
        		->selectRaw('sl.log_id,sl.log_time,sl.log_info,sl.ip_address,sl.ip_location,su.name')
        		->orderby($filter['sort_by'], $filter['sort_order'])
        		->take(10)
        		->skip($page->start_id-1)
        		->get();
		/* 获取管理员日志记录 */
		$list = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$rows['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['log_time']);
				$list[] = $rows;
			}
		}
		return array('list' => $list, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}

    /**
     * 批量删除管理员操作日志
     */
    public function batch_drop(){
        $this->admin_priv('store_log_delete', ecjia::MSGTYPE_JSON);

        $drop_type_date = isset($_POST['drop_type_date']) ? $_POST['drop_type_date'] : '';
        $staff_log      = RC_DB::table('staff_log');
        $store_id       = $_GET['store_id'];

		/* 按日期删除日志 */
		if ($drop_type_date) {
			if ($_POST['log_date'] > 0) {
				$where = array();
				switch ($_POST['log_date']) {
					case 1:
						$a_week = RC_Time::gmtime() - (3600 * 24 * 7);
						$staff_log->where('log_time', '<=',$a_week);
						$deltime = __('一周之前');
					break;
					case 2:
						$a_month = RC_Time::gmtime() - (3600 * 24 * 30);
                        $staff_log->where('log_time', '<=',$a_month);
						$deltime = __('一个月前');
					break;
					case 3:
						$three_month = RC_Time::gmtime() - (3600 * 24 * 90);
                        $staff_log->where('log_time', '<=',$three_month);
						$deltime = __('三个月前');
					break;
					case 4:
						$half_year = RC_Time::gmtime() - (3600 * 24 * 180);
                        $staff_log->where('log_time', '<=',$half_year);
						$deltime = __('半年之前');
					break;
					case 5:
					default:
						$a_year = RC_Time::gmtime() - (3600 * 24 * 365);
                        $staff_log->where('log_time', '<=',$a_year);
						$deltime = __('一年之前');
					break;
				}

				$staff_log->where('store_id', $store_id)->delete();

                return $this->showmessage(sprintf(__('%s 的日志成功删除。'), $deltime), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/view_log', array('store_id' => $store_id))));
            }
        } else {
            return $this->showmessage(__('请选择日期'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 根据地区获取经纬度
     */
    public function getgeohash(){
        $shop_province      = !empty($_REQUEST['province'])    ? intval($_REQUEST['province'])           : 0;
        $shop_city          = !empty($_REQUEST['city'])        ? intval($_REQUEST['city'])               : 0;
        $shop_district      = !empty($_REQUEST['district'])    ? intval($_REQUEST['district'])           : 0;
        $shop_address       = !empty($_REQUEST['address'])     ? urlencode($_REQUEST['address'])  		 : '';

        if (empty($shop_province)) {
            return $this->showmessage('请选择省份', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'province'));
        }
        if (empty($shop_city)) {
            return $this->showmessage('请选择城市', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'city'));
        }
        if (empty($shop_district)) {
            return $this->showmessage('请选择地区', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'district'));
        }
        if (empty($shop_address)) {
            return $this->showmessage('请填写详细地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'address'));
        }
		
        $key = ecjia::config('map_qq_key');
        if (empty($key)) {
        	return $this->showmessage('腾讯地图key不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $city_name    	= RC_DB::table('region')->where('region_id', $shop_city)->pluck('region_name');
        $city_district 	= RC_DB::table('region')->where('region_id', $shop_district)->pluck('region_name');
        $address      	= $city_name.'市'.$city_district.$shop_address;
        $address		= urlencode($address);
        $shop_point   	= RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=".$address."&key=".$key);
        $shop_point  	= json_decode($shop_point['body'], true);

		if ($shop_point['status'] != 0) {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $shop_point);
		}
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $shop_point);
    }

}

//end

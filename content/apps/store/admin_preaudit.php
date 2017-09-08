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
 * 入驻商家待审核列表
 */
class admin_preaudit extends ecjia_admin {
	private $db_region;
	public function __construct() {
		parent::__construct();

		$this->db_region = RC_Model::model('store/region_model');

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

		RC_Script::enqueue_script('store', RC_App::apps_url('statics/js/store.js', __FILE__));
		RC_Script::enqueue_script('region',RC_Uri::admin_url('statics/lib/ecjia-js/ecjia.region.js'));
		RC_Script::enqueue_script('qq_map', 'https://map.qq.com/api/js?v=2.exp');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('store::store.store_preaudit'), RC_Uri::url('store/admin_preaudit/init')));

		RC_Loader::load_app_func('global');
		
		ecjia_admin_log::instance()->add_object('merchants_preaudit', '入驻商家');
		ecjia_admin_log::instance()->add_action('check', '审核');
	}

	/**
	 * 入驻商家预审核列表
	 */
	public function init() {
	    $this->admin_priv('store_preaudit_manage');

	    $this->assign('ur_here', RC_Lang::get('store::store.store_preaudit_list'));

	    $store_list = $this->store_preaudit_list();
	    $this->assign('store_list', $store_list);

	    $this->assign('search_action', RC_Uri::url('store/admin_preaudit/init'));

	    $this->display('store_preaudit_list.dwt');
	}

	/**
	 * 编辑入驻商
	 */
	public function edit() {
		$this->admin_priv('store_preaudit_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('store::store.store_update')));
		$this->assign('ur_here',RC_Lang::get('store::store.store_update'));
		if ($_GET['type']) {
		    $action_link_href = RC_Uri::url('store/admin_preaudit/init', array('type' => $_GET['type']));
		} else {
		    $action_link_href = RC_Uri::url('store/admin_preaudit/init');
		}
		$this->assign('action_link',array('href' => $action_link_href, 'text' => RC_Lang::get('store::store.store_preaudit')));

		$id    = intval($_GET['id']);
		$store = RC_DB::table('store_preaudit')->where('id', $id)->first();

		$province   = $this->db_region->get_regions(1, 1);
		$city       = $this->db_region->get_regions(2, $store['province']);
		$district   = $this->db_region->get_regions(3, $store['city']);
		$this->assign('province', $province);
		$this->assign('city', $city);
		$this->assign('district', $district);

		$certificates_list = array(
			'1' => RC_Lang::get('store::store.people_id'),
			'2' => RC_Lang::get('store::store.passport'),
			'3' => RC_Lang::get('store::store.hong_kong_and_macao_pass')
		);
		$this->assign('certificates_list', $certificates_list);

		$store['apply_time']	= RC_Time::local_date(ecjia::config('time_format'), $store['apply_time']);
		$this->assign('store', $store);
		$cat_list = $this->get_cat_select_list();
		$this->assign('cat_list', $cat_list);

		$this->assign('form_action',RC_Uri::url('store/admin_preaudit/update'));

		$this->display('store_preaudit_edit.dwt');
	}

	/**
	 * 编辑入驻商数据更新
	 */
	public function update() {
		$this->admin_priv('store_preaudit_update', ecjia::MSGTYPE_JSON);

		$id = intval($_POST['id']);
		$info = RC_DB::table('store_preaudit')->where('id', $id)->first();

		if (!empty($_FILES['one']['name'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
			$info = $upload->upload($_FILES['one']);
			if (!empty($info)) {
				$business_licence_pic = $upload->get_position($info);
				$upload->remove($info['business_licence_pic']);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$business_licence_pic = $info['business_licence_pic'];
		}

		if (!empty($_FILES['two']['name'])) {
			$upload  = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
			$info    = $upload->upload($_FILES['two']);
			if (!empty($info)) {
				$identity_pic_front = $upload->get_position($info);
				$upload->remove($info['identity_pic_front']);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$identity_pic_front = $info['identity_pic_front'];
		}

		if (!empty($_FILES['three']['name'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
			$info   = $upload->upload($_FILES['three']);
			if (!empty($info)) {
				$identity_pic_back = $upload->get_position($info);
				$upload->remove($info['identity_pic_back']);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$identity_pic_back = $info['identity_pic_back'];
		}

		if (!empty($_FILES['four']['name'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
			$info = $upload->upload($_FILES['four']);
			if (!empty($info)) {
				$personhand_identity_pic = $upload->get_position($info);
				$upload->remove($info['personhand_identity_pic']);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$personhand_identity_pic = $info['personhand_identity_pic'];
		}

		$data = array(
			'cat_id'   	   				=> !empty($_POST['store_cat']) 		        ? $_POST['store_cat']           : '',
			'merchants_name'   			=> !empty($_POST['merchants_name'])         ? $_POST['merchants_name']      : '',
			'shop_keyword'      		=> !empty($_POST['shop_keyword']) 	        ? $_POST['shop_keyword']        : '',
			'responsible_person'		=> !empty($_POST['responsible_person'])     ? $_POST['responsible_person']  : '',
			'company_name'      		=> !empty($_POST['company_name']) 		    ? $_POST['company_name']        : '',
			'email'      				=> !empty($_POST['email']) 				    ? $_POST['email']               : '',
			'contact_mobile'    		=> !empty($_POST['contact_mobile']) 	    ? $_POST['contact_mobile']      : '',
			'address'      				=> !empty($_POST['address']) 			    ? $_POST['address']             : '',
			'identity_type'     		=> !empty($_POST['identity_type']) 		    ? $_POST['identity_type']       : '',
			'identity_number'   		=> !empty($_POST['identity_number']) 	    ? $_POST['identity_number']     : '',
			'identity_pic_front'		=> $identity_pic_front,
			'identity_pic_back' 		=> $identity_pic_back,
			'personhand_identity_pic'	=> $personhand_identity_pic,
			'business_licence'  		=> !empty($_POST['business_licence']) 		? $_POST['business_licence']    : '',
			'business_licence_pic' 		=> $business_licence_pic,
			'bank_name'      	   		=> !empty($_POST['bank_name']) 				? $_POST['bank_name']           : '',
			'bank_branch_name'     		=> !empty($_POST['bank_branch_name']) 		? $_POST['bank_branch_name']    : '',
			'bank_account_name' 	 	=> !empty($_POST['bank_account_name'])		? $_POST['bank_account_name']   : '',
			'bank_account_number' 	 	=> !empty($_POST['bank_account_number'])	? $_POST['bank_account_number'] : '',
			'province'					=> !empty($_POST['province'])				? $_POST['province']            : '',
			'city'						=> !empty($_POST['city'])					? $_POST['city']                : '',
			'district'					=> !empty($_POST['district'])				? $_POST['district']            : '',
			'bank_address'         		=> !empty($_POST['bank_address']) 			? $_POST['bank_address']        : '',
			'longitude'         		=> !empty($_POST['longitude']) 				? $_POST['longitude']           : '',
			'latitude'         			=> !empty($_POST['latitude']) 				? $_POST['latitude']            : '',
		);
		
		$franchisee_count = 0;
		if ($info['store_id']) {
		    $franchisee_count = RC_DB::table('store_franchisee')->where('email', '=', $data['email'])->where('store_id', '!=', $info['store_id'])->count();
		}
		$preaudit_count   = RC_DB::table('store_preaudit')->where('email', '=', $data['email'])->where('id', '!=', $id)->count();
		if ($franchisee_count || $preaudit_count) {
		    return $this->showmessage('该邮箱已经使用，请填写其他邮箱地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$franchisee_count = 0;
		if ($info['store_id']) {
		    $franchisee_count = RC_DB::table('store_franchisee')->where('contact_mobile', '=', $data['contact_mobile'])->where('store_id', '!=', $info['store_id'])->count();
		}
		$preaudit_count   = RC_DB::table('store_preaudit')->where('contact_mobile', '=', $data['contact_mobile'])->where('id', '!=', $id)->count();
		if ($franchisee_count || $preaudit_count) {
		    return $this->showmessage('该手机号已经使用，请填写其他联系方式', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$geohash = RC_Loader::load_app_class('geohash', 'store');
		if(!empty($_POST['latitude']) && !empty($_POST['longitude']))
		$geohash_code = $geohash->encode($_POST['latitude'] , $_POST['longitude']);
		$geohash_code = substr($geohash_code, 0, 10);
		$data['geohash'] = $geohash_code;
		RC_DB::table('store_preaudit')->where('id', $id)->update($data);
		
		ecjia_admin::admin_log($data['merchants_name'], 'edit', 'merchants_preaudit');

		return $this->showmessage(RC_Lang::get('store::store.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_preaudit/edit', array('id' => $id))));
	}

	/**
	 * 审核入驻商
	 */
	public function check() {
		$this->admin_priv('store_preaudit_check');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('store::store.check_view')));
		$this->assign('ur_here',RC_Lang::get('store::store.check_view'));
		if ($_GET['type']) {
		    $action_link_href = RC_Uri::url('store/admin_preaudit/init', array('type' => $_GET['type']));
		} else {
		    $action_link_href = RC_Uri::url('store/admin_preaudit/init');
		}
		$this->assign('action_link',array('href' => $action_link_href,'text' => RC_Lang::get('store::store.store_preaudit')));

		$id = intval($_GET['id']);
		$info = RC_DB::table('store_preaudit')->where('id', $id)->first();

		if (empty($info)) {
		    return $this->showmessage('信息不存在或已处理完成', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR,  array('pjaxurl' => RC_Uri::url('store/admin_preaudit/init')));
		}
		$info['province'] = RC_DB::table('region')->where('region_id', $info['province'])->pluck('region_name');

		$info['city'] = RC_DB::table('region')->where('region_id', $info['city'])->pluck('region_name');

		$info['district'] = RC_DB::table('region')->where('region_id', $info['district'])->pluck('region_name');

		$info['apply_time']	= RC_Time::local_date(ecjia::config('time_format'), $info['apply_time']);
		$info['cat_name'] = RC_DB::table('store_category')->where('cat_id', $info['cat_id'])->pluck('cat_name');
		$this->assign('store', $info);

		$this->assign('form_action',RC_Uri::url('store/admin_preaudit/check_update'));

		//审核日志
		if ($info['store_id']) {
		    $log_store_id = $info['store_id'];
		    $log_type = 2;
		} else {
		    $log_store_id = $info['id'];
		    $log_type = 1;
		}

		$log_rs = get_check_log($log_store_id, $log_type, 1, 3);

		$this->assign('log_list', $log_rs['list']);
		$this->assign('log_last', $log_rs['list'][0]['log']);

		$this->display('store_preaudit_check.dwt');
	}

	/**
	 * 审核入驻商
	 */
	public function check_update() {
		$this->admin_priv('store_preaudit_update', ecjia::MSGTYPE_JSON);

		$id         = intval($_POST['id']);
		$store_id   = intval($_POST['store_id']);
		$remark 	=!empty($_POST['remark']) ? $_POST['remark'] : null;
		//通过
		if ($_POST['check_status'] == 2) {
			if (empty($store_id)) {//首次审核
				$store        = RC_DB::table('store_preaudit')->where('id', $id)->first();
				$geohash      = RC_Loader::load_app_class('geohash', 'store');
				$geohash_code = $geohash->encode($store['latitude'] , $store['longitude']);
				$geohash_code = substr($geohash_code, 0, 10);
				if (empty($store['merchants_name'])) {
				    return $this->showmessage('店铺名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$count= RC_DB::table('store_franchisee')->where(RC_DB::raw('merchants_name'), $store['merchants_name'])->count();
				if ($count > 0) {
				    return $this->showmessage('店铺名称已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$data = array(
					'cat_id' 					=> $store['cat_id'] ? $store['cat_id'] : 0,
				    'validate_type' 			=> $store['validate_type'],
					'merchants_name'			=> $store['merchants_name'],
					'shop_keyword'				=> $store['shop_keyword'],
					'status'					=> 1,
// 				    'identity_status'           => intval($_POST['identity_status']),
					'responsible_person'		=>$store['responsible_person'],
					'company_name'				=>$store['company_name'],
					'email'						=>$store['email'],
					'contact_mobile'			=>$store['contact_mobile'],
					'apply_time'				=>$store['apply_time'],
					'confirm_time'				=>RC_Time::gmtime(),
				    'expired_time'				=>RC_Time::local_strtotime("+1 year"),
					'address'					=>$store['address'],
					'identity_type'				=>$store['identity_type'],
					'identity_number'			=>$store['identity_number'],
					'identity_pic_front'		=>$store['identity_pic_front'],
					'identity_pic_back'			=>$store['identity_pic_back'],
					'personhand_identity_pic'	=>$store['personhand_identity_pic'],
					'business_licence'			=>$store['business_licence'],
					'business_licence_pic'		=>$store['business_licence_pic'],
					'bank_name'					=>$store['bank_name'],
					'province'					=>$store['province'],
					'city'						=>$store['city'],
					'district'					=>$store['district'],
					'bank_branch_name'			=>$store['bank_branch_name'],
					'bank_account_number'		=>$store['bank_account_number'],
					'bank_address'				=>$store['bank_address'],
					'remark'					=>$remark,
					'longitude'					=>$store['longitude'],
					'latitude'					=>$store['latitude'],
				    'geohash'                   =>$geohash_code,
					'sort_order' 				=> 50,
				);
				
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
				
				RC_Logger::getlogger('new_store')->info($data);
				$store_id = RC_DB::table('store_franchisee')->insertGetId($data);
				RC_DB::table('store_preaudit')->where('id', $id)->delete();
				
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
				
// 				$merchants_config = RC_DB::table('merchants_config');//不能写外面
				foreach ($merchant_config as $val) {
					//RC_DB::table一定要写在里面 不然每次循环都会追加where条件
					$count = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', $val)->count();
					if ($count == 0) {
						RC_DB::table('merchants_config')->insert(array('store_id' => $store_id, 'code' => $val));
					}
				}
				
				//审核通过产生一个主员工的资料
				$password = rand(100000,999999);
				$salt = rand(1, 9999);
				$data_staff = array(
					'mobile' 		=> $store['contact_mobile'],
					'store_id' 		=> $store_id,
					'name' 			=> $store['responsible_person'],
					'nick_name' 	=> '',
					'user_ident' 	=> 'SC001',
					'email' 		=> $store['email'],
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
				RC_DB::table('staff_user')->insertGetId($data_staff);

				//审核通过，修改所有日志storeid type
				RC_DB::table('store_check_log')->where('store_id', $id)->where('type', 1)->update(array('store_id' => $store_id, 'type' => 2));
				$log = array(
				    'store_id' => $store_id ? $store_id : $id,
				    'type' => $store_id ? 2 : 1,
				    'name' => '管理员',
				    'info' => '恭喜您的申请通过审核。'.$remark,
				);
				RC_Api::api('store', 'add_check_log', $log);
				ecjia_admin::admin_log($data['merchants_name'].' 通过', 'check', 'merchants_preaudit');
				
				//短信发送通知
				$options = array(
					'mobile' => $store['contact_mobile'],
					'event'	 => 'sms_join_merchant',
					'value'  =>array(
						'user_name' => $store['responsible_person'],
						'shop_name' => ecjia::config('shop_name'),
						'account'	=> $store['contact_mobile'],
						'password'	=> $password,
						'service_phone' => ecjia::config('service_phone'),
					),
				);
				$response = RC_Api::api('sms', 'send_event_sms', $options);
				return $this->showmessage(RC_Lang::get('store::store.check_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_preaudit/init')));
			} else {
				//再次审核资料
				$store = RC_DB::table('store_preaudit')->where('store_id', $store_id)->first();
				$franchisee_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
				
				$count= RC_DB::table('store_franchisee')->where(RC_DB::raw('merchants_name'), $store['merchants_name'])->where(RC_DB::raw('store_id'), '<>', $store_id)->count();
				if ($count > 0) {
				    return $this->showmessage('店铺名称已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$data = array(
				    'merchants_name'            => $store['merchants_name'],
					'cat_id' 					=> $store['cat_id'],
// 				    'identity_status'           => intval($_POST['identity_status']),
					'shop_keyword'				=> $store['shop_keyword'],
					'responsible_person'		=> $store['responsible_person'],
				    'company_name'		        => $store['company_name'],
					'email'						=> $store['email'],
					'contact_mobile'			=> $store['contact_mobile'],
					'apply_time'				=> $store['apply_time'],
// 					'confirm_time'				=> RC_Time::gmtime(),
					'identity_type'				=> $store['identity_type'],
					'identity_number'			=> $store['identity_number'],
					'identity_pic_front'		=> $store['identity_pic_front'],
					'identity_pic_back'			=> $store['identity_pic_back'],
					'personhand_identity_pic'	=> $store['personhand_identity_pic'],
					'business_licence'			=> $store['business_licence'],
					'business_licence_pic'		=> $store['business_licence_pic'],
					'province'					=> $store['province'],
					'city'						=> $store['city'],
					'district'					=> $store['district'],
				    'address'					=> $store['address'],
				    'longitude'					=> $store['longitude'],
				    'latitude'					=> $store['latitude'],
				    'geohash'                   => $store['geohash'],
				);
				$is_exist = RC_DB::table('store_franchisee')->where('store_id', '<>', $store_id)->where('contact_mobile', $data['contact_mobile'])->get();
				if ($is_exist) {
				    return $this->showmessage('联系手机已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('mobile', $data['contact_mobile'])->get();
				if ($is_exist) {
				    return $this->showmessage('联系手机员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$is_exist = RC_DB::table('store_franchisee')->where('store_id', '<>', $store_id)->where('email', $data['email'])->get();
				if ($is_exist) {
				    return $this->showmessage('邮箱已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('email', $data['email'])->get();
				if ($is_exist) {
				    return $this->showmessage('邮箱员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}

				//判断是否修改认证相关字段
				if (
				    ($store['identity_pic_front'] && $store['identity_pic_front'] != $franchisee_info['identity_pic_front']) ||
				    ($store['identity_pic_back'] && $store['identity_pic_back'] != $franchisee_info['identity_pic_back']) || 
				    ($store['personhand_identity_pic'] && $store['personhand_identity_pic'] != $franchisee_info['personhand_identity_pic']) ||
				    ($store['business_licence_pic'] && $store['business_licence_pic'] != $franchisee_info['business_licence_pic']) || 
				    ($store['identity_type'] && $store['identity_type'] != $franchisee_info['identity_type']) || 
				    ($store['identity_number'] && $store['identity_number'] != $franchisee_info['identity_number']) || 
				    ($store['business_licence'] && $store['business_licence'] != $franchisee_info['business_licence']) ||
				    ($store['responsible_person'] && $store['responsible_person'] != $franchisee_info['responsible_person']) ||
				    ($store['company_name'] && $store['company_name'] != $franchisee_info['company_name'])
				    ) {
				        $data['identity_status'] = 0;
				        if (ecjia::config('store_identity_certification') == 1) {
				            //如强制审核，则关闭该商店
				            $data['shop_close'] = 1;
				        }
				    }

				RC_DB::table('store_franchisee')->where('store_id', $store_id)->update($data);
				RC_DB::table('store_preaudit')->where('store_id', $store_id)->delete();
				$log = array(
				    'store_id' => $store_id ? $store_id : $id,
				    'type'     => $store_id ? 2 : 1,
				    'name'     => '管理员',
				    'info'     => '审核通过。'.$remark,
				);
				
				$store_franchisee_db = RC_Model::model('store/orm_store_franchisee_model');
				/* 释放app缓存*/
				$store_cache_array = $store_franchisee_db->get_cache_item('store_list_cache_key_array');
				if (!empty($store_cache_array)) {
					foreach ($store_cache_array as $val) {
						$store_franchisee_db->delete_cache_item($val);
					}
					$store_franchisee_db->delete_cache_item('store_list_cache_key_array');
				}
				
				RC_Api::api('store', 'add_check_log', $log);
				ecjia_admin::admin_log($data['merchants_name'], 'check', 'merchants_preaudit');
				return $this->showmessage('再次审核成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_preaudit/init')));
			}
		} else if($_POST['check_status'] == 3) {
		    $store = RC_DB::table('store_preaudit')->where('id', $id)->first();
		    //不通过
		    $log = array(
		        'store_id' => $store_id ? $store_id : $id,
		        'type' => $store_id ? 2 : 1,
		        'name' => '管理员',
		        'info' => '审核不通过。'.$remark,
		    );
		    RC_Api::api('store', 'add_check_log', $log);
		    RC_DB::table('store_preaudit')->where('id', $id)->update(array('remark' => $remark, 'check_status' => intval($_POST['check_status'])));
		    
		    ecjia_admin::admin_log($store['merchants_name'].' 拒绝', 'check', 'merchants_preaudit');
		    return $this->showmessage(RC_Lang::get('store::store.deal_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_preaudit/init')));
		} else {
		    //异常状态
			return $this->showmessage('操作异常，请检查', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	public function view_log() {
	    $this->admin_priv('store_preaudit_check_log');

	    $this->assign('ur_here','查看日志');
	    $id = intval($_GET['id']);
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('store::store.check_view'), RC_Uri::url('store/admin_preaudit/check', array('id' => $id))));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('查看日志'));
	    $this->assign('action_link',array('href' => RC_Uri::url('store/admin_preaudit/check', array('id' => $id)),'text' => RC_Lang::get('store::store.store_preaudit')));
	    $info = RC_DB::table('store_preaudit')->where('id', $id)->first();

	    if (empty($info)) {
	        return $this->showmessage('信息不存在或已处理完成', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR,  array('pjaxurl' => RC_Uri::url('store/admin_preaudit/init')));
	    }
	    $log_store_id = $info['store_id'] ? $info['store_id'] : $info['id'];
	    $log_type     = $info['store_id'] ? 2 : 1;

	    $log = get_check_log($log_store_id, $log_type, 1, 15);

	    $this->assign('log_list', $log);
	    $this->display('store_preaudit_check_log.dwt');
	}

	//获取入驻商列表信息
	private function store_preaudit_list($page_size = 15) {
		$db_store_franchisee = RC_DB::table('store_preaudit as sp');

		$filter['keywords'] = empty($_GET['keywords']) ? ''     : trim($_GET['keywords']);
		$filter['type']     = empty($_GET['type'])     ? 'join' : trim($_GET['type']);
		if ($filter['keywords']) {
			$db_store_franchisee->where(function ($query) use ( $filter) {
			    $query->where('merchants_name', 'like', '%'.mysql_like_quote($filter['keywords']).'%')
			    ->orWhere('contact_mobile', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
			});
		}

		$filter_type = $db_store_franchisee
                		->select(RC_DB::raw('count(*) as count_all'),
                		    RC_DB::raw('SUM(store_id = 0 AND check_status <> 3) as count_join'),
                		    RC_DB::raw('SUM(store_id <> 0 AND check_status <> 3) as count_edit'),
                		    RC_DB::raw('SUM(check_status = 3) as count_refuse'))
                		->first();

		$filter['count_all']    = $filter_type['count_all']    ? $filter_type['count_all']    : 0;
		$filter['count_join']   = $filter_type['count_join']   ? $filter_type['count_join']   : 0;
		$filter['count_edit']   = $filter_type['count_edit']   ? $filter_type['count_edit']   : 0;
		$filter['count_refuse'] = $filter_type['count_refuse'] ? $filter_type['count_refuse'] : 0;

		if ($filter['type'] == 'edit') {
		    $db_store_franchisee->where('store_id', '<>', 0)->where('check_status', '<>', 3);
		    $count = $filter['count_edit'];
		} else if ($filter['type'] == 'refuse') {
		    $db_store_franchisee->where('check_status', '=', 3);
		    $count = $filter['count_refuse'];
		} else {
		    $db_store_franchisee->where('store_id', '=', 0)->where('check_status', '<>', 3);
		    $count = $filter['count_join'];
		}

		$page = new ecjia_page($count, $page_size, 5);
		$data = $db_store_franchisee
        		->leftJoin('store_category as sc', RC_DB::raw('sp.cat_id'), '=', RC_DB::raw('sc.cat_id'))
        		->selectRaw('sp.id,sp.merchants_name,sp.merchants_name,sp.responsible_person,sp.apply_time,sp.company_name,sp.contact_mobile,sc.cat_name')
        		->orderby('id', 'asc')
        		->take($page->page_size)
        		->skip($page->start_id-1)
        		->get();
		$res = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['apply_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['apply_time']);
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
}

//end

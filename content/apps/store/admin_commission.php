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
 * 商家店铺后台设置
 */
class admin_commission extends ecjia_admin {

	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('global');
		Ecjia\App\Store\Helper::assign_adminlog_content();

		/* 加载全局 js/css */
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('bootstrap-editable',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('bootstrap-editable.min',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));

		RC_Script::enqueue_script('media-editor',RC_Uri::vendor_url('tinymce/tinymce.min.js'));
		RC_Script::enqueue_script('store', RC_App::apps_url('statics/js/store.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('commission', RC_App::apps_url('statics/js/commission.js' , __FILE__), array(), false, 1);
		RC_Style::enqueue_style('admin_fund', RC_App::apps_url('statics/css/admin_fund.css',__FILE__));
		
		//js语言包
		RC_Script::localize_script('store', 'js_lang', config('app-store::jslang.admin_page'));
		
		RC_Loader::load_app_func('admin_order', 'store');
	}

	
	/**
	 * 设置佣金
	 */
	public function add() {
		$this->admin_priv('store_commission_add');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here( __('设置商家佣金', 'store')));

		$this->assign('ur_here', __('设置商家佣金', 'store'));
		$this->assign('action_link'  , array('href' => RC_Uri::url('seller/admin_commission/init'), 'text' => __('佣金结算', 'store')));
		$this->assign('form_action',RC_Uri::url('seller/admin_commission/insert'));

		$suppliers_percent = $this->get_suppliers_percent();
		$this->assign('suppliers_percent', $suppliers_percent);

		$date = array('shoprz_brandName, shopNameSuffix');
		$user = get_table_date('merchants_shop_information', "user_id = '$_GET[user_id]'", $date);
		if (empty($user['shoprz_brandName'])) {
			$user['shoprz_brandName'] = '';
		}
		if (empty($user['shopNameSuffix'])) {
			$user['shopNameSuffix'] = '';
		}

		$user_name = $this->user_db->where(array('user_id'=>$_GET['user_id']))->get_field('user_name');
		$this->assign('user_name',$user_name);
		$this->assign('user', $user);
		$this->assign('user_id', $_GET[user_id]);

		$this->assign_lang();
		$this->display('merchants_commission_info.dwt');
	}

	public function insert() {
		$this->admin_priv('store_commission_add', ecjia::MSGTYPE_JSON);

		$user_id			= isset($_POST['user_id']) 		        ? intval($_POST['user_id']) 		    : 0;
		$suppliers_percent	= isset($_POST['suppliers_percent']) 	? intval($_POST['suppliers_percent']) 	: 0;
		$suppliers_desc		= isset($_POST['suppliers_desc']) 		? trim($_POST['suppliers_desc']) 		: '';

		if (empty($_POST['suppliers_percent'])) {
			return $this->showmessage(__('请选择佣金比例！', 'store'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array (
			'user_id'			=> $user_id,
			'suppliers_desc'	=> $suppliers_desc,
			'suppliers_percent'	=> $suppliers_percent
		);

		$server_id = $this->msdb->insert($data);

		if ($server_id) {
			$user_name   = $this->user_db->where(array('user_id' => $user_id))->get_field('user_name');
			$percent     = $this->mpdb->where(array('percent_id' => $suppliers_percent))->get_field('percent_value');
			
			ecjia_admin::admin_log(sprintf(__('商家名是%s，佣金比例是%s%', 'store'), $user_name, $percent), 'add', 'store_commission');
			
			return $this->showmessage(__('设置商家佣金成功！', 'store'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>RC_Uri::url('store/admin_commission/edit',array('id'=>$server_id, 'user_id'=>$user_id))));
		} else {
			return $this->showmessage(__('设置商家佣金失败！', 'store'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 订单佣金结算页面
	 */
	public function edit()	{
		$this->admin_priv('store_commission_update');
		$this->assign('form_action', RC_Uri::url('store/admin_commission/update'));

		$store_id = $_GET['store_id'];
		$this->assign('store_id', $store_id);
		$store = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $store_id)->first();
		$this->assign('store_commission', $store);
		
		if ($store['manage_mode'] == 'self') {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('自营店铺', 'store'),RC_Uri::url('store/admin/init')));
			$this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => __('自营店铺列表', 'store')));
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('入驻商家', 'store'),RC_Uri::url('store/admin/join')));
			$this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => __('入驻商家列表', 'store')));
		}
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('佣金设置', 'store')));
		
		ecjia_screen::get_current_screen()->set_sidebar_display(false);
		ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
		ecjia_screen::get_current_screen()->add_option('current_code', 'store_commission');

		$this->assign('ur_here', $store['merchants_name'].' - '.__('佣金设置', 'store'));
		$this->assign('merchants_name', $store['merchants_name']);
		$this->assign('store_id', $store['store_id']);

		$store_percent = $this->get_suppliers_percent(); //管理员获取佣金百分比
		$this->assign('store_percent', $store_percent);
		
		$store_account = RC_DB::table('store_account')->where('store_id', $store_id)->first();
		if(empty($store_account)) {
		    $ins_data = array(
		        'store_id' => $store_id,
		        'deposit' => ecjia::config('store_deposit')
		    );
		    RC_DB::table('store_account')->insert($ins_data);
		    $store_deposit = ecjia::config('store_deposit');
		} else {
		    $store_deposit = $store_account['deposit'];
		}
	    $store_deposit = empty($store_deposit) ? 0 : $store_deposit;
		$this->assign('store_deposit', $store_deposit);

		$this->display('store_commission_info.dwt');
	}

	/**
	 * 订单佣金结算页面
	 */
	public function update() {
		$this->admin_priv('store_commission_update', ecjia::MSGTYPE_JSON);

		$id       = $_POST['id'];
		$store_id = $_POST['store_id'];
		$store_deposit = !empty($_POST['store_deposit']) ? intval($_POST['store_deposit']) : 0;

		$data = array (
			'percent_id'  => intval($_POST['percent_id']),
		);

		if (empty($_POST['percent_id'])) {
			return $this->showmessage(__('请选择佣金比例！', 'store'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		RC_DB::table('store_franchisee')
				->where(RC_DB::raw('store_id'), '=', $store_id)
		        ->update($data);
		        
		RC_DB::table('store_account')->where('store_id', $store_id)->update(array('deposit' => $store_deposit));

		$merchants_name = RC_DB::table('store_franchisee')
							  ->where(RC_DB::raw('store_id'), '=', $store_id)
		                      ->pluck('merchants_name');

		$percent = RC_DB::table('store_percent')->where(RC_DB::raw('percent_id'), '=', $_POST['percent_id'])->pluck('percent_value');
		ecjia_admin::admin_log(__('商家名是 ', 'store').$merchants_name.'，'.__('佣金比例是 ', 'store').$percent.__('%，保证金是', 'store').$store_deposit, 'edit', 'store_commission');
		return $this->showmessage(__('编辑成功！', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS , array('pjaxurl' => RC_Uri::url('store/admin_commission/edit',array('id' => $id, 'store_id' => $store_id))));
	}

	public function remove(){
		$this->admin_priv('store_commission_delete',ecjia::MSGTYPE_JSON);

		$id = $_GET['id'];
		$info     = RC_DB::table('store_commission')->where(RC_DB::raw('id'), '=', $id)->first();
		$srore_id = $info['store_id'];
		if ($info) {
			//判断是否存在订单
// 			$order_list = $this->merchants_order_list($info['user_id']);
// 			$order_exists = $this->oi_viewdb->join(array('order_goods','goods'))->where(array('server_id'=>$id))->count();

			//判断是否存在商品
// 			$goods_exists = $this->goods_db->where(array('goods_id'=>$id))->count();

			/* 删除管理员、发货单关联、退货单关联和订单关联的服务站 */
// 			$table_array = array($this->db_admin_user,$this->db_delivery_order,$this->db_back_order);

// 			foreach ($table_array as $value) {
// 				$value->where(array('server_id'=>$id))->delete();
// 			}

			//$user_name = $this->user_db->where(array('user_id' => $info['user_id']))->get_field('user_name');
			//$percent = $this->mpdb->where(array('percent_id' => intval($info['suppliers_percent'])))->get_field('percent_value');
			//$this->msdb->where(array('server_id' => $id))->delete();
			$merchants_name = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $srore_id)->pluck('merchants_name');
			$percent        = RC_DB::table('store_percent')->where(RC_DB::raw('percent_id'), '=', intval($info['percent_id']))->pluck('percent_value');

			RC_DB::table('store_commission')->where(RC_DB::raw('id'), $id)->delete();

			ecjia_admin::admin_log(__('商家名是 ', 'store').$merchants_name.'，'.__('佣金比例是 ', 'store').$percent.'%', 'remove', 'store_commission');

			return $this->showmessage(__('删除成功', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(__('删除失败', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 批量操作
	 */
	public function batch() {
		$this->admin_priv('store_commission_delete', ecjia::MSGTYPE_JSON);

		$id     = $_POST['id'];
		$id_new = explode(',', $id);

		$info = RC_DB::table('store_commission as sc')
				 ->leftJoin('store_franchisee as sf', RC_DB::raw('sc.store_id'), '=', RC_DB::raw('sf.store_id'))
				 ->leftJoin('store_percent as sp', RC_DB::raw('sc.percent_id'), '=', RC_DB::raw('sp.percent_id'))
				 ->select(RC_DB::raw('sf.merchants_name, sp.percent_value'))
		         ->get();

		$server_delete = RC_DB::table('store_commission')->whereIn(RC_DB::raw('id'), $id_new)->delete();

		if ($server_delete) {
			foreach ($info as $k => $v) {
				ecjia_admin::admin_log(__('商家名是 ', 'store').$v['merchants_name'].'，'.__('佣金比例是 ', 'store').$v['percent_value'].'%', 'batch_remove', 'store_commission');
			}

			return $this->showmessage(__('批量删除成功', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_commission/init')));
		} else {
			return $this->showmessage(__('批量删除失败', 'store'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 修改结算状态
	 */
	public function toggle_state() {
		$this->admin_priv('store_commission_update', ecjia::MSGTYPE_JSON);
		
		$order_id             = intval($_POST['id']);
		$order_sn             = $_GET['order_sn'];
		$arr['is_settlement'] = intval($_POST['val']);

		RC_DB::table('order_info')->where(RC_DB::raw('order_id'), $order_id)->update($arr);
// 		if ($update) {
			//$user_name = $this->user_db->where(array('user_id' => $_GET['id']))->get_field('user_name');
			$merchants_name = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $_GET['id'])->pluck(RC_DB::raw('merchants_name'));
			if ($arr['is_settlement'] == 1) {
				ecjia_admin::admin_log(sprintf(__('商家名是 %s，订单编号是%s，已结算', 'store'), $merchants_name, $order_sn), 'setup', 'store_commission_status');
			} else {
				ecjia_admin::admin_log(sprintf(__('商家名是%s，订单编号是%s，未结算 ', 'store'),$merchants_name, $order_sn), 'setup', 'store_commission_status');
			}
			return $this->showmessage(__('结算状态修改成功！', 'store'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_commission/order_list',array('id' => $_GET['id']))));
// 		} else {
// 			return $this->showmessage('结算状态修改失败！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
// 		}
	}

	public function get_shop_name() {
		$filter = $_GET['JSON'];
		$filter = (object)$filter;

		$user_id  = $filter->user_id;
		$date     = array('shoprz_brandName, shopNameSuffix');
		$user     = get_table_date('merchants_shop_information', "user_id = '$user_id'", $date);
		if (empty($user['shoprz_brandName'])) {
			$user['shoprz_brandName'] = '';
		}
		if (empty($user['shopNameSuffix'])) {
			$user['shopNameSuffix'] = '';
		}
		$user['user_id'] = $user_id;
		$opt = array(
			'value' => $user['shoprz_brandName'],
			'text'  => $user['shopNameSuffix']
		);
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $opt));
	}
	
	public function fund() {
		$this->admin_priv('store_fund_manage');
		$this->assign('form_action', RC_Uri::url('store/admin_commission/update'));
		
		$store_id = $_GET['store_id'];
		$this->assign('store_id', $store_id);
		$store = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $store_id)->first();
		
		if ($store['manage_mode'] == 'self') {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('自营店铺', 'store'),RC_Uri::url('store/admin/init')));
			$this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => __('自营店铺列表', 'store')));
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('入驻商家', 'store'),RC_Uri::url('store/admin/join')));
			$this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => __('入驻商家列表', 'store')));
		}
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('资金管理', 'store')));
		
		ecjia_screen::get_current_screen()->set_sidebar_display(false);
		ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
		ecjia_screen::get_current_screen()->add_option('current_code', 'store_fund');
		
		$this->assign('ur_here', $store['merchants_name'].' - '.__('资金管理', 'store'));
		$this->assign('merchants_name', $store['merchants_name']);
		
		//store_account
		$account = $this->get_store_account($store_id);
		$this->assign('account', $account);
		
		//store_account_log
		$data = $this->get_account_log($store_id);
		$this->assign('data', $data);
		
		$this->display('store_fund_list.dwt');
	}

	/**
	 *  获取商家佣金列表
	 */
	//private function store_commission_list() {
	//	$filter['sort_by'] = empty($_GET['sort_by']) ?  RC_DB::raw('sc.id') : trim($_GET['sort_by']);
	//	$filter['sort_order'] = empty($_GET['sort_order']) ? 'ASC' : trim($_GET['sort_order']);

	//	$count = RC_DB::table('store_commission')->count();
	//	$page = new ecjia_page($count,10,5);

	//	$dbview = RC_DB::table('store_commission as sc')
	//			 ->leftJoin('store_franchisee as sf', RC_DB::raw('sc.store_id'), '=', RC_DB::raw('sf.store_id'))
	//			 ->leftJoin('store_percent as sp', RC_DB::raw('sc.percent_id'), '=', RC_DB::raw('sp.percent_id'));

	//	$data =  $dbview
	//	         ->select(RC_DB::raw('sf.merchants_name, sf.contact_mobile, sf.store_id, sc.percent_id, sp.percent_value, sc.id'))
	//			 ->orderBy($filter['sort_by'], $filter['sort_order'])
	//			 ->groupBy(RC_DB::raw('sc.store_id'))
    //    		 ->take(10)
    //    		 ->skip($page->start_id-1)
    //    		 ->get();

	//	if (!empty($data)) {
	//		foreach ($data as $key => $val) {
	//			//$valid = $this->get_nerchants_order_valid_refund($val['user_id']); //订单有效总额
	//			$valid = $this->get_nerchants_order_valid_refund($val['store_id']);//订单有效总额
	//			$data[$key]['order_valid_total'] = price_format($valid['total_fee']);

				//$data[$key]['percent_value'] = $this->mpdb->where(array('percent_id'=>$val['suppliers_percent']))->get_field('percent_value');

	//			$refund = $this->get_nerchants_order_valid_refund($val['store_id'], 1); //订单退款总额
	//			$data[$key]['order_refund_total'] = price_format($refund['total_fee']);
	//		}
	//	}

	//	$arr = array('item' => $data, 'filter'=>$filter,'page' => $page->show(2), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
	//	return $arr;
	//}

	//佣金百分比
	private function get_suppliers_percent() {
		$res = RC_DB::table('store_percent')
				 ->select(RC_DB::raw('percent_id'), RC_DB::raw('percent_value'))
				 ->orderBy('sort_order', 'asc')
		         ->get();

		return $res;
	}
	//获取列表商家
	//private function get_merchants_user_list() {
	//	$msidb = RC_Loader::load_app_model('merchants_shop_information_model','seller');
	//	$res = $msidb->select();
	//	$arr = array();
	//	if (!empty($res)) {
	//		foreach ($res as $key=>$row) {
	//			$arr[$key] = $row;
	//			$data = array('user_name');
	//			$user_name = get_table_date('users', "user_id = '" .$row['user_id']. "'", $data, 2);
	//			$arr[$key]['user_name'] = $user_name;
	//		}
	//	}
	//	return $arr;
	//}


	//商家订单有效金额和退款金额
	//private function get_nerchants_order_valid_refund($store_id, $type = 0) {

	//	$where =array();
	//	if ($type == 1) {
	//		$where = array(
	//				'o.order_status'		=> OS_RETURNED,
	//				'o.shipping_status'		=> SS_UNSHIPPED,
	//				'o.pay_status'			=> PS_UNPAYED
	//		);
	//	} else {
	//		$order_query = RC_Loader::load_app_class('order_query', 'store');
	//		$where = $order_query->order_finished('o.');
	//	}
	//	$total_fee  = "SUM(" . order_amount_field('o.', $store_id) . ") AS total_fee ";
	//	$order_info = RC_Loader::load_app_model('order_info_viewmodel', 'store');

	//	$where = array_merge($where, array('store_id' => $store_id));

	//	$res   = $order_info->join(array('order_goods', 'order_info'))->field($total_fee)->where($where)->group('o.order_id')->find();
	//	return $res;
	//}

	/**
	 * 生成查询订单的sql
	 * @param   string  $type   类型
	 * @param   string  $alias  order表的别名（包括.例如 o.）
	 * @return  string
	 */
	private function order_query_sql($type = 'finished', $alias = '') {
		/* 已完成订单 */
		if ($type == 'finished') {
			return " AND {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .
			" AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) .
			" AND {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " ";
		}
		/* 待发货订单 */
		elseif ($type == 'await_ship') {
			return " AND   {$alias}order_status " .
			db_create_in(array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) .
			" AND   {$alias}shipping_status " .
			db_create_in(array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) .
			" AND ( {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " OR {$alias}pay_id " . db_create_in(payment_id_list(true)) . ") ";
		}
		/* 待付款订单 */
		elseif ($type == 'await_pay') {
			return " AND   {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) .
			" AND   {$alias}pay_status = '" . PS_UNPAYED . "'" .
			" AND ( {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " OR {$alias}pay_id " . db_create_in(payment_id_list(false)) . ") ";
		}
		/* 未确认订单 */
		elseif ($type == 'unconfirmed') {
			return " AND {$alias}order_status = '" . OS_UNCONFIRMED . "' ";
		}
		/* 未处理订单：用户可操作 */
		elseif ($type == 'unprocessed') {
			return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
			" AND {$alias}shipping_status = '" . SS_UNSHIPPED . "'" .
			" AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
		}
		/* 未付款未发货订单：管理员可操作 */
		elseif ($type == 'unpay_unship') {
			return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) .
			" AND {$alias}shipping_status " . db_create_in(array(SS_UNSHIPPED, SS_PREPARING)) .
			" AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
		}
		/* 已发货订单：不论是否付款 */
		elseif ($type == 'shipped') {
			return " AND {$alias}order_status = '" . OS_CONFIRMED . "'" .
			" AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " ";
		}
		else {
			die('函数 order_query_sql 参数错误');
		}
	}

	/**
	 * 创建像这样的查询: "IN('a','b')";
	 *
	 * @access public
	 * @param mix $item_list
	 *        	列表数组或字符串
	 * @param string $field_name
	 *        	字段名称
	 *
	 * @return void
	 */
	private function db_create_in($item_list, $field_name = '') {
		if (empty ( $item_list )) {
			return $field_name . " IN ('') ";
		} else {
			if (! is_array ( $item_list )) {
				$item_list = explode ( ',', $item_list );
			}
			$item_list = array_unique ( $item_list );
			$item_list_tmp = '';
			foreach ( $item_list as $item ) {
				if ($item !== '') {
					$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
				}
			}
			if (empty ( $item_list_tmp )) {
				return $field_name . " IN ('') ";
			} else {
				return $field_name . ' IN (' . $item_list_tmp . ') ';
			}
		}
	}

	/**
	 *  获取商家订单列表
	 */
	private function store_order_list($store_id = 0) {

		$filter['sort_by']    = empty($_GET['sort_by']) ? RC_DB::raw('o.order_id') : trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order']) ? 'DESC' : trim($_GET['sort_order']);

		$filter['start_time'] = empty($_GET['start_time']) ? '' : RC_Time::local_strtotime(trim($_GET['start_time']));
		$filter['end_time']   = empty($_GET['end_time']) ? '' : RC_Time::local_strtotime(trim($_GET['end_time']));

		$where  = '1';
		$count  = RC_DB::table('order_info')->select(RC_DB::raw('count(*)'))->get();
		$string = RC_DB::table('order_info')->toSql();


		$where .= " AND o.is_delete = 0 AND o.store_id = '$store_id' ";
		if (!empty($filter['start_time'])) {
			$where .= " AND o.add_time > '" .$filter['start_time'] . "'";
		}
		if(!empty($filter['end_time'])){
			$where .= " AND o.add_time < '" .$filter['end_time']. "'";
		}

		//$res = $this->oi_viewdb->join(array('users','order_goods','goods'))->field('o.order_id')->where($where)->select();
		$dbview = RC_DB::table('order_info as o')
				->leftJoin('users as u', RC_DB::raw('u.user_id'), '=', RC_DB::raw('o.user_id'))
				->leftJoin('order_goods as og', RC_DB::raw('o.order_id'), '=', RC_DB::raw('og.order_id'))
				->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('og.goods_id'));

				$res	=  $dbview->select(RC_DB::raw('o.order_id'))->whereRaw($where)->groupBy(RC_DB::raw('o.order_id'))->get();

		$count = count($res);

		$page = new ecjia_page($count,10,5);

		//$field = "o.store_id, o.order_id, o.order_sn, o.add_time, o.order_status, o.shipping_status, o.order_amount, o.money_paid, o.is_delete, o.is_settlement," .
		//		 "o.shipping_time, o.auto_delivery_time, o.pay_status, o.consignee, o.address, o.email, o.tel, o.extension_code, o.extension_id, " .
		//		 "(" . get_order_amount_field('o.') . ") AS total_fee, " .
		//		 "IFNULL(u.user_name, '" . RC_Lang::get('store::store.anonymous'). "') AS buyer ";

		$field1 = "o.store_id, o.order_id, o.order_sn, o.add_time, o.order_status, o.shipping_status, o.order_amount, o.money_paid, o.is_delete, o.is_settlement";
		$field2 = "o.shipping_time, o.auto_delivery_time, o.pay_status, o.consignee, o.address, o.email, o.tel, o.extension_code, o.extension_id";
		$field3 = "(". get_order_amount_field('o.') .") AS buyer ";
		$field4 = " IFNULL(u.user_name, '匿名用户') AS buyer ";

		//$row = $this->oi_viewdb->join(array('users','order_goods','goods'))->field($field)->where($where)->order(array($filter['sort_by'] => $filter['sort_order']))->limit($page->limit())->select();

		$row = $dbview
				 ->select(RC_DB::raw($field1), RC_DB::raw($field2), RC_DB::raw($field3), RC_DB::raw($field4))
				 ->whereRaw($where)
				 ->orderBy($filter['sort_by'], $filter['sort_order'])
				 ->groupBy(RC_DB::raw('o.order_id'))
				 ->take(10)
				 ->skip($page->start_id-1)
				 ->get();

		$data_count = count($row);

		for ($i=0; $i<$data_count; $i++) {
			$row[$i]['formated_order_amount'] 	= price_format($row[$i]['order_amount']);
			$row[$i]['formated_money_paid'] 	= price_format($row[$i]['money_paid']);
			$row[$i]['formated_total_fee'] 		= price_format($row[$i]['total_fee']);
			$row[$i]['short_order_time'] 		= RC_Time::local_date('Y-m-d H:i', $row[$i]['add_time']);

			$percent_id = RC_DB::table('store_commission')
							->where(RC_DB::raw('store_id'), $row[$i]['store_id'])
			                ->pluck(RC_DB::raw('percent_id'));
			$percent_value = RC_DB::table('store_percent')
							   ->where(RC_DB::raw('percent_id'), $percent_id)
			                   ->pluck(RC_DB::raw('percent_value'));

			if ($percent_value == 0) {
				$percent_value = 1;
			} else {
				$percent_value = $percent_value/100;
			}

			$row[$i]['formated_brokerage_amount'] = price_format($row[$i]['total_fee'] * $percent_value);

			$filter['all_brokerage_amount'] += $row[$i]['total_fee'] * $percent_value;
		}
		if (!empty($filter['all_brokerage_amount'])) {
			$filter['all_brokerage_amount'] = price_format($filter['all_brokerage_amount']);
		}
    	$arr = array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
    	return $arr;
	}
	
	//获取店铺账户信息
	private function get_store_account($store_id = 0) {
		$data = RC_DB::table('store_account')->where('store_id', $store_id)->first();
		if (empty($data)) {
			$data['formated_amount_available'] = $data['formated_money'] = $data['formated_frozen_money'] = $data['formated_deposit'] = '￥0.00';
			$data['amount_available'] = $data['money'] = $data['frozen_money'] = $data['deposit'] = '0.00';
		} else {
			$amount_available = $data['money'] - $data['deposit'];//可用余额=money-保证金
			$data['formated_amount_available'] = price_format($amount_available);
			$data['amount_available'] = $amount_available;
				
			$money = $data['money'] + $data['frozen_money'];//总金额=money+冻结
			$data['formated_money'] = price_format($money);
			$data['money'] = $money;
				
			$data['formated_frozen_money'] = price_format($data['frozen_money']);
			$data['formated_deposit'] = price_format($data['deposit']);
		}
		return $data;
	}
	
	//获取资金明细
	private function get_account_log($store_id = 0) {
		$db = RC_DB::table('store_account_log');
	
		$db->where('store_id', $store_id);
		$count = $db->count();
		$page = new ecjia_page($count, 10, 5);
		$data = $db->take(10)->skip($page->start_id - 1)->orderBy('change_time', 'desc')->orderBy('log_id', 'desc')->get();
		if (!empty($data)) {
			foreach ($data as $k => $v) {
				$data[$k]['change_time'] = RC_Time::local_date('Y-m-d H:i:s', $v['change_time']);
			}
		}
		return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

//end

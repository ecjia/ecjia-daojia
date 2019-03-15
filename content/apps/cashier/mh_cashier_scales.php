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
 * 店铺条码秤
 */
class mh_cashier_scales extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		Ecjia\App\Cashier\Helper::assign_adminlog_content();
		
        RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
        
        RC_Script::enqueue_script('mh_cashdesk_scales', RC_App::apps_url('statics/js/mh_cashdesk_scales.js', __FILE__), array(), false, 1);
        RC_Script::localize_script('mh_cashdesk_scales', 'js_lang', config('app-cashier::jslang.cashdesk_scales_page'));

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('条码秤管理', 'cashier'), RC_Uri::url('cashier/mh_cashier_scales/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('merchant', 'merchant/cashdesk_scales.php');
	}

	/**
	 * 店铺条码秤列表
	 */
	public function init() {
		$this->admin_priv('mh_scales_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('条码秤', 'cashier')));
		$this->assign('app_url', RC_App::apps_url('statics', __FILE__));

		$this->assign('ur_here', __('条码秤', 'cashier'));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_scales/add'), 'text' => __('添加条码秤', 'cashier')));
        
      	$scales_list = $this->scales_list();
      	
		$this->assign('scales_list', $scales_list);

		$this->display('cashdesk_scales_list.dwt');
	}
	
	/**
	 * 添加条码秤
	 */
	public function add() {
		// 检查权限
		$this->admin_priv('mh_scales_update');
	
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('条码秤列表', 'cashier')));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_scales/init'), 'text' => __('条码秤列表', 'cashier')));
	
		$this->assign('ur_here', __('添加条码秤', 'cashier'));
	
		$this->assign('form_action', RC_Uri::url('cashier/mh_cashier_scales/insert'));
	
		$this->display('cashdesk_scales_info.dwt');
	}
	
	/**
	 * 添加条码秤数据处理
	 */
	public function insert() {
		// 检查权限
		$this->admin_priv('mh_scales_update', ecjia::MSGTYPE_JSON);
		
		$barcode_mode 		= !empty($_POST['barcode_mode'])  ? $_POST['barcode_mode'] : 1;
		$scale_sn 			= !empty($_POST['scale_sn'])  ? trim($_POST['scale_sn']) : '';
		$date_format 		= !empty($_POST['date_format'])  ? $_POST['date_format'] : 1;
		$weight_unit 		= !empty($_POST['weight_unit'])  ? $_POST['weight_unit'] : 1;
		$price_unit 		= !empty($_POST['price_unit'])  ? $_POST['price_unit'] : 1;
		$wipezero 			= empty($_POST['wipezero']) ? 0 : $_POST['wipezero'];
		$reserve_quantile 	= empty($_POST['reserve_quantile']) ? 0 : $_POST['reserve_quantile'];
		
		if (empty($scale_sn)) {
			return $this->showmessage(__('请输入条码秤码！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		//条码秤码是否重复
		$count = RC_DB::table('cashier_scales')->where('store_id', $_SESSION['store_id'])->where('scale_sn', $scale_sn)->count();
		if ($count > 0) {
			return $this->showmessage(__('条码秤码已存在，请重新输入！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$scale_sn_length = strlen($scale_sn);
		if ($scale_sn_length != 2) {
			return $this->showmessage(__('请输入2位数的条码秤码！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array(
				'barcode_mode' 		=> $barcode_mode,
				'scale_sn'	   		=> $scale_sn,
				'date_format'		=> $date_format,
				'weight_unit'		=> $weight_unit,
				'price_unit'		=> $price_unit,
				'wipezero'			=> $wipezero,
				'reserve_quantile'	=> $reserve_quantile,
				'store_id'			=> $_SESSION['store_id']
		);
		
		$id = RC_DB::table('cashier_scales')->insertGetId($data);
	
		/* 记录日志 */
		ecjia_merchant::admin_log(sprintf(__('条码秤码%s', 'cashier'), $scale_sn), 'add', 'scales');
		return $this->showmessage(__('添加条码秤成功！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cashier/mh_cashier_scales/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑条码秤
	 */
	public function edit() {
		$this->admin_priv('mh_scales_update');
	
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('条码秤列表', 'cashier'), RC_Uri::url('cashier/mh_cashier_scales/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑条码秤', 'cashier')));
	
		$this->assign('ur_here', __('编辑条码秤', 'cashier'));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_scales/init'), 'text' => __('条码秤列表', 'cashier')));
		$id = $_GET['id'];
		/* 条码秤信息 */
		$scales_info = RC_DB::table('cashier_scales')->where('id', $id)->where('store_id', $_SESSION['store_id'])->first();
	
		$this->assign('scales_info', $scales_info);
		$this->assign('id', $id);
		
		/* 显示商品信息页面 */
		$this->assign('form_action', RC_Uri::url('cashier/mh_cashier_scales/update'));
		$this->display('cashdesk_scales_info.dwt');
	}
	
	/**
	 * 编辑条码秤处理
	 */
	public function update() {
		$this->admin_priv('mh_scales_update', ecjia::MSGTYPE_JSON);
	
		$id = $_POST['id'];
		$barcode_mode 		= !empty($_POST['barcode_mode'])  ? $_POST['barcode_mode'] : 1;
		$scale_sn 			= !empty($_POST['scale_sn'])  ? trim($_POST['scale_sn']) : '';
		$date_format 		= !empty($_POST['date_format'])  ? $_POST['date_format'] : 1;
		$weight_unit 		= !empty($_POST['weight_unit'])  ? $_POST['weight_unit'] : 1;
		$price_unit 		= !empty($_POST['price_unit'])  ? $_POST['price_unit'] : 1;
		$wipezero 			= $_POST['wipezero'];
		$reserve_quantile 	= $_POST['reserve_quantile'];
		
		if (empty($scale_sn)) {
			return $this->showmessage(__('请输入条码秤码！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		//条码秤码重复判断
		$count = RC_DB::table('cashier_scales')->where('store_id', $_SESSION['store_id'])->where('scale_sn', $scale_sn)->where('id', '!=', $id)->count();
		if ($count > 0) {
			return $this->showmessage(__('条码秤码已存在！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$scale_sn_length = strlen($scale_sn);
		if ($scale_sn_length != '2') {
			return $this->showmessage(__('请输入2位数的条码秤码！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array(
				'barcode_mode' 		=> $barcode_mode,
				'scale_sn'	   		=> $scale_sn,
				'date_format'		=> $date_format,
				'weight_unit'		=> $weight_unit,
				'price_unit'		=> $price_unit,
				'wipezero'			=> empty($wipezero) ? 0 : $wipezero,
				'reserve_quantile'	=> empty($reserve_quantile) ? 0 : $reserve_quantile
		);
		RC_DB::table('cashier_scales')->where('id', $id)->where('store_id', $_SESSION['store_id'])->update($data);
		/* 记录日志 */
		ecjia_merchant::admin_log(__('条码秤码', 'cashier').$scale_sn, 'edit', 'scales');
		
		return $this->showmessage(__('编辑条码秤成功', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cashier/mh_cashier_scales/edit', array('id' => $id))));
	}
	
	/**
	 * 条码秤是否抹零切换
	 */
	public function toggle_wipezero() {
		$this->admin_priv('mh_scales_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['id']);
		$is_wipezero = intval($_POST['val']);
	
		$data = array(
				'wipezero' 	=> $is_wipezero,
		);
		RC_DB::table('cashier_scales')->where('id', $id)->where('store_id', $_SESSION['store_id'])->update($data);
	
		return $this->showmessage(__('已成功切状态', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 条码秤是否保留分位切换
	 */
	public function toggle_reserve_quantile() {
		$this->admin_priv('mh_scales_update', ecjia::MSGTYPE_JSON);
	
		$id = intval($_POST['id']);
		$is_reserve_quantile = intval($_POST['val']);
		
		$data = array(
				'reserve_quantile' 	=> $is_reserve_quantile,
		);
		RC_DB::table('cashier_scales')->where('id', $id)->where('store_id', $_SESSION['store_id'])->update($data);
	
		return $this->showmessage(__('已成功切状态', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取条码秤列表
	 */
	private function scales_list() {
		$store_id = $_SESSION['store_id'];
		$db = RC_DB::table('cashier_scales');
	
		$db->where('store_id', $store_id);
		
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
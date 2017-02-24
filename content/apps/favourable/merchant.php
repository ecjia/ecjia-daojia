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
 * 管理中心优惠活动管理
 * @author songqian
 */
class merchant extends ecjia_merchant {
	private $db_favourable_activity;

	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('admin_favourable');
		$this->db_favourable_activity = RC_Model::model('favourable/favourable_activity_model');

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('bootstrap-editable',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);

        /*快速编辑*/
        RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array());
		RC_Style::enqueue_style('bootstrap-editable-css', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css', array(), false, false);

		//时间控件
		RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));

		RC_Script::enqueue_script('favourable_list', RC_App::apps_url('statics/js/merchant_favourable_list.js', __FILE__));
		RC_Script::localize_script('favourable_list', 'js_lang', RC_Lang::get('favourable::favourable.js_lang'));

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('优惠活动管理'), RC_Uri::url('favourable/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('promotion', 'promotion/merchant.php');
	}

	/**
	 * 活动列表页
	 */
	public function init() {
		$this->admin_priv('favourable_manage');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('favourable::favourable.favourable_list')));
		

		$this->assign('ur_here', RC_Lang::get('favourable::favourable.favourable_list'));
		$this->assign('action_link', array('href' => RC_Uri::url('favourable/merchant/add'), 'text' => RC_Lang::get('favourable::favourable.add_favourable')));

		$list = $this->get_favourable_list();
		$this->assign('favourable_list', $list);
		$this->assign('search_action', RC_Uri::url('favourable/merchant/init'));

		$this->display('favourable_list.dwt');
	}

	/**
	 * 添加页面
	 */
	public function add() {
		$this->admin_priv('favourable_update');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('favourable::favourable.add_favourable')));
		$this->assign('ur_here', RC_Lang::get('favourable::favourable.add_favourable'));
		$this->assign('action_link', array('text' => RC_Lang::get('favourable::favourable.favourable_list'), 'href' => RC_Uri::url('favourable/merchant/init')));
		$favourable = array (
			'act_id'        => 0,
			'act_name'      => '',
    		'start_time'    => RC_Time::local_date('Y-m-d H:i', RC_Time::gmtime()),
			'end_time'      => RC_Time::local_date('Y-m-d H:i',RC_Time::local_strtotime("+1 month")),
			'user_rank'     => '',
			'act_range'     => FAR_ALL,
			'act_range_ext' => '',
			'min_amount'    => 0,
			'max_amount'    => 0,
			'act_type'      => FAT_GOODS,
			'act_type_ext'  => 0,
			'gift'          => array()
		);
		$this->assign('favourable', $favourable);

		$user_rank_list   = array();
		$user_rank_list[] = array(
    			'rank_id'   => 0,
    			'rank_name' => RC_Lang::get('favourable::favourable.not_user'),
    			'checked'   => strpos(',' . $favourable['user_rank'] . ',', ',0,') !== false
		);
		$data = RC_DB::table('user_rank')->select('rank_id', 'rank_name')->get();

		if (!empty($data)) {
			foreach ($data as $key => $row) {
				$row['checked']   = strpos(',' . $favourable['user_rank'] . ',', ',' . $key. ',') !== false;
				$user_rank_list[] = $row;
			}
		}
		$this->assign('user_rank_list', $user_rank_list);

		$act_range_ext = array();

		if ($favourable['act_range'] != FAR_ALL && !empty($favourable['act_range_ext'])) {
			$favourable['act_range_ext'] = explode(',', $favourable['act_range_ext']);
			if ($favourable['act_range'] == FAR_CATEGORY) {
				$act_range_ext = RC_DB::table('category')
                				->whereIn('cat_id', $favourable['act_range_ext'])
                				->select(RC_DB::raw('cat_id as id'), RC_DB::raw('cat_name as name'))
                				->get();
			} elseif ($favourable['act_range'] == FAR_BRAND) {
				$act_range_ext = RC_DB::table('brand')
                				->whereIn('brand_id', $favourable['act_range_ext'])
                				->select(RC_DB::raw('brand_id as id'), RC_DB::raw('brand_name as name'))
                				->get();
			} else {
				$act_range_ext = RC_DB::table('goods')
                				->whereIn('goods_id', $favourable['act_range_ext'])
                				->where(RC_DB::raw('store_id'), $_SESSION['store_id'])
                				->select(RC_DB::raw('goods_id as id'), RC_DB::raw('goods_name as name'))
                				->get();
			}
		}

		$this->assign('act_range_ext', $act_range_ext);
		$this->assign('form_action', RC_Uri::url('favourable/merchant/insert'));

		$this->display('favourable_info.dwt');
	}

	/**
	 * 添加处理
	 */
	public function insert() {
		$this->admin_priv('favourable_update' ,ecjia::MSGTYPE_JSON);

		$act_name = !empty($_POST['act_name']) 		? trim($_POST['act_name']) 		: '';
		$store_id = !empty($_SESSION['store_id']) 	? intval($_SESSION['store_id']) : 0;
		
		if (RC_DB::table('favourable_activity')->where('act_name', $act_name)->where('store_id', $store_id)->count() > 0) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.act_name_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$start_time = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time'])   : '';
		$end_time   = !empty($_POST['end_time'])   ? RC_Time::local_strtotime($_POST['end_time'])     : '';

		if ($start_time >= $end_time) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.start_lt_end'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 检查享受优惠的会员等级 */
		if (!isset($_POST['user_rank']) || empty($_POST['user_rank'])) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.pls_set_user_rank'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 检查优惠范围扩展信息 */
		if ($_POST['act_range'] > 0 && !isset($_POST['act_range_ext'])) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.pls_set_act_range'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 检查金额上下限 */
		$min_amount = floatval($_POST['min_amount']) >= 0 ? floatval($_POST['min_amount']) : 0;
		$max_amount = floatval($_POST['max_amount']) >= 0 ? floatval($_POST['max_amount']) : 0;
		if ($max_amount > 0 && $min_amount > $max_amount) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($_POST['act_type'] == 1 && $_POST['min_amount'] < $_POST['act_type_ext']) {
		    return $this->showmessage('现金减免不能超过金额下限', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 提交值 */
		$favourable = array(
			'act_name'      => $act_name,
			'start_time'    => $start_time,
			'end_time'      => $end_time,
			'user_rank'     => isset($_POST['user_rank']) ? join(',', $_POST['user_rank']) : '0',
			'act_range'     => intval($_POST['act_range']),
			'act_range_ext' => intval($_POST['act_range']) == 0 ? '' : join(',', $_POST['act_range_ext']),
			'min_amount'    => $min_amount,
			'max_amount'    => $max_amount,
			'act_type'      => intval($_POST['act_type']),
			'act_type_ext'  => floatval($_POST['act_type_ext']),
			'store_id'		=> !empty($_SESSION['store_id']) ? $_SESSION['store_id'] : 0,
		);

        if ($favourable['act_type'] == 1) {
			$act_type = RC_Lang::get('favourable::favourable.fat_price');
        } elseif ($favourable['act_type'] == 2) {
			$act_type = RC_Lang::get('favourable::favourable.fat_discount');
		}
		$act_id = $this->db_favourable_activity->favourable_manage($favourable);
		
		/* 释放优惠活动缓存*/
		$favourable_activity_db = RC_Model::model('favourable/orm_favourable_activity_model');
		$cache_favourable_key   = 'favourable_list_store_'.$store_id;
		$cache_id               = sprintf('%X', crc32($cache_favourable_key));
		$favourable_activity_db->delete_cache_item($cache_id);

		ecjia_merchant::admin_log($favourable['act_name'].'，'.RC_Lang::get('favourable::favourable.favourable_way_is').$act_type, 'add', 'favourable');
		$links[] = array('text' => RC_Lang::get('favourable::favourable.back_favourable_list'), 'href' => RC_Uri::url('favourable/merchant/init'));
		$links[] = array('text' => RC_Lang::get('favourable::favourable.continue_add_favourable'), 'href' => RC_Uri::url('favourable/merchant/add'));

		return $this->showmessage(RC_Lang::get('favourable::favourable.add_favourable_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('favourable/merchant/edit', array('act_id' => $act_id))));
	}

	/**
	 * 编辑
	 */
	public function edit() {
		$this->admin_priv('favourable_update');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('favourable::favourable.edit_favourable')));
		$this->assign('ur_here', RC_Lang::get('favourable::favourable.edit_favourable'));
		$this->assign('action_link', array('text' => RC_Lang::get('favourable::favourable.favourable_list'), 'href' => RC_Uri::url('favourable/merchant/init')));

		$id         = !empty($_GET['act_id']) ? intval($_GET['act_id']) : 0;
		$favourable = $this->db_favourable_activity->favourable_info($id);

		if (empty($favourable)) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.favourable_not_exist'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}

		$this->assign('favourable', $favourable);
		$this->assign('user_rank_list', $favourable['user_rank_list']);
		$this->assign('act_range_ext', $favourable['act_range_ext']);

		$this->assign('form_action', RC_Uri::url('favourable/merchant/update'));

		$this->display('favourable_info.dwt');
	}

	/**
	 * 编辑处理
	 */
	public function update() {
		$this->admin_priv('favourable_update', ecjia::MSGTYPE_JSON);

		$act_name 	= !empty($_POST['act_name']) 	? trim($_POST['act_name']) 		: '';
		$act_id 	= !empty($_POST['act_id']) 		? intval($_POST['act_id']) 		: 0;
		$store_id 	= !empty($_SESSION['store_id']) ? intval($_SESSION['store_id']) : 0;
		
		if (RC_DB::table('favourable_activity')->where('act_name', $act_name)->where('act_id', '!=', $act_id)->where('store_id', $store_id)->count() > 0) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.act_name_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$start_time = !empty($_POST['start_time'])	? RC_Time::local_strtotime($_POST['start_time']) 	: '';
		$end_time 	= !empty($_POST['end_time']) 	? RC_Time::local_strtotime($_POST['end_time']) 		: '';
		/* 检查优惠活动时间 */
		if ($start_time >= $end_time) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.start_lt_end'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 检查享受优惠的会员等级 */
		if (!isset($_POST['user_rank']) || empty($_POST['user_rank'])) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.pls_set_user_rank'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 检查优惠范围扩展信息 */
		if ($_POST['act_range'] > 0 && !isset($_POST['act_range_ext'])) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.pls_set_act_range'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 判断是否在优惠范围内 */
		if ($_POST['act_range'] != 0 && $_POST['act_range'] != 3) {
		    return $this->showmessage(RC_Lang::get('favourable::favourable.pls_set_act_range'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 检查金额上下限 */
		$min_amount = floatval($_POST['min_amount']) >= 0 ? floatval($_POST['min_amount']) : 0;
		$max_amount = floatval($_POST['max_amount']) >= 0 ? floatval($_POST['max_amount']) : 0;
		if ($max_amount > 0 && $min_amount > $max_amount) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($_POST['act_type'] == 1 && $_POST['min_amount'] < $_POST['act_type_ext']) {
		    return $this->showmessage('现金减免不能超过金额下限', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 提交值 */
		$favourable = array(
			'act_id'		=> $act_id,
			'act_name'      => $act_name,
			'start_time'    => $start_time,
			'end_time'      => $end_time,
			'user_rank'     => isset($_POST['user_rank']) ? join(',', $_POST['user_rank']) : '0',
			'act_range'     => intval($_POST['act_range']),
			'act_range_ext' => intval($_POST['act_range']) == 0 ? '' : join(',', $_POST['act_range_ext']),
			'min_amount'    => $min_amount,
			'max_amount'    => $max_amount,
			'act_type'      => intval($_POST['act_type']),
			'act_type_ext'  => floatval($_POST['act_type_ext']),
		);
        if ($favourable['act_type'] == 1) {
			$act_type = RC_Lang::get('favourable::favourable.fat_price');
        } elseif ($favourable['act_type'] == 2) {
			$act_type = RC_Lang::get('favourable::favourable.fat_discount');
		}
		$this->db_favourable_activity->favourable_manage($favourable);
		
		/* 释放优惠活动缓存*/
		$favourable_activity_db = RC_Model::model('favourable/orm_favourable_activity_model');
		$cache_favourable_key   = 'favourable_list_store_'.$store_id;
		$cache_id               = sprintf('%X', crc32($cache_favourable_key));
		$favourable_activity_db->delete_cache_item($cache_id);

		ecjia_merchant::admin_log($favourable['act_name'].'，'.RC_Lang::get('favourable::favourable.favourable_way_is').$act_type, 'edit', 'favourable');
		return $this->showmessage(RC_Lang::get('favourable::favourable.edit_favourable_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('favourable/merchant/edit', array('act_id' => $act_id))));
	}

	/**
	 * 删除
	 */
	public function remove() {
		$this->admin_priv('favourable_delete', ecjia::MSGTYPE_JSON);

		$id         = intval($_GET['act_id']);
		$favourable = $this->db_favourable_activity->favourable_info($id);
		if (empty($favourable)) {
			return $this->showmessage(RC_Lang::get('favourable::favourable.favourable_not_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$name     = $favourable['act_name'];
		$act_type = $favourable['act_type'];

		if ($act_type == 0) {
			$act_type = RC_Lang::get('favourable::favourable.fat_goods');
		} elseif ($act_type == 1) {
			$act_type = RC_Lang::get('favourable::favourable.fat_price');
		} else {
			$act_type = RC_Lang::get('favourable::favourable.fat_discount');
		}

		$this->db_favourable_activity->favourable_remove($id);
		/*释放优惠活动缓存*/
		$favourable_activity_db = RC_Model::model('favourable/orm_favourable_activity_model');
		$cache_favourable_key   = 'favourable_list_store_'.$_SESSION['store_id'];
		$cache_id               = sprintf('%X', crc32($cache_favourable_key));
		$favourable_activity_db->delete_cache_item($cache_id);

		ecjia_merchant::admin_log($name.'，'.RC_Lang::get('favourable::favourable.favourable_way_is').$act_type, 'remove', 'favourable');
		return $this->showmessage(RC_Lang::get('favourable::favourable.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 批量操作
	 */
	public function batch() {
		$this->admin_priv('favourable_delete', ecjia::MSGTYPE_JSON);

		$ids      = $_POST['act_id'];
		$act_ids  = explode(',', $ids);
		$info     = RC_DB::table('favourable_activity')->whereIn('act_id', $act_ids)->get();

		$this->db_favourable_activity->favourable_remove($act_ids, true);
		if (!empty($info)) {
			foreach ($info as $v) {
				if ($v['act_type'] == 0) {
					$act_type = RC_Lang::get('favourable::favourable.fat_goods');
				} elseif ($v['act_type'] == 1) {
					$act_type = RC_Lang::get('favourable::favourable.fat_price');
				} else {
					$act_type = RC_Lang::get('favourable::favourable.fat_discount');
				}
				/*释放优惠活动缓存*/
				$favourable_activity_db = RC_Model::model('favourable/orm_favourable_activity_model');
				$cache_favourable_key   = 'favourable_list_store_'.$v['store_id'];
				$cache_id               = sprintf('%X', crc32($cache_favourable_key));
				
				$favourable_activity_db->delete_cache_item($cache_id);
				ecjia_merchant::admin_log($v['act_name'].'，'.RC_Lang::get('favourable::favourable.favourable_way_is').$act_type, 'batch_remove', 'favourable');
			}
		}
		return $this->showmessage(RC_Lang::get('favourable::favourable.batch_drop_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('favourable/merchant/init')));
	}
	/**
	 * 编辑优惠活动名称
	 */
	public function edit_act_name() {
		$this->admin_priv('favourable_update', ecjia::MSGTYPE_JSON);

		$act_name 	= trim($_POST['value']);
		$id			= intval($_POST['pk']);
		$store_id 	= !empty($_SESSION['store_id']) ? intval($_SESSION['store_id']) : 0;

		if (!empty($act_name)) {
			if (RC_DB::table('favourable_activity')->where('act_name', $act_name)->where('act_id', '!=', $id)->where('store_id', $store_id)->count() == 0) {
				$data = array(
					'act_id'	=> $id,
					'act_name'	=> $act_name
				);
				$this->db_favourable_activity->favourable_manage($data);
				/*释放优惠活动缓存*/
				$favourable_activity_db = RC_Model::model('favourable/orm_favourable_activity_model');
				$cache_favourable_key   = 'favourable_list_store_'.$_SESSION['store_id'];
				$cache_id               = sprintf('%X', crc32($cache_favourable_key));
				
				$favourable_activity_db->delete_cache_item($cache_id);
				return $this->showmessage(RC_Lang::get('favourable::favourable.edit_name_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				return $this->showmessage(RC_Lang::get('favourable::favourable.act_name_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(RC_Lang::get('favourable::favourable.pls_enter_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 修改排序
	 */
	public function edit_sort_order() {
		$this->admin_priv('favourable_update', ecjia::MSGTYPE_JSON);
		$id  = intval($_POST['pk']);
		$val = intval($_POST['value']);
		$data = array(
			'act_id' 		=> $id,
			'sort_order' 	=> $val
		);
		$this->db_favourable_activity->favourable_manage($data);

		return $this->showmessage(RC_Lang::get('favourable::favourable.sort_edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('favourable/merchant/init')) );
	}

	/**
	 * 搜索商品
	 */
	public function search() {
		$this->admin_priv('favourable_manage', ecjia::MSGTYPE_JSON);

		$act_range = !empty($_POST['act_range']) ? $_POST['act_range']     : 0;
		$keyword   = !empty($_POST['keyword'])   ? trim($_POST['keyword']) : '';
		$where = array();
		if ($act_range == FAR_ALL) {//全部商品
			$arr[0] = array(
				'id'   => 0,
				'name' => RC_Lang::get('favourable::favourable.all_need_not_search')
			);
		} elseif ($act_range == FAR_CATEGORY) {//按分类选择
			$db_category = RC_DB::table('merchants_category')->select(RC_DB::raw('cat_id as id'), RC_DB::raw('cat_name as name'));
			if (empty($keyword)) {
				$arr = $db_category->get();
				RC_Loader::load_app_func('merchant_goods', 'goods');
				$result = merchant_cat_list(0, 0, false);
				$arr = array();
				if (!empty($result)) {
					foreach ($result as $key => $row) {
						$arr[$key]['id'] 	= $row['cat_id'];
						$arr[$key]['level'] = $row['level'];
						$arr[$key]['name'] 	= $row['cat_name'];
					}
					$arr = array_merge($arr);
				}
			} else {
				$arr = $db_category->where('cat_name', 'like', '%'.mysql_like_quote($keyword).'%')->get();
			}
		} else {
			$db_goods = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->select(RC_DB::raw('goods_id as id'), RC_DB::raw('goods_name as name'));
			if (!empty($keyword)) {
				$db_goods->where('goods_name', 'like', '%'.mysql_like_quote($keyword).'%');
			}
			$db_goods->where('is_delete', 0);
			$arr = $db_goods->get();
			if (!empty($arr)) {
				foreach ($arr as $key => $row) {
					$arr[$key]['name'] = stripslashes($row['name']);
					$arr[$key]['url']  = RC_Uri::url('goods/merchant/preview', 'id='.$row['id']);
				}
			}
		}
		if (empty($arr)) {
			$arr = array(0 => array(
				'id'   => 0,
				'name' => RC_Lang::get('favourable::favourable.search_result_empty')
			));
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
	}

	/*
	 * 取得优惠活动列表
	*/
	private function get_favourable_list() {
		$filter['sort_by']    	= empty($_GET['sort_by']) 	? 'act_id' 				: trim($_GET['sort_by']);
		$filter['sort_order'] 	= empty($_GET['sort_order'])? 'DESC' 				: trim($_GET['sort_order']);
		$filter['keyword']		= empty($_GET['keyword']) 	? '' 					: mysql_like_quote(trim($_GET['keyword']));
		$filter['type'] 	 	= isset($_GET['type']) 		? trim($_GET['type']) 	: '';

		/* 连接导航*/
		$uri = array();
		empty($filter['keyword']) ? '' : $uri['keyword'] = $filter['keyword'];

		$quickuri = array(
			'init'			=> RC_Uri::url('favourable/merchant/init', $uri),
			'on_going'		=> RC_Uri::url('favourable/merchant/init', array_merge(array('type' => 'on_going'), $uri)),
		);

		/* 初始化优惠活动数量*/
		$favourable_count = array(
			'count'		=> 0,//全部
			'on_going'	=> 0,//进行中
		);

		$favourable_count['count']		= RC_Api::api('favourable', 'favourable_count', array('keyword' => $filter['keyword']));
		$favourable_count['on_going']	= RC_Api::api('favourable', 'favourable_count', array('keyword' => $filter['keyword'], 'type' => 'on_going'));


		if ($filter['type'] == 'on_going') {
			$page = new ecjia_merchant_page($favourable_count['on_going'], 15, 5);
		} else {
			$page = new ecjia_merchant_page($favourable_count['count'], 15, 5);
		}
		$filter['skip']   = $page->start_id-1;
		$filter['limit']  = 15;
		$data             = RC_Api::api('favourable', 'favourable_list', $filter);

		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['start_time']  = RC_Time::local_date('Y-m-d H:i', $row['start_time']);
				$row['end_time']    = RC_Time::local_date('Y-m-d H:i', $row['end_time']);
				$list[]             = $row;
			}
		}
		return array('item' => $list, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'count' => $favourable_count, 'quickuri' => $quickuri);
	}
}

//end
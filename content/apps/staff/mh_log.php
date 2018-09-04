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
 * 员工日志管理
 */
class mh_log extends ecjia_merchant {
	public function __construct() {
		parent::__construct();

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');

		RC_Script::enqueue_script('staff_logs', RC_App::apps_url('statics/js/staff_logs.js', __FILE__), array(), false, true);
		RC_Script::localize_script('staff_logs', 'js_lang', RC_Lang::get('staff::staff.js_lang'));

		ecjia_merchant_screen::get_current_screen()->set_parentage('staff', 'staff/merchant.php');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('员工管理', RC_Uri::url('staff/merchant/init')));
	}


	/**
	 * 员工日志列表页面
	 */
	public function init() {
		$this->admin_priv('staff_log_manage');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('员工日志'));
		$this->assign('ur_here', RC_Lang::get('staff::staff.log_list'));

		$logs = $this->get_admin_logs($_REQUEST);

		/* 查询IP地址列表 */
		$ip_list = array();
		$data = RC_DB::table('staff_log')->select(RC_DB::raw('distinct ip_address'))->get();
		if (!empty($data)) {
			foreach ($data as $row) {
				$ip_list[] = $row['ip_address'];
			}
		}

		/* 查询管理员列表 */
		$user_list = array();
		$userdata = RC_DB::table('staff_user')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->get();
		if (!empty($userdata)) {
			foreach ($userdata as $row) {
				if (!empty($row['user_id']) && !empty($row['name'])) {
					$user_list[$row['user_id']] = $row['name'];
				}
			}
		}

		$this->assign('form_search_action', RC_Uri::url('staff/mh_log/init'));

		$this->assign('logs', $logs);
		$this->assign('ip_list', $ip_list);
		$this->assign('user_list', $user_list);

		$this->display('staff_log_list.dwt');
	}

	/**
	 *  获取管理员操作记录
	 *  @param array $_GET , $_POST, $_REQUEST 参数
	 * @return array 'list', 'page', 'desc'
	 */
	private function get_admin_logs($args = array()) {
		$db_staff_log = RC_DB::table('staff_log as sl')
						->leftJoin('staff_user as su', RC_DB::raw('sl.user_id'), '=', RC_DB::raw('su.user_id'));

		$user_id  = !empty($args['user_id']) ? intval($args['user_id']) : 0;
		$ip = !empty($args['ip']) ? $args['ip'] : '';


		$filter = array();
		$filter['sort_by']      = !empty($args['sort_by']) ? safe_replace($args['sort_by']) :  RC_DB::raw('sl.log_id');
		$filter['sort_order']   = !empty($args['sort_order']) ? safe_replace($args['sort_order']) : 'DESC';

		$keyword = !empty($args['keyword']) ? trim(htmlspecialchars($args['keyword'])) : '';

		//查询条件
		$where = array();
		if (!empty($ip)) {
			$db_staff_log->where(RC_DB::raw('sl.ip_address'), $ip);
		}

		if (!empty($keyword)) {
			$db_staff_log->where(RC_DB::raw('sl.log_info'), 'like', '%'.$keyword.'%');
		}

		if (!empty($user_id)) {
			$db_staff_log->where(RC_DB::raw('su.user_id'), $user_id);
		}
		
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$db_staff_log->where(RC_DB::raw('sl.store_id'), $_SESSION['store_id']);
		}
		

		$count = $db_staff_log->count();
		$page = new ecjia_merchant_page($count, 15, 5);
		$data = $db_staff_log
    		->select(RC_DB::raw('sl.log_id'), RC_DB::raw('sl.log_time'), RC_DB::raw('sl.log_info'), RC_DB::raw('sl.ip_address'), RC_DB::raw('sl.ip_location'), RC_DB::raw('su.name'))
    		->orderby($filter['sort_by'], $filter['sort_order'])
    		->take(20)
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
}

//end

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
/**
 * ECJIA 记录管理员操作日志
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_logs extends ecjia_admin {
	private $admin_log;
	
	public function __construct() {
		parent::__construct();

		$this->admin_log = RC_Loader::load_model('admin_log_model');
		
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-admin_logs');
		
		$admin_logs_jslang = array(
			'choose_delet_time'	=> __('请先选择删除日志的时间！'),
			'delet_ok_1'		=> __('确定删除'),
			'delet_ok_2'		=> __('的日志吗？'),
			'ok'				=> __('确定'),
			'cancel'			=> __('取消')
		);
		RC_Script::localize_script('ecjia-admin_logs', 'admin_logs_lang', $admin_logs_jslang );
	}
	
	/**
	 * 获取所有日志列表
	 */
	public function init() {
		$this->admin_priv('logs_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员日志')));
		$this->assign('ur_here', __('管理员日志'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台管理员日志页面，可以在此查看管理员操作的一些记录信息。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E7.AE.A1.E7.90.86.E5.91.98.E6.97.A5.E5.BF.97" target="_blank">关于管理员日志帮助文档</a>') . '</p>'
		);
		
		$logs = $this->get_admin_logs($_REQUEST);
		/* 查询IP地址列表 */
		$ip_list = array();
		$data = $this->admin_log->field('DISTINCT ip_address')->select();
		if (!empty($data)) {
			foreach ($data as $row) {
				$ip_list[] = $row['ip_address'];
			}
		}
		$this->assign('ip_list',   $ip_list);
		$viewmodel = RC_Loader::load_model('admin_log_viewmodel');
		$viewmodel->view['admin_user']['field'] = 'DISTINCT au.user_name , au.user_id';
		$viewmodel->join('admin_user');
		
		/* 查询管理员列表 */
		$user_list = array();
		$userdata = $viewmodel->select();
		if (!empty($userdata)) {
			foreach ($userdata as $row) {
				if (!empty($row['user_id']) && !empty($row['user_name'])) {
					$user_list[$row['user_id']] = $row['user_name'];
				}
			}
		}
		$this->assign('user_list',   $user_list);
		$this->assign('logs', $logs);
		
		$this->display('admin_logs.dwt');
	}
	
	/**
	 * 批量删除日志记录
	 */
	public function batch_drop() {
		$this->admin_priv('logs_drop');
		
		$drop_type_date = isset($_POST['drop_type_date']) ? $_POST['drop_type_date'] : '';
		
		/* 按日期删除日志 */
		if ($drop_type_date) {				
			if ($_POST['log_date'] > 0) {
				$where = array();
				switch ($_POST['log_date']) {
					case 1:
						$a_week = RC_Time::gmtime() - (3600 * 24 * 7);
						$where['log_time'] = array('elt' => $a_week); 
						$deltime = __('一周之前');
					break;
					case 2:
						$a_month = RC_Time::gmtime() - (3600 * 24 * 30);
						$where['log_time'] = array('elt' => $a_month);
						$deltime = __('一个月前');
					break;
					case 3:
						$three_month = RC_Time::gmtime() - (3600 * 24 * 90);
						$where['log_time'] = array('elt' => $three_month);
						$deltime = __('三个月前');
					break;
					case 4:
						$half_year = RC_Time::gmtime() - (3600 * 24 * 180);
						$where['log_time'] = array('elt' => $half_year);
						$deltime = __('半年之前');
					break;
					case 5:
					default:
						$a_year = RC_Time::gmtime() - (3600 * 24 * 365);
						$where['log_time'] = array('elt' => $a_year);
						$deltime = __('一年之前');
					break;
				}

				$this->admin_log->where($where)->delete();
                /* 记录日志 */
                ecjia_admin::admin_log(sprintf(__('删除 %s 的日志。'), $deltime), 'remove', 'adminlog');

				return $this->showmessage(sprintf(__('%s 的日志成功删除。'), $deltime), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@admin_logs/init')));
			}
			
			return $this->redirect(RC_Uri::url('@admin_logs/init'));
		}
	}
	
	
	/**
	 *  获取管理员操作记录
	 *  @param array $_GET , $_POST, $_REQUEST 参数
	 * @return array 'list', 'page', 'desc'
	 */
	private function get_admin_logs($args = array()) {
		$viewmodel = RC_Loader::load_model('admin_log_viewmodel');

		$user_id  = !empty($args['user_id']) ? intval($args['user_id']) : 0;
		$ip = !empty($args['ip']) ? $args['ip'] : '';

		$filter = array();
		$filter['sort_by']      = !empty($args['sort_by']) ? safe_replace($args['sort_by']) : 'al.log_id';
		$filter['sort_order']   = !empty($args['sort_order']) ? safe_replace($args['sort_order']) : 'DESC';

		$keyword = !empty($args['keyword']) ? trim(htmlspecialchars($args['keyword'])) : '';

		//查询条件
		$where = array();
		if (!empty($ip)) {
			$where['ip_address'] = $ip;
		}

		if(!empty($keyword)) {
			$where['log_info'] = array('like' => "%$keyword%");
		}

		if (!empty($user_id)) {
			$where['au.user_id'] = $user_id;	
		}
		
		$viewmodel->join('admin_user');

		/* 获得总记录数据 */
		$filter['record_count'] = $viewmodel->where($where)->count();

		$page = new ecjia_page($filter['record_count'], 15, 6);

		$data = $viewmodel->where($where)->order(array($filter['sort_by'] => $filter['sort_order']))->limit($page->limit())->select();

		/* 获取管理员日志记录 */
		$list = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$rows['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['log_time']);
				$list[] = $rows;
			}
		}
		return array('list' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());	
	}
	
}


// end
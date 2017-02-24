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
 * 会员排行
*/
class admin_users_order extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('global', 'orders');

		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

		RC_Script::enqueue_script('user_order', RC_App::apps_url('statics/js/user_order.js', __FILE__));
		RC_Script::localize_script('user_order', 'js_lang', RC_Lang::get('orders::statistic.js_lang'));
	}

	/**
	 *	会员排行列表
	 */
	public function init() {
		/* 权限判断 */
		$this->admin_priv('users_order_stats');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('system::system.report_users')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::statistic.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::statistic.users_order_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::statistic.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员排行" target="_blank">'. RC_Lang::get('orders::statistic.about_users_order') .'</a>') . '</p>'
		);

		$this->assign('ur_here', RC_Lang::get('system::system.report_users'));
		$this->assign('action_link', array('text' => '下载会员排行报表', 'href' => RC_Uri::url('orders/admin_users_order/download')));

		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) 	? $_GET['start_date'] 	: RC_Time::local_date(ecjia::config('date_format'), strtotime('-7 days')-8*3600);
		$end_date 	= !empty($_GET['end_date']) 	? $_GET['end_date'] 	: RC_Time::local_date(ecjia::config('date_format'));

		$filter['start_date'] 	= RC_Time::local_strtotime($start_date);
		$filter['end_date'] 	= RC_Time::local_strtotime($end_date) + 24*3600;
		$filter['sort_by'] 		= empty($_GET['sort_by']) 		? 'order_num' 	: trim($_GET['sort_by']);
		$filter['sort_order'] 	= empty($_GET['sort_order']) 	? 'DESC' 		: trim($_GET['sort_order']);

		$users_order_data = $this->get_users_order($filter, true);
		$this->assign('users_order_data', $users_order_data);
		$this->assign('start_date', $start_date);
		$this->assign('end_date', $end_date);
		$this->assign('filter', $filter);

		$this->assign('search_action', RC_Uri::url('orders/admin_users_order/init'));

		$this->display('users_order.dwt');
	}

	/**
	 * 下载会员排行
	 */
	public function download() {
		/* 检查权限 */
		$this->admin_priv('users_order_stats', ecjia::MSGTYPE_JSON);

		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) 	? $_GET['start_date'] 	: RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('-7 days'));
		$end_date 	= !empty($_GET['end_date']) 	? $_GET['end_date'] 	: RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('today'));

		$filter['start_date'] 	= RC_Time::local_strtotime($start_date);
		$filter['end_date'] 	= RC_Time::local_strtotime($end_date) + 24*3600;
		
		$filter['sort_by'] 		= empty($_GET['sort_by']) 		? 'order_num' 	: trim($_GET['sort_by']);
		$filter['sort_order'] 	= empty($_GET['sort_order']) 	? 'DESC' 		: trim($_GET['sort_order']);

		/*文件名*/
		$file_name = mb_convert_encoding('会员排行报表_'.$_GET['start_date'].'至'.$_GET['end_date'],"GBK","UTF-8");
		$users_order_data = $this->get_users_order($filter, false);

		/*强制下载,下载类型EXCEL*/
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$file_name.xls");

		$data = RC_Lang::get('orders::statistic.order_by')."\t".RC_Lang::get('orders::statistic.member_name')."\t".RC_Lang::get('orders::statistic.order_amount')."\t".RC_Lang::get('orders::statistic.buy_sum')."\n";
		if (!empty($users_order_data['item'])) {
			foreach ($users_order_data['item'] as $k=>$v) {
				$order_by = $k + 1;
				$data .= $order_by."\t".$v['user_name']."\t".$v['order_num']."\t".$v['turnover']."\n";
			}
		}

		echo mb_convert_encoding($data."\t","GBK","UTF-8");
		exit;
	}

	/**
	 * 取得会员排行数据信息
	 * @param   bool  $is_pagination  是否分页
	 * @return  array   销会员排行数据
	 */
	private function get_users_order($filter, $paging = true) {
	    $where = "u.user_id > 0 " .order_query_sql('finished', 'o.');

		if ($filter['start_date']) {
	        $where .= " AND o.add_time >= '" . $filter['start_date'] . "'";
	    }
	    if ($filter['end_date']) {
	        $where .= " AND o.add_time <= '" . $filter['end_date'] . "'";
	    }
	    $where .= " AND o.is_delete = 0";

	    $db_users = RC_DB::table('users as u')
	    	->leftJoin('order_info as o', RC_DB::raw('o.user_id'), '=', RC_DB::raw('u.user_id'))
	    	->whereRaw($where);

	    $count = $db_users->count(RC_DB::raw('distinct(u.user_id)'));
	    $page = new ecjia_page($count, 20, 5);
	    if ($paging) {
	    	$limit = $page->limit();
	    	$db_users->take($page->page_size)->skip($page->start_id-1);
	    }
	    /* 计算订单各种费用之和的语句 */
    	$users_order_data = $db_users
    		->select(RC_DB::raw('u.user_id, u.user_name, COUNT(*) AS order_num, SUM(o.goods_amount + o.tax + o.shipping_fee + o.insure_fee + o.pay_fee + o.pack_fee + o.card_fee) AS turnover'))
    		->orderby($filter['sort_by'], $filter['sort_order'])
    		->orderby(turnover, 'desc')
    		->groupby(RC_DB::raw('u.user_id'))
    		->get();

	    if (!empty($users_order_data)) {
	    	foreach ($users_order_data as $key => $item) {
	    		$users_order_data[$key]['turnover']  = price_format($users_order_data[$key]['turnover']);
	    	}
	    }
	    return array('item' => $users_order_data, 'filter' => $filter, 'desc' => $page->page_desc(), 'page' => $page->show(2));
	}
}

// end
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
 * 资金对账
 * @author songqianqian
 */
class admin_match extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-region');
		
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('admin_express', RC_App::apps_url('statics/js/admin_express.js', __FILE__));
		RC_Style::enqueue_style('admin_express', RC_App::apps_url('statics/css/admin_express.css', __FILE__));
        RC_Script::localize_script('admin_express', 'js_lang', config('app-express::jslang.express_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('资金对账', 'express'), RC_Uri::url('express/admin_match/init')));
	}
	
	/**
	 * 资金对账
	 */
	public function init() {
		$this->admin_priv('express_match_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('资金对账', 'express')));
		$this->assign('ur_here', __('资金对账', 'express'));
	
		$data = $this->get_account_list();
		$this->assign('data', $data);
		
		$this->assign('search_action', RC_Uri::url('express/admin_match/init'));

        return $this->display('express_match_list.dwt');
	}
	
	/**
	 * 查看详情
	 */
	public function detail() {
		$this->admin_priv('express_match_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('对账详情', 'express')));
		$this->assign('ur_here', __('对账详情', 'express'));
	
		$user_id = intval($_GET['user_id']);
		$name = RC_DB::table('staff_user')->where('user_id', $user_id)->value('name');
		$this->assign('name', $name);
		$this->assign('user_id', $user_id);
		
		$this->assign('form_action', RC_Uri::url('express/admin_match/detail'));
		$start_date = $end_date = '';
		if (isset($_GET['start_date']) && !empty($_GET['end_date'])) {
			$start_date	= RC_Time::local_strtotime($_GET['start_date']);
			$end_date	= RC_Time::local_strtotime($_GET['end_date']);
		} else {
			$start_date	= RC_Time::local_strtotime(RC_Time::local_date(ecjia::config('date_format'), strtotime('-1 month')-8*3600));
			$end_date	= RC_Time::local_strtotime(RC_Time::local_date(ecjia::config('date_format')));
		}
		$this->assign('start_date',		RC_Time::local_date('Y-m-d', $start_date));
		$this->assign('end_date',		RC_Time::local_date('Y-m-d', $end_date));
		
		
		$db_data = RC_DB::table('express_order');
		$db_data->where(RC_DB::raw('staff_id'), $user_id);
		$db_data->where('receive_time', '>=', $start_date);
		$db_data->where('receive_time', '<', $end_date + 86400);
		$order_number= $db_data->where('staff_id', $user_id)->count();
		$this->assign('order_number', $order_number);
		
		$money= $db_data->where('staff_id', $user_id)->select(RC_DB::raw('sum(shipping_fee) as all_money'),RC_DB::raw('sum(commision) as express_money'))->first();
		$money['all_money'] = price_format($money['all_money']);
		$money['express_money'] = price_format($money['express_money']);
		$this->assign('money', $money);
		
		$account_money= RC_DB::table('express_order')->where('receive_time', '>=', $start_date)->where('receive_time', '<', $end_date + 86400)->where('staff_id', $user_id)->where('commision_status', 1)->select(RC_DB::raw('sum(commision) as account_money'))->first();
		$account_money = price_format($account_money['account_money']);
		$this->assign('account_money', $account_money);
		
		
		
		

		$count = $db_data->count();
		$page = new ecjia_page($count, 10, 5);
		
		$data = $db_data
		->select(RC_DB::raw('express_id'), RC_DB::raw('express_sn'), RC_DB::raw('`from`'), RC_DB::raw('commision'), RC_DB::raw('shipping_fee'), RC_DB::raw('commision_status'), RC_DB::raw('receive_time'), RC_DB::raw('staff_id'), RC_DB::raw('shipping_fee-commision as store_money'))
		->orderby('express_id', 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['receive_time']  = RC_Time::local_date('Y-m-d', $row['receive_time']);
				$list[] = $row;
			}
		}
		$order_list = array('list' => $list,'page' => $page->show(5), 'desc' => $page->page_desc());
		$this->assign('order_list', $order_list);

        return $this->display('express_match_detail.dwt');
	}
	
	private function get_account_list() {
		
		$db_data = RC_DB::table('staff_user');
		$db_data->where(RC_DB::raw('store_id'), 0);
	
		$filter['keyword']	 = trim($_GET['keyword']);
		if ($filter['keyword']) {
			$db_data ->whereRaw('(name  like  "%'.mysql_like_quote($filter['keyword']).'%"  or mobile like "%'.mysql_like_quote($filter['keyword']).'%")');
		}

		$count = $db_data->count();
		$page = new ecjia_page($count, 10, 5);
		
		$data = $db_data
		->select(RC_DB::raw('user_id'), RC_DB::raw('name'), RC_DB::raw('mobile'))
		->orderby(RC_DB::raw('user_id'), 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['order_number'] = RC_DB::table('express_order')->where('staff_id', $row['user_id'])->count();
				$money_stats = RC_DB::table('express_order')->where('staff_id', $row['user_id'])->select(RC_DB::raw('sum(shipping_fee) as all_money'),RC_DB::raw('sum(commision) as express_money'),RC_DB::raw('sum(shipping_fee-commision) as store_money'))->first();
				$money_stats['all_money'] = price_format($money_stats['all_money']);
				$money_stats['express_money'] = price_format($money_stats['express_money']);
				$money_stats['store_money'] = price_format($money_stats['store_money']);
				$row['money'] = $money_stats;
				$list[] = $row;
			}
		}
		return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

//end
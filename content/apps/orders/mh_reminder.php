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
 * ECJIA 订单-卖家催单
 */
class mh_reminder extends ecjia_merchant {
	private $dbview_order_reminder;
	
	public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('smoke');
// 		RC_Script::enqueue_script('order_back', RC_Uri::home_url('content/apps/orders/statics/js/order_delivery.js'));
		RC_Script::enqueue_script('order_delivery', RC_App::apps_url('statics/js/merchant_order_delivery.js', __FILE__));
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		
		$this->dbview_order_reminder = RC_Model::Model('orders/order_reminder_viewmodel');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单管理'), RC_Uri::url('orders/merchant/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.reminder_list'), RC_Uri::url('orders/admin_order_remind/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('order', 'order/mh_reminder.php');
	}
	
	/**
	 * 发货提醒列表
	 */
	public function init() {
		$this->admin_priv('delivery_view');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.reminder_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::order.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::order.order_reminder_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::order.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:发货提醒列表" target="_blank">'. RC_Lang::get('orders::order.about_order_reminder') .'</a>') . '</p>'
		);
		
		/* 查询 */
		$db_order_reminder = RC_DB::table('order_reminder as r')
			->leftJoin('order_info as o', RC_DB::raw('o.order_id'), '=', RC_DB::raw('r.order_id'))
			->leftJoin('users as a', RC_DB::raw('o.user_id'), '=', RC_DB::raw('a.user_id'));
		
		isset($_SESSION['store_id']) ? $db_order_reminder->where(RC_DB::raw('r.store_id'), $_SESSION['store_id']) : '';
		
		$keywords = $_GET['keywords'];
		$keywords = empty($keywords) ? '' : trim($keywords);

		if (!empty($keywords)) {
		    $db_order_reminder->whereRaw('(o.order_sn like "%'.mysql_like_quote($keywords).'%" or o.consignee like "%'.mysql_like_quote($keywords).'%")');
		}
        
		$count = $db_order_reminder->count();
		$page = new ecjia_merchant_page($count, 10, 6);
		
		$result = $db_order_reminder->take(10)->skip($page->start_id-1)->get();
		$result_list = array('list' => $result, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'keywords' => $keywords);

		if (!empty($result_list['list'])) {
			foreach ($result_list['list'] as $key => $val) {
		 		$result_list['list'][$key]['order_status'] = $val[order_status] == 1 ? RC_Lang::get('orders::order.processed') : RC_Lang::get('orders::order.untreated');
	    		$result_list['list'][$key]['confirm_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['confirm_time']);
			}
		} 

		/* 模板赋值 */
		$this->assign('ur_here', RC_Lang::get('orders::order.reminder_list'));
		$this->assign('form_action', RC_Uri::url('orders/mh_reminder/remove&type=batch'));
		$this->assign('order_remind', $result_list['list']);
		$this->assign('result_list', $result_list);
		$this->display('remind_list.dwt');
	}
	

	/* 催货单删除 */
	public function remove() {
		/* 检查权限 */
		$this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);
	 
		$order_id = !empty($_GET['order_id']) ? $_GET['order_id'] : $_POST['order_id'];
		$order_id = explode(',',$order_id);
	
		/* 记录日志 */
		RC_DB::table('order_reminder')->whereIn('order_id', $order_id)->delete();
		return $this->showmessage(RC_Lang::get('orders::order.tips_back_del'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/mh_reminder/init')));
	}
}

// end
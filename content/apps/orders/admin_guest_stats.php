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
 * 客户统计
 */
class admin_guest_stats extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('global','orders');
		
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
	}
	/**
	 * 客户统计列表
	 */
	public function init() {
		$this->admin_priv('guest_stats');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::statistic.guest_stats')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::statistic.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::statistic.guest_stats_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::statistic.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:客户统计" target="_blank">'. RC_Lang::get('orders::statistic.about_guest_stats') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('orders::statistic.guest_stats'));
		$this->assign('action_link', array('text' => RC_Lang::get('orders::statistic.down_guest_stats'), 'href'=> RC_Uri::url('orders/admin_guest_stats/download')));
		
		/* 取得会员总数 */
		$res = RC_DB::table('users')->count();
		$user_num = $res;
		
 		/* 计算订单各种费用之和的语句 */
		$total_fee = " SUM(" . order_amount_field() . ") AS turnover ";
		
		/* 有过订单的会员数 */
		$have_order_usernum = RC_DB::table('order_info')->whereRaw(RC_DB::raw('user_id > 0' . order_query_sql('finished') .' AND is_delete = 0'))->count(RC_DB::raw('DISTINCT user_id'));
		
		/* 会员订单总数和订单总购物额 */
		$user_all_order = array();
		$user_all_order = RC_DB::table('order_info')->select(RC_DB::raw('COUNT(*) AS order_num , '.$total_fee.''))->whereRaw(RC_DB::raw('user_id > 0 ' . order_query_sql('finished') .' AND is_delete = 0'))->first();
		
		$user_all_order['turnover'] = floatval($user_all_order['turnover']);
		
		/* 赋值到模板 */
		$this->assign('user_num',            $user_num);                    // 会员总数
		$this->assign('have_order_usernum',  $have_order_usernum);          // 有过订单的会员数
		$this->assign('user_order_turnover', $user_all_order['order_num']); // 会员总订单数
		$this->assign('user_all_turnover',   price_format($user_all_order['turnover']));  //会员购物总额
		/* 每会员订单数 */
		$this->assign('ave_user_ordernum', $user_num > 0 ? sprintf("%0.2f", $user_all_order['order_num'] / $user_num) : 0);
		
		/* 每会员购物额 */
		$this->assign('ave_user_turnover', $user_num > 0 ? price_format($user_all_order['turnover'] / $user_num) : 0);
		/* 注册会员购买率 */
		$this->assign('user_ratio', sprintf("%0.2f", ($user_num > 0 ? $have_order_usernum / $user_num : 0) * 100));
		
		$this->assign_lang();
		$this->display('guest_stats.dwt');
	}
	
	/**
	 * 客户统计报表下载
	 */
	public function download() {
		/* 权限判断 */ 
		$this->admin_priv('guest_stats', ecjia::MSGTYPE_JSON);
		
		/* 取得会员总数 */
		$res = RC_DB::table('users')->count();
		$user_num = $res;
		
		/* 计算订单各种费用之和的语句 */
		$total_fee = " SUM(" . order_amount_field() . ") AS turnover ";
		
		/* 有过订单的会员数 */
		$have_order_usernum = RC_DB::table('order_info')->whereRaw(RC_DB::raw('user_id > 0' . order_query_sql('finished') .' AND is_delete = 0'))->count(RC_DB::raw('DISTINCT user_id'));

		/* 会员订单总数和订单总购物额 */
		$user_all_order = array();
		$user_all_order = RC_DB::table('order_info')->select(RC_DB::raw('COUNT(*) AS order_num , '.$total_fee.''))->whereRaw(RC_DB::raw('user_id > 0 ' . order_query_sql('finished') .' AND is_delete = 0'))->first();
		
		$user_all_order['turnover'] = floatval($user_all_order['turnover']);
		
		$filename = mb_convert_encoding(RC_Lang::get('orders::statistic.guest_statement').'-'.RC_Time::local_date('Y-m-d'),"GBK","UTF-8");
		header("Content-type: application/vnd.ms-excel;charset=utf-8");
		header("Content-Disposition:attachment;filename=$filename.xls");
		
		/* 生成会员购买率 */
		$data  = RC_Lang::get('orders::statistic.percent_buy_member'). "\t\n";
		$data .= RC_Lang::get('orders::statistic.member_count'). "\t" . RC_Lang::get('orders::statistic.order_member_count') . "\t" . RC_Lang::get('orders::statistic.member_order_count') . "\t" . RC_Lang::get('orders::statistic.percent_buy_member') . "\n";
	
		$data .= $user_num . "\t" . $have_order_usernum . "\t" . $user_all_order['order_num'] . "\t" . sprintf("%0.2f", ($user_num > 0 ? ($have_order_usernum / $user_num) : 0) * 100).'%' . "\n\n";
	
		/* 每会员平均订单数及购物额 */
		$data .= RC_Lang::get('orders::statistic.order_turnover_peruser') . "\t\n";
		$data .= RC_Lang::get('orders::statistic.member_sum') . "\t" . RC_Lang::get('orders::statistic.average_member_order') . "\t" . RC_Lang::get('orders::statistic.member_order_sum') . "\n";
		
		$ave_user_ordernum = $user_num > 0 ? sprintf("%0.2f", $user_all_order['order_num'] / $user_num) : 0;
		$ave_user_turnover = $user_num > 0 ? price_format($user_all_order['turnover'] / $user_num) : 0;
		
		$data .= price_format($user_all_order['turnover']) . "\t" . $ave_user_ordernum . "\t" . $ave_user_turnover . "\n\n";
		echo mb_convert_encoding($data. "\t", "GBK", "UTF-8");
		exit;
	}
}

// end
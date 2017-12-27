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
 * 买单销售明细列表
 * songqianqian
*/
class admin_sale_list extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
 		RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('admin_sale_list', RC_App::apps_url('statics/js/admin_sale_list.js', __FILE__));
        RC_Style::enqueue_style('admin_order', RC_App::apps_url('statics/css/admin_order.css', __FILE__));
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('买单管理', RC_Uri::url('quickpay/admin_order/init')));
	}
	
	/**
	 * 销售明细列表
	 */
	public function init() {
		$this->admin_priv('mh_sale_list_stats');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('买单销售明细'));
		
		$this->assign('ur_here', '买单销售明细');
		$this->assign('action_link', array('text' => '销售明细报表下载', 'href' => RC_Uri::url('quickpay/admin_sale_list/download')));
		
		$sale_list_data = $this->get_sale_list();
        $this->assign('sale_list_data', $sale_list_data);
        $this->assign('order_count', $sale_list_data['count_data'][0]['order_count']);
        $this->assign('order_amount', $sale_list_data['count_data'][0]['order_amount']);
        $this->assign('filter', $sale_list_data['filter']);

        $this->assign('search_action', RC_Uri::url('quickpay/admin_sale_list/init'));
        
		$this->display('quickpay_sale_list.dwt');
	}

	/**
	 * 下载销售明细
	 */
	public function download() {
		$this->admin_priv('mh_sale_list_stats');
		
		$db_quickpay_order = RC_DB::table('quickpay_orders');

		$start_date = RC_Time::local_strtotime($_GET['start_date']);
		$end_date   = RC_Time::local_strtotime($_GET['end_date']);
			
		$format = '%Y-%m-%d';
		$db_quickpay_order->where('pay_time', '>=', $start_date);
		$db_quickpay_order->where('pay_time', '<=', $end_date);

		$sale_list_data = $db_quickpay_order
		->selectRaw("DATE_FORMAT(FROM_UNIXTIME(pay_time), '". $format ."') AS period,
				COUNT(DISTINCT order_sn) AS order_count,
				SUM(goods_amount) AS goods_amount,
				SUM(order_amount + surplus) AS order_amount,
				SUM(goods_amount - order_amount -surplus) AS favorable_amount")
		->groupby('period')
		->get();

		$filename = mb_convert_encoding('平台买单销售明细报表' . '_' . $_GET['start_date'] . '至' . $_GET['end_date'], "GBK", "UTF-8");
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename={$filename}.xls");

		echo mb_convert_encoding('平台买单销售明细','UTF-8', 'UTF-8') . "\t\n";
		echo mb_convert_encoding('日期','UTF-8', 'UTF-8') . "\t";
		echo mb_convert_encoding('订单数量（单）','UTF-8', 'UTF-8') . "\t";
		echo mb_convert_encoding('消费总金额（元）','UTF-8', 'UTF-8') . "\t";
		echo mb_convert_encoding('优惠总金额（元）','UTF-8', 'UTF-8') . "\t";
		echo mb_convert_encoding('实付总金额（元）','UTF-8', 'UTF-8') . "\t\n";
		foreach ($sale_list_data AS $data) {
			echo mb_convert_encoding($data['period'],'UTF-8', 'UTF-8') . "\t";
			echo mb_convert_encoding($data['order_count'],'UTF-8', 'UTF-8') . "\t";
			echo mb_convert_encoding($data['goods_amount'],'UTF-8', 'UTF-8') . "\t";
			echo mb_convert_encoding($data['favorable_amount'],'UTF-8', 'UTF-8') . "\t";
			echo mb_convert_encoding($data['order_amount'],'UTF-8', 'UTF-8') . "\t";
			echo "\n";
		}
		exit;
	}
	
	/**
	 * 取得销售明细数据信息
	 * @return  array销售明细数据
	 */
	private function get_sale_list() {
		$db_quickpay_order = RC_DB::table('quickpay_orders');
		
		$format = '%Y-%m-%d';
		if (empty($_GET['year_beginYear'])) {//当年当月的数据
			$start = RC_Time::local_mktime(0, 0, 0, intval(date('m')), 1, intval(date('Y')));
			$end   = RC_Time::local_mktime(23, 59, 59, intval(date('m')), 31, intval(date('Y')));
		} else {
			if ($_GET['month_beginMonth'] == 'all') {//指定某年（一年数据）
				$start = RC_Time::local_mktime(0, 0, 0, 1, 1, intval($_GET['year_beginYear']));
				$end   = RC_Time::local_mktime(23, 59, 59, 12, 31, intval($_GET['year_beginYear']));
				$select_value = 'select_all';
				$format = '%Y-%m';
			} else {//指定某年某月的数据
				$month_beginMonth = intval($_GET['month_beginMonth']);
				$year_beginYear   = intval($_GET['year_beginYear']);
				$start = RC_Time::local_mktime(0, 0, 0, $month_beginMonth, 1, $year_beginYear);
				if ($month_beginMonth ==1 || $month_beginMonth ==3 || $month_beginMonth ==5 || $month_beginMonth ==7 || $month_beginMonth ==8 || $month_beginMonth ==10 || $month_beginMonth ==12) {
					$end   = RC_Time::local_mktime(23, 59, 59, $month_beginMonth, 31, $year_beginYear);//每年大月
				} elseif ($month_beginMonth == 4 || $month_beginMonth == 6 || $month_beginMonth == 9 || $month_beginMonth == 11) {
					$end = RC_Time::local_mktime(23, 59, 59, $month_beginMonth, 30, $year_beginYear);//每年小月
				} elseif ($month_beginMonth == 2 && ($year_beginYear%4 == 0 && $year_beginYear%100 != 0) || ($year_beginYear%400 == 0)) {
					$end = RC_Time::local_mktime(23, 59, 59, $month_beginMonth, 29, $year_beginYear);//闰年2月
				} else {
					$end = RC_Time::local_mktime(23, 59, 59, $month_beginMonth, 28, $year_beginYear);//平年2月
				}
			}
		}
		
		$db_quickpay_order->where('pay_time', '>=', $start);
		$db_quickpay_order->where('pay_time', '<=', $end);
	
		$count_data = $db_quickpay_order
		->selectRaw("COUNT(DISTINCT order_sn) AS order_count,
				SUM(order_amount + surplus) AS order_amount")
		->get();
		
		$sale_list_data = $db_quickpay_order
		->selectRaw("DATE_FORMAT(FROM_UNIXTIME(pay_time), '". $format ."') AS period,
				COUNT(DISTINCT order_sn) AS order_count, 
				SUM(goods_amount) AS goods_amount,
				SUM(order_amount + surplus) AS order_amount, 
				SUM(goods_amount - order_amount -surplus) AS favorable_amount")
		->groupby('period')
		->get();
		
		$filter['start_date'] = RC_Time::local_date('Y-m-d', $start);
		$filter['end_date']   = RC_Time::local_date('Y-m-d', $end);
		
		$arr = array('item' => $sale_list_data, 'count_data' => $count_data, 'filter' => $filter, 'select_value' => $select_value);
		return $arr;
	}
}

// end
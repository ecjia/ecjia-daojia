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
 * 销售明细列表程序
*/
class mh_sale_list extends ecjia_merchant {
	private $order_goods_view;
	private $order_info_view;
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global','orders');
		$this->order_info_view = RC_Loader::load_app_model('order_info_viewmodel','orders');
		$this->order_goods_view = RC_Loader::load_app_model('order_goods_viewmodel','orders');
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
        /*自定义js*/
        RC_Script::enqueue_script('sale_list',RC_App::apps_url('statics/js/merchant_sale_list.js',__FILE__), array('ecjia-merchant'), false, 1);
        
        ecjia_merchant_screen::get_current_screen()->set_parentage('stats');
	}
	
	/**
	 * 商品明细列表
	 */
	public function init() {
		/* 权限判断 */ 
		$this->admin_priv('sale_list_stats');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('报表统计', RC_Uri::url('stats/mh_keywords_stats/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::statistic.sales_list')));
		
		$this->assign('ur_here', RC_Lang::get('orders::statistic.sales_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('orders::statistic.down_sales'), 'href' => RC_Uri::url('orders/mh_sale_list/download')));
		
		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('-7 days'));
		$end_date = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'));
		
		$sale_list_data = $this->get_sale_list();
        /* 赋值到模板 */
        $this->assign('sale_list_data', $sale_list_data);
        
        $this->assign('start_date', $start_date);
        $this->assign('end_date', $end_date);
        
        $this->assign('search_action', RC_Uri::url('orders/mh_sale_list/init'));
        
        $this->assign_lang();
		$this->display('sale_list.dwt');
	}

	/**
	 * 下载销售明细
	 */
	public function download() {
		/* 检查权限 */
		$this->admin_priv('sale_list_stats', ecjia::MSGTYPE_JSON);
		
		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_strtotime('-7 days'));
		$end_date = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_strtotime('today'));

		/*文件名*/
		$file_name = RC_Lang::get('orders::statistic.sales_list');
		$goods_sales_list = $this->get_sale_list(false);
		/*强制下载,下载类型EXCEL*/
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$file_name.xls");
		
		echo mb_convert_encoding($filename . RC_LANG::lang('sales_list_statement'),'UTF-8', 'UTF-8') . "\t\n";
		$data = RC_Lang::get('orders::statistic.goods_name')."\t".RC_Lang::get('orders::statistic.order_sn')."\t".RC_Lang::get('orders::statistic.amount')."\t".RC_Lang::get('orders::statistic.sell_price')."\t".RC_Lang::get('orders::statistic.sell_date')."\n";
		
		foreach ($goods_sales_list as $row) {
			foreach ($row as $v) {
				$data .= mb_convert_encoding("$v[goods_name]\t$v[order_sn]\t$v[goods_num]\t$v[sales_price]\t$v[sales_time]\n",'UTF-8','auto');
			}
		}
		echo mb_convert_encoding($data."\t",'UTF-8','auto');
		exit;
	}

	/**
	 * 取得销售明细数据信息
	 * @param   bool  $is_pagination  是否分页
	 * @return  array   销售明细数据
	 */
	private function get_sale_list($is_pagination = true) {
		/* 时间参数 */
	    $filter['start_date'] = empty($_GET['start_date']) ? RC_Time::local_strtotime('-7 days') : RC_Time::local_strtotime($_GET['start_date']);
	    $filter['end_date'] = empty($_GET['end_date']) ? RC_Time::local_strtotime('today') : RC_Time::local_strtotime($_GET['end_date']);
	    $where = "oi.store_id = " . $_SESSION['store_id'] .order_query_sql('finished', 'oi.') ." AND oi.add_time >= '".$filter['start_date']."' AND oi.add_time < '" . ($filter['end_date'] + 86400) . "'";
	    $where .= " AND oi.is_delete = 0";
	    
	    $count = $this->order_goods_view->where($where)->count('og.goods_id');
		$page = new ecjia_merchant_page($count,20,5);
	    if ($is_pagination) {
           $limit = $page->limit();
	    }
	    $sale_list_data = $this->order_goods_view->field('og.goods_id, og.goods_sn, og.goods_name, og.goods_number AS goods_num, og.goods_price '.
           'AS sales_price, oi.add_time AS sales_time, oi.order_id, oi.order_sn ')->where($where)->order(array( 'sales_time'=> 'DESC', 'goods_num'=> 'DESC'))->limit($limit)->select();
	    
	    foreach ($sale_list_data as $key => $item) {
	        $sale_list_data[$key]['sales_price'] = price_format($sale_list_data[$key]['sales_price']);
	        $sale_list_data[$key]['sales_time']  = RC_Time::local_date(ecjia::config('date_format'), $sale_list_data[$key]['sales_time']);
	    }
	    $arr = array('item' => $sale_list_data, 'filter' => $filter, 'desc' => $page->page_desc(), 'page' => $page->show(2));
	    return $arr;
	}
}

// end
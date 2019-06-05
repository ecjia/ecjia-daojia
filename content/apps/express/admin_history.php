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
 * 历史配送订单管理
 * @author songqianqian
 */
class admin_history extends ecjia_admin {
	
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
		
		RC_Script::enqueue_script('admin_history', RC_App::apps_url('statics/js/admin_history.js', __FILE__));
		RC_Style::enqueue_style('admin_express', RC_App::apps_url('statics/css/admin_express.css', __FILE__));
        RC_Script::localize_script('admin_history', 'js_lang', config('app-express::jslang.express_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('历史配送', 'express'), RC_Uri::url('express/admin_history/init')));
	}
	
	/**
	 * 历史配送订单列表加载
	 */
	public function init() {
		$this->admin_priv('express_history_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('历史配送', 'express')));
		$this->assign('ur_here', __('历史配送', 'express'));
		
		$data = $this->get_history_list();
		$this->assign('data', $data);
		
		$this->assign('express_detail', RC_Uri::url('express/admin_history/detail'));
		$this->assign('search_action', RC_Uri::url('express/admin_history/init'));

        return $this->display('express_history_list.dwt');
	}
	
	
	/**
	 * 查看详情
	 */
	public function detail() {
		$this->admin_priv('express_history_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('配送详情', 'express')));
		$this->assign('ur_here', __('配送详情', 'express'));
	
		$express_id = intval($_POST['express_id']);
		$express_info = RC_DB::table('express_order')->where('express_id', $express_id)->select('store_id','order_id', 'order_sn', 'delivery_id', 'delivery_sn','mobile','consignee','user_id','express_sn', 'distance','commision','express_user','express_mobile','from','signed_time','district as eodistrict','street as eostreet','address as eoaddress')->first();
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $express_info['store_id'])->select('merchants_name','contact_mobile','district','street','address')->first();
		$order_info = RC_DB::table('order_info')->where('order_id', $express_info['order_id'])->select('add_time','expect_shipping_time','postscript')->first();
		//$goods_list = RC_DB::table('order_goods')->where('order_id', $express_info['order_id'])->select('goods_id', 'goods_name' ,'goods_price','goods_number')->get();
		/*配送单对应的发货单商品*/
		$goods_list = RC_DB::table('delivery_goods')->where('delivery_id', $express_info['delivery_id'])->select(RC_DB::raw('goods_id'), RC_DB::raw('goods_name'), RC_DB::raw('send_number'))->get();
		
		foreach ($goods_list as $key => $val) {
			$goods_list[$key]['image']  				= RC_DB::table('goods')->where('goods_id', $val['goods_id'])->pluck('goods_thumb');
			$goods_list[$key]['goods_price']			= RC_DB::table('order_goods')->where('goods_id', $val['goods_id'])->where('order_id', $express_info['order_id'])->pluck('goods_price');
			$goods_list[$key]['formated_goods_price']	= price_format($goods_list[$key]['goods_price']);
		}
		$disk = RC_Filesystem::disk();
		foreach ($goods_list as $key => $val) {
			if (!$disk->exists(RC_Upload::upload_path($val['image'])) || empty($val['image'])) {
				$goods_list[$key]['image'] = RC_Uri::admin_url('statics/images/nopic.png');
			} else {
				$goods_list[$key]['image'] = RC_Upload::upload_url($val['image']);
			}
		}
		$content = array_merge($express_info,$store_info,$order_info);
		$content['district']      = ecjia_region::getRegionName($content['district']);
		$content['street']        = ecjia_region::getRegionName($content['street']);
		$content['eodistrict']    = ecjia_region::getRegionName($content['eodistrict']);
		$content['eostreet']      = ecjia_region::getRegionName($content['eostreet']);
		$content['add_time']  = RC_Time::local_date('Y-m-d H:i:s', $content['add_time']);
		$content['signed_time']  = RC_Time::local_date('Y-m-d H:i:s', $content['signed_time']);
		$content['expect_shipping_time']  = RC_Time::local_date('Y-m-d H:i:s', $content['expect_shipping_time']);
		$content['all_address'] = $content['district'].$content['street'];
		$content['express_all_address'] = $content['eodistrict'].$content['eostreet'];
		
		if($content['from'] == 'grab') {
			$content['from'] =__('抢单', 'express');
		} else {
			$content['from'] =__('派单', 'express');
		}
	
		$this->assign('content', $content);
		$this->assign('goods_list', $goods_list);
		
		$data = $this->fetch('express_history_detail.dwt');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	private function get_history_list() {
		$db_data = RC_DB::table('express_order as eo')
		->leftJoin('users as user', RC_DB::raw('eo.user_id'), '=', RC_DB::raw('user.user_id'))
		->leftJoin('store_franchisee as sf', RC_DB::raw('eo.store_id'), '=', RC_DB::raw('sf.store_id'));
		
		$db_data->whereIn(RC_DB::raw('eo.status'), array(5, 7));
		$db_data->where(RC_DB::raw('eo.shipping_code'), 'ship_ecjia_express');
		
		if($_GET['start_date'] && $_GET['end_date']) {
			$start_date = RC_Time::local_strtotime($_GET['start_date']);
			$end_date	= RC_Time::local_strtotime($_GET['end_date']);
			$db_data->where('signed_time', '>=', $start_date);
			$db_data->where('signed_time', '<', $end_date + 86400);
		}
		
		$filter['work_type'] = trim($_GET['work_type']);
		$filter['keyword']	 = trim($_GET['keyword']);
		
		if ($filter['keyword']) {
			$db_data ->whereRaw('(eo.express_user  like  "%'.mysql_like_quote($filter['keyword']).'%"  or eo.express_sn like "%'.mysql_like_quote($filter['keyword']).'%")');
		}
		
		if ($filter['work_type']) {
			$db_data ->where('from', $filter['work_type']);
		}
		
		$count = $db_data->count();
		$page = new ecjia_page($count, 10, 5);
		
		$data = $db_data
		->select(RC_DB::raw('eo.express_id'), RC_DB::raw('eo.order_sn'), RC_DB::raw('eo.express_sn'), RC_DB::raw('eo.from'), RC_DB::raw('eo.express_user'), RC_DB::raw('eo.express_mobile'), RC_DB::raw('eo.signed_time'), RC_DB::raw('eo.status'), RC_DB::raw('eo.consignee'), RC_DB::raw('eo.mobile'), RC_DB::raw('eo.district as eodistrict'), RC_DB::raw('eo.street as eostreet'), RC_DB::raw('eo.address as eoaddress'), RC_DB::raw('sf.district'), RC_DB::raw('sf.street'), RC_DB::raw('sf.address'))
		->orderby(RC_DB::raw('eo.signed_time'), 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['signed_time']  = RC_Time::local_date('Y-m-d H:i:s', $row['signed_time']);
				$row['district']      = ecjia_region::getRegionName($row['district']);
				$row['street']        = ecjia_region::getRegionName($row['street']);
				$row['eodistrict']    = ecjia_region::getRegionName($row['eodistrict']);
				$row['eostreet']      = ecjia_region::getRegionName($row['eostreet']);
				$list[] = $row;
			}
		}
		return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

//end
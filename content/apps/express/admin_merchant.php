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
 * 商家管理
 * @author songqianqian
 */
class admin_merchant extends ecjia_admin {
	
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
		RC_Script::enqueue_script('qq_map', ecjia_location_mapjs());
		
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('admin_merchant', RC_App::apps_url('statics/js/admin_merchant.js', __FILE__));
		RC_Style::enqueue_style('admin_express', RC_App::apps_url('statics/css/admin_express.css', __FILE__));
        RC_Script::localize_script('admin_merchant', 'js_lang', config('app-express::jslang.express_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家管理', 'express'), RC_Uri::url('express/admin_merchant/init')));
	}
	
	/**
	 * 商家列表管理
	 */
	public function init() {
		$this->admin_priv('express_merchant_manage');
		
		ecjia_screen::$current_screen->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('温馨提示', 'express'),
			'content'	=> '<p>' . __('商家管理列表只展示未完成配送订单的商家以及分类', 'express') .  '</p>'
		));
				
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家管理', 'express')));
		$this->assign('ur_here', __('商家管理', 'express'));
		
		$cat_id = trim($_GET['cat_id']);
		$data = $this->get_merchant_list($cat_id);
		$this->assign('data', $data);
		
		$keyword = trim($_GET['keyword']);
		$cat_arr = $this->get_cat_list($keyword);
		
		$this->assign('cat_list', $cat_arr['list']);
		$this->assign('allnumber', $cat_arr['allnumber']);
		
		$this->assign('search_action', RC_Uri::url('express/admin_merchant/init'));

		$this->display('merchant_list.dwt');
	}
	

	/**
	 * 商家详情
	 */
	public function detail() {
		$this->admin_priv('express_merchant_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家详情', 'express')));
		$this->assign('ur_here', __('商家详情', 'express'));
		
		$store_id = trim($_GET['store_id']);
		$this->assign('store_id', $store_id);
		
		$type = trim($_GET['type']);
		$this->assign('type', $type);
		
		$this->assign('express_detail', RC_Uri::url('express/admin_merchant/order_detail'));
	
		$shop_trade_time = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'shop_trade_time')->pluck('value');
		$store_info['shop_trade_time'] = unserialize($shop_trade_time);
		$store_info['img'] = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'shop_logo')->pluck('value');
		$store_info['shop_kf_mobile'] = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'shop_kf_mobile')->pluck('value');
		$info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->select('merchants_name','district', 'street', 'address')->first();
		$store_info['merchants_name'] = $info['merchants_name'];
		$store_info['merchants_all_address'] = ecjia_region::getRegionName($info['district']).ecjia_region::getRegionName($info['street']).$info['address'];
		$this->assign('store_info', $store_info);
		
		$db_data = RC_DB::table('express_order as eo')
		->leftJoin('users as user', RC_DB::raw('eo.user_id'), '=', RC_DB::raw('user.user_id'));
		
		$db_data->where(RC_DB::raw('eo.shipping_code'), 'ship_ecjia_express');
		
		$db_data->where(RC_DB::raw('eo.store_id'), $store_id)->where(RC_DB::raw('eo.status'),"!=", 6)->where(RC_DB::raw('eo.status'),"!=", 5)->where(RC_DB::raw('eo.status'),"!=", 4)->where(RC_DB::raw('eo.status'),"!=", 3);
		
		$express_count = $db_data->select(RC_DB::raw('count(*) as count'),
				RC_DB::raw('SUM(IF(eo.status = 0, 1, 0)) as no'),
				RC_DB::raw('SUM(IF(eo.status = 1, 1, 0)) as ok'),
				RC_DB::raw('SUM(IF(eo.status = 2, 1, 0)) as ing'))->first();
		
		if ($type == 'wait_grab') {
			$db_data->where(RC_DB::raw('eo.status'), 0);
		}
		
		if ($type == 'wait_pickup') {
			$db_data->where(RC_DB::raw('eo.status'), 1);
		}
		
		if ($type == 'delivery') {
			$db_data->where(RC_DB::raw('eo.status'), 2);
		}
		
		$count = $db_data->count();
		$page = new ecjia_page($count, 10, 5);
		
		$data = $db_data
		->select(RC_DB::raw('eo.express_id'), RC_DB::raw('eo.order_id'), RC_DB::raw('eo.express_sn'), RC_DB::raw('eo.commision'), RC_DB::raw('eo.status'), RC_DB::raw('eo.district'), RC_DB::raw('eo.street'), RC_DB::raw('eo.address'), RC_DB::raw('eo.consignee'), RC_DB::raw('eo.mobile'), RC_DB::raw('eo.express_user'), RC_DB::raw('eo.express_mobile'))
		->orderby(RC_DB::raw('eo.express_id'), 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['add_time'] 			= RC_Time::local_date('Y-m-d H:i:s', RC_DB::table('order_info')->where('order_id', $row['order_id'])->pluck('add_time'));
				$row['consignee_address'] 	= ecjia_region::getRegionName($row['district']).ecjia_region::getRegionName($row['street']).$row['address'];
				$list[] = $row;
			}
		}
		$order_list =  array('list' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc(),  'count' => $express_count);
		$this->assign('order_list', $order_list);
		
		$this->display('merchant_detail.dwt');
	}
	

	/**
	 * 查看订单详情
	 */
	public function order_detail() {
		$this->admin_priv('express_merchant_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('配送详情', 'express')));
		$this->assign('ur_here', __('配送详情', 'express'));

		$express_id = intval($_POST['express_id']);
		$express_info = RC_DB::table('express_order')->where('express_id', $express_id)->select('store_id','consignee','mobile','order_id', 'order_sn', 'delivery_id', 'delivery_sn', 'user_id','express_sn', 'distance','commision','express_user','express_mobile','from','signed_time','district as eodistrict','street as eostreet','address as eoaddress','status')->first();
		$store_info = RC_DB::table('store_franchisee')->where('store_id', $express_info['store_id'])->select('merchants_name','contact_mobile','district','street','address')->first();
		$order_info = RC_DB::table('order_info')->where('order_id', $express_info['order_id'])->select('add_time','expect_shipping_time','postscript')->first();
		//$goods_list = RC_DB::table('order_goods')->where('order_id', $express_info['order_id'])->select('goods_id', 'goods_name' ,'goods_price','goods_number')->get();
		$goods_list = RC_DB::table('delivery_goods')->where('delivery_id', $express_info['delivery_id'])->select(RC_DB::raw('goods_id'), RC_DB::raw('goods_name'), RC_DB::raw('send_number'))->get();
		
		foreach ($goods_list as $key => $val) {
			$goods_list[$key]['image']  				= RC_DB::table('goods')->where('goods_id', $val['goods_id'])->pluck('goods_thumb');
			$goods_list[$key]['goods_price']  			= RC_DB::table('order_goods')->where('goods_id', $val['goods_id'])->where('order_id', $express_info['order_id'])->pluck('goods_price');
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
	
		$data = $this->fetch('merchant_express_detail.dwt');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	private function get_merchant_list($cat_id = '') {
		$db_data = RC_DB::table('express_order as eo')
		->leftJoin('store_franchisee as sf', RC_DB::raw('eo.store_id'), '=', RC_DB::raw('sf.store_id'));
		
		$db_data->select(RC_DB::raw('distinct eo.store_id'), RC_DB::raw('sf.merchants_name'), RC_DB::raw('sf.cat_id'), RC_DB::raw('sf.district'), RC_DB::raw('sf.street'), RC_DB::raw('sf.address'))
		->orderby(RC_DB::raw('sf.store_id'), 'desc')->get();
		
		$db_data->Where(function ($query) {
			$query->orwhere(RC_DB::raw('eo.status'), 0)->orwhere(RC_DB::raw('eo.status'), 1)->orwhere(RC_DB::raw('eo.status'),2);
		});
		
		if ($cat_id) {
			$db_data ->where(RC_DB::raw('sf.cat_id'), $cat_id);
		}
		
		$db_data->where(RC_DB::raw('eo.shipping_code'), 'ship_ecjia_express');
		
		$keyword = trim($_GET['keyword']);
		if ($keyword) {
			$db_data ->whereRaw('(sf.merchants_name  like  "%'.mysql_like_quote($keyword).'%")');
		}

		$count = $db_data->count(RC_DB::raw('distinct(eo.store_id)'));
		$page = new ecjia_page($count, 15, 5);

		$data = $db_data
            ->take(10)
            ->skip($page->start_id-1)
			->get();
		
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$shop_trade_time = RC_DB::table('merchants_config')->where('store_id',$row['store_id'])->where('code', 'shop_trade_time')->pluck('value');
				$row['img'] = 	RC_DB::table('merchants_config')->where('store_id',$row['store_id'])->where('code', 'shop_logo')->pluck('value');
				$row['shop_kf_mobile'] = RC_DB::table('merchants_config')->where('store_id',$row['store_id'])->where('code', 'shop_kf_mobile')->pluck('value');
				$row['shop_trade_time'] = unserialize($shop_trade_time);
				$row['district'] = ecjia_region::getRegionName($row['district']);
				$row['street']   = ecjia_region::getRegionName($row['street']);
				$row['wait_grab'] = RC_DB::table('express_order')->where('status', 0)->where('shipping_code', 'ship_ecjia_express')->where('store_id', $row['store_id'])->count();
				$row['wait_pickup']	= RC_DB::table('express_order')->where('status', 1)->where('shipping_code', 'ship_ecjia_express')->where('store_id', $row['store_id'])->count();
				$row['delivery'] = RC_DB::table('express_order')->where('status', 2)->where('shipping_code', 'ship_ecjia_express')->where('store_id', $row['store_id'])->count();
				$list[] = $row;
			}
		}
			
		return array('list' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $count);
	}
	
	
	/**
	 * 获取店铺分类表
	 */
	private function get_cat_list($keyword = '') {
		$db_data = RC_DB::table('express_order as eo')
		->leftJoin('store_franchisee as sf', RC_DB::raw('eo.store_id'), '=', RC_DB::raw('sf.store_id'));
		$db_data->where(RC_DB::raw('eo.shipping_code'), 'ship_ecjia_express');
		$db_data->Where(function ($query) {
			$query->orwhere(RC_DB::raw('eo.status'), 0)->orwhere(RC_DB::raw('eo.status'), 1)->orwhere(RC_DB::raw('eo.status'),2);
		});
		$store_list = $db_data->select(RC_DB::raw('distinct eo.store_id'), RC_DB::raw('sf.cat_id'))->orderby(RC_DB::raw('sf.store_id'), 'desc')->get();
		
		$cat_list =array();
		foreach ($store_list as $k => $v) {
			$cat_list[$k]['cat_id'] = RC_DB::table('store_franchisee')->where('store_id', $v['store_id'])->pluck('cat_id');
		}
		
		foreach ($cat_list as $key => $value) {
			$cat_list[$key]['cat_name'] = RC_DB::table('store_category')->where('cat_id', $value['cat_id'])->pluck('cat_name');
			$count_cat = array_count_values(array_column($store_list,"cat_id"));
			foreach ($count_cat as $k => $v) {
				if($k == $value['cat_id']){
					$cat_list[$key]['number'] = $v;
				}
			}
		}
		
		//$cat_list = array_unique($cat_list);
		$cat_list = $this->more_array_unique($cat_list);

		if ($keyword) {
			foreach ($cat_list as $k => $v) {
				$cat_list[$k]['number'] = 0;
			}
			
			$db_data ->whereRaw('(sf.merchants_name  like  "%'.mysql_like_quote($keyword).'%")');
			$store_list = $db_data->select(RC_DB::raw('distinct eo.store_id'), RC_DB::raw('sf.cat_id'))->orderby(RC_DB::raw('sf.store_id'), 'desc')->get();
			
			$cat_list_keyword =array();
			foreach ($store_list as $k => $v) {
				$cat_list_keyword[$v['cat_id']]['cat_id'] = RC_DB::table('store_franchisee')->where('store_id', $v['store_id'])->pluck('cat_id');
			}
// 			foreach ($cat_list_keyword as $k => $v) {
				foreach ($cat_list_keyword as $key => $value) {
					$cat_list_keyword[$value['cat_id']]['cat_name'] = RC_DB::table('store_category')->where('cat_id', $value['cat_id'])->pluck('cat_name');
					$count_cat = array_count_values(array_column($store_list,"cat_id"));
					foreach ($count_cat as $k => $v) {
						if($k == $value['cat_id']){
							$cat_list_keyword[$value['cat_id']]['number'] = $v;
						}
					}
				}
// 			}
			//$cat_list_keyword = array_unique($cat_list_keyword);
			$cat_list_keyword = $this->more_array_unique($cat_list_keyword);
			foreach ($cat_list as $k => $v) {
				$cat_id = $v['cat_id'];
				$number = $cat_list_keyword[$cat_id]['number'];
				$cat_list[$k]['number'] = $number;
			}
		}

		$allnumber = 0;
		foreach($cat_list as $key=>$value){
			$allnumber+= $value['number'];
		}
		return array('list' => $cat_list, 'allnumber' => $allnumber);
	}
	
	/**
	 * 二维数组去重
	 * @param array $arr
	 * @return array
	 */
	private function more_array_unique($arr=array()){
		if (!empty($arr)) {
			foreach($arr[0] as $k => $v){
				$arr_inner_key[]= $k;  //先把二维数组中的内层数组的键值记录在在一维数组中
			}
			
			foreach ($arr as $k => $v){
				$v =join(",",$v);  //降维 用implode()也行
				$temp[$k] =$v;   //保留原来的键值 $temp[]即为不保留原来键值
			}
			
			$temp =array_unique($temp);  //去重：去掉重复的字符串
			
			foreach ($temp as $k => $v){
				$a = explode(",",$v);  //拆分后的重组 如：Array( [0] => james [1] => 30 )
				$arr_after[$k]= array_combine($arr_inner_key,$a); //将原来的键与值重新合并
			}
			//ksort($arr_after);//排序如需要：ksort对数组进行排序(保留原键值key) ,sort为不保留key值
			sort($arr_after);
			return$arr_after;
		}
	}
}

//end
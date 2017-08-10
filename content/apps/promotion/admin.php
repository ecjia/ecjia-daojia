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
 * ECJIA 促销管理程序
 */
class admin extends ecjia_admin {
	public function __construct() {
        parent::__construct();
        
        RC_Loader::load_app_func('global');
        assign_adminlog_content();
        
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        
        //时间控件
		RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
		
        RC_Script::enqueue_script('promotion', RC_App::apps_url('statics/js/promotion.js', __FILE__), array(), false, true);
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('promotion::promotion.promotion'), RC_Uri::url('mobilebuy/admin/init')));
    }
    	
	/**
	 * 促销商品列表页
	 */
	public function init() {
		$this->admin_priv('promotion_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('promotion::promotion.promotion')));
		
		$this->assign('ur_here', RC_Lang::get('promotion::promotion.promotion_list'));
		$this->assign('action_link', array('href' => RC_Uri::url('promotion/admin/add'), 'text' => RC_Lang::get('promotion::promotion.add_promotion')));
		
		$type = isset($_GET['type']) && in_array($_GET['type'], array('on_sale', 'coming', 'finished', 'self')) ? trim($_GET['type']) : '';
		$promotion_list = $this->promotion_list($type);
		$time = RC_Time::gmtime();
		
		$this->assign('promotion_list', $promotion_list);
		$this->assign('type_count', $promotion_list['count']);
		$this->assign('filter', $promotion_list['filter']);
		
		$this->assign('type', $type);
		$this->assign('time', $time);
		$this->assign('form_search', RC_Uri::url('promotion/admin/init'));
		
		$this->display('promotion_list.dwt');
	}

	/**
	 * 添加促销商品
	 */
	public function add() {
		$this->admin_priv('promotion_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('promotion::promotion.add_promotion')));
		$this->assign('ur_here', RC_Lang::get('promotion::promotion.add_promotion'));
		$this->assign('action_link', array('href' => RC_Uri::url('promotion/admin/init'), 'text' => RC_Lang::get('promotion::promotion.promotion_list')));
		
		$this->assign('form_action', RC_Uri::url('promotion/admin/insert'));
		
		$this->display('promotion_info.dwt');
	}
	
	/**
	 * 处理添加促销商品
	 */
	public function insert() {
		$this->admin_priv('promotion_update', ecjia::MSGTYPE_JSON);
		
		$goods_id 	= intval($_POST['goods_id']);
		$price		= $_POST['price'];
		
		$time = RC_Time::gmtime();
		$info = RC_DB::table('goods')
			->where('is_promote', 1)
			->where('goods_id', $goods_id)
			->where('promote_start_date', '<=', $time)
			->where('promote_end_date', '>=', $time)
			->first();
		
		if (!empty($info)) {
			return $this->showmessage(RC_Lang::get('promotion::promotion.promotion_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$goods_name = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_name');
		
		$start_time = RC_Time::local_strtotime($_POST['start_time']);
		$end_time 	= RC_Time::local_strtotime($_POST['end_time']);
		
		if ($start_time >= $end_time) {
			return $this->showmessage(RC_Lang::get('promotion::promotion.promotion_invalid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		RC_DB::table('goods')->where('goods_id', $goods_id)->update(array('is_promote' => 1, 'promote_price' => $price, 'promote_start_date' => $start_time, 'promote_end_date' => $end_time));
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		
		ecjia_admin::admin_log($goods_name, 'add', 'promotion');
		$links[] = array('text' => RC_Lang::get('promotion::promotion.return_promotion_list'), 'href'=> RC_Uri::url('promotion/admin/init'));
		$links[] = array('text' => RC_Lang::get('promotion::promotion.continue_add_promotion'), 'href'=> RC_Uri::url('promotion/admin/add'));
		return $this->showmessage(RC_Lang::get('promotion::promotion.add_promotion_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('promotion/admin/edit', array('id' => $goods_id))));
	}
	
	/**
	 * 编辑促销商品
	 */
	public function edit() {	
		$this->admin_priv('promotion_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('promotion::promotion.edit_promotion')));
		
		$this->assign('ur_here', RC_Lang::get('promotion::promotion.edit_promotion'));
		$this->assign('action_link', array('href' => RC_Uri::url('promotion/admin/init'), 'text' => RC_Lang::get('promotion::promotion.promotion_list')));

		$id = intval($_GET['id']);
		$promotion_info = RC_DB::table('goods')
		->select('goods_id', 'goods_name', 'promote_price', 'promote_start_date', 'promote_end_date')
		->where('goods_id', $id)
		->first();
	   
		$promotion_info['promote_start_date'] 	= RC_Time::local_date('Y-m-d H:i:s', $promotion_info['promote_start_date']);
		$promotion_info['promote_end_date'] 	= RC_Time::local_date('Y-m-d H:i:s', $promotion_info['promote_end_date'] );

		$this->assign('promotion_info', $promotion_info);
		$this->assign('form_action', RC_Uri::url('promotion/admin/update'));

		$this->display('promotion_info.dwt');
	}
	
	/**
	 * 更新促销商品
	 */
	public function update() {
		$this->admin_priv('promotion_update', ecjia::MSGTYPE_JSON);
		
		$goods_id		= intval($_POST['goods_id']);
		$price	  	  	= $_POST['price'];
		$goods_name 	= RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_name');
		
		$start_time 	= RC_Time::local_strtotime($_POST['start_time']);
		$end_time 		= RC_Time::local_strtotime($_POST['end_time']);
		$old_goods_id   = intval($_POST['old_goods_id']);
		
		if ($start_time >= $end_time) {
			return $this->showmessage(RC_Lang::get('promotion::promotion.promotion_invalid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		RC_DB::table('goods')->where('goods_id', $goods_id)->update(array('is_promote' => 1, 'promote_price' => $price, 'promote_start_date' => $start_time, 'promote_end_date' => $end_time));
		
		//更新原来的商品为非促销商品
		if ($goods_id != $old_goods_id) {
			RC_DB::table('goods')->where('goods_id', $old_goods_id)->update(array('is_promote' => 0, 'promote_price' => 0, 'promote_start_date' => 0, 'promote_end_date' => 0));
		}
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		
		ecjia_admin::admin_log($goods_name, 'edit', 'promotion');
		return $this->showmessage(RC_Lang::get('promotion::promotion.edit_promotion_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('promotion/admin/edit', array('id' => $goods_id))));
	}
	
	/**
	 * 删除促销商品
	 */
	public function remove() {
		$this->admin_priv('promotion_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$goods_name = RC_DB::table('goods')->where('goods_id', $id)->pluck('goods_name');
		
		//更新商品为非促销商品
		RC_DB::table('goods')->where('goods_id', $id)->update(array('is_promote' => 0, 'promote_price' => 0, 'promote_start_date' => 0, 'promote_end_date' => 0));
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		
		ecjia_admin::admin_log($goods_name, 'remove', 'promotion');
		return $this->showmessage(RC_Lang::get('promotion::promotion.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 添加/编辑页搜索商品
	 */
	public function search_goods() {
		$goods_list = array();
        $arr = $_POST;
        $goods_id = !empty($_POST['goods_id']) ? intval($_POST['goods_id']) : '';
        $arr['store_id'] = RC_DB::table('goods')->select('store_id')->where('goods_id', $goods_id)->pluck();
		$row = RC_Api::api('goods', 'get_goods_list', $arr);
		if (!is_ecjia_error($row)) {
			if (!empty($row)) {
				foreach ($row AS $key => $val) {
					$goods_list[] = array(
						'value' => $val['goods_id'],
						'text'  => $val['goods_name'],
						'data'  => $val['shop_price']
					);
				}
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $goods_list));
	}
	
	/**
	 * 获取活动列表
	 *
	 * @access  public
	 *
	 * @return void
	 */
	private function promotion_list($type = '') {
		$filter['keywords'] 			= empty($_GET['keywords']) 			? '' : stripslashes(trim($_GET['keywords']));
		$filter['merchant_keywords'] 	= empty($_GET['merchant_keywords']) ? '' : stripslashes(trim($_GET['merchant_keywords']));
		
		$db_goods = RC_DB::table('goods as g')
			->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('g.store_id'));
		
		$db_goods->where('is_promote', '1')->where('is_delete', '!=', 1);
		
		if (!empty($filter['keywords'])) {
			$db_goods->where('goods_name', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
		
		if (!empty($filter['merchant_keywords'])) {
			$db_goods->where(RC_DB::raw('s.merchants_name'), 'like', '%'.mysql_like_quote($filter['merchant_keywords']).'%');
		}
		
		$time = RC_Time::gmtime();
		$type_count = $db_goods->select(RC_DB::raw('count(*) as count'),
				RC_DB::raw('SUM(IF(promote_start_date <'.$time.' and promote_end_date > '.$time.', 1, 0)) as on_sale'),
				RC_DB::raw('SUM(IF(promote_start_date >'.$time.', 1, 0)) as coming'),
				RC_DB::raw('SUM(IF(s.manage_mode = "self", 1, 0)) as self'),
				RC_DB::raw('SUM(IF(promote_end_date <'.$time.', 1, 0)) as finished'))->first();
		
		if ($type == 'on_sale') {
			$where['promote_start_date'] = array('elt' => $time);
			$where['promote_end_date'] = array('egt' => $time);
			
			$db_goods->where('promote_start_date', '<=', $time)->where('promote_end_date', '>=', $time);
		}
		
		if ($type == 'coming') {
			$db_goods->where('promote_start_date', '>=', $time);
		}
		
		if ($type == 'finished') {
			$db_goods->where('promote_end_date', '<=', $time);
		}

		if ($type == 'self') {
			$db_goods->where(RC_DB::raw('s.manage_mode'), 'self');
		}
		
		$count = $db_goods->count();
		$page = new ecjia_page($count, 10, 5);
		
		$result = $db_goods
			->select('goods_id', 'goods_name', 'promote_price', 'promote_start_date', 'promote_end_date', 'goods_thumb', RC_DB::raw('s.merchants_name'))->take(10)->skip($page->start_id-1)->get();
		
		if (!empty($result)) {
			$disk = RC_Filesystem::disk();
			foreach ($result as $key => $val) {
				$result[$key]['start_time'] = RC_Time::local_date('Y-m-d H:i:s', $val['promote_start_date']);
				$result[$key]['end_time']   = RC_Time::local_date('Y-m-d H:i:s', $val['promote_end_date']);
				if (!$disk->exists(RC_Upload::upload_path() . $val['goods_thumb']) || empty($val['goods_thumb'])) {
					$result[$key]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
				} else {
					$result[$key]['goods_thumb'] = RC_Upload::upload_url() . '/' . $val['goods_thumb'];
				}
			}
		}
		return array('item' => $result, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $type_count);
	}
}

// end
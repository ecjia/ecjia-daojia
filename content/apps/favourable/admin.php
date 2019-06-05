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
 * 管理中心优惠活动管理
 * @author songqian
 */
class admin extends ecjia_admin {
	//private $db_favourable_activity;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('admin_favourable');
		//$this->db_favourable_activity = RC_Model::model('favourable/favourable_activity_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');

		//时间控件
		RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
		
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('favourable_list', RC_App::apps_url('statics/js/favourable_list.js', __FILE__));
		
		RC_Script::localize_script('favourable_list', 'js_lang', config('app-favourable::jslang.favourable_page'));
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('优惠活动列表', 'favourable'), RC_Uri::url('favourable/admin/init')));
	}
	
	/**
	 * 活动列表页
	 */
	public function init() {
		$this->admin_priv('favourable_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('优惠活动列表', 'favourable')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> __('概述', 'favourable'),
			'content'	=> '<p>' . __('欢迎访问ECJia智能后台优惠活动列表页面，系统中所有的优惠活动都会显示在此列表中。', 'favourable') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息：', 'favourable') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:优惠活动" target="_blank">'.__('关于优惠活动列表帮助文档', 'favourable').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', __('优惠活动列表', 'favourable'));
		
		$list = $this->get_favourable_list();
		$this->assign('favourable_list', $list);
		
		$shop_type = RC_Config::load_config('site', 'SHOP_TYPE');
		$shop_type = !empty($shop_type) ? $shop_type : 'b2c';
		$this->assign('shop_type', $shop_type);
		
		$this->assign('search_action', RC_Uri::url('favourable/admin/init'));

        return $this->display('favourable_list.dwt');
	}
	
	/**
	 * 添加页面
	 */
	public function add() {}
	
	/**
	 * 添加处理
	 */
	public function insert() {}
	
	/**
	 * 编辑
	 */
	public function edit() {}
	
	/**
	 * 编辑处理
	 */
	public function update() {}

	/**
	 * 删除
	 */
	public function remove() {
		$this->admin_priv('favourable_delete', ecjia::MSGTYPE_JSON);
		
		$id         = intval($_GET['act_id']);
		//$favourable = $this->db_favourable_activity->favourable_info($id);
		$favourable = Ecjia\App\Favourable\FavourableActivity::FavourableInfo($id);
		if (empty($favourable)) {
			return $this->showmessage(__('您要操作的优惠活动不存在', 'favourable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$name     = $favourable['act_name'];
		$act_type = $favourable['act_type'];
		
		if ($act_type == 0) {
			$act_type = __('享受赠品（特惠品）', 'favourable');
		} elseif ($act_type == 1) {
			$act_type = __('享受现金减免', 'favourable');
		} else {
			$act_type = __('享受价格折扣', 'favourable');
		}

		//$this->db_favourable_activity->favourable_remove($id);
		Ecjia\App\Favourable\FavourableActivity::FavourableRemove($id);
		/* 释放优惠活动缓存*/
		$favourable_activity_db   = RC_Model::model('favourable/orm_favourable_activity_model');
		$cache_favourable_key     = 'favourable_list_store_'.$favourable['store_id'];
		$cache_id                 = sprintf('%X', crc32($cache_favourable_key));
		$favourable_activity_db->delete_cache_item($cache_id);
		
		ecjia_admin::admin_log($name.'，'.__('优惠活动方式是 ', 'favourable').$act_type, 'remove', 'favourable');
		return $this->showmessage(__('删除成功', 'favourable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 批量操作
	 */
	public function batch() {
		$this->admin_priv('favourable_delete', ecjia::MSGTYPE_JSON);
		
		$ids      = $_POST['act_id'];
		$act_ids  = explode(',', $ids);
		$info     = RC_DB::table('favourable_activity')->whereIn('act_id', $act_ids)->get();

		Ecjia\App\Favourable\FavourableActivity::FavourableRemove($act_ids);
		
		/* 释放优惠活动缓存*/
		$favourable_activity_db = RC_Model::model('favourable/orm_favourable_activity_model');
		
		if (!empty($info)) {
			foreach ($info as $v) {
				if ($v['act_type'] == 0) {
					$act_type = __('享受赠品（特惠品）', 'favourable');
				} elseif ($v['act_type'] == 1) {
					$act_type = __('享受现金减免', 'favourable');
				} else {
					$act_type = __('享受价格折扣', 'favourable');
				}
				/* 释放优惠活动缓存*/
				$cache_favourable_key   = 'favourable_list_store_'.$v['store_id'];
				$cache_id               = sprintf('%X', crc32($cache_favourable_key));
				$favourable_activity_db->delete_cache_item($cache_id);
				ecjia_admin::admin_log($v['act_name'].'，'.__('优惠活动方式是 ', 'favourable').$act_type, 'batch_remove', 'favourable');
			}
		}
		return $this->showmessage(__('批量删除成功', 'favourable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('favourable/admin/init')));
	}
	/**
	 * 编辑优惠活动名称
	 */
	public function edit_act_name() {
		$this->admin_priv('favourable_update', ecjia::MSGTYPE_JSON);
		
		$act_name = trim($_POST['value']);
		$id	      = intval($_POST['pk']);
		$store_id = intval($_REQUEST['store_id']);
		
		if ($store_id > 0) {
			$count = RC_DB::table('favourable_activity')->where('act_name', $act_name)->where('act_id', '!=', $id)->where('store_id', $store_id)->count();
		} else {
			$count = RC_DB::table('favourable_activity')->where('act_name', $act_name)->where('act_id', '!=', $id)->count();
		}
	
		if (!empty($act_name)) {
			if ($count == 0) {
				$data = array(
					'act_id'	=> $id,
					'act_name'	=> $act_name
				);
				//$this->db_favourable_activity->favourable_manage($data);
				Ecjia\App\Favourable\FavourableActivity::FavourableManage($data);
				/* 释放优惠活动缓存*/
				$favourable_activity_db = RC_Model::model('favourable/orm_favourable_activity_model');
				$cache_favourable_key   = 'favourable_list_store_'.$store_id;
				$cache_id               = sprintf('%X', crc32($cache_favourable_key));
				$favourable_activity_db->delete_cache_item($cache_id);
				return $this->showmessage(__('更新优惠活动名称成功', 'favourable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				return $this->showmessage(__('该优惠活动名称已存在，请您换一个', 'favourable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(__('请输入优惠活动名称', 'favourable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 修改排序
	 */
	public function edit_sort_order() {
		$this->admin_priv('favourable_update', ecjia::MSGTYPE_JSON);
		
		$id  = intval($_POST['pk']);
		$val = intval($_POST['value']);
		$data = array(
			'act_id' 		=> $id,
			'sort_order' 	=> $val
		);
		//$this->db_favourable_activity->favourable_manage($data);
		Ecjia\App\Favourable\FavourableActivity::FavourableManage($data);
		
		return $this->showmessage(__('排序操作成功', 'favourable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('favourable/admin/init')) );
	}
	
	/**
	 * 搜索商品
	 */
	public function search() {
		$this->admin_priv('favourable_manage', ecjia::MSGTYPE_JSON);
		
		$act_range    = !empty($_POST['act_range'])    ? $_POST['act_range']      : 0;
		$keyword      = !empty($_POST['keyword'])      ? trim($_POST['keyword'])  : '';
		$store_id     = is_numeric($_POST['store_id']) ? $_POST['store_id']       : '';
		$where = array();
		
		if ($act_range == FAR_ALL) {//全部商品
			$arr[0] = array(
				'id'   => 0,
				'name' => __('优惠范围是全部商品，不需要此操作', 'favourable')
			);
		} elseif ($act_range == FAR_CATEGORY) {//按分类选择
			$db_category = RC_DB::table('category')->select(RC_DB::raw('cat_id as id'), RC_DB::raw('cat_name as name'));
			if (empty($keyword)) {
				$arr = $db_category->get();
				RC_Loader::load_app_func('admin_category', 'goods');
				$result = cat_list(0, 0, false);
				$arr = array();
				if (!empty($result)) {
					foreach ($result as $key => $row) {
						$arr[$key]['id'] 	= $row['cat_id'];
						$arr[$key]['level'] = $row['level'];
						$arr[$key]['name'] 	= $row['cat_name'];
					}
					$arr = array_merge($arr);
				}
			} else {
				$arr = $db_category->where('cat_name', 'like', '%'.mysql_like_quote($keyword).'%')->get();
			}
		} elseif ($act_range == FAR_BRAND) {//按品牌选择
			$db_brand = RC_DB::table('brand')->select(RC_DB::raw('brand_id as id'), RC_DB::raw('brand_name as name'));
			if (!empty($keyword)) {
				$db_brand->where('brand_name', 'like', '%'.mysql_like_quote($keyword).'%');
			}
			$arr = $db_brand->get();
		} else {
			$db_goods = RC_DB::table('goods')->select(RC_DB::raw('goods_id as id'), RC_DB::raw('goods_name as name'));
			if (!empty($keyword)) {
				$db_goods->where('goods_name', 'like', '%'.mysql_like_quote($keyword).'%');
			}
			$db_goods->where('is_delete', 0);
			if (!empty($store_id)) {
				$db_goods->where('store_id', $store_id);
			}
			$arr = $db_goods->get();

			if (!empty($arr)) {
				foreach ($arr as $key => $row) {
					$arr[$key]['name'] = stripslashes($row['name']);
					$arr[$key]['url'] = RC_Uri::url('goods/admin/preview', 'id='.$row['id']);
				}
			}
		}
		if (empty($arr)) {
			$arr = array(0 => array(
				'id'   => 0,
				'name' => __('没有找到相应记录，请重新搜索', 'favourable')
			));
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
	}
	
	/*
	 * 取得优惠活动列表
	*/
	private function get_favourable_list() {
		$filter['sort_by']    	 = empty($_GET['sort_by']) 	       ? 'act_id' 				: trim($_GET['sort_by']);
		$filter['sort_order'] 	 = empty($_GET['sort_order'])      ? 'DESC' 				: trim($_GET['sort_order']);
		$filter['keyword']		 = empty($_GET['keyword']) 	       ? '' 					: mysql_like_quote(trim($_GET['keyword']));
		$filter['merchant_name'] = empty($_GET['merchant_name'])   ? '' 				    : mysql_like_quote(trim($_GET['merchant_name']));
		$filter['type'] 	 	 = isset($_GET['type']) 		   ? trim($_GET['type']) 	: '';

		/* 连接导航*/
		$uri = array();
		empty($filter['merchant_name']) ? '' : $uri['merchant_name']  = $filter['merchant_name'];
		empty($filter['keyword']) 		? '' : $uri['keyword']        = $filter['keyword'];
		
		$quickuri = array(
			'init'		=> RC_Uri::url('favourable/admin/init', $uri),
			'on_going'	=> RC_Uri::url('favourable/admin/init', array_merge(array('type' => 'on_going'), $uri)),
			'self'		=> RC_Uri::url('favourable/admin/init', array_merge(array('type' => 'self'), $uri)),
		);
		
		/* 初始化优惠活动数量*/		
		$favourable_count = array(
			'count'		=> 0,//全部
			'on_going'	=> 0,//进行中
			'self'		=> 0,//商家
		);
		
		$favourable_count['count']		= RC_Api::api('favourable', 'favourable_count', array('keyword' => $filter['keyword'], 'merchant_name' => $filter['merchant_name']));
		$favourable_count['on_going']	= RC_Api::api('favourable', 'favourable_count', array('keyword' => $filter['keyword'], 'merchant_name' => $filter['merchant_name'], 'type' => 'on_going'));
		$favourable_count['self']		= RC_Api::api('favourable', 'favourable_count', array('keyword' => $filter['keyword'], 'merchant_name' => $filter['merchant_name'], 'type' => 'self'));
			
		if ($filter['type'] == 'on_going') {
			$page = new ecjia_page($favourable_count['on_going'], 15, 5);
		} elseif ($filter['type'] == 'self') {
			$page = new ecjia_page($favourable_count['self'], 15, 5);
		} else {
			$page = new ecjia_page($favourable_count['count'], 15, 5);
		}
		$filter['skip']  = $page->start_id-1;
		$filter['limit'] = 15;
		$data            = RC_Api::api('favourable', 'favourable_list', $filter);
		
		$list = array();
		if (!empty($data)) {
		    $rank_list = RC_DB::table('user_rank')->get();
		    if($rank_list) {
		        $rank_list = self::array_change_key($rank_list, 'rank_id');
		    }
			foreach ($data as $row) {
				$row['start_time']  = RC_Time::local_date('Y-m-d H:i', $row['start_time']);
				$row['end_time']    = RC_Time::local_date('Y-m-d H:i', $row['end_time']);
				$row['user_rank_name'] = '未设置';
				if(!empty($row['user_rank'])) {
				    $rank_arr = explode(',', $row['user_rank']);
				    if($rank_arr) {
				        $row['user_rank_name'] = '';
				        $i = 0;
				        foreach ($rank_arr as $rank_id) {
				            $delimiter = $i > 0 ? ',' : '';
				            $row['user_rank_name'] .= $delimiter . ($rank_id == 0 ? '非会员' : $rank_list[$rank_id]['rank_name']);
				            $i++;
				        }
				    }
				}
				$list[] = $row;
			}
		}
		return array('item' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $favourable_count, 'quickuri' => $quickuri);
	}
	
	private function array_change_key($arr, $new_key) {
	    $formate_arr = [];
	    foreach ($arr as $row) {
	        if (is_array($new_key)) {
	            $key = '';
	            $i = 0;
	            foreach ($new_key as $val) {
	                if ($i > 0) {
	                    $key .= '_' . $row[$val];
	                } else {
	                    $key .= $row[$val];
	                }
	                $i++;
	            }
	            $formate_arr[$key] = $row;
	        } else {
	            $formate_arr[$row[$new_key]] = $row;
	        }
	        
	    }
	    
	    return $formate_arr;
	}
}

//end
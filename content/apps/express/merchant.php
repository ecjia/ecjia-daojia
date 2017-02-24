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
 * ECJIA 配送信息
 */
class merchant extends ecjia_merchant {
	private $express_order_db;

	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('global');
		$this->express_order_db	= RC_Model::model('express/express_order_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('express', RC_App::apps_url('statics/js/merchant_express.js', __FILE__));
		RC_Script::enqueue_script('ecjia.utils');
		
		RC_Loader::load_app_class('shipping_factory', null, false);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('配送管理', RC_Uri::url('shipping/merchant/init')));
	}

	/**
	 * 配送方式列表 
	 */
	public function init() { 
		$this->admin_priv('express_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('express::express.express_list')));
		
		$this->assign('ur_here', RC_Lang::get('express::express.express_list'));
		
		$count = RC_Api::api('express', 'express_order_count');
		
		/* 定义每页数量*/
		$filter['limit']	= 15;
		
		$page               = new ecjia_merchant_page($count, $filter['limit'], 5);
		$filter['skip']		= $page->start_id-1;
		
		$express_list       = RC_Api::api('express', 'express_order_list', $filter);
		
		if (!empty($express_list)) {
			foreach ($express_list as $key => $val) {
				$express_list[$key]['formatted_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
				if ($val['from'] == 'assign') {
					$express_list[$key]['label_from'] = RC_Lang::get('express::express.assign');
				} elseif ($val['from'] == 'grab') {
					$express_list[$key]['label_from'] = RC_Lang::get('express::express.grab');
				} else {
					$express_list[$key]['label_from'] = RC_Lang::get('express::express.wait_assign');
				}
				
				switch ($val['status']) {
					case 0 : 
						$express_list[$key]['label_status'] = RC_Lang::get('express::express.wait_assign_express');
						break;
					case 1 : 
						$express_list[$key]['label_status'] = RC_Lang::get('express::express.wait_pick_up');
						break;
					case 2 :
						$express_list[$key]['label_status'] = RC_Lang::get('express::express.express_delivery');
						break;
					case 3 :
						$express_list[$key]['label_status'] = RC_Lang::get('express::express.return_express');
						break;
					case 4 :
						$express_list[$key]['label_status'] = RC_Lang::get('express::express.refused');
						break;
					case 5 :
						$express_list[$key]['label_status'] = RC_Lang::get('express::express.already_signed');
						break;
					case 6 :
						$express_list[$key]['label_status'] = RC_Lang::get('express::express.has_returned');
						break;
				}
			}
		}
		
		$this->assign('express_list', $express_list);
		
		$this->assign('page', $page->show(2));
		
		$this->display('express_list.dwt');
	}
	
	public function info() {
		$this->admin_priv('express_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('express::express.express_info')));
		
		$express_id = isset($_GET['express_id']) ? intval($_GET['express_id']) : 0;
		$where = array('store_id' => $_SESSION['store_id']);
		
		$express_info = RC_DB::table('express_order as eo')
			->where(RC_DB::raw('express_id'), $express_id)
			->first();
		
		$express_info['formatted_add_time']		= RC_Time::local_date(ecjia::config('time_format'), $express_info['add_time']);
		$express_info['formatted_receive_time']	= $express_info['receive_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_info['receive_time']) : '';
		$express_info['formatted_express_time']	= $express_info['express_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_info['express_time']) : '';
		$express_info['formatted_signed_time']	= $express_info['signed_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_info['signed_time']) : '';
		$express_info['formatted_update_time']	= $express_info['update_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_info['update_time']) : '';
		
		if ($express_info['from'] == 'assign') {
			$express_info['label_from'] = RC_Lang::get('express::express.assign');
		} elseif ($express_info['from'] == 'grab') {
			$express_info['label_from'] = RC_Lang::get('express::express.grab');
		} elseif ($express_info['from'] == 'grab' && $express_info['staff_id'] == 0) {
			$express_info['label_from'] = RC_Lang::get('express::express.wait_assign');
		}
		
		switch ($express_info['status']) {
			case 0 :
				$express_info['label_status'] = RC_Lang::get('express::express.wait_assign_express');
				break;
			case 1 :
				$express_info['label_status'] = RC_Lang::get('express::express.wait_pick_up');
				break;
			case 2 :
				$express_info['label_status'] = RC_Lang::get('express::express.express_delivery');
				break;
			case 3 :
				$express_info['label_status'] = RC_Lang::get('express::express.return_express');
				break;
			case 4 :
				$express_info['label_status'] = RC_Lang::get('express::express.refused');
				break;
			case 5 :
				$express_info['label_status'] = RC_Lang::get('express::express.already_signed');
				break;
			case 6 :
				$express_info['label_status'] = RC_Lang::get('express::express.has_returned');
				break;
		}
		
		/* 取得发货单商品 */
		$goods_list = RC_DB::table('delivery_goods')->where('delivery_id', $express_info['delivery_id'])->get();
		
		/* 取得区域名 */
		$region = RC_DB::table('express_order as eo')
			->leftJoin('region as c', RC_DB::raw('eo.country'), '=', RC_DB::raw('c.region_id'))
			->leftJoin('region as p', RC_DB::raw('eo.province'), '=', RC_DB::raw('p.region_id'))
			->leftJoin('region as t', RC_DB::raw('eo.city'), '=', RC_DB::raw('t.region_id'))
			->leftJoin('region as d', RC_DB::raw('eo.district'), '=', RC_DB::raw('d.region_id'))
			->select(RC_DB::raw("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region"))
			->where(RC_DB::raw('eo.express_id'), $express_id)
			->first();
		
		$express_info['region'] = $region['region'];
		
		if ($express_info['staff_id'] > 0) {
			$express_info['staff_user'] = RC_DB::table('staff_user')->where('user_id', $express_info['staff_id'])->pluck('name');
		}
		
		$staff_list = RC_DB::table('staff_user')
			->where('store_id', $_SESSION['store_id'])
// 			->where('online_status', 1)
			->get();
		
		$this->assign('staff_user', $staff_list);
		$this->assign('express_info', $express_info);
		$this->assign('goods_list', $goods_list);
		$this->assign('form_action', RC_Uri::url('express/merchant/assign_express'));
		
		$this->assign('ur_here', RC_Lang::get('express::express.express_info'));
		$this->assign('action_link',array('href' => RC_Uri::url('express/merchant/init'),'text' => RC_Lang::get('express::express.express_list')));
		
		$this->display('express_info.dwt');
	}
	
	function assign_express() {
		$this->admin_priv('express_manage', ecjia::MSGTYPE_JSON);
		
		$staff_id	= isset($_POST['staff_id']) ? intval($_POST['staff_id']) : 0;
		$express_id	= isset($_POST['express_id']) ? intval($_POST['express_id']) : 0;
		
		$express_info = RC_DB::table('express_order')->where('status', '<=', 2)->where('store_id', $_SESSION['store_id'])->where('express_id', $express_id)->first();
		
		/* 判断配送单*/
		if (empty($express_info)) {
			return $this->showmessage('没有相应的配送单！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$staff_user = RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('user_id', $staff_id)->first();
		if (empty($staff_user)) {
			return $this->showmessage('请选择相应配送员！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$assign_express_data = array('status' => 1, 'staff_id' => $staff_id, 'express_user' => $staff_user['name'], 'express_mobile' => $staff_user['mobile'], 'update_time' => RC_Time::gmtime());
		RC_DB::table('express_order')->where('store_id', $_SESSION['store_id'])->where('express_id', $express_id)->update($assign_express_data);
		
		return $this->showmessage('配送单派单成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('express/merchant/info', array('express_id' => $express_id))));
	}
}	

// end
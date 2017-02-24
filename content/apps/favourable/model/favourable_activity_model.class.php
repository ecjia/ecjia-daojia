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

class favourable_activity_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'favourable_activity';
		parent::__construct();
	}

	/*
	 * 取得优惠活动列表
	 * @param   array()     $filter     查询条件
	 * @return   array
	 */
	public function favourable_list($filter = array()) {
		$db_favourable_activity = RC_DB::table('favourable_activity');
		if (!empty($filter['keyword'])) {
			$db_favourable_activity->where('act_name', 'like', '%'. mysql_like_quote($filter['keyword']) .'%');
		}
		$now = RC_Time::gmtime();
		if (isset($filter['is_going']) && $filter['is_going'] == 1) {
			$db_favourable_activity->where('start_time', '<=', $now)->where('end_time', '>=', $now);
		}
		/* 正在进行中*/
		if (isset($filter['status']) && $filter['status'] == 'going') {
			$db_favourable_activity->where('start_time', '<=', $now)->where('end_time', '>=', $now);
		}
		/* 即将开始*/
		if (isset($filter['status']) && $filter['status'] == 'coming') {

			$db_favourable_activity->where('start_time', '>=', $now);
		}
		/* 已结束*/
		if (isset($filter['status']) && $filter['status'] == 'finished') {
			$db_favourable_activity->where('end_time', '<=', $now);
		}

		/* 排序*/
		$filter['sort_by']    = empty($filter['sort_by']) ? 'act_id' : trim($filter['sort_by']);
		$filter['sort_order'] = empty($filter['sort_order']) ? 'DESC' : trim($filter['sort_order']);

		$count = $db_favourable_activity->count();
		//实例化分页
		$page_row = new ecjia_page($count, $filter['size'], 6, '', $filter['page']);

		$res = $db_favourable_activity
			->orderby($filter['sort_by'], $filter['sort_order'])
			->select('*')
			->take($filter['size'])
			->skip($page->start_id-1)
			->get();

		$list = array();
		if (!empty($res)) {
			foreach ($res as $row) {
				$row['start_time']  = RC_Time::local_date('Y-m-d H:i', $row['start_time']);
				$row['end_time']    = RC_Time::local_date('Y-m-d H:i', $row['end_time']);
				$list[] = $row;
			}
		}
		return array('item' => $list, 'page' => $page_row);
	}

	public function favourable_info($act_id) {
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			RC_DB::table('favourable_activity')->where('store_id', $_SESSION['store_id']);
			$favourable = RC_DB::table('favourable_activity')->where('act_id', $act_id)->where('store_id', $_SESSION['store_id'])->first();
		} else {
		    $favourable = RC_DB::table('favourable_activity')->where('act_id', $act_id)->first();
		}
		
		if (!empty ($favourable)) {
			$favourable['start_time']	= RC_Time::local_date(ecjia::config('time_format'), $favourable['start_time']);
			$favourable['end_time']		= RC_Time::local_date(ecjia::config('time_format'), $favourable['end_time']);

			$favourable['formatted_min_amount'] = price_format($favourable['min_amount'] );
			$favourable['formatted_max_amount'] = price_format($favourable['max_amount'] );

			$favourable['gift'] = unserialize($favourable['gift']);
			if ($favourable['act_type'] == FAT_GOODS) {
				$favourable['act_type_ext'] = round($favourable['act_type_ext']);
			}
			/* 取得用户等级 */
			$favourable['user_rank_list'] = array();
			$favourable['user_rank_list'][] = array(
				'rank_id'   => 0,
				'rank_name' => __('非会员'),
				'checked'   => strpos(',' . $favourable['user_rank'] . ',', ',0,') !== false,
			);

			$data = RC_DB::table('user_rank')->select('rank_id', 'rank_name')->get();
			if (!empty($data)) {
				foreach ($data as $row) {
					$row['checked']                 = strpos(',' . $favourable['user_rank'] . ',', ',' . $row['rank_id']. ',') !== false;
					$favourable['user_rank_list'][] = $row;
				}
			}

			/* 取得优惠范围 */
			$act_range_ext = array();
			if ($favourable['act_range'] != FAR_ALL && !empty($favourable['act_range_ext'])) {
				$favourable['act_range_ext'] = explode(',', $favourable['act_range_ext']);
				if ($favourable['act_range'] == FAR_CATEGORY) {
					$act_range_ext = RC_DB::table('category')
                		->whereIn('cat_id', $favourable['act_range_ext'])
                		->select(RC_DB::raw('cat_id as id'), RC_DB::raw('cat_name as name'))
                		->get();

				} elseif ($favourable['act_range'] == FAR_BRAND) {
					/* 区分入驻商及平台*/
					$act_range_ext = RC_DB::table('brand')
                		->whereIn('brand_id', $favourable['act_range_ext'])
                		->select(RC_DB::raw('brand_id as id'), RC_DB::raw('brand_name as name'))
                		->get();
				} else {
					$act_range_ext = RC_DB::table('goods')
                		->whereIn('goods_id', $favourable['act_range_ext'])
                		->select(RC_DB::raw('goods_id as id'), RC_DB::raw('goods_name as name'), RC_DB::raw('shop_price'))
                		->get();
				}
			}
			if(!empty($act_range_ext) && is_array($act_range_ext)){
				foreach($act_range_ext as $key => $val){
					if(!empty($val['shop_price'])){
						$act_range_ext[$key]['shop_price'] = price_format($val['shop_price']);
					}
				}
			}
			$favourable['act_range_ext'] = $act_range_ext;
		}
		return $favourable;
	}

	/* 优惠活动管理*/
	public function favourable_manage($parameter) {
		$db_favourable = RC_DB::table('favourable_activity');
		if (!isset($parameter['act_id'])) {
			$act_id = $db_favourable->insertGetId($parameter);
		} else {
			$db_favourable->where('act_id', $parameter['act_id']);
			if (isset($parameter['store_id'])) {
				$db_favourable->where('store_id', $parameter['store_id']);
			}
			$db_favourable->update($parameter);

			$act_id = $parameter['act_id'];
		}

		return $act_id;
	}

	public function favourable_remove($act_id, $bool = false) {
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			RC_DB::table('favourable_activity')->where('store_id', $_SESSION['store_id']);
		}
		if ($bool) {
			return RC_DB::table('favourable_activity')->whereIn('act_id', $act_id)->delete();
		}
		return RC_DB::table('favourable_activity')->where('act_id', $act_id)->delete();
	}
}

// end
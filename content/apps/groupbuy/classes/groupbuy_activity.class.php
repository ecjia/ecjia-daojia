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
 * 团购活动
 */
class groupbuy_activity {
	
	/**
	 * 取得团购活动信息
	 *
	 * @param int $group_buy_id
	 *        	团购活动id
	 * @param int $current_num
	 *        	本次购买数量（计算当前价时要加上的数量）
	 * @return array status 状态：
	 */
	public static function group_buy_info($group_buy_id, $current_num = 0) {
		/* 取得团购活动信息 */
		$group_buy_id = intval ( $group_buy_id );
		$db = RC_DB::table('goods_activity');
		$group_buy = $db->where('act_id', $group_buy_id)
						->where('start_time', '<', RC_Time::gmtime())
						->where('end_time', '>', RC_Time::gmtime())
						->where('act_type',GAT_GROUP_BUY)
						->select(RC_DB::raw('*,act_id as group_buy_id, act_desc as group_buy_desc, start_time as start_date, end_time as end_date'))
						->first();
	
		/* 如果为空，返回空数组 */
		if (empty ( $group_buy )) {
			return array ();
		}
	
		$ext_info = unserialize ( $group_buy ['ext_info'] );
		$group_buy = array_merge ( $group_buy, $ext_info );
	
		/* 格式化时间 */
		$group_buy ['formated_start_date'] = RC_Time::local_date('Y/m/d H:i:s', $group_buy ['start_time'] );
		$group_buy ['formated_end_date'] = RC_Time::local_date('Y/m/d H:i:s', $group_buy ['end_time'] );
	
		/* 格式化保证金 */
		$group_buy ['formated_deposit'] = price_format ( $group_buy ['deposit'], false );
	
		//团购限购时，剩余可团购数
		if (!empty($group_buy['restrict_amount'])) {
			//获取已团购数量
			$has_buyed = RC_DB::table('order_info as oi')
			->leftJoin('order_goods as og', RC_DB::raw('og.order_id'), '=', RC_DB::raw('oi.order_id'))
			->where(RC_DB::raw('oi.extension_id'), $group_buy_id)
			->where(RC_DB::raw('oi.extension_code'), 'group_buy')
			->where(RC_DB::raw('oi.order_status'), '<>', OS_INVALID)
			->select(RC_DB::raw('SUM(goods_number) as total_buyed'))->first();
	
			if ($group_buy['restrict_amount'] > $has_buyed['total_buyed']) {
				$group_buy['left_num'] = $group_buy['restrict_amount'] - $has_buyed['total_buyed'];
			} else {
				$group_buy['left_num'] = 0;
			}
		} else {
			$group_buy['left_num'] = null;
		}
	
		/* 处理价格阶梯 */
		$price_ladder = $group_buy ['price_ladder'];
		if (! is_array ( $price_ladder ) || empty ( $price_ladder )) {
			$price_ladder = array (
					array ('amount' => 0, 'price' => 0)
			);
		} else {
			foreach ( $price_ladder as $key => $amount_price ) {
				$price_ladder [$key] ['formated_price'] = price_format ( $amount_price ['price'], false );
			}
		}
		$group_buy ['price_ladder'] = $price_ladder;
	
		/* 统计信息 */
		$stat = group_buy_stat ( $group_buy_id, $group_buy ['deposit'] );
		$group_buy = array_merge ( $group_buy, $stat );
	
		/* 计算当前价 */
		$cur_price = $price_ladder [0] ['price']; // 初始化
		$cur_amount = $stat ['valid_goods'] + $current_num; // 当前数量
		foreach ( $price_ladder as $amount_price ) {
			if ($cur_amount >= $amount_price ['amount']) {
				$cur_price = $amount_price ['price'];
			} else {
				break;
			}
		}
		$group_buy ['cur_price'] = $cur_price;
		$group_buy ['formated_cur_price'] = price_format ( $cur_price, false );
	
		/* 最终价 */
		$group_buy ['trans_price'] = $group_buy ['cur_price'];
		$group_buy ['formated_trans_price'] = $group_buy ['formated_cur_price'];
		$group_buy ['trans_amount'] = $group_buy ['valid_goods'];
	
		/* 状态 */
		$group_buy ['status'] = group_buy_status ( $group_buy );
	
		if (RC_Lang::get('goods::goods.gbs.' . $group_buy ['status'])) {
			$group_buy ['status_desc'] = RC_Lang::get('goods::goods.gbs.' . $group_buy ['status']);
		}
	
		$group_buy ['start_time'] = $group_buy ['formated_start_date'];
		$group_buy ['end_time'] = $group_buy ['formated_end_date'];
	
		return $group_buy;
	}
	
}	


// end
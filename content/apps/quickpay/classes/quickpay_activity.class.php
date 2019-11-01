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
 * 买单活动
 */
class quickpay_activity {
	/**
	 * 获取周
	 */
	 public static function get_week_list(){
		$week_list = array(
				'星期一'	=> Ecjia\App\Quickpay\Weekly::Monday,
				'星期二'	=> Ecjia\App\Quickpay\Weekly::Tuesday,
				'星期三'	=> Ecjia\App\Quickpay\Weekly::Wednesday,
				'星期四'  => Ecjia\App\Quickpay\Weekly::Thursday,
				'星期五'  => Ecjia\App\Quickpay\Weekly::Friday,
				'星期六'  => Ecjia\App\Quickpay\Weekly::Saturday,
				'星期日'  => Ecjia\App\Quickpay\Weekly::Sunday,
		);
		return $week_list;
	}
	
	
	/**
	 * 获取当前天是星期几
	 */
	public static function current_week($w){
		if ($w == 1) {
			$current_week = Ecjia\App\Quickpay\Weekly::Monday;
		} elseif ($w == 2) {
			$current_week = Ecjia\App\Quickpay\Weekly::Tuesday;
		} elseif ($w == 3) {
			$current_week = Ecjia\App\Quickpay\Weekly::Wednesday;
		} elseif ($w == 4) {
			$current_week = Ecjia\App\Quickpay\Weekly::Thursday;
		} elseif ($w == 5) {
			$current_week = Ecjia\App\Quickpay\Weekly::Friday;
		} elseif ($w == 6) {
			$current_week = Ecjia\App\Quickpay\Weekly::Saturday;
		} elseif ($w == 0) {
			$current_week = Ecjia\App\Quickpay\Weekly::Sunday;
		}
		
		return $current_week;
	}
	
	/**
	 * 获取活动可使用的星期
	 * 
	 */
	public static function get_weeks_str($limit_time_weekly){
		$week_list = self::get_week_list();
		foreach ($week_list as $k => $v) {
			if (in_array($v, $limit_time_weekly)) {
				$week[] = $k;
			}
		}
		if (!empty($week)) {
			if ($week == array(1,2,4,8,16)) {
				$week = '周一至周五';
			} elseif ($week == array(1,2,4,8,16,32,64)) {
				$week = '周一至周日';
			} else {
				$week = implode(',', $week);
			}
		}
		return $week;
	}
	
	/**
	 * 取得用户当前可用红包
	 * @param   int	 $user_id		用户id
	 * @param   float   $goods_amount   订单商品金额
	 * @return  array   红包数组
	 */
	public static function user_bonus($user_id, $goods_amount = 0, $store_id = 0) {
		$today = RC_Time::gmtime();
		$dbview = RC_DB::table('user_bonus as ub')
		->leftJoin('bonus_type as bt', RC_DB::raw('bt.type_id'), '=', RC_DB::raw('ub.bonus_type_id'));
		$dbview->where(RC_DB::raw('bt.use_start_date'), '<=', $today)
		->where(RC_DB::raw('bt.use_end_date'), '>=', $today)
		->where(RC_DB::raw('bt.min_goods_amount'), '<=', $goods_amount)
		->where(RC_DB::raw('bt.store_id'), $store_id)
		->where(RC_DB::raw('ub.user_id'), $user_id)
		->where(RC_DB::raw('ub.order_id'), 0);
		$row = $dbview->select(RC_DB::raw('bt.type_id, bt.type_name, bt.type_money, ub.bonus_id, bt.usebonus_type'))->get();
		return $row;
	}
	
	/**
	 * 获取活动指定可用红包
	 *
	 */
	public static function get_acyivity_bonus($options){
		$user_id = !empty($options['user_id']) ? $options['user_id'] : 0;
		$bonus_type_ids = !empty($options['bonus_type_ids']) ? $options['bonus_type_ids'] : array();
		$store_id = !empty($options['store_id']) ? $options['store_id'] : 0;
		$row = array();
		if (!empty($user_id) && !empty($bonus_type_ids)) {
			$today = RC_Time::gmtime();
			$dbview = RC_DB::table('user_bonus as ub')
			->leftJoin('bonus_type as bt', RC_DB::raw('bt.type_id'), '=', RC_DB::raw('ub.bonus_type_id'));
	
			$dbview->where(RC_DB::raw('bt.use_start_date'), '<=', $today)
			->where(RC_DB::raw('bt.use_end_date'), '>=', $today)
			->whereIn(RC_DB::raw('bt.type_id'), $bonus_type_ids)
			->where(RC_DB::raw('bt.store_id'), $store_id)
			->where(RC_DB::raw('ub.user_id'), $user_id)
			->where(RC_DB::raw('ub.order_id'), 0);
	
			$row = $dbview->select(RC_DB::raw('bt.type_id, bt.type_name, bt.type_money, ub.bonus_id, bt.usebonus_type'))->get();
		}
		return $row;
	}
	
	/**
	 * 计算指定的积分可折算成多少钱
	 *
	 * @access  public
	 * @param   integer $value  积分数
	 * @return  void
	 */
	public static function integral_of_value($value) {
		$scale = floatval(ecjia::config('integral_scale'));
		
		return $scale > 0 ? floatval($value*$scale/100) : 0;
	}
	
	/**
	 * 计算积分的价值（能抵多少钱）
	 * @param   int	 $integral   积分
	 * @return  float   积分价值
	 */
	public static function value_of_integral($value) {
		$scale = floatval(ecjia::config('integral_scale'));
		return $scale > 0 ? round($value / $scale * 100) : 0;
	}
	
	/**
	 * 买单活动折扣
	 */
	public static function get_quickpay_discount($options){
		$discount = 0.00;
		if (!empty($options['activity_type']) && !empty($options['goods_amount']) && !empty($options['activity_value'])) {
			if ($options['activity_type'] == 'normal') {
				//无优惠
				$discount = 0.00;
			} elseif ($options['activity_type'] == 'discount') {
				//打折
				$discount_price = ($options['goods_amount'] - $options['exclude_amount'])*$options['activity_value']/100;
				$discount = ($options['goods_amount'] - $options['exclude_amount']) - $discount_price;
			} elseif ($options['activity_type'] == 'reduced') {
				//满多少减多少
				$activity_value = explode(',', $options['activity_value']);
				$min_amount = $activity_value['0'];
				$reduce_amount = $activity_value['1'];
				if (($options['goods_amount'] - $options['exclude_amount']) >= $min_amount) {
					$discount = $reduce_amount;
				} else {
					$discount = 0.00;
				}
			} elseif ($options['activity_type'] == 'everyreduced') {
				//每满多少减多少
				$activity_value = explode(',', $options['activity_value']);
				$every_min_amount = $activity_value['0'];
				$every_reduce_amount = $activity_value['1'];
				
				$max_amount = $activity_value['2'];
				if (($options['goods_amount'] - $options['exclude_amount']) >= $every_reduce_amount) {
					//可减次数
					$reduce_times = ($options['goods_amount'] - $options['exclude_amount'])/$every_min_amount;
					$reduce_times = intval($reduce_times);
					$reduce_amount = $reduce_times*$every_reduce_amount;
					
					if ($reduce_amount > $max_amount) {
						$reduce_amount = $max_amount;
					}
					$discount = $reduce_amount;
				}
			}
		}
		return $discount;
	}
	
	/**
	 * 当前时间是否在活动限制时间段内
	 */
	public static function is_in_timelimit($options) {
		$curr_time = RC_Time::gmtime();
		$time = RC_Time::local_date('H:i', $curr_time);
		
		$timeBegin1 = RC_Time::local_strtotime($options['start']);
		$timeEnd1 = RC_Time::local_strtotime($options['end']);
		
		$time = RC_Time::local_strtotime($time);
		
		if ($time >= $timeBegin1 && $time <= $timeEnd1)
		{
			return 0;
		}
		
		return -1;
	}
	
	
	/**
	 * 记录买单订单操作记录
	 *
	 */
	public static function quickpay_order_action($options) {
		$order_id 			= empty($options['order_id']) ? 0 : $options['order_id'];
		$action_user_id 	= $options['action_user_id'];
		$username 			= $options['action_user_name'];
		$action_user_type 	= $options['action_user_type'];
		$order_status 		= $options['order_status'];
		$pay_status 		= $options['pay_status'];
		$action_note		= $options['action_note'];
		
		if (empty($username)) {
			$username = empty($_SESSION['admin_name']) ? $_SESSION['staff_name'] : $_SESSION['admin_name'];
			$username = empty($username) ? '' : $username;
		}
		
		$data = array(
				'order_id' 			=> $order_id,
				'action_user_id' 	=> $action_user_id,
				'action_user_name' 	=> $username,
				'action_user_type' 	=> $action_user_type,
				'order_status' 		=> $order_status,
				'pay_status'		=> $pay_status,
				'action_note' 		=> $action_note,
				'add_time' 			=> RC_Time::gmtime()
		);
		RC_DB::table('quickpay_order_action')->insert($data);
	}
	
	/**
	 * 获取订单状态
	 */
	public static function get_label_order_status($order_status, $pay_status, $verification_status){
		$order_status_str = '';
		$label_order_status = '';
		
		if (($order_status == \Ecjia\App\Quickpay\Enums\QuickpayOrderEnum::UNCONFIRMED) && ($pay_status == \Ecjia\App\Quickpay\Enums\QuickpayPayEnum::UNPAID) && ($verification_status == \Ecjia\App\Quickpay\Enums\QuickpayVerifyEnum::UNVERIFICATION)) {
			$order_status_str = 'unpaid';
			$label_order_status = '待付款';
		} elseif (($order_status == \Ecjia\App\Quickpay\Enums\QuickpayOrderEnum::CONFIRMED) && ($pay_status == \Ecjia\App\Quickpay\Enums\QuickpayPayEnum::PAID)) {
			$order_status_str = 'paid';
			$label_order_status = '已付款';
		} elseif (($order_status == \Ecjia\App\Quickpay\Enums\QuickpayOrderEnum::CONFIRMED) && ($pay_status == \Ecjia\App\Quickpay\Enums\QuickpayPayEnum::PAID) && ($verification_status == \Ecjia\App\Quickpay\Enums\QuickpayVerifyEnum::VERIFICATION)) {
			$order_status_str = 'succeed';
			$label_order_status = '买单成功';
		} elseif (($order_status == \Ecjia\App\Quickpay\Enums\QuickpayOrderEnum::CANCELED) && ($pay_status == \Ecjia\App\Quickpay\Enums\QuickpayPayEnum::UNPAID) && ($verification_status == \Ecjia\App\Quickpay\Enums\QuickpayVerifyEnum::UNVERIFICATION)){
			$order_status_str = 'canceled';
			$label_order_status = '已取消';
		}
		return array('order_status_str' => $order_status_str, 'label_order_status' => $label_order_status);
	}
	
	/**
	 * 获取活动优惠信息，列表
	 */
	public static function max_discount_activitys ($options) {
		$quickpay_activity_list  = RC_Api::api('quickpay', 'quickpay_activity_list', $options);
		$list = $quickpay_activity_list['list'];
		
		$user_id = $options['user_id'];
		
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$list[$key]['total_act_discount'] = self::get_quickpay_discount(array('activity_type' => $val['activity_type'],'goods_amount' => $options['goods_amount'], 'exclude_amount' => $options['exclude_amount'], 'activity_value' => $val['activity_value']));
				$list[$key]['is_allow_use'] = 1;
				/*活动是否允许使用积分处理*/
				if ($val['use_integral'] == 'nolimit') {
					//无积分限制；最多可用积分按商品价格兑换
					$scale = floatval(ecjia::config('integral_scale'));
					$integral = (($options['goods_amount'] - $options['exclude_amount'])/$scale)*100;
					$order_max_integral = intval($integral);
					$integral_money = self::integral_of_value($integral);
					$allow_use_integral = 1;
				} elseif (($val['use_integral'] != 'nolimit') && ($val['use_integral'] != 'close')) {
					//有积分限制
					$allow_use_integral = 1;
					$order_max_integral = intval($val['use_integral']);
					$integral_money = self::integral_of_value($integral);
				} else {
					//不可用积分
					$allow_use_integral = 0;
					$integral_money = 0.00;
					$order_max_integral = 0;
				}
				$list[$key]['act_integral_money'] = $integral_money;
				$list[$key]['allow_use_integral'] = $allow_use_integral;
				$list[$key]['order_max_integral'] = $order_max_integral;
				/*活动是否允许使用红包*/
				$bonus_list = array();
				$allow_use_bonus =0;
				
				if (ecjia::config('use_bonus') == '1') {
					if ($val['use_bonus'] == 'nolimit') {
						//无限制红包；获取用户可用红包
						// 取得用户可用红包
						$real_amount = $options['goods_amount'] - $options['exclude_amount'];
						if (!empty($user_id)) {
							$user_bonus = self::user_bonus($user_id, $real_amount, $options['store_id']);
							if (!empty($user_bonus)) {
								foreach ($user_bonus AS $arr1 => $res1) {
									$user_bonus[$arr1]['bonus_money_formated'] = price_format($res1['type_money'], false);
								}
								$bonus_list = $user_bonus;
							}
						}
						$allow_use_bonus = 1;
						// 能使用红包
					} elseif (($val['use_bonus'] != 'nolimit') && $val['use_bonus'] != 'close') {
						//活动指定红包类型
						$bonus_type_ids = explode(',', $val['use_bonus']);
						$bonus_list = self::get_acyivity_bonus(array('user_id' => $options['user_id'], 'bonus_type_ids' => $bonus_type_ids, 'store_id' => $options['store_id']));
				
						if (!empty($bonus_list)) {
							foreach ($bonus_list AS $arr2 => $res2) {
								$bonus_list[$arr2]['bonus_money_formated'] = price_format($res2['type_money'], false);
							}
						}
						$allow_use_bonus = 1;
					} else{
						$allow_use_bonus = 0;
						$bonus_list = array();
					}
				}
				$list[$key]['allow_use_bonus'] = $allow_use_bonus;
				$list[$key]['act_bonus_list'] = $bonus_list;
			}
		}
		return $list;
	}
	
	/**
	 * 获取某个店铺是否有开启优惠活动
	 */
	public static function is_open_quickpay ($store_id) {
		$allow_use_quickpay = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'quickpay_enabled')->value('value');
		return $allow_use_quickpay;
	}
	
	/**
	 * 活动有无优惠判断，给标识字段is_allow_use
	 */
	public static function mark_activitys($activitys = [])
	{
		if (!empty($activitys)) {
			foreach ($activitys as $k1 => $v1) {
				/*无优惠过滤*/
				if ($v1['activity_type'] == 'normal') {
					$activitys[$k1]['is_allow_use'] = 0;
				}
				if ($v1['total_act_discount'] == '0') {
					$activitys[$k1]['is_allow_use'] = 0;
				}
					
				/*自定义时间的活动，当前时间段不可用的过滤掉*/
				if ($v1['limit_time_type'] == 'customize') {
					/*每周限制时间*/
					if (!empty($v1['limit_time_weekly'])){
						$w = date('w');
						$current_week = self::current_week($w);
						$limit_time_weekly = Ecjia\App\Quickpay\Weekly::weeks($v1['limit_time_weekly']);
						$weeks_str = self::get_weeks_str($limit_time_weekly);
						if (!in_array($current_week, $limit_time_weekly)){
							$activitys[$k1]['is_allow_use'] = 0;
						}
					}
					/*每天限制时间段*/
					if (!empty($v1['limit_time_daily'])) {
						$limit_time_daily = unserialize($v1['limit_time_daily']);
						foreach ($limit_time_daily as $val1) {
							$arr[] = self::is_in_timelimit(array('start' => $val1['start'], 'end' => $val1['end']));
						}
						if (!in_array(0, $arr)) {
							$activitys[$k1]['is_allow_use'] = 0;
						}
					}
					/*活动限制日期*/
					if (!empty($v1['limit_time_exclude'])) {
						$limit_time_exclude = explode(',', $v1['limit_time_exclude']);
						$current_date = RC_Time::local_date(ecjia::config('date_format'), RC_Time::gmtime());
						$current_date = array($current_date);
						if (in_array($current_date, $limit_time_exclude) || $current_date == $limit_time_exclude) {
							$activitys[$k1]['is_allow_use'] = 0;
						}
					}
				}
					
			}
		}
		
		return $activitys;
	}
	
	
	/**
	 * 获取一组活动中最优惠的活动id
	 */
	public static function get_favorable_activity_id($activitys)
	{
		$favorable_activity_id = 0;
		if (!empty($activitys)) {
			$final = array();
			foreach ($activitys as $k2 => $v2) {
				$final[$v2['id']] = array(
						'id'	=> $v2['id'],
						'final_discount' => $v2['total_act_discount'],
				);
			}
				
			$final_discounts = array();
			foreach ($final as $kk => $vv) {
				$final_discounts[$vv['id']] = $vv['final_discount'];
			}
				
			if (!empty($final_discounts)) {
				/*获取最优惠的活动id*/
				if (count($final_discounts) > 1) {
					$favorable_activity_id = array_keys($final_discounts, max($final_discounts));
					$favorable_activity_id = $favorable_activity_id['0'];
				} else {
					foreach ($final_discounts as $a2 => $b2) {
						$favorable_activity_id = $a2;
					}
				}
			}
		}
		
		return $favorable_activity_id;
	}
	
	
	/**
	 * 标识活动是否是最优惠的
	 */
	public static function mark_is_favorable($activitys = [], $favorable_activity_id)
	{
		if (!empty($activitys) && !empty($favorable_activity_id)) {
			foreach ($activitys as $k3 => $v3) {
				if ($favorable_activity_id == $v3['id']) {
					$activitys[$k3]['is_favorable'] = 1;
					if ($v3['total_act_discount'] == '0') {
						$activitys[$k3]['is_favorable'] = 0;
					}
				} else{
					$activitys[$k3]['is_favorable'] = 0;
				}
			}
		}
		
		return $activitys;
	}
	
	/**
	 * 判断自定义活动当前时间段是否可用
	 */
	public static function customize_activity_is_available($quickpay_activity_info)
	{
		/*每周限制时间*/
		if (!empty($quickpay_activity_info['limit_time_weekly'])){
			$w = date('w');
			$current_week = quickpay_activity::current_week($w);
			$limit_time_weekly = Ecjia\App\Quickpay\Weekly::weeks($quickpay_activity_info['limit_time_weekly']);
			$weeks_str = self::get_weeks_str($limit_time_weekly);
		
			if (!in_array($current_week, $limit_time_weekly)){
				return false;
			}
		}
		
		/*每天限制时间段*/
		if (!empty($quickpay_activity_info['limit_time_daily'])) {
			$limit_time_daily = unserialize($quickpay_activity_info['limit_time_daily']);
			foreach ($limit_time_daily as $val) {
				$arr[] = self::is_in_timelimit(array('start' => $val['start'], 'end' => $val['end']));
			}
			if (!in_array(0, $arr)) {
				return false;
			}
		}
		
		/*活动限制日期*/
		if (!empty($quickpay_activity_info['limit_time_exclude'])) {
			$time = RC_Time::gmtime();
			$limit_time_exclude = explode(',', $quickpay_activity_info['limit_time_exclude']);
			$current_date = RC_Time::local_date('Y-m-d', $time);
			if (in_array($current_date, $limit_time_exclude) || $current_date == $quickpay_activity_info['limit_time_exclude']) {
				return false;
			}
		}
		
		return true;
	}
	
}	


// end
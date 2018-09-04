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
 * 收银台收款买单活动
 */
class cashdesk_quickpay_activity {
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
	 * 得到新订单号
	 * @return  string
	 */
	public static function get_order_sn() {
		/* 选择一个随机的方案 */
		mt_srand((double) microtime() * 1000000);
		return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
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
		
		if (($order_status == Ecjia\App\Quickpay\Status::UNCONFIRMED) && ($pay_status == Ecjia\App\Quickpay\Status::UNPAID) && ($verification_status == Ecjia\App\Quickpay\Status::UNVERIFICATION)) {
			$order_status_str = 'unpaid';
			$label_order_status = '待付款';
		} elseif (($order_status == Ecjia\App\Quickpay\Status::CONFIRMED) && ($pay_status == Ecjia\App\Quickpay\Status::PAID)) {
			$order_status_str = 'paid';
			$label_order_status = '已付款';
		} elseif (($order_status == Ecjia\App\Quickpay\Status::CONFIRMED) && ($pay_status == Ecjia\App\Quickpay\Status::PAID) && ($verification_status == Ecjia\App\Quickpay\Status::VERIFICATION)) {
			$order_status_str = 'succeed';
			$label_order_status = '买单成功';
		} elseif (($order_status == Ecjia\App\Quickpay\Status::CANCELED) && ($pay_status == Ecjia\App\Quickpay\Status::UNPAID) && ($verification_status == Ecjia\App\Quickpay\Status::UNVERIFICATION)){
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
		
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$list[$key]['total_act_discount'] = self::get_quickpay_discount(array('activity_type' => $val['activity_type'],'goods_amount' => $options['goods_amount'], 'exclude_amount' => $options['exclude_amount'], 'activity_value' => $val['activity_value']));
				$list[$key]['is_allow_use'] = 1;
			}
		}
		return $list;
	}
	
	/**
	 * 获取某个店铺是否有开启优惠活动
	 */
	public static function is_open_quickpay ($store_id) {
		$allow_use_quickpay = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'quickpay_enabled')->pluck('value');
		return $allow_use_quickpay;
	}
}	


// end
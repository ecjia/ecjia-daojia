<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-05
 * Time: 17:03
 */

namespace Ecjia\App\Quickpay;

use Ecjia\App\Quickpay\Models\QuickpayIntegralActivityModel;
use Ecjia\App\Quickpay\Models\QuickpayActivityStorePercentModel;
use RC_DB;
use ecjia_error;
use ecjia;
use RC_Time;
use RC_Api;


class QuickpayIntegralActivity
{
	/**
	 * 商家参与的平台正在进行的买单送积分活动（每个商家只可参与一个）
	 * @param int $store_id
	 * @return array
	 */
	public static function storeParticipateQuickpayIntegralActivity($store_id)
	{
		$now = RC_Time::gmtime();
		$activity_info = [];
		//商家参与的平台正在进行的买单送积分活动
		$query = QuickpayIntegralActivityModel::with(['quickpay_activity_store_percent_collection']);
		if (!empty($store_id)) {
			$query = $query->whereHas('quickpay_activity_store_percent_collection', function($query) use ($store_id){
				$query->where('store_id', $store_id);
			});
		}
		
		$quickpay_integral_activity = $query->where('start_time', '<', $now)->where('end_time', '>', $now)->first();
		
		if ($quickpay_integral_activity) {
			$activity_info = $quickpay_integral_activity->toArray();
		}
		return $activity_info;
	}
	
	/**
	 * 店铺正在参与的买单送积分活动（格式化的）
	 * @param int $store_id
	 * @return array
	 */
	public static function formatStoreParticipateQuickpayIntegralActivity($store_id)
	{
		$info = [];
		$activity_info = self::storeParticipateQuickpayIntegralActivity($store_id);
		if ($activity_info) {
			$info = [
				'activity_id' 		=> intval($activity_info['id']),
				'title'		  		=> trim($activity_info['title']),
				'activity_amount'	=> $activity_info['activity_amount'],
				'give_integral'		=> intval($activity_info['give_integral'])
			];
		}
		return $info;
	}
	
	/**
	 * 买单订单结算页是否可赠送积分
	 * @param int $store_id
	 * @param float $goods_amount
	 * @param int $user_id
	 * @return string
	 */
	public static function isGiveIntegral($store_id, $goods_amount, $user_id)
	{
		$is_give_integral = 'no';
		$activity_info = self::storeParticipateQuickpayIntegralActivity($store_id);
		//消费金额满足赠送积分条件
		if ($activity_info && $goods_amount >= $activity_info['activity_amount']) {
			//用户等级是否满足赠送积分条件
			$activity_user_rank = unserialize($activity_info['user_rank_ids']);
			if (!empty($activity_user_rank)) {
				//用户当前等级id
				$user_info = RC_DB::table('users')->where('user_id', $user_id)->first();
				if ($user_info['user_rank'] == 0) {
					//重新计算会员等级
					$now_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user_id));
				} else {
					//用户等级更新，不用计算，直接读取
					$now_rank = RC_DB::table('user_rank')->where('rank_id', $user_info['user_rank'])->first();
				}
				$rank_id = $now_rank['rank_id'];
				if (in_array($rank_id, $activity_user_rank)) {
					$is_give_integral = 'yes';
				}
			}
		}
		return $is_give_integral;
	}

    /**
     * 获取结算比例
     * @param $order_info
     */
	public static function getCommissionPercentByOrder($order_info) {

	    $percent = ecjia::config('quickpay_fee');
	    if($order_info['give_integral']) {
            $store_id = $order_info['store_id'];
            $query = QuickpayIntegralActivityModel::with(['quickpay_activity_store_percent_collection']);
            $query = $query->whereHas('quickpay_activity_store_percent_collection', function($query) use ($store_id){
                $query->where('store_id', $store_id);
            });

            $quickpay_integral_activity = $query->where('start_time', '<', $order_info['add_time'])->where('end_time', '>', $order_info['add_time'])->first();

            if ($quickpay_integral_activity) {
                $activity_info = $quickpay_integral_activity->toArray();
                $percent_value = $activity_info['quickpay_activity_store_percent_collection'][0]['percent_value'];
                //优惠减免
                if($percent_value) {
                    $percent = $percent * floatval(100 - $percent_value) / 100;
                }
            }
        }

	    return $percent;
    }
}
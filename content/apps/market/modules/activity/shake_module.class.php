<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 摇一摇
 * @author  zrl
 *
 */
class shake_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		
		$this->authSession();
		if ($_SESSION['user_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$location = $this->requestData('location', array());
		$city_id	 = $this->requestData('city_id', 0);
		
		/*经纬度为空判断*/
		$options = array();
		if ((!is_array($location) || empty($location['longitude']) || empty($location['latitude']))) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		/*
		 * 奖项数组
		* 是一个二维数组，记录了所有本次抽奖的奖项信息，
		* 其中id表示中奖等级，prize表示奖品，v表示中奖概率。
		* 注意其中的v必须为整数，你可以将对应的 奖项的v设置成0，即意味着该奖项抽中的几率是0，
		* 数组中v的总和（基数），基数越大越能体现概率的准确性。
		* 本例中v的总和为100，那么平板电脑对应的 中奖概率就是1%，
		* 如果v的总和是10000，那中奖概率就是万分之一了。
		*/
		$time = RC_Time::gmtime();
		$market_activity = RC_DB::table('market_activity')
							->where('activity_group', 1)
							->where('activity_object', 1)
							->where('start_time', '<=', $time)
							->where('end_time', '>=', $time)
							->where('enabled', 1)
							->first();
		
		/* 判断活动有无限定次数*/
		if ($market_activity['limit_num'] > 0) {
			$db_activity_log = RC_DB::table('market_activity_log');
			$db_activity_log->where('activity_id', $market_activity['activity_id'])->where('user_id', $_SESSION['user_id']);
			
			if ($market_activity['limit_time'] > 0) {
				$time_limit = $time - $market_activity['limit_time']*60;
				$db_activity_log->where('add_time', '<=', $time)->where('add_time', '>=', $time_limit);
			}
			$limit_count = $db_activity_log->count('id');
			
			if ($market_activity['limit_num'] <= $limit_count) {
				return new ecjia_error('activity_limit', '活动次数太频繁，请稍微再来！');
			}
		}
		
		$market_activity_prize = RC_DB::table('market_activity_prize')
									->where('activity_id', $market_activity['activity_id'])
									->where('prize_number', '>', 0)
									->selectRaw('prize_id, activity_id, prize_level, prize_name, prize_type, prize_value, prize_number, prize_prob')->get();
		
		/*
		 * 每次前端页面的请求，PHP循环奖项设置数组，
		* 通过概率计算函数get_rand获取抽中的奖项id。
		* 最后输出json个数数据给前端页面。
		*/
		
		if (!empty($market_activity_prize)) {
			$prize_arr = array();
			$market_activity_prize_new = array();
			foreach ($market_activity_prize as $k => $v) {
				$prize_arr[$v['prize_id']] = $v['prize_prob'];
				$market_activity_prize_new[$v['prize_id']] = $v;
			}
		}
		
		$rid = get_rand($prize_arr);
		
		/* 获取中奖*/
		$prize_info = $market_activity_prize_new[$rid];
		if ($prize_info['prize_type'] == '1') {
			$bonus_info = RC_DB::table('bonus_type')->where('type_id', $prize_info['prize_value'])->first();
			if ($bonus_info['send_start_date'] <= $time && $bonus_info['send_end_date'] >= $time) {
				/*减奖品数量*/
				RC_DB::table('market_activity_prize')->where('prize_id', $prize_info['prize_id'])->decrement('prize_number');
				/*发放奖品至用户，发放红包*/
				$data = array(
						'bonus_type_id' => $prize_info['prize_value'],
						'user_id'		=> $_SESSION['user_id']
				);
				RC_DB::table('user_bonus')->insert($data);
				
				$result = array(
						'type' => 'bonus',
						'bonus' => array(
								'bonus_id'					=> intval($bonus_info['type_id']),
								'bonus_name'				=> $bonus_info['type_name'],
								'bonus_amount'				=> $bonus_info['type_money'],
								'formatted_bonus_amount' 	=> price_format($bonus_info['type_money']),
								'request_amount' 			=> $bonus_info['min_goods_amount'],
								'formatted_request_amount'	=> price_format($bonus_info['min_goods_amount']),
								'start_date'				=> $bonus_info['use_start_date'],
								'end_date'					=> $bonus_info['use_end_date'],
								'formatted_start_date'		=> RC_Time::local_date(ecjia::config('date_format'), $bonus_info['use_start_date']),
								'formatted_end_date'		=> RC_Time::local_date(ecjia::config('date_format'), $bonus_info['use_end_date']),
						)
				);
			} else {
				$result = array(
						'type' => 'nothing',
						'nothing' => array(
								'message' => '很遗憾，您未摇中奖品！',
						)
				);
			}
		} elseif ($prize_info['prize_type'] == '3') {
			/*减奖品数量*/
			RC_DB::table('market_activity_prize')->where('prize_id', $prize_info['prize_id'])->decrement('prize_number');
			/*发放奖品至用户，赠送积分给用户*/
			$options = array(
					'user_id'		=> $_SESSION['user_id'],
					'pay_points'	=> intval($prize_info['prize_value']),
					'change_desc'	=> '摇一摇活动抽奖赠送'
			);
			RC_Api::api('user', 'account_change_log',$options);
			
			$result = array(
					'type' => 'integral',
					'integral' => array(
							'integral' => intval($prize_info['prize_value']),
					)
			);
		} elseif ($prize_info['prize_type'] == '4') {
			$where = array(
					'is_on_sale'	=> 1,
					'is_alone_sale' => 1,
					'is_delete'		=> 0,
					'review_status'	=> 3,
			);
			$goods_info = RC_Model::model('goods/goods_model')->where($where)->order('Rand()')->find();
			RC_Loader::load_app_func('admin_goods', 'goods');
			if ($goods_info['promote_price'] > 0) {
				$promote_price = bargain_price($goods_info['promote_price'], $goods_info['promote_start_date'], $goods_info['promote_end_date']);
			} else {
				$promote_price = 0;
			}
			$activity_type = ($goods_info['shop_price'] > $promote_price && $promote_price > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
			
			$result = array(
					'type' => 'goods',
					'goods' => array(
						'goods_id'  => intval($goods_info['goods_id']),
						'name'		=> $goods_info['goods_name'],
						'market_price'	=> price_format($goods_info['market_price']),
						'shop_price'	=> price_format($goods_info['shop_price']),
						'promote_price' => $promote_price > 0 ? price_format($promote_price) : '',
						'img' => array(
							'thumb' =>  !empty($goods_info['goods_img']) ?  RC_Upload::upload_url($goods_info['goods_img']) :  RC_Uri::admin_url('statics/images/nopic.png'),
							'url'	=>  !empty($goods_info['original_img']) ?  RC_Upload::upload_url($goods_info['original_img']) :  RC_Uri::admin_url('statics/images/nopic.png'),
							'small' =>  !empty($goods_info['goods_thumb']) ?  RC_Upload::upload_url($goods_info['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png'),
						)
					)
			);
		} elseif ($prize_info['prize_type'] == '5') {
			/*经纬度判断*/
			$options = array();
			if ((is_array($location) || !empty($location['longitude']) || !empty($location['latitude']))) {
				$geohash      = RC_Loader::load_app_class('geohash', 'store');
				$geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
				$options['store_id']   = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code, 'city_id' => $city_id));
			}
			
			if (!empty($options['store_id'])) {
				RC_Loader::load_app_func('merchant', 'merchant');
					
				$store_info_new = array();
				$store_info = RC_Model::model('merchant/store_franchisee_model')
				->in(array('store_id' => $options['store_id']))
				->where(array('status' => 1, 'identity_status' => 2, 'shop_close' => 0))
				->order('Rand()')->find();
				
				if (!empty($store_info)) {
					$shop_logo = RC_DB::table('merchants_config')->where('store_id', $store_info['store_id'])->where('code', 'shop_logo')->pluck('value');
					$shop_notice = RC_DB::table('merchants_config')->where('store_id', $store_info['store_id'])->where('code', 'shop_notice')->pluck('value');
					$shop_logo = empty($shop_logo) ?  '' : RC_Upload::upload_url($shop_logo);
					$trade_time = get_store_trade_time($store_info['store_id']);
					
					$store_info_new = array(
							'store_id' 			=> $store_info['store_id'],
							'merchants_name' 	=> $store_info['merchants_name'],
							'shop_keyword'		=> $store_info['shop_keyword'],
							'location'			=> array(
									'longitude' => $store_info['longitude'],
									'latitude'	=> $store_info['latitude']
							),
							'shop_logo'			=> $shop_logo,
							'label_trade_time'	=> $trade_time,
							'shop_notice'		=> $shop_notice
					);
			
				}
			}
			
			$result = array(
					'type' => 'store',
					'store' => $store_info_new
			);
		} else {
			$result = array(
				'type' => 'nothing',
				'nothing' => array(
					'message' => '很遗憾，您未摇中奖品！',
				)
			);
		}
		if (!empty($prize_info)) {
			$log = array(
					'activity_id'	=> $prize_info['activity_id'],
					'user_id'		=> $_SESSION['user_id'],
					'username'		=> $_SESSION['user_name'],
					'prize_id'		=> $prize_info['prize_id'],
					'prize_name'	=> $prize_info['prize_name'],
					'issue_status'	=> 1,
					'issue_time'	=> $time,
					'add_time'		=> $time,
					'source'		=> 'app'
			);
			RC_DB::table('market_activity_log')->insert($log);
		}

		return $result;
	}
}

/*
 * 经典的概率算法，
* $proArr是一个预先设置的数组，
* 假设数组为：array(100,200,300，400)，
* 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，
* 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间，
* 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。
* 这样 筛选到最终，总会有一个数满足要求。
* 就相当于去一个箱子里摸东西，
* 第一个不是，第二个不是，第三个还不是，那最后一个一定是。
* 这个算法简单，而且效率非常 高，
* 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。
*/
function get_rand($proArr) {
	$result = '';
	//概率数组的总概率精度
	$proSum = array_sum($proArr);
	//概率数组循环
	foreach ($proArr as $key => $proCur) {
		$randNum = mt_rand(1, $proSum);
		if ($randNum <= $proCur) {
			$result = $key;
			break;
		} else {
			$proSum -= $proCur;
		}
	}
	unset ($proArr);
	return $result;
}



// end
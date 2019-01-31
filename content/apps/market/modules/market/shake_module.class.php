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
 * 摇一摇
 * @author  zrl
 *
 */
class market_shake_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		
		$this->authSession();
		if ($_SESSION['user_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$user_id = $_SESSION['user_id'];
		$api_version = $this->request->header('api-version');
		//判断用户有没申请注销
		if (version_compare($api_version, '1.25', '>=')) {
			$account_status = Ecjia\App\User\Users::UserAccountStatus($user_id);
			if ($account_status == Ecjia\App\User\Users::WAITDELETE) {
				return new ecjia_error('account_status_error', '当前账号已申请注销，不可执行此操作！');
			}
		}
		
		$location = $this->requestData('location', array());
		$city_id	 = $this->requestData('city_id', '');
		
		/*经纬度为空判断*/
		$options = array();
		if ((!is_array($location) || empty($location['longitude']) || empty($location['latitude']))) {
			return new ecjia_error('invalid_parameter', __('参数无效'));
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
							->where('activity_group', 'mobile_shake')
							->where('activity_object', 'app')
							->where('store_id', 0)
							->where('wechat_id', 0)
							->where('start_time', '<=', $time)
							->where('end_time', '>=', $time)
							->where('enabled', 1)
							->first();
	
		if (empty($market_activity)) {
			return new ecjia_error('activity_error', '活动未开始或已结束！');
		}
	
		//获取用户剩余抽奖次数
		
		$prize_num = $this->_getLotteryOverCount($_SESSION['user_id'], $market_activity);
		
		if ($prize_num == 0) {
			//规定时间抽奖次数超过设定的次数;
			return new ecjia_error('activity_limit', '活动次数太频繁，请稍后再来！');
		}
		
		//填写参与记录
		$this->_incrementLotteryCount($_SESSION['user_id'], $market_activity);
		
		$market_activity_prize = RC_DB::table('market_activity_prize')
									->where('activity_id', $market_activity['activity_id'])
									->where('prize_number', '>', 0)
									->select(RC_DB::raw('prize_id, activity_id, prize_level, prize_name, prize_type, prize_value, prize_number, prize_prob'))->get();
		
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
		
		$rid = $this->get_rand($prize_arr);
		
		/*中奖处理，及返回值*/
		$prize_info = $market_activity_prize_new[$rid];
		if ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BONUS) {
			$result = $this->_ProcessTypeBonus($prize_info, $_SESSION['user_id']);
		} elseif ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_INTEGRAL) {
			$result = $this->_ProcessTypeIntegral($prize_info, $_SESSION['user_id']);
		} elseif ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_GOODS) {
			$result = $this->_ProcessTypeGoods($prize_info, $_SESSION['user_id']);
		} elseif ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_STORE) {
			$result = $this->_ProcessTypeStore ($prize_info, $_SESSION['user_id'], $location = array(), $city_id = 0);
		} elseif ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BALANCE) { 
			$result = $this->_ProcessTypeBalance ($prize_info, $_SESSION['user_id']);
		} else {
			$result = array(
				'type' => 'nothing',
				'nothing' => array(
					'message' => '很遗憾，您未摇中奖品！',
				)
			);
		}
		//记录抽奖log
		if (!empty($prize_info)) {
			$this->_insertMarketActivityLog($prize_info, $_SESSION['user_id'], $_SESSION['user_name']);
		}

		return $result;
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
	private function get_rand($proArr) {
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
	
	/**
	 * 获取用户的剩余抽奖次数
	 * @param $openid
	 * @return int
	 */
	private function _getLotteryOverCount($user_id = 0, $market_activity_info = array())
	{
		if ($market_activity_info['limit_num'] > 0) {
			$starttime = $market_activity_info['start_time'];
			$endtime = $market_activity_info['end_time'];
			$time = RC_Time::gmtime();
	
			$time_limit = $time - $market_activity_info['limit_time'] * 60;
	
			if ($time_limit == $time) {
				$time_limit = $starttime;
			}
	
			$market_activity_lottery = RC_DB::table('market_activity_lottery')
			->where('user_id', $user_id)
			->where('user_type', 'user')
			->where('update_time', '<=', $time)
			->where('add_time', '>=', $time_limit)
			->first();
	
			//找到数据，说明在有效时间内
			if (!empty($market_activity_lottery)) {
				//限定时间已抽取的次数
				$has_used_count = $market_activity_lottery['lottery_num'];
			}
			//找不到数据，说明已经过有效时间，可以重置抽奖时间和抽奖次数
			else {
				$this->_resetLotteryOverCount($user_id, $market_activity_info);
	
				$has_used_count = 0;
			}
	
			//剩余可抽取的次数
			$prize_num = $market_activity_info['limit_num'] - $has_used_count;
	
			$prize_num = max(0, $prize_num);
	
		} else {
			$prize_num = -1; //无限次
		}
	
		return intval($prize_num);
	}
	
	/**
	 * 重置用户的剩余抽奖次数
	 * @param $openid
	 */
	private function _resetLotteryOverCount($user_id = 0, $market_activity_info = array())
	{
		
		$time = RC_Time::gmtime();
		$market_activity_lottery_info = RC_DB::table('market_activity_lottery')
											->where('activity_id', $market_activity_info['activity_id'])
											->where('user_type', 'user')
											->where('user_id', $user_id)
											->first();
		
		if (! empty($market_activity_lottery_info)) {
			RC_DB::table('market_activity_lottery')->update(['add_time' => $time, 'update_time' => $time, 'lottery_num' => 0]);
		} else {
			RC_DB::table('market_activity_lottery')->insert(array(
			'activity_id'   => $market_activity_info['activity_id'],
			'user_id'       => $user_id,
			'user_type'     => 'user',
			'lottery_num'   => 0,
			'add_time'      => $time,
			'update_time'   => $time,
			));
		}
	}
	
	/**
	 * 自增用户的抽奖使用次数
	 * @param $openid
	 */
	private function _incrementLotteryCount($user_id = 0, $market_activity_info = array())
	{
		$model = RC_DB::table('market_activity_lottery')->where('activity_id', $market_activity_info['activity_id'])
		->where('user_id', $user_id)
		->where('user_type', 'user')
		->first();
		
		//规定时间未超出设定的次数；更新抽奖次数，更新抽奖时间
		if (! empty($model)) {
			$time = RC_Time::gmtime();
			$limit_count_new = $model->lottery_num + 1;
			RC_DB::table('market_activity_lottery')->update(['update_time' => $time, 'lottery_num' => $limit_count_new]);
		} else {
			$this->_resetLotteryOverCount($user_id, $market_activity_info);
			$this->_incrementLotteryCount($user_id, $market_activity_info);
		}
	}
	
	/**
	 * 红包中奖处理
	 */
	private function _ProcessTypeBonus($prize_info = array(), $user_id = 0) 
	{
		$time = RC_Time::gmtime();
		$bonus_info = RC_DB::table('bonus_type')->where('type_id', $prize_info['prize_value'])->first();
		if ($bonus_info['send_start_date'] <= $time && $bonus_info['send_end_date'] >= $time) {
			/*减奖品数量*/
			RC_DB::table('market_activity_prize')->where('prize_id', $prize_info['prize_id'])->decrement('prize_number');
			/*发放奖品至用户，发放红包*/
			$data = array(
					'bonus_type_id' => $prize_info['prize_value'],
					'user_id'		=> $user_id
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
		
		return $result;
	}
	
	/**
	 * 积分中奖处理
	 */
	private function _ProcessTypeIntegral ($prize_info = array(), $user_id = 0) 
	{
		/*减奖品数量*/
		RC_DB::table('market_activity_prize')->where('prize_id', $prize_info['prize_id'])->decrement('prize_number');
		/*发放奖品至用户，赠送积分给用户*/
		$options = array(
				'user_id'		=> $user_id,
				'point'			=> intval($prize_info['prize_value']),
				'change_desc'	=> '摇一摇活动抽奖赠送'
		);
			
		$pay_points_change = RC_Api::api('finance', 'pay_points_change',$options);
		if (is_ecjia_error($pay_points_change)) {
			
		}
		$result = array(
				'type' => 'integral',
				'integral' => array(
						'integral' => intval($prize_info['prize_value']),
				)
		);
		
		return $result;
	}
	
	/**
	 * 商品中奖处理
	 */
	private function _ProcessTypeGoods ($prize_info = array(), $user_id = 0)
	{
		$where = array(
				'is_on_sale'	=> 1,
				'is_alone_sale' => 1,
				'is_delete'		=> 0,
		);
		$where['review_status'] = array('gt' => 3);
		$goods_info = RC_Model::model('goods/goods_model')->where($where)->order('Rand()')->find();
		RC_Loader::load_app_func('admin_goods', 'goods');
		if ($goods_info['promote_price'] > 0) {
			$promote_price = Ecjia\App\Goods\BargainPrice::bargain_price($goods_info['promote_price'], $goods_info['promote_start_date'], $goods_info['promote_end_date']);
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
		
		return $result;
	}
	
	
	/**
	 * 店铺中奖处理
	 */
	private function _ProcessTypeStore ($prize_info = array(), $user_id = 0, $location = array(), $city_id = 0)
	{
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
			$store_info = RC_DB::table('store_franchisee')
			->whereIn('store_id', $options['store_id'])
			->where('status', 1)->where('identity_status', 2)->where('shop_close', 0)
			->orderBy(RC_DB::raw('Rand()'))
			->first();
		
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
		
		return $result;
	}
	
	/**
	 * 现金红包中奖处理
	 */
	private function _ProcessTypeBalance ($prize_info = array(), $user_id = 0)
	{
		//减奖品数量
		RC_DB::table('market_activity_prize')->where('prize_id', $prize_info['prize_id'])->decrement('prize_number');
		//发放现金红包；更新用户账户余额
		$options = array(
				'user_id'		=> $user_id,
				'user_money'	=> intval($prize_info['prize_value']),
				'change_desc'	=> '摇一摇活动抽奖赠送'
		);
		
		$account_change_log = RC_Api::api('user', 'account_change_log',$options);
		if (is_ecjia_error($account_change_log)) {
			
		}
		$result = array(
				'type' => 'balance',
				'balance' => array(
						'balance' => intval($prize_info['prize_value']),
						'formatted_balance' => price_format($prize_info['prize_value'])
				)
		);
		return $result;
	}
	
	/**
	 * 记录抽奖log
	 */
	private function _insertMarketActivityLog($prize_info = array(), $user_id = 0, $user_name = '')
	{
		$time = RC_TIME::gmtime();
		if ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_REAL) {
			$issue_status = 0;
			$issue_time = 0;
		} else {
			$issue_status = 1;
			$issue_time = $time;
		}
		$prize_type = array(
				Ecjia\App\Market\Prize\PrizeType::TYPE_BONUS,
				Ecjia\App\Market\Prize\PrizeType::TYPE_REAL,
				Ecjia\App\Market\Prize\PrizeType::TYPE_INTEGRAL,
				Ecjia\App\Market\Prize\PrizeType::TYPE_BALANCE,
		);
			
		if (in_array($prize_info['prize_type'], $prize_type)) {
			$log = array(
					'activity_id'	=> $prize_info['activity_id'],
					'user_id'		=> $user_id,
					'user_name'		=> $user_name,
					'prize_id'		=> $prize_info['prize_id'],
					'prize_name'	=> $prize_info['prize_name'],
					'issue_status'	=> $issue_status,
					'issue_time'	=> $issue_time,
					'add_time'		=> $time,
					'source'		=> 'app'
			);
			RC_DB::table('market_activity_log')->insert($log);
		}
	}
}

// end
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
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_zjd_init_action implements platform_interface {

    public function action() {
    	$platform_config_db = RC_Loader::load_app_model('platform_config_model','platform');
    	$wechat_prize_db = RC_Loader::load_app_model('wechat_prize_model','wechat');
    	RC_Loader::load_app_class('platform_account', 'platform', false);

    	## 获取GET请求数据
    	$openid     = trim($_GET['openid']);
    	$uuid       = trim($_GET['uuid']);
    	$account    = platform_account::make($uuid);
    	$wechat_id  = $account->getAccountID();

    	## 判断是否登陆
    	$rs = array();
    	if (empty($openid)) {
    		$rs['status'] = 2;
    		$rs['msg'] = '请先登录';
    		echo json_encode($rs);
    		exit();
    	}
    	
//     	$ext_config  = $platform_config_db->where(array('account_id' => $wechat_id,'ext_code'=>'mp_zjd'))->get_field('ext_config');
//     	$config = unserialize($ext_config);
//     	foreach ($config as $k => $v) {
//     		if ($v['name'] == 'starttime') {
//     			$starttime = strtotime($v['value']);
//     		}
//     		if ($v['name'] == 'endtime') {
//     			$endtime = strtotime($v['value']);
//     		}
//     		if ($v['name'] == 'prize_num') {
//     			$prize_num = $v['value'];
//     		}    		
//     		if ($v['name'] == 'list') {
//     			$list = explode("\n",$v['value']);
//     			foreach ($list as $k => $v){
//     				$prize[] = explode(",",$v);
//     			}
//     		}
//     	}
    	
//     	//判断砸金蛋时间时间是否开始
//     	if (time() < $starttime) {
//     		$rs['status'] = 2;
//     		$rs['msg'] = '砸金蛋活动还未开始';
//     		echo json_encode($rs);
//     		exit();
//     	}
//     	//判断砸金蛋时间时间是否结束
//     	if (time() > $endtime) {
//     		$rs['status'] = 2;
//     		$rs['msg'] = '砸金蛋活动已经结束';
//     		echo json_encode($rs);
//     		exit();
//     	}
//     	// 超过次数
//     	if (!empty($openid)) {
//     		$num = $wechat_prize_db->where('openid = "' . $openid . '"  and activity_type = "mp_zjd" and dateline between "' . $starttime . '" and "' . $endtime . '"')->count();
//     		if ($num <= 0) {
//     			$num = 1;
//     		} else {
//     			$num = $num + 1;
//     		}
//     	} else {
//     		$num = 1;
//     	}
//     	// 判断抽奖次数
//     	if ($num > $prize_num) {
//     		$rs['status'] = 2;
//     		$rs['msg'] = '抱歉，抽奖次数已用光';
//     		echo json_encode($rs);
//     		exit();
//     	}
//     	if (!empty($prize)) {
//     		$arr = array();
//     		$prize_name = array();
//     		foreach ($prize as $key => $val) {
//     			// 删除数量不足的奖品
//     			$count = $wechat_prize_db->where(array('prize_name' => $val[1],'activity_type'=>'mp_zjd','wechat_id'=>$wechat_id))->count();
//     			if ($count >= $val[2]) {
//     				unset($prize[$key]);
//     			} else {
//     				$arr[$val[0]] = $val[3];
//     				$prize_name[$val[0]] = $val[1];
//     			}
//     		}
//     		// 最后一个奖项
//     		$lastarr = end($prize);
//     		// 获取中奖项
//     		$level = $this->get_rand($arr);
//     		// 0为未中奖,1为中奖
//     		if ($level == $lastarr[0]) {
//     			$rs['status'] = 0;
//     			$data['prize_type'] = 0;
//     		} else {
//     			$rs['status'] = 1;
//     			$data['prize_type'] = 1;
//     		}
//     		$rs['msg'] = $prize_name[$level];
//     		$rs['num'] = $prize_num - $num > 0 ? $prize_num - $num : 0;
//     		// 抽奖记录
//     		$data['wechat_id'] = $wechat_id;
//     		$data['openid'] = $openid;
//     		$data['prize_name'] = $prize_name[$level];
//     		$data['dateline'] = time();
//     		$data['activity_type'] = 'mp_zjd';
//     		$id = $wechat_prize_db->insert($data);
//     		if ($level != $lastarr[0] && !empty($id)) {
//     			// 获奖链接
//     			$rs['link'] = RC_Uri::url('platform/plugin/show', array('handle' => 'mp_zjd/user', 'name' => 'mp_zjd', 'id' => $id,'openid' => $openid,'uuid' => $uuid));
// //     			$rs['link'] = str_replace('&amp;', '&', $rs['link']);
//     		}
//     	}

    	$store_id = RC_DB::table('platform_account')->where('id', $wechat_id)->pluck('shop_id');
    	$market_activity = RC_DB::table('market_activity')->where('store_id', $store_id)->where('wechat_id', $wechat_id)->where('activity_group', 'wechat_zajindan')->first();
    	$starttime = $market_activity['start_time'];
    	$endtime   = $market_activity['end_time'];
    	$time	   = RC_Time::gmtime();
    	// 判断砸金蛋时间时间是否开始
    	if ($time < $starttime) {
    		$rs['status'] = 2;
    		$rs['msg'] = '砸金蛋活动还未开始';
    		echo json_encode($rs);
    		exit();
    	}    	
    	//判断砸金蛋时间时间是否结束
    	if ($time > $endtime) {
    		$rs['status'] = 2;
    		$rs['msg'] = '砸金蛋活动已经结束';
    		echo json_encode($rs);
    		exit();
    	}
    	// 超过次数
    	if ($market_activity['limit_num'] > 0) {
    		//$db_activity_log = RC_DB::table('market_activity_log');
    		//$db_activity_log->where('activity_id', $market_activity['activity_id'])->where('user_id', $openid);//openid
    		$db_market_activity_lottery = RC_DB::table('market_activity_lottery');
    		if ($market_activity['limit_time'] > 0) {
    			$time_limit = $time - $market_activity['limit_time']*60*60;
    			$db_market_activity_lottery->where('update_time', '<=', $time)->where('add_time', '>=', $time_limit);
    		}
    		$market_activity_lottery_info = RC_DB::table('market_activity_lottery')->where('activity_id', $market_activity['activity_id'])->where('user_id', $openid)->first();
    			
    		$limit_count = $market_activity_lottery_info['lottery_num'];
    		
    		//当前时间 -上次抽奖添加时间大于限制时间时；重置抽奖时间和抽奖次数；
    		if ($time - $market_activity_lottery_info['add_time'] >= $market_activity['limit_time']*60*60) {
    			RC_DB::table('market_activity_lottery')
    			->where('activity_id', $market_activity['activity_id'])
    			->where('user_id', $_SESSION['user_id'])
    			->update(array('add_time' => $time, 'update_time' => $time, 'lottery_num' => 1));
    		}
    		
    		//限定时间已抽取的次数
    		$has_used_count = $limit_count;
    		$unused_num = $market_activity['limit_num'] - $has_used_count;//剩余可抽取的次数
    		 
    		if ($unused_num <= 0) {
    			$rs['status'] = 2;
    			$rs['msg'] = '活动次数太频繁，请稍后再来！';
    			echo json_encode($rs);
    			exit();
    		} else {
    			if (empty($market_activity_lottery_info)) {
    				//第一次参与抽奖此活动
    				$data = array(
    						'activity_id' => $market_activity['activity_id'],
    						'user_id'	  => $openid,
    						'user_type'	  => 'wechat',
    						'lottery_num' => 1,
    						'add_time'    => $time,
    						'update_time' => $time
    				);
    				RC_DB::table('market_activity_lottery')->insertGetId($data);
    			} else {
    				//规定时间未超出设定的次数；更新抽奖次数，更新抽奖时间
    				$limit_count_new = $limit_count + 1;
    				RC_DB::table('market_activity_lottery')->where('activity_id', $market_activity['activity_id'])->where('user_id', $openid)->update(array('update_time' => $time, 'lottery_num' => $limit_count_new));
    			}
    		}
    		
    		
    	} else {
    		$unused_num = '无限次';
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
    	
    	$rid = $this->get_rand($prize_arr);
    	/* 获取中奖*/
    	$prize_info = $market_activity_prize_new[$rid];
    	if (empty($prize_info)) {
    		$rs['status'] = 2;
    		$rs['msg'] = '很遗憾，未中奖！';
    		echo json_encode($rs);
    		exit();
    	}
    	
    	$user_id = RC_DB::table('connect_user')->where('connect_code', 'sns_wechat')->where('open_id', $openid)->pluck('user_id');
    	if ($prize_info['prize_type'] == '1') {
    		$bonus_info = RC_DB::table('bonus_type')->where('type_id', $prize_info['prize_value'])->first();
    		if ($bonus_info['send_start_date'] <= $time && $bonus_info['send_end_date'] >= $time) {
    			/*减奖品数量*/
    			RC_DB::table('market_activity_prize')->where('prize_id', $prize_info['prize_id'])->decrement('prize_number');
    			/*发放奖品至用户，发放红包*/
    			if (!empty($user_id)) {
    				$data = array(
    						'bonus_type_id' => $prize_info['prize_value'],
    						'user_id'		=> $user_id
    				);
    			}
    			RC_DB::table('user_bonus')->insert($data);
    		} 
    		/*else {
    			$rs['status'] = 2;
    			$rs['msg'] = '很遗憾，您未中奖！';
    			echo json_encode($rs);
    			exit();
    		}*/
    	} elseif ($prize_info['prize_type'] == '3') {
    		/*减奖品数量*/
    		RC_DB::table('market_activity_prize')->where('prize_id', $prize_info['prize_id'])->decrement('prize_number');
    		/*发放奖品至用户，赠送积分给用户*/
    		if (!empty($user_id)) {
    			$options = array(
    					'user_id'		=> $user_id,
    					'pay_points'	=> intval($prize_info['prize_value']),
    					'change_desc'	=> '微信营销活动参与赠送'
    			);
    			RC_Api::api('user', 'account_change_log',$options);
    		}
    	}
    	
    	if (in_array($prize_info['prize_type'], array(2))) {
    		$rs['status'] = 1;
    	} else {
    		$rs['status'] = 0;
    	}
    	$rs['msg'] = $prize_info['prize_name'];
    	if ($market_activity['limit_num'] > 0) {
    		$rs['num'] = $unused_num - 1;
    	} else {
    		$rs['num'] = $unused_num;
    	}
    	
    	$name = RC_DB::table('wechat_user')->where('openid', $openid)->pluck('nickname');
    	if (in_array($prize_info['prize_type'], array(1,2,3))) {
    		if ($prize_info['prize_type'] == 2) {
    			$issue_status = 0;
    			$issue_time = 0;
    		} else {
    			$issue_status = 1;
    			$issue_time = $time;
    		}
    		$data = array(
    				'activity_id' 	=> $market_activity['activity_id'],
    				'user_id'		=> $openid,
    				'user_type'		=> 'wechat',
    				'user_name'		=> empty($name) ? '' : $name,
    				'prize_id'		=> $prize_info['prize_id'],
    				'prize_name'	=> $prize_info['prize_name'],
    				'add_time'		=> RC_Time::gmtime(),
    				'source'		=> 'wechat',
    				'issue_status'	=> $issue_status,
    				'issue_time'	=> $issue_time
    		);
    		$id = RC_DB::table('market_activity_log')->insertGetId($data);
    	}
    	
    	//奖品类型为红包或积分为中奖
    	if (in_array($prize_info['prize_type'], array(2)) && !empty($id)) {
    		// 获奖链接
    		$rs['link'] = RC_Uri::url('platform/plugin/show', array('handle' => 'mp_zjd/user', 'name' => 'mp_zjd', 'id' => $id,'openid' => $openid,'uuid' => $uuid));
    	}
    	echo json_encode($rs);
    	exit();
	}
	
	/**
	 * 中奖概率计算
	 *
	 * @param unknown $proArr
	 * @return Ambigous <string, unknown>
	 */
	private function get_rand($proArr) {
		$result = '';
		// 概率数组的总概率精度
		$proSum = array_sum($proArr);
		// 概率数组循环
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset($proArr);
		return $result;
	}
}

// end
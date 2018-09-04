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

use Ecjia\App\Market\Controllers\EcjiaMarketActivityController;


class mobile_prize extends EcjiaMarketActivityController
{

    public function __construct()
    {
        parent::__construct();

        $this->assign('front_url', RC_App::apps_url('statics/front', __FILE__));
        
        $this->assign('system_statics_url', RC_Uri::admin_url('statics'));
    }

    public function prize_init()
    {
        $openid 		= trim($_GET['openid']);
        $uuid 			= trim($_GET['uuid']);
        $activity_id 	= intval($_GET['activity_id']);
        
        $dbview = RC_DB::table('market_activity_log as mal')->leftJoin('market_activity_prize as map', RC_DB::raw('mal.prize_id'), '=', RC_DB::raw('map.prize_id'));
        if (!empty($activity_id)) {
        	$dbview->where(RC_DB::raw('mal.activity_id'), $activity_id);
        }
        //中奖类型的奖品id
        $prize_log_list = $dbview->where(RC_DB::raw('mal.user_id'), $openid)
        							->whereIn(RC_DB::raw('map.prize_type'), array(1,2,3,6))
        							->select(RC_DB::raw('mal.*, map.prize_type, map.prize_value'))
        							->groupBy(RC_DB::raw('mal.id'))
        							->orderBy(RC_DB::raw('mal.add_time'), 'desc')
        							->get();
 		
        if (!empty($prize_log_list)) {
        	foreach ($prize_log_list as $key => $val) {
        		if ($val['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_REAL) {
        			$prize_log_list[$key]['icon'] = RC_App::apps_url('statics/front/images/shiwu.png', __FILE__);
        			$prize_log_list[$key]['prize_value_label'] = $val['prize_name'];
        		} elseif ($val['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_INTEGRAL) {
        			$prize_log_list[$key]['icon'] = RC_App::apps_url('statics/front/images/jifen.png', __FILE__);
        			$prize_log_list[$key]['prize_value_label'] = '+'.$val['prize_value'];
        		} else {
        			$prize_log_list[$key]['icon'] = RC_App::apps_url('statics/front/images/hongbao.png', __FILE__);
        			if ($val['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BONUS) {
        				$prize_value = RC_DB::table('bonus_type')->where('type_id', $val['prize_value'])->pluck('type_money');
        				$prize_log_list[$key]['prize_value_label'] = price_format($prize_value, false);
        			} elseif ($val['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BALANCE) {
        				$prize_log_list[$key]['prize_value_label'] = price_format($val['prize_value']);
        			}
        		}
        		$activity_group = RC_DB::table('market_activity')->where('activity_id', $val['activity_id'])->pluck('activity_group');
        		if ($activity_group == 'wechat_dazhuanpan') {
        			$prize_log_list[$key]['activity_name'] = '微信大转盘';
        		} elseif ($activity_group == 'wechat_guaguale') {
        			$prize_log_list[$key]['activity_name'] = '微信刮刮乐';
        		} elseif ($activity_group == 'wechat_zajindan') {
        			$prize_log_list[$key]['activity_name'] = '微信砸金蛋';
        		} elseif ($activity_group == 'mobile_shake') {
        			$prize_log_list[$key]['activity_name'] = '手机摇一摇';
        		}
        		$prize_log_list[$key]['formated_add_time'] = RC_Time::local_date('Y-m-d H:i:s', $val['add_time']);
        		if (!empty($val['issue_extend'])) {
        			$issue_extend = unserialize($val['issue_extend']);
        			if (!empty($issue_extend['user_name']) && !empty($issue_extend['mobile']) && !empty($issue_extend['address'])) {
        				$prize_log_list[$key]['has_filled'] = 1;
        			} else {
        				$prize_log_list[$key]['has_filled'] = 0;
        			}
        		} else {
        			$prize_log_list[$key]['has_filled'] = 0;
        		}
        	}
        }
   	
        $this->assign('prize_log_list', $prize_log_list);
        $this->assign('uuid',  $uuid );
        $this->assign('openid',  $openid);
        
        $this->display(
            RC_Package::package('app::market')->loadTemplate('front/prize_list.dwt', true)
        );
    }


    //用户收货信息填写
    public function user_info()
    {
    	$log_id 	= intval($_GET['log_id']);
  
    	$log_info   = RC_DB::table('market_activity_log')->where('id', $log_id)->first();
    	$prize_id 	= $log_info['prize_id'];
    	$issue_extend = unserialize($log_info['issue_extend']);
    	if (!empty($log_info['issue_extend'])) {
    		$this->assign('has_filled', 1);
    	}
    	
    	$prize_info = RC_DB::table('market_activity_prize')->where('prize_id', $prize_id)->first();
    	$prize_info['formated_add_time'] = RC_Time::local_date('Y-m-d H:i:s', $prize_info['add_time']);
    	
    	$prize_info['id'] = $log_id;
    	$prize_info['user_name'] 	= $issue_extend['user_name'];
    	$prize_info['mobile'] 		= $issue_extend['mobile'];
    	$prize_info['address'] 		= $issue_extend['address'];
    	
    	if ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_REAL) {
    		$prize_info['prize_value_label'] = $prize_info['prize_name'];
    		$prize_info['icon'] = RC_App::apps_url('statics/front/images/shiwu.png', __FILE__);
    	} elseif ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_INTEGRAL) {
    		$prize_info['prize_value_label'] = '+'.$prize_info['prize_value'];
    		$prize_info['icon'] = RC_App::apps_url('statics/front/images/jifen.png', __FILE__);
    	} else {
    		$prize_info['icon'] = RC_App::apps_url('statics/front/images/hongbao.png', __FILE__);
    		if ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BONUS) {
    			$prize_value = RC_DB::table('bonus_type')->where('type_id', $prize_info['prize_value'])->pluck('type_money');
    			$prize_info['prize_value_label'] = price_format($prize_value, false);
    		} elseif ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BALANCE) {
    			$prize_info['prize_value_label'] = price_format($prize_info['prize_value']);
    		}
    	}
    	
    	$activity_group = RC_DB::table('market_activity')->where('activity_id', $prize_info['activity_id'])->pluck('activity_group');
    	if ($activity_group == 'wechat_dazhuanpan') {
    		$prize_info['activity_name'] = '微信大转盘';
    	} elseif ($activity_group == 'wechat_guaguale') {
    		$prize_info['activity_name'] = '微信刮刮乐';
    	} elseif ($activity_group == 'wechat_zajindan') {
    		$prize_info['activity_name'] = '微信砸金蛋';
    	} elseif ($activity_group == 'mobile_shake') {
    		$prize_info['activity_name'] = '手机摇一摇';
    	}
    	
    	$this->assign('prize_info', $prize_info);
    	
        $this->display(
            RC_Package::package('app::market')->loadTemplate('front/fill_user_info.dwt', true)
        );
    }
    
    //用户收货信息提交处理
    public function submit_user_info()
    {
    	$log_id 	= intval($_GET['log_id']);
    	$user_name	= trim($_POST['user_name']);
    	$mobile 	= trim($_POST['mobile']);
    	$address 	= trim($_POST['address']);
  
    	$prize_log_info = RC_DB::table('market_activity_log')->where('id',$log_id )->first();
    	if (empty($prize_log_info)) {
    		return ecjia_front::$controller->showmessage('抽奖信息不存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	if ($prize_log_info['issue_status'] == '1') {
    		return ecjia_front::$controller->showmessage('奖品已发放！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	if (empty($user_name)) {
    		return ecjia_front::$controller->showmessage('请填写收货人姓名！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	if (empty($mobile)) {
    		return ecjia_front::$controller->showmessage('请填写收货人手机号码！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	if (empty($address)) {
    		return ecjia_front::$controller->showmessage('请填写收货人详细地址！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$data = array(
    			'user_name' => $user_name,
    			'mobile'	=> $mobile,
    			'address'	=> $address
    	);
    	$data = serialize($data);
    	$winner['issue_extend'] = $data;
    	RC_DB::table('market_activity_log')->where('id', $log_id)->update($winner);
    	return ecjia_front::$controller->showmessage('资料提交成功，请等待发放奖品！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('market/mobile_prize/prize_init', array('openid' => $prize_log_info['user_id']))));
    }
    
    //领取奖品
    public function issue_prize()
    {
    	$openid					= trim($_GET['openid']);
    	$log_id 				= intval($_GET['log_id']);
    	$activity_id 			= intval($_GET['activity_id']);
    	$activity_info  		= RC_DB::table('market_activity')->where('activity_id', $activity_id)->first();
    	$time					= RC_Time::gmtime();
    	
    	if (empty($activity_info)) {
    		return ecjia_front::$controller->showmessage('活动信息不存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$market_activity_log	= RC_DB::table('market_activity_log')->where('id', $log_id)->first();
    	if (empty($market_activity_log)) {
    		return ecjia_front::$controller->showmessage('抽奖信息不存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$prize_info = Ecjia\App\Market\Models\MarketActivityPrizeModel::where('activity_id', $activity_id)->find($market_activity_log['prize_id']);
    	if (empty($prize_info)) {
    		return ecjia_front::$controller->showmessage('奖品信息不存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$MarketActivity = new Ecjia\App\Market\Prize\MarketActivity($activity_info['activity_group'], $activity_info['store_id'], $activity_info['wechat_id']);
    	//红包发放日期过期处理
    	if ($prize_info['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BONUS) {
    		$bonus_info = RC_DB::table('bonus_type')->where('type_id', $prize_info['prize_value'])->where('send_start_date', '<=', $time)->where('send_end_date', '>=', $time)->first();
    		if (empty($bonus_info)) {
    			return ecjia_front::$controller->showmessage('红包发放日期已过，请联系管理员发放！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    	}
    	//发奖环节
    	$res = $MarketActivity->issuePrize($activity_info['wechat_id'], $openid, $prize_info, $log_id);
    	if ($res) {
    		return ecjia_front::$controller->showmessage('兑换成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/mobile_prize/prize_init', array('openid' => $openid))));
    	} else {
    		return ecjia_front::$controller->showmessage('兑换失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
}

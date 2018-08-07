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

use Ecjia\App\Platform\Frameworks\Contracts\PluginPageInterface;

class mp_zjd_init_action implements PluginPageInterface
{

    public function action()
    {

        ## 获取GET请求数据
        $openid = trim($_GET['openid']);

        ## 判断是否登陆
        if (empty($openid)) {
            return ecjia_front::$controller->showmessage('请先登录', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $code = trim($_GET['name']);
        
        if ($code != 'mp_zjd') {
        	return ecjia_front::$controller->showmessage('错误的请求', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        return $this->doAction();
    }
	
    /**
     * 中奖请求处理类
     */
    public function doAction()
    {
    	// 获取GET请求数据
    	$openid = trim($_GET['openid']);
    	$uuid = trim($_GET['uuid']);

        $code = 'wechat_zajindan';
        $platform_account = new Ecjia\App\Platform\Frameworks\Platform\Account($uuid);
    
    	$wechat_id = $platform_account->getAccountID();
    	$store_id = $platform_account->getStoreId();
    
        try {
            $MarketActivity = new Ecjia\App\Market\Prize\MarketActivity($code, $store_id, $wechat_id);
        } catch (Ecjia\App\Market\Exceptions\ActivityException $e) {
            return ecjia_front::$controller->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $starttime = $MarketActivity->getActivityStartTime();
    	$endtime = $MarketActivity->getActivityEndTime();
    	$time = RC_Time::gmtime();
    
    	// 判断砸金蛋时间时间是否开始
    	if ($time < $starttime) {
    		return ecjia_front::$controller->showmessage('刮刮卡活动还未开始', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	//判断砸金蛋时间时间是否结束
    	if ($time > $endtime) {
    		return ecjia_front::$controller->showmessage('刮刮卡活动已经结束', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    
    	//获取用户剩余抽奖次数
    	$prize_num = $MarketActivity->getLotteryOverCount($openid);
    	
    	if ($prize_num === 0) {
    		return ecjia_front::$controller->showmessage('活动次数太频繁，请稍后再来！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	/*
    	 * 每次前端页面的请求，PHP循环奖项设置数组，
    	* 通过概率计算函数get_rand获取抽中的奖项id。
    	* 最后输出json个数数据给前端页面。
    	*/
    	$prize_info = $MarketActivity->randLotteryPrizeAction();
    	
    	$prize_id = $prize_info['prize_id'];
    	
    	if (empty($prize_id)) {
    		return ecjia_front::$controller->showmessage('很遗憾，未中奖！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    
    	$prize_info = Ecjia\App\Market\Models\MarketActivityPrizeModel::where('activity_id', $MarketActivity->getActivityId())->find($prize_id);
    	if (empty($prize_info)) {
    		return ecjia_front::$controller->showmessage('很遗憾，未中奖！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	//填写参与记录
    	$MarketActivity->incrementLotteryCount($openid);
    	
    	$status = Ecjia\App\Market\Prize\PrizeType::getPrizeStatus($prize_info->prize_type);
    	if (empty($status)) {
            //扣减未中奖的奖品数量
            $MarketActivity->subtractLotteryPrizeNum($prize_info);
    		return ecjia_front::$controller->showmessage('很遗憾，再接再励！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    
    	//记录中奖记录
    	$logid = $MarketActivity->addLotteryPrizeLog($openid, $prize_info);
    
    	//发奖环节
    	$MarketActivity->issuePrize($wechat_id, $openid, $prize_info, $logid);
 
    	//中奖名称
    	$rs['prize_name'] = $prize_info->prize_name;
    
    	// 获奖链接
    	$rs['link'] = RC_Uri::url('market/mobile_prize/prize_init', array('activity_id' => $MarketActivity->getActivityId(), 'openid' => $openid, 'uuid' => $uuid));
    
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $rs);
    }
    
}

// end

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
class mp_zjd_init implements platform_interface {
    
    public function action() {
        ##  载入插件素材
        $css_url    = RC_Plugin::plugins_url('css/style.css', __FILE__);
    	$jq_url     = RC_Plugin::plugins_url('js/jquery.js', __FILE__);
    	$tplpath    = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/zjd_index.dwt.php';
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	
    	ecjia_front::$controller->assign('jq_url',$jq_url);
    	ecjia_front::$controller->assign('css_url',$css_url);

        $img4   = RC_Plugin::plugins_url('images/img-4.png',__FILE__);
        $img6   = RC_Plugin::plugins_url('images/img-6.png',__FILE__);
    	$egg1   = RC_Plugin::plugins_url('images/egg_1.png',__FILE__);
    	$egg2   = RC_Plugin::plugins_url('images/egg_2.png',__FILE__);
        ecjia_front::$controller->assign('img4',$img4);
        ecjia_front::$controller->assign('img6',$img6);
    	ecjia_front::$controller->assign('egg1',$egg1);
    	ecjia_front::$controller->assign('egg2',$egg2);
    	
    	$platform_config_db     = RC_Loader::load_app_model('platform_config_model','platform');
    	$wechat_prize_db        = RC_Loader::load_app_model('wechat_prize_model','wechat');
    	$wechat_prize_view_db   = RC_Loader::load_app_model('wechat_prize_viewmodel','wechat');

    	// 获取GET请求数据
    	$openid = trim($_GET['openid']);
    	$uuid   = trim($_GET['uuid']);

    	$account        = platform_account::make($uuid);
    	$wechat_id      = $account->getAccountID();
    	
//     	$ext_config     = $platform_config_db->where(array('account_id' => $wechat_id,'ext_code'=>'mp_zjd'))->get_field('ext_config');
//     	$config = unserialize($ext_config);
//     	foreach ($config as $k => $v) {
//     	    // 开始时间
//     		if ($v['name'] == 'starttime') {
//     			$starttime = $v['value'];
//     		}
//     		// 结束时间
//     		if ($v['name'] == 'endtime') {
//     			$endtime = $v['value'];
//     		}
//     		// 奖品名称
//     		if ($v['name'] == 'prize_num') {
//     			$prize_num = $v['value'];
//     		}
//     		// 奖品描述
//     		if ($v['name'] == 'description') {
//     			$description = $v['value'];
//     		}
//     		// 奖品列表
//     		if ($v['name'] == 'list') {
//     			$list = explode("\n",$v['value']);
//     			foreach ($list as $k => $v){
//     				$prize[] = explode(",",$v);
//     			}
//     		}
//     	}
//     	if (!empty($prize)) {
//     		$num = count($prize);
//     		if($num > 0){
//     			foreach ($prize as $key => $val) {
//     				if ($key == ($num - 1)) {
//     					unset($prize[$key]);
//     				}
//     			}
//     		}
//     	}
//     	$starttime = strtotime($starttime);
//     	$endtime   = strtotime($endtime);
//     	$count = $wechat_prize_db->where('openid = "' . $openid . '"  and wechat_id = "' . $wechat_id . '"  and activity_type = "mp_zjd" and dateline between "' . $starttime . '" and "' . $endtime . '"')->count();
//     	$prize_num = ($prize_num - $count) < 0 ? 0 : $prize_num - $count;
//     	$list = $wechat_prize_view_db->where('p.wechat_id = "' . $wechat_id . '" and p.prize_type = 1  and p.activity_type = "mp_zjd" and dateline between "' . $starttime . '" and "' . $endtime . '"')->order('dateline desc')->limit(10)->select();
		
    	$store_id = RC_DB::table('platform_account')->where('id', $wechat_id)->pluck('shop_id');
    	$market_activity = RC_DB::table('market_activity')->where('store_id', $store_id)->where('activity_group', 'wechat_zajindan')->where('wechat_id', $wechat_id)->first();
    	
    	$starttime = $market_activity['start_time'];
    	$endtime   = $market_activity['end_time'];
    	$time	   = RC_Time::gmtime();
    
    	/* 判断活动有无限定次数*/
    	if ($market_activity['limit_num'] > 0) {
    		$db_market_activity_lottery = RC_DB::table('market_activity_lottery');
    		if ($market_activity['limit_time'] > 0) {
    			$time_limit = $time - $market_activity['limit_time']*60*60;
    			$db_market_activity_lottery->where('update_time', '<=', $time)->where('add_time', '>=', $time_limit);
    		}
    		$market_activity_lottery_info = RC_DB::table('market_activity_lottery')->where('activity_id', $market_activity['activity_id'])->where('user_id', $openid)->first();
    			
    		$limit_count = $market_activity_lottery_info['lottery_num'];
    		//限定时间已抽取的次数
    		$has_used_count = $limit_count;
    		$prize_num = $market_activity['limit_num'] - $has_used_count;//剩余可抽取的次数
    	} else {
    		$prize_num = '无限次';
    	}
    	$description = $market_activity['activity_desc'];
    	$prize_list = RC_DB::table('market_activity_prize')->where('activity_id', $market_activity['activity_id'])->orderBy('prize_level', 'asc')->get();
 
    	if (!empty($prize_list)) {
    		foreach ($prize_list as $k => $v) {
    			if ($v['prize_type'] == '1') {
    				$prize_value = RC_DB::table('bonus_type')->where('type_id', $v['prize_value'])->pluck('type_money');
    				$prize_list[$k]['prize_value'] = price_format($prize_value, false);
    			}
    		}
    	}
    	//当前活动的奖品类型为红包和积分的奖品
    	$prize_ids = RC_DB::table('market_activity_prize')->where('activity_id', $market_activity['activity_id'])->whereIn('prize_type', array(1,2,3))->lists('prize_id');
    	$winning_list = [];
    	if (!empty($prize_ids)) {
    		$winning_list = RC_DB::table('market_activity_log')->where('activity_id', $market_activity['activity_id'])->whereIn('prize_id', $prize_ids)->take(10)->get();
    	}
    	
    	if (!empty($winning_list)) {
    		foreach ($winning_list as $row) {
    			$prize_info = RC_DB::table('market_activity_prize')->where('prize_id', $row['prize_id'])->first();
    			if ($prize_info['prize_type'] == '1') {
    				$prize_value = RC_DB::table('bonus_type')->where('type_id', $prize_info['prize_value'])->pluck('type_money');
    				$prize_value = price_format($prize_value, false);
    			} else {
    				$prize_value = $prize_info['prize_value'];
    			}
    			$row['prize_value'] = $prize_value;
    			$row['prize_type'] = $prize_info['prize_type'];
    			$list[] = $row;
    		}
    	}
  	
    	ecjia_front::$controller->assign('form_action',RC_Uri::url('platform/plugin/show', array('handle' => 'mp_zjd/init_action', 'openid' => $openid, 'uuid' => $uuid)));
    	//ecjia_front::$controller->assign('prize',$prize);
    	ecjia_front::$controller->assign('prize',$prize_list);
    	ecjia_front::$controller->assign('list',$list);
    	ecjia_front::$controller->assign('prize_num',$prize_num);
    	ecjia_front::$controller->assign('description',$description);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display($tplpath);
	}
}

// end
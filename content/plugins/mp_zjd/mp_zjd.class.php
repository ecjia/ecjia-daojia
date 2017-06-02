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
/**
 * 微信登录
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('platform_abstract', 'platform', false);
class mp_zjd extends platform_abstract
{    

	/**
	 * 获取插件配置信息
	 */
	public function local_config() {
		$config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
		if (is_array($config)) {
			return $config;
		}
		return array();
	}
	
    public function event_reply() {
    	$wechat_point_db = RC_Loader::load_app_model('wechat_point_model','wechat');
    	$platform_config = RC_Loader::load_app_model('platform_config_model','platform');
    	$users_db = RC_Loader::load_app_model('users_model','user');
    	$media_db = RC_Loader::load_app_model('wechat_media_model', 'wechat');
    	$connect_db = RC_Loader::load_app_model('connect_user_model', 'connect');
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	RC_Loader::load_app_class('wechat_user', 'wechat', false);
    	RC_Loader::load_app_func('global','wechat');
    	
    	$time = RC_Time::gmtime();
    	$openid = $this->from_username;
    	$uuid = trim($_GET['uuid']);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	$wechat_user = new wechat_user($wechat_id, $openid);
    
    	$ect_uid = $wechat_user->getUserId();
    	$unionid = $wechat_user->getUnionid();
    	$user_id = $connect_db->where(array('open_id' => $unionid, 'connect_code'=>'sns_wechat'))->get_field('user_id');
    	$nobd = "还未绑定，需<a href = '".RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_init', 'openid' => $openid, 'uuid' => $_GET['uuid']))."'>点击此处</a>进行绑定";
    	
		if (empty($ect_uid)) {
			if(!empty($ect_uid)){
				$query = $connect_db->where(array('open_id'=>$unionid, 'connect_code'=>'sns_wechat'))->count();
				if($query > 0){
					$connect_db->where(array('open_id' => $unionid, 'connect_code'=>'sns_wechat'))->update(array('user_id' => $ect_uid));
				}else{
					$data['connect_code'] = 'sns_wechat';
					$data['user_id'] = $ect_uid;
					$data['is_admin'] = 0;
					$data['open_id'] = $unionid;
					$data['create_at'] = $time;
					$connect_db->insert($data);
				}
			}
			$content = array(
				'ToUserName' => $this->from_username,
				'FromUserName' => $this->to_username,
				'CreateTime' => SYS_TIME,
				'MsgType' => 'text',
				'Content' => $nobd
			);
		} else {
			$ext_config  = $platform_config->where(array('account_id' => $wechat_id,'ext_code'=>$info['ext_code']))->get_field('ext_config');
	    	$config = array();
	    	$config = unserialize($ext_config);
	    	foreach ($config as $k => $v) {
				if ($v['name'] == 'media_id') {
					$media_id = $v['value'];
				}
			}
			//页面信息
			if (isset($media_id) && ! empty($media_id)) {
				$field='id, title, content, digest, file, type, file_name, link';
				$mediaInfo = $media_db->field($field)->find(array('id' => $media_id));
				$articles = array();
	            if (!empty($mediaInfo['digest'])){
	            	$desc = $mediaInfo['digest'];
	            } else {
	            	$desc = msubstr(strip_tags(html_out($mediaInfo['content'])),100);
	            }
	            $articles[0]['Title'] = $mediaInfo['title'];
	            $articles[0]['Description'] = $desc;
	            $articles[0]['PicUrl'] = RC_Upload::upload_url($mediaInfo['file']);
// 	            $articles[0]['Url'] = $mediaInfo['link'];
	            $articles[0]['Url'] = RC_Uri::url('platform/plugin/show', array('handle' => 'mp_zjd/init', 'openid' => $openid, 'uuid' => $_GET['uuid']));
	            $count = count($articles);
	            $content = array(
                     'ToUserName' => $this->from_username,
                     'FromUserName' => $this->to_username,
                     'CreateTime' => SYS_TIME,
                     'MsgType' => 'news',
                     'ArticleCount'=>$count,
                     'Articles'=>$articles
                );
	            // 积分赠送
	            $this->give_point($openid, $info);
			} 
		}
		return $content;
    }
    
    /**
     * 积分赠送
     */
    public function give_point($openid, $info) {
    	$wechat_point_db = RC_Loader::load_app_model('wechat_point_model','wechat');
    	if (!empty($info)) {
    		// 配置信息
    		$config = array();
    		$config = unserialize($info['ext_config']);
    		
    		foreach ($config as $k => $v) {
    			if ($v['name'] == 'point_status') {
    				$point_status = $v['value'];
    			}
    			if ($v['name'] == 'point_interval') {
    				$point_interval = $v['value'];
    			}
    			if ($v['name'] == 'point_num') {
    				$point_num = $v['value'];
    			}
    			if ($v['name'] == 'point_value') {
    				$point_value = $v['value'];
    			}
    		}
    		// 开启积分赠送
    		if (isset($point_status) && $point_status == 1) {
    			$where = 'openid = "' . $openid . '" and createtime > (UNIX_TIMESTAMP(NOW())- ' .$point_interval . ') and keywords = "'.$info['ext_code'].'" ';
	            $num = $wechat_point_db->where($where)->count('*');
    			if ($num < $point_num) {
    				$this->do_point($openid, $info, $point_value);
    			}
    		}
    	}
    }
    
    /**
     * 执行赠送积分
     */
    public function do_point($openid, $info, $point_value) {
    	$wechatuser_db		= RC_Loader::load_app_model('wechat_user_model','wechat');
    	$users_db 			= RC_Loader::load_app_model('users_model','user');
    	$account_log_db 	= RC_Loader::load_app_model('account_log_model','user');
    	$wechat_point_db	= RC_Loader::load_app_model('wechat_point_model','wechat');
    	
    	$time = RC_Time::gmtime();
    	$ect_uid = $wechatuser_db->where(array('openid'=>$openid))->get_field('ect_uid');
    	$rank_points = $users_db->where(array('user_id' => $ect_uid))->get_field('rank_points');
    	
    	$point = array(
    		'rank_points' => intval($rank_points) + intval($point_value)
    	);
    	
    	$users_db->where(array('user_id' => $ect_uid))->update($point);
        	
    	// 积分记录
    	$data['user_id'] = $ect_uid;
    	$data['user_money'] = 0;
    	$data['frozen_money'] = 0;
    	$data['rank_points'] = $point_value;
    	$data['pay_points'] = 0;
    	$data['change_time'] = $time;
    	$data['change_desc'] = '积分赠送';
    	$data['change_type'] = ACT_OTHER;
    	
    	$log_id = $account_log_db->insert($data);
    	
    	// 从表记录
    	$data1['log_id'] = $log_id;
    	$data1['openid'] = $openid;
    	$data1['keywords'] = $info['ext_code'];
    	$data1['createtime'] = $time;
    	
    	$log_id = $wechat_point_db->insert($data1);
    }
}

// end
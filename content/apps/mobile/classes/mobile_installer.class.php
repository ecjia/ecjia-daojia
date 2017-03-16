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

class mobile_installer extends ecjia_installer {

    protected $dependent = array(
        'ecjia.system' => '1.0',
    );

    public function __construct() {
        $id = 'ecjia.mobile';
        parent::__construct($id);
    }
    
    public function install() {
    	/* 设备信息*/
        $table_name = 'mobile_device';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`device_udid` char(40) NOT NULL DEFAULT ''",
                "`device_client` char(10) NOT NULL DEFAULT ''",
                "`device_code` char(4) NOT NULL DEFAULT ''",
                "`device_name` varchar(30) DEFAULT NULL",
                "`device_alias` varchar(30) DEFAULT NULL",
                "`device_token` char(64) DEFAULT NULL",
                "`device_os` varchar(30) DEFAULT NULL",
            	"`device_type` varchar(30) DEFAULT NULL",
                "`user_id` int(9) NOT NULL DEFAULT '0'",
                "`user_type` varchar(10)  NULL COMMENT '用户类型'",
                "`location_province` varchar(20) DEFAULT NULL",
                "`location_city` varchar(20) DEFAULT NULL",
            	"`visit_times` int(10) NOT NULL DEFAULT '0'",
                "`in_status` tinyint(1) NULL",
                "`add_time` int(10) NOT NULL DEFAULT '0'",
            	"`update_time` int(10) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
                "UNIQUE KEY `device_udid` (`device_udid`,`device_client`,`device_code`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        /* 今日热点*/
        $table_name = 'mobile_news';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
        			"`group_id` int(11) NULL",
        			"`title` varchar(100) DEFAULT NULL",
        			"`description` varchar(255) DEFAULT NULL",
        			"`image` varchar(100) DEFAULT NULL",
        			"`content_url` varchar(100) DEFAULT NULL",
        			"`type` char(10) NOT NULL DEFAULT ''",
        			"`status` tinyint(3) NOT NULL DEFAULT '0'",
        			"`create_time` int(10) NOT NULL DEFAULT '0'",
        			"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        
        $table_name = 'mobile_message';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`message_id` int(11) unsigned NOT NULL AUTO_INCREMENT",
        			"`sender_id` int(11) NOT NULL DEFAULT '0'",
        			"`sender_admin` tinyint(1) NOT NULL DEFAULT '0'",
        			"`receiver_id` int(11) NOT NULL DEFAULT '0'",
        			"`receiver_admin` tinyint(1) NOT NULL DEFAULT '0'",
        			"`send_time` int(11) unsigned NOT NULL DEFAULT '0'",
        			"`read_time` int(11) unsigned NOT NULL DEFAULT '0'",
        			"`readed` tinyint(1) unsigned NOT NULL DEFAULT '0'",
        			"`deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'",
        			"`title` varchar(150) NOT NULL DEFAULT ''",
        			"`message` text NULL",
        			"`message_type` varchar(25) NOT NULL DEFAULT ''",
        			"PRIMARY KEY (`message_id`)",
            	    "KEY `sender_id` (`sender_id`,`receiver_id`)",
            	    "KEY `receiver_id` (`receiver_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
		
        /* 客户端管理*/
        $table_name = 'mobile_manage';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`app_id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`app_name` varchar(100) NOT NULL COMMENT '应用名称'",
                "`bundle_id` varchar(100) NOT NULL DEFAULT '' COMMENT 'app包名'",
                "`app_key` varchar(100) NOT NULL DEFAULT '' COMMENT 'appkey'",
                "`app_secret` varchar(100) NOT NULL DEFAULT '' COMMENT 'AppSecret'",
                "`device_code` char(4) NOT NULL DEFAULT ''",
                "`device_client` char(10) NOT NULL DEFAULT ''",
                "`platform` varchar(50) NOT NULL DEFAULT '' COMMENT '服务平台名称'",
                "`add_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'",
                "`sort` smallint(4) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`app_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 今日头条*/
        $table_name = 'mobile_toutiao';
    	if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`title` varchar(100) NOT NULL",
                "`tag` varchar(20) DEFAULT NULL",
                "`description` varchar(255) DEFAULT NULL",
                "`image` varchar(100) DEFAULT NULL",
                "`content_url` varchar(100) DEFAULT NULL",
                "`sort_order` smallint(4) unsigned NOT NULL DEFAULT '100'",
                "`status` tinyint(1) unsigned NOT NULL DEFAULT '1'",
                "`create_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`update_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 扫码登录*/
        $table_name = 'qrcode_validate';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`user_id` int(40) NOT NULL DEFAULT '0' COMMENT 'user_id'",
        			"`is_admin` bit(1) NOT NULL COMMENT '是否是管理员'",
        			"`uuid` varchar(20) NOT NULL DEFAULT '' COMMENT 'code'",
        			"`status` tinyint(4) NULL COMMENT '状态'",
        			"`expires_in` int(11) NULL COMMENT '有效期'",
        			"`device_udid` char(40) DEFAULT NULL",
        			"`device_client` char(10) DEFAULT NULL",
        			"`device_code` char(4) DEFAULT NULL",
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 签到*/
        $table_name = 'mobile_checkin';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			 "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
					 "`user_id` int(10) unsigned DEFAULT NULL COMMENT '用户id'",
					 "`checkin_time` int(10) unsigned DEFAULT NULL COMMENT '签到时间'",
					 "`integral` int(10) unsigned DEFAULT NULL COMMENT '签到获取积分'",
					 "`source` varchar(20) DEFAULT NULL COMMENT '签到来源'",
					 "PRIMARY KEY (`id`)",
					 "KEY `user_id` (`user_id`)",
					 "KEY `checkin_time` (`checkin_time`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 催单提醒*/
        $table_name = 'order_reminder';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			 "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
					 "`order_id` int(11) NOT NULL",
					 "`message` varchar(255) DEFAULT NULL",
					 "`status` varchar(100) DEFAULT NULL",
					 "`create_time` int(10) NOT NULL DEFAULT '0'",
					 "`confirm_time` int(10) NULL",
        	         " `store_id` int(10) unsigned NOT NULL DEFAULT '0'",
					 "PRIMARY KEY (`id`)",
        	    "KEY `store_id` (`store_id`)",
        	    "KEY `store_order` (`order_id`,`store_id`)",
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /*摇一摇活动表*/
        $table_name = 'mobile_activity';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`activity_id` int(10)  NOT NULL AUTO_INCREMENT",
        			"`activity_name` varchar(20) NOT NULL COMMENT '活动名称'",
        			"`activity_group` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活动组（1、摇一摇）'",
        			"`activity_desc` text NOT NULL COMMENT '活动规则描述'",
        			"`activity_object` int(10) unsigned NOT NULL COMMENT '活动对象（app，pc，touch等）'",
        			"`limit_num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活动限制次数（0为不限制）'",
        			"`limit_time` int(10) NOT NULL DEFAULT '0' COMMENT '多少时间内活动限制（0为在活动时间内，否则多少时间内限制，单位：分钟）'",
        			"`start_time` int(10) unsigned DEFAULT '0' COMMENT '活动开始时间'",
        			"`end_time` int(10) unsigned DEFAULT '0' COMMENT '活动结束时间'",
        			"`add_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间'",
        			"`enabled` tinyint(4) DEFAULT '1' COMMENT '是否使用，1开启，0禁用'",
        			"PRIMARY KEY (`activity_id`)",
        			"KEY `activity_group` (`activity_group`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /*活动日志表*/
        $table_name = 'mobile_activity_log';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		  "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
				  "`activity_id` int(10) unsigned NOT NULL COMMENT '活动id'",
				  "`user_id` int(10) unsigned NOT NULL COMMENT '会员id'",
				  "`username` varchar(25) NOT NULL COMMENT '会员名称'",
				  "`prize_id` int(10) unsigned NOT NULL COMMENT '奖品池id'",
				  "`prize_name` varchar(30) NOT NULL COMMENT '奖品名称'",
				  "`issue_status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '发放状态，0未发放，1发放'",
				  "`issue_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '（奖品）发放时间'",
				  "`issue_extend` text COMMENT '需线下延期发放的扩展信息（序列化）'",
				  "`add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抽奖时间'",
				  "`source` varchar(20) DEFAULT NULL COMMENT '来源（app，touch，pc等）'",
				  "PRIMARY KEY (`id`)",
				  "KEY `activity_id` (`activity_id`)",
				  "KEY `prize_id` (`prize_id`)",
				  "KEY `user_id` (`user_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /*活动奖品表*/
        $table_name = 'mobile_activity_prize';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		  "`prize_id` int(10) unsigned NOT NULL AUTO_INCREMENT",
				  "`activity_id` int(10) unsigned NOT NULL COMMENT '活动id'",
				  "`prize_level` tinyint(4) unsigned DEFAULT '0' COMMENT '奖项等级（从0开始，0为大奖，依此类推）'",
				  "`prize_name` varchar(30) NOT NULL DEFAULT '' COMMENT '奖品名称'",
				  "`prize_type` int(10) unsigned NOT NULL COMMENT '奖品类型'",
				  "`prize_value` varchar(30) NOT NULL DEFAULT '' COMMENT '对应奖品信息（id或数量）'",
				  "`prize_number` int(10) NOT NULL DEFAULT '0' COMMENT '奖品数量（goods与nothing设置无效）'",
				  "`prize_prob` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '奖品数量（概率，总共100%）'",
				  "PRIMARY KEY (`prize_id`)",
				  "KEY `activity_id` (`activity_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        RC_Loader::load_app_class('mobile_method', 'mobile');
        if (!ecjia_config::instance()->check_group('mobile')) {
            ecjia_config::instance()->add_group('mobile', 10);
        }
        
        if (!ecjia::config(mobile_method::STORAGEKEY_discover_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', mobile_method::STORAGEKEY_discover_data, serialize(array()), array('type' => 'hidden'));
        }
        if (!ecjia::config(mobile_method::STORAGEKEY_shortcut_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', mobile_method::STORAGEKEY_shortcut_data, serialize(array()), array('type' => 'hidden'));
        }
        if (!ecjia::config(mobile_method::STORAGEKEY_cycleimage_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', mobile_method::STORAGEKEY_cycleimage_data, serialize(array()), array('type' => 'hidden'));
        }
        if (!ecjia::config(mobile_method::STORAGEKEY_cycleimage_phone_data, ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', mobile_method::STORAGEKEY_cycleimage_phone_data, serialize(array()), array('type' => 'hidden'));
        }
        //应用二维码图片
        if (!ecjia::config('mobile_iphone_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_iphone_qrcode', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        if (!ecjia::config('mobile_ipad_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_ipad_qrcode', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        if (!ecjia::config('mobile_android_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_android_qrcode', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        
        if (!ecjia::config('mobile_launch_adsense', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', 'mobile_launch_adsense', '', array('type' => 'manual'));
        }
        if (!ecjia::config('mobile_tv_adsense_group', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', 'mobile_tv_adsense_group', '', array('type' => 'manual'));
        }
        if (!ecjia::config('mobile_home_adsense_group', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_home_adsense_group', '', array('type' => 'manual'));
        }
        if (!ecjia::config('mobile_recommend_city', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_recommend_city', '', array('type' => 'manual'));
        }
        /* pad 登录页颜色设置*/
        if (!ecjia::config('mobile_pad_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_pad_login_fgcolor', '', array('type' => 'color'));
        }
        if (!ecjia::config('mobile_pad_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_pad_login_bgcolor', '', array('type' => 'color'));
        }
        if (!ecjia::config('mobile_pad_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_pad_login_bgimage', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        /* 手机  登录页颜色设置*/
        if (!ecjia::config('mobile_phone_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_phone_login_fgcolor', '', array('type' => 'color'));
        }
        if (!ecjia::config('mobile_phone_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_phone_login_bgcolor', '', array('type' => 'color'));
        }
        if (!ecjia::config('mobile_phone_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_phone_login_bgimage', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        
        if (!ecjia::config('bonus_readme_url', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'bonus_readme_url', '', array('type' => 'text'));
        }
        if (!ecjia::config('mobile_feedback_autoreply', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_feedback_autoreply', '', array('type' => 'textarea'));
        }
        if (!ecjia::config('mobile_topic_adsense', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_topic_adsense', '', array('type' => 'manual'));
        }
        if (!ecjia::config('mobile_app_icon', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_app_icon', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        
        if (!ecjia::config('checkin_award_open', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_award_open', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('checkin_award_type', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_award_type', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('checkin_award', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_award', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('checkin_extra_day', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_extra_day', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('checkin_extra_award', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_extra_award', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('comment_award_open', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'comment_award_open', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('comment_award', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'comment_award', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('comment_award_rules', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'comment_award_rules', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('order_reminder_type', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'order_reminder_type', 0, array('type' => 'select'));
        }
        
        if (!ecjia::config('order_reminder_value', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'order_reminder_value', '', array('type' => 'hidden'));
        }
        
		/*分享链接*/   
    	if (!ecjia::config('mobile_share_link', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_share_link', '', array('type' => 'text'));
        }
        
        /* 定位范围设置*/
        if (!ecjia::config('mobile_location_range', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_location_range', 3, array('type' => 'text'));
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'mobile_device';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_news';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_message';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_manage';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
    	$table_name = 'mobile_toutiao';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        RC_Loader::load_app_class('mobile_method', 'mobile');
        if (ecjia_config::instance()->check_group('mobile')) {
            ecjia_config::instance()->delete_group('mobile');
        }
        
        if (ecjia::config(mobile_method::STORAGEKEY_discover_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_discover_data);
        }
        if (ecjia::config(mobile_method::STORAGEKEY_shortcut_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_shortcut_data);
        }
        if (ecjia::config(mobile_method::STORAGEKEY_cycleimage_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_cycleimage_data);
        }
        
        if (ecjia::config('mobile_iphone_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_iphone_qr_code');
        }
        if (ecjia::config('mobile_ipad_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_ipad_qr_code');
        }
        if (ecjia::config('mobile_android_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_android_qr_code');
        }
        if (ecjia::config('mobile_launch_adsense', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('mobile_launch_adsense');
        }
        if (ecjia::config('mobile_tv_adsense_group', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('mobile_tv_adsense_group');
        }
        
        if (ecjia::config('mobile_home_adsense_group', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_home_adsense_group');
        }
        if (ecjia::config('mobile_recommend_city', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_recommend_city');
        }
        /* 删除pad 登录页颜色设置*/
        if (ecjia::config('mobile_pad_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_fgcolor');
        }
        if (ecjia::config('mobile_pad_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_bgcolor');
        }
        if (ecjia::config('mobile_pad_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_bgimage');
        }
        /* 删除手机  登录页颜色设置*/
        if (ecjia::config('mobile_phone_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_fgcolor');
        }
        if (ecjia::config('mobile_phone_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_bgcolor');
        }
        if (ecjia::config('mobile_phone_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_bgimage');
        }
        
        if (ecjia::config('bonus_readme_url', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('bonus_readme_url');
        }
        if (ecjia::config('mobile_feedback_autoreply', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_feedback_autoreply');
        }
        if (ecjia::config('mobile_topic_adsense', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_topic_adsense');
        }
        if (ecjia::config('mobile_app_icon', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_app_icon');
        }
        /*分享链接*/
        if (ecjia::config('mobile_share_link', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_share_link');
        }
        
        /*定位范围*/
        if (ecjia::config('mobile_location_range', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_location_range');
        }
        return true;
    }
    
}

// end
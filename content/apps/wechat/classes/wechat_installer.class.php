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

class wechat_installer  extends ecjia_installer {

    protected $dependent = array(
        'ecjia.system'    => '1.0',
    );

    public function __construct() {
        $id = 'ecjia.wechat';
        parent::__construct($id);
    }
    
    
    public function install() {
        $table_name = 'wechat_oauth';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`oauth_redirecturi` varchar(200) NOT NULL DEFAULT ''",
                "`oauth_count` int(8) unsigned NOT NULL DEFAULT '0'",
                "`oauth_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启授权'",
                "`last_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`wechat_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_menu';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`pid` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID'",
                "`name` varchar(255) NOT NULL COMMENT '菜单标题'",
                "`type` varchar(10) NOT NULL COMMENT '菜单的响应动作类型'",
                "`key` varchar(255) NULL COMMENT '菜单KEY值，click类型必须'",
                "`url` varchar(255) NULL COMMENT '网页链接，view类型必须'",
                "`sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'",
                "`status` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '状态'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_reply';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
                "`id` int(10) NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(11) unsigned NOT NULL",
                "`type` varchar(10) NULL COMMENT '自动回复类型'",
                "`content` varchar(255) DEFAULT NULL",
                "`media_id` int(10) DEFAULT NULL",
                "`rule_name` varchar(180) DEFAULT NULL",
                "`add_time` int(11) unsigned NOT NULL DEFAULT '0'",
                "`reply_type` varchar(10) DEFAULT NULL COMMENT '关键词回复内容的类型'",
        	    "PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_rule_keywords';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) NOT NULL AUTO_INCREMENT",
                "`rid` int(11) NULL COMMENT '规则id'",
                "`rule_keywords` varchar(255) DEFAULT NULL",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_user';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`uid` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否订阅该公众号标识'",
                "`openid` varchar(255) NOT NULL COMMENT '用户的标识'",
                "`nickname` varchar(255) NULL COMMENT '用户的昵称'",
                "`sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户的性别'",
                "`city` varchar(255) NULL COMMENT '用户所在城市'",
                "`country` varchar(255) NULL COMMENT '用户所在国家'",
                "`province` varchar(255) NULL COMMENT '用户所在省份'",
                "`language` varchar(50) NULL COMMENT '用户的语言'",
                "`headimgurl` varchar(255) NULL COMMENT '用户头像'",
                "`subscribe_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户关注时间'",
                "`remark` varchar(255) DEFAULT NULL",
                "`privilege` varchar(255) DEFAULT NULL",
                "`unionid` varchar(255) NULL",
                "`group_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户组id'",
                "`ect_uid` int(11) unsigned NULL COMMENT 'ecshop会员id'",
                "`bein_kefu` tinyint(1) unsigned NULL COMMENT '是否处在多客服流程'",
                "PRIMARY KEY (`uid`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
                
        $table_name = 'wechat_qrcode';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) NOT NULL AUTO_INCREMENT",
                "`type` int(1) NOT NULL DEFAULT '0' COMMENT '二维码类型，0临时，1永久'",
                "`expire_seconds` int(4) DEFAULT '0' COMMENT '二维码有效时间'",
                "`scene_id` int(10) NULL COMMENT '场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）'",
                "`username` varchar(60) DEFAULT NULL COMMENT '推荐人'",
                "`function` varchar(255) NULL COMMENT '功能'",
                "`ticket` varchar(255) DEFAULT NULL COMMENT '二维码ticket'",
                "`qrcode_url` varchar(255) DEFAULT NULL COMMENT '二维码路径'",
                "`endtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间'",
                "`scan_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扫描量'",
                "`wechat_id` int(10) NOT NULL",
                "`status` int(1) NOT NULL DEFAULT '1' COMMENT '状态'",
                "`sort` int(10) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        
        $table_name = 'wechat_prize';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(11) unsigned NOT NULL",
                "`openid` varchar(100) NOT NULL",
                "`prize_name` varchar(100) NOT NULL",
                "`issue_status` int(2) NOT NULL DEFAULT '0' COMMENT '发放状态，0未发放，1发放'",
                "`winner` varchar(255) DEFAULT NULL",
                "`dateline` int(11) unsigned NOT NULL DEFAULT '0'",
                "`prize_type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否中奖，0未中奖，1中奖'",
                "`activity_type` varchar(20) NULL COMMENT '活动类型'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_point';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`log_id` mediumint(8) unsigned NOT NULL COMMENT '积分增加记录id'",
                "`openid` varchar(100) DEFAULT NULL",
                "`keywords` varchar(100) NULL COMMENT '关键词'",
                "`createtime` int(11) unsigned NOT NULL DEFAULT '0'"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_media';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) NOT NULL",
                "`title` varchar(255) DEFAULT NULL COMMENT '图文消息标题'",
                "`command` varchar(20) NOT NULL COMMENT '关键词'",
                "`author` varchar(20) DEFAULT NULL",
                "`is_show` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示封面，1为显示，0为不显示'",
                "`digest` varchar(255) DEFAULT NULL COMMENT '图文消息的描述'",
                "`content` text NOT NULL COMMENT '图文消息页面的内容，支持HTML标签'",
                "`link` varchar(255) DEFAULT NULL COMMENT '点击图文消息跳转链接'",
                "`file` varchar(255) DEFAULT NULL COMMENT '图片链接'",
                "`size` int(7) DEFAULT NULL COMMENT '媒体文件上传后，获取时的唯一标识'",
                "`file_name` varchar(255) DEFAULT NULL COMMENT '媒体文件上传时间戳'",
                "`thumb` varchar(255) DEFAULT NULL",
                "`add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间'",
                "`edit_time` int(11) unsigned NOT NULL DEFAULT '0'",
                "`type` varchar(10) DEFAULT NULL",
                "`article_id` varchar(100) DEFAULT NULL",
                "`sort` int(10) unsigned NOT NULL DEFAULT '0'",
            	"`media_id` varchar(255) NOT NULL",
            	"`is_material` varchar(20) NULL",
            	"`media_url` varchar(255) NULL",
            	"`parent_id` int(10) NULL",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_mass_history';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(11) unsigned NOT NULL",
                "`media_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '素材id'",
                "`type` varchar(10) DEFAULT NULL COMMENT '发送内容类型'",
                "`status` varchar(20) DEFAULT NULL COMMENT '发送状态，对应微信通通知状态'",
                "`send_time` int(11) unsigned NOT NULL DEFAULT '0'",
                "`msg_id` varchar(20) DEFAULT NULL COMMENT '微信端返回的消息ID'",
                "`totalcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'group_id下粉丝数；或者openid_list中的粉丝数'",
                "`filtercount` int(10) unsigned NOT NULL DEFAULT '0'",
                "`sentcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送成功的粉丝数'",
                "`errorcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送失败的粉丝数'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_custom_message';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) NOT NULL AUTO_INCREMENT",
                "`uid` int(10) unsigned NOT NULL DEFAULT '0'",
                "`msg` varchar(255) DEFAULT NULL COMMENT '信息内容'",
                "`iswechat` smallint(1) unsigned DEFAULT NULL",
                "`send_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_customer';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		"`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT",
        		"`wechat_id` int(10) UNSIGNED NOT NULL DEFAULT '0'",
        		"`kf_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客服工号'",
        		"`kf_account` VARCHAR(100) NOT NULL COMMENT '完整客服账号'",
        		"`kf_nick` VARCHAR(100) NULL COMMENT '客服昵称'",
        		"`kf_headimgurl` VARCHAR(255) NULL COMMENT '客服头像'",
        		"`status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客服状态'",
        		"`online_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客服在线状态'",
        		"`accepted_case` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客服当前正在接待的会话数'",
        		"`kf_wx` VARCHAR(200) NOT NULL",
        		"`invite_wx` VARCHAR(200) NULL",
        		"`invite_expire_time` int(10) NOT NULL DEFAULT '0'",
        		"`invite_status` VARCHAR(100) NULL",
        		"`file_url` VARCHAR(255) NULL",
        		"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_customer_session';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		"`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT",
        		"`wechat_id` int(10) UNSIGNED NOT NULL DEFAULT '0'",
        		"`kf_account` VARCHAR(255) NOT NULL COMMENT '客服账号'",
        		"`openid` VARCHAR(255) NOT NULL COMMENT '用户openid'",
        		"`opercode` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会话状态'",
        		"`text` VARCHAR(255) NOT NULL COMMENT '发送内容'",
        		"`time` int(11) UNSIGNED NOT NULL COMMENT '发送时间'",
        		"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_request_times';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`day` date NOT NULL COMMENT '日期'",
                "`api_name` varchar(60) NOT NULL COMMENT 'Api名称'",
                "`times` int(10) NULL COMMENT '限制次数'",
                "`last_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后请求时间'",
                "PRIMARY KEY (`id`)",
                "UNIQUE KEY `day` (`day`,`api_name`,`wechat_id`)",
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_tag';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		"`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
        		"`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
        		"`tag_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签id'",
        		"`name` varchar(255) NOT NULL COMMENT '标签名字'",
        		"`count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签内用户数量'",
        		"`sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'",
        		"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_user_tag';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		"`userid` int(10) unsigned NOT NULL DEFAULT '0'",
        		"`tagid` int(10) unsigned NOT NULL DEFAULT '0'",
        		"KEY `userid` (`userid`)",
        		"KEY `tagid` (`tagid`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'wechat_oauth';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_menu';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_reply';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_rule_keywords';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_user';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_qrcode';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_prize';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_point';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_media';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_mass_history';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_custom_message';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_customer';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_customer_session';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_request_times';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_tag';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_user_tag';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        return true;
    }
    
}

// end
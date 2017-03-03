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

class platform_installer  extends ecjia_installer {

    protected $dependent = array(
        'ecjia.system'    => '1.0',
    );

    public function __construct() {
        $id = 'ecjia.platform';
        parent::__construct($id);
    }
    
    public function install() {
        $table_name = 'platform_account';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`uuid` varchar(60) NOT NULL COMMENT '唯一标识'",
                "`platform` varchar(30) NULL DEFAULT '' COMMENT '平台'",
                "`type` int(1) unsigned NULL DEFAULT '0' COMMENT '公众号类型'",
                "`shop_id` int(10) NOT NULL DEFAULT '0'",
                "`name` varchar(100) NOT NULL COMMENT '公众号名称'",
                "`logo` varchar(100) DEFAULT ''",
                "`token` varchar(100) NOT NULL DEFAULT '' COMMENT 'Token'",
                "`aeskey` varchar(100) NOT NULL DEFAULT ''",
                "`appid` varchar(100) NOT NULL DEFAULT '' COMMENT 'AppID'",
                "`appsecret` varchar(100) NOT NULL DEFAULT '' COMMENT 'AppSecret'",
                "`add_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'",
                "`status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'",
                "PRIMARY KEY (`id`)",
                "UNIQUE KEY `uuid` (`uuid`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'platform_command';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`cmd_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT",
                "`cmd_word` varchar(20) DEFAULT NULL COMMENT '关键字'",
                "`account_id` int(10) NOT NULL",
                "`platform` varchar(30) NOT NULL DEFAULT '' COMMENT '平台'",
                "`ext_code` varchar(30) NOT NULL DEFAULT '' COMMENT '插件标识符'",
                "`sub_code` varchar(30) NOT NULL DEFAULT '' COMMENT '子命令'",
                "PRIMARY KEY (`cmd_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'platform_extend';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
                "`ext_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '扩展id'",
                "`ext_name` varchar(120) NOT NULL DEFAULT '' COMMENT '扩展名称'",
                "`ext_desc` text NULL COMMENT '扩展描述'",
                "`ext_code` varchar(30) NOT NULL DEFAULT '' COMMENT '扩展关键字'",
                "`ext_config` text NULL COMMENT '扩展配置'",
                "`enabled` tinyint(4) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否安装，1开启，0禁用'",
                "PRIMARY KEY (`ext_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'platform_config';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`account_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'",
                "`ext_code` VARCHAR(30) NOT NULL DEFAULT '' COMMENT '扩展关键字'",
                "`ext_config` TEXT NULL COMMENT '扩展配置'",
                "PRIMARY KEY (`account_id`, `ext_code`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        return true;
    }
    
    public function uninstall() {
        $table_name = 'platform_account';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'platform_command';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'platform_extend';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'platform_config';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        return true;
    }
}

// end
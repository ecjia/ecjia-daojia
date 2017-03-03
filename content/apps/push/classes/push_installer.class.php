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

class push_installer extends ecjia_installer {
    
    protected $dependent = array(
    	'ecjia.system' => '1.0',
    );
    
    public function __construct() {
        $id = 'ecjia.push';
        parent::__construct($id);
    }
    
    
    public function install() {
        $table_name = 'push_message';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
            	"`message_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT",
            	"`app_id` int(10) unsigned NOT NULL",
                "`device_token` CHAR(64) NOT NULL DEFAULT ''",
                "`device_client` CHAR(10) NULL",
                "`title` VARCHAR(150) NOT NULL",
                "`content` VARCHAR(255) NOT NULL DEFAULT ''",
                "`add_time` INT(10) NOT NULL DEFAULT '0'",
                "`push_time` INT(10) NOT NULL DEFAULT '0'",
                "`push_count` TINYINT(1) NOT NULL DEFAULT '0'",
                "`template_id` MEDIUMINT(8) NULL",
                "`in_status` TINYINT(1) NOT NULL DEFAULT '0'",
                "`extradata` TEXT NULL",
                "PRIMARY KEY (`message_id`)"
            );
            
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'push_event';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`event_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息事件id'",
        			"`event_code` varchar(60) NOT NULL DEFAULT '' COMMENT '消息事件code'",
        			"`event_name` varchar(60) NOT NULL DEFAULT '' COMMENT '消息事件名称'",
        			"`app_id` int(10) unsigned NULL COMMENT '客户端设备id'",
        			"`template_id` int(10) unsigned NULL COMMENT '模板id'",
        			"`is_open` tinyint(3) NOT NULL COMMENT '是否启用'",
        			"`create_time` int(100) unsigned NOT NULL DEFAULT '0'",
        			"PRIMARY KEY (`event_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        if (!ecjia::config('app_name', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_name', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_push_development', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_push_development', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('app_key_android', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_key_android', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_secret_android', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_secret_android', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_key_iphone', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_key_iphone', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_secret_iphone', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_secret_iphone', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_key_ipad', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_key_ipad', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_secret_ipad', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_secret_ipad', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('push_user_signin', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'push_user_signin', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('push_order_shipped', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'push_order_shipped', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('push_order_payed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'push_order_payed', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('push_order_placed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'push_order_placed', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'push_message';
        if (RC_Model::make()->table_exists($table_name)) {
           RC_Model::make()->drop_table($table_name);
        }
        
        if (ecjia::config('app_name', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_name');
        }
        if (ecjia::config('app_push_development', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_push_development');
        }
        if (ecjia::config('app_key_android', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_key_android');
        }
        if (ecjia::config('app_secret_android', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_secret_android');
        }
        if (ecjia::config('app_key_iphone', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_key_iphone');
        }
        if (ecjia::config('app_secret_iphone', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_secret_iphone');
        }
        if (ecjia::config('app_key_ipad', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_key_ipad');
        }
        if (ecjia::config('app_secret_ipad', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_secret_ipad');
        }
        
        if (ecjia::config('push_user_signin', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('push_user_signin');
        }
        if (ecjia::config('push_order_shipped', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('push_order_shipped');
        }
        if (ecjia::config('push_order_payed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('push_order_payed');
        }
        if (ecjia::config('push_order_placed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('push_order_placed');
        }
        
        return true;
    }
}

// end
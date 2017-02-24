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
 * ecjia 系统升级类
 * @author royalwang
 *
 */
class ecjia_upgrade_db {
    
    const STORAGEKEY_db_version = 'ecjia_db_version';
    
    const current_db_version = 5;
    
    public static function initialization() {
        if (!ecjia::config(self::STORAGEKEY_db_version, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', self::STORAGEKEY_db_version, '0', array('type' => 'hidden'));
        }
        
        self::db_init_1();
        self::db_init_2();
        self::db_init_3();
        self::db_init_4();
        self::db_init_5();
        
        if (self::current_db_version > ecjia::config(self::STORAGEKEY_db_version)) {
            ecjia_config::instance()->write_config(self::STORAGEKEY_db_version, self::current_db_version);
        }
    }
    
    
    private static function db_init_1() {
        if (ecjia::config(self::STORAGEKEY_db_version, ecjia::CONFIG_CHECK) && ecjia::config(self::STORAGEKEY_db_version) >= 1) {
            return ;
        }
        
        $table_name = 'term_relationship';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`relation_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT",
                "`object_type` char(30) NOT NULL DEFAULT ''",
                "`object_group` char(30) NOT NULL DEFAULT ''",
                "`object_id` int(11) NOT NULL",
                "`item_key1` varchar(60) DEFAULT NULL",
                "`item_value1` varchar(60) DEFAULT NULL",
                "`item_key2` varchar(60) DEFAULT NULL",
                "`item_value2` varchar(60) DEFAULT NULL",
                "`item_key3` varchar(60) DEFAULT NULL",
                "`item_value3` varchar(60) DEFAULT NULL",
                "`item_key4` varchar(60) DEFAULT NULL",
                "`item_value4` varchar(60) DEFAULT NULL",
                "PRIMARY KEY (`relation_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
    }
    
    private static function db_init_2() {
        if (ecjia::config(self::STORAGEKEY_db_version, ecjia::CONFIG_CHECK) && ecjia::config(self::STORAGEKEY_db_version) >= 2) {
            return ;
        }
        
        $table_name = 'term_meta';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT",
                "`object_type` char(30) NOT NULL DEFAULT ''",
                "`object_group` char(30) NOT NULL DEFAULT ''",
                "`object_id` int(11) NOT NULL",
                "`meta_key` varchar(255) NOT NULL DEFAULT ''",
                "`meta_value` longtext",
                "PRIMARY KEY (`meta_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
    }
    
    private static function db_init_3() {
        if (ecjia::config(self::STORAGEKEY_db_version, ecjia::CONFIG_CHECK) && ecjia::config(self::STORAGEKEY_db_version) >= 3) {
            return ;
        }
        
        $table_name = 'admin_log';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`log_id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`log_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`user_id` tinyint(3) unsigned NOT NULL DEFAULT '0'",
                "`log_info` varchar(255) NOT NULL DEFAULT ''",
                "`ip_address` varchar(15) NOT NULL DEFAULT ''",
                "PRIMARY KEY (`log_id`)",
                "KEY `log_time` (`log_time`)",
                "KEY `user_id` (`user_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'admin_user';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`user_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT",
                "`user_name` varchar(60) NOT NULL DEFAULT ''",
                "`email` varchar(60) NOT NULL DEFAULT ''",
                "`password` varchar(32) NOT NULL DEFAULT ''",
                "`ec_salt` varchar(10) DEFAULT NULL",
                "`add_time` int(11) NOT NULL DEFAULT '0'",
                "`last_login` int(11) NOT NULL DEFAULT '0'",
                "`last_ip` varchar(15) NOT NULL DEFAULT ''",
                "`action_list` text NOT NULL",
                "`nav_list` text NOT NULL",
                "`lang_type` varchar(50) NOT NULL DEFAULT ''",
                "`agency_id` smallint(5) unsigned NOT NULL",
                "`suppliers_id` smallint(5) unsigned DEFAULT '0'",
                "`todolist` longtext",
                "`role_id` smallint(5) DEFAULT NULL",
                "PRIMARY KEY (`user_id`)",
                "KEY `user_name` (`user_name`)",
                "KEY `agency_id` (`agency_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'admin_message';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`message_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT",
                "`sender_id` tinyint(3) unsigned NOT NULL DEFAULT '0'",
                "`receiver_id` tinyint(3) unsigned NOT NULL DEFAULT '0'",
                "`sent_time` int(11) unsigned NOT NULL DEFAULT '0'",
                "`read_time` int(11) unsigned NOT NULL DEFAULT '0'",
                "`readed` tinyint(1) unsigned NOT NULL DEFAULT '0'",
                "`deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'",
                "`title` varchar(150) NOT NULL DEFAULT ''",
                "`message` text NOT NULL",
                "PRIMARY KEY (`message_id`)",
                "KEY `sender_id` (`sender_id`,`receiver_id`)",
                "KEY `receiver_id` (`receiver_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'nav';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` mediumint(8) NOT NULL AUTO_INCREMENT",
                "`ctype` varchar(10) DEFAULT NULL",
                "`cid` smallint(5) unsigned DEFAULT NULL",
                "`name` varchar(255) NOT NULL",
                "`ifshow` tinyint(1) NOT NULL",
                "`vieworder` tinyint(1) NOT NULL",
                "`opennew` tinyint(1) NOT NULL",
                "`url` varchar(255) NOT NULL",
                "`type` varchar(10) NOT NULL",
                "PRIMARY KEY (`id`)",
                "KEY `type` (`type`)",
                "KEY `ifshow` (`ifshow`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'region';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT",
                "`parent_id` smallint(5) unsigned NOT NULL DEFAULT '0'",
                "`region_name` varchar(120) NOT NULL DEFAULT ''",
                "`region_type` tinyint(1) NOT NULL DEFAULT '2'",
                "`agency_id` smallint(5) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`region_id`)",
                "KEY `parent_id` (`parent_id`)",
                "KEY `region_type` (`region_type`)",
                "KEY `agency_id` (`agency_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'role';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT",
                "`role_name` varchar(60) NOT NULL DEFAULT ''",
                "`action_list` text NOT NULL",
                "`role_describe` text",
                "PRIMARY KEY (`role_id`)",
                "KEY `user_name` (`role_name`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'sessions';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`sesskey` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT ''",
                "`expiry` int(10) unsigned NOT NULL DEFAULT '0'",
                "`userid` mediumint(8) unsigned NOT NULL DEFAULT '0'",
                "`adminid` mediumint(8) unsigned NOT NULL DEFAULT '0'",
                "`ip` char(15) NOT NULL DEFAULT ''",
                "`user_name` varchar(60) NOT NULL",
                "`user_rank` tinyint(3) NOT NULL",
                "`discount` decimal(3,2) NOT NULL",
                "`email` varchar(60) NOT NULL",
                "`data` char(255) NOT NULL DEFAULT ''",
                "PRIMARY KEY (`sesskey`)",
                "KEY `expiry` (`expiry`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'sessions_data';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`sesskey` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT ''",
                "`expiry` int(10) unsigned NOT NULL DEFAULT '0'",
                "`data` longtext NOT NULL",
                "PRIMARY KEY (`sesskey`)",
                "KEY `expiry` (`expiry`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'shop_config';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT",
                "`parent_id` smallint(5) unsigned NOT NULL DEFAULT '0'",
                "`code` varchar(30) NOT NULL DEFAULT ''",
                "`type` varchar(10) NOT NULL DEFAULT ''",
                "`store_range` varchar(255) NOT NULL DEFAULT ''",
                "`store_dir` varchar(255) NOT NULL DEFAULT ''",
                "`value` text NOT NULL",
                "`sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1'",
                "PRIMARY KEY (`id`)",
                "UNIQUE KEY `code` (`code`)",
                "KEY `parent_id` (`parent_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }

    }
    
    private static function db_init_4() {
        if (ecjia::config(self::STORAGEKEY_db_version, ecjia::CONFIG_CHECK) && ecjia::config(self::STORAGEKEY_db_version) >= 4) {
            return ;
        }
        
        $table_name = 'sites';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` bigint(20) NOT NULL AUTO_INCREMENT",
                "`domain` varchar(200) NOT NULL DEFAULT ''",
                "`path` varchar(100) NOT NULL DEFAULT ''",
                "PRIMARY KEY (`id`)",
                "KEY `domain` (`domain`(140),`path`(51))",
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'site_options';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT",
                "`site_id` bigint(20) NOT NULL DEFAULT '0'",
                "`option_name` varchar(200) NOT NULL DEFAULT ''",
                "`option_value` longtext NOT NULL",
                "`autoload` varchar(20) NOT NULL DEFAULT 'yes'",
                "PRIMARY KEY (`option_id`)",
                "UNIQUE KEY `option_name` (`option_name`(191))",
                "KEY `site_id` (`site_id`)",
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }     
    }
    
    private static function db_init_5() {
        if (ecjia::config(self::STORAGEKEY_db_version, ecjia::CONFIG_CHECK) && ecjia::config(self::STORAGEKEY_db_version) >= 5) {
            return ;
        }
        
        $table_name = 'template_widget';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''",
                "`filename` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT ''",
                "`region` varchar(40) CHARACTER SET utf8mb4 NOT NULL DEFAULT ''",
                "`library` varchar(40) CHARACTER SET utf8mb4 NOT NULL DEFAULT ''",
                "`sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0'",
                "`type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'",
                "`title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL",
                "`theme` varchar(60) CHARACTER SET utf8mb4 NOT NULL",
                "`widget_config` text COLLATE utf8mb4_unicode_ci",
                "`remarks` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT ''",
                "PRIMARY KEY (`id`)",
                "KEY `filename` (`filename`,`region`)",
                "KEY `theme` (`theme`)",
                "KEY `remarks` (`remarks`)",
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
    }
}

// end
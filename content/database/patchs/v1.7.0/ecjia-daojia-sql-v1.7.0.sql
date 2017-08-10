# ************************************************************
#
#    ______         ______           __         __         ______
#   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
#   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
#    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
#     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
#
#   上海商创网络科技有限公司
#
#  ---------------------------------------------------------------------------------
#
#   一、协议的许可和权利
#
#    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
#    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
#    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
#       法律义务；
#    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
#       指定的方式获得指定范围内的技术支持服务；
#
#   二、协议的约束和限制
#
#    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
#       以及以盈利为目的或实现盈利产品）；
#    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
#       方版本用于重新开发；
#    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
#
#   三、有限担保和免责声明
#
#    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
#    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
#       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
#    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
#       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
#
#   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
#   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
#   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
#   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
#   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
#   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
#
#  ---------------------------------------------------------------------------------
#
# ECJia到家数据库更新脚本v1.7.0
# 
# 2017-08-04
# ************************************************************

-- 新增用户发票表
CREATE TABLE `ecjia_finance_invoice` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` int (10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
	`title_name` VARCHAR(60) NOT NULL COMMENT '抬头名称',
	`title_type` VARCHAR(20) NOT NULL DEFAULT 'PERSONAL' COMMENT '抬头类型: PERSONAL（个人） CORPORATION（单位）',
	`user_mobile` VARCHAR(20) NOT NULL DEFAULT '0' COMMENT '电话号码',
    `tax_register_no` VARCHAR(60)  NOT NULL DEFAULT ''  COMMENT '纳税人识别号',
	`user_address` VARCHAR(100) NULL DEFAULT NULL COMMENT '详细地址',
	`open_bank_name` VARCHAR(100) NULL DEFAULT NULL COMMENT '开户银行',
	`open_bank_account` VARCHAR(100) NULL DEFAULT NULL COMMENT '银行账号',	
	`add_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
	`update_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
	`is_default` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0非默认，1默认',
    `status` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 待审核，1 审核通过',
	PRIMARY KEY (`id`),
	INDEX `user_id` (`user_id`),
	INDEX `status` (`status`),
	INDEX `user_mobile` (`user_mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 新增客户端配置选项表
CREATE TABLE `ecjia_mobile_options` (
	`option_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`platform` VARCHAR(60) NULL DEFAULT NULL COMMENT '平台',
	`app_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '默认0，取平台配置',
	`option_name` VARCHAR(120) NOT NULL DEFAULT '' COMMENT '选项名称',
	`option_type` VARCHAR(60) NULL DEFAULT NULL COMMENT '值类型，用于解析数据',
	`option_value` TEXT NULL COMMENT '选项值',
	PRIMARY KEY (`option_id`),
	UNIQUE INDEX `platform` (`platform`, `app_id`, `option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 新增地区管理表
CREATE TABLE `ecjia_region_cn` (
  `region_id` varchar(20) NOT NULL COMMENT '地区码',
  `parent_id` varchar(20) NOT NULL COMMENT '上级区域编码',
  `region_name` varchar(120) NOT NULL COMMENT '区域名称',
  `region_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '区域类型（1省2市3区4街道）',
  `index_letter` char(1) DEFAULT NULL COMMENT '拼音首字母',
  `country` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CN',
  PRIMARY KEY (`region_id`),
  KEY `parent_id` (`parent_id`),
  KEY `region_type` (`region_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 优化推送记录表
DROP TABLE IF EXISTS `ecjia_push_message`;
CREATE TABLE `ecjia_push_message` (
  `message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `device_code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_token` text COLLATE utf8mb4_unicode_ci COMMENT '可多个批量发送，逗号分隔',
  `device_client` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content_params` text COLLATE utf8mb4_unicode_ci COMMENT '内容变量参数',
  `add_time` int(10) NOT NULL DEFAULT '0',
  `push_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后发送时间',
  `push_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '发送次数',
  `template_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模板ID',
  `in_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `extradata` text COLLATE utf8mb4_unicode_ci COMMENT '扩展数据',
  `priority` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0 延迟发送，1 优先发送',
  `last_error_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '最后一次错误消息',
  `msgid` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '厂商消息ID',
  `channel_code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '推送消息渠道代码',
  PRIMARY KEY (`message_id`),
  KEY `device_code` (`device_code`),
  KEY `channel_code` (`channel_code`),
  KEY `priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 优化用户关联表
ALTER TABLE `ecjia_connect_user` ADD `user_type` VARCHAR(30)  NOT NULL  DEFAULT 'user'  AFTER `user_id`;
ALTER TABLE `ecjia_connect_user` MODIFY `connect_code` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `ecjia_connect_user` MODIFY `open_id` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `ecjia_connect_user` MODIFY `refresh_token` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `ecjia_connect_user` MODIFY `access_token` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 添加商家入驻有效期
ALTER TABLE `ecjia_store_franchisee`
ADD COLUMN `expired_time`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '过期时间' AFTER `confirm_time`;


-- 调整支付流水记录，记录更多信息
ALTER TABLE `ecjia_payment_record` DROP INDEX `order_sn`;
ALTER TABLE `ecjia_payment_record` ADD `order_trade_no` VARCHAR(60)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci NULL AFTER `order_sn`;
ALTER TABLE `ecjia_payment_record` ADD `partner_id` VARCHAR(60)  NULL  COMMENT '商户号'  AFTER `pay_time`;
ALTER TABLE `ecjia_payment_record` ADD `account` VARCHAR(60)  NULL  COMMENT '收款帐号'  AFTER `partner_id`;
ALTER TABLE `ecjia_payment_record` CHANGE `order_sn` `order_sn` VARCHAR(30)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NOT NULL  DEFAULT '';
ALTER TABLE `ecjia_payment_record` ADD INDEX (`order_trade_no`);
ALTER TABLE `ecjia_payment_record` ADD INDEX (`order_sn`);

-- 优化短信发送记录表
ALTER TABLE `ecjia_sms_sendlist`
MODIFY COLUMN `msgid`  varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '短信厂商的消息ID' AFTER `last_send`;


-- 更新广告客户端类型值
UPDATE `ecjia_ad` SET `show_client` = 3 WHERE `show_client` = 17;
UPDATE `ecjia_ad` SET `show_client` = 7 WHERE `show_client` = 273;
UPDATE `ecjia_ad` SET `show_client` = 8 WHERE `show_client` = 4096;

UPDATE `ecjia_merchants_ad` SET `show_client` = 3 WHERE `show_client` = 17;
UPDATE `ecjia_merchants_ad` SET `show_client` = 7 WHERE `show_client` = 273;
UPDATE `ecjia_merchants_ad` SET `show_client` = 8 WHERE `show_client` = 4096;


-- 更新门店模式设置
INSERT INTO `ecjia_shop_config` (`parent_id`, `code`, `type`, `sort_order`) VALUES (6, 'store_model', 'text', 1);
-- 增加地区同步设置	
INSERT INTO `ecjia_shop_config` (`parent_id`, `code`, `type`, `sort_order`) VALUES (6, 'region_cn_version', 'text', 1);
INSERT INTO `ecjia_shop_config` (`parent_id`, `code`, `type`, `sort_order`) VALUES (6, 'region_last_checktime', 'text', 1);
-- 移除废弃的配置项
DELETE FROM `ecjia_shop_config` WHERE `code`='map_baidu_key';
DELETE FROM `ecjia_shop_config` WHERE `code`='map_baidu_referer';
DELETE FROM `ecjia_shop_config` WHERE `code`='push_order_placed_apps';
DELETE FROM `ecjia_shop_config` WHERE `code`='push_order_placed';
DELETE FROM `ecjia_shop_config` WHERE `code`='push_order_payed_apps';
DELETE FROM `ecjia_shop_config` WHERE `code`='push_order_payed';
DELETE FROM `ecjia_shop_config` WHERE `code`='push_order_shipped_apps';
DELETE FROM `ecjia_shop_config` WHERE `code`='push_order_shipped';
DELETE FROM `ecjia_shop_config` WHERE `code`='push_user_signin';
DELETE FROM `ecjia_shop_config` WHERE `code`='app_push_development';


-- 更新已经入驻的商家有效期
UPDATE ecjia_store_franchisee SET expired_time = confirm_time + 31536000 WHERE confirm_time > 0 AND expired_time = 0;


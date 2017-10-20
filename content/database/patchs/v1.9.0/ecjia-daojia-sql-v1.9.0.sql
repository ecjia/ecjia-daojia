# ************************************************************
#
# 到家数据库更新脚本v1.9
# 
# 2017-09-27
# ************************************************************

-- 新增闪惠规则表
CREATE TABLE `ecjia_quickpay_activity` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`store_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '商家店铺ID',
	`title` VARCHAR(100) NOT NULL COMMENT '闪惠标题 ',
	`description` VARCHAR(255) NULL DEFAULT NULL COMMENT '闪惠描述',
	`quickpay_type` VARCHAR(60) NOT NULL DEFAULT 'quickpay' COMMENT '闪惠类型',
	`activity_type` VARCHAR(60) NOT NULL DEFAULT 'normal' COMMENT 'normal无优惠, discount价格折扣, everyreduced每满多少减多少,最高减多少, reduced满多少减多少',
	`activity_value` VARCHAR(255) NULL DEFAULT NULL COMMENT ' 活动参数配置 1、空 2、90为9折 3、500,200 4、100,10,50',
	`limit_time_type` VARCHAR(60) NOT NULL DEFAULT 'nolimit' COMMENT '限制时间类型类型说明：nolimit不限制时间, customize自定义时间',
	`limit_time_weekly` INT(11) NOT NULL DEFAULT '0' COMMENT '每周星期0b1111111代表7天',
	`limit_time_daily` TEXT NULL DEFAULT NULL COMMENT '每天时间段' COLLATE 'utf8mb4_unicode_ci',
	`limit_time_exclude` TEXT NULL DEFAULT NULL COMMENT '排除日期 逗号分隔存储，如2017-01-01,2017-02-01,',
	`start_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '闪惠规则开始时间',
	`end_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '闪惠规则结束时间',
	`use_integral` VARCHAR(60) NOT NULL DEFAULT 'close' COMMENT '使用最大积分多少 类型说明：close 不能使用，nolimit 不限使用，20（数字）最大可用积分',
	`use_bonus` VARCHAR(200) NOT NULL DEFAULT 'close' COMMENT '允许使用红包类型，逗号分隔存储，类型说明：close 不能使用， nolimit 不限使用， 红包id，指定使用',
	`enabled` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 关闭，1 开启',
	PRIMARY KEY (`id`),
	INDEX `store_id` (`store_id`),
	INDEX `quickpay_type` (`quickpay_type`),
	INDEX `activity_type` (`activity_type`),
	INDEX `limit_time_type` (`limit_time_type`),
	INDEX `limit_time_weekly` (`limit_time_weekly`),
	INDEX `enabled` (`enabled`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- 新增闪惠订单表
CREATE TABLE `ecjia_quickpay_orders` (
	`order_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`order_sn` VARCHAR(30) NOT NULL COMMENT '订单编号' COLLATE 'utf8mb4_unicode_ci',
	`order_type` VARCHAR(60) NOT NULL COMMENT '订单类型' COLLATE 'utf8mb4_unicode_ci',
	
	`store_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '店铺id',
	`add_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '买单时间',
	`activity_type` VARCHAR(60) NULL DEFAULT NULL COMMENT '优惠类型' COLLATE 'utf8mb4_unicode_ci',
	`activity_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '闪惠活动id',
	
	`user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
	`user_type` VARCHAR(60) NULL DEFAULT NULL COMMENT '用户类型' COLLATE 'utf8mb4_unicode_ci',
	`user_name` VARCHAR(60) NULL DEFAULT NULL COMMENT '购买人姓名' COLLATE 'utf8mb4_unicode_ci',
	`user_mobile` VARCHAR(60) NULL DEFAULT NULL COMMENT '购买人电话' COLLATE 'utf8mb4_unicode_ci',
	
	`goods_amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '消费金额',
	`discount` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '闪惠金额',
	`integral` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分数量',
	`integral_money` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分金额',
	`surplus` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额使用',
	`bonus` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '红包抵扣',
	`bonus_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '红包id',
	`order_amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付金额',
	
	`order_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0未确认1已确认',
	
	`pay_code` VARCHAR(60) NULL DEFAULT NULL COMMENT '支付代号' COLLATE 'utf8mb4_unicode_ci',
	`pay_name` VARCHAR(60) NULL DEFAULT NULL COMMENT '支付名称' COLLATE 'utf8mb4_unicode_ci',
	`pay_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付时间',
	`pay_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '支付状态 0未支付1已支付',
	
	`verification_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '核销时间',
	`verification_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '核销状态 0未核销1已核销',
	
	`referer` VARCHAR(255) NULL DEFAULT NULL COMMENT '订单来源' COLLATE 'utf8mb4_unicode_ci',
	`from_ad` VARCHAR(20) NULL DEFAULT NULL COMMENT '订单由某广告带来的广告id' COLLATE 'utf8mb4_unicode_ci',
	
	PRIMARY KEY (`order_id`),
	UNIQUE INDEX `order_sn` (`order_sn`),
	UNIQUE INDEX `store_order` (`order_id`, `store_id`),
	INDEX `store_id` (`store_id`),
	INDEX `user_id` (`user_id`),
	INDEX `pay_code` (`pay_code`),
	INDEX `activity_type` (`activity_type`),
	INDEX `activity_id` (`activity_id`)
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 新增闪惠订单日志表
CREATE TABLE `ecjia_quickpay_order_action` (
	`action_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`order_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属订单',
	`action_user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作者用户id',
	`action_user_name` VARCHAR(60) NULL DEFAULT NULL COMMENT '操作者用户名称',
	`action_user_type` VARCHAR(60) NULL DEFAULT NULL COMMENT '操作用户类型',
	`order_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '订单状态 0未确认1已确认',
	`pay_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '支付状态 0未支付1已支付',
	`verification_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '核销状态 0未核销1已核销',
	`action_note` VARCHAR(255) NULL DEFAULT NULL COMMENT '操作备注',
	`add_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作时间',
	PRIMARY KEY (`action_id`),
	INDEX `order_id` (`order_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 创建收银员操作订单日志表
CREATE TABLE `ecjia_cashier_record` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`store_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`staff_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`order_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`order_type` varchar(60)  NOT NULL COMMENT 'ecjia-cashdesk收银台',
	`mobile_device_id` int(10)  NOT NULL DEFAULT '0' COMMENT '对应mobile_device表的id',
	`device_sn` varchar(60) NOT NULL COMMENT '设备号',
	`device_type` varchar(60) NOT NULL COMMENT 'ecjia-cashdesk收银台',
	`action` varchar(60) NOT NULL COMMENT 'billing开单，receipt收款，check_order验单',
	`create_at` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	INDEX `store_id` (`store_id`),
	INDEX `staff_id` (`staff_id`),
	INDEX `mobile_device_id` (`mobile_device_id`),
	INDEX `order_id` (`order_id`, `order_type`),
	INDEX `device_sn` (`device_sn`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 收银设备表
CREATE TABLE `ecjia_cashier_device` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`store_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`device_name` VARCHAR(100) NOT NULL DEFAULT '',
	`device_mac` VARCHAR(100) NOT NULL DEFAULT 'MAC',
	`device_sn` varchar(100) NOT NULL COMMENT 'SN',
	`device_type` varchar(50)  NOT NULL COMMENT '机型',
	`product_sn` varchar(100) NOT NULL COMMENT '设备号',
	`keyboard_sn` varchar(50) NOT NULL COMMENT '密码键盘序列号',
	`status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
	`add_time` INT(10) NOT NULL  COMMENT '添加时间',
	`update_time` INT(10) NOT NULL COMMENT '更新时间',
	PRIMARY KEY (`id`),
	INDEX `store_id` (`store_id`),
	INDEX `device_sn` (`device_sn`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 计划任务作业表
CREATE TABLE `ecjia_cron_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `return` text COLLATE utf8mb4_unicode_ci,
  `runtime` float NOT NULL,
  `cron_manager_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`cron_manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 计划任务管理表
CREATE TABLE `ecjia_cron_manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rundate` datetime NOT NULL,
  `runtime` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 重新创建新的计划任务插件表
DROP TABLE IF EXISTS `ecjia_crons`;
CREATE TABLE `ecjia_crons` (
  `cron_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `cron_code` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `cron_name` varchar(120) CHARACTER SET utf8mb4 NOT NULL,
  `cron_desc` text CHARACTER SET utf8mb4,
  `cron_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cron_config` text CHARACTER SET utf8mb4,
  `cron_expression` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '表达式',
  `expression_alias` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '别名',
  `runtime` int(10) DEFAULT NULL,
  `nexttime` int(10) DEFAULT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `run_once` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `allow_ip` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`cron_id`),
  KEY `nextime` (`nexttime`),
  KEY `cron_code` (`cron_code`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 增加闪付规则
INSERT INTO `ecjia_shop_config` (`parent_id`, `code`, `type`, `value`) 
VALUES (6, 'quickpay_rule', 'text', '1、优惠买单仅限于到店消费后使用，请勿提前支付；\r\n
2、请在输入买单金额前与商家确认门店信息和消费金额；\r\n
3、遇节假日能否享受优惠，请详细咨询商家；\r\n
4、请咨询商家能否与店内其他优惠同享；\r\n
5、如需发票，请您在消费时向商家咨询。');

-- shop_config 增加code quickpay_fee 闪惠手续费设置
INSERT INTO `ecjia_shop_config` (`parent_id`, `code`, `type`, `sort_order`) VALUES (6, 'quickpay_fee', 'text', 1);

-- shop_config 增加code cron_secret_key 计划任务秘钥
INSERT INTO `ecjia_shop_config` (`parent_id`, `code`, `type`, `sort_order`) VALUES (6, 'cron_secret_key', 'text', 1);

-- shop_config 增加code merchant_join_close 是否关闭入驻商加盟
INSERT INTO `ecjia_shop_config` (`parent_id`, `code`, `type`, `store_range`, `value`, `sort_order`) VALUES (6, 'merchant_join_close', 'select', '0,1', 0, 1);


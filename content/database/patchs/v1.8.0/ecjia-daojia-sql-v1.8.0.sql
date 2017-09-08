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
# ECJia到家数据库更新脚本v1.8.0
# 
# 2017-08-31
# ************************************************************


-- ecjia_connect_user表修改
ALTER TABLE `ecjia_connect_user` CHANGE `refresh_token` `refresh_token` VARCHAR(200)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NULL  DEFAULT NULL;
ALTER TABLE `ecjia_connect_user` CHANGE `access_token` `access_token` VARCHAR(200)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NULL  DEFAULT NULL;


-- ecjia_wechat_menu表修改
ALTER TABLE `ecjia_wechat_menu` CHANGE `type` `type` VARCHAR(60)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NULL  DEFAULT NULL  COMMENT '菜单的响应动作类型';
ALTER TABLE `ecjia_wechat_menu` CHANGE `url` `url` VARCHAR(255)  CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NULL  DEFAULT NULL  COMMENT '菜单KEY值，click类型必须';


-- 创建营销活动表
CREATE TABLE IF NOT EXISTS `ecjia_market_activity` (
  `activity_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `activity_name` varchar(100) NOT NULL DEFAULT '' COMMENT '活动名称',
  `activity_group` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活动组（1、摇一摇）',
  `activity_desc` text NOT NULL COMMENT '活动规则描述',
  `activity_object` int(10) unsigned NOT NULL COMMENT '活动对象（app，pc，touch等）',
  `limit_num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活动限制次数（0为不限制）',
  `limit_time` int(10) NOT NULL DEFAULT '0' COMMENT '多少时间内活动限制（0为在活动时间内，否则多少时间内限制，单位：分钟）',
  `start_time` int(10) unsigned DEFAULT NULL COMMENT '活动开始时间',
  `end_time` int(10) unsigned DEFAULT NULL COMMENT '活动结束时间',
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  `enabled` tinyint(4) DEFAULT NULL COMMENT '是否使用，1开启，0禁用',
  PRIMARY KEY (`activity_id`),
  KEY `store_id` (`store_id`),
  KEY `activity_group` (`activity_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 创建营销活动日志表
CREATE TABLE IF NOT EXISTS `ecjia_market_activity_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(10) unsigned NOT NULL COMMENT '活动id',
  `user_id` int(10) unsigned NOT NULL COMMENT '会员id',
  `username` varchar(25) NOT NULL COMMENT '会员名称',
  `prize_id` int(10) unsigned NOT NULL COMMENT '奖品池id',
  `prize_name` varchar(30) NOT NULL COMMENT '奖品名称',
  `issue_status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '发放状态，0未发放，1发放',
  `issue_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '（奖品）发放时间',
  `issue_extend` text COMMENT '需线下延期发放的扩展信息（序列化）',
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '抽奖时间',
  `source` varchar(20) DEFAULT NULL COMMENT '来源（app，touch，pc等）',
  PRIMARY KEY (`id`),
  KEY `activity_id` (`activity_id`),
  KEY `prize_id` (`prize_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 创建营销活动奖品表
CREATE TABLE IF NOT EXISTS `ecjia_market_activity_prize` (
  `prize_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` int(10) unsigned NOT NULL COMMENT '活动id',
  `prize_level` tinyint(4) unsigned DEFAULT '0' COMMENT '奖项等级（从0开始，0为大奖，依此类推）',
  `prize_name` varchar(30) NOT NULL DEFAULT '' COMMENT '奖品名称',
  `prize_type` int(10) unsigned NOT NULL COMMENT '奖品类型',
  `prize_value` varchar(30) NOT NULL DEFAULT '' COMMENT '对应奖品信息（id或数量）',
  `prize_number` int(10) NOT NULL DEFAULT '0' COMMENT '奖品数量（goods与nothing设置无效）',
  `prize_prob` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '奖品数量（概率，总共100%）',
  PRIMARY KEY (`prize_id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- o2o物流跟踪详细表
CREATE TABLE IF NOT EXISTS `ecjia_express_track_record` (
  `id`  int(11) NOT NULL AUTO_INCREMENT,
  `express_code`  varchar(30) NOT NULL COMMENT '对应配送方式表中shipping_code',
  `track_number`  varchar(30) NOT NULL COMMENT '运单号',
  `time`  datetime NULL COMMENT '时间' ,
  `context`  varchar(200) NULL COMMENT '描述' ,
  PRIMARY KEY (`id`),
  INDEX `track_number` (`track_number`),
  INDEX `express_code` (`express_code`)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;







# ************************************************************
#
# 到家数据库更新脚本v1.10
# 
# 2017-11-27
# ************************************************************

-- 修改表名ecjia_region_cn为ecjia_regions
RENAME TABLE `ecjia_region_cn` TO `ecjia_regions`;


-- 修改表ad_position内地区字段
alter table ecjia_ad_position 
MODIFY city_id varchar(20)  NOT NULL default '0';

-- 修改表order_info内地区字段
alter table ecjia_order_info 
MODIFY country varchar(20)  NOT NULL default '',
MODIFY province varchar(20)  NOT NULL default '',
MODIFY city varchar(20)  NOT NULL default '',
MODIFY district varchar(20)  NOT NULL default '',
ADD COLUMN `street` varchar(20) NOT NULL  default '' COMMENT '街道地区码' AFTER `district`;

-- 修改表store_franchisee内地区字段
alter table ecjia_store_franchisee
MODIFY province varchar(20)  NOT NULL default '',
MODIFY city varchar(20)  NOT NULL default '',
MODIFY district varchar(20)  NOT NULL default '',
ADD COLUMN `street` varchar(20) NOT NULL default '' COMMENT '街道地区码' AFTER `district`;

-- 修改表express_order内地区字段
alter table ecjia_express_order
MODIFY country varchar(20)  NOT NULL default '',
MODIFY province varchar(20)  NOT NULL default '',
MODIFY city varchar(20)  NOT NULL default '',
MODIFY district varchar(20)  NOT NULL default '',
ADD COLUMN `street` varchar(20) NOT NULL  default '' COMMENT '街道地区码' AFTER `district`;

-- 修改表area_region内地区字段
alter table ecjia_area_region
MODIFY region_id varchar(20)  NOT NULL;

-- 修改表back_order内地区字段
alter table ecjia_back_order
MODIFY country varchar(20)  NOT NULL default '',
MODIFY province varchar(20)  NOT NULL default '',
MODIFY city varchar(20)  NOT NULL default '',
MODIFY district varchar(20)  NOT NULL default '',
ADD COLUMN `street` varchar(20) NOT NULL default '' COMMENT '街道地区码' AFTER `district`;

-- 修改表delivery_order内地区字段
alter table ecjia_delivery_order
MODIFY country varchar(20)  NOT NULL default '',
MODIFY province varchar(20)  NOT NULL default '',
MODIFY city varchar(20)  NOT NULL default '',
MODIFY district varchar(20)  NOT NULL default '',
ADD COLUMN `street` varchar(20) NOT NULL default '' COMMENT '街道地区码' AFTER `district`;

-- 修改表store_preaudit内地区字段
alter table ecjia_store_preaudit
MODIFY province varchar(20)  NOT NULL default '',
MODIFY city varchar(20)  NOT NULL default '',
MODIFY district varchar(20)  NOT NULL default '',
ADD COLUMN `street` varchar(20) NOT NULL default '' COMMENT '街道地区码' AFTER `district`;

-- 修改表user_address内地区字段
alter table ecjia_user_address
MODIFY country varchar(20)  NOT NULL default '',
MODIFY province varchar(20)  NOT NULL default '',
MODIFY city varchar(20)  NOT NULL default '',
MODIFY district varchar(20)  NOT NULL default '',
ADD COLUMN `street` varchar(20) NOT NULL default '' COMMENT '街道地区码' AFTER `district`;


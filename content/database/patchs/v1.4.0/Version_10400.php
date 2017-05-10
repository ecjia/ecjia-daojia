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
use Ecjia\System\Version\Version;
use Ecjia\System\Database\Seeder;
use Ecjia\System\Database\Migrate;
use Royalcms\Component\Database\QueryException;

class Version_10400 extends Version
{
    
    
    /**
     * 升级触发
     */
    public function fire()
    {
        try {
            $migrate = new Migrate();
            
            // 创建ecjia_migrations表
            $migrate->createMigrationsTable();
            
            // 插入1.3.x版本中安装过的数据库
            $this->insertMigrationsData();
            
            // 移除旧的comment表
            RC_Schema::dropIfExists('comment');
            
            // 移除废弃的template表
            RC_Schema::dropIfExists('template');
            
            // 移除升级失败创建的表
            $this->dropUpgradeFailedTables();
            
            // 更新1.4中新增的迁移项
            $migrate->fire();
            
            // 修改shop_config表中的id类型
            $this->alertTableByShopConfigIdType();
            
            // 更新shop_config数据表主键ID顺序
            $seeder = new Seeder('FixShopConfigTableSeeder');
            $seeder->fire();
            
            // 更新shop_config数据填充
            $seeder = new Seeder('InitShopConfigTableSeeder');
            $seeder->fire();
            
            $this->updateConfig();
            
            return true;
        }
        catch (QueryException $e) {
        
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
        
    }
    
    /**
     * 修改shop_config表中的id类型
     */
    protected function alertTableByShopConfigIdType()
    {
        RC_Schema::table('shop_config', function($table)
        {
            $table->increments('id')->change();
        });
    }
    
    /**
     * 移除升级失败安装的数据表，便于重装
     */
    protected function dropUpgradeFailedTables()
    {
        RC_Schema::dropIfExists('term_attachment');
        RC_Schema::dropIfExists('comment');
        RC_Schema::dropIfExists('comment_appeal');
        RC_Schema::dropIfExists('comment_reply');
        RC_Schema::dropIfExists('goods_data');
    }
    
    protected function insertMigrationsData()
    {
        $data = array(
        	array('migration' => '2017_03_03_170201_create_account_log_table', 'batch' => '1'),
        	array('migration' => '2017_03_06_163732_create_ad_table', 'batch' => '1'),
        	array('migration' => '2017_03_06_164930_create_ad_position_table', 'batch' => '1'),
        	array('migration' => '2017_03_06_181301_create_admin_log_table', 'batch' => '1'),
        	array('migration' => '2017_03_06_184226_create_admin_message_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_094740_create_admin_user_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_095103_create_adsense_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_100204_create_affiliate_log_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_100507_create_area_region_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_101656_create_article_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_102324_create_article_cat_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_105929_create_attribute_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_132654_create_auto_manage_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_133247_create_back_goods_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_135415_create_back_order_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_140959_create_bonus_type_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_141439_create_brand_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_150504_create_cart_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_150733_create_cat_recommend_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_153658_create_category_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_154651_create_collect_goods_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_154827_create_collect_store_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_155734_create_connect_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_160637_create_connect_user_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_163442_create_crons_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_164223_create_delivery_goods_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_170004_create_delivery_order_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_170342_create_email_list_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_170810_create_email_sendlist_table', 'batch' => '1'),
        	array('migration' => '2017_03_07_173755_create_express_checkin_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_103525_create_express_order_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_110156_create_express_user_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_112200_create_favourable_activity_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_121311_create_goods_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_132245_create_goods_activity_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_133109_create_goods_article_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_134814_create_goods_attr_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_135053_create_goods_cat_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_135417_create_goods_gallery_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_140420_create_goods_type_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_140933_create_group_goods_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_142221_create_invite_reward_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_143001_create_invitee_record_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_150840_create_keywords_table', 'batch' => '1'),
        	array('migration' => '2017_03_08_155236_create_link_goods_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_144926_create_mail_templates_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_145521_create_member_price_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_152328_create_merchants_category_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_153012_create_merchants_config_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_153423_create_mobile_checkin_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_154426_create_mobile_device_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_155522_create_mobile_manage_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_161915_create_mobile_news_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_162545_create_mobile_screenshots_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_163255_create_nav_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_163349_create_notifications_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_175359_create_order_action_table', 'batch' => '1'),
        	array('migration' => '2017_03_09_180443_create_order_goods_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_132131_create_order_info_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_132941_create_order_reminder_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_133246_create_order_status_log_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_133827_create_package_goods_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_134146_create_pay_log_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_135231_create_payment_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_135908_create_payment_record_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_141007_create_platform_account_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_141416_create_platform_command_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_141749_create_platform_config_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_142207_create_platform_extend_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_142529_create_products_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_143928_create_push_event_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_144455_create_push_message_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_150625_create_reg_extend_info_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_151013_create_reg_fields_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_151513_create_region_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_151734_create_role_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_165327_create_searchengine_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_170133_create_sessions_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_170350_create_sessions_data_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_171203_create_shipping_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_171445_create_shipping_area_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_171943_create_shop_config_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_173004_create_site_options_table', 'batch' => '1'),
        	array('migration' => '2017_03_10_174331_create_sites_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_114959_create_sms_sendlist_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_115918_create_staff_group_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_120621_create_staff_log_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_133250_create_staff_user_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_165231_create_stats_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_170309_create_store_bill_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_171456_create_store_bill_day_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_172202_create_store_bill_detail_table', 'batch' => '1'),
        	array('migration' => '2017_03_13_172800_create_store_bill_paylog_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_102148_create_store_category_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_102638_create_store_check_log_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_105627_create_store_franchisee_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_105939_create_store_keywords_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_110227_create_store_percent_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_115842_create_store_preaudit_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_131256_create_template_widget_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_133615_create_term_meta_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_134129_create_term_relationship_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_134848_create_topic_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_135654_create_user_account_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_141935_create_user_address_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_142413_create_user_bonus_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_142918_create_user_rank_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_150031_create_users_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_150318_create_volume_price_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_150646_create_wechat_custom_message_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_152231_create_wechat_customer_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_152644_create_wechat_customer_session_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_153258_create_wechat_mass_history_table', 'batch' => '1'),
        	array('migration' => '2017_03_14_155318_create_wechat_media_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_161251_create_wechat_menu_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_161822_create_wechat_oauth_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_162248_create_wechat_point_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_164056_create_wechat_prize_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_165156_create_wechat_qrcode_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_170058_create_wechat_reply_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_170511_create_wechat_request_times_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_170746_create_wechat_rule_keywords_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_171111_create_wechat_tag_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_173235_create_wechat_user_table', 'batch' => '1'),
        	array('migration' => '2017_03_15_173743_create_wechat_user_tag_table', 'batch' => '1'),
        );
        
        RC_DB::table('migrations')->truncate();
        RC_DB::table('migrations')->insert($data);
    }
    
    protected function updateConfig()
    {
        $data = [
            ['group' => 'basic', 'code' => 'close_comment', 'value' => null, 'options' => ['type' => 'hidden']],
            ['group' => 'basic', 'code' => 'comment_factor', 'value' => null, 'options' => ['type' => 'hidden']],
            ];
    
        collect($data)->each(function($item) {
            ecjia_config::change($item['group'], $item['code'], $item['value'], $item['options']);
        });
    }
    
    /**
     * shop_config 表中废弃的code值记录
     * 
     * close_comment    关闭评论，不支持了
     * comment_factor   评论的用户权限：游客、是否购买、购买后评论
     */
    public function shop_config_remarks() {}
    
    /**
     * 获取更新日志文件路径
     */
    public function upgradeLogPath()
    {
        return __DIR__ . '/ecjia-daojia-patch-v1.4.0.log';
    }
    
    /**
     * 获取更新说明文件路径
     */
    public function upgradeReadmePath()
    {
        return __DIR__ . '/readme.txt';
    }
}

// end
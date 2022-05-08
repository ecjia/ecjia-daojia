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
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/23
 * Time: 11:56 AM
 */

namespace Ecjia\Resources\Components\SettingComponents;


use Ecjia\Component\Config\Component\ComponentAbstract;

class G06Hidden extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'hidden';

    /**
     * 排序
     * @var int
     */
    protected $sort = 95;

    protected $displayed = false;

    public function __construct()
    {
        $this->name = __('自定义组', 'setting');
    }


    public function handle()
    {
        $config = [
            [
                'cfg_code'  => 'integrate_code',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'integrate_config',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'hash_code',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'template',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'ecjia-pc',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'install_date',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'ecjia_version',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'ecjia_db_version',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '5',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'affiliate',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'a:5:{s:2:"on";i:1;s:6:"config";a:7:{s:6:"expire";d:24;s:11:"expire_unit";s:4:"hour";s:11:"separate_by";i:0;s:15:"level_point_all";s:2:"5%";s:15:"level_money_all";s:2:"1%";s:18:"level_register_all";i:2;s:17:"level_register_up";i:60;}s:13:"intvie_reward";a:3:{s:16:"intive_reward_by";s:6:"signup";s:18:"intive_reward_type";s:5:"bonus";s:19:"intive_reward_value";i:106;}s:14:"intviee_reward";a:3:{s:17:"intivee_reward_by";s:6:"signup";s:19:"intivee_reward_type";s:5:"bonus";s:20:"intivee_reward_value";i:106;}s:4:"item";a:4:{i:0;a:2:{s:11:"level_point";s:3:"60%";s:11:"level_money";s:3:"60%";}i:1;a:2:{s:11:"level_point";s:3:"30%";s:11:"level_money";s:3:"30%";}i:2;a:2:{s:11:"level_point";s:2:"7%";s:11:"level_money";s:2:"7%";}i:3;a:2:{s:11:"level_point";s:2:"3%";s:11:"level_money";s:2:"3%";}}}',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'captcha',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '45',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'captcha_width',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '100',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'captcha_height',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '28',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'sitemap',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'a:6:{s:19:"homepage_changefreq";s:6:"hourly";s:17:"homepage_priority";s:3:"0.9";s:19:"category_changefreq";s:6:"hourly";s:17:"category_priority";s:3:"0.8";s:18:"content_changefreq";s:6:"weekly";s:16:"content_priority";s:3:"0.7";}',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'points_rule',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'flash_theme',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'dynfocus',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'stylename',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'certificate_sn',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'certificate_file',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'auth_key',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'captcha_style',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'captcha_royalcms',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'navigator_data',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'a:4:{i:0;a:2:{s:4:"type";s:3:"top";s:4:"name";s:6:"顶部";}i:1;a:2:{s:4:"type";s:6:"middle";s:4:"name";s:6:"中间";}i:2;a:2:{s:4:"type";s:6:"bottom";s:4:"name";s:6:"底部";}i:3;a:2:{s:4:"type";s:5:"touch";s:4:"name";s:10:"ECJiaTouch";}}',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'last_check_upgrade_time',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'app_key_android',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'app_secret_android',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'app_key_iphone',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'app_secret_iphone',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'app_key_ipad',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'app_secret_ipad',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'touch_template',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'touch_stylename',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'merchant_admin_cpname',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'ECJia商家后台管理',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'merchant_admin_login_logo',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'mobile_seller_home_adsense',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '94',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'index_ad',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'certificate_id',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'certi',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'token',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'ent_id',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'ent_ac',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'ent_sign',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'ent_email',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'invite_template',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '你的好友（{$user_name}）向您推荐了一款购物应用【{$shop_name}】，优惠活动多多，新人注册还有红包奖励，赶紧下载体验吧！',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'invite_explain',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '1、通过推广页面把属于自己的二维码通过第三方平台分享给新人好友；\r\n2、新人好友通过您的邀请，打开链接，在活动页输入自己的手机号，并通过指定渠道下载客户端完成注册，即可获得奖励；\r\n3、每邀请一位新人好友并完成注册都可获得相应奖励；\r\n4、奖励一经领取后，不可删除，不可提现，不可转赠；\r\n5、新用户领取的奖励查看方式：【App-我的－我的钱包】查看，也可通过【我的推广—奖励明细】查看；\r\n6、如有任何的疑问请咨询官网客服人员。',
                'cfg_type'  => 'hidden',
            ],

            //v1.5.0新增
            [
                'cfg_code'  => 'app_template',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'ecjia-app',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'app_stylename',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'cloud_express_key',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'cloud_express_secret',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            //v1.7.0新增
            [
                'cfg_code'  => 'store_model',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'region_cn_version',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'region_last_checktime',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            //v1.9.0新增
            [
                'cfg_code'  => 'quickpay_rule',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '1、优惠买单仅限于到店消费后使用，请勿提前支付；\r\n2、请在输入买单金额前与商家确认门店信息和消费金额；\r\n3、遇节假日能否享受优惠，请详细咨询商家；\r\n4、请咨询商家能否与店内其他优惠同享；\r\n5、如需发票，请您在消费时向商家咨询。',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'quickpay_fee',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'cron_method',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => array(0, 1),
                'cfg_value' => '0',
                'cfg_type'  => 'select',
            ],

            [
                'cfg_code'  => 'cron_secret_key',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '0',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'merchant_join_close',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => array(0, 1),
                'cfg_value' => '0',
                'cfg_type'  => 'select',
            ],
            //v1.15.0新增
            [
                'cfg_code'  => 'store_deposit',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '0',
                'cfg_type'  => 'hidden',
            ],

            [
                'cfg_code'  => 'plugin_ship_ecjia_express',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '0',
                'cfg_type'  => 'text',
            ],
            //v1.20.0新增
            [
                'cfg_code'  => 'merchant_staff_max_number',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '10',
                'cfg_type'  => 'text',
            ],
            //v1.21.0新增
            [
                'cfg_code'  => 'invitee_rule_explain',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '1、奖励仅限新用户领取；\n2、每位新用户仅限领取1次，相同设备、手机号等均视为同一用户；\n3、奖励一经领取后，不可删除，不可提现，不可转赠；\n4、新用户领取的奖励查看方式：【我的－我的钱包】查看；\n5、如有其他疑问请咨询官网客服人员。',
                'cfg_type'  => 'text',
            ],

            [
                'cfg_code'  => 'pc_enabled_member',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => array(0, 1),
                'cfg_value' => '0',
                'cfg_type'  => 'select',
            ],
            //v1.22.0新增
            [
                'cfg_code'  => 'home_visual_page',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => 'a:9:{i:0;s:15:"home_cycleimage";i:1;s:13:"home_shortcut";i:2;s:25:"scanqrcode_and_membercode";i:3;s:24:"home_complex_adsense_one";i:4;s:24:"home_complex_adsense_two";i:5;s:9:"new_goods";i:6;s:14:"groupbuy_goods";i:7;s:10:"best_goods";i:8;s:13:"promote_goods";}',
                'cfg_type'  => 'text',
            ],
            //v1.24.0新增
            [
                'cfg_code'  => 'withdraw_fee',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '0',
                'cfg_type'  => 'text',
            ],

            [
                'cfg_code'  => 'withdraw_min_amount',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '0',
                'cfg_type'  => 'text',
            ],
            //v1.25.0新增
//            [
//                'cfg_code'  => 'orders_auto_cancel_time',
//                'cfg_name'  => '',
//                'cfg_desc'  => '',
//                'cfg_range' => '',
//                'cfg_value' => '',
//                'cfg_type'  => 'text',
//            ],

            [
                'cfg_code'  => 'withdraw_support_banks',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text',
            ],
            //v1.27.0新增
            [
                'cfg_code'  => 'agent_rank',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text',
            ],

            [
                'cfg_code'  => 'store_cancel_agreement',
                'cfg_name'  => '',
                'cfg_desc'  => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text',
            ],
        ];

        return $config;
    }
}
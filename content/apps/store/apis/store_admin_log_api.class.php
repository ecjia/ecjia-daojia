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

class store_admin_log_api extends Component_Event_Api
{

    public function call(& $options)
    {

        $log_object = [
            'store_commission'        => __('佣金结算', 'store'),
            'store_commission_status' => __('佣金结算状态', 'store'),

            'merchants_step'        => __('申请流程', 'store'),
            'merchants_step_title'  => __('申请流程信息', 'store'),
            'merchants_step_custom' => __('自定义字段', 'store'),

            'seller'          => __('入驻商', 'store'),
            'merchants_brand' => __('商家品牌', 'store'),
            'store_category'  => __('店铺分类', 'store'),
            'merchant_notice' => __('商家公告', 'store'),

            'config'             => __('配置', 'store'),
            'store_percent'      => __('佣金比例', 'store'),
            'store_mobileconfig' => __('店铺街配置', 'store'),

            'store_business_city' => __('店铺经营城市', 'store'),

            'store' => __('店铺', 'store'),

            'store_article'         => __('店铺文章', 'store'),
            'store_article_comment' => __('文章评论', 'store'),

            'store_bonus'               => __('店铺红包', 'store'),
            'store_favourable_activity' => __('店铺优惠活动', 'store'),
            'store_promotion_activity'  => __('店铺促销活动', 'store'),
            'store_groupbuy_activity'   => __('店铺团购活动', 'store'),
            'store_quickpay_activity'   => __('店铺买单活动', 'store'),

            'store_staff'      => __('店铺员工', 'store'),
            'store_collect'    => __('店铺收藏', 'store'),
            'store_goods'      => __('店铺商品数据', 'store'),
            'store_cart_goods' => __('店铺购物车商品', 'store'),

            'store_cashier_pendorder' => __('店铺收银台挂单', 'store'),
            'store_cashier_device'    => __('店铺收银台设备', 'store'),
            'store_cashier_scales'    => __('店铺电子秤设备', 'store'),

            'store_market_activity'  => __('店铺公众平台营销活动', 'store'),
            'store_adsense'          => __('店铺广告', 'store'),
            'store_adsense_position' => __('店铺广告位', 'store'),

            'store_toutiao_menu' => __('店铺自定义菜单', 'store'),
            'store_toutiao'      => __('店铺今日头条', 'store'),

            'store_printer'      => __('店铺小票打印机', 'store'),
            'store_print_record' => __('店铺小票打印记录', 'store'),

            'store_shipping_area' => __('店铺配送区域', 'store'),
            'store_staff_log'     => __('店铺操作日志', 'store'),
            'store_close'         => __('锁定、关闭店铺主表', 'store'),
            'store_keywords'      => __('店铺搜索关键词', 'store'),
            'store_user'          => __('店铺会员', 'store'),

            'store_check_log'         => __('店铺审核日志', 'store'),
            'store_preaudit'          => __('店铺申请资料', 'store'),
            'store_order'             => __('店铺订单', 'store'),
            'store_goods_comment'     => __('商品评论', 'store'),
            'store_shipping_template' => __('运费模版', 'store'),

        ];


        $log_action = [
            'clean' => __('一键删除', 'store'),
            'duplicate' => __('一键复制', 'store'),
        ];


    }

}
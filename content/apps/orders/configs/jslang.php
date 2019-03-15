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

return array(
    'admin_page'                    => array(
        'time_error'             => __('下单开始时间不能大于或等于结束时间', 'orders'),
        'confirm'                => __('确认', 'orders'),
        'pay'                    => __('付款', 'orders'),
        'unpay'                  => __('未付款', 'orders'),
        'prepare'                => __('配货', 'orders'),
        'unship'                 => __('未发货', 'orders'),
        'receive'                => __('收货确认', 'orders'),
        'invalid'                => __('无效', 'orders'),
        'after_service'          => __('售后', 'orders'),
        'return_goods'           => __('退货', 'orders'),
        'refund'                 => __('退款', 'orders'),
        'cancel'                 => __('取消', 'orders'),
        'operate_order_required' => __('请选择需要操作的订单！', 'orders'),
        'select_user_empty'      => __('未搜索到会员信息', 'orders'),
        'pls_search_user'        => __('请搜索并选择会员', 'orders'),
        'select_goods_empty'     => __('未搜索到商品信息', 'orders'),
        'remove_confirm'         => __('删除订单将清除该订单的所有信息。您确定要这么做吗？', 'orders'),
        'ok'                     => __('确定', 'orders'),
        'refund_note_required'   => __('请填写退款说明！', 'orders'),
        'pls_input_cancel'       => __('请输入取消原因！', 'orders'),
        'consignee_required'     => __('请填写收货人！', 'orders'),
        'email_required'         => __('请输入电子邮件！', 'orders'),
        'tel_required'           => __('请输入电话号码！', 'orders'),
        'address_required'       => __('请输入详细地址！', 'orders'),
        'city_required'          => __('请选择所在地区！', 'orders'),
        'shipping_required'      => __('请选择配送方式！', 'orders'),
        'payment_required'       => __('请选择支付方式！', 'orders'),
        'no_brand_name'          => __('无品牌', 'orders'),
        'market_price'           => __('市场价', 'orders'),
        'goods_price'            => __('本店价', 'orders'),
        'custom_price'           => __('自定义价格', 'orders'),
        'no_other_attr'          => __('暂无其他属性', 'orders'),
        'not_add_goods'          => __('还没有添加商品哦！请搜索后加入订单！', 'orders'),
    ),
    'admin_order_stats_page'        => array(
        'year_required' => __('请选择年份', 'orders'),
        'sheet'         => __('%s：%s单', 'orders'),
    ),
    'admin_order_stats_chart_page'  => array(
        'await_pay_order'  => __('待付款订单', 'orders'),
        'await_ship_order' => __('待发货订单', 'orders'),
        'shipped_order'    => __('已发货订单', 'orders'),
        'returned_order'   => __('退货订单', 'orders'),
        'canceled_order'   => __('已取消订单', 'orders'),
        'no_stats_data'    => __('没有统计数据', 'orders'),
        'order_number_s'   => __('订单数量：%s', 'orders'),
        'default'          => __('配送', 'orders'),
        'groupbuy'         => __('团购', 'orders'),
        'storebuy'         => __('到店', 'orders'),
        'storepickup'      => __('自提', 'orders'),
        'cashdesk'         => __('收银台', 'orders'),
    ),
    'admin_sale_general_page'       => array(
        'start_year_required' => __('查询的开始年份不能为空！', 'orders'),
        'end_year_required'   => __('查询的结束年份不能为空！', 'orders'),
        'time_exceed'         => __('查询的开始时间不能超于结束时间！', 'orders'),
    ),
    'admin_sale_general_chart_page' => array(
        'sheet'         => __('单', 'orders'),
        'order_number'  => __('订单数量', 'orders'),
        'yuan'          => __('元', 'orders'),
        'sales_volume'  => __('销售额', 'orders'),
        'no_stats_data' => __('没有统计数据', 'orders'),
    ),
    'admin_sale_list_page'          => array(
        'start_time_required' => __('查询的开始时间不能为空！', 'orders'),
        'end_time_required'   => __('查询的结束时间不能为空！', 'orders'),
        'time_exceed'         => __('查询的开始时间不能超于结束时间！', 'orders'),
    ),
    'admin_sale_order_page'         => array(
        'start_time_required' => __('查询的开始时间不能为空！', 'orders'),
        'end_time_required'   => __('查询的结束时间不能为空！', 'orders'),
        'time_exceed'         => __('查询的开始时间不能超于结束时间！', 'orders'),
    ),
    'admin_user_order_page'         => array(
        'start_time_required' => __('查询的开始时间不能为空！', 'orders'),
        'end_time_required'   => __('查询的结束时间不能为空！', 'orders'),
        'time_exceed'         => __('查询的开始时间不能超于结束时间！', 'orders'),
    ),

    'merchant_page'                    => array(
        'time_error'                => __('下单开始时间不能大于或等于结束时间', 'orders'),
        'operate_order_required'    => __('请选择需要操作的订单！', 'orders'),
        'remove_confirm'            => __('删除订单将清除该订单的所有信息。您确定要这么做吗？', 'orders'),
        'confirm'                   => __('确认', 'orders'),
        'pay'                       => __('付款', 'orders'),
        'unpay'                     => __('未付款', 'orders'),
        'prepare'                   => __('配货', 'orders'),
        'unship'                    => __('未发货', 'orders'),
        'receive'                   => __('收货确认', 'orders'),
        'invalid'                   => __('无效', 'orders'),
        'after_service'             => __('售后', 'orders'),
        'return_goods'              => __('退货', 'orders'),
        'refund'                    => __('退款', 'orders'),
        'cancel'                    => __('取消', 'orders'),
        'label_order_operate'       => __('订单操作', 'orders'),
        'refund_note_required'      => __('请填写退款说明！', 'orders'),
        'ok'                        => __('确定', 'orders'),
        'pls_input_cancel'          => __('请输入取消原因！', 'orders'),
        'pls_select_way'            => __('请选择退款方式', 'orders'),
        'pls_select_reason'         => __('请选择退款原因', 'orders'),
        'unconfirm_reason_required' => __('请填写拒绝原因', 'orders'),
        'shipping_required'         => __('请选择配送方式！', 'orders'),
        'payment_required'          => __('请选择支付方式！', 'orders'),
        'invoice_no_required'       => __('请填写运单编号', 'orders'),
        'select_goods_empty'        => __('未搜索到商品信息', 'orders'),
        'no_brand_name'             => __('无品牌', 'orders'),
        'market_price'              => __('市场价', 'orders'),
        'goods_price'               => __('本店价', 'orders'),
        'custom_price'              => __('自定义价格', 'orders'),
        'no_other_attr'             => __('暂无其他属性', 'orders'),
        'not_add_goods'             => __('还没有添加商品哦！请搜索后加入订单！', 'orders'),
        'consignee_required'        => __('请填写收货人！', 'orders'),
        'email_required'            => __('请输入电子邮件！', 'orders'),
        'tel_required'              => __('请输入电话号码！', 'orders'),
        'address_required'          => __('请输入详细地址！', 'orders'),
        'city_required'             => __('请选择所在地区！', 'orders'),
        'twenty_seconds_refresh'    => __('20秒自动刷新', 'orders'),
        's_seconds_refresh'         => __('%s秒自动刷新', 'orders'),
    ),
    'merchant_order_stats_page'        => array(
        'year_required' => __('请选择年份', 'orders'),
        'time_required' => __('查询的时间不能为空！', 'orders'),
    ),
    'merchant_order_stats_chart_page'  => array(
        'await_pay_order'  => __('待付款订单', 'orders'),
        'await_ship_order' => __('待发货订单', 'orders'),
        'shipped_order'    => __('已发货订单', 'orders'),
        'returned_order'   => __('退货订单', 'orders'),
        'canceled_order'   => __('已取消订单', 'orders'),
        'no_stats_data'    => __('没有统计数据', 'orders'),
        'order_number_s'   => __('订单数量：%s', 'orders'),
        'default'          => __('配送', 'orders'),
        'groupbuy'         => __('团购', 'orders'),
        'storebuy'         => __('到店', 'orders'),
        'storepickup'      => __('自提', 'orders'),
        'cashdesk'         => __('收银台', 'orders'),
    ),
    'merchant_sale_general_page'       => array(
        'start_year_required' => __('查询的开始年份不能为空！', 'orders'),
        'end_year_required'   => __('查询的结束年份不能为空！', 'orders'),
        'time_exceed'         => __('查询的开始时间不能超于结束时间！', 'orders'),
    ),
    'merchant_sale_general_chart_page' => array(
        'sheet'         => __('单', 'orders'),
        'order_number'  => __('订单数量', 'orders'),
        'yuan'          => __('元', 'orders'),
        'sales_volume'  => __('销售额', 'orders'),
        'no_stats_data' => __('没有统计数据', 'orders'),
    ),
    'merchant_sale_list_page'          => array(
        'start_time_required' => __('查询的开始时间不能为空！', 'orders'),
        'end_time_required'   => __('查询的结束时间不能为空！', 'orders'),
        'time_exceed'         => __('查询的开始时间不能超于结束时间！', 'orders'),
    ),
    'merchant_sale_order_page'         => array(
        'start_time_required' => __('查询的开始时间不能为空！', 'orders'),
        'end_time_required'   => __('查询的结束时间不能为空！', 'orders'),
        'time_exceed'         => __('查询的开始时间不能超于结束时间！', 'orders'),
    ),
    'merchant_validate_order_page'     => array(
        'pickup_code_required' => __('请输入取货验证码！', 'orders'),
    ),
);

// end
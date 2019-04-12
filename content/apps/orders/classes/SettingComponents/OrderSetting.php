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

namespace Ecjia\App\Orders\SettingComponents;


use Ecjia\App\Setting\ComponentAbstract;

class OrderSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'orders';


    public function __construct()
    {
        $this->name = __('订单设置', 'orders');
    }


    public function handle()
    {
        $data = [
            ['code' => 'send_confirm_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'send_ship_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'send_cancel_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'send_invalid_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_pay_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_unpay_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_ship_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_receive_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_unship_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_return_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_invalid_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'order_cancel_note', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'send_service_email', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'show_goods_in_cart', 'value' => '3', 'options' => ['type' => 'select', 'store_range' => '1,2,3']],
            ['code' => 'show_attr_in_cart', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'orders_auto_cancel_time', 'value' => '', 'options' => ['type' => 'text']],
            ['code' => 'enable_order_check', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],

        ];

        return $data;
    }


    public function getConfigs()
    {
        $config = [
            [
                'cfg_code' => 'send_confirm_email',
                'cfg_name' => __('确认订单时', 'orders'),
                'cfg_desc' => __('控制商家对应操作之后对客户发送邮件', 'orders'),
                'cfg_range' => array(
                    '0' => __('不发送邮件', 'orders'),
                    '1' => __('发送邮件', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'send_ship_email',
                'cfg_name' => __('发货时', 'orders'),
                'cfg_desc' => __('控制商家对应操作之后对客户发送邮件', 'orders'),
                'cfg_range' => array(
                    '0' => __('不发送邮件', 'orders'),
                    '1' => __('发送邮件', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'send_cancel_email',
                'cfg_name' => __('取消订单时', 'orders'),
                'cfg_desc' => __('控制商家对应操作之后对客户发送邮件', 'orders'),
                'cfg_range' => array(
                    '0' => __('不发送邮件', 'orders'),
                    '1' => __('发送邮件', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'send_invalid_email',
                'cfg_name' => __('把订单设为无效时', 'orders'),
                'cfg_desc' => __('控制商家对应操作之后对客户发送邮件', 'orders'),
                'cfg_range' => array(
                    '0' => __('不发送邮件', 'orders'),
                    '1' => __('发送邮件', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'order_pay_note',
                'cfg_name' => __('设置订单为“已付款”时', 'orders'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('无需填写备注', 'orders'),
                    '1' => __('必须填写备注', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'order_unpay_note',
                'cfg_name' => __('设置订单为“未付款”时', 'orders'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('无需填写备注', 'orders'),
                    '1' => __('必须填写备注', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'order_ship_note',
                'cfg_name' => __('设置订单为“已发货”时', 'orders'),
                'cfg_desc' => __('控制商家后台管理的时候，进行这些操作是否必须要填写备注', 'orders'),
                'cfg_range' => array(
                    '0' => __('无需填写备注', 'orders'),
                    '1' => __('必须填写备注', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'order_receive_note',
                'cfg_name' => __('设置订单为“收货确认”时', 'orders'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('无需填写备注', 'orders'),
                    '1' => __('必须填写备注', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'order_unship_note',
                'cfg_name' => __('设置订单为“未发货”时', 'orders'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('无需填写备注', 'orders'),
                    '1' => __('必须填写备注', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'order_return_note',
                'cfg_name' => __('退货时', 'orders'),
                'cfg_desc' => __('控制商家后台管理的时候，进行这些操作是否必须要填写备注', 'orders'),
                'cfg_range' => array(
                    '0' => __('无需填写备注', 'orders'),
                    '1' => __('必须填写备注', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'order_invalid_note',
                'cfg_name' => __('把订单设为无效时', 'orders'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('无需填写备注', 'orders'),
                    '1' => __('必须填写备注', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'order_cancel_note',
                'cfg_name' => __('取消订单时', 'orders'),
                'cfg_desc' => __('控制商家后台管理的时候，进行这些操作是否必须要填写备注', 'orders'),
                'cfg_range' => array(
                    '0' => __('无需填写备注', 'orders'),
                    '1' => __('必须填写备注', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'send_service_email',
                'cfg_name' => __('下订单时是否给客服发邮件', 'orders'),
                'cfg_desc' => __('网店信息中的客服邮件地址不为空时，该选项有效。', 'orders'),
                'cfg_range' => array(
                    '0' => __('否', 'orders'),
                    '1' => __('是', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'show_goods_in_cart',
                'cfg_name' => __('购物车里显示商品方式', 'orders'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '1' => __('只显示文字', 'orders'),
                    '2' => __('只显示图片', 'orders'),
                    '3' => __('显示文字与图片', 'orders'),
                ),
            ],

            [
                'cfg_code' => 'show_attr_in_cart',
                'cfg_name' => __('购物车里是否显示商品属性', 'orders'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('否', 'orders'),
                    '1' => __('是', 'orders'),
                ),
            ],
            
            [
	            'cfg_code' => 'orders_auto_cancel_time',
	            'cfg_name' => __('未付款订单取消', 'orders'),
	            'cfg_desc' => __('会员未付款的订单，在设置时间（单位：分钟）后若还没有支付，系统将会自动取消未付款的订单，默认0代表不设置，不设置则未支付订单将不会自动取消。', 'orders'),
	            'cfg_range' => '',
            ],

            [
                'cfg_code' => 'enable_order_check',
                'cfg_name' => __('是否开启新订单提醒', 'orders'),
                'cfg_desc' => __('开启后，后台将弹出新订单提醒', 'orders'),
                'cfg_range' => array(
                    '0' => __('否', 'orders'),
                    '1' => __('是', 'orders'),
                ),
            ],

        ];

        return $config;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-28
 * Time: 12:05
 */

namespace Ecjia\Resources\Components\SettingComponents;


use Ecjia\Component\Config\Component\ComponentAbstract;

class ShoppingFlowSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'shopping_flow';

    /**
     * 排序
     * @var int
     */
    protected $sort = 3;

    public function __construct()
    {
        $this->name = __('购物流程', 'cart');
    }


    public function handle()
    {
        $config = [
            [
                'cfg_code' => 'use_integral',
                'cfg_name' => __('是否使用积分', 'cart'),
                'cfg_desc' => __('设置“使用”则表示用户在结算时，可使用积分抵扣订单金额结算', 'cart'),
                'cfg_range' => array(
                    '0' => __('不使用', 'cart'),
                    '1' => __('使用', 'cart'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'use_bonus',
                'cfg_name' => __('是否使用红包', 'cart'),
                'cfg_desc' => __('设置“使用”则表示用户在结算时，可使用红包抵扣订单金额结算', 'cart'),
                'cfg_range' => array(
                    '0' => __('不使用', 'cart'),
                    '1' => __('使用', 'cart'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'use_surplus',
                'cfg_name' => __('是否使用余额', 'cart'),
                'cfg_desc' => __('设置“使用”则表示用户在结算时，可使用余额抵扣订单金额结算', 'cart'),
                'cfg_range' => array(
                    '0' => __('不使用', 'cart'),
                    '1' => __('使用', 'cart'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'use_how_oos',
                'cfg_name' => __('是否使用缺货处理', 'cart'),
                'cfg_desc' => __('使用缺货处理时前台订单确认页面允许用户选择缺货时处理方法。', 'cart'),
                'cfg_range' => array(
                    '0' => __('不使用', 'cart'),
                    '1' => __('使用', 'cart'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'can_invoice',
                'cfg_name' => __('能否开发票', 'cart'),
                'cfg_desc' => __('设置“能”则表示用户在结算时，可选择开具发票', 'cart'),
                'cfg_range' => array(
                    '0' => __('不能', 'cart'),
                    '1' => __('能', 'cart'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'invoice_content',
                'cfg_name' => __('发票内容', 'cart'),
                'cfg_desc' => __('客户要求开发票时可以选择的内容。例如：办公用品。每一行代表一个选项。', 'cart'),
                'cfg_range' => '',
                'cfg_value' => '水果蔬菜\r\n肉禽蛋奶\r\n冷热速食\r\n休闲食品',
                'cfg_type' => 'textarea',
            ],

            [
                'cfg_code' => 'invoice_type',
                'cfg_name' => __('发票类型及税率', 'cart'),
                'cfg_desc' => __('税率填写整数值，例如(税率:12，商品金额:35.70)则公式:35.70 * (12 / 100) = 4.28元', 'cart'),
                'cfg_range' => '',
                'cfg_value' => 'a:2:{s:4:"type";a:3:{i:0;s:12:"普通发票";i:1;s:15:"增值税发票";i:2;s:0:"";}s:4:"rate";a:3:{i:0;d:0;i:1;d:13;i:2;d:0;}}',
                'cfg_type' => 'manual',
            ],

            [
                'cfg_code' => 'one_step_buy',
                'cfg_name' => __('是否一步购物', 'cart'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('否', 'cart'),
                    '1' => __('是', 'cart'),
                ),
                'cfg_value' => '0',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'min_goods_amount',
                'cfg_name' => __('最小购物金额', 'cart'),
                'cfg_desc' => __('达到此购物金额，才能提交订单。', 'cart'),
                'cfg_range' => '',
                'cfg_value' => '0',
                'cfg_type' => 'text',

            ],

            [
                'cfg_code' => 'anonymous_buy',
                'cfg_name' => __('是否允许未登录用户购物', 'cart'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('不允许', 'cart'),
                    '1' => __('允许', 'cart'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'cart_confirm',
                'cfg_name' => __('购物车确定提示', 'cart'),
                'cfg_desc' => __('允许您设置用户点击“加入购物车”后是否提示以及随后的动作。', 'cart'),
                'cfg_range' => array(
                    '1' => __('提示用户，点击“确定”进购物车', 'cart'),
                    '2' => __('提示用户，点击“取消”进购物车', 'cart'),
                    '3' => __('直接进入购物车', 'cart'),
                    '4' => __('不提示并停留在当前页面', 'cart'),
                ),
                'cfg_value' => '3',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'stock_dec_time',
                'cfg_name' => __('减库存的时机', 'cart'),
                'cfg_desc' => __('例如:选择“下单时”，则表示用户购买商品时，只要下单后，就减少商品的库存', 'cart'),
                'cfg_range' => array(
                    '0' => __('发货时', 'cart'),
                    '1' => __('下订单时', 'cart'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],
        ];

        return $config;
    }
}
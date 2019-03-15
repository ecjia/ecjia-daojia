<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 02:40
 */

namespace Ecjia\App\Payment\Enums;


use Royalcms\Component\Enum\Enum;

class PayEnum extends Enum
{

    /**
     * =======================================
     * 常见支付订单类型
     * =======================================
     */
    /**
     * 订单支付
     * @var string
     */
    const PAY_ORDER = 'buy';

    /**
     * 分单订单支付
     * @var string
     */
    const PAY_SEPARATE_ORDER = 'separate';

    /**
     * 会员预付款
     * @var string
     */
    const PAY_SURPLUS = 'surplus';

    /**
     * 闪付订单
     * @var string
     */
    const PAY_QUICKYPAY = 'quickpay';


    protected function __statusMap()
    {
        return [
            self::PAY_ORDER             => __('普通订单', 'payment'),
            self::PAY_SEPARATE_ORDER    => __('分割订单', 'payment'),
            self::PAY_SURPLUS           => __('充值订单', 'payment'),
            self::PAY_QUICKYPAY         => __('闪付订单', 'payment'),
        ];
    }
}
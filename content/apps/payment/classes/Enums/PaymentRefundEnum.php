<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 02:47
 */

namespace Ecjia\App\Payment\Enums;


use Royalcms\Component\Enum\Enum;

class PaymentRefundEnum extends Enum
{

    /**
     * 退款流水状态
     */
    const PAYMENT_REFUND_STATUS_CREATE      = 0; //创建退款请求
    const PAYMENT_REFUND_STATUS_REFUND      = 1; //确认退款
    const PAYMENT_REFUND_STATUS_PROGRESS    = 2; //退款处理中
    const PAYMENT_REFUND_STATUS_FAIL        = 11; //退款失败
    const PAYMENT_REFUND_STATUS_CLOSE       = 12; //退款关闭


    protected function __statusMap()
    {
        return [
            self::PAYMENT_REFUND_STATUS_CREATE      => __('创建退款请求', 'payment'),
            self::PAYMENT_REFUND_STATUS_REFUND      => __('确认退款', 'payment'),
            self::PAYMENT_REFUND_STATUS_PROGRESS    => __('退款处理中', 'payment'),
            self::PAYMENT_REFUND_STATUS_FAIL        => __('退款失败', 'payment'),
            self::PAYMENT_REFUND_STATUS_CLOSE       => __('退款关闭', 'payment'),
        ];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 02:44
 */

namespace Ecjia\App\Payment\Enums;


use Royalcms\Component\Enum\Enum;

class PaymentRecordEnum extends Enum
{

    /**
     * 流水记录的支付状态
     */
    const PAYMENT_RECORD_STATUS_WAIT        = 0; //等待支付
    const PAYMENT_RECORD_STATUS_PAYED       = 1; //支付完成
    const PAYMENT_RECORD_STATUS_PROGRESS    = 2; //支付进行中
    const PAYMENT_RECORD_STATUS_FAIL        = 11; //支付失败
    const PAYMENT_RECORD_STATUS_CANCEL      = 21; //订单撤消
    const PAYMENT_RECORD_STATUS_REFUND      = 22; //订单退款

    protected function __statusMap()
    {
        return [
            self::PAYMENT_RECORD_STATUS_WAIT        => __('等待支付', 'payment'),
            self::PAYMENT_RECORD_STATUS_PAYED       => __('支付完成', 'payment'),
            self::PAYMENT_RECORD_STATUS_PROGRESS    => __('支付进行中', 'payment'),
            self::PAYMENT_RECORD_STATUS_FAIL        => __('支付失败', 'payment'),
            self::PAYMENT_RECORD_STATUS_CANCEL      => __('订单撤消', 'payment'),
            self::PAYMENT_RECORD_STATUS_REFUND      => __('订单退款', 'payment'),
        ];
    }

}
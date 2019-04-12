<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 10:26
 */

namespace Ecjia\App\Payment\Refund;

use Ecjia\App\Payment\Contracts\RefundPayment;
use Ecjia\App\Payment\PaymentManagerAbstract;
use ecjia_error;

class RefundManager extends PaymentManagerAbstract
{

    protected $total_fee;

    protected $operator;

    /**
     * 原路退回
     * @param $total_fee
     * @param $operator
     * @return \Ecjia\System\Plugin\AbstractPlugin|ecjia_error|mixed
     */
    public function refund($total_fee, $operator)
    {
        $this->total_fee = $total_fee;
        $this->operator = $operator;

        return $this->initPaymentRecord();
    }

    /**
     * 强制退款到余额
     *
     * @param $total_fee
     * @param $operator
     */
    public function refundToBalance($total_fee, $operator)
    {
        $this->payCode = 'pay_balance';

        return $this->refund($total_fee, $operator);
    }


    /**
     * 退款插件处理
     *
     * @return array|ecjia_error
     */
    protected function doPluginHandler()
    {
        if (! ($this->pluginHandler instanceof RefundPayment)) {
            return new ecjia_error('payment_plugin_not_support_refund_payment', $this->pluginHandler->getName().__('支付方式不支持退款操作', 'payment'));
        }

        $order_trade_no = $this->paymentRecord->order_trade_no ?: $this->paymentRecord->order_sn;

        $result = $this->pluginHandler->refund($order_trade_no, $this->total_fee, $this->operator);

        return $this->updateRefundStatus($result);
    }

    /**
     * 更新交易流水记录中的退款状态
     *
     * @param array $result
     */
    protected function updateRefundStatus($result)
    {
        return $result;
    }

}
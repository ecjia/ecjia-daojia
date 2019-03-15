<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 10:26
 */

namespace Ecjia\App\Payment\Refund;

use Ecjia\App\Payment\Contracts\CancelPayment;
use Ecjia\App\Payment\PaymentManagerAbstract;
use ecjia_error;

class CancelManager extends PaymentManagerAbstract
{

    public function cancel()
    {
        return $this->initPaymentRecord();
    }

    /**
     * 退款插件处理
     *
     * @return array|ecjia_error
     */
    protected function doPluginHandler()
    {
        if (! ($this->pluginHandler instanceof CancelPayment)) {
            return new ecjia_error('payment_plugin_not_support_cancel_payment', $this->pluginHandler->getName().__('支付方式不支持支付撤单操作', 'payment'));
        }

        $result = $this->pluginHandler->cancel($this->paymentRecord->order_trade_no);

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
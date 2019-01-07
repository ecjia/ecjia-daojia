<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 10:26
 */

namespace Ecjia\App\Payment\Pay;

use Ecjia\App\Payment\Contracts\PayPayment;
use Ecjia\App\Payment\PaymentManagerAbstract;
use ecjia_error;

class PayManager extends PaymentManagerAbstract
{

    public function pay()
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
        if (! ($this->pluginHandler instanceof PayPayment)) {
            return new ecjia_error('payment_plugin_not_support_pay_payment', $this->pluginHandler->getName().'支付方式不支持付款操作');
        }

        $result = $this->pluginHandler->pay($this->paymentRecord->order_trade_no);

        return $result;
    }

}
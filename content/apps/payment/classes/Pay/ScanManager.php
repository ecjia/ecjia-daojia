<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 10:26
 */

namespace Ecjia\App\Payment\Pay;

use Ecjia\App\Payment\Contracts\ScanPayment;
use Ecjia\App\Payment\PaymentManagerAbstract;
use ecjia_error;

class ScanManager extends PaymentManagerAbstract
{

    protected $dynamic_code;

    public function scan($dynamic_code)
    {
        $this->dynamic_code = $dynamic_code;

        return $this->initPaymentRecord();
    }

    /**
     * 退款插件处理
     *
     * @return array|ecjia_error
     */
    protected function doPluginHandler()
    {
        if (! ($this->pluginHandler instanceof ScanPayment)) {
            return new ecjia_error('payment_plugin_not_support_scan_payment', $this->pluginHandler->getName().'支付方式不支持扫码收款操作');
        }

        $result = $this->pluginHandler->scan($this->paymentRecord->order_trade_no, $this->dynamic_code);

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
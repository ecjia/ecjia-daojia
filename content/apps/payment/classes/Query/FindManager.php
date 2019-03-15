<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 20:28
 */

namespace Ecjia\App\Payment\Query;

use Ecjia\App\Payment\Contracts\FindPayment;
use Ecjia\App\Payment\PaymentManagerAbstract;
use ecjia_error;

class FindManager extends PaymentManagerAbstract
{

    public function find()
    {
        return $this->initPaymentRecord();
    }

    /**
     * 插件查询订单处理
     *
     * @return array|ecjia_error
     */
    protected function doPluginHandler()
    {
        if (! ($this->pluginHandler instanceof FindPayment)) {
            return new ecjia_error('payment_plugin_not_support__cancel_payment', $this->pluginHandler->getName().__('支付方式不支持查询操作', 'payment'));
        }

        $result = $this->pluginHandler->find($this->paymentRecord->order_trade_no);

        return $result;
    }

}
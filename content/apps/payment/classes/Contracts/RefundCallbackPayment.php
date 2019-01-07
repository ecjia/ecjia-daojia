<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 13:32
 */
namespace Ecjia\App\Payment\Contracts;

interface RefundCallbackPayment
{

    /**
     * 第三方支付退款请求异步回调通知地址
     */
    public function refundNotifyUrl();

    /**
     * 第三方支付退款请求异步回调通知 POST方式
     */
    public function refundCallback();

}
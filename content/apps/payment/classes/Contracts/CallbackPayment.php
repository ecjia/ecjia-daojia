<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/27
 * Time: 13:32
 */
namespace Ecjia\App\Payment\Contracts;

interface CallbackPayment
{

    /**
     * 支付服务器异步回调通知地址
     */
    public function notifyUrl();

    /**
     * 支付服务器同步回调响应地址
     */
    public function callbackUrl();

    /**
     * 支付服务器异步回调通知 POST方式
     */
    public function notify();

    /**
     * 支付服务器同步回调响应 GET方式
     */
    public function response();

}
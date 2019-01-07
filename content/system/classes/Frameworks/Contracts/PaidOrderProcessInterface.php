<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/14
 * Time: 15:27
 */

namespace Ecjia\System\Frameworks\Contracts;


interface PaidOrderProcessInterface
{

    /**
     * 获取订单信息
     *
     * @return array
     */
    public function getOrderInfo();


    /**
     * 获取支付数据
     */
    public function getPaymentData();


    /**
     * 获取打印数据
     */
    public function getPrintData();


}
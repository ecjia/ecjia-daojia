<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/31
 * Time: 11:20 AM
 */

namespace Ecjia\System\Business\Orders;


class OrderSnGeneration
{
    /**
     * 普通购买订单
     */
    const ORDER_BUY         = 10;

    /**
     * 普通订单用来分单的订单号
     */
    const ORDER_SEPARATE    = 11;

    /**
     * 快速买单订单
     */
    const ORDER_QUICKPAY    = 20;

    /**
     * 会员充值订单
     */
    const ORDER_DEPOSIT     = 30;

    /**
     * 商家提现订单
     */
    const ORDER_STORE_ACCOUNT = 40;

    /**
     * 退款订单
     */
    const ORDER_REFUND      = 90;

    /**
     * 发货单号订单
     */
    const ORDER_DELIVERY    = 16;

    /**
     * 配送订单号
     */
    const ORDER_EXPRESS     = 17;


    protected $order_type;

    public function __construct($order_type)
    {
        $this->order_type = $order_type;


    }

    /**
     * 生成24位唯一订单号码，格式：TT-YYYY-MMDD-HHII-SS-NNNN,NN-CC，
     * 其中：TT=订单类型，YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNN=随机数，CC=检查码
     *
     * @return string
     */
    public function generation()
    {

        //订购日期

        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

        $order_id_main = date('YmdHis', SYS_TIME) . rand(100000, 999999);

        //订单号码主体长度

        $order_id_len = strlen($order_id_main);

        $order_id_sum = 0;

        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i,1));
        }

        //生成校验码CC
        $order_cc = str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);

        //唯一订单号码（TTYYYYMMDDHHIISSNNNNNNNNCC）

        $order_SN = $this->order_type . $order_id_main . $order_cc;

        return $order_SN;
    }

}
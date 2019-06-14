<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19/5/20 020
 * Time: 11:17
 */

namespace Ecjia\App\Commission;


/**
 * 商家账户订单，结算，提现，充值（所有storeAccount收支）都对应产生订单
 * Class StoreAccountOrder
 * @package Ecjia\App\Commission
 */
class StoreAccountOrder
{

    const PROCESS_TYPE_DEPOSIT  = 'deposit';    //充值
    const PROCESS_TYPE_WITHDRAW = 'withdraw';   //提现
    const PROCESS_TYPE_BILL     = 'bill';       //结算
    const PROCESS_TYPE_ORDER    = 'order';      //购买订单
    const PROCESS_TYPE_REFUND   = 'refund';     //退款

    const BILL_ORDER_TYPE_BUY      = 'buy'; //普通订单
    const BILL_ORDER_TYPE_QUICKPAY = 'quickpay'; //优惠买单
    const BILL_ORDER_TYPE_REFUND   = 'refund'; //退款



}
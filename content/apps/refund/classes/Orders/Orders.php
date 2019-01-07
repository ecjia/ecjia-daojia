<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/24
 * Time: 16:57
 */

namespace Ecjia\App\Refund\Orders;


class Orders
{

    protected $store_id;

    protected $user_id;
    protected $user_name;

    protected $order_type;
    protected $order_id;
    protected $order_sn;

    protected $pay_code;
    protected $pay_name;
    protected $pay_fee;

    protected $goods_amount;

    protected $bonus_id;
    protected $bonus;

    protected $surplus;

    protected $integral;
    protected $integral_money;

    protected $discount;

    protected $inv_tax;

    protected $order_amount;

    protected $money_paid;

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * @param mixed $store_id
     */
    public function setStoreId($store_id)
    {
        $this->store_id = $store_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getOrderType()
    {
        return $this->order_type;
    }

    /**
     * @param mixed $order_type
     */
    public function setOrderType($order_type)
    {
        $this->order_type = $order_type;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * @return mixed
     */
    public function getOrderSn()
    {
        return $this->order_sn;
    }

    /**
     * @param mixed $order_sn
     */
    public function setOrderSn($order_sn)
    {
        $this->order_sn = $order_sn;
    }

    /**
     * @return mixed
     */
    public function getPayCode()
    {
        return $this->pay_code;
    }

    /**
     * @param mixed $pay_code
     */
    public function setPayCode($pay_code)
    {
        $this->pay_code = $pay_code;
    }

    /**
     * @return mixed
     */
    public function getPayName()
    {
        return $this->pay_name;
    }

    /**
     * @param mixed $pay_name
     */
    public function setPayName($pay_name)
    {
        $this->pay_name = $pay_name;
    }

    /**
     * @return mixed
     */
    public function getPayFee()
    {
        return $this->pay_fee;
    }

    /**
     * @param mixed $pay_fee
     */
    public function setPayFee($pay_fee)
    {
        $this->pay_fee = $pay_fee;
    }

    /**
     * @return mixed
     */
    public function getGoodsAmount()
    {
        return $this->goods_amount;
    }

    /**
     * @param mixed $goods_amount
     */
    public function setGoodsAmount($goods_amount)
    {
        $this->goods_amount = $goods_amount;
    }

    /**
     * @return mixed
     */
    public function getBonusId()
    {
        return $this->bonus_id;
    }

    /**
     * @param mixed $bonus_id
     */
    public function setBonusId($bonus_id)
    {
        $this->bonus_id = $bonus_id;
    }

    /**
     * @return mixed
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * @param mixed $bonus
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;
    }

    /**
     * @return mixed
     */
    public function getSurplus()
    {
        return $this->surplus;
    }

    /**
     * @param mixed $surplus
     */
    public function setSurplus($surplus)
    {
        $this->surplus = $surplus;
    }

    /**
     * @return mixed
     */
    public function getIntegral()
    {
        return $this->integral;
    }

    /**
     * @param mixed $integral
     */
    public function setIntegral($integral)
    {
        $this->integral = $integral;
    }

    /**
     * @return mixed
     */
    public function getIntegralMoney()
    {
        return $this->integral_money;
    }

    /**
     * @param mixed $integral_money
     */
    public function setIntegralMoney($integral_money)
    {
        $this->integral_money = $integral_money;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getInvTax()
    {
        return $this->inv_tax;
    }

    /**
     * @param mixed $inv_tax
     */
    public function setInvTax($inv_tax)
    {
        $this->inv_tax = $inv_tax;
    }

    /**
     * @return mixed
     */
    public function getOrderAmount()
    {
        return $this->order_amount;
    }

    /**
     * @param mixed $order_amount
     */
    public function setOrderAmount($order_amount)
    {
        $this->order_amount = $order_amount;
    }

    /**
     * @return mixed
     */
    public function getMoneyPaid()
    {
        return $this->money_paid;
    }

    /**
     * @param mixed $money_paid
     */
    public function setMoneyPaid($money_paid)
    {
        $this->money_paid = $money_paid;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/24
 * Time: 17:05
 */

namespace Ecjia\App\Refund\Orders;

/**
 * 退款退货订单
 *
 * Class ReturnOrders
 * @package Ecjia\App\Refund\Orders
 */
class ReturnOrders extends RefundOrders
{

    protected $refund_type = 'return';


    protected $shipping_code;

    protected $shipping_name;

    protected $shipping_fee;

    protected $shipping_whether;

    protected $insure_fee;


    protected $return_status;
    protected $return_time;
    protected $return_shipping_range;
    protected $return_shipping_type;
    protected $return_shipping_value;

    /**
     * @return mixed
     */
    public function getShippingCode()
    {
        return $this->shipping_code;
    }

    /**
     * @param mixed $shipping_code
     */
    public function setShippingCode($shipping_code)
    {
        $this->shipping_code = $shipping_code;
    }

    /**
     * @return mixed
     */
    public function getShippingName()
    {
        return $this->shipping_name;
    }

    /**
     * @param mixed $shipping_name
     */
    public function setShippingName($shipping_name)
    {
        $this->shipping_name = $shipping_name;
    }

    /**
     * @return mixed
     */
    public function getShippingFee()
    {
        return $this->shipping_fee;
    }

    /**
     * @param mixed $shipping_fee
     */
    public function setShippingFee($shipping_fee)
    {
        $this->shipping_fee = $shipping_fee;
    }

    /**
     * @return mixed
     */
    public function getShippingWhether()
    {
        return $this->shipping_whether;
    }

    /**
     * @param mixed $shipping_whether
     */
    public function setShippingWhether($shipping_whether)
    {
        $this->shipping_whether = $shipping_whether;
    }

    /**
     * @return mixed
     */
    public function getInsureFee()
    {
        return $this->insure_fee;
    }

    /**
     * @param mixed $insure_fee
     */
    public function setInsureFee($insure_fee)
    {
        $this->insure_fee = $insure_fee;
    }

    /**
     * @return mixed
     */
    public function getReturnStatus()
    {
        return $this->return_status;
    }

    /**
     * @param mixed $return_status
     */
    public function setReturnStatus($return_status)
    {
        $this->return_status = $return_status;
    }

    /**
     * @return mixed
     */
    public function getReturnTime()
    {
        return $this->return_time;
    }

    /**
     * @param mixed $return_time
     */
    public function setReturnTime($return_time)
    {
        $this->return_time = $return_time;
    }

    /**
     * @return mixed
     */
    public function getReturnShippingRange()
    {
        return $this->return_shipping_range;
    }

    /**
     * @param mixed $return_shipping_range
     */
    public function setReturnShippingRange($return_shipping_range)
    {
        $this->return_shipping_range = $return_shipping_range;
    }

    /**
     * @return mixed
     */
    public function getReturnShippingType()
    {
        return $this->return_shipping_type;
    }

    /**
     * @param mixed $return_shipping_type
     */
    public function setReturnShippingType($return_shipping_type)
    {
        $this->return_shipping_type = $return_shipping_type;
    }

    /**
     * @return mixed
     */
    public function getReturnShippingValue()
    {
        return $this->return_shipping_value;
    }

    /**
     * @param mixed $return_shipping_value
     */
    public function setReturnShippingValue($return_shipping_value)
    {
        $this->return_shipping_value = $return_shipping_value;
    }


    
}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/24
 * Time: 16:57
 */

namespace Ecjia\App\Refund\Orders;

/**
 * 仅退款订单
 *
 * Class RefundOrders
 * @package Ecjia\App\Refund\Orders
 */
class RefundOrders extends Orders
{
    protected $refund_type = 'refund';

    protected $refund_id;
    protected $refund_sn;


    protected $status;
    protected $refund_status;
    protected $refund_content;
    protected $refund_reason;
    protected $refund_time;


    protected $add_time;
    protected $last_submit_time;
    protected $referer;

    /**
     * @return mixed
     */
    public function getRefundId()
    {
        return $this->refund_id;
    }

    /**
     * @param mixed $refund_id
     */
    public function setRefundId($refund_id)
    {
        $this->refund_id = $refund_id;
    }

    /**
     * @return mixed
     */
    public function getRefundSn()
    {
        return $this->refund_sn;
    }

    /**
     * @param mixed $refund_sn
     */
    public function setRefundSn($refund_sn)
    {
        $this->refund_sn = $refund_sn;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getRefundStatus()
    {
        return $this->refund_status;
    }

    /**
     * @param mixed $refund_status
     */
    public function setRefundStatus($refund_status)
    {
        $this->refund_status = $refund_status;
    }

    /**
     * @return mixed
     */
    public function getRefundContent()
    {
        return $this->refund_content;
    }

    /**
     * @param mixed $refund_content
     */
    public function setRefundContent($refund_content)
    {
        $this->refund_content = $refund_content;
    }

    /**
     * @return mixed
     */
    public function getRefundReason()
    {
        return $this->refund_reason;
    }

    /**
     * @param mixed $refund_reason
     */
    public function setRefundReason($refund_reason)
    {
        $this->refund_reason = $refund_reason;
    }

    /**
     * @return mixed
     */
    public function getRefundTime()
    {
        return $this->refund_time;
    }

    /**
     * @param mixed $refund_time
     */
    public function setRefundTime($refund_time)
    {
        $this->refund_time = $refund_time;
    }

    /**
     * @return mixed
     */
    public function getAddTime()
    {
        return $this->add_time;
    }

    /**
     * @param mixed $add_time
     */
    public function setAddTime($add_time)
    {
        $this->add_time = $add_time;
    }

    /**
     * @return mixed
     */
    public function getLastSubmitTime()
    {
        return $this->last_submit_time;
    }

    /**
     * @param mixed $last_submit_time
     */
    public function setLastSubmitTime($last_submit_time)
    {
        $this->last_submit_time = $last_submit_time;
    }

    /**
     * @return mixed
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * @param mixed $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }


}
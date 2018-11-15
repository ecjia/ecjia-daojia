<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/1
 * Time: 10:41 AM
 */

namespace Royalcms\Component\Shouqianba\Gateways\Shouqianba\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class RefundOrder implements PayloadInterface
{

    protected $terminal_sn;
    protected $sn;
    protected $client_sn;
    protected $client_tsn;
    protected $refund_request_no;
    protected $operator;
    protected $refund_amount;
    protected $extended;
    protected $goods_details;

    /**
     * @return mixed
     */
    public function getTerminalSn()
    {
        return $this->terminal_sn;
    }

    /**
     * @param mixed $terminal_sn
     */
    public function setTerminalSn($terminal_sn)
    {
        $this->terminal_sn = $terminal_sn;
    }

    /**
     * @return mixed
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * @param mixed $sn
     */
    public function setSn($sn)
    {
        $this->sn = $sn;
    }

    /**
     * @return mixed
     */
    public function getClientSn()
    {
        return $this->client_sn;
    }

    /**
     * @param mixed $client_sn
     */
    public function setClientSn($client_sn)
    {
        $this->client_sn = $client_sn;
    }

    /**
     * @return mixed
     */
    public function getClientTsn()
    {
        return $this->client_tsn;
    }

    /**
     * @param mixed $client_tsn
     */
    public function setClientTsn($client_tsn)
    {
        $this->client_tsn = $client_tsn;
    }

    /**
     * @return mixed
     */
    public function getRefundRequestNo()
    {
        return $this->refund_request_no;
    }

    /**
     * @param mixed $refund_request_no
     */
    public function setRefundRequestNo($refund_request_no)
    {
        $this->refund_request_no = $refund_request_no;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }

    /**
     * @return mixed
     */
    public function getRefundAmount()
    {
        return $this->refund_amount;
    }

    /**
     * @param mixed $refund_amount
     */
    public function setRefundAmount($refund_amount)
    {
        $this->refund_amount = $refund_amount;
    }

    /**
     * @return mixed
     */
    public function getExtended()
    {
        return $this->extended;
    }

    /**
     * @param mixed $extended
     */
    public function setExtended($extended)
    {
        $this->extended = $extended;
    }

    /**
     * @return mixed
     */
    public function getGoodsDetails()
    {
        return $this->goods_details;
    }

    /**
     * @param mixed $goods_details
     */
    public function setGoodsDetails($goods_details)
    {
        $this->goods_details = $goods_details;
    }


    /**
     * 对象转换成数组输出
     *
     * @return array
     */
    public function toArray()
    {
        $result = [
            'terminal_sn'       => $this->getTerminalSn(),
            'sn'                => $this->getSn(),
            'client_sn'         => $this->getClientSn(),
            'client_tsn'        => $this->getClientTsn(),
            'refund_request_no' => $this->getRefundRequestNo(),
            'operator'          => $this->getOperator(),
            'refund_amount'     => $this->getRefundAmount(),
            'extended'          => $this->getExtended(),
            'goods_details'     => $this->getGoodsDetails(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}
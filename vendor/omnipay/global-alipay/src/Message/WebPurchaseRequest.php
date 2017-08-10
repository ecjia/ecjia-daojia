<?php

namespace Omnipay\GlobalAlipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\GlobalAlipay\Helper;

class WebPurchaseRequest extends AbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'key',
            'partner',
            'notify_url',
            'subject',
            'out_trade_no'
        );

        if ($this->getTotalFee() && $this->getRmbFee()) {
            throw new InvalidRequestException("The 'total_fee' and 'rmb_fee' parameter can not be provide together");
        }

        if (! $this->getTotalFee() && ! $this->getRmbFee()) {
            throw new InvalidRequestException("The 'total_fee' and 'rmb_fee' must be provide one of them");
        }

        $data = array (
            'service'               => 'create_forex_trade',
            'partner'               => $this->getPartner(),
            'notify_url'            => $this->getNotifyUrl(),
            'return_url'            => $this->getReturnUrl(),//<>
            'sign_type'             => $this->getSignType() ?: 'MD5',
            'subject'               => $this->getSubject(),
            '_input_charset'        => $this->getInputCharset() ?: 'utf-8',//<>
            'body'                  => $this->getBody(),//<>
            'out_trade_no'          => $this->getOutTradeNo(),
            'currency'              => $this->getCurrency() ?: 'USD',
            'total_fee'             => $this->getTotalFee(),
            'rmb_fee'               => $this->getRmbFee(),//<>
            'supplier'              => $this->getSupplier(),//<>
            'order_gmt_create'      => $this->getOrderGmtCreate(),//<>
            'order_valid_time'      => $this->getOrderValidTime(),//<>
            'timeout_rule'          => $this->getTimeoutRule(),//<>
            'specified_pay_channel' => $this->getSpecifiedPayChannel(),//<>
            'seller_id'             => $this->getSellerId(),//<>
            'seller_name'           => $this->getSellerIndustry(),//<>
            'split_fund_info'       => $this->getSplitFundInfo(),
            'product_code'          => $this->getProductCode(),
        );

        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, 'MD5', $this->getKey());

        return $data;
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $responseData = array ();

        return $this->response = new WebPurchaseResponse($this, $responseData);
    }


    public function getKey()
    {
        return $this->getParameter('key');
    }


    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }


    public function getPartner()
    {
        return $this->getParameter('partner');
    }


    public function setPartner($value)
    {
        return $this->setParameter('partner', $value);
    }


    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }


    public function getReturnUrl()
    {
        return $this->getParameter('return_url');
    }


    public function setReturnUrl($value)
    {
        return $this->setParameter('return_url', $value);
    }


    public function getSignType()
    {
        return $this->getParameter('sign_type');
    }


    public function setSignType($value)
    {
        return $this->setParameter('sign_type', $value);
    }


    public function getSubject()
    {
        return $this->getParameter('subject');
    }


    public function setSubject($value)
    {
        return $this->setParameter('subject', $value);
    }


    public function getInputCharset()
    {
        return $this->getParameter('input_charset');
    }


    public function setInputCharset($value)
    {
        return $this->setParameter('input_charset', $value);
    }


    public function getBody()
    {
        return $this->getParameter('body');
    }


    public function setBody($value)
    {
        return $this->setParameter('body', $value);
    }


    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }


    public function setOutTradeNo($value)
    {
        return $this->setParameter('out_trade_no', $value);
    }


    public function getTotalFee()
    {
        return $this->getParameter('total_fee');
    }


    public function setTotalFee($value)
    {
        return $this->setParameter('total_fee', $value);
    }


    public function getRmbFee()
    {
        return $this->getParameter('rmb_fee');
    }


    public function setRmbFee($value)
    {
        return $this->setParameter('rmb_fee', $value);
    }


    public function getSupplier()
    {
        return $this->getParameter('supplier');
    }


    public function setSupplier($value)
    {
        return $this->setParameter('supplier', $value);
    }


    public function getOrderGmtCreate()
    {
        return $this->getParameter('order_gmt_create');
    }


    /**
     * @param string $value YYYY-MM-DD HH:MM:SS
     *
     * @return AbstractRequest
     */
    public function setOrderGmtCreate($value)
    {
        return $this->setParameter('order_gmt_create', $value);
    }


    public function getOrderValidTime()
    {
        return $this->getParameter('order_valid_time');
    }


    /**
     * @param int $value second (max=21600)
     *
     * @return AbstractRequest
     */
    public function setOrderValidTime($value)
    {
        return $this->setParameter('order_valid_time', $value);
    }


    public function getTimeoutRule()
    {
        return $this->getParameter('timeout_rule');
    }


    /**
     * @param $value 5m 10m 15m 30m 1h 2h 3h 5h 10h 12h(default)
     *
     * @return AbstractRequest
     */
    public function setTimeoutRule($value)
    {
        return $this->setParameter('timeout_rule', $value);
    }


    public function getSpecifiedPayChannel()
    {
        return $this->getParameter('specified_pay_channel');
    }


    public function setSpecifiedPayChannel($value)
    {
        return $this->setParameter('specified_pay_channel', $value);
    }


    public function getSellerId()
    {
        return $this->getParameter('seller_id');
    }


    public function setSellerId($value)
    {
        return $this->setParameter('seller_id', $value);
    }


    public function getSellerName()
    {
        return $this->getParameter('seller_name');
    }


    public function setSellerName($value)
    {
        return $this->setParameter('seller_name', $value);
    }


    public function getSellerIndustry()
    {
        return $this->getParameter('seller_industry');
    }


    public function setSellerIndustry($value)
    {
        return $this->setParameter('seller_industry', $value);
    }


    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }


    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }


    public function getSplitFundInfo()
    {
        return $this->getParameter('split_fund_info');
    }


    public function setSplitFundInfo(array $value = array())
    {
        return $this->setParameter('split_fund_info', json_encode($value));
    }


    public function getProductCode()
    {
        return $this->getParameter('product_code');
    }


    public function setProductCode($value)
    {
        return $this->setParameter('product_code', $value);
    }
}

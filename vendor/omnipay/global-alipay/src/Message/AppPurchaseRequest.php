<?php

namespace Omnipay\GlobalAlipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class AppPurchaseRequest extends AbstractRequest
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
            'partner',
            'out_trade_no',
            'subject',
            'seller_id',
            'body'
        );

        if ($this->getTotalFee() && $this->getRmbFee()) {
            throw new InvalidRequestException("The 'total_fee' and 'rmb_fee' parameter can not be provide together");
        }

        if (! $this->getTotalFee() && ! $this->getRmbFee()) {
            throw new InvalidRequestException("The 'total_fee' and 'rmb_fee' must be provide one of them");
        }

        $data = array (
            'service'        => 'mobile.securitypay.pay',
            'partner'        => $this->getPartner(),
            '_input_charset' => $this->getInputCharset() ?: 'utf-8',//<>
            'sign_type'      => 'RSA',
            'notify_url'     => $this->getNotifyUrl(),//<>
            'app_id'         => $this->getAppId(),//<>
            'appenv'         => $this->getAppEnv(),//<>
            'out_trade_no'   => $this->getOutTradeNo(),
            'subject'        => $this->getSubject(),
            'payment_type'   => $this->getPaymentType() ?: 1,
            'seller_id'      => $this->getSellerId(),
            'total_fee'      => $this->getTotalFee(),
            'rmb_fee'        => $this->getRmbFee(),//<>
            'forex_biz'      => $this->getForexBiz() ?: 'FP',
            'currency'       => $this->getCurrency() ?: 'USD',
            'body'           => $this->getBody(),
            'it_b_pay'       => $this->getItBPay() ?: '1d',
            'show_url'       => $this->getShowUrl(),//<>
            'extern_token'   => $this->getExternToken(),//<>
        );

        $data = array_filter($data);

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

        return $this->response = new AppPurchaseResponse($this, $responseData);
    }


    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }


    public function setPrivateKey($value)
    {
        return $this->setParameter('private_key', $value);
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


    public function getSubject()
    {
        return $this->getParameter('subject');
    }


    public function setSubject($value)
    {
        return $this->setParameter('subject', $value);
    }


    public function getPaymentType()
    {
        return $this->getParameter('payment_type');
    }


    public function setPaymentType($value)
    {
        return $this->setParameter('payment_type', $value);
    }


    public function getInputCharset()
    {
        return $this->getParameter('input_charset');
    }


    public function setInputCharset($value)
    {
        return $this->setParameter('input_charset', $value);
    }


    public function getAppId()
    {
        return $this->getParameter('app_id');
    }


    public function setAppId($value)
    {
        return $this->setParameter('app_id', $value);
    }


    public function getAppEnv()
    {
        return $this->getParameter('app_env');
    }


    public function setAppEnv($value)
    {
        return $this->setParameter('app_env', $value);
    }


    public function getBody()
    {
        return $this->getParameter('body');
    }


    public function setBody($value)
    {
        return $this->setParameter('body', $value);
    }


    public function getItBPay()
    {
        return $this->getParameter('it_b_pay');
    }


    public function setItBPay($value)
    {
        return $this->setParameter('it_b_pay', $value);
    }


    public function getShowUrl()
    {
        return $this->getParameter('show_url');
    }


    public function setShowUrl($value)
    {
        return $this->setParameter('show_url', $value);
    }


    public function getExternToken()
    {
        return $this->getParameter('extern_token');
    }


    public function setExternToken($value)
    {
        return $this->setParameter('extern_token', $value);
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


    public function getForexBiz()
    {
        return $this->getParameter('forex_biz');
    }


    public function setForexBiz($value)
    {
        return $this->setParameter('forex_biz', $value);
    }


    public function getSellerId()
    {
        return $this->getParameter('seller_id');
    }


    public function setSellerId($value)
    {
        return $this->setParameter('seller_id', $value);
    }
}

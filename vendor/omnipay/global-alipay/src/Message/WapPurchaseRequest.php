<?php

namespace Omnipay\GlobalAlipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\GlobalAlipay\Helper;

class WapPurchaseRequest extends AbstractRequest
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
            'subject'
        );

        $signType = strtoupper($this->getSignType() ?: 'MD5');

        if ($signType == 'MD5') {
            $this->validate('key');
        } else {
            $this->validate('private_key');
        }

        if ($this->getTotalFee() && $this->getRmbFee()) {
            throw new InvalidRequestException("The 'total_fee' and 'rmb_fee' parameter can not be provide together");
        }

        if (! $this->getTotalFee() && ! $this->getRmbFee()) {
            throw new InvalidRequestException("The 'total_fee' and 'rmb_fee' must be provide one of them");
        }

        $data = array (
            'service'         => 'create_forex_trade_wap',
            'partner'         => $this->getPartner(),
            '_input_charset'  => $this->getInputCharset() ?: 'utf-8',//<>
            'sign_type'       => $signType,
            'notify_url'      => $this->getNotifyUrl(),//<>
            'return_url'      => $this->getReturnUrl(),//<>
            'out_trade_no'    => $this->getOutTradeNo(),
            'currency'        => $this->getCurrency() ?: 'USD',
            'subject'         => $this->getSubject(),
            'total_fee'       => $this->getTotalFee(),//<>
            'rmb_fee'         => $this->getRmbFee(),//<>
            'supplier'        => $this->getSupplier(),//<>
            'timeout_rule'    => $this->getTimeoutRule(),//<>
            'body'            => $this->getBody(),//<>
            'product_code'    => $this->getProductCode(),
            'split_fund_info' => $this->getSplitFundInfo(),
        );

        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, $signType, $this->getSignKey($signType));

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

        return $this->response = new WapPurchaseResponse($this, $responseData);
    }


    public function getKey()
    {
        return $this->getParameter('key');
    }


    public function setKey($value)
    {
        return $this->setParameter('key', $value);
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


    public function getProductCode()
    {
        return $this->getParameter('product_code');
    }


    public function setProductCode($value)
    {
        return $this->setParameter('product_code', $value);
    }


    public function getSplitFundInfo()
    {
        return $this->getParameter('split_fund_info');
    }


    public function setSplitFundInfo(array $value = array())
    {
        return $this->setParameter('split_fund_info', json_encode($value));
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


    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }


    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }


    /**
     * @param $signType
     *
     * @return mixed
     */
    protected function getSignKey($signType)
    {
        if ($signType == 'MD5') {
            $key = $this->getKey();

            return $key;
        } else {
            $key = $this->getPrivateKey();

            return $key;
        }
    }
}

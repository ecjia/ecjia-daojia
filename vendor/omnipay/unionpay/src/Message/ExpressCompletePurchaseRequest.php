<?php

namespace Omnipay\UnionPay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\UnionPay\Helper;

/**
 * Class ExpressCompletePurchaseRequest
 * @package Omnipay\UnionPay\Message
 */
class ExpressCompletePurchaseRequest extends AbstractExpressRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->getRequestParams();
    }


    public function setRequestParams($value)
    {
        $this->setParameter('request_params', $value);
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }


    public function setCertDir($value)
    {
        $this->setParameter('certDir', $value);
    }


    public function getCertDir()
    {
        return $this->getParameter('certDir');
    }


    public function getRequestParam($key)
    {
        $params = $this->getRequestParams();
        if (isset($params[$key])) {
            return $params[$key];
        } else {
            return null;
        }
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
        $data['verify_success'] = Helper::verify($this->getRequestParams(), $this->getCertDir());
        $data['is_paid']        = $data['verify_success'] && ($this->getRequestParam('respCode') == '00');

        return $this->response = new ExpressCompletePurchaseResponse($this, $data);
    }
}

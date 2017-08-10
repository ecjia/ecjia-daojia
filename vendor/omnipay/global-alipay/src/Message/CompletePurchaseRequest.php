<?php

namespace Omnipay\GlobalAlipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\GlobalAlipay\Helper;

class CompletePurchaseRequest extends AbstractRequest
{

    protected $endpoint = 'http://notify.alipay.com/trade/notify_query.do?';

    protected $endpointHttps = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validateParam('sign_type', 'sign', 'out_trade_no');

        $transport = strtolower($this->getTransport() ?: 'http');
        $signType  = $this->getRequestParam('sign_type');

        if ($transport == 'https') {
            $this->validate('ca_cert_path');
        }

        if ($signType == 'MD5') {
            $this->validate('key');
        } else {
            $this->validate('private_key');
        }

        $data = array (
            'request_params' => $this->getRequestParams()
        );

        return $data;
    }


    public function validateParam()
    {
        foreach (func_get_args() as $key) {
            $value = $this->getRequestParam($key);
            if (empty($value)) {
                throw new InvalidRequestException("The $key of request_params is required");
            }
        }
    }


    public function setRequestParams($value)
    {
        $this->setParameter('request_params', $value);
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
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


    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }


    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }


    public function getTransport()
    {
        return $this->getParameter('transport');
    }


    public function setTransport($value)
    {
        return $this->setParameter('transport', $value);
    }


    public function getCaCertPath()
    {
        return $this->getParameter('ca_cert_path');
    }


    public function setCaCertPath($value)
    {
        return $this->setParameter('ca_cert_path', $value);
    }


    protected function getRequestParam($key)
    {
        $params = $this->getRequestParams();

        return isset($params[$key]) ? $params[$key] : null;
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
        $data = $this->getRequestParams();

        $signType = strtoupper($this->getRequestParam('sign_type'));

        $sign = Helper::sign($data, $signType, $this->getSignKey($signType));

        $notifyId = $this->getRequestParam('notify_id');

        /**
         * is sign match?
         */
        if (isset($data['sign']) && $data['sign'] && $sign === $data['sign']) {
            $signMatch = true;
        } else {
            $signMatch = false;
        }

        /**
         * Verify through Alipay server if exists notify_id
         */
        if ($notifyId) {
            $verifyResponse = $this->getVerifyResponse($notifyId);
            $verifyOk       = $this->isNotifyVerifiedOK($verifyResponse);
        } else {
            $verifyOk = true;
        }

        /**
         * is paid?
         */
        if ($signMatch && $verifyOk && isset($data['trade_status']) && $data['trade_status'] == 'TRADE_FINISHED') {
            $paid = true;
        } else {
            $paid = false;
        }

        $responseData = array (
            'sign_match'          => $signMatch,
            'notify_id_verify_ok' => $verifyOk,
            'paid'                => $paid,
        );

        return $this->response = new CompletePurchaseResponse($this, $responseData);
    }


    protected function isNotifyVerifiedOK($verifyResponse)
    {
        if (preg_match("/true$/i", $verifyResponse)) {
            return true;
        } else {
            return false;
        }
    }


    private function getVerifyResponse($notifyId)
    {
        $partner  = $this->getPartner();
        $endpoint = $this->getEndpoint();

        $url = "{$endpoint}partner={$partner}&notify_id={$notifyId}";

        $response = $this->getHttpResponseGET($url, $this->getCacertPath());

        return $response;
    }


    private function getHttpResponseGET($url, $caCertUrl)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CAINFO, $caCertUrl);
        $responseText = curl_exec($curl);
        curl_close($curl);

        return $responseText;
    }


    private function getEndpoint()
    {
        $transport = strtolower($this->getTransport() ?: 'http');

        if (strtolower($transport) == 'http') {
            return $this->endpoint;
        } else {
            return $this->endpointHttps;
        }
    }


    /**
     * @param $signType
     *
     * @return mixed
     */
    protected function getSignKey($signType)
    {
        if ($signType == 'MD5') {
            return $this->getKey();
        } else {
            return $this->getPrivateKey();
        }
    }
}

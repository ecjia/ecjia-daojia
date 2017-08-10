<?php

namespace Omnipay\GlobalAlipay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\GlobalAlipay\Helper;

class AppPurchaseResponse extends AbstractResponse
{

    /**
     * The embodied request object.
     *
     * @var AppPurchaseRequest
     */
    protected $request;


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return true;
    }


    private function getOrderQuery($data)
    {
        unset($data['sign']);
        unset($data['sign_type']);

        ksort($data);

        $str = http_build_query($data);
        $str = str_replace('&', '"&', $str);
        $str = str_replace('=', '="', $str) . '"';
        $str = urldecode($str);

        return $str;
    }


    public function getOrderString()
    {
        $query = $this->getOrderQuery($this->request->getData());

        $sign = Helper::signWithRSA($query, $this->request->getPrivateKey());

        return sprintf('%s&sign="%s"&sign_type="RSA"', $query, urlencode($sign));
    }
}

<?php

namespace Omnipay\GlobalAlipay;

use Omnipay\Common\AbstractGateway;

class WapGateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Global Alipay wap gateway';
    }


    public function getEnvironment()
    {
        return $this->getParameter('environment');
    }


    public function setEnvironment($value)
    {
        return $this->setParameter('environment', $value);
    }


    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }


    public function getKey()
    {
        return $this->getParameter('key');
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


    public function purchase(array $parameters = array ())
    {
        return $this->createRequest('\Omnipay\GlobalAlipay\Message\WapPurchaseRequest', $parameters);
    }


    public function completePurchase(array $parameters = array ())
    {
        return $this->createRequest('\Omnipay\GlobalAlipay\Message\CompletePurchaseRequest', $parameters);
    }
}

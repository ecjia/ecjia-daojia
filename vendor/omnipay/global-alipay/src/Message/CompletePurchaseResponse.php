<?php

namespace Omnipay\GlobalAlipay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->isPaid();
    }


    public function isSignMatch()
    {
        $data = $this->getData();

        return $data['sign_match'];
    }


    public function isNotifyIdVerifyOk()
    {
        $data = $this->getData();

        return $data['notify_id_verify_ok'];
    }


    public function isPaid()
    {
        $data = $this->getData();

        return $data['paid'];
    }
}

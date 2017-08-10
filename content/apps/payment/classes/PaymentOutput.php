<?php

namespace Ecjia\App\Payment;

class PaymentOutput 
{
    /**
     * 订单ID
     * @var integer
     */
    protected $orderId;
    
    /**
     * 订单编号
     * @var string
     */
    protected $orderSn;
    
    /**
     * 订单金额
     * @var float
     */
    protected $orderAmount;
    
    /**
     * 订单支付状态
     * @var string
     */
    protected $orderPayStatus;
    
    /**
     * 商户交易号
     * @var string
     */
    protected $orderTradeNo;
    
    /**
     * 支付流水记录ID
     * @var integer
     */
    protected $payRecordId;
    
    /**
     * 支付插件code
     * @var string
     */
    protected $payCode;
    
    /**
     * 支付插件名称
     * @var string
     */
    protected $payName;
    
    
    /**
     * 支付主题内容
     * @var string
     */
    protected $subject;
    
    /**
     * 异步返回通知地址
     * @var string
     */
    protected $notifyUrl;
    
    /**
     * 同步返回通知地址
     * @var string
     */
    protected $callbackUrl;

    /**
     * 支付插件相关的私有数据
     * @var array
     */
    protected $privateData = array(

        //余额支付
        //'order_surplus',
    );
    
    /**
     * 支付相关的加密数据
     * @var array
     */
    protected $encryptedData = array(
    	///'app_secret',
        //'private_key',
    );
    
    
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        
        return $this;
    }
    
    
    public function getOrderId()
    {
        return $this->orderId;
    }
    
    
    public function setOrderSn($orderSn)
    {
        $this->orderSn = $orderSn;
        
        return $this;
    }
    
    
    public function setOrderAmount($orderAmount)
    {
        $this->orderAmount = $orderAmount;
        
        return $this;
    }
    
    
    public function getOrderAmount()
    {
        return $this->orderAmount;
    }
    
    
    public function setOrderPayStatus($orderPayStatus)
    {
        $this->orderPayStatus = $orderPayStatus;
        
        return $this;
    }
    
    
    public function getOrderPayStatus()
    {
        return $this->orderPayStatus;
    }
    
    
    public function setOrderTradeNo($orderTradeNo)
    {
        $this->orderTradeNo = $orderTradeNo;
        
        return $this;
    }
    
    
    public function getOrderTradeNo()
    {
        return $this->orderTradeNo;
    }
    
    
    public function setPayRecordId($payRecordId)
    {
        $this->payRecordId = $payRecordId;
        
        return $this;
    }
    
    
    public function getPayRecordId()
    {
        return $this->payRecordId;
    }
    
    public function setPayCode($payCode)
    {
        $this->payCode = $payCode;
        
        return $this;
    }
    
    
    public function getPayCode()
    {
        return $this->payCode;
    }
    
    public function setPayName($payName)
    {
        $this->payName = $payName;
        
        return $this;
    }
    
    
    public function getPayName()
    {
        return $this->payName;
    }
    
    
    public function setSubject($subject)
    {
        $this->subject = $subject;
        
        return $this;
    }
    
    
    public function getSubject()
    {
        return $this->subject;
    }
    
    
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
        
        return $this;
    }
    
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }
    
    
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
        
        return $this;
    }
    
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }
    
     
    
    public function setPrivateData(array $privateData)
    {
        $this->privateData = $privateData;
        
        return $this;
    }
    
    public function getPrivateData()
    {
        return $this->privateData;
    }
    
    
    public function setEncryptedData(array $encryptedData)
    {
        $this->encryptedData = $encryptedData;
        
        return $this;
    }
    
    public function getEncryptedData()
    {
        return $this->encryptedData;
    }
    
    /**
     * 导出内容为数组格式
     */
    public function export() {
        return array(
            'order_id'          => $this->orderId,
            'order_sn'          => $this->orderSn,
            'order_amount'      => $this->orderAmount,
            'order_pay_status'  => $this->orderPayStatus,
            'order_trade_no'    => $this->orderTradeNo,
            
            'pay_record_id'     => $this->payRecordId,
            'pay_code'          => $this->payCode,
            'pay_name'          => $this->payName,
            
            'subject'           => $this->subject,
            'notify_url'        => $this->notifyUrl,
            'callback_url'      => $this->callbackUrl,
            
            'private_data'      => $this->privateData,
            'encrypted_data'    => $this->encryptedData,
        );
    }
    
    /**
     * 魔术方法
     */
    public function __toString() {
        return var_export($this->export(), true);
    }
}
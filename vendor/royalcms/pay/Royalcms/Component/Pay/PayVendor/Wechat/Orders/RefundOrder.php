<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/1
 * Time: 10:41 AM
 */

namespace Royalcms\Component\Pay\PayVendor\Wechat\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class RefundOrder implements PayloadInterface
{

    /**
     * 公众账号ID
     * 微信分配的公众账号ID（企业号corpid即为此appId）
     * @var
     */
    protected $appid;

    /**
     * 商户号
     * 微信支付分配的商户号
     * @var
     */
    protected $mch_id;

    /**
     * 随机字符串
     * 随机字符串，不长于32位。推荐随机数生成算法
     * @var
     */
    protected $nonce_str;

    /**
     * 签名
     * 签名，详见签名生成算法
     * @var
     */
    protected $sign;

    /**
     * 签名类型
     * 签名类型，目前支持HMAC-SHA256和MD5，默认为MD5
     * @var
     */
    protected $sign_type = 'MD5';

    /**
     * 微信订单号
     * 微信生成的订单号，在支付通知中有返回
     * @var
     */
    protected $transaction_id;

    /**
     * 商户订单号
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     * @var
     */
    protected $out_trade_no;

    /**
     * 商户退款单号
     * 商户系统内部的退款单号，商户系统内部唯一，只能是数字、大小写字母_-|*@ ，同一退款单号多次请求只退一笔。
     * @var
     */
    protected $out_refund_no;

    /**
     * 订单金额
     * 订单总金额，单位为分，只能为整数，详见支付金额
     * @var
     */
    protected $total_fee;

    /**
     * 退款金额
     * 退款总金额，订单总金额，单位为分，只能为整数，详见支付金额
     * @var
     */
    protected $refund_fee;

    /**
     * 退款货币种类
     * 退款货币类型，需与支付一致，或者不填。符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     * @var
     */
    protected $refund_fee_type = 'CNY';

    /**
     * 退款原因
     * 若商户传入，会在下发给用户的退款消息中体现退款原因
     * @var
     */
    protected $refund_desc;

    /**
     * 退款资金来源
     * 仅针对老资金流商户使用
     * REFUND_SOURCE_UNSETTLED_FUNDS---未结算资金退款（默认使用未结算资金退款）
     * REFUND_SOURCE_RECHARGE_FUNDS---可用余额退款
     * @var
     */
    protected $refund_account = 'REFUND_SOURCE_UNSETTLED_FUNDS';

    /**
     * 退款结果通知url
     * 异步接收微信支付退款结果通知的回调地址，通知URL必须为外网可访问的url，不允许带参数
     * 如果参数中传了notify_url，则商户平台上配置的回调地址将不会生效。
     * @var
     */
    protected $notify_url;

    /**
     * @return mixed
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * @param mixed $appid
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setAppid($appid)
    {
        $this->appid = $appid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMchId()
    {
        return $this->mch_id;
    }

    /**
     * @param mixed $mch_id
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setMchId($mch_id)
    {
        $this->mch_id = $mch_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNonceStr()
    {
        return $this->nonce_str;
    }

    /**
     * @param mixed $nonce_str
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setNonceStr($nonce_str)
    {
        $this->nonce_str = $nonce_str;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @param mixed $sign
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignType()
    {
        return $this->sign_type;
    }

    /**
     * @param mixed $sign_type
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setSignType($sign_type)
    {
        $this->sign_type = $sign_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * @param mixed $transaction_id
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutTradeNo()
    {
        return $this->out_trade_no;
    }

    /**
     * @param mixed $out_trade_no
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setOutTradeNo($out_trade_no)
    {
        $this->out_trade_no = $out_trade_no;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutRefundNo()
    {
        return $this->out_refund_no;
    }

    /**
     * @param mixed $out_refund_no
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setOutRefundNo($out_refund_no)
    {
        $this->out_refund_no = $out_refund_no;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalFee()
    {
        return $this->total_fee;
    }

    /**
     * @param mixed $total_fee
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setTotalFee($total_fee)
    {
        $this->total_fee = intval(strval($total_fee));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefundFee()
    {
        return $this->refund_fee;
    }

    /**
     * @param mixed $refund_fee
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setRefundFee($refund_fee)
    {
        $this->refund_fee = intval(strval($refund_fee));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefundFeeType()
    {
        return $this->refund_fee_type;
    }

    /**
     * @param mixed $refund_fee_type
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setRefundFeeType($refund_fee_type)
    {
        $this->refund_fee_type = $refund_fee_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefundDesc()
    {
        return $this->refund_desc;
    }

    /**
     * @param mixed $refund_desc
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setRefundDesc($refund_desc)
    {
        $this->refund_desc = $refund_desc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefundAccount()
    {
        return $this->refund_account;
    }

    /**
     * @param mixed $refund_account
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setRefundAccount($refund_account)
    {
        $this->refund_account = $refund_account;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->notify_url;
    }

    /**
     * @param mixed $notify_url
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundOrder
     */
    public function setNotifyUrl($notify_url)
    {
        $this->notify_url = $notify_url;
        return $this;
    }


    /**
     * 对象转换成数组输出
     *
     * @return array
     */
    public function toArray()
    {
        $result = [
            'appid'             => $this->getAppid(),
            'mch_id'            => $this->getMchId(),
            'nonce_str'         => $this->getNonceStr(),
            'sign'              => $this->getSign(),
            'sign_type'         => $this->getSignType(),
            'transaction_id'    => $this->getTransactionId(),
            'out_trade_no'      => $this->getOutTradeNo(),
            'out_refund_no'     => $this->getOutRefundNo(),
            'total_fee'         => $this->getTotalFee(),
            'refund_fee'        => $this->getRefundFee(),
            'refund_fee_type'   => $this->getRefundFeeType(),
            'refund_desc'       => $this->getRefundDesc(),
            'refund_account'    => $this->getRefundAccount(),
            'notify_url'        => $this->getNotifyUrl(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}
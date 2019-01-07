<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/1
 * Time: 10:41 AM
 */

namespace Royalcms\Component\Pay\PayVendor\Wechat\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class RefundQueryOrder implements PayloadInterface
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
     * 微信退款单号
     * 微信生成的退款单号，在申请退款接口有返回
     * @var
     */
    protected $refund_id;

    /**
     * 偏移量
     * 偏移量，当部分退款次数超过10次时可使用，表示返回的查询结果从这个偏移量开始取记录
     * @var
     */
    protected $offset;

    /**
     * @return mixed
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * @param mixed $appid
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
     */
    public function setOutRefundNo($out_refund_no)
    {
        $this->out_refund_no = $out_refund_no;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefundId()
    {
        return $this->refund_id;
    }

    /**
     * @param mixed $refund_id
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
     */
    public function setRefundId($refund_id)
    {
        $this->refund_id = $refund_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param mixed $offset
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\RefundQueryOrder
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
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
            'refund_id'         => $this->getRefundId(),
            'offset'            => $this->getOffset(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}
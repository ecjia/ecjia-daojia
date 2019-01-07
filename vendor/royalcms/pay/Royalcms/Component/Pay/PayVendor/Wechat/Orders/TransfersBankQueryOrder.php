<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/1
 * Time: 10:41 AM
 */

namespace Royalcms\Component\Pay\PayVendor\Wechat\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class TransfersBankQueryOrder implements PayloadInterface
{

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
     * 商户订单号
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     * @var
     */
    protected $partner_trade_no;

    /**
     * @return mixed
     */
    public function getMchId()
    {
        return $this->mch_id;
    }

    /**
     * @param mixed $mch_id
     * @return TransfersBankQueryOrder
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
     * @return TransfersBankQueryOrder
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
     * @return TransfersBankQueryOrder
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPartnerTradeNo()
    {
        return $this->partner_trade_no;
    }

    /**
     * @param mixed $partner_trade_no
     * @return TransfersBankQueryOrder
     */
    public function setPartnerTradeNo($partner_trade_no)
    {
        $this->partner_trade_no = $partner_trade_no;
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
            'mch_id'                => $this->getMchid(),
            'nonce_str'             => $this->getNonceStr(),
            'sign'                  => $this->getSign(),
            'partner_trade_no'      => $this->getPartnerTradeNo(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}
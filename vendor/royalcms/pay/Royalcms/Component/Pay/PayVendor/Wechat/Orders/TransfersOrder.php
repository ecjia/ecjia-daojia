<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/1
 * Time: 10:41 AM
 */

namespace Royalcms\Component\Pay\PayVendor\Wechat\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class TransfersOrder implements PayloadInterface
{

    /**
     * 公众账号ID
     * 微信分配的公众账号ID（企业号corpid即为此appId）
     * @var
     */
    protected $mch_appid;

    /**
     * 商户号
     * 微信支付分配的商户号
     * @var
     */
    protected $mchid;

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
     * 设备号
     * 微信支付分配的终端设备号
     * @var
     */
    protected $device_info;

    /**
     * 商户订单号
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     * @var
     */
    protected $partner_trade_no;

    /**
     * 用户openid
     * 商户appid下，某用户的openid
     * @var
     */
    protected $openid;

    /**
     * 校验用户姓名选项
     * NO_CHECK：不校验真实姓名
     * FORCE_CHECK：强校验真实姓名
     * @var
     */
    protected $check_name;

    /**
     * 收款用户姓名
     * 收款用户真实姓名。
     * 如果check_name设置为FORCE_CHECK，则必填用户真实姓名
     * @var
     */
    protected $re_user_name;

    /**
     * 金额
     * 企业付款金额，单位为分
     * @var
     */
    protected $amount;

    /**
     * 企业付款备注
     * 企业付款备注，必填。注意：备注中的敏感词会被转成字符*
     * @var
     */
    protected $desc;

    /**
     * Ip地址
     * 该IP同在商户平台设置的IP白名单中的IP没有关联，该IP可传用户端或者服务端的IP。
     * @var
     */
    protected $spbill_create_ip;

    /**
     * @return mixed
     */
    public function getMchAppid()
    {
        return $this->mch_appid;
    }

    /**
     * @param mixed $mch_appid
     */
    public function setMchAppid($mch_appid)
    {
        $this->mch_appid = $mch_appid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMchid()
    {
        return $this->mchid;
    }

    /**
     * @param mixed $mchid
     */
    public function setMchid($mchid)
    {
        $this->mchid = $mchid;
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
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeviceInfo()
    {
        return $this->device_info;
    }

    /**
     * @param mixed $device_info
     */
    public function setDeviceInfo($device_info)
    {
        $this->device_info = $device_info;
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
     */
    public function setPartnerTradeNo($partner_trade_no)
    {
        $this->partner_trade_no = $partner_trade_no;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @param mixed $openid
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCheckName()
    {
        return $this->check_name;
    }

    /**
     * @param mixed $check_name
     */
    public function setCheckName($check_name)
    {
        $this->check_name = $check_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReUserName()
    {
        return $this->re_user_name;
    }

    /**
     * @param mixed $re_user_name
     */
    public function setReUserName($re_user_name)
    {
        $this->re_user_name = $re_user_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = intval(strval($amount));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpbillCreateIp()
    {
        return $this->spbill_create_ip;
    }

    /**
     * @param mixed $spbill_create_ip
     */
    public function setSpbillCreateIp($spbill_create_ip)
    {
        $this->spbill_create_ip = $spbill_create_ip;
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
            'mch_appid'             => $this->getMchAppid(),
            'mchid'                 => $this->getMchid(),
            'device_info'           => $this->getDeviceInfo(),
            'nonce_str'             => $this->getNonceStr(),
            'sign'                  => $this->getSign(),
            'partner_trade_no'      => $this->getPartnerTradeNo(),
            'openid'                => $this->getOpenid(),
            'check_name'            => $this->getCheckName(),
            're_user_name'          => $this->getReUserName(),
            'amount'                => $this->getAmount(),
            'desc'                  => $this->getDesc(),
            'spbill_create_ip'      => $this->getSpbillCreateIp(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}
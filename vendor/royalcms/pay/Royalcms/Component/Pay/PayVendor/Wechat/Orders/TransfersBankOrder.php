<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/1
 * Time: 10:41 AM
 */

namespace Royalcms\Component\Pay\PayVendor\Wechat\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class TransfersBankOrder implements PayloadInterface
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
     * 收款方银行卡号
     * 收款方银行卡号（采用标准RSA算法，公钥由微信侧提供）,详见获取RSA加密公钥API
     * @link https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=24_7
     * @var
     */
    protected $enc_bank_no;

    /**
     * 收款方用户名
     * 收款方用户名（采用标准RSA算法，公钥由微信侧提供）详见获取RSA加密公钥API
     * @var
     */
    protected $enc_true_name;

    /**
     * 收款方开户行
     * 银行卡所在开户行编号,详见银行编号列表
     * @link https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=24_4
     * @var
     */
    protected $bank_code;

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
     * @return mixed
     */
    public function getMchId()
    {
        return $this->mch_id;
    }

    /**
     * @param mixed $mch_id
     * @return TransfersBankOrder
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
     * @return TransfersBankOrder
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
     * @return TransfersBankOrder
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
     * @return TransfersBankOrder
     */
    public function setPartnerTradeNo($partner_trade_no)
    {
        $this->partner_trade_no = $partner_trade_no;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEncBankNo()
    {
        return $this->enc_bank_no;
    }

    /**
     * @param mixed $enc_bank_no
     * @return TransfersBankOrder
     */
    public function setEncBankNo($enc_bank_no)
    {
        $this->enc_bank_no = $enc_bank_no;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEncTrueName()
    {
        return $this->enc_true_name;
    }

    /**
     * @param mixed $enc_true_name
     * @return TransfersBankOrder
     */
    public function setEncTrueName($enc_true_name)
    {
        $this->enc_true_name = $enc_true_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankCode()
    {
        return $this->bank_code;
    }

    /**
     * @param mixed $bank_code
     * @return TransfersBankOrder
     */
    public function setBankCode($bank_code)
    {
        $this->bank_code = $bank_code;
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
     * @return TransfersBankOrder
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
     * @return TransfersBankOrder
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
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
            'mch_id'                => $this->getMchId(),
            'nonce_str'             => $this->getNonceStr(),
            'sign'                  => $this->getSign(),
            'partner_trade_no'      => $this->getPartnerTradeNo(),
            'enc_bank_no'           => $this->getEncBankNo(),
            'enc_true_name'         => $this->getEncTrueName(),
            'bank_code'             => $this->getBankCode(),
            'amount'                => $this->getAmount(),
            'desc'                  => $this->getDesc(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}
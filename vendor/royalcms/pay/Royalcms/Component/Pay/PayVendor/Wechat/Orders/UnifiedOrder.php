<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/1
 * Time: 10:41 AM
 */

namespace Royalcms\Component\Pay\PayVendor\Wechat\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class UnifiedOrder implements PayloadInterface
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
     * 设备号
     * 自定义参数，可以为终端设备号(门店号或收银设备ID)，PC网页或公众号内支付可以传"WEB"
     * @var
     */
    protected $device_info;

    /**
     * 商品描述
     * 商品简单描述，该字段请按照规范传递，具体请见参数规定
     * @link https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_2
     * @var
     */
    protected $body;

    /**
     * 商品详情
     * 商品详细描述，对于使用单品优惠的商户，改字段必须按照规范上传，详见“单品优惠参数说明”
     * @link https://pay.weixin.qq.com/wiki/doc/api/danpin.php?chapter=9_102&index=2
     * @var
     */
    protected $detail;

    /**
     * 附加数据
     * 附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用。
     * @var
     */
    protected $attach;

    /**
     * 商户订单号
     * 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|* 且在同一个商户号下唯一。详见商户订单号
     * @link https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_2
     * @var
     */
    protected $out_trade_no;

    /**
     * 标价币种
     * 符合ISO 4217标准的三位字母代码，默认人民币：CNY，详细列表请参见货币类型
     * @link https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_2
     * @var
     */
    protected $fee_type;

    /**
     * 标价金额
     * 订单总金额，单位为分，详见支付金额
     * @link https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_2
     * @var
     */
    protected $total_fee;

    /**
     * 终端IP
     * APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。
     * @var
     */
    protected $spbill_create_ip;

    /**
     * 交易起始时间
     * 订单生成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010。其他详见时间规则
     * @link https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_2
     * @var
     */
    protected $time_start;

    /**
     * 交易结束时间
     * 订单失效时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。订单失效时间是针对订单号而言的，由于在请求支付的时候有一个必传参数prepay_id只有两小时的有效期，所以在重入时间超过2小时的时候需要重新请求下单接口获取新的prepay_id。其他详见时间规则
     * 建议：最短失效时间间隔大于1分钟
     * @link https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_2
     * @var
     */
    protected $time_expire;

    /**
     * 订单优惠标记
     * 订单优惠标记，使用代金券或立减优惠功能时需要的参数，说明详见代金券或立减优惠
     * @link https://pay.weixin.qq.com/wiki/doc/api/tools/sp_coupon.php?chapter=12_1
     * @var
     */
    protected $goods_tag;

    /**
     * 通知地址
     * 异步接收微信支付结果通知的回调地址，通知url必须为外网可访问的url，不能携带参数。
     * @var
     */
    protected $notify_url;

    /**
     * 交易类型
     * JSAPI -JSAPI支付
     * NATIVE -Native支付
     * APP -APP支付
     * 说明详见参数规定
     * @link https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_2
     * @var
     */
    protected $trade_type;

    /**
     * 商品ID
     * trade_type=NATIVE时，此参数必传。此参数为二维码中包含的商品ID，商户自行定义。
     * @var
     */
    protected $product_id;

    /**
     * 指定支付方式
     * 上传此参数no_credit--可限制用户不能使用信用卡支付
     * @var
     */
    protected $limit_pay;

    /**
     * 用户标识
     * trade_type=JSAPI时（即JSAPI支付），此参数必传，此参数为微信用户在商户对应appid下的唯一标识。openid如何获取，可参考【获取openid】。企业号请使用【企业号OAuth2.0接口】获取企业号内成员userid，再调用【企业号userid转openid接口】进行转换
     * @link https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_4 获取openid
     * @link http://qydev.weixin.qq.com/wiki/index.php?title=OAuth%E9%AA%8C%E8%AF%81%E6%8E%A5%E5%8F%A3 企业号OAuth2.0接口
     * @link http://qydev.weixin.qq.com/wiki/index.php?title=Userid%E4%B8%8Eopenid%E4%BA%92%E6%8D%A2%E6%8E%A5%E5%8F%A3 企业号userid转openid接口
     * @var
     */
    protected $openid;

    /**
     * 电子发票入口开放标识
     * Y，传入Y时，支付成功消息和支付详情页将出现开票入口。需要在微信支付商户平台或微信公众平台开通电子发票功能，传此字段才可生效
     * @var
     */
    protected $receipt;

    /**
     * 场景信息
     * 该字段常用于线下活动时的场景信息上报，支持上报实际门店信息，商户也可以按需求自己上报相关信息。
     * 该字段为JSON对象数据，对象格式为{"store_info":{"id": "门店ID","name": "名称","area_code": "编码","address": "地址" }} ，字段详细说明请点击行前的+展开
     * -门店id	id
     * -门店名称	name
     * -门店行政区划码	area_code
     * -门店详细地址	address
     * @var
     */
    protected $scene_info;

    /**
     * @return mixed
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * @param mixed $appid
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setSignType($sign_type)
    {
        $this->sign_type = $sign_type;
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setDeviceInfo($device_info)
    {
        $this->device_info = $device_info;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param mixed $detail
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttach()
    {
        return $this->attach;
    }

    /**
     * @param mixed $attach
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setAttach($attach)
    {
        $this->attach = $attach;
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setOutTradeNo($out_trade_no)
    {
        $this->out_trade_no = $out_trade_no;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeeType()
    {
        return $this->fee_type;
    }

    /**
     * @param mixed $fee_type
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setFeeType($fee_type)
    {
        $this->fee_type = $fee_type;
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setTotalFee($total_fee)
    {
        $this->total_fee = $total_fee;
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setSpbillCreateIp($spbill_create_ip)
    {
        $this->spbill_create_ip = $spbill_create_ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeStart()
    {
        return $this->time_start;
    }

    /**
     * @param mixed $time_start
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setTimeStart($time_start)
    {
        $this->time_start = $time_start;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeExpire()
    {
        return $this->time_expire;
    }

    /**
     * @param mixed $time_expire
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setTimeExpire($time_expire)
    {
        $this->time_expire = $time_expire;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsTag()
    {
        return $this->goods_tag;
    }

    /**
     * @param mixed $goods_tag
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setGoodsTag($goods_tag)
    {
        $this->goods_tag = $goods_tag;
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setNotifyUrl($notify_url)
    {
        $this->notify_url = $notify_url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTradeType()
    {
        return $this->trade_type;
    }

    /**
     * @param mixed $trade_type
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setTradeType($trade_type)
    {
        $this->trade_type = $trade_type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimitPay()
    {
        return $this->limit_pay;
    }

    /**
     * @param mixed $limit_pay
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setLimitPay($limit_pay)
    {
        $this->limit_pay = $limit_pay;
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
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param mixed $receipt
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSceneInfo()
    {
        return $this->scene_info;
    }

    /**
     * @param mixed $scene_info
     * @return \Royalcms\Component\Pay\PayVendor\Wechat\Orders\UnifiedOrder
     */
    public function setSceneInfo($scene_info)
    {
        $this->scene_info = $scene_info;
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
            'device_info'       => $this->getDeviceInfo(),
            'body'              => $this->getBody(),
            'detail'            => $this->getDetail(),
            'attach'            => $this->getAttach(),
            'out_trade_no'      => $this->getOutTradeNo(),
            'fee_type'          => $this->getFeeType(),
            'total_fee'         => $this->getTotalFee(),
            'spbill_create_ip'  => $this->getSpbillCreateIp(),
            'time_start'        => $this->getTimeStart(),
            'time_expire'       => $this->getTimeExpire(),
            'goods_tag'         => $this->getGoodsTag(),
            'notify_url'        => $this->getNotifyUrl(),
            'trade_type'        => $this->getTradeType(),
            'product_id'        => $this->getProductId(),
            'limit_pay'         => $this->getLimitPay(),
            'openid'            => $this->getOpenid(),
            'receipt'           => $this->getReceipt(),
            'scene_info'        => $this->getSceneInfo(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}
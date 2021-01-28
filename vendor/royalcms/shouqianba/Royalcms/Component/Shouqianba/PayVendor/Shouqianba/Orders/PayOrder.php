<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/29
 * Time: 4:36 PM
 */

namespace Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class PayOrder implements PayloadInterface
{

    /**
     * 收钱吧终端ID
     *
     * 收钱吧终端ID，不超过32位的纯数字
     *
     * @var string
     */
    protected $terminal_sn;

    /**
     * 商户系统订单号
     *
     * 必须在商户系统内唯一；且长度不超过64字节
     *
     * @var string
     */
    protected $client_sn;

    /**
     * 交易总金额
     *
     * 以分为单位,不超过10位纯数字字符串,超过1亿元的收款请使用银行转账
     *
     * @var string
     */
    protected $total_amount;

    /**
     * 支付方式
     *
     * 非必传。内容为数字的字符串。一旦设置，则根据支付码判断支付通道的逻辑失效
     *
     * 1:支付宝
     * 3:微信
     * 4:百度钱包
     * 5:京东钱包
     * 6:qq钱包
     * 17:银联二维码
     *
     * @var string
     */
    protected $payway;

    /**
     * 条码内容
     *
     * 不超过32字节
     *
     * @var string
     */
    protected $dynamic_id;

    /**
     * 交易简介
     *
     * 本次交易的简要介绍
     *
     * @var string
     */
    protected $subject;

    /**
     * 门店操作员
     *
     * 发起本次交易的操作员
     *
     * @var string
     */
    protected $operator;

    /**
     * 商品详情
     *
     * 对商品或本次交易的描述
     *
     * @var string
     */
    protected $description;

    /**
     * 经度
     *
     * 经纬度必须同时出现
     *
     * @var string
     */
    protected $longitude;

    /**
     * 维度
     *
     * 经纬度必须同时出现
     *
     * @option
     * @var string
     */
    protected $latitude;

    /**
     * 设备指纹
     *
     * @var
     */
    protected $device_id;

    /**
     * 扩展参数集合
     *
     * 收钱吧与特定第三方单独约定的参数集合,json格式，最多支持24个字段，每个字段key长度不超过64字节，value长度不超过256字节
     * { "goods_tag": "beijing"}
     *
     * @var string
     */
    protected $extended;

    /**
     * 商品详情
     *
     * 格式为json goods_details的值为数组，每一个元素包含五个字段，goods_id商品的编号，goods_name商品名称，quantity商品数量，price商品单价，单位为分，promotion_type优惠类型，0:没有优惠 1: 支付机构优惠，为1会把相关信息送到支付机构
     * "goods_details": [{"goods_id": "wx001","goods_name": "苹果笔记本电脑","quantity": 1,"price": 2,"promotion_type": 0},{"goods_id":"wx002","goods_name":"tesla","quantity": 1,"price": 2,"promotion_type": 1}]
     *
     * @var string json
     */
    protected $goods_details;

    /**
     * 反射参数
     *
     * 任何调用者希望原样返回的信息，可以用于关联商户ERP系统的订单或记录附加订单内容
     * { "tips": "200" }
     *
     * @var string json
     */
    protected $reflect;

    /**
     * 回调
     *
     * 支付回调的地址
     *
     * @var string
     */
    protected $notify_url;

    /**
     * @return string
     */
    public function getTerminalSn()
    {
        return $this->terminal_sn;
    }

    /**
     * @param string $terminal_sn
     * @return PayOrder
     */
    public function setTerminalSn($terminal_sn)
    {
        $this->terminal_sn = $terminal_sn;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSn()
    {
        return $this->client_sn;
    }

    /**
     * @param string $client_sn
     * @return PayOrder
     */
    public function setClientSn($client_sn)
    {
        $this->client_sn = $client_sn;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalAmount()
    {
        return strval($this->total_amount);
    }

    /**
     * @param string $total_amount
     * @return PayOrder
     */
    public function setTotalAmount($total_amount)
    {
        $this->total_amount = intval(strval($total_amount));
        return $this;
    }

    /**
     * @return string
     */
    public function getPayway()
    {
        return $this->payway;
    }

    /**
     * @param string $payway
     * @return PayOrder
     */
    public function setPayway($payway)
    {
        $this->payway = $payway;
        return $this;
    }

    /**
     * @return string
     */
    public function getDynamicId()
    {
        return $this->dynamic_id;
    }

    /**
     * @param string $dynamic_id
     * @return PayOrder
     */
    public function setDynamicId($dynamic_id)
    {
        $this->dynamic_id = $dynamic_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return PayOrder
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     * @return PayOrder
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return PayOrder
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     * @return PayOrder
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     * @return PayOrder
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->device_id;
    }

    /**
     * @param mixed $device_id
     * @return PayOrder
     */
    public function setDeviceId($device_id)
    {
        $this->device_id = $device_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtended()
    {
        return $this->extended;
    }

    /**
     * @param string $extended
     * @return PayOrder
     */
    public function setExtended($extended)
    {
        $this->extended = $extended;
        return $this;
    }

    /**
     * @return string json
     */
    public function getGoodsDetails()
    {
        return $this->goods_details;
    }

    /**
     * @param string $goods_details json
     * @return PayOrder
     */
    public function setGoodsDetails($goods_details)
    {
        $this->goods_details = $goods_details;
        return $this;
    }

    /**
     * @return string json
     */
    public function getReflect()
    {
        return $this->reflect;
    }

    /**
     * @param string $reflect json
     * @return PayOrder
     */
    public function setReflect($reflect)
    {
        $this->reflect = $reflect;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->notify_url;
    }

    /**
     * @param string $notify_url
     * @return PayOrder
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
            'terminal_sn'   => $this->getTerminalSn(),
            'client_sn'     => $this->getClientSn(),
            'total_amount'  => $this->getTotalAmount(),
            'payway'        => $this->getPayway(),
            'dynamic_id'    => $this->getDynamicId(),
            'subject'       => $this->getSubject(),
            'operator'      => $this->getOperator(),
            'description'   => $this->getDescription(),
            'longitude'     => $this->getLongitude(),
            'latitude'      => $this->getLatitude(),
            'device_id'     => $this->getDeviceId(),
            'extended'      => $this->getExtended(),
            'goods_details' => $this->getGoodsDetails(),
            'reflect'       => $this->getReflect(),
            'notify_url'    => $this->getNotifyUrl(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }


}
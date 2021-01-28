<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/1
 * Time: 10:41 AM
 */

namespace Royalcms\Component\Shouqianba\PayVendor\Shouqianba\Orders;

use Royalcms\Component\Pay\Contracts\PayloadInterface;

class RefundOrder implements PayloadInterface
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
     * 收钱吧唯一订单号
     *
     * 收钱吧系统内部唯一订单号
     *
     * @var string
     */
    protected $sn;

    /**
     * 商户系统订单号
     *
     * 必须在商户系统内唯一；且长度不超过64字节
     *
     * @var string
     */
    protected $client_sn;

    /**
     * 商户退款流水号
     *
     * 商户退款流水号，如果商户同一笔订单多次退款，需要传入不同的退款流水号来区分退款，
     * 如果退款请求超时，需要发起查询，并根据查询结果的client_tsn判断本次退款请求是否成功
     *
     * @var string
     */
    protected $client_tsn;

    /**
     * 退款序列号
     *
     * 商户退款所需序列号，用于唯一标识某次退款请求，以防止意外的重复退款。
     * 正常情况下，对同一笔订单进行多次退款请求时该字段不能重复；
     * 而当通信质量不佳，终端不确认退款请求是否成功，
     * 自动或手动发起的退款请求重试，则务必要保持序列号不变
     *
     * @var
     */
    protected $refund_request_no;

    /**
     * 门店操作员
     *
     * 发起本次交易的操作员
     *
     * @var string
     */
    protected $operator;

    /**
     * 退款金额
     *
     * 以分为单位,不超过10位纯数字字符串,超过1亿元的收款请使用银行转账
     *
     * @var string
     */
    protected $refund_amount;

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
     * @return string
     */
    public function getTerminalSn()
    {
        return $this->terminal_sn;
    }

    /**
     * @param string $terminal_sn
     */
    public function setTerminalSn($terminal_sn)
    {
        $this->terminal_sn = $terminal_sn;
        return $this;
    }

    /**
     * @return string
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * @param string $sn
     */
    public function setSn($sn)
    {
        $this->sn = $sn;
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
     */
    public function setClientSn($client_sn)
    {
        $this->client_sn = $client_sn;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientTsn()
    {
        return $this->client_tsn;
    }

    /**
     * @param string $client_tsn
     */
    public function setClientTsn($client_tsn)
    {
        $this->client_tsn = $client_tsn;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefundRequestNo()
    {
        return $this->refund_request_no;
    }

    /**
     * @param string $refund_request_no
     */
    public function setRefundRequestNo($refund_request_no)
    {
        $this->refund_request_no = $refund_request_no;
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
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefundAmount()
    {
        return strval($this->refund_amount);
    }

    /**
     * @param string $refund_amount
     */
    public function setRefundAmount($refund_amount)
    {
        $this->refund_amount = intval(strval($refund_amount));
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtended()
    {
        return $this->extended;
    }

    /**
     * @param mixed $extended
     */
    public function setExtended($extended)
    {
        $this->extended = $extended;
        return $this;
    }

    /**
     * @return array
     */
    public function getGoodsDetails()
    {
        return $this->goods_details;
    }

    /**
     * @param array $goods_details
     */
    public function setGoodsDetails($goods_details)
    {
        $this->goods_details = $goods_details;
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
            'terminal_sn'       => $this->getTerminalSn(),
            'sn'                => $this->getSn(),
            'client_sn'         => $this->getClientSn(),
            'client_tsn'        => $this->getClientTsn(),
            'refund_request_no' => $this->getRefundRequestNo(),
            'operator'          => $this->getOperator(),
            'refund_amount'     => $this->getRefundAmount(),
            'extended'          => $this->getExtended(),
            'goods_details'     => $this->getGoodsDetails(),
        ];

        $result = array_filter($result, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        return $result;
    }

}
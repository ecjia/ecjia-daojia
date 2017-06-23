<?php

namespace Royalcms\Component\Alidayu\Commands;

use Royalcms\Component\Alidayu\Request;
use Royalcms\Component\Alidayu\Contracts\RequestCommand;

/**
 * 阿里大于 - 流量直充分省接口
 *
 * @link   http://open.taobao.com/docs/api.htm?apiId=26477
 */
class AlibabaAliqinFcFlowChargeProvince extends Request implements RequestCommand
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'alibaba.aliqin.fc.flow.charge.province';

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'phone_num'       => '',  // 必须 手机号
            'reason'          => '',  // 可选 充值原因
            'grade'           => '',  // 必须 需要充值的流量
            'out_recharge_id' => '',  // 必须 唯一流水号
        ];
    }

    /**
     * 设置手机号
     * @param string $value 手机号
     */
    public function setPhoneNum($value)
    {
        $this->params['phone_num'] = $value;

        return $this;
    }

    /**
     * 设置需要充值的流量
     * @param string $value 需要充值的流量
     */
    public function setGrade($value)
    {
        $this->params['grade'] = $value;

        return $this;
    }

    /**
     * 设置唯一流水号
     * @param string $value 唯一流水号
     */
    public function setOutRechargeId($value)
    {
        $this->params['out_recharge_id'] = $value;

        return $this;
    }

    /**
     * 设置充值原因
     * @param  string $value 充值原因
     */
    public function setReason($value = '')
    {
        $this->params['reason'] = $value;

        return $this;
    }
}

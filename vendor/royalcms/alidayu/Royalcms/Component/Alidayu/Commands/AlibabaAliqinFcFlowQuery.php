<?php

namespace Royalcms\Component\Alidayu\Commands;

use Royalcms\Component\Alidayu\Request;
use Royalcms\Component\Alidayu\Contracts\RequestCommand;

/**
 * 阿里大于 - 流量直充查询
 *
 * @link   http://open.taobao.com/docs/api.htm?apiId=26305
 */
class AlibabaAliqinFcFlowQuery extends Request implements RequestCommand
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'alibaba.aliqin.fc.flow.query';

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [
            'out_id' => '',  // 必须 唯一流水号
        ];
    }

    /**
     * 设置唯一流水号
     * @param string $value 唯一流水号
     */
    public function setOutId($value)
    {
        $this->params['out_id'] = $value;

        return $this;
    }
}

<?php

namespace Royalcms\Component\Alidayu\Commands;

use Royalcms\Component\Alidayu\Request;
use Royalcms\Component\Alidayu\Contracts\RequestCommand;

/**
 * 阿里大于 - 流量直充档位表
 *
 * @link   http://open.taobao.com/docs/api.htm?apiId=26312
 */
class AlibabaAliqinFcFlowGrade extends Request implements RequestCommand
{
    /**
     * 接口名称
     * @var string
     */
    protected $method = 'alibaba.aliqin.fc.flow.grade';

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->params = [];
    }
}

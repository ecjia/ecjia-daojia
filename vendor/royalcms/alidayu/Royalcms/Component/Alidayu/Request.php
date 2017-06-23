<?php

namespace Royalcms\Component\Alidayu;

use Royalcms\Component\Alidayu\Contracts\RequestCommand;

/**
 * 阿里大于 - 请求基类
 *
 */
abstract class Request implements RequestCommand
{
    /**
     * 接口名称
     * @var string
     */
    protected $method;

    /**
     * 接口请求参数
     * @var array
     */
    protected $params = [];

    /**
     * 获取接口名称
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * 获取请求参数
     * @return [type] [description]
     */
    public function getParams()
    {
        return $this->params;
    }
}

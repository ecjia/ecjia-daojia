<?php

namespace Royalcms\Component\Printer\Contracts;

/**
 * 云打印 - 请求接口类
 */
Interface Command
{
    /**
     * 获取接口名称
     * @return string
     */
    public function getMethod();

    /**
     * 获取请求参数
     * @return array 
     */
    public function getParams();
}

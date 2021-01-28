<?php

namespace Royalcms\Component\Aliyun\OSS\Exceptions;

use Royalcms\Component\Aliyun\Common\Exceptions\ServiceException;

/**
 * 该异常在对开放存储数据服务（Open Storage Service）访问失败时抛出。
 *
 * @package Aliyun\OSS\Exceptions
 */
class OSSException extends ServiceException {
    public function __construct($code, $message, $requestId, $hostId) {
        parent::__construct($code, $message, $requestId, $hostId);
    }
}
 
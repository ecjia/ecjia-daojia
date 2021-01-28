<?php

namespace Royalcms\Component\Aliyun\OSS\Utilities;

use Royalcms\Component\Aliyun\Common\Exceptions\ClientException;
use Royalcms\Component\Aliyun\OSS\Exceptions\OSSException;

class OSSExceptionFactory {
    public function createFromError($error) {
            $exception = new OSSException($error->getCode(),
                                            $error->getMessage(),
                                            $error->getRequestId(),
                                            $error->getHostId()
            );
            return $exception;
    }

    public function create($errorCode, $message = null, $requestId = null, $hostId = null) {
        return new OSSException($errorCode, $message, $requestId, $hostId);
    }
    
    public function createInvalidResponseException($message, $e = null) {
        return new ClientException($message, $e);
    }
     
    public static function factory() {
        return new static();
    }
}

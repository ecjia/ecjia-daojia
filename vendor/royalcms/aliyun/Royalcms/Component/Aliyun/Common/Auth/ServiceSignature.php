<?php

namespace Royalcms\Component\Aliyun\Common\Auth;

use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;

abstract class ServiceSignature {
    public abstract function getSignatureMethod();
    public abstract function getSignatureVersion();
    protected abstract function computeSignatureCore($key, $data);
    
    public function computeSignature($key, $data) {
        AssertUtils::assertNotEmpty($key, 'key');
        AssertUtils::assertNotEmpty($data, 'data');
        return $this->computeSignatureCore($key, $data);
    }
    
    public static function factory() {
        return new HmacSHA1Signature();
    }
}

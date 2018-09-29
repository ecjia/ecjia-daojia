<?php

namespace Royalcms\Component\Aliyun\Common\Auth;

class HmacSHA1Signature extends ServiceSignature {
    public function getSignatureMethod() {
        return 'HmacSHA1';
    }
    
    public function getSignatureVersion() {
        return '1';
    }
    
    protected function computeSignatureCore($key, $data) {
        return base64_encode(hash_hmac('sha1', $data, $key, true));
    }
}
 
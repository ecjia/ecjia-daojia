<?php

namespace Royalcms\Component\Aliyun\OSS\Auth;

use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;
use Royalcms\Component\Aliyun\Common\Communication\HttpRequest;
use Royalcms\Component\Aliyun\Common\Auth\ServiceSignature;
use Royalcms\Component\Aliyun\OSS\Utilities\SignUtils;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\Common\Auth\SignerInterface;

class OSSRequestSigner implements SignerInterface {
 
    private $bucket;

    private $key;

    function __construct($bucket, $key) {
        $this->bucket = $bucket;
        $this->key = $key;
    }

    public function sign(HttpRequest $request, array $credentials) {
	    AssertUtils::assertSet(array(
                    OSSOptions::ACCESS_KEY_ID,
                    OSSOptions::ACCESS_KEY_SECRET,
	    ), $credentials);
	    AssertUtils::assertString($credentials[OSSOptions::ACCESS_KEY_ID], OSSOptions::ACCESS_KEY_ID);
	    AssertUtils::assertString($credentials[OSSOptions::ACCESS_KEY_SECRET], OSSOptions::ACCESS_KEY_SECRET);
		
	    $key = $credentials[OSSOptions::ACCESS_KEY_ID];
	    $secret = $credentials[OSSOptions::ACCESS_KEY_SECRET];
	    
	    if (strlen($key) > 0 && strlen($secret) > 0) {
	        $canonicalString = SignUtils::buildCanonicalString($request, $this->bucket, $this->key);
	        $signature = ServiceSignature::factory()->computeSignature($secret, $canonicalString);
	        
	        $request->addHeader(OSSHeaders::AUTHORIZATION, 'OSS '.$key.':'.$signature);
	    } else if (strlen($key) > 0) {
	        $request->addHeader(OSSHeaders::AUTHORIZATION, $key);
	    }
	}
}

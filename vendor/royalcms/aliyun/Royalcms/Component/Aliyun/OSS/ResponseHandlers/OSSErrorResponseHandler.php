<?php

namespace Royalcms\Component\Aliyun\OSS\ResponseHandlers;

use Royalcms\Component\Aliyun\OSS\Utilities\OSSResponseParserFactory;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSExceptionFactory;
use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\Common\Communication\ResponseHandlerInterface;

class OSSErrorResponseHandler implements ResponseHandlerInterface {
    public function handle(HttpResponse $response) {
        if ($response->isSuccess()) {
            return;
        }
        
        if (!$response->getContent() || $response->getContentLength() <= 0) {
            throw OSSExceptionFactory::factory()->createInvalidResponseException('ServerReturnsUnknownError');
        } 
        
        $error = OSSResponseParserFactory::factory()->createErrorParser()->parse($response, null);
        throw OSSExceptionFactory::factory()->createFromError($error);
    }
}

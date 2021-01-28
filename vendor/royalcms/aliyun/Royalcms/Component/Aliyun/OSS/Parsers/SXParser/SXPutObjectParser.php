<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\OSS\Models\PutObjectResult;
use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;
use Royalcms\Component\Aliyun\Common\Communication\ResponseParserInterface;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class SXPutObjectParser implements ResponseParserInterface {

    public function parse(HttpResponse $response, $options) {
        $putObjectResult = new PutObjectResult();
        $putObjectResult->setETag(OSSUtils::trimQuotes($response->getHeader(OSSHeaders::ETAG)));
        return $putObjectResult;
    } 
}
<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\UploadPartResult;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;
use Royalcms\Component\Aliyun\Common\Communication\ResponseParserInterface;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class SXUploadPartParser implements ResponseParserInterface {

    public function parse(HttpResponse $response, $options) {
        $result = new UploadPartResult();
        $result->setETag(OSSUtils::trimQuotes($response->getHeader(OSSHeaders::ETAG)));
        $result->setPartNumber($options[OSSOptions::PART_NUMBER]);
        return $result;
    } 
}
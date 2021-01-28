<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\Common\Utilities\DateUtils;
use Royalcms\Component\Aliyun\OSS\Models\CopyObjectResult;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class SXCopyObjectParser extends SXParser {

    public function parse(HttpResponse $response, $options) {
        $xml = $this->getXmlObject($response->getContent());
        $lastModified = DateUtils::parseDate((string) $xml->LastModified);
        $eTag = OSSUtils::trimQuotes((string) $xml->ETag);

        $copyObjectResult = new CopyObjectResult();

        $copyObjectResult->setLastModified($lastModified);
        $copyObjectResult->setETag($eTag);
        return $copyObjectResult;
    } 
}
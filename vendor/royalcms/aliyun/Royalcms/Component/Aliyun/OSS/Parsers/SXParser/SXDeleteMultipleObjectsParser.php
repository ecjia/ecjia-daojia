<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
// use Royalcms\Component\Aliyun\Common\Utilities\DateUtils;
use Royalcms\Component\Aliyun\OSS\Models\DeleteResult;
// use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class SXDeleteMultipleObjectsParser extends SXParser {

    public function parse(HttpResponse $response, $options) {
        $xml = $this->getXmlObject($response->getContent());
//         $lastModified = DateUtils::parseDate((string) $xml->LastModified);
//         $eTag = OSSUtils::trimQuotes((string) $xml->ETag);
//         $keys = '';
//         _dump($xml->Deleted,1);
        $deleteResult = new DeleteResult();

//         $deleteResult->setLastModified($lastModified);
        return $deleteResult;
    } 
}
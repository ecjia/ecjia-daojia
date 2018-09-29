<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\InitiateMultipartUploadResult;

class SXInitiateMultipartUploadParser extends SXParser {

    public function parse(HttpResponse $response, $options) {
        $xml = $this->getXmlObject($response->getContent());
        $result = new InitiateMultipartUploadResult();

        $result->setBucketName((string) $xml->Bucket);
        $result->setKey((string) $xml->Key);
        $result->setUploadId((string) $xml->UploadId);

        return $result;
    } 
}
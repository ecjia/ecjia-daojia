<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\OSSError;

class SXOSSErrorParser extends SXParser {
    public function parse(HttpResponse $response, $options) {
        $xml = $this->getXmlObject($response->getContent());
        $code = ($xml->Code)? (string)$xml->Code : null;
        $message = ($xml->Message)? (string)$xml->Message : null;
        $requestId = ($xml->RequestId)? (string)$xml->RequestId : null;
        $hostId = ($xml->HostId)? (string)$xml->HostId : null;

        $error = new OSSError();
        $error->setCode($code);
        $error->setRequestId($requestId);
        $error->setMessage($message);
        $error->setHostId($hostId);

        return $error;
    } 
}

<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\ResponseParserInterface;
use Royalcms\Component\Aliyun\Common\Exceptions\ClientException;

abstract class SXParser implements ResponseParserInterface  {
    protected function getXmlObject($content) {
        if (is_resource($content)) {
            @$content = stream_get_contents($content, -1, 0);
        }

        try {
            $xmlObject = new \SimpleXMLElement($content);
            return $xmlObject;
        } catch (\Exception $e) {
            throw new ClientException('Parse error', $e);
        }
    } 
}
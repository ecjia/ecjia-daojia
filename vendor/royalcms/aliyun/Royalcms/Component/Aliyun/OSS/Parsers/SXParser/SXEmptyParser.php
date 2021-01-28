<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\ResponseParserInterface;
use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;

/**
 * Class EmptyParser
 * do nothing for the service that need not be parsed.
 * @package Aliyun\OSS\Parsers\SXParser
 */
class SXEmptyParser implements  ResponseParserInterface {
    public function parse(HttpResponse $response, $options) {
        // Do nothing...
    } 
}
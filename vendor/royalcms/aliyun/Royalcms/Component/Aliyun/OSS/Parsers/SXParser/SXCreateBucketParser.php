<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\Bucket;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;

class SXCreateBucketParser extends SXParser {

    public function parse(HttpResponse $response, $options) {
        return new Bucket($options[OSSOptions::BUCKET]);
    } 
}
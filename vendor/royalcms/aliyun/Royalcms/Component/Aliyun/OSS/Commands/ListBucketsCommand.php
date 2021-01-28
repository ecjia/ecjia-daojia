<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Parsers\OSSResponseParserFactory;
use Royalcms\Component\Aliyun\OSS\Parsers\ListBucketParser;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class ListBucketsCommand extends OSSCommand {
    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        if (isset($options[OSSOptions::BUCKET])) {
            unset($options[OSSOptions::BUCKET]);
        }

        if (isset($options[OSSOptions::KEY])) {
            unset($options[OSSOptions::KEY]);
        }

        return $options;
    }

    protected function getRequest($options) {
        return OSSRequestBuilder::factory()
                        ->setEndpoint($options[OSSOptions::ENDPOINT])
                        ->setMethod(HttpMethods::GET)
                        ->build();
    }
}
 
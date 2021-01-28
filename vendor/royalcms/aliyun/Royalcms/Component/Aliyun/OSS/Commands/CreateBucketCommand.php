<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class CreateBucketCommand extends OSSCommand {

    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        AssertUtils::assertSet(array(
            OSSOptions::BUCKET,
        ), $options);

        if (isset($options[OSSOptions::KEY])) {
            unset($options[OSSOptions::KEY]);
        }
 
        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);

        return $options;
    }

    protected function getRequest($options) {
        return OSSRequestBuilder::factory()
            ->setEndpoint($options[OSSOptions::ENDPOINT])
            ->setBucket($options[OSSOptions::BUCKET])
            ->setMethod(HttpMethods::PUT)
            ->build();
    }
}
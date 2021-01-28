<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class InitiateMultipartUploadCommand extends OSSCommand {

    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        AssertUtils::assertSet(array(
            OSSOptions::BUCKET,
            OSSOptions::KEY,
        ), $options);

        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);
        OSSUtils::assertObjectKey($options[OSSOptions::KEY]);

        return $options;
    }

    protected function commandOptions() {
        return array(
            OSSOptions::CONTENT_TYPE => OSSUtils::DEFAULT_CONTENT_TYPE,
        );
    }

    protected function getRequest($options) {

        return OSSRequestBuilder::factory()
            ->addObjectMetadataHeaders($options)
            ->setEndpoint($options[OSSOptions::ENDPOINT])
            ->setMethod(HttpMethods::POST) 
            ->setBucket($options[OSSOptions::BUCKET])
            ->setKey($options[OSSOptions::KEY])
            ->addParameter(OSSUtils::SUBRESOURCE_UPLOADS, null)
            ->setContent('')
            ->build();
    }
}
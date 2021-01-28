<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Parsers\OSSResponseParserFactory;
use Royalcms\Component\Aliyun\OSS\Parsers\ListBucketParser;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class AbortMultipartUploadCommand extends OSSCommand {

    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        AssertUtils::assertSet(array(
            OSSOptions::BUCKET,
            OSSOptions::KEY,
            OSSOptions::UPLOAD_ID,
        ), $options);
        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);
        OSSUtils::assertObjectKey($options[OSSOptions::KEY]);
        return $options;
    }

    protected function getRequest($options) {
        return OSSRequestBuilder::factory()
            ->setEndpoint($options[OSSOptions::ENDPOINT])
            ->setBucket($options[OSSOptions::BUCKET])
            ->setKey($options[OSSOptions::KEY])
            ->addParameter('uploadId', $options[OSSOptions::UPLOAD_ID])
            ->setMethod(HttpMethods::DELETE)
            ->build();
    }
} 
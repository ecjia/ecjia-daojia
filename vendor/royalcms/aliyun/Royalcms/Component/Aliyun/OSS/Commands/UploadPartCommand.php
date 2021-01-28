<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class UploadPartCommand extends OSSCommand {
    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        AssertUtils::assertSet(array(
            OSSOptions::CONTENT,
            OSSOptions::BUCKET,
            OSSOptions::KEY,
            OSSOptions::UPLOAD_ID,
            OSSOptions::PART_NUMBER,
            OSSOptions::PART_SIZE,
        ), $options);

        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);
        OSSUtils::assertObjectKey($options[OSSOptions::KEY]);

        AssertUtils::assertNumber($options[OSSOptions::PART_NUMBER], OSSOptions::PART_NUMBER);
        AssertUtils::assertNumber($options[OSSOptions::PART_SIZE], OSSOptions::PART_SIZE);

        return $options;
 
    }

    protected function leaveRequestOpen($options) {
        return true;
    }

    protected function getRequest($options) {
        return OSSRequestBuilder::factory()
            ->setEndpoint($options[OSSOptions::ENDPOINT])
            ->setBucket($options[OSSOptions::BUCKET])
            ->setKey($options[OSSOptions::KEY])
            ->setMethod(HttpMethods::PUT)
            ->addParameter('partNumber', (string) intval($options[OSSOptions::PART_NUMBER]))
            ->addParameter('uploadId', $options[OSSOptions::UPLOAD_ID])
            ->setContent($options[OSSOptions::CONTENT])
            ->addHeader(OSSHeaders::CONTENT_LENGTH, (string) intval($options[OSSOptions::PART_SIZE]))
            ->build();
    }
}
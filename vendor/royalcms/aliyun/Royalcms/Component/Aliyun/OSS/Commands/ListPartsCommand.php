<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Parsers\OSSResponseParserFactory;
use Royalcms\Component\Aliyun\OSS\Parsers\ListBucketParser;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;
 
class ListPartsCommand extends OSSCommand {

    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        AssertUtils::assertSet(array(
            OSSOptions::BUCKET,
            OSSOptions::KEY,
            OSSOptions::UPLOAD_ID,
        ), $options);

        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);
        OSSUtils::assertObjectKey($options[OSSOptions::KEY]);

        if (isset($options[OSSOptions::PART_NUMBER_MARKER])) {
            AssertUtils::assertNumber($options[OSSOptions::PART_NUMBER_MARKER], OSSOptions::PART_NUMBER_MARKER);
        }

        if (isset($options[OSSOptions::MAX_PARTS])) {
            AssertUtils::assertNumber($options[OSSOptions::MAX_PARTS], OSSOptions::MAX_PARTS);
        }

        return $options;
    }

    protected function getRequest($options) {
        $builder = OSSRequestBuilder::factory();

        $builder->addParameter('uploadId', $options[OSSOptions::UPLOAD_ID]);

        if (isset($options[OSSOptions::MAX_PARTS])) {
            $builder->addParameter('max-parts', (string) $options[OSSOptions::MAX_PARTS]);
        }

        if (isset($options[OSSOptions::PART_NUMBER_MARKER])) {
            $builder->addParameter('part-number-marker', (string) intval($options[OSSOptions::PART_NUMBER_MARKER]));
        }

        return $builder
            ->setEndpoint($options[OSSOptions::ENDPOINT])
            ->setBucket($options[OSSOptions::BUCKET])
            ->setKey($options[OSSOptions::KEY])
            ->setMethod(HttpMethods::GET)
            ->build();
    }
}
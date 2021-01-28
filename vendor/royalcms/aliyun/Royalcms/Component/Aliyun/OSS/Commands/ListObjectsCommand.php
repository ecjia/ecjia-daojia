<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Parsers\OSSResponseParserFactory;
use Royalcms\Component\Aliyun\OSS\Parsers\ListBucketParser;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class ListObjectsCommand extends OSSCommand {

    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        AssertUtils::assertSet(array(
            OSSOptions::BUCKET, 
        ), $options);

        if (isset($options[OSSOptions::MAX_KEYS])) {
            AssertUtils::assertNumber($options[OSSOptions::MAX_KEYS], OSSOptions::MAX_KEYS);
        }

        if (isset($options[OSSOptions::KEY])) {
            unset($options[OSSOptions::KEY]);
        }

        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);

        return $options;
    }

    protected function getRequest($options) {
        $builder = OSSRequestBuilder::factory();

        if (isset($options[OSSOptions::PREFIX])) {
            $builder->addParameter('prefix', $options[OSSOptions::PREFIX]);
        }

        if (isset($options[OSSOptions::MARKER])) {
            $builder->addParameter('marker', $options[OSSOptions::MARKER]);
        }

        if (isset($options[OSSOptions::DELIMITER])) {
            $builder->addParameter('delimiter', $options[OSSOptions::DELIMITER]);
        }

        if (isset($options[OSSOptions::MAX_KEYS])) {
            $builder->addParameter('max-keys', (string) intval($options[OSSOptions::MAX_KEYS]));
        }


        return $builder
            ->setEndpoint($options[OSSOptions::ENDPOINT])
            ->setBucket($options[OSSOptions::BUCKET])
            ->setMethod(HttpMethods::GET)
            ->build();
    }
}
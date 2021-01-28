<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\DateUtils;
use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\ResponseHandlers\Head404ErrorHandle;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;



class GetObjectCommand extends OSSCommand {

    protected function leaveResponseOpen($options) {
        if (isset($options[OSSOptions::SAVE_AS])){
            if (is_string($options[OSSOptions::SAVE_AS])) {
                return false;
            }
        }
        return true;
    } 

    protected function getResponseHandlers($options) {
        $handlers = parent::getResponseHandlers($options);
        if ($options[OSSOptions::META_ONLY]) {
            array_unshift($handlers, new Head404ErrorHandle());
        }
        return $handlers;
    }

    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        AssertUtils::assertSet(array(
            OSSOptions::BUCKET,
            OSSOptions::KEY,
        ), $options);

        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);
        OSSUtils::assertObjectKey($options[OSSOptions::KEY]);

        if (isset($options[OSSOptions::META_ONLY])) {
            if ($options[OSSOptions::META_ONLY]) {
                unset($options[OSSOptions::SAVE_AS]);
            }
        }

        return $options;
    }

    protected function commandOptions() {
        return array(
            OSSOptions::META_ONLY => false,
        );
    }

    protected function getRequest($options) {

        if ($options[OSSOptions::META_ONLY] === true) {
            unset($options[OSSOptions::RANGE]);
            unset($options[OSSOptions::SAVE_AS]);
            unset($options[OSSOptions::RESPONSE_CONTENT_LANGUAGE]);
            unset($options[OSSOptions::RESPONSE_CONTENT_DISPOSITION]);
            unset($options[OSSOptions::RESPONSE_CACHE_CONTROL]);
            unset($options[OSSOptions::RESPONSE_CONTENT_TYPE]);
            unset($options[OSSOptions::RESPONSE_CONTENT_ENDCODING]);
            unset($options[OSSOptions::RESPONSE_EXPIRES]);
        }

        $builder = OSSRequestBuilder::factory();

        if (isset($options[OSSOptions::RANGE])) {
            $range = $options[OSSOptions::RANGE];
            $rangeValue = 'bytes=';
            if ($range[0] == -1) {
                $rangeValue .= '-' . $range[1];
            } else if ($range[1] == -1) {
                $rangeValue .= $range[0] . '-';
            } else {
                $rangeValue .= $range[0] . '-' . $range[1];
            }

            $builder->addHeader(OSSHeaders::RANGE, $rangeValue);
        }

        if (isset($options[OSSOptions::MODIFIED_SINCE_CONSTRAINT])) {
            $builder->addHeader(OSSHeaders::GET_OBJECT_IF_MODIFIED_SINCE, DateUtils::formatDate($options[OSSOptions::MODIFIED_SINCE_CONSTRAINT]));
        }

        if (isset($options[OSSOptions::UNMODIFIED_SINCE_CONSTRAINT])) {
            $builder->addHeader(OSSHeaders::GET_OBJECT_IF_UNMODIFIED_SINCE, DateUtils::formatDate($options[OSSOptions::UNMODIFIED_SINCE_CONSTRAINT]));
        }

        if (isset($options[OSSOptions::MATCHING_ETAG_CONSTRAINTS])) {
            $constraints = $options[OSSOptions::MATCHING_ETAG_CONSTRAINTS];
            $builder->addHeader(OSSHeaders::GET_OBJECT_IF_MATCH, join(', ', $constraints));
        }

        if (isset($options[OSSOptions::NO_MATCHING_ETAG_CONSTRAINTS])) {
            $constraints = $options[OSSOptions::NO_MATCHING_ETAG_CONSTRAINTS];
            $builder->addHeader(OSSHeaders::GET_OBJECT_IF_NONE_MATCH, join(', ', $constraints));
        }

        if (isset($options[OSSOptions::SAVE_AS])) {
            $builder->setResponseBody($options[OSSOptions::SAVE_AS]);
        }


        return $builder
                ->setEndpoint($options[OSSOptions::ENDPOINT])
                ->setBucket($options[OSSOptions::BUCKET])
                ->setKey($options[OSSOptions::KEY])
                ->setMethod($options[OSSOptions::META_ONLY] ? HttpMethods::HEAD : HttpMethods::GET)
                ->addOverrides($options)
                ->build();
    }

    protected function afterResult($result, $options) {

        if (isset($options[OSSOptions::SAVE_AS])) {
            $result->setObjectContent(null);
        }

        return $result;
    }

}
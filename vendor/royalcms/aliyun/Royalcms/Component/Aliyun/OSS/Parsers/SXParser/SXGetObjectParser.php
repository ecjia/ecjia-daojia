<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Utilities\DateUtils;
use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\OSSObject;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class SXGetObjectParser extends SXParser {

    public function parse(HttpResponse $response, $options) {
        $object = new OSSObject();
        $object->setBucketName($options[OSSOptions::BUCKET]);
        $object->setKey($options[OSSOptions::KEY]);

        if (!$options[OSSOptions::META_ONLY])
            $object->setObjectContent($response->getContent());

        foreach ($response->getHeaders() as $key => $value) {
            if ($key == OSSHeaders::LAST_MODIFIED) {
                $object->addMetadata(OSSHeaders::LAST_MODIFIED, DateUtils::parseDate($value));
            } else if ($key == OSSHeaders::CONTENT_LENGTH) {
                $object->addMetadata(OSSHeaders::CONTENT_LENGTH, (int) $value);
            } else if ($key == OSSHeaders::ETAG) {
                $object->addMetadata(OSSHeaders::ETAG, OSSUtils::trimQuotes($value));
            } else if (strpos($key, OSSHeaders::OSS_USER_META_PREFIX) === 0) {
                $key = substr($key, strlen(OSSHeaders::OSS_USER_META_PREFIX));
                $object->addUserMetadata($key, $value);
            } else {
                $object->addMetadata($key, $value);
            }
        }
        return $object;
    } 
}

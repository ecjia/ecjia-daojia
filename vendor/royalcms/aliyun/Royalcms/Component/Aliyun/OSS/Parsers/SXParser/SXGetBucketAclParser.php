<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\AccessControlPolicy;
use Royalcms\Component\Aliyun\OSS\Models\Owner;

class SXGetBucketAclParser extends SXParser {

    public function parse(HttpResponse $response, $options) {
        $xml = $this->getXmlObject($response->getContent());

        $accessPolicy = new AccessControlPolicy();

        if (isset($xml->Owner)) {
            $owner  = new Owner();
            $owner->setId((string) $xml->Owner->ID);
            $owner->setDisplayName((string) $xml->Owner->DisplayName);
            $accessPolicy->setOwner($owner);
        }

        if (isset($xml->AccessControlList)) {
            $grants = array();
            foreach ($xml->AccessControlList as $access) {
                $grants[] = (string) $access->Grant;
            }
            $accessPolicy->setGrants($grants);
        }
        return $accessPolicy;
    } 
}
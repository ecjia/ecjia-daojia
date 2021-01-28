<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Utilities\DateUtils;
use Royalcms\Component\Aliyun\OSS\Models\Bucket;
use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\Owner;

class SXListBucketsParser extends SXParser {
    public function parse(HttpResponse $response, $options) {
        $xml = $this->getXmlObject($response->getContent());
        $buckets = array();

        $owner = ($xml->Owner) ? new Owner() : null;
        $owner->setId((string) $xml->Owner->ID);
        $owner->setDisplayName((string) $xml->Owner->DisplayName);

        if ($xml->Buckets) {
            foreach ($xml->Buckets->children() as $bucket) {
                $bucketName = (string)$bucket->Name;
                $creationDate = (string)$bucket->CreationDate;
                $bucket = new Bucket($bucketName);
                $bucket->setOwner($owner);
                $bucket->setName($bucketName);
                $bucket->setCreationDate(DateUtils::parseDate($creationDate));
                $buckets[] = $bucket;
            }            
        }
        return $buckets;
    } 
}

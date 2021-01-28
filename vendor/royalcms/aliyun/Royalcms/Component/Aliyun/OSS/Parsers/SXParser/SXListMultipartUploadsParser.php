<?php

namespace Royalcms\Component\Aliyun\OSS\Parsers\SXParser;

use Royalcms\Component\Aliyun\Common\Utilities\DateUtils;
use Royalcms\Component\Aliyun\Common\Communication\HttpResponse;
use Royalcms\Component\Aliyun\OSS\Models\MultipartUpload;
use Royalcms\Component\Aliyun\OSS\Models\MultipartUploadsListing;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;

class SXListMultipartUploadsParser extends SXParser {

    public function parse(HttpResponse $response, $options) {
        $xml = $this->getXmlObject($response->getContent());

        $multipartUploadsListing = new MultipartUploadsListing();

        $bucket = (string) $xml->Bucket;
        $prefix = (string) $xml->Prefix ? (string) $xml->Prefix : null;
        $keyMarker = (string) $xml->KeyMarker ? (string) $xml->KeyMarker : null;
        $uploadIdMarker = (string) $xml->UploadIdMarker ? (string) $xml->UploadIdMarker : null;
        $nextKeyMarker = (string) $xml->NextKeyMarker ? (string) $xml->NextKeyMarker : null;
        $nextUploadIdMarker = (string) $xml->NextUploadIdMarker ? (string) $xml->NextUploadIdMarker : null;
        $maxUploads = $xml->MaxUploads ? (int) $xml->MaxUploads : null;
        $delimiter = $xml->Delimiter ? (string) $xml->Delimiter : null;
        $isTruncated = $xml->IsTruncated ? (string) $xml->IsTruncated : null;

        if ($isTruncated === 'true') {
            $isTruncated = true;
        } else {
            $isTruncated = false;
        }

        $multipartUploadsListing->setBucketName($bucket);
        $multipartUploadsListing->setPrefix($prefix);
        $multipartUploadsListing->setKeyMarker($keyMarker);
        $multipartUploadsListing->setUploadIdMarker($uploadIdMarker);
        $multipartUploadsListing->setNextKeyMarker($nextKeyMarker);
        $multipartUploadsListing->setNextUploadIdMarker($nextUploadIdMarker);
        $multipartUploadsListing->setMaxUploads($maxUploads);
        $multipartUploadsListing->setIsTruncated($isTruncated);
        $multipartUploadsListing->setDelimiter($delimiter);

        if ($xml->Upload) {
            $uploads = array();
            foreach ($xml->Upload as $upload) {
                $multipartUpload = new MultipartUpload();
                $multipartUpload->setKey((string) $upload->Key);
                $multipartUpload->setUploadId((string) $upload->UploadId);
                $multipartUpload->setInitiated(DateUtils::parseDate((string) $upload->Initiated));
                $uploads[] = $multipartUpload;
            }
            $multipartUploadsListing->setMultipartUploads($uploads);
        }

        if ($xml->CommonPrefixes) {
            $commonPrefixes = array();
            foreach ($xml->CommonPrefixes->Prefix as $commonPrefix) {
                $commonPrefixes[] = (string) $commonPrefix;
            }
            $multipartUploadsListing->setCommonPrefixes($commonPrefixes);
        }

        return $multipartUploadsListing;
    } 
}
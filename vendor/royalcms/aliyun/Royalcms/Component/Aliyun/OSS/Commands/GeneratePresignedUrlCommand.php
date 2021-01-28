<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Auth\ServiceSignature;
use Royalcms\Component\Aliyun\Common\Communication\HttpRequest;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\Common\Utilities\HttpHeaders;
use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Auth\OSSRequestSigner;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\OSS\OSSClient;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\SignUtils;
use Royalcms\Component\Aliyun\Common\Exceptions\ClientException;

class GeneratePresignedUrlCommand {

    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    private function getCommandOptions() {
        return array(
            OSSOptions::METHOD => 'GET',
        );
    } 

    private function checkOptions($options) {
        AssertUtils::assertSet(array(
            OSSOptions::BUCKET,
            OSSOptions::KEY,
            OSSOptions::EXPIRES,
        ), $options);

        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);
        if (isset($options[OSSOptions::KEY])) {
            OSSUtils::assertObjectKey($options[OSSOptions::KEY]);
        }

        if (!($options[OSSOptions::EXPIRES] instanceof \DateTime)) {
            throw new \InvalidArgumentException(OSSOptions::EXPIRES . ' must be instance of \DateTime');
        }

        $options[OSSOptions::METHOD] = strtoupper($options[OSSOptions::METHOD]);

        return $options;
    }

    private function generate($options) {
        $bucket = $options[OSSOptions::BUCKET];
        $key = $options[OSSOptions::KEY];
        $method = $options[OSSOptions::METHOD];

        $expires = $options[OSSOptions::EXPIRES];
        $expires = (string) $expires->getTimeStamp();

        $builder = OSSRequestBuilder::factory()
            ->setEndpoint($options[OSSOptions::ENDPOINT])
            ->setBucket($bucket)
            ->setKey($key)
            ->setMethod($method)
            ->addHeader(HttpHeaders::DATE, $expires);

        if (isset($options[OSSOptions::CONTENT_TYPE])) {
            $builder->addHeader(OSSHeaders::CONTENT_TYPE, $options[OSSOptions::CONTENT_TYPE]);
        }

        if (isset($options[OSSOptions::USER_METADATA])) {
            foreach ($options[OSSOptions::USER_METADATA] as $metakey => $value) {
                $builder->addHeader(OSSHeaders::OSS_USER_META_PREFIX . $metakey, $value);
            }
        }

        // Overrides
        $builder->addOverrides($options);

        $request = $builder->build();

        $canonicalString = SignUtils::buildCanonicalString($request, $bucket, $key);

        $signature = ServiceSignature::factory()->computeSignature($options[OSSOptions::ACCESS_KEY_SECRET], $canonicalString);

        $request->addParameter('OSSAccessKeyId', $options[OSSOptions::ACCESS_KEY_ID]);
        $request->addParameter('Signature', $signature);
        $request->addParameter('Expires', $expires);

        return $request->getFullUrl();
    }

    public function execute($clientOptions, $userOptions) {
        $options = array_merge($clientOptions, $this->getCommandOptions(), $userOptions);
        $options = $this->checkOptions($options);
        try {
            return $this->generate($options);
        } catch (\Exception $ex) {

            if ($ex instanceof ClientException) {
                throw $ex;
            }

            throw new ClientException($ex->getMessage(), $ex);
        }
    }
}
<?php

namespace Royalcms\Component\Aliyun\OSS\Commands;

use Royalcms\Component\Aliyun\Common\Utilities\HttpMethods;
use Royalcms\Component\Aliyun\OSS\Models\OSSOptions;
use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSRequestBuilder;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSUtils;
use Royalcms\Component\Aliyun\OSS\Utilities\OSSHeaders;

class DeleteMultipleObjectsCommand extends OSSCommand {
    protected function checkOptions($options) {
        $options = parent::checkOptions($options);
        AssertUtils::assertSet(array(
            OSSOptions::BUCKET,
            OSSOptions::KEYS,
            OSSOptions::QUIET,
        ), $options);
        
        if (isset($options[OSSOptions::KEY])) {
            unset($options[OSSOptions::KEY]);
        }

        OSSUtils::assertBucketName($options[OSSOptions::BUCKET]);

        return $options;
    }
    
    protected function getRequest($options) {
        $content = self::createDeleteObjectsXmlBody($options['Keys'], $options['Quiet']);
        
        $builder = OSSRequestBuilder::factory();
        $builder->setContentLength((string) strlen($content));
        $builder->addHeader(OSSHeaders::CONTENT_MD5, base64_encode(md5($content, true)));
        $builder->addHeader(OSSHeaders::CONTENT_TYPE, 'application/xml');
        
        return $builder
                ->setEndpoint($options[OSSOptions::ENDPOINT])
                ->setBucket($options[OSSOptions::BUCKET])
                ->addParameter('delete', null)
                ->setMethod(HttpMethods::POST)
                ->setContent($content)
                ->build();
    }
    
    /**
     * 生成DeleteMultiObjects接口的xml消息
     *
     * @param string[] $objects
     * @param bool $quiet
     * @return string
     */
    private static function createDeleteObjectsXmlBody($objects, $quiet)
    {
        $quite = $quiet ? 'true' : 'false';
        
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Delete></Delete>');
        $xml->addChild('Quiet', $quiet);
        foreach ($objects as $object) {
            $sub_object = $xml->addChild('Object');
            $object = self::sReplace($object);
            $sub_object->addChild('Key', $object);
        }
        return $xml->asXML();
    }
    
    /**
     * 转义字符替换
     *
     * @param string $subject
     * @return string
     */
    private static function sReplace($subject)
    {
        $search = array('<', '>', '&', '\'', '"');
        $replace = array('&lt;', '&gt;', '&amp;', '&apos;', '&quot;');
        return str_replace($search, $replace, $subject);
    }
    
}
 
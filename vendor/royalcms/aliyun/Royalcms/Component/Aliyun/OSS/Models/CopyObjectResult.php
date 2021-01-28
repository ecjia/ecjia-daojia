<?php

namespace Royalcms\Component\Aliyun\OSS\Models;

/**
 * CopyObject 的返回结果
 *
 * @package Royalcms\Component\Aliyun\OSS\Models
 */
class CopyObjectResult {
    /**
     * @var \DateTime Object最后修改时间
     */
    private $lastModified;

    /**
     * @var string eTag
     */
    private $eTag;

    /**
     * @internal
     * @param string $eTag
     */
    public function setETag($eTag) {
        $this->eTag = $eTag;
    }

    /**
     * 获取新Object的ETag
     *
     * @return string
     */
    public function getETag() {
        return $this->eTag;
    }

    /**
     * @internal
     * @param \DateTime $lastModified
     */
    public function setLastModified($lastModified) {
        $this->lastModified = $lastModified;
    }

    /**
     * 获取新Object的最后修改时间。
     *
     * @return \DateTime
     */
    public function getLastModified() {
        return $this->lastModified;
    }
}
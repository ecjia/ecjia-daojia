<?php

namespace Royalcms\Component\Aliyun\OSS\Models;

/**
 * 用以表示每个分块上传事件的信息
 *
 * @package Royalcms\Component\Aliyun\OSS\Models
 */
class MultipartUpload {
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $uploadId;

    /**
     * @var \DateTime 上传事件初始化的时间
     */
    private $initiated;

    /**
     * @internal
     * @param \DateTime $initiated
     */
    public function setInitiated($initiated) {
        $this->initiated = $initiated;
    }

    /**
     * 获取上传事件初始化的时间
     *
     * @return \DateTime
     */
    public function getInitiated() {
        return $this->initiated;
    }

    /**
     * @internal
     * @param string $key
     */
    public function setKey($key) {
        $this->key = $key;
    }

    /**
     * 获取分块上传Object的Key
     * @return string
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * @internal
     * @param string $uploadId
     */
    public function setUploadId($uploadId) {
        $this->uploadId = $uploadId;
    }

    /**
     * 获取上传事件的UploadId
     *
     * @return string
     */
    public function getUploadId() {
        return $this->uploadId;
    }

}
<?php

namespace Royalcms\Component\Aliyun\OSS\Models;

/**
 *
 * 表示OSS的访问控制策略。
 *
 * @package Royalcms\Component\Aliyun\OSS\Models
 */
class AccessControlPolicy {
    /**
     * @var Owner
     */
    private $owner;

    /**
     * @var array
     */
    private $grants;

    /**
     * @internal
     * @param array $grants
     */
    public function setGrants($grants) {
        $this->grants = $grants;
    }

    /**
     * 获取授权列表
     *
     * @return array
     */
    public function getGrants() {
        return $this->grants;
    }

    /**
     * @internal
     * @param \Royalcms\Component\Aliyun\OSS\Models\Owner $owner
     */
    public function setOwner($owner) {
        $this->owner = $owner;
    }

    /**
     * 获取所有者
     *
     * @return \Royalcms\Component\Aliyun\OSS\Models\Owner
     */
    public function getOwner() {
        return $this->owner;
    }
}

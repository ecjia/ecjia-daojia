<?php

namespace Royalcms\Component\Aliyun\OSS\Models;

use Royalcms\Component\Aliyun\Common\Utilities\AssertUtils;

/**
 * 
 * @package Royalcms\Component\Aliyun\OSS\Models
 */
class DeleteResult {
    /**
     * @var array Object 信息列表
     */
    private $objectDeleteds = array();

    /**
     * 获取Bucket的名字
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * 设置Bucket的名字
     *
     * @internal
     *
     * @param string $name Bucket的名字
     */
    public function setName($name) {
        AssertUtils::assertString($name, 'name');
        $this->name = $name; 
    }
    
    /**
     * 获取Bucket的所有者
     *
     * @return Owner Bucket的所有者
     */
    public function getOwner() {
        return $this->owner;
    }
    
    /**
     * 设置Bucket的所有者
     *
     * @internal
     *
     * @param string $owner Bucket的所有者
     */
    public function setOwner($owner) {
        $this->owner = $owner;
    }
    
    /**
     * 返回Bucket的创建时间
     *
     * @return \DateTime Bucket的创建时间
     */
    public function getCreationDate() {
        return $this->creationDate;
    }
    
    /**
     * 设置Bucket创建的时间
     *
     * @internal
     *
     * @param \DateTime $creationDate Bucket创建的时间
     */
    public function setCreationDate(\DateTime $creationDate) {
        $this->creationDate = $creationDate;
    }
}

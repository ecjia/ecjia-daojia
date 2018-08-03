<?php

namespace Ecjia\System\Frameworks\Contracts;

interface UserAllotPurview
{
    /**
     * 获取当前用户ID
     */
    public function getUserId();
    
    
    /**
     * 保存权限值给指定用户
     * @param unknown $value
     */
    public function save($value);
    
    /**
     * 获取用户的权限值
     */
    public function get();
}

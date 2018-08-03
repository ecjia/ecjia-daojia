<?php

namespace Ecjia\System\Frameworks\Contracts;

interface UserInterface
{
    /**
     * 获取用户名
     */
    public function getUserName();
    
    /**
     * 获取用户ID
     */
    public function getUserId();
    
    /**
     * 获取用户的类型
     */
    public function getUserType();
    
    /**
     * 获取用户邮箱
     */
    public function getEmail();
    
    /**
     * 获取用户最后一次登录时间
     */
    public function getLastLogin();
    
    /**
     * 获取用户最后一次登录IP
     */
    public function getLastIp();
    
    /**
     * 获取用户权限列表
     */
    public function getActionList();
    
    /**
     * 获取用户权限列表
     */
    public function setActionList($purview);
    
    /**
     * 获取用户设置的语言类型
     */
    public function getLangType();
    
    /**
     * 获取用户的角色ID
     */
    public function getRoleId();
    
    /**
     * 获取用户的类型
     */
    public function getAddTime();
    
}

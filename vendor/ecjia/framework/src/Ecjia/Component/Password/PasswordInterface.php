<?php


namespace Ecjia\Component\Password;


interface PasswordInterface
{

    /**
     * 创建加盐密码
     * @param $password
     * @param null $salt
     * @return string
     */
    public function createSaltPassword($password, $salt = null);


    /**
     * 验证加盐密码
     * @param $password
     * @param null $password
     * @param null $salt
     */
    public function verifySaltPassword($hash, $password, $salt = null);

}
<?php


namespace Ecjia\Component\Password;


interface ResetPasswordInterface
{

    /**
     * 生成找回密码的Hash Code
     * @param $user_id
     * @param $password
     * @param null $hash_code
     */
    public function generateResetPasswordHash($user_id, $password, $hash_code = null);


    /**
     * 验证找回密码的Hash Code
     * @param $hash
     * @param $user_id
     * @param $password
     * @param null $hash_code
     * @return bool
     */
    public function verifyResetPasswordHash($hash, $user_id, $password, $hash_code = null);
    
}
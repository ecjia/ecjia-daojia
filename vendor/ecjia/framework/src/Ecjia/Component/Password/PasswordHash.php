<?php


namespace Ecjia\Component\Password;

use Illuminate\Support\Facades\Hash;

class PasswordHash implements PasswordInterface, ResetPasswordInterface
{

    /**
     * 创建加盐密码
     * @param $password
     * @param null $salt
     * @return string
     */
    public function createSaltPassword($password, $salt = null)
    {
        return Hash::make($password);
    }

    /**
     * 验证加盐密码
     * @param $password
     * @param null $password
     * @param null $salt
     */
    public function verifySaltPassword($hash, $password, $salt = null)
    {
        return Hash::check($password, $hash);
    }


    /**
     * 生成找回密码的Hash Code
     * @param $user_id
     * @param $password
     * @param null $hash_code
     */
    public function generateResetPasswordHash($user_id, $password, $hash_code = null)
    {
        $password = $user_id . $password;

        return $this->createSaltPassword($password, $hash_code);
    }


    /**
     * 验证找回密码的Hash Code
     * @param $hash
     * @param $user_id
     * @param $password
     * @param null $hash_code
     * @return bool
     */
    public function verifyResetPasswordHash($hash, $user_id, $password, $hash_code = null)
    {
        $password = $user_id . $password;

        return Hash::check($password, $hash);
    }

}
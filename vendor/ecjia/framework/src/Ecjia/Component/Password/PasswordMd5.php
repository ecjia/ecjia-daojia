<?php


namespace Ecjia\Component\Password;


class PasswordMd5 implements PasswordInterface, ResetPasswordInterface
{

    /**
     * 创建加盐密码
     * @param $password
     * @param null $salt
     * @return string
     */
    public function createSaltPassword($password, $salt = null)
    {
        if (empty($salt)) {
            return md5($password);
        }

        return md5(md5($password) . $salt);
    }

    /**
     * 验证加盐密码
     * @param $password
     * @param null $password
     * @param null $salt
     */
    public function verifySaltPassword($hash, $password, $salt = null)
    {
        $password = $this->createSaltPassword($password, $salt);

        return ($password === $hash);
    }

    /**
     * 生成找回密码的Hash Code
     * @param $user_id
     * @param $password
     * @param null $hash_code
     * @return string
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
        $generate_hash = $this->generateResetPasswordHash($user_id, $password, $hash_code);

        return $hash === $generate_hash;
    }


}
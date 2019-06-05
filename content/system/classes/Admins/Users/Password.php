<?php


namespace Ecjia\System\Admins\Users;


class Password
{

    /**
     * 创建加盐密码
     * @param $password
     * @param null $salt
     * @return string
     */
    public static function createSaltPassword($password, $salt = null)
    {
        if (is_null($salt)) {
            return md5($password);
        }

        return md5(md5($password) . $salt);
    }

    /**
     * 生成找回密码的Hash Code
     * @param $user_id
     * @param $password
     * @param $rand_code
     */
    public static function generateResetPasswordHash($user_id, $password, $hash_code = null)
    {
        $password = $user_id . $password;

        return self::createSaltPassword($password, $hash_code);

    }

    /**
     * 验证找回密码的Hash Code
     * @param $hash
     * @param $user_id
     * @param $password
     * @param null $rand_code
     * @return bool
     */
    public static function verifyResetPasswordHash($hash, $user_id, $password, $hash_code = null)
    {
        $generate_hash = self::generateResetPasswordHash($user_id, $password, $hash_code);

        return $hash === $generate_hash;
    }


}
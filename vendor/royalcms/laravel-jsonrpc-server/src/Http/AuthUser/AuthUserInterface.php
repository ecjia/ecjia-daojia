<?php


namespace Royalcms\Laravel\JsonRpcServer\Http\AuthUser;


interface AuthUserInterface
{

    /**
     * @param $username 验证的用户名
     * @param $password 验证的密码，使用password_verify验证
     * @param null|string|array $user 指定用户验证，特殊使用
     * @return bool
     */
    public function verify($username, $password, $user = null);

}
<?php


namespace Ecjia\App\Rpc\AuthUser;


use Ecjia\App\Rpc\Repositories\DefaultRpcAccountRepository;
use Royalcms\Laravel\JsonRpcServer\Http\AuthUser\AuthUserInterface;

class AuthUser implements AuthUserInterface
{

    /**
     * @param $username
     * @param $password
     * @param null $user
     * @return bool
     */
    public function verify($username, $password, $user = null)
    {
        if ($username === null || $password === null) {
            return false;
        }

        $model = (new DefaultRpcAccountRepository)->findBy('appid', $username);
        if (empty($model)) {
            return false;
        }

        if (password_verify($model->appsecret, $password)) {
            return true;
        }

        return false;
    }

}

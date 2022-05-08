<?php


namespace Royalcms\Laravel\JsonRpcServer\Http\AuthUser;


class AuthUser implements AuthUserInterface
{
    /**
     * @var array
     */
    protected $users;

    public function __construct()
    {
        $this->users = config('basic-auth.users');
    }

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

        $users = $this->getUsers($user);

        foreach ($users as $user => $credentials) {
            if (
                reset($credentials) == $username &&
                password_verify(end($credentials), $password)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param null $user
     * @return array
     */
    protected function getUsers($user = null)
    {
        if ($user !== null) {
            return array_intersect_key($this->users, array_flip((array) $user));
        }

        return $this->users;
    }

}

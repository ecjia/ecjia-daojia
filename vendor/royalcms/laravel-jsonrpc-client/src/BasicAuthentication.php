<?php


namespace Royalcms\Laravel\JsonRpcClient;


class BasicAuthentication
{

    private $username;

    private $password;

    /**
     * BasicAuthentication constructor.
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return BasicAuthentication
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return BasicAuthentication
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorization()
    {
        $username = $this->username;
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $authentication = base64_encode("{$username}:{$password}");
        return $authentication;
    }

    /**
     * @return string[]
     */
    public function getAuthorizationHeaders()
    {
        $headers = ['Authorization' => "Basic {$this->getAuthorization()}"];
        return $headers;
    }

}

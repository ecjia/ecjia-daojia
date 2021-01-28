<?php


namespace Ecjia\System\Admins\Users;


use RC_Ip;
use RC_Session;

class AdminUserSession
{
    /**
     * @var integer
     */
    private $admin_id;

    /**
     * @var string
     */
    private $admin_name;

    /**
     * @var string
     */
    private $admin_email;

    /**
     * @var string
     */
    private $action_list;

    /**
     * @var string
     */
    private $last_check_time;

    /**
     * @var integer
     */
    private $session_user_id;

    /**
     * @var string
     */
    private $session_user_type;

    /**
     * @var string
     */
    private $client_ip;

    /**
     * AdminUserSession constructor.
     * @param int $admin_id
     * @param string $admin_name
     * @param string $admin_email
     * @param string $action_list
     * @param string $last_check_time
     * @param int $session_user_id
     * @param string $session_user_type
     * @param string $client_ip
     */
    public function __construct($admin_id = null, $admin_name = null, $admin_email = null, $action_list = null, $last_check_time = null, $session_user_id = null, $session_user_type = null, $client_ip = null)
    {
        $this->admin_id          = $admin_id;
        $this->admin_name        = $admin_name;
        $this->admin_email       = $admin_email;
        $this->action_list       = $action_list;
        $this->last_check_time   = $last_check_time;
        $this->session_user_id   = $session_user_id;
        $this->session_user_type = $session_user_type;
        $this->client_ip         = $client_ip;
    }

    /**
     * @return int
     */
    public function getAdminId()
    {
        return $this->admin_id;
    }

    /**
     * @param int $admin_id
     * @return AdminUserSession
     */
    public function setAdminId($admin_id): AdminUserSession
    {
        $this->admin_id = $admin_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminName()
    {
        return $this->admin_name;
    }

    /**
     * @param string $admin_name
     * @return AdminUserSession
     */
    public function setAdminName($admin_name): AdminUserSession
    {
        $this->admin_name = $admin_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminEmail()
    {
        return $this->admin_email;
    }

    /**
     * @param string $admin_email
     * @return AdminUserSession
     */
    public function setAdminEmail($admin_email): AdminUserSession
    {
        $this->admin_email = $admin_email;
        return $this;
    }

    /**
     * @return string
     */
    public function getActionList()
    {
        return $this->action_list;
    }

    /**
     * @param string $action_list
     * @return AdminUserSession
     */
    public function setActionList($action_list): AdminUserSession
    {
        $this->action_list = $action_list;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastCheckTime()
    {
        return $this->last_check_time;
    }

    /**
     * @param string $last_check_time
     * @return AdminUserSession
     */
    public function setLastCheckTime($last_check_time): AdminUserSession
    {
        $this->last_check_time = $last_check_time;
        return $this;
    }

    /**
     * @return int
     */
    public function getSessionUserId()
    {
        return $this->session_user_id;
    }

    /**
     * @param int $session_user_id
     * @return AdminUserSession
     */
    public function setSessionUserId($session_user_id): AdminUserSession
    {
        $this->session_user_id = $session_user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSessionUserType()
    {
        return $this->session_user_type;
    }

    /**
     * @param string $session_user_type
     * @return AdminUserSession
     */
    public function setSessionUserType($session_user_type): AdminUserSession
    {
        $this->session_user_type = $session_user_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->client_ip;
    }

    /**
     * @param string $client_ip
     * @return AdminUserSession
     */
    public function setClientIp($client_ip): AdminUserSession
    {
        $this->client_ip = $client_ip;
        return $this;
    }

    /**
     * 创建登录会话
     */
    public function createLoginSession()
    {
        RC_Session::set('admin_id', $this->admin_id);
        RC_Session::set('admin_name', $this->admin_name);
        RC_Session::set('action_list', $this->action_list);
        RC_Session::set('last_check_order', $this->last_check_time); // 用于保存最后一次检查订单的时间
        RC_Session::set('session_user_id', $this->session_user_id ?: $this->admin_id);
        RC_Session::set('session_user_type', $this->session_user_type ?: 'admin');
        RC_Session::set('email', $this->admin_email);
        RC_Session::set('ip', RC_Ip::client_ip());
    }

}
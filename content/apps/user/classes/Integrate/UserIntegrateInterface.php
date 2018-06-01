<?php

namespace Ecjia\App\User\Integrate;


class UserIntegrateInterface
{
    
    
    public function compile_password($cfg);
    
    
    
    public function check_user($username, $password = null);
    
    
    
    public function check_email($email);
    
    
    /**
     *  设置指定用户SESSION
     *
     * @access  public
     * 
     * @return void
     */
    public function setSession($username);
    
    
    public function clearSession();
    
    
    /**
     *  设置cookie
     *
     * @return void
     */
    public function setCookie($username, $remember = null );
    
    
    public function clearCookie();
    
    
    
    
}
<?php 

namespace Royalcms\Component\Ucenter\Client\Services;

use Royalcms\Component\Ucenter\Client\Traits\FunctionTrait;
use Royalcms\Component\Ucenter\Client\Contracts\UcApi;
use Exception;
use RC_Http;

class Api implements UcApi
{
    use FunctionTrait;
    
    protected $request;
    
    
    public function __construct()
    {
        $this->request = royalcms('request');
    }

    public  function test()
    {
        return API_RETURN_SUCCEED;
    }
    
    public  function deleteuser()
    {
        $uids = $this->get['ids'];
       
        /*
        同步删除用户代码
         */
        
        return API_RETURN_SUCCEED;
    }
    
    public  function renameuser()
    {
        $uid = $this->get['uid'];
        $oldusername = $this->get['oldusername'];
        $newusername = $this->get['newusername'];
        
        /*
        同步重命名用户代码
        */
        
        return API_RETURN_SUCCEED;
    }

    public  function updatepw()
    {

        $username = $this->get['username'];
        $password = $this->get['password'];

        /*
        同步更新用户密码
         */
        
        return API_RETURN_SUCCEED;
    }


    public  function synlogin()
    {
        $uid = $this->get['uid'];
        $username = $this->get['username'];

        /*
        
        同步登陆代码
        
        */
        return API_RETURN_SUCCEED;
    }

    public  function synlogout()
    {

        /*
        
        同步注销代码
        
        */
        return API_RETURN_SUCCEED;
    }


}

// end
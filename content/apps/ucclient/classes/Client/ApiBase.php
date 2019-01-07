<?php

namespace Ecjia\App\Ucclient\Client;

class ApiBase
{

    //启用接口
    const API_DELETEUSER            = true;
    const API_RENAMEUSER            = true;
    const API_SYNLOGIN              = true;
    const API_SYNLOGOUT             = true;
    const API_UPDATEPW              = true;
    
    //禁用接口
    const API_GETTAG                = false;
    const API_UPDATEBADWORDS        = false;
    const API_UPDATEHOSTS           = false;
    const API_UPDATEAPPS            = false;
    const API_UPDATECLIENT          = false;
    const API_UPDATECREDIT          = false;
    const API_GETCREDIT             = false;
    const API_GETCREDITSETTINGS     = false;
    const API_UPDATECREDITSETTINGS  = false;
    const API_ADDFEED               = false;
    
    //返回值
    const API_RETURN_SUCCEED    = 1;
    const API_RETURN_FAILED     = -1;
    const API_RETURN_FORBIDDEN  = -2;


    public function __construct()
    {

    }
    
    
    
}

// end
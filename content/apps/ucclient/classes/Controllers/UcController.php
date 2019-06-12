<?php

namespace Ecjia\App\Ucclient\Controllers;

use Ecjia\App\Ucclient\Client\ApiRouter;
use Ecjia\App\Ucclient\Client\ApiBase;
use Ecjia\System\BaseController\BasicController;

class UcController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    
    public function init()
    {
        $get = array();
        
        $code = $this->request->input('code');
        parse_str(ApiBase::authcode($code, 'DECODE', RC_Ucenter::config()->UC_KEY()), $get);
        if (SYS_TIME - $get['time'] > 3600) {
            exit('Authracation has expiried');
        }
        
        if (empty($get)) {
            exit('Invalid Request');
        }
        
        $url = $get['action'];
        
        $router = new ApiRouter($url, RC_Config::get('clientapi'));
        if (! $router->hasKey()) {
            echo 'Api Error: ' . $url . ' does not exist.';
            exit(0);
        }
        
        $router->parseKey();
        
        $handle = RC_Loader::load_app_module($router->getClassPath().'.'.$router->getClassName(), $router->getApp());
        if ($handle && is_a($handle, $router->getClassName())) {
            
            $data = $handle->handleRequest($this->request);
            $data = is_array($data) ? ApiBase::serialize($data, 1) : $data;
            return $this->displayContent($data);

        } else {
            
            echo 'Api Error: ' . $url . ' does not exist.';
            exit(0);
            
        }
    }
    

}

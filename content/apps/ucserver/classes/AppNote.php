<?php

namespace Ecjia\App\Ucserver;

use Ecjia\App\Ucserver\Repositories\ApplicationRepository;

class AppNote
{
    
    protected $operations = array();
    
    protected $repository;
    
    
    public function __construct()
    {
        $this->repository = new ApplicationRepository();
        
        $this->operations = array(
            'test'                  => array('', 'action=test'),
            'deleteuser'            => array('', 'action=deleteuser'),
            'renameuser'            => array('', 'action=renameuser'),
//             'deletefriend'          => array('', 'action=deletefriend'),
//             'gettag'                => array('', 'action=gettag', 'tag', 'updatedata'),
//             'getcreditsettings'     => array('', 'action=getcreditsettings'),
//             'getcredit'             => array('', 'action=getcredit'),
//             'updatecreditsettings'  => array('', 'action=updatecreditsettings'),
//             'updateclient'          => array('', 'action=updateclient'),
            'updatepw'              => array('', 'action=updatepw'),
//             'updatebadwords'        => array('', 'action=updatebadwords'),
//             'updatehosts'           => array('', 'action=updatehosts'),
//             'updateapps'            => array('', 'action=updateapps'),
//             'updatecredit'          => array('', 'action=updatecredit'),
        );
    }
    
    
    public function getUrlCode($operation, $getdata, $appid) 
    {
        $app = $this->repository->getAppCacheData($appid);
        $authkey = $app['authkey'];
        $url = trim($app['url'], '/');
        $apifilename = array_get($app, 'apifilename', 'uc.php');
        
        $action = $this->operations[$operation][1];
        $content = sprintf("%s&%stime=%s", $action, ($getdata ? "$getdata&" : ''), SYS_TIME);
        $code = urlencode(Helper::authcode($content, 'ENCODE', $authkey));
        
        if ($app['type'] == 'ECJIA') {
            $url = $url."/sites/uc";
        } else {
            $url = $url."/api";
        }
        
        $requestUrl = $url."/$apifilename?code=$code";
        return $requestUrl;
    }
    
    
    
}

// end
<?php

namespace Ecjia\App\Ucserver\Server;

use Ecjia\App\Ucserver\Repositories\ApplicationRepository;
use RC_Ip;
use Ecjia\App\Ucserver\Helper;

class ApiBase
{
    /**
     * 用户名检测失败
     */
    const UC_USER_CHECK_USERNAME_FAILED = -1;

    /**
     * 用户名被禁用
     */
    const UC_USER_USERNAME_BADWORD = -2;

    /**
     * 用户名已经存在
     */
    const UC_USER_USERNAME_EXISTS = -3;

    /**
     * E-mail格式无效
     */
    const UC_USER_EMAIL_FORMAT_ILLEGAL = -4;

    /**
     * E-mail限制使用
     */
    const UC_USER_EMAIL_ACCESS_ILLEGAL = -5;

    /**
     * E-mail已经存在
     */
    const UC_USER_EMAIL_EXISTS = -6;

    /**
     * Mobile格式无效
     */
    const UC_USER_MOBILE_FORMAT_ILLEGAL = -7;

    /**
     * Mobile限制使用
     */
    const UC_USER_MOBILE_ACCESS_ILLEGAL = -8;

    /**
     * Mobile已经存在
     */
    const UC_USER_MOBILE_EXISTS = -9;


    /**
     * @var \Royalcms\Component\Http\Request
     */
    protected $request;

    protected $api_version;

    protected $api_release;
    
    protected $input = [];
    
    protected $app = [];
    
    protected $authkey;

    protected $time;

    protected $onlineip;
    
    public function __construct()
    {
        $this->request = royalcms('request');
        $this->time = SYS_TIME;
        $this->api_release = $this->request->input('release');
        $this->api_version = $this->request->input('version');
        $this->onlineip = RC_Ip::client_ip();

        $this->initApp();
        
        $this->authkey = array_get($this->app, 'authkey');
    }

    /**
     * 初始化输入参数
     *
     * @param null $getagent
     */
    public function initInput($getagent = null)
    {
        $input = $this->request->input('input');
        if ($input) {
            $input = Helper::authcode($input, 'DECODE', $this->authkey);
            if (empty($input)) {
                exit('Access denied for authcode DECODE failed');
            }

            parse_str($input, $this->input);
            $this->input = Helper::daddslashes($this->input, true);
            $agent = $getagent ? $getagent : $this->input['agent'];

            if (($getagent && $getagent != $this->input['agent']) || 
                (!$getagent && md5($_SERVER['HTTP_USER_AGENT']) != $agent)) {
                    
                exit('Access denied for agent changed');
                
            } elseif($this->time - $this->input('time') > 3600) {
                
                exit('Authorization has expired');
                
            }
        }
        
        if (empty($this->input)) {
            
            exit('Invalid input');
            
        }

    }

    /**
     * 初始化应用
     */
    public function initApp()
    {
        $appid = intval($this->request->input('appid'));
        if (! empty($appid)) {
            $this->app = (new ApplicationRepository())->getAppCacheData($appid);
        }
    }

    /**
     * @param $key
     * @param null $default
     * @return array|mixed|null|string
     */
    public function input($key, $default = null)
    {
        if ($key == 'uid') {
            if (is_array($this->input[$key])) {
                foreach ($this->input[$key] as $value) {
                    if(!preg_match("/^[0-9]+$/", $value)) {
                        return null;
                    }
                }
            } elseif (!preg_match("/^[0-9]+$/", $this->input[$key])) {
                return null;
            }
        }

        $value = array_get($this->input, $key, $default);

        return is_array($value) ? $value : trim($value);
    }
    
    
}

// end
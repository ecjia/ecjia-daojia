<?php

namespace Ecjia\App\Wechat;

use RC_WeChat;
use RC_Loader;
use platform_account;

class WechatUUID {
    
    protected $uuid;
    
    public function __construct($uuid) {
        $this->uuid = trim($uuid);   
        
        RC_Loader::load_app_class('platform_account', 'platform', false);
    }
    
    
    public function getWechatInstance() {
        $platform_account = platform_account::make($this->uuid);
        $platform         = $platform_account->getPlatform();
        $account          = $platform_account->getAccount();
        
        if ($platform == 'wechat') {
            
            $config = array(
                'app_id'     => $account['appid'],
                'app_secret' => $account['appsecret'],
            );
            RC_WeChat::init($config);
            
            return royalcms('wechat');
        }
        
        return null;
    }
    
    /**
     * 获取公众号添加后的wechat_Id
     * @return integer
     */
    public function getWechatID()
    {
        $account = platform_account::make($this->uuid);
        $wechat_id = $account->getAccountID();
        return $wechat_id;
    }
    
    /**
     * 获取公众号添加后台UUID
     * @return string
     */
    public function getUUID()
    {
        return $this->uuid;
    }
    
    
}
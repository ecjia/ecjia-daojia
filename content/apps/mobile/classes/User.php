<?php

namespace Ecjia\App\Mobile;

use Ecjia\App\Mobile\Models\MobileDeviceModel;

class User {
    
    const TYPE_USER      = 'user';
    const TYPE_ADMIN     = 'admin';
    const TYPE_MERCHANT  = 'merchant';
    
    protected $user_id;
    
    protected $user_type;
    
    
    public function __construct($user_type, $user_id)
    {
        $this->user_type = $user_type;
        $this->user_id = $user_id;
    }
    
    
    public function getUserType()
    {
        return $this->user_type;
    }
    
    
    public function getUserId()
    {
        return $this->user_id;
    }
    
    /**
     * 获取所有可用于推送的用户设备
     */
    public function getDevices()
    {        
        $model = MobileDeviceModel::whereNotNull('device_token');

        switch ($this->user_type) {
        
    	    case self::TYPE_USER:
    	       $model->user($this->user_id);
    	       break;
    	       
    	    case self::TYPE_ADMIN:
    	        $model->admin($this->user_id);
    	        break;
    	        
    	    case self::TYPE_MERCHANT:
    	        $model->merchant($this->user_id);
    	        break;
    	       
            default:
        }

        return $model->get();
    }
    
    /**
     * 获取客户端配置选项
     */
    public function getClientOptions($client_code, $name)
    {
        $client = with(new ApplicationFactory)->client($client_code);
        return $client->getOptions($name);
    }
    
    
}
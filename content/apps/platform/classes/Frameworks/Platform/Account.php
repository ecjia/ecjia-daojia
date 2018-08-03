<?php

namespace Ecjia\App\Platform\Frameworks\Platform;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use RC_Upload;
use RC_Uri;
use Ecjia\App\Platform\Frameworks\Exceptions\AccountException;
use Ecjia\App\Platform\Plugin\PlatformAbstract;

class Account extends AbstractRepository
{
    
    protected $uuid;
    
    protected $model = 'Ecjia\App\Platform\Models\PlatformAccountModel';
    
    protected $account;
    
    public function __construct($uuid)
    {
        parent::__construct();
        
        $this->uuid = $uuid;
        
        $this->account = $this->findBy('uuid', $uuid);
        
        if (is_null($this->account)) {
            throw new AccountException('Ecjia Platform uuid not exists.');
        } 
    } 
    
    
    public function getAccountID()
    {
        return $this->account->id;
    }
    
    public function getUUID()
    {
        return $this->account->uuid;
    }
    
    public function getPlatform()
    {
        return $this->account->platform;
    }
    
    public function getPlatformName()
    {
        if ($this->getPlatform() == 'wechat') {
            return '微信';
        } 
        else if ($this->getPlatform() == 'alipay') {
            return '支付宝';
        } 
        else if ($this->getPlatform() == 'weapp') {
            return '小程序';
        }
        else {
            return '未知';
        }
    }
    
    public function getType()
    {
        return $this->account->type;
    }
    
    public function getTypeCode()
    {
        if ($this->getType() === 0) {
            return 'unauthorized';
        }
        elseif ($this->getType() == 1) {
            return 'subscribe';
        }
        elseif ($this->getType() == 2) {
            return 'service';
        }
        elseif ($this->getType() == 3) {
            return 'test';
        }
    }
    
    public function getTypeName()
    {
        if ($this->getType() === 0) {
            return '未认证的公众号';
        }
        elseif ($this->getType() == 1) {
            return '订阅号';
        }
        elseif ($this->getType() == 2) {
            return '服务号';
        }
        elseif ($this->getType() == 3) {
            return '测试账号';
        }
    }
    
    public function getStoreId()
    {
        return intval($this->account->shop_id);
    }
    
    public function getAccountName()
    {
        return $this->account->name;
    }
    
    public function getLogo()
    {
        return RC_Upload::upload_url($this->account->logo);
    }
    
    public function getToken()
    {
        return $this->account->token;
    }
    
    public function getAESKey()
    {
        return $this->account->aeskey;
    }
    
    public function getAppId()
    {
        return $this->account->appid;
    }
    
    public function getAppSecret()
    {
        return $this->account->appsecret;
    }
    
    public function getAddTime()
    {
        return $this->account->add_time;
    }
    
    public function getSort()
    {
        return $this->account->sort;
    }
    
    public function getStatus()
    {
        return $this->account->status;
    }
    
    public function getApiUrl()
    {
        return RC_Uri::home_url().'/sites/platform/?uuid=' . $this->getUUID();
    }
    
    /**
     * 公众平台列表URL，支持平台和商家
     */
    public function getPlatformListUrl()
    {
        if ($this->getStoreId() > 0) {
            return str_replace('sites/platform/index.php', 'sites/merchant/index.php', RC_Uri::url('platform/merchant/init'));
        }
        else {
            return str_replace('sites/platform/index.php', 'index.php', RC_Uri::url('platform/admin/init'));
        }
    }
    
    /**
     * 公众平台信息设置URL，支持平台和商家
     */
    public function getPlatformSettingUrl()
    {
        if ($this->getStoreId() > 0) {
            return str_replace('sites/platform/index.php', 'sites/merchant/index.php', RC_Uri::url('platform/merchant/edit', ['id' => $this->getAccountID()]));
        }
        else {
            return str_replace('sites/platform/index.php', 'index.php', RC_Uri::url('platform/admin/edit', ['id' => $this->getAccountID()]));
        }
    }

    /**
     * 获取公众平台帐户类型，是平台还是商家
     */
    public function getPlatformAccountType()
    {
        if ($this->getStoreId() > 0) {
            return PlatformAbstract::TypeMerchant;
        } else {
            return PlatformAbstract::TypeAdmin;
        }
    }
    
}

// end
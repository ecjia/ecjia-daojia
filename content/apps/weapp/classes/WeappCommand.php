<?php

namespace Ecjia\App\Weapp;

use Ecjia\App\Platform\Models\PlatformCommandModel;
use Ecjia\App\Platform\Plugin\PlatformPlugin;

class WeappCommand
{
    protected $message;
    
    protected $weapp_id;
    
    protected $weapp_uuid;
    
    public function __construct($message, WeappUUID $weapp_uuid)
    {
        $this->weapp_uuid = $weapp_uuid;
        
        $this->message = $message;
        $this->weapp_id = $weapp_uuid->getWeappID();
    }
    
    /**
     * 执行一个命令
     * @param string $cmd
     */
    public function runCommand($cmd) {
        list($cmd, $keyword) = explode(' ', $cmd);

        //查询$cmd命令是哪个插件的
        $model = PlatformCommandModel::where('account_id', $this->weapp_id)->where('cmd_word', $cmd)->first();
        
        if (!empty($model) && $model->ext_code) {
            $extend_handle = with(new PlatformPlugin)->channel($model->ext_code);

            $extend_handle->setAccount($this->weapp_uuid->getAccount());
            $extend_handle->setMessage($this->message);
            $extend_handle->setSubCodeCommand($model->sub_code);
            $extend_handle->setStoreId($this->weapp_uuid->getAccount()->getStoreId());
            $extend_handle->setKeyword($keyword);

            if ($this->weapp_uuid->getAccount()->getStoreId() > 0 && $extend_handle->hasSupportTypeMerchant()) {
                $extend_handle->setStoreType(\Ecjia\App\Platform\Plugin\PlatformAbstract::TypeMerchant);
            }
            else if ($this->weapp_uuid->getAccount()->getStoreId() === 0 && $extend_handle->hasSupportTypeAdmin()) {
                $extend_handle->setStoreType(\Ecjia\App\Platform\Plugin\PlatformAbstract::TypeAdmin);
            }

            return $extend_handle->eventReply();
        } else {
            return null;
        }
    }
    
    /**
     * 查询$cmd命令是否存在
     * @param string $cmd
     * @return boolean
     */
    public function hasCommand($cmd) 
    {
        $model = PlatformCommandModel::where('account_id', $this->weapp_id)->where('cmd_word', $cmd)->first();
        
        if (!empty($model)) {
            return true;
        } else {
            return false;
        }
    }
    
}
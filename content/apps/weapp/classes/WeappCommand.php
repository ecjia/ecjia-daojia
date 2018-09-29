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
        $model = PlatformCommandModel::where('account_id', $this->wechat_id)->where('cmd_word', $cmd)->first();
        
        if (!empty($model) && $model->ext_code) {
            $extend_handle = with(new PlatformPlugin)->channel($model->ext_code);
            
            if ($this->wechat_uuid->getAccount()->getStoreId() > 0 && $extend_handle->hasSupportTypeMerchant()) {
                $extend_handle->setMessage($this->message);
                $extend_handle->setSubCodeCommand($model->sub_code);
                $extend_handle->setStoreId($this->wechat_uuid->getAccount()->getStoreId());
                $extend_handle->setStoreType(\Ecjia\App\Platform\Plugin\PlatformAbstract::TypeMerchant);
                $extend_handle->setKeyword($keyword);
                return $extend_handle->eventReply();
            }
            else if ($this->wechat_uuid->getAccount()->getStoreId() === 0 && $extend_handle->hasSupportTypeAdmin()) {
                $extend_handle->setMessage($this->message);
                $extend_handle->setSubCodeCommand($model->sub_code);
                $extend_handle->setStoreId($this->wechat_uuid->getAccount()->getStoreId());
                $extend_handle->setStoreType(\Ecjia\App\Platform\Plugin\PlatformAbstract::TypeAdmin);
                $extend_handle->setKeyword($keyword);
                return $extend_handle->eventReply();
            }
            else {
                return null;
            }
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
        $model = PlatformCommandModel::where('account_id', $this->wechat_id)->where('cmd_word', $cmd)->first();
        
        if (!empty($model)) {
            return true;
        } else {
            return false;
        }
    }
    
}
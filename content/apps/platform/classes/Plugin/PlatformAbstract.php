<?php

namespace Ecjia\App\Platform\Plugin;

use Ecjia\System\Plugin\AbstractPlugin;
use Royalcms\Component\Support\Traits\Macroable;

abstract class PlatformAbstract extends AbstractPlugin
{
    use Macroable;
    
    protected $message;
    
    protected $sub_code;
    
    protected $store_id;

    protected $keywrod;
    
    /**
     * 商家类型
     * @var self::TypeAdmin | self::TypeMerchant 
     */
    protected $store_type;

    /**
     * 公众平台类型
     */
    protected $platform_type_code;
    
    const TypeAdmin = 0b01;
    
    const TypeMerchant = 0b11;
    
    /**
     * 获取iconUrl
     */
    abstract public function getPluginIconUrl();
    
    /**
     * 插件返回数据统一接口
     */
    abstract public function eventReply();
    
    
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    
    public function setSubCodeCommand($sub_code)
    {
        $this->sub_code = $sub_code;
        return $this;
    }
    
    public function getSubCodeCommand()
    {
        return $this->sub_code;
    }
    
    /**
     * 获取子命令数组
     */
    public function getSubCode()
    {
        return $this->loadConfig('sub_code', false);
    }
    
    /**
     * 获取默认插件使用命令
     * @return array | null
     */
    public function getDefaultCommands()
    {
        return $this->loadConfig('commands', null);
    }
    
    public function setStoreId($store_id)
    {
        $this->store_id = $store_id;
        return $this;
    }
    
    public function getStoreId()
    {
        return $this->store_id;
    }
    
    public function setStoreType($store_type)
    {
        $this->store_type = $store_type;
        return $this;
    }
    
    public function getStoreType()
    {
        return $this->store_type;
    }


    public function setKeyword($keyword)
    {
        $this->keywrod = $keyword;
        return $this;
    }

    public function getKeyword()
    {
        return $this->keywrod;
    }


    public function setPlatformTypeCode($platform_type)
    {
        $this->platform_type_code = $platform_type;
        return $this;
    }

    public function getPlatformTypeCode()
    {
        return $this->platform_type_code;
    }

    /**
     * 获取插件是否支持该公众号
     * @return bool
     */
    public function hasSupport($store_type)
    {
        if ($store_type == self::TypeAdmin) {
            $supported = $this->hasSupportTypeAdmin();
        }
        else if ($store_type == self::TypeMerchant) {
            $supported = $this->hasSupportTypeMerchant();
        }

        $types = $this->loadConfig('support_platform_type', ['service']);
        if ($supported && in_array($this->getPlatformTypeCode(), $types)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 获取公众平台插件支持平台公众号
     * @return bool
     */
    public function hasSupportTypeAdmin()
    {
        $type = $this->loadConfig('support_type', self::TypeAdmin);
        
        return ($type & self::TypeAdmin) == self::TypeAdmin;
    }
    
    /**
     * 获取公众平台插件支持商家公众号
     * @return bool
     */
    public function hasSupportTypeMerchant()
    {
        $type = $this->loadConfig('support_type', self::TypeAdmin);
        
        return ($type & self::TypeMerchant) == self::TypeMerchant;
    }

    /**
     * 转发命令，这里直接使用插件代号
     *
     * @param $ext_code 插件代号
     * @param null $sub_code    插件子命令
     * @return null
     */
    public function forwardCommand($ext_code, $sub_code = null)
    {
        $extend_handle = with(new PlatformPlugin)->channel($ext_code);

        if (is_ecjia_error($extend_handle))
        {
            return null;
        }

        $extend_handle->setMessage($this->getMessage());
        $extend_handle->setSubCodeCommand($sub_code);
        $extend_handle->setStoreId($this->getStoreId());
        $extend_handle->setStoreType($this->getStoreType());
        $extend_handle->setKeyword($this->getKeyword());
        return $extend_handle->eventReply();
    }


    public function getOpenId()
    {
        $openid = $this->getMessage()->get('FromUserName');
        return $openid;
    }

}
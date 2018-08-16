<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
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

    /**
     * 设置子命令参数
     * @param $subCommand
     */
    public function subCommand($subCommand)
    {
        $subCommand->setMessage($this->getMessage());
        $subCommand->setSubCodeCommand($this->getSubCodeCommand());
        $subCommand->setStoreId($this->getStoreId());
        $subCommand->setStoreType($this->getStoreType());

        return $subCommand;
    }


    public function getOpenId()
    {
        $openid = $this->getMessage()->get('FromUserName');
        return $openid;
    }

}
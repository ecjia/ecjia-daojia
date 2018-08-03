<?php

namespace Ecjia\App\Platform\Plugin;

use Ecjia\System\Plugin\PluginModel;
use ecjia_error;
use ecjia_config;
use RC_DB;
use Ecjia\App\Platform\Frameworks\EcjiaPlatform;
use Ecjia\App\Platform\Frameworks\Platform\Account;

class PlatformPlugin extends PluginModel
{
    
    protected $table = 'platform_extend';
    
    /**
     * 当前插件种类的唯一标识字段名
     */
    public function codeFieldName()
    {
        return 'ext_code';
    }
    
    /**
     * 激活的支付插件列表
     */
    public function getInstalledPlugins()
    {
        return ecjia_config::getAddonConfig('platform_plugins', true);
    }
    
    
    /**
     * 获取数据库中启用的插件列表
     */
    public function getEnableList()
    {
        $data = $this->enabled()->orderBy('ext_code', 'asc')->get()->toArray();
        return $data;
    }
    
    /**
     * 获取数据库中插件数据
     */
    public function getPluginDataById($id)
    {
        return $this->where('ext_id', $id)->where('enabled', 1)->first();
    }
    
    public function getPluginDataByCode($code)
    {
        return $this->where('ext_code', $code)->where('enabled', 1)->first();
    }
    
    public function getPluginDataByName($name)
    {
        return $this->where('ext_name', $name)->where('enabled', 1)->first();
    }
    
    /**
     * 获取数据中的Config配置数据，并处理
     */
    public function configData($code)
    {
        $pluginData = $this->getPluginDataByCode($code);

        return $this->getAccountPluginConfig($code, $pluginData['ext_name']);
    }

    /**
     * 获取公众平台指定帐号的插件配置
     * @param $code
     */
    protected function getAccountPluginConfig($code, $name, $acount_id = null)
    {
        if (is_null($acount_id)) {
            if (method_exists(EcjiaPlatform::$controller, 'getPlatformAccount')) {
                $acount_id = EcjiaPlatform::$controller->getPlatformAccount()->getAccountID();
            } else {
                $uuid = royalcms('request')->input('uuid');
                $acount_id = with(new Account($uuid))->getAccountId();
            }
        }

        $ext_config = RC_DB::table('platform_config')->where('account_id', $acount_id)->where('ext_code', $code)->pluck('ext_config');

        $config = $this->unserializeConfig($ext_config);

        $config['ext_code'] = $code;
        $config['ext_name'] = $name;

        return $config;
    }
    
    
    /**
     * 限制查询只包括启动的支付渠道。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', 1);
    }
    
    /**
     * 获取默认插件实例
     */
    public function defaultChannel()
    {
        $data = $this->enabled()->orderBy('ext_code', 'asc')->first();

        $config = $this->getAccountPluginConfig($data->ext_code, $data->ext_name);
        
        $handler = $this->pluginInstance($data->ext_code, $config);
        
        if (!$handler) {
            return new ecjia_error('code_not_found', $data->ext_code . ' plugin not found!');
        }
        
        return $handler;
    }
    
    
    /**
     * 获取某个插件的实例对象
     * @param string|integer $code 类型为string时是pay_code，类型是integer时是pay_id
     * @return \Ecjia\System\Plugin\AbstractPlugin | ecjia_error
     */
    public function channel($code = null)
    {
        if (is_null($code)) {
            return $this->defaultChannel();
        }
        
        if (is_int($code)) {
            $data = $this->getPluginDataById($code);
        } else {
            $data = $this->getPluginDataByCode($code);
        }
        
        if (empty($data)) {
            return new ecjia_error('extend_not_found', $code . ' extend not found!');
        }

        $config = $this->getAccountPluginConfig($data->ext_code, $data->ext_name);

        $handler = $this->pluginInstance($data->ext_code, $config);
        if (!$handler) {
            return new ecjia_error('extend_not_found', $data->ext_code . ' plugin not found!');
        }
        
        return $handler;
    }
    
    
}


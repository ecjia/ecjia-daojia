<?php

namespace Ecjia\App\User\Integrate;

use ecjia;
use ecjia_config;
use ecjia_error;

class IntegratePlugin
{
    
    /**
     * 激活的支付插件列表
     */
    public function getInstalledPlugins()
    {
        return ecjia_config::getAddonConfig('user_integrate_plugins', true);
    }
    
    
    /**
     * 获取数据库中启用的插件列表
     */
    public function getEnableList()
    {
        $plugins = $this->getInstalledPlugins();
        
        $list = array();
		foreach ($plugins as $code => $plugin) {
		    if (isset($plugins[$plugin])) {
		        $list[$code] = $plugins[$plugin];
		        
		        $list[$code]['code'] = $code;
		        $list[$code]['format_name'] = $list[$code]['Name'];
		        $list[$code]['format_description'] = $list[$code]['Description'];
		    }
		}

		return $list;
    }
    
    
    /**
     * 获取数据中的Config配置数据，并处理
     */
    public function configData($code)
    {
        $config = unserialize(ecjia::config('integrate_config'));
    
//         $config['pay_code'] = $code;
//         $config['pay_name'] = $pluginData['pay_name'];
    
        return $config;
    }
    
    /**
     * 保存插件的配置数据
     * @param string $code
     * @param array $config
     */
    public function saveConfigData($code, $config)
    {
        $cur_domain = $this->currentDomain();
        $int_domain = $this->getDomainByUrl($config['integrate_url']);
        
        $domain = '';
        
        if ($this->judgeDomainSame($cur_domain, $int_domain, $domain)) {
            $config['cookie_domain']   = $domain;
            $config['cookie_path']     = '/';
        } else {
            /* 不在同一域，设置提示信息 */
            $config['cookie_domain']   = '';
            $config['cookie_path']     = '/';
        }
        
        ecjia_config::write('integrate_code', $code);
        ecjia_config::write('integrate_config', serialize($config));
    }
    
    
    protected function judgeDomainSame($domain1, $domain2, & $domain)
    {
        $same_domain    = true;
        
        if ($domain1 != $domain2) {
            
            
            /* 域名不一样，检查是否在同一域下 */
            $cur_domain_arr = explode(".", $domain1);
            $int_domain_arr = explode(".", $domain2);
            
            if (count($cur_domain_arr) != count($int_domain_arr) || 
                $cur_domain_arr[0] == '' || 
                $int_domain_arr[0] == '') {
                /* 域名结构不相同 */
                $same_domain = false;
            } else {
                /* 域名结构一致，检查除第一节以外的其他部分是否相同 */
                $count = count($cur_domain_arr);
                
                for ($i = 1; $i < $count; $i++) {
                    if ($cur_domain_arr[$i] != $int_domain_arr[$i]) {
                        $domain         = '';
                        $same_domain    = false;
                        break;
                    } else {
                        $domain .= ".$cur_domain_arr[$i]";
                    }
                }
            }
        }
        
        return $same_domain;
    }
    
    /**
     * 从一个url地址中获取域名
     * @param unknown $url
     */
    protected function getDomainByUrl($url)
    {
        $domain = str_replace(array('http://', 'https://'), array('', ''), $url);
        if (strrpos($domain, '/')) 
        {
            $domain = substr($domain, 0, strrpos($domain, '/'));
        }
        
        return $domain;
    }
    
    /**
     * 当前的域名
     */
    protected function currentDomain()
    {
        $currentdomain = '';
        
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) 
        {
            $currentdomain = $_SERVER['HTTP_X_FORWARDED_HOST'];
        } 
        elseif (isset($_SERVER['HTTP_HOST'])) 
        {
            $currentdomain = $_SERVER['HTTP_HOST'];
        } 
        else 
        {
            if (isset($_SERVER['SERVER_NAME'])) 
            {
                $currentdomain = $_SERVER['SERVER_NAME'];
            } 
            elseif (isset($_SERVER['SERVER_ADDR'])) 
            {
                $currentdomain = $_SERVER['SERVER_ADDR'];
            }
        }
        
        return $currentdomain;
    }

    /**
     * 获取某个插件的实例对象
     * @param string|integer $code 类型为string时是pay_code，类型是integer时是pay_id
     * @return Ambigous <\ecjia_error, \Ecjia\System\Plugin\AbstractPlugin>|\ecjia_error|\Ecjia\System\Plugin\AbstractPlugin
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
            return new ecjia_error('payment_not_found', $code . ' payment not found!');
        }
    
        $config = $this->unserializeConfig($data->pay_config);
         
        $handler = $this->pluginInstance($data->pay_code, $config);
        if (!$handler) {
            return new ecjia_error('plugin_not_found', $data->pay_code . ' plugin not found!');
        }
    
        $handler->setPayment($data);
    
        return $handler;
    }
    
    
    public function defaultChannel()
    {
        $config = unserialize(ecjia::config('integrate_config'));
        
        
    }
    

}


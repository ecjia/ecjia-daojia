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
namespace Ecjia\App\User\Integrate;

use Ecjia\System\Plugin\PluginModel;
use ecjia;
use Ecjia\App\User\Integrate\Plugins\IntegrateEcjia;
use ecjia_config;
use ecjia_error;

class IntegratePlugin extends PluginModel
{

    public function codeFieldName()
    {
        return null;
    }
    
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
        $plugins = array_keys($plugins);
        $plugins = array_prepend($plugins, 'ecjia');
        $list = array();
		foreach ($plugins as $code) {
            $plugin = $this->channel($code);
            if (is_ecjia_error($plugin)) {
                continue;
            }

            $metadata = $plugin->getPluginMateData();

		    if ($metadata) {
		        $list[$code] = $metadata->toArray();
		        $list[$code]['format_name'] = $list[$code]['integrate_name'];
		        $list[$code]['format_description'] = $list[$code]['integrate_desc'];
		    }
		}

		return $list;
    }

    public function getPluginDataById($id)
    {
        return null;
    }

    public function getPluginDataByCode($code)
    {
        if ($code == 'ecjia') {
            return with(new IntegrateEcjia())->getPluginMateData();
        }

        return $this->channel($code)->getPluginMateData();
    }

    public function getPluginDataByName($name)
    {
        return null;
    }
    
    /**
     * 获取数据中的Config配置数据，并处理
     */
    public function configData($code)
    {
        $config = unserialize(ecjia::config('integrate_config'));
    
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

        return true;
    }

    /**
     * @param $domain1
     * @param $domain2
     * @param $domain
     * @return bool
     */
    protected function judgeDomainSame($domain1, $domain2, & $domain)
    {
        $same_domain = true;
        
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
     * @param string $url
     */
    protected function getDomainByUrl($url)
    {
        $domain = str_replace(array('http://', 'https://'), array('', ''), $url);
        if (strrpos($domain, '/')) {
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
        
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $currentdomain = $_SERVER['HTTP_X_FORWARDED_HOST'];
        } elseif (isset($_SERVER['HTTP_HOST'])) {
            $currentdomain = $_SERVER['HTTP_HOST'];
        } else {
            if (isset($_SERVER['SERVER_NAME'])) {
                $currentdomain = $_SERVER['SERVER_NAME'];
            } elseif (isset($_SERVER['SERVER_ADDR'])){
                $currentdomain = $_SERVER['SERVER_ADDR'];
            }
        }
        
        return $currentdomain;
    }

    /**
     * 获取某个插件的实例对象
     * @param string|integer $code 类型为string时是pay_code，类型是integer时是pay_id
     * @return \ecjia_error|\Ecjia\System\Plugin\AbstractPlugin
     */
    public function channel($code = null)
    {
        if (is_null($code)) {
            return $this->defaultChannel();
        }

        if ($code == 'ecjia') {

            $handler = new IntegrateEcjia();

        } else {

            $config = $this->configData($code);
            if (empty($config)) {
                $config = [];
            }
            $handler = $this->pluginInstance($code, $config);
            if (!$handler) {
                return new ecjia_error('plugin_not_found', $code . ' plugin not found!');
            }

        }

        return $handler;
    }
    
    
    public function defaultChannel()
    {
        $code = ecjia::config('integrate_code');

        if ($code == 'ecshop') {
            $code = 'ecjia';
        }

        return $this->channel($code);
    }
    

}


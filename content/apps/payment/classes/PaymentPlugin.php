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

namespace Ecjia\App\Payment;

use Ecjia\System\Plugin\PluginModel;
use ecjia_config;
use ecjia_error;

class PaymentPlugin extends PluginModel
{
    protected $table = 'payment';
    
    /**
     * 当前插件种类的唯一标识字段名
     */
    public function codeFieldName()
    {
        return 'pay_code';
    }
    
    /**
     * 激活的支付插件列表
     */
    public function getInstalledPlugins()
    {
        return ecjia_config::getAddonConfig('payment_plugins', true, true);
    }
    
    /**
     * 获取数据库中启用的插件列表
     */
    public function getEnableList()
    {
        $data = $this->enabled()->orderBy('pay_code', 'asc')->get()->toArray();
        return $data;
    }
    
    /**
     * 获取数据库中插件数据
     */
    public function getPluginDataById($id)
    {
        return $this->where('pay_id', $id)->where('enabled', 1)->first();
    }
    
    public function getPluginDataByCode($code)
    {
        return $this->where('pay_code', $code)->where('enabled', 1)->first();
    }
    
    public function getPluginDataByName($name)
    {
        return $this->where('pay_name', $name)->where('enabled', 1)->first();
    }
    
    /**
     * 获取数据中的Config配置数据，并处理
     */
    public function configData($code)
    {
        $pluginData = $this->getPluginDataByCode($code);
    
        $config = $this->unserializeConfig($pluginData['pay_config']);
    
        $config['pay_code'] = $code;
        $config['pay_name'] = $pluginData['pay_name'];
    
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
     * 限制查询只包括在线的支付渠道。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeOnlie($query)
    {
        return $query->where('is_online', 1);
    }
    
    /**
     * 限制查询只包括在线的支付渠道。
     *
     * @return \Royalcms\Component\Database\Eloquent\Builder
     */
    public function scopeNotSupportCod($query)
    {
        return $query->where('is_cod', 0);
    }
    
    /**
     * 取得已安装的支付方式(其中不包括线下支付的)
     * @param   array   $available_plugins  可使用的插件，一维数组 ['pay_alipay', 'pay_balance']
     * @param   bool    $include_balance    是否包含余额支付（冲值时不应包括）
     * @return  array   已安装的配送方式列表
     */
    public function getOnlinePayments(array $available_plugins = array(), $include_balance = true)
    {
        $model = $this->online();
        if (!$include_balance) {
            $model->where('pay_code', '<>', 'pay_balance');
        }
        
        $data = $model->select('pay_id', 'pay_code', 'pay_name', 'pay_fee')->get();
        
        $pay_list = array();
        	
        if (!empty($data)) {
            
            $pay_list = $data->mapWithKeys(function ($item) use ($available_plugins) {
                if (empty($available_plugins)) {
                    $available_plugins = array_keys($this->getInstalledPlugins());
                }
                
                if (in_array($item['pay_code'], $available_plugins)) {
                    $item['format_pay_fee'] = strpos($item['pay_fee'], '%') !== false ? $item['pay_fee'] : price_format($item['pay_fee'], false);
                    return array($item);
                } else {
                    return array();
                }
            });
        }
        
        return $pay_list;
    }
    
    /**
     * 取得可用的支付方式列表
     * @param   bool    $support_cod        配送方式是否支持货到付款
     * @param   int     $cod_fee            货到付款手续费（当配送方式支持货到付款时才传此参数）
     * @param   int     $is_online          是否支持在线支付
     * @return  array   配送方式数组
     */
    public function getAvailablePayments(array $available_plugins = array(), $support_cod = true, $cod_fee = 0, $is_online = false)
    {
        $model = $this->enabled();
        
        if (! $support_cod) 
        {
            $model->notSupportCod();
        }
        
        if ($is_online)
        {
            $model->online();
        }

        $data = $model->select('pay_id', 'pay_code', 'pay_name', 'pay_fee', 'is_cod', 'is_online')
             ->orderby('pay_order', 'asc')->get();

        $pay_list = array();
         
        if (!empty($data)) {
        
            $pay_list = $data->mapWithKeys(function ($item) use ($available_plugins, $cod_fee) {
                if (empty($available_plugins)) {
                    $available_plugins = array_keys($this->getInstalledPlugins());
                }
 
                if (in_array($item['pay_code'], $available_plugins)) {
                    if ($item['is_cod'] == 1) {
                        $item['pay_fee'] = $cod_fee;
                    }
                    
                    $item['pay_name'] = $this->channel($item['pay_code'])->getDisplayName();
                    $item['format_pay_fee'] = strpos($item['pay_fee'], '%') !== false ? $item['pay_fee'] : price_format($item['pay_fee'], false);
                    return array($item);
                } else {
                    return array();
                }
            });
        }

        return $pay_list;
    }
    
    /**
     * 获取默认插件实例
     */
    public function defaultChannel()
    {
        $data = $this->enabled()->orderBy('pay_order', 'asc')->first();
        
        $config = $this->unserializeConfig($data->pay_config);
     
        $handler = $this->pluginInstance($data->pay_code, $config);
        
        if (!$handler) {
            return new ecjia_error('code_not_found', $data->pay_code . ' plugin not found!');
        }
        
        return $handler;
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
        }
        else {
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
    
}

// end
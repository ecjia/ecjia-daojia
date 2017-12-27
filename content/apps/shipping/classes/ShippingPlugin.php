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
namespace Ecjia\App\Shipping;

use Ecjia\System\Plugin\PluginModel;
use ecjia_error;
use ecjia_region;
use ecjia_config;
use Ecjia\App\Shipping\Plugins\ShipNoExpress;
use Ecjia\App\Shipping\Models\ShippingAreaModel;

/**
 * 配送方法
 * @author royalwang
 */
class ShippingPlugin extends PluginModel
{
    use CompatibleTrait;
    
    protected $table = 'shipping';

    /**
     * 当前插件种类的唯一标识字段名
     */
    public function codeFieldName()
    {
        return 'shipping_code';
    }

    /**
     * 激活的支付插件列表
     */
    public function getInstalledPlugins()
    {
        return ecjia_config::getAddonConfig('shipping_plugins', true);
    }

    /**
     * 获取数据库中启用的插件列表
     */
    public function getEnableList()
    {
        $data = $this->enabled()->orderBy('shipping_code', 'asc')->get()->toArray();
        return $data;
    }

    /**
     * 获取数据库中插件数据
     */
    public function getPluginDataById($id)
    {
        $id = intval($id);
        if ($id === 0) {
            return with(new ShipNoExpress)->express();
        }
        return $this->where('shipping_id', $id)->where('enabled', 1)->first();
    }

    public function getPluginDataByCode($code)
    {
        if ($code == 'ship_no_express') {
            return with(new ShipNoExpress)->express();
        }
        return $this->where('shipping_code', $code)->where('enabled', 1)->first();
    }

    public function getPluginDataByName($name)
    {
        if ($name == '无需物流') {
            return with(new ShipNoExpress)->express();
        }
        return $this->where('shipping_name', $name)->where('enabled', 1)->first();
    }

    /**
     * 获取数据中的Config配置数据，并处理
     */
    public function configData($code)
    {
        $pluginData = $this->getPluginDataByCode($code);

        $config['shipping_code'] = $code;
        $config['shipping_name'] = $pluginData['shipping_name'];

        return $config;
    }

    /**
     * 限制查询只包括启动的配送渠道。
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
        $data = $this->enabled()->orderBy('shipping_order', 'asc')->first();

        $handler = $this->pluginInstance($data->shipping_code, []);

        if (!$handler) {
            return new ecjia_error('code_not_found', $data->shipping_code . ' plugin not found!');
        }

        return $handler;
    }

    /**
     * 获取某个插件的实例对象
     * @param string|integer $code 类型为string时是shipping_code，类型是integer时是shipping_id
     * @return \ecjia_error|\Ecjia\System\Plugin\AbstractPlugin
     */
    public function channel($code = null)
    {
        if (is_null($code)) {
            return $this->defaultChannel();
        }
        
        if ($code == 'ship_no_express' || $code === 0) {
            
            $handler = new ShipNoExpress();
            
        } else {
            if (is_int($code)) {
                $data = $this->getPluginDataById($code);
            } else {
                $data = $this->getPluginDataByCode($code);
            }
            
            if (empty($data)) {
                return new ecjia_error('shipping_not_found', $code . ' shipping not found!');
            }
            
            $handler = $this->pluginInstance($data->shipping_code, []);
            
            if (!$handler) {
                return new ecjia_error('plugin_not_found', $data->shipping_code . ' plugin not found!');
            }
        }

        return $handler;
    }
    
    /**
     * 获取指定配送区域插件的实例对象
     * @param string|integer $code 类型为string时是shipping_code，类型是integer时是shipping_id
     * @param integer $areaId 配送区域ID
     * @return \ecjia_error|\Ecjia\System\Plugin\AbstractPlugin
     */
    public function areaChannel($areaId)
    {
        $areaData = ShippingAreaModel::find($areaId);
        if (empty($areaData)) {
            return new ecjia_error('shipping_area_not_found', 'Shipping area by ' . $areaId . ' not found!');
        }
        
        $data = $this->getPluginDataById($areaData->shipping_id);
        if (empty($data)) {
            return new ecjia_error('shipping_not_found', 'Shipping id by ' . $areaData->shipping_id . ' not found!');
        }
        
        if ($data->shipping_code == 'ship_no_express' || $areaData->shipping_id === 0) {
        
            $handler = new ShipNoExpress();
        
        } else {
            
            try {
                $config = $this->unserializeConfig($areaData->configure);
            
                $handler = $this->pluginInstance($data->shipping_code, $config);
                
            } catch (\InvalidArgumentException $e) {
                return new ecjia_error('plugin_not_found', $e->getMessage());
            }
            
            if (!$handler) {
                return new ecjia_error('plugin_not_found', $data->shipping_code . ' plugin not found!');
            }
        }
        
        return $handler;
    }
    
    /**
     * 取得配送方式信息
     * 同原shipping_info
     * @param   int/string     $shippingCode    配送方式id/code
     * @return  boolean   
     */
    public function isEnabled($shippingCode)
    {
        if (is_int($shippingCode)) {
            $model = $this->getPluginDataById($shippingCode);
        } else {
            $model = $this->getPluginDataByCode($shippingCode);
        }
        
        if ($model) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 取得配送方式信息
     * 同原shipping_info
     * @param   int/string     $shippingCode    配送方式id/code
     * @return  array   配送方式信息
     */
    public function pluginData($shippingCode) 
    {
        if (is_int($shippingCode)) {
            $model = $this->getPluginDataById($shippingCode);
        } else {
            $model = $this->getPluginDataByCode($shippingCode);
        }

        if ($model) {
            return $model->toArray();
        } else {
            return [];
        }
    }
    
    /**
     * 计算运费
     * @param   string  $areaId            配送区域的ID
     * @param   float   $goodsWeight       商品重量
     * @param   float   $goodsAmount       商品金额
     * @param   float   $goodsNumber       商品数量
     * @return  float   运费
     */
    public function fee($areaId, $goodsWeight, $goodsAmount, $goodsNumber)
    {
        $handler = $this->areaChannel($areaId);
        if (is_ecjia_error($handler)) return $handler;
        
        $shipping_fee = $handler->calculate($goodsWeight, $goodsAmount, $goodsNumber);
        return $shipping_fee ?: 0;
    }
    
    /**
     * 获取指定配送的保价费用
     *
     * @access  public
     * @param   string      $shipping_code  配送方式的code
     * @param   float       $goods_amount   保价金额
     * @param   mix         $insure         保价比例
     * @return  float
     */
    public function insureFee($shippingCode, $goodsAmount, $insure)
    {
        if (strpos($insure, '%') === false) {
            /* 如果保价费用不是百分比则直接返回该数值 */
            return floatval($insure);
        } else {
            $handler = $this->channel($shippingCode);
            if (is_ecjia_error($handler)) return $handler;
            
            $insure = floatval($insure) / 100;
            return $handler->calculateInsure($goodsAmount, $insure);
        }
    }
    
    
    /**
     * 取得用户可用的配送方式列表
     * @param   array   $region_id     收货人地区最后一级id（包括国家、省、市、区、街道）
     * @param   integer $store_id      商家
     * @return  array   配送方式数组
     */
    public function availableUserShippings($region_id, $store_id)
    {
        if (is_array($region_id)) {
            $region_ids = $region_id;
        } else {
            $region_ids = ecjia_region::getSplitRegion($region_id);
        }
        
        $data = $this->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
                    ->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
                    ->select('shipping.shipping_id', 'shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure', 'shipping_area.shipping_area_id')
                    ->where('shipping.enabled', 1)
                    ->where('shipping_area.store_id', $store_id)
                    ->whereIn('area_region.region_id', $region_ids)
                    ->groupBy('shipping_area.shipping_area_id')
                    ->orderBy('shipping.shipping_order', 'asc')
                    ->get();
        $plugins = $this->getInstalledPlugins();

        return $data->mapWithKeys(function ($item, $key) use ($plugins) {
            if (array_get($plugins, $item['shipping_code']) && $item['shipping_code'] != 'ship_no_express') {
                return [$key => $item];
            } else {
                return [];
            }
        })->toArray();
    }
    
    /**
     * 取得商家可用的配送方式列表
     * @param   array   $region_id     收货人地区最后一级id（包括国家、省、市、区、街道）
     * @param   integer $store_id      商家
     * @return  array   配送方式数组
     */
    public function availableMerchantShippings($region_id, $store_id)
    {
        if (is_array($region_id)) {
            $region_ids = $region_id;
        } else {
            $region_ids = ecjia_region::getSplitRegion($region_id);
        }
        
        $data = $this->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
                    ->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
                    ->select('shipping.shipping_id', 'shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure')
                    ->where('shipping.enabled', 1)
                    ->where('shipping_area.store_id', $store_id)
                    ->whereIn('area_region.region_id', $region_ids)
                    ->orderby('shipping.shipping_order', 'asc')
                    ->get();
        $plugins = $this->getInstalledPlugins();
        
        $ships = $data->mapWithKeys(function ($item, $key) use ($plugins) {
            if (array_get($plugins, $item['shipping_code']) && $item['shipping_code'] != 'ship_no_express') {
                return [$key => $item];
            } else {
                return [];
            }
        });
        
        $ships->push($this->channel('ship_no_express')->express()->toArray());
        
        return $ships->toArray();
    }
    
    /**
     * 取得某配送方式对应于指定收货地址的区域信息
     * @param   int     $shipping_code      配送方式id|code
     * @param   array   $region_id          收货人地区最后一级id（包括国家、省、市、区、街道）
     * @return  array   配送区域信息（config 对应着反序列化的 configure）
     */
    public function shippingArea($shippingCode, $region_id, $store_id)
    {
        if (is_array($region_id)) {
            $region_ids = $region_id;
        } else {
            $region_ids = ecjia_region::getSplitRegion($region_id);
        }
        
        if (is_int($shippingCode)) {
            $model = $this->getPluginDataById($shippingCode);
            if ($model) {
                $shippingCode = $model->getOriginal('shipping_code');
            } else {
                return null;
            }
        }
        
        if ($shippingCode == 'ship_no_express') {
            
            return $this->getPluginDataByCode($shippingCode)->toArray();
            
        } else {
        
            $model = $this->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
                        ->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
                        ->select('shipping.shipping_id', 'shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure', 'shipping_area.shipping_area_id')
                        ->where('shipping.shipping_code', $shippingCode)
                        ->where('shipping.enabled', 1)
                        ->whereIn('area_region.region_id', $region_ids)
                        ->where('shipping_area.store_id', $store_id)
                        ->first();
            
            if ($model) {
                $model->configure = $this->unserializeConfig($model->configure);
                if (isset($model->configure['pay_fee'])) {
                    if (strpos($model->configure['pay_fee'], '%') !== false) {
                        $model['pay_fee'] = floatval($model->configure['pay_fee']) . '%';
                    } else {
                        $model['pay_fee'] = floatval($model->configure['pay_fee']);
                    }
                } else {
                    $model['pay_fee'] = 0.00;
                }

                return $model->toArray();
            }
            
            return $model;
        }
    }

}

// end
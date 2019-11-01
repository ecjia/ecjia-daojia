<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-05
 * Time: 17:03
 */

namespace Ecjia\App\Merchant;

use RC_DB;

class MerchantFunction
{

    public static function get_store_trade_time($store_id = 0) {
    	if (empty($store_id)) {
    		$store_id = $_SESSION['store_id'];
    	}
    	if (empty($store_id)) {
    		return false;
    	}
    
    	$trade_time = self::get_merchant_config($store_id, 'shop_trade_time', '');
    	if (empty($trade_time)) {
    		return __('暂未设置', 'store');
    	}
    	$trade_time = unserialize($trade_time);
    	if (empty($trade_time)) {
    		return __('暂未设置', 'store');
    	}
    	$sart_time = $trade_time['start'];
    	$end_time = explode(':', $trade_time['end']);
    	if ($end_time[0] >= 24) {
    		$end_time[0] = __('次日', 'store'). ($end_time[0] - 24);
    	}
    
    	return $sart_time . '--' . $end_time[0] . ':' . $end_time[1];
    
    }
    
    
    /**
     * 获取店铺配置信息
     * @return  array
     */
    public static function get_merchant_config($store_id = 0, $code = '', $arr = ''){
    	if(empty($code)){
    		if(is_array($arr)){
    			$config = RC_DB::table('merchants_config')->where('store_id', $store_id)->select('code','value')->get();
    			foreach ($config as $key => $value) {
    				$arr[$value['code']] = $value['value'];
    			}
    			return $arr;
    		}else{
    			return ;
    		}
    	}else{
    		$config = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', '=', $code)->value('value');
    		return $config;
    	}
    }
}
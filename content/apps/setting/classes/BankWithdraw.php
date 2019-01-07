<?php

namespace Ecjia\App\Setting;

use RC_DB;
use ecjia_cloud;
use ecjia;
use RC_Cache;

class BankWithdraw
{
    
    /**
     * 获取支持银行，配置为空时返回全部
     */
    public static function supportBanks() {
        $support_banks = unserialize(ecjia::config('withdraw_support_banks'));
        if(empty($support_banks)) {
            return self::allBanks();
        }
        
        return $support_banks;
    }
    
    /**
     * 获取所有银行（云平台）
     */
    public static function allBanks() {
        
        $data = RC_Cache::app_cache_get('allBanks-BankWithdraw', 'setting');
        if(empty($data)) {
            //获取ecjia_cloud对象
            $cloud = ecjia_cloud::instance()->api('product/banks')->run();
            //获取每页可更新数
            $data = $cloud->getReturnData();
            $data = is_ecjia_error($data) ? [] : $data;
            
            RC_Cache::app_cache_set('allBanks-BankWithdraw', $data, 'setting', DAY_IN_SECONDS);
        }
        
        return $data;
    }
    
    /**
     * 获取银行名称 - 根据英文缩写
     * @param string $bankEnShort
     */
    public static function getBankNameByEnShort($bankEnShort) {
        $supportBanks = self::supportBanks();
        
        $supportBanks = collect($supportBanks)->keyBy('bank_en_short')->toArray();
        
        return array_get(array_get($supportBanks, $bankEnShort), 'bank_name');
        
    }
    
    /**
     * 获取银行信息 - 根据英文缩写
     * @param string $bankEnShort
     * return array [bank_name,bank_icon,bank_en_short]
     */
    public static function getBankInfoByEnShort($bankEnShort) {
        $supportBanks = self::supportBanks();
        
        $supportBanks = collect($supportBanks)->keyBy('bank_en_short')->toArray();
        
        return array_get($supportBanks, $bankEnShort);
        
    }
    
    
}

// end
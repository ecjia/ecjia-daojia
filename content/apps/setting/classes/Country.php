<?php

namespace Ecjia\App\Setting;

class Country 
{
    protected $country = [
        'CN' => '中国',
    ];
    
    
    /**
     * 获取所有国家信息
     */
    public function getCountries()
    {
        return $this->country;
    }
 

    /**
     * 获取指定国家名称
     * @param string $country
     */
    public function getCountryName($country)
    {
        return array_get($this->country, $country);
    }
    
    
    
}
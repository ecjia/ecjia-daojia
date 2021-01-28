<?php

namespace Ecjia\Component\Region;

use RC_Hook;

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
        return RC_Hook::apply_filters('ecjia_region_country', $this->country);
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
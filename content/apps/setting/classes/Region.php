<?php

namespace Ecjia\App\Setting;

use RC_DB;

class Region
{
    use CompatibleTrait;
    
    protected $country;
        
    public function __construct($country = 'CN') {
        $this->country = $country;
    }
    
    /**
     * 获取当前国家
     */
    public function defaultCountry() {
        return $this->country;
    }
    
    /**
     * 获取当前国家名称
     */
    public function defaultCountryName() {
        return $this->getCountryName($this->country);
    }
    
    /**
     * 获取国家名称
     */
    public function getCountryName($country) {
        return with(new Country)->getCountryName($country);
    }
    
    
    /**
     * 指定国家
     * @param string $country
     */
    public function country($country) {
        $this->country = $country;
        return $this;
    }
    
    /**
     * 获取所有省份地区
     */
    public function getProvinces() {
    	$country = $this->country;
    	return RC_DB::table('regions')->where('parent_id', $country)->select('region_id', 'region_name')->get();
    }
    
    /**
     * 获取指定城市的下一级地区
     * 
     * @param string $regionId
     */
    public function getSubarea($regionId) {
    	return RC_DB::table('regions')->where('parent_id', $regionId)->select('region_id', 'region_name', 'parent_id', 'region_type')->get();
    }
    
    /**
     * 获取地区信息
     * 
     * @param string $regionId
     */
    public function getRegion($regionId) {
        return RC_DB::table('regions')->where('region_id', $regionId)->select('region_id', 'region_name', 'parent_id', 'region_type')->first();
    }
    
    /**
     * 获取地区名称
     *
     * @param string $regionId
     */
    public function getRegionName($regionId) {
        if (strlen($regionId) === 2) {
            return $this->getCountryName($regionId);
        }
        return array_get($this->getRegion($regionId), 'region_name');
    }
    
    /**
     * 获取多个地区信息
     * 
     * @param array $regionIds
     */
    public function getRegions(array $regionIds) {
        return RC_DB::table('regions')->whereIn('region_id', $regionIds)->select('region_id', 'region_name', 'parent_id', 'region_type')->get();
    }
    
    /**
     * 获取地区信息，只能获取3级（含3级）以下的所有地区
     *
     * @param string $type
     */
    public function getRegionsByType($type) {
        if ($type < 4) {
            $result = RC_DB::table('regions')->where('region_type', $type)->select('region_id', 'region_name', 'parent_id', 'region_type')->get();
        } else {
            $result = [];
        }
    
        return $result;
    }
    
    /**
     * 获取地区信息，根据城市名称搜索匹配的所有地区
     * 
     * @param string $name
     * @param integer $type
     * @return array
     */
    public function getRegionsBySearch($name, $type = null) {
        if (is_null($type)) {
            $result = RC_DB::table('regions')->where('region_name', 'like', '%'.ecjia_mysql_like_quote($name).'%')->get();
        } else {
            $result = RC_DB::table('regions')->where('region_name', 'like', '%'.ecjia_mysql_like_quote($name).'%')->where('region_type', $type)->get();
        }
        return $result;
    }
    
    /**
     * 获取地区信息，并同时获取该地区向上递归的所有父级地区信息
     * 
     * @param string $regionId
     */
    public function getRegionsWithRecursivelyUpwards($regionId) {
        $regions = $this->getSplitRegion($regionId);
        $result = $this->getRegions($regions);
        return $result;
    }
    
    /**
     * 获取指定字符串的5级地区信息数组
     * country 国家
     * province 省
     * city 市
     * district 地区
     * street 街道
     * @param array $regionIds
     */
    public function getSplitRegionWithKey($regionId) {
    	$length = strlen($regionId);
    	$data = array(
    		'country' 	=> null,
    		'province' 	=> null,
    		'city' 		=> null,
    		'district' 	=> null,
    		'street' 	=> null
    	);

    	if ($length >= 11) {
    		$data['street'] = substr($regionId, 0, 11);
    	}
    	
    	if ($length >= 8) {
			$data['district'] = substr($regionId, 0, 8);
		} 
		
		if ($length >= 6) {
			$data['city'] = substr($regionId, 0, 6);
		} 
		
		if ($length >= 4) {
			$data['province'] = substr($regionId, 0, 4);
		}
		
		if ($length >= 2) {
    		$data['country'] = substr($regionId, 0, 2);
    	} 

    	return $data;
    }
    
    /**
     * 获取分割后地区数组
     * @param string $regionId
     * @return array
     */
    public function getSplitRegion($regionId) {
        $regions = $this->getSplitRegionWithKey($regionId);
        
        return collect($regions)->values()->filter(function ($item) {
        	return !is_null($item);
        })->all();
    }
    
}

// end
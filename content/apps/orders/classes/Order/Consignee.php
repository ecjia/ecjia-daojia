<?php

namespace Ecjia\App\Orders\Order;

class Consignee
{
    /**
     * 国家
     * @var unknown
     */
    protected $country;
    
    /**
     * 省份
     * @var unknown
     */
    protected $province;
    
    /**
     * 城市
     * @var unknown
     */
    protected $city;
    
    /**
     * 地区
     * @var unknown
     */
    protected $district;
    
    /**
     * 街道
     * @var unknown
     */
    protected $street;
    
    /**
     * 祥细地址
     * @var unknown
     */
    protected $address;
    
    /**
     * 经度
     * @var unknown
     */
    protected $longitude;
    
    /**
     * 纬度
     * @var unknown
     */
    protected $latitude;
    
    /**
     * 邮编号码
     * @var unknown
     */
    protected $zipcode;
    
    /**
     * 电话号码
     * @var unknown
     */
    protected $telephone;
    
    /**
     * 手机号码
     * @var unknown
     */
    protected $mobile;
    
    /**
     * 邮箱
     * @var unknown
     */
    protected $email;
    
    /**
     * 最佳配送时机
     * @var unknown
     */
    protected $best_time;
    
    /**
     * 标致性建筑物
     * @var unknown
     */
    protected $sign_building;
    
    
    public function getCountry()
    {
        return $this->country;
    }
    
    public function getProvince()
    {
        return $this->province;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function getDistrict()
    {
        return $this->getDistrict();
    }
    
    public function getStreet()
    {
        return $this->street;
    }
    
    public function getAddress()
    {
        return $this->address;
    }
    
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    public function getZipcode()
    {
        return $this->zipcode;
    }
    
    public function getTelephone()
    {
        return $this->telephone;
    }
    
    public function getMobile()
    {
        return $this->mobile;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getBestTime()
    {
        return $this->best_time;
    }
    
    public function getSignBuilding()
    {
        return $this->sign_building;
    }
    
    
}
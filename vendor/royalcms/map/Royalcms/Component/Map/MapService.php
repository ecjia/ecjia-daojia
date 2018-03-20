<?php

namespace Royalcms\Component\Map\Maps;

use Royalcms\Component\Map\Exceptions\MapException;

class MapService
{
    /**
     * 地图别名
     * @var
     */
    public $alias;

    /**
     * 配置信息
     * @var \Royalcms\Component\Config\Repository|mixed
     */
    public $config;

    /**
     * 地理位置编码服务的具体位置
     * @var
     */
    public $address;

    /**
     * 地理位置编码服务的具体城市
     * @var
     */
    public $city;

    /**
     * 地理位置逆编码服务的具体坐标
     * @var
     */
    public $location;

    /**
     * 输出格式 json or xml
     * @var
     */
    public $outPut = 'json';

    /**
     * 输出格式方法，默认为json，不需要调用此方法，如想xml格式，调用此方法即可
     * @param string $outPut
     * @return $this
     */
    public function outPut($outPut = 'xml')
    {
        $this->outPut = $outPut ?: $this->outPut;
        return $this;
    }

    /**
     * 地理编码 功能设置待解析的地址。具体支持的格式见对应地图的文档，基本格式可以为
     * 北京市海淀区上地十街十号 【推荐，地址结构越完整，解析精度越高】
     * @param $address string
     * @return $this
     */
    public function address($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * 地理编码 功能设置地址所在的城市名。
     * 用于指定待解析地址所在的城市，当多个城市都有上述地址时，该参数起到过滤作用，但不限制坐标召回城市。
     * 例如 “北京市”
     * 注：腾讯地图不支持此参数
     * @param $city string
     * @return $this
     */
    public function city($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * 逆地理编码 根据经纬度坐标获取地址。
     * 暂不支持批量
     * 格式 百度和腾讯地图 lat<纬度>,lng<经度> 例如 38.76623,116.43213
     * 高德地图为经度在前纬度在后
     * @param $location float
     * @return $this
     */
    public function location($location)
    {
        $this->location = $location;
        return $this;
    }

    public function __call($function, $args)
    {
        throw new MapException("sorry, $this->alias map is not support function '$function'");
    }
}
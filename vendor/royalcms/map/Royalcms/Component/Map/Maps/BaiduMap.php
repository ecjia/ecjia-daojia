<?php

namespace Royalcms\Component\Map\Maps;

use Royalcms\Component\Map\Contracts\Map;
use Royalcms\Component\Map\Exceptions\MapException;

class BaiduMap extends MapService implements Map
{


    /**
     * BaiduMap constructor.
     */
    public function __construct()
    {
        $this->alias = config('chinamap.maps')['baidu'];
        $this->config = config('chinamap.' . $this->alias);
    }

    /**
     * IP定位Api
     * @param $ip
     * @return mixed
     */
    public function locateIp($ip = '')
    {
        $domain = $this->config['location.ip']['type'] . '://' . $this->config['location.ip']['url'];
        $param = "?ip=$ip" . $this->appendParam();
        $url = $domain . $param;
        return Curl::to($url)
            ->get();
    }

    /**
     * @param $coords
     * @param array ...$param
     * @return mixed
     */
    public function geoConvert($coords)
    {
        $default = [
            'from' => 1,
            'to' => 5
        ];
        $url = $this->config['geoconv.v1'] . "?coords=$coords&from=$from&to=$to&ak=" . $this->config['ak'];
        return Curl::to($url)
            ->get();
    }

    /**
     * 地理位置编码/逆编码
     * 调用此方法前需要设置address变量（编码） 或location变量（逆编码） 否则抛出异常
     * @return mixed
     * @throws ChinamapException
     */
    public function geoCoder()
    {
        $domain = $this->config['geocoder.v2'];
        if (!empty($this->address)) {
            $param = "?address={$this->address}&city={$this->city}";
        } elseif (!empty($this->location)) {
            $param = "?location={$this->location}";
        } else {
            throw new MapException('sorry,geoCoder function need “address” or “location” is not empty');
        }
        $param .= "&output={$this->outPut}" . $this->appendParam();
        $url = $domain . $param;
        return Curl::to($url)
            ->get();
    }

    /**
     * 返回固定的拼接参数
     * @return string
     */
    public function appendParam()
    {
        return "&ak={$this->config['ak']}";
    }

}
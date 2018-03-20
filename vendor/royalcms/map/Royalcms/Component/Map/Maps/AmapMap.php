<?php

namespace Royalcms\Component\Map\Maps;

use Royalcms\Component\Map\Contracts\Map;
use Royalcms\Component\Map\Exceptions\MapException;

class AmapMap extends MapService implements Map
{

    /**
     * Amapmap constructor.
     */
    public function __construct()
    {
        $this->alias = config('map::config.maps')['amap'];
        $this->config = config('chinamap.' . $this->alias);
    }

    /**
     * IP定位API
     * @param $ip
     * @return mixed
     */
    public function locateIp($ip = '')
    {
        $domain = $this->config['location.ip'];
        $param = "?ip={$ip}&output={$this->outPut}" . $this->appendParam();
        $url = $domain . $param;
        return Curl::to($url)
            ->get();
    }

    public function geoConvert($coords)
    {

    }

    /**
     * 地理位置编码/逆编码
     * @return mixed
     * @throws ChinamapException
     */
    public function geoCoder()
    {
        if (!empty($this->address)) {
            $domain = $this->config['geo'];
            $param = "?address={$this->address}&outPut={$this->outPut}";
        } elseif (!empty($this->location)) {
            $domain = $this->config['regeo'];
            $param = "?location={$this->location}&outPut={$this->outPut}";
        } else {
            throw new MapException('sorry,geoCoder function need “address” or “location” is not empty');
        }
        $url = $domain . $param . $this->appendParam();
        return Curl::to($url)
            ->get();
    }

    public function appendParam()
    {
        return "&key={$this->config['key']}";
    }

}
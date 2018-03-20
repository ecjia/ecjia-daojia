<?php

namespace Royalcms\Component\Map\Contracts;

interface Map
{

    /**
     * IP定位
     * @param $ip
     * @return mixed
     */
    public function locateIp($ip);

    /**
     * 坐标转换
     * @param $coords
     * @return mixed
     */
    public function geoConvert($coords);

    /**
     * 地理位置正、逆编码
     * @return mixed
     */
    public function geoCoder();

    /**
     * 追加固定参数
     * @return mixed
     */
    public function appendParam();

}
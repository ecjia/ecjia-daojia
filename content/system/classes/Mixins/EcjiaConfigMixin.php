<?php

namespace Ecjia\System\Mixins;

use Ecjia\Component\Framework\Ecjia;
use ecjia_config;

class EcjiaConfigMixin
{
    /**
     * @return \Closure
     */
    public function config()
    {
        /**
         * 调用站点配置文件
         * @param string $name
         * @param int $what
         * @return array|string
         */
        return function ($name = null, $what = ecjia::CONFIG_READ) {

            if (is_null($name)) {
                return ecjia_config::all();
            }

            if ($what === ecjia::CONFIG_READ) {
                return ecjia_config::get($name);
            } elseif ($what === ecjia::CONFIG_CHECK || $what === ecjia::CONFIG_EXISTS) {
                return ecjia_config::has($name);
            }
        };
    }

}
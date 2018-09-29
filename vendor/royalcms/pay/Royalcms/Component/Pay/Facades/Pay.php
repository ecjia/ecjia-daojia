<?php

namespace Royalcms\Component\LaravelPay\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Pay extends Facade
{
    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'pay.alipay';
    }

    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function alipay()
    {
        return royalcms('pay.alipay');
    }

    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function wechat()
    {
        return royalcms('pay.wechat');
    }
}

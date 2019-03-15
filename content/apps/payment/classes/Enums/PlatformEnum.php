<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 02:52
 */

namespace Ecjia\App\Payment\Enums;


use Royalcms\Component\Enum\Enum;

class PlatformEnum extends Enum
{

    /**
     * PC平台
     * @var number
     */
    const PLATFORM_PC       = 0b00000001;

    /**
     * 手机APP平台
     * @var number
     */
    const PLATFORM_APP      = 0b00000010;

    /**
     * H5平台
     * @var number
     */
    const PLATFORM_H5       = 0b00000100;

    /**
     * 微信小程序平台
     * @var number
     */
    const PLATFORM_WEAPP    = 0b00001000;


    protected function __statusMap()
    {
        return [
            self::PLATFORM_PC       => __('PC平台', 'payment'),
            self::PLATFORM_APP      => __('手机APP平台', 'payment'),
            self::PLATFORM_H5       => __('H5平台', 'payment'),
            self::PLATFORM_WEAPP    => __('微信小程序平台', 'payment'),
        ];
    }

}
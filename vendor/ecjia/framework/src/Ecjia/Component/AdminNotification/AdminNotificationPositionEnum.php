<?php

namespace Ecjia\Component\AdminNotification;

use Royalcms\Component\Enum\Enum;

class AdminNotificationPositionEnum extends Enum
{

    /**
     * 上右
     */
    const POSITION_TOP_RIGHT = 'top-right';

    /**
     * 上左
     */
    const POSITION_TOP_LEFT = 'top-left';

    /**
     * 上中
     */
    const POSITION_TOP_CENTER = 'top-center';

    /**
     * 下右
     */
    const POSITION_BOTTOM_RIGHT = 'bottom-right';

    /**
     * 下左
     */
    const POSITION_BOTTOM_LEFT = 'bottom-left';


    protected function __statusMap()
    {
        return [
            self::POSITION_TOP_RIGHT    => __('上右位置', 'ecjia'),
            self::POSITION_TOP_LEFT     => __('上左位置', 'ecjia'),
            self::POSITION_TOP_CENTER   => __('上中位置', 'ecjia'),
            self::POSITION_BOTTOM_RIGHT => __('下右位置', 'ecjia'),
            self::POSITION_BOTTOM_LEFT  => __('下左位置', 'ecjia'),
        ];
    }

}
<?php

namespace Ecjia\Component\AdminNotification;

use Royalcms\Component\Enum\Enum;

class AdminNotificationTypeEnum extends Enum
{

    /**
     * 错误
     */
    const TYPE_ERROR = 'st-error';

    /**
     * 成功
     */
    const TYPE_SUCCESS = 'st-success';

    /**
     * 信息
     */
    const TYPE_INFO = 'st-info';


    protected function __statusMap()
    {
        return [
            self::TYPE_ERROR   => __('ERROR', 'ecjia'),
            self::TYPE_SUCCESS => __('SUCCESS', 'ecjia'),
            self::TYPE_INFO    => __('INFO', 'ecjia'),
        ];
    }

}
<?php

namespace Royalcms\Component\Enum\Demo;

use Royalcms\Component\Enum\Enum;

/**
 * Custom global request code.
 */
class RequestCode extends Enum
{
    /**
     * Request success.
     *
     * @var int
     */
    const SUCCESS = 0;

    /**
     * Request failure.
     *
     * @var int
     */
    const ERROR = 1;


    protected function __statusMap()
    {
        /**
         * The display value for view.
         */
        return [
            self::SUCCESS => 'request success',
            self::ERROR   => 'request failure',
        ];

    }

}

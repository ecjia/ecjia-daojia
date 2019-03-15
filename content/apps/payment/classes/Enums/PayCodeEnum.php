<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/3/10
 * Time: 02:50
 */

namespace Ecjia\App\Payment\Enums;


use Royalcms\Component\Enum\Enum;

class PayCodeEnum extends Enum
{

    /**
     * 支付代码类型 1 => 表单
     * @var integer
     */
    const PAYCODE_FORM     = 1;

    /**
     * 支付代码类型 2 => 链接
     * @var integer
     */
    const PAYCODE_STRING   = 2;

    /**
     * 支付代码类型 3 => 数组
     * @var integer
     */
    const PAYCODE_PARAM    = 3; //废弃
    const PAYCODE_ARRAY    = 3; //新名


    protected function __statusMap()
    {

        return [
            self::PAYCODE_FORM      => __('表单', 'payment'),
            self::PAYCODE_STRING    => __('链接', 'payment'),
            self::PAYCODE_PARAM     => __('数组', 'payment'),
            self::PAYCODE_ARRAY     => __('数组', 'payment'),
        ];

    }

}
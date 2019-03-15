<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/13
 * Time: 16:29
 */

namespace Ecjia\App\Article\Enums;

use Royalcms\Component\Enum\Enum;

class ArticleTypeEnum extends Enum
{

    /**
     * 网店帮助
     */
    const TYPE_SHOP_HELP = 'shop_help';

    /**
     * 网店信息
     */
    const TYPE_SHOP_INFO = 'shop_info';

    /**
     * 普通文章
     */
    const TYPE_ARTICLE = 'article';

    /**
     * 系统信息
     */
    const TYPE_SYSTEM = 'system';

    /**
     * 商家公告
     */
    const TYPE_MERCHANT_NOTICE = 'merchant_notice';

    /**
     * 平台公告
     */
    const TYPE_SHOP_NOTICE = 'shop_notice';


    protected function __statusMap()
    {
        return [
            self::TYPE_SHOP_HELP        => __('网店帮助', 'article'),
            self::TYPE_SHOP_INFO        => __('网店信息', 'article'),
            self::TYPE_ARTICLE          => __('普通文章', 'article'),
            self::TYPE_SYSTEM           => __('系统信息', 'article'),
            self::TYPE_MERCHANT_NOTICE  => __('商家公告', 'article'),
            self::TYPE_SHOP_NOTICE      => __('平台公告', 'article'),
        ];
    }

}
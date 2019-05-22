<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:24
 */

namespace Ecjia\App\Orders\OrdersSearch\Filters;


use Ecjia\System\Frameworks\SuperSearch\FilterInterface;
use Royalcms\Component\Database\Eloquent\Builder;

class ShippingStatus implements FilterInterface
{

    /**
     * 把过滤条件附加到 builder 的实例上
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        if ($value != -1) {
            return $builder->where('order_info.shipping_status', $value);
        }

        return $builder;
    }

}
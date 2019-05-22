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

class CompositeStatus implements FilterInterface
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
        //综合状态
        switch ($value) {
            case CS_AWAIT_PAY:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('await_pay');
                $whereQuery($builder);
                break;

            case CS_AWAIT_SHIP:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('admin_await_ship');
                $whereQuery($builder);
                break;

            case CS_FINISHED:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('finished');
                $whereQuery($builder);
                break;

            case CS_RECEIVED:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('received');
                $whereQuery($builder);
                break;

            case CS_SHIPPED:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('shipped');
                $whereQuery($builder);
                break;
            //新增类型

            //未接单
            case CS_UNCONFIRMED:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('admin_unconfirmed');
                $whereQuery($builder);
                break;

            //备货中
            case CS_PREPARING:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('preparing');
                $whereQuery($builder);
                break;

            //发货中
            case CS_SHIPPED_ING:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('shipped_ing');
                $whereQuery($builder);
                break;

            //已发货（部分商品）
            case CS_SHIPPED_PART:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('shipped_part');
                $whereQuery($builder);
                break;

            //已取消
            case CS_CANCELED:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('canceled');
                $whereQuery($builder);
                break;

            //无效
            case CS_INVALID:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('invalid');
                $whereQuery($builder);
                break;

            //已申请退货
            case CS_REFUND:
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('refund');
                $whereQuery($builder);
                break;

            default:
                break;
        };

        return $builder;
    }

}
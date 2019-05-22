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

/**
 * 用户端（接口）综合状态条件
 * @author Administrator
 *
 */
class ApiCompositeStatus implements FilterInterface
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
        //用户端（接口）综合状态条件
        switch ($value) {
        	//待付款订单
            case 'await_pay':
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('await_pay');
                $whereQuery($builder);
                break;
			//待发货订单
            case 'await_ship':
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('await_ship');
                $whereQuery($builder);
                break;
			//已发货订单：不论是否付款
            case 'shipped':
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('shipped');
                $whereQuery($builder);
                break;
			//已完成订单
            case 'finished':
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('finished');
                $whereQuery($builder);
                break;

            //未确认订单
            case 'unconfirmed':
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('unconfirmed');
                $whereQuery($builder);
                break;

            //待评论
            case 'allow_comment':
                $whereQuery = \Ecjia\App\Orders\OrderStatus::getQueryOrder('allow_comment');
                $whereQuery($builder);
                break;

            default:
                break;
        };

        return $builder;
    }

}
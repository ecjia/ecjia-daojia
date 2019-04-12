<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-26
 * Time: 18:15
 */

namespace Ecjia\App\Cart\Middleware;

use Closure;
use Ecjia\App\Cart\CreateOrders\OrderParts\OrderBonusPart;

/**
 * Class BeforeBonusMiddleware
 * @package Ecjia\App\Cart\Middleware
 */
class BeforeBonusMiddleware
{

    /**
     * @param \Ecjia\App\Cart\CreateOrders\CreateOrder $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		//检验红包是否可用，不可用红包信息重置为空数组
        if ($request['bonus']) {
        	$bonus = $request['bonus'];
        	if ($request['cart']) {
        		$cart = $request['cart'];
        		$bonus = $bonus->check_bonus($bonus, $cart);
        	}
        	
        }
        
//         $order->addOrderPart(new \Ecjia\App\Cart\CreateOrders\OrderParts\OrderUserPart(3080));

//        if ($request->getOrder()->getBonusPart()) {


//            $cart = $request->getCart()->getGoodsCollection();

//            $bonus = $request->getOrder()->getBonusPart()->check_bonus($cart['user_id']);

//            dd();

//            $request->getOrder()->setBonusPart($bonus);
//            $bonus_part = new OrderBonusPart($cart['user_id']);

//            return new \ecjia_error('xx', 'xx', $request);

//        }



        return $next($request);
    }

}
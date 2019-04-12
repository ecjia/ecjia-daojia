<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-26
 * Time: 18:15
 */

namespace Ecjia\App\Cart\Middleware;

use Closure;
use Ecjia\App\Cart\CreateOrders\OrderParts\OrderAddressPart;

/**
 * Class BeforeBonusMiddleware
 * @package Ecjia\App\Cart\Middleware
 */
class BeforeAddressMiddleware
{

    /**
     * @param \Ecjia\App\Cart\CreateOrders\CreateOrder $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

//         if ($request['address']) {
//            dd($request);
//            dd($request['bonus']);
//         }

//        if ($request['address']) {

		   
//            $cart = $request->getCart()->getGoodsCollection();

//            $bonus = $request->getOrder()->getBonusPart()->check_bonus($cart['user_id']);

//            dd();

//            $request->getOrder()->setBonusPart($bonus);
//            $bonus_part = new OrderBonusPart($cart['user_id']);

//            return new \ecjia_error('xx', 'xx', $request);

//        		$request->getOrder()->getBonusPart();

//        }



        return $next($request);
    }

}
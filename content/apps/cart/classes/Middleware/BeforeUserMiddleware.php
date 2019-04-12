<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 09:45
 */

namespace Ecjia\App\Cart\Middleware;

use Closure;
use Ecjia\App\Cart\CreateOrders\OrderParts\OrderUserPart;

/**
 * Class BeforeUserMiddleware
 * @package Ecjia\App\Cart\Middleware
 */
class BeforeUserMiddleware
{

    /**
     * @param \Ecjia\App\Cart\CreateOrders\CreateOrder $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 运行动作
//        $cart = $request->getCart()->getGoodsCollection();
//        dd($cart);

//        if ($request->getOrder()->getUserPart()) {
//            $user = $request->getOrder()->getUserPart()->getUserInfo();

//            $request->getOrder()->setUserPart($user);
//        }

//        $user = (new OrderUserPart($cart['user_id']))->getUserInfo();



//        $request->setCartData('cart', '123');
        return $next($request);
    }

}
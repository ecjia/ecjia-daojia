<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 11:56
 */

namespace Ecjia\App\Cart\CreateOrders;


use Ecjia\App\Cart\CartFlow\Cart;
use Royalcms\Component\Pipeline\Pipeline;

/**
 * Class CreateOrder
 * @package Ecjia\App\Cart\CreateOrders
 */
class CreateOrder
{

    /**
     * @var GeneralOrder
     */
    protected $order;

    protected $middlewares = [
        'Ecjia\App\Cart\Middleware\BeforeUserMiddleware',
        'Ecjia\App\Cart\Middleware\BeforeAddressMiddleware',
        'Ecjia\App\Cart\Middleware\BeforePaymentMiddleware',
        'Ecjia\App\Cart\Middleware\BeforeShippingMiddleware',
        'Ecjia\App\Cart\Middleware\BeforeBonusMiddleware',
        'Ecjia\App\Cart\Middleware\BeforeIntegralMiddleware',
        'Ecjia\App\Cart\Middleware\BeforeInvoinceMiddleware',
        
//        'Ecjia\App\Cart\Middleware\AfterMiddleware',
    ];

    public function __construct(GeneralOrder $order)
    {
        $this->order = $order;
    }


    public function pipeline()
    {
//        dd($this);
        $create_order = (new Pipeline(royalcms()))
            ->send($this->order)
            ->through($this->middlewares)
            ->then(function ($poster) {
            return $poster;
        });

        if (is_ecjia_error($create_order)) {

            dd($create_order);

        } else {

            dd($this->order);
            return $this->order;

        }

    }

    /**
     * @return \Ecjia\App\Cart\CreateOrders\GeneralOrder
     */
    public function getOrder()
    {
        return $this->order;
    }




}
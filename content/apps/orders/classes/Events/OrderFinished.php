<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/10/30
 * Time: 3:21 PM
 */

namespace Ecjia\App\Orders\Events;

use Ecjia\System\Events\Event;
use Ecjia\App\Orders\Models\OrdersModel;

class OrderFinished extends Event
{

    protected $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OrdersModel $order)
    {
        $this->order = $order;
    }




}
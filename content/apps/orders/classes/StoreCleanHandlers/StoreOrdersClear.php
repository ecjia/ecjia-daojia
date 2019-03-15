<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Orders\StoreCleanHandlers;

use Ecjia\App\Store\StoreCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

class StoreOrdersClear extends StoreCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_orders_clear';

    /**
     * 排序
     * @var int
     */
    protected $sort = 39;

    public function __construct($store_id)
    {
        $this->name = __('店铺订单', 'orders');

        parent::__construct($store_id);
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $text = __('将店铺内所有订单（包含配送、自提、到店、收银台订单、团购、买单订单）、售后、发货单、结算全部删除', 'orders');

        return <<<HTML
<span class="controls-info w800">{$text}</span>
HTML;
    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $count = RC_DB::table('order_info')->where('store_id', $this->store_id)->count();

        return $count;
    }


    /**
     * 执行清除操作
     *
     * @return mixed
     */
    public function handleClean()
    {
        $count = $this->handleCount();
        if (empty($count)) {
            return true;
        }

        $order_list = RC_DB::table('order_info')->where('store_id', $this->store_id)->lists('order_id');

        RC_DB::table('refund_order')->where('store_id', $this->store_id)->delete();

        RC_DB::table('delivery_order')->whereIn('order_id', $order_list)->delete();

        RC_DB::table('order_action')->whereIn('order_id', $order_list)->delete();

        RC_DB::table('order_goods')->whereIn('order_id', $order_list)->delete();

        RC_DB::table('order_status_log')->whereIn('order_id', $order_list)->delete();

        RC_DB::table('pay_log')->whereIn('order_id', $order_list)->delete();

        $result = RC_DB::table('order_info')->where('store_id', $this->store_id)->delete();

        if ($result) {
            $this->handleAdminLog();
        }

        return true;
    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {
        \Ecjia\App\Store\Helper::assign_adminlog_content();

        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'orders'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'orders'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'clean', 'store_order');
    }

    /**
     * 是否允许删除
     *
     * @return mixed
     */
    public function handleCanRemove()
    {
        return !empty($this->handleCount()) ? true : false;
    }


}
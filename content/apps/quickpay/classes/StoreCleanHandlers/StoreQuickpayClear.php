<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Quickpay\StoreCleanHandlers;

use Ecjia\App\Store\StoreCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

class StoreQuickpayClear extends StoreCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_quickpay_clear';

    /**
     * 排序
     * @var int
     */
    protected $sort = 17;

    public function __construct($store_id)
    {
        $this->name = __('买单活动', 'quickpay');

        parent::__construct($store_id);
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));
        $url        = RC_Uri::url('quickpay/admin/init', array('merchant_name' => $store_info['merchants_name']));

        $count     = $this->handleCount();
        $text      = sprintf(__('店铺买单活动总共<span class="ecjiafc-red ecjiaf-fs3">%s</span>个', 'quickpay'), $count);
        $text_info = __('查看全部>>>', 'quickpay');

        return <<<HTML
<span class="controls-info w300">{$text}</span>
<span class="controls-info"><a href="{$url}" target="_blank">{$text_info}</a></span>
HTML;
    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $count = RC_DB::table('quickpay_activity')->where('store_id', $this->store_id)->count();

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

        $order_list = RC_DB::table('quickpay_order')->where('store_id', $this->store_id)->lists('order_id');

        RC_DB::table('quickpay_order')->where('store_id', $this->store_id)->delete();

        RC_DB::table('quickpay_order_action')->whereIn('order_id', $order_list)->delete();

        $result = RC_DB::table('quickpay_activity')->where('store_id', $this->store_id)->delete();

        if ($result) {
            $this->handleAdminLog();
        }

        return $result;
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

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'quickpay'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'quickpay'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'clean', 'store_quickpay_activity');
    }

    /**
     * 是否允许删除
     *
     * @return mixed
     */
    public function handleCanRemove()
    {
        return $this->handleCount() != 0 ? true : false;
    }


}
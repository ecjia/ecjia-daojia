<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Favourable\StoreCleanHandlers;

use Ecjia\App\Store\StoreCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

class StoreFavourableClear extends StoreCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_favourable_clear';

    /**
     * 排序
     * @var int
     */
    protected $sort = 14;

    public function __construct($store_id)
    {
        $this->name = __('优惠活动', 'favourable');

        parent::__construct($store_id);
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));
        $url        = RC_Uri::url('favourable/admin/init', array('merchant_name' => $store_info['merchants_name']));

        $count     = $this->handleCount();
        $text      = sprintf(__('店铺优惠活动总共<span class="ecjiafc-red ecjiaf-fs3">%s</span>个', 'favourable'), $count);
        $text_info = __('查看全部>>>', 'favourable');

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
        $count = RC_DB::table('favourable_activity')->where('store_id', $this->store_id)->count();

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

        $result = RC_DB::table('favourable_activity')->where('store_id', $this->store_id)->delete();

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

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'favourable'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'favourable'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'clean', 'store_favourable_activity');
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
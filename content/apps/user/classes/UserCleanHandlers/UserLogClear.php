<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\User\UserCleanHandlers;

use Ecjia\App\User\UserCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

class UserLogClear extends UserCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'user_log_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '账户日志';

    /**
     * 排序
     * @var int
     */
    protected $sort = 41;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        return <<<HTML

<span class="controls-info">与账号有关的所有日志记录</span>

HTML;

    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        //账户日志
        $order_list    = RC_DB::table('order_info')->where('user_id', $this->user_id)->lists('order_id');
        $order_sn_list = RC_DB::table('order_info')->where('user_id', $this->user_id)->lists('order_sn');

        $order_status_log_count  = 0;
        $pay_log_count           = 0;
        $refund_status_log_count = 0;
        $payment_record_count    = 0;
        $refund_payrecord_count  = 0;

        if (!empty($order_list)) {
            $order_status_log_count = RC_DB::table('order_status_log')->whereIn('order_id', $order_list)->count(); //订单状态日志
            $pay_log_count          = RC_DB::table('pay_log')->whereIn('order_id', $order_list)->count(); //支付日志
        }
        $refund_order_list = RC_DB::table('refund_order')->where('user_id', $this->user_id)->lists('refund_id');
        if (!empty($refund_order_list)) {
            $refund_status_log_count = RC_DB::table('refund_status_log')->whereIn('refund_id', $refund_order_list)->count(); //退款日志
            $refund_payrecord_count  = RC_DB::table('refund_payrecord')->whereIn('refund_id', $refund_order_list)->count(); //退款支付方式日志
        }
        if (!empty($order_sn_list)) {
            $payment_record_count = RC_DB::table('payment_record')->whereIn('order_sn', $order_sn_list)->count(); //支付方式日志
        }

        $log_count = 1;
        if (empty($order_status_log_count) && empty($pay_log_count)
            && empty($refund_status_log_count) && empty($refund_payrecord_count)
            && empty($payment_record_count)) {
            $log_count = 0;
        }

        return $log_count;
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
        
        $order_list    = RC_DB::table('order_info')->where('user_id', $this->user_id)->lists('order_id');
        $order_sn_list = RC_DB::table('order_info')->where('user_id', $this->user_id)->lists('order_sn');

        if (!empty($order_list)) {
            RC_DB::table('order_status_log')->whereIn('order_id', $order_list)->delete(); //订单状态日志
            RC_DB::table('pay_log')->whereIn('order_id', $order_list)->delete(); //支付日志
        }
        $refund_order_list = RC_DB::table('refund_order')->where('user_id', $this->user_id)->lists('refund_id');
        if (!empty($refund_order_list)) {
            RC_DB::table('refund_status_log')->whereIn('refund_id', $refund_order_list)->delete(); //退款日志
            RC_DB::table('refund_payrecord')->whereIn('refund_id', $refund_order_list)->delete(); //退款支付方式日志
        }
        if (!empty($order_sn_list)) {
            RC_DB::table('payment_record')->whereIn('order_sn', $order_sn_list)->delete(); //支付方式日志
        }
        $this->handleAdminLog();

        return true;
    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {
        \Ecjia\App\User\Helper::assign_adminlog_content();

        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $this->user_id));

        $user_name = !empty($user_info) ? sprintf(__('用户名是%s', 'user'), $user_info['user_name']) : sprintf(__('用户ID是%s', 'user'), $this->user_id);

        ecjia_admin::admin_log($user_name, 'clean', 'user_log');
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
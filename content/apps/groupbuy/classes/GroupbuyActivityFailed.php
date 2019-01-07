<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
namespace Ecjia\App\Groupbuy;

use Ecjia\App\Groupbuy\Notifications\GroupbuyActivityFailed as GroupbuyActivityFailedNotifications;

use RC_DB;
use RC_Notification;
use RC_Time;
use RC_Api;
use RC_Lang;
use RC_Model;
use ecjia_error;
use RC_Loader;
use Ecjia\App\Refund\ReturnAutoApply;


/**
 * 团购活动失败
 */
class GroupbuyActivityFailed extends GroupbuyActivitySucceed
{

    protected function cronJob()
    {
        //先获取一个已经结束的团购活动，只能一个一个团购活动处理，不能一次性处理太多，防止失败
        $activity_info = $this->getFirstGroupBuyActivityFailed();

        //未找到有效活动，直接返回不处理
        if (empty($activity_info)) {
            return true;
        }
        $orders_list = $this->getGroupBuyOrders($activity_info['act_id']);

        if (empty($orders_list)) {
            $this->processGroupBuyAcitivityComplete($activity_info['act_id']);

            return new ecjia_error('groupbuy_orderlist_empty', '团购订单为空');
        }

        $group_buy = $this->groupBuyInfo($activity_info['act_id']);

        //遍历执行订单确认任务
        collect($orders_list)->map(function ($order) use ($group_buy) {
            //处理订单成功逻辑
            $this->processSingleOrder($order, $group_buy);
        });

        return true;

    }

    /**
     * 获取第一个团购活动
     * @return int
     */
    protected function getFirstGroupBuyActivityFailed()
    {
        $activity_info = RC_DB::table('goods_activity')->where('store_id', '>', 0)->where('is_finished', GBS_FAIL)->first();
        if (!empty($activity_info)) {
            return $activity_info;
        } else {
            return 0;
        }
    }


    /**
     * 处理付款订单
     * @param $order
     */
    protected function processPayedOrders($order)
    {
        RC_Loader::load_app_func('admin_order', 'orders');

        // 修改订单状态为已取消，付款状态为未付款
        $order['order_status'] = OS_CANCELED;
        $order['to_buyer']     = RC_Lang::get('groupbuy::groupbuy.cancel_order_reason');
        $order['pay_status']   = PS_UNPAYED;
        $order['pay_time']     = 0;

        /* 如果使用余额或有已付款金额，退回帐户余额 */
        $money = $order['surplus'] + $order['money_paid'];

        if ($money > 0) {
            $order['surplus']      = 0;
            $order['money_paid']   = 0;
            $order['order_amount'] = $money;

            //发起退款请求，生成退款订单，打款记录

            $action     = array(
                'user_type' => 'admin',
                'user_id'   => 0,
                'user_name' => '系统操作'
            );
            $auto_apply = new ReturnAutoApply($order['order_id'], $action);

            $auto_apply->autoApplyRefundOrder();
        }

        $data = array(
            'order_status' => '团购活动失败',
            'order_id'     => $order['order_id'],
            'message'      => '团购活动失败， 我们会尽快为你退款',
            'add_time'     => RC_Time::gmtime()
        );

        RC_DB::table('order_status_log')->insert($data);

        /* 更新订单 */
        update_order($order['order_id'], $order);
    }

    /**
     * 发送短信消息通知
     */
    protected function sendSmsMessageNotice($order)
    {
        $store_name = $this->getStoreName($order['store_id']);
        $options    = array(
            'mobile' => $order['mobile'],
            'event'  => 'sms_groupbuy_activity_failed',
            'value'  => array(
                'user_name'  => $order['consignee'],
                'store_name' => $store_name,
                'goods_name' => $order['goods_name']
            )
        );
        $response   = RC_Api::api('sms', 'send_event_sms', $options);
    }

    /**
     * 发送数据库消息通知
     */
    protected function sendDatabaseMessageNotice($order)
    {
        $store_name = $this->getStoreName($order['store_id']);

        //消息通知
        $user_name = RC_DB::table('users')->where('user_id', $order['user_id'])->pluck('user_name');

        $orm_user_db = RC_Model::model('orders/orm_users_model');
        $user_ob     = $orm_user_db->find($order['user_id']);

        $groupbuy_data      = array(
            'title' => '团购活动失败',
            'body'  => '您在' . $store_name . '店铺参加的商品' . $order['goods_name'] . '的团购活动失败， 我们会尽快为你退款。',
            'data'  => array(
                'user_id'    => $order['user_id'],
                'user_name'  => $user_name,
                'store_name' => $store_name,
                'goods_name' => $order['goods_name'],
                'order_id'   => $order['order_id'],
            ),
        );
        $push_groupbuy_data = new GroupbuyActivityFailedNotifications($groupbuy_data);
        RC_Notification::send($user_ob, $push_groupbuy_data);
    }

    protected function processGroupBuyAcitivityComplete($act_id)
    {
        RC_DB::table('goods_activity')
            ->where('store_id', '>', 0)
            ->where('act_id', $act_id)
            ->update(array('is_finished' => GBS_FAIL_COMPLETE));
    }

}
// end
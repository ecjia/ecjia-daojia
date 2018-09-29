<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 消息通知列表
 * @author zrl
 *
 */
class notification_notification_list_api extends Component_Event_Api
{
    /**
     * @param  string $options['type']    通知类型（用户，商家）
     * @param  int $options['notifiable_id'] 通知用户id
     * @param  string $options['status']  消息状态（readed已读，unread未读）
     * @return array
     */
    public function call(&$options)
    {
        if (!is_array($options)) {
            return new ecjia_error('invalid_parameter', '调用api文件,notification_list,参数无效');
        }
        return $this->notifications_list($options);
    }

    /**
     * 消息通知列表
     * @param   array $options    条件参数
     * @return  array   消息通知列表
     */

    private function notifications_list($options)
    {
        $db = RC_DB::table('notifications');

        if (!empty($options['notifiable_id'])) {
            $db->where('notifiable_id', $options['notifiable_id']);
        }

        if ($options['type'] == 'user') {
            $type = array(
                'Ecjia\System\Notifications\OrderShipped',
                'Ecjia\App\Finance\Notifications\UserAccountChange',
                'Ecjia\App\Refund\Notifications\RefundBalanceArrived',
                'Ecjia\App\Groupbuy\Notifications\GroupbuyActivitySucceed',
                'Ecjia\App\Orders\Notifications\OrderPickup',
                'Ecjia\App\Orders\Notifications\OrderPickupSuccess',
            );
        } else {
            $type = array(
                'Ecjia\System\Notifications\ExpressAssign',
                'Ecjia\System\Notifications\ExpressGrab',
                'Ecjia\System\Notifications\ExpressPickup',
                'Ecjia\System\Notifications\ExpressFinished',
                'Ecjia\System\Notifications\NewOrdersRemind',
                'Ecjia\System\Notifications\OrderPay',
                'Ecjia\System\Notifications\OrderPlaced',
            );
        }

        $db->whereIn('type', $type);

        $size = empty($options['size']) ? 15 : intval($options['size']);
        $page = empty($options['page']) ? 1 : intval($options['page']);

        $time = RC_Time::gmtime();

        if (!empty($options['status'])) {
            if ($options['status'] == 'readed') {
                $db->whereRaw("(read_at is not null or read_at !='')");
            } elseif ($options['status'] == 'unread') {
                 $db->whereRaw("(read_at is null or read_at ='')");
            }
        }

        $count = $db->select('id')->count();


        $page_row = new ecjia_page($count, $size, 6, '', $page);

        $list = $db->take($size)->skip($page_row->start_id - 1)->orderBy('created_at', 'dsec')->select('*')->get();

        $pager = array(
            'total' => $page_row->total_records,
            'count' => $page_row->total_records,
            'more' => $page_row->total_pages <= $page ? 0 : 1,
        );

        $notifications_list = array();

        $type_label = array(
            'Ecjia\System\Notifications\ExpressAssign' => 'express_assign',
            'Ecjia\System\Notifications\ExpressGrab' => 'express_grab',
            'Ecjia\System\Notifications\ExpressPickup' => 'express_pickup',
            'Ecjia\System\Notifications\ExpressFinished' => 'express_finished',
            'Ecjia\System\Notifications\NewOrdersRemind' => 'order_new',
            'Ecjia\System\Notifications\OrderPay' => 'order_pay',
            'Ecjia\System\Notifications\OrderPlaced' => 'order_placed',
            'Ecjia\System\Notifications\OrderShipped' => 'order_shipped',
            'Ecjia\App\Finance\Notifications\UserAccountChange' => 'account_change',
            'Ecjia\App\Refund\Notifications\RefundBalanceArrived' => 'refund_arrived',
            'Ecjia\App\Groupbuy\Notifications\GroupbuyActivitySucceed' => 'groupbuy_succeed',
            'Ecjia\App\Orders\Notifications\OrderPickup' => 'order_pickupcode',
            'Ecjia\App\Orders\Notifications\OrderPickupSuccess' => 'order_pickup_succeed',
        );

        if (!empty($list)) {
            foreach ($list as $val) {
                $data = json_decode($val['data'], true);
                $notifications_list[] = array(
                    'id' => $val['id'],
                    'type' => $type_label[$val['type']],
                    'time' => $val['created_at'],
                    'title' => $data['title'],
                    'description' => $data['body'],
                    'read_status' => empty($val['read_at']) ? 'unread' : 'read',
                    'data' => $data['data'],
                );
            }
        }

        return array('list' => $notifications_list, 'page' => $pager);
    }
}

// end

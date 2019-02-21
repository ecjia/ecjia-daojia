<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台管理员查看店铺会员列表
 * @author zrl
 *
 */
class admin_merchant_user_list_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }

        $size = $this->requestData('pagination.count', 15);
        $page = $this->requestData('pagination.page', 1);

        if ($_SESSION['staff_id'] > 0) {
            $store_id = $_SESSION['store_id'];
        }

        if (empty($store_id)) {
            return new ecjia_error('invalid_parameter', __('参数无效', 'user'));
        }

        $filter = array(
            'size'     => !empty($size) ? intval($size) : 15,
            'page'     => !empty($page) ? intval($page) : 1,
            'store_id' => $store_id
        );

        $store_user_list = RC_Api::api('user', 'store_user_list', $filter);
        if (is_ecjia_error($store_user_list)) {
            return $store_user_list;
        }
        $list = [];
        if (!empty($store_user_list['list'])) {
            foreach ($store_user_list['list'] as $result) {
                $list[] = array(
                    'user_id'             => intval($result['user_id']),
                    'user_name'           => trim($result['user_name']),
                    'mobile'              => empty($result['mobile_phone']) ? '' : $result['mobile_phone'],
                    'integral'            => empty($result['pay_points']) ? 0 : intval($result['pay_points']),
                    'user_money'          => $result['user_money'] > 0 ? $result['user_money'] : '0.00',
                    'formated_user_money' => price_format($result['user_money'], false),
                    'user_rank_id'        => intval($result['user_rank']),
                    'user_rank_name'      => $result['user_rank_name'],
                    'formated_add_time'   => RC_Time::local_date(ecjia::config('time_format'), $result['add_time'])
                );
            }
        }
        return array('data' => $list, 'pager' => $store_user_list['page']);
    }
}


// end
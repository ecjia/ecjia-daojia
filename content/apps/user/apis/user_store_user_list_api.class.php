<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取店铺会员列表
 * @author zrl
 *
 */
class user_store_user_list_api extends Component_Event_Api
{

    /**
     * @param  array $options
     * @return array
     */
    public function call(&$options)
    {
        if (!is_array($options)) {
            return new ecjia_error('invalid_parameter', __('调用api文件store_user_list参数无效', 'user'));
        }
        return $this->user_list($options);
    }

    /**
     * 获取店铺会员列表
     */
    private function user_list($options)
    {
        $size = empty($options['size']) ? 15 : intval($options['size']);
        $page = empty($options['page']) ? 1 : intval($options['page']);

        $user_db = RC_DB::table('users as u')->leftJoin('store_users as su', RC_DB::raw('u.user_id'), '=', RC_DB::raw('su.user_id'));
        $user_db->where(RC_DB::raw('su.store_id'), $options['store_id']);
        $count = $user_db->count(RC_DB::raw('distinct su.user_id'));

        $page_row = new ecjia_page($count, $options['size'], 6, '', $options['page']);

        $rows = $user_db
            ->select(RC_DB::raw('su.*, u.email, u.user_name, u.birthday, u.user_money, u.frozen_money, u.pay_points, u.rank_points, u.reg_time, u.user_rank, u.parent_id, u.qq, u.mobile_phone, u.avatar_img'))
            ->take($options['size'])
            ->skip($page_row->start_id - 1)->orderBy(RC_DB::raw('su.add_time'), 'desc')->get();

        $pager = array(
            'total' => $page_row->total_records,
            'count' => $page_row->total_records,
            'more'  => $page_row->total_pages <= $options['page'] ? 0 : 1,
        );

        $list = array();

        if (!empty($rows)) {
            foreach ($rows as $result) {
                /* 取得用户等级 */
                if ($result['user_rank'] == 0) {
                    // 非特殊等级，根据成长值计算用户等级（注意：不包括特殊等级）
                    $row = RC_DB::table('user_rank')->where('special_rank', 0)->where('min_points', '<=', intval($result['rank_points']))->where('max_points', '>', intval($result['rank_points']))->select('rank_id', 'rank_name')->first();
                } else {
                    // 特殊等级
                    $row = RC_DB::table('user_rank')->where('rank_id', $result['user_rank'])->select('rank_id', 'rank_name')->first();
                }
                if (!empty($row)) {
                    $result['user_rank_name'] = empty($row['rank_name']) ? __('非特殊等级', 'user') : $row['rank_name'];
                } else {
                    $result['user_rank_name'] = __('非特殊等级', 'user');
                }


                $list[] = $result;
            }
        }
        return array('list' => $list, 'page' => $pager);
    }
}

// end
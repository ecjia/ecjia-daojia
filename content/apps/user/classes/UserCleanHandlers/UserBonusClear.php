<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\User\UserCleanHandlers;

use Ecjia\App\User\UserCleanAbstract;
use RC_DB;
use RC_Api;
use ecjia_admin;
use RC_Time;

class UserBonusClear extends UserCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'user_bonus_clear';

    /**
     * 排序
     * @var int
     */
    protected $sort = 2;

    public function __construct($user_id)
    {
        $this->name = __('账户红包', 'user');

        parent::__construct($user_id);
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $count = $this->handleCount();

        $text = sprintf(__('账户内可用红包<span class="ecjiafc-red ecjiaf-fs3">%s</span>个', 'user'), $count);

        return <<<HTML

<span class="controls-info">{$text}</span>

HTML;
    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $db = RC_DB::table('bonus_type as bt')
            ->leftJoin('user_bonus as ub', RC_DB::raw('bt.type_id'), '=', RC_DB::raw('ub.bonus_type_id'))
            ->leftJoin('store_franchisee as s', RC_DB::raw('bt.store_id'), '=', RC_DB::raw('s.store_id'));

        $cur_date = RC_Time::gmtime();

        $db->where(RC_DB::raw('ub.user_id'), $this->user_id)
            ->where(RC_DB::raw('bt.use_end_date'), '>=', $cur_date)
            ->where(RC_DB::raw('ub.order_id'), 0)
            ->where(RC_DB::raw('ub.used_time'), 0);

        $user_bonus_count = $db->count(RC_DB::raw('ub.bonus_id'));

        return $user_bonus_count;
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
        
        $result = RC_DB::table('user_bonus')->where('user_id', $this->user_id)->where('used_time', 0)->delete();

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
        \Ecjia\App\User\Helper::assign_adminlog_content();

        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $this->user_id));

        $user_name = !empty($user_info) ? sprintf(__('用户名是%s', 'user'), $user_info['user_name']) : sprintf(__('用户ID是%s', 'user'), $this->user_id);

        ecjia_admin::admin_log($user_name, 'clean', 'user_bonus');
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
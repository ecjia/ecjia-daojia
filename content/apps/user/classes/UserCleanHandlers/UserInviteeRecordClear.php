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

class UserInviteeRecordClear extends UserCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'user_invitee_record_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '会员邀请记录';

    /**
     * 排序
     * @var int
     */
    protected $sort = 91;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        return <<<HTML

<span class="controls-info">会员推荐邀请的所有记录</span>

HTML;

    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $count = RC_DB::table('invitee_record')->where('invite_id', $this->user_id)->count();

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
        
        $result = RC_DB::table('invitee_record')->where('invite_id', $this->user_id)->delete();

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

        ecjia_admin::admin_log($user_name, 'clean', 'user_invitee_record');
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
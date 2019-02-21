<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Wechat\UserCleanHandlers;

use Ecjia\App\User\UserCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

class UserWechatCustomerRecordClear extends UserCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'user_wechat_customer_record_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '微信客服消息记录';

    /**
     * 排序
     * @var int
     */
    protected $sort = 54;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        return <<<HTML

<span class="controls-info">账户微信公众号上给客服发送的所有消息记录</span>

HTML;

    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $wechat_user_info = RC_DB::table('wechat_user')->where('ect_uid', $this->user_id)->first();

        //账户抽奖记录
        $wechat_customer_record_count = 0;
        if (!empty($wechat_user_info)) {
            //账户发送消息记录
            $wechat_customer_record_count = RC_DB::table('wechat_customer_record')->where('openid', $wechat_user_info['openid'])->where('opercode', 2002)->count();

        }

        return $wechat_customer_record_count;
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

        $wechat_user_info = RC_DB::table('wechat_user')->where('ect_uid', $this->user_id)->first();

        $result = false;
        if (!empty($wechat_user_info)) {
            $result = RC_DB::table('wechat_customer_record')->where('openid', $wechat_user_info['openid'])->where('opercode', 2002)->delete();
        }

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

        $user_name = !empty($user_info) ? sprintf(__('用户名是%s', 'wechat'), $user_info['user_name']) : sprintf(__('用户ID是%s', 'wechat'), $this->user_id);

        ecjia_admin::admin_log($user_name, 'clean', 'user_wechat_customer_record');
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
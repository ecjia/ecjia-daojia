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

class UserWechatPrizeClear extends UserCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'user_wechat_prize_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '账户抽奖记录';

    /**
     * 排序
     * @var int
     */
    protected $sort = 53;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        return <<<HTML

<span class="controls-info">账户参与抽奖活动有关的所有记录</span>

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
        $wechat_prize_count = 0;
        if (!empty($wechat_user_info)) {
            $wechat_prize_count = RC_DB::table('wechat_prize')->where('openid', $wechat_user_info['openid'])->count();
        }

        //账户抽奖记录
        $market_activity_log_count = RC_DB::table('market_activity_log')->where('user_id', $this->user_id)->count();

        return $wechat_prize_count + $market_activity_log_count;
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

        //微信抽奖记录
        if (!empty($wechat_user_info)) {
            RC_DB::table('wechat_prize')->where('openid', $wechat_user_info['openid'])->delete();
        }

        //账户抽奖记录
        RC_DB::table('market_activity_log')->where('user_id', $this->user_id)->delete();

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

        $user_name = !empty($user_info) ? '用户名是' . $user_info['user_name'] : '用户ID是' . $this->user_id;

        ecjia_admin::admin_log($user_name, 'clean', 'user_wechat_prize');
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
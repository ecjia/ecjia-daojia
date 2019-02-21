<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Finance\UserCleanHandlers;

use Ecjia\App\User\UserCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

class UserMoneyClear extends UserCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'user_money_clear';

    /**
     * 名称
     * @var string
     */
    protected $name = '账户余额';

    /**
     * 排序
     * @var int
     */
    protected $sort = 11;

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $this->user_id));

        $user_money = $user_info['formated_user_money'];

        $url = RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'user_money', 'user_id' => $this->user_id));

        return <<<HTML

<span class="controls-info w300">账户内可用余额<span class="ecjiafc-red ecjiaf-fs3">{$user_money}</span></span>

<span class="controls-info"><a href="{$url}" target="__blank">查看全部>>></a></span>

HTML;

    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $this->user_id));

        return $user_info['user_money'] != 0 ? 1 : 0;
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

        $result = RC_DB::table('users')->where('user_id', $this->user_id)->update(array('user_money' => 0));

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
        
        $user_name = !empty($user_info) ? sprintf(__('用户名是%s', 'finance'), $user_info['user_name']) : sprintf(__('用户ID是%s', 'finance'), $this->user_id);

        ecjia_admin::admin_log($user_name, 'clean', 'user_money');
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
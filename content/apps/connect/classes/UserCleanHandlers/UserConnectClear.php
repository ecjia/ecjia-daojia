<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Connect\UserCleanHandlers;

use Ecjia\App\User\UserCleanAbstract;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

class UserConnectClear extends UserCleanAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'user_connect_clear';

    /**
     * 排序
     * @var int
     */
    protected $sort = 31;

    public function __construct($user_id)
    {
        parent::__construct($user_id);

        $this->name = __('第三方账号关联', 'connect');
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $count['qq'] = RC_DB::table('connect_user')->where('user_id', $this->user_id)->where('connect_platform', 'qq')->count();
        $count['wx'] = RC_DB::table('connect_user')->where('user_id', $this->user_id)->where('connect_platform', 'wechat')->count();

        $html = __('暂无绑定', 'connect');
        $span = '';
        if (!empty($count['qq']) && !empty($count['wx'])) {
            $span = __('已关联', 'connect');
            $html = __('QQ、微信', 'connect');
        } elseif (!empty($count['qq'])) {
            $span = __('已关联', 'connect');
            $html = __('QQ', 'connect');
        } elseif (!empty($count['wx'])) {
            $span = __('已关联', 'connect');
            $html = __('微信', 'connect');
        }

        return <<<HTML

<span class="controls-info w300">{$span}<span class="ecjiafc-red ecjiaf-fs3">{$html}</span></span>

HTML;

    }

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    public function handleCount()
    {
        $bind_qq_count = RC_DB::table('connect_user')->where('user_id', $this->user_id)->where('connect_platform', 'qq')
            ->where('user_type', 'user')
            ->count();
        $bind_wx_count = RC_DB::table('connect_user')->where('user_id', $this->user_id)->where('connect_platform', 'wechat')
            ->where('user_type', 'user')
            ->count();

        return $bind_qq_count + $bind_wx_count;
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

        RC_DB::table('connect_user')->where('user_id', $this->user_id)->where('connect_code', 'sns_qq')
            ->where('user_type', 'user')
            ->delete();

        RC_DB::table('connect_user')->where('user_id', $this->user_id)->where('connect_code', 'sns_wechat')
            ->where('user_type', 'user')
            ->delete();

        RC_DB::table('connect_user')->where('user_id', $this->user_id)->where('connect_platform', 'qq')
            ->where('user_type', 'user')
            ->delete();

        RC_DB::table('connect_user')->where('user_id', $this->user_id)->where('connect_platform', 'wechat')
            ->where('user_type', 'user')
            ->delete();

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

        $user_name = !empty($user_info) ? __('用户名是', 'connect') . $user_info['user_name'] : __('用户ID是', 'connect') . $this->user_id;

        ecjia_admin::admin_log($user_name, 'clean', 'user_connect');
    }

    /**
     * 是否允许删除
     *
     * @return mixed
     */
    public function handleCanRemove()
    {
        $count = $this->handleCount();

        return !empty($count) ? true : false;
    }

}
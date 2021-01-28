<?php


namespace Ecjia\Component\PasswordLock;


use Illuminate\Support\Carbon;

class PasswordLock
{
    /**
     * 最大允许失败次数
     * @var int
     */
    protected $max_times;

    /**
     * 锁定时间，单位秒
     * @var int
     */
    protected $lock_time;

    /**
     * 失败登录次数
     */
    const META_KEY_FAILED_LOGIN_TIMES = 'failed_login_times';

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;

        $this->max_times = config('login.max_failed_times', 6);
        $this->lock_time = config('login.error_lock_minutes', 5) * 60;
    }

    /**
     * 失败增加一次
     */
    public function failed()
    {
        $data = $this->model->getMeta(self::META_KEY_FAILED_LOGIN_TIMES);

        if (empty($data) || !isset($data['times'])) {
            $data['times'] = 0;
        }

        $this->model->setMeta(self::META_KEY_FAILED_LOGIN_TIMES, [
            'times' => $data['times'] + 1,
            'last_time' => Carbon::now()
        ]);
    }

    /**
     * 清除失败次数
     */
    public function clearTimes()
    {
        $this->model->setMeta(self::META_KEY_FAILED_LOGIN_TIMES, null);
    }

    /**
     * 获取锁定登录状态
     *
     * 返回数组，[锁定状态， 可解锁时间]
     * @return array
     */
    public function getLockLoginStatus()
    {
        $data = $this->model->getMeta(self::META_KEY_FAILED_LOGIN_TIMES);
        if (empty($data)) {
            return [false, 0];
        }

        $times = isset($data['times']) ? $data['times'] : 0;
        $last_time = isset($data['last_time']) ? $data['last_time'] : 0;

        $expired_time = Carbon::now()->diffInSeconds($last_time);

        $unlock_time = $this->lock_time - $expired_time;

        $lock_status = ($times >= $this->max_times) && ($unlock_time > 0);

        /**
         * 锁定时间已过，清除锁定次数
         */
        if ($unlock_time <= 0) {
            $this->clearTimes();;
        }

        /**
         * 返回数组，[锁定状态， 可解锁时间]
         */
        return [$lock_status, $unlock_time];
    }

    /**
     * 获取解锁剩余时间
     */
    public function getUnLockTime()
    {
        [$lock_status, $unlock_time] = $this->getLockLoginStatus();
        return $unlock_time;
    }

    /**
     * 是否登录锁定
     */
    public function isLoginLock()
    {
        [$lock_status, $unlock_time] = $this->getLockLoginStatus();
        return $lock_status;
    }


}
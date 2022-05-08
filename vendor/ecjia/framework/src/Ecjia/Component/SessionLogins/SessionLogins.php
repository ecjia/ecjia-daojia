<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-05
 * Time: 10:07
 */

namespace Ecjia\Component\SessionLogins;


class SessionLogins
{

    protected $session_id;

    protected $user_id;

    protected $user_type;

    public function __construct($session_id, $user_id, $user_type = null)
    {
        $this->session_id = $session_id;
        $this->user_id    = $user_id;

        if (!empty($user_type)) {
            $this->user_type = $user_type;
        }

    }

    /**
     * @param null $from_type
     * @param null $from_value
     */
    public function record($from_type = null, $from_value = null)
    {
        $model = SessionLoginsModel::find($this->session_id);

        if (!empty($model)) {
            $request = royalcms('request');

            $data = [
                'id'                => $this->session_id,
                'user_id'           => $this->user_id,
                'user_type'         => $this->user_type,
                'user_agent'        => $request->header('user_agent'),
                'login_time'        => \RC_Time::gmtime(),
                'login_ip'          => \RC_Ip::client_ip(),
                'login_ip_location' => \RC_Ip::area(\RC_Ip::client_ip()),
                'from_type'         => $from_type,
                'from_value'        => $from_value,
            ];

            $model->update($data);
        }
        else {

            $request = royalcms('request');

            $data = [
                'id'                => $this->session_id,
                'user_id'           => $this->user_id,
                'user_type'         => $this->user_type,
                'user_agent'        => $request->header('user_agent'),
                'login_time'        => \RC_Time::gmtime(),
                'login_ip'          => \RC_Ip::client_ip(),
                'login_ip_location' => \RC_Ip::area(\RC_Ip::client_ip()),
                'from_type'         => $from_type,
                'from_value'        => $from_value,
            ];

            SessionLoginsModel::create($data);

        }


    }


    /**
     * 通过session_id移除数据
     */
    public function removeBySessionId()
    {
        return SessionLoginsModel::where('id', $this->session_id)->delete();
    }

    /**
     * 通过user_id移除数据
     */
    public function removeByUserId()
    {
        return SessionLoginsModel::where('user_id', $this->user_id)->where('user_type', $this->user_type)->delete();
    }

    /**
     * 通过user_id获取数据
     * @return \Royalcms\Component\Support\Collection
     */
    public function getByUserId()
    {
        return SessionLoginsModel::where('user_id', $this->user_id)->where('user_type', $this->user_type)->get();
    }

    /**
     * 获取当前在线用户总数
     * @return int
     */
    public function getUserCount()
    {
        return SessionLoginsModel::where('user_type', $this->user_type)->count();
    }

}
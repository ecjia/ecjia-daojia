<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/11
 * Time: 13:08
 */

namespace Ecjia\App\User;

use Ecjia\App\User\Models\UserModel;
use RC_Ip;
use RC_Time;

class LocalUser
{

    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * 创建本地用户
     *
     * @param $username
     * @param $password
     * @param $email
     * @param $mobile
     */
    public function create($username, $password = null, $email = null, $mobile = null)
    {
        $ip = RC_Ip::client_ip();
        $reg_date = RC_Time::gmtime();

        $data = [
            'user_name'     => $username,
            'password'      => $password,
            'email'         => $email,
            'mobile_phone'  => $mobile,
            'reg_time'      => $reg_date,
            'last_ip'       => $ip,
        ];
        $model = $this->model->create($data);

        return $model;
    }

    /**
     * @param $mobile
     */
    public function createWithMobile($mobile)
    {

        return $this->create($mobile, null, null, $mobile);
    }


    public function getProfileByModel(UserModel $model)
    {
        return [
            'user_id'       => $model->user_id,
            'user_name'     => $model->user_name,
            'email'         => $model->email,
            'sex'           => $model->sex,
            'birthday'      => $model->birthday,
            'reg_time'      => $model->reg_time,
            'password'      => $model->password,
        ];
    }


    /**
     *  获取指定用户的信息
     *
     * @param $username
     * @return array
     */
    public function getProfileByName($username)
    {
        $row = $this->model
            ->select('user_id', 'user_name', 'email', 'sex', 'birthday', 'reg_time', 'password')
            ->where('user_name', $username)
            ->first();

        return $row;
    }

    /**
     *  获取指定用户的信息
     *
     * @param $username
     * @return array
     */
    public function getProfileByMobile($mobile)
    {
        $row = $this->model
            ->select('user_id', 'user_name', 'email', 'sex', 'birthday', 'reg_time', 'password')
            ->where('mobile_phone', $mobile)
            ->first();

        return $row;
    }


    /**
     *  获取指定用户的信息
     *
     * @param $id
     * @return array
     */
    public function getProfileById($id)
    {
        $row = $this->model
            ->select('user_id', 'user_name', 'email', 'sex', 'birthday', 'reg_time', 'password')
            ->where('user_id', $id)
            ->first();

        return $row;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/11
 * Time: 16:08
 */

namespace Ecjia\App\Connect\ConnectUser;

use Ecjia\App\Connect\Models\ConnectUserModel;
use RC_Time;

abstract class ConnectUserAbstract
{

    protected $connect_code;

    protected $open_id;

    protected $user_id;

    protected $user_type;

    /**
     * @var \Ecjia\App\Connect\Models\ConnectUserModel
     */
    protected $model;

    public function __construct($open_id, $user_type = 'user')
    {

        $this->open_id = $open_id;
        $this->user_type = $user_type;

        $this->setModel(new ConnectUserModel);
    }

    /**
     * @param $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @param ConnectUserModel $model
     */
    public function setModel(ConnectUserModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getConnectCode()
    {
        return $this->connect_code;
    }

    /**
     * @return mixed
     */
    public function getOpenId()
    {
        return $this->open_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }


    public function createUser($user_id)
    {
        return $this->model->create([
            'connect_code' => $this->getConnectCode(),
            'open_id' => $this->getOpenId(),
            'user_type' => $this->getUserType(),
            'user_id' => $user_id,
            'create_at' => RC_Time::gmtime(),
        ]);
    }

    public function bindUser($user_id)
    {
        $this->setUserId($user_id);

        $model = $this->model->where('connect_code', $this->getConnectCode())
            ->where('user_type', $this->getUserType())
            ->where('open_id', $this->getOpenId())->first();

        if ($model) {
            $model->user_id = $this->getUserId();
            $model->user_type = $this->getUserType();
            $model->save();
        }

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/11
 * Time: 16:16
 */

use Ecjia\App\Connect\ConnectUser\ConnectUserAbstract;

class ecjiauc_connect_user extends ConnectUserAbstract
{

    protected $connect_code = 'ecjiauc';

    /**
     * 获取Connect User用户
     */
    public function getUserId()
    {
        $model = $this->model->where('connect_code', $this->getConnectCode())
            ->where('user_type', $this->getUserType())
            ->where('open_id', $this->getOpenId())->first();

        if ($model) {
            return $model->user_id;
        } else {
            return null;
        }
    }





}
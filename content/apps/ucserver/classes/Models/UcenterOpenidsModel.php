<?php

namespace Ecjia\App\Ucserver\Models;

use Royalcms\Component\Database\Eloquent\Model;
use RC_Time;

class UcenterOpenidsModel extends Model
{
    protected $table = 'ucenter_openids';

    protected $primaryKey = 'openid';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'openid',
        'appid',
        'user_id',
        'user_name',
        'create_time',
        'login_times',
        'last_time',
    ];

    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 更新用户的登录次数和最后登录时间
     *
     * @param $openid
     * @return mixed
     */
    public function updateLoginTimes($appid, $userid)
    {
        return $this->where('appid', $appid)->where('user_id', $userid)->increment('login_times', 1, ['last_time' => RC_Time::gmtime()]);
    }


    public function getOpenIdByUserId($appid, $userid)
    {
        $model = $this->where('appid', $appid)->where('user_id', $userid)->first();
        return $model->openid;
    }


    public function createOpenId($appid, $userid, $username)
    {
        $data = [
            'openid'        => $this->generateUUID(),
            'appid'         => $appid,
            'user_id'       => $userid,
            'user_name'     => $username,
            'create_time'   => RC_Time::gmtime(),
            'last_time'     => RC_Time::gmtime(),
            'login_times'   => 1,
        ];
        $model = $this->create($data);

        return $model->toArray();
    }


    public function deleteOpenId($appid, $userid)
    {
        return $this->where('appid', $appid)->where('user_id', $userid)->delete();
    }


    public function hasOpenId($appid, $userid)
    {
        return $this->where('appid', $appid)->where('user_id', $userid)->count();
    }


    protected function generateUUID()
    {
        $uuid = \Royalcms\Component\Uuid\Uuid::generate();
        $uuid = str_replace("-", "", $uuid);

        return $uuid;
    }
    
}

// end
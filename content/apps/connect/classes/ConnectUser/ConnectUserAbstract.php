<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/11
 * Time: 16:08
 */

namespace Ecjia\App\Connect\ConnectUser;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use Ecjia\App\Connect\Models\ConnectUserModel;
use RC_Time;
use RC_Logger;
use Royalcms\Component\Support\Collection;

abstract class ConnectUserAbstract extends AbstractRepository
{

    /**
     * 数据模型
     * @var \Ecjia\App\Connect\Models\ConnectUserModel
     */
    protected $model = 'Ecjia\App\Connect\Models\ConnectUserModel';

    /**
     * 用户类型定义
     * @var string
     */
    const USER = 'user';
    const MERCHANT = 'merchant';
    const ADMIN = 'admin';

    protected $connect_code;

    protected $connect_platform;

    protected $open_id;

    protected $union_id;

    protected $user_id;

    protected $user_type;

    /**
     * ConnectUserAbstract constructor.
     * @param $open_id
     * @param string $user_type
     * @throws \Royalcms\Component\Repository\Exceptions\RepositoryException
     */
    public function __construct($open_id, $user_type = self::USER)
    {
        parent::__construct();

        $this->open_id   = $open_id;
        $this->user_type = $user_type;

        $this->setModel(new ConnectUserModel);
    }

    public function setConnectPlatform($connect_platform)
    {
        $this->connect_platform = $connect_platform;
        return $this;
    }

    public function getConnectPlatform()
    {
        return $this->connect_platform;
    }

    public function setUnionId($union_id)
    {
        $this->union_id = $union_id;
        return $this;
    }

    public function getUnionId()
    {
        return $this->union_id;
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

    /**
     * 创建绑定用户
     * createUser 和 bindUser 也是二选一操作方法
     * 可以通过判断open_id是否存在，决定使用哪一种绑定方法
     * 如果记录不存在，则需创建记录
     * 如果记录已经存在，则直接绑定用户
     *
     * @param $user_id
     * @return \Ecjia\App\Connect\Models\ConnectUserModel
     */
    public function createUser($user_id)
    {
        return $this->model->create([
            'connect_code'     => $this->getConnectCode(),
            'connect_platform' => $this->getConnectPlatform(),
            'open_id'          => $this->getOpenId(),
            'union_id'         => $this->getUnionId(),
            'user_type'        => $this->getUserType(),
            'user_id'          => $user_id,
            'create_at'        => RC_Time::gmtime(),
        ]);
    }

    /**
     * 获取用户数据模型
     * @return \Ecjia\App\Connect\Models\ConnectUserModel
     */
    public function getUserModel()
    {
        return $this->getModel()
            ->where('open_id', $this->open_id)
            ->where('connect_code', $this->connect_code)
            ->where('user_type', $this->user_type)
            ->first();
    }

    /**
     * 获取用户数据模型
     * @return \Ecjia\App\Connect\Models\ConnectUserModel
     */
    public function getUserModelByUserId()
    {
        return $this->getModel()
            ->where('user_id', $this->getUserId())
            ->where('connect_code', $this->getConnectCode())
            ->where('user_type', $this->getUserType())
            ->first();
    }

    /**
     * 获取用户数据模型集合，通过union_id
     * @return Collection
     */
    public function getUserModelCollectionByUnionId()
    {
        if ($this->union_id) {
            return $this->getModel()
                ->where('union_id', $this->union_id)
                ->where('connect_platform', $this->connect_platform)
                ->where('user_type', $this->user_type)
                ->get();
        }

        return collect();
    }

    /**
     * 获取用户数据模型集合，通过open_id
     * @return Collection
     */
    public function getUserModelCollectionByOpenId()
    {
        return $this->getModel()
            ->where('open_id', $this->open_id)
            ->where('connect_platform', $this->connect_platform)
            ->where('user_type', $this->user_type)
            ->get();
    }

    /**
     * 获取用户数据模型集合，通过user_id
     * @return Collection
     */
    public function getUserModelCollectionByUserId()
    {
        return $this->getModel()
            ->where('user_id', $this->user_id)
            ->where('user_type', $this->user_type)
            ->get();
    }

    /**
     * 保存授权token和profile
     * @param $user_model \Ecjia\App\Connect\Models\ConnectUserModel
     * @param $access_token
     * @param $refresh_token
     * @param $user_profile
     * @param $expires_time
     * @return mixed
     */
    public function saveConnectProfile(ConnectUserModel $user_model, $access_token, $refresh_token, $user_profile, $expires_time)
    {
        $curr_time = RC_Time::gmtime();

        $user_model->create_at = $curr_time;
        $user_model->expires_in = $expires_time;
        $user_model->expires_at = $curr_time + $expires_time;

        if (empty($user_model->user_id)) {
            $user_model->user_id = $this->getUserId();
            $user_model->user_type = $this->getUserType();
        }

        if ($access_token) {
            $user_model->access_token = $access_token;
        }

        if ($refresh_token) {
            $user_model->refresh_token = $refresh_token;
        }

        if ($user_profile) {
            if (is_array($user_profile)) {
                $user_profile = serialize($user_profile);
            }

            $user_model->profile = $user_profile;
        }

        return $user_model->save();
    }

    /**
     * 绑定用户，需要通过手动创建用户，获取user_id传入
     *
     * bindUser 和 bindUserByUnionId 是二选一，取决于有没有user_id的情况下
     * 如果有user_id，走bindUser
     * 如果没有user_id，走bindUserByUnionId，需要提前设置connect_platform和union_id
     *
     * @param $user_id
     * @return \Royalcms\Component\Database\Eloquent\Model | bool
     */
    public function bindUser($user_id)
    {
        $this->setUserId($user_id);

        $model = $this->getUserModel();

        if ($model) {
            if (! empty($model->user_id)) {
                return $model;
            }

            //关联同一平台下union_id相同的用户，同时绑定
            $collection = $this->getUserModelCollectionByUnionId();
            if ($collection->isNotEmpty()) {
                $collection->each(function ($item) use ($user_id) {
                    if (empty($item->user_id)) {
                        $item->user_id = $user_id;
                        $item->save();
                    }
                });
            } else {
                //关联同一平台下open_id相同的用户，同时绑定
                $collection = $this->getUserModelCollectionByOpenId();
                if ($collection->isNotEmpty()) {
                    $collection->each(function ($item) use ($user_id) {
                        if (empty($item->user_id)) {
                            $item->user_id = $user_id;
                            $item->save();
                        }
                    });
                }
            }

            $model->user_id   = $this->getUserId();
            $model->user_type = $this->getUserType();
            return $model->save();
        } else {
            return false;
        }

    }

    /**
     * 绑定用户，通过union_id，使用setUnionId传入
     * @return \Royalcms\Component\Database\Eloquent\Model | bool
     */
    public function bindUserByUnionId()
    {
        $model = $this->getUserModel();

        $user_id = 0;

        $collection = $this->getUserModelCollectionByUnionId();

        if ($collection->isNotEmpty()) {

            $collection->each(function ($item) use (& $user_id) {
                if (! empty($item->user_id)) {
                    $user_id = $item->user_id;
                }
            });

        }

        if ($user_id) {
            if (empty($model)) {
                return $this->createUser($user_id);
            } else {
                return $this->bindUser($user_id);
            }
        }

        return false;
    }

    /**
     * 绑定用户，通过open_id
     * @return \Royalcms\Component\Database\Eloquent\Model | bool
     */
    public function bindUserByOpenId()
    {
        $model = $this->getUserModel();

        $user_id = 0;

        $collection = $this->getUserModelCollectionByOpenId();

        if ($collection->isNotEmpty()) {

            $collection->each(function ($item) use (& $user_id) {
                if (! empty($item->user_id)) {
                    $user_id = $item->user_id;
                }
            });

        }

        if ($user_id) {
            if (empty($model)) {
                return $this->createUser($user_id);
            } else {
                return $this->bindUser($user_id);
            }
        }

        return false;
    }

    /**
     * 获取用户的profile
     * @return mixed
     */
    public function getConnectProfile()
    {
        $profile = optional($this->getUserModel())->profile;

        $profile = unserialize($profile);

        return  $profile ?: array();
    }

}
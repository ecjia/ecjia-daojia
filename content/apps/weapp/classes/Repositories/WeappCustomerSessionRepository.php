<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/29
 * Time: 4:16 PM
 */

namespace Ecjia\App\Weapp\Repositories;

use Royalcms\Component\Repository\Repositories\AbstractRepository;

class WeappCustomerSessionRepository extends AbstractRepository
{

    protected $model = 'Ecjia\App\Wechat\Models\WechatCustomerSessionModel';

    protected $orderBy = ['create_time' => 'desc'];

    protected $weappId;

    public function __construct($weappId)
    {
        parent::__construct();

        $this->weappId = $weappId;

        $this->addScopeQuery(function ($query) use ($weappId) {
            return $query->where('wechat_id', $weappId);
        });
    }

    /**
     * 创建接入会话，或修改待接入的会话为接入会话
     */
    public function createSession($openid, $kf_account, $create_time)
    {
        $model = $this->findBy('openid', $openid);
        if (! empty($model)) {
            $data = [
                'kf_account' => $kf_account,
                'create_time' => $create_time,
                'status' => 1, //会话中
            ];

            $this->update($model, $data);

        } else {
            $data = [
                'wechat_id' => $this->weappId,
                'openid' => $openid,
                'kf_account' => $kf_account,
                'create_time' => $create_time,
                'status' => 1, //待接入
            ];

            $this->create($data);
        }
    }

    /**
     * 创建等待接入的会话
     */
    public function createWaitSession($openid)
    {
        $model = $this->findBy('openid', $openid);
        if (! empty($model)) {
            $data = [
                'latest_time' => SYS_TIME,
            ];

            $this->update($model, $data);

        } else {
            $data = [
                'wechat_id' => $this->weappId,
                'openid' => $openid,
                'latest_time' => SYS_TIME,
                'status' => 2, //待接入
            ];

            $this->create($data);
        }
    }

    /**
     * 关闭会话接入
     */
    public function closeSession($openid, $kf_account, $create_time)
    {
        $model = $this->findBy('openid', $openid);
        if (! empty($model)) {
            $data = [
                'kf_account' => $kf_account,
                'latest_time' => $create_time,
                'status' => 3, //已关闭
            ];

            $this->update($model, $data);

        } else {
            $data = [
                'wechat_id' => $this->weappId,
                'openid' => $openid,
                'kf_account' => $kf_account,
                'latest_time' => $create_time,
                'status' => 3, //已关闭
            ];

            $this->create($data);
        }

    }


}
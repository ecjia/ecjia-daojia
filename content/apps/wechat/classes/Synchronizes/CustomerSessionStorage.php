<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/31
 * Time: 10:33 AM
 */

namespace Ecjia\App\Wechat\Synchronizes;

use Ecjia\App\Wechat\Models\WechatCustomerSessionModel;

class CustomerSessionStorage
{

    protected $wechat_id;

    protected $data;

    protected $kf_account;

    public function __construct($wechat_id, $data, $kf_account)
    {
        $this->wechat_id = $wechat_id;
        $this->data = $data;
        $this->kf_account = $kf_account;
    }

    public function save()
    {
        $items = $this->data->get('sessionlist');

        $wechat_id = $this->wechat_id;
        $kf_account = $this->kf_account;

        collect($items)->map(function($item) use ($wechat_id, $kf_account) {

            $model = WechatCustomerSessionModel::where('wechat_id', $wechat_id)->where('openid', $item['openid'])->first();
            if (!empty($model)) {
                if ($model->kf_account != $kf_account
                    || $model->status != 1
                    || $model->create_time != $item['create_time']) {
                    //已存在，更新数据
                    $newdata = [
                        'kf_account' => $kf_account,
                        'create_time' => $item['create_time'],
                        'status'      => 1,
                    ];
                    $model->update($newdata);
                }

            } else {
                //不存在，添加数据
                $newdata = [
                    'wechat_id' => $wechat_id,
                    'kf_account' => $kf_account,
                    'openid' => $item['openid'],
                    'status' => 1,
                    'create_time' => $item['create_time'],
                ];
                WechatCustomerSessionModel::create($newdata);
            }

        });

    }

}
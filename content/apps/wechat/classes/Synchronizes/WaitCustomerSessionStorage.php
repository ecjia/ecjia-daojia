<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/31
 * Time: 10:33 AM
 */

namespace Ecjia\App\Wechat\Synchronizes;

use Ecjia\App\Wechat\Models\WechatCustomerSessionModel;

class WaitCustomerSessionStorage
{

    protected $wechat_id;

    protected $data;

    public function __construct($wechat_id, $data)
    {
        $this->wechat_id = $wechat_id;
        $this->data = $data;
    }

    public function save()
    {
        $items = $this->data->get('waitcaselist');

        $wechat_id = $this->wechat_id;

        collect($items)->map(function($item) use ($wechat_id) {

            $model = WechatCustomerSessionModel::where('wechat_id', $wechat_id)->where('openid', $item['openid'])->first();
            if (!empty($model)) {
                if ($model->status != 2 || $model->latest_time != $item['latest_time']) {
                    //已存在，更新数据
                    $newdata = [
                        'latest_time' => $item['latest_time'],
                        'status'      => 2,
                    ];
                    $model->update($newdata);
                }

            } else {
                //不存在，添加数据
                $newdata = [
                    'wechat_id' => $wechat_id,
                    'openid' => $item['openid'],
                    'status' => 2,
                    'latest_time' => $item['latest_time'],
                ];
                WechatCustomerSessionModel::create($newdata);
            }

        });

    }

}
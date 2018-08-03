<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/31
 * Time: 10:33 AM
 */

namespace Ecjia\App\Wechat\Synchronizes;

use Ecjia\App\Wechat\Models\WechatCustomerRecordModel;

class CustomerRecordStorage
{

    protected $wechat_id;

    protected $data;

    protected $cache_key;

    //更新多少天前的数据
    const CYCLE_DAY = 7;

    public function __construct($wechat_id, $data = null)
    {
        $this->wechat_id = $wechat_id;
        $this->data = $data;

        $this->cache_key = 'wechat_customer_record_position_'.$wechat_id;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function save()
    {
        $items = $this->data->get('recordlist');

        if ($this->data->get('number') > 0) {
            $wechat_id = $this->wechat_id;

            $newdata = collect($items)->map(function($item) use ($wechat_id) {
                return [
                    'wechat_id' => $wechat_id,
                    'kf_account' => $item['worker'],
                    'openid' => $item['openid'],
                    'opercode' => $item['opercode'],
                    'text' => $item['text'],
                    'time' => $item['time'],
                ];
            })->toArray();

            WechatCustomerRecordModel::insert($newdata);

            //删除缓存
            ecjia_cache('wechat')->forget($this->cache_key);
        }
    }

    /**
     * 设置下一次请求的开始时间
     * @param $start_time
     */
    public function setNextStartTime($start_time)
    {
        //永久缓存
        ecjia_cache('wechat')->forever($this->cache_key, $start_time);
    }

    /**
     * 获取查询时间段，开始时间和结束时间
     */
    public function getStartTimeAndEndTime()
    {
        //读取上次获取用户位置
        $start_time = ecjia_cache('wechat')->get($this->cache_key);

        if (empty($start_time)) {
            $model = WechatCustomerRecordModel::where('wechat_id', $this->wechat_id)->orderBy('time', 'desc')->first();
            if (! empty($model)) {
                $start_time = $model->time;
            } else {
                $start_time = mktime(0, 0, 0, date('m'), date('d') - self::CYCLE_DAY, date('Y'));
            }
        }

        $end_time = ($start_time + 24 * 3600) - 1;

        return array($start_time, $end_time);
    }


}
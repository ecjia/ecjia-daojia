<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/6
 * Time: 10:12 AM
 */

namespace Ecjia\App\Market\Prize;

use Ecjia\App\Market\Models\MarketActivityLogModel;
use Ecjia\App\Market\Models\MarketActivityModel;
use Ecjia\App\Market\Models\MarketActivityLotteryModel;
use Ecjia\App\Market\Models\MarketActivityPrizeModel;
use RC_Time;
use RC_DB;

class MarketActivity
{

    protected $wechat_id;

    protected $store_id;

    protected $activity_code;

    protected $model;

    protected $prize;


    public function __construct($activity_code, $store_id = 0, $wechat_id = 0)
    {
        $this->activity_code = $activity_code;
        $this->store_id = $store_id;
        $this->wechat_id = $wechat_id;

        $this->model = $this->getMarketActivity();

        $this->prize = new ActivityPrize($this->model);
    }

    private function getMarketActivity()
    {
        return MarketActivityModel::where('store_id', $this->store_id)->where('wechat_id', $this->wechat_id)->where('activity_group', $this->activity_code)->first();
    }

    public function getMarketActivityModel()
    {
        return $this->model;
    }

    /**
     * 获取活动ID
     * @return mixed
     */
    public function getActivityId()
    {
        return $this->model->activity_id;
    }

    /**
     * 获取活动名称
     * @return mixed
     */
    public function getActivityName()
    {
        return $this->model->activity_name;
    }

    /**
     * 获取活动代号
     * @return mixed
     */
    public function getActivityCode()
    {
        return $this->model->activity_group;
    }

    /**
     * 获取活动描述
     */
    public function getActivityDescription()
    {
        return $this->model->activity_desc;
    }


    /**
     * 获取活动开始时间
     * @return mixed
     */
    public function getActivityStartTime()
    {
        return $this->model->start_time;
    }

    /**
     * 获取活动结束时间
     * @return mixed
     */
    public function getActivityEndTime()
    {
        return $this->model->end_time;
    }

    /**
     * 获取用户的剩余抽奖次数
     * @param $openid
     * @return int
     */
    public function getLotteryOverCount($openid)
    {
        if ($this->model->limit_num > 0) {
            $starttime = $this->model->start_time;
            $endtime = $this->model->end_time;
            $time = RC_Time::gmtime();

            $time_limit = $time - $this->model->limit_time * 60;

            $market_activity_lottery = $this->model->MarketActivityLottery()
                ->where('user_id', $openid)
                ->where('user_type', 'wechat')
                ->where('update_time', '<=', $time)
                ->where('add_time', '>=', $time_limit)
                ->first();

            //找到数据，说明在有效时间内
            if (!empty($market_activity_lottery)) {
                //限定时间已抽取的次数
                $has_used_count = $market_activity_lottery->lottery_num;
            }
            //找不到数据，说明已经过有效时间，可以重置抽奖时间和抽奖次数
            else {
                $this->resetLotteryOverCount($openid);

                $has_used_count = 0;
            }

            //剩余可抽取的次数
            $prize_num = $this->model->limit_num - $has_used_count;

        } else {
            $prize_num = -1; //无限次
        }

        return intval($prize_num);
    }

    /**
     * 获取活动的所有奖品
     */
    public function getPrizes()
    {
        return $this->prize->getPrizes();
    }

    /**
     * 获取活动的能中奖的奖品
     * @return mixed
     */
    public function getCanWinningPrizes()
    {
        return $this->prize->getCanWinningPrizes();
    }

    /**
     * 获取活动中奖的记录
     */
    public function getActivityWinningLog()
    {
        $types = $this->getCanWinningPrizes();

        $model = $this->model;

        $data = MarketActivityModel::with(['MarketActivityLog' => function ($query) use ($types, $model) {
            $query->whereIn('market_activity_log.prize_id', $types)
                ->where('market_activity_log.add_time', '>=', $model->start_time)
                ->where('market_activity_log.add_time', '<=', $model->end_time)
                ->orderBy('market_activity_log.add_time', 'DESC')
                ->take(10);
        }])->where('market_activity.store_id', $this->store_id)
            ->where('market_activity.wechat_id', $this->wechat_id)
            ->where('market_activity.activity_group', $this->activity_code)
            ->first();


        $prize = $this->prize;

        $newdata = $data->MarketActivityLog->map(function ($item) use (& $bound_ids, $prize) {
            //奖品为红包的时候，查询红包信息
            if ($item->MarketActivityPrize->prize_type == PrizeType::TYPE_BONUS) {

                $bonus = $item->MarketActivityPrize->BonusType;
                $prize_value = $bonus->type_money;
                $prize_value = ecjia_price_format($prize_value, false);
                $item->prize_value = $prize_value;

            } else {
                $item->prize_value = $item->MarketActivityPrize->prize_value;
            }

            return $item;
        });

        return $newdata;

    }

    /**
     * 自增用户的抽奖使用次数
     * @param $openid
     */
    public function incrementLotteryCount($openid)
    {
        $model = MarketActivityLotteryModel::where('activity_id', $this->getActivityId())
            ->where('user_id', $openid)
            ->where('user_type', 'wechat')
            ->first();

        //规定时间未超出设定的次数；更新抽奖次数，更新抽奖时间
        if (! empty($model)) {
            $time = RC_Time::gmtime();
            $limit_count_new = $model->lottery_num + 1;
            $model->update(['update_time' => $time, 'lottery_num' => $limit_count_new]);
        } else {
            $this->resetLotteryOverCount($openid);
            $this->incrementLotteryCount($openid);
        }
    }

    /**
     * 重置用户的剩余抽奖次数
     * @param $openid
     */
    protected function resetLotteryOverCount($openid)
    {
        $time = RC_Time::gmtime();

        $model = MarketActivityLotteryModel::where('activity_id', $this->getActivityId())
            ->where('user_id', $openid)->first();
        if (! empty($model)) {
            $model->update(['add_time' => $time, 'update_time' => $time, 'lottery_num' => 0]);
        } else {
            MarketActivityLotteryModel::insert([
                'activity_id'   => $this->getActivityId(),
                'user_id'       => $openid,
                'user_type'     => 'wechat',
                'lottery_num'   => 0,
                'add_time'      => $time,
                'update_time'   => $time,
            ]);
        }
    }

    /**
     * 抽奖动作，获取一个奖品
     *
     * 每次前端页面的请求，PHP循环奖项设置数组，
     * 通过概率计算函数get_rand获取抽中的奖项id。
     */
    public function randLotteryPrizeAction()
    {
        $prizes = $this->getPrizes();

        $sum_prob = $prizes->sum('prize_prob');

        $rand_prize =  $prizes->map(function ($item) use ( & $sum_prob) {
            $rand = mt_rand(1, $sum_prob);
            if ($rand <= $item->prize_prob) {
                return $item;
            } else {
                $sum_prob = $sum_prob - $item->prize_prob;
                return null;
            }
        })->filter(function ($item) {
            return is_null($item) ? false : true;
        })->first();

        return $rand_prize;
    }

    /**
     * 发放中奖的奖品
     * @param $openid
     */
    public function issuePrize($wechat_id, $openid, MarketActivityPrizeModel $prize_info, $logid)
    {

        //发实物奖品，后台发放，系统不自动发放

        //事务执行，出错回滚
        return RC_DB::transaction(function () use ($wechat_id, $openid, $prize_info, $logid) {
            switch ($prize_info->prize_type) {
                //发红包优惠券
                case PrizeType::TYPE_BONUS:
                    $prize = new \Ecjia\App\Market\Prize\IssuePrizeBonus($wechat_id, $prize_info);
                    $result = $prize->issue($openid);
                    break;

                //发积分
                case PrizeType::TYPE_INTEGRAL:
                    $prize = new \Ecjia\App\Market\Prize\IssuePrizeIntegral($wechat_id, $prize_info);
                    $result = $prize->issue($openid);
                    break;

                //发现金红包
                case PrizeType::TYPE_BALANCE:
                    $prize = new \Ecjia\App\Market\Prize\IssuePrizeBalance($wechat_id, $prize_info);
                    $result = $prize->issue($openid);
                    break;

                default:
                    $result = false;
                    break;

            }

            //发放奖品成功后，更新发放记录
            if ($result) {

                $this->subtractLotteryPrizeNum($prize_info);

                return MarketActivityLogModel::where('id', $logid)->update(
                    [
                        'issue_status'  => 1,
                        'issue_time'    => RC_Time::gmtime(),
                    ]
                );
            }
        });
    }

    /**
     * 减奖品数量
     * @param MarketActivityPrizeModel $prize_info
     */
    protected function subtractLotteryPrizeNum(MarketActivityPrizeModel $prize_info)
    {
        $prize_info->decrement('prize_number');
    }

    /**
     * 添加用户的中奖记录
     */
    public function addLotteryPrizeLog($openid, MarketActivityPrizeModel $prize_info)
    {
        $name = RC_DB::table('wechat_user')->where('openid', $openid)->pluck('nickname');
        $data = array(
            'activity_id'   => $prize_info->activity_id,
            'user_id'       => $openid,
            'user_type'     => 'wechat',
            'user_name'     => empty($name) ? '' : $name,
            'prize_id'      => $prize_info['prize_id'],
            'prize_name'    => $prize_info['prize_name'],
            'add_time'      => RC_Time::gmtime(),
            'source'        => 'wechat',
            'issue_status'  => 0,
            'issue_time'    => 0,
        );
        return MarketActivityLogModel::insertGetId($data);
    }


}
<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/6
 * Time: 10:12 AM
 */

namespace Ecjia\App\Market\Prize;

use Ecjia\App\Market\Exceptions\ActivityException;
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

        if (is_null($this->model)) {
            throw new ActivityException('营销活动暂未开启！');
        }

        $this->prize = new ActivityPrize($this->model);
    }

    private function getMarketActivity()
    {
        return MarketActivityModel::where('store_id', $this->store_id)
            ->where('wechat_id', $this->wechat_id)
            ->where('activity_group', $this->activity_code)
            ->where('enabled', 1)
            ->first();
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
     * 获取活动的可用奖品
     */
    public function getAvailablePrizes()
    {
        return $this->prize->getAvailablePrizes();
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
        $prizes = $this->getAvailablePrizes();

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

                case PrizeType::TYPE_REAL:
                    $prize = new \Ecjia\App\Market\Prize\IssuePrizeReal($wechat_id, $prize_info);
                    $result = $prize->issue($openid);
                    break;

                case PrizeType::TYPE_NONE:
                    $prize = new \Ecjia\App\Market\Prize\IssuePrizeNone($wechat_id, $prize_info);
                    $result = $prize->issue($openid);
                    break;

                case PrizeType::TYPE_GOODS:
                    $prize = new \Ecjia\App\Market\Prize\IssuePrizeGoods($wechat_id, $prize_info);
                    $result = $prize->issue($openid);
                    break;

                case PrizeType::TYPE_STORE:
                    $prize = new \Ecjia\App\Market\Prize\IssuePrizeStore($wechat_id, $prize_info);
                    $result = $prize->issue($openid);
                    break;

                default:
                    $result = false;
                    break;

            }

            //发放奖品成功后，更新发放记录
            if ($result) {

                $this->subtractLotteryPrizeNum($prize_info);

                //排除实事奖品发放
                if ($prize_info->prize_type != PrizeType::TYPE_REAL) {
                    return MarketActivityLogModel::where('id', $logid)->update(
                        [
                            'issue_status'  => 1,
                            'issue_time'    => RC_Time::gmtime(),
                        ]
                    );
                }
            }
        });
    }

    /**
     * 减奖品数量
     * @param MarketActivityPrizeModel $prize_info
     */
    public function subtractLotteryPrizeNum(MarketActivityPrizeModel $prize_info)
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
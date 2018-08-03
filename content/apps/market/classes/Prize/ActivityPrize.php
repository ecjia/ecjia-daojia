<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/8/2
 * Time: 1:00 PM
 */

namespace Ecjia\App\Market\Prize;

use Ecjia\App\Market\MarketAbstract;
use Ecjia\App\Market\Models\MarketActivityPrizeModel;

class ActivityPrize
{

    protected $activity;

    public function __construct(MarketAbstract $activity)
    {
        $this->activity = $activity;
    }


    public function getPrizes()
    {
        MarketActivityPrizeModel::where('activity_id', $this->activity->getActivityId());
    }




}
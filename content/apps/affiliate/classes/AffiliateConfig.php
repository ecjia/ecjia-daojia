<?php

namespace Ecjia\App\Affiliate;

use ecjia;

class AffiliateConfig
{
    /**
     * expire               COOKIE过期数字
     * expire_unit          单位：小时、天、周
     * separate_by          分成模式：0、注册 1、订单
     * level_point_all      积分分成比
     * level_money_all      金钱分成比
     * level_register_all   推荐注册奖励积分
     * level_register_up    推荐注册奖励积分上限
     * 
     * @var array
     */
    protected $config = [];
    
    /**
     * 邀请人的奖励
     * invite_reward_by 
     * invite_reward_type
     * invite_reward_value
     * 
     * @var array
     */
    protected $invite_reward = [];
    
    
    /**
     * 被邀请人的奖励
     * invitee_reward_by
     * invitee_reward_type
     * invitee_reward_value
     * 
     * @var array
     */
    protected $invitee_reward = [];
    
    
    protected $on = 0;
    
    
    protected $item = [];
    
    
    public function __construct(array $affiliate = [])
    {
        if (empty($affiliate)) {
            $affiliate = unserialize(ecjia::config('affiliate'));
        }
        
        $this->config           = array_get($affiliate, 'config');
        $this->invite_reward    = array_get($affiliate, 'invite_reward');
        $this->invitee_reward   = array_get($affiliate, 'invitee_reward');
        $this->item             = array_get($affiliate, 'item');
        $this->on               = array_get($affiliate, 'on');
        
        
    }
    
    
    
    public function getInviteRewardBy()
    {
        return array_get($this->invite_reward, 'invite_reward_by');
    }
    
    public function getInviteRewardType()
    {
        return array_get($this->invite_reward, 'invite_reward_type');
    }
    
    public function getInviteRewardValue()
    {
        return array_get($this->invite_reward, 'invite_reward_value');
    }
    
    
    public function getInviteeRewardBy()
    {
        return array_get($this->invitee_reward, 'invitee_reward_by');
    }
    
    public function getInviteeRewardType()
    {
        return array_get($this->invitee_reward, 'invitee_reward_type');
    }
    
    public function getInviteeRewardValue()
    {
        return array_get($this->invitee_reward, 'invitee_reward_value');
    }
    
    
    
}
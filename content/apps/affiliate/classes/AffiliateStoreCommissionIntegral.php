<?php
/**
 * Created by PhpStorm.
 * User: huangyuyuan@ecmoban.com
 * Date: 19/6/5 005
 * Time: 11:35
 */

namespace Ecjia\App\Affiliate;

use Ecjia\App\Affiliate\Models\AffiliateStoreModel;
use Ecjia\App\Affiliate\Models\AffiliateOrderCommissionModel;
use Ecjia\App\Affiliate\Models\OrderGoodsModel;

use Ecjia\App\Affiliate\AffiliateStore;
use RC_Time;
use ecjia;
use ecjia_error;
use RC_Logger;
use RC_Api;

//订单使用积分，分成给AB代理
class AffiliateStoreCommissionIntegral
{

    /**
     * 分佣规则
     * 前置：
     * 1.开启积分返利（积分返利设置-开关）
     * 2.完成订单（已付款）
     * 3.使用积分
     *
     * 细节：
     * 1.结算时积分分成(订单完成：确认收货 提货 核销 )
     * 2.普通订单退款 退回积分
     *
     * 积分返利设置
     * 1.直属代理积分比例 ecjia::config('affiliate_integral_percent_agent_a')
     * 2.次级代理积分比例 ecjia::config('affiliate_integral_percent_agent_b')
     * 3.开关 ecjia::config('affiliate_integral') = 1
     */

    public $store_id;
    public $order;
    public $inviter_agent_info;
    public $inviter_agent_info_parent;
    public $order_type;

    public function __construct($order_type, $store_id, $order) {
        $this->order_type = $order_type;
        $this->store_id = $store_id;
        $this->order = $order;
    }

    public function run() {
        RC_Logger::getlogger('info')->info([
            'file' => __FILE__,
            'line' => __LINE__,
            'name' => 'AffiliateStoreCommissionIntegral',
            'content' => $this->order,
        ]);


        //退款订单
        if($this->order_type  == 'refund') {
            return $this->refundCommission();
        } else {
            return $this->orderCommission();
        }

    }

    private function orderCommission() {
        $affiliate_integral = ecjia::config('affiliate_integral');
        if ($affiliate_integral != 1) {
            return new \ecjia_error('affiliate_integral_off', '积分返利未开启');
        }

        if(($this->order_type == 'quickpay' && $this->order['pay_status'] != 1) || ($this->order_type == 'buy' && $this->order['pay_status'] != PS_PAYED)) {
            return new \ecjia_error('unpay', '订单未付款，无返利');
        }

        if(!$this->order['integral']) {
            return new \ecjia_error('unuse_integral', '订单未使用积分，无返利');
        }

        $inviter_agent_id = AffiliateStore::getAffiliateStoreId($this->store_id);//邀请人
        if(empty($inviter_agent_id)) {
            return new \ecjia_error('no_agent', '无代理商');;//无邀请记录
        }

        //获得邀请人信息，并判断有无上级代理
        $this->inviter_agent_info = AffiliateStore::getAgentInfo($inviter_agent_id);
        if(empty($this->inviter_agent_info)) {
            return new \ecjia_error('agent_info_not_find', '代理商信息不存在');//代理商信息空
        }

        //获取上级代理商
        if($this->inviter_agent_info['agent_parent_id']) {
            $this->agentParentCommission();
            return $this->agentCommission();
        } else {
            return $this->agentCommission('AGENT_A');
        }

        return true;
    }

    private function refundCommission() {
        //查询分成记录
        $record = $this->getOrderCommission();
        if($record) {
            foreach ($record as $row) {
                if($row['agent_integral']) {
                    $agent_integral = $row['agent_integral'] * -1;
                    $data = [
                        'store_id' => $row['store_id'],
                        'affiliate_store_id' => $row['affiliate_store_id'],
                        'order_type' => $this->order_type,
                        'order_id' => $row['order_id'],
                        'order_sn' => $row['order_sn'],
                        'order_amount' => $row['order_amount'],
                        'platform_commission' => 0,//平台佣金
                        'percent_value'=> 0,
                        'agent_integral' => $agent_integral,
                        'status' => 1,
                        'add_time' => \RC_Time::gmtime()
                    ];
                    AffiliateOrderCommissionModel::insert($data);

                    //自动分成
                    $agent_user_id = AffiliateStoreModel::where('id', $row['affiliate_store_id'])->pluck('user_id');
                    $log_id = RC_Api::api('finance', 'pay_points_change', [
                        'user_id' => $agent_user_id,
                        'point' => $agent_integral,
                        'change_desc' => '订单退款，'.$this->order['order_sn'].' 扣除返利积分',
                    ]);
                }
            }
        }

    }

    //当前代理结算
    //代理结算算法更新，不使用代理比例，使用affiliate_grade_price商品设置的佣金
    private function agentCommission($agent_rank = 'AGENT_B') {
        $agent = [
            'affiliate_store_id' => $this->inviter_agent_info['id'],
            'user_id' => $this->inviter_agent_info['user_id'],
        ];
        return $this->insertOrderCommission($agent, $agent_rank);
    }

    //父级代理结算
    private function agentParentCommission() {
        $this->inviter_agent_info_parent = AffiliateStoreModel::where('id', $this->inviter_agent_info['agent_parent_id'])->first();
        $agent = [
            'affiliate_store_id' => $this->inviter_agent_info_parent['id'],
            'user_id' => $this->inviter_agent_info_parent['user_id'],
        ];
        return $this->insertOrderCommission($agent, 'AGENT_A');
    }

    private function insertOrderCommission($agent, $agent_rank = '') {
        $count = AffiliateOrderCommissionModel::where('affiliate_store_id', $agent['affiliate_store_id'])->where('order_sn', $this->order['order_sn'])
            ->where('agent_integral', '>', 0)->count();
        if($count) {
            return new \ecjia_error('repeat_affiliate', '重复分佣');
        }

        $agent_integral = $this->calculateAgentIntegral($agent_rank);
        if($agent_integral) {
            $data = [
                'store_id' => $this->store_id,
                'affiliate_store_id' => $agent['affiliate_store_id'],
                'order_type' => $this->order_type,
                'order_id' => $this->order['order_id'],
                'order_sn' => $this->order['order_sn'],
                'order_amount' => $this->order['order_amount'],
                'platform_commission' => 0,//平台佣金
                'percent_value'=> 0,
                'agent_integral' => $agent_integral,
                'status' => 1,
                'add_time' => \RC_Time::gmtime()
            ];
            AffiliateOrderCommissionModel::insert($data);

            //自动分成
            $log_id = RC_Api::api('finance', 'pay_points_change', [
                'user_id' => $agent['user_id'],
                'point' => $agent_integral,
                'change_desc' => '订单'.$this->order['order_sn'].'返利的积分',
            ]);
        }

        return true;
    }

    private function calculateAgentIntegral($agent_rank) {
        $amount = 0;

        if($agent_rank == 'AGENT_A') {
            $percent = ecjia::config('affiliate_integral_percent_agent_a');
        } else if($agent_rank == 'AGENT_B') {
            $percent = ecjia::config('affiliate_integral_percent_agent_b');
        }

        if($percent) {
            $percent = str_replace('%', '', $percent);
            $percent = floatval($percent);
            if($this->order['integral']) {
                $amount = $this->order['integral'] * $percent / 100;
            }
        }

        return intval($amount);
    }

    private function getOrderCommission() {
        $rs = AffiliateOrderCommissionModel::where('order_id', $this->order['order_id'])->where('order_type', 'buy')->get();
        return $rs;
    }

}
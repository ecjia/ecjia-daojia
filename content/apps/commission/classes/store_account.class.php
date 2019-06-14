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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺账户类
 */
class store_account {
    
    //订单(store_account_order)->修改余额(store_account)->变动日志(store_account_log)
    //充值
    /**
     * 可用余额=money-保证金(deposit)
     * 总金额=money+冻结
     * money 大于等于 deposit
     * -保证金并非实际金钱，只是衡量和比对的标记，表示保证金是多少，实际的钱在money内，变动money需和保证金对比
     */
    
    //充值
    public function charge($data) {
        //         `store_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
        //         `order_sn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '订单编号',
        //         `amount` decimal(10,2) NOT NULL,
        //         `process_type` = charge,
        //         `pay_code` varchar(90) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
        //         `payname` varchar(90) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
        //         `pay_time` int(10) NOT NULL DEFAULT '0',
        //         `pay_status` tinyint(1) NOT NULL DEFAULT '0',
        //         `status` 2,
        //         `add_time` int(10) NOT NULL DEFAULT '0',
    }
    
    //提现
    public function withdraw() {
        //`store_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
        //         `amount` decimal(10,2) NOT NULL,
        //         `staff_note` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
        //         `process_type` varchar(20) = withdraw
        //         `status` 1待审核,
        //         `add_time` int(10) NOT NULL DEFAULT '0',
//         `account_type` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '账户类型，bank银行，alipay支付宝',
//         `account_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '收款人',
//         `account_number` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '银行账号',
//         `bank_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '收款银行',
//         `bank_branch_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '开户银行支行名称',
    }
    
    //结算
    public static function bill($data) {
        if(empty($data['store_id']) || empty($data['amount']) || empty($data['bill_order_type']) || empty($data['bill_order_id']) || empty($data['bill_order_sn']) ) {
            return new ecjia_error('invalid_parameter', __('参数无效', 'commission'));
        }
        $data['process_type'] = 'bill';
        $data['pay_time'] = $data['add_time'] = RC_Time::gmtime();
        $data['pay_status'] = 1;
        $data['status'] = 2;
        $platform_profit = $data['platform_profit'];//平台收益
        unset($data['platform_profit']);
        
        if(self::insert_store_account_order($data)) {
            //改动账户
            if($data['bill_order_type'] == 'buy') {
                $change_desc = __('订单', 'commission');
            } else if ($data['bill_order_type'] == 'quickpay') {
                $change_desc = __('优惠买单', 'commission');
            } else if ($data['bill_order_type'] == 'refund') {
                $change_desc = __('退款', 'commission');
            }
            $change_desc .= ' ' . $data['bill_order_sn']; 
            
            return self::update_store_account($data['store_id'], $data['amount'], $data['process_type'], $change_desc, $platform_profit);
        }
        
        return false;
    }
    
    //订单表
    public static function insert_store_account_order($data) {
//         `store_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
//         `order_sn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '订单编号',
//         `amount` decimal(10,2) NOT NULL,
//         `admin_id` int(10) NOT NULL DEFAULT '0',
//         `admin_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
//         `admin_note` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
//         `staff_note` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
//         `process_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'buy' COMMENT 'charge充值，withdraw提现，bill结算',
//         `pay_code` varchar(90) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
//         `payname` varchar(90) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
//         `pay_time` int(10) NOT NULL DEFAULT '0',
//         `pay_status` tinyint(1) NOT NULL DEFAULT '0',
//         `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1待审核，2通过，3拒绝',
//         `bill_order_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'buy' COMMENT 'buy订单,quickpay买单,refund退款',
//         `bill_order_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
//         `bill_order_sn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '订单编号',
//         `add_time` int(10) NOT NULL DEFAULT '0',

        $data['order_sn'] = empty($data['order_sn']) ? ecjia_order_store_account_sn() : $data['order_sn'];
        return RC_DB::table('store_account_order')->insert($data);
    }
    
    public static function update_store_account($store_id, $money = 0, $change_type = '', $change_desc = '', $platform_profit = 0) {
        $info = RC_DB::table('store_account')->where('store_id', $store_id)->first();
        
        if(empty($info)) {
            RC_DB::table('store_account')->insert(array('store_id' => $store_id));
        }
        
        if ($change_type == 'withdraw' && $info['money'] - abs($money) < $info['deposit']) {
            return new ecjia_error('withdraw_error', __('提现金额过大，余额需不低于保证金', 'commission'));
        }
        
        $info['money'] = $info['money'] ? $info['money'] : 0;
        $info['frozen_money'] = $info['frozen_money'] ? $info['frozen_money'] : 0;
        $data = array(
            'money_before' => $info['money'] ? $info['money'] : 0,
            'money' => $info['money'] + $money,
            'platform_profit' => $info['platform_profit'] + $platform_profit,
        );
        if($change_type == 'withdraw') {
            $data['frozen_money'] = $info['frozen_money'] + $money;
            $data['frozen_money'] = $data['frozen_money'] ? $data['frozen_money'] : 0;
        }
        
        if(RC_DB::table('store_account')->where('store_id', $store_id)->update($data)) {
            $log = array(
                'store_id' => $store_id,
                'store_money' => $data['money'],
                'money' => $money,
                'frozen_money' => abs($data['frozen_money']) > 0 ? $data['frozen_money'] : $info['frozen_money'],
                'change_desc' => $change_desc,
                'change_type' => $change_type,
            );
            return self::insert_store_account_log($log);
        }
        
    }
    
    public static function insert_store_account_log($data) {

        if(empty($data['store_id']) || empty($data['change_type'])) {
            return new ecjia_error('invalid_parameter', __('参数无效', 'commission'));
        }
        $data['change_time'] = RC_Time::gmtime();
        return RC_DB::table('store_account_log')->insert($data);
    }
    
}

// end
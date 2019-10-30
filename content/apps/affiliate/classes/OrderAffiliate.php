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
namespace Ecjia\App\Affiliate;

use RC_DB;
use RC_Time;
use ecjia;
use RC_Api;
use RC_Logger;
use RC_Loader;
use ecjia_admin;
use Ecjia\App\Finance\AccountConstant;

/**
 * 普通订单分成
 *
 */
class OrderAffiliate
{

    /**
     * 普通订单分成
     * @param array $options  $options['order_id']订单id  $options['user_id']下单用户id
     * @return bool
     */
    public static function OrderAffiliateDo($options = array()) {
        if (empty($options['user_id']) || empty($options['order_id'])) {
            return new \ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'affiliate'), __CLASS__));
        }

//        RC_Logger::getlogger('info')->info('OrderAffiliateDo');
//        RC_Logger::getlogger('info')->info([
//            'line' => __LINE__,
//            'orderinfo' => json_encode($options)
//        ]);

        $time = RC_Time::gmtime();

        //判断用户上级
        $user_info = RC_DB::table('users')->where('user_id', $options['user_id'])->first();
//        RC_Logger::getlogger('info')->info([
//            'line' => __LINE__,
//            'user_info' => json_encode($user_info)
//        ]);
        $parent_id = $user_info['parent_id'];
        $parent_info = RC_DB::table('users')->where('user_id', $parent_id)->first();
        if(empty($parent_id)) {
            return new \ecjia_error('parent_not_exists', '不存在上级');
        }
        $distributor = RC_DB::table('affiliate_distributor')->where('user_id', $parent_id)->where('expiry_time', '>', $time)->first();
//        RC_Logger::getlogger('info')->info([
//            'line' => __LINE__,
//            'distributor' => json_encode($distributor)
//        ]);
//        if(!empty($distributor)) {
//            //vip分销商
//            $distributor['user_name'] = $parent_info['user_name'];
//            $handel = self::separate_vip($options, $distributor);
//        } else {
            //普通分销
            $handel = self::separate_normal($options, $user_info);
//        }
        if(is_ecjia_error($handel)) {
            RC_Logger::getlogger('error')->error('orderAffiliate:'.$handel->get_error_message());
            return $handel;
        }

        $data = array(
            'is_separate' => '1'
        );
        RC_DB::table('order_info')->where('order_id', $options['order_id'])->update($data);

//        ecjia_admin::admin_log(__('订单号为 ', 'affiliate').$options['order_sn'], 'do', 'affiliate');

        return true;
    }

    //vip分佣
    public static function separate_vip($order_info, $distributor) {
        $affiliate = ecjia::config('affiliate');
        $affiliate = unserialize($affiliate);
        //推荐奖励开启
        if ($affiliate['vip_on'] != '1') {
            return new \ecjia_error('vip_config_off', '未开启VIP推荐分佣');
        }

        //判断订单商品有无vip分佣
        $vip_goods = self::get_order_goods_vip($order_info['order_id'], $distributor['grade_id']);
        if(empty($vip_goods)) {
            return new \ecjia_error('vip_goods_empty', '订单不存在VIP分佣商品');
        }

        //防止重复分佣
        $count = RC_DB::table('affiliate_log')->where('user_id', $distributor['user_id'])->where('order_id', $order_info['order_id'])->count();
        if($count) {
            return new \ecjia_error('alerady_separate', '订单已经分佣');
        }

        $affiliate_amount = self::order_goods_total_affliate_money_vip($vip_goods);

//        RC_Logger::getlogger('info')->info([
//            'line' => __LINE__,
//            'affiliate_amount' => $affiliate_amount
//        ]);

        if ($affiliate_amount > 0) {
            //分成记录
            $log = array(
                'order_id'      => $order_info['order_id'],
                'time'          => RC_Time::gmtime(),
                'user_id'       => $distributor['user_id'],
                'user_name'     => empty($distributor['user_name']) ? '' : $distributor['user_name'],
                'money'         => sprintf("%.2f", $affiliate_amount),
                'separate_type' => 0,
            );
            RC_DB::table('affiliate_log')->insert($log);
        }
    }

    /**
     * 普通分佣
     * @param $options order_info
     * @return \ecjia_error
     */
    public static function separate_normal($options, $user_info) {
        $affiliate = ecjia::config('affiliate');
        $affiliate = unserialize($affiliate);
        //推荐奖励开启
        if ($affiliate['on'] != '1') {
            return new \ecjia_error('config_off', '未开启推荐分佣');
        }

        //商品分成比例
        $affiliate_goods_percent = $affiliate['config']['level_money_all'];
        if(empty($affiliate_goods_percent)) {
            return new \ecjia_error('config_empty', '未设置订单分成总额比');
        }
        if(empty($affiliate['item'])) {
            return new \ecjia_error('config_empty', '未设置不同级别分成比例');
        }

        //普通订单商品
//        $order_goods_list = self::get_order_goods($options['order_id']);

        $total_affiliate_money = self::order_affiliate_money($options, $affiliate_goods_percent); //订单总分佣金额
        //订单特殊商品
//        $order_special_goods_list = self::get_order_special_goods($options['order_id']);
//        $special_affiliate_money  = self::order_goods_total_affliate_money($order_special_goods_list); //订单特殊商品总分佣金额

        //获取下单会员的3级直属上级
        $three_parent_ids = self::get_three_parent_id($options['user_id']);
        //如果当前购买用户没有上级，则直接返回
        // if(empty($three_parent_ids['one'])){
        //     return true;
        // }

//        if ($special_affiliate_money > 0) {
//            //特殊商品分佣
//            self::special_goods_affiliate_do($three_parent_ids, $special_affiliate_money, $options, $store_affiliate_role, $can_affiliate_role);
//        } else {
//        RC_Logger::getlogger('info')->info([
//            'line' => __LINE__,
//            'affiliate_amount' => $total_affiliate_money
//        ]);
//        RC_Logger::getlogger('info')->info([
//            'line' => __LINE__,
//            'three_parent_ids' => json_encode($three_parent_ids)
//        ]);
        if (!empty($three_parent_ids)) {
            foreach ($three_parent_ids as $k => $v) {
                $percent = 0;
                if (!empty($v)) {
                    //防止重复分佣
                    $count = RC_DB::table('affiliate_log')->where('user_id', $v)->where('order_id', $options['order_id'])->count();
                    if($count == 0) {
                        //当前角色的等级，及是第几级直属上级；获取最终分成比例
                        if ($k) {
                            $percent = self::get_percent($k);
                        }

                        $affiliate_amount = $total_affiliate_money * ($percent/100);

                        if ($affiliate_amount > 0) {
                            //分成记录
                            $log = array(
                                'order_id'      => $options['order_id'],
                                'time'          => RC_Time::gmtime(),
                                'user_id'       => $v,
                                'user_name'     => empty($user_info['user_name']) ? '' : $user_info['user_name'],
                                'money'         => sprintf("%.2f", $affiliate_amount),
                                'separate_type' => 0,
                            );
                            RC_DB::table('affiliate_log')->insert($log);
                        }
                    }
                }
            }
        }

//        }


    }

    /**
     * 获取某个会员的所有上级
     * @param int $user_id
     * @return string
     */
    public static function get_parent_id($user_id){
        $pids = '';
        $parent_id = RC_DB::table('users')->where('user_id', $user_id)->pluck('parent_id');
        if( $parent_id != '' ){
            $pids .= $parent_id;
            $npids = self::get_parent_id( $parent_id );
            if(isset($npids))
                $pids .= ','.$npids;
        }
        return $pids;
    }

    /**
     * 获取某个会员的3级直属上级
     * @param int $user_id
     * @return string
     */
    public static function get_three_parent_id($user_id){
        $arr = [];
        $level1_id = RC_DB::table('users')->where('user_id', $user_id)->pluck('parent_id');
        if (!empty($level1_id)) {
            $level2_id = RC_DB::table('users')->where('user_id', $level1_id)->pluck('parent_id');
        }
        if (!empty($level2_id)) {
            $level3_id = RC_DB::table('users')->where('user_id', $level2_id)->pluck('parent_id');
        }
        $result = array('one' => $level1_id, 'two' => $level2_id, 'three' => $level3_id);
        return $result;
    }

    /**
     *
     * @param string $k 第几级直属上级
     * @param string $invite_user 用户角色
     * @param array $affiliate_goods_percent 商品分成比例
     * @return string
     */
    public static function get_percent ($k) {
        $affiliate = ecjia::config('affiliate');
        $affiliate = unserialize($affiliate);

        if ($k == 'one') {//一级上级
            $percent = $affiliate['item'][0]['level_money'];
        } elseif ($k == 'two') {//二级上级
            $percent = $affiliate['item'][1]['level_money'];
        } elseif ($k == 'three') {//三级上级
            $percent = $affiliate['item'][2]['level_money'];
        }
        return $percent ? $percent : 0;
    }

    /**
     * 获取订单商品
     * @param int $order_id
     * @return array
     */
    public static function get_order_goods ($order_id = 0) {
        $field = 'og.*, g.goods_thumb, g.goods_img, g.original_img';

        $order_goods = RC_DB::table('order_goods as og')->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->where(RC_DB::raw('og.order_id'), $order_id)
            ->select(RC_DB::raw($field))
            ->get();
        return $order_goods;
    }


    public static function get_order_goods_vip($order_id = 0, $grade_id = 0) {
        $field = 'og.*, g.goods_thumb, g.goods_img, g.original_img, p.grade_price';

        $order_goods = RC_DB::table('order_goods as og')->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
            ->leftJoin('affiliate_grade_price as p', RC_DB::raw('p.goods_id'), '=', RC_DB::raw('og.goods_id'))
            ->where(RC_DB::raw('og.order_id'), $order_id)
            ->where(RC_DB::raw('p.grade_id'), $grade_id)
            ->select(RC_DB::raw($field))
            ->get();
        return $order_goods;
    }

    /**
     * 获取上级会员id数组
     * @param string $parent_id_string
     */
    public static function get_parent_ids_array($parent_id_string) {
        $parent_id_string = trim($parent_id_string);
        $parent_id_string = substr($parent_id_string, 0, -1);
        $parent_ids = explode(',', $parent_id_string);
        return $parent_ids;
    }

    /**
     * 获取订单所有商品可分成总金额
     * @param array $goods_list
     */
    public static function order_goods_total_affliate_money($order_goods_list = array(), $affiliate_percent = 0) {
        $total_affiliate_money = 0; //订单商品总分佣金额

        if (!empty($order_goods_list)) {
            foreach ($order_goods_list as $value) {
                $affilate_money = 0;
                if ($affiliate_percent > 0) {
                    $affilate_money = $affiliate_percent/100*($value['goods_price'] * $value['goods_number']);
                }
                $total_affiliate_money += $affilate_money;
            }
        }
        return $total_affiliate_money;
    }

    public static function order_affiliate_money($order_info, $affiliate_percent = 0) {
        $total = $order_info['goods_amount'] + $order_info['shipping_fee'] + $order_info['insure_fee'] + $order_info['pay_fee']
            + $order_info['pack_fee'] + $order_info['card_fee'] + $order_info['tax']
            - $order_info['integral_money'] - $order_info['bonus'] - $order_info['discount'];
        return $total * $affiliate_percent / 100;
    }

    public static function order_goods_total_affliate_money_vip($order_goods_list = array()) {
        $total_affiliate_money = 0; //订单商品总分佣金额

        if (!empty($order_goods_list)) {
            foreach ($order_goods_list as $value) {

                $total_affiliate_money += ($value['grade_price'] * $value['goods_number']);
            }
        }
        return $total_affiliate_money;
    }

    /**
     * 更新分成记录金额到账户余额（分成记录金额状态为0的）
     * @param array $affiliate_log
     */
    public static function OrderAffiliateChangeAccount ($affiliate_log, $change_type = AccountConstant::BALANCE_AFFILIATE) {
        //账户变动
        if ($affiliate_log['money'] > 0 && !empty($affiliate_log['user_id']) && !empty($affiliate_log['order_id'])) {
            $change_desc = '推荐订单分成';
            $order_sn = ecjia_order_affiliate_sn();

            /* 变量初始化 */
            $surplus = array(
                'user_id'      => $affiliate_log['user_id'],
                'order_sn'     => $order_sn,
                'process_type' => SURPLUS_AFFILIATE,
                'payment_id'   => 0,
                'user_note'    => $change_desc,
                'amount'       => $affiliate_log['money'],
                'from_type'    => 'system',
                'from_value'   => '',
                'is_paid'      => 1,
            );
            RC_Loader::load_app_func('admin_user', 'finance');
            //插入会员账目明细
            $surplus['account_id'] = insert_user_account($surplus, $affiliate_log['money']);

            $arrs = array(
                'user_id'		=> $affiliate_log['user_id'],
                'user_money'	=> $affiliate_log['money'],
                'change_type'   => $change_type,
                'change_desc'	=> $change_desc
            );
            RC_Api::api('finance', 'account_change_log', $arrs);
            //更新分成记录金额状态
            RC_DB::table('affiliate_log')->where('log_id', $affiliate_log['log_id'])->update(array('separate_type' => 1));
            //更新订单分成状态
            RC_DB::table('order_info')->where('order_id', $affiliate_log['order_id'])->update(array('is_separate' => 1));
            //更新分成统计
            self::update_affiliate_count($affiliate_log['user_id']);
        }
    }

    //更新代理商分成统计
    //affiliate_distributor(order_number_total,order_amount_total)
    public static function update_affiliate_count($user_id) {
        $distributor = RC_DB::table('affiliate_distributor')->where('user_id', $user_id)->first();
        if($distributor) {
            $order_number_total = RC_DB::table('affiliate_log')->where('user_id', $user_id)->where('separate_type', 1)->count();
            $order_amount_total = RC_DB::table('affiliate_log as a')
                ->leftJoin('order_info as o', RC_DB::raw('o.order_id'), '=', RC_DB::raw('a.order_id'))
                ->where(RC_DB::raw('a.user_id'), $user_id)->where('separate_type', 1)
                ->sum(RC_DB::raw('(o.goods_amount + o.shipping_fee + o.insure_fee + o.pay_fee + o.pack_fee + o.card_fee + o.tax - o.integral_money - o.bonus - o.discount)'));
            $data = [
                'order_number_total' => $order_number_total ? $order_number_total : 0,
                'order_amount_total' => $order_amount_total ? $order_amount_total : 0,
            ];
            RC_DB::table('affiliate_distributor')->where('user_id', $user_id)->update($data);
        }
    }

    /**
     * 获取订单特殊商品
     */
    public static function get_order_special_goods ($order_id)
    {
//    	$field = 'og.*, g.affiliate_percent, g.goods_thumb, g.goods_img, g.original_img';
//
//    	$special_goods_id = RC_Loader::load_app_config('special_goods', 'yuemeihouapi');
//
//    	$order_goods = RC_DB::table('order_goods as og')->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
//    						->where(RC_DB::raw('order_id'), $order_id)
//    						->whereIn(RC_DB::raw('og.goods_id'), $special_goods_id)
//    						->select(RC_DB::raw($field))
//    						->get();
//    	return $order_goods;

    }

    /**
     * 特殊商品分成处理
     */
    public static function special_goods_affiliate_do($three_parent_ids, $special_affiliate_money, $options, $store_affiliate_role, $can_affiliate_role)
    {
    }
}

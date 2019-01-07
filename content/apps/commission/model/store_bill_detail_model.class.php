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
 * 账单
 */
class store_bill_detail_model extends Component_Model_Model {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'store_bill_detail';
		parent::__construct();
	}
	/*
	 * brokerage_amount 订单入账时需校验金额是否和订单一致，退货为负数须校验该订单总退货次数所有金额是否超过订单金额
	 * percent_value 根据storeid获取，退货获取订单入账时比例
	 * order_type buy订单,quickpay买单,refund退款
	 * TODO：订单入账时需校验金额是否和订单一致，退货为负数须校验该订单总退货次数所有金额是否超过订单金额
	 * TODO：异常处理，记录
	 * @update20180320:增加订单相关信息信息
	 */

	public function add_bill_detail($data) {
        if (!is_array($data) || !isset($data['order_type']) || empty($data['order_id']) ) {
            return false;
        }

        if($data['order_type'] == 'quickpay') {
            $order_info = RC_DB::table('quickpay_orders')->where('order_id', $data['order_id'])->first();
            $data['order_sn'] = $order_info['order_sn'];
        } else if($data['order_type'] == 'refund') {
            $order_info = RC_DB::table('refund_order')->where('refund_id', $data['order_id'])->first();
            $data['order_sn'] = $order_info['refund_sn'];//退款单号
        } else if($data['order_type'] == 'buy') {
            RC_Loader::load_app_func('admin_order', 'orders');
            $order_info = order_info($data['order_id']);
            $data['order_sn'] = $order_info['order_sn'];
        } else {
            //超出范围
            RC_Logger::getLogger('bill_order_error')->error("commission/model/store_bill_detail_model-line:".__LINE__);
            RC_Logger::getLogger('bill_order_error')->error('订单类型超出范围，order_id:'.$data['order_id']);
            return false;
        }
        
        if (empty($order_info)) {
            RC_Logger::getLogger('bill_order_error')->error('订单信息空:');
            RC_Logger::getLogger('bill_order_error')->error($data);
            return false;
        }
        if ($data['order_type'] == 'buy' && RC_DB::table('store_bill_detail')->where('order_id', $data['order_id'])->where('order_type', 'buy')->count()) {
            RC_Logger::getLogger('bill_order_error')->error('重复入账');
            RC_Logger::getLogger('bill_order_error')->error($data);
            return false;
        }
        
        if (!isset($data['store_id'])) {
            $data['store_id'] = $order_info['store_id'];
        }
        
        $data['goods_amount'] = $order_info['goods_amount'];
        $data['shipping_fee'] = $order_info['shipping_fee'] ? $order_info['shipping_fee'] : 0;
        $data['insure_fee'] = $order_info['insure_fee'] ? $order_info['insure_fee'] : 0;
        $data['pay_fee'] = $order_info['pay_fee'] ? $order_info['pay_fee'] : 0;
        $data['pack_fee'] = $order_info['pack_fee'] ? $order_info['pack_fee'] : 0;
        $data['card_fee'] = $order_info['card_fee'] ? $order_info['card_fee'] : 0;
        $data['surplus'] = $order_info['surplus'];
        $data['integral'] = $order_info['integral'];
        $data['integral_money'] = $order_info['integral_money'];
        $data['bonus'] = $order_info['bonus'];
        $data['discount'] = $order_info['discount'];
        $data['inv_tax'] = $order_info['tax'] ? $order_info['tax'] : 0;
        $data['money_paid'] = $order_info['money_paid'] ? $order_info['money_paid'] : 0;
        $data['pay_code'] = $order_info['pay_code'] ? $order_info['pay_code'] : '';
        $data['pay_name'] = $order_info['pay_name'] ? $order_info['pay_name'] : '';
        //订单金额 付款+余额消耗+积分抵钱
        if($data['order_type'] == 'quickpay') {
            $data['order_amount'] = $order_info['goods_amount'] - $order_info['discount'] - $order_info['integral_money'] - $order_info['bonus'];
        } else {
            //众包配送，运费不参与商家结算 @update 20180606
            if($order_info['shipping_code'] == 'ship_ecjia_express') {
                $data['order_amount'] = $order_info['money_paid'] + $order_info['surplus'] + $order_info['integral_money'] - $order_info['shipping_fee'];
            } else {
                $data['order_amount'] = $order_info['money_paid'] + $order_info['surplus'] + $order_info['integral_money'];
            }
            
        }
        if ($data['order_type'] == 'buy') {
            $data['percent_value'] = RC_Model::model('commission/store_franchisee_model')->get_store_commission_percent($data['store_id']);
            if (empty($data['percent_value'])) {
                $data['percent_value'] = 100; //未设置分成比例，默认100
            }
            
            //众包配送，运费不参与商家结算 @update 20180606
            if($order_info['shipping_code'] == 'ship_ecjia_express') {
                if(in_array($data['pay_code'], array('pay_cod', 'pay_cash'))) {
                    $data['brokerage_amount'] = $data['order_amount'] * (100 - $data['percent_value']) / 100 * -1;
                    $data['platform_profit'] = $data['brokerage_amount'] * -1;
                } else {
                    $data['brokerage_amount'] = $data['order_amount'] * $data['percent_value'] / 100;
                    $data['platform_profit'] = $data['order_amount'] - $data['brokerage_amount'];
                }
            } else {
                //运费不参与分佣 @update 20181210
                if(in_array($data['pay_code'], array('pay_cod', 'pay_cash'))) {
                    $data['brokerage_amount'] = (($data['order_amount'] - $data['shipping_fee'] - $data['insure_fee']) * (100 - $data['percent_value']) / 100 + $data['shipping_fee'] + $data['insure_fee']) * -1;
                    $data['platform_profit'] = $data['brokerage_amount'] * -1;
                } else {
                    $data['brokerage_amount'] = ($data['order_amount'] - $data['shipping_fee'] - $data['insure_fee']) * $data['percent_value'] / 100 + $data['shipping_fee'] + $data['insure_fee'];
                    $data['platform_profit'] = $data['order_amount'] - $data['brokerage_amount'];
                }
            }
            
        } else if ($data['order_type'] == 'refund') {
            //退款时 $data['order_id']是 refund_id
            if ($data['brokerage_amount']) {
                //退货时 结算比例使用当时入账比例
//                 $data['percent_value'] = $this->get_bill_percent($data['order_id']);
//                 if (!$data['percent_value']) {
//                     RC_Logger::getLogger('bill_order')->error('退货未找到原入账订单，订单号：'.$data['order_id']);
//                     RC_Logger::getLogger('bill_order')->error($data);
//                     return false;
//                 }
//                 if (($data['brokerage_amount'] = $data['order_amount'] * $data['percent_value'] / 100) > 0) {
//                     $data['brokerage_amount'] *= -1;
//                 }
            } else {
                $datail = $this->get_bill_detail($order_info['order_id']);
                if (empty($datail)) {
                    //删除队列表数据
                    RC_DB::table('store_bill_queue')->where('order_type', $data['order_type'])->where('order_id', $data['order_id'])->delete();
                    RC_Logger::getLogger('bill_order')->info('退款refund_id:'.$data['order_id'].'，未收货，未入账，结算无需退款');
                    return false;
                }
                $back_money_total = RC_DB::table('refund_payrecord')->where('refund_id', $data['order_id'])->pluck('back_money_total');
                $back_money_total = $back_money_total > 0 ? $back_money_total : $back_money_total * -1;
                $data['percent_value'] = $datail['percent_value'];
                //退款结算：平台得-用户退=商家得
                $data['brokerage_amount'] = $datail['platform_profit'] - $back_money_total;
                $data['platform_profit'] = $datail['platform_profit'] * -1;
            }
        } else if ($data['order_type'] == 'quickpay') {
            $data['percent_value'] = 100 - ecjia::config('quickpay_fee');
            if ($data['percent_value'] > 100) {
                RC_Logger::getLogger('bill_order_error')->error('quickpay_fee超出范围：');
                RC_Logger::getLogger('bill_order_error')->error($data);
                return false;
            }
            if(in_array($data['pay_code'], array('pay_cod', 'pay_cash'))) {
                $data['brokerage_amount'] = $data['order_amount'] * (100 - $data['percent_value']) / 100 * -1;
                $data['platform_profit'] = $data['brokerage_amount'] * -1;
            } else {
                $data['brokerage_amount'] = $data['order_amount'] * $data['percent_value'] / 100;
                $data['platform_profit'] = $data['order_amount'] - $data['brokerage_amount'];
            }
        }

        $data['add_time'] = RC_Time::gmtime();
//         RC_Logger::getLogger('info')->info($data);

        $status = false;
        RC_DB::transaction(function () use ($data, &$status){
            
            $datail_id = RC_DB::table('store_bill_detail')->insertGetId($data);
            if($datail_id) {
                //TODO每成功后结算一次
                RC_Loader::load_app_class('store_account', 'commission');
                $account = array(
                    'store_id' => $data['store_id'],
                    'amount' => $data['brokerage_amount'],
                    'bill_order_type' => $data['order_type'],
                    'bill_order_id' => $data['order_id'],
                    'bill_order_sn' => $data['order_sn'],
                    'platform_profit' => $data['platform_profit'],
                );
                $rs_account = store_account::bill($account);
                if ($rs_account && !is_ecjia_error($rs_account)) {
                    RC_DB::table('store_bill_detail')->where('detail_id', $datail_id)->update(array('bill_status' => 1, 'bill_time' => RC_Time::gmtime()));
                    //删除队列表数据
                    RC_DB::table('store_bill_queue')->where('order_type', $data['order_type'])->where('order_id', $data['order_id'])->delete();
                } else {
                    RC_DB::rollBack();
                }
                $status = true;
            }
            $status = false;
        });
        
	    return $status;
	}

	//计算日账单,分批处理数据
	public function count_bill_day($options) {
	    
        $day_time = RC_Time::local_strtotime($options['day']);
        
	    $rs_order = RC_DB::table('store_bill_detail')->select("store_id", RC_DB::raw("'".$options['day']."' as day"), RC_DB::raw('COUNT(store_id) as order_count'), RC_DB::raw('SUM(brokerage_amount) as order_amount'),
	        RC_DB::raw('0 as refund_count'), RC_DB::raw('0.00 as refund_amount'), 'percent_value')
	    ->whereBetween('add_time', array($day_time, $day_time + 86399))
	    ->where(function ($query) {
	        $query->where('order_type', 'buy')
	        ->orWhere('order_type', 'quickpay');
	    })
	    ->groupBy('store_id')
	    ->get();

	    $rs_refund = RC_DB::table('store_bill_detail')->groupBy('store_id')->select("store_id", RC_DB::raw("'".$options['day']."' as day"),RC_DB::raw('COUNT(store_id) as refund_count'), RC_DB::raw('SUM(brokerage_amount) as refund_amount'),
	        RC_DB::raw('0 as order_count'), RC_DB::raw('0.00 as order_amount'), 'percent_value')
	    ->whereBetween('add_time', array($day_time, $day_time + 86399))->where('order_type', 'refund')->get();
	    
	    $rs_refund = self::formate_array($rs_refund, 'store_id');
// 	    _dump($rs_order);
// 	    _dump($rs_refund,1);
// 	    RC_Logger::getLogger('info')->info($val);
	    //获取结算店铺列表
	    if ($rs_order) {
	        foreach ($rs_order as $key => $val) {
                if ($rs_refund && $rs_refund[$val['store_id']]) {
                    $rs_order[$key]['refund_count'] = $rs_refund[$val['store_id']]['refund_count'];
                    $rs_order[$key]['refund_amount'] = $rs_refund[$val['store_id']]['refund_amount'];
                    $rs_order[$key]['brokerage_amount'] = $val['order_amount'] + $rs_refund[$val['store_id']]['refund_amount'];
                } else {
                    $rs_order[$key]['brokerage_amount'] = $val['order_amount'];
                }
	            $rs_order[$key]['add_time'] = RC_Time::gmtime();
	        }
	        return $rs_order;
	    } else {
	        if ($rs_refund) {
	            foreach ($rs_refund as $key => $val) {
                    $rs_refund[$key]['brokerage_amount'] = $val['refund_amount'];
	                $rs_refund[$key]['add_time'] = RC_Time::gmtime();
	            }
	            return $rs_refund;
	        }
	        return array();
	    }
	   
	}
	
	public function get_bill_percent($order_id) {
	    $rs = RC_DB::table('store_bill_detail')->where('order_id', $order_id)->where('order_type', 'buy')->first();
	    return $rs['percent_value'];
	}
	
	public function get_bill_detail($order_id) {
	    $rs = RC_DB::table('store_bill_detail')->where('order_id', $order_id)->where('order_type', 'buy')->first();
	    return $rs;
	}

	public function get_bill_record($store_id = 0, $page = 1, $page_size = 15, $filter = array(), $is_admin = 0) {
	    $db_bill_detail = RC_DB::table('store_bill_detail as bd')
	    ->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('bd.store_id'));
// 	    ->leftJoin('order_info as oi', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('bd.order_id'));

	    if ($store_id) {
	        $db_bill_detail->whereRaw('bd.store_id ='.$store_id);
	    }

	    if (!empty($filter['order_sn'])) {
	        $db_bill_detail->whereRaw('bd.order_sn ='.$filter['order_sn']);
	    }
	    if (!empty($filter['merchant_keywords'])) {
	        $db_bill_detail->whereRaw("s.merchants_name like'%".$filter['merchant_keywords']."%'");
	    }
	    if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
	        $db_bill_detail->whereRaw("(bd.add_time BETWEEN ".$filter['start_date']." AND ".$filter['end_date'].')');
	    } else {
	        if (!empty($filter['start_date']) && empty($filter['end_date'])) {
	            $db_bill_detail->whereRaw('bd.add_time >= '.$filter['start_date']);
	        }
	        if (empty($filter['start_date']) && !empty($filter['end_date'])) {
	            $db_bill_detail->whereRaw('bd.add_time <='.$filter['end_date']);
	        }
	    }
  
	    $count = $db_bill_detail->count('detail_id');
	    if($is_admin) {
	        $page = new ecjia_page($count, $page_size, 3);
	    } else {
	        $page = new ecjia_merchant_page($count, $page_size, 3);
	    }
	    $fields .= " bd.*,bd.order_amount as total_fee,s.merchants_name";
	    $row = $db_bill_detail
		    ->select(RC_DB::raw($fields))
		    ->take($page_size)
		    ->orderBy(RC_DB::raw('bd.add_time'), 'desc')
		    ->skip($page->start_id-1)
		    ->get();
	    
	    if ($row) {
	        foreach ($row as $key => $val) {
	            if(empty($val['order_sn'])) {
	                //原有数据做兼容
	                if($val['order_type'] == 'quickpay') {
	                    //优惠买单订单
	                    $order_info = RC_DB::table('quickpay_orders')->where('order_id', $val['order_id'])->
	                    select('order_sn','order_amount as total_fee')->first();
	                    $order_info['buyer'] = RC_DB::table('users')->where('user_id', $order_info['user_id'])->pluck('user_name as buyer');
	                    $row[$key] = array_merge($row[$key], $order_info);
	                } elseif ($val['order_type'] == 'buy' || $val['order_type'] == 'refund') {
	                    //普通订单（含退款）
	                    $db_order_info = RC_DB::table('order_info as oi');
	                    $fields = " oi.order_sn, oi.order_amount, oi.money_paid,";
	                    $fields .= " (money_paid + surplus + integral_money) AS total_fee ";
	                    $order_info = $db_order_info->where('order_id', $val['order_id'])->select(RC_DB::raw($fields))->first();
	                    $row[$key] = array_merge($row[$key], $order_info);
	                } else {
	                    RC_Logger::getLogger('info')->info('store_bill_error:');
	                    RC_Logger::getLogger('info')->info($val);
	                    continue;
	                }
	            }
	            //分成金额=订单金额-运费-保价费
	            $row[$key]['commission_fee'] = $row[$key]['total_fee'] - $row[$key]['shipping_fee'] - $row[$key]['insure_fee'];
	            $row[$key]['commission_fee'] = number_format($row[$key]['commission_fee'], 2, '.', '');
	        	$row[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $row[$key]['add_time']);
	        	$row[$key]['bill_time'] = RC_Time::local_date('Y-m-d H:i:s', $row[$key]['bill_time']);

	        	if($val['order_type'] == 'buy') {
	        		$row[$key]['order_type_name'] = '购物订单';
	        	} elseif ($val['order_type'] == 'refund') {
	        		$row[$key]['order_type_name'] = '退款';
// 	        		$row[$key]['order_type_name_style'] = '<span class="ecjiafc-red">退款</span>';
	        	} elseif ($val['order_type'] == 'quickpay'){
	        		$row[$key]['order_type_name'] = '优惠买单';
	        	} else {
	        	    $row[$key]['order_type_name'] = '未知';
	        	}
	        }
	    }
	    return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
	
	public function formate_array($data, $newKey) {
	    $newArray = array();
	    if($data) {
	        foreach ($data as $val) {
	            $newArray[$val[$newKey]] = $val;
	        }
	        return $newArray;
	    }
	    return $data;
	}
}

// end

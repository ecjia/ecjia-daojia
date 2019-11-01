<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-05
 * Time: 16:50
 */

namespace Ecjia\App\User;

use ecjia_region;
use ecjia_error;
use ecjia;
use RC_Loader;
use RC_DB;
use RC_Api;
use RC_Upload;
use RC_Time;
use RC_Model;
use RC_Ip;

class UserInfoFunction
{

    /**
     * 取得用户信息
     * @param   int $user_id 用户id
     * @return  array|ecjia_error   用户信息
     */
    public static function user_info($user_id, $mobile = '')
    {
        if (!empty($user_id)) {
            $user = RC_DB::table('users')->where('user_id', $user_id)->first();
        } elseif (!empty($mobile)) {
            $user = RC_DB::table('users')->where('mobile_phone', $mobile)->first();
        }

        if (empty($user)) {
            return new ecjia_error('userinfo_error', '用户信息不存在！');
        }

        unset($user['question']);
        unset($user['answer']);
        /* 格式化帐户余额 */
        if ($user) {
            $user['formated_user_money']   = price_format($user['user_money'], false);
            $user['formated_frozen_money'] = price_format($user['frozen_money'], false);
        }
        return $user;
    }

    /**
     * 生成查询订单的sql
     * @param   string $type 类型
     * @param   string $alias order表的别名（包括.例如 o.）
     * @return  string
     */
    public static function EM_order_query_sql($type = 'finished', $alias = '')
    {
        /* 已完成订单 */
        if ($type == 'finished') {
            return "{$alias}order_status " . ecjia_db_create_in(array(OS_CONFIRMED, OS_SPLITED)) . " AND {$alias}shipping_status " . ecjia_db_create_in(array(SS_RECEIVED)) . " AND {$alias}pay_status " . ecjia_db_create_in(array(PS_PAYED, PS_PAYING)) . " ";
        } elseif ($type == 'await_ship') {
            /* 待发货订单 */
            return "{$alias}order_status " . ecjia_db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) . " AND   {$alias}shipping_status " . ecjia_db_create_in(array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) . " AND ( {$alias}pay_status " . ecjia_db_create_in(array(PS_PAYED, PS_PAYING)) . " OR {$alias}pay_id " . ecjia_db_create_in(self::payment_id_list(true)) . ") ";
        } elseif ($type == 'await_pay') {
            /* 待付款订单 */
            return "{$alias}order_status " . ecjia_db_create_in(array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) . " AND   {$alias}pay_status = '" . PS_UNPAYED . "'" . " AND ( {$alias}shipping_status " . ecjia_db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " OR {$alias}pay_id " . ecjia_db_create_in(self::payment_id_list(false)) . ") ";
        } elseif ($type == 'unconfirmed') {
            /* 未确认订单 */
            return "{$alias}order_status = '" . OS_UNCONFIRMED . "' ";
        } elseif ($type == 'unprocessed') {
            /* 未处理订单：用户可操作 */
            return "{$alias}order_status " . ecjia_db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) . " AND {$alias}shipping_status = '" . SS_UNSHIPPED . "'" . " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
        } elseif ($type == 'unpay_unship') {
            /* 未付款未发货订单：管理员可操作 */
            return "{$alias}order_status " . ecjia_db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) . " AND {$alias}shipping_status " . ecjia_db_create_in(array(SS_UNSHIPPED, SS_PREPARING)) . " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
        } elseif ($type == 'shipped') {
            /* 已发货订单：不论是否付款 */
            return "{$alias}shipping_status " . ecjia_db_create_in(array(SS_SHIPPED)) . " AND {$alias}order_status != '" . OS_RETURNED . "'";
        } else {
            //@todo return new ecjia_error()
            die('函数 order_query_sql 参数错误');
        }
    }

    /**
     * 取得支付方式id列表
     * @param   bool    $is_cod 是否货到付款
     * @return  array
     */
    public static function payment_id_list($is_cod) {
        $db_payment = RC_DB::table('payment');
        if ($is_cod) {
            // $where = "is_cod = 1" ;
            $db_payment->where('is_cod', 1);

        } else {
            // $where = "is_cod = 0" ;
            $db_payment->where('is_cod', 0);
        }
        // $row = $this->db->field('pay_id')->where($where)->select();
        $row = $db_payment->select('pay_id')->get();

        $arr = array();
        if(!empty($row) && is_array($row)) {
            foreach ($row as $val) {
                $arr[] = $val['pay_id'];
            }
        }

        return $arr;
    }

    public static function EM_user_info($user_id, $mobile = '')
    {
        $user_info = self::user_info($user_id, $mobile);

        if (is_ecjia_error($user_info)) {
            return $user_info;
        }

        $collection_num = RC_DB::table('collect_goods')->where('user_id', $user_id)->orderBy('add_time', 'desc')->count();
        //收藏店铺数
        $collect_store_num = RC_DB::table('collect_store')->where('user_id', $user_id)->count();

        $db1 = RC_DB::table('order_info');
        /*货到付款订单不在待付款里显示*/
        $pay_cod_id = RC_DB::table('payment')->where('pay_code', 'pay_cod')->value('pay_id');
        if (!empty($pay_cod_id)) {
            $db1->where('pay_id', '!=', $pay_cod_id);
        }
        $await_pay  = $db1->where('user_id', $user_id)->where('extension_code', '!=', "group_buy")->where('pay_status', PS_UNPAYED)->whereIn('order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED))->count();
        $await_ship = RC_DB::table('order_info')->where('user_id', $user_id)->where('extension_code', '!=', "group_buy")->whereRaw(self::EM_order_query_sql('await_ship', ''))->count();
        $shipped    = RC_DB::table('order_info')->where('user_id', $user_id)->where('extension_code', "!=", "group_buy")->whereRaw(self::EM_order_query_sql('shipped', ''))->count();
        $finished   = RC_DB::table('order_info')->where('user_id', $user_id)->whereIn('order_status', array(OS_CONFIRMED, OS_SPLITED))
            ->whereIn('shipping_status', array(SS_RECEIVED))
            ->whereIn('pay_status', array(PS_PAYED, PS_PAYING))
            ->where('extension_code', "!=", "group_buy")
            ->count();

        $db_allow_comment = RC_DB::table('order_info as oi')
            ->leftJoin('order_goods as og', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('og.order_id'))
            ->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('og.goods_id'))
            ->leftJoin('comment as c', function ($join) {
                $join->on(RC_DB::raw('c.id_value'), '=', RC_DB::raw('og.goods_id'))
                    ->on(RC_DB::raw('og.rec_id'), '=', RC_DB::raw('c.rec_id'))
                    ->on(RC_DB::raw('c.order_id'), '=', RC_DB::raw('oi.order_id'))
                    ->where(RC_DB::raw('c.parent_id'), '=', 0)
                    ->where(RC_DB::raw('c.comment_type'), '=', 0);
            });

        $allow_comment_count = $db_allow_comment
            ->where(RC_DB::raw('oi.user_id'), $user_id)
            ->where(RC_DB::raw('oi.extension_code'), "!=", "group_buy")
            ->where(RC_DB::raw('oi.shipping_status'), SS_RECEIVED)
            ->whereIn(RC_DB::raw('oi.order_status'), array(OS_CONFIRMED, OS_SPLITED))
            ->whereIn(RC_DB::raw('oi.pay_status'), array(PS_PAYED, PS_PAYING))
            ->whereRaw(RC_DB::raw('c.comment_id is null'))
            ->select(RC_DB::Raw('count(DISTINCT oi.order_id) as counts'))->get();
        $allow_comment_count = $allow_comment_count['0']['counts'];
        //申请售后数
        $refund_order = RC_DB::table('refund_order')->where('user_id', $_SESSION['user_id'])
            ->whereRaw('status != 10 and refund_status != 2')
            ->count();

        if ($user_info['user_rank'] == 0) {
            //重新计算会员等级
            $now_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user_id));
        } else {
            //用户等级更新，不用计算，直接读取
            $now_rank = RC_DB::table('user_rank')->where('rank_id', $user_info['user_rank'])->first();
        }

        $user_info['user_rank_name'] = $now_rank['rank_name'];
        $user_info['user_rank_id']   = $now_rank['rank_id'];
        $level                       = 1;
        if ($now_rank['special_rank'] == 0 && $now_rank['min_points'] == 0) {
            $level = 0;
        }

        if (empty($user_info['avatar_img'])) {
            $avatar_img = '';
        } else {
            $avatar_img = RC_Upload::upload_url($user_info['avatar_img']);
        }

        $user_info['user_name'] = preg_replace('/<span(.*)span>/i', '', $user_info['user_name']);

        /* 获取可使用的红包数量*/
        $dbview = RC_DB::table('bonus_type as bt')->leftJoin('user_bonus as ub', RC_DB::raw('bt.type_id'), '=', RC_DB::raw('ub.bonus_type_id'));
        $time   = RC_Time::gmtime();

        $bonus_count = $dbview->where(RC_DB::raw('ub.user_id'), $user_id)
            ->where(RC_DB::raw('use_start_date'), '<', $time)
            ->where(RC_DB::raw('use_end_date'), '>', $time)
            ->where(RC_DB::raw('ub.order_id'), 0)
            ->count(RC_DB::raw('ub.bonus_id'));
        /* 判断会员名更改时间*/
        $username_update_time = RC_DB::table('term_meta')->where('object_type', 'ecjia.user')
            ->where('object_group', 'update_user_name')
            ->where('object_id', $user_id)
            ->where('meta_key', 'update_time')
            ->first();


        $address              = $user_info['address_id'] > 0 ? RC_DB::table('user_address')->where('address_id', $user_info['address_id'])->first() : '';
        $user_info['address'] = $user_info['address_id'] > 0 ? ecjia_region::getRegionName($address['city']) . ecjia_region::getRegionName($address['district']) . ecjia_region::getRegionName($address['street']) . $address['address'] : '';

        /*返回connect_user表中open_id和token*/
        $open_id         = RC_DB::table('connect_user')->where('user_id', $user_id)->where('user_type', 'user')->where('connect_code', 'app')->value('open_id');
        $connect_appuser = (new \Ecjia\App\Connect\Plugins\EcjiaSyncAppUser($open_id, 'user'))->setUserId($user_id)->getEcjiaAppUser();

        return array(
            'id'                   => $user_info['user_id'],
            'name'                 => $user_info['user_name'],
            'rank_id'              => $user_info['user_rank_id'],
            'rank_name'            => $user_info['user_rank_name'],
            'rank_level'           => $level,
            'collection_num'       => $collection_num,
            'collect_store_num'    => $collect_store_num,
            'email'                => $user_info['email'],
            'mobile_phone'         => $user_info['mobile_phone'],
            'address'              => $user_info['address'],
            'avatar_img'           => $avatar_img,
            'order_num'            => array(
                'await_pay'     => $await_pay,
                'await_ship'    => $await_ship,
                'shipped'       => $shipped,
                'finished'      => $finished,
                'allow_comment' => $allow_comment_count,
                'refund_order'  => $refund_order
            ),
            'user_money'           => $user_info['user_money'],
            'formated_user_money'  => price_format($user_info['user_money'], false),
            'user_points'          => $user_info['pay_points'],
            'user_bonus_count'     => $bonus_count,
            'reg_time'             => empty($user_info['reg_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $user_info['reg_time']),
            'update_username_time' => empty($username_update_time) ? '' : RC_Time::local_date(ecjia::config('time_format'), $username_update_time['meta_value']),
            'open_id'              => $connect_appuser->open_id ? $connect_appuser->open_id : '',
            'access_token'         => $connect_appuser->access_token ? $connect_appuser->access_token : '',
            'refresh_token'        => $connect_appuser->refresh_token ? $connect_appuser->refresh_token : '',
            'user_type'            => 'user',
            'has_paypassword'      => empty($user_info['pay_password']) ? 0 : 1,
            'account_status'       => $user_info['account_status'],
            'delete_time'          => $user_info['delete_time'] > 0 ? RC_Time::local_date('Y/m/d H:i:s O', $user_info['delete_time']) : '',
        );
    }


    /**
     * 更新用户SESSION,COOKIE及登录时间、登录次数。
     *
     * @access public
     * @return bool
     */
    public static function update_user_info()
    {
        if (!$_SESSION['user_id']) {
            return false;
        }

        /* 查询会员信息 */
        $time = RC_Time::gmtime();

        $row = RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->first();
        if ($row) {
            /* 更新SESSION */
            $_SESSION['last_time']  = RC_Time::local_date('Y-m-d H:i:s', $row['last_login']);
            $_SESSION['last_ip']    = $row['last_ip'];
            $_SESSION['login_fail'] = 0;
            $_SESSION['email']      = $row['email'];
            
            if ($row['user_rank'] == 0) {
            	//重新计算会员等级
            	$now_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $_SESSION['user_id']));
            } else {
            	//用户等级更新，不用计算，直接读取
            	$now_rank = RC_DB::table('user_rank')->where('rank_id', $row['user_rank'])->first();
            }
            
            if (!empty($now_rank)) {
            	$_SESSION['user_rank'] = $now_rank['rank_id'];
            	$_SESSION['discount']  = $now_rank['discount'] / 100;
            } else {
            	$_SESSION['user_rank'] = 0;
            	$_SESSION['discount']  = 1;
            }
        }

        /* 更新登录时间，登录次数及登录ip */
        $data = array(
            'visit_count' => $row['visit_count'] + 1,
            'last_ip'     => RC_Ip::client_ip(),
            'last_login'  => RC_Time::gmtime()
        );
        RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->update($data);
    }

	/**
	 * 获取用户待付款订单数
	 * @param int $user_id
	 * @return int
	 */
    public static function await_pay_num($user_id, $store_id = 0)
    {
    	$db1 = RC_DB::table('order_info');
    	if (!empty($store_id)) {
    		$db1->where('store_id', $store_id);
    	}
    	/*货到付款订单不在待付款里显示*/
    	$pay_cod_id = RC_DB::table('payment')->where('pay_code', 'pay_cod')->value('pay_id');
    	if (!empty($pay_cod_id)) {
    		$db1->where('pay_id', '!=', $pay_cod_id);
    	}
    	$await_pay  = $db1->where('user_id', $user_id)->where('extension_code', '!=', "group_buy")->where('pay_status', PS_UNPAYED)->whereIn('order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED))->count();
    	
    	return $await_pay;
    }
    
    /**
     * 获取用户待发货订单数
     * @param int $user_id
     * @return int
     */
    public static function await_ship_num($user_id, $store_id = 0)
    {
    	$db = RC_DB::table('order_info');
    	if (!empty($store_id)) {
    		$db->where('store_id', $store_id);
    	}
    	$await_ship = $db->where('user_id', $user_id)->where('extension_code', '!=', "group_buy")->whereRaw(self::EM_order_query_sql('await_ship', ''))->count();
		return $await_ship;
    }
    
    /**
     * 获取用户已发货的订单数量
     * @param int $user_id
     * @return int
     */
    public static function shipped_num($user_id, $store_id = 0)
    {
    	$db = RC_DB::table('order_info');
    	if (!empty($store_id)) {
    		$db->where('store_id', $store_id);
    	}
    	
    	$shipped = $db->where('user_id', $user_id)->where('extension_code', "!=", "group_buy")->whereRaw(self::EM_order_query_sql('shipped', ''))->count();
		return $shipped;
    }
    
    /**
     * 获取用户已完成的订单数
     * @param int $user_id
     * @return int
     */
    public static function finished_num($user_id, $store_id = 0)
    {
    	$db = RC_DB::table('order_info');
    	if (!empty($store_id)) {
    		$db->where('store_id', $store_id);
    	}
    	
    	$finished   = $db->where('user_id', $user_id)->whereIn('order_status', array(OS_CONFIRMED, OS_SPLITED))
    	->whereIn('shipping_status', array(SS_RECEIVED))
    	->whereIn('pay_status', array(PS_PAYED, PS_PAYING))
    	->where('extension_code', "!=", "group_buy")
    	->count();
    	
    	return $finished;
    }
    
    /**
     * 获取用户允许评论的订单数
     * @param int $user_id
     * @return int
     */
    public static function allow_comment_num($user_id, $store_id = 0)
    {
    	$db_allow_comment = RC_DB::table('order_info as oi')
    	->leftJoin('order_goods as og', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('og.order_id'))
    	->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('og.goods_id'))
    	->leftJoin('comment as c', function ($join) {
    		$join->on(RC_DB::raw('c.id_value'), '=', RC_DB::raw('og.goods_id'))
    		->on(RC_DB::raw('og.rec_id'), '=', RC_DB::raw('c.rec_id'))
    		->on(RC_DB::raw('c.order_id'), '=', RC_DB::raw('oi.order_id'))
    		->where(RC_DB::raw('c.parent_id'), '=', 0)
    		->where(RC_DB::raw('c.comment_type'), '=', 0);
    	});
    	
    	$allow_comment_count = $db_allow_comment
    		->where(RC_DB::raw('oi.user_id'), $user_id)
    		->where(RC_DB::raw('oi.extension_code'), "!=", "group_buy")
    		->where(RC_DB::raw('oi.shipping_status'), SS_RECEIVED)
    		->whereIn(RC_DB::raw('oi.order_status'), array(OS_CONFIRMED, OS_SPLITED))
    		->whereIn(RC_DB::raw('oi.pay_status'), array(PS_PAYED, PS_PAYING))
    		->whereRaw(RC_DB::raw('c.comment_id is null'));
    	
    	//store_id
    	if (!empty($store_id)) {
    		$allow_comment_count->where(RC_DB::raw('oi.store_id'), $store_id);
    	}
    	$allow_comment_count = $db_allow_comment->select(RC_DB::Raw('count(DISTINCT oi.order_id) as counts'))->get();
    	
    	$allow_comment_count = $allow_comment_count['0']['counts'];
    	
    	return $allow_comment_count;
    }
    
    /**
     * 获取用户申请退款订单数
     * @param int $user_id
     * @return int
     */
    public static function refund_order_num($user_id, $store_id = 0)
    {
    	//申请售后数
    	$db = RC_DB::table('refund_order');
    	if (!empty($store_id)) {
    		$db->where('store_id', $store_id);
    	}
    	$refund_order = $db->where('user_id', $user_id)
    	->whereRaw('status != 10 and refund_status != 2')
    	->count();
    	
    	return $refund_order;
    }
    

}
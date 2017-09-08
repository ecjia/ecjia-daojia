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
 * 取得图表颜色
 *
 * @access  public
 * @param   integer $n  颜色顺序
 * @return  void
 */
function chart_color($n) {
    /* 随机显示颜色代码 */
    $arr = array('33FF66', 'FF6600', '3399FF', '009966', 'CC3399', 'FFCC33', '6699CC', 'CC3366', '33FF66', 'FF6600', '3399FF');
    if ($n > 8) {
        $n = $n % 8;
    }
    return $arr[$n];
}
/**
 * 过滤和排序所有分类，返回一个带有缩进级别的数组
 *
 * @access private
 * @param int $cat_id
 *        	上级分类ID
 * @param array $arr
 *        	含有所有分类的数组
 * @param int $level
 *        	级别
 * @return void
 */
function cat_options($spec_cat_id, $arr) {
    static $cat_options = array();
    if (isset($cat_options[$spec_cat_id])) {
        return $cat_options[$spec_cat_id];
    }
    if (!isset($cat_options[0])) {
        $level = $last_cat_id = 0;
        $options = $cat_id_array = $level_array = array();
        $data = false;
        if ($data === false) {
            while (!empty($arr)) {
                foreach ($arr as $key => $value) {
                    $cat_id = $value['cat_id'];
                    if ($level == 0 && $last_cat_id == 0) {
                        if ($value['parent_id'] > 0) {
                            break;
                        }
                        $options[$cat_id] = $value;
                        $options[$cat_id]['level'] = $level;
                        $options[$cat_id]['id'] = $cat_id;
                        $options[$cat_id]['name'] = $value['cat_name'];
                        unset($arr[$key]);
                        if ($value['has_children'] == 0) {
                            continue;
                        }
                        $last_cat_id = $cat_id;
                        $cat_id_array = array($cat_id);
                        $level_array[$last_cat_id] = ++$level;
                        continue;
                    }
                    if ($value['parent_id'] == $last_cat_id) {
                        $options[$cat_id] = $value;
                        $options[$cat_id]['level'] = $level;
                        $options[$cat_id]['id'] = $cat_id;
                        $options[$cat_id]['name'] = $value['cat_name'];
                        unset($arr[$key]);
                        if ($value['has_children'] > 0) {
                            if (end($cat_id_array) != $last_cat_id) {
                                $cat_id_array[] = $last_cat_id;
                            }
                            $last_cat_id = $cat_id;
                            $cat_id_array[] = $cat_id;
                            $level_array[$last_cat_id] = ++$level;
                        }
                    } elseif ($value['parent_id'] > $last_cat_id) {
                        break;
                    }
                }
                $count = count($cat_id_array);
                if ($count > 1) {
                    $last_cat_id = array_pop($cat_id_array);
                } elseif ($count == 1) {
                    if ($last_cat_id != end($cat_id_array)) {
                        $last_cat_id = end($cat_id_array);
                    } else {
                        $level = 0;
                        $last_cat_id = 0;
                        $cat_id_array = array();
                        continue;
                    }
                }
                if ($last_cat_id && isset($level_array[$last_cat_id])) {
                    $level = $level_array[$last_cat_id];
                } else {
                    $level = 0;
                }
            }
        } else {
            $options = $data;
        }
        $cat_options[0] = $options;
    } else {
        $options = $cat_options[0];
    }
    if (!$spec_cat_id) {
        return $options;
    } else {
        if (empty($options[$spec_cat_id])) {
            return array();
        }
        $spec_cat_id_level = $options[$spec_cat_id]['level'];
        foreach ($options as $key => $value) {
            if ($key != $spec_cat_id) {
                unset($options[$key]);
            } else {
                break;
            }
        }
        $spec_cat_id_array = array();
        foreach ($options as $key => $value) {
            if ($spec_cat_id_level == $value['level'] && $value['cat_id'] != $spec_cat_id || $spec_cat_id_level > $value['level']) {
                break;
            } else {
                $spec_cat_id_array[$key] = $value;
            }
        }
        $cat_options[$spec_cat_id] = $spec_cat_id_array;
        return $spec_cat_id_array;
    }
}
/**
 * 获得指定分类下的子分类的数组
 *
 * @access public
 * @param int $cat_id
 *        	分类的ID
 * @param int $selected
 *        	当前选中分类的ID
 * @param boolean $re_type
 *        	返回的类型: 值为真时返回下拉列表,否则返回数组
 * @param int $level
 *        	限定返回的级数。为0时返回所有级数
 * @param int $is_show_all
 *        	如果为true显示所有分类，如果为false隐藏不可见分类。
 * @return mix
 */
function cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true) {
    // 加载方法
    $db_goods = RC_Loader::load_app_model('goods_model', 'orders');
    $db_category = RC_Loader::load_app_model('sys_category_viewmodel', 'orders');
    $db_goods_cat = RC_Loader::load_app_model('goods_cat_viewmodel', 'orders');
    static $res = NULL;
    if ($res === NULL) {
        $data = false;
        if ($data === false) {
            $res = $db_category->join('category')->group('c.cat_id')->order(array('c.parent_id' => 'asc', 'c.sort_order' => 'asc'))->select();
            $res2 = $db_goods->field('cat_id, COUNT(*)|goods_num')->where(array('is_delete' => 0, 'is_on_sale' => 1))->group('cat_id asc')->select();
            $res3 = $db_goods_cat->join('goods')->where(array('g.is_delete' => 0, 'g.is_on_sale' => 1))->group('gc.cat_id')->select();
            $newres = array();
            foreach ($res2 as $k => $v) {
                $newres[$v['cat_id']] = $v['goods_num'];
                foreach ($res3 as $ks => $vs) {
                    if ($v['cat_id'] == $vs['cat_id']) {
                        $newres[$v['cat_id']] = $v['goods_num'] + $vs['goods_num'];
                    }
                }
            }
            if (!empty($res)) {
                foreach ($res as $k => $v) {
                    $res[$k]['goods_num'] = !empty($newres[$v['cat_id']]) ? $newres[$v['cat_id']] : 0;
                }
            }
        } else {
            $res = $data;
        }
    }
    if (empty($res) == true) {
        return $re_type ? '' : array();
    }
    $options = cat_options($cat_id, $res);
    // 获得指定分类下的子分类的数组
    $children_level = 99999;
    // 大于这个分类的将被删除
    if ($is_show_all == false) {
        foreach ($options as $key => $val) {
            if ($val['level'] > $children_level) {
                unset($options[$key]);
            } else {
                if ($val['is_show'] == 0) {
                    unset($options[$key]);
                    if ($children_level > $val['level']) {
                        $children_level = $val['level'];
                        // 标记一下，这样子分类也能删除
                    }
                } else {
                    $children_level = 99999;
                    // 恢复初始值
                }
            }
        }
    }
    /* 截取到指定的缩减级别 */
    if ($level > 0) {
        if ($cat_id == 0) {
            $end_level = $level;
        } else {
            $first_item = reset($options);
            // 获取第一个元素
            $end_level = $first_item['level'] + $level;
        }
        /* 保留level小于end_level的部分 */
        foreach ($options as $key => $val) {
            if ($val['level'] >= $end_level) {
                unset($options[$key]);
            }
        }
    }
    if ($re_type == true) {
        $select = '';
        if (!empty($options)) {
            foreach ($options as $var) {
                $select .= '<option value="' . $var['cat_id'] . '" ';
                $select .= $selected == $var['cat_id'] ? "selected='ture'" : '';
                $select .= '>';
                if ($var['level'] > 0) {
                    $select .= str_repeat('&nbsp;', $var['level'] * 4);
                }
                $select .= htmlspecialchars(addslashes($var['cat_name']), ENT_QUOTES) . '</option>';
            }
        }
        return $select;
    } else {
        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $options[$key]['url'] = build_uri('category', array('cid' => $value['cat_id']), $value['cat_name']);
            }
        }
        return $options;
    }
}
/**
 * 获得指定分类下所有底层分类的ID
 *
 * @access public
 * @param integer $cat
 *        	指定的分类ID
 * @return string
 */
function get_children($cat = 0) {
    return 'g.cat_id ' . db_create_in(array_unique(array_merge(array($cat), array_keys(cat_list($cat, 0, false)))));
}
/**
 * 生成查询订单总金额的字段
 * @param   string  $alias  order表的别名（包括.例如 o.）
 * @return  string
 */
function order_amount_field($alias = '') {
    return "   {$alias}goods_amount + {$alias}tax + {$alias}shipping_fee" . " + {$alias}insure_fee + {$alias}pay_fee + {$alias}pack_fee" . " + {$alias}card_fee ";
}
/**
 * 生成查询订单的sql
 * @param   string  $type   类型
 * @param   string  $alias  order表的别名（包括.例如 o.）
 * @return  string
 */
function order_query_sql($type = 'finished', $alias = '') {
	RC_Loader::load_app_func('global', 'goods');
    /* 已完成订单 */
    if ($type == 'finished') {
        return " AND {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) . " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " AND {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " ";
    } elseif ($type == 'await_ship') {
        return " AND   {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) . " AND   {$alias}shipping_status " . db_create_in(array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) . " AND ( {$alias}pay_status " . db_create_in(array(PS_PAYED, PS_PAYING)) . " OR {$alias}pay_id " . db_create_in(payment_id_list(true)) . ") ";
    } elseif ($type == 'await_pay') {
        return " AND   {$alias}order_status " . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) . " AND   {$alias}pay_status = '" . PS_UNPAYED . "'" . " AND ( {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " OR {$alias}pay_id " . db_create_in(payment_id_list(false)) . ") ";
    } elseif ($type == 'unconfirmed') {
        return " AND {$alias}order_status = '" . OS_UNCONFIRMED . "' ";
    } elseif ($type == 'unprocessed') {
        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) . " AND {$alias}shipping_status = '" . SS_UNSHIPPED . "'" . " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
    } elseif ($type == 'unpay_unship') {
        return " AND {$alias}order_status " . db_create_in(array(OS_UNCONFIRMED, OS_CONFIRMED)) . " AND {$alias}shipping_status " . db_create_in(array(SS_UNSHIPPED, SS_PREPARING)) . " AND {$alias}pay_status = '" . PS_UNPAYED . "' ";
    } elseif ($type == 'shipped') {
        return " AND {$alias}order_status = '" . OS_CONFIRMED . "'" . " AND {$alias}shipping_status " . db_create_in(array(SS_SHIPPED, SS_RECEIVED)) . " ";
    } else {
        die('函数 order_query_sql 参数错误');
    }
}
/**
 * 取得支付方式id列表
 * @param   bool    $is_cod 是否货到付款
 * @return  array
 */
function payment_id_list($is_cod) {
    $db = RC_Loader::load_app_model('payment_model', 'orders');
    $where = '';
    if ($is_cod) {
        $where = " is_cod = 1";
    } else {
        $where = " is_cod = 0";
    }
    $arr = $db->field('pay_id')->where($where)->select();
    return $arr;
}
/**
 * 截取UTF-8编码下字符串的函数
 *
 * @param   string      $str        被截取的字符串
 * @param   int         $length     截取的长度
 * @param   bool        $append     是否附加省略号
 *
 * @return  string
 */
function sub_str($str, $length = 0, $append = true) {
    $str = trim($str);
    $strlength = strlen($str);
    if ($length == 0 || $length >= $strlength) {
        return $str;
    } elseif ($length < 0) {
        $length = $strlength + $length;
        if ($length < 0) {
            $length = $strlength;
        }
    }
    if (function_exists('mb_substr')) {
        $newstr = mb_substr($str, 0, $length, EC_CHARSET);
    } elseif (function_exists('iconv_substr')) {
        $newstr = iconv_substr($str, 0, $length, EC_CHARSET);
    } else {
        $newstr = substr($str, 0, $length);
    }
    if ($append && $str != $newstr) {
        $newstr .= '...';
    }
    return $newstr;
}
/**
 * 取得状态列表
 * @param   string  $type   类型：all | order | shipping | payment
 */
function get_status_list($type = 'all') {
    $list = array();
    if ($type == 'all' || $type == 'order') {
        $pre = $type == 'all' ? 'os_' : '';
        foreach (RC_Lang::get('orders::order.os') as $key => $value) {
            $list[$pre . $key] = $value;
        }
    }
    if ($type == 'all' || $type == 'shipping') {
        $pre = $type == 'all' ? 'ss_' : '';
        foreach (RC_Lang::get('orders::order.ss') as $key => $value) {
            $list[$pre . $key] = $value;
        }
    }
    if ($type == 'all' || $type == 'payment') {
        $pre = $type == 'all' ? 'ps_' : '';
        foreach (RC_Lang::get('orders::order.ps') as $key => $value) {
            $list[$pre . $key] = $value;
        }
    }
    return $list;
}
/**
 * 退回余额、积分、红包（取消、无效、退货时），把订单使用余额、积分、红包设为0
 * @param   array   $order  订单信息
 */
function return_user_surplus_integral_bonus($order) {
    /* 处理余额、积分、红包 */
    if ($order['user_id'] > 0 && $order['surplus'] > 0) {
        $surplus = $order['money_paid'] < 0 ? $order['surplus'] + $order['money_paid'] : $order['surplus'];
        $options = array('user_id' => $order['user_id'], 'user_money' => $surplus, 'change_desc' => sprintf(RC_Lang::get('orders::order.return_order_surplus'), $order['order_sn']));
        RC_Api::api('user', 'account_change_log', $options);
        $data = array('order_amount' => '0');
        RC_DB::table('order_info')->where('order_id', $order['order_id'])->update($data);
    }
    if ($order['user_id'] > 0 && $order['integral'] > 0) {
        $options = array('user_id' => $order['user_id'], 'pay_points' => $order['integral'], 'change_desc' => sprintf(RC_Lang::get('orders::order.return_order_integral'), $order['order_sn']));
        RC_Api::api('user', 'account_change_log', $options);
    }
    if ($order['bonus_id'] > 0) {
        RC_Loader::load_app_func('admin_bonus', 'bonus');
        unuse_bonus($order['bonus_id']);
    }
    /* 修改订单 */
    $arr = array('bonus_id' => 0, 'bonus' => 0, 'integral' => 0, 'integral_money' => 0, 'surplus' => 0);
    update_order($order['order_id'], $arr);
}
/**
 * 更新订单总金额
 * @param   int     $order_id   订单id
 * @return  bool
 */
function update_order_amount($order_id) {
    return RC_DB::table('order_info')->where('order_id', $order_id)->decrement('order_amount', 'order_amount+' . order_due_field());
}

/**
 * 处理编辑订单时订单金额变动
 * @param   array   $order  订单信息
 * @param   array   $msgs   提示信息
 * @param   array   $links  链接信息
 */
function handle_order_money_change($order, &$msgs, &$links) {
    $order_id = $order['order_id'];
    if ($order['pay_status'] == PS_PAYED || $order['pay_status'] == PS_PAYING) {
        /* 应付款金额 */
        $money_dues = $order['order_amount'];
        if ($money_dues > 0) {
            /* 修改订单为未付款 */
            update_order($order_id, array('pay_status' => PS_UNPAYED, 'pay_time' => 0));
            $msgs[] = RC_Lang::get('orders::order.amount_increase');
            $links[] = array('text' => RC_Lang::get('orders::order.order_info'), 'href' => RC_Uri::url('orders/admin/info', 'order_id=' . $order_id));
        } elseif ($money_dues < 0) {
            $anonymous = $order['user_id'] > 0 ? 0 : 1;
            $msgs[] = RC_Lang::get('orders::order.amount_decrease');
            $links[] = array('text' => RC_Lang::get('orders::order.refund'), 'href' => RC_Uri::url('orders/admin/process', 'func=load_refund&anonymous=' . $anonymous . '&order_id=' . $order_id . '&refund_amount=' . abs($money_dues)));
        }
    }
}
/**
 * 更新订单对应的 pay_log
 * 如果未支付，修改支付金额；否则，生成新的支付log
 * @param   int     $order_id   订单id
 */
function update_pay_log($order_id) {
    $order_id = intval($order_id);
    if ($order_id > 0) {
        $order_amount = RC_DB::table('order_info')->where('order_id', $order_id)->pluck('order_amount');
        if (!is_null($order_amount)) {
            $log_id = RC_DB::table('pay_log')->whereRaw('order_id = "' . $order_id . '" and order_type = "' . PAY_ORDER . '" and is_paid = 0')->pluck('log_id');
            if ($log_id > 0) {
                /* 未付款，更新支付金额 */
                $data = array('order_amount' => $order_amount);
                RC_DB::table('pay_log')->where('log_id', $log_id)->update($data);
            } else {
                /* 已付款，生成新的pay_log */
                $data = array('order_id' => $order_id, 'order_amount' => $order_amount, 'order_type' => PAY_ORDER, 'is_paid' => 0);
                RC_DB::table('pay_log')->insert($data);
            }
        }
    }
}
/**
 * 取得订单商品
 * @param   array     $order  订单数组
 * @return array
 */
function get_order_goods($order) {
    $goods_list = array();
    $goods_attr = array();
    $data = RC_DB::table('order_goods as o')->leftJoin('products as p', RC_DB::raw('p.product_id'), '=', RC_DB::raw('o.product_id'))
    ->leftJoin('goods as g', RC_DB::raw('o.goods_id'), '=', RC_DB::raw('g.goods_id'))
    ->leftJoin('brand as b', RC_DB::raw('g.brand_id'), '=', RC_DB::raw('b.brand_id'))
    ->selectRaw("o.*, g.suppliers_id AS suppliers_id, IF(o.product_id > 0, p.product_number, g.goods_number) AS storage, o.goods_attr, IFNULL(b.brand_name, '') AS brand_name, p.product_sn")
    ->where(RC_DB::raw('o.order_id'), $order['order_id'])->get();
    $goods_list = array();
    if (!empty($data)) {
        foreach ($data as $key => $row) {
            $row['formated_subtotal'] = price_format($row['goods_price'] * $row['goods_number']);
            $row['formated_goods_price'] = price_format($row['goods_price']);
            $goods_attr[] = explode(' ', trim($row['goods_attr']));
            //将商品属性拆分为一个数组
            if ($row['extension_code'] == 'package_buy') {
                $row['storage'] = '';
                $row['brand_name'] = '';
                $row['package_goods_list'] = get_package_goods_list($row['goods_id']);
            }
            //处理货品id
            $row['product_id'] = empty($row['product_id']) ? 0 : $row['product_id'];
            $goods_list[] = $row;
        }
    }
    $attr = array();
    $arr = array();
    if (!empty($goods_attr)) {
        foreach ($goods_attr as $index => $array_val) {
            foreach ($array_val as $value) {
                $arr = explode(':', $value);
                //以 : 号将属性拆开
                $attr[$index][] = @array('name' => $arr[0], 'value' => $arr[1]);
            }
        }
    }
    return array('goods_list' => $goods_list, 'attr' => $attr);
}

/**
 * 取得订单商品
 * @param   array     $order_id  订单id
 * @return array
 */
function get_order_goods_base($order_id) {
    $goods_list = array();
    $field = 'og.*, og.goods_price * og.goods_number AS subtotal, g.goods_thumb, g.original_img, g.goods_img, g.store_id, c.comment_id, c.comment_rank, c.content as comment_content, c.has_image';
    
    $db_view = RC_DB::table('order_goods as og')
        ->leftJoin('goods as g', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
        ->leftJoin('comment as c', RC_DB::raw('og.rec_id'), '=', RC_DB::raw('c.rec_id'));
    $res = $db_view->selectRaw($field)->where(RC_DB::raw('og.order_id'), $order_id)
        ->groupBy(RC_DB::raw('og.rec_id'))
		->get();

    if (!empty($res)) {
        foreach ($res as $row) {
            if ($row['extension_code'] == 'package_buy') {
                $row['package_goods_list'] = get_package_goods($row['goods_id']);
            }
            $row['is_commented'] = empty($row['comment_id']) ? 0 : 1;
            $row['has_image'] = empty($row['has_image']) ? 0 : 1;
            $goods_list[] = $row;
        }
    }
    return $goods_list;
}
/**
 * 取得礼包列表
 * @param   integer     $package_id  订单商品表礼包类商品id
 * @return array
 */
function get_package_goods_list($package_id) {
    $resource = RC_DB::table('package_goods as pg')->leftJoin('goods as g', RC_DB::raw('pg.goods_id'), '=', RC_DB::raw('g.goods_id'))->leftJoin('products as p', RC_DB::raw('pg.product_id'), '=', RC_DB::raw('p.product_id'))->selectRaw('pg.goods_id, g.goods_name, (CASE WHEN pg.product_id > 0 THEN p.product_number ELSE g.goods_number END) AS goods_number, p.goods_attr, p.product_id, pg.goods_number AS order_goods_number, g.goods_sn, g.is_real, p.product_sn')->where(RC_DB::raw('pg.package_id'), $package_id)->get();
    if (!$resource) {
        return array();
    }
    $row = array();
    /* 生成结果数组 取存在货品的商品id 组合商品id与货品id */
    $good_product_str = '';
    if (!empty($resource)) {
        foreach ($resource as $key => $_row) {
            if ($_row['product_id'] > 0) {
                /* 取存商品id */
                $good_product_str .= ',' . $_row['goods_id'];
                /* 组合商品id与货品id */
                $_row['g_p'] = $_row['goods_id'] . '_' . $_row['product_id'];
            } else {
                /* 组合商品id与货品id */
                $_row['g_p'] = $_row['goods_id'];
            }
            //生成结果数组
            $row[] = $_row;
        }
    }
    $good_product_str = trim($good_product_str, ',');
    /* 释放空间 */
    unset($resource, $_row, $sql);
    /* 取商品属性 */
    if ($good_product_str != '') {
        $result_goods_attr = RC_DB::table('goods_attr as ga')->leftJoin('attribute as a', RC_DB::raw('ga.attr_id'), '=', RC_DB::raw('a.attr_id'))->selectRaw('ga.goods_attr_id, ga.attr_value, ga.attr_price, a.attr_name')->where(RC_DB::raw('a.attr_type'), 1)->whereIn('goods_id', $good_product_str)->get();
        $_goods_attr = array();
        if (!empty($result_goods_attr)) {
            foreach ($result_goods_attr as $value) {
                $_goods_attr[$value['goods_attr_id']] = $value;
            }
        }
    }
    /* 过滤货品 */
    $format[0] = "%s:%s[%d] <br>";
    $format[1] = "%s--[%d]";
    foreach ($row as $key => $value) {
        if ($value['goods_attr'] != '') {
            $goods_attr_array = explode('|', $value['goods_attr']);
            $goods_attr = array();
            foreach ($goods_attr_array as $_attr) {
                $goods_attr[] = sprintf($format[0], $_goods_attr[$_attr]['attr_name'], $_goods_attr[$_attr]['attr_value'], $_goods_attr[$_attr]['attr_price']);
            }
            $row[$key]['goods_attr_str'] = implode('', $goods_attr);
        }
        $row[$key]['goods_name'] = sprintf($format[1], $value['goods_name'], $value['order_goods_number']);
    }
    return $row;
}
/**
 * 订单单个商品或货品的已发货数量
 *
 * @param   int     $order_id       订单 id
 * @param   int     $goods_id       商品 id
 * @param   int     $product_id     货品 id
 *
 * @return  int
 */
function order_delivery_num($order_id, $goods_id, $product_id = 0) {
    $db_delivery_goods = RC_DB::table('delivery_goods as dg')->leftJoin('delivery_order as o', RC_DB::raw('o.delivery_id'), '=', RC_DB::raw('dg.delivery_id'));
    if ($product_id > 0) {
        $sum = $db_delivery_goods->whereRaw('o.status = 0 and o.order_id = "' . $order_id . '" and dg.extension_code <> "package_buy" and dg.goods_id = "' . $goods_id . '" and dg.product_id = "' . $product_id . '"')->sum(RC_DB::raw('dg.send_number'));
    } else {
        $sum = $db_delivery_goods->whereRaw('o.status = 0 and o.order_id = "' . $order_id . '" and dg.extension_code <> "package_buy" and dg.goods_id = "' . $goods_id . '"')->sum(RC_DB::raw('dg.send_number'));
    }
    if (empty($sum)) {
        $sum = 0;
    }
    return $sum;
}
/**
 * 判断订单是否已发货（含部分发货）
 * @param   int     $order_id  订单 id
 * @return  int     1，已发货；0，未发货
 */
function order_deliveryed($order_id) {
    $return_res = 0;
    if (empty($order_id)) {
        return $return_res;
    }
    $sum = RC_DB::table('delivery_order')->where('order_id', $order_id)->where('status', 0)->count('delivery_id');
    if ($sum) {
        $return_res = 1;
    }
    return $return_res;
}
/**
 * 更新订单商品信息
 * @param   int     $order_id       订单 id
 * @param   array   $_sended        Array('商品id' => '此单发货数量')
 * @param   array   $goods_list
 * @return  Bool
 */
function update_order_goods($order_id, $_sended, $goods_list = array()) {
    if (!is_array($_sended) || empty($order_id)) {
        return false;
    }
    foreach ($_sended as $key => $value) {
        // 超值礼包
        if (is_array($value)) {
            if (!is_array($goods_list)) {
                $goods_list = array();
            }
            foreach ($goods_list as $goods) {
                if ($key != $goods['rec_id'] || (!isset($goods['package_goods_list']) || !is_array($goods['package_goods_list']))) {
                    continue;
                }
                $goods['package_goods_list'] = package_goods($goods['package_goods_list'], $goods['goods_number'], $goods['order_id'], $goods['extension_code'], $goods['goods_id']);
                $pg_is_end = true;
                foreach ($goods['package_goods_list'] as $pg_key => $pg_value) {
                    if ($pg_value['order_send_number'] != $pg_value['sended']) {
                        $pg_is_end = false;
                        // 此超值礼包，此商品未全部发货
                        break;
                    }
                }
                // 超值礼包商品全部发货后更新订单商品库存
                if ($pg_is_end) {
                    RC_DB::table('order_goods')->where('order_id', $order_id)->where('goods_id', $goods['goods_id'])->increment('send_number', '0, send_number=goods_number');
                }
            }
        } elseif (!is_array($value)) {
            // 商品（实货）（货品）
            /* 检查是否为商品（实货）（货品） */
            foreach ($goods_list as $goods) {
                if ($goods['rec_id'] == $key && $goods['is_real'] == 1) {
                    RC_DB::table('order_goods')->where('order_id', $order_id)->where('rec_id', $key)->increment('send_number', $value);
                    break;
                }
            }
        }
    }
    return true;
}
/**
 * 更新订单虚拟商品信息
 * @param   int     $order_id       订单 id
 * @param   array   $_sended        Array(‘商品id’ => ‘此单发货数量’)
 * @param   array   $virtual_goods  虚拟商品列表
 * @return  Bool
 */
function update_order_virtual_goods($order_id, $_sended, $virtual_goods) {
    if (!is_array($_sended) || empty($order_id)) {
        return false;
    }
    if (empty($virtual_goods)) {
        return true;
    } elseif (!is_array($virtual_goods)) {
        return false;
    }
    if (!empty($virtual_goods)) {
        foreach ($virtual_goods as $goods) {
            $query = RC_DB::table('order_goods')->where('order_id', $order_id)->where('goods_id', $goods['goods_id'])->increment('send_number', $goods['num']);
            if (!$query) {
                return false;
            }
        }
    }
    return true;
}
/**
 * 订单中的商品是否已经全部发货
 * @param   int     $order_id  订单 id
 * @return  int     1，全部发货；0，未全部发货
 */
function get_order_finish($order_id) {
    $db_order_goods = RC_DB::table('order_goods');
    $return_res = 0;
    if (empty($order_id)) {
        return $return_res;
    }
    $sum = $db_order_goods->where('order_id', $order_id)->whereRaw('goods_number > send_number')->count('rec_id');
    if (empty($sum)) {
        $return_res = 1;
    }
    return $return_res;
}
function trim_array_walk(&$array_value) {
    if (is_array($array_value)) {
        array_walk($array_value, 'trim_array_walk');
    } else {
        $array_value = trim($array_value);
    }
}
function intval_array_walk(&$array_value) {
    if (is_array($array_value)) {
        array_walk($array_value, 'intval_array_walk');
    } else {
        $array_value = intval($array_value);
    }
}
/**
 * 删除发货单(不包括已退货的单子)
 * @param   int     $order_id  订单 id
 * @return  int     1，成功；0，失败
 */
function del_order_delivery($order_id) {
    $return_res = 0;
    if (empty($order_id)) {
        return $return_res;
    }
    //查找delivery_id
    $delivery_id = RC_DB::table('delivery_order')->where('order_id', $order_id)->lists('delivery_id');
    if (!empty($delivery_id)) {
        $query = RC_DB::table('delivery_goods')->whereIn('delivery_id', $delivery_id)->delete();
        $query .= RC_DB::table('delivery_order')->where('order_id', $order_id)->where('status', 0)->delete();
    }
    if ($query) {
        $return_res = 1;
    }
    return $return_res;
}
/**
 * 删除订单所有相关单子
 * @param   int     $order_id      订单 id
 * @param   int     $action_array  操作列表 Array('delivery', 'back', ......)
 * @return  int     1，成功；0，失败
 */
function del_delivery($order_id, $action_array) {
    $return_res = 0;
    if (empty($order_id) || empty($action_array)) {
        return $return_res;
    }
    $query_delivery = 1;
    $query_back = 1;
    if (in_array('delivery', $action_array)) {
        //查找delivery_id
        $delivery_id = RC_DB::table('delivery_order')->where('order_id', $order_id)->lists('delivery_id');
        if (!empty($delivery_id)) {
            $query_delivery = RC_DB::table('delivery_goods')->whereIn('delivery_id', $delivery_id)->delete();
            $query_delivery = RC_DB::table('delivery_order')->where('order_id', $order_id)->delete();
        }
    }
    if (in_array('back', $action_array)) {
        //查找back_id
        $back_id = RC_DB::table('back_order')->where('order_id', $order_id)->lists('back_id');
        if (!empty($back_id)) {
            $query_back = RC_DB::table('back_goods')->whereIn('back_id', $back_id)->delete();
            $query_back = RC_DB::table('back_order')->where('order_id', $order_id)->delete();
        }
    }
    if ($query_delivery && $query_back) {
        $return_res = 1;
    }
    return $return_res;
}
/**
 * 超级礼包发货数处理
 * @param   array   超级礼包商品列表
 * @param   int     发货数量
 * @param   int     订单ID
 * @param   varchar 虚拟代码
 * @param   int     礼包ID
 * @return  array   格式化结果
 */
function package_goods(&$package_goods, $goods_number, $order_id, $extension_code, $package_id) {
    $return_array = array();
    if (count($package_goods) == 0 || !is_numeric($goods_number)) {
        return $return_array;
    }
    foreach ($package_goods as $key => $value) {
        $return_array[$key] = $value;
        $return_array[$key]['order_send_number'] = $value['order_goods_number'] * $goods_number;
        $return_array[$key]['sended'] = package_sended($package_id, $value['goods_id'], $order_id, $extension_code, $value['product_id']);
        $return_array[$key]['send'] = $value['order_goods_number'] * $goods_number - $return_array[$key]['sended'];
        $return_array[$key]['storage'] = $value['goods_number'];
        if ($return_array[$key]['send'] <= 0) {
            $return_array[$key]['send'] = RC_Lang::get('orders::order.act_good_delivery');
            $return_array[$key]['readonly'] = 'readonly="readonly"';
        }
        /* 是否缺货 */
        if ($return_array[$key]['storage'] <= 0 && ecjia::config('use_storage') == '1') {
            $return_array[$key]['send'] = RC_Lang::get('orders::order.act_good_vacancy');
            $return_array[$key]['readonly'] = 'readonly="readonly"';
        }
    }
    return $return_array;
}
/**
 * 获取超级礼包商品已发货数
 *
 * @param       int         $package_id         礼包ID
 * @param       int         $goods_id           礼包的产品ID
 * @param       int         $order_id           订单ID
 * @param       varchar     $extension_code     虚拟代码
 * @param       int         $product_id         货品id
 *
 * @return  int     数值
 */
function package_sended($package_id, $goods_id, $order_id, $extension_code, $product_id = 0) {
    $db_delivery_goods = RC_DB::table('delivery_goods as dg')->leftJoin('delivery_order as o', RC_DB::raw('o.delivery_id'), '=', RC_DB::raw('dg.delivery_id'));
    if (empty($package_id) || empty($goods_id) || empty($order_id) || empty($extension_code)) {
        return false;
    }
    if ($product_id > 0) {
        $where = 'o.order_id = "' . $order_id . '" AND dg.parent_id = "' . $package_id . '" AND dg.goods_id = "' . $goods_id . '" AND dg.extension_code = "' . $extension_code . '" and dg.product_id = "' . $product_id . '"';
    } else {
        $where = 'o.order_id = "' . $order_id . '" AND dg.parent_id = "' . $package_id . '" AND dg.goods_id = "' . $goods_id . '" AND dg.extension_code = "' . $extension_code . '"';
    }
    $send = $db_delivery_goods->whereRaw($where)->whereIn(RC_DB::raw('o.status'), array(0, 2))->sum(RC_DB::raw('dg.send_number'));
    return empty($send) ? 0 : $send;
}
/**
 * 改变订单中商品库存
 * @param   int     $order_id  订单 id
 * @param   array   $_sended   Array(‘商品id’ => ‘此单发货数量’)
 * @param   array   $goods_list
 * @return  Bool
 */
function change_order_goods_storage_split($order_id, $_sended, $goods_list = array()) {
    /* 参数检查 */
    if (!is_array($_sended) || empty($order_id)) {
        return false;
    }
    foreach ($_sended as $key => $value) {
        // 商品（超值礼包）
        if (is_array($value)) {
            if (!is_array($goods_list)) {
                $goods_list = array();
            }
            foreach ($goods_list as $goods) {
                if ($key != $goods['rec_id'] || (!isset($goods['package_goods_list']) || !is_array($goods['package_goods_list']))) {
                    continue;
                }
                // 超值礼包无库存，只减超值礼包商品库存
                foreach ($goods['package_goods_list'] as $package_goods) {
                    if (!isset($value[$package_goods['goods_id']])) {
                        continue;
                    }
                    // 减库存：商品（超值礼包）（实货）、商品（超值礼包）（虚货）
                    RC_DB::table('goods')->where('goods_id', $package_goods['goods_id'])->decrement('goods_number', $value[$package_goods['goods_id']]);
                }
            }
        } elseif (!is_array($value)) {
            // 商品（实货）
            /* 检查是否为商品（实货） */
            foreach ($goods_list as $goods) {
                if ($goods['rec_id'] == $key && $goods['is_real'] == 1) {
                    $query = RC_DB::table('goods')->where('goods_id', $goods['goods_id'])->decrement('goods_number', $value);
                    break;
                }
            }
        }
    }
    return true;
}
/**
 * 获取站点根目录网址
 *
 * @access  private
 * @return  Bool
 */
function get_site_root_url() {
    return 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/' . '/order.php', '', PHP_SELF);
}
/**
 * 获取区域名
 * @param 订单id $order_id
 */
function get_regions($order_id) {
    $region = RC_DB::table('order_info as o')->leftJoin('region as c', RC_DB::raw('o.country'), '=', RC_DB::raw('c.region_id'))->leftJoin('region as p', RC_DB::raw('o.province'), '=', RC_DB::raw('p.region_id'))->leftJoin('region as t', RC_DB::raw('o.city'), '=', RC_DB::raw('t.region_id'))->leftJoin('region as d', RC_DB::raw('o.district'), '=', RC_DB::raw('d.region_id'))->select(RC_DB::raw("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region"))->where(RC_DB::raw('o.order_id'), $order_id)->first();
    return $region['region'];
}
/**
 * order_back.php
 */


/**
 * 根据id取得退货单信息
 * @param   int     $back_id   退货单 id（如果 back_id > 0 就按 id 查，否则按 sn 查）
 * @return  array   退货单信息（金额都有相应格式化的字段，前缀是 formated_ ）
 */
function back_order_info($back_id, $store_id) {
    $return_order = array();
    if (empty($back_id) || !is_numeric($back_id)) {
        return $return_order;
    }
    $db_back_order = RC_DB::table('back_order')->where('back_id', $back_id);
    isset($_SESSION['store_id']) ? $db_back_order->where('store_id', $store_id) : '';
    $back = $db_back_order->first();
    if ($back) {
        /* 格式化金额字段 */
        $back['formated_insure_fee'] = price_format($back['insure_fee'], false);
        $back['formated_shipping_fee'] = price_format($back['shipping_fee'], false);
        /* 格式化时间字段 */
        $back['formated_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $back['add_time']);
        $back['formated_update_time'] = RC_Time::local_date(ecjia::config('time_format'), $back['update_time']);
        $back['formated_return_time'] = RC_Time::local_date(ecjia::config('time_format'), $back['return_time']);
        $return_order = $back;
    }
    return $return_order;
}

/**
 * 取得发货单信息
 * @param   int     $delivery_order   发货单id（如果delivery_order > 0 就按id查，否则按sn查）
 * @param   string  $delivery_sn      发货单号
 * @return  array   发货单信息（金额都有相应格式化的字段，前缀是formated_）
 */
function delivery_order_info($delivery_id, $delivery_sn = '') {
    $return_order = array();
    if (empty($delivery_id) || !is_numeric($delivery_id)) {
        return $return_order;
    }
    $db_delivery_order = RC_DB::table('delivery_order');
    if ($delivery_id > 0) {
        $db_delivery_order->where('delivery_id', $delivery_id);
    } else {
        $db_delivery_order->where('delivery_sn', $delivery_sn);
    }
    isset($_SESSION['store_id']) ? $db_delivery_order->where(RC_DB::raw('store_id'), $_SESSION['store_id']) : '';
    $delivery = $db_delivery_order->first();
    if ($delivery) {
        /* 格式化金额字段 */
        $delivery['formated_insure_fee'] = price_format($delivery['insure_fee'], false);
        $delivery['formated_shipping_fee'] = price_format($delivery['shipping_fee'], false);
        /* 格式化时间字段 */
        $delivery['formated_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $delivery['add_time']);
        $delivery['formated_update_time'] = RC_Time::local_date(ecjia::config('time_format'), $delivery['update_time']);
        $return_order = $delivery;
    }
    return $return_order;
}

/**
 * 删除发货单时进行退货
 *
 * @access   public
 * @param    int     $delivery_id      发货单id
 * @param    array   $delivery_order   发货单信息数组
 *
 * @return  void
 */
function delivery_return_goods($delivery_id, $delivery_order) {
    /* 查询：取得发货单商品 */
    $goods_list = RC_DB::table('delivery_goods')->where('delivery_id', $delivery_order['delivery_id'])->get();
    /* 更新： */
    if (!empty($goods_list)) {
        foreach ($goods_list as $key => $val) {
            RC_DB::table('order_goods')->where('order_id', $delivery_order['order_id'])->where('goods_id', $goods_list[$key]['goods_id'])->where('product_id', $goods_list[$key]['product_id'])->limit(1)->decrement('send_number', '"' . $goods_list[$key]['send_number'] . '"');
        }
    }
    $data = array('shipping_status' => '0', 'order_status' => 1);
    RC_DB::table('order_info')->where('order_id', $delivery_order['order_id'])->limit(1)->update($data);
}

/**
 * 删除发货单时删除其在订单中的发货单号
 *
 * @access   public
 * @param    int      $order_id              定单id
 * @param    string   $delivery_invoice_no   发货单号
 *
 * @return  void
 */
function del_order_invoice_no($order_id, $delivery_invoice_no) {
    /* 查询：取得订单中的发货单号 */
    $order_invoice_no = RC_DB::table('order_info')->where('order_id', $order_id)->pluck('invoice_no');
    /* 如果为空就结束处理 */
    if (empty($order_invoice_no)) {
        return;
    }
    /* 去除当前发货单号 */
    $order_array = explode('<br>', $order_invoice_no);
    $delivery_array = explode('<br>', $delivery_invoice_no);
    foreach ($order_array as $key => $invoice_no) {
        $ii = array_search($invoice_no, $delivery_array);
        if ($ii) {
            unset($order_array[$key], $delivery_array[$ii]);
        }
    }
    $arr['invoice_no'] = implode('<br>', $order_array);
    update_order($order_id, $arr);
}

/**
 * 判断订单的发货单是否全部发货
 * @param   int     $order_id  订单 id
 * @return  int     1，全部发货；0，未全部发货；-1，部分发货；-2，完全没发货；
 */
function get_all_delivery_finish($order_id) {
    $db_delivery_order = RC_DB::table('delivery_order');
    $return_res = 0;
    if (empty($order_id)) {
        return $return_res;
    }
    /* 未全部分单 */
    if (!get_order_finish($order_id)) {
        return $return_res;
    } else {
        /* 已全部分单 */
        /* 是否全部发货 */
        $sum = $db_delivery_order->where('order_id', $order_id)->where('status', 2)->count('delivery_id');
        /* 全部发货 */
        if (empty($sum)) {
            $return_res = 1;
        } else {
            /* 未全部发货 */
            /* 订单全部发货中时：当前发货单总数 */
            $_sum = $db_delivery_order->where('order_id', $order_id)->where('status', '!=', 1)->count('delivery_id');
            if ($_sum == $sum) {
                $return_res = -2;
                // 完全没发货
            } else {
                $return_res = -1;
                // 部分发货
            }
        }
    }
    return $return_res;
}

/**
 * 合并订单
 * @param   string  $from_order_sn  从订单号
 * @param   string  $to_order_sn    主订单号
 * @return  成功返回true，失败返回错误信息
 */
function merge_order($from_order_sn, $to_order_sn) {
    /* 订单号不能为空 */
    if (trim($from_order_sn) == '' || trim($to_order_sn) == '') {
        return ecjia_front::$controller->showmessage(RC_Lang::get('orders::order.order_sn_not_null'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    /* 订单号不能相同 */
    if ($from_order_sn == $to_order_sn) {
        return ecjia_front::$controller->showmessage(RC_Lang::get('orders::order.two_order_sn_same'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    /* 取得订单信息 */
    $from_order = order_info(0, $from_order_sn);
    $to_order = order_info(0, $to_order_sn);
    /* 检查订单是否存在 */
    if (!$from_order) {
        return ecjia_front::$controller->showmessage(sprintf(RC_Lang::get('orders::order.order_not_exist'), $from_order_sn), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    } elseif (!$to_order) {
        return ecjia_front::$controller->showmessage(sprintf(RC_Lang::get('orders::order.order_not_exist'), $to_order_sn), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    /* 检查合并的订单是否为普通订单，非普通订单不允许合并 */
    if ($from_order['extension_code'] != '' || $to_order['extension_code'] != 0) {
        return ecjia_front::$controller->showmessage(RC_Lang::get('orders::order.merge_invalid_order'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    /* 检查订单状态是否是已确认或未确认、未付款、未发货 */
    if ($from_order['order_status'] != OS_UNCONFIRMED && $from_order['order_status'] != OS_CONFIRMED) {
        return ecjia_front::$controller->showmessage(sprintf(RC_Lang::get('orders::order.os_not_unconfirmed_or_confirmed'), $from_order_sn), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    } elseif ($from_order['pay_status'] != PS_UNPAYED) {
        return ecjia_front::$controller->showmessage(sprintf(RC_Lang::get('orders::order.ps_not_unpayed'), $from_order_sn), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    } elseif ($from_order['shipping_status'] != SS_UNSHIPPED) {
        return ecjia_front::$controller->showmessage(sprintf(RC_Lang::get('orders::order.ss_not_unshipped'), $from_order_sn), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    if ($to_order['order_status'] != OS_UNCONFIRMED && $to_order['order_status'] != OS_CONFIRMED) {
        return ecjia_front::$controller->showmessage(sprintf(RC_Lang::get('orders::order.os_not_unconfirmed_or_confirmed'), $to_order_sn), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    } elseif ($to_order['pay_status'] != PS_UNPAYED) {
        return ecjia_front::$controller->showmessage(sprintf(RC_Lang::get('orders::order.ps_not_unpayed'), $to_order_sn), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    } elseif ($to_order['shipping_status'] != SS_UNSHIPPED) {
        return ecjia_front::$controller->showmessage(sprintf(RC_Lang::get('orders::order.ss_not_unshipped'), $to_order_sn), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    /* 检查订单用户是否相同 */
    if ($from_order['user_id'] != $to_order['user_id']) {
        return ecjia_front::$controller->showmessage(RC_Lang::get('orders::order.order_user_not_same'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    /* 合并订单 */
    $order = $to_order;
    $order['order_id'] = '';
    $order['add_time'] = RC_Time::gmtime();
    // 合并商品总额
    $order['goods_amount'] += $from_order['goods_amount'];
    // 合并折扣
    $order['discount'] += $from_order['discount'];
    if ($order['shipping_id'] > 0) {
        // 重新计算配送费用
        $weight_price = order_weight_price($to_order['order_id']);
        $from_weight_price = order_weight_price($from_order['order_id']);
        $weight_price['weight'] += $from_weight_price['weight'];
        $weight_price['amount'] += $from_weight_price['amount'];
        $weight_price['number'] += $from_weight_price['number'];
        $region_id_list = array($order['country'], $order['province'], $order['city'], $order['district']);
        $shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
        $shipping_area = $shipping_method->shipping_area_info($order['shipping_id'], $region_id_list);
        $order['shipping_fee'] = $shipping_method->shipping_fee($shipping_area['shipping_code'], unserialize($shipping_area['configure']), $weight_price['weight'], $weight_price['amount'], $weight_price['number']);
        // 如果保价了，重新计算保价费
        if ($order['insure_fee'] > 0) {
            $order['insure_fee'] = shipping_insure_fee($shipping_area['shipping_code'], $order['goods_amount'], $shipping_area['insure']);
        }
    }
    // 重新计算包装费、贺卡费
    if ($order['pack_id'] > 0) {
        $order['pack_fee'] = 0;
    }
    if ($order['card_id'] > 0) {
        $order['card_fee'] = 0;
    }
    // 红包不变，合并积分、余额、已付款金额
    $order['integral'] += $from_order['integral'];
    $order['integral_money'] = value_of_integral($order['integral']);
    $order['surplus'] += $from_order['surplus'];
    $order['money_paid'] += $from_order['money_paid'];
    // 计算应付款金额（不包括支付费用）
    $order['order_amount'] = $order['goods_amount'] - $order['discount'] + $order['shipping_fee'] + $order['insure_fee'] + $order['pack_fee'] + $order['card_fee'] - $order['bonus'] - $order['integral_money'] - $order['surplus'] - $order['money_paid'];
    // 重新计算支付费
    if ($order['pay_id'] > 0) {
        // 货到付款手续费
        $cod_fee = $shipping_area ? $shipping_area['pay_fee'] : 0;
        $order['pay_fee'] = pay_fee($order['pay_id'], $order['order_amount'], $cod_fee);
        // 应付款金额加上支付费
        $order['order_amount'] += $order['pay_fee'];
    }
    /* 插入订单表 */
    $order['order_sn'] = get_order_sn();
    $order_id = RC_Model::model('orders/order_info_model')->insert(rc_addslashes($order));
    if (!$order_id) {
        return ecjia_front::$controller->showmessage(RC_Lang::get('orders::order.order_merge_invalid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    /* 更新订单商品 */
    $data = array('order_id' => $order_id);
    RC_DB::table('order_goods')->whereIn('order_id', array($from_order['order_id'], $to_order['order_id']))->update($data);
    //合并订单商品
    $order_goods_list = RC_DB::table('order_goods')->where('order_id', $order_id)->selectRaw('*, sum(goods_number) as goods_number, count(*) as count, sum(goods_price) as goods_price, sum(send_number) as send_number, sum(shopping_fee) as shopping_fee')->groupBy('goods_sn')->get();
    if (!empty($order_goods_list)) {
        foreach ($order_goods_list as $k => $v) {
            $order_goods_list[$k]['goods_price'] = $v['goods_price'] / $v['count'];
            unset($order_goods_list[$k]['count']);
        }
    }
    RC_DB::table('order_goods')->where('order_id', $order_id)->delete();
    //删除原来的订单商品
    RC_DB::table('order_goods')->insert($order_goods_list);
    //添加合并后的订单商品
//     $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
//     /* 插入支付日志 */
//     $payment_method->insert_pay_log($order_id, $order['order_amount'], PAY_ORDER);
    /* 删除原订单 */
    RC_DB::table('order_info')->whereIn('order_id', array($from_order['order_id'], $to_order['order_id']))->delete();
    /* 删除原订单支付日志 */
    RC_DB::table('pay_log')->whereIn('order_id', array($from_order['order_id'], $to_order['order_id']))->delete();
    /* 返还 from_order 的红包，因为只使用 to_order 的红包 */
    if ($from_order['bonus_id'] > 0) {
        RC_Loader::load_app_func('admin_bonus', 'bonus');
        unuse_bonus($from_order['bonus_id']);
    }
    ecjia_admin::admin_log(sprintf(RC_Lang::get('orders::order.merge_success_notice'), $to_order['order_sn'], $from_order['order_sn'], $order['order_sn']), 'merge', 'order');
    /* 返回成功 */
    return true;
}

/**
 * 获取指定年、月、日 开始和结束时间戳
 * @param number $year
 * @param number $month
 * @param number $day
 * @return array
 */
function getTimestamp($year = 0, $month = 0, $day = 0) {
	if (empty($year)) {
		$year = RC_Time::local_date("Y");
	}
	$start_year = $year;
	$start_year_formated = str_pad(intval($start_year), 4, "0", STR_PAD_RIGHT);
	$end_year = $start_year + 1;
	$end_year_formated = str_pad(intval($end_year), 4, "0", STR_PAD_RIGHT);

	if (empty($month)) {
		//只设置了年份
		$start_month_formated = '01';
		$end_month_formated = '01';
		$start_day_formated = '01';
		$end_day_formated = '01';
	} else {
		$month > 12 || $month < 1 ? $month = 1 : $month = $month;
		$start_month = $month;
		$start_month_formated = sprintf("%02d", intval($start_month));
		if (empty($day)) {
			//只设置了年份和月份
			$end_month = $start_month + 1;
			if ($end_month > 12) {
				$end_month = 1;
			} else {
				$end_year_formated = $start_year_formated;
			}
			$end_month_formated = sprintf("%02d", intval($end_month));
			$start_day_formated = '01';
			$end_day_formated = '01';
		} else {
			//设置了年份月份和日期
			$startTimestamp = RC_Time::local_strtotime($start_year_formated.'-'.$start_month_formated.'-'.sprintf("%02d", intval($day))." 00:00:00");
			$endTimestamp = $startTimestamp + 24 * 3600 - 1;
			return array('start' => $startTimestamp, 'end' => $endTimestamp);
		}
	}
	$startTimestamp = RC_Time::local_strtotime($start_year_formated.'-'.$start_month_formated.'-'.$start_day_formated." 00:00:00");
	$endTimestamp = RC_Time::local_strtotime($end_year_formated.'-'.$end_month_formated.'-'.$end_day_formated." 00:00:00") - 1;
	return array('start' => $startTimestamp, 'end' => $endTimestamp);
}

//end
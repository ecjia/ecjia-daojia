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
 * pc模板购物流类 拆单
 * @author 
 */
class cart_pc {
    
    
    //查询订单中所使用的红包等归属信息，所属商家(ID : bt.user_id)
    public static function get_bonus_merchants($bonus_id = 0, $user_id = 0) {
        return RC_DB::table('user_bonus as ub')->leftJoin('bonus_type as bt', RC_DB::raw('ub.bonus_type_id'), '=', RC_DB::raw('bt.type_id'))
        ->select(RC_DB::raw('ub.user_id, bt.store_id, bt.type_money, bt.usebonus_type, bt.min_goods_amount'))
        ->where(RC_DB::raw('ub.bonus_id'), $bonus_id)
        ->where(RC_DB::raw('ub.user_id'), $user_id)
        ->first();
    }
    
    //提交订单配送方式 --ecmoban模板堂 --zhuo
    public static function get_order_post_shipping($shipping, $shippingCode = array(), $shippingType = array(), $ru_id = 0){
        
        $shipping_list = array();
        if($shipping){
            $shipping_id = '';
            foreach($shipping as $k1=>$v1){
                
                $v1 = !empty($v1) ? intval($v1) : 0;
                $shippingCode[$k1] = !empty($shippingCode[$k1]) ? addslashes($shippingCode[$k1]) : '';
                $shippingType[$k1] = empty($shippingType[$k1]) ?  0 : intval($shippingType[$k1]);
                
//                 $shippingInfo = shipping_info($v1);
                $shippingInfo = ecjia_shipping::pluginData($v1);
                
                foreach($ru_id as $k2=>$v2){
                    if($k1 == $k2){
                        $shipping_id .= $v2. "|" .$v1 . ",";  //商家ID + 配送ID
                        $shipping_name .= $v2. "|" .$shippingInfo['shipping_name'] . ",";  //商家ID + 配送名称
                        $shipping_code .= $v2. "|" .$shippingCode[$k1] . ",";  //商家ID + 配送code
                        $shipping_type .= $v2. "|" .$shippingType[$k1] . ",";  //商家ID + （配送或自提）
                        
                    }
                }
            }
            
            $shipping_id = substr($shipping_id, 0, -1);
            $shipping_name = substr($shipping_name, 0, -1);
            $shipping_code = substr($shipping_code, 0, -1);
            $shipping_type = substr($shipping_type, 0, -1);
            $shipping_list = array(
                'shipping_id' => $shipping_id,
                'shipping_name' => $shipping_name,
                'shipping_code' => $shipping_code,
                'shipping_type' => $shipping_type
            );
        }
        return $shipping_list;
    }
    
    /**
     * 计算指定的金额需要多少积分
     *
     * @access  public
     * @param   integer $value  金额
     * @return  void
     */
    public static function integral_of_value($value)
    {
        $scale = floatval(ecjia::config('integral_scale'));
        return $scale > 0 ? round($value / $scale * 100) : 0;
    }
    
    
    /* $cart_goods_store = Array(
        [63] => Array
        (
            [0] => Array
            (
            [goods_id] => 829
            [goods_name] => xxx
            [goods_sn] => ECS000829
            )
        )
    ) */
        
    /**
     * 获取结算时店铺可用积分
     * @param array $cart_goods_store
     * @return number 
     */
    public static function get_integral_store($cart_goods_store) {
        //单店可用积分
        $store_integral = 0;
        
        foreach ($cart_goods_store as $row) {
            $integral = 0;
            $goods = RC_DB::table('goods')->where('goods_id', $row['goods_id'])->first();
            if(empty($goods['integral']) || empty($row['goods_price'])) {
                continue;
            }
            //取价格最小值，防止积分抵扣超过商品价格(并未计算优惠) -flow_available_points()
            $val_min = min($goods['integral'], $row['goods_price']);
            $val_min = $val_min * $row['goods_number'];
            if ($val_min < 1 && $val_min > 0) {
                $val = $val_min;
            } else {
                $val = intval($val_min);
            }
            if($val <= 0) {
                continue;
            }
            $integral = self::integral_of_value($val);
            $store_integral += $integral;
        }
        
        return $store_integral;
        
    }
    
}

// end
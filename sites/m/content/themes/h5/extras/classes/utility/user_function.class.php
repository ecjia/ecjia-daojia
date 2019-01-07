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

class user_function
{
    /**
     * 记录搜索历史
     */
    public static function insert_search($keywords = '', $store_id = 0)
    {
        $ecjia_search = 'ECJia[search]';
        if (!empty($store_id)) {
            $cookie_search = $_COOKIE['ECJia']['search'][$store_id];
            $ecjia_search  .= '[' . $store_id . ']';
        } else {
            $cookie_search = $_COOKIE['ECJia']['search']['other'];
            $ecjia_search  .= '[other]';
        }
        if (!empty($keywords)) {
            if (!empty($cookie_search)) {
                $history = explode(',', $cookie_search);
                array_unshift($history, $keywords);
                $history = array_unique($history);
                while (count($history) > ecjia::config('history_number')) {
                    array_pop($history);
                }
                return setcookie($ecjia_search, implode(',', $history), RC_Time::gmtime() + 3600 * 24 * 7);
            } else {
                return setcookie($ecjia_search, $keywords, RC_Time::gmtime() + 3600 * 24 * 7);
            }
        }
    }

    /**
     * 调用搜索历史
     */
    public static function get_search($store_id = 0)
    {
        $str = '';
        if (!empty($store_id)) {
            return empty($_COOKIE['ECJia']['search'][$store_id]) ? array() : explode(',', $_COOKIE['ECJia']['search'][$store_id]);
        } else {
            return empty($_COOKIE['ECJia']['search']['other']) ? array() : explode(',', $_COOKIE['ECJia']['search']['other']);
        }
    }

    /**
     * 获取单条地址信息
     */
    public static function address_info($token, $address_id)
    {
        $token        = ecjia_touch_user::singleton()->getToken();
        $address_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_INFO)->data(array('token' => $token, 'address_id' => $address_id))->run();
        if (!is_ecjia_error($address_info)) {
            return $address_info;
        }
    }

    /**
     * 判断是否是微信浏览器
     * @return boolean
     */
    public static function is_weixin()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }

    public static function get_region_list($province_id = '', $city_id = '', $district_id = '')
    {
        $province_list = RC_Cache::app_cache_get('user_address_province', 'user_address');
        if (empty($province_list)) {
            $rs_province = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('type' => 1))->run();
            if (!is_ecjia_error($rs_province) && !empty($rs_province['regions'])) {
                RC_Cache::app_cache_set('user_address_province', $rs_province['regions'], 'user_address');
                $province_list = $rs_province['regions'];
            }
        }

        $city_list = RC_Cache::app_cache_get('user_address_city', 'user_address');
        if (empty($city_list)) {
            $rs_city = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('type' => 2))->run();
            if (!is_ecjia_error($rs_city) && !empty($rs_city['regions'])) {
                RC_Cache::app_cache_set('user_address_city', $rs_city['regions'], 'user_address');
                $city_list = $rs_city['regions'];
            }
        }

        $district_list = RC_Cache::app_cache_get('user_address_district', 'user_address');
        if (empty($district_list)) {
            $rs_district = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('type' => 3))->run();
            if (!is_ecjia_error($rs_district) && !empty($rs_district['regions'])) {
                RC_Cache::app_cache_set('user_address_district', $rs_district['regions'], 'user_address');
                $district_list = $rs_district['regions'];
            }
        }

        $street_list = array();
        if (!empty($district_id)) {
            $street_list = RC_Cache::app_cache_get('user_address_street' . $district_id, 'user_address');
            if (empty($street_list)) {
                $rs_street = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('parent_id' => $district_id))->run();
                if (!is_ecjia_error($rs_street) && !empty($rs_street['regions'])) {
                    RC_Cache::app_cache_set('user_address_street' . $district_id, $rs_street['regions'], 'user_address');
                    $street_list = $rs_street['regions'];
                }
            }
        }

        return array(
            'province_list' => json_encode($province_list),
            'city_list'     => json_encode($city_list),
            'district_list' => json_encode($district_list),
            'street_list'   => !empty($street_list) ? json_encode($street_list) : '',
        );
    }

    public static function return_login_str()
    {
        $str = 'user/privilege/login';
        if (user_function::is_weixin()) {
            $str = 'user/privilege/wechat_login';
        }
        return $str;
    }

    public static function is_change_payment($pay_code = '', $manage_mode = '')
    {
        $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_PAYMENT)->run();
        $pay = is_ecjia_error($pay) ? array() : $pay;

        $open_id = '';
        /*根据浏览器过滤支付方式，微信自带浏览器过滤掉支付宝支付，其他浏览器过滤掉微信支付*/
        if (!empty($pay['payment'])) {
            if (cart_function::is_weixin() == true) {
                foreach ($pay['payment'] as $key => $val) {
                    if ($val['pay_code'] == 'pay_alipay') {
                        unset($pay['payment'][$key]);
                    }
                    if ($val['pay_code'] == 'pay_wxpay') {
                        $handler                   = with(new Ecjia\App\Payment\PaymentPlugin)->channel($val['pay_code']);
                        $open_id                   = $handler->getWechatOpenId();
                        $_SESSION['wxpay_open_id'] = $open_id;
                    }
                    //非自营过滤货到付款
                    if ($manage_mode != 'self' && $val['pay_code'] == 'pay_cod') {
                        unset($pay['payment'][$key]);
                    }
                }
            } else {
                foreach ($pay['payment'] as $key => $val) {
                    if ($val['pay_code'] == 'pay_wxpay') {
                        unset($pay['payment'][$key]);
                    }
                    //非自营过滤货到付款
                    if ($manage_mode != 'self' && $val['pay_code'] == 'pay_cod') {
                        unset($pay['payment'][$key]);
                    }
                }
            }
        }

        $change_payment = true;
        if (!empty($pay['payment'])) {
            foreach ($pay['payment'] as $key => $value) {
                if ($value['pay_code'] == $pay_code) {
                    $change_payment = false;
                }
            }
        }
        return array('change' => $change_payment, 'payment' => $pay['payment'], 'open_id' => $open_id);
    }

    public static function get_payment_list($pay_code = '', $manage_mode = '')
    {
        //获取可用的支付方式列表
        $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_PAYMENT)->run();
        $pay = is_ecjia_error($pay) ? array() : $pay;

        /*根据浏览器过滤支付方式，微信自带浏览器过滤掉支付宝支付，其他浏览器过滤掉微信支付*/
        if (!empty($pay['payment'])) {
            if (cart_function::is_weixin() == true) {
                foreach ($pay['payment'] as $key => $val) {
                    if ($val['pay_code'] == 'pay_alipay' || $val['pay_code'] == $pay_code) {
                        unset($pay['payment'][$key]);
                    }
                    if ($val['pay_code'] == 'pay_wxpay') {
                        $handler                   = with(new Ecjia\App\Payment\PaymentPlugin)->channel($val['pay_code']);
                        $open_id                   = $handler->getWechatOpenId();
                        $_SESSION['wxpay_open_id'] = $open_id;
                    }
                    //非自营过滤货到付款
                    if ($manage_mode != 'self' && $val['pay_code'] == 'pay_cod') {
                        unset($pay['payment'][$key]);
                    }
                }
            } else {
                foreach ($pay['payment'] as $key => $val) {
                    if ($val['pay_code'] == 'pay_wxpay' || $val['pay_code'] == $pay_code) {
                        unset($pay['payment'][$key]);
                    }
                    //非自营过滤货到付款
                    if ($manage_mode != 'self' && $val['pay_code'] == 'pay_cod') {
                        unset($pay['payment'][$key]);
                    }
                }
            }
        }
        return $pay['payment'];
    }

    //获取用户绑定的银行卡信息
    public static function get_userInfo_bankcard()
    {
        $token = ecjia_touch_user::singleton()->getToken();
        $list  = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO_BANKCARD)->data(array('token' => $token))->run();
        $list  = is_ecjia_error($list) ? [] : $list;

        return $list;
    }

    //获取用户有效的提现方式和默认一种提现方式
    public static function get_user_available_withdraw_way()
    {
        $list = self::get_userInfo_bankcard();

        $user_binded_list = !empty($list['user_binded_list']) ? $list['user_binded_list'] : [];

        $bind_list = [];
        $type_list = [];
        if (!empty($user_binded_list)) {
            foreach ($user_binded_list as $k => $v) {
                $bind_list[$v['bank_type']] = $v;
                $type_list[]                = $v['bank_type'];
            }
        }

        $available_withdraw_way = !empty($list['available_withdraw_way']) ? $list['available_withdraw_way'] : [];

        $withdraw_way = [];
        $bank_info    = [];

        if (!empty($available_withdraw_way)) {
            foreach ($available_withdraw_way as $k => $v) {
                if (in_array($v['bank_type'], $type_list)) {
                    $withdraw_way[] = $bind_list[$v['bank_type']];
                    if ($v['bank_type'] == 'bank') {
                        $bank_info = $bind_list[$v['bank_type']];
                    } elseif ($v['bank_type'] == 'wechat') {
                        $bank_info = $bind_list[$v['bank_type']];
                    }
                }
            }
        }

        return [
            'withdraw_way' => $withdraw_way,
            'bank_info'    => $bank_info
        ];
    }

    //检查微信提现是否设置真实姓名
    public static function check_user_wechat_name()
    {
        $list = self::get_userInfo_bankcard();

        $user_binded_list = !empty($list['user_binded_list']) ? $list['user_binded_list'] : [];

        $has_wechat_name = false;

        if (!empty($user_binded_list)) {
            foreach ($user_binded_list as $k => $v) {
                if ($v['bank_type'] == 'wechat' && !empty($v['cardholder'])) {
                    $has_wechat_name = true;
                }
            }
        }

        return $has_wechat_name;
    }


    public static function get_wechat_config($url)
    {
        $uuid = with(new Ecjia\App\Platform\Frameworks\Platform\AccountManager(0))->getDefaultUUID('wechat');
        if (empty($uuid)) {
            return [];
        }

        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
        if (empty($wechat)) {
            return [];
        }

        $apis = array('onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ');

        $wechat->js->setUrl($url);

        $config = $wechat->js->config($apis, false);

        return $config;
    }

}

//end

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
 * 地址模块控制器代码
 */
class user_address_controller
{

    /**
     * 收货地址列表界面
     */
    public static function address_list()
    {
        unset($_SESSION['referer_url']);

        $token = ecjia_touch_user::singleton()->getToken();

        $type = !empty($_GET['type']) ? trim($_GET['type']) : '';
        if ($type == 'choose') {
            $rec_id   = empty($_REQUEST['rec_id']) ? 0 : trim($_REQUEST['rec_id']);
            $store_id = empty($_REQUEST['store_id']) ? 0 : intval($_REQUEST['store_id']);
            ecjia_front::$controller->assign('rec_id', $rec_id);
            ecjia_front::$controller->assign('store_id', $store_id);

            $_SESSION['order_address_temp']['rec_id']   = $rec_id;
            $_SESSION['order_address_temp']['store_id'] = $store_id;
            $_SESSION['order_address_temp']['type']     = $type;

            $referer_url = RC_Uri::url('cart/flow/checkout', array('store_id' => $store_id, 'rec_id' => $rec_id));
            ecjia_front::$controller->assign('referer_url', $referer_url);
            ecjia_front::$controller->assign_title(__('选择收货地址', 'h5'));

            $address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => $token, 'seller_id' => $store_id))->run();
            $address_list = is_ecjia_error($address_list) ? array() : $address_list;

            if (!empty($address_list)) {
                foreach ($address_list as $k => $v) {
                    if ($v['local'] == 1) {
                        $address_list['local'][] = $v;
                    } else {
                        $address_list['other'][] = $v;
                    }
                    unset($address_list[$k]);
                }
            }
            ecjia_front::$controller->assign('address_list', $address_list);

            ecjia_front::$controller->assign('type', $type);
            ecjia_front::$controller->assign_lang();

            return ecjia_front::$controller->display('choose_address_list.dwt');
        } else {
            unset($_SESSION['order_address_temp']);

            $address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => $token))->run();
            $address_list = is_ecjia_error($address_list) ? array() : $address_list;

            ecjia_front::$controller->assign('address_list', $address_list);
            ecjia_front::$controller->assign_title(__('收货地址管理', 'h5'));

            ecjia_front::$controller->assign('type', $type);
            ecjia_front::$controller->assign_lang();

            return ecjia_front::$controller->display('user_address_list.dwt');
        }
    }

    public static function save_temp_data($is_return = 0, $data_key = '', $is_clear = [], $options = [])
    {
        if (isset($_GET['city'])) {
            $options['tem_city_name'] = $_GET['city'];
        }
        if (isset($_GET['city_id'])) {
            $options['tem_city'] = $_GET['city_id'];
        }
        if (isset($_GET['address'])) {
            $options['tem_address'] = $_GET['address'];
        }
        if (isset($_GET['name'])) {
            $options['tem_name'] = $_GET['name'];
        }
        if (isset($_GET['addr'])) {
            $options['tem_address_detail'] = $_GET['addr'];
        }
        if (isset($_GET['address_info'])) {
            $options['tem_address_info'] = $_GET['address_info'];
        }
        if (isset($_GET['consignee'])) {
            $options['tem_consignee'] = $_GET['consignee'];
        }
        if (isset($_GET['mobile'])) {
            $options['tem_mobile'] = $_GET['mobile'];
        }
        $temp_data = user_address_controller::update_temp_data('add', $_GET['clear'], $options);
        if ($is_return) {
            return $temp_data;
        }
    }

    //临时数据
    private static function update_temp_data($data_key, $is_clear, $options = array())
    {
        if ($is_clear) {
            return $temp_data = $_SESSION['address'][$data_key] = array();
        }
        if ($options) {
            $keys_array = array('id', 'consignee', 'address', 'address_info', 'country', 'province', 'city', 'district',
                'country_name', 'province_name', 'city_name', 'district_name',
                'tel', 'mobile', 'email', 'default_address', 'best_time', 'zipcode',
                'location' => array(
                    'longitude',
                    'latitude',
                ),
                //tem
                'tem_city',
                'tem_city_name',
                'tem_address',
                'tem_address_info',
                'tem_address_detail',
                'tem_mobile',
                'tem_consignee',
                'tem_name',
            );

            foreach ($keys_array as $key) {
                if (is_array($key)) {
                    foreach ($key as $child) {
                        if (isset($options[$key][$child])) {
                            $_SESSION['address'][$data_key][$key][$child] = $options[$key][$child];
                        }
                    }
                } else {
                    if (isset($options[$key])) {
                        $_SESSION['address'][$data_key][$key] = $options[$key];
                    }
                }
            }
        }
        return $temp_data = $_SESSION['address'][$data_key];

    }

    /**
     * 增加收货地址
     */
    public static function add_address()
    {
        $temp_data = user_address_controller::save_temp_data(1, 'add', $_GET['clear'], $_GET);
        ecjia_front::$controller->assign('temp', $temp_data);

        $location_backurl = urlencode(RC_Uri::url('user/address/add_address', array('clear' => 0)));
        ecjia_front::$controller->assign('location_backurl', $location_backurl);

        $clear = !empty($_GET['clear']) ? intval($_GET['clear']) : 0;
        if ($clear == 1) {
            ecjia_front::$controller->assign('clear', $clear);
        }

        $referer_url = !empty($_GET['referer_url']) ? htmlspecialchars_decode(urlencode($_GET['referer_url'])) : (!empty($_SESSION['referer_url']) ? $_SESSION['referer_url'] : '');
        if (!empty($referer_url)) {
            $_SESSION['referer_url'] = $referer_url;
            ecjia_front::$controller->assign('referer_url', $referer_url);
        }
        $key         = ecjia::config('map_qq_key');
        $referer     = ecjia::config('map_qq_referer');
        $my_location = "https://apis.map.qq.com/tools/locpicker?search=1&type=0&backurl=" . $location_backurl . "&key=" . $key . "&referer=" . $referer;
        ecjia_front::$controller->assign('my_location', $my_location);

        $latng   = !empty($_GET['latng']) ? $_GET['latng'] : '';
        $adcode  = '';
        $regions = array();
        if (!empty($latng)) {
            $res = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?location=" . $latng . "&key=" . $key);
            $res = json_decode($res['body'], true);
            if ($res['status'] == 0 && isset($res['result']['ad_info'])) {
                $adcode = $res['result']['ad_info']['adcode'];
            }
            $params = array(
                'token'   => ecjia_touch_user::singleton()->getToken(),
                'city_id' => $adcode,
            );
            $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION_DETAIL)->data($params)->run();
            if (!is_ecjia_error($rs)) {
                $regions = $rs['regions'];
            }
        }

        $province_id   = $city_id   = $district_id   = $street_id   = '';
        $province_name = $city_name = $district_name = $street_name = '';
        if (!empty($regions)) {
            foreach ($regions as $k => $v) {
                if ($v['region_type'] == 1) {
                    $province_id   = $v['region_id'];
                    $province_name = $v['region_name'];
                }
                if ($v['region_type'] == 2) {
                    $city_id   = $v['region_id'];
                    $city_name = $v['region_name'];
                }
                if ($v['region_type'] == 3) {
                    $district_id   = $v['region_id'];
                    $district_name = $v['region_name'];
                }
                if ($v['region_type'] == 4) {
                    $street_id   = $v['region_id'];
                    $street_name = $v['region_name'];
                }
            }
            $info = array(
                'province'      => $province_id,
                'city'          => $city_id,
                'district'      => $district_id,
                'street'        => $street_id,
                'province_name' => $province_name,
                'city_name'     => $city_name,
                'district_name' => $district_name,
                'street_name'   => $street_name,
            );
            ecjia_front::$controller->assign('clear', 2); //手动定位
            ecjia_front::$controller->assign('info', $info);
        }

        ecjia_front::$controller->assign('form_action', RC_Uri::url('user/address/insert_address'));
        ecjia_front::$controller->assign('temp_key', 'add');
        ecjia_front::$controller->assign_title(__('添加收货地址', 'h5'));
        ecjia_front::$controller->assign_lang();

        $type = !empty($_GET['type']) ? trim($_GET['type']) : '';
        ecjia_front::$controller->assign('type', $type);

        $region_data = user_function::get_region_list($province_id, $city_id, $district_id);
        ecjia_front::$controller->assign('region_data', $region_data);

        $local = 1;
        if (!empty($_SESSION['order_address_temp']['store_id'])) {
            $store_id = $_SESSION['order_address_temp']['store_id'];
            $addr     = !empty($_GET['addr']) ? $_COOKIE['city_name'] . trim($_GET['addr']) : $_COOKIE['location_address'];

            $key = ecjia_config::has('map_qq_key') ? ecjia::config('map_qq_key') : '';
            if (!empty($key)) {
                $addr                 = urlencode($addr);
                $shop_point           = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=" . $addr . "&key=" . $key);
                $shop_point           = json_decode($shop_point['body'], true);
                $location             = (array) $shop_point['result']['location'];
                $address['longitude'] = $location['lng'];
                $address['latitude']  = $location['lat'];

                $param = array('address' => array('latitude' => $address['latitude'], 'longitude' => $address['longitude']), 'store_id' => $store_id);
                $local = RC_Api::api('user', 'neighbors_address_store', $param);
                $local = $local ? 1 : 0;
            }
        }
        ecjia_front::$controller->assign('local', $local);
        ecjia_front::$controller->assign('get_region_url', RC_Uri::url('user/address/get_region'));

        return ecjia_front::$controller->display('user_address_edit.dwt');
    }

    /**
     * 插入收货地址
     */
    public static function insert_address()
    {
        if (empty($_POST['province']) || empty($_POST['city']) || empty($_POST['district']) || empty($_POST['street']) || empty($_POST['address']) || empty($_POST['consignee']) || empty($_POST['mobile'])) {
            return ecjia_front::$controller->showmessage(__('请完整填写相关信息', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
        }

        $params = array(
            'token'   => ecjia_touch_user::singleton()->getToken(),
            'address' => array(
                'province'     => trim($_POST['province']),
                'city'         => trim($_POST['city']),
                'district'     => trim($_POST['district']),
                'street'       => trim($_POST['street']),
                'address'      => htmlspecialchars($_POST['address']),
                'address_info' => htmlspecialchars($_POST['address_info']),
                'consignee'    => htmlspecialchars($_POST['consignee']),
                'mobile'       => htmlspecialchars($_POST['mobile']),
            ),
        );
        $mobile = $params['address']['mobile'];

        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile);
        if (is_ecjia_error($check_mobile)) {
            return ecjia_front::$controller->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_ADD)->data($params)->run();
        if (is_ecjia_error($rs)) {
            return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
        } else {
            $address_id = $rs['address_id'];
        }
        $url_address_list = RC_Uri::url('user/address/address_list');
        user_address_controller::update_temp_data('add', 1);

        if (!empty($_SESSION['referer_url'])) {
            $pjax_url = urldecode($_SESSION['referer_url']);

            setcookie('location_address_id', $address_id, time() + 1800);
            $params       = array('token' => ecjia_touch_user::singleton()->getToken(), 'address_id' => $address_id);
            $address_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_INFO)->data($params)->run();

            if (!is_ecjia_error($address_info)) {
                setcookie('location_name', $address_info['address'], time() + 1800);
                setcookie('location_address', $address_info['address_info'], time() + 1800);
                setcookie('longitude', $address_info['location']['longitude'], time() + 1800);
                setcookie('latitude', $address_info['location']['latitude'], time() + 1800);

                setcookie("city_id", $address_info['city'], time() + 1800);
                setcookie("city_name", $address_info['city_name'], time() + 1800);
            }
        } else {
            $pjax_url = RC_Uri::url('user/address/address_list');
            if (!empty($_SESSION['order_address_temp'])) {
                $array = array(
                    'store_id' => $_SESSION['order_address_temp']['store_id'],
                    'rec_id'   => $_SESSION['order_address_temp']['rec_id'],
                    'type'     => 'choose',
                );
                $pjax_url = RC_Uri::url('user/address/address_list', $array);
            }

            $type = !empty($_SESSION['order_address_temp']['type']) ? trim($_SESSION['order_address_temp']['type']) : '';
            if ($type == 'choose') {
                $params       = array('token' => ecjia_touch_user::singleton()->getToken(), 'address_id' => $address_id, 'seller_id' => $_SESSION['order_address_temp']['store_id']);
                $address_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_INFO)->data($params)->run();
                if (!is_ecjia_error($address_info) && $address_info['local'] == 1) {
                    $array = array(
                        'store_id'   => $_SESSION['order_address_temp']['store_id'],
                        'rec_id'     => $_SESSION['order_address_temp']['rec_id'],
                        'address_id' => $address_id,
                    );
                    $pjax_url = RC_Uri::url('cart/flow/checkout', $array);
                }
            }
        }
        unset($_SESSION['referer_url']);
        unset($_SESSION['address']);
        return ecjia_front::$controller->showmessage(__('添加地址成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjax_url));
    }

    /**
     * 编辑收货地址的处理
     */
    public static function edit_address()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return ecjia_front::$controller->showmessage(__('参数错误', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
        }
        $temp_key  = 'edit_' . $id;
        $temp_data = user_address_controller::save_temp_data(1, $temp_key, $_GET['clear'], $_GET);
        $params    = array('token' => ecjia_touch_user::singleton()->getToken(), 'address_id' => $id);
        $info      = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_INFO)->data($params)->run();
        $info      = is_ecjia_error($info) ? array() : $info;

        $location_backurl = urlencode(RC_Uri::url('user/address/edit_address', array('id' => $id, 'clear' => 0)));
        ecjia_front::$controller->assign('location_backurl', $location_backurl);

        $referer_url = !empty($_GET['referer_url']) ? htmlspecialchars_decode(urlencode($_GET['referer_url'])) : (!empty($_SESSION['referer_url']) ? $_SESSION['referer_url'] : '');
        if (!empty($referer_url)) {
            $_SESSION['referer_url'] = $referer_url;
            ecjia_front::$controller->assign('referer_url', $referer_url);
        }

        $key         = ecjia::config('map_qq_key');
        $referer     = ecjia::config('map_qq_referer');
        $my_location = "https://apis.map.qq.com/tools/locpicker?search=1&type=0&backurl=" . $location_backurl . "&key=" . $key . "&referer=" . $referer;
        ecjia_front::$controller->assign('my_location', $my_location);

        if (empty($temp_data['tem_city_name'])) {
            $temp_data['tem_city_name'] = $info['city_name'];
        }

        $clear = !empty($_GET['clear']) ? intval($_GET['clear']) : 0;
        if ($clear == 1) {
            ecjia_front::$controller->assign('clear', $clear);
        }

        $latng   = !empty($_GET['latng']) ? $_GET['latng'] : '';
        $adcode  = '';
        $regions = array();
        if (!empty($latng)) {
            $res = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?location=" . $latng . "&key=" . $key);
            $res = json_decode($res['body'], true);
            if ($res['status'] == 0 && isset($res['result']['ad_info'])) {
                $adcode = $res['result']['ad_info']['adcode'];
            }
            $params = array(
                'token'   => ecjia_touch_user::singleton()->getToken(),
                'city_id' => $adcode,
            );
            $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION_DETAIL)->data($params)->run();
            if (!is_ecjia_error($rs)) {
                $regions = $rs['regions'];
            }
        }

        $province_id   = $city_id   = $district_id   = $street_id   = '';
        $province_name = $city_name = $district_name = $street_name = '';
        if (!empty($regions)) {
            foreach ($regions as $k => $v) {
                if ($v['region_type'] == 1) {
                    $province_id   = $v['region_id'];
                    $province_name = $v['region_name'];
                }
                if ($v['region_type'] == 2) {
                    $city_id   = $v['region_id'];
                    $city_name = $v['region_name'];
                }
                if ($v['region_type'] == 3) {
                    $district_id   = $v['region_id'];
                    $district_name = $v['region_name'];
                }
                if ($v['region_type'] == 4) {
                    $street_id   = $v['region_id'];
                    $street_name = $v['region_name'];
                }
            }
            $info['province'] = $province_id;
            $info['city']     = $city_id;
            $info['district'] = $district_id;
            $info['street']   = $street_id;

            $info['province_name'] = $province_name;
            $info['city_name']     = $city_name;
            $info['district_name'] = $district_name;
            $info['street_name']   = $street_name;
            ecjia_front::$controller->assign('clear', 2); //手动定位
        }

        $region_data = user_function::get_region_list($info['province'], $info['city'], $info['district']);
        ecjia_front::$controller->assign('region_data', $region_data);

        ecjia_front::$controller->assign('info', $info);
        ecjia_front::$controller->assign('temp', $temp_data);
        ecjia_front::$controller->assign('temp_key', $temp_key);
        ecjia_front::$controller->assign('form_action', RC_Uri::url('user/address/update_address'));
        ecjia_front::$controller->assign('location_backurl', urlencode(RC_Uri::url('user/address/edit_address', array('id' => $id))));
        ecjia_front::$controller->assign_title(__('编辑收货地址', 'h5'));
        ecjia_front::$controller->assign_lang();

        $local = 1;
        if (!empty($_SESSION['order_address_temp']['store_id'])) {
            $store_id = $_SESSION['order_address_temp']['store_id'];
            $addr     = !empty($_GET['addr']) ? $_COOKIE['city_name'] . trim($_GET['addr']) : $_COOKIE['location_address'];

            $key = ecjia_config::has('map_qq_key') ? ecjia::config('map_qq_key') : '';
            if (!empty($key)) {
                $addr                 = urlencode($addr);
                $shop_point           = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=" . $addr . "&key=" . $key);
                $shop_point           = json_decode($shop_point['body'], true);
                $location             = (array) $shop_point['result']['location'];
                $address['longitude'] = $location['lng'];
                $address['latitude']  = $location['lat'];

                $param = array('address' => array('latitude' => $address['latitude'], 'longitude' => $address['longitude']), 'store_id' => $store_id);
                $local = RC_Api::api('user', 'neighbors_address_store', $param);
                $local = $local ? 1 : 0;
            }
        }
        ecjia_front::$controller->assign('local', $local);
        ecjia_front::$controller->assign('get_region_url', RC_Uri::url('user/address/get_region'));

        return ecjia_front::$controller->display('user_address_edit.dwt');
    }

    /**
     * 更新地址信息
     */
    public static function update_address()
    {

        if (empty($_POST['address_id'])) {
            return ecjia_front::$controller->showmessage(__('参数错误', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
        }
        if (empty($_POST['province']) || empty($_POST['city']) || empty($_POST['district']) || empty($_POST['street']) || empty($_POST['address']) || empty($_POST['consignee']) || empty($_POST['mobile'])) {
            return ecjia_front::$controller->showmessage(__('请完整填写相关信息', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
        }
        $params = array(
            'token'      => ecjia_touch_user::singleton()->getToken(),
            'address_id' => $_POST['address_id'],
            'address'    => array(
                'province'     => trim($_POST['province']),
                'city'         => trim($_POST['city']),
                'district'     => trim($_POST['district']),
                'street'       => trim($_POST['street']),
                'address'      => htmlspecialchars($_POST['address']),
                'address_info' => htmlspecialchars($_POST['address_info']),
                'consignee'    => htmlspecialchars($_POST['consignee']),
                'mobile'       => htmlspecialchars($_POST['mobile']),
            ),
        );

        $mobile       = $params['address']['mobile'];
        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile);
        if (is_ecjia_error($check_mobile)) {
            return ecjia_front::$controller->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_UPDATE)->data($params)->run();

        if (is_ecjia_error($rs)) {
            return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
        }
        $temp_data = user_address_controller::save_temp_data(0, 'edit_' . $_POST['address_id'], 1);

        $pjaxurl = RC_Uri::url('user/address/address_list');
        if (!empty($_SESSION['order_address_temp'])) {
            $array = array(
                'store_id' => $_SESSION['order_address_temp']['store_id'],
                'rec_id'   => $_SESSION['order_address_temp']['rec_id'],
                'type'     => 'choose',
            );
            $pjaxurl = RC_Uri::url('user/address/address_list', $array);
        }

        unset($_SESSION['address']);
        return ecjia_front::$controller->showmessage(__('编辑地址成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }

    /**
     * 删除收货地址
     */
    public static function del_address()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        $pjax_url = RC_Uri::url('address_list');
        if (!empty($_SESSION['order_address_temp'])) {
            $array = array(
                'store_id' => $_SESSION['order_address_temp']['store_id'],
                'rec_id'   => $_SESSION['order_address_temp']['rec_id'],
                'type'     => 'choose',
            );
            $pjax_url = RC_Uri::url('user/address/address_list', $array);
        }
        if (!$id) {
            return ecjia_front::$controller->showmessage(__('参数错误', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $pjax_url));
        }

        $params       = array('token' => ecjia_touch_user::singleton()->getToken(), 'address_id' => $id);
        $address_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_INFO)->data($params)->run();
        if (is_ecjia_error($address_info)) {
            return ecjia_front::$controller->showmessage($address_info->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('address_list')));
        }
        if ($address_info['default_address'] == 0) {
            if ($id == $_COOKIE['location_address_id']) {
                setcookie("location_address_id", 0, 1);
            }
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_DELETE)->data($params)->run();
            if (is_ecjia_error($data)) {
                return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $pjax_url));
            } else {
                return ecjia_front::$controller->showmessage(__('删除成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjax_url));
            }
        } else {
            return ecjia_front::$controller->showmessage(__('该地址为默认的收货地址，不能删除', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $pjax_url));
        }
    }

    /**
     * 设置默认地址
     */
    public static function set_default()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        $pjax_url = RC_Uri::url('user/address/address_list');
        if (!empty($_SESSION['order_address_temp'])) {
            $array = array(
                'store_id' => $_SESSION['order_address_temp']['store_id'],
                'rec_id'   => $_SESSION['order_address_temp']['rec_id'],
                'type'     => 'choose',
            );
            $pjax_url = RC_Uri::url('user/address/address_list', $array);
        }
        if (!$id) {
            return ecjia_front::$controller->showmessage(__('参数错误', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $pjax_url));
        }

        $params = array('token' => ecjia_touch_user::singleton()->getToken(), 'address_id' => $id);

        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_SETDEFAULT)->data($params)->run();
        if (!is_ecjia_error($data)) {
            return ecjia_front::$controller->showmessage(__('设置成功', 'h5'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjax_url));
        } else {
            return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $pjax_url));
        }
    }

    /**
     * 定位当前位置
     */
    public static function near_location()
    {
        $referer_url = !empty($_GET['referer_url']) ? htmlspecialchars_decode($_GET['referer_url']) : '';
        if (!empty($referer_url)) {
            ecjia_front::$controller->assign('referer_url', $referer_url);
        }

        if (!empty($_GET['address_id'])) {
            ecjia_front::$controller->assign('action_url', RC_Uri::url('user/address/edit_address', array('id' => intval($_GET['address_id']))));
            $temp_data = user_address_controller::save_temp_data(1, 'edit_' . $_GET['address_id'], $_GET['clear'], $_GET);
        } else {
            ecjia_front::$controller->assign('action_url', RC_Uri::url('user/address/add_address'));
            $temp_data = user_address_controller::save_temp_data(1, 'add', $_GET['clear'], $_GET);
            if (empty($temp_data['tem_city']) && empty($_COOKIE['city_name'])) {
                return ecjia_front::$controller->showmessage(__('请先选择城市', 'h5'), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => ''));
            }
        }
        ecjia_front::$controller->assign('temp', $temp_data);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title(__('选择位置', 'h5'));
        return ecjia_front::$controller->display('user_near_location.dwt');
    }

    public static function choose_address()
    {
        $referer_url = !empty($_GET['referer_url']) ? htmlspecialchars_decode(urldecode($_GET['referer_url'])) : RC_Uri::url('touch/index/init');
        $address_id  = !empty($_GET['address_id']) ? intval($_GET['address_id']) : 0;
        $type        = !empty($_GET['type']) ? trim($_GET['type']) : '';

        if (!empty($address_id) && $type != 'choose') {
            $address_info = user_function::address_info(ecjia_touch_user::singleton()->getToken(), $address_id);

            setcookie('location_address_id', $address_id, time() + 1800);
            setcookie('location_name', $address_info['address'], time() + 1800);
            setcookie('location_address', $address_info['address_info'], time() + 1800);
            setcookie('longitude', $address_info['location']['longitude'], time() + 1800);
            setcookie('latitude', $address_info['location']['latitude'], time() + 1800);

            setcookie("city_id", $address_info['city'], time() + 1800);
            setcookie("city_name", $address_info['city_name'], time() + 1800);
        }
        return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $referer_url));
    }

    public static function get_region()
    {
        $province_id = !empty($_POST['province_id']) ? trim($_POST['province_id']) : '';
        $city_id     = !empty($_POST['city_id']) ? trim($_POST['city_id']) : '';
        $district_id = !empty($_POST['district_id']) ? trim($_POST['district_id']) : '';

        if (!empty($province_id) || !empty($city_id) || !empty($district_id)) {
            $region_data = user_function::get_region_list($province_id, $city_id, $district_id);
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $region_data);
        }
    }
}

// end

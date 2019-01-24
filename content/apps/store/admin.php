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
 * 入驻商家管理
 */
class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        RC_Loader::load_app_func('merchant_store');
        Ecjia\App\Store\Helper::assign_adminlog_content();

        //全局JS和CSS
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');

        RC_Style::enqueue_style('splashy');

        RC_Script::enqueue_script('jquery-range', RC_App::apps_url('statics/js/jquery.range.js', __FILE__));
        RC_Style::enqueue_style('range', RC_App::apps_url('statics/css/range.css', __FILE__), array());
        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
        RC_Script::enqueue_script('qq_map', ecjia_location_mapjs());

        RC_Script::enqueue_script('store', RC_App::apps_url('statics/js/store.js', __FILE__));
        RC_Script::enqueue_script('store_log', RC_App::apps_url('statics/js/store_log.js', __FILE__));
        RC_Script::enqueue_script('commission_info', RC_App::apps_url('statics/js/commission.js', __FILE__));
        RC_Script::enqueue_script('region', RC_Uri::admin_url('statics/lib/ecjia-js/ecjia.region.js'));

        $store_id   = intval($_GET['store_id']);
        $store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $nav_here   = '入驻商家';
        $url        = RC_Uri::url('store/admin/join');
        if ($store_info['manage_mode'] == 'self') {
            $nav_here = '自营店铺';
            $url      = RC_Uri::url('store/admin/init');
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, $url));
    }

    /**
     * 自营商家
     */
    public function init()
    {
        $this->admin_priv('store_self_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('自营店铺'));
        ecjia_screen::get_current_screen()->set_sidebar_display(true);

        $this->assign('ur_here', '自营店铺列表');
        $manage_mode = 'self';
        $store_list  = $this->store_list($manage_mode);
        $cat_list    = $this->get_cat_select_list();

        $this->assign('cat_list', $cat_list);
        $this->assign('store_list', $store_list);
        $this->assign('filter', $store_list['filter']);
        $this->assign('action_link', array('text' => '添加自营商家', 'href' => RC_Uri::url('store/admin/add')));
        $this->assign('manage_mode', $manage_mode);

        $this->assign('search_action', RC_Uri::url('store/admin/init'));
        $this->assign('bill_progress', array('text' => '结算流程', 'href' => RC_Uri::url('store/admin/progress', array('type' => 'bill', 'from' => 'self'))));

        $this->display('store_list.dwt');
    }

    /**
     * 入驻商家列表
     */
    public function join()
    {
        $this->admin_priv('store_affiliate_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('入驻商家'));
        ecjia_screen::get_current_screen()->set_sidebar_display(true);
        $this->assign('ur_here', '入驻商家列表');

        $manage_mode = 'join';
        $store_list  = $this->store_list($manage_mode);
        $cat_list    = $this->get_cat_select_list();

        $this->assign('cat_list', $cat_list);
        $this->assign('store_list', $store_list);
        $this->assign('filter', $store_list['filter']);
        $this->assign('manage_mode', $manage_mode);
        $this->assign('search_action', RC_Uri::url('store/admin/join'));

        $this->assign('bill_progress', array('text' => '结算流程', 'href' => RC_Uri::url('store/admin/progress', array('type' => 'bill'))));
        $this->assign('enter_progress', array('text' => '入驻流程', 'href' => RC_Uri::url('store/admin/progress', array('type' => 'enter'))));

        $this->display('store_list.dwt');
    }

    /**
     * 添加自营商家
     */
    public function add()
    {
        $this->admin_priv('store_affiliate_add', ecjia::MSGTYPE_JSON);

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('自营店铺', RC_Uri::url('store/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加自营商家'));

        $this->assign('ur_here', '添加自营商家');
        $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => '自营店铺列表'));

        $cat_list  = $this->get_cat_select_list();
        $provinces = ecjia_region::getSubarea(ecjia::config('shop_country'));//获取当前国家的所有省份
        $this->assign('province', $provinces);

        $this->assign('form_action', RC_Uri::url('store/admin/insert'));
        $this->assign('cat_list', $cat_list);

        $this->display('store_add.dwt');
    }

    /**
     * 添加自营商家
     */
    public function insert()
    {
        $this->admin_priv('store_affiliate_add', ecjia::MSGTYPE_JSON);

        $store_id = intval($_POST['store_id']);

        $data = array(
            'validate_type'  => 2,
            'cat_id'         => !empty($_POST['store_cat']) ? $_POST['store_cat'] : 0,
            'merchants_name' => !empty($_POST['merchants_name']) ? $_POST['merchants_name'] : '',
            'shop_keyword'   => !empty($_POST['shop_keyword']) ? $_POST['shop_keyword'] : '',
            'email'          => !empty($_POST['email']) ? $_POST['email'] : '',
            'contact_mobile' => !empty($_POST['contact_mobile']) ? $_POST['contact_mobile'] : '',
            'address'        => !empty($_POST['address']) ? $_POST['address'] : '',
            'province'       => !empty($_POST['province']) ? $_POST['province'] : '',
            'city'           => !empty($_POST['city']) ? $_POST['city'] : '',
            'district'       => !empty($_POST['district']) ? $_POST['district'] : '',
            'street'         => !empty($_POST['street']) ? $_POST['street'] : '',
            'longitude'      => !empty($_POST['longitude']) ? $_POST['longitude'] : '',
            'latitude'       => !empty($_POST['latitude']) ? $_POST['latitude'] : '',
            'manage_mode'    => 'self',
            'shop_close'     => isset($_POST['shop_close']) ? $_POST['shop_close'] : 1,
            'confirm_time'   => RC_Time::gmtime(),
        );

        if (empty($data['merchants_name'])) {
            return $this->showmessage('店铺名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (mb_strlen($data['merchants_name']) > 17) {
            return $this->showmessage('店铺名称不能超过17个字符', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($data['cat_id'])) {
            return $this->showmessage('请选择商家分类', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($data['contact_mobile'])) {
            return $this->showmessage('联系手机不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($data['contact_mobile']);
        if (is_ecjia_error($check_mobile)) {
            return $this->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($data['email'])) {
            return $this->showmessage('邮箱不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($data['province']) || empty($data['city']) || empty($data['district'])) {
            return $this->showmessage('请选择地区', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($data['address'])) {
            return $this->showmessage('请填写通讯地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($data['latitude']) || empty($data['longitude'])) {
            return $this->showmessage('请获取坐标', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $is_exist = RC_DB::table('store_franchisee')->where('merchants_name', $data['merchants_name'])->get();
        if ($is_exist) {
            return $this->showmessage('店铺名称已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $is_exist = RC_DB::table('store_franchisee')->where('contact_mobile', $data['contact_mobile'])->get();
        if ($is_exist) {
            return $this->showmessage('联系手机已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $is_exist = RC_DB::table('staff_user')->where('mobile', $data['contact_mobile'])->get();
        if ($is_exist) {
            return $this->showmessage('联系手机员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $is_exist = RC_DB::table('store_franchisee')->where('email', $data['email'])->get();
        if ($is_exist) {
            return $this->showmessage('邮箱已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $is_exist = RC_DB::table('staff_user')->where('email', $data['email'])->get();
        if ($is_exist) {
            return $this->showmessage('邮箱员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $geohash         = RC_Loader::load_app_class('geohash', 'store');
        $geohash_code    = $geohash->encode($data['latitude'], $data['longitude']);
        $geohash_code    = substr($geohash_code, 0, 10);
        $data['geohash'] = $geohash_code;

        $store_id = RC_DB::table('store_franchisee')->insertGetId($data);
        if ($store_id) {
            //审核通过产生店铺中的code
            $merchant_config  = array(
                'shop_logo', // 默认店铺页头部LOGO
                'shop_nav_background', // 店铺导航背景图
                'shop_banner_pic', // app banner图
                'shop_kf_mobile', // 客服手机号码
                'shop_trade_time', // 营业时间
                'shop_description', // 店铺描述
                'shop_notice', // 店铺公告
                'shop_review_goods', // 店铺商品审核状态，平台开启审核时店铺优先级高于平台设置
                'express_assign_auto', // o2o配送自动派单开关
            );
            $merchants_config = RC_DB::table('merchants_config');
            foreach ($merchant_config as $val) {
                $count = $merchants_config->where(RC_DB::raw('store_id'), $store_id)->where(RC_DB::raw('code'), $val)->count();
                if ($count == 0) {
                    $merchants_config->insert(array('store_id' => $store_id, 'code' => $val));
                }
            }

            //审核通过产生一个主员工的资料
            $password   = rand(100000, 999999);
            $salt       = rand(1, 9999);
            $data_staff = array(
                'mobile'       => $data['contact_mobile'],
                'store_id'     => $store_id,
                'name'         => $data['merchants_name'] . '店长',
                'nick_name'    => '',
                'user_ident'   => 'SC001',
                'email'        => $data['email'],
                'password'     => md5(md5($password) . $salt),
                'salt'         => $salt,
                'add_time'     => RC_Time::gmtime(),
                'last_ip'      => '',
                'action_list'  => 'all',
                'todolist'     => '',
                'parent_id'    => 0,
                'avatar'       => '',
                'introduction' => '',
            );
            $staff      = RC_DB::table('staff_user')->insertGetId($data_staff);
            if (!$staff) {
                return $this->showmessage('店长账号添加失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            //短信发送通知
            $options  = array(
                'mobile' => $data['contact_mobile'],
                'event'  => 'sms_self_merchant',
                'value'  => array(
                    'shop_name'     => ecjia::config('shop_name'),
                    'account'       => $data['contact_mobile'],
                    'password'      => $password,
                    'service_phone' => ecjia::config('service_phone'),
                ),
            );
            $response = RC_Api::api('sms', 'send_event_sms', $options);
            if (is_ecjia_error($response)) {
                RC_Logger::getlogger('error')->info('添加自营店铺：' . $response->get_error_message());
            }
        } else {
            return $this->showmessage('操作失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        ecjia_admin::admin_log('添加商家：' . $data['merchants_name'], 'add', 'store');
        return $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/edit', array('store_id' => $store_id, 'step' => 'base'))));

    }

    /**
     * 编辑入驻商
     */
    public function edit()
    {
        $this->admin_priv('store_affiliate_update', ecjia::MSGTYPE_JSON);

        $store_id = intval($_GET['store_id']);
        $store    = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);

        $this->assign('action_link', array('href' => RC_Uri::url('store/admin/preview', array('store_id' => $store_id)), 'text' => '基本信息'));
        $step = trim($_GET['step']);

        $nav_here     = '编辑入驻商';
        $current_code = 'store_preview';
        $ur_here      = $store['merchants_name'] . ' - ' . RC_Lang::get('store::store.store_update');

        if ($step == 'identity' || $step == 'pic') {
            $nav_here     = '编辑资质认证信息';
            $current_code = 'store_auth';
            $ur_here      = $store['merchants_name'] . ' - 编辑资质认证信息';
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here));
        ecjia_screen::get_current_screen()->add_option('current_code', $current_code);

        $store['apply_time']   = RC_Time::local_date(ecjia::config('time_format'), $store['apply_time']);
        $store['confirm_time'] = RC_Time::local_date(ecjia::config('time_format'), $store['confirm_time']);
        $store['expired_time'] = RC_Time::local_date('Y-m-d', $store['expired_time']);
        $cat_list              = $this->get_cat_select_list();
        $certificates_list     = array(
            '1' => RC_Lang::get('store::store.people_id'),
            '2' => RC_Lang::get('store::store.passport'),
            '3' => RC_Lang::get('store::store.hong_kong_and_macao_pass'),
        );

        $provinces = ecjia_region::getSubarea(ecjia::config('shop_country'));
        $cities    = ecjia_region::getSubarea($store['province']);
        $districts = ecjia_region::getSubarea($store['city']);
        $streets   = ecjia_region::getSubarea($store['district']);

        $this->assign('province', $provinces);
        $this->assign('city', $cities);
        $this->assign('district', $districts);
        $this->assign('street', $streets);

        $this->assign('cat_list', $cat_list);
        $this->assign('certificates_list', $certificates_list);

        $store['shop_review_goods'] = get_merchant_config($store_id, 'shop_review_goods');
        $this->assign('store', $store);
        $this->assign('form_action', RC_Uri::url('store/admin/update'));
        $this->assign('longitudeForm_action', RC_Uri::url('store/admin/get_longitude'));
        $this->assign('step', $step);
        $this->assign('ur_here', $ur_here);

        $this->display('store_edit.dwt');
    }

    /**
     * 编辑入驻商数据更新
     */
    public function update()
    {
        $this->admin_priv('store_affiliate_update', ecjia::MSGTYPE_JSON);

        $store_id = intval($_POST['store_id']);
        $step     = trim($_POST['step']);
        if (!in_array($step, array('base', 'identity', 'bank', 'pic'))) {
            return $this->showmessage('操作异常，请检查', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        if (!$store_info) {
            return $this->showmessage('店铺信息不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($step == 'base') {
            $data = array(
                'cat_id'         => !empty($_POST['store_cat']) ? $_POST['store_cat'] : '',
                'merchants_name' => !empty($_POST['merchants_name']) ? $_POST['merchants_name'] : '',
                'shop_keyword'   => !empty($_POST['shop_keyword']) ? $_POST['shop_keyword'] : '',
                'email'          => !empty($_POST['email']) ? $_POST['email'] : '',
                'contact_mobile' => !empty($_POST['contact_mobile']) ? $_POST['contact_mobile'] : '',
                'address'        => !empty($_POST['address']) ? $_POST['address'] : '',
                'province'       => !empty($_POST['province']) ? $_POST['province'] : '',
                'city'           => !empty($_POST['city']) ? $_POST['city'] : '',
                'district'       => !empty($_POST['district']) ? $_POST['district'] : '',
                'street'         => !empty($_POST['street']) ? $_POST['street'] : '',
                'longitude'      => !empty($_POST['longitude']) ? $_POST['longitude'] : '',
                'latitude'       => !empty($_POST['latitude']) ? $_POST['latitude'] : '',
                'manage_mode'    => !empty($_POST['manage_mode']) ? $_POST['manage_mode'] : 'join',
                'shop_close'     => isset($_POST['shop_close']) ? $_POST['shop_close'] : 1,
                'expired_time'   => !empty($_POST['expired_time']) ? RC_Time::local_strtotime($_POST['expired_time']) : 0,
            );

            if ($_POST['shop_close'] == '1') {
                clear_cart_list($store_id);
            }
            if ($store_info['identity_status'] != 2 && $data['shop_close'] == 0 && ecjia::config('store_identity_certification') == 1) {
                return $this->showmessage('未认证通过不能开启店铺', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($data['merchants_name'])) {
                return $this->showmessage('店铺名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($data['contact_mobile'])) {
                return $this->showmessage('联系手机不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($data['email'])) {
                return $this->showmessage('邮箱不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $is_exist = RC_DB::table('store_franchisee')->where('store_id', '<>', $store_id)->where('merchants_name', $data['merchants_name'])->get();
            if ($is_exist) {
                return $this->showmessage('店铺名称已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $is_exist = RC_DB::table('store_franchisee')->where('store_id', '<>', $store_id)->where('contact_mobile', $data['contact_mobile'])->get();
            if ($is_exist) {
                return $this->showmessage('联系手机已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $is_exist = RC_DB::table('store_franchisee')->where('store_id', '<>', $store_id)->where('email', $data['email'])->get();
            if ($is_exist) {
                return $this->showmessage('邮箱已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('mobile', $data['contact_mobile'])->get();
            if ($is_exist) {
                return $this->showmessage('联系手机员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('email', $data['email'])->get();
            if ($is_exist) {
                return $this->showmessage('邮箱员工中已存在，请修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $geohash         = RC_Loader::load_app_class('geohash', 'store');
            $geohash_code    = $geohash->encode($_POST['latitude'], $_POST['longitude']);
            $geohash_code    = substr($geohash_code, 0, 10);
            $data['geohash'] = $geohash_code;

            set_merchant_config($store_id, 'shop_review_goods', $_POST['shop_review_goods']);

            $store_franchisee_db = RC_Model::model('store/orm_store_franchisee_model');
            /* 释放app缓存*/
            $store_cache_array = $store_franchisee_db->get_cache_item('store_list_cache_key_array');
            if (!empty($store_cache_array)) {
                foreach ($store_cache_array as $val) {
                    $store_franchisee_db->delete_cache_item($val);
                }
                $store_franchisee_db->delete_cache_item('store_list_cache_key_array');
            }

        } else if ($step == 'identity') {
            $data = array(
                'responsible_person' => !empty($_POST['responsible_person']) ? $_POST['responsible_person'] : '',
                'company_name'       => !empty($_POST['company_name']) ? $_POST['company_name'] : '',
                'identity_type'      => !empty($_POST['identity_type']) ? $_POST['identity_type'] : '',
                'identity_number'    => !empty($_POST['identity_number']) ? $_POST['identity_number'] : '',
                'business_licence'   => !empty($_POST['business_licence']) ? $_POST['business_licence'] : '',
            );
        } else if ($step == 'bank') {
            $data = array(
                'bank_account_name'   => !empty($_POST['bank_account_name']) ? $_POST['bank_account_name'] : '',
                'bank_name'           => !empty($_POST['bank_name']) ? $_POST['bank_name'] : '',
                'bank_branch_name'    => !empty($_POST['bank_branch_name']) ? $_POST['bank_branch_name'] : '',
                'bank_account_number' => !empty($_POST['bank_account_number']) ? $_POST['bank_account_number'] : '',
                'bank_address'        => !empty($_POST['bank_address']) ? $_POST['bank_address'] : '',
            );
        } else if ($step == 'pic') {
            if (!empty($_FILES['one']['name'])) {
                $upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
                $info   = $upload->upload($_FILES['one']);
                if (!empty($info)) {
                    $business_licence_pic = $upload->get_position($info);
                    $upload->remove($store_info['business_licence_pic']);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $business_licence_pic = $store_info['business_licence_pic'];
            }

            if (!empty($_FILES['two']['name'])) {
                $upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
                $info   = $upload->upload($_FILES['two']);
                if (!empty($info)) {
                    $identity_pic_front = $upload->get_position($info);
                    $upload->remove($store_info['identity_pic_front']);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $identity_pic_front = $store_info['identity_pic_front'];
            }

            if (!empty($_FILES['three']['name'])) {
                $upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
                $info   = $upload->upload($_FILES['three']);
                if (!empty($info)) {
                    $identity_pic_back = $upload->get_position($info);
                    $upload->remove($store_info['identity_pic_back']);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $identity_pic_back = $store_info['identity_pic_back'];
            }

            if (!empty($_FILES['four']['name'])) {
                $upload = RC_Upload::uploader('image', array('save_path' => 'data/store', 'auto_sub_dirs' => false));
                $info   = $upload->upload($_FILES['four']);
                if (!empty($info)) {
                    $personhand_identity_pic = $upload->get_position($info);
                    $upload->remove($store_info['personhand_identity_pic']);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } else {
                $personhand_identity_pic = $store_info['personhand_identity_pic'];
            }

            $data = array(
                'identity_pic_front'      => $identity_pic_front,
                'identity_pic_back'       => $identity_pic_back,
                'personhand_identity_pic' => $personhand_identity_pic,
                'business_licence_pic'    => $store_info['validate_type'] == 2 ? $business_licence_pic : null,
            );
        }

        /* $data = array(
        'cat_id'                          => !empty($_POST['store_cat'])         ? $_POST['store_cat'] : '',
        'merchants_name'               => !empty($_POST['merchants_name']) ? $_POST['merchants_name'] : '',
        'shop_keyword'              => !empty($_POST['shop_keyword'])     ? $_POST['shop_keyword'] : '',
        'responsible_person'        => !empty($_POST['responsible_person']) ? $_POST['responsible_person'] : '',
        'company_name'              => !empty($_POST['company_name'])         ? $_POST['company_name'] : '',
        'email'                      => !empty($_POST['email'])                 ? $_POST['email'] : '',
        'contact_mobile'            => !empty($_POST['contact_mobile'])     ? $_POST['contact_mobile'] : '',
        'address'                      => !empty($_POST['address'])             ? $_POST['address'] : '',
        'identity_type'             => !empty($_POST['identity_type'])         ? $_POST['identity_type'] : '',
        'identity_number'           => !empty($_POST['identity_number'])     ? $_POST['identity_number'] : '',
        'identity_pic_front'        => $identity_pic_front,
        'identity_pic_back'         => $identity_pic_back,
        'personhand_identity_pic'     => $personhand_identity_pic,
        'bank_account_name'          => !empty($_POST['bank_account_name'])     ? $_POST['bank_account_name'] : '',
        'business_licence_pic'         => $store_info['validate_type']  == 2 ? $business_licence_pic : null,
        'business_licence'          => !empty($_POST['business_licence'])         ? $_POST['business_licence'] : '',
        'bank_name'                     => !empty($_POST['bank_name'])                 ? $_POST['bank_name'] : '',
        'bank_branch_name'             => !empty($_POST['bank_branch_name'])         ? $_POST['bank_branch_name'] : '',
        'bank_account_number'          => !empty($_POST['bank_account_number'])    ? $_POST['bank_account_number'] : '',
        'province'                    => !empty($_POST['province'])                ? $_POST['province'] : '',
        'city'                        => !empty($_POST['city'])                    ? $_POST['city'] : '',
        'district'                    => !empty($_POST['district'])                ? $_POST['district'] : '',
        'bank_address'                 => !empty($_POST['bank_address'])             ? $_POST['bank_address'] : '',
        ); */

        $sn = RC_DB::table('store_franchisee')->where('store_id', $store_id)->update($data);
        ecjia_admin::admin_log(RC_Lang::get('store::store.edit_store') . ' ' . RC_Lang::get('store::store.store_title_lable') . $store_info['merchants_name'], 'update', 'store');
        return $this->showmessage(RC_Lang::get('store::store.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,
            array('pjaxurl' => RC_Uri::url('store/admin/edit', array('store_id' => $store_id, 'step' => $step))));
    }

    /**
     * 查看商家详细信息
     */
    public function preview()
    {
        $this->admin_priv('store_affiliate_manage');
        $store_id = intval($_GET['store_id']);

        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        if ($store['manage_mode'] == 'self' && $_SESSION['action_list'] == 'all') {
            $this->assign('action_link_self', array('href' => RC_Uri::url('store/admin/autologin', array('store_id' => $store_id)), 'text' => '进入商家后台'));
        }
        if ($store['manage_mode'] == 'self') {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => '自营店铺列表'));
        } else {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => RC_Lang::get('store::store.store_list')));
        }

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('基本信息'));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_preview');

        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $store['apply_time']   = RC_Time::local_date(ecjia::config('time_format'), $store['apply_time']);
        $store['confirm_time'] = RC_Time::local_date(ecjia::config('time_format'), $store['confirm_time']);
        $store['expired_time'] = RC_Time::local_date('Y-m-d', $store['expired_time']);

        $store['province'] = ecjia_region::getRegionName($store['province']);
        $store['city']     = ecjia_region::getRegionName($store['city']);
        $store['district'] = ecjia_region::getRegionName($store['district']);
        $store['street']   = ecjia_region::getRegionName($store['street']);

        $this->assign('ur_here', $store['merchants_name']);
        $store['cat_name'] = RC_DB::table('store_category')->where('cat_id', $store['cat_id'])->pluck('cat_name');
        if ($store['percent_id']) {
            $store['percent_value'] = RC_DB::table('store_percent')->where('percent_id', $store['percent_id'])->pluck('percent_value');
        }
        $store['shop_review_goods'] = get_merchant_config($store_id, 'shop_review_goods');
//        $store['franchisee_amount'] = ecjia_price_format($store['franchisee_amount']);

        $this->assign('store', $store);

        $this->display('store_preview.dwt');
    }

    //自营商家自动登录
    public function autologin()
    {
        $store_id = intval($_GET['store_id']);
        $store    = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        if ($store['manage_mode'] == 'self' && $_SESSION['action_list'] == 'all') {
            $cookie_name    = RC_Config::get('session.session_admin_name');
            $authcode_array = array(
                'admin_token' => RC_Cookie::get($cookie_name),
                'store_id'    => $store_id,
                'time'        => RC_Time::gmtime(),
            );
            $authcode_str   = http_build_query($authcode_array);
            $authcode       = RC_Crypt::encrypt($authcode_str);

            if (defined('RC_SITE')) {
                $index = 'sites/' . RC_SITE . '/index.php';
            } else {
                $index = 'index.php';
            }
            $url = str_replace($index, "sites/merchant/index.php", RC_Uri::url('staff/privilege/autologin')) . '&authcode=' . $authcode;
            return $this->redirect($url);
        }
    }

    /**
     * 资质认证
     */
    public function auth()
    {
        $this->admin_priv('store_auth_manage');

        $store_id = intval($_GET['store_id']);
        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        if ($store['manage_mode'] == 'self') {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => '自营店铺列表'));
        } else {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => RC_Lang::get('store::store.store_list')));
        }

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('资质认证'));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_auth');

        $this->assign('ur_here', $store['merchants_name'] . ' - 资质认证');
        $this->assign('form_action', RC_Uri::url('store/admin/auth_update'));
        $this->assign('store', $store);
        $this->display('store_auth.dwt');
    }

    public function auth_update()
    {
        $this->admin_priv('store_auth_manage', ecjia::MSGTYPE_JSON);

        $store_id = intval($_POST['store_id']);
        if (empty($store_id)) {
            return $this->showmessage('参数错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //0、待审核，1、审核中，2、审核通过，3、拒绝通过',
        $data = array();
        if (isset($_POST['check_ing'])) {
            $data['identity_status'] = 1;
        }
        if (isset($_POST['check_no'])) {
            $data['identity_status'] = 3;
        }
        if (isset($_POST['check_yes'])) {
            $data['identity_status'] = 2;
        }

        if (RC_DB::table('store_franchisee')->where('store_id', $store_id)->update($data)) {
            return $this->showmessage('操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/auth', array('store_id' => $store_id))));
        } else {
            return $this->showmessage('操作失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 锁定商家
     */
    public function status()
    {
        $this->admin_priv('store_affiliate_lock');

        $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => RC_Lang::get('store::store.store_list')));

        $store_id = $_GET['store_id'];
        $status   = $_GET['status'];
        if ($status == 1) {
            $this->assign('ur_here', '锁定店铺');
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('锁定店铺'));
        } else {
            $this->assign('ur_here', '店铺解锁');
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('店铺解锁'));
        }
        $this->assign('status', $status);
        $this->assign('form_action', RC_Uri::url('store/admin/status_update', array('store_id' => $store_id, 'status' => $status)));

        $this->display('store_lock.dwt');
    }

    /**
     * 锁定解锁商家操作
     */
    public function status_update()
    {
        $this->admin_priv('store_affiliate_lock', ecjia::MSGTYPE_JSON);

        $store_id = $_GET['store_id'];
        $status   = $_GET['status'];

        if ($status == 1) {
            $status_new   = 2;
            $status_label = '锁定';
        } elseif ($status == 2) {
            $status_new   = 1;
            $status_label = '解锁';
        }
        $store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        RC_DB::table('store_franchisee')->where('store_id', $store_id)->update(array('status' => $status_new));

        $store_franchisee_db = RC_Model::model('store/orm_store_franchisee_model');
        /* 释放app缓存*/
        $store_cache_array = $store_franchisee_db->get_cache_item('store_list_cache_key_array');
        if (!empty($store_cache_array)) {
            foreach ($store_cache_array as $val) {
                $store_franchisee_db->delete_cache_item($val);
            }
            $store_franchisee_db->delete_cache_item('store_list_cache_key_array');
        }

        clear_cart_list($store_id);
        ecjia_admin::admin_log('店铺' . $status_label . ' ' . RC_Lang::get('store::store.store_title_lable') . $store_info['merchants_name'], 'update', 'store');
        return $this->showmessage('操作成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
    }

    /**
     * 获取商家店铺经纬度
     */
    public function get_longitude()
    {
        $detail_address = !empty($_POST['detail_address']) ? urlencode($_POST['detail_address']) : '';
        $store_id       = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        if (empty($detail_address)) {
            return $this->showmessage('详细地址不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $key       = ecjia::config('map_qq_key');
        $location  = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=" . $detail_address . "&key=" . $key);
        $location  = json_decode($location['body'], true);
        $location  = $location['result']['location'];
        $longitude = $location['lng'];
        $latitude  = $location['lat'];
        //获取geohash值
        $geohash      = RC_Loader::load_app_class('geohash', 'store');
        $geohash_code = $geohash->encode($location['lat'], $location['lng']);
        $geohash_code = substr($geohash_code, 0, 10);
        RC_DB::table('store_franchisee')->where('store_id', $store_id)->update(array('longitude' => $longitude, 'latitude' => $latitude, 'geohash' => $geohash_code));
        $data = array('longitude' => $longitude, 'latitude' => $latitude, 'geohash' => $geohash_code);
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $data));
    }

    //获取入驻商列表信息
    private function store_list($manage_mode)
    {
        $db_store_franchisee = RC_DB::table('store_franchisee as sf');

        $filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
        $filter['type']     = empty($_GET['type']) ? '' : trim($_GET['type']);
        $filter['cat']      = empty($_GET['cat']) ? null : trim($_GET['cat']);

        $db_store_franchisee->where('manage_mode', $manage_mode);

        if ($filter['keywords']) {
            $db_store_franchisee->where(function ($query) use ($filter) {
                $query->where('merchants_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%')
                    ->orWhere('contact_mobile', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
            });
        }
        if ($filter['cat']) {
            if ($filter['cat'] == -1) {
                $db_store_franchisee->whereRaw('sf.cat_id=0');
            } else {
                $db_store_franchisee->whereRaw('sf.cat_id=' . $filter['cat']);
            }
        }

        $filter_type = $db_store_franchisee
            ->select(RC_DB::raw('count(*) as count_all'),
                RC_DB::raw('SUM(status = 1) as count_unlock'),
                RC_DB::raw('SUM(status = 2) as count_locking'))
            ->first();

        $filter['count_all']     = $filter_type['count_all'] ? $filter_type['count_all'] : 0;
        $filter['count_unlock']  = $filter_type['count_unlock'] ? $filter_type['count_unlock'] : 0;
        $filter['count_locking'] = $filter_type['count_locking'] ? $filter_type['count_locking'] : 0;
        if (!empty($filter['type'])) {
            $db_store_franchisee->where('status', $filter['type']);
        }
        if ($filter['type'] == 1) {
            $count = $filter_type['count_unlock'];
        } else if ($filter['type'] == 2) {
            $count = $filter_type['count_locking'];
        } else {
            $count = $filter_type['count_all'];
        }

        $page = new ecjia_page($count, 20, 5);

        $data = $db_store_franchisee
            ->leftJoin('store_category as sc', RC_DB::raw('sf.cat_id'), '=', RC_DB::raw('sc.cat_id'))
            ->select(RC_DB::raw('sf.store_id,sf.merchants_name,sf.manage_mode,sf.contact_mobile,sf.responsible_person,sf.confirm_time,sf.company_name,sf.sort_order,sc.cat_name,sf.status'))
            ->orderby('store_id', 'asc')
            ->take($page->page_size)
            ->skip($page->start_id - 1)
            ->get();

        $res = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                $row['confirm_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['confirm_time']);
                $res[]               = $row;
            }
        }

        return array('store_list' => $res, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    /**
     * 获取店铺分类表
     */
    private function get_cat_select_list()
    {
        $data     = RC_DB::table('store_category')
            ->select('cat_id', 'cat_name')
            ->orderBy('cat_id', 'desc')
            ->get();
        $cat_list = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                $cat_list[$row['cat_id']] = $row['cat_name'];
            }
        }
        return $cat_list;
    }

    /**
     * 查看店铺日志
     */
    public function view_log()
    {
        $this->admin_priv('store_log_manage');

        $store_id = intval($_GET['store_id']);
        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $store_jslang = array(
            'choose_delet_time' => __('请先选择删除日志的时间！'),
            'delet_ok_1'        => __('确定删除'),
            'delet_ok_2'        => __('的日志吗？'),
            'ok'                => __('确定'),
            'cancel'            => __('取消'),
        );
        RC_Script::localize_script('store', 'store', $store_jslang);

        $merchants_name = RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');
        $this->assign('merchants_name', $merchants_name);
        $this->assign('ur_here', $merchants_name . ' - 查看日志');

        $logs    = $this->get_admin_logs($_REQUEST, $store_id);
        $user_id = !empty($_REQUEST['userid']) ? intval($_REQUEST['userid']) : 0;
        $ip      = !empty($_REQUEST['ip']) ? $_REQUEST['ip'] : '';
        $keyword = !empty($_REQUEST['keyword']) ? trim(htmlspecialchars($_REQUEST['keyword'])) : '';

        $this->assign('user_id', $user_id);
        $this->assign('ip', $ip);
        $this->assign('keyword', $keyword);
        /* 查询IP地址列表 */
        $ip_list = array();
        $data    = RC_DB::table('staff_log')->select(RC_DB::raw('distinct ip_address'))->get();
        if (!empty($data)) {
            foreach ($data as $row) {
                $ip_list[] = $row['ip_address'];
            }
        }

        /* 查询管理员列表 */
        $user_list = array();
        $userdata  = RC_DB::table('staff_user')->where(RC_DB::raw('store_id'), $store_id)->get();
        if (!empty($userdata)) {
            foreach ($userdata as $row) {
                if (!empty($row['user_id']) && !empty($row['name'])) {
                    $user_list[$row['user_id']] = $row['name'];
                }
            }
        }

        $this->assign('form_search_action', RC_Uri::url('store/admin/view_log', array('store_id' => $store_id)));

        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        if ($store['manage_mode'] == 'self') {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => '自营店铺列表'));
        } else {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => RC_Lang::get('store::store.store_list')));
        }

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('查看日志'));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_view_log');

        $this->assign('logs', $logs);
        $this->assign('ip_list', $ip_list);
        $this->assign('user_list', $user_list);
        $this->display('staff_log.dwt');
    }

    public function check_log()
    {
        $this->admin_priv('store_preaudit_check_log');

        $store_id = intval($_GET['store_id']);
        $store    = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        if ($store['manage_mode'] == 'self') {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => '自营店铺列表'));
        } else {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => RC_Lang::get('store::store.store_list')));
        }

        $this->assign('store', $store);
        $this->assign('ur_here', $store['merchants_name'] . ' - ' . '审核申请日志');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('审核申请日志'));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_check_log');

        $log = get_check_log($store_id, 2, 1, 15);
        $this->assign('log_list', $log);

        $this->display('store_preaudit_check_log.dwt');
    }

    /**
     *  获取管理员操作记录
     * @param array $_GET , $_POST, $_REQUEST 参数
     * @return array 'list', 'page', 'desc'
     */
    private function get_admin_logs($args = array(), $store_id)
    {
        $db_staff_log = RC_DB::table('staff_log as sl')
            ->leftJoin('staff_user as su', RC_DB::raw('sl.user_id'), '=', RC_DB::raw('su.user_id'));

        $user_id = !empty($args['user_id']) ? intval($args['user_id']) : 0;
        $ip      = !empty($args['ip']) ? $args['ip'] : '';

        $filter               = array();
        $filter['sort_by']    = !empty($args['sort_by']) ? safe_replace($args['sort_by']) : RC_DB::raw('sl.log_id');
        $filter['sort_order'] = !empty($args['sort_order']) ? safe_replace($args['sort_order']) : 'DESC';

        $keyword = !empty($args['keyword']) ? trim(htmlspecialchars($args['keyword'])) : '';

        //查询条件
        $where = array();
        if (!empty($ip)) {
            $db_staff_log->where(RC_DB::raw('sl.ip_address'), $ip);
        }

        if (!empty($keyword)) {
            $db_staff_log->where(RC_DB::raw('sl.log_info'), 'like', '%' . $keyword . '%');
        }

        if (!empty($user_id)) {
            $db_staff_log->where(RC_DB::raw('su.user_id'), $user_id);
        }
        $db_staff_log->where(RC_DB::raw('sl.store_id'), $store_id);

        $count = $db_staff_log->count();
        $page  = new ecjia_page($count, 15, 5);
        $data  = $db_staff_log
            ->select(RC_DB::raw('sl.log_id,sl.log_time,sl.log_info,sl.ip_address,sl.ip_location,su.name'))
            ->orderby($filter['sort_by'], $filter['sort_order'])
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();
        /* 获取管理员日志记录 */
        $list = array();
        if (!empty($data)) {
            foreach ($data as $rows) {
                $rows['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['log_time']);
                $list[]           = $rows;
            }
        }
        return array('list' => $list, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    /**
     * 批量删除管理员操作日志
     */
    public function batch_drop()
    {
        $this->admin_priv('store_log_delete', ecjia::MSGTYPE_JSON);

        $drop_type_date = isset($_POST['drop_type_date']) ? $_POST['drop_type_date'] : '';
        $staff_log      = RC_DB::table('staff_log');
        $store_id       = $_GET['store_id'];

        /* 按日期删除日志 */
        if ($drop_type_date) {
            if ($_POST['log_date'] > 0) {
                $where = array();
                switch ($_POST['log_date']) {
                    case 1:
                        $a_week = RC_Time::gmtime() - (3600 * 24 * 7);
                        $staff_log->where('log_time', '<=', $a_week);
                        $deltime = __('一周之前');
                        break;
                    case 2:
                        $a_month = RC_Time::gmtime() - (3600 * 24 * 30);
                        $staff_log->where('log_time', '<=', $a_month);
                        $deltime = __('一个月前');
                        break;
                    case 3:
                        $three_month = RC_Time::gmtime() - (3600 * 24 * 90);
                        $staff_log->where('log_time', '<=', $three_month);
                        $deltime = __('三个月前');
                        break;
                    case 4:
                        $half_year = RC_Time::gmtime() - (3600 * 24 * 180);
                        $staff_log->where('log_time', '<=', $half_year);
                        $deltime = __('半年之前');
                        break;
                    case 5:
                    default:
                        $a_year = RC_Time::gmtime() - (3600 * 24 * 365);
                        $staff_log->where('log_time', '<=', $a_year);
                        $deltime = __('一年之前');
                        break;
                }

                $staff_log->where('store_id', $store_id)->delete();

                return $this->showmessage(sprintf(__('%s 的日志成功删除。'), $deltime), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin/view_log', array('store_id' => $store_id))));
            }
        } else {
            return $this->showmessage(__('请选择日期'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 根据地区获取经纬度
     */
    public function getgeohash()
    {
        $shop_province = !empty($_REQUEST['province']) ? trim($_REQUEST['province']) : '';
        $shop_city     = !empty($_REQUEST['city']) ? trim($_REQUEST['city']) : '';
        $shop_district = !empty($_REQUEST['district']) ? trim($_REQUEST['district']) : '';
        $shop_street   = !empty($_REQUEST['street']) ? trim($_REQUEST['street']) : '';
        $shop_address  = !empty($_REQUEST['address']) ? trim($_REQUEST['address']) : '';

        if (empty($shop_province)) {
            return $this->showmessage('请选择省份', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'province'));
        }
        if (empty($shop_city)) {
            return $this->showmessage('请选择城市', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'city'));
        }
        if (empty($shop_district)) {
            return $this->showmessage('请选择地区', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'district'));
        }
        if (empty($shop_address)) {
            return $this->showmessage('请填写详细地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'address'));
        }

        $key = ecjia::config('map_qq_key');
        if (empty($key)) {
            return $this->showmessage('腾讯地图key不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $province_name = ecjia_region::getRegionName($shop_province);
        $city_name     = ecjia_region::getRegionName($shop_city);
        $district_name = ecjia_region::getRegionName($shop_district);
        $street_name   = ecjia_region::getRegionName($shop_street);

        $address = '';
        if (!empty($province_name)) {
            $address .= $province_name;
        }
        if (!empty($city_name)) {
            $address .= $city_name;
        }
        if (!empty($district_name)) {
            $address .= $district_name;
        }
        if (!empty($street_name)) {
            $address .= $street_name;
        }
        $address    .= $shop_address;
        $address    = urlencode($address);
        $shop_point = RC_Http::remote_get("https://apis.map.qq.com/ws/geocoder/v1/?address=" . $address . "&key=" . $key);
        $shop_point = json_decode($shop_point['body'], true);

        if ($shop_point['status'] != 0) {
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $shop_point);
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $shop_point);
    }

    public function progress()
    {
        $this->admin_priv('store_self_manage');
        $type = trim($_GET['type']);
        $from = trim($_GET['from']);

        if ($from == 'self') {
            ecjia_screen::get_current_screen()->remove_last_nav_here();
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('自营店铺', RC_Uri::url('store/admin/init')));
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => '自营店铺列表'));
        } else {
            ecjia_screen::get_current_screen()->remove_last_nav_here();
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('store::store.store'), RC_Uri::url('store/admin/join')));
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => RC_Lang::get('store::store.store_list')));
        }
        $url = RC_App::apps_url('statics/', __FILE__);
        if ($type == 'bill') {
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('结算流程'));
            $this->assign('ur_here', '结算流程');
        } else {
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('入驻流程'));
            $this->assign('ur_here', '入驻流程');
        }

        $this->assign('type', $type);
        $this->assign('url', $url);
        $this->display('store_progress.dwt');
    }

}

//end

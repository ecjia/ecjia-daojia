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
 * 查看员工
 */
class admin_store_staff extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global', 'store');
        RC_Loader::load_app_func('merchant_store', 'store');

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

        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        RC_Script::enqueue_script('store', RC_App::apps_url('statics/js/admin_store_staff.js', __FILE__), array(), false, 1);
        RC_Script::enqueue_script('qq_map', ecjia_location_mapjs());
        RC_Script::localize_script('store', 'js_lang', config('app-staff::jslang.staff_page'));

        $store_id = intval($_GET['store_id']);
        $store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $nav_here = __('入驻商家', 'staff');
        $url = RC_Uri::url('store/admin/join');
        if ($store_info['manage_mode'] == 'self') {
        	$nav_here = __('自营店铺', 'staff');
        	$url = RC_Uri::url('store/admin/init');
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, $url));
    }

    /**
     * 查看员工
     */
    public function init()
    {
        $this->admin_priv('store_staff_manage');
        
        $store_id   = intval($_GET['store_id']);
        $main_staff = RC_DB::table('staff_user')->where('store_id', $store_id)->where('parent_id', 0)->first();
        $store      = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('查看员工', 'staff')));
        
        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_view_staff');

        $parent_id  = $main_staff['user_id'];
        $staff_list = RC_DB::table('staff_user')->where('parent_id', $parent_id)->get();

        $main_staff['avatar']   = !empty($main_staff['avatar']) ? RC_Upload::upload_url($main_staff['avatar']) : RC_App::apps_url('statics/images/ecjia_avatar.jpg', __FILE__);
        $main_staff['add_time'] = RC_Time::local_date('Y-m-d', $main_staff['add_time']);
        foreach ($staff_list as $key => $val) {
            $staff_list[$key]['add_time'] = RC_Time::local_date('Y-m-d', $val['add_time']);
        }

       	if ($store['manage_mode'] == 'self') {
        	$this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => __('自营店铺列表', 'staff')));
        } else {
        	$this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => __('入驻商家列表', 'staff')));
        }
        $this->assign('ur_here', $store['merchants_name'] . ' - ' . __('查看员工', 'staff'));
        $this->assign('main_staff', $main_staff);
        $this->assign('staff_list', $staff_list);
        $this->assign('current_url', RC_Uri::current_url());

        $this->assign('store', $store);
        $this->display('store_staff.dwt');
    }

    public function edit()
    {
        $this->admin_priv('store_staff_edit');

        $store_id   = intval($_GET['store_id']);
        $main_staff = intval($_GET['main_staff']);
        $store      = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
       	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑店长', 'staff')));
        
        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_view_staff');
        
        if (empty($store)) {
            return $this->showmessage(__('店铺信息不存在！', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $this->assign('action_link', array('href' => RC_Uri::url('staff/admin_store_staff/init', array('store_id' => $store_id)), 'text' => __('查看员工', 'staff')));
        $this->assign('ur_here', $store['merchants_name'] . __(' - 编辑店长', 'staff'));
        $this->assign('store', $store);

        if ($main_staff == 1) {
            //店长
            $info = RC_DB::table('staff_user')->where('store_id', $store_id)->where('parent_id', 0)->first();
        }
        $this->assign('info', $info);
        $this->assign('form_action', RC_Uri::url('staff/admin_store_staff/update'));

        $this->display('store_staff_edit.dwt');
    }

    public function update()
    {
        $this->admin_priv('store_staff_edit');

        $store_id     = intval($_POST['store_id']);
        $staff_id     = intval($_POST['staff_id']);
        $user_name    = trim($_POST['user_name']);
        $mobile       = trim($_POST['contact_mobile']);
        $email        = trim($_POST['email']);
        $user_ident   = trim($_POST['user_ident']);
        $nick_name    = trim($_POST['nick_name']);
        $introduction = trim($_POST['introduction']);
        $store        = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        if (empty($user_name)) {
            return $this->showmessage(__('店铺信息不存在！', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($user_name)) {
            return $this->showmessage(__('姓名不能为空', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($mobile)) {
            return $this->showmessage(__('联系手机不能为空', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
//         $chars = "/^1(3|4|5|6|7|8|9)\d{9}$/";
//         if (!preg_match($chars, $mobile)) {
//             return $this->showmessage(__('手机号码格式错误', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//         }
        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile);
        if (is_ecjia_error($check_mobile)) {
            return $this->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($email)) {
            return $this->showmessage(__('邮箱不能为空', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('mobile', $mobile)->get();
        if ($is_exist) {
            return $this->showmessage(__('联系手机员工中已存在，请修改', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $is_exist = RC_DB::table('staff_user')->where('store_id', '<>', $store_id)->where('email', $email)->get();
        if ($is_exist) {
            return $this->showmessage(__('邮箱员工中已存在，请修改', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'mobile'       => $mobile,
            'name'         => $user_name,
            'email'        => $email,
            'user_ident'   => $user_ident,
            'nick_name'    => $nick_name,
            'introduction' => $introduction,
        );

        $rs = RC_DB::table('staff_user')->where('store_id', $store_id)->where('user_id', $staff_id)->update($data);

        return $this->showmessage(__('更新成功', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/admin_store_staff/init', array('store_id' => $store_id))));
    }

    public function reset_staff()
    {
        $this->admin_priv('store_staff_reset');

        $store_id   = intval($_GET['store_id']);
        $main_staff = intval($_GET['main_staff']);
        if ($main_staff == 1) {
            //店长
            $info = RC_DB::table('staff_user')->where('store_id', $store_id)->where('parent_id', 0)->first();
        }

        if (info) {
            $password = rand(100000, 999999);
            //短信发送通知
            $options = array(
                'mobile' => $info['mobile'],
                'event'  => 'sms_staff_reset_password',
                'value'  => array(
                    'user_name'     => $info['name'],
                    'account'       => $info['mobile'],
                    'password'      => $password,
                    'service_phone' => ecjia::config('service_phone'),
                ),
            );
            RC_Api::api('sms', 'send_event_sms', $options);
            $salt       = rand(1, 9999);
            $data_staff = array(
                'password' => md5(md5($password) . $salt),
                'salt'     => $salt,
            );
            $rs = RC_DB::table('staff_user')->where('store_id', $store_id)->where('user_id', $info['user_id'])->update($data_staff);

            if ($rs) {
                return $this->showmessage(__('重置成功', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/admin_store_staff/init', array('store_id' => $store_id))));
            } else {
                return $this->showmessage(__('重置失败', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
    }
    
    public function set()
    {
    	$this->admin_priv('store_staff_manage');
    	
 		$store_id   = intval($_GET['store_id']);
        $store      = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('员工设置', 'staff')));
        
        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_staff_set');

       	if ($store['manage_mode'] == 'self') {
        	$this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => __('自营店铺列表', 'staff')));
        } else {
        	$this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => __('入驻商家列表', 'staff')));
        }
        $this->assign('ur_here', $store['merchants_name'] . ' - ' . __('员工设置', 'staff'));
        $this->assign('form_action', RC_Uri::url('staff/admin_store_staff/set_update'));
        
        $merchant_info = get_merchant_info($store_id);
        //员工数量
        $has_merchant_staff_max_number = array_key_exists('merchant_staff_max_number', $merchant_info);
        if ($has_merchant_staff_max_number == false) {
        	$db = RC_DB::table('merchants_config');
        	$data = array('store_id' => $store_id, 'group' => 0, 'code' => 'merchant_staff_max_number', 'type' => '', 'store_range' => '', 'store_dir' => '', 'value' => 0, 'sort_order' => 1);
        	$db->insert($data);
        } else {
        	$store['merchant_staff_max_number'] = $merchant_info['merchant_staff_max_number'];
        }
        
    	$this->assign('store', $store);
    	$this->display('store_staff_set.dwt');
    }
    
    public function set_update()
    {
    	$this->admin_priv('store_staff_edit', ecjia::MSGTYPE_JSON);
    	
    	$store_id = intval($_POST['store_id']);
    	
    	$merchant_staff_max_number = !empty($_POST['merchant_staff_max_number']) ? intval($_POST['merchant_staff_max_number']) : 0;
    	RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'merchant_staff_max_number')->update(array('value' => $merchant_staff_max_number));
     	
    	return $this->showmessage(__('更新成功', 'staff'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/admin_store_staff/set', array('store_id' => $store_id))));
    }
}

//end

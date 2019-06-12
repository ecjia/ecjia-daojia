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
 * ECJIA 区域代理
 *
 */
class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_class('AgentRankList', 'agent', false);
        RC_Loader::load_app_class('Agent', 'agent', false);

        Ecjia\App\Agent\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');

        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);

        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);

        RC_Script::enqueue_script('region', RC_Uri::admin_url('statics/lib/ecjia_js/ecjia.region.js'));
        RC_Script::enqueue_script('agent', RC_App::apps_url('statics/js/agent.js', __FILE__), array(), false, 1);
        RC_Style::enqueue_style('agent', RC_App::apps_url('statics/css/agent.css', __FILE__));

        RC_Script::localize_script('agent', 'js_lang', config('app-agent::jslang.agent_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('代理商列表', 'agent'), RC_Uri::url('agent/admin/init')));
    }

    public function init()
    {
        $this->admin_priv('agent_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('代理商列表', 'agent')));

        $this->assign('ur_here', __('代理商列表', 'agent'));
        $this->assign('action_link', array('href' => RC_Uri::url('agent/admin/add'), 'text' => __('添加代理商', 'agent')));

        $list = $this->get_agent_list();
        $this->assign('list', $list);

        return $this->display('agent_list.dwt');
    }

    public function add()
    {
        $this->admin_priv('agent_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加代理商', 'agent')));

        $this->assign('ur_here', __('添加代理商', 'agent'));
        $this->assign('action_link', array('href' => RC_Uri::url('agent/admin/init'), 'text' => __('代理商列表', 'agent')));
        $this->assign('form_action', RC_Uri::url('agent/admin/insert'));

        $province = ecjia_region::getSubarea(ecjia::config('shop_country'));
        $this->assign('province', $province);

        $agent_rank_list = ecjia::config('agent_rank');
        if (empty($agent_rank_list)) {
            $agent_rank_list = AgentRankList::get_rank_list();

            ecjia_config::instance()->write_config('agent_rank', serialize($agent_rank_list));
        } else {
            $agent_rank_list = unserialize($agent_rank_list);
        }
        $this->assign('rank_list', $agent_rank_list);

        return $this->display('agent_edit.dwt');
    }

    public function insert()
    {
        $this->admin_priv('agent_update', ecjia::MSGTYPE_JSON);

        $name           = trim($_POST['agent_name']);
        $mobile_phone   = trim($_POST['mobile_phone']);
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : '';
        $login_password = trim($_POST['login_password']);
        $salt           = rand(1, 9999);
        $rank_code      = trim($_POST['agent_rank']);
        $province       = trim($_POST['province']);
        $city           = trim($_POST['city']);
        $district       = trim($_POST['district']);

        if (empty($name)) {
            return $this->showmessage(__('请输入代理商名称', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($mobile_phone)) {
            return $this->showmessage(__('请输入手机号码', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if (empty($email)) {
            return $this->showmessage(__('请输入邮箱账号', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($login_password)) {
            return $this->showmessage(__('请输入登录密码', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $name_count = RC_DB::table('staff_user')->where('name', $name)->count();
        if ($name_count > 0) {
            return $this->showmessage(__('该代理商名称已存在', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile_phone);
        if (is_ecjia_error($check_mobile)) {
            return $this->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $mobile_count = RC_DB::table('staff_user')->where('mobile', $mobile_phone)->count();
        if ($mobile_count > 0) {
            return $this->showmessage(__('该手机号码已存在', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $email_count = RC_DB::table('staff_user')->where('email', $email)->count();
        if ($email_count > 0) {
            return $this->showmessage(__('该邮箱账号已存在', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }


        $check_rank = $this->check_rank_code($rank_code, $province, $city, $district);
        if (is_ecjia_error($check_rank)) {
            return $this->showmessage($check_rank->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'mobile'       => $mobile_phone,
            'name'         => $name,
            'email'        => $email,
            'password'     => md5(md5($login_password) . $salt),
            'salt'         => $salt,
            'add_time'     => RC_Time::gmtime(),
            'last_ip'      => RC_Ip::client_ip(),
            'group_id'     => Ecjia\App\Staff\StaffGroupConstant::GROUP_AGENT,
            'introduction' => __('代理商', 'agent')
        );

        $id = RC_DB::table('staff_user')->insertGetId($data);

        if (empty($id)) {
            return $this->showmessage(__('添加失败', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $insert_data = array('user_id' => $id, 'rank_code' => $rank_code);

        $insert_data['province'] = $province;
        if ($rank_code == 'city_agent') {
            $insert_data['city'] = $city;
        } elseif ($rank_code == 'district_agent') {
            $insert_data['city']     = $city;
            $insert_data['district'] = $district;
        }
        RC_DB::table('agent_user')->insert($insert_data);

        ecjia_admin::admin_log($name, 'add', 'agent');

        return $this->showmessage(__('添加成功', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('agent/admin/edit', array('id' => $id))));
    }

    public function edit()
    {
        $this->admin_priv('agent_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑代理商', 'agent')));

        $this->assign('ur_here', __('编辑代理商', 'agent'));
        $this->assign('action_link', array('href' => RC_Uri::url('agent/admin/init'), 'text' => __('代理商列表', 'agent')));
        $this->assign('form_action', RC_Uri::url('agent/admin/update'));

        $id   = intval($_GET['id']);
        $data = Agent::get_agent_info($id);
        if (empty($data)) {
            return $this->showmessage(__('该代理商不存在', 'agent'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }
        $this->assign('data', $data);

        $province = ecjia_region::getSubarea(ecjia::config('shop_country'));
        $city     = ecjia_region::getSubarea($data['province']);
        $district = ecjia_region::getSubarea($data['city']);

        $this->assign('province', $province);
        $this->assign('city', $city);
        $this->assign('district', $district);

        $agent_rank_list = ecjia::config('agent_rank');
        $agent_rank_list = unserialize($agent_rank_list);

        $this->assign('rank_list', $agent_rank_list);

        return $this->display('agent_edit.dwt');
    }

    public function update()
    {
        $this->admin_priv('agent_update', ecjia::MSGTYPE_JSON);

        $id             = intval($_POST['id']);
        $name           = trim($_POST['agent_name']);
        $mobile_phone   = trim($_POST['mobile_phone']);
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : '';
        $login_password = trim($_POST['new_password']);
        $rank_code      = trim($_POST['agent_rank']);
        $province       = trim($_POST['province']);
        $city           = trim($_POST['city']);
        $district       = trim($_POST['district']);

        $data = Agent::get_agent_info($id);
        if (empty($data)) {
            return $this->showmessage(__('该代理商不存在', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($name)) {
            return $this->showmessage(__('请输入代理商名称', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($mobile_phone)) {
            return $this->showmessage(__('请输入手机号码', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($email)) {
            return $this->showmessage(__('请输入邮箱账号', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $name_count = RC_DB::table('staff_user')->where('name', $name)->where('user_id', '!=', $id)->count();
        if ($name_count > 0) {
            return $this->showmessage(__('该代理商名称已存在', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile_phone);
        if (is_ecjia_error($check_mobile)) {
            return $this->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $mobile_count = RC_DB::table('staff_user')->where('mobile', $mobile_phone)->where('user_id', '!=', $id)->count();
        if ($mobile_count > 0) {
            return $this->showmessage(__('该手机号码已存在', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $email_count = RC_DB::table('staff_user')->where('email', $email)->where('user_id', '!=', $id)->count();
        if ($email_count > 0) {
            return $this->showmessage(__('该邮箱账号已存在', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $check_rank = $this->check_rank_code($rank_code, $province, $city, $district, $id);
        if (is_ecjia_error($check_rank)) {
            return $this->showmessage($check_rank->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'mobile'   => $mobile_phone,
            'name'     => $name,
            'email'    => $email,
            'password' => !empty($login_password) ? md5(md5($login_password) . $data['salt']) : $data['password'],
            'last_ip'  => RC_Ip::client_ip(),
        );

        RC_DB::table('staff_user')->where('user_id', $id)->update($data);

        $update_data = array('user_id' => $id, 'rank_code' => $rank_code);

        $update_data['province'] = $province;
        $update_data['city']     = '';
        $update_data['district'] = '';
        if ($rank_code == 'city_agent') {
            $update_data['city'] = $city;
        } elseif ($rank_code == 'district_agent') {
            $update_data['city']     = $city;
            $update_data['district'] = $district;
        }
        RC_DB::table('agent_user')->where('user_id', $id)->update($update_data);

        ecjia_admin::admin_log($name, 'edit', 'agent');

        return $this->showmessage(__('编辑成功', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('agent/admin/edit', array('id' => $id))));
    }

    public function detail()
    {
        $this->admin_priv('agent_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('代理商详情', 'agent')));

        $this->assign('ur_here', __('代理商详情', 'agent'));
        $this->assign('action_link', array('href' => RC_Uri::url('agent/admin/init'), 'text' => __('代理商列表', 'agent')));

        $id   = intval($_GET['id']);
        $data = Agent::get_agent_info($id);
        if (empty($data)) {
            return $this->showmessage(__('该代理商不存在', 'agent'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        $rank_info          = Agent::get_agent_rank($data['rank_code']);
        $data['rank_name']  = $rank_info['rank_name'];
        $data['rank_alias'] = $rank_info['rank_alias'];

        $this->assign('data', $data);

        $count = Agent::get_count_info($id);
        $this->assign('count', $count);

        $store_list = $this->get_store_list($id);
        $this->assign('list', $store_list);

        return $this->display('agent_detail.dwt');
    }

    public function delete()
    {
        $this->admin_priv('agent_delete', ecjia::MSGTYPE_JSON);

        $id = intval($_GET['id']);

        $data = Agent::get_agent_info($id);

        RC_DB::table('staff_user')->where('user_id', $id)->delete();
        RC_DB::table('agent_user')->where('user_id', $id)->delete();

        ecjia_admin::admin_log($data['name'], 'remove', 'agent');

        return $this->showmessage(__('删除成功', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function batch()
    {
        $this->admin_priv('agent_delete', ecjia::MSGTYPE_JSON);

        $id = !empty($_POST['id']) ? explode(',', $_POST['id']) : '';
        if (empty($id)) {
            return $this->showmessage(__('请先选择要删除的代理商', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $name_list = RC_DB::table('staff_user')->whereIn('user_id', $id)->lists('name');

        RC_DB::table('staff_user')->whereIn('user_id', $id)->delete();
        RC_DB::table('agent_user')->whereIn('user_id', $id)->delete();

        if (!empty($name_list)) {
            foreach ($name_list as $v) {
                ecjia_admin::admin_log($v, 'batch_remove', 'agent');
            }
        }

        return $this->showmessage(__('删除成功', 'agent'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('agent/admin/init')));
    }

    private function get_agent_list()
    {
        $keywords   = trim($_GET['keywords']);
        $agent_rank = intval($_GET['agent_rank']);

        $db_staff_user = RC_DB::table('staff_user as s')
            ->leftJoin('agent_user as a', RC_DB::raw('s.user_id'), '=', RC_DB::raw('a.user_id'))
            ->where(RC_DB::raw('s.store_id'), 0)
            ->where(RC_DB::raw('s.group_id'), Ecjia\App\Staff\StaffGroupConstant::GROUP_AGENT);

        if (!empty($keywords)) {
            $db_staff_user->where(function ($query) use ($keywords) {
                $query->where(RC_DB::raw('s.name'), 'like', '%' . mysql_like_quote($keywords) . '%')
                    ->orWhere(RC_DB::raw('s.mobile'), 'like', '%' . mysql_like_quote($keywords) . '%');
            });
        }

        if (!empty($agent_rank)) {
            if ($agent_rank == 1) {
                $db_staff_user->where(RC_DB::raw('a.rank_code'), 'province_agent');
            } elseif ($agent_rank == 2) {
                $db_staff_user->where(RC_DB::raw('a.rank_code'), 'city_agent');
            } elseif ($agent_rank == 3) {
                $db_staff_user->where(RC_DB::raw('a.rank_code'), 'district_agent');
            }
        }

        $count  = $db_staff_user->count();
        $page   = new ecjia_page($count, 15, 5);
        $result = $db_staff_user->take(15)->skip($page->start_id - 1)->orderBy(RC_DB::raw('s.add_time'), 'desc')->get();

        $data = [];
        if (!empty($result)) {
            foreach ($result as $val) {
                if (!empty($val['add_time'])) {
                    $val['add_time']    = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
                    $val['area_region'] = ecjia_region::getRegionName($val['province']) . ' ' . ecjia_region::getRegionName($val['city']) . ' ' . ecjia_region::getRegionName($val['district']);
                    $rank_info          = Agent::get_agent_rank($val['rank_code']);
                    $val['rank_name']   = $rank_info['rank_name'];

                    if ($val['rank_code'] == 'province_agent') {
                        $val['store_count'] = RC_DB::table('store_franchisee')->where('province', $val['province'])->count();
                    } elseif ($val['rank_code'] == 'city_agent') {
                        $val['store_count'] = RC_DB::table('store_franchisee')->where('city', $val['city'])->count();
                    } elseif ($val['rank_code'] == 'district_agent') {
                        $val['store_count'] = RC_DB::table('store_franchisee')->where('district', $val['district'])->count();
                    }
                }
                $data[] = $val;
            }
        }

        return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    private function check_rank_code($rank_code = '', $province = '', $city = '', $district = '', $user_id = 0)
    {
        if (empty($rank_code)) {
            return new ecjia_error('rank_code_required', __('请选择代理等级', 'agent'));
        }

        $db_agent_user = RC_DB::table('agent_user')->where('rank_code', $rank_code);

        if (!empty($user_id)) {
            $db_agent_user->where('user_id', '!=', $user_id);
        }

        if ($rank_code == 'province_agent') {
            if (empty($province)) {
                return new ecjia_error('province_required', __('请选择省份', 'agent'));
            }
            $db_agent_user->where('province', $province);
            $message = __('该省份已存在一个代理商', 'agent');

        } elseif ($rank_code == 'city_agent') {
            if (empty($city)) {
                return new ecjia_error('city_required', __('请选择城市', 'agent'));
            }
            $db_agent_user->where('city', $city);
            $message = __('该城市已存在一个代理商', 'agent');

        } elseif ($rank_code == 'district_agent') {
            if (empty($district)) {
                return new ecjia_error('district_required', __('请选择地区', 'agent'));
            }
            $db_agent_user->where('district', $district);
            $message = __('该地区已存在一个代理商', 'agent');
        }

        $count = $db_agent_user->count();
        if (!empty($count)) {
            return new ecjia_error('agent_error', $message);
        }
    }

    private function get_store_list($id)
    {
        $data = Agent::get_agent_info($id);

        $db = RC_DB::table('store_franchisee');
        if ($data['rank_code'] == 'province_agent') {
            $count = $db->where('province', $data['province'])->count();
        } elseif ($data['rank_code'] == 'city_agent') {
            $count = $db->where('city', $data['city'])->count();
        } elseif ($data['rank_code'] == 'district_agent') {
            $count = $db->where('district', $data['district'])->count();
        }
        $page   = new ecjia_page($count, 15, 5);
        $result = $db->take(15)->skip($page->start_id - 1)->orderBy('apply_time', 'desc')->get();

        $data = [];
        if (!empty($result)) {
            foreach ($result as $val) {
                if (!empty($val['apply_time'])) {
                    $val['formated_apply_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['apply_time']);
                }
                $val['category_name'] = RC_DB::table('store_category')->where('cat_id', $val['cat_id'])->pluck('cat_name');

                $data[] = $val;
            }
        }

        return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

}

// end
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
 * 员工组管理
 */
class mh_group extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Staff\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Style::enqueue_style('staff', RC_App::apps_url('statics/css/staff.css', __FILE__), array());
        RC_Style::enqueue_style('bar', RC_App::apps_url('statics/css/bar.css', __FILE__), array());

        RC_Script::enqueue_script('staff_group', RC_App::apps_url('statics/js/staff_group.js', __FILE__));
        RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__), array(), false, true);
        RC_Script::enqueue_script('staff', RC_App::apps_url('statics/js/staff.js', __FILE__));
        RC_Script::enqueue_script('staff_logs', RC_App::apps_url('statics/js/staff_logs.js', __FILE__), array(), false, true);
        RC_Script::localize_script('staff_logs', 'js_lang', RC_Lang::get('staff::staff.js_lang'));

        ecjia_merchant_screen::get_current_screen()->set_parentage('staff', 'staff/merchant.php');
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('员工管理', RC_Uri::url('staff/mh_group/init')));
    }

    /**
     * 员工组展示
     */
    public function init()
    {
        $this->admin_priv('staff_group_manage');

        $this->assign('ur_here', '员工管理');

        $Manager               = RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('parent_id', 0)->first();
        $Manager['last_login'] = RC_Time::local_date('Y-m-d H:i', $Manager['last_login']);
        $Manager['add_time']   = RC_Time::local_date('Y-m-d', $Manager['add_time']);
        $this->assign('Manager', $Manager);

        $parent_id = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->pluck('parent_id');
        $this->assign('parent_id', $parent_id);

        $staff_group_list = $this->staff_group_list($_SESSION['store_id']);
        $this->assign('staff_group_list', $staff_group_list);
        $staff_count['express']      = RC_DB::table('staff_user')->where('group_id', -1)->where('store_id', $_SESSION['store_id'])->count();
        $staff_count['cashdesk']     = RC_DB::table('staff_user')->where('group_id', -2)->where('store_id', $_SESSION['store_id'])->count();
        $staff_count['unclassified'] = RC_DB::table('staff_user')->where('group_id', 0)->where('store_id', $_SESSION['store_id'])->where('parent_id', '>', 0)->count();
        $this->assign('staff_count', $staff_count);

        $this->assign('staff_admin', RC_App::apps_url('statics/images/staff_admin.png', __FILE__));
        $this->assign('staff_cashdesk', RC_App::apps_url('statics/images/staff_cashdesk.png', __FILE__));
        $this->assign('staff_express', RC_App::apps_url('statics/images/staff_express.png', __FILE__));
        $this->assign('staff_plus', RC_App::apps_url('statics/images/staff_plus.png', __FILE__));
        $this->assign('staff_edit', RC_App::apps_url('statics/images/staff_edit.png', __FILE__));

        //最大员工数量
        $merchant_staff_max_number = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'merchant_staff_max_number')->pluck('value');
		$max = !empty($merchant_staff_max_number) ? $merchant_staff_max_number : ecjia::config('merchant_staff_max_number');
		$this->assign('max', $max);
        
        $this->display('staff_customize.dwt');
    }

    /**
     * 添加员工组页面
     */
    public function add()
    {
        $this->admin_priv('staff_group_update');

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.staff_group_add')));
        $this->assign('ur_here', RC_Lang::get('staff::staff.staff_group_add'));
        $this->assign('action_link', array('href' => RC_Uri::url('staff/mh_group/init'), 'text' => '员工管理'));

        $priv_group = ecjia_merchant_purview::load_purview();
        $this->assign('priv_group', $priv_group);

        $this->assign('form_action', RC_Uri::url('staff/mh_group/insert'));

        $this->display('staff_group_edit.dwt');

    }

    /**
     * 处理添加员工组
     */
    public function insert()
    {
        $this->admin_priv('staff_group_update', ecjia::MSGTYPE_JSON);

        if (RC_DB::table('staff_group')->where('group_name', $_POST['group_name'])->where('store_id', $_SESSION['store_id'])->count() > 0) {
            return $this->showmessage('该员工组名称已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $action_list = join(",", $_POST['action_code']);
        $data        = array(
            'store_id'      => $_SESSION['store_id'],
            'group_name'    => !empty($_POST['group_name']) ? $_POST['group_name'] : '',
            'groupdescribe' => !empty($_POST['groupdescribe']) ? $_POST['groupdescribe'] : '',
            'action_list'   => $action_list,
        );

        $group_id = RC_DB::table('staff_group')->insertGetId($data);

        ecjia_merchant::admin_log($_POST['group_name'], 'add', 'staff_group');
        $links[] = array('text' => RC_Lang::get('staff::staff.back_staff_group_list'), 'href' => RC_Uri::url('staff/mh_group/init'));
        $links[] = array('text' => RC_Lang::get('staff::staff.continue_add_staff_group'), 'href' => RC_Uri::url('staff/mh_group/add'));
        return $this->showmessage(RC_Lang::get('staff::staff.staff_add_group_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('staff/mh_group/edit', array('group_id' => $group_id))));
    }

    /**
     * 编辑员工组页面
     */
    public function edit()
    {
        $this->admin_priv('staff_group_update');

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.staff_group_update')));
        $this->assign('ur_here', RC_Lang::get('staff::staff.staff_group_update'));
        $this->assign('action_link', array('href' => RC_Uri::url('staff/mh_group/init'), 'text' => '员工管理'));

        $group_id    = intval($_GET['group_id']);
        $staff_group = RC_DB::table('staff_group')->where('group_id', $group_id)->where('store_id', $_SESSION['store_id'])->first();
        if (empty($staff_group)) {
            $links[] = array('text' => '返回员工组列表', 'href' => RC_Uri::url('staff/mh_group/init'));
            return $this->showmessage('该员工组不存在', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }

        $this->assign('staff_group', $staff_group);
        $this->assign('edit', 'edit');
        $priv_group = ecjia_merchant_purview::load_purview($staff_group['action_list']);
        $this->assign('priv_group', $priv_group);

        $this->assign('form_action', RC_Uri::url('staff/mh_group/update'));

        $this->display('staff_group_edit.dwt');
    }

    /**
     * 编辑员工组信息处理
     */
    public function update()
    {
        $this->admin_priv('staff_group_update', ecjia::MSGTYPE_JSON);

        $action_list = join(",", $_POST['action_code']);
        $group_id    = intval($_POST['group_id']);
        if (RC_DB::table('staff_group')->where('group_name', $_POST['group_name'])->where('group_id', '!=', $group_id)->where('store_id', $_SESSION['store_id'])->count() > 0) {
            return $this->showmessage('该员工组名称已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $data = array(
            'group_name'    => !empty($_POST['group_name']) ? $_POST['group_name'] : '',
            'groupdescribe' => !empty($_POST['groupdescribe']) ? $_POST['groupdescribe'] : '',
            'action_list'   => $action_list,
        );
        RC_DB::table('staff_group')->where('group_id', $group_id)->where('store_id', $_SESSION['store_id'])->update($data);
        ecjia_merchant::admin_log($_POST['group_name'], 'edit', 'staff_group');
        return $this->showmessage(RC_Lang::get('staff::staff.staff_update_group_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_group/edit', array('group_id' => $group_id))));
    }

    /**
     * 删除员工组
     */
    public function remove()
    {
    	//判断权限
        $this->admin_priv('staff_group_remove', ecjia::MSGTYPE_JSON);

        //组id
        $group_id = intval($_GET['group_id']);
        
        if (empty($group_id)) {
        	return $this->showmessage('请选择要删除的员工组', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        //将该组下的员工移入默认员工组
		RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('group_id', $group_id)->update(array('group_id' => 0));
        
        //获取员工组名称
        $group_name = RC_DB::table('staff_group')->where(RC_DB::raw('group_id'), $group_id)->pluck('group_name');
        
        //删除员工组
        RC_DB::table('staff_group')->where('group_id', $group_id)->delete();
        
        //记录日志
        ecjia_merchant::admin_log($group_name, 'remove', 'staff_group');
        
        //提示
        return $this->showmessage(RC_Lang::get('staff::staff.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_group/init')));
    }

    /**
     * 获取员工组信息
     */
    private function staff_group_list($store_id)
    {
        $db_staff_group = RC_DB::table('staff_group');

        $db_staff_group->where(RC_DB::raw('store_id'), $store_id);
        $count = $db_staff_group->count();
        $page  = new ecjia_merchant_page($count, 10, 5);

        $data = $db_staff_group
            ->select('group_id', 'group_name', 'groupdescribe')
            ->orderby('group_id', 'asc')
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();

        $res = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                $row['staff_count'] = RC_DB::table('staff_user')->where('group_id', $row['group_id'])->count();
                $res[]              = $row;
            }
        }
        return array('staff_group_list' => $res, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }
}

//end

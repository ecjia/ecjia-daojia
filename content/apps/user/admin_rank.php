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
 * ECJIA 会员等级管理程序
 */
class admin_rank extends ecjia_admin
{
    private $db_user;
    private $db_user_rank;

    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('admin_user');
        RC_Loader::load_app_func('global', 'goods');
        $this->db_user      = RC_Model::model('user/users_model');
        $this->db_user_rank = RC_Model::model('user/user_rank_model');

        /* 加载全局js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('user_info', RC_App::apps_url('statics/js/user_info.js', __FILE__));
        RC_Script::localize_script('user_info', 'js_lang', config('app-user::jslang.admin_rank_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员等级', 'user'), RC_Uri::url('user/admin_rank/init')));
    }

    /**
     * 会员等级列表
     */
    public function init()
    {
        $this->admin_priv('user_rank');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员等级', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台会员等级列表页面，系统中所有的会员等级都会显示在此列表中。', 'user') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员等级" target="_blank">关于会员等级列表帮助文档</a>', 'user') . '</p>'
        );
        $this->assign('ur_here', __('会员等级', 'user'));
        $this->assign('action_link', array('text' => __('添加会员等级', 'user'), 'href' => RC_Uri::url('user/admin_rank/add')));

        $ranks = RC_DB::table('user_rank')->orderBy('rank_id', 'desc')->get();
        $this->assign('user_ranks', $ranks);

        $this->display('user_rank_list.dwt');
    }

    /**
     * 添加会员等级
     */
    public function add()
    {
        $this->admin_priv('user_rank');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加会员等级', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台添加会员等级页面，在此页面可以进行添加会员等级操作。', 'user') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员等级#.E6.B7.BB.E5.8A.A0.E4.BC.9A.E5.91.98.E7.AD.89.E7.BA.A7" target="_blank">关于添加会员等级帮助文档</a>', 'user') . '</p>'
        );

        $this->assign('ur_here', __('添加会员等级', 'user'));
        $this->assign('action_link', array('text' => __('会员等级', 'user'), 'href' => RC_Uri::url('user/admin_rank/init')));

        $rank['rank_special'] = 0;
        $rank['show_price']   = 1;
        $rank['min_points']   = 0;
        $rank['max_points']   = 0;
        $rank['discount']     = 100;

        $this->assign('rank', $rank);
        $this->assign('form_action', RC_Uri::url('user/admin_rank/insert'));

        $this->display('user_rank_edit.dwt');
    }

    /**
     * 增加会员等级到数据库
     */
    public function insert()
    {
        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $rank_name    = trim($_POST['rank_name']);
        $special_rank = isset($_POST['special_rank']) ? intval($_POST['special_rank']) : 0;
        $min_points   = empty($_POST['min_points']) ? 0 : intval($_POST['min_points']);
        $max_points   = empty($_POST['max_points']) ? 0 : intval($_POST['max_points']);
        $discount     = empty($_POST['discount']) ? 0 : intval($_POST['discount']);
        $show_price   = empty($_POST['show_price']) ? 0 : intval($_POST['show_price']);

        /* 检查是否存在重名的会员等级 */
        if (RC_DB::table('user_rank')->where('rank_name', $rank_name)->count() != 0) {
            return $this->showmessage(sprintf(__('会员等级名 %s 已经存在。', 'user'), $rank_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 非特殊会员组检查积分的上下限是否合理 */
        if ($min_points >= $max_points && $special_rank == 0) {
            return $this->showmessage(__('成长值上限必须大于成长值下限。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 特殊等级会员组不判断积分限制 */
        if ($special_rank == 0) {
            /* 检查下限制有无重复 */
            if (RC_DB::table('user_rank')->where('min_points', $min_points)->count() != 0) {
                return $this->showmessage(sprintf(__('已经存在一个成长值下限为 %s 的会员等级', 'user'), $min_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            /* 检查上限有无重复 */
            if (RC_DB::table('user_rank')->where('max_points', $max_points)->count() != 0) {
                return $this->showmessage(sprintf(__('已经存在一个成长值上限为 %s 的会员等级', 'user'), $max_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        /* 折扣验证 (0-100) */
        if ($discount > 100 || $discount < 0 || !is_numeric($discount) || empty($discount)) {
            return $this->showmessage(__('请填写为0-100的整数，如填入80，表示初始折扣率为8折', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data   = array(
            'rank_name'    => $rank_name,
            'min_points'   => $min_points,
            'max_points'   => $max_points,
            'discount'     => $discount,
            'special_rank' => $special_rank,
            'show_price'   => $show_price,
        );
        $new_id = RC_DB::table('user_rank')->insertGetId($data);

        ecjia_admin::admin_log($rank_name, 'add', 'user_rank');
        $links[] = array('text' => __('返回会员等级列表', 'user'), 'href' => RC_Uri::url('user/admin_rank/init'));
        $links[] = array('text' => __('继续添加会员等级', 'user'), 'href' => RC_Uri::url('user/admin_rank/add'));
        return $this->showmessage(sprintf(__('会员等级[ %s ]添加成功', 'user'), $rank_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_rank/edit', array('id' => $new_id))));

    }

    /**
     * 编辑会员等级
     */
    public function edit()
    {
        $this->admin_priv('user_rank');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑会员等级', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台编辑会员等级页面，在此页面可以进行编辑会员等级操作。', 'user') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员等级#.E7.BC.96.E8.BE.91.E4.BC.9A.E5.91.98.E7.AD.89.E7.BA.A7" target="_blank">关于编辑会员等级帮助文档</a>', 'user') . '</p>'
        );
        $this->assign('ur_here', __('编辑会员等级', 'user'));
        $this->assign('action_link', array('text' => __('会员等级', 'user'), 'href' => RC_Uri::url('user/admin_rank/init')));

        $id   = $_REQUEST['id'];
        $rank = RC_DB::table('user_rank')->where('rank_id', $id)->first();

        $this->assign('rank', $rank);
        $this->assign('form_action', RC_Uri::url('user/admin_rank/update'));

        $this->display('user_rank_edit.dwt');
    }

    /**
     * 更新会员等级到数据库
     */
    public function update()
    {
        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $id           = empty($_POST['id']) ? 0 : $_POST['id'];
        $rank_name    = empty($_POST['rank_name']) ? '' : trim($_POST['rank_name']);
        $special_rank = empty($_POST['special_rank']) ? 0 : intval($_POST['special_rank']);
        $min_points   = empty($_POST['min_points']) ? 0 : intval($_POST['min_points']);
        $max_points   = empty($_POST['max_points']) ? 0 : intval($_POST['max_points']);
        $discount     = empty($_POST['discount']) ? 0 : intval($_POST['discount']);
        $show_price   = empty($_POST['show_price']) ? 0 : intval($_POST['show_price']);

        /* 验证名称 是否重复  */
        $old_name = $_POST['old_name'];
        $old_min  = $_POST['old_min'];
        $old_max  = $_POST['old_max'];

        if ($rank_name != $old_name) {
            if (RC_DB::table('user_rank')->where('rank_name', $rank_name)->count() != 0) {
                return $this->showmessage(sprintf(__('会员等级名 %s 已经存在。', 'user'), htmlspecialchars($rank_name)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        /* 非特殊会员组检查积分的上下限是否合理 */
        if ($min_points >= $max_points && $special_rank == 0) {
            return $this->showmessage(__('成长值上限必须大于成长值下限。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 特殊等级会员组不判断积分限制 */
        if ($special_rank == 0) {
            if ($min_points != $old_min) {
                /* 检查下限有无重复 */
                if (RC_DB::table('user_rank')->where('min_points', $min_points)->where('rank_id', $id)->count() != 0) {
                    return $this->showmessage(sprintf(__('已经存在一个成长值下限为 %s 的会员等级', 'user'), $min_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
            if ($max_points != $old_max) {
                /* 检查上限有无重复 */
                if (RC_DB::table('user_rank')->where('max_points', $max_points)->where('rank_id', $id)->count() != 0) {
                    return $this->showmessage(sprintf(__('已经存在一个成长值上限为 %s 的会员等级', 'user'), $max_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        /* 折扣验证 (0-100) */
        if ($discount > 100 || $discount < 0 || !is_numeric($discount) || empty($discount)) {
            return $this->showmessage(__('请填写为0-100的整数，如填入80，表示初始折扣率为8折', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'rank_name'    => $rank_name,
            'min_points'   => $min_points,
            'max_points'   => $max_points,
            'discount'     => $discount,
            'special_rank' => $special_rank,
            'show_price'   => $show_price,
        );
        RC_DB::table('user_rank')->where('rank_id', $id)->update($data);


        ecjia_admin::admin_log($rank_name, 'edit', 'user_rank');
        $links[] = array('text' => __('返回会员等级列表', 'user'), 'href' => RC_Uri::url('user/admin_rank/init'));
        return $this->showmessage(sprintf(__('会员等级[ %s ]编辑成功', 'user'), $rank_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_rank/edit', "id=$id")));
    }

    /**
     * 删除会员等级
     */
    public function remove()
    {

        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $rank_id   = intval($_GET['id']);
        $rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');

        if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->delete()) {
            /* 更新会员表的等级字段 */
            RC_DB::table('users')->where('user_rank', $rank_id)->update(array('user_rank' => 0));

            ecjia_admin::admin_log($rank_name, 'remove', 'user_rank');
            return $this->showmessage(sprintf(__('会员等级[ %s ]删除成功', 'user'), $rank_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    /**
     * 编辑会员等级名称
     */
    public function edit_name()
    {
        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $rank_id = intval($_POST['pk']);
        $val     = trim($_POST['value']);

        /* 验证名称 ,根据id获取之前的名字  */
        $old_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');

        if (empty($val)) {
            return $this->showmessage(__('请输入会员等级名称', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($val != $old_name) {
            if (RC_DB::table('user_rank')->where('rank_name', $val)->count() != 0) {
                return $this->showmessage(sprintf(__('会员等级名 %s 已经存在。', 'user'), htmlspecialchars($val)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('rank_name' => $val))) {
            ecjia_admin::admin_log(sprintf(__('等级名是 %s', 'user'), $val), 'edit', 'user_rank');

            return $this->showmessage(__('编辑成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * ajax编辑成长值下限
     */
    public function edit_min_points()
    {
        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $rank_id = intval($_REQUEST['pk']);
        $val     = intval($_REQUEST['value']);

        /* 验证参数有效性  */
        if (!is_numeric($val) || empty($val) || $val <= 0 || strpos($val, '.') > 0) {
            return $this->showmessage(__('您没有输入成长值下限或者成长值下限不是一个正整数。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 查找该ID 对应的成长值上限值,验证是否大于上限  */
        $max_points = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('max_points');

        if ($val >= $max_points) {
            return $this->showmessage(__('成长值上限必须大于成长值下限。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 验证是否存在 */
        if (RC_DB::table('user_rank')->where('min_points', $val)->where('rank_id', '!=', $rank_id)->count() != 0) {
            return $this->showmessage(sprintf(__('已经存在一个成长值下限为 %s 的会员等级', 'user'), $val), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('min_points' => $val))) {

            $rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');
            ecjia_admin::admin_log($rank_name, 'edit', 'user_rank');

            return $this->showmessage(__('编辑成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * ajax修改成长值上限
     */
    public function edit_max_points()
    {
        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $rank_id = intval($_REQUEST['pk']);
        $val     = intval($_REQUEST['value']);

        /* 验证参数有效性  */
        if (!is_numeric($val) || empty($val) || $val <= 0) {
            return $this->showmessage(__('您没有输入成长值下限或者成长值下限不是一个正整数。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 查找该ID 对应的成长值下限值,验证是否大于上限  */
        $min_points = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('min_points');
        if ($val <= $min_points) {
            return $this->showmessage(__('成长值上限必须大于成长值下限。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 验证是否存在 */
        if (RC_DB::table('user_rank')->where('max_points', $val)->where('rank_id', '!=', $rank_id)->count() != 0) {
            return $this->showmessage(sprintf(__('已经存在一个成长值上限为 %s 的会员等级', 'user'), $val), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('max_points' => $val))) {
            $rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');

            ecjia_admin::admin_log($rank_name, 'edit', 'user_rank');
            return $this->showmessage(__('编辑成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 修改折扣率
     */
    public function edit_discount()
    {
        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $rank_id = intval($_REQUEST['pk']);
        $val     = intval($_REQUEST['value']);

        /* 验证参数有效性  */
        if ($val < 1 || $val > 100 || !is_numeric($val) || empty($val)) {
            return $this->showmessage(__('请填写为0-100的整数，如填入80，表示初始折扣率为8折', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('discount' => $val))) {
            $rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');

            ecjia_admin::admin_log(addslashes($rank_name), 'edit', 'user_rank');
            return $this->showmessage(__('编辑成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 切换是否是特殊会员组
     */
    public function toggle_special()
    {
        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $rank_id    = intval($_POST['id']);
        $is_special = intval($_POST['val']);

        if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('special_rank' => $is_special))) {
            $rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');

            if ($is_special == 1) {
                ecjia_admin::admin_log(sprintf(__('%s，显示价格', 'user'), $rank_name), 'edit', 'user_rank');
            } else {
                ecjia_admin::admin_log(sprintf(__('%s，隐藏价格', 'user'), $rank_name), 'edit', 'user_rank');
            }

            return $this->showmessage(__('切换成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_special, 'pjaxurl' => RC_Uri::url('user/admin_rank/init')));
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 切换是否显示价格
     */
    public function toggle_showprice()
    {
        $this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);

        $rank_id = intval($_POST['id']);
        $is_show = intval($_POST['val']);

        if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('show_price' => $is_show))) {
            $rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');
            if ($is_show == 1) {
                ecjia_admin::admin_log(sprintf(__('%s，加入特殊会员组', 'user'), $rank_name), 'edit', 'user_rank');
            } else {
                ecjia_admin::admin_log(sprintf(__('%s，移出特殊会员组', 'user'), $rank_name), 'edit', 'user_rank');
            }
            return $this->showmessage(__('切换成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_show, 'pjaxurl' => RC_Uri::url('user/admin_rank/init')));
        } else {
            return $this->showmessage(__('编辑失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
}

// end 
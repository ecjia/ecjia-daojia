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
 * ECJIA 提现方式管理
 */
class admin_plugin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();
        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');

        /* 提现方式 列表页面 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('admin_plugin', RC_App::apps_url('statics/js/admin_plugin.js', __FILE__), array(), false, true);

        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::localize_script('admin_plugin', 'js_lang', config('app-withdraw::jslang.admin_plugin_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('提现方式', 'withdraw')), RC_Uri::url('withdraw/admin_plugin/init'));
        ecjia_screen::get_current_screen()->set_parentage('withdraw', 'withdraw/admin_plugin.php');
    }

    /**
     * 提现方式列表
     */
    public function init()
    {
        $this->admin_priv('withdraw_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('提现方式', 'withdraw')));

        $this->assign('ur_here', __('提现方式', 'withdraw'));

        $plugins = ecjia_config::instance()->get_addon_config('withdraw_plugins', true, true);

        $data = RC_DB::table('withdraw_method')->orderBy('withdraw_order')->get();

        $data or $data = array();
        $modules = array();

        foreach ($data as $_key => $_value) {
            if (isset($plugins[$_value['withdraw_code']])) {
                $modules[$_key]['id']             = $_value['withdraw_id'];
                $modules[$_key]['code']           = $_value['withdraw_code'];
                $modules[$_key]['name']           = $_value['withdraw_name'];
                $modules[$_key]['withdraw_fee']   = $_value['withdraw_fee'];
                $modules[$_key]['is_cod']         = $_value['is_cod'];
                $modules[$_key]['desc']           = $_value['withdraw_desc'];
                $modules[$_key]['withdraw_order'] = $_value['withdraw_order'];
                $modules[$_key]['enabled']        = $_value['enabled'];
            }
        }
        $this->assign('modules', $modules);

        return $this->display('withdraw_channel.dwt');
    }

    /**
     * 禁用提现方式
     */
    public function disable()
    {
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        $code = trim($_GET['code']);
        $from = trim($_GET['from']);
        $data = array(
            'enabled' => 0
        );

        try {
            RC_DB::table('withdraw_method')->where('withdraw_code', $code)->update($data);

            $withdraw_name = RC_DB::table('withdraw_method')->where('withdraw_code', $code)->pluck('withdraw_name');

            ecjia_admin::admin_log($withdraw_name, 'stop', 'withdraw');

            $refresh_url = RC_Uri::url('withdraw/admin_plugin/init');
            if ($from == 'edit') {
                $refresh_url = RC_Uri::url('withdraw/admin_plugin/edit', array('code' => $code));
            }
            return $this->showmessage(__('插件<strong>已禁用</strong>', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 启用提现方式
     */
    public function enable()
    {
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        $code = trim($_GET['code']);
        $from = trim($_GET['from']);
        $data = array(
            'enabled' => 1
        );

        try {
            RC_DB::table('withdraw_method')->where('withdraw_code', $code)->update($data);

            $withdraw_name = RC_DB::table('withdraw_method')->where('withdraw_code', $code)->pluck('withdraw_name');

            ecjia_admin::admin_log($withdraw_name, 'use', 'withdraw');

            $refresh_url = RC_Uri::url('withdraw/admin_plugin/init');
            if ($from == 'edit') {
                $refresh_url = RC_Uri::url('withdraw/admin_plugin/edit', array('code' => $code));
            }
            return $this->showmessage(__('插件<strong>已启用</strong>', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑提现方式 code={$code}
     */
    public function edit()
    {
        $this->admin_priv('withdraw_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑提现方式', 'withdraw')));
        $this->assign('action_link', array('text' => __('提现方式', 'withdraw'), 'href' => RC_Uri::url('withdraw/admin_plugin/init')));
        $this->assign('ur_here', __('编辑提现方式', 'withdraw'));

        if (isset($_GET['code'])) {
            $withdraw_code = trim($_GET['code']);
        } else {
            return $this->showmessage(__('参数错误', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        /* 查询该提现方式内容 */
        $withdraw = RC_DB::table('withdraw_method')->where('withdraw_code', $withdraw_code)->where('enabled', 1)->first();

        if (empty($withdraw)) {
            return $this->showmessage(__('提现方式不存在', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 取得配置信息 */
        if (is_string($withdraw['withdraw_config'])) {
            $withdraw_config = unserialize($withdraw['withdraw_config']);
            /* 取出已经设置属性的code */
            $code_list = array();
            if (!empty($withdraw_config)) {
                foreach ($withdraw_config as $key => $value) {
                    $code_list[$value['name']] = $value['value'];
                }
            }

            $withdrawment_handle         = with(new Ecjia\App\Withdraw\WithdrawPlugin)->channel($withdraw_code);
            $withdraw['withdraw_config'] = $withdrawment_handle->makeFormData($code_list);
        }

        /* 如果以前没设置支付费用，编辑时补上 */
        if (!isset($withdraw['withdraw_fee'])) {
            $withdraw['withdraw_fee'] = 0;
        }

        $this->assign('withdraw', $withdraw);
        $this->assign('form_action', RC_Uri::url('withdraw/admin_plugin/save'));

        return $this->display('withdraw_edit.dwt');
    }

    /**
     * 提交提现方式 post
     */
    public function save()
    {
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        $name = trim($_POST['withdraw_name']);
        $code = trim($_POST['withdraw_code']);

        try {
            /* 检查输入 */
            if (empty($name)) {
                return $this->showmessage(__('提现方式名称不能为空', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $data = RC_DB::table('withdraw_method')->where('withdraw_name', $name)->where('withdraw_code', '!=', $code)->count();
            if ($data > 0) {
                return $this->showmessage(__('提现方式名称重复', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 取得配置信息 */
            $withdraw_config = array();
            if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
                for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
                    $withdraw_config[] = array(
                        'name'  => trim($_POST['cfg_name'][$i]),
                        'type'  => trim($_POST['cfg_type'][$i]),
                        'value' => trim($_POST['cfg_value'][$i])
                    );
                }
            }

            $refresh_url = RC_Uri::url('withdraw/admin_plugin/edit', array('code' => $code));

            if (!empty($_FILES)) {
                $withdrawment_handle = with(new Ecjia\App\Withdraw\WithdrawPlugin)->channel($code);
                foreach ($_FILES as $k => $v) {
                    $form   = $withdrawment_handle->getForm($k);
                    $upload = RC_Upload::uploader('image', array('save_path' => $form['dir'], 'auto_sub_dirs' => false));
                    $upload->allowed_type($form['file_ext']);
                    $upload->allowed_mime($form['file_mime']);
                    $image_info = $upload->upload($v);

                    $image_url = '';
                    if (!empty($image_info)) {
                        $image_url = $upload->get_position($image_info);
                    } else {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => $refresh_url));
                    }
                    $withdraw_config[] = array(
                        'name'  => $form['name'],
                        'type'  => $form['type'],
                        'value' => $image_url
                    );
                }
            }

            $withdraw_config = serialize($withdraw_config);
            /* 取得和验证支付手续费 */
            $withdraw_fee = empty($_POST['withdraw_fee']) ? 0 : intval($_POST['withdraw_fee']);

            if ($_POST['withdraw_id']) {
                /* 编辑 */
                $array = array(
                    'withdraw_name'   => $name,
                    'withdraw_desc'   => trim($_POST['withdraw_desc']),
                    'withdraw_config' => $withdraw_config,
                    'withdraw_fee'    => $withdraw_fee
                );
                RC_DB::table('withdraw_method')->where('withdraw_code', $code)->update($array);

                /* 记录日志 */
                ecjia_admin::admin_log($name, 'edit', 'withdraw');
                return $this->showmessage(__('编辑成功', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
            } else {
                $data_one = RC_DB::table('withdraw_method')->where('withdraw_code', $code)->count();
                if ($data_one > 0) {
                    /* 该提现方式已经安装过, 将该提现方式的状态设置为 enable */
                    $data = array(
                        'withdraw_name'   => $name,
                        'withdraw_desc'   => trim($_POST['withdraw_desc']),
                        'withdraw_config' => $withdraw_config,
                        'withdraw_fee'    => $withdraw_fee,
                        'enabled'         => '1'
                    );
                    RC_DB::table('withdraw_method')->where('withdraw_code', $code)->update($data);

                } else {
                    /* 该提现方式没有安装过, 将该提现方式的信息添加到数据库 */
                    $data = array(
                        'withdraw_code'   => $code,
                        'withdraw_name'   => $name,
                        'withdraw_desc'   => trim($_POST['withdraw_desc']),
                        'withdraw_config' => $withdraw_config,
                        'is_cod'          => intval($_POST['is_cod']),
                        'withdraw_fee'    => $withdraw_fee,
                        'enabled'         => '1',
                        'is_online'       => intval($_POST['is_online'])
                    );
                    RC_DB::table('withdraw_method')->insertGetId($data);
                }

                /* 记录日志 */
                ecjia_admin::admin_log($name, 'edit', 'withdraw');
                return $this->showmessage(__('安装成功', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
            }

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    public function delete_file()
    {
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        $withdraw_code = trim($_GET['withdraw_code']);
        $code          = trim($_GET['code']);

        try {
            /* 查询该提现方式内容 */
            $withdraw = RC_DB::table('withdraw_method')->where('withdraw_code', $withdraw_code)->where('enabled', 1)->first();

            if (empty($withdraw)) {
                return $this->showmessage(__('提现方式不存在', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $withdraw_config = [];
            $img_name        = '';
            /* 取得配置信息 */
            if (is_string($withdraw['withdraw_config'])) {
                $withdraw_config = unserialize($withdraw['withdraw_config']);

                if (!empty($withdraw_config)) {
                    foreach ($withdraw_config as $key => $value) {
                        if ($value['name'] == $code) {
                            $img_name                       = $value['value'];
                            $withdraw_config[$key]['value'] = '';
                        }
                    }
                }
            }

            $withdraw_config = serialize($withdraw_config);
            RC_DB::table('withdraw_method')->where('withdraw_code', $withdraw_code)->update(array('withdraw_config' => $withdraw_config));

            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $img_name);

            ecjia_admin::admin_log($withdraw['withdraw_name'], 'edit', 'withdraw');

            $refresh_url = RC_Uri::url('withdraw/admin_plugin/edit', array('code' => $withdraw_code));

            return $this->showmessage(__('删除成功', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 修改提现方式名称
     */
    public function edit_name()
    {
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        /* 取得参数 */
        $withdraw_id   = intval($_POST['pk']);
        $withdraw_name = trim($_POST['value']);

        try {
            /* 检查名称是否为空 */
            if (empty($withdraw_name) || $withdraw_id == 0) {
                return $this->showmessage(__('提现方式名称不能为空', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                /* 检查名称是否重复 */
                if (RC_DB::table('withdraw_method')->where('withdraw_name', $withdraw_name)->where('withdraw_id', '!=', $withdraw_id)->count() > 0) {
                    return $this->showmessage(__('提现方式名称重复', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                } else {
                    RC_DB::table('withdraw_method')->where('withdraw_id', $withdraw_id)->update(array('withdraw_name' => stripcslashes($withdraw_name)));

                    ecjia_admin::admin_log(stripcslashes($withdraw_name), 'edit', 'withdraw');
                    return $this->showmessage(__('编辑成功', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
                }
            }

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }


    /**
     * 修改提现方式排序
     */
    public function edit_order()
    {
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        try {
            if (!is_numeric($_POST['value'])) {
                return $this->showmessage(__('请输入合法数字', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                /* 取得参数 */
                $withdraw_id    = intval($_POST['pk']);
                $withdraw_order = intval($_POST['value']);

                RC_DB::table('withdraw_method')->where('withdraw_id', $withdraw_id)->update(array('withdraw_order' => $withdraw_order));

                return $this->showmessage(__('编辑成功', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('withdraw/admin_plugin/init')));
            }

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 修改提现方式费用
     */
    public function edit_withdraw_fee()
    {
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        /* 取得参数 */
        $withdraw_id  = intval($_POST['pk']);
        $withdraw_fee = trim($_POST['value']);

        try {
            if (empty($withdraw_fee) && !($withdraw_fee === '0')) {
                return $this->showmessage(__('提现费用不是一个合法的价格', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $withdraw_insure = make_semiangle($withdraw_fee); //全角转半角
                if (strpos($withdraw_insure, '%') === false) { //不包含百分号
                    if (!is_numeric($withdraw_fee)) {
                        return $this->showmessage(__('请输入合法数字或百分比%', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    } else {
                        $withdraw_fee = floatval($withdraw_insure);
                    }
                } else {
                    $withdraw_fee = floatval($withdraw_insure) . '%';
                }
                $withdraw_name = RC_DB::table('withdraw_id', $withdraw_id)->pluck('withdraw_name');
                RC_DB::table('withdraw_method')->where('withdraw_id', $withdraw_id)->update(array('withdraw_fee' => stripcslashes($withdraw_fee)));

                ecjia_admin::admin_log(sprintf(__('%s，修改费用为：%s', 'withdraw'), $withdraw_name, $withdraw_fee), 'setup', 'withdraw');

                return $this->showmessage(__('编辑成功', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
}

// end
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
 * 小票机
 */
class admin_store_printer extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Printer\Helper::assign_adminlog_content();

        //全局JS和CSS
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);

        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
        RC_Style::enqueue_style('nouislider', RC_App::apps_url('statics/css/jquery.nouislider.css', __FILE__), array());
        RC_Script::enqueue_script('nouislider', RC_App::apps_url('statics/js/jquery.nouislider.min.js', __FILE__), array(), false, false);

        RC_Style::enqueue_style('printer', RC_App::apps_url('statics/css/printer.css', __FILE__), array());
        RC_Script::enqueue_script('printer', RC_App::apps_url('statics/js/printer.js', __FILE__), array(), false, false);
        RC_Script::localize_script('printer', 'js_lang', config('app-printer::jslang.admin_store_printer_page'));

        $store_id   = intval($_GET['store_id']);
        $store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $nav_here   = __('入驻商家', 'printer');
        $url        = RC_Uri::url('store/admin/join');
        if ($store_info['manage_mode'] == 'self') {
            $nav_here = __('自营店铺', 'printer');
            $url      = RC_Uri::url('store/admin/init');
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, $url));
    }

    /**
     * 小票机
     */
    public function init()
    {
        $this->admin_priv('printer_manage');

        $store_id = intval($_GET['store_id']);
        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('小票机', 'printer')));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_printer');

        if ($store['manage_mode'] == 'self') {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => __('自营店铺列表', 'printer')));
        } else {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => __('入驻商家列表', 'printer')));
        }
        $this->assign('ur_here', sprintf(__('%s - 小票机', 'printer'), $store['merchants_name']));
        $this->assign('add_url', RC_Uri::url('printer/admin_store_printer/add', array('store_id' => $store_id)));

        $printer_list = RC_DB::table('printer_machine')->where('store_id', $store_id)->orderBy('id', 'desc')->get();
        $this->assign('list', $printer_list);

        $statics_url = RC_App::apps_url('statics/', __FILE__);
        $this->assign('statics_url', $statics_url);

        $this->display('printer_list.dwt');
    }

    /**
     * 添加小票机
     */
    public function add()
    {
        $this->admin_priv('printer_update');

        $store_id = intval($_GET['store_id']);
        $store    = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加小票机', 'printer')));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_printer');

        $this->assign('action_link', array('href' => RC_Uri::url('printer/admin_store_printer/init', array('store_id' => $store_id)), 'text' => __('小票机', 'printer')));
        $this->assign('ur_here', sprintf(__('%s - 添加小票机', 'printer'), $store['merchants_name']));
        $this->assign('form_action', RC_Uri::url('printer/admin_store_printer/insert', array('store_id' => $store_id)));

        $this->assign('machine_name', sprintf(__('%s - 小票机', 'printer'), $store['merchants_name']));
        $this->assign('add_url', RC_Uri::url('printer/admin_store_printer/add', array('store_id' => $store_id)));
        $this->display('printer_edit.dwt');
    }

    /**
     * 插入小票机
     */
    public function insert()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $machine_name   = !empty($_POST['machine_name']) ? trim($_POST['machine_name']) : '';
        $machine_code   = !empty($_POST['machine_code']) ? trim($_POST['machine_code']) : '';
        $machine_key    = !empty($_POST['machine_key']) ? trim($_POST['machine_key']) : '';
        $machine_mobile = !empty($_POST['machine_mobile']) ? trim($_POST['machine_mobile']) : '';

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($machine_name)) {
            return $this->showmessage(__('请输入小票机名称', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($machine_code)) {
            return $this->showmessage(__('请输入终端编号', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($machine_key)) {
            return $this->showmessage(__('请输入终端密钥', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $count = RC_DB::table('printer_machine')->where('machine_code', $machine_code)->count();
        if ($count != 0) {
            return $this->showmessage(__('该终端编号已存在', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $data = array(
            'store_id'       => $store_id,
            'machine_name'   => $machine_name,
            'machine_code'   => $machine_code,
            'machine_key'    => $machine_key,
            'machine_mobile' => $machine_mobile,
            'add_time'       => RC_Time::gmtime(),
        );

        //添加小票机
        $rs = ecjia_printer::addPrinter($machine_name, $machine_code, $machine_key, $machine_mobile);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $id = RC_DB::table('printer_machine')->insertGetId($data);

        //小票机版本和打印宽度
        $res = ecjia_printer::getPrintInfo($machine_code);
        if (is_ecjia_error($res)) {
            return $this->showmessage($res->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('version' => $res['version'], 'print_width' => $res['print_width']));

        //小票机软硬件版本
        $response = ecjia_printer::getVersion($machine_code);
        if (is_ecjia_error($response)) {
            return $this->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('hardware' => $response['hardware'], 'software' => $response['software']));

        ecjia_admin::admin_log($machine_name, 'add', 'printer');
        return $this->showmessage(__('添加成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/init', array('store_id' => $store_id))));
    }

    //删除
    public function delete()
    {
        $this->admin_priv('printer_delete', ecjia::MSGTYPE_JSON);

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $data = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();

        $rs = ecjia_printer::deletePrinter($data['machine_code']);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->delete();

        ecjia_admin::admin_log($data['machine_name'], 'remove', 'printer');
        return $this->showmessage(__('删除成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/init', array('store_id' => $store_id))));
    }

    //查看
    public function view()
    {
        $this->admin_priv('printer_manage');

        $store_id = intval($_GET['store_id']);
        $id       = intval($_GET['id']);
        $store    = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $info     = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();
        if (!empty($info['machine_key'])) {
            $len                      = strlen($info['machine_key']);
            $info['machine_key_star'] = substr_replace($info['machine_key'], str_repeat('*', $len), 0, $len);
        }

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('查看小票机', 'printer')));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_printer');

        $this->assign('action_link', array('href' => RC_Uri::url('printer/admin_store_printer/init', array('store_id' => $store_id)), 'text' => __('小票机', 'printer')));
        $this->assign('ur_here', sprintf(__('%s - 查看小票机', 'printer'), $store['merchants_name']));

        $this->assign('info', $info);

        $statics_url = RC_App::apps_url('statics/', __FILE__);
        $this->assign('statics_url', $statics_url);
        $this->assign('control_url', RC_Uri::url('printer/admin_store_printer/voice_control', array('id' => $id, 'store_id' => $store_id)));
        $this->assign('print_type_url', RC_Uri::url('printer/admin_store_printer/edit_print_type', array('id' => $id, 'store_id' => $store_id)));
        $this->assign('getorder_url', RC_Uri::url('printer/admin_store_printer/edit_getorder', array('id' => $id, 'store_id' => $store_id)));

        $count = $this->get_print_count($store_id, $info['machine_code']);
        $this->assign('count', $count);

        $this->display('printer_view.dwt');
    }

    //取消所有未打印
    public function cancel()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $data = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();
        $rs   = ecjia_printer::cancelAll($data['machine_code']);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        //修改该店铺下该台打印机未打印的记录
        RC_DB::table('printer_printlist')
            ->where('store_id', $store_id)
            ->where('machine_code', $data['machine_code'])
            ->where('status', 0)
            ->update(array('status' => 10));

        return $this->showmessage(__('取消成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //关机
    public function close()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $data = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();

        $rs = ecjia_printer::shutdown($data['machine_code']);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('online_status' => 0));
        return $this->showmessage(__('关闭成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //重启
    public function restart()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $data = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();

        $rs = ecjia_printer::restart($data['machine_code']);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('online_status' => 1));
        return $this->showmessage(__('重启成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //刷新打印机状态
    public function get_print_status()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $data = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();

        $rs = ecjia_printer::getPrintStatus($data['machine_code']);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $rs['machine_logo'] = $rs['logo_url'];
        unset($rs['logo_url']);
        RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update($rs);
        return $this->showmessage(__('刷新成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //音量控制
    public function voice_control()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $action   = trim($_POST['action']);
        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $type     = isset($_POST['type']) ? trim($_POST['type']) : '';
        $voice    = isset($_POST['voice']) ? intval($_POST['voice']) : 0;

        $data = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();

        if ($action == 'edit_type') {
            $response_type = $type == 'buzzer' ? 'horn' : 'buzzer';
            $voice         = $data['voice'];
        } else {
            $response_type = $data['voice_type'];
        }
        $rs = ecjia_printer::setSound($data['machine_code'], $response_type, $voice);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($action == 'edit_type') {
            $type = $type == 'buzzer' ? 'horn' : 'buzzer';
            RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('voice_type' => $type));
            return $this->showmessage(__('响铃类型修改成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
        } else {
            RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('voice' => $voice));
            return $this->showmessage(__('音量修改成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
        }
    }

    //修改按键打印
    public function edit_print_type()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $type     = isset($_POST['type']) ? trim($_POST['type']) : '';
        $type     = $type == 'btnopen' ? 'btnclose' : 'btnopen';

        $info = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();
        if ($type == 'btnopen') {
            $rs = ecjia_printer::openBtnPrint($info['machine_code']);
        } elseif ($type == 'btnclose') {
            $rs = ecjia_printer::closeBtnPrint($info['machine_code']);
        }
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('print_type' => $type));
        return $this->showmessage(__('按键打印修改成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //修改订单确认
    public function edit_getorder()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $type     = isset($_POST['type']) ? trim($_POST['type']) : '';
        $type     = $type == 'open' ? 'close' : 'open';

        $info = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();
        if ($type == 'open') {
            $rs = ecjia_printer::openGetOrder($info['machine_code']);
        } elseif ($type == 'close') {
            $rs = ecjia_printer::closeGetOrder($info['machine_code']);
        }
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('getorder' => $type));
        return $this->showmessage(__('订单确认修改成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //打印测试
    public function printer_test()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $store_id = !empty($_POST['store_id']) ? intval($_POST['store_id']) : 0;
        $id       = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        $content = !empty($_POST['content']) ? strip_tags($_POST['content']) : '';
        if (empty($content)) {
            return $this->showmessage(__('请输入要打印的内容', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $print_number = !empty($_POST['print_number']) ? (intval($_POST['print_number']) > 9 ? 9 : intval($_POST['print_number'])) : 1;

        $data     = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();
        $order_sn = date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        if ($print_number > 1) {
            $content = "<MN>$print_number</MN>" . $content;
        }
        $rs = ecjia_printer::printSend($data['machine_code'], $content, $order_sn);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        return $this->showmessage(__('测试打印成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //编辑打印机名称
    public function edit_machine_name()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $id           = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
        $machine_name = !empty($_POST['value']) ? trim($_POST['value']) : '';
        if (empty($machine_name)) {
            return $this->showmessage(__('请输入小票机名称', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('machine_name' => $machine_name));

        ecjia_admin::admin_log($machine_name, 'edit', 'machine_name');
        return $this->showmessage(__('小票机名称修改成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    //编辑打印机手机号
    public function edit_machine_mobile()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $id             = !empty($_POST['pk']) ? intval($_POST['pk']) : 0;
        $machine_mobile = !empty($_POST['value']) ? trim($_POST['value']) : '';
        if (empty($machine_mobile)) {
            return $this->showmessage(__('请输入手机卡号', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('printer_machine')->where('id', $id)->update(array('machine_mobile' => $machine_mobile));
        return $this->showmessage(__('手机卡号修改成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    //上传logo
    public function upload_logo()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $store_id = !empty($_POST['store_id']) ? intval($_POST['store_id']) : 0;
        $id       = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        /* 处理上传的LOGO图片 */
        if ((isset($_FILES['machine_logo']['error']) && $_FILES['machine_logo']['error'] == 0) || (!isset($_FILES['machine_logo']['error']) && isset($_FILES['machine_logo']['tmp_name']) && $_FILES['machine_logo']['tmp_name'] != 'none')) {
            $size = $_FILES['machine_logo']['size'];
            if ($size / 1000 > 40) {
                return $this->showmessage(__('图片大小不能超过40kb', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $upload     = RC_Upload::uploader('image', array('save_path' => 'data/printer', 'auto_sub_dirs' => false));
            $image_info = $upload->upload($_FILES['machine_logo']);

            if (!empty($image_info)) {
                $file_name = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $info = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();
        if (!empty($file_name)) {
            $file_url = RC_Upload::upload_url($file_name);
            $img      = RC_Image::make($file_url);
            $width    = $img->width();
            $height   = $img->height();
            if ($width > 350 || $height > 350) {
                return $this->showmessage(__('图片宽高不能超过350px', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $rs = ecjia_printer::setIcon($info['machine_code'], RC_Upload::upload_url($file_name));
            if (is_ecjia_error($rs)) {
                return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            //删除旧logo
            if (!empty($info['machine_logo'])) {
                $disk = RC_Filesystem::disk();

                $url        = $info['machine_logo'];
                $upload_url = RC_Upload::upload_url();
                $bool       = strstr($url, $upload_url);
                if ($bool) {
                    $url = str_replace($upload_url . '/', '', $url);
                }
                $disk->delete(RC_Upload::upload_path() . $url);
            }
        } else {
            $file_url = $info['machine_logo'];
        }
        ecjia_admin::admin_log($file_url, 'edit', 'machine_logo');
        RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('machine_logo' => $file_url));
        return $this->showmessage(__('上传成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //删除打印机logo
    public function del_file()
    {
        $this->admin_priv('printer_update', ecjia::MSGTYPE_JSON);

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $info = RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->first();
        if (!empty($info['machine_logo'])) {
            $rs = ecjia_printer::deleteIcon($info['machine_code']);
            if (is_ecjia_error($rs)) {
                return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $disk = RC_Filesystem::disk();

            $url        = $info['machine_logo'];
            $upload_url = RC_Upload::upload_url();
            $bool       = strstr($url, $upload_url);
            if ($bool) {
                $url = str_replace($upload_url . '/', '', $url);
            }
            $disk->delete(RC_Upload::upload_path() . $url);
        }

        RC_DB::table('printer_machine')->where('store_id', $store_id)->where('id', $id)->update(array('machine_logo' => ''));

        ecjia_admin::admin_log($info['machine_logo'], 'remove', 'machine_logo');
        return $this->showmessage(__('删除成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('printer/admin_store_printer/view', array('id' => $id, 'store_id' => $store_id))));
    }

    //打印记录列表
    public function record_list()
    {
        $this->admin_priv('printer_record_manage');

        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('打印记录', 'printer')));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_printer_record');

        if ($store['manage_mode'] == 'self') {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => __('自营店铺列表', 'printer')));
        } else {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => __('入驻商家列表', 'printer')));
        }
        $this->assign('ur_here', sprintf(__('%s - 打印记录', 'printer'), $store['merchants_name']));

        $record_list = $this->get_record_list($store_id);
        $this->assign('record_list', $record_list);

        $this->display('printer_record_list.dwt');
    }

    //再次打印
    public function reprint()
    {
        $this->admin_priv('printer_record_update', ecjia::MSGTYPE_JSON);
        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(__('请选择您要操作的记录', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $rs = with(new Ecjia\App\Printer\EventPrint)->resend($id);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        return $this->showmessage(__('打印已发送', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    //取消单条打印记录
    public function cancel_print()
    {
        $this->admin_priv('printer_record_update', ecjia::MSGTYPE_JSON);

        $id   = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $info = RC_DB::table('printer_printlist')->where('id', $id)->first();
        if (empty($info)) {
            return $this->showmessage(__('请选择您要操作的记录', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $rs = ecjia_printer::cancelOne($info['machine_code'], $info['print_order_id']);
        if (is_ecjia_error($rs)) {
            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        //修改状态为已取消
        RC_DB::table('printer_printlist')->where('id', $id)->update(array('status' => 10));

        $arr  = array('store_id' => $info['store_id']);
        $page = !empty($_GET['page']) ? intval($_GET['page']) : 0;
        if (!empty($page)) {
            $arr['page'] = $page;
        }
        $pjaxurl = RC_Uri::url('printer/admin_store_printer/record_list', $arr);
        return $this->showmessage(__('取消成功', 'printer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }

    //获取打印记录列表
    private function get_record_list($store_id = 0)
    {
        $db_printer_view = RC_DB::table('printer_printlist as p')
            ->leftJoin('printer_machine as m', RC_DB::raw('p.machine_code'), '=', RC_DB::raw('m.machine_code'));

        if (!empty($store_id)) {
            $db_printer_view->where(RC_DB::raw('p.store_id'), $store_id);
        }

        $count = $db_printer_view->count();
        $page  = new ecjia_page($count, 10, 5);
        $data  = $db_printer_view->select(RC_DB::raw('p.*, m.machine_name'))->take(10)->skip($page->start_id - 1)->orderBy('id', 'desc')->get();

        return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    //打印统计
    private function get_print_count($store_id = 0, $machine_code = '')
    {
        $week_start_time = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m"), RC_Time::local_date("d") - RC_Time::local_date("w") + 1, RC_Time::local_date("Y"));
        $now             = RC_Time::gmtime();

        $count['week_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $store_id)
            ->where('machine_code', $machine_code)
            ->where('status', 1)
            ->where('print_time', '>', $week_start_time)
            ->where('print_time', '<', $now)
            ->SUM('print_count');

        $start                      = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m", $now), RC_Time::local_date("d", $now), RC_Time::local_date("Y", $now));
        $count['today_print_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $store_id)
            ->where('machine_code', $machine_code)
            ->where('status', 1)
            ->where('print_time', '>', $start)
            ->where('print_time', '<', $now)
            ->SUM('print_count');

        $count['today_unprint_count'] = RC_DB::table('printer_printlist')
            ->where('store_id', $store_id)
            ->where('machine_code', $machine_code)
            ->where('status', '!=', 1)
            ->where('last_send', '>', $start)
            ->where('last_send', '<', $now)
            ->SUM('print_count');

        return $count;
    }
}

//end

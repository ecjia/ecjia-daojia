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
namespace Ecjia\App\Cron\Controllers;

use admin_nav_here;
use admin_notice;
use ecjia;
use Ecjia\App\Cron\CronExpression;
use Ecjia\App\Cron\CronPlugin;
use Ecjia\App\Cron\CronRun;
use Ecjia\App\Cron\Helper;
use Ecjia\App\Cron\Installer\PluginUninstaller;
use Ecjia\Component\Plugin\Storages\CronPluginStorage;
use Ecjia\System\Frameworks\BrowserEvent\SwitchClickEvent;
use ecjia_admin;
use ecjia_screen;
use RC_Api;
use RC_App;
use RC_DB;
use RC_Package;
use RC_Script;
use RC_Style;
use RC_Time;
use RC_Uri;

/**
 * ECJia 计划任务
 * @author songqianqian
 */
class AdminPluginController extends AdminBase
{
    private $cron_method;

    public function __construct()
    {
        parent::__construct();

        $this->cron_method = RC_Package::package('app::cron')->loadClass('cron_method');
        RC_Package::package('app::cron')->loadClass('cron_helper');

        /*加载全局JS及CSS*/
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');

        RC_Style::enqueue_style('cron', RC_App::apps_url('statics/css/cron.css', $this->__FILE__));
        RC_Script::enqueue_script('cron', RC_App::apps_url('statics/js/cron.js', $this->__FILE__));
        RC_Script::enqueue_script('cronGen', RC_App::apps_url('statics/js/cronGen.js', $this->__FILE__));
        RC_Script::enqueue_script('cron_config', RC_App::apps_url('statics/js/cron_config.js', $this->__FILE__), array(), false, true);

        RC_Script::localize_script('cron', 'js_lang', config('app-cron::jslang.cron_page'));
        RC_Script::localize_script('cronGen', 'js_lang', config('app-cron::jslang.cron_page'));
        RC_Script::localize_script('cron_config', 'js_lang', config('app-cron::jslang.cron_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('计划任务', 'cron'), RC_Uri::url('cron/admin_plugin/init')));

        ecjia_screen::get_current_screen()->set_parentage('cron', 'cron/admin_plugin.php');
    }

    //列表页
    public function init()
    {
        try {
            $this->admin_priv('cron_manage');

            ecjia_screen::get_current_screen()->remove_last_nav_here();
            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('计划任务', 'cron')));
            $this->assign('ur_here', __('计划任务', 'cron'));

            $this->assign('action_link', array('text' => __('计划任务配置', 'cron'), 'href' => RC_Uri::url('cron/admin_config/init')));

            $db_cron       = RC_DB::connection('ecjia')->table('crons');
            $count['type'] = isset($_GET['type']) ? $_GET['type'] : '';
            if (!empty($count['type'])) {
                $db_cron->where('enabled', 0);
            } else {
                $db_cron->where('enabled', 1);
            }
            $data              = $db_cron->get()->toArray();
            $filter_count      = RC_DB::connection('ecjia')->table('crons')->select(RC_DB::raw('SUM(IF(enabled = 1, 1, 0)) as enabled'), RC_DB::raw('SUM(IF(enabled =0 , 1, 0)) as disabled'))->first();
            $count['enabled']  = $filter_count['enabled'] > 0 ? $filter_count['enabled'] : 0;
            $count['disabled'] = $filter_count['disabled'] > 0 ? $filter_count['disabled'] : 0;

            $this->assign('count', $count);
            $data or $data = array();
            $modules = array();
            if (isset($data)) {
                foreach ($data as $_key => $_value) {
                    $modules[$_key]['code']       = $_value['cron_code'];
                    $modules[$_key]['name']       = $_value['cron_name'];
                    $modules[$_key]['desc']       = $_value['cron_desc'];
                    $modules[$_key]['cron_order'] = $_value['cron_order'];
                    $modules[$_key]['nexttime']   = RC_Time::local_date('Y-m-d H:i:s', $_value['nexttime']);
                    $modules[$_key]['runtime']    = $_value['runtime'] ? RC_Time::local_date('Y-m-d H:i:s', $_value['runtime']) : '-';
                    $modules[$_key]['enabled']    = $_value['enabled'];
                    $modules[$_key]['install']    = '1';
                }
            }

            $this->assign('modules', $modules);

            return $this->display('cron_list.dwt');
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }
    }


    public function edit()
    {
        try {
            $this->admin_priv('cron_update');

            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑计划任务', 'cron')));
            $this->assign('ur_here', __('编辑计划任务', 'cron'));

            $this->assign('action_link', array('text' => __('计划任务', 'cron'), 'href' => RC_Uri::url('cron/admin_plugin/init')));

            //获取插件信息
            $code = trim($_GET['code']);
            $cron = RC_DB::table('crons')->where('cron_code', $code)->first();

            if ($cron['enabled'] != 1) {
                $gourl = RC_Uri::url("cron/admin_plugin/enabled", [
                    'code' => $code,
                    'from' => 'edit',
                ]);
                $msg = sprintf(__('<strong>温馨提示：</strong>该计划任务插件已经禁用，如果您需要使用，
                    请点击<a class="switch" href="javascript:;" data-url="{%s}" title="启用">启用</a>。', 'cron'), $gourl);
                ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($msg, 'alert-error'));
            }

            $cron_config = unserialize($cron['cron_config']);

            try {
                /* 取出已经设置属性的code */
                $code_list = array();
                if (!empty($cron_config)) {
                    foreach ($cron_config as $key => $value) {
                        $code_list[$value['name']] = $value['value'];
                    }
                }
                $cron_handle         = with(new CronPlugin)->channel($code);
                $cron_config = $cron_handle->makeFormData($code_list);
                $cron_config_file    = $cron_handle->loadConfig();
                //获取配置时间
                $config_list = with(new CronExpression)->getExpressions();
            }
            catch (\InvalidArgumentException $exception) {
                $gourl = RC_Uri::url("cron/admin_plugin/delete", [
                    'code' => $code,
                    'from' => 'edit',
                ]);
                $msg = sprintf(__('<strong>温馨提示：</strong>该计划任务的插件已经丢失，请确认插件文件已经放入"/content/plugins/"下，
                如需继续，请点击<a class="switch" href="javascript:;" data-url="%s">删除</a>，然后重新安装该插件。', 'cron'), $gourl);
                ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($msg, 'alert-error'));
            }

            $cron['cron_config'] = $cron_config;

            $cron['run_once'] && $cron['autoclose'] = 'checked';

            $this->assign('cron_config_file', $cron_config_file);
            $this->assign('config_list', $config_list);
            $this->assign('cron', $cron);

            $this->assign('inline_script', (new SwitchClickEvent())());

            return $this->display('cron_edit.dwt');
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }
    }

    //时间设置返回相对应的公式
    public function ajax_law()
    {
        try {
            $expression = $_POST['config_time'];
            $law        = with(new CronExpression)->getExpressionVaule($expression);

            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $law));
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    //时间设置返回相对应的公式
    public function ajax_five()
    {
        try {
            $cron_tab    = $_POST['cron_tab'];
            $config_time = $_POST['config_time'];

            if (!empty($cron_tab)) {
                $cron_expression = $cron_tab;
            } else {
                $cron_expression = $config_time;
            }

            if (!empty($cron_expression)) {
                $dates = $this->five_list($cron_expression);
                return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $dates));
            } else {
                return $this->showmessage(__('请配置执行时间', 'cron'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    public function update()
    {
        try {
            $this->admin_priv('cron_update');

            $code        = trim($_POST['cron_code']);
            $cron_name   = !empty($_POST['cron_name']) ? $_POST['cron_name'] : '';
            $cron_desc   = !empty($_POST['cron_desc']) ? $_POST['cron_desc'] : '';
            $cron_config = array();
            if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
                $temp = count($_POST['cfg_value']);
                for ($i = 0; $i < $temp; $i++) {
                    $cron_config[] = array(
                        'name'  => trim($_POST['cfg_name'][$i]),
                        'type'  => trim($_POST['cfg_type'][$i]),
                        'value' => trim($_POST['cfg_value'][$i])
                    );
                }
            }
            $cron_config   = serialize($cron_config);
            $cron_run_once = !empty($_POST['cron_run_once']) ? $_POST['cron_run_once'] : 0;
            $allow_ip      = !empty($_POST['allow_ip']) ? $_POST['allow_ip'] : '';

            if ($code == 'cron_bill_day' || $code == 'cron_bill_month') {
                $select_cron_config = 'cron';
            } else {
                $select_cron_config = trim($_POST['select_cron_config']);
            }

            if (empty($select_cron_config)) {
                return $this->showmessage(__('请选择计划任务的执行时间', 'cron'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if ($select_cron_config == 'cron') {
                $cron_expression = $_POST['cron_tab'];
            } else {
                $cron_expression = $_POST['config_time'];
            }

            //处理下次执行时间
            if (!empty($cron_expression)) {
                $times = $this->five_list($cron_expression);
                if (date('Y-m-d H:i') . ':00' == $times[0]) {
                    $date = $times[1];
                } else {
                    $date = $times[0];
                }
                $nexttime = Helper::getNextRunTime($cron_expression);
            } else {
                return $this->showmessage(__('请配置执行时间', 'cron'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if ($code == 'cron_bill_day' || $code == 'cron_bill_month') {
                $data = array(
                    'cron_name'   => $cron_name,
                    'cron_desc'   => $cron_desc,
                    'cron_config' => $cron_config,
                    'run_once'    => $cron_run_once,
                    'allow_ip'    => $allow_ip,
                );
            } else {
                $data = array(
                    'cron_name'        => $cron_name,
                    'cron_desc'        => $cron_desc,
                    'cron_config'      => $cron_config,
                    'cron_expression'  => $cron_expression,
                    'expression_alias' => $select_cron_config,
                    'run_once'         => $cron_run_once,
                    'allow_ip'         => $allow_ip,
                    'nexttime'         => $nexttime
                );
            }

            RC_DB::connection('ecjia')->table('crons')->where('cron_id', $_POST['cron_id'])->update($data);

            ecjia_admin::admin_log($cron_name, 'edit', 'cron');
            return $this->showmessage(__('编辑计划任务成功', 'cron'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/edit', array('code' => $code))));
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 禁用计划任务
     */
    public function disable()
    {
        try {
            $this->admin_priv('cron_update');

            $code = trim($_GET['code']);
            $data = array(
                'enabled' => 0
            );

            RC_DB::connection('ecjia')->table('crons')->where('cron_code', $code)->update($data);
            $cron_name = RC_DB::connection('ecjia')->table('crons')->where('cron_code', $code)->value('cron_name');

            ecjia_admin::admin_log($cron_name, 'disable', 'cron');
            return $this->showmessage(__('计划任务已禁用', 'cron'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/init')));
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 启用计划任务
     */
    public function enabled()
    {
        try {
            $this->admin_priv('cron_update');

            $code = trim($_GET['code']);
            $data = array(
                'enabled' => 1
            );

            RC_DB::connection('ecjia')->table('crons')->where('cron_code', $code)->update($data);
            $cron_name = RC_DB::connection('ecjia')->table('crons')->where('cron_code', $code)->value('cron_name');

            ecjia_admin::admin_log($cron_name, 'enabled', 'cron');

            return $this->showmessage(__('计划任务已启用', 'cron'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/init')));
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除插件配置
     */
    public function delete()
    {
        try {
            $code = $this->request->input('code');

            $result = RC_Api::api('system', 'ecjia_deactivate_plugin', ['code' => $code]);
            if (is_ecjia_error($result)) {
                return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            (new PluginUninstaller($code, new CronPluginStorage()))->uninstall();

            return $this->showmessage(__('删除成功', 'cron'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/init')));
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 执行计划任务测试
     */
    public function run()
    {
        try {
            $this->admin_priv('cron_run', ecjia::MSGTYPE_JSON);

            ini_set('memory_limit', -1);
            set_time_limit(0);

            $code = trim($_GET['code']);
            $cron = RC_DB::connection('ecjia')->table('crons')->where('cron_code', $code)->first();
            if (empty($cron)) {
                return $this->showmessage('Cron script not found.', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $result = CronRun::runBy($code);
            if (is_ecjia_error($result)) {
                return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            ecjia_admin::admin_log($cron['cron_name'], 'run', 'cron');

            return $this->showmessage(__('执行成功', 'cron'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin_plugin/init')));
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 获取即将执行该任务的前5条时间记录
     * @param $cron_expression
     * @return array
     */
    private function five_list($cron_expression)
    {
        $file_list = with(new CronExpression)->getProvidesMultipleRunDates($cron_expression);
        $dates     = collect($file_list)->map(function ($item) {
            return $item->format('Y-m-d H:i:s');
        })->toArray();
        return $dates;
    }
}

//end
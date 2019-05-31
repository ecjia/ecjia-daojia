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

namespace Ecjia\System\Controllers;


use admin_nav_here;
use ecjia;
use Ecjia\System\Models\AdminLogModel;
use ecjia_admin;
use ecjia_page;
use ecjia_screen;
use RC_Script;
use RC_Style;
use RC_Time;
use RC_Uri;

class AdminLogsController extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();


        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('ecjia-admin_logs');

        //js语言包调用
        RC_Script::localize_script('ecjia-admin_logs', 'admin_logs_lang', config('system::jslang.logs_page'));
    }

    public function init()
    {
        $this->admin_priv('logs_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员日志')));

        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => __('概述'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台管理员日志页面，可以在此查看管理员操作的一些记录信息。') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E7.AE.A1.E7.90.86.E5.91.98.E6.97.A5.E5.BF.97" target="_blank">关于管理员日志帮助文档</a>') . '</p>'
        );

        $logs = $this->get_admin_logs(array_map('remove_xss', $_REQUEST));

        //查询IP地址列表
        $ip_list = [];
        $ipdata = AdminLogModel::select('ip_address')->distinct()->get();
        if (!empty($ipdata)){
            $ip_list = $ipdata->map(function ($model) {
                return $model->ip_address;
            })->toArray();
        }


        // 查询管理员列表
        $user_list = [];
        $userdata = AdminLogModel::with(['admin_user_model' => function ($query) {
            $query->select('user_id', 'user_name');
        }])->select('user_id')->distinct()->get();

        if (!empty($userdata)) {
            $user_list = $userdata->mapWithKeys(function ($model) {
                if (!empty($model->admin_user_model)) {
                    $model->user_name = $model->admin_user_model->user_name;
                } else {
                    $model->user_name = __('佚名') . $model->user_id;
                }

                return [$model->user_id => $model->user_name];
            });
        }

        $log_date = $this->buildDropLogDate();

        $this->assign('ur_here', __('管理员日志'));
        $this->assign('ip_list', $ip_list);
        $this->assign('user_list', $user_list);
        $this->assign('log_date', $log_date);
        $this->assign('logs', $logs);

        $this->display('admin_logs.dwt');
    }

    /**
     *  获取管理员操作记录
     * @param array $_GET , $_POST, $_REQUEST 参数
     * @return array ['list', 'page', 'desc']
     */
    private function get_admin_logs($args = [])
    {
        $user_id = !empty($args['user_id']) ? intval($args['user_id']) : 0;
        $ip = !empty($args['ip']) ? $args['ip'] : '';

        $filter = [];
        $filter['sort_by'] = !empty($args['sort_by']) ? safe_replace($args['sort_by']) : 'log_id';
        $filter['sort_order'] = !empty($args['sort_order']) ? safe_replace($args['sort_order']) : 'DESC';

        $keyword = !empty($args['keyword']) ? trim(htmlspecialchars($args['keyword'])) : '';

        $query = AdminLogModel::with(['admin_user_model' => function ($query) {
            $query->select('user_id', 'user_name');
        }]);

        if (!empty($ip)) {
            $query->where('ip_address', $ip);
        }

        if (!empty($keyword)) {
            $query->where('log_info', 'like', "%{$keyword}%");
        }

        if (!empty($user_id)) {
            $query->where('user_id', $user_id);
        }

        $filter['record_count'] = $query->count();

        $page = new ecjia_page($filter['record_count'], 15, 6);

        $query->orderBy($filter['sort_by'], $filter['sort_order']);

        $query->skip($page->start_id - 1)->take($page->page_size);
        $data = $query->get();

        $list = [];
        if (!empty($data)) {
            $list = $data->map(function ($model) {
                if (!empty($model->admin_user_model)) {
                    $model->user_name = $model->admin_user_model->user_name;
                } else {
                    $model->user_name = __('佚名') . $model->user_id;
                }
                $model->log_time = RC_Time::local_date(ecjia::config('time_format'), $model['log_time']);
                return $model;
            })->toArray();
        }

        return [
            'list' => $list,
            'page' => $page->show(5),
            'desc' => $page->page_desc()
        ];
    }

    /**
     * 批量删除日志记录
     */
    public function batch_drop()
    {
        $this->admin_priv('logs_drop');

        $drop_type_date = remove_xss($this->request->input('drop_type_date', ''));

        /* 按日期删除日志 */
        if (empty($drop_type_date)) {
            return $this->redirect(RC_Uri::url('@admin_logs/init'));
        }

        $log_date_select = intval($this->request->input('log_date', 5));
        if (empty($log_date_select)) {
            return $this->redirect(RC_Uri::url('@admin_logs/init'));
        }

        $log_dates = $this->buildDropLogDate();
        $log_date = collect($log_dates)->where('value', $log_date_select)->first();
        if (empty($log_date)) {
            return $this->redirect(RC_Uri::url('@admin_logs/init'));
        }

        AdminLogModel::where('log_time', '<=', $log_date['log_time'])->delete();
        /* 记录日志 */
        ecjia_admin::admin_log(sprintf(__('删除 %s 的日志。'), $log_date['lable']), 'remove', 'adminlog');

        return $this->showmessage(sprintf(__('%s 的日志成功删除。'), $log_date['lable']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@admin_logs/init')));
    }

    /**
     * @return array
     */
    private function buildDropLogDate()
    {
        $gmtime = RC_Time::gmtime();

        return [
            [
                'log_time' => $gmtime - (3600 * 24 * 7),
                'label' => __('一周之前'),
                'value' => 1,
            ],

            [
                'log_time' => $gmtime - (3600 * 24 * 30),
                'label' => __('一个月前'),
                'value' => 2,
            ],

            [
                'log_time' => $gmtime - (3600 * 24 * 90),
                'label' => __('三个月前'),
                'value' => 3,
            ],

            [
                'log_time' => $gmtime - (3600 * 24 * 180),
                'label' => __('半年之前'),
                'value' => 4,
            ],

            [
                'log_time' => $gmtime - (3600 * 24 * 365),
                'label' => __('一年之前'),
                'value' => 5,
            ],

        ];
    }


}
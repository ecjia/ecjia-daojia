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
 * 会员排行
 */
class admin_level extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global', 'orders');
        /* 加载所有全局 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');

        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        //百度图表
        RC_Script::enqueue_script('echarts-min-js', RC_App::apps_url('statics/js/echarts.min.js', __FILE__));

        RC_Script::enqueue_script('user_level_js', RC_App::apps_url('statics/js/user_level.js', __FILE__));
        RC_Style::enqueue_style('user_level_css', RC_App::apps_url('statics/css/user_level.css', __FILE__));

        RC_Script::localize_script('user_level', 'js_lang', config('app-user::jslang.admin_level_page'));
    }

    /**
     * 列表
     */
    public function init()
    {
        $this->admin_priv('user_manage');

        $nav_here = __('会员排行榜', 'user');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here));

        $this->assign('ur_here', $nav_here);

        $list = $this->get_list();
        $this->assign('list', $list);

        if (!empty($list['stats_data'])) {
            $this->assign('data', json_encode($list['stats_data']));
        }
        $stats = !empty($_GET['stats']) ? trim($_GET['stats']) : 'order_money';
        $this->assign('stats', $stats);

        $this->display('user_level_list.dwt');
    }

    public function download()
    {
        $data = $this->get_list(true);
        $item = $data['item'];

        RC_Excel::load(RC_APP_PATH . 'user' . DIRECTORY_SEPARATOR . 'statics/files/user_level.xls', function ($excel) use ($item) {
            $excel->sheet('First sheet', function ($sheet) use ($item) {
                foreach ($item as $k => $v) {
                    $sheet->appendRow($k + 2, $v);
                }
            });
        })->download('xls');
    }

    private function get_list($return_all = false)
    {
        $keywords = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';

        $table_users      = RC_DB::getTableFullName('users');
        $table_order_info = RC_DB::getTableFullName('order_info');

        $sql = "select u.user_id, u.user_name, u.user_money as avaliable_money, u.pay_points as integral, order_count, order_money
from " . $table_users . " as u

INNER JOIN (select user_id, count(order_id) as order_count from " . $table_order_info . " where is_delete = 0 and order_status in (1, 5) and shipping_status = 2 and pay_status in (2, 1) GROUP BY user_id)
as c on c.user_id = u.user_id

INNER JOIN (select user_id, sum(goods_amount + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee + tax - integral_money - bonus - discount) as order_money from " . $table_order_info . " where is_delete = 0 and order_status in (1, 5) and shipping_status = 2 and pay_status in (2, 1) GROUP BY user_id)
as d on d.user_id = u.user_id";

        $pagenum    = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $sort_by    = isset($_GET['sort_by']) && $_GET['sort_by'] != 'level' ? trim($_GET['sort_by']) : 'order_money';
        $sort_order = isset($_GET['sort_order']) ? trim($_GET['sort_order']) : 'desc';

        $m = RC_Time::local_date('m');
        $d = RC_Time::local_date('d');
        $y = RC_Time::local_date('y');

        $start_date = RC_Time::local_mktime(0, 0, 0, $m, $d - 30, $y); //30天前 开始时间
        $end_date   = RC_Time::gmtime(); //当前时间

        $filter['start_date'] = empty($_GET['start_date']) ? '' : $_GET['start_date'];
        $filter['end_date']   = empty($_GET['end_date']) ? '' : $_GET['end_date'];

        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $start_date = RC_Time::local_strtotime($filter['start_date']);
            $end_date   = RC_Time::local_strtotime($filter['end_date']);
        }
        $sql .= "

INNER JOIN (select user_id from " . $table_order_info . " where add_time >=" . $start_date . " and add_time <=" . $end_date . " GROUP BY user_id) as o on o.user_id = u.user_id";

        //图表数据 根据按钮状态切换显示 start
        $stats = !empty($_GET['stats']) ? trim($_GET['stats']) : 'order_money';
        if ($stats == 'order_count') {
            $level_sql = $sql . " ORDER BY order_count desc";
        } else {
            $level_sql = $sql . " ORDER BY order_money desc";
        }
        $stats_data = RC_DB::select($level_sql);
        //图表数据 根据按钮状态切换显示 end

        $sql .= " ORDER BY " . $sort_by . ' ' . $sort_order;
        //店铺排行 不受分页/关键字影响 start
        $amount_sql = $sql;
        $level_data = RC_DB::select($amount_sql);
        $level      = [];
        if (!empty($level_data)) {
            foreach ($level_data as $k => $v) {
                $level[$v['user_id']]['level'] = $k + 1;
            }
        }
        //店铺排行 不受分页/关键字影响 end

        //列表数据 start
        $data = [];
        if (!empty($keywords)) {
            $sql .= ' and u.user_name like "' . '%' . $keywords . '%"';
        }
        $data = RC_DB::select($sql);
        //列表数据 end

        $pageSize = 30;
        $count    = count($data);
        $page     = new ecjia_page($count, $pageSize, 6);

        if (!$return_all) {
            $sql .= " limit " . ($pagenum - 1) * $pageSize . "," . $pageSize;
        }
        $result = RC_DB::select($sql);

        if (!empty($result)) {
            foreach ($result as $k => $v) {
                //店铺排行
                $result[$k]['level']                    = $level[$v['user_id']]['level'];
                $result[$k]['formated_avaliable_money'] = price_format($v['avaliable_money']);
                $result[$k]['formated_order_money']     = price_format($v['order_money']);
            }
            if (empty($sort_by)) {
                $result = $this->array_sort($result, 'level');
            } else if ($sort_by == 'level') {
                $result = $this->array_sort($result, 'level', $sort_order);
            }

            $arr = [];
            if ($return_all) {
                foreach ($result as $k => $v) {
                    //店铺排行
                    $arr[$k]['level']                    = $v['level'];
                    $arr[$k]['user_name']                = $v['user_name'];
                    $arr[$k]['formated_avaliable_money'] = $v['formated_avaliable_money'];
                    $arr[$k]['integral']                 = $v['integral'];
                    $arr[$k]['order_count']              = $v['order_count'];
                    $arr[$k]['formated_order_money']     = $v['formated_order_money'];
                }
                $result = $arr;
            }
        }
        return array('item' => $result, 'page' => $page->show(2), 'stats_data' => $stats_data);
    }

    private function array_sort($arr, $keys, $type = 'asc')
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
}

// end

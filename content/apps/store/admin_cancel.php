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
 * 注销申请
 */
class admin_cancel extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

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
        RC_Script::enqueue_script('admin_cancel', RC_App::apps_url('statics/js/admin_cancel.js', __FILE__), array(), false, 1);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('注销申请', 'store')));
        ecjia_admin_log::instance()->add_object('store_cancel', __('注销申请', 'store'));
    }

    /**
     * 入驻商家预审核列表
     */
    public function init()
    {
        $this->admin_priv('store_cancel_manage');

        $this->assign('ur_here', __('注销申请', 'store'));

        $store_list = $this->get_store_list();
        $this->assign('store_list', $store_list);

        $this->assign('search_action', RC_Uri::url('store/admin_cancel/init'));

        $action = $_SESSION['action_list'] == 'all' ? true : false;
        $this->assign('action', $action);

        $this->display('store_cancel_list.dwt');
    }

    private function get_store_list()
    {
        $db_store_franchisee     = RC_DB::table('store_franchisee as sf');
        $db_store_franchisee_two = RC_DB::table('store_franchisee as sf');

        $filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
        $filter['type']     = empty($_GET['type']) ? '' : trim($_GET['type']);

        if ($filter['keywords']) {
            $db_store_franchisee->where(function ($query) use ($filter) {
                $query->where(RC_DB::raw('sf.merchants_name'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%')
                    ->orWhere(RC_DB::raw('sf.contact_mobile'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
            });

            $db_store_franchisee_two->where(function ($query) use ($filter) {
                $query->where(RC_DB::raw('sf.merchants_name'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%')
                    ->orWhere(RC_DB::raw('sf.contact_mobile'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
            });
        }

        $filter['expire'] = $db_store_franchisee
            ->where(RC_DB::raw('sf.account_status'), 'wait_delete')
            ->where(RC_DB::raw('sf.shop_close'), 1)
            ->whereRaw("FROM_UNIXTIME(sf.delete_time, '%Y-%m-%d') <= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")
            ->count();

        $filter['unexpired'] = $db_store_franchisee_two
            ->where(RC_DB::raw('sf.account_status'), 'wait_delete')
            ->where(RC_DB::raw('sf.shop_close'), 1)
            ->whereRaw("FROM_UNIXTIME(delete_time, '%Y-%m-%d') > DATE_SUB(CURDATE(), INTERVAL 30 DAY)")
            ->count();

        $count = empty($filter['type']) ? $filter['expire'] : $filter['unexpired'];
        $db    = empty($filter['type']) ? $db_store_franchisee : $db_store_franchisee_two;
        $page  = new ecjia_page($count, 15, 5);
        $data  = $db
            ->leftJoin('store_category as sc', RC_DB::raw('sf.cat_id'), '=', RC_DB::raw('sc.cat_id'))
            ->select(RC_DB::raw('sf.store_id, sf.merchants_name, sf.manage_mode, sc.cat_name, sf.responsible_person, sf.company_name, sf.contact_mobile, sf.delete_time'))
            ->orderby(RC_DB::raw('sf.delete_time'), 'desc')
            ->take($page->page_size)
            ->skip($page->start_id - 1)
            ->get();

        $res = array();
        if (!empty($data)) {
            $curtime = RC_Time::local_date('Y-m-d H:i:s', RC_Time::gmtime());
            foreach ($data as $row) {
                $expire_time        = RC_Time::local_date('Y-m-d H:i:s', $row['delete_time'] + 30 * 24 * 3600);
                $row['delete_time'] = RC_Time::local_date('Y-m-d H:i:s', $row['delete_time']);

                $diff        = $this->diffDate($curtime, $expire_time);
                $row['diff'] = empty($diff) ? __('1天内', 'store') : $diff;
                $res[]       = $row;
            }
        }
        return array('item' => $res, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    private function diffDate($date1, $date2)
    {
        $datetime1 = new \DateTime($date1);
        $datetime2 = new \DateTime($date2);
        $interval  = $datetime1->diff($datetime2);
        $time['y'] = $interval->format('%Y');
        $time['m'] = $interval->format('%m');
        $time['d'] = $interval->format('%d');
        $time['h'] = $interval->format('%h');

        $time_str = '';
        $year     = intval($time['y']);
        if (!empty($year)) {
            $time_str .= $year . __('年', 'store');
        }
        $month = intval($time['m']);
        if (!empty($month)) {
            $time_str .= $month . __('个月', 'store');
        }
        $day = intval($time['d']);
        if (!empty($day)) {
            $time_str .= $day . __('天', 'store');
        }
        $hour = intval($time['h']);
        if (!empty($day)) {
            $time_str .= $hour . __('小时', 'store');
        }
        return $time_str;
    }


}

//end

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
 * 营销活动
 */
class platform extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        //Ecjia\App\Market\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('bootstrap-placeholder');

        RC_Style::enqueue_style('activity', RC_App::apps_url('statics/platform-css/activity.css', __FILE__));
        RC_Style::enqueue_style('prize', RC_App::apps_url('statics/platform-css/prize.css', __FILE__));

        //时间控件
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
        RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));

        RC_Script::enqueue_script('platform_activity', RC_App::apps_url('statics/platform-js/platform_activity.js', __FILE__), array(), false, true);
        RC_Script::localize_script('platform_activity', 'js_lang', RC_Lang::get('market::market.js_lang'));

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('market::market.activity_list'), RC_Uri::url('market/platform/init')));
        ecjia_platform_screen::get_current_screen()->set_subject('营销活动');
    }

    /**
     * 活动列表
     */
    public function init()
    {
        $this->admin_priv('market_activity_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('market::market.activity_list')));
        $this->assign('ur_here', RC_Lang::get('market::market.activity_list'));

        $activity_list = $this->get_activity_list();

        $this->assign('activity_list', $activity_list);

        $this->display('market_activity_list.dwt');
    }

    /**
     *活动详情
     */
    public function activity_detail()
    {
        $this->admin_priv('market_activity_update');
        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('market::market.activity_detail')));

        $this->assign('ur_here', RC_Lang::get('market::market.activity_detail'));
        $this->assign('form_action', RC_Uri::url('market/platform/update'));
        $this->assign('action_link', array('text' => RC_Lang::get('market::market.back_activity_list'), 'href' => RC_Uri::url('market/platform/init')));

        $code = trim($_GET['code']);
        $activity_detail = [];
        if (!empty($code)) {
            $factory = new Ecjia\App\Market\Factory();
            $activity_info = $factory->driver($code);
            $activity_detail['code'] = $activity_info->getCode();
            $activity_detail['name'] = $activity_info->getName();
            $activity_detail['description'] = $activity_info->getDescription();
            $activity_detail['icon'] = $activity_info->getIcon();
            $this->assign('activity_detail', $activity_detail);
            $this->assign('code', $code);
            $wechat_id = $this->platformAccount->getAccountID();

            $info = RC_DB::table('market_activity')->where('activity_group', $code)->where('enabled', 1)->where('store_id', $_SESSION['store_id'])->where('wechat_id', $wechat_id)->first();
            if (!empty($info)) {
                $info['start_time'] = RC_Time::local_date('Y-m-d H:i', $info['start_time']);
                $info['end_time'] = RC_Time::local_date('Y-m-d H:i', $info['end_time']);
                $this->assign('info', $info);
                $this->assign('activity_info', $info);

                $this->assign('action_edit', RC_Uri::url('market/platform/edit', array('code' => $code)));
                $this->assign('action_prize', RC_Uri::url('market/platform/activity_prize', array('code' => $code)));
                //$this->assign('action_record', RC_Uri::url('market/platform/activity_record', array('code' => $code)));
                $this->assign('action_record', RC_Uri::url('market/platform_prize/init', array('code' => $code)));
            }
        }
        $this->assign('images_url', RC_App::apps_url('statics/image/', __FILE__));
        $this->display('activity_detail.dwt');
    }

    /**
     * 活动编辑页面
     */
    public function edit()
    {
        $this->admin_priv('market_activity_update');

        $wechat_id = $this->platformAccount->getAccountID();
        $code = trim($_GET['code']);
        $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('enabled', 1)->where('store_id', $_SESSION['store_id'])->where('wechat_id', $wechat_id)->first();

        $activity_info['start_time'] = RC_Time::local_date('Y-m-d H:i', $activity_info['start_time']);
        $activity_info['end_time'] = RC_Time::local_date('Y-m-d H:i', $activity_info['end_time']);

        $this->assign('action_link', array('text' => RC_Lang::get('market::market.back_activity_info'), 'href' => RC_Uri::url('market/platform/activity_detail', array('code' => $code))));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('market::market.edit_activity')));

        $this->assign('ur_here', RC_Lang::get('market::market.edit_activity'));
        $this->assign('form_action', RC_Uri::url('market/platform/update'));

        $this->assign('activity_info', $activity_info);
        $this->display('activity_edit.dwt');
    }

    /**
     * 关闭活动
     */
    public function close_activity()
    {
        $this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);
        $wechat_id = $this->platformAccount->getAccountID();
        $code = trim($_GET['code']);
        if (!empty($code)) {
            //$activity_name = RC_DB::table('market_activity')->where('activity_group', $code)->where('store_id', $_SESSION['store_id'])->pluck('activity_name');

            RC_DB::table('market_activity')->where('activity_group', $code)->where('store_id', $_SESSION['store_id'])->where('wechat_id', $wechat_id)->update(array('enabled' => 0));

            //ecjia_admin::admin_log($activity_name, 'stop', 'market_activity');
            return $this->showmessage(RC_Lang::get('market::market.close_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/platform/activity_detail', array('code' => $code))));
        } else {
            return $this->showmessage(RC_Lang::get('market::market.wrong_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 开通活动
     */
    public function open_activity()
    {
        $this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);
        $wechat_id = $this->platformAccount->getAccountID();
        $code = trim($_GET['code']);
        if (!empty($code)) {
            $factory = new Ecjia\App\Market\Factory();
            $info = $factory->driver($code);
            $activity_detail['code'] = $info->getCode();
            $activity_detail['name'] = $info->getName();
            $activity_detail['description'] = $info->getDescription();

            $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('store_id', $_SESSION['store_id'])->where('wechat_id', $wechat_id)->first();
            if (!empty($activity_info)) {
                RC_DB::table('market_activity')->where('activity_id', $activity_info['activity_id'])->update(array('enabled' => 1, 'activity_object' => 'wechat'));
            } else {
                $activity_info = array(
                    'store_id' => $_SESSION['store_id'],
                    'activity_name' => $activity_detail['name'],
                    'activity_group' => $activity_detail['code'],
                    'activity_desc' => $activity_detail['description'],
                    'activity_object' => 'wechat',
                    'add_time' => RC_Time::gmtime(),
                    'enabled' => 1,
                    'wechat_id' => $wechat_id,
                );
                RC_DB::table('market_activity')->insertGetId($activity_info);
            }
            //ecjia_admin::admin_log($activity_info['activity_name'], 'use', 'market_activity');
            return $this->showmessage(RC_Lang::get('market::market.open_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/platform/activity_detail', array('code' => $code))));
        } else {
            return $this->showmessage(RC_Lang::get('market::market.wrong_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 更新活动
     */
    public function update()
    {
        $this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);

        $limit_num = empty($_POST['limit_num']) ? 0 : intval($_POST['limit_num']);
        $limit_time = empty($_POST['limit_time']) ? 0 : intval($_POST['limit_time']);
        $start_time = empty($_POST['start_time']) ? '' : RC_Time::local_strtotime($_POST['start_time']);
        $end_time = empty($_POST['end_time']) ? '' : RC_Time::local_strtotime($_POST['end_time']);
        $activity_desc = empty($_POST['activity_desc']) ? '' : trim($_POST['activity_desc']);
        $id = empty($_POST['id']) ? 0 : intval($_POST['id']);

        $activity_code = empty($_POST['activity_code']) ? '' : trim($_POST['activity_code']);

        if (empty($start_time)) {
            return $this->showmessage(RC_Lang::get('market::market.start_time_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($end_time)) {
            return $this->showmessage(RC_Lang::get('market::market.end_time_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($start_time >= $end_time) {
            return $this->showmessage(RC_Lang::get('market::market.time_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        //$activity_name =  RC_DB::table('market_activity')->where('activity_id', $id)->pluck('activity_name');

        $data = array(
            'limit_num' => $limit_num,
            'limit_time' => $limit_time,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'activity_desc' => $activity_desc,
            'add_time' => RC_Time::gmtime(),
        );

        RC_DB::table('market_activity')->where('activity_id', $id)->update($data);

        //ecjia_admin::admin_log($activity_name, 'edit', 'market_activity');
        return $this->showmessage(RC_Lang::get('market::market.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/platform/edit', array('code' => $activity_code))));
    }

    /**
     * 活动奖品池页面显示
     */
    public function activity_prize()
    {
        $this->admin_priv('market_activity_manage');

        $wechat_id = $this->platformAccount->getAccountID();
        $activity_code = trim($_GET['code']);

        $id = RC_DB::table('market_activity')->where('activity_group', $activity_code)->where('store_id', $_SESSION['store_id'])->where('wechat_id', $wechat_id)->pluck('activity_id');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('market::market.prize_pool')));

        $count = RC_DB::table('market_activity_prize')->where('activity_id', $id)->count();
        $page = new ecjia_platform_page($count, 15, 5);

        $prize_list = RC_DB::table('market_activity_prize')->where('activity_id', $id)->take(15)->skip($page->start_id - 1)->orderby('prize_level', 'asc')->get();
        if (!empty($prize_list)) {
            foreach ($prize_list as $k => $v) {
                if ($v['prize_type'] == '1') {
                    $prize_value = RC_DB::table('bonus_type')->where('type_id', $v['prize_value'])->pluck('type_money');
                    $prize_list[$k]['prize_value_label'] = price_format($prize_value, false);
                } elseif ($v['prize_type'] == '6') {
                    $prize_list[$k]['prize_value_label'] = price_format($v['prize_value'], false);
                } else {
                    $prize_list[$k]['prize_value_label'] = $v['prize_value'];
                }
                $prize_list[$k]['is_used'] = RC_DB::table('market_activity_log')->where('activity_id', $id)->where('prize_id', $v['prize_id'])->count();
            }
        }
        $data = array('item' => $prize_list, 'page' => $page->show(), 'desc' => $page->page_desc(), 'current_page' => $page->current_page, 'total_pages' => $page->total_pages);
        $this->assign('data', $data);

        $this->assign('ur_here', RC_Lang::get('market::market.prize_pool'));
        $this->assign('id', $id);
        $this->assign('code', $activity_code);
        $this->assign('store_id', $_SESSION['store_id']);
        $this->assign('action_link', array('href' => RC_Uri::url('market/platform/activity_detail', array('code' => $activity_code)), 'text' => RC_Lang::get('market::market.back_activity_info')));
        $this->assign('form_action', RC_Uri::url('market/platform/activity_prize_edit', array('code' => $activity_code)));

        $this->display('prize_list.dwt');
    }

    /**
     * 活动奖品添加
     */
    public function activity_prize_add()
    {
        $this->admin_priv('market_activity_manage');

        $wechat_id = $this->platformAccount->getAccountID();
        $activity_code = trim($_GET['code']);

        $id = RC_DB::table('market_activity')->where('activity_group', $activity_code)->where('store_id', $_SESSION['store_id'])->where('wechat_id', $wechat_id)->pluck('activity_id');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('market::market.prize_pool')));

        $prize_type = Ecjia\App\Market\Prize\PrizeType::getPrizeTypes();
        $this->assign('prize_type', $prize_type);

        $time = RC_Time::gmtime();
        $bonus_list = RC_DB::table('bonus_type')->where('store_id', $_SESSION['store_id'])->where('use_start_date', '<=', $time)->where('use_end_date', '>=', $time)->select('type_id', 'type_name')->get();
        $this->assign('bonus_list', $bonus_list);

        $this->assign('ur_here', RC_Lang::get('market::market.prize_pool'));
        $this->assign('code', $activity_code);
        $this->assign('action_link', array('href' => RC_Uri::url('market/platform/activity_prize', array('code' => $activity_code)), 'text' => RC_Lang::get('market::market.prize_pool')));
        $this->assign('form_action', RC_Uri::url('market/platform/activity_prize_insert', array('code' => $activity_code)));

        $this->display('activity_prize_add.dwt');
    }

    /**
     * 活动奖品池添加处理
     */
    public function activity_prize_insert()
    {
        $this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);

        $prize_level = isset($_POST['prize_level']) ? $_POST['prize_level'] : '';
        $prize_name = $_POST['prize_name'];
        $prize_type = isset($_POST['prize_type']) ? $_POST['prize_type'] : '';
        $prize_value = $_POST['prize_value'];
        $prize_value_other = $_POST['prize_value_other'];
        $prize_number = $_POST['prize_number'];
        $prize_prob = $_POST['prize_prob'];

        $code = $_POST['code'];
        $wechat_id = $this->platformAccount->getAccountID();
        $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('wechat_id', $wechat_id)->where('store_id', $_SESSION['store_id'])->first();

        if ($prize_level === '') {
            return $this->showmessage('请选择奖品等级！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($prize_name)) {
            return $this->showmessage('请填写奖品名称！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($prize_type === '') {
            return $this->showmessage('请填写奖品类型！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $prize_value_final = '';
        if ($prize_type == 1) {
            if (empty($prize_value)) {
                return $this->showmessage('请选择礼券奖品的红包！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $prize_value_final = $prize_value;
        } else if (in_array($prize_type, [2, 3, 6])) {
            if (empty($prize_value_other)) {
                return $this->showmessage('请填写奖品内容！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $prize_value_final = $prize_value_other;
        }

        if (empty($prize_number)) {
            return $this->showmessage('请填写奖品数量！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($prize_prob)) {
            return $this->showmessage('请填写获奖概率！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'activity_id' => $activity_info['activity_id'],
            'prize_level' => $prize_level,
            'prize_name' => $prize_name,
            'prize_type' => $prize_type,
            'prize_value' => $prize_value_final,
            'prize_number' => $prize_number,
            'prize_prob' => $prize_prob,
        );
        $p_id = RC_DB::table('market_activity_prize')->insertGetId($data);

        return $this->showmessage(RC_Lang::get('market::market.edit_prize_pool_succss'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/platform/activity_prize_edit', array('code' => $code, 'p_id' => $p_id))));
    }

    /**
     * 活动奖品编辑
     */
    public function activity_prize_edit()
    {
        $this->admin_priv('market_activity_manage');

        $wechat_id = $this->platformAccount->getAccountID();
        $activity_code = trim($_GET['code']);
        $p_id = intval($_GET['p_id']);
        $id = RC_DB::table('market_activity')->where('activity_group', $activity_code)->where('store_id', $_SESSION['store_id'])->where('wechat_id', $wechat_id)->pluck('activity_id');
        $activity_prize = RC_DB::table('market_activity_prize')->where('prize_id', $p_id)->first();

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('market::market.prize_pool')));

        $prize_type = Ecjia\App\Market\Prize\PrizeType::getPrizeTypes();
        $this->assign('prize_type', $prize_type);

        $time = RC_Time::gmtime();
        $bonus_list = RC_DB::table('bonus_type')->where('store_id', $_SESSION['store_id'])->where('use_start_date', '<=', $time)->where('use_end_date', '>=', $time)->select('type_id', 'type_name')->get();
        $this->assign('bonus_list', $bonus_list);
        $this->assign('activity_prize', $activity_prize);

        $this->assign('ur_here', RC_Lang::get('market::market.prize_pool'));
        $this->assign('code', $activity_code);
        $this->assign('p_id', $p_id);
        $this->assign('action_link', array('href' => RC_Uri::url('market/platform/activity_prize', array('code' => $activity_code)), 'text' => RC_Lang::get('market::market.prize_pool')));
        $this->assign('form_action', RC_Uri::url('market/platform/activity_prize_update', array('code' => $activity_code)));

        $this->display('activity_prize_add.dwt');
    }

    /**
     * 活动奖品池编辑处理
     */
    public function activity_prize_update()
    {
        $this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);

        $prize_level = isset($_POST['prize_level']) ? $_POST['prize_level'] : '';
        $prize_name = $_POST['prize_name'];
        $prize_type = isset($_POST['prize_type']) ? $_POST['prize_type'] : '';
        $prize_value = $_POST['prize_value'];
        $prize_value_other = $_POST['prize_value_other'];
        $prize_number = $_POST['prize_number'];
        $prize_prob = $_POST['prize_prob'];

        $p_id = $_POST['p_id'];

        $code = $_POST['code'];
        $wechat_id = $this->platformAccount->getAccountID();
        $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('wechat_id', $wechat_id)->where('store_id', $_SESSION['store_id'])->first();

        if ($prize_level === '') {
            return $this->showmessage('请选择奖品等级！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($prize_name)) {
            return $this->showmessage('请填写奖品名称！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($prize_type === '') {
            return $this->showmessage('请填写奖品类型！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $prize_value_final = '';
        if ($prize_type == 1) {
            if (empty($prize_value)) {
                return $this->showmessage('请选择礼券奖品的红包！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $prize_value_final = $prize_value;
        } else if (in_array($prize_type, [2, 3, 6])) {
            if (empty($prize_value_other)) {
                return $this->showmessage('请填写奖品内容！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $prize_value_final = $prize_value_other;
        }

        if (empty($prize_number)) {
            return $this->showmessage('请填写奖品数量！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($prize_prob)) {
            return $this->showmessage('请填写获奖概率！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'activity_id' => $activity_info['activity_id'],
            'prize_level' => $prize_level,
            'prize_name' => $prize_name,
            'prize_type' => $prize_type,
            'prize_value' => $prize_value_final,
            'prize_number' => $prize_number,
            'prize_prob' => $prize_prob,
        );

        RC_DB::table('market_activity_prize')->where('prize_id', $p_id)->update($data);

        return $this->showmessage(RC_Lang::get('market::market.edit_prize_pool_succss'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 活动奖品池编辑处理
     */
    public function activity_prize_remove()
    {
        $this->admin_priv('market_activity_delete', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $activity_code = trim($_GET['code']);
        $p_id = intval($_GET['p_id']);

        $activity_id_list = RC_DB::table('market_activity')->where('wechat_id', $wechat_id)->where('store_id', $_SESSION['store_id'])->lists('activity_id');
        RC_DB::table('market_activity_prize')->where('prize_id', $p_id)->whereIn('activity_id', $activity_id_list)->delete();

        return $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 活动记录列表
     */
    public function activity_record()
    {
        $this->admin_priv('activity_record_manage');

        $this->assign('action_link', array('text' => RC_Lang::get('market::market.back_activity_list'), 'href' => RC_Uri::url('market/platform/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('market::market.view_activity_record')));

        $this->assign('ur_here', RC_Lang::get('market::market.activity_record'));

        $wechat_id = $this->platformAccount->getAccountID();
        $activity_code = trim($_GET['code']);
        $this->assign('action_link', array('href' => RC_Uri::url('market/platform/activity_detail', array('code' => $activity_code)), 'text' => RC_Lang::get('market::market.back_activity_info')));
        if (!empty($activity_code)) {
            $factory = new Ecjia\App\Market\Factory();
            $activity_info = $factory->driver($activity_code);
            $activity_detail['code'] = $activity_info->getCode();
            $activity_detail['name'] = $activity_info->getName();
            $activity_detail['description'] = $activity_info->getDescription();
            $activity_detail['icon'] = $activity_info->getIcon();
            $this->assign('activity_detail', $activity_detail);
            $info = RC_DB::table('market_activity')->where('activity_group', $activity_code)->where('store_id', $_SESSION['store_id'])->where('wechat_id', $wechat_id)->where('enabled', 1)->first();
            if (!empty($info)) {
                $info['start_time'] = RC_Time::local_date('Y-m-d H:i', $info['start_time']);
                $info['end_time'] = RC_Time::local_date('Y-m-d H:i', $info['end_time']);
                $this->assign('info', $info);
            }
        }
        $list = $this->get_activity_record_list($info['activity_id']);

        $this->assign('activity_record_list', $list);
        $this->assign('tags', $this->tags);

        $this->display('activity_record.dwt');
    }

    /**
     * 获取活动列表
     * @return array
     */
    private function get_activity_list()
    {

        $wechat_id = $this->platformAccount->getAccountID();
        $store_id = $this->platformAccount->getStoreId();

        $activity_list = array();

        $factory = new Ecjia\App\Market\Factory();
        if ($store_id > 0) {
            $activity_data = $factory->getDrivers(Ecjia\App\Market\MarketAbstract::DISPLAY_PLATFORM | Ecjia\App\Market\MarketAbstract::ACCOUNT_MERCHANT);
        } else {
            $activity_data = $factory->getDrivers(Ecjia\App\Market\MarketAbstract::DISPLAY_PLATFORM | Ecjia\App\Market\MarketAbstract::ACCOUNT_ADMIN);
        }

        foreach ($activity_data as $k => $event) {
            $activity_list[$k]['code'] = $event->getCode();
            $activity_list[$k]['name'] = $event->getName();
            $activity_list[$k]['description'] = $event->getDescription();
            $activity_list[$k]['icon'] = $event->getIcon();
        }
        return $activity_list;
    }

    /**
     * 获取活动记录列表数据
     * @return array
     */
    private function get_activity_record_list($activity_id = 0)
    {
        $db_activity_log = RC_DB::table('market_activity_log');

        if (!empty($activity_id)) {
            $db_activity_log->where('activity_id', $activity_id);
        }

        $count = $db_activity_log->count();
        $page = new ecjia_platform_page($count, 15, 5);
        $res = $db_activity_log->where('activity_id', $activity_id)->orderBy('add_time', 'desc')->take(15)->skip($page->start_id - 1)->get();

        if (!empty($res)) {
            foreach ($res as $key => $val) {
                $res[$key]['issue_time'] = RC_Time::local_date('Y-m-d H:i:s', $res[$key]['issue_time']);
                $res[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $res[$key]['add_time']);
                $res[$key]['prize_type'] = RC_DB::table('market_activity_prize')->where('prize_id', $val['prize_type'])->pluck('prize_type');
            }
        }
        return array('item' => $res, 'page' => $page->show(), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
    }
}

//end

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
 * 摇一摇活动管理控制器
 */
class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Market\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Style::enqueue_style('chosen');

        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-placeholder');

        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));

        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

        RC_Script::enqueue_script('activity', RC_App::apps_url('statics/js/activity.js', __FILE__), array(), false, 1);
        RC_Style::enqueue_style('activity', RC_App::apps_url('statics/css/activity.css', __FILE__));
        RC_Script::localize_script('activity', 'js_lang', config('app-market::jslang.market_page'));

        //时间控件
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
        RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));

        ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(__('营销活动', 'market'), RC_Uri::url('market/admin/init')));
        $activity_id = isset($_GET['id']) ? $_GET['id'] : 0;
        $activity_code = isset($_GET['code']) ? trim($_GET['code']) : 'mobile_shake';
        $this->tags = array(
            'activity_detail' => array('name' => __('编辑营销活动', 'market'), 'pjax' => 1, 'href' => RC_Uri::url('market/admin/activity_detail', "code=$activity_code")),
            'activity_prize' => array('name' => __('活动奖品池', 'market'), 'pjax' => 1, 'href' => RC_Uri::url('market/admin/activity_prize', "code=$activity_code")),
            'activity_record' => array('name' => __('活动记录', 'market'), 'pjax' => 1, 'href' => RC_Uri::url('market/admin/activity_record', "code=$activity_code")),
        );

        $this->tags[ROUTE_A]['active'] = 1;
    }

    /**
     *活动列表页面加载
     */
    public function init()
    {
        $this->admin_priv('market_activity_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('营销活动', 'market')));

        $this->assign('ur_here', __('营销活动', 'market'));
        //$this->assign('action_link', array('text' => __('添加活动', 'market'), 'href' => RC_Uri::url('market/admin/add')));
        $this->assign('search_action', RC_Uri::url('market/admin/init'));

        $activity_list = $this->get_activity_list();

        $this->assign('activity_list', $activity_list);

        return $this->display('activity_list.dwt');
    }

    /**
     *活动详情
     */
    public function activity_detail()
    {
        $this->admin_priv('market_activity_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('活动详情', 'market')));
        $this->assign('ur_here', __('活动详情', 'market'));
        $this->assign('form_action', RC_Uri::url('market/admin/update'));
        $this->assign('action_link', array('text' => __('返回营销活动', 'market'), 'href' => RC_Uri::url('market/admin/init')));

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
            $info = RC_DB::table('market_activity')->where('activity_group', $code)->where('enabled', 1)->where('store_id', 0)->where('wechat_id', 0)->first();
            if (!empty($info)) {
                $info['formated_start_time'] 	=  !empty($info['start_time']) ? RC_Time::local_date(ecjia::config('time_format'), $info['start_time']) : '';
                $info['formated_end_time'] 		=  !empty($info['end_time']) ? RC_Time::local_date(ecjia::config('time_format'), $info['end_time']) : '';
                $info['limit_time']	= $info['limit_time']/60;
                $this->assign('info', $info);
                $this->assign('activity_info', $info);

                $this->assign('action_edit', RC_Uri::url('market/admin/edit', array('code' => $code)));
                $this->assign('action_prize', RC_Uri::url('market/admin/activity_prize', array('code' => $code)));
                $this->assign('action_record', RC_Uri::url('market/admin/activity_record', array('code' => $code)));
            }
        }
        $this->assign('images_url', RC_App::apps_url('statics/image/', __FILE__));
        return $this->display('activity_detail.dwt');
    }

    /**
     * 活动编辑页面
     */
    public function edit()
    {
        $this->admin_priv('market_activity_update');

        $code = trim($_GET['code']);
        $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('enabled', 1)->where('store_id', 0)->where('wechat_id', 0)->first();

        $activity_info['start_time'] = RC_Time::local_date('Y-m-d H:i', $activity_info['start_time']);
        $activity_info['end_time'] = RC_Time::local_date('Y-m-d H:i', $activity_info['end_time']);
        
        $activity_info['limit_time'] = $activity_info['limit_time']/60;
        
        $this->assign('action_link', array('text' => __('返回活动详情', 'market'), 'href' => RC_Uri::url('market/admin/activity_detail', array('code' => $code))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑营销活动', 'market')));

        $this->assign('ur_here', __('编辑营销活动', 'market'));
        $this->assign('form_action', RC_Uri::url('market/admin/update'));

        $this->assign('activity_info', $activity_info);
        return $this->display('activity_edit.dwt');
    }

    /**
     * 关闭活动
     */
    public function close_activity()
    {
        $this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);
        $code = trim($_GET['code']);
        if (!empty($code)) {
            $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('store_id', 0)->where('wechat_id', 0)->first();

            RC_DB::table('market_activity')->where('activity_id', $activity_info['activity_id'])->update(array('enabled' => 0));

            ecjia_admin::admin_log($activity_info['activity_name'], 'stop', 'market_activity');
            return $this->showmessage(__('成功关闭营销活动', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/admin/activity_detail', array('code' => $code))));
        } else {
            return $this->showmessage(__('错误的参数', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 开通活动
     */
    public function open_activity()
    {
        $this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);
        $code = trim($_GET['code']);
        if (!empty($code)) {
            $factory = new Ecjia\App\Market\Factory();
            $info = $factory->driver($code);
            $activity_detail['code'] = $info->getCode();
            $activity_detail['name'] = $info->getName();
            $activity_detail['description'] = $info->getDescription();

            $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('store_id', 0)->where('wechat_id', 0)->first();
            if (!empty($activity_info)) {
                RC_DB::table('market_activity')->where('activity_id', $activity_info['activity_id'])->update(array('enabled' => 1, 'activity_object' => 'app'));
            } else {
                $activity_info = array(
                    'store_id' => 0,
                    'activity_name' => $activity_detail['name'],
                    'activity_group' => $activity_detail['code'],
                    'activity_desc' => $activity_detail['description'],
                    'activity_object' => 'app',
                    'add_time' => RC_Time::gmtime(),
                    'enabled' => 1,
                    'wechat_id' => 0,
                );
                RC_DB::table('market_activity')->insertGetId($activity_info);
            }
            ecjia_admin::admin_log($activity_info['activity_name'], 'use', 'market_activity');
            return $this->showmessage(__('成功开启营销活动', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/admin/activity_detail', array('code' => $code))));
        } else {
            return $this->showmessage(__('错误的参数', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
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
            return $this->showmessage(__('请输入活动开始时间', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($end_time)) {
            return $this->showmessage(__('请输入活动结束时间', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($start_time >= $end_time) {
            return $this->showmessage(__('活动开始时间不能大于结束时间', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($limit_num < 0) {
        	return $this->showmessage(__('活动限购次数不可小于0', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        $activity_name = RC_DB::table('market_activity')->where('activity_id', $id)->pluck('activity_name');

        $data = array(
            'limit_num' => $limit_num,
            'limit_time' => $limit_time*60,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'activity_desc' => $activity_desc,
            'add_time' => RC_Time::gmtime(),
        );

        RC_DB::table('market_activity')->where('activity_id', $id)->update($data);

        ecjia_admin::admin_log($activity_name, 'edit', 'market_activity');
        return $this->showmessage(__('编辑活动成功', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/admin/edit', array('code' => $activity_code))));
    }

    /**
     * 活动记录列表
     */
    public function activity_record()
    {
        $this->admin_priv('activity_record_manage');

        $this->assign('action_link', array('text' => __('返回营销活动', 'market'), 'href' => RC_Uri::url('market/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('查看活动记录', 'market')));

        $this->assign('ur_here', __('添加活动', 'market'));

        $activity_code = trim($_GET['code']);
        $this->assign('action_link', array('href' => RC_Uri::url('market/admin/activity_detail', array('code' => $activity_code)), 'text' => __('返回活动详情', 'market')));
        if (!empty($activity_code)) {
            $factory = new Ecjia\App\Market\Factory();
            $activity_info = $factory->driver($activity_code);
            $activity_detail['code'] = $activity_info->getCode();
            $activity_detail['name'] = $activity_info->getName();
            $activity_detail['description'] = $activity_info->getDescription();
            $activity_detail['icon'] = $activity_info->getIcon();
            $this->assign('activity_detail', $activity_detail);
            $info = RC_DB::table('market_activity')->where('activity_group', $activity_code)->where('store_id', 0)->where('enabled', 1)->first();
            if (!empty($info)) {
                $info['start_time'] = RC_Time::local_date('Y-m-d H:i', $info['start_time']);
                $info['end_time'] = RC_Time::local_date('Y-m-d H:i', $info['end_time']);
                $this->assign('info', $info);
            }
        }
        $list = $this->get_activity_record_list($info['activity_id']);

        $this->assign('activity_record_list', $list);
        $this->assign('tags', $this->tags);

        return $this->display('activity_record.dwt');
    }

    /**
     * 活动奖品池页面显示
     */
    public function activity_prize()
    {
        $this->admin_priv('market_activity_manage');

        $activity_code = trim($_GET['code']);

        $id = RC_DB::table('market_activity')->where('activity_group', $activity_code)->where('store_id', 0)->pluck('activity_id');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('活动奖品池', 'market')));

        $count = RC_DB::table('market_activity_prize')->where('activity_id', $id)->count();
        $page = new ecjia_page($count, 15, 5);

        $prize_list = RC_DB::table('market_activity_prize')->where('activity_id', $id)->take(15)->skip($page->start_id - 1)->orderby('prize_level', 'asc')->get();
        if (!empty($prize_list)) {
            foreach ($prize_list as $k => $v) {
                if ($v['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BONUS) {
                    $prize_value = RC_DB::table('bonus_type')->where('type_id', $v['prize_value'])->pluck('type_money');
                    $prize_list[$k]['prize_value_label'] = price_format($prize_value, false);
                } elseif ($v['prize_type'] == Ecjia\App\Market\Prize\PrizeType::TYPE_BALANCE) {
                    $prize_list[$k]['prize_value_label'] = price_format($v['prize_value'], false);
                } else {
                    $prize_list[$k]['prize_value_label'] = $v['prize_value'];
                }
                $prize_list[$k]['is_used'] = RC_DB::table('market_activity_log')->where('activity_id', $id)->where('prize_id', $v['prize_id'])->count();
            }
        }
        $data = array('item' => $prize_list, 'page' => $page->show(), 'desc' => $page->page_desc(), 'current_page' => $page->current_page, 'total_pages' => $page->total_pages);
        $this->assign('data', $data);

        $this->assign('ur_here', __('活动奖品池', 'market'));
        $this->assign('code', $activity_code);
        $this->assign('action_link', array('href' => RC_Uri::url('market/admin/activity_detail', array('code' => $activity_code)), 'text' => __('返回活动详情', 'market')));
        $this->assign('form_action', RC_Uri::url('market/admin/activity_prize_edit', array('code' => $activity_code)));

        return $this->display('activity_prize_list.dwt');
    }

    /**
     * 活动奖品添加
     */
    public function activity_prize_add()
    {
        $this->admin_priv('market_activity_manage');

        $activity_code = trim($_GET['code']);

        $id = RC_DB::table('market_activity')->where('activity_group', $activity_code)->where('store_id', 0)->where('wechat_id', 0)->pluck('activity_id');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('活动奖品池', 'market')));

        $prize_type = Ecjia\App\Market\Prize\PrizeType::getPrizeTypes();
        $this->assign('prize_type', $prize_type);

        $time = RC_Time::gmtime();
        $bonus_list = RC_DB::table('bonus_type')
        				->where('store_id', 0)
        				->where('use_start_date', '<=', $time)
        				->where('use_end_date', '>=', $time)
        				->whereIn('send_type', array(1,2))
        				->select('type_id', 'type_name')
        				->get();
        $this->assign('bonus_list', $bonus_list);

        $this->assign('ur_here', __('活动奖品池', 'market'));
        $this->assign('code', $activity_code);
        $this->assign('action_link', array('href' => RC_Uri::url('market/admin/activity_prize', array('code' => $activity_code)), 'text' => __('活动奖品池', 'market')));
        $this->assign('form_action', RC_Uri::url('market/admin/activity_prize_insert', array('code' => $activity_code)));

        return $this->display('activity_prize_add.dwt');
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
        $wechat_id = 0;
        $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('wechat_id', $wechat_id)->where('store_id', 0)->first();

        if ($prize_level === '') {
            return $this->showmessage(__('请选择奖品等级！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($prize_name)) {
            return $this->showmessage(__('请填写奖品名称！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($prize_type === '') {
            return $this->showmessage(__('请填写奖品类型！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $prize_value_final = '';
        $prize_type_arr = array(
        		Ecjia\App\Market\Prize\PrizeType::TYPE_REAL,
        		Ecjia\App\Market\Prize\PrizeType::TYPE_INTEGRAL,
        		Ecjia\App\Market\Prize\PrizeType::TYPE_BALANCE
        );
        if ($prize_type == Ecjia\App\Market\Prize\PrizeType::TYPE_BONUS) {
            if (empty($prize_value)) {
                return $this->showmessage(__('请选择礼券奖品的红包！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $prize_value_final = $prize_value;
        } else if (in_array($prize_type, $prize_type_arr)) {
            if (empty($prize_value_other)) {
                return $this->showmessage(__('请填写奖品内容！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $prize_value_final = $prize_value_other;
        }

        if (empty($prize_number)) {
            return $this->showmessage(__('请填写奖品数量！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($prize_prob <= 0) {
            return $this->showmessage(__('请填写获奖概率！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        //某个活动的所有奖品中奖概率不能大于100
        $current_all_prize_prob_final = 0;
        if (!empty($prize_prob)) {
        	$current_all_prize_prob = RC_DB::table('market_activity_prize')->where('activity_id', $activity_info['activity_id'])->lists('prize_prob');
        	if ($current_all_prize_prob) {
        		foreach ($current_all_prize_prob as $row) {
        			$current_all_prize_prob_final += $row;
        		}
        	}
        	if ($current_all_prize_prob_final > 100 || ($current_all_prize_prob_final + $prize_prob) > 100) {
        		return $this->showmessage(__('活动所有奖品获奖概率总和不可大于100', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
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
		
        ecjia_admin::admin_log('活动'.$activity_info['activity_name'].'的奖品'.$prize_name, 'add', 'market_activity_prize');
        
        return $this->showmessage(__('修改活动奖品池成功', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/admin/activity_prize_edit', array('code' => $code, 'p_id' => $p_id))));
    }

    /**
     * 活动奖品编辑
     */
    public function activity_prize_edit()
    {
        $this->admin_priv('market_activity_manage');

        $wechat_id = 0;
        $activity_code = trim($_GET['code']);
        $p_id = intval($_GET['p_id']);
        $id = RC_DB::table('market_activity')->where('activity_group', $activity_code)->where('store_id', 0)->where('wechat_id', $wechat_id)->pluck('activity_id');
        $activity_prize = RC_DB::table('market_activity_prize')->where('prize_id', $p_id)->first();
       

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('活动奖品池', 'market')));

        $prize_type = Ecjia\App\Market\Prize\PrizeType::getPrizeTypes();
        $this->assign('prize_type', $prize_type);

        $time = RC_Time::gmtime();
        $bonus_list = RC_DB::table('bonus_type')
        					->where('store_id', 0)
        					->where('use_start_date', '<=', $time)
        					->where('use_end_date', '>=', $time)
        					->whereIn('send_type', array(1,2))
        					->select('type_id', 'type_name')
        					->get();
        $this->assign('bonus_list', $bonus_list);
        $this->assign('activity_prize', $activity_prize);

        $this->assign('ur_here', __('活动奖品池', 'market'));
        $this->assign('code', $activity_code);
        $this->assign('p_id', $p_id);
        $this->assign('action_link', array('href' => RC_Uri::url('market/admin/activity_prize', array('code' => $activity_code)), 'text' => __('活动奖品池', 'market')));
        $this->assign('form_action', RC_Uri::url('market/admin/activity_prize_update', array('code' => $activity_code)));

        return $this->display('activity_prize_add.dwt');
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
        $wechat_id = 0;
        $activity_info = RC_DB::table('market_activity')->where('activity_group', $code)->where('wechat_id', $wechat_id)->where('store_id', 0)->first();

        if ($prize_level === '') {
            return $this->showmessage(__('请选择奖品等级！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($prize_name)) {
            return $this->showmessage(__('请填写奖品名称！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($prize_type === '') {
            return $this->showmessage(__('请填写奖品类型！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $prize_value_final = '';
        $prize_type_arr = array(
        		Ecjia\App\Market\Prize\PrizeType::TYPE_REAL,
        		Ecjia\App\Market\Prize\PrizeType::TYPE_INTEGRAL,
        		Ecjia\App\Market\Prize\PrizeType::TYPE_BALANCE
        );
        if ($prize_type == Ecjia\App\Market\Prize\PrizeType::TYPE_BONUS) {
            if (empty($prize_value)) {
                return $this->showmessage(__('请选择礼券奖品的红包！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $prize_value_final = $prize_value;
        } else if (in_array($prize_type, $prize_type_arr)) {
            if (empty($prize_value_other)) {
                return $this->showmessage(__('请填写奖品内容！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $prize_value_final = $prize_value_other;
        }

        if (!isset($prize_number)) {
            return $this->showmessage(__('请填写奖品数量！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($prize_prob <= 0) {
            return $this->showmessage(__('请填写获奖概率！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        //某个活动的所有奖品中奖概率不能大于100
        $current_all_prize_prob_final = 0;
        if (!empty($prize_prob)) {
        	$current_all_prize_prob = RC_DB::table('market_activity_prize')->where('activity_id', $activity_info['activity_id'])->where('prize_id', '!=', $p_id)->lists('prize_prob');
        	if ($current_all_prize_prob) {
        		foreach ($current_all_prize_prob as $row) {
        			$current_all_prize_prob_final += $row;
        		}
        	}
        	if ($current_all_prize_prob_final > 100 || ($current_all_prize_prob_final + $prize_prob) > 100) {
        		return $this->showmessage(__('活动所有奖品获奖概率总和不可大于100', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
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
        ecjia_admin::admin_log('活动'.$activity_info['activity_name'].'的奖品'.$prize_name, 'edit', 'market_activity_prize');
        return $this->showmessage(__('修改活动奖品池成功', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 活动奖品池奖品删除
     */
    public function activity_prize_remove()
    {
        $this->admin_priv('market_activity_delete', ecjia::MSGTYPE_JSON);

        $wechat_id = 0;
        $activity_code = trim($_GET['code']);
        $p_id = intval($_GET['p_id']);
        
        $prize_info = RC_DB::table('market_activity_prize')->where('prize_id', $p_id)->first();
        $activity_name = RC_DB::table('market_activity')->where('activity_id', $prize_info['prize_id'])->pluck('activity_name');
        
        RC_DB::table('market_activity_prize')->where('prize_id', $p_id)->delete();
//        $this->admin_log('活动'.$activity_name.'的奖品'.$prize_info['prize_name'], 'remove', 'prize');
        $this->admin_log(sprintf(__('活动%s的奖品%s', 'market'), $activity_name, $prize_info['prize_name']), 'remove', 'prize');
        return $this->showmessage(__('删除成功', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 发放奖品（实物奖品）
     */
    public function issue_prize()
    {
        $this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);
        $id = trim($_GET['id']);

        if (!empty($id)) {
            $info = RC_DB::table('market_activity_log')->where('id', $id)->first();
            $code = RC_DB::table('market_activity')->where('activity_id', $info['activity_id'])->pluck('activity_group');
            $prize_info = RC_DB::table('market_activity_prize')->where('prize_id', $info['prize_id'])->first();
            if (empty($prize_info)) {
            	return $this->showmessage(__('奖品信息不存在！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($prize_info['prize_number'] == 0) {
            	return $this->showmessage(__('奖品数量不足！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            RC_DB::table('market_activity_log')->where('id', $id)->update(array('issue_status' => 1, 'issue_time' => RC_Time::gmtime()));
			if ($prize_info['prize_number'] > 0) {
				/*减奖品数量*/
				RC_DB::table('market_activity_prize')->where('prize_id', $prize_info['prize_id'])->decrement('prize_number');
			}

//            ecjia_admin::admin_log('发放奖品' . $info['prize_name'] . '给' . $info['user_name'], 'issue', 'prize');
            $this->admin_log(sprintf(__('发放奖品%s给%s', 'market'), $info['prize_name'], $info['user_name']), 'issue', 'prize');

            return $this->showmessage(__('发放奖品成功！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/admin/activity_record', array('code' => $code))));
        } else {
            return $this->showmessage(__('错误的参数', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 获取活动列表
     * @return array
     */
    private function get_activity_list()
    {

        $activity_list = array();

        $factory = new Ecjia\App\Market\Factory();
        $activity_data = $factory->getDrivers();

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
        $page = new ecjia_page($count, 15, 5);
        $res = $db_activity_log->where('activity_id', $activity_id)->orderBy('add_time', 'desc')->take(15)->skip($page->start_id - 1)->get();

        if (!empty($res)) {
            foreach ($res as $key => $val) {
                $res[$key]['issue_time'] = RC_Time::local_date('Y-m-d H:i:s', $res[$key]['issue_time']);
                $res[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $res[$key]['add_time']);
                $prize_type = RC_DB::table('market_activity_prize')->where('prize_id', $val['prize_id'])->pluck('prize_type');
                $res[$key]['prize_type'] = $prize_type;
            }
        }
        return array('item' => $res, 'page' => $page->show(), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
    }
}
// end

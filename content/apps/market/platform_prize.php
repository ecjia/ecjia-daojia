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
 * 营销活动抽奖记录
 */
class platform_prize extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Market\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-placeholder');

        RC_Style::enqueue_style('activity', RC_App::apps_url('statics/platform-css/activity.css', __FILE__));
        RC_Style::enqueue_style('prize', RC_App::apps_url('statics/platform-css/prize.css', __FILE__));

        RC_Script::enqueue_script('prize_list', RC_App::apps_url('statics/platform-js/prize_list.js', __FILE__), array(), false, 1);
        RC_Script::localize_script('prize_list', 'js_lang', config('app-market::jslang.market_platform_page'));

        RC_Script::enqueue_script('popover', RC_App::apps_url('statics/platform-js/popover.js', __FILE__), array(), false, 1);

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('抽奖记录', 'market'), RC_Uri::url('market/platform_prize/init')));
        ecjia_platform_screen::get_current_screen()->set_subject('抽奖记录');
    }

    /**
     * 活动列表
     */
    public function init()
    {
        $this->admin_priv('activity_record_manage');

        $wechat_id = $this->platformAccount->getAccountID();
        $store_id = RC_DB::table('platform_account')->where('id', $wechat_id)->pluck('shop_id');

        $this->assign('ur_here', __('抽奖记录', 'market'));

        $list = [];
        $code_list = [];
        $activity_code = '';
        $type = empty($_GET['type']) ? '' : trim($_GET['type']);

        if (!empty($_GET['code'])) {
            $activity_code = trim($_GET['code']);
        } else {
            $menus = with(new Ecjia\App\Market\MarketPrizeMenu($store_id, $wechat_id))->getMenus();
            if (!empty($menus)) {
                foreach ($menus as $k => $menu) {
                    $code_list[$k]['code'] = $menu->action;
                }
                $default_code = $code_list['0']['code'];
                $activity_code = $default_code;
            }
        }

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('抽奖记录', 'market')));
        ecjia_platform_screen::get_current_screen()->add_option('current_code', $activity_code);
        $this->assign('action_link', array('href' => RC_Uri::url('market/platform/activity_detail', array('code' => $activity_code)), 'text' => __('返回活动详情', 'market')));

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
        $this->assign('code', $activity_code);
        $this->assign('type', $type);
        $this->assign('count', $list['filter']);
        
        $this->display('prize_record.dwt');
    }
    
    /**
     * 发放奖品（实物奖品）
     */
    public function issue_prize()
    {
    	$this->admin_priv('market_activity_update', ecjia::MSGTYPE_JSON);
    	$id = trim($_GET['id']);
    	$type = $_GET['type'];
    	
    	if (!empty($id)) {
    		$info = RC_DB::table('market_activity_log')->where('id', $id)->first();
    		$code = RC_DB::table('market_activity')->where('activity_id', $info['activity_id'])->pluck('activity_group');
    		$activity_name = RC_DB::table('market_activity')->where('activity_id', $info['activity_id'])->pluck('activity_name');
    		
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
//    		$this->admin_log('发放奖品' . $info['prize_name'] . '给' . $info['user_name'], 'issue', 'prize');
            $this->admin_log(sprintf(__('发放奖品%s给%s', 'market'), $info['prize_name'], $info['user_name']), 'issue', 'prize');

            return $this->showmessage(__('发放奖品成功！', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('market/platform_prize/init', array('code' => $code, 'type' => $type))));
    	} else {
    		return $this->showmessage(__('错误的参数', 'market'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 导出实物中奖用户信息
     */
    public function export() {
    	$this->admin_priv('activity_record_manage', ecjia::MSGTYPE_JSON);
    	$filename = mb_convert_encoding("实物中奖用户收货地址信息", "GBK", "UTF-8");
    	
    	$activity_id = intval($_GET['activity_id']);
    	$list = $this->get_realprize_userlist($activity_id);
    	
    	header("Content-type: application/vnd.ms-excel; charset=utf-8");
    	header("Content-Disposition: attachment; filename=$filename.xls");
    
    	$data = __('奖品名', 'market')."\t".__('发放状态', 'market')."\t".__('微信昵称', 'market')."\t".__('收货人', 'market')."\t".__('手机号', 'market')."\t".__('收货地址', 'market')."\t\n";
    	
    	if (!empty($list['list'])) {
    		foreach ($list['list'] as $v) {
    			$data .= $v['prize_name'] . "\t";
    			$data .= $v['label_issue_status'] . "\t";
    			$data .= RC_Format::filterEmoji($v['user_name']) . "\t";
    			$data .= $v['issue_extend_name'] . "\t";
    			$data .= $v['issue_extend_mobile'] . "\t";
    			$data .= $v['issue_extend_address'] . "\t\n";
    		}
    	}
    
    	echo mb_convert_encoding($data."\t", "GBK", "UTF-8");
    	exit;
    }

    /**
     * 获取活动抽奖记录
     * @return array
     */
    private function get_activity_record_list($activity_id = 0)
    {
        $db_activity_log = RC_DB::table('market_activity_log');

        if (!empty($activity_id)) {
            $db_activity_log->where('activity_id', $activity_id);
        }
	
        $type = empty($_GET['type']) ? '' : $type;
        $filter = [];
        //找到实物类型奖品id
        $prize_real_type_id = RC_DB::table('market_activity_prize')->where('prize_type', Ecjia\App\Market\Prize\PrizeType::TYPE_REAL)->where('activity_id', $activity_id)->lists('prize_id');
        $prize_real_type_id = array_unique($prize_real_type_id);
       
        if (!empty($_GET['type'])) {
        	if (!empty($prize_real_type_id)) {
        		$db_activity_log->whereIn('prize_id', $prize_real_type_id);
        	}
        }
      
        $count = $db_activity_log->count();
        $page = new ecjia_platform_page($count, 15, 5);
        $res = $db_activity_log->where('activity_id', $activity_id)->orderBy('add_time', 'desc')->take(15)->skip($page->start_id - 1)->get();
		
        //数量统计单独计算
        $db =  RC_DB::table('market_activity_log');
        if (!empty($activity_id)) {
        	$db->where('activity_id', $activity_id);
        }
        $filter['count_total']	= $db->count();
        if (!empty($_GET['type'])) {
        	if (!empty($prize_real_type_id)) {
        		$filter['count_real']	= $db->whereIn('prize_id', $prize_real_type_id)->count();
        	} else {
        		$filter['count_real']	= 0;
        		$count = 0;
        		$page = new ecjia_platform_page($count, 15, 5);
        		$res = [];
        	}
        } else {
        	if (!empty($prize_real_type_id)) {
        		$filter['count_real']	= $db->whereIn('prize_id', $prize_real_type_id)->count();
        	} else {
        		$filter['count_real'] = 0;
        	}
        }
       
        if (!empty($res)) {
            foreach ($res as $key => $val) {
                $res[$key]['issue_time'] = RC_Time::local_date('Y-m-d H:i:s', $res[$key]['issue_time']);
                $res[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $res[$key]['add_time']);
                $res[$key]['prize_type'] = RC_DB::table('market_activity_prize')->where('prize_id', $val['prize_id'])->pluck('prize_type');
                if (!empty($val['issue_extend'])) {
                	$issue_extend = unserialize($val['issue_extend']);
                	$res[$key]['is_issue_extend'] = 1;
                	$res[$key]['issue_extend_format'] 	= $issue_extend;
                	$res[$key]['issue_extend_name'] 	= $issue_extend['user_name'];
                	$res[$key]['issue_extend_mobile'] 	= $issue_extend['mobile'];
                	$res[$key]['issue_extend_address'] 	= $issue_extend['address'];
                } else {
                	$res[$key]['is_issue_extend'] = 0;
                	$res[$key]['issue_extend_format'] = [];
                }
            }
        }
        return array('item' => $res, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
    }

	
    /**
     * 获取实物中奖用户信息
     * @return array
     */
    private function get_realprize_userlist($activity_id = 0)
    {
    	
    	$db_activity_log = RC_DB::table('market_activity_log');
    
    	if (!empty($activity_id)) {
    		$db_activity_log->where('activity_id', $activity_id);
    	}
    
    	$type = empty($_GET['type']) ? 'real_object' : $type;
    	//找到实物类型奖品id
    	$prize_real_type_id = RC_DB::table('market_activity_prize')->where('prize_type', Ecjia\App\Market\Prize\PrizeType::TYPE_REAL)->where('activity_id', $activity_id)->lists('prize_id');
    	$prize_real_type_id = array_unique($prize_real_type_id);
    	 
    	if (!empty($_GET['type'])) {
    		if (!empty($prize_real_type_id)) {
    			$db_activity_log->whereIn('prize_id', $prize_real_type_id);
    		}
    	}
    	
    	$count = $db_activity_log->count();
    	$page = new ecjia_platform_page($count, 15, 5);
    	$res = $db_activity_log->where('activity_id', $activity_id)->orderBy('add_time', 'desc')->take(15)->skip($page->start_id - 1)->get();
    	//实物类型奖品id为空时，实物奖品记录为0
    	if (!empty($_GET['type'])) {
    		if (empty($prize_real_type_id))  {
    			$filter['count_real']	= 0;
    			$count = 0;
    			$page = new ecjia_platform_page($count, 15, 5);
    			$res = [];
    		}
    	}
    	
    	if (!empty($res)) {
    		foreach ($res as $key => $val) {
    			$res[$key]['label_issue_status'] = $val['issue_status'] == '0' ? __('未发放', 'market') : __('已发放', 'market');
    			if (!empty($val['issue_extend'])) {
    				$issue_extend = unserialize($val['issue_extend']);
    				$res[$key]['is_issue_extend'] = 1;
    				$res[$key]['issue_extend_format'] 	= $issue_extend;
    				$res[$key]['issue_extend_name'] 	= $issue_extend['user_name'];
    				$res[$key]['issue_extend_mobile'] 	= $issue_extend['mobile'];
    				$res[$key]['issue_extend_address'] 	= $issue_extend['address'];
    			} else {
    				$res[$key]['is_issue_extend'] = 0;
    				$res[$key]['issue_extend_format'] 	= [];
    				$res[$key]['issue_extend_name'] 	= '';
    				$res[$key]['issue_extend_mobile'] 	= '';
    				$res[$key]['issue_extend_address'] 	= '';
    			}
    		}
    	}
    	return array('list' => $res, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
    }
    
    
}

//end

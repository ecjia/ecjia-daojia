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
use Ecjia\System\Notifications\ExpressAssign;
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 派单提醒
 *
 */
class admin_reminder extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();
        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');

        RC_Script::enqueue_script('admin_express_task', RC_App::apps_url('statics/js/admin_express_task.js', __FILE__));
        RC_Script::enqueue_script('admin_express_order_list', RC_App::apps_url('statics/js/admin_express_order_list.js', __FILE__));
        RC_Style::enqueue_style('admin_express_task', RC_App::apps_url('statics/css/admin_express_task.css', __FILE__));
        RC_Script::enqueue_script('qq_map', ecjia_location_mapjs());
        RC_Script::localize_script('admin_express_task', 'js_lang', config('app-express::jslang.express_page'));
        RC_Script::localize_script('admin_express_order_list', 'js_lang', config('app-express::jslang.express_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('派单提醒', 'express')));
    }

    /**
     * 列表
     */
    public function init()
    {
        $this->admin_priv('express_reminder_manage');

        /* 查询 */
        $db_order_reminder = RC_DB::table('express_order_reminder as e')
            ->leftJoin('express_order as o', RC_DB::raw('o.express_id'), '=', RC_DB::raw('e.express_id'))
            ->leftJoin('users as a', RC_DB::raw('o.user_id'), '=', RC_DB::raw('a.user_id'));
        
		/*数量统计单独查询*/
        $db = RC_DB::table('express_order_reminder as e') ->leftJoin('express_order as o', RC_DB::raw('o.express_id'), '=', RC_DB::raw('e.express_id'));
        
        $keywords = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
        $type	  = empty($_GET['type']) ? '' : trim($_GET['type']);
        
        if (!empty($keywords)) {
            $db_order_reminder->whereRaw('(o.express_sn like "%' . mysql_like_quote($keywords) . '%" or o.consignee like "%' . mysql_like_quote($keywords) . '%")');
            $db->whereRaw('(o.express_sn like "%' . mysql_like_quote($keywords) . '%" or o.consignee like "%' . mysql_like_quote($keywords) . '%")');
        }
        
        if (!empty($type)) {
        	if ($type == 'wait_process') {
        		$db_order_reminder->where(RC_DB::raw('e.status'), 0);
        	} elseif ($type == 'processed') {
        		$db_order_reminder->where(RC_DB::raw('e.status'), 1);
        	}
        }
        
        $express_remind_count = $db->select(RC_DB::raw('count("e.id") as whole'),
        							RC_DB::raw('SUM(IF(e.status = 0, 1, 0)) as wait_process'),
        							RC_DB::raw('SUM(IF(e.status = 1, 1, 0)) as processed'))->first();
        
        $count = $db_order_reminder->count();
        $page = new ecjia_page($count, 10, 5);
        
        $result = $db_order_reminder
        ->orderBy(RC_DB::raw('e.create_time'), 'desc')
        ->take(10)
        ->skip($page->start_id-1)
        ->get();
        $result_list = array('list' => $result,  'page' => $page->show(5), 'desc' => $page->page_desc(), 'keywords' => $keywords);
        
        if (!empty($result_list['list'])) {
            foreach ($result_list['list'] as $key => $val) {
            	$result_list['list'][$key]['unformat_status'] = $val['status'];
                $result_list['list'][$key]['status'] = $val['status'] == 1 ? __('已处理', 'express') : __('未处理', 'express');
                $result_list['list'][$key]['create_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['create_time']);
                
                $result_list['list'][$key]['express_all_address'] = '';
                if (!empty($val['district'])) {
                	$result_list['list'][$key]['express_all_address'] .= ecjia_region::getRegionName($val['district']);
                }
                if (!empty($val['street'])) {
                	$result_list['list'][$key]['express_all_address'] .= ecjia_region::getRegionName($val['street']).'&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }
        }
        
        
        $this->assign('result_list', $result_list);
        $this->assign('express_remind_count', $express_remind_count);
        $this->assign('type', $type);
        $this->assign('keywords', $keywords);
        $this->assign('ur_here', __('派单提醒列表', 'express'));
        $this->assign('form_action', RC_Uri::url('express/admin_reminder/remove&type=batch'));
        $this->assign('search_action', RC_Uri::url('express/admin_reminder/init'));

        return $this->display('express_reminder_list.dwt');
    }

    /**
     * 查看订单详情
     */
    public function order_detail()
    {
        $this->admin_priv('express_task_manage');

        $express_id = intval($_GET['express_id']);
        $type = trim($_GET['type']);

        $express_info = RC_DB::table('express_order')->where('express_id', $express_id)->select('store_id', 'status', 'order_id', 'order_sn', 'delivery_id', 'delivery_sn', 'user_id', 'mobile', 'consignee', 'express_sn', 'distance', 'shipping_fee', 'commision', 'express_user', 'express_mobile', 'from', 'signed_time', 'province as eoprovince', 'city as eocity', 'district as eodistrict', 'street as eostreet', 'address as eoaddress')->first();
        $store_info = RC_DB::table('store_franchisee')->where('store_id', $express_info['store_id'])->select('merchants_name', 'contact_mobile', 'province', 'city', 'district', 'street', 'address')->first();
        $order_info = RC_DB::table('order_info')->where('order_id', $express_info['order_id'])->select('add_time', 'expect_shipping_time', 'postscript')->first();

        /*配送单对应的发货单商品*/
        $goods_list = RC_DB::table('delivery_goods')->where('delivery_id', $express_info['delivery_id'])->select(RC_DB::raw('goods_id'), RC_DB::raw('goods_name'), RC_DB::raw('send_number'))->get();
        foreach ($goods_list as $key => $val) {
            $goods_list[$key]['image'] = RC_DB::table('goods')->where('goods_id', $val['goods_id'])->value('goods_thumb');
            $goods_list[$key]['goods_price'] = RC_DB::table('order_goods')->where('goods_id', $val['goods_id'])->where('order_id', $express_info['order_id'])->value('goods_price');
            $goods_list[$key]['formated_goods_price'] = price_format($goods_list[$key]['goods_price']);
        }
        
        $disk = RC_Filesystem::disk();
        foreach ($goods_list as $key => $val) {
            if (!$disk->exists(RC_Upload::upload_path($val['image'])) || empty($val['image'])) {
                $goods_list[$key]['image'] = RC_Uri::admin_url('statics/images/nopic.png');
            } else {
                $goods_list[$key]['image'] = RC_Upload::upload_url($val['image']);
            }
        }

        $content = array_merge($express_info, $store_info, $order_info);
        
        $content['district'] 			= ecjia_region::getRegionName($content['district']);
        $content['street'] 				= ecjia_region::getRegionName($content['street']);
        $content['eoprovince'] 			= ecjia_region::getRegionName($content['eoprovince']);
        $content['eocity'] 				= ecjia_region::getRegionName($content['eocity']);
        $content['eodistrict'] 			= ecjia_region::getRegionName($content['eodistrict']);
        $content['eostreet'] 			= ecjia_region::getRegionName($content['eostreet']);
        $content['add_time'] 			= RC_Time::local_date(ecjia::config('time_format'), $content['add_time']);
        $content['signed_time'] 		= RC_Time::local_date('Y-m-d H:i', $content['signed_time']);
        $content['all_address'] 		= $content['district'] . $content['street'];
        $content['express_all_address'] = $content['eodistrict'] . $content['eostreet'];

        if (empty($type)) {
        	if ($express_info['status'] == 0) {
        		$type = 'wait_grab';
        	} elseif ($express_info['status'] == 1) {
        		$type = 'wait_pickup';
        	} elseif ($express_info['status'] == 2) {
        		$type = 'sending';
        	}
        }
        $this->assign('type', $type);
        $this->assign('content', $content);
        $this->assign('goods_list', $goods_list);

        $data = $this->fetch('express_order_detail.dwt');
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
    }

    /**
     * 订单重新指派
     */
    public function express_detail()
    {
        $this->admin_priv('express_task_manage');

        $express_id = intval($_GET['express_id']);
        $store_id 	= intval($_GET['store_id']);
        $type 		= trim($_GET['type']);

        $express_info = RC_DB::table('express_order as eo')
            ->leftJoin('express_user as eu', RC_DB::raw('eo.staff_id'), '=', RC_DB::raw('eu.user_id'))
            ->where(RC_DB::raw('eo.express_id'), $express_id)
            ->select(RC_DB::raw('eo.express_user'), RC_DB::raw('eo.express_mobile'), RC_DB::raw('eo.longitude as u_longitude'), RC_DB::raw('eo.latitude as u_latitude'), RC_DB::raw('eu.longitude as eu_longitude'), RC_DB::raw('eu.latitude as eu_latitude'))
            ->first();

        $store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->select(RC_DB::raw('longitude as sf_longitude'), RC_DB::raw('latitude as sf_latitude'))->first();

        $content = array_merge($express_info, $store_info);

        $content['start'] = $content['sf_latitude'] . ',' . $content['sf_longitude'];
        $content['end'] = $content['u_latitude'] . ',' . $content['u_longitude'];

        /*配送员列表*/
        $express_user_list = $this->get_express_user_list($type);

        $this->assign('express_user_list', $express_user_list);
        $this->assign('express_count', $express_user_list['express_count']);
        
        $app_url = RC_App::apps_url('statics/images', __FILE__);
        $this->assign('app_url', $app_url);
        
        $this->assign('type', $type);
        $this->assign('content', $content);
        $this->assign('express_id', $express_id);

        $this->assign('search_action', RC_Uri::url('express/admin_reminder/reassign_search_user', array('type' => $type)));
        $this->assign('assign_url', RC_Uri::url('express/admin_reminder/assign_express_order'));
        $this->assign('title', __('指派订单', 'express'));

        $data = $this->fetch('express_order_reassign.dwt');

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
    }

    /**
     * 重新指派页搜索配送员
     */
    public function reassign_search_user()
    {
        $type = $_GET['type'];
        $keywords = $_GET['keywords'];

        /*配送员列表*/
        $express_user_list = $this->get_express_user_list($type, $keywords);

        $this->assign('express_user_list', $express_user_list);
        $this->assign('express_count', $express_user_list['express_count']);
        
        $app_url = RC_App::apps_url('statics/images', __FILE__);
        $this->assign('app_url', $app_url);
        
        $this->assign('type', $type);
        $this->assign('search_action', RC_Uri::url('express/admin_reminder/reassign_search_user', array('type' => $type)));

        $data = $this->fetch('reassign_express_user_list.dwt');
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
    }

    /**
     * 指派订单
     */
    public function assign_express_order()
    {
        $this->admin_priv('express_task_manage');

        $express_id = $_POST['express_id'];
        if (empty($express_id)) {
            return $this->showmessage(__('暂无可指派的订单！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $staff_id = $_GET['staff_id'];
        $type = $_GET['type'];

        $field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.expect_shipping_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.district as sf_district, sf.street as sf_street, sf.address as merchant_address, sf.longitude as sf_longitude, sf.latitude as sf_latitude';
        $dbview = RC_DB::table('express_order as eo')
            ->leftJoin('store_franchisee as sf', RC_DB::raw('sf.store_id'), '=', RC_DB::raw('eo.store_id'))
            ->leftJoin('order_info as oi', RC_DB::raw('eo.order_id'), '=', RC_DB::raw('oi.order_id'));

        $express_order_info = $dbview->where(RC_DB::raw('eo.express_id'), $express_id)->select(RC_DB::raw('eo.*'), RC_DB::raw('oi.add_time as order_time'), RC_DB::raw('oi.pay_time'), RC_DB::raw('oi.expect_shipping_time'), RC_DB::raw('oi.order_amount'), RC_DB::raw('oi.pay_name'), RC_DB::raw('sf.merchants_name'), RC_DB::raw('sf.district as sf_district'), RC_DB::raw('sf.street as sf_street'), RC_DB::raw('sf.address as merchant_address'), RC_DB::raw('sf.longitude as sf_longitude'), RC_DB::raw('sf.latitude as sf_latitude'))->first();

        $staff_user_info = RC_DB::table('staff_user as su')->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'))
            ->where(RC_DB::raw('su.user_id'), $staff_id)
            ->select(RC_DB::raw('su.name'), RC_DB::raw('su.mobile'), RC_DB::raw('su.online_status'), RC_DB::raw('eu.shippingfee_percent'))->first();

        if ($staff_user_info['online_status'] == '4') {
            return $this->showmessage(__('当前配送员不在线，请选择在线配送员进行指派！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $commision = $staff_user_info['shippingfee_percent'] / 100 * $express_order_info['shipping_fee'];
        $commision = sprintf("%.2f", $commision);
        $data = array(
            'from' 				=> 'assign',
            'status' 			=> 1,
            'staff_id' 			=> $staff_id,
            'express_user' 		=> $staff_user_info['name'],
            'express_mobile' 	=> $staff_user_info['mobile'],
            'commision' 		=> $commision,
            'commision_status' 	=> 0,
            'receive_time' 		=> RC_Time::gmtime()
        );

        $update = RC_DB::table('express_order')->where('express_id', $express_id)->update($data);
        
        /*当前配送单有没派单提醒，有的话修改派单提醒状态为已处理；派单提醒只有众包配送有*/
        $remind_list = RC_DB::table('express_order_reminder')->where('express_id', $express_id)->where('status', 0)->get();
        if (!empty($remind_list)) {
        	foreach ($remind_list as $row) {
        		RC_DB::table('express_order_reminder')->where('id', $row['id'])->update(array('status' => 1, 'confirm_time' => RC_Time::gmtime()));
        	}
        }

        /*指派后*/
        if ($staff_id > 0) {
            /* 消息插入 */
            $orm_staff_user_db = RC_Model::model('orders/orm_staff_user_model');
            $user = $orm_staff_user_db->find($staff_id);

            /* 派单发短信 */
            if (!empty($staff_user_info['mobile'])) {
                $options = array(
                    'mobile' => $staff_user_info['mobile'],
                    'event' => 'sms_express_system_assign',
                    'value' => array(
                        'express_sn' => $express_order_info['express_sn'],
                    ),
                );
                RC_Api::api('sms', 'send_event_sms', $options);
            }

            /*派单推送消息*/
            $options = array(
                'user_id' => $staff_id,
                'user_type' => 'merchant',
                'event' => 'express_system_assign',
                'value' => array(
                    'express_sn' => $express_order_info['express_sn'],
                ),
                'field' => array(
                    'open_type' => 'admin_message',
                ),
            );
            RC_Api::api('push', 'push_event_send', $options);

            //消息通知
            $express_from_address = ecjia_region::getRegionName($express_order_info['sf_district']) . ecjia_region::getRegionName($express_order_info['sf_street']) . $express_order_info['merchant_address'];
            $express_to_address = ecjia_region::getRegionName($express_order_info['district']) . ecjia_region::getRegionName($express_order_info['street']) . $express_order_info['address'];

            $notification_express_data = array(
                'title' => __('系统派单', 'express'),
                'body' => __('有单啦！系统已分配配送单到您账户，赶快行动起来吧！', 'express'),
                'data' => array(
                    'express_id' 			=> $express_order_info['express_id'],
                    'express_sn' 			=> $express_order_info['express_sn'],
                    'express_type' 			=> $express_order_info['from'],
                    'label_express_type' 	=> $express_order_info['from'] == 'assign' ? __('系统派单', 'express') : __('抢单', 'express'),
                    'order_sn' 				=> $express_order_info['order_sn'],
                    'payment_name' 			=> $express_order_info['pay_name'],
                    'express_from_address' 	=> '【' . $express_order_info['merchants_name'] . '】' . $express_from_address,
                    'express_from_location' => array(
                        'longitude' => $express_order_info['merchant_longitude'],
                        'latitude' 	=> $express_order_info['merchant_latitude'],
                    ),
                    'express_to_address' 	=> $express_to_address,
                    'express_to_location' 	=> array(
                        'longitude' => $express_order_info['longitude'],
                        'latitude' 	=> $express_order_info['latitude'],
                    ),
                    'distance' 		=> $express_order_info['distance'],
                    'consignee' 	=> $express_order_info['consignee'],
                    'mobile' 		=> $express_order_info['mobile'],
                    'receive_time' 	=> RC_Time::local_date(ecjia::config('time_format'), $express_order_info['receive_time']),
                    'order_time' 	=> RC_Time::local_date(ecjia::config('time_format'), $express_order_info['order_time']),
                    'pay_time' 		=> empty($express_order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['pay_time']),
                    'best_time' 	=> $express_order_info['expect_shipping_time'],
                    'shipping_fee' 	=> $express_order_info['shipping_fee'],
                    'order_amount' 	=> $express_order_info['order_amount'],
                ),
            );
            $express_assign = new ExpressAssign($notification_express_data);
            RC_Notification::send($user, $express_assign);
        }
        return $this->showmessage(__('指派订单成功！', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('express/admin_reminder/init')));
    }

    /**
     * 配送员列表
     */
    private function get_express_user_list($type ='', $keywords ='')
    {
        $keywords = $_GET['keywords'];
        $express_user_view = RC_DB::table('staff_user as su')
            ->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'));
        $express_user_view->where(RC_DB::raw('su.store_id'), 0);

        if (!empty($keywords)) {
            $express_user_view->whereRaw('(su.name  like  "%' . mysql_like_quote($keywords) . '%")');
        }

        $db = RC_DB::table('staff_user as su')
            ->leftJoin('express_user as eu', RC_DB::raw('su.user_id'), '=', RC_DB::raw('eu.user_id'));
        if (!empty($keywords)) {
            $db->whereRaw('(su.name  like  "%' . mysql_like_quote($keywords) . '%")');
        }

        if (!empty($type)) {
            if ($type == 'online') {
                $express_user_view->where(RC_DB::raw('su.online_status'), 1);
                $db->where(RC_DB::raw('su.online_status'), 1);
            } elseif ($type == 'offline') {
                $express_user_view->where(RC_DB::raw('su.online_status'), 4);
                $db->where(RC_DB::raw('su.online_status'), 1);
            }
        }

        $express_user_count = $db
            ->where(RC_DB::raw('su.store_id'), 0)
            ->select(RC_DB::raw('count(*) as count'), RC_DB::raw('SUM(IF(su.online_status = 1, 1, 0)) as online'), RC_DB::raw('SUM(IF(su.online_status = 4, 1, 0)) as offline'))
            ->first();

        $list = $express_user_view->select(RC_DB::raw('eu.*'), RC_DB::raw('su.mobile'), RC_DB::raw('su.name'), RC_DB::raw('su.avatar'), RC_DB::raw('su.online_status'))->orderBy('online_status', 'asc')->get();
        $data = array();
        if (!empty($list)) {
            foreach ($list as $row) {
                $count = RC_DB::table('express_order')->where('staff_id', $row['user_id'])->select(RC_DB::raw('count(*) as count'), RC_DB::raw('SUM(IF(status = 1, 1, 0)) as wait_pickup'), RC_DB::raw('SUM(IF(status = 2, 1, 0)) as sending'))->first();
                $row['avatar'] = empty($row['avatar']) ? '' : RC_Upload::upload_url($row['avatar']);
                $row['wait_pickup_count'] = $count['wait_pickup'];
                $row['sending_count'] = $count['sending'];
                $data[] = $row;
            }
        }
        return array('list' => $data, 'express_count' => $express_user_count);
    }
}

//end
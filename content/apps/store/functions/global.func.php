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
* 添加管理员记录日志操作对象
*/
function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('store_commission','佣金结算');
	ecjia_admin_log::instance()->add_object('store_commission_status','佣金结算状态');

	ecjia_admin_log::instance()->add_object('merchants_step', '申请流程');
	ecjia_admin_log::instance()->add_object('merchants_step_title', '申请流程信息');
	ecjia_admin_log::instance()->add_object('merchants_step_custom', '自定义字段');

	ecjia_admin_log::instance()->add_object('seller', '入驻商');
	ecjia_admin_log::instance()->add_object('merchants_brand', '商家品牌');
	ecjia_admin_log::instance()->add_object('store_category', '店铺分类');
	ecjia_admin_log::instance()->add_object('merchant_notice', '商家公告');

	ecjia_admin_log::instance()->add_object('config', '配置');
	ecjia_admin_log::instance()->add_object('store_percent', '佣金比例');
	ecjia_admin_log::instance()->add_object('store_mobileconfig', '店铺街配置');
}

/**
* 设置页面菜单
*/
function set_store_menu($store_id, $key){

    $keys = array('preview','store_set','commission_set','commission','view_staff','view_log','check_log');
//     if(!in_array($key,$keys)){
//         $key = 'preview';
//     }
    $arr = array(
        array(
            'menu'  => '基本信息',
            'name'  => 'preview',
            'url'   => RC_Uri::url('store/admin/preview', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '店铺设置',
            'name'  => 'store_set',
            'url'   => RC_Uri::url('store/admin/store_set', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '资质认证',
            'name'  => 'auth',
            'url'   => RC_Uri::url('store/admin/auth', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '佣金设置',
            'name'  => 'commission_set',
            'url'   => RC_Uri::url('store/admin_commission/edit', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '结算账单',
            'name'  => 'bill',
            'url'   => RC_Uri::url('commission/admin/init', array('store_id' => $store_id, 'refer' => 'store'))
        ),
        array(
            'menu'  => '查看员工',
            'name'  => 'view_staff',
            'url'   => RC_Uri::url('store/admin/view_staff', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '配送方式',
            'name'  => 'shipping',
            'url'   => RC_Uri::url('store/admin/shipping', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '查看日志',
            'name'  => 'view_log',
            'url'   => RC_Uri::url('store/admin/view_log', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '审核日志',
            'name'  => 'check_log',
            'url'   => RC_Uri::url('store/admin/check_log', array('store_id' => $store_id))
        ),
    );
    foreach($arr as $k => $val){
        if($key == $val['name']){
            $arr[$k]['active']  = 1;
            $arr[$k]['url']     = "#tab".($k+1);
        }
    }
    return $arr;
}

//审核日志
function get_check_log ($store_id, $type, $page = 1, $page_size = 10) {
     
    $db_log = RC_DB::table('store_check_log')->where('store_id', $store_id)->where('type', $type);
    $count  = $db_log->count();
    $page   = new ecjia_page($count, $page_size, 5);
    $log_rs = $db_log->orderBy('id', 'desc')->take($page->page_size)->skip($page->start_id-1)->get();
     
    if (empty($log_rs)) {
        return false;
    }
    foreach ($log_rs as &$val) {
        $val['log']     = null;
        $new_data       = unserialize($val['new_data']);
        $original_data  = unserialize($val['original_data']);
        if ($original_data) {
            foreach ($original_data as $key => $original_data) {
                if (in_array($key, array('identity_pic_front', 'identity_pic_back', 'personhand_identity_pic', 'business_licence_pic'))) {
                    // 	                    $val['log'] .= '<br><code>'.$original_data['name'] . '</code>，旧图为<a href="'. $original_data['value'].'" target="_blank"><img class="w120 h70 thumbnail ecjiaf-ib" src="'. $original_data['value'].'"/></a>，新图为<a href="'. $new_data[$key]['value'].'" target="_blank"><img class="w120 h70 thumbnail ecjiaf-ib" src="'.$new_data[$key]['value'].'"/></a>；';
                    $val['log'][$key] = array(
                        'name'          => $original_data['name'],
                        'original_data' => '<a href="'. $original_data['value'].'" title="点击查看大图" target="_blank"><img class="w120 h70 thumbnail ecjiaf-ib" src="'. $original_data['value'].'"/></a>',
                        'new_data'      => '<a href="'. $new_data[$key]['value'].'" title="点击查看大图" target="_blank"><img class="w120 h70 thumbnail ecjiaf-ib" src="'.$new_data[$key]['value'].'"/></a>',
                        'is_img'        => 1
                    );
                } else {
                    // 	                    $val['log'] .= '<br><code>'.$original_data['name'] . '</code>，旧值为<code>'. $original_data['value'].'</code>，新值为<code>'.$new_data[$key]['value'].'</code>；';
                    $val['log'][$key] = array(
                        'name'          => $original_data['name'],
                        'original_data' => $original_data['value'],
                        'new_data'      => $new_data[$key]['value'],
                    );
                }
                 
            }
        }
        $val['formate_time'] = RC_Time::local_date('Y-m-d H:i:s', $val['time']);
    }
    // 	    _dump($log_rs,1);
    return array('list' => $log_rs, 'page' => $page->show(2), 'desc' => $page->page_desc());
     
}

//end

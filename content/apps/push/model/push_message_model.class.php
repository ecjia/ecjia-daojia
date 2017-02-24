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

class push_message_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'push_message';
		parent::__construct();
	}
	
	/**
	 * 消息记录
	 */
	public function get_pushlist() {
	    $filter['keywords']	= empty($_GET['keywords']) 	? '' 	: trim($_GET['keywords']);
	    $filter['pushval']	= empty($_GET['pushval']) 	? 0 	: intval($_GET['pushval']);
	    $status 			= empty($_GET['status'])	? 0  	: $_GET['status'];
	    $filter['in_status']='';
	
	    $db_push_message = RC_DB::table('push_message');
	    
	    if (!empty($status) || (isset($_GET['status']) && intval($_GET['status']) === 0 )) {
	        $filter['in_status']  =  $status;
	        $db_push_message->where('in_status', $status);
	    }
	
	    if ($filter['keywords']) {
	        $db_push_message->where('title', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
	    }
	    
	    $msg_count = $db_push_message->select(RC_DB::raw('count(*) AS count, SUM(IF(device_client="android", 1, 0)) AS android, SUM(IF(device_client="iphone", 1, 0)) AS iphone, SUM(IF(device_client="ipad", 1, 0)) AS ipad'))
	    	->first();
	    
	    $msg_count = array(
    		'count'		=> empty($msg_count['count'])   ? 0 : $msg_count['count'],
    		'android'	=> empty($msg_count['android']) ? 0 : $msg_count['android'],
    		'iphone'	=> empty($msg_count['iphone']) 	? 0 : $msg_count['iphone'],
    		'ipad'	    => empty($msg_count['ipad']) 	? 0 : $msg_count['ipad'],
	    );
	
	    //安卓
	    if ($filter['pushval'] == 1) {
	        $db_push_message->where('device_client', 'android');
	    }
	    //iphone
	    if ($filter['pushval'] == 2) {
	        $db_push_message->where('device_client', 'iphone');
	    }
	
	    //ipad
	    if ($filter['pushval'] == 3) {
	        $db_push_message->where('device_client', 'ipad');
	    }
	
	    $count = $db_push_message->count();
	    $page = new ecjia_page($count, 15, 6);
	    
	    $row = $db_push_message->select('*')->orderby('add_time', 'desc')->take(15)->skip($page->start_id-1)->get();

	    if (!empty($row)) {
	        foreach ($row AS $key => $val) {
	            $row[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
	            $row[$key]['push_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['push_time']);
	            if ($row[$key]['device_client'] == 'android') {
	                $row[$key]['device_client'] = 'Android';
	            } elseif ($row[$key]['device_client'] == 'iphone') {
	                $row[$key]['device_client'] = 'iPhone';
	            } elseif ($row[$key]['device_client'] == 'ipad'){
	                $row[$key]['device_client'] = 'iPad';
	            }
	        }
	    }
	    return array('item' => $row, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
	}
	
	public function push_message_find($id, $field) {
        if (!empty($field)) {
            return RC_DB::table('push_message')->where('message_id', $id)->select($field)->first();
        } else {
            return RC_DB::table('push_message')->where('message_id', $id)->first();
        }
	}
	
	public function push_message_remove($id, $in = false) {
		$db_push_message = RC_DB::table('push_message');
		if ($in) {
			return $db_push_message->whereIn('message_id', $id)->delete();
		} else {
			return $db_push_message->where('message_id', $id)->delete();
		}
	}
}

// end
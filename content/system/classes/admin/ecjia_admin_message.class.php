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
 * ECJia 后台管理员留言管理类
 * @author royalwang
 *
 */
class ecjia_admin_message {
    
    /**
     *  获取管理员未读消息
     *
     * @return void
     */
    public static function get_admin_chat($filters = array()) {
        $dbview = RC_Loader::load_model('admin_message_user_viewmodel');
        /* 查询条件 */
        $filter['chat-id']		= empty($_REQUEST['chat_id'])		? 0 : intval($_REQUEST['chat_id']);
        $filter['sort_by']		= empty($_REQUEST['sort_by'])		? 'sent_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order']	= empty($_REQUEST['sort_order'])	? 'DESC' : trim($_REQUEST['sort_order']);
        $filter['msg_type']		= empty($_REQUEST['msg_type'])		? 0 : intval($_REQUEST['msg_type']);
        //群聊的状态
        empty($filter['chat-id']) && $filter = array_merge($filter, array('msg_type'=>1, 'start'=>0, 'page_size'=>10));
        //与自己交谈的状态
        $filter['chat-id'] == $_SESSION['admin_id'] && $filter = array_merge($filter, array('msg_type'=>2, 'start'=>0, 'page_size'=>10));
        //获取已读留言的状态
        $filter['last_id'] = empty($_REQUEST['last_id']) ? 0 : intval($_REQUEST['last_id']);
        !empty($filter['last_id']) &&  $filter = array_merge($filter, array('start'=>0, 'page_size'=>10));
    
        $filter = array_merge($filter, $filters);
    
        /* 查询条件 */
        switch ($filter['msg_type']) {
        	case 1:
        	    $where = " a.deleted='0' AND a.receiver_id='0'";
        	    break;
        	case 2 :
        	    $where = " a.deleted='0' AND a.receiver_id='" . $_SESSION['admin_id'] . "'";
        	    break;
        	case 3:
        	    $where = " a.receiver_id='".$_SESSION['admin_id']."' AND  a.deleted='0' AND a.readed='0'";
        	    break;
        	    // case 4:
        	    // 	$where = " a.readed='1' AND a.receiver_id='".$_SESSION['admin_id']."' AND a.deleted='0'";
        	    // break;
        	default:
        	    if (!empty($filter['last_id'])) {
        	        $where = " (a.receiver_id='".$_SESSION['admin_id']."' AND  a.sender_id='" .$filter['chat-id']. "' OR a.sender_id='" .$_SESSION['admin_id']. "' AND a.receiver_id='".$filter['chat-id']."') AND a.deleted='0' AND a.readed='1'";
        	    } else {
        	        $where = " (a.receiver_id='".$_SESSION['admin_id']."' AND  a.sender_id='" .$filter['chat-id']. "' OR a.sender_id='" .$_SESSION['admin_id']. "' AND a.receiver_id='".$filter['chat-id']."') AND a.deleted='0' AND a.readed='0'";
        	    }
        	    break;
        }
        !empty($filter['last_id']) && $where .= " AND a.message_id<".$filter['last_id'];
    
        $count = $dbview->join(null)->where("1 and ".$where)->count();
        $filter['record_count'] = $count;
        $dbview->view =array(
            'admin_user' => array(
                'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'b',
                'field' => 'a.message_id,a.sender_id,a.receiver_id,a.sent_time,a.read_time,a.deleted,a.title,a.message,b.user_name',
                'on'   => 'b.user_id = a.sender_id '
            )
        );
        $row = $dbview->join('admin_user')->where($where)->order(array($filter['sort_by']=>$filter['sort_order']))->limit($filter['start'] , $filter['page_size'])->select();
    
        if (!empty($row)) {
            foreach ($row AS $key=>$val) {
                $row[$key]['sent_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['sent_time']);
                $row[$key]['read_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['read_time']);
            }
            $end_row = end($row);
            $reverse_row = array_reverse($row);
        } else {
            $end_row = null;
            $reverse_row = null;
        }

        $arr = array('item' => $reverse_row,'filter' => $filter, 'record_count' => $filter['record_count'], 'last_id' => $end_row['message_id']);
        return $arr;
    }
    
    /**
     *  更改留言为已读状态
     *
     * @return void
     */
   public static function read_meg($chatid) {
        $db_message = RC_Loader::load_model('admin_message_model');
        if(empty($chatid)) {
            //更新阅读日期和阅读状态
            $where = array(
                'receiver_id' 	=> $_SESSION['admin_id'],
                'readed' 		=> 0
            );
        } else {
            //更新阅读日期和阅读状态
            $where = array(
                'receiver_id' 	=> $_SESSION['admin_id'],
                'sender_id' 	=> intval($chatid),
                'readed' 		=> 0
            );
        }
        $data = array (
            'read_time'	=> RC_Time::gmtime() ,
            'readed'	=> '1',
        );
        $db_message->where($where)->update($data);
    }   
}

// end
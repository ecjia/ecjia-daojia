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

use Ecjia\System\Admins\Plugin\ConfigMenu;

class admin_system_hooks {
		
	static public function admin_dashboard_header_links() {
		echo <<<EOF
		<a data-toggle="modal" data-backdrop="static" href="index.php-uid=1&page=dashboard.html#myMail" class="label ttip_b" title="New messages">25 <i class="splashy-mail_light"></i></a>
		<a data-toggle="modal" data-backdrop="static" href="index.php-uid=1&page=dashboard.html#myTasks" class="label ttip_b" title="New tasks">10 <i class="splashy-calendar_week"></i></a>
EOF;
	}
	
	static public function admin_dashboard_header_codes() {
		echo <<<EOF
	<div class="modal hide fade" id="myMail">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>New messages</h3>
		</div>
		<div class="modal-body">
			<div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
			<table class="table table-condensed table-striped" data-provides="rowlink">
				<thead>
					<tr>
						<th>Sender</th>
						<th>Subject</th>
						<th>Date</th>
						<th>Size</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Declan Pamphlett</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>23/05/2012</td>
						<td>25KB</td>
					</tr>
					<tr>
						<td>Erin Church</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>24/05/2012</td>
						<td>15KB</td>
					</tr>
					<tr>
						<td>Koby Auld</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>25/05/2012</td>
						<td>28KB</td>
					</tr>
					<tr>
						<td>Anthony Pound</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>25/05/2012</td>
						<td>33KB</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0)" class="btn">Go to mailbox</a>
		</div>
	</div>
	<div class="modal hide fade" id="myTasks">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>New Tasks</h3>
		</div>
		<div class="modal-body">
			<div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
			<table class="table table-condensed table-striped" data-provides="rowlink">
				<thead>
					<tr>
						<th>id</th>
						<th>Summary</th>
						<th>Updated</th>
						<th>Priority</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>P-23</td>
						<td><a href="javascript:void(0)">Admin should not break if URL&hellip;</a></td>
						<td>23/05/2012</td>
						<td class="tac"><span class="label label-important">High</span></td>
						<td>Open</td>
					</tr>
					<tr>
						<td>P-18</td>
						<td><a href="javascript:void(0)">Displaying submenus in custom&hellip;</a></td>
						<td>22/05/2012</td>
						<td class="tac"><span class="label label-warning">Medium</span></td>
						<td>Reopen</td>
					</tr>
					<tr>
						<td>P-25</td>
						<td><a href="javascript:void(0)">Featured image on post types&hellip;</a></td>
						<td>22/05/2012</td>
						<td class="tac"><span class="label label-success">Low</span></td>
						<td>Updated</td>
					</tr>
					<tr>
						<td>P-10</td>
						<td><a href="javascript:void(0)">Multiple feed fixes and&hellip;</a></td>
						<td>17/05/2012</td>
						<td class="tac"><span class="label label-warning">Medium</span></td>
						<td>Open</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0)" class="btn">Go to task manager</a>
		</div>
	</div>	
EOF;
	}
	
	
	public static function admin_dashboard_left_1() {
		$title = __('管理员留言');

		$chat_list = RC_Cache::app_cache_get('admin_dashboard_admin_message', 'system');
		if (! $chat_list) {
		    $chat_list = ecjia_admin_message::get_admin_chat(array('page_size' => 5));
		    RC_Cache::app_cache_set('admin_dashboard_admin_message', $chat_list, 'system', 15);
		}
		ecjia_admin::$controller->assign('title'			, $title);
		ecjia_admin::$controller->assign('msg_lists'		, $chat_list['item']);
		ecjia_admin::$controller->display('library/widget_admin_dashboard_messagelist.lbi');
	}
	
	
	public static function admin_dashboard_right_1() {
		if (!ecjia_admin::$controller->admin_priv('logs_manage', ecjia::MSGTYPE_HTML, false)) {
			return false;
		}
		
	    $title = __('操作日志');
	    $data = RC_Cache::app_cache_get('admin_dashboard_admin_log', 'system');
	    if (!$data) {
	        $data = RC_DB::table('admin_log')->select('admin_log.*', 'admin_user.user_name')->leftJoin('admin_user', 'admin_log.user_id', '=', 'admin_user.user_id')->orderBy('log_id', 'desc')->take(5)->get();
	        RC_Cache::app_cache_set('admin_dashboard_admin_log', $data, 'system', 30);
	    }

	    ecjia_admin::$controller->assign('title'	  , $title);
	    ecjia_admin::$controller->assign('log_lists'  , $data);
	    ecjia_admin::$controller->display('library/widget_admin_dashboard_loglist.lbi');
	}
	
	public static function admin_dashboard_right_2() {
	    $title = __('产品新闻');
	    
	    $product_news = ecjia_utility::site_admin_news();
        if (! empty($product_news)) {
            ecjia_admin::$controller->assign('title'	  , $title);
            ecjia_admin::$controller->assign('product_news'  , $product_news);
            ecjia_admin::$controller->display('library/widget_admin_dashboard_product_news.lbi');
        }	    
	}
	
	/**
	 * 添加后台左侧边栏信息
	 */
	public static function admin_sidebar_info() {
		$cache_key = 'admin_remind_sidebar';
		$remind = RC_Cache::userdata_cache_get($cache_key, $_SESSION['admin_id'], true);

		if (empty($remind)) {
			$remind = array();
			
			/*注册用户*/
			$validate_app_user = ecjia_app::validate_application('user');
			if (!is_ecjia_error($validate_app_user)) {
				$remind_user = RC_Api::api('user', 'remind_user');
				
				$new_user_count = (!empty($remind_user['new_user_count']) && is_numeric($remind_user['new_user_count'])) ? $remind_user['new_user_count'] : 0;
				
				$remind[] = array(
						'label' => __('新注册用户'),
						'total' => $new_user_count,
						'style' => 'danger',
				);
			}
			
			/*留言*/
			$validate_app_feedback = ecjia_app::validate_application('feedback');
			if (!is_ecjia_error($validate_app_feedback)) {
				$remind_message = RC_Api::api('feedback', 'remind_feedback');
				
				$message_count = (!empty($remind_message['message_count']) && is_numeric($remind_message['message_count'])) ? $remind_message['message_count'] : 0;
				
				$remind[] = array(
						'label' => __('新手机咨询'),
						'total' => $message_count,
						'style' => 'warning',
				);
			}
			
			/*订单*/
			$validate_app_order = ecjia_app::validate_application('orders');
			if (!is_ecjia_error($validate_app_order)) {
				$remind_order = RC_Api::api('orders', 'remind_order');
				
				$new_orders = (!empty($remind_order['new_orders']) && is_numeric($remind_order['new_orders'])) ? $remind_order['new_orders'] : 0;
				
				$remind[] = array(
						'label' => __('新订单'),
						'total' =>  $new_orders,
						'style' => 'success',
				);
			}
			
			RC_Cache::userdata_cache_set($cache_key, $remind, $_SESSION['admin_id'], true, 5);
		}
		
		if (! empty($remind)) {
			ecjia_admin::$controller->assign('remind'  , $remind);
			ecjia_admin::$controller->display('library/widget_admin_dashboard_remind_sidebar.lbi');
		}

	}
	
	
	public static function display_admin_plugin_menus() {
	    
	    $menus = ConfigMenu::singleton()->authMenus();
	    $screen = ecjia_screen::get_current_screen();

	    echo '<div class="setting-group">'.PHP_EOL;
	    echo '<span class="setting-group-title"><i class="fontello-icon-cog"></i>插件配置</span>'.PHP_EOL;
	    echo '<ul class="nav nav-list m_t10">'.PHP_EOL; //
	    
	    foreach ($menus as $key => $menu) 
	    {
	        if ($menu->action == 'divider') 
	        {
	            echo '<li class="divider"></li>';
	        } 
	        elseif ($menu->action == 'nav-header') 
	        {
	            echo '<li class="nav-header">' . $menu->name . '</li>';
	        } 
	        else 
	        {
	            echo '<li><a class="setting-group-item'; //data-pjax
	
	            if ($menu->base && $screen->parent_base && $menu->base == $screen->parent_base) 
	            {
	                echo ' llv-active';
	            }
	    
	            echo '" href="' . $menu->link . '">' . $menu->name . '</a></li>'.PHP_EOL;
	        }
	    }
	    
	    echo '</ul>'.PHP_EOL;
	    echo '</div>'.PHP_EOL;
	}
	
}

RC_Hook::add_action( 'display_admin_plugin_menus', array('admin_system_hooks', 'display_admin_plugin_menus') );
RC_Hook::add_action( 'admin_sidebar_info', array('admin_system_hooks', 'admin_sidebar_info'));
RC_Hook::add_action( 'admin_dashboard_left', array('admin_system_hooks', 'admin_dashboard_left_1') );
RC_Hook::add_action( 'admin_dashboard_right', array('admin_system_hooks', 'admin_dashboard_right_1') );
RC_Hook::add_action( 'admin_dashboard_right', array('admin_system_hooks', 'admin_dashboard_right_2') );

// RC_Hook::add_action( 'admin_dashboard_header_links', array('admin_system_hooks', 'admin_dashboard_header_links') );

// RC_Hook::add_action( 'admin_dashboard_header_codes', array('admin_system_hooks', 'admin_dashboard_header_codes') );


// end
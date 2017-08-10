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
 * ECJIA用户管理
 */
class admin_subscribe extends ecjia_admin {
	private $wu_viewdb;
	private $wechat_user_db;
	private $wechat_user_tag;
	private $wechat_tag;
	private $custom_message_viewdb;
	private $db_platform_account;
	
	public function __construct() {
		parent::__construct();
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->wu_viewdb = RC_Loader::load_app_model('wechat_user_viewmodel');
		$this->wechat_user_db = RC_Loader::load_app_model('wechat_user_model');
		$this->wechat_user_tag = RC_Loader::load_app_model('wechat_user_tag_model');
		$this->wechat_tag = RC_Loader::load_app_model('wechat_tag_model');
		$this->custom_message_viewdb = RC_Loader::load_app_model('wechat_custom_message_viewmodel');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('bootstrap-responsive');
		
		RC_Script::enqueue_script('admin_subscribe', RC_App::apps_url('statics/js/admin_subscribe.js', __FILE__));
		RC_Style::enqueue_style('admin_subscribe', RC_App::apps_url('statics/css/admin_subscribe.css', __FILE__));
		
		RC_Script::localize_script('admin_subscribe', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.subscribe_manage'), RC_Uri::url('wechat/admin_subscribe/init')));
	}

	public function init() {
		$this->admin_priv('wechat_subscribe_manage');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.subscribe_manage')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.subscribe_manage_content') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:用户管理#.E7.94.A8.E6.88.B7.E7.AE.A1.E7.90.86" target="_blank">'. RC_Lang::get('wechat::wechat.subscribe_manage_help') .'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.subscribe_manage'));
		$this->assign('form_action', RC_Uri::url('wechat/admin_subscribe/init'));
		$this->assign('action', RC_Uri::url('wechat/admin_subscribe/subscribe_move'));
		$this->assign('label_action', RC_Uri::url('wechat/admin_subscribe/batch'));
		$this->assign('get_checked', RC_Uri::url('wechat/admin_subscribe/get_checked_tag'));
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			
			//微信id、type、关键字
			$where = "u.wechat_id = $wechat_id";
			$type     = isset($_GET['type'])     ? $_GET['type']           : 'all';
			$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
			
			//用户标签列表
			$tag_arr['all'] = $this->wu_viewdb->join(null)->where(array('wechat_id' => $wechat_id, 'subscribe' => 1, 'group_id' => array('neq' => 1)))->count();
			$tag_arr['item'] = $this->wechat_tag->field('id, tag_id, name, count')->where(array('wechat_id' => $wechat_id))->order(array('id' => 'desc'))->select();
			$this->assign('tag_arr', $tag_arr);
			
			//关键字搜索
			if (!empty($keywords)) {
				$where .= ' and (u.nickname like "%' . $keywords . '%" or u.province like "%' . $keywords . '%" or u.city like "%' . $keywords . '%")';
			}

			//全部用户
			if ($type == 'all') {
				$where .= " and u.subscribe = 1 and u.group_id != 1";
			//标签用户
			} elseif ($type == 'subscribed') {
				$tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
				if (!empty($tag_id)) {
					$user_list = $this->wechat_user_tag->where(array('tagid' => $tag_id))->get_field('userid', true);
					if (empty($user_list)) {
						$user_list = 0;
					}
					$where .= ' and u.group_id != 1 and u.uid'.db_create_in($user_list);
				}
			//黑名单
			} elseif ($type == 'blacklist') {
				$where .= ' and u.group_id = 1';
			//取消关注
			} elseif ($type == 'unsubscribe') {
				$where .= " and u.subscribe = 0 and u.group_id = 0";
			}
			//用户列表
			$total = $this->wu_viewdb->join(null)->where($where)->count();
			$page = new ecjia_page($total, 10, 5);
			$list = $this->wu_viewdb->join(array('users'))->field('u.*, user_name')->where($where)->order(array('u.subscribe_time' => 'desc'))->limit($page->limit())->select();
			
			if (!empty($list)) {
				foreach ($list as $k => $v) {
					//假如不是黑名单
					if ($v['group_id'] != 1) {
						$tag_list = $this->wechat_user_tag->where(array('userid' => $v['uid']))->get_field('tagid', true);
						$name_list = $this->wechat_tag->where(array('tag_id' => $tag_list, 'wechat_id' => $wechat_id))->order(array('tag_id' => 'desc'))->get_field('name', true);
						if (!empty($name_list)) {
							$list[$k]['tag_name'] = implode('，', $name_list);
						}
					}
				}
			}
			$arr = array('item' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());
			$this->assign('list', $arr);

			if (isset($_GET['action']) && $_GET['action'] == 'get_list') {
				//无unionid给提示
				if (!empty($list)) {
					if (empty($list[0]['unionid'])) {
						$unionid = 1;
						$this->assign('unionid', $unionid);
					}
				}
			}
			
			//取消关注用户数量
			$where = array('wechat_id' => $wechat_id, 'subscribe' => 0, 'group_id' => 0);
			$num = $this->wechat_user_db->where($where)->count();
			$this->assign('num', $num);
			
			//获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
			$types = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $types);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$types)));
		}
	
		$this->assign_lang();
		$this->display('wechat_subscribe_list.dwt');
	}
	
	public function edit_tag() {
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
		$name = !empty($_POST['new_tag']) ? $_POST['new_tag'] : '';
		if (empty($name)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.tag_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (!empty($id)) {
			$this->admin_priv('wechat_subscribe_update', ecjia::MSGTYPE_JSON);
			
			$data = array('name' => $name);
			$is_only = $this->wechat_tag->where(array('id' => array('neq' => $id), 'name' => $name, 'wechat_id' => $wechat_id))->count();
			if ($is_only != 0 ) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.tag_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$tag_id = $this->wechat_tag->where(array('id' => $id))->get_field('tag_id');
			//微信端更新
			$rs = $wechat->setTag($tag_id, $name);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			//本地更新
			$update = $this->wechat_tag->where(array('id' => $id, 'wechat_id' => $wechat_id))->update($data);
			
			//记录日志
			ecjia_admin::admin_log($name, 'edit', 'users_tag');
			if ($update) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_subscribe/init')));
			} else {
				return $this->showmessage(RC_Lang::get('wechat::wechat.edit_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$this->admin_priv('wechat_subscribe_add', ecjia::MSGTYPE_JSON);
			
			$count = $this->wechat_tag->where(array('wechat_id' => $wechat_id))->count();
			if ($count == 100) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.up_tag_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$is_only = $this->wechat_tag->where(array('name' => $name, 'wechat_id' => $wechat_id))->count();
			if ($is_only != 0 ) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.tag_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			//微信端添加
			$rs = $wechat->addTag($name);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$tag_id = $rs['tag']['id'];
			
			//本地添加
			$data = array('name' => $name, 'wechat_id' => $wechat_id, 'tag_id' => $tag_id);
			$id = $this->wechat_tag->insert($data);
			//记录日志
			ecjia_admin::admin_log($name, 'add', 'users_tag');
			if ($id) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_subscribe/init')));
			} else {
				return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 删除标签
	 */
	public function remove() {
		$this->admin_priv('wechat_subscribe_delete', ecjia::MSGTYPE_JSON);
		
		$tag_id = !empty($_GET['tag_id']) ? intval($_GET['tag_id']) : 0;
		$id     = !empty($_GET['id'])     ? intval($_GET['id'])     : 0;
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		//微信端删除
		$rs = $wechat->deleteTag($tag_id);
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//本地删除
		$name = $this->wechat_tag->where(array('id' => $id))->get_field('name');
		$delete = $this->wechat_tag->where(array('id' => $id, 'tag_id' => $tag_id))->delete();
		
		//记录日志
		ecjia_admin::admin_log($name, 'remove', 'users_tag');
		$this->wechat_user_db->where(array('group_id' => $tag_id))->update(array('group_id' => 0));
		
		if ($delete){
			return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.remove_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 获取全部标签
	 */
	public function get_usertag() {
		$this->admin_priv('wechat_subscribe_manage', ecjia::MSGTYPE_JSON);
		
		$result = $this->get_user_tags();
		if ($result === true) {
			//记录日志
			ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.get_user_tag'), 'setup', 'users_tag');
			return $this->showmessage(RC_Lang::get('wechat::wechat.get_tag_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_subscribe/init')));
		}
	}
	
	/**
	 * 获取用户信息
	 */
	public function get_userinfo() {
		$this->admin_priv('wechat_subscribe_manage', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();

// 		$wechat = wechat_method::wechat_instance($uuid);
		$wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		//读取上次获取用户位置
		$p = RC_Cache::app_cache_get('wechat_user_position_'.$wechat_id, 'wechat');
		
		if ($p == false) {
			$p = !empty($_GET['p']) ? intval($_GET['p']) : 0;	
		}
		//删除缓存
		if (empty($p)) {
			RC_Cache::app_cache_delete('wechat_user_list_'.$wechat_id, 'wechat');
		}
		
		//读取缓存
		$wechat_user_list =  RC_Cache::app_cache_get('wechat_user_list_'.$wechat_id, 'wechat');
		if ($wechat_user_list == false) {
		    
		    try {
		        
		        $wechat_user = $wechat->user->lists()->toArray();
		        
		        if ($wechat_user['total'] <= 10000) {
		            $wechat_user_list = $wechat_user['data']['openid'];
		        } else {
		            $num = ceil($wechat_user['total'] / 10000);
		            for ($i = 1; $i < $num; $i ++) {
		                $wechat_user1 = $wechat->user->lists($wechat_user['next_openid'])->toArray();
		                $wechat_user_list = array_merge($wechat_user['data']['openid'], $wechat_user1['data']['openid']);
		            }
		        }
		        
		        //设置缓存
		        RC_Cache::app_cache_set('wechat_user_list_'.$wechat_id, $wechat_user_list, 'wechat');
		        
		    } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
			    
			    return $this->showmessage(Ecjia\App\Wechat\ErrorCodes::getError($e->getCode()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
		}
		
		$user_list = $this->wechat_user_db->where(array('wechat_id' => $wechat_id))->get_field('openid', true);
		if (empty($user_list)) {
			$user_list = array();
		}
		
		//比较微信端获取的用户列表 与 本地数据表用户列表
		if (empty($_GET['p'])) {
			foreach ($user_list as $v) {
				if (!in_array($v, $wechat_user_list)) {
					$unsubscribe_list[] = $v;
				}
			}
			//更新取消关注用户
			if (!empty($unsubscribe_list)) {
				$where = array(
					'wechat_id' => $wechat_id,
					'openid' . db_create_in($unsubscribe_list)
				);
				$this->wechat_user_db->where($where)->update(array('subscribe' => 0));
				
				//删除取消关注用户的标签
				$uid_list = $this->wechat_user_db->where($where)->get_field('uid', true);
				$this->wechat_user_tag->where(array('userid' => $uid_list))->delete();
			}
		}
		
		$arr1 = $arr2 = array();
		$list = array_slice($wechat_user_list, $p, 100);
		
		$total = count($wechat_user_list);
		$counts = count($list);
		
		$p += $counts;
		$where = '';
		if (!empty($list)) {
			foreach ($list as $k => $vs) {
				//不在表中为新关注用户、添加用户信息
				if (!in_array($vs, $user_list)) {
					$arr1[] = $vs;
					
				} else {
					//在表中为原来关注用户、更新用户信息
					$arr2[] = $vs;
				}
			}
		}

		//添加
		if (!empty($arr1)) {
		    
		    try {
		        $info2 = $wechat->user->batchGet($arr1)->toArray();
		        foreach ($info2['user_info_list'] as $key => $v) {
		            $info2['user_info_list'][$key]['wechat_id'] = $wechat_id;
		            $info2['user_info_list'][$key]['headimgurl'] = is_ssl() && !empty($v['headimgurl']) ? str_replace('http://', 'https://', $v['headimgurl']) : $v['headimgurl'];
		            $uid = $this->wechat_user_db->insert($info2['user_info_list'][$key]);
		            if (!empty($v['tagid_list'])) {
		                foreach ($v['tagid_list'] as $val) {
		                    if (!empty($val)) {
		                        $this->wechat_user_tag->insert(array('userid' => $uid, 'tagid' => $val));
		                    }
		                }
		            }
		        }
		        
		    } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
			    
			    return $this->showmessage(Ecjia\App\Wechat\ErrorCodes::getError($e->getCode()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
		}
		//更新
		if (!empty($arr2)) {
		    
		    try {
		        $info3 = $wechat->user->batchGet($arr2)->toArray();
		        foreach ($info3['user_info_list'] as $key => $v) {
		            $info3['user_info_list'][$key]['subscribe'] = 1;
		            $info3['user_info_list'][$key]['headimgurl'] = is_ssl() && !empty($v['headimgurl']) ? str_replace('http://', 'https://', $v['headimgurl']) : $v['headimgurl'];
		            $where['wechat_id'] = $wechat_id;
		            $where['openid'] = $v['openid'];
		            $this->wechat_user_db->where($where)->update($info3['user_info_list'][$key]);
		        
		            $uid = $this->wechat_user_db->where($where)->get_field('uid');
		            if (!empty($v['tagid_list'])) {
		                $this->wechat_user_tag->where(array('userid' => $uid))->delete();
		                foreach ($v['tagid_list'] as $val) {
		                    if (!empty($val)) {
		                        $this->wechat_user_tag->insert(array('userid' => $uid, 'tagid' => $val));
		                    }
		                }
		            }
		        }
		        
		    } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
			    
			    return $this->showmessage(Ecjia\App\Wechat\ErrorCodes::getError($e->getCode()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}

		}
		
		if ($p < $total) {
			RC_Cache::app_cache_set('wechat_user_position_'.$wechat_id, $p, 'wechat');
			return $this->showmessage(sprintf(RC_Lang::get('wechat::wechat.get_user_already'), $p), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url("wechat/admin_subscribe/get_userinfo"), 'notice' => 1, 'p' => $p));
		} else {
			RC_Cache::app_cache_delete('wechat_user_position_'.$wechat_id, 'wechat');
			RC_Cache::app_cache_delete('wechat_user_list_'.$wechat_id, 'wechat');
			
			ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.get_user_info'), 'setup', 'users_info');
			return $this->showmessage(RC_Lang::get('wechat::wechat.get_userinfo_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_subscribe/init', array('action' => 'get_list'))));
		}
	}
	
	//用户消息记录	
	public function subscribe_message() {
		$this->admin_priv('wechat_subscribe_message_manage');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.user_message_record'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.user_message_record')));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.subscribe_manage'), 'href'=> RC_Uri::url('wechat/admin_subscribe/init', array('page' => $page))));
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
		 	$this->assign('warn', 'warn');
		 	
		 	//获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
		 	$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
		 	$this->assign('type', $type);
		 	$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
		 	
		 	$tag_arr['item'] = $this->wechat_tag
                        		 	->field('id, tag_id, name, count')
                        		 	->where(array('wechat_id' => $wechat_id))
                        		 	->order(array('id' => 'desc', 'sort' => 'desc'))
                        		 	->select();
		 	$this->assign('tag_arr', $tag_arr);
		 	
		 	$uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
		 	$this->assign('chat_action', RC_Uri::url('wechat/admin_subscribe/send_message'));
		 	$this->assign('last_action', RC_Uri::url('wechat/admin_subscribe/read_message'));
		 	$this->assign('label_action', RC_Uri::url('wechat/admin_subscribe/batch'));
		 	$this->assign('get_checked', RC_Uri::url('wechat/admin_subscribe/get_checked_tag'));
		 	
		 	if (empty($uid)) {
		 		return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		 	}
		 	$info = $this->wu_viewdb->join(array('users'))->field('u.*, us.user_name')->find(array('u.uid' => $uid, 'u.wechat_id' => $wechat_id));
		 	if (!empty($info)) {
		 		if ($info['subscribe_time']) {
		 			$info['subscribe_time'] = RC_Time::local_date(ecjia::config('time_format'), $info['subscribe_time']-8*3600);
		 		}
		 		$tag_list = $this->wechat_user_tag->where(array('userid' => $info['uid']))->get_field('tagid', true);
		 		$name_list = $this->wechat_tag
                		 		->where(array('tag_id' => $tag_list, 'wechat_id' => $wechat_id))
                		 		->order(array('tag_id' => 'desc'))
                		 		->get_field('name', true);
		 		if (!empty($name_list)) {
		 			$info['tag_name'] = implode('，', $name_list);
		 		}
		 	}
		 	$this->assign('info', $info);
		 	$message = $this->get_message_list();
		 	$this->assign('message', $message);
		 	
		 	//最后发送时间
		 	$last_send_time = $this->custom_message_viewdb
                        		 	->join(null)
                        		 	->where(array('uid' => $uid, 'iswechat' => 0))
                        		 	->order(array('id' => 'desc'))
                        		 	->limit(1)
                        		 	->get_field('send_time');
		 	$time = RC_Time::gmtime();
		 	if ($time - $last_send_time > 48*3600) {
		 		$this->assign('disabled', '1');
		 	}
		}
		$this->assign_lang();
		$this->display('wechat_subscribe_message.dwt');
	}
	
	//获取信息
	public function read_message() {
		$this->admin_priv('wechat_subscribe_message_manage', ecjia::MSGTYPE_JSON);
		
		$list = $this->get_message_list();
		$message = count($list['item']) < 10 ? RC_Lang::get('wechat::wechat.no_more_message') : RC_Lang::get('wechat::wechat.searched');
		if (!empty($list['item'])) {
			return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('msg_list' => $list['item'], 'last_id' => $list['last_id']));
		} else {
			return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	//发送信息
	public function send_message() {
		$this->admin_priv('wechat_subscribe_message_add', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$openid = !empty($_POST['openid']) ? $_POST['openid'] : '';
		$data['msg'] = !empty($_POST['message']) ? $_POST['message'] : '';
		$data['uid'] = !empty($_POST['uid']) ? intval($_POST['uid']) : 0;
		
		if (empty($openid)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($data['msg'])) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.message_content_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data['send_time'] = RC_Time::gmtime();
		$data['iswechat'] = 1;
			
		// 微信端发送消息
		$msg = array(
			'touser' 	=> $openid,
			'msgtype' 	=> 'text',
			'text' 		=> array(
				'content' => $data['msg']
			)
		);
		
		$rs = $wechat->sendCustomMessage($msg);
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		// 添加数据
		$message_id = $this->custom_message_viewdb->join(null)->insert($data);
		ecjia_admin::admin_log($data['msg'], 'send', 'subscribe_message');
		if ($message_id) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.send_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('send_time' => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime())));
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.send_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	public function edit_remark() {
		$this->admin_priv('wechat_subscribe_update', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		$wechat = wechat_method::wechat_instance($uuid);
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		// 数据更新
		$remark	= !empty($_POST['remark'])	? trim($_POST['remark']) : '';
		$openid = !empty($_POST['openid']) 	? trim($_POST['openid']) : '';
		$page 	= !empty($_POST['page']) 	? intval($_POST['page']) : 1;
		$uid 	= !empty($_POST['uid']) 	? intval($_POST['uid'])  : 0;
		
		if (strlen($remark) > 30) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.up_remark_count'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$info = $this->wechat_user_db->find(array('openid' => $openid));
		//微信端更新
		$rs = $wechat->setUserRemark($openid, $remark);
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array('remark' => $remark);
		$update = $this->wechat_user_db->where(array('openid' => $openid, 'wechat_id' => $wechat_id))->update($data);
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.edit_remark_to'), $info['nickname'], $remark), 'edit', 'users_info');
		if ($update) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_subscribe/subscribe_message', array('uid' => $uid, 'page' => $page))));
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.edit_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	//添加/移出黑名单
	public function backlist() {
		$this->admin_priv('wechat_subscribe_update', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$wechat = wechat_method::wechat_instance($uuid);
		$uid 	= !empty($_GET['uid']) 		? intval($_GET['uid']) 		: 0;
		$type 	= !empty($_GET['type']) 	? trim($_GET['type']) 		: '';
		$page 	= !empty($_GET['page']) 	? intval($_GET['page']) 	: 1;
		$openid = !empty($_GET['openid']) 	? trim($_GET['openid']) 	: '';
		
		if ($type == 'remove_out') {
			$data['group_id']  = 0;
			$data['subscribe'] = 1;
			$sn                = RC_Lang::get('wechat::wechat.remove_blacklist');
			$success_msg       = RC_Lang::get('wechat::wechat.remove_blacklist_success');
			$error_msg         = RC_Lang::get('wechat::wechat.remove_blacklist_error');
		} else {
			$data['group_id']  = 1;
			$data['subscribe'] = 0;
			$sn                = RC_Lang::get('wechat::wechat.add_blacklist');
			$success_msg       = RC_Lang::get('wechat::wechat.add_blacklist_success');
			$error_msg         = RC_Lang::get('wechat::wechat.add_blacklist_error');
		}
		
		//微信端更新
		$rs = $wechat->setUserGroup($openid, $data['group_id']);
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		ecjia_admin::admin_log($sn, 'setup', 'users_info');
		$update = $this->wechat_user_db->where(array('uid' => $uid))->update($data);
		
		if ($update) {
			$this->get_user_tags();
			return $this->showmessage($success_msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_subscribe/subscribe_message', array('uid' => $uid, 'page' => $page))));
		} else {
			return $this->showmessage($error_msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	//获取消息列表
	public function get_message_list() {
		$custom_message_viewdb = RC_Loader::load_app_model('wechat_custom_message_viewmodel');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		$platform_name = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('name');
		
		$uid     = !empty($_GET['uid'])     ? intval($_GET['uid'])     : 0;
		$last_id = !empty($_GET['last_id']) ? intval($_GET['last_id']) : 0;
		$chat_id = !empty($_GET['chat_id']) ? intval($_GET['chat_id']) : 0;
		
		if (!empty($last_id)) {
			$where =  "m.uid = '".$chat_id."' AND (m.iswechat = 0 OR m.iswechat = 1) AND m.id<".$last_id;
		} else {
			$where =  "m.uid = '".$uid."' AND (m.iswechat = 0 OR m.iswechat = 1)";
		}
		$count = $custom_message_viewdb->where($where)->count();
		$page = new ecjia_page($count, 10, 5);
		$limit = $page->limit();

		$list = $custom_message_viewdb->join('wechat_user')
                                		->field('m.*, wu.nickname')
                                		->where($where)
                                		->order(array('m.id' => 'desc'))
                                		->limit($limit)
                                		->select();

		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$list[$key]['send_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['send_time']);
				if (!empty($val['iswechat'])) {
					$list[$key]['nickname'] = $platform_name;
				}
			}
			$end_list     = end($list);
			$reverse_list = array_reverse($list);
		} else {
			$end_list     = null;
			$reverse_list = null;
		}
		return array('item' => $reverse_list, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'last_id' => $end_list['id']);
	}
	
	//批量操作
	public function batch() {
		$uuid = platform_account::getCurrentUUID('wechat');
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$wechat = wechat_method::wechat_instance($uuid);
		$action = !empty($_GET['action']) 	? $_GET['action'] 	: '';
		$uid 	= !empty($_POST['uid']) 	? $_POST['uid'] 	: '';
		$openid = !empty($_POST['openid']) 	? $_POST['openid'] 	: '';
		$tag_id = !empty($_POST['tag_id']) 	? $_POST['tag_id'] 	: '';

		if (count($tag_id) > 3) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.up_tag_count'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$openid_list = explode(',', $openid);
		$tag = array();
		$openids_no_tag = $openids_tag = array();

		foreach ($openid_list as $k => $v) {
			$tag = $this->wu_viewdb->join(array('wechat_user', 'wechat_user_tag'))->where(array('u.openid' => $v, 'u.wechat_id' => $wechat_id))->field('ut.tagid, u.uid, u.openid')->select();
			foreach ($tag as $key => $val) {
				if (empty($val['tagid'])) {
					//没有标签的用户
					$openids_no_tag['openid'][] = $val['openid'];
					$openids_no_tag['uid'][]	= $val['uid'];
				} else {
					//有标签的用户
					$openids_tag[$val['uid']][] = array('tagid' => $val['tagid'], 'openid' => $val['openid']);
				}
			}
		}

		if (!empty($openids_no_tag)) {
			//添加用户标签
			if (!empty($tag_id)) {
				foreach ($tag_id as $v) {
					$rs = $wechat->setBatchTag($openids_no_tag['openid'], $v);
					if (RC_Error::is_error($rs)) {
						return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
					foreach ($openids_no_tag['uid'] as $val) {
						$this->wechat_user_tag->insert(array('userid' => $val, 'tagid' => $v));
					}
				}
			}
		}
		
		//取消用户标签
		if (!empty($openids_tag)) {
			foreach ($openids_tag as $k => $v) {
				foreach ($v as $val) {
					$rs = $wechat->setBatchunTag($val['openid'], $val['tagid']);
					if (RC_Error::is_error($rs)) {
						return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}
				$this->wechat_user_tag->where(array('userid' => $k))->delete();
				$new_uid[] = $k;
				$new_openid[] = $val['openid'];
			}
			
			if (!empty($new_openid)) {
				$openid_unique = array_unique($new_openid);
			}
			if (!empty($tag_id)) {
				foreach ($tag_id as $v) {
					$rs = $wechat->setBatchTag($openid_unique, $v);
					if (RC_Error::is_error($rs)) {
						return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
					foreach ($new_uid as $val) {
						$this->wechat_user_tag->insert(array('userid' => $val, 'tagid' => $v));
					}
				}
			}
		}
		$this->get_user_tags();
		if ($action == 'set_label') {
			$url = RC_Uri::url('wechat/admin_subscribe/init', array('type' => 'all'));
		} elseif ($action == 'set_user_label') {
			$url = RC_Uri::url('wechat/admin_subscribe/subscribe_message', array('uid' => $uid));
		}
		return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
	}
	
	//获取选择用户的标签
	public function get_checked_tag() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uid = !empty($_POST['uid']) ? intval($_POST['uid']) : '';
		$tag_arr = $this->wechat_tag->field('id, tag_id, name, count')->where(array('wechat_id' => $wechat_id))->order(array('id' => 'desc', 'sort' => 'desc'))->select();
		$user_tag_list = array();
		if (!empty($uid)) {
			$user_tag_list = $this->wechat_user_tag->where(array('userid' => $uid))->get_field('tagid', true);
			if (empty($user_tag_list)) {
				$user_tag_list = array();
			}
		}
		foreach ($tag_arr as $k => $v) {
			if (in_array($v['tag_id'], $user_tag_list)) {
				$tag_arr[$k]['checked'] = 1;
			}
			if ($v['tag_id'] == 1) {
				unset($tag_arr[$k]);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $tag_arr));
	}
	
	//获取用户标签
	private function get_user_tags() {
		$uuid = platform_account::getCurrentUUID('wechat');
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		try {
    		$wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
    		$list = $wechat->user_tag->lists()->toArray();
    		if (!empty($list['tags'])) {
    			$where['wechat_id'] = $wechat_id;
    			$this->wechat_tag->where($where)->delete();
    			foreach ($list['tags'] as $key => $val) {
    				$data['wechat_id']  = $wechat_id;
    				$data['tag_id']     = $val['id'];
    				$data['name']       = $val['name'] == RC_Lang::get('wechat::wechat.star_group') ? RC_Lang::get('wechat::wechat.star_user') : $val['name'];
    				$data['count']      = $val['count'];
    				$this->wechat_tag->insert($data);
    			}
    		}
    		
    		return true;
		} catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
		     
		    return $this->showmessage(Ecjia\App\Wechat\ErrorCodes::getError($e->getCode()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}		
	}
}

//end
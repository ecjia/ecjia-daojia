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

use Ecjia\App\Ucserver\Requests\CreateApplicationFormRequest;

/**
 * Ucenter
 */
class admin extends ecjia_admin
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

        Ecjia\App\Ucserver\Helper::assign_adminlog_content();
        
        RC_Script::enqueue_script('admin_ucenter', RC_App::apps_url('statics/js/admin_ucenter.js', __FILE__));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('Ucenter', RC_Uri::url('ucserver/admin/init')));
    }

    public function init()
    {
        $this->admin_priv('ucserver_manage');

        $this->assign('ur_here', '应用列表');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('Ucenter'));

        $list = $this->get_list();
        $this->assign('list', $list);

        $this->assign('action_link', array('text' => '添加新应用', 'href' => RC_Uri::url('ucserver/admin/add')));
        $this->assign('search_action', RC_Uri::url('ucserver/admin/init'));

        $this->display('ucenter_list.dwt');
    }
    
    public function ping()
    {
        $ip = $this->request->input('ip');
        $url = $this->request->input('url');
        $appid = intval($this->request->input('appid'));
        
        $app = with(new Ecjia\App\Ucserver\Repositories\ApplicationRepository());
        $note = new Ecjia\App\Ucserver\AppNote();
        $url = $note->getUrlCode('test', '', $appid);
        $status = $app->testApi($url, $ip);
        
        if ($status == '1') {
        	return $this->showmessage('通信成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('appid' => $appid));
        } else {
        	return $this->showmessage('通信失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('appid' => $appid));
        }
    }

    public function add()
    {
    	$this->admin_priv('ucenter_update');
    	
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加新应用'));

        $this->assign('ur_here', '添加新应用');
        $this->assign('action_link', array('href' => RC_Uri::url('ucserver/admin/init'), 'text' => '应用列表'));

        $this->assign('form_action', RC_Uri::url('ucserver/admin/update'));

        $data['synlogin'] = 0;
        $data['recvnote'] = 0;
        $this->assign('data', $data);

        $typelist = RC_Package::package('app::ucserver')->loadConfig('uctypes');
        $this->assign('typelist', $typelist);

        $this->display('ucenter_edit.dwt');
    }

    public function edit()
    {
    	$this->admin_priv('ucenter_update');
    	
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑应用'));

        $this->assign('ur_here', '编辑应用');
        $this->assign('action_link', array('href' => RC_Uri::url('ucserver/admin/init'), 'text' => '应用列表'));
        $this->assign('form_action', RC_Uri::url('ucserver/admin/update'));

        $id = intval($_GET['id']);
        $data = with(new Ecjia\App\Ucserver\Repositories\ApplicationRepository)->getApp($id);
        $this->assign('data', $data);

        $typelist = RC_Package::package('app::ucserver')->loadConfig('uctypes');
        $this->assign('typelist', $typelist);

        $this->display('ucenter_edit.dwt');
    }

    public function update(CreateApplicationFormRequest $request)
    {
    	$this->admin_priv('ucenter_update', ecjia::MSGTYPE_JSON);
    	
        $id = intval($_POST['id']);
        $type = trim($_POST['type']);
        $name = trim($_POST['name']);
        $url = trim($_POST['url']);
        $ip = trim($_POST['ip']);
        $authkey = trim($_POST['authkey']);

        $apifilename = trim($_POST['apifilename']);
        $synlogin = intval($_POST['synlogin']);
        $recvnote = intval($_POST['recvnote']);
        
        $apifilename = $apifilename ? $apifilename : 'uc.php';
        $authkey = $authkey ? $authkey : Ecjia\App\Ucserver\Helper::generateAuthKey();
        $authkey = Ecjia\App\Ucserver\Helper::authcode($authkey, 'ENCODE', UC_MYKEY);

        if (!Ecjia\App\Ucserver\Helper::checkUrl($url)) {
            return $this->showmessage('接口 URL 地址不合法', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (!empty($ip) && !Ecjia\App\Ucserver\Helper::checkIp($ip)) {
            return $this->showmessage('IP 地址不合法', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'type'          => $type,
            'name'          => $name,
            'url'           => $url,
            'ip'            => $ip,
            'authkey'       => $authkey,
            'apifilename'   => $apifilename,
            'synlogin'      => $synlogin,
            'recvnote'      => $recvnote,
        );
        if (empty($id)) {
        	$count = RC_DB::table('ucenter_applications')->where('name', $name)->count();
        	if ($count != 0) {
        		return $this->showmessage('应用名称不合法或者与其他应用重复, 请返回更换', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
        	
            $id = RC_DB::table('ucenter_applications')->insertGetId($data);
            $message = '添加成功';
            ecjia_admin::admin_log($name, 'add', 'ucserver_app');
        } else {
        	$count = RC_DB::table('ucenter_applications')->where('appid', '!=', $id)->where('name', $name)->count();
        	if ($count != 0) {
        		return $this->showmessage('应用名称不合法或者与其他应用重复, 请返回更换', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	}
        	
            RC_DB::table('ucenter_applications')->where('appid', $id)->update($data);
            $message = '编辑成功';
            ecjia_admin::admin_log($name, 'edit', 'ucserver_app');
        }
        return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('ucserver/admin/edit', array('id' => $id))));
    }

    public function remove()
    {
    	$this->admin_priv('ucserver_delete', ecjia::MSGTYPE_JSON);
    	
        $id = intval($_GET['id']);
        
        $name = RC_DB::table('ucenter_applications')->where('appid', $id)->pluck('name');
        ecjia_admin::admin_log($name, 'remove', 'ucserver_app');
        
        RC_DB::table('ucenter_applications')->where('appid', $id)->delete();
        
        return $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function batch_remove()
    {
    	$this->admin_priv('ucserver_delete', ecjia::MSGTYPE_JSON);
    	
        $appid_str = trim($_POST['appid']);
        $appid_list = explode(',', $appid_str);
        
        $list = RC_DB::table('ucenter_applications')->whereIn('appid', $appid_list)->get();
        if (!empty($list)) {
        	foreach ($list as $k => $v) {
        		ecjia_admin::admin_log($v['name'], 'batch_remove', 'ucserver_app');
        	}
        }
        RC_DB::table('ucenter_applications')->whereIn('appid', $appid_list)->delete();
        return $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('ucserver/admin/init')));
    }

    private function get_list()
    {
        $db = RC_DB::table('ucenter_applications');

        $count = $db->count();
        $page = new ecjia_page($count, 10, 5);
        $data = $db->select('appid', 'name', 'url', 'ip')->take(10)->skip($page->start_id - 1)->orderBy('appid', 'desc')->get();

        return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    
}

//end
